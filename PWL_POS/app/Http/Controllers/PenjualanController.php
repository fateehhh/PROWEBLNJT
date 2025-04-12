<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\StokModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan Barang',
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::all();
        $user = UserModel::all();
        $level = \App\Models\LevelModel::select('level_nama')->distinct()->get();

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'penjualan' => $penjualan,
            'user' => $user,
            'level' => $level
        ]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with(['detail.barang', 'user.level', 'user'])
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');

        if ($request->level_nama) {
            $penjualan->whereHas('user.level', function ($query) use ($request) {
                $query->where('level_nama', $request->level_nama);
            });
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('petugas', function ($penjualan) {
                return $penjualan->user->nama;
            })
            ->addColumn('jumlah', function ($penjualan) {
                return $penjualan->detail->sum('jumlah');
            })
            ->addColumn('harga', function ($penjualan) {
                return $penjualan->detail->sum(function ($d) {
                    return $d->harga * $d->jumlah;
                });
            })
            ->addColumn('aksi', function ($data) {
                return '
                    <button onclick="modalAction(\'' . url('/penjualan/' . $data->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(\'' . url('/penjualan/' . $data->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(\'' . url('/penjualan/' . $data->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::all();
        $user = Auth::user();

        $lastPenjualan = PenjualanModel::orderBy('penjualan_id', 'desc')->first();
        if ($lastPenjualan) {
            $lastNumber = (int) substr($lastPenjualan->penjualan_kode, 3); // Ambil angka saja, hilangkan 'PNJ'
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $newKode = 'PNJ' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        return view('penjualan.create_ajax', [
            'barang' => $barang,
            'user' => $user,
            'kodePenjualan' => $newKode
        ]);
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'user_id' => 'required|exists:m_user,user_id',
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualan',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'jumlah' => 'required|array',
            'harga' => 'required|array'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::create($request->only(['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal']));

        foreach ($request->barang_id as $index => $barangId) {
            $barang = BarangModel::find($barangId);
            $harga = $barang->harga_jual;
            $jumlah = $request->jumlah[$index];

            $stok = StokModel::where('barang_id', $barangId)->orderBy('stok_tanggal', 'desc')->first();

            // Cek stok mencukupi sebelum simpan transaksi
            if (!$stok || $stok->stok_jumlah < $jumlah) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak mencukupi untuk barang: ' . $barang->nama
                ]);
            }

            // Buat detail penjualan
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barangId,
                'harga' => $harga,
                'jumlah' => $jumlah,
            ]);

            // Kurangi stok
            $stok->stok_jumlah -= $jumlah;
            $stok->save();
        }


        return response()->json(['status' => true, 'message' => 'Penjualan berhasil disimpan']);
    }


    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['detail.barang', 'user'])->find($id);
        return view('penjualan.show_ajax', compact('penjualan'));
    }

    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['detail'])->find($id);
        $barang = BarangModel::all();
        $user = Auth::user();

        return view('penjualan.edit_ajax', compact('penjualan', 'barang', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'pembeli' => 'required|string|max:50',
            'penjualan_tanggal' => 'required|date',
            'barang_id.*' => 'required|exists:m_barang,barang_id',
            'harga.*' => 'required|numeric',
            'jumlah.*' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::find($id);
        $penjualan->update($request->only(['pembeli', 'penjualan_tanggal']));

        // Kembalikan stok lama
        $oldDetails = PenjualanDetailModel::where('penjualan_id', $id)->get();
        foreach ($oldDetails as $detail) {
            $stok = StokModel::where('barang_id', $detail->barang_id)->orderBy('stok_tanggal', 'desc')->first();
            if ($stok) {
                $stok->stok_jumlah += $detail->jumlah; // kembalikan stok lama
                $stok->save();
            }
        }
        // Hapus detail lama
        PenjualanDetailModel::where('penjualan_id', $id)->delete();

        // Tambahkan data baru dan kurangi stok lagi
        foreach ($request->barang_id as $index => $barangId) {
            $jumlah = $request->jumlah[$index];
            $harga = $request->harga[$index];

            $stok = StokModel::where('barang_id', $barangId)->orderBy('stok_tanggal', 'desc')->first();

            // Cek stok mencukupi
            if (!$stok || $stok->stok_jumlah < $jumlah) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak mencukupi untuk barang: ' . $barangId
                ]);
            }

            PenjualanDetailModel::create([
                'penjualan_id' => $id,
                'barang_id' => $barangId,
                'harga' => $harga,
                'jumlah' => $jumlah,
            ]);

            $stok->stok_jumlah -= $jumlah;
            $stok->save();
        }


        return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui']);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                // First, delete the related PenjualanDetail records
                PenjualanDetailModel::where('penjualan_id', $id)->delete();

                // Now delete the Penjualan record
                PenjualanModel::find($id)->delete();

                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Data gagal dihapus']);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }
}

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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function export_excel()
    {
        // 1. Ambil data penjualan
        $penjualan = PenjualanModel::with(['detail.barang', 'user'])->orderBy('penjualan_tanggal')->get();

        // 2. Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 3. Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Nama Petugas');
        $sheet->setCellValue('E1', 'Pembeli');
        $sheet->setCellValue('F1', 'Jumlah Barang');
        $sheet->setCellValue('G1', 'Total Harga');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // 4. Isi data
        $no = 1;
        $baris = 2;
        foreach ($penjualan as $item) {
            $totalJumlah = $item->detail->sum('jumlah');
            $totalHarga = $item->detail->sum(function ($d) {
                return $d->jumlah * $d->harga;
            });

            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item->penjualan_kode);
            $sheet->setCellValue('C' . $baris, $item->penjualan_tanggal);
            $sheet->setCellValue('D' . $baris, $item->user->nama ?? '-');
            $sheet->setCellValue('E' . $baris, $item->pembeli);
            $sheet->setCellValue('F' . $baris, $totalJumlah);
            $sheet->setCellValue('G' . $baris, $totalHarga);

            $baris++;
        }

        // 5. Auto size
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 6. Export
        $sheet->setTitle('Data Penjualan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['user', 'detail'])
            ->orderBy('penjualan_kode', 'asc')  // Mengurutkan berdasarkan kode penjualan
            ->get()
            ->map(function ($item) {
                $item->jumlah = $item->detail->sum('jumlah');
                $item->total = $item->detail->sum(function ($d) {
                    return $d->harga * $d->jumlah;
                });
                return $item;
            });

        $pdf = PDF::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Laporan Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

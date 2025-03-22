<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori Barang'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_kode) {
            $kategori->where('kategori_kode', $request->kategori_kode);
        }
        
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Barang'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|max:100',
        ], [
            'kategori_kode.required' => 'Kode kategori wajib diisi',
            'kategori_kode.max' => 'Kode kategori maksimal 10 karakter',
            'kategori_kode.unique' => 'Kode kategori sudah digunakan',
            'kategori_nama.required' => 'Nama kategori wajib diisi',
            'kategori_nama.max' => 'Nama kategori maksimal 100 karakter',
        ]);

        if ($validator->fails()) {
            return redirect('/kategori/create')
                ->withErrors($validator)
                ->withInput();
        }

        $kategori = new KategoriModel();
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori Barang'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::find($id);

        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori Barang'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::find($id);

        return view('kategori.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|max:100',
        ]);

        $kategori = KategoriModel::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih digunakan');
        }
    }
}
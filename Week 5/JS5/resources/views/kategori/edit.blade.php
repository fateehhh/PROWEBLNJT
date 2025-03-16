@extends('layouts.app')

@section('subtitle', 'Edit Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Edit Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Kategori</div>
            <div class="card-body">
                <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kodeKategori" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" id="kodeKategori" name="kodeKategori"
                            value="{{ $kategori->kategori_kode }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="namaKategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="namaKategori" name="namaKategori"
                            value="{{ $kategori->kategori_nama }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

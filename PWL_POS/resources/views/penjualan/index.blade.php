@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')" class="btn btn-sm btn-success">
                    <i class="fas fa-plus mr-1"></i>Tambah Penjualan
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- Filter --}}
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Filter Penjualan:</label>
                            <div class="col-3">
                                <select class="form-control" id="level_nama" name="level_nama">
                                    <option value="">- Semua -</option>
                                    @foreach ($level as $item)
                                        <option value="{{ $item->level_nama }}">{{ $item->level_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter Berdasarkan Level User</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Tabel --}}
            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Petugas</th>
                        <th>Pembeli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataPenjualan;
        $(document).ready(function () {
            dataPenjualan = $('#table_penjualan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('penjualan/list') }}",
                    type: "POST",
                    data: function (d) {
                        d.level_nama = $('#level_nama').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "penjualan_kode", className: "", orderable: true, searchable: true },
                    { data: "petugas", className: "", orderable: false, searchable: false },
                    { data: "pembeli", className: "", orderable: true, searchable: true },
                    { data: "jumlah", className: "text-left", orderable: false, searchable: false },
                    { data: "harga", className: "text-left", orderable: false, searchable: false },
                    { data: "penjualan_tanggal", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-left", orderable: false, searchable: false }
                ]
            });

            $('#table_penjualan_filter input').unbind().bind().on('keyup', function (e) {
                if (e.keyCode == 13) {
                    dataPenjualan.search(this.value).draw();
                }
            });

            $('#level_nama').on('change', function () {
                dataPenjualan.ajax.reload();
            });
        });
    </script>
@endpush
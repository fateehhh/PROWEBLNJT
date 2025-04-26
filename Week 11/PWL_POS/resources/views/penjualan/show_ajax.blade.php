<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Detail Penjualan</h5>
            <button type="button" class="close text-white" data-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Penjualan</th>
                        <td>{{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pembeli</th>
                        <td>{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $penjualan->user->nama }} ({{ $penjualan->user->level->level_kode }})</td>
                    </tr>
                    <tr>
                        <th>Tanggal Penjualan</th>
                        <td>{{ $penjualan->penjualan_tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Detail Barang</th>
                        <td>
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan->detail as $detail)
                                        <tr>
                                            <td>{{ $detail->barang->barang_nama }}</td>
                                            <td>Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>Rp{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>
                                            Rp{{ number_format($penjualan->detail->sum(function ($d) {
                                            return $d->harga * $d->jumlah;
                                            }), 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Modal Content Styling */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-title {
        font-weight: bold;
    }

    .text-right {
        text-align: right;
    }

    .text-danger {
        color: red;
    }

    .close {
        font-size: 1.5rem;
        color: white;
    }
</style>
<form id="formEditPenjualan"
    onsubmit="return submitForm(this, '{{ url('penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}')">
    @csrf
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Penjualan - {{ $penjualan->penjualan_kode }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                {{-- Info Petugas --}}
                <div class="form-group">
                    <label>Petugas</label>
                    <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                </div>

                {{-- Pembeli --}}
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" class="form-control" name="pembeli" value="{{ $penjualan->pembeli }}" required>
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" class="form-control" name="penjualan_tanggal"
                        value="{{ $penjualan->penjualan_tanggal }}" required>
                </div>

                {{-- Barang & Detail --}}
                <div id="barangWrapper">
                    @foreach ($penjualan->detail as $index => $detail)
                        <div class="row barang-item mb-2">
                            <div class="col-md-5">
                                <label>Barang</label>
                                <select name="barang_id[]" class="form-control barang-select" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barang as $b)
                                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}" {{ $detail->barang_id == $b->barang_id ? 'selected' : '' }}>
                                            {{ $b->barang_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Harga</label>
                                <input type="number" name="harga[]" class="form-control harga-input"
                                    value="{{ $detail->harga }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control" value="{{ $detail->jumlah }}"
                                    required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeBarangRow(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-success btn-sm mb-2 mt-2" onclick="addBarangRow()">+ Tambah
                    Barang</button>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</form>

<style>
.modal-header {
    background-color: #fcc404;
    color: white;
}
.modal-title {
        font-weight: bold;
}
.barang-item {
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    background-color: #fdfdfd;
}
.modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
}
</style>

<script>
    function removeBarangRow(button) {
        $(button).closest('.barang-item').remove();
    }

    function addBarangRow() {
        let options = @json($barang->map(function ($b) {
            return ['id' => $b->barang_id, 'nama' => $b->barang_nama, 'harga' => $b->harga_jual];
        }));

        let row = `<div class="row barang-item mb-2">
            <div class="col-md-5">
                <label>Barang</label>
                <select name="barang_id[]" class="form-control barang-select" required>
                    <option value="">Pilih Barang</option>
                    ${options.map(opt => `<option value="${opt.id}" data-harga="${opt.harga}">${opt.nama}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <label>Harga</label>
                <input type="number" name="harga[]" class="form-control harga-input" readonly>
            </div>
            <div class="col-md-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah[]" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeBarangRow(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>`;
        $('#barangWrapper').append(row);
    }

    function submitForm(form, url) {
        $.ajax({
            url: url,
            method: 'PUT',
            data: $(form).serialize(),
            success: function (res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    $('#table_penjualan').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
                }
            },
            error: function (xhr) {
                // Optional: menangani error dari server yang tidak terduga
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Silakan coba lagi nanti.'
                });
            }
        });
        return false;
    }

    // Otomatis isi harga ketika barang dipilih
    $(document).on('change', '.barang-select', function () {
        let harga = $(this).find('option:selected').data('harga') || 0;
        $(this).closest('.barang-item').find('.harga-input').val(harga);
    });

</script>
<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- User --}}
                <div class="form-group">
                    <label class="font-weight-bold">User:</label>
                    <div class="form-control" readonly style="background-color: #f8f9fa;">
                        {{ $user->nama }} ({{ $user->level->level_nama }})
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                    <small id="error-user_id" class="text-danger error-text"></small>
                </div>

                {{-- Barang --}}
                <div class="form-group">
                    <label>Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b['barang_id'] }}">{{ $b['barang_nama'] }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang-id" class="text-danger error-text"></small>
                </div>

                {{-- Supplier --}}
                <div class="form-group">
                    <label>Supplier</label>
                    <input type="text" name="supplier_nama" id="supplier_nama" class="form-control" readonly>
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="datetime-local" name="stok_tanggal" id="stok_tanggal" class="form-control" required>
                    <small id="error-stok-tanggal" class="text-danger error-text"></small>
                </div>

                {{-- Jumlah --}}
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                    <small id="error-stok-jumlah" class="text-danger error-text"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    const barangList = @json($barang); // dari controller

    function updateSupplierName(barangId) {
        const barang = barangList.find(b => b.barang_id == barangId);
        $('#supplier_nama').val(barang ? barang.supplier_nama : '');
    }

    $(document).ready(function () {
        $('#barang_id').on('change', function () {
            updateSupplierName(this.value);
        });

        $("#form-tambah").validate({
            rules: {
                user_id: { required: true },
                barang_id: { required: true },
                stok_tanggal: { required: true },
                stok_jumlah: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                            dataStok.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: response.message });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
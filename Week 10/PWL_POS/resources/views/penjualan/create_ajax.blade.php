<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penjualan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                {{-- User --}}
                <div class="form-group">
                    <label for="user-display" class="font-weight-bold">User:</label>
                    <div class="form-control" id="user-display" readonly style="background-color: #f8f9fa;">
                        {{ $user->nama }} ({{ $user->level->level_nama }})
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                    <small id="error-user_id" class="error-text text-danger"></small>
                </div>

                {{-- Pembeli --}}
                <div class="form-group">
                    <label>Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text text-danger"></small>
                </div>

                {{-- Kode Penjualan --}}
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" class="form-control" value="{{ $kodePenjualan }}" required>
                    <small id="error-penjualan_kode" class="error-text text-danger"></small>
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                </div>

                {{-- Daftar Barang --}}
                <div id="barang-container">
                    <div class="barang-item row mb-2">
                        <div class="col-md-5">
                            <label>Barang</label>
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="error-text text-danger error-barang_id"></small>
                        </div>
                        <div class="col-md-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" required>
                            <small class="error-text text-danger error-jumlah"></small>
                        </div>
                        <div class="col-md-3">
                            <label>Harga</label>
                            <input type="number" name="harga[]" class="form-control harga-input" readonly>
                        </div>

                        <div class="d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-barang">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm mt-2" id="tambah-barang">+ Tambah Barang</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<style>
    .form-group {
        margin-bottom: 1rem;
    }

    .error-text {
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    .barang-item {
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        background-color: #fdfdfd;
    }

    #barang-container .barang-item:not(:first-child) {
        margin-top: 10px;
    }

    .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #8A9A5B;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-title {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-danger {
        margin-left: 10px;
    }

    select,
    input[type="text"],
    input[type="number"],
    input[type="datetime-local"] {
        border-radius: 6px;
    }
</style>

<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                user_id: { required: true },
                pembeli: { required: true },    // ← Tambah ini
                penjualan_kode: { required: true }, // ← Tambah ini
                penjualan_tanggal: { required: true },
                barang_id: { required: true },
                jumlah: { required: true },
                harga: { required: true }
            }
            ,
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
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

    $(document).ready(function () {
        // Ambil harga dari database saat barang dipilih
        $('#barang_id').on('change', function () {
            var barangId = $(this).val();
            if (barangId) {
                $.ajax({
                    url: '/get-barang/' + barangId, // endpoint akan kita buat
                    type: 'GET',
                    success: function (response) {
                        $('#harga').val(response.barang_harga);
                        hitungTotal(); // langsung hitung total juga
                    }
                });
            } else {
                $('#harga').val('');
                $('#total_harga').val('');
            }
        });

        // Hitung total saat jumlah diubah
        $('#jumlah').on('input', function () {
            hitungTotal();
        });

        function hitungTotal() {
            var harga = parseFloat($('#harga').val()) || 0;
            var jumlah = parseInt($('#jumlah').val()) || 0;
            var total = harga * jumlah;
            $('#total_harga').val(total);
        }
    });

    $(document).ready(function () {
        // Tambah baris barang
        $('#tambah-barang').click(function () {
            let newItem = $('.barang-item').first().clone();
            newItem.find('input, select').val('');
            $('#barang-container').append(newItem);
        });

        // Hapus baris barang
        $(document).on('click', '.remove-barang', function () {
            if ($('.barang-item').length > 1) {
                $(this).closest('.barang-item').remove();
            }
        });
    });

    // Otomatis isi harga ketika barang dipilih
    $(document).on('change', '.barang-select', function () {
        let harga = $(this).find('option:selected').data('harga') || 0;
        $(this).closest('.barang-item').find('.harga-input').val(harga);
    });

</script>
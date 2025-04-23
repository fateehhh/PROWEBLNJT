<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Font & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif
        }

        .container {
            margin: 50px auto;
            width: 100%;
            max-width: 720px;
            padding: 20px;
        }

        .body {
            display: flex;
            /* Tambahan ini penting */
            position: relative;
            width: 720px;
            height: 720px;
            margin: 20px auto;
            border: 1px solid #dddd;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }


        .box-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .box-2 {
            padding: 30px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .box-1,
        .box-2 {
            width: 50%;
        }

        .h-1 {
            font-size: 24px;
            font-weight: 700;
        }

        .text-muted {
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            background-color: rgb(57, 104, 114);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #294c53;
        }

        .error-text {
            font-size: 12px;
            color: red;
        }

        .back {
            color: #294c53;
            margin-top: auto;
            font-size: 14px;
            text-align: center;
        }

        .footer {
            font-size: 10px;
        }

        @media (max-width:767px) {
            .body {
                flex-direction: column;
                width: 100%;
                height: auto;
            }

            .box-1,
            .box-2 {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="body d-md-flex align-items-center justify-content-between">
            <div class="box-2 d-flex flex-column h-100">
                <div>
                    <p class="mb-4 h-1">Buat Akun</p><br>
                    <form action="{{ url('/register') }}" method="POST" id="form-register">
                        @csrf
                        <label>Level Pengguna</label>
                        <select name="level_id">
                            <option value="">- Pilih Level -</option>
                            @foreach($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="error-text"></small>

                        <label>Username</label>
                        <input name="username" placeholder="Masukkan username">
                        <small id="error-username" class="error-text"></small>

                        <label>Nama</label>
                        <input name="nama" placeholder="Masukkan nama lengkap">
                        <small id="error-nama" class="error-text"></small>

                        <label>Password</label>
                        <input name="password" type="password" placeholder="Buat password">
                        <small id="error-password" class="error-text"></small>

                        <label>Konfirmasi Password</label>
                        <input name="password_confirmation" type="password" placeholder="Ulangi password">

                        <button type="submit" class="btn mt-2">Daftar</button>
                    </form>
                </div>
                <a href="{{ url('/login') }}" class="back text-center mt-auto"> sudah punya akun? Log in</a>
            </div>
            <div class="box-1 mt-md-0 mt-5">
                <img src="https://images.pexels.com/photos/1059979/pexels-photo-1059979.jpeg" alt="">
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#form-register').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (res) {
                        if (res.status) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                window.location.href = res.redirect;
                            });
                        } else {
                            $('.error-text').text('');
                            $.each(res.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
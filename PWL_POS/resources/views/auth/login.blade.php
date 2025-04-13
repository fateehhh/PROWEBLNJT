<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Font & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin: 50px auto;
            width: 100%;
            max-width: 720px;
            padding: 20px;
        }

        .body {
            display: flex;
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

        input {
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
        <div class="body">
            <div class="box-1">
                <img src="https://images.pexels.com/photos/1059979/pexels-photo-1059979.jpeg" alt="">
            </div>
            <div class="box-2">
                <p class="h-1 mb-4">Login Akun</p>
                <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username">
                    <small id="error-username" class="error-text"></small>

                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password">
                    <small id="error-password" class="error-text"></small>

                    <button type="submit" class="btn mt-1">Login</button>
                </form>
                <a href="{{ url('/register') }}" class="back">Belum punya akun? Daftar di sini</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#form-login').on('submit', function (e) {
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
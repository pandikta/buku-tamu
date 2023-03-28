<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Daftar</title>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <!-- <form method="POST" action="{{ route('guest.store') }}"> -->
                        <form action="" id="form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
                                <label for="email">Email</label>
                                @error('email')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password" value="{{ old('password') }}">
                                <label for="password">Password</label>
                                @error('password')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <button type="button" onclick="login_()" class="btn btn-primary w-100">Login</button>
                            <!-- <a href="{{ route('regis') }}" class="btn btn-info w-100 mt-2">Registrasi</a> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    function login_() {
        // var token = $("meta[name='csrf-token']").attr("content");

        // console.log(token);
        if ($("#email").val() == '') {
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Alamat Email Wajib Diisi !'
            });
            return false
        } else if ($("#password").val() == '' || $("#password").val().length < 6) {
            var msg = 'Password wajib diisi!'
            if ($("#password").val().length < 6) {
                var msg = 'Password minimal 6 karakter'
            }
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: msg
            });
            return false
        } else {
            let form = $("#form-data")[0];
            let data = new FormData(form);
            $.ajax({
                url: "{{ route('login-proses') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {

                    Swal.fire({
                        type: 'success',
                        title: 'Login berhasil',
                        text: data.responeText
                    }).then(() => {
                        setTimeout(() => {
                            window.location.href = "{{ route('regis') }}";
                        }, 2000);

                    })
                },
                statusCode: {
                    422: function(data) {
                        Swal.fire({
                            type: 'warning',
                            title: 'Login gagal',
                            text: data.responseText
                        });
                    },
                    500: function(data) {
                        Swal.fire({
                            type: 'error',
                            title: 'Server Eror',
                        });
                    }
                },
                error: function(data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Server Eror',
                    });
                }
            })
        }

    }
</script>

</html>
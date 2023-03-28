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
                        <h3 class="card-title text-center">Daftar Tamu</h3>
                    </div>
                    <div class="card-body">
                        <!-- <form method="POST" action="{{ route('guest.store') }}"> -->
                        <form action="" id="form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}">
                                <label for="name">Nama Lengkap</label>
                                @error('name')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="Nomor Telepon" value="{{ old('no_hp') }}">
                                <label for="phone">Nomor Telepon</label>
                                @error('no_hp')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
                                <label for="email">Email</label>
                                @error('email')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="id_card_number" class="form-control @error('id_card_number') is-invalid @enderror" id="id_card_number" placeholder="Nomor Identitas" value="{{ old('id_card_number') }}">
                                <label for="id_card_number">Nomor Identitas</label>
                                @error('id_card_number')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <button type="button" onclick="simpan()" class="btn btn-primary w-100">Daftar</button>
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
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function simpan() {
        event.preventDefault();

        let c = confirm('apakah anda yakin isian sudah sesuai ?')
        if (!c) {
            return false
        }
        // let token = $("meta[name='csrf-token']").attr("content");
        let form = $("#form-data")[0];
        let data = new FormData(form);
        $.ajax({
            type: "POST",
            url: "{{ route('guest.store') }}",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data.success);
                if (data.success == true) {
                    swal.fire('Guest Succesfully Added', '', 'success');
                    setTimeout(() => {
                        location.reload()
                    }, 2000);
                }

            },
            statusCode: {
                422: function(data) {
                    swal.fire(data.responseJSON.message, '', 'warning');
                }
            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                // console.log(errors);
                if (errors) {
                    $.each(errors, function(key, messages) {
                        let input = $('#' + key);
                        input.addClass('is-invalid');
                        let feedback = $('.invalid-feedback');
                        feedback.html(messages[0]);
                        swal.fire(messages[0], '', 'warning');
                    });
                }
            }
        })

    }
</script>

</html>
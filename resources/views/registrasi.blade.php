<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Regist</title>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Registrasi Tamu</h3>
                    </div>
                    <div class="card-body">
                        <!-- <form method="POST" action="{{ route('guest.store') }}"> -->
                        <form action="" id="form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="staff" class="search form-control @error('staff') is-invalid @enderror" id="staff" placeholder="Nama Lengkap" value="{{ old('staff') }}">
                                <input type="hidden" name="id_staf" id="id_staf">

                                <label for="name">Nama Staff</label>
                                @error('staff')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="guest" class="form-control @error('guest') is-invalid @enderror" id="guest" placeholder="Nomor Identitas" value="{{ old('guest') }}">
                                <input type="hidden" name="id_guest" id="id_guest">
                                <label for="guest">Nama Tamu/Nomor Identitas</label>
                                @error('guest')
                                <div class="invalid-feedback"></div>
                                @enderror
                            </div>
                            <button type="button" onclick="simpan()" class="btn btn-primary w-100">Registrasi</button>
                            <button type="button" onclick="logout()" class="btn btn-danger w-100 mt-2">Logout</button>
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

    $('#staff').typeahead({
        source: function(str, process) {
            return $.get("{{ route('search-staff') }}", {
                str: str
            }, function(data) {
                return process(data);
            });
        },
        updater: function(item) {
            var id = item.id;
            $('#id_staf').val(id);
            return item;
        }
    });

    $('#guest').typeahead({
        source: function(str, process) {
            return $.get("{{ route('search-guest') }}", {
                str: str
            }, function(data) {
                return process(data);
            });
        },
        updater: function(item) {
            var id = item.id;
            $('#id_guest').val(id);
            return item;
        }
    });


    function simpan() {
        event.preventDefault();
        if ($("#staff").val() == '') {
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Staff Wajib Diisi !'
            });
            return false
        } else if ($("#guest").val() == '') {

            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Tamu wajib di isi'
            });
            return false
        } else {
            let c = confirm('apakah anda yakin isian sudah sesuai ?')
            if (!c) {
                return false
            }
            // let token = $("meta[name='csrf-token']").attr("content");
            let form = $("#form-data")[0];
            let data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('regis.store') }}",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data.success);
                    if (data.success == true) {
                        swal.fire('Registration Succesfull', '', 'success');
                    }

                    setTimeout(() => {
                        location.reload()
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
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


    }

    function logout() {
        $.ajax({
            type: 'POST',
            url: '{{ route("logout") }}',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                Swal.fire({
                    type: 'success',
                    title: 'Logout berhasil',
                }).then(() => {
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 2000);

                })
            }
        });
    }
</script>

</html>
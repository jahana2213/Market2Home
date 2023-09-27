@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User Registration') }}</div>

                    <div class="card-body">
                        <form method="POST" id="user_registration_form">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value=""
                                        required autocomplete="name" autofocus>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value=""
                                        required autocomplete="email">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="new-password">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script type="text/javascript">
        //store 

        $("#user_registration_form").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: 'api/registration',
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('response');

                    Swal.fire({
                        title: 'User Registered Successfully!!',
                        showCancelButton: true,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            window.location.href = 'login';
                        }
                    })

                },
                error: function(xhr) {
                    if (xhr.status === 422) {

                        var errors = JSON.parse(xhr.responseText).errors;

                        showErrorAlert(errors);
                    } else {
                        // Handle other types of errors
                        console.error(xhr.responseText);
                    }

                }

            });

        });

        function showErrorAlert(errors) {
            var errorMessage = errors.join('\n');
            Swal.fire('Validation Error', errorMessage, 'error');
        }
    </script>
@endsection

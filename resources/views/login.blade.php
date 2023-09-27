@extends('layouts.app')
 
@section('content')
    <form method="POST" id="login_form">
        <div class="container" id="login_container">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Enter email">

            </div><br>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="container" style="display: none" id="profile_container">
            <h3>Welcome</h3>
            <div class="form-group">
                <label for="exampleInputEmail1">Name:</label>
                <span id="name"></span>
            </div><br>
            <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <span id="email"></span>
            </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script type="text/javascript">
        //store 

        $("#login_form").on("submit", function(e) {

            e.preventDefault();
            var formData = new FormData(this);

            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: 'api/login',
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    var SanctumToken = response.token;
                    if (response.message == 'success') {
                        Swal.fire({
                            title: 'LoggedIn Successfully!!',
                            showCancelButton: true,
                        }).then((result) => {

                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/api/profile_details',
                                    type: 'POST',

                                    headers: {
                                        'Authorization': 'Bearer ' + SanctumToken,
                                        'X-CSRF-TOKEN': _token
                                    },
                                    success: function(loginApiResponse) {
                                        $('#login_container').hide();
                                        $('#profile_container').show();
                                        $('#name').append(loginApiResponse.user.name);
                                        $('#email').append(loginApiResponse.user.email);

                                        //  console.log(loginApiResponse.user.name);
                                    },
                                    error: function(externalApiError) {

                                    }
                                });
                            }
                        })

                    } else {
                        // console.log(response);
                        Swal.fire('Email or Password is Incorrect');
                    }
                },
                error: function(response) {

                }

            });

        });
    </script>
@endsection

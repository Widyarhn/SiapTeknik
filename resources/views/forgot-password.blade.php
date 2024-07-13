<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Forget Password &mdash; Akreditasi POLINDRA</title>
    @include('body')
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="assets/img/polindra.png" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <!-- Menampilkan pesan sukses jika ada -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="card card-primary" style="border-top: 3px solid #243dff;">
                            <div class="card-header">
                                <h4>Lupa Password</h4>
                            </div>
                            <!-- Menampilkan pesan kesalahan validasi -->
                            <div class="card-body">
                                <p class="text-muted">Isi email yang sudah didaftarkan sebelumnya untuk mereset password
                                    anda</p>
                                <form action="{{ route('password-email.pwEmail') }}" method="POST"
                                    enctype="multipart/form-data" id="formPassword">
                                    @csrf
                                    <div class="form-group" id="formPassword">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" style="border-color:#243dff; background-color:#243dff" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; 2024 <div class="bullet"></div> Created By <a href="" style="color: #ffcd3f"><b>Widia Rahani</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

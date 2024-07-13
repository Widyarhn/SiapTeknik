<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Akreditasi POLINDRA</title>
  @include('body')
  <style>
    body {
      background-image: url('assets/img/gedung.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/polindra.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            @if(session()->has('sukses'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <i class="fas fa-check-circle"></i> {{ session('sukses') }}
                  <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                  </button>
                </div>
              </div>
              @endif

              @if(session()->has('status'))
              <div class="alert alert-success alert-dismissible show fade">
                  <div class="alert-body">
                      <i class="fas fa-check-circle"></i> {{ session('status') }}
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                  </div>
                </div>
                @endif

              @if(session()->has('LoginError'))
              <div class="alert alert-danger alert-dismissible show fade">
                  <div class="alert-body">
                      <i class="fas fa-times-circle"></i> {{ session('LoginError') }}
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                  </div>
                </div>
                @endif

            <div class="card card-primary" style="border-top: 3px solid #243dff;">
              <div class="card-header" style=""><h4>LOGIN SIAPTEKNIK</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route('login.auth') }}" class="needs-validation" novalidate="">
                    @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required  placeholder="contoh@gmail.com">
                    <div class="invalid-feedback">
                      masukkan email valid
                    </div>
                    @error('email')
                          <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                          </div>
                      @enderror
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="{{route('forgot-password')}}" class="text-small" style="color: #243dff">
                          Lupa Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="password">
                    <div class="invalid-feedback">
                      masukkan password yang benar
                    </div>
                  </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-color:#243dff; background-color:#243dff">
                      Login
                    </button>
                </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
            </div>
            {{-- <div class="simple-footer" style="color: white;">
              Copyright &copy; Politeknik Negeri Indramayu 2024 <div class="bullet"></div> Created By <a href="" style="color: #ffcd3f"><b>Widia Rahani</b></a>
            </div> --}}
            <div class="simple-footer" style="color: white;">
              Copyright &copy; 2024 <div class="bullet"></div> Created By <a href="" style="color: #ffcd3f"><b>Widia Rahani</b></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
</html>

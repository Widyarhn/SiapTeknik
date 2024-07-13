<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>LAM INFOKOM &mdash; Akreditasi</title>
  @include('body')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      @include('prodi.layout.header')

    <!-- Main SIdebar -->
      <div class="main-sidebar sidebar-style-2">
        @include('prodi.layout.sidebar')
      </div>



      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Anda belum terdaftar di program studi manapun</h1>
          </div>
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif
          @if(session('success'))
          <script>
              const success = swal({
                  icon: 'success',
                  title: 'Login Berhasil!',
                  text: '{{ session('success') }}'
              })
          </script>
      @endif
      <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Anda hanya bisa melihat instrumen akreditasi</h4>
                </div>
                <div class="card-body">
                    Pastikan anda sudah terdaftar sebagai pengguna program studi akreditasi untuk bisa mengakses semua fitur program studi
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Instrumen Akreditasi</h4>
              <div class="card-header-action">
                <a href="{{ url('instrumen-prodi')}}" class="btn btn-primary">
                  View All
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-file"> D3</i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Instrumen Akreditasi</h4>
                  </div>
                  <div class="card-body">
                    {{$instrumen_d3}}
                  </div>
                </div>
              </div>
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-file"> D4</i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Instrumen Akreditasi</h4>
                  </div>
                  <div class="card-body">
                    {{$instrumen_d4}}
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
</section>
      </div>
      <footer class="main-footer">
        @include('footer')
      </footer>
    </div>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>LAM TEKNIK &mdash; Akreditasi</title>
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
                        <h1>Dashboard Program Studi Akreditasi LAM Teknik Politeknik Negeri Indramayu</h1>
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
                    @if (session('success'))
                        <script>
                            const successTitle = '{{ session('success')['success_title'] }}';
                            const successMessage = '{{ session('success')['success_message'] }}';

                            const success = swal({
                                icon: 'success',
                                title: successTitle,
                                text: successMessage
                            });
                        </script>
                    @endif
                    {{-- <div class="alert alert-warning alert-dismissible show fade alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            @if ($timeline)
                            <div class="alert-title">{{ $timeline->tanggal_mulai }} s.d.
                                {{ $timeline->tanggal_akhir }}</div>
                            {{ $timeline->kegiatan }}
                            @else

                            @endif
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Sertifikat Akreditasi</h4>
                                    <div class="card-header-action">
                                        @if (count($user_prodi->program_studi->sertifikat) == 0)
                                            <a href="#" class="btn btn-secondary btn-create"> Sertifikat belum
                                                tersedia</a>
                                        @else
                                            <a href="{{ url('storage/sertifikat/', $user_prodi->program_studi->sertifikat[0]->file) }}"
                                                target="_blank">{{ $user_prodi->program_studi->sertifikat[0]->file }}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Anda bisa download sertifikat akreditasi di sini</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Berita Acara</h4>
                                    <div class="card-header-action">
                                        @if (count($user_prodi->program_studi->berita_acara) == 0)
                                            <a href="#" class="btn btn-secondary btn-create">
                                                Berita Acara belum tersedia</a>
                                        @else
                                            <a href="{{ url('storage/berita-acara/', $user_prodi->program_studi->berita_acara[0]->file) }}"
                                                target="_blank">Asesmen Lapangan</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Anda bisa melihat Berita Acara Asesmen Lapangan di sini</p>
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

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
            @include('asesor.layout.header')
            <!-- Main SIdebar -->
            @include('asesor.layout.sidebar')
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Dashboard Asesor Akreditasi LAM Teknik Politeknik Negeri Indramayu</h1>
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
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Sertifikat Akreditasi</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('dashboard-asesor.sertifikat.sertif') }}"
                                            class="btn btn-primary" target="_blank">
                                            View
                                        </a>
                                        {{-- @if (empty($user_asesor->program_studi->sertifikat)) --}}
                                        @if ($user_asesor->program_studi->sertifikat->isEmpty())
                                            <a href="#" data-toggle="modal" data-target="#modalTambah"
                                                class="btn btn-outline-primary btn-create"><i class="fas fa-upload"></i>
                                                Upload Sertifikat</a>
                                        @else
                                            <a href="#" class="btn btn-secondary btn-create">Sertifikat sudah
                                                diupload</a>
                                        @endif
                                        {{-- @if (count($user_asesor->program_studi->sertifikat) == 0)
                                            <a href="#" data-toggle="modal" data-target="#modalTambah"
                                                class="btn btn-outline-primary btn-create"><i class="fas fa-upload"></i>
                                                Upload Sertifikat</a>
                                        @else
                                            <a href="#" class="btn btn-secondary btn-create"> Sertifikat sudah
                                                diupload</a>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Anda bisa melihat dan mengunduh sertifikat akreditasi program studi yang telah
                                        melalui tahap asesmen lapangan di sini, kemudian kirimkan sertifikat ketika
                                        penilaian asesmen lapangan sudah selesai dilakukan, dengan cara upload pada
                                        tombol upload sertifikat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Berita Acara</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('dashboard-asesor.pdf.asesmen') }}" class="btn btn-primary"
                                            target="_blank">
                                            View
                                        </a>
                                        @if ($user_asesor->program_studi->berita_acara->isEmpty())
                                            <!-- Tombol untuk membuka modal -->
                                            <a href="#" data-toggle="modal" data-target="#modalTambahBeritaAcara"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-upload"></i> Upload Berita Acara
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-secondary"><i
                                                    class="fa fa-check"></i>&nbsp; Berita Acara sudah diupload</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Anda bisa melihat berita acara yang berisi keterangan dan rekap penilaian di
                                        sini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- Modal Sertifikat -->
            <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kirimkan sertifikat ke UPPS dan Program Studi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard-asesor.sertifikat.storeSertif') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Upload Sertifikat</label>
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                                <div class="form-group">
                                    <label>*unduh sertifikat akreditasi program studi terlebih dahulu, pada tombol
                                        View</label>
                                    <label>**pastikan desk evaluasi dan asesmen lapangan sudah selesai dilakukan</label>
                                </div>
                                <input type="hidden" value="{{ $user_asesor->tahun->id }}" name="tahun_id" />
                                <input type="hidden" value="{{ $user_asesor->program_studi->id }}"
                                    name="program_studi_id" />
                                <input type="hidden" value="{{ $user_asesor->program_studi->jenjang->id }}"
                                    name="jenjang_id" />
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Berita Acara -->
            <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahBeritaAcara">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kirimkan Berita Acara Asesmen Lapangan ke UPPS dan Program Studi
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('dashboard-asesor.berita-acara.asesmenLapangan') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Upload Berita acara asesmen lapangan</label>
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                                <div class="form-group">
                                    <label>*unduh berita acara asesmen lapangan akreditasi program studi terlebih
                                        dahulu, pada tombol asesmen lapangan</label>
                                    <label>**pastikan asesmen lapangan sudah selesai dilakukan</label>
                                </div>
                                <input type="hidden" value="{{ $user_asesor->tahun->id }}" name="tahun_id" />
                                <input type="hidden" value="{{ $user_asesor->program_studi->id }}"
                                    name="program_studi_id" />
                                <input type="hidden" value="{{ $user_asesor->program_studi->jenjang->id }}"
                                    name="jenjang_id" />
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer class="main-footer">
                @include('footer')
            </footer>
        </div>

    </div>

</body>

</html>

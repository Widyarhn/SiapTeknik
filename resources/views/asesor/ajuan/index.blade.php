<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dokumen Ajuan &rsaquo; {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('asesor.layout.header')

            
            @include('asesor.layout.sidebar')
            
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Dokumen Akreditasi {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item"> {{ $program_studi->jenjang->jenjang }}
                                {{ $program_studi->nama }}</div>
                        </div>
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
                            const success = swal({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '{{ session('success') }}'
                            })
                        </script>
                    @endif
                    <div class="section-body">
                        <h2 class="section-title">Dokumen LKPS dan LED Program Pendidikan
                            {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h2>
                        <p class="section-lead">Dokumen Lembar Kerja Program Studi (LKPS) dan Lembar Evaluasi Diri (LED)
                            program studi D3 {{ $program_studi->nama }} POLINDRA</p>
                    </div>
                    </p>
                    @if ($user_prodi->tahun->is_active == 1)
                        <div class="card">
                            <div class="card-body" style="padding-top: 20px;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Tahun {{ $user_prodi->tahun->tahun }} </th>
                                                <th class="text-center w-50">Nama File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">Surat Pengantar</td>
                                                <td class="text-center">
                                                    @if (count($user_prodi->tahun->surat_pengantar) == 0)
                                                        Belum ada file yang diupload
                                                    @else
                                                        <a href="{{ Storage::url($user_prodi->surat_pengantar->file) }}"
                                                            target="_blank">{{ basename($user_prodi->surat_pengantar->file) }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Dokumen LKPS</td>
                                                <td class="text-center">
                                                    @if (count($user_prodi->tahun->lkps) == 0)
                                                        Belum ada file yang diupload
                                                    @else
                                                        <a href="{{ Storage::url($user_prodi->lkps->file) }}"
                                                            target="_blank">{{ basename($user_prodi->lkps->file) }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Dokumen LED</td>
                                                <td class="text-center">
                                                    @if (count($user_prodi->tahun->led) == 0)
                                                        Belum ada file yang diupload
                                                    @else
                                                        <a href="{{ Storage::url($user_prodi->led->file) }}"
                                                            target="_blank">{{ basename($user_prodi->led->file) }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <h1>Akreditasi pada tahun {{ $user_prodi->tahun->tahun }} telah selesai, silahkan lihat history
                            akreditasi</h1>
                    @endif
                </section>
            </div>
            <footer class="main-footer">
                @include('footer')
            </footer>
        </div>
    </div>
</body>
</html>

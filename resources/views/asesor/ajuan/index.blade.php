<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dokumen Ajuan &rsaquo; {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</title>
    @include('body')
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                @include('asesor.layout.header')
                
                <div class="main-sidebar sidebar-style-2">
                    @include('asesor.layout.sidebar')
                </div>
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        <div class="section-header">
                            <h1>Dokumen Akreditasi  {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</h1>
                            <div class="section-header-breadcrumb">
                                <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a></div>
                                <div class="breadcrumb-item">  {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</div>
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
                        @if(session('success'))
                        <script>
                            const success = swal({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '{{ session('success') }}'
                            })
                        </script>
                        @endif
                        <div class="section-body">
                            <h2 class="section-title">Dokumen LKPS dan LED Program Pendidikan   {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</h2>
                            <p class="section-lead">Dokumen Lembar Kerja Program Studi (LKPS) dan Lembar Evaluasi Diri (LED) program studi D3 {{$program_studi->nama}} POLINDRA</p>
                        </div>
                    </p>
                    @if($tahun->tahun->is_active==0)
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tahun {{ $tahun->tahun->tahun }} </th>
                                            <th>Nama File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Dokumen LKPS</td>
                                             @if (count($tahun->tahun->lkps) == 0)
                                                <td>
                                                    Belum ada file yang diupload
                                                </td>
                                                @else
                                                <a href="{{url('storage/dokumen_prodi/', $tahun->lkps->file)}}" target="_blank">{{$tahun->lkps->file}}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Dokumen LED</td>
                                            @if (count($tahun->tahun->led) == 0)
                                               <td>
                                                Belum ada file yang diupload
                                               </td>
                                               @else
                                               <a href="{{url('storage/dokumen_prodi/', $tahun->led->file)}}" target="_blank">{{$tahun->led->file}}</a>
                                               @endif
                                           </td>
                                       </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <h1>Akreditasi pada tahun {{$tahun->tahun->tahun}} telah selesai, silahkan lihat history akreditasi</h1>
                    @endif
                </div>
            </section>
        </div>
        <footer class="main-footer">
            @include('footer')
            
            <div class="footer-right">
            </div>
        </footer>
    </div>
</div>

</body>

</html>

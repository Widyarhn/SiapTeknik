<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Akreditasi Program Studi</title>
    @include('body')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            @include('UPPS.layout.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        {{-- <div class="section-header-back">
                            <a href="{{ route('dashboard-UPPS') }}" class="btn btn-icon"><i class="fa fa-arrow-left"></i></a>
                        </div> --}}
                        <h1>Akreditasi Program Studi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Akreditasi</div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('akreditasi.index') }}"><i
                                                    class="fas fa-circle"></i>
                                                Dokumen Ajuan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('akreditasi.asesmenKecukupan') }}"><i
                                                    class="fas fa-regular fa-circle"></i>
                                                Asesmen Kecukupan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('akreditasi.asesmenLapangan') }}"><i
                                                    class="fas fa-circle"></i> Asesmen
                                                Lapangan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('akreditasi.selesai') }}"><i
                                                    class="fas  fa-solid fa-check"></i>
                                                Selesai</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" id="settings-card">
                                    {{-- <div class="card-header">
                                        <h4>Data Elemen Penilaian Desk Evaluasi</h4>
                                    </div> --}}
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="finishTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tahun</th>
                                                        <th>Program Studi</th>
                                                        <th>Akreditasi</th>
                                                        <th>Sertifikat</th>
                                                        <th>Berita Acara</th>
                                                        <th>Saran & Rekomendasi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="card-footer bg-whitesmoke text-md-right">
                                        <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                        <button class="btn btn-secondary" type="button">Reset</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
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

    <script>
        $(function() {
            $('#finishTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.akreditasi.selesai.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'akreditasi',
                        name: 'akreditasi'
                    },
                    {
                        data: 'sertifikat',
                        name: 'sertifikat'
                    },
                    {
                        data: 'berita_acara',
                        name: 'berita_acara'
                    },{
                        data: 'saran_rekomendasi',
                        name: 'saran_rekomendasi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            })
        })
    </script>

</body>

</html>



{{-- <li class="nav-item"><a href="#" class="nav-link">D4 Perancangan
                                                    Manufaktur</a></li> --}}

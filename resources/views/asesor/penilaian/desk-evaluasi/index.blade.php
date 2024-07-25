<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Asesor {{$program_studi->jenjang->jenjang}} | Elemen Penilaian {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </title>
    @include('body')
</head>
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
                        <h1>Asesmen Kecukupan {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Asesmen Kecukupan</div>
                        </div>
                    </div>
                    @if($user_asesor->tahun->is_active==0)
                    <div class="section-body">
                        <h2 class="section-title">Data Elemen Penilaian {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </h2>
                        <p class="section-lead">Informasi Elemen Penilaian Asesmen Kecukupan Jenjang {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}  Lingkup Teknik</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                            <h4>Tabel Elemen Penilaian {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="elemenTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Butir</th>
                                                        <th>Kriteria</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Basic table-->
                    @else
                    <h1>Akreditasi pada tahun {{$user_asesor->tahun->tahun}} telah selesai, silahkan lihat history akreditasi</h1>
                    @endif
            </div>
            </section>
        </div>
    </div>
    <script>
            $(function() {
                $('#elemenTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('asesmen-kecukupan.json', $program_studi->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'butir',
                            name: 'butir'
                        },
                        {
                            data: 'kriteria',
                            name: 'kriteria'
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
    <footer class="main-footer">
        @include('footer')
        <div class="footer-right">
        </div>
    </footer>
    </div>

</body>

</html>

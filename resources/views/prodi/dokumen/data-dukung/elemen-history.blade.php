<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Program Studi | Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </title>
    @include('body')
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('prodi.layout.header')
            
            <div class="main-sidebar sidebar-style-2">
                @include('prodi.layout.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <h2 class="section-title">Data Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </h2>
                        <p class="section-lead">Upload data dukung program studi {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} sesuai dengan folder elemen penilaian akreditasi</p>
                        <!--Basic table-->
                        @if($tahun->tahun->is_active==1)
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} {{$tahun->tahun->tahun}} </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="elemenTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Butir</th>
                                                        <th>Elemen</th>
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
                    <h1>Akreditasi pada tahun {{$tahun->tahun->tahun}} sedang berlangsung</h1>
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
                ajax: "{{ route('prodi.data-dukung.jsonHistory', $program_studi->id) }}",
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

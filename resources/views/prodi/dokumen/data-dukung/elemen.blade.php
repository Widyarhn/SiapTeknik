<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Program Studi | Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </title>
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
                            <div class="breadcrumb-item">Elemen Data Dukung</div>
                        </div>
                    </div>
                    <div class="section-body">
                        <h2 class="section-title">Data Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} </h2>
                        <p class="section-lead">Upload data dukung program studi {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} sesuai dengan folder elemen penilaian akreditasi</p>
                        <!--Basic table-->
                        <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Tahun</label>
                                                <select id="tahun" class="form-control selectric" name="">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach ($user_prodi as $role)
                                                    <option value="{{ $role->tahun->tahun }}">{{ $role->tahun->tahun }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Elemen Data Dukung {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}} <span id="tahunSelected"></span></h4>
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
                </div>
            </section>
        </div>
    </div>
    <script>
        $(function() {
            let year = null;

            var dataTable = $('#elemenTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('prodi.data-dukung.json', $program_studi->id) }}",
                    data: {}
                },
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

            $("#tahun").on("change", function (e){
                $('#elemenTable').DataTable().destroy()
                $("#tahunSelected").html(e.target.value)
                newDataTable(e.target.value)
            })

            function newDataTable(search) {
                $('#elemenTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('prodi.data-dukung.json', $program_studi->id) }}",
                    data: {
                        searchByYear : search
                    }
                },
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
            }
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

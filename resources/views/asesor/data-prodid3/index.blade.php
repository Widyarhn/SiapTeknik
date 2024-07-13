<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Instrumen Akreditasi &rsaquo; D3 {{$program_studi->nama}}</title>
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
                        <h1>Dokumen Akreditasi {{$program_studi->jenjang}} {{$program_studi->nama}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesord3') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">{{$program_studi->jenjang}} {{$program_studi->nama}}</div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-6">
                                <h2 class="section-title">Dokumen LKPS Prodi {{$program_studi->jenjang}} {{$program_studi->nama}}</h2>
                                 <p class="section-lead">Dokumen Lembar Kerja Program Studi (LKPS) berisi informasi dan petunjuk mengenai program studi D3 Teknik Informatika POLINDRA</p>
                            </div>
                            <div class="col-6">
                                <h2 class="section-title">Dokumen LED Prodi {{$program_studi->jenjang}} {{$program_studi->nama}}</h2>
                                 <p class="section-lead">Dokumen Lembar Evaluasi Diri (LED) berisi tentang evaluasi diri program studi D3 Teknik Informatika POLINDRA </p>
                            </div>
                        </div>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Dokumen LKPS</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="LkpsTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Nama File</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Dokumen LED</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="LedTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Nama File</th>
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
    </div>

        <script>
            $(function() {
                $('#LkpsTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('asesor.data-prodid3.getlkps', $program_studi->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'nama_file',
                            name: 'nama_file'
                        },
                        {
                            data:'action',
                            name:'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                })
                $('#LedTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('asesor.data-prodid3.getled', $program_studi->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'nama_file',
                            name: 'nama_file'
                        },
                        {
                            data:'action',
                            name:'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                })
            })

            $("body").on('click', ".btn-edit", function() {
                let url = $(this).data("url") + "/edit"
                $("#formActionEdit").attr("action", $(this).data("url"))
                $.ajax({
                    url: url,
                    type: "get",
                    success: function(data) {
                        $("#formEdit").html(data)
                    }
                })
            })

        </script>
        <footer class="main-footer">
            @include('footer')
            <div class="footer-right">
            </div>
        </footer>
    </div>
    </div>

</body>

</html>

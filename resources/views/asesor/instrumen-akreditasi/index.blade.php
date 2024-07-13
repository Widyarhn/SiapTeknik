<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Instrumen Akreditasi &rsaquo; Diploma 3</title>
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
                        <h1>Instrumen Akreditasi Diploma 3</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesord3') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Diploma 3</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Program Pendidikan Diploma 3</h2>
                        <p class="section-lead">Instrumen Akreditasi Lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Program Pendidikan Diploma 3</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="instrumenTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Program Pendidikan</th>
                                                        <th>Judul</th>
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
        <script>
            $(function() {
                $('#instrumenTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('instrumen-diploma-tiga.json') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'jenjang',
                            name: 'jenjang'
                        },
                        {
                            data: 'judul',
                            name: 'judul'
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

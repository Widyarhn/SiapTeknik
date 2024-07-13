<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Data Dukung &rsaquo; D3 {{$program_studi->nama}}</title>
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
                        <h1>Data Dukung D3 {{$program_studi->nama}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesord3') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">D3 {{$program_studi->nama}}</div>
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
                        <h2 class="section-title">Program Pendidikan D3 {{$program_studi->nama}}</h2>
                        <p class="section-lead">Dokumen data dukung Lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Dokumen Data Dukung</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="dataDukung">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Elemen Penilaian LAM</th>
                                                        <th>Nama Dokumen</th>
                                                        <th>PPP</th>
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
                $('#dataDukung').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('asesor.data-prodi.data-dukung.json', $program_studi->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'elemen',
                            name: 'elemen'
                        },
                        {
                            data: 'nama_file',
                            name: 'nama_file'
                        },
                        {
                            data: 'golongan',
                            name: 'golongan'
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

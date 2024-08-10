<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | User Asesor {{ $jenjang->jenjang }}</title>
    @include('body')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('UPPS.layout.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Data User Asesor Jenjang {{ $jenjang->jenjang }}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">User Asesor Jenjang {{ $jenjang->jenjang }}</div>
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
                        <h2 class="section-title">Data User Asesor Jenjang {{ $jenjang->jenjang }}</h2>
                        <p class="section-lead">Informasi User Asesor Jenjang {{ $jenjang->jenjang }} atau pengguna
                            aplikasi Lingkup Teknik</p>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="buttons">
                                            {{-- <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-outline-secondary btn-create"><i class="fas fa-plus-circle"></i> Tambahkan</a> --}}
                                            <h4>Tabel User Asesor Jenjang {{ $jenjang->jenjang }}</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="instrumenTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Nama</th>
                                                        <th>Jabatan</th>
                                                        <th>Email</th>
                                                        <th>Asesor</th>
                                                        <th>Tahun Akreditasi</th>
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
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User Asesor Jenjang {{ $jenjang->jenjang }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="formActionEdit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="formEdit">
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            const table = $('#instrumenTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.user.jsonAsesor', $jenjang->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }, {
                        data: 'nama',
                        name: 'nama'
                    }, {
                        data: 'jabatan',
                        name: 'jabatan'
                    },{
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
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

        $("body").on('click', '#delete', function(e) {
            let id = $(this).data('id')
            let route = $(this).data('route')
            swal({
                title: 'Konfirmasi hapus data User Asesor?',
                html: `DataUser Asesor akan dihapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                console.log(willDelete);
                if (willDelete) {
                    const response = $.ajax({
                        url: route,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                        }
                    }).catch(() => {
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: 'Server Error',
                            icon: 'error'
                        })
                    })
                    if (!response) return;

                    const success = swal({
                        title: 'Berhasil!',
                        text: "User asesor berhasil dihapus",
                        icon: 'success',
                    }).then((response) => {

                        window.location.reload()
                    })
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

</body>

</html>

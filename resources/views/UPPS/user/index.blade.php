<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | User </title>
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
                        <h1>Data User</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">User</div>
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
                        <h2 class="section-title">Data User</h2>
                        <p class="section-lead">Informasi user atau pengguna aplikasi Lingkup Teknik</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="buttons">
                                            <a href="#" data-toggle="modal" data-target="#modalTambah"
                                                class="btn btn-outline-secondary btn-create"><i
                                                    class="fas fa-plus-circle"></i> Tambahkan</a>
                                            <h4>Tabel User</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="instrumenTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Nama</th>
                                                        <th>Email</th>
                                                        <th>Level</th>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('UPPS.user.create') }}" method="post" enctype="multipart/form-data"
                        id="formActionTambah">
                        @csrf
                        @method('POST')
                        <div class="modal-body" id="formTambah">
                            <div class="card">
                                <form class="needs-validation" novalidate="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Level</label>
                                            <select id="role" class="form-control selectric" name="role_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="password" required="">
                                        </div>

                                </form>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
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
                ajax: "{{ route('UPPS.user.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }, {
                        data: 'nama',
                        name: 'nama'
                    }, {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role.role'
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
                url: url
                , type: "get"
                , success: function(data) {
                    $("#formEdit").html(data)
                }
            })
        })

        $("body").on('click', '#delete', function(e) {
            let id = $(this).data('id')
            let route = $(this).data('route')
            swal({
                title: 'Konfirmasi hapus data  User?',
                html: `Data User akan dihapus!`,
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
                        text: "User berhasil dihapus",
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

</body>

</html>

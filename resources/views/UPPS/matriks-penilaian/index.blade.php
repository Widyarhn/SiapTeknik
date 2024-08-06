<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Matriks Penilaian </title>
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
                        <h1>Data Matriks Penilaian {{$jenjang->jenjang}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Matriks Penilaian  {{$jenjang->jenjang}}</div>
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
                        <h2 class="section-title">Data Matriks Penilaian  {{$jenjang->jenjang}}</h2>
                        <p class="section-lead">Informasi matriks penilaian jenjang {{$jenjang->jenjang}} lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="buttons">
                                            <a href="{{route('UPPS.matriks-penilaian.create', $jenjang->id) }}"
                                                class="btn btn-outline-secondary btn-create"><i
                                                    class="fas fa-plus-circle"></i> Tambahkan</a>
                                            <h4>Tabel Matriks Penilaian  {{$jenjang->jenjang}}</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="matriksTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th >Informasi</th>
                                                        <th >Indikator</th>
                                                        <th >Deskripsi Nilai</th>
                                                        <th >Aksi</th>
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
            $('#matriksTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.matriks-penilaian.json', $jenjang->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'informasi',
                        name: 'informasi'
                    },
                    {
                        data: 'indikator',
                        name: 'indikator'
                    },
                    {
                        data: 'nilai',
                        name: 'nilai'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            })
        })

        $("body").on('click', '#delete', function(e) {
            let id = $(this).data('id')
            let route = $(this).data('route')
            swal({
                title: 'Konfirmasi hapus  Matriks Penilaian?',
                html: `Data Matriks Penilaian akan dihapus!`,
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
                        text: "Matriks Penilaian berhasil dihapus",
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

@php
    use App\Models\Lkps;
    use App\Models\Led;
    use App\Models\SuratPengantar;
    use App\Models\UserAsesor;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Setting Tahun Akreditasi</title>
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
                        <h1>Setting Tahun Akreditasi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Setting Tahun</div>
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
                        <h2 class="section-title">Setting Tahun Akreditasi</h2>
                        <p class="section-lead">Informasi terkait batch 1 s/d 3 untuk tahapan akreditasi program studi lingkup teknik di polindra</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="buttons">
                                            <a href="#" data-toggle="modal" data-target="#modalTambah"
                                                class="btn btn-outline-secondary btn-create"><i
                                                    class="fas fa-plus-circle"></i> Tambahkan</a>
                                            <h4>Tabel Tahun Akreditasi</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="tahunTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Tahun Akreditasi</th>
                                                        <th>Mulai Akreditasi</th>
                                                        <th>Akhir Akreditasi</th>
                                                        <th>Status</th>
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
            <footer class="main-footer">
                @include('footer')
                <div class="footer-right">
                </div>
            </footer>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tahun Akreditasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="formActionTambah">
                        @csrf
                        @method('POST')
                        <div class="modal-body" id="formTambah">
                            <div class="card">
                                <form class="needs-validation" novalidate="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="number" class="form-control" name="tahun" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Mulai Akreditasi</label>
                                            <input type="date" class="form-control" name="tanggal_awal"
                                                required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Akhir Akeditasi</label>
                                            <input type="date" class="form-control" name="tanggal_akhir"
                                                required="">
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
        <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Tahun Akreditasi</h5>
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
          $('#tahunTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('tahun-akreditasi.json') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'tahun',
                            name: 'tahun'
                        },
                        {
                            data: 'awal',
                            name: 'awal'
                        },
                        {
                            data: 'akhir',
                            name: 'akhir'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
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
    
        $("body").on('click', '.selesai-btn', function(e) {
          let id = $(this).data('id');
          let route = $(this).data('route')
            swal({
                title: 'Selesaikan Akreditasi?'
                , html: `Akreditasi akan selesai, pastikan semua proses telah dilakukan!`
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonText: 'Selesai!'
                , buttons: true
                , dangerMode: true,
            }).then((willEdit) => {
              let is_active = '1';
                if (willEdit) {
                    const response = $.ajax({
                    url: route
                    , method: 'POST'
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , id: id
                        , is_active: is_active
                    , }
                }).catch(() => {
                    swal({
                        title: 'Terjadi kesalahan!'
                        , text: 'Server Error'
                        , icon: 'error'
                    })
                })
                if (!response) return;

                const success = swal({
                    title: 'Berhasil!'
                    , text: "Akreditasi telah selesai"
                    , icon: 'success'
                , }).then((response) => {

                    window.location.reload()
                })
                }

            })
        })
        </script>
    </div>
</body>

</html>

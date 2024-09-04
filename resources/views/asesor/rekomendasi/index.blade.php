<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Rekomendasi Pembinaan Program Studi</title>
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
                    <div class="section-header">
                        <h1>Rekomendasi Pembinaan Program Studi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Rekomendasi Pembinaan</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Rekomendasi Pembinaan Program Studi {{ $prodi->jenjang->jenjang }}
                            {{ $prodi->nama }}</h2>
                        <p class="section-lead">Rekomendasi berdasarkan kriteria
                            yang menjelaskan kekuatan (keunggulan) dan kelemahan dari perguruan tinggi yang
                            disertai dengan pemberian apresiasi/komendasi (commendation) atas hasil yang telah
                            dicapai, serta pemberian saran perbaikan/rekomendasi (recommendation) untuk hal-hal
                            yang masih harus diperbaiki dan ditingkatkan.</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Rekomendasi Pembinaan</h4>
                                        <div class="card-header-action">
                                            <a href="#" data-toggle="modal" data-target="#modalTambahRek"
                                                {{-- data-tahun-id="{{ $t->user_prodi->tahun_id }}"
                                                data-program-studi-id="{{ $t->user_prodi->program_studi_id }}"
                                                data-jenjang-id="{{ $t->user_prodi->jenjang_id }}" --}} class="btn btn-outline-primary btn-create"
                                                style="border-radius: 30px;">
                                                <i class="fas fa-plus"></i> Buat Rekomendasi Pembinaan
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#modalTambahRekomendasi"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-upload"></i> Upload
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="rekomendasiTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Kriteria</th>
                                                        <th>Apresiasi/Komendasi</th>
                                                        <th>Rekomendasi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Rekomendasi Pembinaan</h4>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                            @if (count($user_asesor->program_studi->rpembinaan) == 0)
                                                <a href="#" class="btn btn-secondary btn-create">
                                                    Rekomendasi Pembinaan belum tersedia</a>
                                            @else
                                            <a href="{{ url('storage/rekomendasi/', $user_asesor->program_studi->rpembinaan[0]->file) }}"
                                            target="_blank">{{ $user_asesor->program_studi->rpembinaan[0]->file }}</a>
                                            @endif
                                            </p>
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
            <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahRek">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Buat Rekomendasi Pembinaan Prodi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" id="formActionTugas">
                                @csrf

                                <div class="card-body" id="formTugas">
                                    <div class="form-group">
                                        <label for="kegiatan">Kriteria</label>
                                        <select id="kriteria_id" class="form-control selectric" name="kriteria_id">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kriteria as $k)
                                                <option value="{{ $k->id }}">
                                                    {{ $k->kriteria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Apresiasi/Komendasi</label>
                                        <textarea class="form-control" name="komendasi"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Rekomendasi</label>
                                        <textarea class="form-control" name="rekomendasi"></textarea>
                                    </div>

                                    <!-- Hidden fields for user_prodi -->
                                    <input type="hidden" name="tahun_id" value="{{ $user_asesor->tahun_id }}">
                                    <input type="hidden" name="program_studi_id"
                                        value="{{ $user_asesor->program_studi_id }}">

                                </div>
                                <div class="card-footer text-right"
                                    style="background-color:rgba(0, 0, 0, 0); border-top:none;">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
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
                            <h5 class="modal-title">Edit Rekomendasi Pembinaan</h5>
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

            <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahRekomendasi">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Kirimkan Rekomendasi Pembinaan ke UPPS dan Program Studi
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('asesor.rekomendasi.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Upload Rekomendasi Pembinaan</label>
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                                <div class="form-group">
                                    <label>*unduh rekomendasi pembinaan program studi terlebih
                                        dahulu, pada tombol pdf</label>
                                    <label>**pastikan asesmen lapangan sudah selesai dilakukan</label>
                                </div>
                                <input type="hidden" value="{{ $user_asesor->tahun->id }}" name="tahun_id" />
                                <input type="hidden" value="{{ $user_asesor->program_studi->id }}"
                                    name="program_studi_id" />
                                <input type="hidden" value="{{ $user_asesor->id }}" name="user_asesor_id" />
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
            <script src="//cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
            <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
            <script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
            <script>
                $(function() {
                    $('#rekomendasiTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('rekomendasi.json') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                            },
                            {
                                data: 'kriteria',
                                name: 'kriteria'
                            },
                            {
                                data: 'komendasi',
                                name: 'komendasi'
                            },
                            {
                                data: 'rekomendasi',
                                name: 'rekomendasi'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        dom: 'Bfrtip', // Menambahkan tempat untuk tombol export
                        buttons: [{
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':not(:last-child)' // Mengecualikan kolom aksi (kolom terakhir) dari ekspor PDF
                            }
                        }]
                    });
                });


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
                        title: 'Konfirmasi hapus data Rekomendasi Pembinaan?',
                        html: `Data Rekomendasi Pembinaan akan dihapus!`,
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
                                text: "Rekomendasi Pembinaan berhasil dihapus",
                                icon: 'success',
                            }).then((response) => {

                                window.location.reload()
                            })
                        }

                    })
                })
            </script>
        </div>
    </div>

</body>

</html>

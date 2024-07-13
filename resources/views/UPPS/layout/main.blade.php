<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>LAM TEKNIK &mdash; Akreditasi</title>
    @include('body')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            <!-- Main SIdebar -->
            @include('UPPS.layout.sidebar')

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
                            const successTitle = '{{ session('success')['success_title'] }}';
                            const successMessage = '{{ session('success')['success_message'] }}';

                            const success = swal({
                                icon: 'success',
                                title: successTitle,
                                text: successMessage
                            });
                        </script>
                    @endif

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon shadow-warning bg-warning">
                                    <i class="far fa-lightbulb"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Dokumen Ajuan</h4>
                                    </div>
                                    <div class="card-body">
                                        @if (count($dokumen_ajuan) == 0)
                                            -
                                        @else
                                            {{ count($dokumen_ajuan) }}
                                        @endif
                                        <div class="btn-group dropright m-2">
                                            @if (count($dokumen_ajuan) == 0)
                                            @else
                                                <a href="{{ route('akreditasi.index') }}"
                                                    class="btn btn-outline-warning btn-sm"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    style="border-radius: 30px;">
                                                    View Docs
                                                </a>
                                                {{-- <div class="dropdown-menu dropright"
                                                    style="width: auto;box-shadow:0 4px 8px rgba(0, 0, 0, 0.13)">
                                                    @foreach ($dokumen_ajuan as $p)
                                                        <a class="dropdown-item" value="{{ $p->program_studi_id }}"
                                                            href="{{ route('upps.dokumenajuan.prodi', $p->program_studi_id) }}">
                                                            {{ $p->program_studi->jenjang->jenjang }}
                                                            {{ $p->program_studi->nama }}
                                                        </a>
                                                    @endforeach
                                                </div> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <a href="{{ route('akreditasi.index') }}">
                                <div class="card card-statistic-2">
                                    <div class="card-icon shadow-primary bg-primary">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Lihat dan Kelola</h4>
                                        </div>
                                        <div class="card-body">
                                            Akreditasi
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <a href="{{ route('user.index') }}">
                                <div class="card card-statistic-2">
                                    <div class="card-icon shadow-info bg-info">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Lihat dan Kelola</h4>
                                        </div>
                                        <div class="card-body">
                                            User
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <a href="{{ route('prodi.index') }}">
                                <div class="card card-statistic-2">
                                    <div class="card-wrap" style="padding-bottom: 24px; padding-left: 10px;">
                                        <div class="card-header">
                                            <h4>Lihat dan Kelola</h4>
                                        </div>
                                        <div class="card-body">
                                            Program Studi
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Timeline Akreditasi</h4>
                                    <div class="card-header-action dropdown">
                                        <a href="#" data-toggle="dropdown"
                                            class="btn btn-danger dropdown-toggle">Pilih Prodi</a>
                                        <ul class="dropdown-menu"
                                            style="width: auto;box-shadow:0 4px 8px rgba(0, 0, 0, 0.13)">
                                            <li class="dropdown-title">Pilih Program Studi</li>
                                            <li><a href="#" class="dropdown-item">D3 Teknik Mesin</a></li>
                                            <li><a href="#" class="dropdown-item">D3 Teknik Pendingin dan Tata
                                                    Udara</a></li>
                                            <li><a href="#" class="dropdown-item">D4 Perancangan
                                                    Manufaktur</a></li>
                                            <li><a href="#" class="dropdown-item">D4 Teknologi Rekayasa
                                                    Instrumentasi dan Kontrol</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body" id="top-5-scroll">
                                    <ul class="list-unstyled list-unstyled-border">
                                        @if (count($status_1) == 0)
                                            <p class="text-center">Belum ada timeline untuk Prodi</p>
                                        @else
                                            @foreach ($timeline as $t)
                                                <li class="media">
                                                    <div class="media-body">
                                                        <div class="media-title">{{ $t->nama_kegiatan }}</div>
                                                        <div class="mt-1">
                                                            <div class="font-weight-600 text-muted text-medium">
                                                                {{ $t->jadwal_awal . ' s/d ' . $t->jadwal_akhir }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                {{-- <div class="card-footer pt-3 d-flex justify-content-center">

                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="buttons">
                                        <a href="#" data-toggle="modal" data-target="#modalTambahJadwal"
                                            class="btn btn-outline-primary btn-create mb-2"
                                            style="border-radius: 30px;"><i class="fas fa-plus-circle"></i>
                                            Tambah Akreditasi</a>
                                        <h4>Daftar Akreditasi Program Studi</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="daftarAkreditasiProdi">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Program Studi</th>
                                                    <th>Tahun</th>
                                                    <th>Mulai Akreditasi</th>
                                                    <th>Akhir Akreditasi</th>
                                                    <th>Status</th>
                                                    <th width="50%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </section>
            </div>

            <footer class="main-footer">
                @include('footer')
            </footer>
            <!--Basic table-->
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambahJadwal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akreditasi Program Studi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('UPPS.akreditasi.store') }}" method="post" enctype="multipart/form-data"
                    id="formTambah">
                    @csrf
                    @method('POST')
                    <div class="card p-4">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-5">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" placeholder="Tahun"
                                        name="tahun" required="">
                                </div>
                                <div class="form-group col-lg-7">
                                    <label for="kegiatan">Kegiatan</label>
                                    <input type="text" class="form-control" id="kegiatan"
                                        placeholder="Pengajuan Dokumen" name="kegiatan" required=""
                                        disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="programStudi">Program Studi</label>
                                <select id="programStudi" class="form-control selectric" name="program_studi_id">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($program_studi as $prodi)
                                        <option value="{{ $prodi->id }}">
                                            {{ $prodi->jenjang->jenjang }}
                                            {{ $prodi->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tanggalMulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggalMulai"
                                        name="tanggal_mulai" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tanggalAkhir">Batas Waktu</label>
                                    <input type="date" class="form-control" id="tanggalAkhir"
                                        name="tanggal_akhir" required="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalPenugasan">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penugasan User Program Studi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('UPPS.akreditasi.penugasanProdi') }}" method="post"
                        enctype="multipart/form-data" id="formActionTugas">
                        @csrf
                        <div class="card-body" id="formTugas">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <select id="user" class="form-control selectric" name="user_id">
                                    <option value="">-- Pilih atau Ketik --</option>
                                    @foreach ($user as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                    @endforeach
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6" id="namaInput" style="display: none;">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                                <div class="form-group col-lg-6" id="emailInput" style="display: none;">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <!-- Hidden fields for user_prodi -->
                            <input type="hidden" id="tahun_id" name="tahun_id" value="">
                            <input type="hidden" id="program_studi_id" name="program_studi_id" value="">
                            <input type="hidden" id="jenjang_id" name="jenjang_id" value="">
                            <input type="hidden" id="timeline_id" name="timeline_id" value="">
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailTitle">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Akreditasi</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Status</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Pengajuan Dokumen</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Asesmen Kecukupan</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Asesmen Lapangan</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Berita Acara</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center" style=" margin-bottom: 3px;" >
                            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Sertifikat</label>
                            <div class="col-sm-6 col-md-9">
                                <p class="mt-2" id="site-title" >: Tgl awal s/d tanggal akhir </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function() {
            $('#daftarAkreditasiProdi').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.akreditasi.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        data: 'mulai',
                        name: 'mulai'
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
            });
        });

        $("body").on('click', ".btn-penugasan", function() {
            let url = $(this).data("url");
            let timelineId = $(this).data("timeline-id"); // Assuming you have the timeline ID
            let programStudiId = $(this).data("program-studi-id"); // Assuming you have the program studi ID
            let tahunId = $(this).data("tahun-id"); // Assuming you have the tahun ID
            let jenjangId = $(this).data("jenjang-id"); // Assuming you have the jenjang ID

            $("#formActionTugas").attr("action", url);
            $("#timeline_id").val(timelineId);
            $("#program_studi_id").val(programStudiId);
            $("#tahun_id").val(tahunId);
            $("#jenjang_id").val(jenjangId);
            $('#modalPenugasan').modal('show');
        });

        $("body").on('click', ".btn-detail", function() {
            let url = $(this).data("url") + "/edit";
            let programStudi = $(this).data("prodi");
            let tahunProdi = $(this).data("tahun");
            $("#modalDetailTitle").text("Detail " + programStudi + " | " + tahunProdi);
            $("#formActionDetail").attr("action", $(this).data("url"));
        });


        $("body").on('click', '#delete', function(e) {
            let id = $(this).data('id')
            let route = $(this).data('route')
            swal({
                title: 'Konfirmasi hapus data Akreditasi Prodi?',
                html: `Data Akreditasi Prodi akan dihapus!`,
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
                        text: "Akreditasi Prodi berhasil dihapus.",
                        icon: 'success',
                    }).then((response) => {

                        window.location.reload()
                    })
                }

            })
        })

        $("body").on('click', '.selesai-btn', function(e) {
            let id = $(this).data('id');
            let route = $(this).data('route')
            swal({
                title: 'Selesaikan Akreditasi?',
                html: `Akreditasi akan selesai, pastikan semua proses telah dilakukan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Selesai!',
                buttons: true,
                dangerMode: true,
            }).then((willEdit) => {
                let is_active = '1';
                if (willEdit) {
                    const response = $.ajax({
                        url: route,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            is_active: is_active,
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
                        text: "Akreditasi telah selesai",
                        icon: 'success',
                    }).then((response) => {

                        window.location.reload()
                    })
                }

            })
        })
        $(document).ready(function() {
            $('#user').change(function() {
                if ($(this).val() == 'other') {
                    $('#namaInput').show(); // Menampilkan input nama jika memilih opsi "Lainnya"
                    $('#emailInput').show(); // Menampilkan input email jika memilih opsi "Lainnya"
                } else {
                    $('#namaInput').hide(); // Menyembunyikan input nama jika memilih opsi lainnya
                    $('#emailInput').hide(); // Menyembunyikan input email jika memilih opsi lainnya
                }
            });
        });
    </script>

</body>

</html>

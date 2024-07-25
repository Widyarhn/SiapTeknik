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
    <title>UPPS | Timeline Akreditasi</title>
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
                        <h1>Akreditasi Program Studi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Akreditasi</div>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('akreditasi.index') }}"><i
                                                    class="fas fa-circle"></i>
                                                Dokumen Ajuan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('akreditasi.asesmenKecukupan') }}"><i
                                                    class="fas fa-regular fa-circle"></i>
                                                Asesmen Kecukupan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('akreditasi.asesmenLapangan') }}"><i
                                                    class="fas fa-circle"></i> Asesmen
                                                Lapangan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('akreditasi.selesai') }}"><i
                                                    class="fas  fa-solid fa-check"></i>
                                                Selesai</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-12">
                                @if ($timeline && $timeline->count() > 0)
                                    @foreach ($timeline as $t)
                                        @php
                                            $lkps = Lkps::where('program_studi_id', $t->program_studi_id)
                                                ->where('tahun_id', $t->tahun_id)
                                                ->first();
                                            $led = Led::where('program_studi_id', $t->program_studi_id)
                                                ->where('tahun_id', $t->tahun_id)
                                                ->first();
                                            $surat_pengantar = SuratPengantar::where(
                                                'program_studi_id',
                                                $t->program_studi_id,
                                            )
                                                ->where('tahun_id', $t->tahun_id)
                                                ->first();
                                            $asesor = UserAsesor::whereHas('timeline', function ($query) {
                                                $query->where('kegiatan', 'Asesmen Kecukupan');
                                            })-> where('program_studi_id', $t->program_studi_id)->first();
                                        @endphp

                                        <div class="card">
                                            @if ($surat_pengantar->status == 1 && $led->status == 1 && $lkps->status == 1)
                                                <div class="card-header"
                                                    style="border-bottom-width: 0px;padding-bottom: 0px;">
                                                    @if (is_null($asesor))
                                                        <h4>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#modalPenugasanAsesor"
                                                                data-tahun-id="{{ $t->tahun_id }}"
                                                                data-program-studi-id="{{ $t->program_studi_id }}"
                                                                data-jenjang-id="{{ $t->program_studi->jenjang_id }}"
                                                                class="btn btn-outline-primary btn-create"
                                                                style="border-radius: 30px;">
                                                                <i class="fas fa-user-plus"></i> Penugasan Asesor
                                                            </a>
                                                        </h4>
                                                    @else
                                                        <h4>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#modalPenugasanAsesor2"
                                                                data-timeline-ids="{{ $t_asesor->id }}"
                                                                data-tahun-ids="{{ $t->tahun_id }}"
                                                                data-program-studi-ids="{{ $t->program_studi_id }}"
                                                                data-jenjang-ids="{{ $t->program_studi->jenjang_id }}"
                                                                class="btn btn-outline-primary btn-tambah-user"
                                                                style="border-radius: 30px;">
                                                                <i class="fas fa-user-plus"></i> Penugasan Asesor
                                                            </a>
                                                        </h4>
                                                        <div class="card-header-action">
                                                            <a href="javascript:void(0)" data-id="{{ $t->id }}"
                                                                class="btn btn-info btn-selesai"
                                                                style="border-radius: 30px;"
                                                                data-route="{{ route('dokumen_selesai', $t->id) }}">
                                                                <i class="fas fa-check"></i> Selesaikan
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                            @endif

                                            <div class="card-body" style="padding-top: 20px;">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    {{ $t->program_studi->jenjang->jenjang }}
                                                                    {{ $t->program_studi->nama }} |
                                                                    {{ $t->tahun->tahun }} </th>
                                                                <th class="text-center w-50">Nama File</th>
                                                                <th class="text-center">Info</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">Surat Pengantar</td>
                                                                <td>
                                                                    <a href="{{ Storage::url($surat_pengantar->file) }}"
                                                                        target="_blank">{{ basename($surat_pengantar->file) }}</a>
                                                                </td>
                                                                <td class="text-center">

                                                                    @if ($surat_pengantar->status == 0 && $surat_pengantar->keterangan == null)
                                                                        <div
                                                                            class="d-flex align-items-center text-center">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-success btn-sm approve-btn"
                                                                                data-id="{{ $surat_pengantar->id }}"
                                                                                data-type="surat_pengantar"
                                                                                data-route="{{ route('dokumen_approve', ['id' => $surat_pengantar->id, 'type' => 'surat_pengantar']) }}">
                                                                                <i class="fa fa-check"></i> Approve
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm ml-1 disapprove-btn"
                                                                                data-id="{{ $surat_pengantar->id }}"
                                                                                data-type="surat_pengantar"
                                                                                data-route="{{ route('dokumen_disapprove', $surat_pengantar->id) }}">
                                                                                <b>X</b> Disapprove
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        @if ($surat_pengantar->status == '1')
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-success">
                                                                                {{ $surat_pengantar->keterangan }}
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-danger">
                                                                                {{ $surat_pengantar->keterangan }}
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">Dokumen LKPS</td>
                                                                <td>
                                                                    <a href="{{ Storage::url($lkps->file) }}"
                                                                        target="_blank">{{ basename($lkps->file) }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($lkps->status == 0 && $lkps->keterangan == null)
                                                                        <div
                                                                            class="d-flex align-items-center text-center">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-success btn-sm approve-btn"
                                                                                data-id="{{ $lkps->id }}"
                                                                                data-type="lkps"
                                                                                data-route="{{ route('dokumen_approve', ['id' => $lkps->id, 'type' => 'lkps']) }}">
                                                                                <i class="fa fa-check"></i> Approve
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm ml-1 disapprove-btn"
                                                                                data-id="{{ $lkps->id }}"
                                                                                data-type="lkps"
                                                                                data-route="{{ route('dokumen_disapprove', $lkps->id) }}">
                                                                                <b>X</b> Disapprove
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        @if ($lkps->status == '1')
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-success">
                                                                                {{ $lkps->keterangan }}
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-danger">
                                                                                {{ $lkps->keterangan }}
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">Dokumen LED</td>
                                                                <td>
                                                                    <a href="{{ Storage::url($led->file) }}"
                                                                        target="_blank">{{ basename($led->file) }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($led->status == 0 && $led->keterangan == null)
                                                                        <div
                                                                            class="d-flex align-items-center text-center">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-success btn-sm approve-btn"
                                                                                data-id="{{ $led->id }}"
                                                                                data-type="led"
                                                                                data-route="{{ route('dokumen_approve', ['id' => $led->id, 'type' => 'led']) }}">
                                                                                <i class="fa fa-check"></i> Approve
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm ml-1 disapprove-btn"
                                                                                data-id="{{ $led->id }}"
                                                                                data-type="led"
                                                                                data-route="{{ route('dokumen_disapprove', $led->id) }}">
                                                                                <b>X</b> Disapprove
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        @if ($led->status == '1')
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-success">
                                                                                {{ $led->keterangan }}
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="buttons btn btn-icon icon-left btn-danger">
                                                                                {{ $led->keterangan }}
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body" style="padding-top: 20px;">
                                            <i class="text-center">
                                                <h6>Belum Ada Dokumen yang Diajukan</h6>
                                            </i>
                                        </div>
                                    </div>
                                @endif
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

            <div class="modal fade" tabindex="-1" role="dialog" id="modalPenugasanAsesor">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Penugasan User Asesor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('UPPS.akreditasi.penugasanAsesor') }}" method="post"
                                enctype="multipart/form-data" id="formActionTugas">
                                @csrf

                                <div class="card-body" id="formTugas">
                                    <div class="form-group">
                                        <label for="kegiatan">Kegiatan</label>
                                        <input type="text" class="form-control" id="kegiatan"
                                            placeholder="Asesmen Kecukupan" name="kegiatan" required=""
                                            disabled="">
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
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="nama">Nama</label>
                                            <select id="user" class="form-control selectric" name="user_id">
                                                <option value="">-- Pilih atau Ketik --</option>
                                                @foreach ($user as $u)
                                                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                                @endforeach
                                                <option value="other">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="jabatan">Jabatan</label>
                                            <input type="text" class="form-control" id="jabatan"
                                                name="jabatan">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6" id="namaInput" style="display: none;">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama"
                                                name="nama">
                                        </div>
                                        <div class="form-group col-lg-6" id="emailInput" style="display: none;">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                name="email">
                                        </div>
                                    </div>

                                    <!-- Hidden fields for user_prodi -->
                                    <input type="hidden" id="tahun_id" name="tahun_id" value="">
                                    <input type="hidden" id="program_studi_id" name="program_studi_id"
                                        value="">
                                    <input type="hidden" id="jenjang_id" name="jenjang_id" value="">

                                </div>
                                <div class="card-footer text-right"
                                    style="background-color:rgba(0, 0, 0, 0); border-top:none;">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="modalPenugasanAsesor2">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Penugasan User Asesor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('UPPS.user.store') }}" method="post"
                                enctype="multipart/form-data" id="formActionTugas">
                                @csrf

                                <div class="card-body" id="formTugass">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="nama">Nama</label>
                                            <select id="user2" class="form-control selectric" name="user_id">
                                                <option value="">-- Pilih atau Ketik --</option>
                                                @foreach ($user as $u)
                                                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                                @endforeach
                                                <option value="other">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="jabatan">Jabatan</label>
                                            <input type="text" class="form-control" id="jabatan"
                                                name="jabatan">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6" id="namaIn" style="display: none;">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama"
                                                name="nama">
                                        </div>
                                        <div class="form-group col-lg-6" id="emailIn" style="display: none;">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                name="email">
                                        </div>
                                    </div>

                                    <!-- Hidden fields for user_prodi -->
                                    <input type="hidden" id="tahun_ids" name="tahun_ids" value="">
                                    <input type="hidden" id="program_studi_ids" name="program_studi_ids"
                                        value="">
                                    <input type="hidden" id="jenjang_ids" name="jenjang_ids" value="">
                                    <input type="hidden" id="timeline_ids" name="timeline_ids" value="">

                                </div>
                                <div class="card-footer text-right"
                                    style="background-color:rgba(0, 0, 0, 0); border-top:none;">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="disapproveModal" tabindex="-1" role="dialog"
                aria-labelledby="disapproveModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="disapproveModalLabel">Disapprove Dokumen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="disapproveForm" action="" method="POST">
                                @csrf
                                <input type="hidden" id="docId" name="id" value="">
                                <input type="hidden" id="docType" name="type" value="">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Disapprove</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">Submit Disapprove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

            <script>
                $(document).ready(function() {
                    $('#modalPenugasanAsesor').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var tahunId = button.data('tahun-id');
                        var programStudiId = button.data('program-studi-id');
                        var jenjangId = button.data('jenjang-id');

                        // Set the values to the hidden input fields
                        $('#tahun_id').val(tahunId);
                        $('#program_studi_id').val(programStudiId);
                        $('#jenjang_id').val(jenjangId);
                    });
                });
                $(document).ready(function() {
                    $('#modalPenugasanAsesor2').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var timelineIds = button.data('timeline-ids');
                        var tahunIds = button.data('tahun-ids');
                        var programStudiIds = button.data('program-studi-ids');
                        var jenjangIds = button.data('jenjang-ids');

                        // Set the values to the hidden input fields
                        $('#timeline_ids').val(timelineIds);
                        $('#tahun_ids').val(tahunIds);
                        $('#program_studi_ids').val(programStudiIds);
                        $('#jenjang_ids').val(jenjangIds);
                    });
                });
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

                $(document).ready(function() {
                    $('#user2').change(function() {
                        if ($(this).val() == 'other') {
                            $('#namaIn').show(); // Menampilkan in nama jika memilih opsi "Lainnya"
                            $('#emailIn').show(); // Menampilkan in email jika memilih opsi "Lainnya"
                        } else {
                            $('#namaIn').hide(); // Menyembunyikan in nama jika memilih opsi lainnya
                            $('#emailIn').hide(); // Menyembunyikan input email jika memilih opsi lainnya
                        }
                    });
                });

                $(document).ready(function() {
                    // Event handler untuk tombol disapprove
                    $('body').on('click', '.disapprove-btn', function() {
                        let id = $(this).data('id');
                        let type = $(this).data('type');
                        let route = $(this).data('route');

                        // Atur form action dan input values
                        $('#disapproveForm').attr('action', route);
                        $('#docId').val(id);
                        $('#docType').val(type);

                        // Tampilkan modal
                        $('#disapproveModal').modal('show');
                    });
                });


                $(document).ready(function() {
                    $("body").on('click', '.approve-btn', function() {
                        let id = $(this).data('id');
                        let route = $(this).data('route');
                        let type = $(this).data('type'); // Jenis dokumen jika diperlukan

                        swal({
                            title: 'Approve?',
                            html: 'Apakah Anda yakin ingin menyetujui dokumen ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Setujui',
                            cancelButtonText: 'Batal',
                            buttons: true,
                            dangerMode: true,
                        }).then((willApprove) => {
                            console.log(willApprove);
                            if (willApprove) {
                                $.ajax({
                                    url: route,
                                    method: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: id,
                                        type: type, // Kirim jenis dokumen jika diperlukan
                                    }
                                }).done(function(response) {
                                    swal({
                                        title: 'Berhasil!',
                                        text: "Dokumen berhasil disetujui!",
                                        icon: 'success',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }).fail(function() {
                                    swal({
                                        title: 'Terjadi kesalahan!',
                                        text: 'Server Error',
                                        icon: 'error'
                                    });
                                });
                            }
                        });
                    });
                });

                $(document).ready(function() {
                    $("body").on('click', '.btn-selesai', function() {
                        let id = $(this).data('id');
                        let route = $(this).data('route');

                        swal({
                            title: 'Selesaikan?',
                            html: 'Apakah Anda yakin ingin menyelesaikan dokumen ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oke!',
                            cancelButtonText: 'Batal',
                            buttons: true,
                            dangerMode: true,
                        }).then((willSelesaikan) => {
                            console.log(willSelesaikan);
                            if (willSelesaikan) {
                                $.ajax({
                                    url: route,
                                    method: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: id,
                                    }
                                }).done(function(response) {
                                    swal({
                                        title: 'Berhasil!',
                                        text: "Dokumen berhasil diselesaikan, Silahkan lihat ditahap selanjutnya!",
                                        icon: 'success',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }).fail(function() {
                                    swal({
                                        title: 'Terjadi kesalahan!',
                                        text: 'Server Error',
                                        icon: 'error'
                                    });
                                });
                            }
                        });
                    });
                });


                // $(document).ready(function() {
                //     $('body').on('click', '#approve-btn', function() {
                //         let id = $(this).data('id');
                //         let route = $(this).data('route');

                //         Swal.fire({
                //             title: 'Approve?',
                //             text: "Apakah Anda yakin ingin menyetujui dokumen ini?",
                //             icon: 'warning',
                //             showCancelButton: true,
                //             confirmButtonText: 'Menyetujui',
                //             cancelButtonText: 'Batal',
                //             reverseButtons: true
                //         }).then((result) => {
                //             if (result.isConfirmed) {
                //                 $.ajax({
                //                     url: route,
                //                     method: 'POST',
                //                     data: {
                //                         _token: "{{ csrf_token() }}",
                //                         id: id
                //                     },
                //                     success: function(response) {
                //                         if (response.success) {
                //                             Swal.fire(
                //                                 'Berhasil!',
                //                                 'Dokumen berhasil disetujui!',
                //                                 'success'
                //                             ).then(() => {
                //                                 window.location.reload();
                //                             });
                //                         } else {
                //                             Swal.fire(
                //                                 'Gagal!',
                //                                 response.message,
                //                                 'error'
                //                             );
                //                         }
                //                     },
                //                     error: function() {
                //                         Swal.fire(
                //                             'Terjadi Kesalahan!',
                //                             'Server Error',
                //                             'error'
                //                         );
                //                     }
                //                 });
                //             }
                //         });
                //     });
                // });
            </script>

        </div>
    </div>
</body>

</html>

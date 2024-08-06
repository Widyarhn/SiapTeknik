@php
    use App\Models\Lkps;
    use App\Models\Led;
    use App\Models\SuratPengantar;
    use App\Models\UserProdi;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dokumen Ajuan &rsaquo; {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('prodi.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('prodi.layout.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Dokumen Ajuan Akreditasi
                        </h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">{{ $program_studi->jenjang->jenjang }}
                                {{ $program_studi->nama }}</div>
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
                        <h2 class="section-title">Dokumen Ajuan Akreditasi Program Studi
                            {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h2>
                        <p class="section-lead">Pengajuan berupa dokumen Lembar Kerja Program Studi (LKPS), Lembar
                            Evaluasi Diri
                            (LED), Surat Pengantar, serta Import File Excel</p>
                    </div>

                    @foreach ($user_prodi as $up)
                        @if (empty($up->tahun_id))
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Tahun
                                                                {{ $now }}</th>
                                                            <th class="text-center"> </th>
                                                            <th>Nama File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            // $lkps = UserProdi::with([
                                                            //     'lkps' => function ($q) use ($up) {
                                                            //         $q->where(
                                                            //             'program_studi_id',
                                                            //             $up->program_studi_id,
                                                            //         );
                                                            //     }, 'tahun' => function ($q){
                                                            //         $q->whereIn('is_active', [1, null]);
                                                            //     },
                                                            // ])->first();

                                                            // $led = UserProdi::with([
                                                            //     'led' => function ($q) use ($up) {
                                                            //         $q->where(
                                                            //             'program_studi_id',
                                                            //             $up->program_studi_id,
                                                            //         );
                                                            //     }, 'tahun' => function ($q){
                                                            //         $q->whereIn('is_active', [1, null]);
                                                            //     },
                                                            // ])->first();
                                                            // $surat_pengantar = UserProdi::with([
                                                            //     'surat_pengantar' => function ($q) use ($up) {
                                                            //         $q->where(
                                                            //             'program_studi_id',
                                                            //             $up->program_studi_id,
                                                            //         );
                                                            //     }, 'tahun' => function ($q){
                                                            //         $q->whereIn('is_active', [1, null]);
                                                            //     },
                                                            // ])->first();

                                                            // $led = Led::where(
                                                            //     'program_studi_id',
                                                            //     $up->program_studi_id,
                                                            // )->first();
                                                            // $surat_pengantar = SuratPengantar::where(
                                                            //     'program_studi_id',
                                                            //     $up->program_studi_id,
                                                            // )->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">Surat Pengantar</td>
                                                            <td class="text-center">
                                                                @if (empty($surat_pengantar))
                                                                    <form action="{{ route('ajuan-prodi.storeSp') }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @elseif($surat_pengantar->status == 0 || $surat_pengantar->status == 2)
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updateSp', $up->surat_pengantar->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="d-flex align-items-left">
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf">
                                                                            <button type="submit"
                                                                                class="btn btn-outline-warning">Update</button>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (empty($surat_pengantar))
                                                                    Belum ada
                                                                @else
                                                                    <a href="{{ Storage::url($surat_pengantar->file) }}"
                                                                        target="_blank">{{ basename($surat_pengantar->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LKPS</td>
                                                            <td class="text-center">
                                                                @if (empty($lkps))
                                                                    <form action="{{ route('ajuan-prodi.storelkps') }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')

                                                                        <div class="d-flex align-items-center">
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @elseif($lkps->status == 0 || $lkps->status == 2)
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updatelkps', $up->lkps->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="d-flex align-items-left">
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required="">

                                                                            <button type="submit"
                                                                                class="btn btn-outline-warning">Update</button>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (empty($lkps))
                                                                    Belum ada
                                                                @else
                                                                    <a href="{{ Storage::url($lkps->file) }}"
                                                                        target="_blank">{{ basename($lkps->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LED</td>
                                                            <td>
                                                                @if (empty($led))
                                                                    <form action="{{ route('ajuan-prodi.storeled') }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @elseif($led->status == 0 || $led->status == 2)
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updateled', $up->led->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden"
                                                                            value="{{ $up->program_studi_id }}"
                                                                            name="program_studi_id" />
                                                                        <div class="d-flex align-items-left">
                                                                            <input type="file" name="file"
                                                                                required="" accept=".pdf">

                                                                            <button type="submit"
                                                                                class="btn btn-outline-warning">Update</button>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (empty($led))
                                                                    Belum ada
                                                                @else
                                                                    <a href="{{ Storage::url($led->file) }}"
                                                                        target="_blank">{{ basename($led->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9 col-lg-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Import Tabel LKPS &rsaquo; </h4>Import file LKPS per kriteria
                                        </div>
                                        <div class="card-body">
                                            @foreach ($kriteria as $kriteria)
                                                <div class="form-group row align-items-center">
                                                    <label
                                                        class="col-md-4 text-md-right text-left">{{ $kriteria->kriteria }}</label>
                                                    <div class="col-lg-6">
                                                        <form
                                                            action="{{ route('ajuan-prodi.importLkps', ['id_prodi' => $up->program_studi_id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id_prodi"
                                                                value="{{ $up->program_studi_id }}">
                                                            <input type="hidden" name="id_kriteria"
                                                                value="{{ $kriteria->id }}">

                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file" accept=".xlsx">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2"><i
                                                                        class="fa fa-file"></i> Import</button>
                                                            </div>
                                                        </form>
                                                        {{-- <div class="d-flex align-items-center">
                                                            <input type="file" name="file" required
                                                                class="form-control-file">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-primary ml-2 ">Import</button>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    @if (
                                        !empty($led) &&
                                            !empty($lkps) &&
                                            !empty($surat_pengantar) &&
                                            $led->status != 2 &&
                                            $lkps->status != 2 &&
                                            $surat_pengantar->status != 2 &&
                                            empty($up->pengajuan_dokumen->tanggal_selesai))
                                        <a href="javascript:void(0)" data-id="{{ $up->id }}"
                                            data-lkps="{{ $lkps->id }}"
                                            data-surat_pengantar="{{ $surat_pengantar->id }}"
                                            data-led="{{ $led->id }}" data-tahun="{{ now()->year }}"
                                            data-route="{{ route('ajuan-prodi.ajukan') }}"
                                            class="text-center text-white btn-sm ajukan-btn">
                                            <div class="card p-3"
                                                style="background-color: rgba(20, 49, 239, 0.801); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);">
                                                <h6 class="m-0">Ajukan Akreditasi Prodi</h6>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @elseif ($up->tahun->is_active == 1)
                            @if ($up->pengajuan_dokumen->status == 2)
                                <div class="alert alert-warning alert-dismissible show fade alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        <div class="alert-title">Dokumen Akreditasi telah ditolak</div>
                                        Catatan UPPS: {{ $up->pengajuan_dokumen->keterangan }}
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Tahun {{ $now }}</th>
                                                            @if ($up->pengajuan_dokumen->status != 1)
                                                                <th class="text-center"> </th>
                                                            @endif
                                                            <th>Nama File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $lkps = Lkps::where(
                                                                'program_studi_id',
                                                                $up->program_studi_id,
                                                            )->first();
                                                            $led = Led::where(
                                                                'program_studi_id',
                                                                $up->program_studi_id,
                                                            )->first();
                                                            $surat_pengantar = SuratPengantar::where(
                                                                'program_studi_id',
                                                                $up->program_studi_id,
                                                            )->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">Surat Pengantar</td>
                                                            @if ($up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if ($surat_pengantar->status == 0 || $surat_pengantar->status == 2)
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updateSp', $up->surat_pengantar->id) }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
                                                                            id="formActionStore">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <div class="d-flex align-items-left">
                                                                                <input type="hidden"
                                                                                    value="{{ $up->program_studi_id }}"
                                                                                    name="program_studi_id" />
                                                                                <input type="file" name="file"
                                                                                    accept=".pdf">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if (!empty($surat_pengantar))
                                                                    <a href="{{ Storage::url($surat_pengantar->file) }}"
                                                                        target="_blank">{{ basename($surat_pengantar->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LKPS</td>
                                                            @if ($up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if ($lkps->status == 0 || $lkps->status == 2)
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updatelkps', $up->lkps->id) }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
                                                                            id="formActionStore">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <div class="d-flex align-items-left">
                                                                                <input type="hidden"
                                                                                    value="{{ $up->program_studi_id }}"
                                                                                    name="program_studi_id" />
                                                                                <input type="file" name="file"
                                                                                    accept=".pdf" required="">

                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if (!empty($lkps))
                                                                    <a href="{{ Storage::url($lkps->file) }}"
                                                                        target="_blank">{{ basename($lkps->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LED</td>
                                                            @if ($up->pengajuan_dokumen->status != 1)
                                                                <td>
                                                                    @if ($led->status == 0 || $led->status == 2)
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updateled', $up->led->id) }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
                                                                            id="formActionStore">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <input type="hidden"
                                                                                value="{{ $up->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <div class="d-flex align-items-left">
                                                                                <input type="file" name="file"
                                                                                    required="" accept=".pdf">

                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if (!empty($led))
                                                                    <a href="{{ Storage::url($led->file) }}"
                                                                        target="_blank">{{ basename($led->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9 col-lg-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Import Tabel LKPS &rsaquo; </h4>Import file LKPS per kriteria
                                        </div>

                                        @if ($up->pengajuan_dokumen->status != 1)
                                            <div class="card-body">
                                                @foreach ($kriteria as $kriteria)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $kriteria->kriteria }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        @else
                                            <div class="card-body">
                                                @foreach ($kriteria as $kriteria)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-6 text-md-right text-left">{{ $kriteria->kriteria }}</label>
                                                        <div class="col-lg-2">
                                                            <a href="" target="_blank"
                                                                class="btn btn-md btn-info btn-edit">
                                                                <i class="fas fa-file" aria-hidden="true">&nbsp
                                                                    Lihat
                                                                    File</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    @if ($up->pengajuan_dokumen->status != 1)
                                        @if (
                                            !empty($led) &&
                                                !empty($lkps) &&
                                                !empty($surat_pengantar) &&
                                                $led->status != 2 &&
                                                $lkps->status != 2 &&
                                                $surat_pengantar->status != 2 &&
                                                empty($up->pengajuan_dokumen->tanggal_selesai))
                                            <a href="javascript:void(0)" data-id="{{ $up->id }}"
                                                data-lkps="{{ $lkps->id }}"
                                                data-surat_pengantar="{{ $surat_pengantar->id }}"
                                                data-led="{{ $led->id }}" data-tahun="{{ now()->year }}"
                                                data-route="{{ route('ajuan-prodi.ajukan') }}"
                                                class="text-center text-white btn-sm ajukan-btn">
                                                <div class="card p-3"
                                                    style="background-color: rgba(20, 49, 239, 0.801); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);">
                                                    <h6 class="m-0">Ajukan Akreditasi Prodi</h6>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <h1 class="p-4 m-4">Akreditasi pada tahun {{ $up->tahun->tahun }} telah
                                    selesai, silahkan lihat history akreditasi</h1>
                            </div>
                        @endif
                    @endforeach




                </section>
            </div>
        </div>
        <footer class="main-footer">
            @include('footer')
            <div class="footer-right">
            </div>
        </footer>
        <script>
            $(document).ready(function() {
                $("body").on('click', '.ajukan-btn', function() {
                    let id = $(this).data('id');
                    let led_id = $(this).data('led');
                    let lkps_id = $(this).data('lkps');
                    let surat_pengantar_id = $(this).data('surat_pengantar');
                    let tahun = $(this).data('tahun'); // Mengambil tahun dari data-attributes
                    let route = $(this).data('route');
                    let tanggal_hari_ini = new Date().toISOString().slice(0, 10);

                    swal({
                        title: 'Ajukan Akreditasi?',
                        html: 'Apakah Anda yakin ingin mengajukan akreditasi prodi ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Setujui',
                        cancelButtonText: 'Batal',
                        buttons: true,
                        dangerMode: true,
                    }).then((willajukan) => {
                        if (willajukan) {
                            $.ajax({
                                url: route,
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_prodi_id: id,
                                    led_id: led_id,
                                    lkps_id: lkps_id,
                                    surat_pengantar_id: surat_pengantar_id,
                                    tahun: tahun, // Menambahkan tahun
                                    tanggal_hari_ini: tanggal_hari_ini
                                }
                            }).done(function(response) {
                                swal({
                                    title: 'Berhasil!',
                                    text: "Pengajuan Akreditasi Program Studi Berhasil! Tunggu info selanjutnya.",
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
        </script>
    </div>
</body>

</html>

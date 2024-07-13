@php
    use App\Models\Lkps;
    use App\Models\Led;
    use App\Models\SuratPengantar;
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
                        <h1>Dokumen Ajuan Akreditasi {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}
                        </h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item"> {{ $program_studi->jenjang->jenjang }}
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
                        <h2 class="section-title">Pengajuan Dokumen Akreditasi Program Pendidikan
                            {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h2>
                        <p class="section-lead">Berupa dokumen Lembar Kerja Program Studi (LKPS), Lembar Evaluasi Diri
                            (LED), dan Surat Pengantar
                            dari program studi D3 {{ $program_studi->nama }} POLINDRA</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @foreach ($user_prodi as $item_tahun)
                                @if ($item_tahun->tahun->is_active == 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Tahun
                                                                {{ $item_tahun->tahun->tahun }}</th>
                                                            <th class="text-center"> </th>
                                                            <th>Nama File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $lkps = Lkps::where(
                                                                'program_studi_id',
                                                                $item_tahun->program_studi_id,
                                                            )
                                                                ->where('tahun_id', $item_tahun->tahun_id)
                                                                ->first();
                                                            $led = Led::where(
                                                                'program_studi_id',
                                                                $item_tahun->program_studi_id,
                                                            )
                                                                ->where('tahun_id', $item_tahun->tahun_id)
                                                                ->first();
                                                            $surat_pengantar = SuratPengantar::where(
                                                                'program_studi_id',
                                                                $item_tahun->program_studi_id,
                                                            )
                                                                ->where('tahun_id', $item_tahun->tahun_id)
                                                                ->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">Surat Pengantar</td>
                                                            <td class="text-center">
                                                                @if (empty($surat_pengantar))
                                                                    <form action="{{ route('ajuan-prodi.storeSp') }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        <div class="d-flex align-items-center"
                                                                            style="width: 270px;">
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->tahun->id }}"
                                                                                name="tahun_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updateSp', $item_tahun->tahun->surat_pengantar[0]->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <!-- Menggunakan POST untuk update -->
                                                                        <div class="d-flex align-items-left"
                                                                            style="width: 270px;">
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->tahun->id }}"
                                                                                name="tahun_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf">
                                                                            <button type="submit"
                                                                                class="btn btn-outline-warning">Update dulu</button>
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

                                                                        <div class="d-flex align-items-center"
                                                                            style="width: 270px;">
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->tahun->id }}"
                                                                                name="tahun_id" />
                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updatelkps', $item_tahun->tahun->lkps[0]->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="d-flex align-items-left"
                                                                            style="width: 270px;">
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->tahun->id }}"
                                                                                name="tahun_id" />
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
                                                                        <div class="d-flex align-items-center"
                                                                            style="width: 270px;">
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->program_studi_id }}"
                                                                                name="program_studi_id" />
                                                                            <input type="hidden"
                                                                                value="{{ $item_tahun->tahun->id }}"
                                                                                name="tahun_id" />

                                                                            <input type="file" name="file"
                                                                                accept=".pdf" required>
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary">Upload</button>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <form
                                                                        action="{{ route('ajuan-prodi.updateled', $item_tahun->tahun->led[0]->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden"
                                                                            value="{{ $item_tahun->program_studi_id }}"
                                                                            name="program_studi_id" />
                                                                        <input type="hidden"
                                                                            value="{{ $item_tahun->tahun->id }}"
                                                                            name="tahun_id" />

                                                                        <div class="d-flex align-items-left"
                                                                            style="width: 270px;">
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
                                @else
                                    <h1>Akreditasi pada tahun {{ $item_tahun->tahun->tahun }} telah selesai, silahkan
                                        lihat history akreditasi</h1>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-12 col-md-9 col-lg-9">
                            <div class="card">
                                <div class="card-body mt-3">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="kriteria1-tab" data-toggle="tab"
                                                href="#kriteria1" role="tab" aria-controls="home"
                                                aria-selected="true">1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria2-tab" data-toggle="tab"
                                                href="#kriteria2" role="tab" aria-controls="kriteria2"
                                                aria-selected="false">2</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria3-tab" data-toggle="tab"
                                                href="#kriteria3" role="tab" aria-controls="kriteria3"
                                                aria-selected="false">3</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria4-tab" data-toggle="tab"
                                                href="#kriteria4" role="tab" aria-controls="kriteria4"
                                                aria-selected="false">4</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria5-tab" data-toggle="tab"
                                                href="#kriteria5" role="tab" aria-controls="kriteria5"
                                                aria-selected="false">5</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria6-tab" data-toggle="tab"
                                                href="#kriteria6" role="tab" aria-controls="kriteria6"
                                                aria-selected="false">6</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria7-tab" data-toggle="tab"
                                                href="#kriteria7" role="tab" aria-controls="kriteria7"
                                                aria-selected="false">7</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="kriteria8-tab" data-toggle="tab"
                                                href="#kriteria8" role="tab" aria-controls="kriteria8"
                                                aria-selected="false">8</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="kriteria1" role="tabpanel"
                                            aria-labelledby="kriteria1-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Tata
                                                        Pamong, Tata Kelola, dan Kerjasama</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 4)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <form
                                                                action="{{ route('ajuan-prodi.importLkps', ['id_prodi' => $program_studi->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="program_studi_id"
                                                                    value="{{ $program_studi->id }}">
                                                                <input type="hidden" name="list_lkps_id"
                                                                    value="{{ $d3->id }}">

                                                                <div class="d-flex align-items-center">
                                                                    <input type="file" name="file" required
                                                                        class="form-control-file">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-primary ml-2"><i
                                                                            class="fa fa-file"></i> Import</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        {{-- if data ada muncul ini kalo gada ga tampil --}}
                                                        {{-- <div class="col-lg-2">
                                                            <a href="" target="_blank"
                                                                class="btn btn-md btn-info btn-edit">
                                                                <i class="fas fa-file" aria-hidden="true">&nbsp
                                                                    View</i>
                                                            </a>
                                                        </div> --}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria2" role="tabpanel"
                                            aria-labelledby="kriteria2-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Mahasiswa
                                                    </p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 5)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria3" role="tabpanel"
                                            aria-labelledby="kriteria3-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Sumber
                                                        Daya Manusia</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 6)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria4" role="tabpanel"
                                            aria-labelledby="kriteria4-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Keuangan,
                                                        Sarana dan Prasarana</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 7)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria5" role="tabpanel"
                                            aria-labelledby="kriteria5-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Pendidikan
                                                    </p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 8)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria6" role="tabpanel"
                                            aria-labelledby="kriteria6-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Pengabdian
                                                        Kepada Masyarakat</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 10)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria7" role="tabpanel"
                                            aria-labelledby="kriteria7-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Luaran dan
                                                        Capaian Tridharma</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 11)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="kriteria8" role="tabpanel"
                                            aria-labelledby="kriteria8-tab">
                                            <div class="form-group row align-items-center d-flex ml-2 mt-4 text-center"
                                                style="width: 100%;">
                                                <div class="col-12">
                                                    <p
                                                        style="font-weight:600; font-size: 20px; color: black; margin: 0;">
                                                        Import Tabel LKPS Kriteria</p>
                                                    <p style="font-weight:600; color: royalblue; margin: 0;">Penjaminan
                                                        Mutu</p>
                                                </div>
                                            </div>

                                            @foreach ($list_d3 as $d3)
                                                @if ($d3->kriteria_id == 12)
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-md-4 text-md-right text-left">{{ $d3->nama }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <a href="" class="text-center text-white">
                                <div class="card p-3"
                                    style="background-color: rgba(70, 231, 61, 0.801); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);">
                                    <h6 class="m-0">Ajukan Akreditasi Prodi</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <footer class="main-footer">
            @include('footer')
            <div class="footer-right">
            </div>
        </footer>
    </div>
</body>

</html>
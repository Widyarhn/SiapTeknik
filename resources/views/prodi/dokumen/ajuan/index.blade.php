@php
    use App\Models\Lkps;
    use App\Models\Led;
    use App\Models\SuratPengantar;
    use App\Models\UserProdi;
    use App\Models\SuratPernyataan;
    use App\Models\LampiranRenstra;
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
                        @php
                            $existingUP = $user_prodi->whereNull('tahun_id')->first();
                        @endphp
                        @if ($existingUP || $up->tahun->is_active == 1)
                            @if ($up->pengajuan_dokumen)
                                @if ($up->pengajuan_dokumen->status == '2')
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
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            {{-- @dd($up) --}}
                                                            <th class="text-center">Tahun {{ $now }}</th>

                                                            {{-- @if ($up->tahun_id == null || $up->pengajuan_dokumen->status != 1)
                                                                <th class="text-center"> </th>
                                                                <th>Nama File</th>
                                                            @elseif ($up->tahun_id && $up->pengajuan_dokumen->status == 1)
                                                                <th>Nama File</th>
                                                            @endif --}}
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <th class="text-center"> </th>
                                                            @endif
                                                            <th>Nama File</th>
                                                        </tr>
                                                    </thead>
                                                    {{-- <tbody>
                                                        <tr>
                                                            <td class="text-center">Surat Pengantar</td>
                                                            @if ($up->tahun_id == null)
                                                                @if (empty($up->surat_pengantar))
                                                                    <td class="text-center">
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storeSp') }}"
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
                                                                    </td>
                                                                    <td>
                                                                        Belum ada
                                                                    </td>
                                                                @elseif($up->surat_pengantar->status != '1')
                                                                    <td class="text-center">
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
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->surat_pengantar->file) }}"
                                                                            target="_blank">{{ basename($up->surat_pengantar->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @else
                                                                @if ($up->pengajuan_dokumen->status == '1')
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->surat_pengantar->file) }}"
                                                                            target="_blank">{{ basename($up->surat_pengantar->file) }}</a>
                                                                    </td>
                                                                @elseif($up->pengajuan_dokumen->status != '1' && $up->surat_pengantar->status != '1')
                                                                    <td class="text-center">
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
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->surat_pengantar->file) }}"
                                                                            target="_blank">{{ basename($up->surat_pengantar->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">LED</td>
                                                            @if ($up->tahun_id == null)
                                                                @if (empty($up->led))
                                                                    <td class="text-center">
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storeled') }}"
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
                                                                    </td>
                                                                    <td>
                                                                        Belum ada
                                                                    </td>
                                                                @elseif($up->led->status != '1')
                                                                    <td class="text-center">
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updateled', $up->led->id) }}"
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
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->led->file) }}"
                                                                            target="_blank">{{ basename($up->led->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @else
                                                                @if ($up->pengajuan_dokumen->status == '1')
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->led->file) }}"
                                                                            target="_blank">{{ basename($up->led->file) }}</a>
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updateled', $up->led->id) }}"
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
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->led->file) }}"
                                                                            target="_blank">{{ basename($up->led->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">LKPS</td>
                                                            @if ($up->tahun_id == null)
                                                                @if (empty($up->lkps))
                                                                    <td class="text-center">
                                                                        <form
                                                                        action="{{ route('ajuan-prodi.storelkps') }}"
                                                                        method="post"
                                                                        enctype="multipart/form-data"
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
                                                                    </td>
                                                                    <td>
                                                                        Belum ada
                                                                    </td>
                                                                @elseif($up->lkps->status != '1')
                                                                    <td class="text-center">
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
                                                                                    accept=".pdf">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->lkps->file) }}"
                                                                            target="_blank">{{ basename($up->lkps->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @else
                                                                @if ($up->pengajuan_dokumen->status == '1')
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->lkps->file) }}"
                                                                            target="_blank">{{ basename($up->lkps->file) }}</a>
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">
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
                                                                                    accept=".pdf">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($up->lkps->file) }}"
                                                                            target="_blank">{{ basename($up->lkps->file) }}</a>
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    </tbody> --}}
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">Surat Pengantar</td>
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if (empty($up->surat_pengantar))
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storeSp') }}"
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
                                                                    @elseif($up->surat_pengantar->status != 1)
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
                                                            @endif
                                                            <td>
                                                                @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                    @if (empty($up->surat_pengantar))
                                                                        Belum ada
                                                                    @else
                                                                        <a href="{{ Storage::url($up->surat_pengantar->file) }}"
                                                                            target="_blank">{{ basename($up->surat_pengantar->file) }}</a>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ Storage::url($up->surat_pengantar->file) }}"
                                                                        target="_blank">{{ basename($up->surat_pengantar->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Surat Pernyataan</td>
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if (empty($up->surat_pernyataan))
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storePernyataan') }}"
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
                                                                    @elseif($up->surat_pernyataan->status != 1)
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updatePernyataan', $up->surat_pernyataan->id) }}"
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
                                                            @endif
                                                            <td>
                                                                @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                    @if (empty($up->surat_pernyataan))
                                                                        Belum ada
                                                                    @else
                                                                        <a href="{{ Storage::url($up->surat_pernyataan->file) }}"
                                                                            target="_blank">{{ basename($up->surat_pernyataan->file) }}</a>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ Storage::url($up->surat_pernyataan->file) }}"
                                                                        target="_blank">{{ basename($up->surat_pernyataan->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LKPS</td>
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if (empty($up->lkps))
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storelkps') }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
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
                                                                    @elseif($up->lkps->status != 1)
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
                                                                @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                    @if (empty($up->lkps))
                                                                        Belum ada
                                                                    @else
                                                                        <a href="{{ Storage::url($up->lkps->file) }}"
                                                                            target="_blank">{{ basename($up->lkps->file) }}</a>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ Storage::url($up->lkps->file) }}"
                                                                        target="_blank">{{ basename($up->lkps->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LED</td>
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <td>
                                                                    @if (empty($up->led))
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storeled') }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
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
                                                                    @elseif($up->led->status != 1)
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
                                                                @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                    @if (empty($up->led))
                                                                        Belum ada
                                                                    @else
                                                                        <a href="{{ Storage::url($up->led->file) }}"
                                                                            target="_blank">{{ basename($up->led->file) }}</a>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ Storage::url($up->led->file) }}"
                                                                        target="_blank">{{ basename($up->led->file) }}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Lampiran (Izin Pendirian PS,
                                                                Renstra)</td>
                                                            @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                <td class="text-center">
                                                                    @if (empty($up->lampiran_renstra))
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.storeLampiran') }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data"
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
                                                                    @elseif($up->lampiran_renstra->status != 1)
                                                                        <form
                                                                            action="{{ route('ajuan-prodi.updateSp', $up->lampiran_renstra->id) }}"
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
                                                                @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                                    @if (empty($up->lampiran_renstra))
                                                                        Belum ada
                                                                    @else
                                                                        <a href="{{ Storage::url($up->lampiran_renstra->file) }}"
                                                                            target="_blank">{{ basename($up->lampiran_renstra->file) }}</a>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ Storage::url($up->lampiran_renstra->file) }}"
                                                                        target="_blank">{{ basename($up->lampiran_renstra->file) }}</a>
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
                                            <b>Template LKPS yang Tersedia:</b>
                                            <ol>
                                                @forelse($templates as $template)
                                                    <li>
                                                        <a href="{{ url('storage/instrumen/' . $template->file) }}"
                                                            target="_blank"  download>
                                                            {{ $template->judul }}
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li>Tidak ada template LKPS yang tersedia.</li>
                                                @endforelse
                                            </ol>
                                            @foreach ($kriteria as $kriteriaItem)
                                                <div class="form-group row align-items-center">
                                                    <label
                                                        class="col-md-4 text-md-right text-left">{{ $kriteriaItem->kriteria }}
                                                    </label>

                                                    @php
                                                        $existingLkps = $importLkps
                                                            ->where('kriteria_id', $kriteriaItem->id)
                                                            ->where('program_studi_id', $up->program_studi_id)
                                                            ->first();
                                                    @endphp
                                                    @if ($existingUP || $up->pengajuan_dokumen->status != 1)
                                                        @if (is_null($existingLkps))
                                                            <div class="col-lg-6">
                                                                <form
                                                                    action="{{ route('ajuan-prodi.importLkps', ['id_prodi' => $up->program_studi_id]) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id_prodi"
                                                                        value="{{ $up->program_studi_id }}">
                                                                    <input type="hidden" name="id_kriteria"
                                                                        value="{{ $kriteriaItem->id }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="file" name="file" required
                                                                            class="form-control-file kriteria-input"
                                                                            accept=".xlsx"
                                                                            data-kriteria-id="{{ $kriteriaItem->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-primary ml-2">
                                                                            Import
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="col-lg-5">
                                                                <form
                                                                    action="{{ route('ajuan-prodi.importLkps', ['id_prodi' => $up->program_studi_id]) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id_prodi"
                                                                        value="{{ $up->program_studi_id }}">
                                                                    <input type="hidden" name="id_kriteria"
                                                                        value="{{ $kriteriaItem->id }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="file" name="file" required
                                                                            class="form-control-file kriteria-input"
                                                                            accept=".xlsx"
                                                                            data-kriteria-id="{{ $kriteriaItem->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-warning ml-2">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a href="{{ asset('storage/' . $existingLkps->file) }}"
                                                                    target="_blank" class="btn btn-md btn-info"
                                                                    download>
                                                                    <i class="fas fa-file" aria-hidden="true">&nbsp;
                                                                        Download</i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if ($existingLkps)
                                                            <div class="col-lg-6">
                                                                <a href="{{ asset('storage/' . $existingLkps->file) }}"
                                                                    target="_blank" class="btn btn-md btn-info"
                                                                    download>
                                                                    <i class="fas fa-file" aria-hidden="true">&nbsp;
                                                                        Download</i>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="col-lg-6">
                                                                <span class="text-danger">Tidak dapat mengimpor atau
                                                                    memperbarui karena dokumen telah diajukan.</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                            <div class="modal-footer bg-whitesmoke br">
                                                <a href="{{ route('ajuan-prodi.calculate', $up->program_studi_id) }}"
                                                    class="btn btn-primary">Calculate</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    @if ($up->tahun_id == null)
                                        @if (
                                            !empty($up->led) &&
                                                !empty($up->lkps) &&
                                                !empty($up->surat_pernyataan) &&
                                                !empty($up->lampiran_renstra) &&
                                                !empty($up->surat_pengantar))
                                            <a href="javascript:void(0)" data-id="{{ $up->id }}"
                                                data-lkps="{{ $up->lkps->id }}"
                                                data-surat_pengantar="{{ $up->surat_pengantar->id }}"
                                                data-surat_pernyataan="{{ $up->surat_pernyataan->id }}"
                                                data-lampiran="{{ $up->lampiran_renstra->id }}"
                                                data-led="{{ $up->led->id }}" data-tahun="{{ now()->year }}"
                                                data-route="{{ route('ajuan-prodi.ajukan') }}"
                                                class="text-center text-white btn-sm ajukan-btn">
                                                <div class="card p-3"
                                                    style="background-color: rgba(20, 49, 239, 0.801); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);">
                                                    <h6 class="m-0">Ajukan Akreditasi Prodi</h6>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                        @if (isset($up->led->status) &&
                                                $up->led->status != 2 &&
                                                isset($up->lkps->status) &&
                                                $up->lkps->status != 2 &&
                                                isset($up->surat_pengantar->status) &&
                                                $up->surat_pengantar->status != 2 &&
                                                isset($up->surat_pernyataan->status) &&
                                                $up->surat_pernyataan->status != 2 &&
                                                isset($up->lampiran_renstra->status) &&
                                                $up->lampiran_renstra->status != 2 &&
                                                isset($up->pengajuan_dokumen) &&
                                                $up->pengajuan_dokumen->status != 1 &&
                                                empty($up->pengajuan_dokumen->tanggal_selesai))
                                            <a href="javascript:void(0)" data-id="{{ $up->id }}"
                                                data-lkps="{{ $up->lkps->id }}"
                                                data-surat_pernyataan="{{ $up->surat_pernyataan->id }}"
                                                data-lampiran="{{ $up->lampiran_renstra->id }}"
                                                data-surat_pengantar="{{ $up->surat_pengantar->id }}"
                                                data-led="{{ $up->led->id }}" data-tahun="{{ now()->year }}"
                                                data-route="{{ route('ajuan-prodi.ajukan') }}"
                                                class="text-center text-white btn-sm ajukan-btn">
                                                <div class="card p-3"
                                                    style="background-color: rgba(20, 49, 239, 0.801); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.11);">
                                                    <h6 class="m-0">Ajukan Akreditasi Prodi</h6>
                                                </div>
                                            </a>
                                        @endif
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
                    let spernyataan_id = $(this).data('surat_pernyataan');
                    let lampiran_id = $(this).data('lampiran');
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
                                    spernyataan_id: spernyataan_id,
                                    lampiran_id: lampiran_id,
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

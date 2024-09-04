@php
    use App\Models\Lkps;
    use App\Models\Led;
    use App\Models\SuratPengantar;
    use App\Models\SuratPernyataan;
    use App\Models\LampiranRenstra;
    use App\Models\ImportLkps;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>History Dokumen Ajuan &rsaquo; {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}
    </title>
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
                        <h1>History Dokumen Akreditasi
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
                        <h2 class="section-title">Dokumen LKPS dan LED Program Pendidikan
                            {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h2>
                        <p class="section-lead">Dokumen Lembar Kerja Program Studi (LKPS) dan Lembar Evaluasi Diri (LED)
                            program studi D3 {{ $program_studi->nama }} POLINDRA</p>
                    </div>
                    </p>
                    @foreach ($user_prodi as $item_tahun)
                        @if ($item_tahun->tahun->is_active == 0)
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Tahun {{ $item_tahun->tahun->tahun }} </th>
                                                    <th>Nama File</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">Dokumen LKPS</td>
                                                    <td class="text-center">
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
                                                            $lampiran = LampiranRenstra::where(
                                                                'program_studi_id',
                                                                $item_tahun->program_studi_id,
                                                            )
                                                                ->where('tahun_id', $item_tahun->tahun_id)
                                                                ->first();
                                                            $lampiran = SuratPernyataan::where(
                                                                'program_studi_id',
                                                                $item_tahun->program_studi_id,
                                                            )
                                                                ->where('tahun_id', $item_tahun->tahun_id)
                                                                ->first();
                                                        @endphp
                                                        @if (empty($lkps))
                                                        @else
                                                            @if (count($item_tahun->tahun->lkps) == 0)
                                                                Belum ada file yang diupload
                                                            @else
                                                                <a href="{{ url('storage/dokumen_prodi/', $lkps->file) }}"
                                                                    target="_blank">{{ $lkps->file }}</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Surat Pengantar</td>
                                                    <td>
                                                        @if (empty($surat_pengantar))
                                                        @else
                                                            @if (count($item_tahun->tahun->surat_pengantar) == 0)
                                                                Belum ada file yang diupload
                                                            @else
                                                                <a href="{{ Storage::url($surat_pengantar->file) }}"
                                                                    target="_blank">{{ basename($surat_pengantar->file) }}</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Dokumen LED</td>
                                                    <td>
                                                        @if (empty($led))
                                                        @else
                                                            @if (count($item_tahun->tahun->led) == 0)
                                                                Belum ada file yang diupload
                                                            @else
                                                                <a href="{{ Storage::url($led->file) }}"
                                                                    target="_blank">{{ basename($led->file) }}</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Lampiran (Izin Pendirian PS, Renstra)</td>
                                                    <td>
                                                        @if (empty($lampiran))
                                                        @else
                                                            @if (count($item_tahun->tahun->lampiran) == 0)
                                                                Belum ada file yang diupload
                                                            @else
                                                                <a href="{{ Storage::url($lampiran->file) }}"
                                                                    target="_blank">{{ basename($lampiran->file) }}</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 col-lg-9">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Import Tabel LKPS &rsaquo; </h4>Import file LKPS per kriteria
                                    </div>
                                    <div class="card-body">
                                        @foreach ($kriteria as $kriteriaItem)
                                            <div class="form-group row align-items-center">
                                                <label
                                                    class="col-md-4 text-md-right text-left">{{ $kriteriaItem->kriteria }}</label>

                                                @php
                                                    // Ambil dokumen LKPS berdasarkan kriteria dan program studi
                                                    $importLkps = ImportLkps::where(
                                                        'program_studi_id',
                                                        $item_tahun->program_studi_id,
                                                    )
                                                        ->where('kriteria_id', $kriteriaItem->id) // Pastikan 'kriteria_id' sesuai dengan kolom yang ada
                                                        ->first();
                                                @endphp
                                                @if (empty($importLkps))
                                                    Belum ada file yang diupload
                                                @else
                                                    <a href="{{ asset('storage/' . $importLkps->file) }}"
                                                        target="_blank" class="btn btn-md btn-info" download>
                                                        <i class="fas fa-file" aria-hidden="true">&nbsp; Download </i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <h1>Akreditasi pada tahun {{ $item_tahun->tahun->tahun }} sedang dilakukan, silahkan lihat
                                ajuan akreditasi</h1>
                        @endif
                    @endforeach
            </div>
            </section>
        </div>
        <footer class="main-footer">
            @include('footer')

            <div class="footer-right">
            </div>
        </footer>
    </div>
    </div>

</body>

</html>

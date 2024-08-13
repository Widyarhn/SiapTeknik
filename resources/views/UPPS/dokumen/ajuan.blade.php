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
    <title>History Akreditasi &rsaquo; {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('UPPS.layout.sidebar')
            </div>
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>History Akreditasi {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">History Akreditasi</div>
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
                            }) +
                        </script>
                    @endif
                    <div class="section-body">
                        <h2 class="section-title">History Akreditasi {{ $program_studi->jenjang->jenjang }}
                            {{ $program_studi->nama }}</h2>
                        <p class="section-lead">History akreditasi program studi {{ $program_studi->jenjang->jenjang }}
                            {{ $program_studi->nama }} POLINDRA</p>


                        {{-- Filtertahun --}}
                        <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <select id="tahun" class="form-control selectric" name="">
                                                <option value="">-- Pilih --</option>
                                                {{-- @foreach ($user_prodi as $role)
                                                                        <option value="{{ $role->tahun->tahun }}">{{ $role->tahun->tahun }}</option>
                                                                        @endforeach --}}
                                            </select>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($user_prodi as $item_tahun)
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Dokumen Ajuan</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Dokumen</th>
                                                            <th class="text-center">Nama File</th>
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
                                                            <td class="text-center">LKPS</td>

                                                            <td>
                                                                @if (empty($lkps))
                                                                @else
                                                                    @if (count($item_tahun->tahun->lkps) == 0)
                                                                        Belum ada file yang diupload
                                                                    @else
                                                                        <a href="{{ Storage::url($lkps->file) }}"
                                                                            target="_blank">{{ basename($lkps->file) }}</a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">LED</td>
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
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Hasil Penilaian</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Dokumen</th>
                                                            <th class="text-center">Nama File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">Berita Acara</td>
                                                            <td class="text-center">
                                                                -
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Saran & Rekomendasi</td>
                                                            <td class="text-center">
                                                                -
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Sertifikat</td>
                                                            <td class="text-center">
                                                                -
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
{{-- @foreach ($user_prodi as $item_tahun)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Tahun {{ $item_tahun->tahun->tahun }} </th>
                                                        <th class="text-center">Nama File</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">LKPS</td>
                                                        @php
                                                        $lkps = Lkps::where(
                                                        'program_studi_id',
                                                        $item_tahun->program_studi_id,
                                                        )
                                                        ->where('tahun_id', $item_tahun->tahun_id)
                                                        ->first();
                                                        $led = Led::where('program_studi_id', $item_tahun->program_studi_id)
                                                        ->where('tahun_id', $item_tahun->tahun_id)
                                                        ->first();
                                                        @endphp
                                                        @if (empty($lkps))
                                                        @else
                                                        @if (count($item_tahun->tahun->lkps) == 0)
                                                        <td class="text-center">
                                                            Belum ada file yang diupload
                                                        </td>
                                                        @else
                                                        <td class="text-center">
                                                            <a href="{{ url('storage/dokumen_prodi/', $lkps->file) }}"
                                                                target="_blank">{{ $lkps->file }}</a>
                                                            </td>
                                                            <td><button type="submit"
                                                                class="btn btn-secondary">Approve</button></td>
                                                                @endif
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">Dokumen LED</td>
                                                                <td class="text-center">
                                                                    @if (empty($led))
                                                                    @else
                                                                    @if (count($item_tahun->tahun->led) == 0)
                                                                    Belum ada file yang diupload
                                                                    @else
                                                                    <a href="{{ url('storage/dokumen_prodi/', $led->file) }}"
                                                                        target="_blank">{{ $led->file }}</a>
                                                                        <td><button type="submit" class="btn btn-secondary">Approve</button>
                                                                        </td>
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        
                                                    </div>
                                                </table>
                                                </div>
                                            </div>
                                            
                                        </section>
                                    </div>
                                </div>
                                @endforeach  --}}

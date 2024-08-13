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
                        <div class="section-header-back">
                            <a href="{{ route('akreditasi.asesmenLapangan') }}" class="btn btn-icon"><i
                                    class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Detail Asesmen Lapangan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Asesmen Lapangan</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Detail Rekap Penilaian oleh Asesor {{ $user_asesor->user->nama }} pada
                            {{ $user_asesor->jenjang->jenjang }}
                            {{ $user_asesor->program_studi->nama }}</h2>
                        <p class="section-lead">
                            Hasil rekap penilaian asesmen lapangan {{ $user_asesor->jenjang->jenjang }}
                            {{ $user_asesor->program_studi->nama }} oleh {{ $user_asesor->user->nama }} sebagai
                            {{ $user_asesor->jabatan }}.
                        </p>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Rekap Penilaian Asesmen lapangan {{ $user_asesor->jenjang->jenjang }}
                                            {{ $user_asesor->program_studi->nama }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="alRekapTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Aspek Penilaian</th>
                                                        <th>No. Butir</th>
                                                        <th>Deskripsi Hasil Asesmen</th>
                                                        <th>Nilai</th>
                                                        <th>Bobot</th>
                                                        <th>Nilai Terbobot</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 0;
                                                        $total_kes = 0;
                                                    @endphp
                                                    @foreach ($data as $subKriterias)
                                                        @foreach ($subKriterias as $item)
                                                            @php
                                                                $keys = array_keys($item);
                                                                $is_new_row = true;
                                                                $total = 0;
                                                                $no++;
                                                            @endphp

                                                            @foreach ($keys as $key)
                                                                @if ($is_new_row)
                                                                    <tr>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            {{ $no }}
                                                                        </td>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            @if ($item[$key]->sub_kriteria)
                                                                                {{ $item[$key]->sub_kriteria->sub_kriteria }}
                                                                            @else
                                                                                {{ $item[$key]->matriks->kriteria->kriteria }} {{ $item[$key]->matriks->kriteria->kriteria }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->no_butir }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_lapangan->deskripsi }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_lapangan->nilai }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->bobot }}
                                                                        </td>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            @php
                                                                                // Inisialisasi variabel
                                                                                $total = 0;
                                                                                $bobotPerRumus = [];
                                                                                $rumuses = [];
                                                                        
                                                                                // Loop untuk mengumpulkan bobot per rumus_id
                                                                                foreach ($item as $indicator) {
                                                                                    if ($indicator->no_butir && $indicator->sub_kriteria->rumus) {
                                                                                        // Ambil rumus_id dari indikator
                                                                                        $rumus_id = $indicator->sub_kriteria->rumus->id ?? null;
                                                                                        
                                                                                        if ($rumus_id) {
                                                                                            // Inisialisasi bobot jika belum ada
                                                                                            if (!isset($bobotPerRumus[$rumus_id])) {
                                                                                                $bobotPerRumus[$rumus_id] = 0;
                                                                                            }
                                                                        
                                                                                            // Tambah bobot berdasarkan rumus_id
                                                                                            $bobotPerRumus[$rumus_id] += $indicator->bobot;
                                                                        
                                                                                            // Simpan rumus ke dalam array jika belum ada
                                                                                            if (!isset($rumuses[$rumus_id])) {
                                                                                                $rumuses[$rumus_id] = $indicator->sub_kriteria->rumus;
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        // Jika tidak memiliki rumus_id, kalikan bobot dengan nilai
                                                                                        $total += $indicator->bobot * ($indicator->matriks->asesmen_lapangan->nilai ?? 0);
                                                                                    }
                                                                                }
                                                                        
                                                                                // Loop untuk menghitung total berdasarkan bobot dan t_butir
                                                                                foreach ($bobotPerRumus as $rumus_id => $totalBobot) {
                                                                                    // Temukan rumus dengan rumus_id yang sesuai
                                                                                    $rumus = $rumuses[$rumus_id] ?? null;
                                                                        
                                                                                    if ($rumus) {
                                                                                        // Hitung total berdasarkan t_butir dan bobot total per rumus_id
                                                                                        $total += $totalBobot * ($rumus->t_butir ?? 0);
                                                                                    }
                                                                                }
                                                                        
                                                                                // Tambah total perhitungan ke total keseluruhan
                                                                                $total_kes += $total;
                                                                            @endphp
                                                                        
                                                                            <span class="badge badge-info">
                                                                                {{ number_format($total, 2) }}
                                                                            </span>
                                                                        </td>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            <a href="{{ route('akreditasi.asesmenLapangan.detail', ['id' => $item[$key]->matriks->asesmen_lapangan->user_asesor_id, 'id_krit' => $item[$key]->matriks->kriteria_id]) }}"
                                                                                class="show btn btn-secondary btn-sm">
                                                                                <i class="fa fa-solid fa-eye"></i></a>

                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>
                                                                            {{ $item[$key]->no_butir }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_lapangan->deskripsi }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_lapangan->nilai }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->bobot }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @php
                                                                    $is_new_row = false;
                                                                @endphp
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-borderless mt-1 mb-0">
                                            <tr>
                                                <th>Total Nilai Asesmen Lapangan</th>
                                                <th>:</th>
                                                <td>
                                                    {{ number_format($total_kes, 2) }}
                                                </td>
                                                <th>Hasil Akreditasi</th>
                                                <th>:</th>
                                                <td>
                                                    @if ($total_kes >= 1 && $total_kes <= 200)
                                                        TIDAK MEMENUHI SYARAT PERINGKAT
                                                    @elseif($total_kes >= 200 && $total_kes <= 301)
                                                        BAIK
                                                    @elseif($total_kes >= 301 && $total_kes <= 361)
                                                        BAIK SEKALI
                                                    @elseif($total_kes >= 361)
                                                        UNGGUL
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
            <script>
                $(function() {
                    $('#RekapTable').dataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('akreditasi.asesmenLapangan.rekap', $user_asesor->id) }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                            },
                            // {
                            //     data: 'butir',
                            //     name: 'butir'
                            // },
                            {
                                data: 'sub_kriteria',
                                name: 'sub_kriteria'
                            },
                            {
                                data: 'deskripsi',
                                name: 'deskripsi'
                            },
                            {
                                data: 'bobot',
                                name: 'bobot'
                            },
                            {
                                data: 'nilai',
                                name: 'nilai'
                            },
                            {
                                data: 'nilai_bobot',
                                name: 'nilai_bobot'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                    })
                })
            </script>
            <footer class="main-footer">
                @include('footer')
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Prodi | Tinjau Berita Acara &rsaquo; {{ $user_asesor->program_studi->jenjang->jenjang }}
        {{ $user_asesor->program_studi->nama }}</title>
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
                        <h1>Berita Acara</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">{{ $user_asesor->program_studi->jenjang->jenjang }}
                                {{ $user_asesor->program_studi->nama }} </div>
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
                        <h2 class="section-title">Berita Acara
                            {{ $user_asesor->program_studi->jenjang->jenjang }} {{ $user_asesor->program_studi->nama }}
                        </h2>
                        <p class="section-lead">Meninjau Berita Acara Program Studi D3 TPTU setelah menyelesaikan Tahap
                            Asesmen Lapangan</p>

                        @if ($user_asesor->tahun->is_active == 1)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Tabel Rekap Penilaian Asesmen Lapangan
                                                {{ $user_asesor->program_studi->jenjang->jenjang }}
                                                {{ $user_asesor->program_studi->nama }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="rekapTable">
                                                    <thead>
                                                        <tr>
                                                            <th width ="5%">No</th>
                                                            <th>Elemen</th>
                                                            <th>Indikator</th>
                                                            <th>Data Dukung</th>
                                                            <th>Desk Hasil Asesmen</th>
                                                            <th>Nilai</th>
                                                            <th>Bobot</th>
                                                            <th>Nilai Terbobot</th>
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
                                                                                    {{ $item[$key]->matriks->kriteria->kriteria }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                {{ $item[$key]->no_butir }}
                                                                                {{ $item[$key]->deskriptor }}
                                                                            </td>
                                                                            <td>
                                                                                @if (!empty($item[$key]->matriks->data_dukung) && $item[$key]->matriks->data_dukung->isNotEmpty())
                                                                                <a href="{{ route('prodi.data-dukung.data', ['id' => $item[$key]->matriks->kriteria_id, 'id_prodi' => $user_asesor->program_studi_id, 'tahun' => $user_asesor->tahun_id]) }}"
                                                                                    class="btn btn-primary"
                                                                                    target="_blank">Ada</a>
                                                                            @else
                                                                                <a href="{{ route('prodi.data-dukung.data', ['id' => $item[$key]->matriks->kriteria_id, 'id_prodi' => $user_asesor->program_studi_id, 'tahun' => $user_asesor->tahun_id]) }}"
                                                                                    class="btn btn-secondary"
                                                                                    target="_blank">Tidak Ada</a>
                                                                            @endif
                                                                            </td>

                                                                            <td>
                                                                                @if (!empty($item[$key]->matriks->asesmen_lapangan->deskripsi))
                                                                                    {{ $item[$key]->matriks->asesmen_lapangan->deskripsi }}
                                                                                @else
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if (!empty($item[$key]->matriks->asesmen_lapangan->nilai))
                                                                                    {{ $item[$key]->matriks->asesmen_lapangan->nilai }}
                                                                                @else
                                                                                @endif
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
                                                                                        if (
                                                                                            $indicator->no_butir &&
                                                                                            $indicator->sub_kriteria
                                                                                                ->rumus
                                                                                        ) {
                                                                                            // Ambil rumus_id dari indikator
                                                                                            $rumus_id =
                                                                                                $indicator->sub_kriteria
                                                                                                    ->rumus->id ?? null;

                                                                                            if ($rumus_id) {
                                                                                                // Inisialisasi bobot jika belum ada
                                                                                                if (
                                                                                                    !isset(
                                                                                                        $bobotPerRumus[
                                                                                                            $rumus_id
                                                                                                        ],
                                                                                                    )
                                                                                                ) {
                                                                                                    $bobotPerRumus[
                                                                                                        $rumus_id
                                                                                                    ] = 0;
                                                                                                }

                                                                                                // Tambah bobot berdasarkan rumus_id
                                                                                                $bobotPerRumus[
                                                                                                    $rumus_id
                                                                                                ] += $indicator->bobot;

                                                                                                // Simpan rumus ke dalam array jika belum ada
                                                                                                if (
                                                                                                    !isset(
                                                                                                        $rumuses[
                                                                                                            $rumus_id
                                                                                                        ],
                                                                                                    )
                                                                                                ) {
                                                                                                    $rumuses[
                                                                                                        $rumus_id
                                                                                                    ] =
                                                                                                        $indicator->sub_kriteria->rumus;
                                                                                                }
                                                                                            }
                                                                                        } else {
                                                                                            // Jika tidak memiliki rumus_id, kalikan bobot dengan nilai
                                                                                            $total +=
                                                                                                $indicator->bobot *
                                                                                                ($indicator->matriks
                                                                                                    ->asesmen_lapangan
                                                                                                    ->nilai ??
                                                                                                    0);
                                                                                        }
                                                                                    }

                                                                                    // Loop untuk menghitung total berdasarkan bobot dan t_butir
                                                                                    foreach (
                                                                                        $bobotPerRumus
                                                                                        as $rumus_id => $totalBobot
                                                                                    ) {
                                                                                        // Temukan rumus dengan rumus_id yang sesuai
                                                                                        $rumus =
                                                                                            $rumuses[$rumus_id] ?? null;

                                                                                        if ($rumus) {
                                                                                            // Hitung total berdasarkan t_butir dan bobot total per rumus_id
                                                                                            $total +=
                                                                                                $totalBobot *
                                                                                                ($rumus->t_butir ?? 0);
                                                                                        }
                                                                                    }

                                                                                    // Tambah total perhitungan ke total keseluruhan
                                                                                    $total_kes += $total;
                                                                                @endphp

                                                                                <span class="badge badge-info">
                                                                                    {{ number_format($total, 2) }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td>
                                                                                {{ $item[$key]->no_butir }}
                                                                                {{ $item[$key]->deskriptor }}
                                                                            </td>
                                                                            <td>

                                                                                @if (!empty($item[$key]->matriks->data_dukung) && $item[$key]->matriks->data_dukung->isNotEmpty())
                                                                                    <a href="{{ route('prodi.data-dukung.data', ['id' => $item[$key]->matriks->kriteria_id, 'id_prodi' => $user_asesor->program_studi_id, 'tahun' => $user_asesor->tahun_id]) }}"
                                                                                        class="btn btn-primary"
                                                                                        target="_blank">Ada</a>
                                                                                @else
                                                                                    <a href="{{ route('prodi.data-dukung.data', ['id' => $item[$key]->matriks->kriteria_id, 'id_prodi' => $user_asesor->program_studi_id, 'tahun' => $user_asesor->tahun_id]) }}"
                                                                                        class="btn btn-secondary"
                                                                                        target="_blank">Tidak Ada</a>
                                                                                @endif
                                                                            </td>

                                                                            <td>
                                                                                @if (!empty($item[$key]->matriks->asesmen_lapangan->deskripsi))
                                                                                    {{ $item[$key]->matriks->asesmen_lapangan->deskripsi }}
                                                                                @else
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if (!empty($item[$key]->matriks->asesmen_lapangan->nilai))
                                                                                    {{ $item[$key]->matriks->asesmen_lapangan->nilai }}
                                                                                @else
                                                                                @endif
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
                        @else
                            <h1>Akreditasi tahun {{ $user_asesor->tahun->tahun }} program studi
                                {{ $user_asesor->program_studi->jenjang->jenjang }}
                                {{ $user_asesor->program_studi->nama }} telah selesai,
                                silahkan
                                lihat
                                di history</h1>
                        @endif
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

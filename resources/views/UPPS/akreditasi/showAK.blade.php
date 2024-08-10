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
                            <a href="{{ route('akreditasi.asesmenKecukupan') }}" class="btn btn-icon"><i
                                    class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Detail Asesmen Kecukupan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Asesmen Kecukupan</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Detail Rekap Penilaian oleh Asesor {{ $user_asesor->user->nama }} pada
                            {{ $user_asesor->jenjang->jenjang }}
                            {{ $user_asesor->program_studi->nama }}</h2>
                        <p class="section-lead">
                            Hasil rekap penilaian asesmen kecukupan {{ $user_asesor->jenjang->jenjang }}
                            {{ $user_asesor->program_studi->nama }} oleh {{ $user_asesor->user->nama }} sebagai
                            {{ $user_asesor->jabatan }}.
                        </p>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Rekap Penilaian Asesmen Kecukupan {{ $user_asesor->jenjang->jenjang }}
                                            {{ $user_asesor->program_studi->nama }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="rekapTable">
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
                                                                            {{ $item[$key]->matriks->asesmen_kecukupan->deskripsi }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_kecukupan->nilai }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->bobot }}
                                                                        </td>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            @php
                                                                                foreach ($item as $indicator) {
                                                                                    $total +=
                                                                                        $indicator->bobot *
                                                                                        $item[$key]->matriks
                                                                                            ->asesmen_kecukupan->nilai;
                                                                                }
                                                                            @endphp
                                                                            <span class="badge badge-info">
                                                                                {{ $total }}
                                                                                @php
                                                                                    $total_kes += $total;
                                                                                @endphp
                                                                            </span>
                                                                        </td>
                                                                        <td rowspan="{{ count($item) }}">
                                                                            <a href="{{ route('akreditasi.asesmenKecukupan.detail', ['id' => $item[$key]->matriks->asesmen_kecukupan->user_asesor_id, 'id_krit' => $item[$key]->matriks->kriteria_id]) }}"
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
                                                                            {{ $item[$key]->matriks->asesmen_kecukupan->deskripsi }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item[$key]->matriks->asesmen_kecukupan->nilai }}
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
                                                <th>Total Nilai Asesmen Kecukupan</th>
                                                <th>:</th>
                                                <td>
                                                    {{ $total_kes }}
                                                </td>
                                                <th>Hasil Akreditasi</th>
                                                <th>:</th>
                                                <td>
                                                    @if ($total >= 1 && $total <= 200)
                                                        TIDAK MEMENUHI SYARAT PERINGKAT
                                                    @elseif($total >= 200 && $total <= 301)
                                                        BAIK
                                                    @elseif($total >= 301 && $total <= 361)
                                                        BAIK SEKALI
                                                    @elseif($total >= 361)
                                                        UNGGUL
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Rekap Penilaian Asesmen Kecukupan {{ $user_asesor->jenjang->jenjang }}
                                            {{ $user_asesor->program_studi->nama }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="akRekapTable">
                                                <thead>
                                                    <tr>
                                                        <th width ="5%">No</th>
                                                        <th>Aspek Penilaian</th>
                                                        <th>Deskripsi Hasil Asesmen</th>
                                                        <th>Bobot</th>
                                                        <th>Nilai</th>
                                                        <th>Nilai Terbobot</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
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
                                                <th>Total Nilai Asesmen Kecukupan</th>
                                                <th>:</th>
                                                <td>
                                                    @php
                                                        $total = 0.0; // Inisialisasi variabel total
                                                    @endphp
                                                    @foreach ($desk_evaluasi as $item)
                                                        @php
                                                            $total +=
                                                                $item->nilai *
                                                                $item->matriks_penilaian->indikator->bobot;
                                                        @endphp
                                                    @endforeach
                                                    {{ $total }}
                                                </td>
                                                <th>Hasil Akreditasi</th>
                                                <th>:</th>
                                                <td>
                                                    @if ($total >= 1 && $total <= 200)
                                                        TIDAK MEMENUHI SYARAT PERINGKAT
                                                    @elseif($total >= 200 && $total <= 301)
                                                        BAIK
                                                    @elseif($total >= 301 && $total <= 361)
                                                        BAIK SEKALI
                                                    @elseif($total >= 361)
                                                        UNGGUL
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                </section>
            </div>
            <script>
                $(function() {
                    $('#akRekapTable').dataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('akreditasi.asesmenKecukupan.rekap', $user_asesor->id) }}",
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

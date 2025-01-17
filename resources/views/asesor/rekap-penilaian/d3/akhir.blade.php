<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Asesor | Rekap Penilaian AL &rsaquo; {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('asesor.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('asesor.layout.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Rekapitulasi Penilaian Asesmen Lapangan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">{{ $program_studi->jenjang->jenjang }}
                                {{ $program_studi->nama }} </div>
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
                        {{-- <h2 class="section-title">Rekapitulasi Penilaian Lingkup INFOKOM {{$matriks_penilaian->created_at->format('Y')}}</h2>
                            --}}
                        <h2 class="section-title">Rekapitulasi Penilaian Asesmen Lapangan
                            {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h2>
                        <p class="section-lead">Rekapitulasi penilaian Asesmen Lapangan ini diambil berdasarkan
                            instrumen penilaian LAM TEKNIK</p>

                        {{-- <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-borderless mt-1 mb-0">
                                                <tr>
                                                    <th>Nama Asesor</th>
                                                    <th>:</th>
                                                    <td> @foreach ($keterangan as $k)
                                                        {{ $k->nama_asesor }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Batas</th>
                                                    <td>:</td>
                                                    <td> @foreach ($keterangan as $k)
                                                        {{ Carbon\Carbon::parse($k->tanggal_batas)->format('d-m-Y') }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Penilaian</th>
                                                    <th>:</th>
                                                    <td> @foreach ($keterangan as $k)
                                                        {{ Carbon\Carbon::parse($k->tanggal_penilaian)->format('d-m-Y') }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr><div class="row">
                                                    <div class="d-grid col-md-6 mt-2">
                                                        <div class="buttons">
                                                            @if ($keterangan->count() < 1)
                                                            <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-outline-primary btn-create"><i class="fas fa-edit"></i> Tambah Keterangan</a>
                                                            @elseif($keterangan -> count() > 0)
                                                            <div class="buttons">
                                                                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="{{ route('rekap-nilaid3.show', $keterangan->first()) }}" class="btn btn-outline-warning btn-edit"><i class="fas fa-edit"></i> Edit Keterangan</a>
                                                            </div>
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-borderless mt-1 mb-0">
                                                <tr>
                                                    <th>Nama Perguruan Tinggi</th>
                                                    <th>:</th>
                                                    <td>
                                                        @foreach ($keterangan as $k)
                                                        {{ $k->perguruan }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Jurusan</th>
                                                    <th>:</th>
                                                    <td>@foreach ($keterangan as $k)
                                                        {{ $k->jurusan }}
                                                        @endforeach</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jenjang</th>
                                                        <th>:</th>
                                                        <td>@foreach ($keterangan as $k)
                                                            {{ $k->program_studi->jenjang}}
                                                            @endforeach</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Program Studi</th>
                                                            <th>:</th>
                                                            <td>@foreach ($keterangan as $k)
                                                                {{ $k->program_studi->nama }}
                                                                @endforeach</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                        <!--Basic table-->
                        {{-- @if ($user_asesor->tahun->is_active == 1)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Tabel Rekap Penilaian Asesmen Lapangan
                                                {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="rekapTable">
                                                    <thead>
                                                        <tr>
                                                            <th width ="5%">No</th>
                                                            {{-- <th>Butir</th>
                                                            <th>Aspek Penilaian</th>
                                                            <th>Deskripsi Hasil Asesmen</th>
                                                            <th>Bobot</th>
                                                            <th>Nilai</th>
                                                            <th>Nilai Terbobot</th>
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
                                                    <th>Total Nilai Asesmen Lapangan</th>
                                                    <th>:</th>
                                                    <td>
                                                        @php
                                                            $nomer_matriks = 0;
                                                        @endphp
                                                        @foreach ($matriks as $item)
                                                            @php
                                                                $nomer_matriks +=
                                                                    $item->matriks_penilaian->bobot * $item->nilai;
                                                            @endphp
                                                        @endforeach

                                                        @php
                                                            $total = $nomer_matriks;
                                                        @endphp
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
                            </div>
                        @else
                            <h1>Akreditasi tahun {{ $user_asesor->tahun->tahun }} program studi
                                {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }} telah selesai,
                                silahkan lihat
                                di history</h1>
                        @endif --}}

                        @if ($user_asesor->tahun->is_active == 1)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Tabel Rekap Penilaian Asesmen Lapangan
                                                {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }}</h4>
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
                                                                            {{-- matiin dulu --}}
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
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td>
                                                                                {{ $item[$key]->no_butir }}
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
                                {{ $program_studi->jenjang->jenjang }} {{ $program_studi->nama }} telah selesai,
                                silahkan
                                lihat
                                di history</h1>
                        @endif
                    </div>
                </section>
            </div>
        </div>
        {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Keterangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('rekap-nilaid3.store') }}" method="post" enctype="multipart/form-data"
                            id="formActionTambah">
                            @csrf
                            @method('POST')
                            <div class="modal-body" id="formTambah">
                                <div class="card">
                                    <form class="needs-validation" novalidate="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Nama Asesor</label>
                                                <input type="text" class="form-control" name="nama_asesor"
                                                    required="">
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-1">
                                                    <label class="form-label">Tanggal Batas</label>
                                                    <input type="date" name="tanggal_batas" class="form-control"
                                                        id="category">
                                                </div>
                                                <div class="col-6 mb-1">
                                                    <label class="form-label">Tanggal Penilaian</label>
                                                    <input type="date" name="tanggal_penilaian" class="form-control"
                                                        id="stock_item">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Perguruan Tinggi</label>
                                                <input type="text" value="Politeknik Negeri Indramayu" readonly
                                                    class="form-control" name="perguruan">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Nama Jurusan</label>
                                                <input type="text" class="form-control" value="Teknik Informatika"
                                                    readonly name="jurusan">
                                            </div>
                                            <div class="row">
                                                <div class="col-4 mb-1">
                                                    <label class="form-label">Jenjang</label>
                                                    <input type="text" class="form-control" placeholder="D3"
                                                        readonly>
                                                    </select>
                                                </div>
                                                <div class="col-8 mb-1">
                                                    <label class="form-label">Prodi</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Teknik Informatika" readonly>
                                                    <input type="hidden" class="form-control" value="1"
                                                        name="program_studi_id">
                                                </div>
                                            </div>

                                    </form>
                                </div>

                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Keterangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="formActionEdit">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="formEdit">
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('#rekapTable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('rekap-nilaiAl.jsonAkhir', $program_studi->id) }}",
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
                        }
                    ],
                })
            })


            $("body").on('click', ".btn-edit", function() {
                let url = $(this).data("url") + "/edit"
                $("#formActionEdit").attr("action", $(this).data("url"))
                $.ajax({
                    url: url,
                    type: "get",
                    success: function(data) {
                        $("#formEdit").html(data)
                    }
                })
            })
        </script> --}}
        <footer class="main-footer">
            @include('footer')
            <div class="footer-right">
            </div>
        </footer>
    </div>
</body>

</html>

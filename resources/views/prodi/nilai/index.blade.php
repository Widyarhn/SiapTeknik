<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Program Studi D3 | Nilai</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('prodi.diploma-tiga.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('prodi.diploma-tiga.layout.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Rekapitulasi Penilaian Asesmen Lapangan Diploma 3</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodid3') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Diploma 3</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Rekapitulasi Penilaian Lingkup INFOKOM</h2>
                        <p class="section-lead">Rekapitulasi penilaian asesmen lapangan ini diambil setelah survei lapangan </p>

                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-borderless mt-1 mb-0">
                                            <tr>
                                                <th>Nama Asesor</th>
                                                <th>:</th>
                                                <td>
                                                    @foreach ($keterangan as $k)
                                                        {{ $k->nama_asesor }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Batas</th>
                                                <td>:</td>
                                                <td>
                                                    @foreach ($keterangan as $k)
                                                        {{ Carbon\Carbon::parse($k->tanggal_batas)->format('d-m-Y') }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Penilaian</th>
                                                <th>:</th>
                                                <td>
                                                    @foreach ($keterangan as $k)
                                                        {{ Carbon\Carbon::parse($k->tanggal_penilaian)->format('d-m-Y') }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>

                                    </div>
                                    </tr>
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
                                            <td>
                                                @foreach ($keterangan as $k)
                                                    {{ $k->jurusan }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Jenjang</th>
                                            <th>:</th>
                                            <td>
                                                @foreach ($keterangan as $k)
                                                    {{ $k->program_studi->jenjang }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nama Program Studi</th>
                                            <th>:</th>
                                            <td>
                                                @foreach ($keterangan as $k)
                                                    {{ $k->program_studi->nama }}
                                                @endforeach
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Basic table-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tabel Rekap Penilaian Asesmen Lapangan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="rekapTable">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Butir</th>
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
                                                    // $nilai = 0;
                                                    $total = 0;
                                                @endphp
                                                @foreach ($matriks_penilaian as $n)
                                                    @if(isset($n->asesmen_lapangan))
                                                    @php
                                                        $bobot = $n->asesmen_lapangan->nilai * $n->bobot;
                                                        $total += $bobot;
                                                        
                                                        // $nilai += $n->nilai->sesudah;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                                {{-- {{ $nilai }} --}}
                                                {{ $total }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!--Basic table-->
        </div>
        </section>
    </div>

    </div>

    <script>
        $(function() {
            $('#rekapTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('prodi.diploma-tiga.nilai.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'butir',
                        name: 'butir.butir'
                    },
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

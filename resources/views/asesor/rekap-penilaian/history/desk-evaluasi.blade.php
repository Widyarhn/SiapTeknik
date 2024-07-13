<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Asesor D3 | Rekap Penilaian &rsaquo; Desk Evaluasi</title>
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
                            <h1>Rekapitulasi Penilaian Desk Evaluasi D3 {{$program_studi->nama}} </h1>
                            <div class="section-header-breadcrumb">
                                <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesord3') }}">Dashboard</a></div>
                                <div class="breadcrumb-item">D3 {{$program_studi->nama}} </div>
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
                        @if(session('success'))
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
                            
                            <h2 class="section-title">Rekapitulasi Penilaian Lingkup INFOKOM </h2>
                            <p class="section-lead">Rekapitulasi penilaian desk evaluasi ini diambil berdasarkan borang sebelum survei lapangan </p>
                            
                            {{-- <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-borderless mt-1 mb-0">
                                                <tr>
                                                    <th>Nama Asesor</th>
                                                    <th>:</th>
                                                    <td> @foreach ($keterangan as $k )
                                                        {{ $k->nama_asesor }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Batas</th>
                                                    <td>:</td>
                                                    <td> @foreach ($keterangan as $k )
                                                        {{ Carbon\Carbon::parse($k->tanggal_batas)->format('d-m-Y') }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Penilaian</th>
                                                    <th>:</th>
                                                    <td> @foreach ($keterangan as $k )
                                                        {{ Carbon\Carbon::parse($k->tanggal_penilaian)->format('d-m-Y') }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr><div class="row">
                                                    <div class="d-grid col-md-6 mt-2">
                                                        <div class="buttons">
                                                            @if ($keterangan -> count() < 1 )
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
                                                        @foreach ($keterangan as $k )
                                                        {{ $k->perguruan }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Jurusan</th>
                                                    <th>:</th>
                                                    <td>@foreach ($keterangan as $k )
                                                        {{ $k->jurusan }}
                                                        @endforeach</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jenjang</th>
                                                        <th>:</th>
                                                        <td>@foreach ($keterangan as $k )
                                                            {{ $k->program_studi->jenjang}}
                                                            @endforeach</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Program Studi</th>
                                                            <th>:</th>
                                                            <td>@foreach ($keterangan as $k )
                                                                {{ $k->program_studi->nama }}
                                                                @endforeach</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!--Basic table-->
                                        @if($user_asesor->tahun->is_active==1)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Tabel Rekap Penilaian Desk Evaluasi {{$program_studi->nama}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="rekapTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th width ="5%">No</th>
                                                                        {{-- <th>Butir</th> --}}
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
                                                            {{-- <tr>
                                                                <th>Total Nilai Desk Evaluasi</th>
                                                                <th>:</th>
                                                                <td>
                                                                    @php
                                                                        $nilai_matriks = 0
                                                                    @endphp
                                                                    @foreach ($matriks as $item)
                                                                        @php
                                                                            $nilai_matriks += $item->nilai * $item->matriks_penilaian->bobot
                                                                        @endphp
                                                                    @endforeach
                                                                    
                                                                    @php
                                                                        $nilai_suplemen = 0
                                                                    @endphp
                                                                    @foreach ($suplemen as $item_suplemen)
                                                                        @php
                                                                            $nilai_suplemen += $item_suplemen->nilai * $item_suplemen->suplemen->bobot
                                                                        @endphp
                                                                    @endforeach --}}

                                                                    {{-- {{ $nilai_matriks + $nilai_suplemen }} --}}
                                                                    {{-- @php
                                                                        $total = 0;
                                                                        @endphp
                                                                        @foreach ($desk_evaluasi)
                                                                        @if(isset($desk_evaluasi))
                                                                        @php
                                                                        $bobot = $desk_evaluasi->nilai * $desk_evaluassi->matriks_penilaian->bobot;
                                                                        $total += $bobot;
                                                                        @endphp
                                                                        @endif
                                                                        @endforeach
                                                                        
                                                                        {{ $total }} --}}
                                                                    {{-- </td> --}}
                                                                
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Basic table-->
                                        @else
                                        <h1>Akreditasi sedang berlangsung</h1>
                                        @endif
                                    </div>
                                </section>
                            </div>
                        <script>
                            $(function() {
                                $('#rekapTable').dataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: "{{ route('rekap-nilaid3.json', $program_studi->id) }}",
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
                                        url: url
                                        , type: "get"
                                        , success: function(data) {
                                            $("#formEdit").html(data)
                                        }
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
                
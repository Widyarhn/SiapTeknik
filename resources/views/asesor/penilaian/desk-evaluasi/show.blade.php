<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Asesor | Matriks Penilaian &rsaquo; Kondisi Eksternal</title>
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
                            <h1>Penilaian Desk Evaluasi {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</h1>
                            <div class="section-header-breadcrumb">
                                <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a></div>
                                <div class="breadcrumb-item">Desk Evaluasi {{$program_studi->jenjang->jenjang}} {{$program_studi->nama}}</div>
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
                            <h2 class="section-title">{{$kriteria->butir}} {{ $kriteria->kriteria }}</h2>
                            <p class="section-lead">
                                Penilaian {{ $kriteria->kriteria }} jenjang D3 lingkup INFOKOM di bawah ini diambil berdasarkan borang
                            </p>
                            
                            <div class="card">
                                <div class="card-header d-block pb-0">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="{{route('asesor.penilaian.desk-evaluasi.elemen', $program_studi->id)}}" class="btn btn-outline-secondary">
                                                <i class="fa fa-chevron-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{$kriteria->butir}}. {{ $kriteria->kriteria }}</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="searchByGolongan" class="form-control selectric">
                                                    <option value="0">-- Lihat Semua --</option>
                                                    @foreach ($golongan as $k)
                                                    <option value="{{ $k->id }}" {{(request()->has('golongan')&&request()->golongan == $k->id) ? 'selected' : ''}}>{{ $k->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @if (count($kriteria->suplemen) > 0)
                            @foreach ($suplemen as $data)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{$user_asesor->tahun->tahun}}</th>
                                                                        <td>
                                                                            <h6>
                                                                                {{ $data->no_butir }}
                                                                                @if (isset($data->golongan)) [{{ $data->golongan->nama }}] @endif
                                                                                {{ $data->sub_kriteria }}
                                                                            </h6>
                                                                        </td>
                                                                        <tr>
                                                                            <th>4</th>
                                                                            <td>
                                                                                {{ $data->sangat_baik }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>3</th>
                                                                            <td>
                                                                                {{ $data->baik }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>2</th>
                                                                            <td>
                                                                                {{ $data->cukup }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>1</th>
                                                                            <td>
                                                                                {{ $data->kurang }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>
                                                                                <div class="badge badge-primary"> File data dukung </div>
                                                                            </th>
                                                                            <td><a href="">Data dukung kondisi</a></td>
                                                                        </tr>
                                                                        <form action="{{ route('nilai-deskeval.store') }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <tr>
                                                                                <th>
                                                                                    <div class="badge badge-primary"> Nilai </div>
                                                                                </th>
                                                                                @if(count($data->desk_evaluasi)>0)
                                                                                <td>
                                                                                    <input type="hidden" id="" />
                                                                                    <input type="text" placeholder="1-4" name="nilai" value=" {{$data->desk_evaluasi[0]->nilai}}" class="form-control text-center">
                                                                                    <input type="hidden" value="{{$program_studi->id}}"  name="program_studi_id" />
                                                                                    <input type="hidden" value="1"  name="jenjang_id" />
                                                                                    <input type="hidden" value="{{$data->id}}"  name="matriks_penilaian_id" />
                                                                                </td>
                                                                                @else
                                                                                <td>
                                                                                    <input type="hidden" id="formActionStore" />
                                                                                    <input type="text" placeholder="1-4" name="nilai" class="form-control text-center">
                                                                                    <input type="hidden" value="{{$program_studi->id}}"  name="program_studi_id" />
                                                                                    <input type="hidden" value="1"  name="jenjang_id" />
                                                                                    <input type="hidden" value="{{$data->id}}"  name="suplemen_id" />
                                                                                    <input type="hidden" value="{{$user_asesor->tahun->id}}"  name="tahun_id" />
                                                                                </td>
                                                                                @endif
                                                                            </tr>
                                                                        {{-- </form> --}}
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <th>Deskripsi</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        {{ $data->deskriptor }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th> 
                                                                        <div
                                                                        class="badge badge-primary"> Deskripsi Nilai
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                @if(count($data->desk_evaluasi)>0)
                                                                <td>
                                                                    <textarea name="deskripsi" class="form-control">
                                                                        {{$data->desk_evaluasi[0]->deskripsi}}
                                                                    </textarea>
                                                                    
                                                                </td>
                                                                @else
                                                                <td>
                                                                    <textarea name="deskripsi" class="form-control">
                                                                    </textarea>
                                                                </td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    @if(count($data->desk_evaluasi)>0)
                                                    <div class="row">
                                                        <div class="d-grid col-md-6 mt-2">
                                                            <div class="btn-group">
                                                                <button type="" class="btn btn-outline-warning">
                                                                    Edit Nilai dan Deskripsi Nilai
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="row">
                                                        <div class="d-grid col-md-6 mt-2">
                                                            <div class="btn-group">
                                                                <button type="submit" class="btn btn-outline-primary">
                                                                    Tambahkan Nilai dan Deskripsi Nilai
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>    
                                    </div>          
                                </div>
                            </div>
                            @endforeach
                            @elseif(count($kriteria->matriks_penilaian) > 0)
                            @foreach ($matriks_penilaian as $data)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{$user_asesor->tahun->tahun}}</th>
                                                                        <td>
                                                                            <h6>
                                                                                {{ $data->no_butir }}
                                                                                @if (isset($data->golongan)) [{{ $data->golongan->nama }}] @endif
                                                                                {{ $data->sub_kriteria }}
                                                                            </h6>
                                                                        </td>
                                                                        <tr>
                                                                            <th>4</th>
                                                                            <td>
                                                                                {{ $data->sangat_baik }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>3</th>
                                                                            <td>
                                                                                {{ $data->baik }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>2</th>
                                                                            <td>
                                                                                {{ $data->cukup }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>1</th>
                                                                            <td>
                                                                                {{ $data->kurang }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>
                                                                                <div class="badge badge-primary"> File data dukung </div>
                                                                            </th>
                                                                            @if ($data->data)
                                                                            <td><a href="{{url('storage/data_dukung/', $data->data->file)}}" target="_blank">{{$data->data->file}}</a></td>
                                                                            @else
                                                                            <th> Belum ada file yang diupload</th>
                                                                            @endif
                                                                        </tr>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <th>Deskripsi</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        {{ $data->deskriptor }}
                                                                    </td>
                                                                </tr>
                                                                @if(count($data->desk_evaluasi)>0)
                                                                <form action="{{route('asesor.penilaian.desk-evaluasi.update', $data->desk_evaluasi[0]->id)}}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                                    @csrf
                                                                    @method('POST')
                                                                <tr>
                                                                    <th> 
                                                                        <div
                                                                        class="badge badge-primary">Nilai
                                                                    </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" id="" />
                                                                        <input type="text" placeholder="1-4" name="nilai" value=" {{$data->desk_evaluasi[0]->nilai}}" class="form-control text-center">
                                                                        <input type="hidden" value="{{$program_studi->id}}"  name="program_studi_id" />
                                                                        <input type="hidden" value="1"  name="jenjang_id" />
                                                                        <input type="hidden" value="{{$data->id}}"  name="matriks_penilaian_id" />
                                                                        <input type="hidden" value="{{$user_asesor->tahun->id}}"  name="tahun_id" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th> 
                                                                        <div
                                                                        class="badge badge-primary">Deskripsi Nilai
                                                                    </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea name="deskripsi" class="form-control">
                                                                            {{$data->desk_evaluasi[0]->deskripsi}}
                                                                        </textarea>                                                                    
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-grid col-md-6 mt-2">
                                                                            <div class="btn-group">
                                                                                <button type="submit" class="btn btn-outline-warning">
                                                                                    Edit
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                                @else
                                                                <form action="{{ route('nilai-deskeval.store') }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <tr>
                                                                        <th> 
                                                                            <div
                                                                            class="badge badge-primary">Nilai
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" id="formActionStore" />
                                                                        <input type="text" placeholder="1-4" name="nilai" class="form-control text-center">
                                                                        <input type="hidden" value="{{$program_studi->id}}"  name="program_studi_id" />
                                                                        <input type="hidden" value="1"  name="jenjang_id" />
                                                                        <input type="hidden" value="{{$data->id}}"  name="matriks_penilaian_id" />
                                                                        <input type="hidden" value="{{$user_asesor->tahun->id}}"  name="tahun_id" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th> 
                                                                        <div
                                                                        class="badge badge-primary">Deskripsi Nilai
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <textarea name="deskripsi" class="form-control">
                                                                    </textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-grid col-md-6 mt-2">
                                                                        <div class="btn-group">
                                                                            <button type="submit" class="btn btn-outline-primary">
                                                                                Tambahkan
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                            @endif
                                                        </tr>
                                                        </table>
                                                    </div>
                                            </div>
                                        </div>    
                                    </div>          
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>
</body>
</head>
</html>

<script>
    $("#searchByGolongan").on('change', function (e) {
        window.location.href = "?golongan="+e.target.value
    })
</script>
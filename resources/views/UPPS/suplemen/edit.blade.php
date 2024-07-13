<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Edit Suplemen Penilaian</title>
    @include('body')
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('UPPS.layout.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Edit Suplemen Penilaian D3 {{$program_studi->nama}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Suplemen Penilaian D3 {{$program_studi->nama}}</div>
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
                        <h2 class="section-title">Suplemen Penilaian D3 {{$program_studi->nama}}</h2>
                        <p class="section-lead">Suplemen Penilaian Instrumen Akreditasi Lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Data Suplemen Penilaian D3 {{$program_studi->nama}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('UPPS.suplemen-d3.update', ['id' => $matriks_penilaian->id, 'id_prodi'=> $program_studi->id]) }}" method="post"
                                        enctype="multipart/form-data" id="formActionEdit">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body" id="formEdit">
                                            <div class="card">
                                                <form class="needs-validation" novalidate="">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Jenis</label>
                                                                    <select id="jenis" class="form-control selectric" name="jenis_id">
                                                                        <option value="">-- Pilih --</option>
                                                                        @foreach ($jenis as $j)
                                                                            <option  @if ($j->id == $matriks_penilaian->jenis_id) selected  @endif value="{{ $j->id }}">{{ $j->jenis }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6"> 
                                                                <div class="form-group">
                                                                    <label>Bobot</label>
                                                                    <input type="text" class="form-control" name="bobot"
                                                                    value="{{$matriks_penilaian->bobot}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Suplemen</label>
                                                                    <select id="kriteria_id" class="form-control selectric" name="kriteria_id">
                                                                        <option value="">-- Pilih --</option>
                                                                        @foreach ($kriteria as $k)
                                                                            <option @if ($k->id == $matriks_penilaian->kriteria_id) selected  @endif value="{{ $k->id }}">
                                                                                {{ $k->butir . '  ' . $k->kriteria }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Sub Kriteria</label>
                                                                <input type="text" class="form-control" name="sub_kriteria" value="{{$matriks_penilaian->sub_kriteria}}">
                                                            </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>No Butir</label>
                                                                <input type="text" class="form-control" name="no_butir" value="{{$matriks_penilaian->no_butir}}">
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <input type="text" class="form-control" name="deskriptor"
                                                                value="{{$matriks_penilaian->deskriptor}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>4</label>
                                                            <input type="text" class="form-control" name="sangat_baik"
                                                                value="{{$matriks_penilaian->sangat_baik}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>3</label>
                                                            <input type="text" class="form-control" name="baik"
                                                                value="{{$matriks_penilaian->baik}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2</label>
                                                            <input type="text" class="form-control" name="cukup"
                                                                value="{{$matriks_penilaian->cukup}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1</label>
                                                            <input type="text" class="form-control" name="kurang"
                                                                value="{{$matriks_penilaian->kurang}}">
                                                        </div>
                                                        <input type="hidden" value="{{$program_studi->id}}"  name="program_studi_id" />
                                                        <input type="hidden" value="1"  name="jenjang_id" />
                
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-whitesmoke br">
                                            <div>
                                                <a href="{{ route('UPPS.suplemen-d3.suplemen', $program_studi->id) }}" class="btn btn-secondary"><i
                                                    class="fa fa-chevron-left"></i> Kembali</a>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Basic table-->
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


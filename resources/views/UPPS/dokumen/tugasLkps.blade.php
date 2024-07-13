<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title >UPPS | Dokumen Ajuan &rsaquo; {{$lkps->program_studi->jenjang->jenjang}} {{$lkps->program_studi->nama}}</title>
    @include('body')

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
                        <h1>Dokumen Akreditasi  {{$lkps->program_studi->jenjang->jenjang}} {{$lkps->program_studi->nama}}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">  {{$lkps->program_studi->jenjang->jenjang}} {{$lkps->program_studi->nama}}</div>
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
                            title: 'Berhasil Menugaskan asesor!',
                            text: '{{ session('success') }}'
                        })
                    </script>
                @endif
                @if(session('sukses'))
                    <script>
                        const sukses = swal({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('sukses') }}'
                        })
                    </script>
                @endif
                    <div class="section-body">
                        <h2 class="section-title">Dokumen LKPS Program Pendidikan   {{$lkps->program_studi->jenjang->jenjang}} {{$lkps->program_studi->nama}}</h2>
                                 <p class="section-lead">Dokumen Lembar Kerja Program Studi (LKPS) berisi informasi dan petunjuk mengenai program studi D3 {{$lkps->program_studi->nama}} POLINDRA</p>
                            </div>
                        </p>
                        <!--Basic table-->
                        <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered">
                                                                    <tr>
                                                                        <th>Nama Dokumen LKPS</th>
                                                                        <th>Pilih Asesor</th>
                                                                        <th>Approve</th>
                                                                 <tr>
                                                                    <th>{{$lkps->file}}</th>
                                                                     <td><div class="buttons"><a href="" data-toggle="modal" data-target="#modalTugas{{$lkps->id}}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i></a>Pilih Asesor</div></td>
                                                                        <form
                                                                        action="{{ route('upps.dokumenajuan.approveLkps', $lkps->id) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        id="formActionStore">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="is_active">
                                                                        @if($lkps->is_active == 0)
                                                                     <td><button type="submit" class="btn btn-secondary">Approve</button></td>
                                                                     @else
                                                                     <td><div class="buttons"><a href="" class="btn btn-icon icon-left btn-success"><i class="fa fa-check"></i></a>Sudah diapprove</div></td>
                                                                     @endif
                                                                 </form>
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
                            </div>
                        </div>
                        <div class="card">           
                            <a href="{{route('upps.dokumenajuan.prodi', $program_studi->id)}}" class="btn btn-outline-secondary"><i
                                    class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalTugas{{$lkps->id}}">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Berikan Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('upps.dokumenajuan.tugasLkps')}}" method="post" enctype="multipart/form-data" id="formActionTugas">
                    @csrf
                    @method('POST')
                    <div class="modal-body" id="formTugas">
                        <div class="card">
                            <form class="needs-validation" novalidate="">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Asesor D3</label>
                                        <select id="role" class="form-control selectric" name="nama[]" multiple>
                                            <option disabled>-- Pilih --</option>
                                            @foreach ($user as $u )
                                            <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="lkps_id" value="{{$lkps->id}}" >
                                        <input type="hidden" name="program_studi_id" value="{{$program_studi->id}}" >
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
        </div>  
            </div>
        </div>
        </div>      
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Asesor | Asesmen Kecukupan</title>
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
                        <div class="section-header-back">
                            <a href="{{ route('asesor.penilaian.asesmen-kecukupan.elemen', $program_studi->id) }}"
                                class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Penilaian Asesmen Kecukupan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">AK {{ $program_studi->jenjang->jenjang }}
                                {{ $program_studi->nama }}</div>
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
                        <h2 class="section-title">{{ $kriteria->butir }} {{ $kriteria->kriteria }}</h2>
                        <p class="section-lead">
                            Penilaian {{ $kriteria->kriteria }} Jenjang {{ $program_studi->jenjang->jenjang }} Lingkup
                            Teknik POLINDRA
                        </p>

                        {{-- <div class="card">
                            <div class="card-header ml-5">
                                <div class="row">
                                    <h4>{{ $kriteria->butir }} {{ $kriteria->kriteria }}</h4>
                                </div>
                            </div>
                        </div> --}}
                        @forelse ($matriks as $m)
                            @if (!empty($m) && !empty($m->indikator->sangat_baik))
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ $user_asesor->tahun->tahun }}</th>
                                                                <td>
                                                                    <h6>
                                                                        @if (!empty($m->sub_kriteria->sub_kriteria))
                                                                            {{ $m->sub_kriteria->sub_kriteria }}
                                                                        @else
                                                                        @endif
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>
                                                                    {{ $m->indikator->sangat_baik }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>
                                                                    {{ $m->indikator->baik }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>
                                                                    {{ $m->indikator->cukup }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>
                                                                    {{ $m->indikator->kurang }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>0</th>
                                                                <td>
                                                                    {{ $m->indikator->sangat_kurang }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <div class="badge badge-primary"> File data
                                                                        dukung </div>
                                                                </th>
                                                                @if ($m->data)
                                                                    <td><a href="{{ url('storage/data_dukung/', $m->data->file) }}"
                                                                            target="_blank">{{ $m->data->file }}</a>
                                                                    </td>
                                                                @else
                                                                    <th> Belum ada file yang diupload</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Deskripsi</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if (!empty($m->indikator->no_butir))
                                                                    {{ $m->indikator->no_butir }}
                                                                    {{ $m->indikator->deskriptor }}
                                                                @else
                                                                    {{ $m->indikator->deskriptor }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        {{-- @php
                                                            $cob = $m->asesmen_kecukupan->user_asesor_id;
                                                            dd($cob);
                                                        @endphp --}}
                                                        @if (empty($m->asesmen_kecukupan))
                                                            <form action="{{ route('asesmen-kecukupan.store') }}"
                                                                method="post" enctype="multipart/form-data"
                                                                id="formActionStore">
                                                                @csrf
                                                                @method('POST')
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Nilai</div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="m_id"
                                                                            value="{{ $m->id }}" />
                                                                        <input type="hidden" name="user_asesor_id"
                                                                            value="{{ $user_asesor->id }}" />
                                                                        <input type="hidden" name="timeline_id"
                                                                            value="{{ $user_asesor->timeline->id }}" />
                                                                        <input type="text" placeholder="1-4"
                                                                            name="nilai"
                                                                            class="form-control text-center" id="{{ $m->indikator->no_butir }}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Deskripsi Nilai
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea name="deskripsi" class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-grid col-md-6 mt-2">
                                                                            <div class="btn-group">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-primary">Tambahkan</button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        @else
                                                            @if ($m->asesmen_kecukupan->user_asesor_id == $user_asesor->id)
                                                                <form
                                                                    action="{{ route('asesor.penilaian.asesmen-kecukupan.update', $m->asesmen_kecukupan->id) }}"
                                                                    method="post" enctype="multipart/form-data"
                                                                    id="formActionUpdate">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary">Nilai</div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="m_id"
                                                                                value="{{ $m->id }}" />
                                                                            <input type="hidden" name="user_asesor_id"
                                                                                value="{{ $user_asesor->id }}" />
                                                                            <input type="hidden" name="timeline_id"
                                                                                value="{{ $user_asesor->timeline->id }}" />
                                                                            <input type="text" placeholder="1-4"
                                                                                name="nilai"
                                                                                value="{{ $m->asesmen_kecukupan->nilai }}"
                                                                                class="form-control text-center" id="{{ $m->indikator->no_butir }}"/>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary">Deskripsi
                                                                                Nilai</div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <textarea name="deskripsi" class="form-control">{{ $m->asesmen_kecukupan->deskripsi }}</textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-grid col-md-6 mt-2">
                                                                                <div class="btn-group">
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-warning">Edit</button>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('asesmen-kecukupan.store') }}"
                                                                    method="post" enctype="multipart/form-data"
                                                                    id="formActionStoreNew">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary">Nilai</div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="m_id"
                                                                                value="{{ $m->id }}" />
                                                                            <input type="hidden" name="user_asesor_id"
                                                                                value="{{ $user_asesor->id }}" />
                                                                            <input type="hidden" name="timeline_id"
                                                                                value="{{ $user_asesor->timeline->id }}" />
                                                                            <input type="text" placeholder="1-4"
                                                                                name="nilai"
                                                                                class="form-control text-center" id="{{ $m->indikator->no_butir }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary">Deskripsi
                                                                                Nilai</div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <textarea name="deskripsi" class="form-control"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-grid col-md-6 mt-2">
                                                                                <div class="btn-group">
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-primary">Tambahkan</button>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </form>
                                                            @endif
                                                        @endif


                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Matriks penilaian tidak lengkap atau belum ada indikator sangat baik.
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-info">
                                Belum ada matriks penilaian.
                            </div>
                        @endforelse

                        @if ($matriks->isNotEmpty())
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="modal-footer bg-whitesmoke br">
                                                <div>
                                                    <a href="{{ route('asesor.penilaian.asesmen-kecukupan.elemen', $program_studi->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                        Kembali</a>
                                                </div>
                                                <button id="btn-save" class="btn {{ empty($m->asesmen_kecukupan) ? 'btn-secondary': 'btn-primary'}}">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </section>
            </div>
        </div>
    </div>
    <script>
        var matriks = @json($matriks);
        $(document).ready(function(){
            $('#btn-save').click(function(e){
                e.preventDefault();
                var data = {}; 
                $.each(matriks, function(index, matrik) {
                    var key = matrik.indikator.no_butir.replace('.', '');
                    if (matrik.indikator.rumus_id != null ) {
                        data[key] = matrik.asesmen_kecukupan.nilai
                    }
                });

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                console.log(data);
                
                $.ajax({
                    url: `{{ route('asesmen-kecukupan.calculate', $matriks[0]->kriteria_id) }}`,
                    type: 'POST',
                    data: data, // Convert data to JSON string
                    dataType: 'json',
                    success: function(response) {
                        console.log('Data berhasil dikirim', response);
                    },
                    error: function(data) {
                        console.error(data);
                    }
                });
            });
        })
    </script>
</body>
</head>

</html>

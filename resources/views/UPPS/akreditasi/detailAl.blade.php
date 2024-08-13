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
                        <h1>Detail Kriteria</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item"><a href="{{ route('akreditasi.asesmenLapangan.show', $user_asesor->id) }}">Asesmen Lapangan</a></div>
                            <div class="breadcrumb-item">Detail Kriteria</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Detail Penilaian Kriteria oleh Asesor {{ $user_asesor->user->nama }}</h2>
                        <p class="section-lead">
                            Detail Kriteria Penilaian asesmen lapangan {{ $user_asesor->jenjang->jenjang }}
                            {{ $user_asesor->program_studi->nama }} oleh {{ $user_asesor->user->nama }} sebagai
                            {{ $user_asesor->jabatan }}.
                        </p>

                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tabel Detail Penilaian Asesmen lapangan {{ $user_asesor->jenjang->jenjang }}
                                            {{ $user_asesor->program_studi->nama }}</h4>
                                    </div>
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
                                                                @if ($m->data_dukung->isNotEmpty())
                                                                    <td>
                                                                        <ul>
                                                                            @foreach ($m->data_dukung as $data)
                                                                                <li>
                                                                                    <a href="{{ Storage::url($data->file) }}"
                                                                                        target="_blank">{{ basename($data->nama) }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
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
                                                            $cob = $m->asesmen_lapangan->user_asesor_id;
                                                            dd($cob);
                                                        @endphp --}}
                                                        @if ($m->asesmen_lapangan)
                                                            @if ($m->asesmen_lapangan->user_asesor_id == $user_asesor->id)
                                                                <form
                                                                    action="{{ route('nilai-asesmenlapangan.update', $m->asesmen_lapangan->id) }}"
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
                                                                            @if ($m->anotasi_label)
                                                                                @if ($m->asesmen_lapangan->matriks_penilaian_id == $m->anotasi_label->matriks_penilaian_id)
                                                                                    <input type="text"
                                                                                        placeholder="1-4" name="nilai"
                                                                                        value=" {{ $m->asesmen_lapangan->nilai }}"
                                                                                        class="form-control text-center"
                                                                                        id="{{ $m->indikator->no_butir }}"
                                                                                        disabled>
                                                                                @else
                                                                                    <input type="text"
                                                                                        placeholder="1-4" name="nilai"
                                                                                        value=" {{ $m->asesmen_lapangan->nilai }}"
                                                                                        class="form-control text-center"
                                                                                        id="{{ $m->indikator->no_butir }}">
                                                                                @endif
                                                                            @else
                                                                                <input type="text" placeholder="1-4"
                                                                                    name="nilai"
                                                                                    value=" {{ $m->asesmen_lapangan->nilai }}"
                                                                                    class="form-control text-center"
                                                                                    id="{{ $m->indikator->no_butir }}">
                                                                            @endif
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
                                                                            <textarea name="deskripsi" class="form-control">{{ $m->asesmen_lapangan->deskripsi }}</textarea>
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
                                                                <form
                                                                    action="{{ route('nilai-asesmenlapangan.update', $m->asesmen_lapangan->id) }}"
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

                                                                            <input type="text" name="nilai"
                                                                                value="{{ $m->asesmen_lapangan->nilai }}"
                                                                                class="form-control text-center"
                                                                                disabled />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary">Deskripsi
                                                                                Nilai
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <textarea name="deskripsi" class="form-control">{{ $m->asesmen_lapangan->deskripsi }}</textarea>
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
                                                            @endif
                                                        @else
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
                                                <div class="text-center">
                                                    <a href="{{ route('akreditasi.asesmenLapangan.show', $user_asesor->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                        Kembali</a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                </section>
            </div>
            <script>
                
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

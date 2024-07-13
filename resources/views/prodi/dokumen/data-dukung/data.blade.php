@php
    use App\Models\DataDukung;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Data Dukung &rsaquo; {{ $kriteria->butir }} - {{ $kriteria->kriteria }} </title>
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
                        <h1>Dokumen Data Dukung {{ $program_studi->nama }}</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Data Dukung {{ $program_studi->nama }}</div>
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
                            Dokumen Data Dukung {{ $kriteria->kriteria }} jenjang D3 lingkup INFOKOM di bawah ini
                            diambil berdasarkan borang
                        </p>
                        <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="{{ route('prodi.data-dukung.elemen', $program_studi->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fa fa-chevron-left"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>
                                            {{ $kriteria->butir }}. {{ $kriteria->kriteria }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            {{-- {{$year}} --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="1" class="text-center">Sub kriteria</th>
                                                <th></th>
                                                <th class="text-center">Nama file</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                                @if (count($kriteria->suplemen) > 0)
                                                @foreach ($suplemen as $item)
                                                    <tr>
                                                        <td>{{ $item->sub_kriteria }}</td>
                                                        <td class="text-center">
                                                            @if ($item->data)
                                                            <form action="{{ route('prodi.data-dukung.update', $item->data->id) }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                            @else
                                                            <form action="{{ route('prodi.data-dukung.store') }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                            @endif
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="suplemen_id" value="{{ $item->id }}">
                                                                <input type="hidden" value="{{ $user_prodi->jenjang->id }}" name="jenjang_id" />
                                                                <input type="hidden" value="{{ $user_prodi->program_studi->id }}" name="program_studi_id" />
                                                                <input type="hidden" value="{{ $user_prodi->tahun->id }}" name="tahun_id" />
                                                                <input type="file" name="file" required>
                                                                @if ($item->data)
                                                                <button type="submit" class="btn btn-outline-warning">Update</button>
                                                                @else
                                                                <button type="submit" class="btn btn-outline-primary">Upload</button>
                                                                @endif
                                                            </form>
                                                            @if ($item->data)
                                                            <td><a href="{{url('storage/data_dukung/', $item->data->file)}}" target="_blank">{{$item->data->file}}</a></td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @elseif(count($kriteria->matriks_penilaian) > 0)
                                                    @foreach ($matriks_penilaian as $item)
                                                    <tr>
                                                        <td>{{ $item->sub_kriteria }}</td>
                                                        <td class="text-center">
                                                            @if ($item->data_dukung)
                                                            <form action="{{ route('prodi.data-dukung.update', $item->data->id) }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                            @else
                                                            <form action="{{ route('prodi.data-dukung.store') }}" method="post" enctype="multipart/form-data" id="formActionStore">
                                                            @endif
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="matriks_penilaian_id" value="{{ $item->id }}">
                                                                <input type="hidden" value="{{ $user_prodi->jenjang->id }}" name="jenjang_id" />
                                                                <input type="hidden" value="{{ $user_prodi->program_studi->id }}" name="program_studi_id" />
                                                                <input type="hidden" value="{{ $user_prodi->tahun->id }}" name="tahun_id" />
                                                                <input type="file" name="file" required>
                                                                @if ($item->data_dukung &&
    $item->whereHas('data_dukung.tahun', function ($query) use ($year) {
            $query->where('tahun', $year);
        })->first())
                                                                <button type="submit" class="btn btn-outline-warning">Update</button>
                                                                @else
                                                                <button type="submit" class="btn btn-outline-primary">Upload</button>
                                                                @endif
                                                            </form>
                                                            @if ($item->data_dukung && $item->data_dukung->tahun->tahun == $year)
                                                            <td><a href="{{url('storage/data_dukung/', $item->data->file)}}" target="_blank">{{$item->data->file}}</a></td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                                
                                            </tbody> --}}
                                        <tbody>
                                            @foreach ($kriteria->matriks_penilaian as $item)
                                                <tr>
                                                    <td>{{ $item->sub_kriteria }}</td>
                                                    <td class="text-center">
                                                        @if ($item->data_dukung)
                                                            <form
                                                                action="{{ route('prodi.data-dukung.update', $item->data->id) }}"
                                                                method="post" enctype="multipart/form-data"
                                                                id="formActionStore">
                                                            @else
                                                                <form action="{{ route('prodi.data-dukung.store') }}"
                                                                    method="post" enctype="multipart/form-data"
                                                                    id="formActionStore">
                                                        @endif
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="matriks_penilaian_id"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" value="{{ $user_prodi->jenjang->id }}"
                                                            name="jenjang_id" />
                                                        <input type="hidden"
                                                            value="{{ $user_prodi->program_studi->id }}"
                                                            name="program_studi_id" />
                                                        <input type="hidden" value="{{ $user_prodi->tahun->id }}"
                                                            name="tahun_id" />
                                                        <input type="file" name="file" required>
                                                        @if (
                                                            $item->data_dukung &&
                                                                $item->whereHas('data_dukung.tahun', function ($query) use ($year) {
                                                                        $query->where('tahun', $year);
                                                                    })->first())
                                                            <button type="submit"
                                                                class="btn btn-outline-warning">Update</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-outline-primary">Upload</button>
                                                        @endif
                                                        </form>
                                                        @if ($item->data_dukung && $item->data_dukung->tahun->tahun == $year)
                                                    <td><a href="{{ url('storage/data_dukung/', $item->data->file) }}"
                                                            target="_blank">{{ $item->data->file }}</a></td>
                                                @else
                                                    <td></td>
                                            @endif
                                            </td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                        {{-- <tbody>
                                            <tr>
                                                <td>Kondisi Eksternal</td>
                                                <td class="text-center">
                                                    <form action="https://www.siapinfokom.com/data-dukung/store"
                                                        method="post" enctype="multipart/form-data"
                                                        id="formActionStore">
                                                        <input type="hidden" name="_token"
                                                            value="bkCFzu8qP6Vr6L2zF3ZLJ0CbGAniXP6xzfX0pNHu"> <input
                                                            type="hidden" name="_method" value="POST"> <input
                                                            type="hidden" name="matriks_penilaian_id" value="1">
                                                        <input type="hidden" value="1" name="jenjang_id" />
                                                        <input type="hidden" value="1" name="program_studi_id" />
                                                        <input type="hidden" value="5" name="tahun_id" />
                                                        <input type="file" name="file" required>
                                                        <button type="submit"
                                                            class="btn btn-outline-primary">Upload</button>
                                                    </form>
                                                <td></td>
                                                </td>
                                            </tr>

                                        </tbody> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="section-body">
                            <h2 class="section-title">{{$kriteria->butir}} {{ $kriteria->kriteria }}</h2>
                            <p class="section-lead">Dokumen Data Dukung {{ $kriteria->kriteria }} jenjang D3 lingkup INFOKOM di bawah ini diambil berdasarkan borang
                            </p>
                            <!--Basic table-->
                            <div class="card">
                                <div class="card-header d-block pb-0">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="{{route('prodi.data-dukung.elemen', $program_studi->id)}}" class="btn btn-outline-secondary"><i
                                                class="fa fa-chevron-left"></i> Kembali</a>
                                            </div>
                                            <div class="col-md-6"> <h4>{{$kriteria->butir}}. {{ $kriteria->kriteria }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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

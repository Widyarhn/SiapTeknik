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
                            Dokumen Data Dukung {{ $kriteria->kriteria }} jenjang D3 lingkup Teknik
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
                                            {{ $kriteria->butir }} {{ $kriteria->kriteria }}
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
                                                <th class="text-center">Sub kriteria</th>
                                                <th></th>
                                                <th class="text-center">Nama file</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($matriks as $item)
                                                <tr>
                                                    <td>
                                                        @if (!empty($item->sub_kriteria->sub_kriteria))
                                                            {{ $item->sub_kriteria->sub_kriteria }}
                                                        @else
                                                            {{ $item->kriteria->kriteria }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('prodi.data-dukung.store') }}"
                                                            method="post" enctype="multipart/form-data"
                                                            id="formActionStore">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="matriks_penilaian_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="sub_kriteria_id"
                                                                value="{{ $item->sub_kriteria_id }}">
                                                            <input type="hidden" name="kriteria_id"
                                                                value="{{ $item->kriteria_id }}">
                                                            <input type="hidden" name="program_studi_id"
                                                                value="{{ $user_prodi->program_studi_id }}">
                                                            <input type="hidden" name="tahun_id"
                                                                value="{{ $user_prodi->tahun_id }}">

                                                            <div class="d-flex align-items-center">
                                                                <input type="file" name="file" required
                                                                    class="form-control-file"
                                                                    accept=".pdf">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary ml-2">
                                                                    Upload
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        @if ($item->data_dukung->isEmpty())
                                                            Belum ada
                                                        @else
                                                            <a href="{{ Storage::url($item->data_dukung->first()->file) }}"
                                                                target="_blank">{{ basename($item->data_dukung->first()->nama) }}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
{{-- @if ($item->data_dukung)
                                                            <form
                                                                action="{{ route('prodi.data-dukung.update', $item->data_dukung->id) }}"
                                                                method="post" enctype="multipart/form-data"
                                                                id="formActionStore">
                                                            @else
                                                                
                                                        @endif --}}

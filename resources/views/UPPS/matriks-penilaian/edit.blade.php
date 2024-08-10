<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Matriks Penilaian</title>
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
                        <h1>Edit Matriks Penilaian</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Matriks Penilaian</div>
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
                        <h2 class="section-title">Matriks Penilaian</h2>
                        <p class="section-lead">Matriks Penilaian Instrumen Akreditasi Lingkup Teknik</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Data Matriks Penilaian</h4>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            action="{{ route('UPPS.matriks-penilaian.update', ['id' => $matriks_penilaian->id, 'id_jenjang' => $jenjang->id]) }}"
                                            method="post" enctype="multipart/form-data" id="formActionEdit">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body" id="formEdit">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="hidden" class="form-control"
                                                            value="{{ $jenjang->id }}" name="jenjang_id">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>Elemen Penilaian</label>
                                                                    <select id="kriteria_id"
                                                                        class="form-control selectric"
                                                                        name="kriteria_id">
                                                                        <option value="">-- Pilih --</option>
                                                                        @foreach ($kriteria as $k)
                                                                            <option
                                                                                @if ($k->id == $matriks_penilaian->kriteria_id) selected @endif
                                                                                value="{{ $k->id }}">
                                                                                {{ $k->butir . '  ' . $k->kriteria }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-lg-4">
                                                                <label>Bobot Butir<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="bobot" value="{{ $matriks_penilaian->indikator->bobot }}"
                                                                    name="indikator[0][bobot]" placeholder="contoh: 0.5">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>Sub Elemen</label>
                                                                    @if (!@empty($matriks_penilaian->sub_kriteria->sub_kriteria))
                                                                    
                                                                        <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"
                                                                            >{{ $matriks_penilaian->sub_kriteria->sub_kriteria }}</textarea>
                                                                    @else
                                                                    <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"
                                                                    ></textarea>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                {{-- <div class="form-group">
                                                                    <label>Rumus</label>
                                                                    @if (!@empty($matriks_penilaian->rumus->rumus))
                                                                        <input type="text" class="form-control" id="rumus"
                                                                        name="rumus">
                                                                    @else
                                                                    <input type="text" class="form-control" id="rumus"
                                                                        name="rumus" value="{{ $matriks_penilaian->indikator->rumus->rumus }}">
                                                                    @endif
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div id="indikator-wrapper">
                                                            <div class="indikator-item">
                                                                <hr>
                                                                <div class="form-row"  style="item-aligns: end;">
                                                                    <div class="custom-control custom-checkbox my-4">
                                                                        <input type="checkbox" class="custom-control-input" id="check"
                                                                            name="indikator[0][check]">
                                                                        <label class="custom-control-label"
                                                                            for="check">Centang jika indikator
                                                                            menggunakan rumus</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-9">
                                                                        <label>Deskripsi</label>
                                                                        <input type="text" class="form-control"
                                                                            name="deskriptor"
                                                                            placeholder="isi deskripsi"
                                                                            value="{{ $matriks_penilaian->indikator->deskriptor }}">
                                                                    </div>
                                                                    <div class="form-group col-lg-3">
                                                                        <label>Bobot Butir</label>
                                                                        <input type="text" class="form-control"
                                                                            name="bobot"
                                                                            placeholder="contoh: 0.5"
                                                                            value="{{ $matriks_penilaian->indikator->bobot }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>4</label>
                                                                    <input type="text" class="form-control"
                                                                        name="sangat_baik"
                                                                        placeholder="isi untuk deskripsi nilai sangat baik"
                                                                        value="{{ $matriks_penilaian->indikator->sangat_baik }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>3</label>
                                                                    <input type="text" class="form-control"
                                                                        name="baik"
                                                                        placeholder="isi untuk deskripsi nilai baik"
                                                                        value="{{ $matriks_penilaian->indikator->baik }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>2</label>
                                                                    <input type="text" class="form-control"
                                                                        name="cukup"
                                                                        placeholder="isi untuk deskripsi nilai cukup"
                                                                        value="{{ $matriks_penilaian->indikator->cukup }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>1</label>
                                                                    <input type="text" class="form-control"
                                                                        name="kurang"
                                                                        placeholder="isi untuk deskripsi nilai kurang"
                                                                        value="{{ $matriks_penilaian->indikator->kurang }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>0</label>
                                                                    <input type="text" class="form-control"
                                                                        name="sangat_kurang"
                                                                        placeholder="isi untuk deskripsi nilai sangat kurang"
                                                                        value="{{ $matriks_penilaian->indikator->sangat_kurang }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <div>
                                                        <a href="{{ route('UPPS.matriks-penilaian.jenjang', $jenjang->id) }}"
                                                            class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                            Kembali</a>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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

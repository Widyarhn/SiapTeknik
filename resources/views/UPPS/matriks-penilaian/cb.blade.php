<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Matriks Penilaian</title>
    @include('body')
    <script type="text/javascript">
        $(document).ready(function() {
            var html = '<div class="card"> <
                div class = "card-header" >
                <
                h4 > < /h4> <
                div class = "card-header-action" >
                <
                a href = ""
            type = "button"
            name = "add"
            id = "add"
            class = "btn btn-icon btn-warning" > < i
            class = "fas fa-plus-circle" > < /i> Tambah</a >
            <
            a href = ""
            type = "button"
            name = "remove"
            id = "remove"
            class = "btn btn-icon btn-danger" > < i
            class = "fas fa-times " > < /i> Hapus</a >
            <
            /div> <
            /div> <
            div class = "card-body" >
            <
            div class = "row" >
            <
            div class = "col-md-3" >
            <
            div class = "form-group" >
            <
            label > No Butir < /label> <
                input type = "text"
            class = "form-control"
            name = "no_butir"
            placeholder = "contoh: 1.1" >
                <
                /div> <
                /div> <
                div class = "col-md-9" >
                <
                div class = "form-group" >
                <
                label > Deskripsi < /label> <
                input type = "text"
            class = "form-control"
            name = "deskriptor"
            placeholder = "isi deskripsi" >
                <
                /div> <
                /div> <
                /div> <
                div class = "form-group" >
                <
                label > 4 < /label> <
                input type = "text"
            class = "form-control"
            name = "sangat_baik"
            placeholder = "isi untuk deskripsi nilai sangat baik" >
                <
                /div> <
                div class = "form-group" >
                <
                label > 3 < /label> <
                input type = "text"
            class = "form-control"
            name = "baik"
            placeholder = "isi untuk deskripsi nilai baik" >
                <
                /div> <
                div class = "form-group" >
                <
                label > 2 < /label> <
                input type = "text"
            class = "form-control"
            name = "cukup"
            placeholder = "isi untuk deskripsi nilai cukup" >
                <
                /div> <
                div class = "form-group" >
                <
                label > 1 < /label> <
                input type = "text"
            class = "form-control"
            name = "kurang"
            placeholder = "isi untuk deskripsi nilai kurang" >
                <
                /div> <
                div class = "form-group" >
                <
                label > 0 < /label> <
                input type = "text"
            class = "form-control"
            name = "sangat_kurang"
            placeholder = "isi untuk deskripsi nilai sangat kurang" >
                <
                /div> <
                /div> <
                /div>';
            var x = 1;
            $(".add").click(function() {
                $(".form-field").append(html);
            });
        });
    </script>
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
                        <h1>Tambah Matriks Penilaian</h1>
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
                        <p class="section-lead">Matriks Penilaian Instrumen Akreditasi Lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <form id="formTambah" class="needs-validation" novalidate=""
                                    action="{{ route('UPPS.matriks-penilaian.store') }}" method="post"
                                    enctype="multipart/form-data" id="formActionTambah">
                                    @csrf
                                    @method('POST')
                                    <div class="card card-primary" style="border-top: 3px solid ;">
                                        <div class="card-header">
                                            <h4>Tambah Data Matriks Penilaian</h4>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" class="form-control" value="{{ $jenjang->id }}"
                                                name="jenjang_id">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Elemen Penilaian</label>
                                                            <select id="kriteria_id" class="form-control selectric"
                                                                name="kriteria_id">
                                                                <option value="">-- Pilih --
                                                                </option>
                                                                @foreach ($kriteria as $k)
                                                                    <option value="{{ $k->id }}">
                                                                        {{ $k->butir . '  ' . $k->kriteria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bobot Butir</label>
                                                        <input type="text" class="form-control" name="bobot"
                                                            placeholder="contoh: 0.5">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Sub Elemen</label>
                                                        <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card form-field">
                                        <div class="card-header">
                                            <h4></h4>
                                            <div class="card-header-action">
                                                <input type="button" name="add" class="add btn btn-icon btn-warning" value="Tambah">

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>No Butir</label>
                                                        <input type="text" class="form-control" name="no_butir"
                                                            placeholder="contoh: 1.1">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <input type="text" class="form-control" name="deskriptor"
                                                            placeholder="isi deskripsi">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>4</label>
                                                <input type="text" class="form-control" name="sangat_baik"
                                                    placeholder="isi untuk deskripsi nilai sangat baik">
                                            </div>
                                            <div class="form-group">
                                                <label>3</label>
                                                <input type="text" class="form-control" name="baik"
                                                    placeholder="isi untuk deskripsi nilai baik">
                                            </div>
                                            <div class="form-group">
                                                <label>2</label>
                                                <input type="text" class="form-control" name="cukup"
                                                    placeholder="isi untuk deskripsi nilai cukup">
                                            </div>
                                            <div class="form-group">
                                                <label>1</label>
                                                <input type="text" class="form-control" name="kurang"
                                                    placeholder="isi untuk deskripsi nilai kurang">
                                            </div>
                                            <div class="form-group">
                                                <label>0</label>
                                                <input type="text" class="form-control" name="sangat_kurang"
                                                    placeholder="isi untuk deskripsi nilai sangat kurang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card bg-whitesmoke br text-center">
                                        <div class="m-lg-4">
                                            <a href="{{ route('UPPS.matriks-penilaian.jenjang', $jenjang->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                Kembali</a>
                                            <button type="submit" class="btn btn-success">Simpan</button>

                                        </div>
                                    </div>
                                </form>
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
                        <h1>Tambah Matriks Penilaian</h1>
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
                        <p class="section-lead">Matriks Penilaian Instrumen Akreditasi Lingkup INFOKOM</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Data Matriks Penilaian</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- <div class="modal-body" id="formTambah">
                                            <form class="needs-validation" novalidate=""
                                                action="{{ route('UPPS.matriks-penilaian.store') }}" method="post"
                                                enctype="multipart/form-data" id="formActionTambah">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" class="form-control" value="{{ $jenjang->id }}"
                                                    name="jenjang_id">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <label>Elemen Penilaian</label>
                                                                <select id="kriteria_id" class="form-control selectric"
                                                                    name="kriteria_id">
                                                                    <option value="">-- Pilih --
                                                                    </option>
                                                                    @foreach ($kriteria as $k)
                                                                        <option value="{{ $k->id }}">
                                                                            {{ $k->butir . '  ' . $k->kriteria }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Bobot Butir</label>
                                                            <input type="text" class="form-control" name="bobot"
                                                                placeholder="contoh: 0.5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Sub Elemen</label>
                                                            <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>No Butir</label>
                                                            <input type="text" class="form-control" name="no_butir"
                                                                placeholder="contoh: 1.1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <input type="text" class="form-control" name="deskriptor"
                                                                placeholder="isi deskripsi">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>4</label>
                                                    <input type="text" class="form-control" name="sangat_baik"
                                                        placeholder="isi untuk deskripsi nilai sangat baik">
                                                </div>
                                                <div class="form-group">
                                                    <label>3</label>
                                                    <input type="text" class="form-control" name="baik"
                                                        placeholder="isi untuk deskripsi nilai baik">
                                                </div>
                                                <div class="form-group">
                                                    <label>2</label>
                                                    <input type="text" class="form-control" name="cukup"
                                                        placeholder="isi untuk deskripsi nilai cukup">
                                                </div>
                                                <div class="form-group">
                                                    <label>1</label>
                                                    <input type="text" class="form-control" name="kurang"
                                                        placeholder="isi untuk deskripsi nilai kurang">
                                                </div>
                                                <div class="form-group">
                                                    <label>0</label>
                                                    <input type="text" class="form-control" name="sangat_kurang"
                                                        placeholder="isi untuk deskripsi nilai sangat kurang">
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <div>
                                                        <a href="{{ route('UPPS.matriks-penilaian.jenjang', $jenjang->id) }}"
                                                            class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                            Kembali</a>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div> --}}
                                        <div class="modal-body" id="formTambah">
                                            <form class="needs-validation" novalidate=""
                                                action="{{ route('UPPS.matriks-penilaian.store') }}" method="post"
                                                enctype="multipart/form-data" id="formActionTambah">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" class="form-control" value="{{ $jenjang->id }}"
                                                    name="jenjang_id">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Elemen Penilaian</label>
                                                            <select id="kriteria_id" class="form-control selectric"
                                                                name="kriteria_id">
                                                                <option value="">-- Pilih --
                                                                </option>
                                                                @foreach ($kriteria as $k)
                                                                    <option value="{{ $k->id }}">
                                                                        {{ $k->butir . '  ' . $k->kriteria }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Bobot Butir</label>
                                                            <input type="text" class="form-control" name="bobot"
                                                                placeholder="contoh: 0.5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Sub Elemen</label>
                                                            <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Start of dynamic section for multiple indicators -->
                                                <div id="indikator-wrapper">
                                                    <div class="indikator-item">
                                                        <hr class="mt-3 mb-3"
                                                            style="border-top: 2px solid rgba(0,0,0,.1);">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Deskripsi</label>
                                                                    <input type="text" class="form-control"
                                                                        name="indikator[0][deskriptor]"
                                                                        placeholder="isi deskripsi">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>4</label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][sangat_baik]"
                                                                placeholder="isi untuk deskripsi nilai sangat baik">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>3</label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][baik]"
                                                                placeholder="isi untuk deskripsi nilai baik">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2</label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][cukup]"
                                                                placeholder="isi untuk deskripsi nilai cukup">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1</label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][kurang]"
                                                                placeholder="isi untuk deskripsi nilai kurang">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>0</label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][sangat_kurang]"
                                                                placeholder="isi untuk deskripsi nilai sangat kurang">
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-danger remove-indikator mb-2">Hapus
                                                            Indikator</button>
                                                    </div>
                                                </div>
                                                <!-- End of dynamic section for multiple indicators -->

                                                <button type="button" class="btn btn-primary mt-3 mb-4"
                                                    id="add-indikator">Tambah Indikator</button>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <div>
                                                        <a href="{{ route('UPPS.matriks-penilaian.jenjang', $jenjang->id) }}"
                                                            class="btn btn-secondary"><i
                                                                class="fa fa-chevron-left"></i>
                                                            Kembali</a>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Basic table-->

                </section>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const wrapper = document.getElementById('indikator-wrapper');
                    const addButton = document.getElementById('add-indikator');

                    addButton.addEventListener('click', function() {
                        const indikatorItem = document.querySelector('.indikator-item').cloneNode(true);
                        const index = wrapper.querySelectorAll('.indikator-item').length;
                        indikatorItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                            input.name = `indikator[${index}][${input.getAttribute('name').split('[')[1]}`;
                        });
                        wrapper.appendChild(indikatorItem);
                    });

                    document.addEventListener('click', function(event) {
                        if (event.target.classList.contains('remove-indikator')) {
                            event.target.closest('.indikator-item').remove();
                        }
                    });
                });
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


//main dash Upps
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>LAM TEKNIK &mdash; Akreditasi</title>
    @include('body')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('UPPS.layout.header')

            <!-- Main SIdebar -->
            @include('UPPS.layout.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    {{-- <div class="section-header">
                        <h1>Dashboard UPPS</h1>
                    </div> --}}
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
                                title: 'Login Berhasil!',
                                text: '{{ session('success') }}'
                            })
                        </script>
                    @endif
                    {{-- <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon shadow-warning bg-warning">
                                    <i class="far fa-lightbulb"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Info Dokumen Ajuan Program Studi yang belum disetujui</h4>
                                    </div>
                                    <div class="card-body">
                                        @if ($jumlah == 0)
                                            -
                                        @else
                                            {{ $jumlah }}
                                        @endif
                                        <div class="btn-group dropright m-2">
                                            @if ($jumlah == 0)
                                            @else
                                                <button type="button"
                                                    class="btn btn-outline-warning dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="border-radius: 30px;">
                                                    View New Documents
                                                </button>
                                                <div class="dropdown-menu dropright" style="width: auto;box-shadow:0 4px 8px rgba(0, 0, 0, 0.13)">
                                                    @foreach ($dokumen_ajuan as $p)
                                                            <a class="dropdown-item" value="{{ $p->program_studi_id }}" href="{{ route('upps.dokumenajuan.prodi', $p->program_studi_id) }}">
                                                                {{ $p->program_studi->jenjang->jenjang }} {{ $p->program_studi->nama }}
                                                            </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="{{ route('timeline.index') }}">
                                <div class="card card-statistic-2">
                                    <div class="card-icon shadow-primary bg-primary">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Lihat dan Kelola</h4>
                                        </div>
                                        <div class="card-body">
                                            Timeline Akreditasi
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="buttons">
                                        <a href="#" data-toggle="modal" data-target="#modalTambah"
                                            class="btn btn-outline-secondary btn-create"><i
                                                class="fas fa-plus-circle"></i> Tambahkan</a>
                                        <h4>Tabel Tahun Akreditasi</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="tahunTable">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Tahun Akreditasi</th>
                                                    <th>Mulai Akreditasi</th>
                                                    <th>Akhir Akreditasi</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Program Studi</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('prodi.index') }}" class="btn btn-outline-primary">
                                            View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Lihat dan kelola program studi di sini</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>User</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('user.index') }}" class="btn btn-outline-primary">
                                            View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p> Lihat dan kelola user di sini</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="buttons">
                                        <h4>Tabel Sertifikat</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="sertifTabel">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Program Studi</th>
                                                    <th>File</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Tabel Berita Acara</h4>
                                    <div class="card-header-action">
                                        <a href="#desk-evaluasi" data-tab="summary-tab" class="btn active">Desk
                                            Evaluasi</a>
                                        <a href="#asesmen-lapangan" data-tab="summary-tab" class="btn">Asesmen
                                            Lapangan</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="summary">
                                        <div class="table-responsive" data-tab-group="summary-tab"
                                            id="asesmen-lapangan">
                                            <table class="table table-striped" id="asesmenLapanganTabel"
                                                style="width: 496px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Program Studi</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive active" data-tab-group="summary-tab"
                                            id="desk-evaluasi">
                                            <table class="table table-striped" id="deskEvalTabel">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Program Studi</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    //New
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon shadow-warning bg-warning">
                                    <i class="far fa-lightbulb"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Info Dokumen Ajuan Program Studi yang belum disetujui</h4>
                                    </div>
                                    <div class="card-body">
                                        @if (count($dokumen_ajuan) == 0)
                                            -
                                        @else
                                            {{ count($dokumen_ajuan) }}
                                        @endif
                                        <div class="btn-group dropright m-2">
                                            @if (count($dokumen_ajuan) == 0)
                                            @else
                                                <button type="button"
                                                    class="btn btn-outline-warning dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="border-radius: 30px;">
                                                    View New Documents
                                                </button>
                                                <div class="dropdown-menu dropright"
                                                    style="width: auto;box-shadow:0 4px 8px rgba(0, 0, 0, 0.13)">
                                                    @foreach ($dokumen_ajuan as $p)
                                                        <a class="dropdown-item" value="{{ $p->program_studi_id }}"
                                                            href="{{ route('upps.dokumenajuan.prodi', $p->program_studi_id) }}">
                                                            {{ $p->program_studi->jenjang->jenjang }}
                                                            {{ $p->program_studi->nama }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="{{ route('timeline.index') }}">
                                <div class="card card-statistic-2">
                                    <div class="card-icon shadow-primary bg-primary">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>Lihat dan Kelola</h4>
                                        </div>
                                        <div class="card-body">
                                            Akreditasi Program Studi
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Timeline Akreditasi</h4>
                                    <div class="card-header-action dropdown">
                                        <a href="#" data-toggle="dropdown"
                                            class="btn btn-danger dropdown-toggle">Pilih Prodi</a>
                                        <ul class="dropdown-menu"
                                            style="width: auto;box-shadow:0 4px 8px rgba(0, 0, 0, 0.13)">
                                            <li class="dropdown-title">Pilih Program Studi</li>
                                            <li><a href="#" class="dropdown-item">D3 Teknik Mesin</a></li>
                                            <li><a href="#" class="dropdown-item">D3 Teknik Pendingin dan Tata
                                                    Udara</a></li>
                                            <li><a href="#" class="dropdown-item">D4 Perancangan
                                                    Manufaktur</a></li>
                                            <li><a href="#" class="dropdown-item">D4 Teknologi Rekayasa
                                                    Instrumentasi dan Kontrol</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body" id="top-5-scroll">
                                    <ul class="list-unstyled list-unstyled-border">
                                        @if (count($status_1) == 0)
                                            <p class="text-center">Belum ada timeline untuk Prodi</p>
                                        @else
                                            @foreach ($timeline as $t)
                                                <li class="media">
                                                    <div class="media-body">
                                                        <div class="media-title">{{ $t->nama_kegiatan }}</div>
                                                        <div class="mt-1">
                                                            <div class="font-weight-600 text-muted text-medium">
                                                                {{ $t->jadwal_awal . ' s/d ' . $t->jadwal_akhir }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                        {{-- <li class="media">
                                            <img class="mr-3 rounded" width="55"
                                                src="assets/img/products/product-4-50.png" alt="product">
                                            <div class="media-body">
                                                <div class="float-right">
                                                    <div class="font-weight-600 text-muted text-small">67 Sales
                                                    </div>
                                                </div>
                                                <div class="media-title">iBook Pro 2018</div>
                                                <div class="mt-1">
                                                    <div class="budget-price">
                                                        <div class="budget-price-square bg-primary"
                                                            data-width="84%"></div>
                                                        <div class="budget-price-label">$107,133</div>
                                                    </div>
                                                    <div class="budget-price">
                                                        <div class="budget-price-square bg-danger" data-width="60%">
                                                        </div>
                                                        <div class="budget-price-label">$91,455</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> --}}
                                    </ul>
                                </div>
                                {{-- <div class="card-footer pt-3 d-flex justify-content-center">

                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="buttons">
                                        <a href="#" data-toggle="modal" data-target="#modalTambah"
                                            class="btn btn-outline-primary btn-create mb-2"
                                            style="border-radius: 30px;"><i class="fas fa-plus-circle"></i>
                                            Tambahkan</a>
                                        <h4>List Akreditasi Program Studi</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="timelineTable">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Program Studi</th>
                                                    <th>Tahun</th>
                                                    <th>Mulai Akreditasi</th>
                                                    <th>Akhir Akreditasi</th>
                                                    <th>Status</th>
                                                    <th>Berita Acara</th>
                                                    <th>Sertifikat</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
            <!--Basic table-->
        </div>

        {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tahun Akreditasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" id="formActionTambah">
                        @csrf
                        @method('POST')
                        <div class="modal-body" id="formTambah">
                            <div class="card">
                                <form class="needs-validation" novalidate="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="number" class="form-control" name="tahun"
                                                required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Mulai Akreditasi</label>
                                            <input type="date" class="form-control" name="tanggal_awal"
                                                required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Akhir Akeditasi</label>
                                            <input type="date" class="form-control" name="tanggal_akhir"
                                                required="">
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
        </div> --}}
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tahun Akreditasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <form action="{{ route('UPPS.timeline.store') }}" method="post"
                            enctype="multipart/form-data" id="formTambah">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Kegiatan</label>
                                        <input type="text" class="form-control" name="nama_kegiatan"
                                            required="">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>Program Studi</label>
                                            <select id="program_studi" class="form-control selectric"
                                                name="program_studi_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($program_studi as $prodi)
                                                    <option value="{{ $prodi->id }}">
                                                        {{ $prodi->jenjang->jenjang }}
                                                        {{ $prodi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Tahun</label>
                                            <select id="tahun" class="form-control selectric" name="tahun_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($tahun as $tahun)
                                                    <option value="{{ $tahun->id }}">{{ $tahun->tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="jadwal_awal"
                                            required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Berakhir</label>
                                        <input type="date" class="form-control" name="jadwal_akhir"
                                            required="">
                                    </div>
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
    {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Tahun Akreditasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="formActionEdit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="formEdit">
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <script>
        $(function() {
            $('#timelineTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.timeline.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'proses',
                        name: 'proses'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        });

        $("body").on('click', ".btn-lihat", function() {
            let url = $(this).data("url") + "/edit"
            $("#formActionEdit").attr("action", $(this).data("url"))
            $.ajax({
                url: url,
                type: "get",
                success: function(data) {
                    $("#formEdit").html(data)
                }
            })
        })

        $("body").on('click', ".btn-edit", function() {
            let url = $(this).data("url") + "/edit"
            $("#formActionEdit").attr("action", $(this).data("url"))
            $.ajax({
                url: url,
                type: "get",
                success: function(data) {
                    $("#formEdit").html(data)
                }
            })
        })

        $("body").on('click', '.selesai-btn', function(e) {
            let id = $(this).data('id');
            let route = $(this).data('route')
            swal({
                title: 'Selesaikan Akreditasi?',
                html: `Akreditasi akan selesai, pastikan semua proses telah dilakukan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Selesai!',
                buttons: true,
                dangerMode: true,
            }).then((willEdit) => {
                let is_active = '1';
                if (willEdit) {
                    const response = $.ajax({
                        url: route,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            is_active: is_active,
                        }
                    }).catch(() => {
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: 'Server Error',
                            icon: 'error'
                        })
                    })
                    if (!response) return;

                    const success = swal({
                        title: 'Berhasil!',
                        text: "Akreditasi telah selesai",
                        icon: 'success',
                    }).then((response) => {

                        window.location.reload()
                    })
                }

            })
        })

        // $(function() {
        //     $('#tahunTable').dataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('tahun-akreditasi.json') }}",
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //             },
        //             {
        //                 data: 'tahun',
        //                 name: 'tahun'
        //             },
        //             {
        //                 data: 'awal',
        //                 name: 'awal'
        //             },
        //             {
        //                 data: 'akhir',
        //                 name: 'akhir'
        //             },
        //             {
        //                 data: 'status',
        //                 name: 'status'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action'
        //             }
        //         ],
        //     })
        // })

        // $(function() {
        //     $('#sertifTabel').dataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('sertifikat.sertifTable') }}",
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //             },
        //             {
        //                 data: 'program_studi',
        //                 name: 'program_studi'
        //             },
        //             {
        //                 data: 'file',
        //                 name: 'file'
        //             }
        //         ],
        //     })
        // })

        // $(function() {
        //     $('#deskEvalTabel').dataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('berita-acara.deskEvalTable') }}",
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //             },
        //             {
        //                 data: 'program_studi',
        //                 name: 'program_studi'
        //             },
        //             {
        //                 data: 'file',
        //                 name: 'file'
        //             }
        //         ],
        //     })
        // })

        // $(function() {
        //     $('#asesmenLapanganTabel').dataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('berita-acara.asesmenLapanganTable') }}",
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //             },
        //             {
        //                 data: 'program_studi',
        //                 name: 'program_studi'
        //             },
        //             {
        //                 data: 'file',
        //                 name: 'file'
        //             }
        //         ],
        //     })
        // })

        // $("body").on('click', ".btn-edit", function() {
        //     let url = $(this).data("url") + "/edit"
        //     $("#formActionEdit").attr("action", $(this).data("url"))
        //     $.ajax({
        //         url: url,
        //         type: "get",
        //         success: function(data) {
        //             $("#formEdit").html(data)
        //         }
        //     })
        // })

        // $("body").on('click', '.selesai-btn', function(e) {
        //     let id = $(this).data('id');
        //     let route = $(this).data('route')
        //     swal({
        //         title: 'Selesaikan Akreditasi?',
        //         html: `Akreditasi akan selesai, pastikan semua proses telah dilakukan!`,
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Selesai!',
        //         buttons: true,
        //         dangerMode: true,
        //     }).then((willEdit) => {
        //         let is_active = '1';
        //         if (willEdit) {
        //             const response = $.ajax({
        //                 url: route,
        //                 method: 'POST',
        //                 data: {
        //                     _token: "{{ csrf_token() }}",
        //                     id: id,
        //                     is_active: is_active,
        //                 }
        //             }).catch(() => {
        //                 swal({
        //                     title: 'Terjadi kesalahan!',
        //                     text: 'Server Error',
        //                     icon: 'error'
        //                 })
        //             })
        //             if (!response) return;

        //             const success = swal({
        //                 title: 'Berhasil!',
        //                 text: "Akreditasi telah selesai",
        //                 icon: 'success',
        //             }).then((response) => {

        //                 window.location.reload()
        //             })
        //         }

        //     })
        // })
    </script>

    <footer class="main-footer">
        @include('footer')
    </footer>
    </div>
    </div>

</body>

</html>

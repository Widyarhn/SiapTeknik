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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Data Matriks Penilaian</h4>
                                    </div>
                                    <div class="card-body">
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
                                                                <option value="">-- Pilih --</option>
                                                                @foreach ($kriteria as $k)
                                                                    <option value="{{ $k->id }}">
                                                                        {{ $k->butir . '  ' . $k->kriteria }}</option>
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
                                                <button type="button" class="btn btn-primary mt-3 mb-4"
                                                    id="add-indikator">Tambah Indikator</button>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <div>
                                                        <a href="{{ route('UPPS.matriks-penilaian.jenjang', $jenjang->id) }}"
                                                            class="btn btn-secondary"><i
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
                    </div>
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
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>
</body>

</html>

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
                        <p class="section-lead">Matriks Penilaian Instrumen Akreditasi Lingkup Teknik</p>
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
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label>Elemen Penilaian<span
                                                                    class="text-danger">*</span></label>
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
                                                    <div class="form-group col-lg-4">
                                                        <label>Bobot Butir<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="bobot"
                                                            name="indikator[0][bobot]" placeholder="contoh: 0.5">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label>Sub Elemen</label>
                                                            <textarea class="form-control" name="sub_kriteria" placeholder="contoh: C.1.4. Indikator Kinerja Utama"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Rumus</label>
                                                            <input type="text" class="form-control" id="rumus"
                                                                name="rumus">
                                                        </div>
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
                                                            <div class="form-group col-lg-2">
                                                                <label>Butir Deskripsi</label>
                                                                <input type="text" class="form-control"
                                                                    name="indikator[0][no_butir]"
                                                                    placeholder="contoh: A.">
                                                            </div>
                                                            <div class="form-group col-lg-10">
                                                                <label>Deskripsi<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="indikator[0][deskriptor]"
                                                                    placeholder="isi deskripsi">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>4<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][sangat_baik]"
                                                                placeholder="isi untuk deskripsi nilai sangat baik">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>3<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][baik]"
                                                                placeholder="isi untuk deskripsi nilai baik">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][cukup]"
                                                                placeholder="isi untuk deskripsi nilai cukup">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][kurang]"
                                                                placeholder="isi untuk deskripsi nilai kurang">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>0<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                name="indikator[0][sangat_kurang]"
                                                                placeholder="isi untuk deskripsi nilai sangat kurang">
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <button type="button"
                                                                class="btn btn-icon icon-left btn-danger remove-indikator ml-2 mb-4"
                                                                style="display: none;"><i class="fa fa-trash"></i>
                                                                Hapus
                                                                Indikator</button>
                                                            <button type="button"
                                                                class="btn btn-primary ml-2 mb-4 add-indikator"><i
                                                                    class="fas fa-plus"></i> Tambah Indikator</button>
                                                        </div>
                                                    </div>
                                                </div>

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
                </section>
            </div>
            <script>
                // document.addEventListener('DOMContentLoaded', function(e) {
                //     function addIndikatorRow() {
                //         const indikatorWrapper = document.getElementById('indikator-wrapper');
                //         const index = indikatorWrapper.querySelectorAll('.indikator-item').length;
                //         const newItem = document.createElement('div');
                //         newItem.className = 'indikator-item';
                //         newItem.innerHTML = `
    //             <hr>
    //             <div class="form-row">
    //                 <div class="form-group col-lg-7">
    //                     <label>Deskripsi</label>
    //                     <input type="text" class="form-control" name="indikator[${index}][deskriptor]" placeholder="isi deskripsi">
    //                 </div>
    //                 <div class="form-group col-lg-5">
    //                     <label>Bobot Butir</label>
    //                     <input type="text" class="form-control" name="indikator[${index}][bobot]" placeholder="contoh: 0.5">
    //                 </div>
    //             </div>
    //             <div class="form-group">
    //                 <label>4</label>
    //                 <input type="text" class="form-control" name="indikator[${index}][sangat_baik]" placeholder="isi untuk deskripsi nilai sangat baik">
    //             </div>
    //             <div class="form-group">
    //                 <label>3</label>
    //                 <input type="text" class="form-control" name="indikator[${index}][baik]" placeholder="isi untuk deskripsi nilai baik">
    //             </div>
    //             <div class="form-group">
    //                 <label>2</label>
    //                 <input type="text" class="form-control" name="indikator[${index}][cukup]" placeholder="isi untuk deskripsi nilai cukup">
    //             </div>
    //             <div class="form-group">
    //                 <label>1</label>
    //                 <input type="text" class="form-control" name="indikator[${index}][kurang]" placeholder="isi untuk deskripsi nilai kurang">
    //             </div>
    //             <div class="form-group">
    //                 <label>0</label>
    //                 <input type="text" class="form-control" name="indikator[${index}][sangat_kurang]" placeholder="isi untuk deskripsi nilai sangat kurang">
    //             </div>
    //             <div class="d-flex align-items-center">
    //                 <button type="button" class="btn btn-icon icon-left btn-danger remove-indikator ml-2 mb-4"><i class="fa fa-trash"></i> Hapus Indikator</button>
    //                 <button type="button" class="btn btn-primary ml-2 mb-4 add-indikator"><i class="fas fa-plus"></i> Tambah Indikator</button>
    //             </div>
    //         `;
                //         indikatorWrapper.appendChild(newItem);

                //         newItem.querySelector('.remove-indikator').addEventListener('click', function() {
                //             indikatorWrapper.removeChild(newItem);
                //         });

                //         newItem.querySelector('.add-indikator').addEventListener('click', addIndikatorRow);

                //         // Update visibility of remove button
                //         indikatorWrapper.querySelectorAll('.indikator-item').forEach(function(item, idx) {
                //             const removeButton = item.querySelector('.remove-indikator');
                //             removeButton.style.display = idx > 0 ? 'inline-block' : 'none';
                //         });
                //     }

                //     document.querySelectorAll('.add-indikator').forEach(function(button) {
                //         button.addEventListener('click', addIndikatorRow);
                //     });

                //     // Hide the initial remove button
                //     const initialRemoveButton = document.querySelector('.indikator-item .remove-indikator');
                //     if (initialRemoveButton) {
                //         initialRemoveButton.style.display = 'none';
                //     }
                // });
                document.addEventListener('DOMContentLoaded', function() {
                    let indikatorCount = 1;

                    // Function to add new indikator row
                    function addIndikatorRow() {
                        const indikatorWrapper = document.getElementById('indikator-wrapper');
                        const index = indikatorWrapper.querySelectorAll('.indikator-item').length;
                        const newItem = document.createElement('div');
                        newItem.className = 'indikator-item';
                        newItem.innerHTML = `
                            <hr>
                            <div class="form-row"  style="item-aligns: end;">
                                <div class="custom-control custom-checkbox my-3">
                                    <input type="checkbox" class="custom-control-input" id="check${index}" name="indikator[${index}][check]">
                                    <label class="custom-control-label"for="check${index}">Centang jika indikator
                                        menggunakan rumus</label>
                                </div>
                            </div>
                            <div class="form-group mb-0 mt-2" style="text-align: end;">
                                    <button type="button" class="btn btn-outline-primary add-bobot" data-index="${index}"><i class="fas fa-plus"></i> Bobot</button>
                            </div>
                            
                            <div class="form-row bobot-rows">
                                <div class="form-group col-lg-2">
                                    <label>Butir Deskripsi</label>
                                    <input type="text" class="form-control" name="indikator[${index}][no_butir]" placeholder="contoh: A.">
                                </div>
                                <div class="form-group col-lg-8">
                                    <label>Deskripsi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][deskriptor]" placeholder="isi deskripsi">
                                </div>
                                <div class="form-group col-lg-2 bobot-group additional-bobot" style="display: none;">
                                    <label>Bobot Butir<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][bobot]" placeholder="contoh: 0.5">
                                </div>
                                
                            </div>
                                <div class="form-group">
                                    <label>4<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][sangat_baik]" placeholder="isi untuk deskripsi nilai sangat baik">
                                </div>
                                <div class="form-group">
                                    <label>3<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][baik]" placeholder="isi untuk deskripsi nilai baik">
                                </div>
                                <div class="form-group">
                                    <label>2<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][cukup]" placeholder="isi untuk deskripsi nilai cukup">
                                </div>
                                <div class="form-group">
                                    <label>1<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][kurang]" placeholder="isi untuk deskripsi nilai kurang">
                                </div>
                                <div class="form-group">
                                    <label>0<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="indikator[${index}][sangat_kurang]" placeholder="isi untuk deskripsi nilai sangat kurang">
                                </div>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-icon icon-left btn-danger remove-indikator ml-2 mb-4"><i class="fa fa-trash"></i> Hapus Indikator</button>
                                <button type="button" class="btn btn-primary ml-2 mb-4 add-indikator"><i class="fas fa-plus"></i> Tambah Indikator</button>
                            </div>
                        `;
                        indikatorWrapper.appendChild(newItem);

                        // Add event listeners to the new buttons
                        newItem.querySelector('.remove-indikator').addEventListener('click', function() {
                            indikatorWrapper.removeChild(newItem);
                        });

                        newItem.querySelector('.add-indikator').addEventListener('click', addIndikatorRow);
                    }

                    // Function to show bobot tambahan input field
                    function showBobot(button) {
                        const index = button.dataset.index;
                        const bobotRows = button.closest('.indikator-item').querySelector('.bobot-rows');
                        const additionalBobot = bobotRows.querySelector('.additional-bobot');
                        additionalBobot.style.display = 'block'; // Show bobot tambahan input field
                        button.style.display = 'none'; // Hide the 'Tambah Bobot' button
                    }

                    document.querySelectorAll('.add-indikator').forEach(function(button) {
                        button.addEventListener('click', addIndikatorRow);
                    });

                    document.getElementById('indikator-wrapper').addEventListener('click', function(event) {
                        if (event.target.classList.contains('add-bobot')) {
                            showBobot(event.target);
                        }
                    });

                    document.getElementById('indikator-wrapper').addEventListener('click', function(event) {
                        if (event.target.classList.contains('remove-indikator')) {
                            event.target.parentElement.parentElement.remove();
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

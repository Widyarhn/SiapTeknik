<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Kriteria </title>
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
                        <h1>Data Kriteria</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Kriteria</div>
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
                        <h2 class="section-title">Data Kriteria</h2>
                        <p class="section-lead">Data tambahan untuk dokumen kriteria jenjang D3 dan D4 lingkup INFOKOM
                            berupa tabel kriteria beserta tabel LKPSnya</p>
                        <!--Basic table-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="buttons">
                                            <a href="" data-toggle="modal" data-target="#tambahKriteria"
                                                class="btn btn-outline-secondary btn-create"><i
                                                    class="fas fa-plus-circle"></i> Tambahkan</a>
                                            <h4>Tabel Kriteria</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="kriteriaTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Butir</th>
                                                        <th>Kriteria</th>
                                                        <th>Tabel LKPS</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Basic table-->
            </div>
            </section>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="tambahKriteria">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('UPPS.matriks-penilaian.kriteria.store') }}" method="post"
                        enctype="multipart/form-data" id="formActionKriteria" class="needs-validation" novalidate="">
                        @csrf
                        @method('POST')
                        <div class="modal-body" id="formKriteria">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Butir</label>
                                        <input type="text" class="form-control" name="butir"
                                            placeholder="contoh: A">
                                    </div>
                                    <div class="form-group">
                                        <label>Kriteria</label>
                                        <input type="text" class="form-control" name="kriteria"
                                            placeholder="contoh: Kondisi Eksternal">
                                    </div>
                                    <div id="lkps-wrapper">
                                        <div class="lkps-item d-flex align-items-center">
                                            <div class="form-group flex-grow-1">
                                                <label>Nama Tabel LKPS</label>
                                                <input type="text" class="form-control"
                                                    name="lkps[0][nama_tabel_lkps]"
                                                    placeholder="contoh: Tabel 1 Kerjasama Tridharma Perguruan Tinggi - Pendidikan">
                                            </div>
                                            <button type="button"
                                                class="btn btn-icon icon-left btn-danger remove-lkps ml-2"
                                                style="display: none;"><i class="fa fa-trash"></i></button>
                                            <button type="button" class="btn btn-primary ml-2 add-lkps"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="formActionEditKriteria">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="deletedLkps" name="deleted_lkps[]">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Butir</label>
                            <input type="text" class="form-control" name="butir" id="editButir">
                        </div>
                        <div class="form-group">
                            <label>Kriteria</label>
                            <input type="text" class="form-control" name="kriteria" id="editKriteria">
                        </div>
                        <div class="form-group">
                            <label>List Tabel LKPS</label>
                            <div id="editLkpsContainer"></div>
                            <button class="btn btn-success" type="button" onclick="addLkpsEdit()">Add LKPS</button>
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


    {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="formActionEditKriteria">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="formEditKriteria">
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-lkps').forEach(function(button) {
                button.addEventListener('click', addLkpsRow);
            });

            function addLkpsRow() {
                const lkpsWrapper = document.getElementById('lkps-wrapper');
                const index = lkpsWrapper.querySelectorAll('.lkps-item').length;
                const newItem = document.createElement('div');
                newItem.className = 'lkps-item d-flex align-items-center';
                newItem.innerHTML = `
                    <div class="form-group flex-grow-1">
                        <label>Nama Tabel LKPS</label>
                        <input type="text" class="form-control" name="lkps[${index}][nama_tabel_lkps]" placeholder="contoh: Tabel 1 Kerjasama Tridharma Perguruan Tinggi - Pendidikan">
                    </div>
                    <button type="button" class="btn btn-icon icon-left btn-danger remove-lkps ml-2"><i class="fa fa-trash"></i></button>
                    <button type="button" class="btn btn-primary ml-2 add-lkps"><i class="fas fa-plus"></i></button>`;
                lkpsWrapper.appendChild(newItem);

                newItem.querySelector('.remove-lkps').addEventListener('click', function() {
                    lkpsWrapper.removeChild(newItem);
                });

                newItem.querySelector('.add-lkps').addEventListener('click', addLkpsRow);

                // Show remove button for all items except the first one
                lkpsWrapper.querySelectorAll('.lkps-item').forEach(function(item, idx) {
                    const removeButton = item.querySelector('.remove-lkps');
                    removeButton.style.display = idx > 0 ? 'inline-block' : 'none';
                });
            }
            // Hide the initial remove button
            const initialRemoveButton = document.querySelector('.lkps-item .remove-lkps');
            if (initialRemoveButton) {
                initialRemoveButton.style.display = 'none';
            }
        });

        $(function() {
            $('#kriteriaTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('UPPS.matriks-penilaian.kriteria.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'butir',
                        name: 'butir'
                    },
                    {
                        data: 'kriteria',
                        name: 'kriteria'
                    },
                    {
                        data: 'listLkpsNames',
                        name: 'listLkpsNames',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });

        let lkpsEditIndex = 0;

        function addLkpsEdit() {
            lkpsEditIndex++;
            $('#editLkpsContainer').append(`
        <div class="input-group mb-3" id="edit-lkps-${lkpsEditIndex}">
            <input type="hidden" name="lkps[${lkpsEditIndex}][id]" value="">
            <input type="text" class="form-control" name="lkps[${lkpsEditIndex}][nama_tabel_lkps]" required>
            <div class="input-group-append">
                <button class="btn btn-danger" type="button" onclick="removeLkpsEdit(${lkpsEditIndex})">Remove</button>
            </div>
        </div>
    `);
        }

        function removeLkpsEdit(index) {
            let id = $(`#edit-lkps-${index} input[name^='lkps[${index}][id]']`).val();

            if (id) {
                // Tambahkan ID yang akan dihapus ke hidden field yang akan dikirim ke server
                $('#deletedLkps').append(`<input type="hidden" name="deleted_lkps[]" value="${id}">`);
            }

            $(`#edit-lkps-${index}`).remove();
        }

        // Saat mengisi form edit dengan data
        $("body").on('click', ".btn-edit", function() {
            let url = $(this).data("url");
            $("#formActionEditKriteria").attr("action", url);

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $('#editButir').val(response.kriteria.butir);
                    $('#editKriteria').val(response.kriteria.kriteria);
                    $('#editLkpsContainer').empty();
                    $('#deletedLkps').empty();

                    // Mengisi item yang ada
                    response.listLkps.forEach((lkps, index) => {
                        $('#editLkpsContainer').append(`
                        <div class="input-group mb-3" id="edit-lkps-${index}">
                            <input type="hidden" name="lkps[${index}][id]" value="${lkps.id}">
                            <input type="text" class="form-control" name="lkps[${index}][nama_tabel_lkps]" value="${lkps.nama}" required>
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" onclick="removeLkpsEdit(${index})">Remove</button>
                            </div>
                        </div>
                    `);
                        lkpsEditIndex = Math.max(lkpsEditIndex, index);
                    });
                }
            });
        });


        // $("body").on('click', ".btn-edit", function() {
        //     let url = $(this).data("url");
        //     $("#formActionEditKriteria").attr("action", url);

        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function(response) {
        //             $('#editButir').val(response.kriteria.butir);
        //             $('#editKriteria').val(response.kriteria.kriteria);
        //             $('#editLkpsContainer').empty();

        //             response.listLkps.forEach((lkps, index) => {
        //                 $('#editLkpsContainer').append(`
    //             <div class="input-group mb-3" id="edit-lkps-${index}">
    //                 <input type="hidden" name="lkps[${index}][id]" value="${lkps.id}">
    //                 <input type="text" class="form-control" name="lkps[${index}][nama_tabel_lkps]" value="${lkps.nama}" required>
    //                 <div class="input-group-append">
    //                     <button class="btn btn-danger" type="button" onclick="removeLkpsEdit(${index})">Remove</button>
    //                 </div>
    //             </div>
    //         `);
        //             });
        //         }
        //     });
        // });



        // $("body").on('click', ".btn-edit", function() {
        //     let url = $(this).data("url") + "/edit"
        //     $("#formActionEditKriteria").attr("action", $(this).data("url"))
        //     $.ajax({
        //         url: url,
        //         type: "get",
        //         success: function(data) {
        //             $("#formEditKriteria").html(data)
        //         }
        //     })
        // })


        $("body").on('click', '#delete', function(e) {
            let id = $(this).data('id')
            let route = $(this).data('route')
            swal({
                title: 'Konfirmasi hapus data  Kriteria?',
                html: `Data Kriteria akan dihapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                console.log(willDelete);
                if (willDelete) {
                    const response = $.ajax({
                        url: route,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
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
                        text: "Kriteria berhasil dihapus",
                        icon: 'success',
                    }).then((response) => {

                        window.location.reload()
                    })
                }

            })
        })
    </script>
    <footer class="main-footer">
        @include('footer')
        <div class="footer-right">
        </div>
    </footer>
    </div>

</body>

</html>

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
                        <h1>Dokumen Data Dukung</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-prodi') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Data Dukung {{ $program_studi->jenjang->jenjang }}
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
                            Dokumen Data Dukung {{ $kriteria->kriteria }} jenjang
                            {{ $program_studi->jenjang->jenjang }} lingkup Teknik
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sub kriteria</th>
                                                <th class="text-center">Nama File</th>
                                                <th class="text-center">Aksi</th>
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
                                                        @if ($item->data_dukung->isEmpty())
                                                            Belum ada
                                                        @else
                                                            <ul>
                                                                @foreach ($item->data_dukung as $file)
                                                                    <li>
                                                                        <a href="{{ Storage::url($file->file) }}"
                                                                            target="_blank">{{ basename($file->nama) }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->data_dukung->isEmpty())
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
                                                                    <input type="file" name="file[]" multiple
                                                                        required class="form-control-file"
                                                                        accept=".pdf">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-primary ml-2">
                                                                        Upload
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-md btn-outline-warning"
                                                                data-toggle="modal" data-target="#editModal"
                                                                data-id="{{ $item->id }}">
                                                                Edit
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- {{$year}} --}}
                            {{-- <div class="card-body">
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
                            </div> --}}

                        </div>
                    </div>
                </section>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Dokumen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('prodi.data-dukung.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="matriks_penilaian_id" id="matriks_penilaian_id">
                                <input type="hidden" name="sub_kriteria_id" id="sub_kriteria_id">
                                <input type="hidden" name="kriteria_id" id="kriteria_id">
                                <input type="hidden" name="program_studi_id" id="program_studi_id">
                                <input type="hidden" name="tahun_id" id="tahun_id">

                                <div id="existing-files" class="p-3">
                                    <!-- Existing files will be listed here -->
                                </div>

                                <div class="form-group d-flex align-items-center p-3">
                                    <label for="new_files">Tambah Dokumen:</label>
                                    <input type="file" name="new_files[]" id="new_files" multiple
                                        class="form-control-file" accept=".pdf">
                                </div>

                                <div class="modal-footer bg-whitesmoke br">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="main-footer">
                @include('footer')

                <div class="footer-right">
                </div>
            </footer>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    $('#editModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Tombol yang memicu modal
                        var id = button.data('id'); // Ambil ID dari data-id atribut
                        var modal = $(this);

                        // Set ID pada form
                        modal.find('#matriks_penilaian_id').val(id);
                        modal.find('#sub_kriteria_id').val(button.data('sub-kriteria-id'));
                        modal.find('#kriteria_id').val(button.data('kriteria-id'));
                        modal.find('#program_studi_id').val(button.data('program-studi-id'));
                        modal.find('#tahun_id').val(button.data('tahun-id'));

                        // Ambil dokumen yang sudah ada
                        $.ajax({
                            url: '{{ route('prodi.data-dukung.fetch', ['id' => '__ID__']) }}'.replace(
                                '__ID__', id),
                            method: 'GET',
                            success: function(data) {
                                var existingFilesDiv = modal.find('#existing-files');
                                existingFilesDiv.empty();

                                data.files.forEach(function(file) {
                                    existingFilesDiv.append(
                                        `<div class="d-flex align-items-center mb-2">
                                            <a href="${file.url}" target="_blank">${file.name}</a>
                                            <form action="{{ route('prodi.data-dukung.delete') }}" method="post" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="file_id" value="${file.id}">
                                                <button type="submit" class="btn btn-sm btn-danger ml-3" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>`
                                    );
                                });
                            }
                        });
                    });
                });
            </script>
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

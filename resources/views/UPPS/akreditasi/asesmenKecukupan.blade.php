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
                        {{-- <div class="section-header-back">
                            <a href="{{ route('dashboard-UPPS') }}" class="btn btn-icon"><i class="fa fa-arrow-left"></i></a>
                        </div> --}}
                        <h1>Akreditasi Program Studi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Akreditasi</div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('akreditasi.index') }}"><i class="fas fa-circle"></i>
                                                Dokumen Ajuan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('akreditasi.asesmenKecukupan') }}"><i class="fas fa-regular fa-circle"></i>
                                                Asesmen Kecukupan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><i class="fas fa-circle"></i> Asesmen
                                                Lapangan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><i class="fas  fa-solid fa-check"></i>
                                                Selesai</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- selesai (perprodi) --}}
                        {{-- <div class="row ">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Jump To</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item"><a href="#" class="nav-link active">All
                                                    Progress</a>
                                            </li>
                                            <li class="nav-item"><a href="#" class="nav-link">Pengajuan
                                                    Dokumen</a></li>
                                            <li class="nav-item"><a href="#" class="nav-link">Asesmen
                                                    Kecukupan</a></li>
                                            <li class="nav-item"><a href="#" class="nav-link">Asesmen Lapangan</a>
                                            </li>
                                            <li class="nav-item"><a href="#" class="nav-link">Berita Acara</a>
                                            </li>
                                            <li class="nav-item"><a href="#" class="nav-link">Sertifikat</a></li>
                                            <li class="nav-item"><a href="#" class="nav-link">Selesai</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form id="setting-form">
                                    <div class="card" id="settings-card">
                                        <div class="card-header">
                                            <h4>General Settings</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted">General settings such as, site title, site
                                                description, address and so on.</p>
                                            <div class="form-group row align-items-center">
                                                <label for="site-title"
                                                    class="form-control-label col-sm-3 text-md-right">Site Title</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <input type="text" name="site_title" class="form-control"
                                                        id="site-title">
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label for="site-description"
                                                    class="form-control-label col-sm-3 text-md-right">Site
                                                    Description</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <textarea class="form-control" name="site_description" id="site-description"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="form-control-label col-sm-3 text-md-right">Site
                                                    Logo</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <div class="custom-file">
                                                        <input type="file" name="site_logo" class="custom-file-input"
                                                            id="site-logo">
                                                        <label class="custom-file-label">Choose File</label>
                                                    </div>
                                                    <div class="form-text text-muted">The image must have a maximum size
                                                        of 1MB</div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <div class="custom-file">
                                                        <input type="file" name="site_favicon"
                                                            class="custom-file-input" id="site-favicon">
                                                        <label class="custom-file-label">Choose File</label>
                                                    </div>
                                                    <div class="form-text text-muted">The image must have a maximum
                                                        size
                                                        of 1MB</div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="form-control-label col-sm-3 mt-3 text-md-right">Google
                                                    Analytics Code</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <textarea class="form-control codeeditor" name="google_analytics_code"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-whitesmoke text-md-right">
                                            <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                            <button class="btn btn-secondary" type="button">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> --}}

                        <div class="row ">
                            <div class="col-12">
                                <form id="setting-form">
                                    {{-- <div class="card" id="settings-card">
                                        <div class="card-header">
                                            <h4>General Settings</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted">General settings such as, site title, site
                                                description, address and so on.</p>
                                            <div class="form-group row align-items-center">
                                                <label for="site-title"
                                                    class="form-control-label col-sm-3 text-md-right">Site Title</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <input type="text" name="site_title" class="form-control"
                                                        id="site-title">
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label for="site-description"
                                                    class="form-control-label col-sm-3 text-md-right">Site
                                                    Description</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <textarea class="form-control" name="site_description" id="site-description"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="form-control-label col-sm-3 text-md-right">Site
                                                    Logo</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <div class="custom-file">
                                                        <input type="file" name="site_logo" class="custom-file-input"
                                                            id="site-logo">
                                                        <label class="custom-file-label">Choose File</label>
                                                    </div>
                                                    <div class="form-text text-muted">The image must have a maximum size
                                                        of 1MB</div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <div class="custom-file">
                                                        <input type="file" name="site_favicon"
                                                            class="custom-file-input" id="site-favicon">
                                                        <label class="custom-file-label">Choose File</label>
                                                    </div>
                                                    <div class="form-text text-muted">The image must have a maximum
                                                        size
                                                        of 1MB</div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="form-control-label col-sm-3 mt-3 text-md-right">Google
                                                    Analytics Code</label>
                                                <div class="col-sm-6 col-md-9">
                                                    <textarea class="form-control codeeditor" name="google_analytics_code"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-whitesmoke text-md-right">
                                            <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                            <button class="btn btn-secondary" type="button">Reset</button>
                                        </div>

                                    </div> --}}
                                    {{-- @foreach ($user_prodi as $item_tahun) --}}
                                    <div class="card">
                                        <div class="card-header" style="border-bottom-width: 0px;padding-bottom: 0px;">
                                            <h4></h4>
                                            <div class="card-header-action">
                                                <a href="#" data-toggle="modal" data-target="#modalTambahJadwal"
                                                    class="btn btn-outline-primary btn-create mb-2"
                                                    style="border-radius: 30px;"><i class="fas fa-user-plus"></i>
                                                    Tambah Akreditasi</a>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-top: 0px;">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">D3 Teknik Mesin | 2024 </th>
                                                            <th class="text-center">Nama File</th>
                                                            <th class="text-center">
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">Dokumen LKPS</td>
                                                            <td class="text-center">
                                                                Belum ada file yang diupload
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-secondary">Approve</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">Dokumen LED</td>
                                                            <td class="text-center">
                                                                Belum ada file yang diupload
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-secondary">Approve</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @endforeach --}}
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
                        <form action="{{ route('UPPS.timeline.store') }}" method="post" enctype="multipart/form-data"
                            id="formTambah">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Kegiatan</label>
                                        <input type="text" class="form-control" name="nama_kegiatan" required="">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>Program Studi</label>
                                            <select id="program_studi" class="form-control selectric"
                                                name="program_studi_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($program_studi as $prodi)
                                                    <option value="{{ $prodi->id }}"> {{ $prodi->jenjang->jenjang }}
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
    </script>

</body>

</html>

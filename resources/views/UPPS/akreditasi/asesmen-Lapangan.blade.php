<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>UPPS | Akreditasi Program Studi</title>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('akreditasi.index') }}"><i
                                                    class="fas fa-circle"></i>
                                                Dokumen Ajuan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('akreditasi.asesmenKecukupan') }}"><i
                                                    class="fas fa-regular fa-circle"></i>
                                                Asesmen Kecukupan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active"
                                                href="{{ route('akreditasi.asesmenLapangan') }}"><i
                                                    class="fas fa-circle"></i> Asesmen Lapangan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('akreditasi.selesai') }}"><i
                                                    class="fas  fa-solid fa-check"></i>
                                                Selesai</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" id="settings-card">
                                    {{-- <div class="card-header">
                                        <h4>Data Elemen Penilaian Desk Evaluasi</h4>
                                    </div> --}}
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="asesmenLapanganTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tahun</th>
                                                        <th>Program Studi</th>
                                                        <th>Nilai Akhir</th>
                                                        <th>Berita Acara</th>
                                                        <th>Saran & Rekomendasi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="card-footer bg-whitesmoke text-md-right">
                                        <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                        <button class="btn btn-secondary" type="button">Reset</button>
                                    </div> --}}
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
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve dan Buatkan Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="approveForm" action="" method="POST">
                        @csrf
                        <input type="hidden" id="docId" name="id" value="">
                        <input type="hidden" id="docProdi" name="prodi" value="">
                        <input type="hidden" id="docThn" name="thn" value="">
                        <div class="form-group">
                            <label for="kegiatan">Tahap Kegiatan Selanjutnya</label>
                            <input type="text" class="form-control" id="kegiatan" placeholder="Asesmen Lapangan"
                                name="kegiatan" required="" disabled="">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggalMulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                                    required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggalAkhir">Batas Waktu</label>
                                <input type="date" class="form-control" id="tanggalAkhir" name="tanggal_akhir"
                                    required="">
                            </div>
                        </div>
                        <div class="text-right mt-3 mb-4" style="background-color:rgba(0, 0, 0, 0); border-top:none;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary">Approve</button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disapproveModal" tabindex="-1" role="dialog"
        aria-labelledby="disapproveModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disapproveModalLabel">Disapprove Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="disapproveForm" action="" method="POST">
                        @csrf
                        <input type="hidden" id="docId" name="id" value="">
                        <input type="hidden" id="docType" name="type" value="">
                        <div class="form-group">
                            <label for="keterangan">Keterangan Disapprove</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Submit Disapprove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#asesmenLapanganTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('Upps.asesmen-lapangan.json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'nilai_akhir',
                        name: 'nilai_akhir'
                    },
                    {
                        data: 'berita_acara',
                        name: 'berita_acara'
                    },
                    {
                        data: 'saran_rekomendasi',
                        name: 'saran_rekomendasi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            })
        })

        $(document).ready(function() {
            $("body").on('click', '.approve-btn', function() {
                let id = $(this).data('id');
                let route = $(this).data('route');

                swal({
                    title: 'Selesaikan?',
                    html: 'Apakah Anda yakin ingin menyelesaikan asesmen ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oke!',
                    cancelButtonText: 'Batal',
                    buttons: true,
                    dangerMode: true,
                }).then((willSelesaikan) => {
                    console.log(willSelesaikan);
                    if (willSelesaikan) {
                        $.ajax({
                            url: route,
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                            }
                        }).done(function(response) {
                            swal({
                                title: 'Berhasil!',
                                text: "Asesmen berhasil diselesaikan, Silahkan lihat ditahap selanjutnya!",
                                icon: 'success',
                            }).then(() => {
                                window.location.reload();
                            });
                        }).fail(function() {
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: 'Server Error',
                                icon: 'error'
                            });
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            // Event handler untuk tombol disapprove
            $('body').on('click', '.disapprove-btn', function() {
                let id = $(this).data('id');
                let route = $(this).data('route');

                // Atur form action dan input values
                $('#disapproveForm').attr('action', route);
                $('#docId').val(id);

                // Tampilkan modal
                $('#disapproveModal').modal('show');
            });
        });
    </script>

</body>

</html>

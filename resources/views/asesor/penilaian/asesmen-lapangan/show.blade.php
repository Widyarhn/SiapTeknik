<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> Asesor | Asesmen Lapangan &rsaquo; {{ $kriteria->butir }} {{ $kriteria->kriteria }}</title>
    @include('body')

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('asesor.layout.header')

            <div class="main-sidebar sidebar-style-2">
                @include('asesor.layout.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <div class="section-header-back">
                            <a href="{{ route('nilai-asesmenlapangan.elemen', $program_studi->id) }}"
                                class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Penilaian Asesmen Lapangan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-asesor') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">AL {{ $program_studi->jenjang->jenjang }}
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
                            Penilaian {{ $kriteria->kriteria }} Jenjang {{ $program_studi->jenjang->jenjang }} Lingkup
                            Teknik POLINDRA
                        </p>

                        {{-- <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="{{ route('nilai-asesmenlapangan.elemen', $program_studi->id) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fa fa-chevron-left"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>{{ $kriteria->butir }}. {{ $kriteria->kriteria }}</h4>
                                    </div>
                                    <div class="col-md-4">
                                        {{-- <div class="form-group">
                                            <select id="searchByGolongan" class="form-control selectric">
                                                <option value="0">-- Lihat Semua --</option>
                                                @foreach ($golongan as $k)
                                                    <option value="{{ $k->id }}"
                                                        {{ request()->has('golongan') && request()->golongan == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        @forelse ($matriks as $m)
                            @if (!empty($m) && !empty($m->indikator->sangat_baik))
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ $user_asesor->tahun->tahun }}</th>
                                                                <td>
                                                                    {{-- <h6>
                                                                        {{ $m->no_butir }}

                                                                        {{ $m->sub_kriteria }}
                                                                    </h6> --}}
                                                                    <h6>
                                                                        @if (!empty($m->sub_kriteria->sub_kriteria))
                                                                            {{ $m->sub_kriteria->sub_kriteria }}
                                                                        @else
                                                                        @endif
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>4</th>
                                                                <td>
                                                                    {{ $m->indikator->sangat_baik }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>3</th>
                                                                <td>
                                                                    {{ $m->indikator->baik }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>2</th>
                                                                <td>
                                                                    {{ $m->indikator->cukup }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>1</th>
                                                                <td>
                                                                    {{ $m->indikator->kurang }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>0</th>
                                                                <td>
                                                                    {{ $m->indikator->sangat_kurang }}
                                                                </td>
                                                            </tr>
                                                            {{-- <tr>
                                                                <th>
                                                                    <div class="badge badge-primary"> File data
                                                                        dukung </div>
                                                                </th>
                                                                @if ($m->data)
                                                                    <td><a href="{{ url('storage/data_dukung/', $m->data->file) }}"
                                                                            target="_blank">{{ $m->data->file }}</a>
                                                                    </td>
                                                                @else
                                                                    <th> Belum ada file yang diupload</th>
                                                                @endif
                                                            </tr> --}}
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Deskripsi</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if (!empty($m->indikator->no_butir))
                                                                    {{ $m->indikator->no_butir }}
                                                                    {{ $m->indikator->deskriptor }}
                                                                @else
                                                                    {{ $m->indikator->deskriptor }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if (!empty($m->asesmen_lapangan))
                                                            <form
                                                                action="{{ route('nilai-asesmenlapangan.update', $m->asesmen_lapangan->id) }}"
                                                                method="post" enctype="multipart/form-data"
                                                                id="formActionUpdate">
                                                                @csrf
                                                                @method('POST')
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Nilai</div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            value="{{ $m->id }}"
                                                                            name="m_id" />
                                                                        <input type="hidden"
                                                                            value="{{ $user_asesor->id }}"
                                                                            name="user_asesor_id" />
                                                                        <input type="hidden"
                                                                            value="{{ $user_asesor->timeline->id }}"
                                                                            name="timeline_id" />

                                                                        <input type="text" placeholder="1-4"
                                                                            name="nilai"
                                                                            value="{{ $m->asesmen_lapangan->nilai }}"
                                                                            class="form-control text-center"  @if ($m->anotasi_label) disabled @endif id="{{ $m->indikator->no_butir }}"/>
                                                                            @if ($m->anotasi_label)
                                                                            <input type="hidden" name="nilai" value="{{ $m->asesmen_kecukupan->nilai }} "id="{{ $m->indikator->no_butir }}">
                                                                            @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Deskripsi Nilai
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea name="deskripsi" class="form-control">{{ $m->asesmen_lapangan->deskripsi }}</textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-grid col-md-6 mt-2">
                                                                            <div class="btn-group">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning">Edit</button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('nilai-asesmenlapangan.store') }}"
                                                                method="post" enctype="multipart/form-data"
                                                                id="formActionStore">
                                                                @csrf
                                                                @method('POST')
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Nilai</div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            value="{{ $m->id }}"
                                                                            name="m_id" />
                                                                        <input type="hidden"
                                                                            value="{{ $user_asesor->id }}"
                                                                            name="user_asesor_id" />
                                                                        <input type="hidden"
                                                                            value="{{ $user_asesor->timeline->id }}"
                                                                            name="timeline_id" />

                                                                        <input type="text" placeholder="1-4"
                                                                            name="nilai"
                                                                            value="{{ $m->asesmen_kecukupan->nilai ?? '' }}"
                                                                            class="form-control text-center"
                                                                            @if ($m->anotasi_label) disabled @endif id="{{ $m->indikator->no_butir }}">
                                                                            @if ($m->anotasi_label)
                                                                            <input type="hidden" name="nilai" value="{{ $m->asesmen_kecukupan->nilai }}" id="{{ $m->indikator->no_butir }}">
                                                                            @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        <div class="badge badge-primary">Deskripsi Nilai
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea name="deskripsi" class="form-control">{{ $m->asesmen_kecukupan->deskripsi ?? '' }}</textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-grid col-md-6 mt-2">
                                                                            <div class="btn-group">
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-primary">Tambahkan</button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        @endif


                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Matriks penilaian tidak lengkap atau belum ada indikator sangat baik.
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-info">
                                Belum ada matriks penilaian.
                            </div>
                        @endforelse

                        @if ($matriks->isNotEmpty())
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="modal-footer bg-whitesmoke br">
                                                <div>
                                                    <a href="{{ route('asesor.penilaian.asesmen-kecukupan.elemen', $program_studi->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-chevron-left"></i>
                                                        Kembali</a>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
@php
        // Periksa apakah $matriks tidak kosong
        if (!empty($matriks) && isset($matriks[0])) {
            $kriteriaId = $matriks[0]->kriteria_id;
        } else {
            // Tangani kasus di mana $matriks kosong
            $kriteriaId = null;
        }
    @endphp
    <script>
        var matriks = @json($matriks);

        $(document).ready(function() {
            $('#btn-save').click(function(e) {
                e.preventDefault();
                var data = {};

                // Kelompokkan data berdasarkan rumus_id
                $.each(matriks, function(index, matrik) {
                    var noButir = matrik.indikator.no_butir;
                    var rumus_id = matrik.indikator.rumus_id;
                    var nilai = matrik.asesmen_lapangan ? matrik.asesmen_lapangan.nilai : null;

                    // Cek jika noButir tidak null atau tidak undefined
                    if (noButir !== null && noButir !== undefined) {
                        var key = noButir.replace('.', '');

                        // Inisialisasi array untuk rumus_id jika belum ada
                        if (!data[rumus_id]) {
                            data[rumus_id] = {};
                        }

                        // Simpan nilai berdasarkan key
                        data[rumus_id][key] = nilai;
                    }
                });

                console.log('Data yang dikirim:', data); // Log data sebelum dikirim

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                @if ($kriteriaId)
                    $.ajax({
                        url: `{{ route('asesmen-lapangan.calculate', $kriteriaId) }}`,
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            console.log('Response dari server:', response);
                            swal({
                                title: 'Berhasil!',
                                text: "Data berhasil disimpan.",
                                icon: 'success',
                            }).then(() => {
                                // Tindakan setelah berhasil
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Terjadi kesalahan:', textStatus, errorThrown);
                        }
                    });
                @else
                    console.error('Matriks kosong atau tidak valid.');
                @endif

            });
        });
    </script>
</head>

</html>

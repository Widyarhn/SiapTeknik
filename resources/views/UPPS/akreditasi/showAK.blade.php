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
                        <div class="section-header-back">
                            <a href="{{ url('akreditasi.asesmenKecukupan') }}" class="btn btn-icon"><i
                                    class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Desk Evaluasi D3 Teknik Mesin</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('dashboard-UPPS') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item">Desk Evaluasi</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">A. Kondisi Eksternal</h2>
                        <p class="section-lead">
                            Hasil penilaian kondisi eksternal jenjang D3 lingkup teknik oleh Ketua Asesor
                        </p>

                        <div class="card">
                            <div class="card-header d-block pb-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>2024</th>
                                                                            <td>
                                                                                <h6>
                                                                                    A. Kondisi Eksternal
                                                                                </h6>
                                                                            </td>
                                                                        <tr>
                                                                            <th>4</th>
                                                                            <td>
                                                                                ahsa
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>3</th>
                                                                            <td>
                                                                                jsdkgnj
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>2</th>
                                                                            <td>
                                                                                dsnjgdsk
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>1</th>
                                                                            <td>
                                                                                snjgkdsgn
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>
                                                                                <div class="badge badge-primary"> File
                                                                                    data dukung </div>
                                                                            </th>
                                                                            <td><a href="">Data dukung
                                                                                    kondisi</a></td>
                                                                        </tr>
                                                                        <form
                                                                            action=""
                                                                            method="post" enctype="multipart/form-data"
                                                                            id="formActionStore">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <tr>
                                                                                <th>
                                                                                    <div class="badge badge-primary">
                                                                                        Nilai </div>
                                                                                </th>
                                                                                {{-- @if (count($data->desk_evaluasi) > 0) --}}
                                                                                    <td>
                                                                                        <input type="hidden"
                                                                                            id="" />
                                                                                        <input type="text"
                                                                                            placeholder="1-4"
                                                                                            name="nilai"
                                                                                            value=""
                                                                                            class="form-control text-center">
                                                                                        <input type="hidden"
                                                                                            value=""
                                                                                            name="program_studi_id" />
                                                                                        <input type="hidden"
                                                                                            value="1"
                                                                                            name="jenjang_id" />
                                                                                        <input type="hidden"
                                                                                            value=""
                                                                                            name="matriks_penilaian_id" />
                                                                                    </td>
                                                                            </tr>
                                                                        </form>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered">
                                                                    <tr>
                                                                        <th>Deskripsi</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Deskripsi
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="badge badge-primary"> Deskripsi
                                                                                Nilai
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                            <td>
                                                                                <textarea name="deskripsi" class="form-control">
                                                                                deskripsi
                                                                            </textarea>

                                                                            </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                                <div class="row">
                                                                    <div class="d-grid col-md-6 mt-2">
                                                                        <div class="btn-group">
                                                                            <button type=""
                                                                                class="btn btn-outline-warning">
                                                                                Edit Nilai dan Deskripsi Nilai
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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

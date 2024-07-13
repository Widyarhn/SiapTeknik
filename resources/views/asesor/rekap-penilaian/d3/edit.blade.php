        <div class="card">
            <form class="needs-validation" novalidate="">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nama Asesor</label>
                        <input type="text" class="form-control" name="nama_asesor" value="{{$keterangan->nama_asesor}}" required="">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-1">
                            <label class="form-label">Tanggal Batas</label>
                            <input type="date" name="tanggal_batas"  value="{{$keterangan->tanggal_batas}}"  class="form-control" >
                        </div>
                        <div class="col-6 mb-1">
                            <label class="form-label">Tanggal Penilaian</label>
                            <input type="date" name="tanggal_penilaian" value="{{$keterangan->tanggal_penilaian}}"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Perguruan Tinggi</label>
                        <input type="text" value="Politeknik Negeri Indramayu" readonly class="form-control"  name="perguruan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" value="Teknik Informatika" readonly  name="jurusan">
                    </div>
                    <div class="row">
                        <div class="col-4 mb-1">
                            <label class="form-label">Jenjang</label>
                            <input type="text" class="form-control" placeholder="D3" readonly>
                            </select>
                        </div>
                        <div class="col-8 mb-1">
                            <label class="form-label">Prodi</label>
                            <input type="text" class="form-control" placeholder="Teknik Informatika" readonly>
                            <input type="hidden" class="form-control" value="1" name="program_studi_id">
                        </div>
                    </div>

            </form>
        </div>


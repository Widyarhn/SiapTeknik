<div class="card">
    <form class="needs-validation" novalidate="">
        <div class="card-body">
            <input type="hidden" name="program_studi_id">
            <div class="form-group">
                <label>Elemen Penilaian</label>
                <select id="kriteria" class="form-control selectric" name="kriteria_id">
                    <option value="">-- Pilih --</option>
                    @foreach ($kriteria as $kriteria )
                    <option @if ($kriteria->id == $data_dukung->kriteria_id) selected  @endif  value="{{ $kriteria->id }}">{{$kriteria->butir}} {{ $kriteria->kriteria }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>PPP</label>
                <select id="golongan" class="form-control selectric" name="golongan_id">
                    <option value="">-- Pilih Jika Ada--</option>
                    @foreach ($golongan as $golongan )
                    <option @if ($golongan->id == $data_dukung->golongan_id) selected  @endif value="{{ $golongan->id }}">{{$golongan->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Dokumen</label>
                <input type="text" class="form-control" value="{{$data_dukung->nama_file}}" name="nama_file" required="">
            </div>
            <div class="form-group">
                <label>File</label>
                <input type="file" class="form-control" name="file" required="">
                <input type="hidden" class="form-control" name="jenjang_id" value="1" required="">
            </div>

    </form>
</div>
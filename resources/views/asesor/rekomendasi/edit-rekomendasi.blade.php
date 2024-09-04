<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="kegiatan">Kriteria</label>
            <select id="kriteria_id" class="form-control selectric" name="kriteria_id">
                @foreach ($kriteria as $k)
                    <option @if ($k->id == $rekomendasi->kriteria_id) selected @endif value="{{ $k->id }}">
                        {{ $k->kriteria }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Apresiasi/Komendasi</label>
            <textarea class="form-control" name="komendasi">{{ $rekomendasi->komendasi }}</textarea>
        </div>
        <div class="form-group">
            <label>Rekomendasi</label>
            <textarea class="form-control" name="rekomendasi">{{ $rekomendasi->rekomendasi }}</textarea>
        </div>
    
        <!-- Hidden fields for user_prodi -->
        <input type="hidden" name="tahun_id" value="{{ $rekomendasi->tahun_id }}">
        <input type="hidden" name="program_studi_id"
            value="{{ $rekomendasi->program_studi_id }}">
    </div>
</div>

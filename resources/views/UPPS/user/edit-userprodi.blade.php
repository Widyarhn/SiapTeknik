<div class="card">
    <form class="needs-validation" novalidate="">
        <div class="card-body">
            <div class="form-group">
                <label>Nama User</label>
                <select id="user" class="form-control selectric" name="user_id">
                    <option value="">-- Pilih --</option>
                    @foreach ($user as $user )
                    <option @if ($user->id == $user_prodi->user_id) selected @endif value="{{ $user->id }}">{{ $user->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" class="form-control" value="{{$user_prodi->program_studi->nama}}" readonly>
            </div>
            <div class="form-group">
                <label>Tahun Akreditasi</label>
                <select id="tahun" class="form-control selectric" name="tahun_id">
                    @foreach ($tahun as $tahun )
                    <option @if ($tahun->id == $user_prodi->tahun_id) selected @endif value="{{ $tahun->id }}">{{ $tahun->tahun}}</option>
                    @endforeach
                </select>
            </div>
    </form>
</div>
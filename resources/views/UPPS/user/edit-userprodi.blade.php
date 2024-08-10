<div class="card-body">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label>Nama User</label>
            <select id="user" class="form-control selectric" name="user_id">
                <option value="">-- Pilih --</option>
                @foreach ($user as $user)
                    <option @if ($user->id == $user_prodi->user_id) selected @endif value="{{ $user->id }}">
                        {{ $user->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label>Email</label>
            <input type="email" class="form-control" id="email"
            name="email" value="{{ $user->email }}" readonly>
        </div>
    </div>

    <div class="form-group">
        <label>Program Studi</label>
        <select id="program_studi" class="form-control selectric" name="program_studi_id">
            @foreach ($program_studi as $prodi)
                <option @if ($prodi->id == $user_prodi->program_studi_id) selected @endif value="{{ $prodi->id }}">
                    {{ $prodi->jenjang->jenjang }} {{ $prodi->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

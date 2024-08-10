<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ $user->nama }}" required="">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required="">
            <input type="hidden" class="form-control" name="password" value="{{ $user->password }}">
        </div>
        <div class="form-group">
            <label>Level</label>
            <select id="level" class="form-control selectric" name="role_id">
                @foreach ($roles as $role)
                    <option @if ($role->id == $user->role_id) selected @endif value="{{ $role->id }}">
                        {{ $role->role }}</option>
                @endforeach
            </select>

        </div>
    </div>
</div>

<div class="card">
    <form class="needs-validation" novalidate="">
        <div class="card-body">
            <div class="form-group">
                <label>Nama Program Studi</label>
                <input type="text" class="form-control" value="{{$program_studi->nama}}" name="nama" required="">
            </div>
            <div class="form-group">
                <label>Jenjang</label>
                <select id="jenjang_id" class="form-control selectric" name="jenjang_id">
                    <option value="">-- Pilih --</option>
                    @foreach ($jenjang as $j )
                    <option @if ($j->id == $program_studi->jenjang_id) selected  @endif value="{{ $j->id }}">{{ $j->jenjang }}</option>
                    @endforeach
                </select>
            </div>
    </form>
</div>
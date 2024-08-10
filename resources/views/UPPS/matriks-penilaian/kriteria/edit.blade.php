<div class="card">
    <form class="needs-validation" novalidate="">
        <div class="card-body">
            <div class="form-group">
                <label>Butir</label>
                <input type="text" class="form-control" name="butir" value="{{ $kriteria->butir }}" required="">
            </div>
            <div class="form-group">
            <label>Kriteria</label>
                <input type="text" class="form-control" name="kriteria" value="{{ $kriteria->kriteria }}"
                    required="">
            </div>
            <div class="form-group">
                <label>List Tabel Lkps</label>
                @foreach ($listLkps as $lkps)
                    <input type="text" class="form-control" name="list_tabel_lkps" value="{{ $lkps->nama }}"
                        required="">
                @endforeach
            </div>
    </form>
</div>

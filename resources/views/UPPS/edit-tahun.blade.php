<div class="card">
    <form class="needs-validation" novalidate="">
        <div class="card-body">
            <div class="form-group">
                <label>Tahun</label>
                <input type="number" class="form-control" value="{{$tahun->tahun}}" name="tahun" required="">
            </div>
            <div class="form-group">
                <label>Mulai Akreditasi</label>
                <input type="date" class="form-control" value="{{$tahun->tanggal_awal}}" name="tanggal_awal" required="">
            </div>
            <div class="form-group">
                <label>Akhir Akeditasi</label>
                <input type="date" class="form-control" value="{{$tahun->tanggal_akhir}}" name="tanggal_akhir" required="">
            </div>
    </form>
</div>

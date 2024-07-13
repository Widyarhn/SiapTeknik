<div class="card">
    <form class="needs-validation" novalidate="">
      <div class="card-body">
        <div class="form-group">
          <label>Judul</label>
          <input type="text" class="form-control" name="judul" value="{{ $instrumen->judul }}" required="">
        </div>
        <div class="form-group">
          <label>File</label>
          <input type="file" class="form-control" name="file" value="{{ $instrumen->file }}">
        </div>
    </form>
  </div>

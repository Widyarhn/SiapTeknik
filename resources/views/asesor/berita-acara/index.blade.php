<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Berita Acara {{$user_asesor->program_studi->jenjang->jenjang}} {{$user_asesor->program_studi->nama}}</title>
<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

h2{
    text-align: center;
}

.kop-surat {
      border-bottom: 2px solid black;
      width: 100%;
      text-align: center;
      display: flex;
}

table {
  border-collapse: collapse;
  width: 100%;
}
.berita-acara {
            width: 210mm; /* Lebar A4 dalam orientasi potret */
            height: 297mm; /* Tinggi A4 dalam orientasi potret */
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            page-break-before: always; /* Mengatur pemisah halaman untuk pencetakan */
        }

th, td {
  padding: 15px;
}
.logo {
    max-width: 100px;
    height: auto;
    margin-right: 20px;
}
.footer {
    text-align: right;
    margin-top: 20px;
    font-size: 14px;
    color: #888;
    clear: both;
}



</style>
</head>
<body>
{{-- <div class="berita-acara"> --}}
  <div class="kop-surat">
    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
    POLITEKNIK NEGERI INDRAMAYU
    Jalan Raya Lohbener Lama Nomor 8 Lohbener – Indramayu 45252
    Telepon/Faximile: (0234) 5746464
    Laman: http://www.polindra.ac.id e-mail: info@polindra.ac.id    
  </div>
  @if (count($desk_evaluasi) == 0)
 <h2> BELUM MELAKUKAN DESK EVALUASI</h2>
  @else
  <h2>Berita Acara Desk Evaluasi 
    <p>Program Studi {{$user_asesor->program_studi->jenjang->jenjang}} {{$user_asesor->program_studi->nama}}</p>
  </h2>
  <p>Dari kegiatan simulasi akreditasi yang dilaksanakan pada tanggal {{ date('d-m-Y', strtotime($user_asesor->tahun->tanggal_awal)) }}
    sampai dengan {{ date('d-m-Y', strtotime($user_asesor->tahun->tanggal_akhir)) }}, tersebut diperoleh informasi butir-butir borang yang sesuai/tidak sesuai dengan kenyataan, dengan penjelasan tercantum di dalam sebagai berikut.</p>
  
  <table>
      <thead>
          <tr>
            <th width="5%">No</th>
            <th>No. Butir Penilaian</th>
            <th>Informasi dari Borang PS</th>
            <th>Bukti-bukti</th>
          </tr>
      </thead>
      <tbody>
  {{-- @php
  $counter = 1;
  @endphp
          @foreach($desk_evaluasi as $d)
          <tr>
            <td>{{ $counter }}</td>
            <td>
              @if ($d->matriks_penilaian != null)
                {{$d->matriks_penilaian->sub_kriteria}}
              @elseif ($d->suplemen != null)
                {{$d->suplemen->sub_kriteria}}
              @endif
            </td>
            <td>{{$d->deskripsi}}</td>
            @if($d->matriks_penilaian->data != null)
            <td>{{$d->matriks_penilaian->data->file}}</td>
            @else
            <td></td>
            @endif
          </tr>
          @php
  $counter++;
  @endphp
  @endforeach
      </tbody>
  </table>
  <div class="footer">
    <p>Berita acara ini dikeluarkan oleh asesor {{ auth()->user()->nama }}.</p>
</div>
  @endif --}}
{{-- </div> --}}
</body>
</html>
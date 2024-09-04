<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat {{ $user_asesor->program_studi->jenjang->jenjang }} {{ $user_asesor->program_studi->nama }}
    </title>
    <style>
        /* Ganti dengan gaya desain yang Anda inginkan */
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f5f5f5; */
            background-image: url('assets/img/sertifikat.png');
            /* Ganti dengan nama dan format gambar yang sesuai */
            background-size: cover;
            /* Sesuaikan sesuai kebutuhan */
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .sertifikat {
            text-align: center;
        }

        .header {
            font-family: Arial, sans-serif;
            font-size: 36px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 30px;
        }

        .akreditasi {
            padding: 30px;
            font-family: Arial, sans-serif;
            color: #8b99c6;
            font-size: 25px;
            font-weight: bold;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="sertifikat">
        <div class="header">
            <h2>Sertifikat Akreditasi</h2>
        </div>
        <div class="content">
            <p>
                Simulasi Akereditasi Politeknik Negeri Indramayu, tahun simulasi {{ $user_asesor->tahun->tahun }}
            </p>
            <p>
                Berdasarkan simulasi yang telah dilakukan, menyatakan bahwa :
            </p>
            <p>
                Program studi {{ $user_asesor->program_studi->jenjang->jenjang }}
                {{ $user_asesor->program_studi->nama }}
            </p>
            <p>
                Politeknik Negeri Indramayu
            </p>
        </div>
        <h2>Total Bobot: <span class="badge-info">{{ number_format($total, 2) }}</span></h2>

        <!-- Tampilkan Kategori Akreditasi -->
        <div class="akreditasi">
            @if($total <= 0)
                BELUM MELAKUKAN AKREDITASI
            @elseif ($total >= 1 && $total <= 200)
                TIDAK MEMENUHI SYARAT PERINGKAT
            @elseif($total >= 200 && $total <= 301 )
                BAIK
            @elseif($total >= 301 && $total <= 361)
                BAIK SEKALI
            @elseif($total >= 361)
                UNGGUL
            @endif
        </div>
    <div class="footer">
        <p>Sertifikat ini dikeluarkan oleh asesor {{ auth()->user()->nama }}</p>
    </div>

    </div>
</body>

</html>

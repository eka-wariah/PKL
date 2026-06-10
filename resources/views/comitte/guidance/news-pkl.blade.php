<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin-top: 2cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 2;
            color: #000;
        }

        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .intro {
            text-align: justify;
            text-indent: 40px;
            margin-bottom: 15px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .label {
            width: 40%;
            font-weight: bold;
        }

        .separator {
            width: 5%;
            font-weight: bold;
        }

        .section-title {
            margin-top: 15px;
            font-weight: bold;
        }

        .content-box {
            margin-top: 5px;
            text-align: justify;
            min-height: 40px;
        }

        .signature-table {
            width: 100%;
            margin-top: 60px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-space {
            height: 80px;
        }

        .name {
            font-weight: bold;
            text-decoration: underline;
        }
        .header-table {
    width: 100%;
    border-collapse: collapse;
    }

    .logo-left,
    .logo-right {
        width: 15%;
        text-align: center;
        vertical-align: middle;
    }

    .header-content {
        width: 70%;
        text-align: center;
        vertical-align: middle;
        line-height: 1.2;
       
    }
    /* PEMERINTAH, DINAS, YAYASAN */
.line1,
.line2 {
    font-weight: bold;
    font-size: 12pt;
}

/* NAMA SEKOLAH + AKREDITASI */
.school-name.school-name {
    font-size: 16pt;
    font-weight: bold;
}
.accreditation {
    font-weight: bold;
    font-size: 13pt;
}

/* JURUSAN */
.major {
    font-weight: bold;
    font-size: 10pt;
}

/* NPSN, NSS, ALAMAT, TELP, EMAIL */
.info,
.address {
    font-weight: bold;
    font-size: 7pt;
    margin: 0;
    padding: 0;
}
.kop-line {
    width: 100%;
    margin-top: 5px;
}

.line-1 {
    height: 1px;
    background: #000;
}

.line-2 {
    height: 3px;
    background: #000;
    margin-top: 2px;
}
.method-label {
    width: 35%;
    font-weight: bold;
    vertical-align: top;
}

.method-separator {
    width: 5%;
    font-weight: bold;
    vertical-align: top;
}

.method-content {
    vertical-align: top;
}

.method-item {
    margin-bottom: 8px;
}
.checkbox {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid #000;
    margin-right: 10px;
    vertical-align: middle;
}
    .logo-left img{
        width: 100px;
        height: auto;
    }
    .logo-right img {
        width: 125px;
        height: auto;
    }
    </style>
</head>
<body>
    <div class="letterhead">
        <table class="header-table">
            <tr>
                <td class="logo-left">
                    <img src="{{ public_path('assets/images/logos/Coat_of_arms_of_West_Java.svg.png') }}"  alt="Logo Jabar">
                </td>
    
                <td class="header-content">
                    <div class="line1">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div class="line2">DINAS PENDIDIKAN</div>
                    <div class="line2">YAYASAN MAHAPUTRA CERDAS UTAMA</div>
    
                    <div class="school-name">
                        SMKS MAHAPUTRA CERDAS UTAMA
                    </div>
    
                    <div class="accreditation">
                        AKREDITASI "A"
                    </div>
    
                    <div class="major">
                        DESAIN KOMUNIKASI VISUAL
                    </div>
    
                    <div class="major">
                        PENGEMBANGAN PERANGKAT LUNAK DAN GIM
                    </div>
    
                    <div class="info">
                        NPSN : 69949896 &nbsp;&nbsp;&nbsp;
                        NSS : 402020828126
                    </div>
    
                    <div class="address">
                        Jl. Katapang Andir, Km 4. Pasantren. Ds. Sukamukti.
                        Kec. Katapang. Kab. Bandung Kode Pos : 40971
                    </div>
    
                    <div class="address">
                        Tlp:(022) 5893178.
                        Email: smkmahaputracerdasutama@gmail.com
                        Web: smkmahaputra.sch.id
                    </div>
                </td>
    
                <td class="logo-right">
                    <img src="{{ public_path('assets/images/logos/images-removebg-preview (1).png') }}" alt="Logo Sekolah">
                </td>
            </tr>
        </table>
    
        <div class="kop-line">
            <div class="line-1"></div>
            <div class="line-2"></div>
        </div>
    </div>

    <div class="title">
        BERITA ACARA BIMBINGAN PKL
    </div>

    <p class="intro">
        Pada hari ini,
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('l') }}</strong>
        tanggal
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('d') }}</strong>
        bulan
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('F') }}</strong>
        tahun
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('Y') }}</strong>,
        telah dilaksanakan kegiatan Bimbingan Praktik Kerja Lapangan (PKL) bagi siswa-siswi SMKS Mahaputra Cerdas Utama oleh Guru Pembimbing dengan rincian pelaksanaan sebagai berikut:
    </p>

    <table class="data-table">
        {{-- <tr>
            <td class="label">Jumlah siswa seharusnya</td>
            <td class="separator">:</td>
            <td>{{ $totalMentee }}</td>
        </tr> --}}
        <tr>
            <td class="label">Waktu Pelaksanaan</td>
            <td class="separator">:</td>
            <td>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('l, d F Y') }} 
                pukul
                {{ \Carbon\Carbon::parse($news->news_start)->format('H.i') }}
                s/d
                {{ \Carbon\Carbon::parse($news->news_ended)->format('H.i') }}
                WIB</td>
        </tr>
        <tr>
            <td class="label">Tempat/Media Bimbingan</td>
            <td class="separator">:</td>
            <td> {!! nl2br(e($news->news_place ?? '-')) !!}</td>
        </tr>
        <tr>
            <td class="label"><b>Metode Pelaksanaan</b></td>
            <td class="separator"><b>:</b></td>
            <td>
                <span style="border:1px solid #000; padding:0 5px;">
                    {!! $news->news_method == 1 ? 'V' : '&nbsp;' !!}
                </span>
                Luring (Tatap Muka)<br>
            
                <span style="border:1px solid #000; padding:0 5px;">
                    {!! $news->news_method == 2 ? 'V' : '&nbsp;' !!}
                </span>
                Daring (Online)<br>
            
                <span style="border:1px solid #000; padding:0 5px;">
                    {!! $news->news_method == 3 ? 'V' : '&nbsp;' !!}
                </span>
                Hybrid (Kombinasi)
            </td>
        </tr>
        {{-- <tr>
            <td class="label">Jumlah siswa hadir</td>
            <td class="separator">:</td>
            <td>{{ $news->participants->count() }}</td>
        </tr>

        <tr>
            <td class="label">Jumlah siswa tidak hadir</td>
            <td class="separator">:</td>
            <td>{{ $totalMentee - $news->participants->count() }}</td>
        </tr> --}}
    </table>
    

    <div class="section-title">
        Daftar siswa yang tidak mengikuti bimbingan:
    </div>

    <div class="content-box">
        @forelse($absentStudents as $student)
            {{ $loop->iteration }}.
            {{ $student->user->name }}
            ({{ $student->std_nis }})
            <br>
        @empty
            -
        @endforelse
    </div>
    <p class="intro">
        Demikian Berita Acara Pelaksanaan Bimbingan ini dibuat dengan sebenar-benarnya untuk digunakan
sebagaimana mestinya sebagai bukti otentik pelaksanaan supervisi dan bimbingan PKL.
    </p>


    {{-- <div class="section-title">
        Isi Bimbingan
    </div>
     --}}

    {{-- <div class="content-box">
        {!! nl2br(e($news->news_guidance_material ?? '-')) !!}
    </div>

    <div class="section-title">
        Kendala
    </div>

    <div class="content-box">
        {!! nl2br(e($news->news_problem ?? '-')) !!}
    </div>

    <div class="section-title">
        Catatan
    </div>

    <div class="content-box">
        {!! nl2br(e($news->news_note ?? '-')) !!}
    </div> --}}

    <table class="signature-table">
        <tr>
            <td>
                Panitia PKL
            </td>

            <td>
                Pembimbing
            </td>
        </tr>

        <tr>
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>

        <tr>
            <td>
                <span class="name">
                    ({{ auth()->user()->name }})
                </span>
            </td>

            <td>
                <span class="name">
                    ({{ $news->mentor->user->name ?? '-' }})
                </span>
            </td>
        </tr>
    </table>

</body>
</html>
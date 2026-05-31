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
        }

        .separator {
            width: 5%;
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
    </style>
</head>
<body>

    <div class="title">
        BERITA ACARA BIMBINGAN PKL
    </div>

    <p class="intro">
        Pada hari
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('l') }}</strong>
        tanggal
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('d') }}</strong>
        bulan
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('F') }}</strong>
        tahun
        <strong>{{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('Y') }}</strong>,
        telah dilaksanakan kegiatan bimbingan Praktik Kerja Lapangan (PKL)
        dengan rincian sebagai berikut:
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Jumlah siswa seharusnya</td>
            <td class="separator">:</td>
            <td>{{ $totalMentee }}</td>
        </tr>

        <tr>
            <td class="label">Jumlah siswa hadir</td>
            <td class="separator">:</td>
            <td>{{ $news->participants->count() }}</td>
        </tr>

        <tr>
            <td class="label">Jumlah siswa tidak hadir</td>
            <td class="separator">:</td>
            <td>{{ $totalMentee - $news->participants->count() }}</td>
        </tr>
    </table>

    <div class="section-title">
        Siswa yang Tidak Hadir
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

    <div class="section-title">
        Isi Bimbingan
    </div>

    <div class="content-box">
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
    </div>

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
                    {{ auth()->user()->name }}
                </span>
            </td>

            <td>
                <span class="name">
                    {{ $news->mentor->user->name ?? '-' }}
                </span>
            </td>
        </tr>
    </table>

</body>
</html>
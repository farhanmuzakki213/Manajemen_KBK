<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara RPS</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 1.5cm 1cm 4cm 1.5cm;
        }

        .kepala {
            position: fixed;
            top: 0;
            left: 56.8px;
            right: 56.8px;
            z-index: 0;
        }

        .kepala table {
            width: 100%;
        }

        .kepala td.logo {
            text-align: center;
        }

        .kepala td.logo img {
            display: block;
            margin-left: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .kepala tr.border-top {
            border-top: 1px solid black;
        }

        .kepala td {
            padding: 0;
            text-align: center;
            border: none;
        }

        .kepala .header-content {
            vertical-align: top;
            border-top: 1px solid black;
        }

        .badan {
            top: 160px;
            position: relative;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 0;
            line-height: 1.6;
        }

        .details .label {
            font-weight: bold;
        }

        table .isi {
            page-break-inside: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        strong {
            font-weight: bold;
        }

        .table-info th {
            text-align: center;
        }

        .semester {
            max-width: 5px;
            overflow: hidden;
            text-align: justify;
            /* word-wrap: break-word; */
        }

        .nama_matkul {
            max-width: 30px;
            overflow: hidden;
            text-align: justify;
            /* word-wrap: break-word; */
        }

        .evaluasi {
            max-width: 200px;
            overflow: hidden;
            text-align: justify;
            word-wrap: break-word;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .signatures table {
            border: none;
        }

        .signatures .left,
        .signatures .right {
            width: 50%;
            text-align: center;
            border: none;
            page-break-inside: avoid;
            white-space: nowrap;
        }

        .signatures .center {
            width: 100%;
            text-align: center;
            page-break-inside: avoid;
        }

        .signatures .center p {
            page-break-after: avoid;
        }
    </style>
</head>

<body>

    <div class="kepala">
        <table>
            <tr class="border-top">
                <td class="logo" rowspan="1" style="width: 15%;">
                    <img src="{{ public_path('backend/assets/images/logos/logo_pnp.png') }}" alt="Logo" />
                </td>
                <td class="header-content">
                    <center>
                        <strong>
                            <font style="font-size: 15px;">KEMENTRIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                            <font style="font-size: 15px;">RISET, DAN TEKNOLOGI</font><br>
                        </strong>
                        <strong>
                            <font style="font-size: 15px;">POLITEKNIK NEGERI PADANG</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">PUSAT PENINGKATAN DAN PENGEMBANGAN AKTIVITAS INSTITUSIONAL</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">(P3AI)</font>
                        </strong><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="header-content" colspan="2">
                    <center>
                        <strong>
                            <font style="font-size: 15px;">FORMULIR</font>
                        </strong><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="header-content" colspan="2">
                    <center>
                        <strong>
                            <font style="font-size: 15px;">VERIFIKASI RENCANA PEMBELAJARAN SEMESTER</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">JURUSAN : TEKNOLOGI INFORMASI PROGRAM STUDI : {{ strtoupper($selectedProdi->prodi) }}</font>
                        </strong>
                        <br>
                    </center>
                </td>
            </tr>
        </table>
    </div>

    <div class="badan">
        <div class="details">
            <p>Telah dilaksanakan rapat Peninjauan materi RPS bersama KBK dan Kaprodi yang dilaksanakan pada:</p>
            <p id="hari-tanggal" style="padding-left: 50px;">
                Hari / Tanggal : {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </p>
            <p style="padding-left: 50px;">Dengan hasil sebagai berikut:</p>
        </div>

        <table class="isi">
            <thead>
                <tr class="table-info">
                    <th>No</th>
                    <th>Semester</th>
                    <th>Nama Matkul</th>
                    <th>Evaluasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $angka_ke_nama = [
                        'Satu',
                        'Dua',
                        'Tiga',
                        'Empat',
                        'Lima',
                        'Enam',
                        'Tujuh',
                        'Delapan',
                        'Sembilan',
                        'Sepuluh',
                    ];
                @endphp
                @foreach ($data_ver_rps as $data_ver)
                    <tr class="table-Light">
                        <td class="no">{{ $no++ }}</td>
                        <td class="semester">
                            @php
                                $semester = optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->semester;
                                if ($semester >= 1 && $semester <= 10) {
                                    echo "$semester (" . $angka_ke_nama[$semester - 1] . ')';
                                } else {
                                    echo 'Angka semester tidak valid';
                                }
                            @endphp
                        </td>
                        <td class="nama_matkul">
                            {{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->nama_matkul }}</td>
                        <td class="evaluasi">{{ $data_ver->saran }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signatures">
            <table style="width: 100%;">
                <tr>
                    <td class="left">
                        <p>Menyetujui,</p>
                        <p>Kaprodi</p>
                        <br><br><br><br>
                        <p>{{ $kaprodi->r_dosen->nama_dosen }}</p>
                    </td>
                    <td class="right" style="padding-left: 100px">
                        <p>Ketua KBK</p>
                        <p style="font-style: italic;">{{ $pengurus_kbk->r_jenis_kbk->deskripsi }}</p>
                        <br><br><br><br>
                        <p>{{ $pengurus_kbk->r_dosen->nama_dosen }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="signatures">
            <div class="center">
                <p>Mengetahui</p>
                <br><br><br><br>
                <p>{{ $kajur->r_dosen->nama_dosen }}</p>
            </div>
        </div>
    </div>

</body>

</html>

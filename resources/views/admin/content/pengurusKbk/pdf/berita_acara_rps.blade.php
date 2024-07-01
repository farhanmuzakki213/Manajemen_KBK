<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara RPS</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0.5cm 1.5cm 1cm 1.5cm;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .details {
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .details p {
            margin: 0;
            line-height: 1.6;
        }

        .details .label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .table-info th {
            text-align: center;
        }

        .evaluasi {
            max-width: 140px;
            overflow: hidden;
            text-align: justify;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signatures table {
            border: none;
        }

        .signatures .left, .signatures .right {
            width: 50%;
            text-align: center;
            border: none;
            page-break-inside: avoid;
        }

        .signatures .center {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .signatures .center p {
            margin-bottom: 60px;
            page-break-after: avoid;
        }

        .kepala {
            margin: 0;
            padding: 0;
            width: 100%;
            border-spacing: 0;
        }

        .kepala td {
            padding: 0;
        }

        .no {
            text-align: center;
        }
       
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
            }

            @page {
                margin: 1.5cm;
            }

            .kepala {
                display: table-header-group;
            }

            .signatures {
                page-break-inside: avoid;
            }
            
        }
    </style>
</head>

<body>

    <div class="kepala">
        <table style="width: 100%;">
            <tr>
                <td>
                    <center>
                        <font style="font-size: 17px;">KEMENTRIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                        <font style="font-size: 17px;">RISET, DAN TEKNOLOGI</font><br>
                        <strong>
                            <font style="font-size: 15px;">POLITEKNIK NEGERI PADANG</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">PUSAT PENINGKATAN DAN PENGEMBANGAN AKTIVITAS INSTITUSIONAL</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 13px;">(P3AI)</font>
                        </strong><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <strong>
                            <font style="font-size: 15px;">FORMULIR</font>
                        </strong><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <strong>
                            <font style="font-size: 15px;">VERIFIKASI RENCANA PEMBELAJARAN SEMESTER</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">JURUSAN : TEKNOLOGI INFORMASI PROGRAM STUDI : TRPL</font>
                        </strong><br>
                    </center>
                </td>
            </tr>
        </table>
    </div>

    <div class="details">
        <p>Telah dilaksanakan rapat Peninjauan materi RPS bersama KBK dan Kaprodi yang dilaksanakan pada :</p>
        <p style="padding-left: 50px;">Hari / Tanggal : Selasa / 14 Februari 2023</p>
        {{-- <p>Tempat : Ruang TUK / E305</p> --}}
        <p style="padding-left: 50px;">Dengan hasil sebagai berikut :</p>
    </div>

    <table>
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
                    <td>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->nama_matkul }}</td>
                    <td class="evaluasi">{{ $data_ver->saran }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <table style="width: 100%;">
            <tr>
                <td class="left">
                    <p>Kaprodi</p>
                    <br><br><br><br>
                    <p>Defni, S.Si., M.Kom</p>
                </td>
                <td class="right">
                    <p>Ketua KBK</p>
                    <br><br><br><br>
                    <p>Yulherniwati, S.Kom., M.T</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="signatures">
        <div class="center">
            <p>Mengetahui</p>
            <br><br><br><br>
            <p>Ronal Hadi, S.T., M.Kom</p>
        </div>
    </div>

</body>

</html>

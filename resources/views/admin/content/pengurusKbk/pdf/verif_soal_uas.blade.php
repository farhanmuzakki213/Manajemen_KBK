<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Soal UAS</title>
    <style>
        /* @font-face {
            font-family: 'CustomFont';
            src: url('{{ asset('backend/assets/font/Times New Roman/times new roman.ttf') }}') format('truetype');
        } */

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 1.5cm 1cm 4cm 0.3cm;
        }

        .kepala {
            position: fixed;
            top: 0;
            /* left: 56.8px;
            right: 56.8px; */
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
        }

        .kepala tr.border-top {
            border-top: 1px solid black;
        }

        .kepala td {
            padding: 0;
            text-align: center;
            border: none;
        }

        .kepala .logo img {
            width: 100%;
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
            /* font-weight: bold; */
        }

        .details-table {
            width: auto;
            margin-bottom: 20px;
            border-collapse: collapse;
            border: none;
        }

        .details-table td {
            padding: 0;
            line-height: 1.6;
            vertical-align: top;
            border: none;
        }

        .details-table .label {
            /* font-weight: bold; */
            padding-right: 10px;
            white-space: nowrap;
        }

        .details-table .value {
            padding-left: 5px;
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

        th {
            text-align: center;
        }

        strong {
            font-weight: bold;
        }

        .table-info th {
            text-align: center;
        }

        .signatures {
            width: 106%;
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            page-break-inside: avoid;
            border-bottom: 1px solid black;

        }

        .signatures table {
            width: 100%;
            /* Atur lebar tabel agar pas dengan container */
            border-collapse: collapse;
            border: none;
            /* Hapus border default jika diperlukan */
        }

        .signatures td,
        .signatures th {
            border: 1px solid black;
            font-size: 14px
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

        .table-light {
            background-color: #f9f9f9;
        }

        .table-light td {
            padding: 8px;
        }

        .spacing {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>

    <div class="kepala">
        <table>
            <tr class="border-top">
                <td class="logo" rowspan="1" style="width: 13%;">
                    <img src="{{ public_path('backend/assets/images/logos/logo_pnp.png') }}" alt="Logo" />
                </td>
                <td class="header-content">
                    <center>
                        <strong>
                            <font style="font-size: 15px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                            <font style="font-size: 15px;">RISET, DAN TEKNOLOGI</font><br>
                        </strong>
                        <strong>
                            <font style="font-size: 15px;">POLITEKNIK NEGERI PADANG</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">PUSAT PENINGKATAN DAN PENGEMBANGAN AKTIVITAS INSTITUSIONAL
                            </font>
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
                <td class="header-content" colspan="2" style="padding-left: 10px; padding-right: 10px;">
                    <center>
                        <strong>
                            <font style="font-size: 15px;">VERIFIKASI SOAL UJIAN AKHIR SEMESTER</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 15px;">
                                JURUSAN : TEKNOLOGI INFORMASI PROGRAM STUDI : D4 Teknologi Rekayasa Perangkat Lunak
                            </font>
                        </strong>
                        <br>
                    </center>
                </td>
            </tr>
        </table>
    </div>

    <div class="badan">
        <div class="details">
            <strong>A. Identitas Matakuliah</strong>
            <table class="details-table" style="padding-left: 20px;">
                <tr>
                    <td class="label">Mata Kuliah/ Kode Matakuliah</td>
                    <td class="value">: Project 1 ( Desktop) / RPL4403</td>
                </tr>
                <tr>
                    <td class="label">Dosen</td>
                    <td class="value">: Yunus C, Yori Adi Atma</td>
                </tr>
                <tr>
                    <td class="label">Semester</td>
                    <td class="value">: Ganjil/Genap*</td>
                </tr>
                <tr>
                    <td class="label">Tahun Akademik</td>
                    <td class="value">: 2022/2023</td>
                </tr>
            </table>
        </div>

        <strong style="margin-bottom: 10px; display: block;">B. Hasil Verifikasi Soal</strong>
        <table class="isi" style="padding-left: 20px;">
            <thead>
                <tr class="table-info">
                    <th rowspan="2" style="text-align: center;">Butir Soal</th>
                    <th colspan="5">Validitas Isi</th>
                    <th colspan="5">Bahasa dan Penulisan Soal</th>
                </tr>
                <tr class="table-info">
                    <th>Tidak Valid</th>
                    <th>Kurang Valid</th>
                    <th>Cukup Valid</th>
                    <th>Valid</th>
                    <th>Sangat Valid</th>
                    <th>Tidak Baik</th>
                    <th>Kurang Baik</th>
                    <th>Cukup Baik</th>
                    <th>Baik</th>
                    <th>Sangat Baik</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($p_HasilVerifUas->p_HasilVerifUas as $data)
                    @php
                        // Mendapatkan validasi isi dan bahasa soal
                        $validasiIsi = $data['soal_data']['validasi_isi'] ?? [];
                        $bahasaSoal = $data['soal_data']['bahasa_soal'] ?? [];
                    @endphp

                    @foreach ($validasiIsi as $index => $validasi)
                        @php
                            // Cek apakah ada data bahasa soal untuk indeks yang sama
                            $bahasaSoalValue = $bahasaSoal[$index] ?? null;
                        @endphp

                        <tr class="table-light">
                            <td>{{ $index }}</td>
                            <td>{{ $validasi == 1 ? '✓' : '' }}</td>
                            <td>{{ $validasi == 2 ? '✓' : '' }}</td>
                            <td>{{ $validasi == 3 ? '✓' : '' }}</td>
                            <td>{{ $validasi == 4 ? '✓' : '' }}</td>
                            <td>{{ $validasi == 5 ? '✓' : '' }}</td>
                            <td>{{ $bahasaSoalValue == 1 ? '✓' : '' }}</td>
                            <td>{{ $bahasaSoalValue == 2 ? '✓' : '' }}</td>
                            <td>{{ $bahasaSoalValue == 3 ? '✓' : '' }}</td>
                            <td>{{ $bahasaSoalValue == 4 ? '✓' : '' }}</td>
                            <td>{{ $bahasaSoalValue == 5 ? '✓' : '' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="spacing"></div>

        <strong>C. Saran</strong>
        <p style="padding-left: 20px;">yaaaaaaa</p>
        <div class="spacing"></div>

        <strong>D. Rekomendasi</strong>
        <p style="padding-left: 20px;">ok</p>
        <div class="spacing"></div>


        <div class="signatures">
            <table>
                <thead>
                    <tr class="table-info">
                        <th colspan="2" style="font-size: 14px">Divalidasi Ketua KBK / Koordinator Program Studi</th>
                        <th colspan="2" style="font-size: 14px">Disetujui Ketua Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-light">
                        <td>Tanggal</td>
                        <td style="width: 40%;"></td>
                        <td>Tanggal</td>
                        <td style="width: 40%;"></td>
                    </tr>
                    <tr class="table-light">
                        <td>Oleh</td>
                        <td>Yulherniwati, S.Kom.,MT</td>
                        <td>Oleh</td>
                        <td>Ronal Hadi, S.T., M.Kom</td>
                    </tr>
                    <tr class="table-light">
                        <td rowspan="2">Tanda Tangan</td>
                        <td rowspan="2"></td>
                        <td rowspan="2">Tanda Tangan</td>
                        <td rowspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>

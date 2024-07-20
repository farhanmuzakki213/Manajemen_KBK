<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Verifikasi Soal UAS</title>
    <style>
        /* @font-face {
            font-family: 'CustomFont';
            src: url('{{ asset('backend/assets/font/Times New Roman/times new roman.ttf') }}') format('truetype');
        } */

        @media print {
            body {
                font-family: 'Times New Roman', Times, serif;
            }
        }

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
            width: 80%;
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
            margin-bottom: 15px;
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
            font-size: 11pt;
            padding-right: 10px;
            white-space: nowrap;
        }

        .details-table .value {
            font-size: 11pt;
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
            border: 1px solid #000;
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
            border: 0.5px solid black;
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

        .table-head {
            background-color: #d9d9d9;
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
                        <div>
                            <font style="font-size: 20px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                            <font style="font-size: 20px;">RISET, DAN TEKNOLOGI</font><br>
                        </div>
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
                                JURUSAN : TEKNOLOGI INFORMASI PROGRAM STUDI : {{ strtoupper($selectedProdi->prodi) }}
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
                @php
                    $smt_thnakd = $p_HasilVerifUas->r_rep_rps_uas->r_smt_thnakd->smt_thnakd ?? 'N/A';
                    $parts = explode('-', $smt_thnakd);
                    $semester = isset($parts[1]) ? $parts[1] : 'N/A';
                    $thnAkd = isset($parts[0]) ? $parts[0] : 'N/A';
                @endphp
                <tr>
                    <td class="label">Mata Kuliah/ Kode Matakuliah</td>
                    <td class="value">:
                        {{ $p_HasilVerifUas->r_rep_rps_uas->r_matkulKbk->r_matkul->nama_matkul ?? 'N/A' }}
                        /
                        {{ $p_HasilVerifUas->r_rep_rps_uas->r_matkulKbk->r_matkul->kode_matkul ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Dosen</td>
                    <td class="value">:
                        {{ $p_HasilVerifUas->r_rep_rps_uas->r_dosen_matkul->r_dosen->nama_dosen ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Semester</td>
                    <td class="value">: {{ $semester }}</td>
                </tr>
                <tr>
                    <td class="label">Tahun Akademik</td>
                    <td class="value">: {{ $thnAkd }}</td>
                </tr>
            </table>
        </div>

        <strong style="margin-bottom: 10px; display: block;">B. Hasil Verifikasi Soal</strong>
        <table style="padding-left: 20px;">
            <thead>
                <tr class="table-info table-head">
                    <th rowspan="2" style="text-align: center; vertical-align: middle; font-size: 11pt; font-weight: normal;">Butir Soal</th>
                    <th colspan="5" style="font-size: 11pt;">Validitas Isi</th>
                    <th colspan="5" style="font-size: 11pt;">Bahasa dan Penulisan Soal</th>
                </tr>
                <tr class="table-info table-head">
                    <th style="font-size: 11pt; font-weight: normal;">Tidak Valid</th>
                    <th style="font-size: 11pt; font-weight: normal;">Kurang Valid</th>
                    <th style="font-size: 11pt; font-weight: normal;">Cukup Valid</th>
                    <th style="font-size: 11pt; font-weight: normal;">Valid</th>
                    <th style="font-size: 11pt; font-weight: normal;">Sangat Valid</th>
                    <th style="font-size: 11pt; font-weight: normal;">Tidak Baik</th>
                    <th style="font-size: 11pt; font-weight: normal;">Kurang Baik</th>
                    <th style="font-size: 11pt; font-weight: normal;">Cukup Baik</th>
                    <th style="font-size: 11pt; font-weight: normal;">Baik</th>
                    <th style="font-size: 11pt; font-weight: normal;">Sangat Baik</th>
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

                        <tr>
                            <td style="text-align: center; padding: 0px; font-size: 11pt;">{{ $index .'.' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $validasi == 1 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $validasi == 2 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $validasi == 3 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $validasi == 4 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $validasi == 5 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $bahasaSoalValue == 1 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $bahasaSoalValue == 2 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $bahasaSoalValue == 3 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $bahasaSoalValue == 4 ? '✔' : '' }}</td>
                            <td style="font-family: DejaVu Sans, sans-serif; text-align: center; padding: 0px; font-size: 11pt;">
                                {{ $bahasaSoalValue == 5 ? '✔' : '' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="spacing"></div>

        <strong>C. Saran</strong>
        <p style="padding-left: 20px;">{{ $p_HasilVerifUas->saran }}</p>
        <div class="spacing"></div>

        <strong>D. Rekomendasi</strong>
        <p style="padding-left: 20px;">
            @if ($p_HasilVerifUas->rekomendasi == 0)
                Belum diverifikasi
            @elseif ($p_HasilVerifUas->rekomendasi == 1)
                Tidak layak dipakai
            @elseif ($p_HasilVerifUas->rekomendasi == 2)
                Layak untuk dipakai dengan revisi sesuai saran
            @else
                Layak untuk dipakai tanpa revisi
            @endif
        </p>
        <div class="spacing"></div>


        <div class="signatures">
            <table>
                <thead>
                    <tr class="table-info">
                        <th colspan="2" style="font-size: 11pt; padding: 2px; margin:20px">Divalidasi Ketua KBK
                        </th>
                        <th colspan="2" style="font-size: 11pt; padding: 2px; margin:20px">Disetujui Ketua Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                    @endphp

                    <tr style="width:auto;">
                        <td style="font-size: 9pt; padding: 4px; padding-left: 8px;">Tanggal</td>
                        <td style="font-size: 9pt; padding: 4px; padding-left: 8px;">{{ $currentDate }}</td>
                        <td style="font-size: 9pt; padding: 4px; padding-left: 8px;">Tanggal</td>
                        <td style="font-size: 9pt; padding: 4px; padding-left: 8px;">{{ $currentDate }}</td>
                    </tr>
                    <tr style="width:auto;">
                        <td style="font-size: 9pt;">Oleh</td>
                        <td style="font-size: 9pt;">{{ $pengurus_kbk->r_dosen->nama_dosen }}</td>
                        <td style="font-size: 9pt;">Oleh</td>
                        <td style="font-size: 9pt;">{{ $kajur->r_dosen->nama_dosen }}</td>
                    </tr>
                    <tr style="width:auto;">
                        <td rowspan="2" style="font-size: 9pt;">Tanda Tangan</td>
                        <td rowspan="2" style="font-size: 9pt;">TDO</td>
                        <td rowspan="2" style="font-size: 9pt;">Tanda Tangan</td>
                        <td rowspan="2" style="font-size: 9pt;">TDO</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>

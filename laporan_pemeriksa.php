<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksa - MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
        }
        h2, h3 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            font-size: 13px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        .no-border {
            border: none;
        }
        .section-title {
            font-weight: bold;
            margin-top: 25px;
        }
    </style>
</head>
<body>

<h2>BULAN SABIT MERAH MALAYSIA (MALAYSIAN RED CRESCENT)</h2>
<h3>IBU PEJABAT KEBANGSAAN</h3>
<p style="text-align:center;">LOT PT54, LENGKOK BELFIELD, OFF JALAN WISMA PUTRA, 50460 KUALA LUMPUR</p>
<h3>LAPORAN DAN ULASAN PEMERIKSA</h3>

<p class="section-title">A. PERSIJILAN UNTUK SEKOLAH</p>
<ul>
    <li>Pertolongan Cemas Kemasyarakatan</li>
    <li>Pendidikan Palang Merah/Bulan Sabit Merah</li>
</ul>

<p class="section-title">B. PERSIJILAN ASAS BSMM</p>
<ul>
    <li>Pertolongan Cemas Asas</li>
    <li>Pendidikan Palang Merah/Bulan Sabit Merah Dan Undang-undang Kemanusiaan Antarabangsa</li>
    <li>Bantuan Bencana & Operasi Menyelamat</li>
    <li>Pendidikan Kesihatan</li>
    <li>Rawatan Rumah</li>
</ul>

<p class="section-title">C. PERSIJILAN LANJUTAN BSMM</p>
<ul>
    <li>Pertolongan Cemas Lanjutan</li>
    <li>Pentadbiran dan Pengurusan</li>
</ul>

<p class="section-title">D. KAEDAH MENGAJAR</p>
<p class="section-title">E. BANTUAN HIDUP ASAS</p>
<p class="section-title">F. UNDANG-UNDANG KEMANUSIAAN ANTARABANGSA</p>
<p class="section-title">G. PENGENALAN PERTOLONGAN CEMAS DAN KARDIOPULMONARI RESUSITASI</p>
<p class="section-title">H. JURULATIH</p>
<p class="section-title">I. JURULATIH KANAN</p>
<p class="section-title">J. PEMBAHARUAN: ______________________</p>
<p class="section-title">K. LAIN-LAIN: _________________________</p>

<br><br>
<p>Nama Pemeriksa: <strong>[ MRCS ]</strong><br>
Tarikh: _____________</p>

<hr>

<h3>PENYATA PEPERIKSAAN</h3>

<table class="no-border">
<tr><td>Cabang (Chapter):</td><td></td></tr>
<tr><td>Cawangan:</td><td>IBU PEJABAT KEBANGSAAN</td></tr>
<tr><td>Jenis Kursus:</td><td>PERTOLONGAN CEMAS DAN CPR ASAS</td></tr>
<tr><td>Tarikh Kursus:</td><td>Dari ____/____/2025 Hingga ____/____/2025</td></tr>
<tr><td>Tarikh Peperiksaan:</td><td>____/____/2025</td></tr>
<tr><td>Nama Jabatan/Syarikat:</td><td>________________________</td></tr>
<tr><td>Alamat Peperiksaan:</td><td>________________________</td></tr>
<tr><td>Nama Pegawai Latihan:</td><td>________________________</td></tr>
</table>

<p><strong>Jumlah Hadir:</strong> ___ orang &nbsp;&nbsp;&nbsp;&nbsp; 
<strong>Jumlah Lulus:</strong> ___ orang</p>

<h3>SENARAI PESERTA</h3>

<table>
    <tr>
        <th>BIL</th>
        <th>NAMA PENUH</th>
        <th>NO. K/P</th>
        <th>SYARAHAN DIBERI</th>
        <th>SYARAHAN HADIR</th>
        <th>BERTULIS</th>
        <th>LISAN</th>
        <th>PRAKTIKAL</th>
        <th>MARKAH</th>
        <th>KEPUTUSAN</th>
    </tr>
    <?php for ($i = 1; $i <= 30; $i++): ?>
    <tr>
        <td><?= $i ?></td>
        <td></td>
        <td></td>
        <td>14 JAM</td>
        <td>14 JAM</td>
        <td></td>
        <td>LULUS / GAGAL</td>
        <td>LULUS / GAGAL</td>
        <td></td>
        <td>LULUS / GAGAL</td>
    </tr>
    <?php endfor; ?>
</table>

<br>
<p><strong>Nota:</strong> Sijil hanya sah untuk 3 tahun dari tarikh peperiksaan.</p>

</body>
</html>

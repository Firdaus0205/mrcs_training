<?php
session_start();
include 'config.php';

// Pastikan peserta sudah login
if (!isset($_SESSION['peserta_id'])) {
    header("Location: login_peserta.php");
    exit();
}

$id_peserta = $_SESSION['peserta_id'];

// Ambil data peserta dari jadual 'peserta'
$query = "
    SELECT 
        nama, 
        no_ic, 
        kategori AS nama_kursus, 
        bulan AS tarikh_kursus 
    FROM peserta
    WHERE id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_peserta);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();

if (!$peserta) {
    echo "<p style='color:red;text-align:center;'>Ralat: Maklumat peserta tidak dijumpai.</p>";
    exit();
}

// Simpan data dalam pembolehubah
$nama_peserta   = $peserta['nama'] ?? 'Nama Tidak Ditemui';
$ic             = $peserta['no_ic'] ?? '-';
$nama_kursus    = $peserta['nama_kursus'] ?? 'Kursus MRCS';
$tarikh_kursus  = !empty($peserta['tarikh_kursus']) ? $peserta['tarikh_kursus'] : 'Tarikh Tidak Tersedia';
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Sijil Penyertaan MRCS</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .sijil-container {
            background-image: url('sijil.png'); /* Pastikan fail sijil.png wujud */
            background-size: cover;
            width: 1123px;
            height: 794px;
            padding: 60px 80px;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
            position: relative;
            text-align: center;
        }

        .header-text {
            font-weight: bold;
            font-size: 18px;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .logo {
            margin: 15px auto;
            width: 100px;
            height: auto;
        }

        .title {
            margin-top: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #c8102e;
        }

        .content {
            margin-top: 30px;
            font-size: 20px;
            line-height: 1.8;
        }

        .nama {
            font-size: 26px;
            font-weight: bold;
            margin-top: 20px;
            text-decoration: underline;
        }

        .footer {
            position: absolute;
            bottom: 80px;
            left: 80px;
            right: 80px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .tandatangan {
            text-align: center;
        }

        /* Gaya butang kembali & cetak */
        .action-btn {
            position: fixed;
            top: 20px;
            padding: 10px 18px;
            background: #c8102e;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 9999;
        }
        .back-btn { left: 20px; }
        .print-btn { right: 20px; background: #007BFF; }
        .print-btn:hover { background: #0056b3; }
        .back-btn:hover { background: #a40c24; }

        @media print {
            .action-btn { display: none; } /* Jangan print butang */
        }
    </style>
</head>
<body>

<!-- Butang kembali & cetak -->
<a href="index_peserta.php" class="action-btn back-btn">← Kembali</a>
<a href="#" onclick="window.print()" class="action-btn print-btn">🖨 Cetak Sijil</a>

<div class="sijil-container">

    <!-- Header -->
    <div class="header-text">
        DI BAWAH NAUNGAN<br>
        SERI PADUKA BAGINDA YANG DIPERTUAN AGONG
    </div>

    <img src="logo_mrcs.jpg" class="logo" alt="Logo MRCS">

    <div class="header-text">
        PERSATUAN BULAN SABIT MERAH MALAYSIA<br>
        (MALAYSIAN RED CRESCENT SOCIETY)
    </div>

    <div class="title">Sijil Penyertaan</div>

    <div class="content">
        This is to certify that
        <div class="nama"><?= htmlspecialchars(strtoupper($nama_peserta)) ?></div>
        No. Kad Pengenalan: <?= htmlspecialchars($ic) ?><br>
        has successfully completed and passed the<br>
        <strong><?= htmlspecialchars($nama_kursus) ?></strong><br>
        on <?= htmlspecialchars($tarikh_kursus) ?>
    </div>

    <div class="footer">
        <div class="tandatangan">
            ------------------------------<br>
            Tandatangan Pegawai MRCS
        </div>
        <div class="tandatangan">
            ------------------------------<br>
            Cop Rasmi & Tarikh
        </div>
    </div>
</div>

</body>
</html>
  


























<?php
session_start();
include 'config.php';

// Pastikan peserta sudah login
if (!isset($_SESSION['peserta_id'])) {
    header("Location: login_peserta.php");
    exit();
}

$peserta_id = $_SESSION['peserta_id'];

// Ambil maklumat peserta
$stmt = $conn->prepare("SELECT nama, no_ic, kategori, bulan FROM peserta WHERE id = ?");
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();

if (!$peserta) {
    echo "<p style='color:red;text-align:center;'>Ralat: Maklumat peserta tidak dijumpai.</p>";
    exit();
}

// Masukkan maklumat kursus secara terus dari jadual peserta
$kursus_list = [];

if (!empty($peserta['kategori']) && !empty($peserta['bulan'])) {
    $kursus_list[] = [
        'nama_kursus' => $peserta['kategori'],
        'tarikh_kursus' => $peserta['bulan']
    ];
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Peserta - MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #b50000;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #b50000;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table td, table th {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .btn {
            display: inline-block;
            background-color: #b50000;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #8e0000;
        }
    </style>
</head>
<body>
<header>
    <h1>MRCS Training System - Peserta</h1>
</header>

<div class="container">
    <h2>Maklumat Peserta</h2>
    <table>
        <tr><td><b>Nama</b></td><td><?= htmlspecialchars($peserta['nama']) ?></td></tr>
        <tr><td><b>No. IC</b></td><td><?= htmlspecialchars($peserta['no_ic']) ?></td></tr>
    </table>

    <h2>Senarai Kursus Didaftarkan</h2>
    <table>
        <tr>
            <th>Kursus</th>
            <th>Tarikh Kursus</th>
        </tr>
        <?php if (!empty($kursus_list)): ?>
            <?php foreach ($kursus_list as $kursus): ?>
                <tr>
                    <td><?= htmlspecialchars($kursus['nama_kursus']) ?></td>
                    <td><?= htmlspecialchars($kursus['tarikh_kursus']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" style="text-align:center; color:gray;">Tiada kursus didaftarkan.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="cetak_sijil.php" class="btn">📄 Cetak Sijil</a>
    <a href="dashboard_peserta.php" class="btn btn-secondary">🔙 Kembali ke Dashboard</a>
</div>
</body>
</html>










<?php
session_start();
include 'config.php';

// Debug sementara (buang bila live)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Semak login admin kewangan
if (!isset($_SESSION['finance_id'])) {
    echo "<!DOCTYPE html>
    <html lang='ms'>
    <head>
        <meta charset='UTF-8'>
        <title>MRCS - Sila Login</title>
        <link href='https://fonts.googleapis.com/css2?family=Rubik&display=swap' rel='stylesheet'>
        <style>
            body { font-family: 'Rubik', sans-serif; background: #f0f4f7; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
            .msg-box { background:#fff; padding:40px; border-radius:10px; text-align:center; box-shadow:0 0 20px rgba(0,0,0,0.1); }
            h2 { color:#007b8a; }
            a.btn { background:#007b8a; color:#fff; padding:12px 24px; border-radius:8px; text-decoration:none; display:inline-block; margin-top:15px; }
            a.btn:hover { background:#005f68; }
        </style>
    </head><body>
        <div class='msg-box'>
            <h2>Anda belum log masuk.</h2>
            <p>Sila log masuk untuk mengakses halaman ini.</p>
            <a href='finances_login.php' class='btn'>Ke Halaman Login</a>
        </div>
    </body></html>";
    exit();
}

// Senarai kategori latihan & yuran
$kategori = [
    "Introduction First Aid & CPR" => 230,
    "Basic First Aid & CPR + AED"  => 350,
    "Advanced First Aid & CPR"     => 420,
    "Basic Life Support (BLS)"     => 280,
    "Psychological First Aid"      => 500,
];

$total = 0;
$jumlah_kutipan = [];

// Semak sama ada kolum 'status_bayaran' wujud dalam jadual peserta
$cek = $conn->query("SHOW COLUMNS FROM peserta LIKE 'status_bayaran'");
$ada_status = $cek->num_rows > 0;

// Kira jumlah kutipan bagi setiap kursus
foreach ($kategori as $kursus => $yuran) {
    if ($ada_status) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS jumlah 
                                FROM peserta 
                                WHERE kategori = ? 
                                AND status_bayaran = 'Lunas'");
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) AS jumlah 
                                FROM peserta 
                                WHERE kategori = ?");
    }
    $stmt->bind_param("s", $kursus);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $jumlah = $result['jumlah'] ?? 0;

    $jumlah_kutipan[$kursus] = [
        'peserta' => $jumlah,
        'yuran'   => $yuran,
        'kutipan' => $jumlah * $yuran
    ];
    $total += $jumlah * $yuran;
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kewangan - MRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Rubik', sans-serif; background: #f8f9fa; margin:0; padding:0; }
        header { background-color:#d70000; color:white; padding:20px; text-align:center; }
        .container { max-width:960px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 0 20px rgba(215,0,0,0.1); }
        h2 { color:#d70000; text-align:center; margin-bottom:30px; }
        table { width:100%; border-collapse:collapse; margin-bottom:30px; }
        th,td { padding:14px; text-align:center; border:1px solid #ddd; }
        th { background-color:#fdd; }
        tr:nth-child(even) { background-color:#fff5f5; }
        tr:hover { background-color:#ffeaea; }
        .total { text-align:right; font-size:18px; font-weight:bold; margin-top:20px; }
        .btn { background-color:#d70000; color:white; padding:12px 24px; border-radius:8px; font-weight:bold; text-decoration:none; display:inline-block; transition:0.3s; }
        .btn:hover { background-color:#a80000; }
        .center { text-align:center; }
    </style>
</head>
<body>
<header><h1>Sistem Kewangan MRCS</h1></header>
<div class="container">
    <h2>Laporan Kutipan Mengikut Kategori Latihan</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori Latihan</th>
                <th>Yuran (RM)</th>
                <th>Peserta Bayar</th>
                <th>Jumlah Kutipan (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jumlah_kutipan as $kursus => $data): ?>
            <tr>
                <td><?= htmlspecialchars($kursus) ?></td>
                <td><?= number_format($data['yuran'], 2) ?></td>
                <td><?= $data['peserta'] ?></td>
                <td><?= number_format($data['kutipan'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="total">Jumlah Kutipan Keseluruhan: <strong>RM <?= number_format($total, 2) ?></strong></div>
    <div class="center"><a href="dashboard_finances.php" class="btn">← Kembali ke Dashboard</a></div>
</div>
</body>
</html>







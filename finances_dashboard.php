<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: finances_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kewangan - MRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #c82333;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .container {
            padding: 30px;
        }
        h2 {
            color: #c82333;
        }
        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 25px;
            margin: 20px auto;
            max-width: 700px;
        }
        .link-list {
            list-style-type: none;
            padding: 0;
        }
        .link-list li {
            margin: 15px 0;
        }
        .link-list a {
            text-decoration: none;
            font-size: 18px;
            color: #c82333;
            font-weight: bold;
            transition: 0.3s ease;
        }
        .link-list a:hover {
            color: #a71d2a;
            padding-left: 10px;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .logout-btn:hover {
            background: #b02a37;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Kewangan MRCS</h1>
</header>

<div class="container">
    <div class="dashboard-card">
        <h2>Selamat Datang, <?= $_SESSION['admin_nama'] ?>!</h2>

        <ul class="link-list">
            <li><a href="senarai_peserta_bayar.php">✔️ Semakan Pembayaran Peserta</a></li>
            <li><a href="import_transaksi.php">📥 Import Transaksi Bank</a></li>
            <li><a href="laporan_kewangan.php">📊 Laporan Kewangan</a></li>
            <li><a href="rekod_resit_invoice.php">🧾 Rekod Resit & Invois</a></li>
            <li><a href="senarai_belum_bayar.php">❌ Senarai Belum Bayar</a></li>
        </ul>

        <a href="logout_finance.php" class="logout-btn">Log Keluar</a>
    </div>
</div>

</body>
</html>



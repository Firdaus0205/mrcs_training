<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$admin_nama = $_SESSION['admin_nama'];
$syarikat = $_SESSION['syarikat'] ?? '-';
$telefon = $_SESSION['telefon'] ?? '-';
$alamat = $_SESSION['alamat'] ?? '-';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - MRCS</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e52d27, #b31217);
            color: #fff;
        }

        header {
            background-color: #fff;
            color: #b31217;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
        }

        .dashboard {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }

        .welcome {
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Quick Actions */
        .quick-actions {
            background: #fff3f3;
            color: #b31217;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .quick-actions h3 {
            margin: 0 0 15px 0;
            font-size: 20px;
            color: #b31217;
        }

        .quick-actions .btn {
            display: inline-block;
            margin: 6px 8px;
            padding: 10px 18px;
            background: #d32f2f;
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .quick-actions .btn:hover {
            background: #9a0007;
        }

        /* Butang logout */
        .btn-logout {
            background-color: #f44336;
            color: #fff !important;
        }
        .btn-logout:hover {
            background-color: #d32f2f;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #eee;
        }
    </style>
</head>
<body>
    <header>
        <h1>DASHBOARD ADMIN - MRCS Training System</h1>
    </header>

    <div class="dashboard">
        <div class="welcome">
            SELAMAT DATANG, <strong><?= htmlspecialchars($admin_nama) ?></strong>
        </div>

        <!-- Seksyen Quick Actions -->
        <div class="quick-actions">
            <h3>⚡ Quick Actions</h3>
            <a href="senarai_peserta.php" class="btn">👥 Senarai Peserta</a>
            <a href="kemaskini_peserta.php" class="btn">✏️ Kemaskini Peserta</a>
            <a href="update_result.php" class="btn">📑 Kemaskini Markah</a>
            <a href="result_training.php" class="btn">📊 Semak Keputusan</a>
            <a href="senarai_peserta_bayar.php" class="btn">💰 Senarai Peserta Bayar</a>
            <a href="cetak_sijil_admin.php" class="btn">📜 Cetak Sijil</a>
            
            <!-- Butang baru: Keseluruhan Markah -->
            <a href="proses_kemaskini_markah.php" class="btn">📝 Keseluruhan Markah</a>

            <a href="logout_admin.php" class="btn btn-logout">🚪 Log Keluar</a>
        </div>
    </div>

    <div class="footer">
        &copy; <?= date("Y") ?> Malaysian Red Crescent Society - Sistem Latihan MRCS
    </div>
</body>
</html>







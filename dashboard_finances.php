<?php
session_start();

// ⏳ Session timeout - 30 minit
$timeout_duration = 1800;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: finances_login.php?timeout=1");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// 🔒 Semak login
if (!isset($_SESSION['finance_id'])) {
    header("Location: finances_login.php");
    exit();
}

// 🧑 Nama pengguna
$nama_finance = $_SESSION['finance_nama'] ?? 'Finance Officer';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>MRCS Finance Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fffafa;
            color: #333;
        }

        header {
            background: #b40000;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 5px 0;
            font-size: 28px;
        }

        header p {
            margin: 0;
            font-size: 16px;
        }

        .back-login {
            text-align: center;
            margin-top: 15px;
        }

        .back-login a {
            display: inline-block;
            background: #f1f1f1;
            color: #b40000;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #b40000;
            transition: background 0.3s, color 0.3s;
        }

        .back-login a:hover {
            background: #b40000;
            color: white;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            padding: 30px;
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            text-align: center;
            transition: transform 0.25s;
            border-top: 6px solid #b40000;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 15px 0 10px;
            color: #b40000;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .card a {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 18px;
            background: #b40000;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #900000;
        }

        footer {
            margin-top: 40px;
            background: #111;
            color: #eee;
            text-align: center;
            padding: 15px;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 22px;
            }

            .card h3 {
                font-size: 16px;
            }

            .card p, .card a {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>💰 MRCS Finance Dashboard</h1>
    <p>Selamat datang, <b><?php echo htmlspecialchars($nama_finance); ?></b></p>
</header>

<!-- ✅ Butang kembali ke login -->
<div class="back-login">
    <a href="finances_login.php">⬅️ Kembali ke Laman Login</a>
</div>

<div class="container">
    <div class="card">
        <h3>📋 Semak Bayaran Peserta</h3>
        <p>Semak status bayaran peserta mengikut kursus.</p>
        <a href="senarai_peserta_bayar.php">Lihat Senarai</a>
    </div>

    <div class="card">
        <h3>⛔ Senarai Belum Bayar</h3>
        <p>Lihat peserta yang masih belum membuat bayaran.</p>
        <a href="senarai_belum_bayar.php">Papar Senarai</a>
    </div>

    <div class="card">
        <h3>🏦 Import Transaksi Bank</h3>
        <p>Import data transaksi bank untuk padanan automatik.</p>
        <a href="import_transaksi.php">Muat Naik CSV</a>
    </div>

    <div class="card">
        <h3>🧾 Rekod Resit & Invoice</h3>
        <p>Senarai dan cetakan rekod resit serta invoice peserta.</p>
        <a href="rekod_resit_invoice.php">Lihat Rekod</a>
    </div>

    <div class="card">
        <h3>📊 Laporan Kewangan</h3>
        <p>Papar laporan kewangan mengikut bulan & tahun.</p>
        <a href="laporan_kewangan.php">Jana Laporan</a>
    </div>

    <div class="card">
        <h3>🚪 Logout</h3>
        <p>Keluar dari sistem kewangan MRCS dengan selamat.</p>
        <a href="logout_finance.php">Log Keluar</a>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Malaysian Red Crescent Society (MRCS) - Finance System
</footer>

</body>
</html>



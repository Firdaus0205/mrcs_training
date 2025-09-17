<?php
session_start();

// Pastikan admin dah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pilih Kategori untuk Kemaskini Markah</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff9f9;
            text-align: center;
            padding: 50px;
        }
        h2 {
            color: #c8102e;
        }
        .btn-category {
            display: block;
            width: 300px;
            margin: 15px auto;
            padding: 15px;
            background-color: #c8102e;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-category:hover {
            background-color: #a40c24;
        }
        .btn-back {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 25px;
            background-color: white;
            color: #c8102e;
            border: 2px solid #c8102e;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #c8102e;
            color: white;
        }
    </style>
</head>
<body>

<h2>Pilih Kategori untuk Kemaskini Markah</h2>

<a href="update_result_introduction.php" class="btn-category">📘 Introduction First Aid</a>
<a href="update_result_basic.php" class="btn-category">🩺 Basic First Aid & CPR + AED</a>
<a href="update_result_advanced.php" class="btn-category">🏥 Advanced First Aid</a>
<a href="update_result_psychological.php" class="btn-category">🧠 Psychological First Aid</a>
<a href="update_result_bls.php" class="btn-category">❤️ Basic Life Support</a>

<!-- Butang kembali ke dashboard admin -->
<a href="admin_dashboard.php" class="btn-back">⬅ Kembali ke Dashboard Admin</a>

</body>
</html>

















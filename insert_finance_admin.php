<?php
include 'config.php';

$nama = "harmain";
$emel = "finance@mrcs.org";
$katalaluan = password_hash("MRCS@2025!@#", PASSWORD_DEFAULT);

$sql = "INSERT INTO finance_admin (nama, emel, katalaluan) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nama, $emel, $katalaluan);
$stmt->execute();

echo "✅ Admin dimasukkan dengan katalaluan HASH.";
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin Kewangan - MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .box img {
            width: 80px;
            margin-bottom: 20px;
        }
        .status-success {
            color: green;
            font-weight: bold;
        }
        .status-error {
            color: red;
            font-weight: bold;
        }
        .btn {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #c20000;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #a00000;
        }
    </style>
</head>
<body>
    <div class="box">
        <img src="logo_mrcs.jpg" alt="MRCS Logo">
        <h2>Tambah Admin Kewangan</h2>
        <p class="status-<?= $status ?>"><?= htmlspecialchars($message) ?></p>
        <a class="btn" href="finances_login.php">Ke Login Kewangan</a>
    </div>
</body>
</html>

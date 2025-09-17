<?php
session_start();
if (!isset($_SESSION['finance_id'])) {
    header("Location: finances_login.php");
    exit();
}
include 'config.php';

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $no_kp = $data[0];
            $jumlah = $data[1];
            $status = strtoupper($data[2]);

            // Cari peserta berdasarkan no_kp
            $sql = "SELECT id FROM peserta WHERE no_kp = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no_kp);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $peserta = $result->fetch_assoc();
                $peserta_id = $peserta['id'];

                // Insert atau Update bayaran
                $check = $conn->prepare("SELECT * FROM bayaran WHERE peserta_id = ?");
                $check->bind_param("i", $peserta_id);
                $check->execute();
                $res = $check->get_result();

                if ($res->num_rows > 0) {
                    $update = $conn->prepare("UPDATE bayaran SET jumlah_bayar = ?, status = ? WHERE peserta_id = ?");
                    $update->bind_param("dsi", $jumlah, $status, $peserta_id);
                    $update->execute();
                } else {
                    $insert = $conn->prepare("INSERT INTO bayaran (peserta_id, jumlah_bayar, status) VALUES (?, ?, ?)");
                    $insert->bind_param("ids", $peserta_id, $jumlah, $status);
                    $insert->execute();
                }
            }
        }
        fclose($handle);
        $msg = "✅ Transaksi berjaya diimport!";
    } else {
        $msg = "❌ Gagal membuka fail.";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Import Transaksi Bank - MRCS</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background-color: #f4f4f4; }
        .form-container { background: white; padding: 30px; border-radius: 10px; width: 500px; margin: auto; }
        h2 { color: #c20000; }
        input[type="file"] { margin-top: 15px; }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #c20000;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .msg { margin-top: 20px; font-weight: bold; color: green; }
        .btn-kembali {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #c20000;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<a class="btn-kembali" href="dashboard_finances.php">← Kembali ke Dashboard</a>

<div class="form-container">
    <h2>Import Transaksi Bayaran Peserta (CSV)</h2>

    <?php if ($msg): ?>
        <div class="msg"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Pilih Fail CSV:</label><br>
        <input type="file" name="csv_file" accept=".csv" required><br>
        <button type="submit">Import</button>
    </form>
</div>
</body>
</html>

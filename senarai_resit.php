<?php
session_start();
include 'config.php';

if (!isset($_SESSION['peserta_id'])) {
    header("Location: login_peserta.php");
    exit();
}

$peserta_id = $_SESSION['peserta_id'];
$result = $conn->query("SELECT * FROM resit ORDER BY tarikh_bayar DESC");

?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Resit - MRCS</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }
        h2 {
            color: #b40000;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #b40000;
            color: white;
        }
        .btn-kembali {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background: #b40000;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<h2>📄 Senarai Resit Pembayaran Anda</h2>

<table>
    <tr>
        <th>Tarikh</th>
        <th>Latihan</th>
        <th>Jumlah (RM)</th>
        <th>Bukti Pembayaran</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= date('d/m/Y H:i', strtotime($row['tarikh'])) ?></td>
        <td><?= htmlspecialchars($row['latihan']) ?></td>
        <td><?= htmlspecialchars($row['jumlah']) ?></td>
        <td>
            <a href="<?= htmlspecialchars($row['bukti']) ?>" target="_blank">📥 Lihat</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="index_peserta.php" class="btn-kembali">← Kembali ke Dashboard</a>

</body>
</html>

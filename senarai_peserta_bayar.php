<?php
session_start();
if (!isset($_SESSION['finance_id'])) {
    header("Location: finances_login.php");
    exit();
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Peserta Bayar - MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #c20000;
            color: white;
        }

        h2 {
            color: #c20000;
        }

        .status-lulus {
            color: green;
            font-weight: bold;
        }

        .status-gagal {
            color: red;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #c20000;
        }

        .btn-kembali {
            display: inline-block;
            padding: 8px 16px;
            background-color: #c20000;
            color: white;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .btn-kembali:hover {
            background-color: #a00000;
        }
    </style>
</head>
<body>

<a class="btn-kembali" href="dashboard_finances.php">← Kembali ke Dashboard</a>
<h2>Senarai Peserta Yang Telah Membuat Bayaran</h2>

<table>
    <tr>
        <th>Bil</th>
        <th>Nama Peserta</th>
        <th>No. Kad Pengenalan</th>
        <th>Kursus</th>
        <th>Jumlah Bayaran (RM)</th>
        <th>Status</th>
    </tr>

    <?php
    $sql = "
        SELECT 
            p.nama, 
            p.no_ic, 
            k.nama_kursus,
            b.jumlah,
            b.status_bayaran
        FROM bayaran b
        JOIN peserta p ON p.id = b.peserta_id
        LEFT JOIN kursus k ON p.latihan_id = k.id
        WHERE b.status_bayaran = 'LULUS'
        ORDER BY p.nama ASC
    ";

    $result = $conn->query($sql);
    $bil = 1;

    if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $bil++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ic']) ?></td>
                <td><?= htmlspecialchars($row['nama_kursus'] ?? '-') ?></td>
                <td><?= number_format($row['jumlah'], 2) ?></td>
                <td class="status-lulus"><?= htmlspecialchars($row['status_bayaran']) ?></td>
            </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6">Tiada rekod bayaran.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>





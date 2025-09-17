<?php
include 'config.php';

$sql = "SELECT p.id, p.nama, p.no_ic, p.syarikat, r.nama_fail, r.tarikh
        FROM peserta p
        LEFT JOIN resit r ON p.id = r.peserta_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Semakan Resit Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #c4002f;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            text-align: center;
            border: 1px solid #eee;
        }

        th {
            background-color: #c4002f;
            color: white;
            font-size: 15px;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status-bayar {
            font-weight: bold;
            color: green;
        }

        .status-belum {
            font-weight: bold;
            color: red;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #c4002f;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.15);
        }

        .btn-back:hover {
            background-color: #a00026;
            transform: scale(1.03);
        }

        a.papar-resit {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a.papar-resit:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>📑 Semakan Resit Pembayaran Peserta MRCS</h2>

<table>
    <tr>
        <th>Nama Peserta</th>
        <th>No. IC</th>
        <th>Organisasi</th>
        <th>Status Bayaran</th>
        <th>Resit</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['no_ic']) ?></td>
            <td><?= htmlspecialchars($row['syarikat']) ?></td>
            <?php if (!empty($row['fail_resit'])): ?>
                <td class="status-bayar">✅ Sudah Bayar</td>
                <td>
                    <a class="papar-resit" href="resit_uploads/<?= urlencode($row['fail_resit']) ?>" target="_blank">📄 Papar Resit</a>
                </td>
            <?php else: ?>
                <td class="status-belum">❌ Belum Bayar</td>
                <td>—</td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
</table>

<div style="text-align:center;">
    <a href="admin_dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
</div>

</body>
</html>



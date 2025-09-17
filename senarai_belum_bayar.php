<?php
session_start();
include 'config.php';

// Semak login kewangan
if (!isset($_SESSION['finance_id'])) {
    header("Location: finances_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Belum Bayar - MRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #d70000;
        }
        header {
            background-color: #d70000;
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
        }
        h2 {
            margin-top: 30px;
            text-align: center;
            color: #d70000;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(215, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #d70000;
        }
        th {
            background-color: #d70000;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #ffe6e6;
        }
        .back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
        }
        .back-link a {
            background-color: #d70000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .back-link a:hover {
            background-color: #a80000;
        }
    </style>
</head>
<body>

<header>
    Sistem Kewangan MRCS
</header>

<div class="container">
    <h2>Senarai Peserta Belum Membayar</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>No. Kad Pengenalan</th>
            <th>Syarikat</th>
            <th>Kursus</th>
        </tr>

        <?php
        $no = 1;

        // Semak kewujudan jadual bayaran
        $checkTable = $conn->query("SHOW TABLES LIKE 'bayaran'");
        if ($checkTable && $checkTable->num_rows > 0) {
            // Jika jadual bayaran wujud
            $query = "
                SELECT 
                    p.id, 
                    p.nama, 
                    p.no_ic, 
                    p.syarikat, 
                    COALESCE(k.nama_kursus, p.nama_kursus, '-') AS kursus
                FROM peserta p
                LEFT JOIN kursus k ON p.latihan_id = k.id
                LEFT JOIN bayaran b ON b.peserta_id = p.id
                WHERE b.status_bayaran IS NULL OR b.status_bayaran != 'LULUS'
                GROUP BY p.id, p.nama, p.no_ic, p.syarikat, kursus
            ";
        } else {
            // Jika jadual bayaran tiada, papar semua peserta bersama kursus
            $query = "
                SELECT 
                    p.id, 
                    p.nama, 
                    p.no_ic, 
                    p.syarikat, 
                    COALESCE(k.nama_kursus, p.nama_kursus, '-') AS kursus
                FROM peserta p
                LEFT JOIN kursus k ON p.latihan_id = k.id
            ";
        }

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['no_ic']) ?></td>
            <td><?= htmlspecialchars($row['syarikat']) ?></td>
            <td><?= htmlspecialchars($row['kursus']) ?></td>
        </tr>
        <?php
            endwhile;
        else:
        ?>
        <tr>
            <td colspan="5">Tiada peserta yang belum membayar.</td>
        </tr>
        <?php endif; ?>
    </table>

    <div class="back-link">
        <a href="dashboard_finances.php">← Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>









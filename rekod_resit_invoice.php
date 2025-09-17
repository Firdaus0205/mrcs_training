<?php
session_start();
include 'config.php';

// Semak pengguna sudah login berdasarkan session finance_id
if (!isset($_SESSION['finance_id'])) {
    echo '<!DOCTYPE html>
    <html lang="ms">
    <head><meta charset="UTF-8"><title>Akses Tidak Sah</title></head>
    <body style="font-family:Arial, sans-serif; background:#f9f9f9; text-align:center; padding:100px;">
        <h2 style="color:#d70000;">Sila log masuk dahulu untuk mengakses halaman ini.</h2>
        <a href="finances_login.php" style="color:#fff; background:#d70000; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:bold;">Ke Halaman Login</a>
    </body></html>';
    exit;
}

// Dapatkan semua peserta, susun ikut tarikh daftar terbaru
$sql = "SELECT * FROM peserta ORDER BY tarikh_daftar DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Rekod Resit & Invois - Sistem Kewangan MRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f9f9f9;
            margin: 0; padding: 0;
        }
        header {
            background-color: #d70000;
            color: #fff;
            text-align: center;
            padding: 25px 0;
            font-size: 28px;
            font-weight: bold;
        }
        .container {
            background-color: #fff;
            max-width: 1100px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(215, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #d70000;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 14px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #d70000;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #fff5f5;
        }
        tr:hover {
            background-color: #ffe5e5;
        }
        .btn {
            background-color: #d70000;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #a80000;
        }
        .center {
            text-align: center;
        }
        .tiada-rekod {
            text-align: center;
            font-style: italic;
            color: #999;
            margin-top: 30px;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                text-align: left;
                background-color: #d70000;
                color: #fff;
                padding: 10px;
            }
            td {
                text-align: left;
                padding: 10px;
                border: none;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

<header>
    Sistem Kewangan MRCS
</header>

<div class="container">
    <h2>Senarai Peserta Terdaftar</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Kursus</th>
                    <th>Kategori</th>
                    <th>Yuran (RM)</th>
                    <th>Tarikh Daftar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($i++); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo !empty($row['nama_kursus']) ? htmlspecialchars($row['nama_kursus']) : '-'; ?></td>
                    <td><?php echo !empty($row['kategori']) ? htmlspecialchars($row['kategori']) : '-'; ?></td>
                    <td><?php echo number_format(floatval($row['yuran']), 2); ?></td>
                    <td><?php echo !empty($row['tarikh_daftar']) ? date('d/m/Y H:i', strtotime($row['tarikh_daftar'])) : '-'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="tiada-rekod">Tiada peserta berdaftar ditemui.</p>
    <?php endif; ?>

    <div class="center">
        <a href="dashboard_finances.php" class="btn">← Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>























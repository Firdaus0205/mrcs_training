<?php
include 'config.php';

$row = null; // Set awal supaya tidak undefined

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM peserta WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Maklumat Penuh Peserta - MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #b30000;
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        td:first-child {
            font-weight: bold;
            width: 200px;
            background-color: #f9f9f9;
        }
        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background: #444;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-back:hover {
            background: #222;
        }
        .error {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Maklumat Penuh Peserta - MRCS</h2>

        <?php if ($row): ?>
            <table>
                <tr>
                    <td>Nama</td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                </tr>
                <tr>
                    <td>No. Kad Pengenalan</td>
                    <td><?= htmlspecialchars($row['no_ic']) ?></td>
                </tr>
                <tr>
                    <td>Syarikat / Organisasi</td>
                    <td><?= htmlspecialchars($row['syarikat']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= nl2br(htmlspecialchars($row['alamat'])) ?></td>
                </tr>
                <tr>
                    <td>No. Telefon</td>
                    <td><?= htmlspecialchars($row['telefon']) ?></td>
                </tr>
                <tr>
                    <td>Emel</td>
                    <td><?= htmlspecialchars($row['emel']) ?></td>
                </tr>
                <tr>
                    <td>Kategori Latihan</td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                </tr>
                <tr>
                    <td>Nama Kursus</td>
                    <td><?= htmlspecialchars($row['nama_kursus']) ?></td>
                </tr>
                <tr>
                    <td>Bulan Penyertaan</td>
                    <td><?= htmlspecialchars($row['bulan']) ?></td>
                </tr>
                <tr>
                    <td>Tarikh Daftar</td>
                    <td><?= htmlspecialchars($row['tarikh_daftar']) ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p class="error">❌ Peserta tidak dijumpai dalam sistem atau ID tidak sah.</p>
        <?php endif; ?>

        <a href="senarai_peserta.php" class="btn-back">← Kembali ke Senarai Peserta</a>
    </div>
</body>
</html>




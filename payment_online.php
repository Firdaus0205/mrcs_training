<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>❌ ID peserta tidak diberikan.</p>";
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT nama, kategori, yuran FROM peserta WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<p style='color:red;'>❌ Peserta tidak dijumpai dalam sistem atau ID tidak sah.</p>";
    exit;
}

$row = $result->fetch_assoc();
$nama        = $row['nama'];
$nama_kursus = $row['kategori'];
$jumlah      = $row['yuran']; // ✅ Ambil terus dari DB
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Online MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 40px;
            color: #333;
        }
        .container {
            max-width: 750px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        h2 { color: #b60000; }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        td:first-child {
            font-weight: bold;
            background-color: #f4f4f4;
            width: 200px;
        }
        .btn {
            margin-top: 25px;
            padding: 10px 25px;
            background-color: #b60000;
            color: white;
            border: none;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
        .btn:hover { background-color: #8f0000; }
        .qr-section {
            margin-top: 30px;
            text-align: center;
        }
        .qr-section img { width: 200px; height: auto; }
        .fpx-button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .fpx-button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h2>Pembayaran Online MRCS</h2>

    <table>
        <tr>
            <td>Nama Peserta:</td>
            <td><?= htmlspecialchars($nama) ?></td>
        </tr>
        <tr>
            <td>Kursus:</td>
            <td><?= htmlspecialchars($nama_kursus) ?></td>
        </tr>
        <tr>
            <td>Jumlah Bayaran:</td>
            <td>RM <?= number_format($jumlah, 2) ?></td>
        </tr>
    </table>

    <div class="info">
        <p>Sila buat pembayaran ke akaun berikut:</p>
        <p><strong>Nama Akaun:</strong> MALAYSIAN RED CRESCENT SOCIETY</p>
        <p><strong>No. Akaun:</strong> 514422105668 (Maybank)</p>
    </div>

    <div class="qr-section">
        <p><strong>Imbas QR Maybank di bawah untuk pembayaran terus:</strong></p>
        <img src="images/qr_maybank_mrcs.png" alt="QR Maybank MRCS">
    </div>

    <div class="qr-section">
        <p><strong>Atau bayar secara atas talian (FPX):</strong></p>
        <a href="https://toyyibpay.com/mrcs-payment" class="fpx-button" target="_blank">🏦 Klik Sini Untuk Bayar (FPX Semua Bank)</a>
    </div>

    <a href="dashboard_peserta.php" class="btn">← Kembali ke Dashboard</a>

    <div style="margin-top: 40px;">
        <p><strong>Untuk makluman:</strong> Fail versi PDF MRCS telah dilampirkan bersama emel ini.</p>
        <p><strong>Sila muat turun melalui pautan berikut:</strong><br>
        <a href="https://contoh-link.com/MRCS_PDF.pdf" target="_blank" style="color: #0066cc;">
            Muat Turun MRCS PDF
        </a></p>
    </div>
</div>
</body>
</html>


















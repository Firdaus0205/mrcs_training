<?php
session_start();
if (!isset($_SESSION['peserta_id'])) {
    header("Location: login_peserta.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Peserta - MRCS</title>
</head>
<body>
    <h2>Selamat Datang, <?= $_SESSION['peserta_nama'] ?>!</h2>

    <p>Anda telah berjaya log masuk ke sistem MRCS.</p>

    <!-- Paparan lain seperti status bayaran, sijil, maklumat latihan dll -->
</body>
</html>


<h2>Pembayaran Online MRCS</h2>
<p>Sila buat pembayaran secara atas talian melalui FPX (Online Banking semua bank).</p>
<p><strong>Nama Akaun:</strong> MALAYSIAN RED CRESCENT SOCIETY</p>
<p><strong>No. Akaun:</strong> 514422105668 (Maybank)</p>

<a href="https://toyyibpay.com/mrcs-payment" class="btn btn-success" target="_blank">
    🏦 Klik Sini Untuk Bayar (FPX Semua Bank)
</a>

<p><em>Sila pastikan anda isi <strong>nama penuh</strong> dan <strong>kategori latihan</strong> semasa membuat bayaran.</em></p>

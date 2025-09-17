<?php
session_start();
include 'config.php';

$peserta_id = $_SESSION['peserta_id'] ?? null;

// Senarai kursus & harga
$kursus = [
    'Introduction First Aid & CPR' => 230,
    'Basic First Aid & CPR + AED' => 350,
    'Advanced First Aid & CPR' => 420,
    'Basic Life Support (BLS)' => 280,
    'Psychological First Aid' => 500
];
?>

<h2>💳 Pembayaran Latihan MRCS</h2>
<form method="GET" action="redirect_to_payment.php">
    <label for="kursus">Pilih Kursus:</label>
    <select name="kursus" required>
        <option value="">-- Sila Pilih --</option>
        <?php foreach ($kursus as $nama => $harga): ?>
            <option value="<?= htmlspecialchars($nama) ?>"><?= $nama ?> (RM<?= $harga ?>)</option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="peserta_id" value="<?= $peserta_id ?>">
    <br><br>
    <button type="submit">Bayar Sekarang</button>
</form>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Online MRCS</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f9f9f9;
            padding: 30px;
            text-align: center;
        }

        .payment-box {
            background: white;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .qr-image {
            width: 200px;
            margin-bottom: 20px;
        }

        .btn-fpx {
            background-color: #d80027;
            color: white;
            padding: 14px 30px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
        }

        .btn-fpx:hover {
            background-color: #a0001b;
        }
    </style>
</head>
<body>

<div class="payment-box">
    <h2>Pembayaran Online MRCS</h2>

    <img src="qr_maybank.jpg" alt="Kod QR Maybank" class="qr-image"><br>

    <p><strong>Nama Akaun:</strong> MALAYSIAN RED CRESCENT SOCIETY</p>
    <p><strong>No. Akaun:</strong> 514422105668</p>
    <p><strong>Bank:</strong> Maybank</p>
    <p><strong>Rujukan:</strong> [Nama Peserta] - [Kategori Latihan]</p>

    <hr>

    <p>Atau bayar secara FPX Online:</p>
    <a class="btn-fpx" target="_blank" href="https://toyyibpay.com/mrcs-latihan">
        💳 Pilih Bank & Bayar Online (FPX)
    </a>
    <a href="index_peserta.php">
</a>

</div>
<a href="index_peserta.php" style="text-decoration: none;">
    <button style="background-color: #c62828; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
        ← Kembali
    </button>
</a>

</body>
</html>

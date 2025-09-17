<?php
session_start();
include 'config.php';

// ✅ Pastikan nilai ini ditentukan awal
$is_warga_emas = isset($_GET['warga_emas']) && $_GET['warga_emas'] == '1';

// Contoh rujukan bayaran
$ref = "MRCS-" . time();
?>


<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Online MRCS</title>
    <style>
        .btn-emas {
    display: inline-block;
    padding: 12px 25px;
    margin: 10px;
    background-color: #666666; /* Kelabu lembut */
    color: white;
    text-decoration: none;
    font-size: 16px;
    border-radius: 6px;
    font-weight: bold;
}

        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 40px; text-align: center; }
        .box {
            background: white; padding: 30px; border-radius: 10px;
            max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn { background: #b40000; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; }
        img { margin-top: 20px; }
        .info { text-align: left; margin-top: 30px; }
    </style>
</head>
<body>

<div class="box">
    <h2>Pembayaran Latihan MRCS</h2>
    <p>Anda boleh membuat bayaran melalui QR code atau secara manual ke akaun bank kami.</p>

    <!-- QR Code (optional) -->
    <img src="qr_maybank.jpg" alt="QR Bayaran" width="180"><br><br>

    <!-- Manual Bank Info -->
    <div class="info">
        <p><strong>Nama Akaun:</strong> MALAYSIAN RED CRESCENT SOCIETY</p>
        <p><strong>No. Akaun:</strong> 514422105668</p>
        <p><strong>Bank:</strong> Maybank</p>
        <p><strong>Jumlah:</strong> RM10.00</p>
        <p><strong>Rujukan Bayaran:</strong> <?php echo $ref; ?></p>
        <hr>
        <p>Jika anda tidak tahu guna QR atau online, sila buat bayaran di ATM atau kaunter bank.</p>
        <p>Kemudian, sila <strong>WhatsApp resit ke 012-3456789</strong> atau <strong>muat naik resit anda</strong> di bawah.</p>
    </div>

    <!-- Upload resit (optional) -->
    <form action="upload_resit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="ref" value="<?php echo $ref; ?>">
    <label for="resit">Muat naik gambar resit bayaran:</label><br>
    <input type="file" name="resit" id="resit" accept="image/*" required><br><br>
    <button type="submit" class="btn">Hantar Resit</button>
    <a href="index_peserta.php" class="btn">Kembali</a>
    </form>
</div>
</body>
</html>


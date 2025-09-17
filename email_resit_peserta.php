<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Data peserta dari sistem
$nama = "Ahmad Bin Ali";
$ic = "900101-01-1234";
$program = "Bengkel Kecemasan MRCS 2025";
$tarikh_bayar = "5 Ogos 2025";
$jumlah = "RM120.00";
$rujukan = "TXN-MRCS2025-000123";
$email_peserta = "ahmad@email.com"; // <-- Emel peserta

// Konfigurasi PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP setup
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';       // Ganti dengan SMTP sebenar
    $mail->SMTPAuth = true;
    $mail->Username = 'you@example.com';    // Emel anda
    $mail->Password = 'yourpassword';       // Kata laluan emel
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Emel pengirim
    $mail->setFrom('mrcs.registration@redcrescent.org.my', 'MRCS Registration');
    $mail->addAddress($email_peserta, $nama);

    // Kandungan emel
    $mail->isHTML(true);
    $mail->Subject = 'Resit Pembayaran – MRCS 2025';

    $body = "
    <p>Assalamualaikum & Salam Sejahtera,</p>
    <p>Tuan/Puan,</p>
    <p>Terima kasih kerana mendaftar sebagai peserta <strong>Malaysian Red Crescent Society (MRCS)</strong>.</p>
    <p><strong>Butiran Pembayaran:</strong></p>
    <ul>
        <li><strong>Nama:</strong> $nama</li>
        <li><strong>No. Kad Pengenalan:</strong> $ic</li>
        <li><strong>Program:</strong> $program</li>
        <li><strong>Tarikh Pembayaran:</strong> $tarikh_bayar</li>
        <li><strong>Jumlah Bayaran:</strong> $jumlah</li>
        <li><strong>Rujukan Transaksi:</strong> $rujukan</li>
    </ul>
    <p>Resit rasmi ini adalah pengesahan bahawa pembayaran telah diterima oleh pihak MRCS.</p>
    <p>Sekian, terima kasih.</p>
    <p><em>Urus Setia Pendaftaran</em><br>Malaysian Red Crescent Society (MRCS)</p>
    ";

    $mail->Body = $body;

    // Hantar emel
    $mail->send();
    echo 'Emel resit berjaya dihantar.';
} catch (Exception $e) {
    echo "Gagal hantar emel. Ralat: {$mail->ErrorInfo}";
}

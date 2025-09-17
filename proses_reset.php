<?php
session_start();

// **KONFIGURASI DATABASE (ubah ikut sistem anda)**
$host = "localhost";
$dbname = "mrcs_training";
$username = "root";
$password = "";

// Sambungkan ke DB
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Sambungan ke pangkalan data gagal: " . $e->getMessage());
}

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emel = filter_var($_POST['emel'], FILTER_VALIDATE_EMAIL);

    if (!$emel) {
        $_SESSION['msg'] = "Emel tidak sah. Sila masukkan emel yang betul.";
        $_SESSION['msg_type'] = "error";
        header("Location: lupa_kata_laluan.php");
        exit;
    }

    // Semak email dalam DB peserta
    $stmt = $pdo->prepare("SELECT id, nama FROM peserta WHERE emel = ?");
    $stmt->execute([$emel]);
    $peserta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peserta) {
        // Untuk keselamatan, jangan dedahkan jika email tak wujud
        $_SESSION['msg'] = "Jika emel wujud dalam sistem MRCS, pautan reset kata laluan akan dihantar.";
        $_SESSION['msg_type'] = "success";
        header("Location: lupa_kata_laluan.php");
        exit;
    }

    // Generate token unik (contoh 64 karakter)
    $token = bin2hex(random_bytes(32));
    $tarikh_luput = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Simpan token dan tarikh luput ke table reset_password (atau table lain ikut sistem)
    $stmt = $pdo->prepare("INSERT INTO reset_password (peserta_id, token, tarikh_luput) VALUES (?, ?, ?)");
    $stmt->execute([$peserta['id'], $token, $tarikh_luput]);

    // Siapkan link reset (ubah URL ikut domain anda)
    $link_reset = "https://www.mrcs.org.my/reset_kata_laluan.php?token=$token";

    // Hantar emel menggunakan PHPMailer
    $mail = new PHPMailer(true);
    try {
        // SMTP Config (ubah ikut SMTP anda)
        $mail->isSMTP();
        $mail->Host = 'smtp.mrcs.org.my';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@mrcs.org.my';
        $mail->Password = 'yourpassword';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('noreply@mrcs.org.my', 'MRCS Registration');
        $mail->addAddress($email, $peserta['nama']);

        $mail->isHTML(true);
        $mail->Subject = 'Permintaan Reset Kata Laluan MRCS';

        $mailBody = "
        <p>Assalamualaikum & Salam Sejahtera,</p>
        <p>Tuan/Puan <strong>{$peserta['nama']}</strong>,</p>
        <p>Anda telah membuat permintaan untuk reset kata laluan akaun peserta MRCS.</p>
        <p>Sila klik pautan di bawah untuk menetapkan kata laluan baru anda. Pautan ini sah selama 1 jam sahaja.</p>
        <p><a href='$link_reset' style='color:#b30000;'>$link_reset</a></p>
        <p>Jika anda tidak membuat permintaan ini, sila abaikan emel ini.</p>
        <p>Terima kasih.<br><em>Urus Setia Pendaftaran<br>Malaysian Red Crescent Society (MRCS)</em></p>
        ";

        $mail->Body = $mailBody;
        $mail->send();

        $_SESSION['msg'] = "Jika emel wujud dalam sistem MRCS, pautan reset kata laluan telah dihantar ke emel anda.";
        $_SESSION['msg_type'] = "success";

    } catch (Exception $e) {
        $_SESSION['msg'] = "Gagal hantar emel. Sila cuba lagi nanti.";
        $_SESSION['msg_type'] = "error";
    }

    header("Location: lupa_kata_laluan.php");
    exit;
} else {
    // Akses selain POST akan terus redirect ke lupa kata laluan
    header("Location: lupa_kata_laluan.php");
    exit;
}

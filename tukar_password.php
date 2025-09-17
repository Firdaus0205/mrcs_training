<?php
session_start();
require 'config.php'; // Sambungan ke database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload

// Semak jika peserta sudah login
if (!isset($_SESSION['user_id'])) {
    die("❌ Akses ditolak. Sila login dahulu.");
}

$id_peserta = $_SESSION['user_id'];
$mesej = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $password_sah  = $_POST['password_sah'];

    // Semakan padanan password baru
    if ($password_baru !== $password_sah) {
        $mesej = "❌ Kata laluan baru dan pengesahan tidak sepadan.";
    } else {
        // Ambil password semasa dari DB
        $stmt = $conn->prepare("SELECT password, email, nama FROM peserta WHERE id = ?");
        $stmt->bind_param("i", $id_peserta);
        $stmt->execute();
        $stmt->bind_result($password_db, $email_peserta, $nama_peserta);
        $stmt->fetch();
        $stmt->close();

        // Sahkan password lama betul
        if (!password_verify($password_lama, $password_db)) {
            $mesej = "❌ Kata laluan lama tidak sah.";
        } else {
            // Hash dan simpan password baru
            $password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE peserta SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $password_baru_hash, $id_peserta);
            $stmt->execute();
            $stmt->close();

            // Hantar notifikasi emel
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; // ← Ganti kepada SMTP sebenar
                $mail->SMTPAuth = true;
                $mail->Username = 'mrcs.registration@redcrescent.org.my'; // ← Akaun MRCS
                $mail->Password = 'yourpassword'; // ← Kata laluan emel
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('mrcs.registration@redcrescent.org.my', 'MRCS Registration');
                $mail->addAddress($email_peserta, $nama_peserta);

                $mail->isHTML(true);
                $mail->Subject = 'Pengesahan Penukaran Kata Laluan – MRCS';
                $mail->Body = "
                <p>Assalamualaikum & Salam Sejahtera <strong>$nama_peserta</strong>,</p>
                <p>Makluman bahawa kata laluan untuk akaun anda telah berjaya dikemas kini melalui sistem rasmi <strong>Malaysian Red Crescent Society (MRCS)</strong>.</p>
                <p>Jika ini bukan tindakan anda, sila maklumkan segera kepada pihak pengurusan MRCS di <a href='mailto:mrcs.security@redcrescent.org.my'>mrcs.security@redcrescent.org.my</a>.</p>
                <p>Terima kasih atas kerjasama anda.</p>
                <p><em>Urus Setia Pendaftaran</em><br>Malaysian Red Crescent Society (MRCS)</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                // Emel gagal dihantar (log jika perlu)
            }

            $mesej = "✅ Kata laluan berjaya dikemaskini.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tukar Kata Laluan – MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #b30000;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="password"], button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #b30000;
            color: white;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        .message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            color: #d9534f;
        }
        .message.success {
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tukar Kata Laluan</h2>

    <?php if ($mesej): ?>
        <div class="message <?= strpos($mesej, '✅') !== false ? 'success' : '' ?>">
            <?= htmlspecialchars($mesej) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="password_lama">Kata Laluan Lama:</label>
        <input type="password" name="password_lama" id="password_lama" required>

        <label for="password_baru">Kata Laluan Baru:</label>
        <input type="password" name="password_baru" id="password_baru" required>

        <label for="password_sah">Sahkan Kata Laluan Baru:</label>
        <input type="password" name="password_sah" id="password_sah" required>

        <button type="submit">Kemaskini Kata Laluan</button>
    </form>
</div>

</body>
</html>

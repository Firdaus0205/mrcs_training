<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function hantarEmelPengesahan($nama, $emel, $id) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'akaun@gmail.com'; // tukar
        $mail->Password = 'app-password';   // guna App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('akaun@gmail.com', 'MRCS Training');
        $mail->addAddress($emel, $nama);

        $mail->isHTML(true);
        $mail->Subject = 'Pengesahan Pendaftaran MRCS';
        $mail->Body = "
            <h3>Terima kasih $nama!</h3>
            <p>Sila klik pautan di bawah untuk sahkan pendaftaran anda:</p>
            <a href='http://localhost/mrcs_training_system/verify.php?id=$id'>✅ Sahkan Pendaftaran</a>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

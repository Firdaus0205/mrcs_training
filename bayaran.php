<?php
session_start();
include 'config.php';

if (!isset($_SESSION['peserta_id'])) {
    header("Location: index_peserta.php");
    exit();
}

$peserta_id = $_SESSION['peserta_id'];

// contoh: harga RM10
$amount = 10.00;
$category = "Pertolongan Cemas Asas";
$ref = "MRCS-" . time(); // unik

// Simpan ke dalam table payments
$stmt = $conn->prepare("INSERT INTO payments (peserta_id, amount, training_category, payment_ref) VALUES (?, ?, ?, ?)");
$stmt->bind_param("idss", $peserta_id, $amount, $category, $ref);
$stmt->execute();
$payment_id = $stmt->insert_id;

// Redirect ke toyyibPay (atau link pembayaran manual)
$toyyibpay_url = "https://toyyibpay.com/example-payment-link"; // GANTI DENGAN LINK SEBENAR

header("Location: $toyyibpay_url");
exit();

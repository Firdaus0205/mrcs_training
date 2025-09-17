<?php
session_start();
include 'config.php';

// Pastikan hanya POST yang dibenarkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $peserta_id = $_SESSION['peserta_id'] ?? 0; // fallback jika tidak login
    $rujukan = $_POST['ref'] ?? 'MRCS-MANUAL';
    
    // Semak fail dimuat naik
    if (isset($_FILES['resit']) && $_FILES['resit']['error'] === 0) {
        $nama_fail_asal = $_FILES['resit']['name'];
        $tmp = $_FILES['resit']['tmp_name'];
        $ext = pathinfo($nama_fail_asal, PATHINFO_EXTENSION);

        // Hanya benarkan fail tertentu
        $dibolehkan = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array(strtolower($ext), $dibolehkan)) {
            die("Fail mesti dalam format JPG, PNG atau PDF sahaja.");
        }

        $fail_baru = 'resit_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        $folder = 'uploads/resit/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (move_uploaded_file($tmp, $folder . $fail_baru)) {
            // Simpan rekod dalam DB
            $stmt = $conn->prepare("INSERT INTO resit_pembayaran (peserta_id, rujukan, fail_resit) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $peserta_id, $rujukan, $fail_baru);
            $stmt->execute();

            echo "<!DOCTYPE html>
            <html lang='ms'>
            <head>
                <meta charset='UTF-8'>
                <title>Resit Dihantar</title>
                <style>
                    body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; padding: 50px; }
                    .box { background: #fff; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .btn { background: #b40000; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class='box'>
                    <h2>Resit Berjaya Dihantar</h2>
                    <p>Terima kasih! Resit anda telah dimuat naik dan akan disemak oleh pihak MRCS.</p>
                    <a href='peserta_dashboard.php' class='btn'>Kembali ke Dashboard</a>
                </div>
            </body>
            </html>";
            exit();
        } else {
            die("Gagal muat naik fail. Sila cuba semula.");
        }
    } else {
        die("Sila pilih fail resit yang sah.");
    }
} else {
    header("Location: peserta_dashboard.php");
    exit();
}


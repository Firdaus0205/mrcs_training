<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

date_default_timezone_set('Asia/Kuala_Lumpur');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['markah'])) {
    foreach ($_POST['markah'] as $peserta_id => $kategori_data) {
        foreach ($kategori_data as $kategori => $markah) {
            $peserta_id = intval($peserta_id);
            $kategori = mysqli_real_escape_string($conn, $kategori);
            $markah = intval($markah);

            // Semak jika rekod markah sudah wujud
            $check_sql = "SELECT id FROM markah WHERE peserta_id = $peserta_id AND kategori = '$kategori'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                // Update
                $row = $check_result->fetch_assoc();
                $id = $row['id'];
                $update_sql = "UPDATE markah SET markah = $markah, tarikh_kemaskini = NOW() WHERE id = $id";
                $conn->query($update_sql);
            } else {
                // Insert
                $insert_sql = "INSERT INTO markah (peserta_id, kursus_id, markah, tarikh_kemaskini, kategori) 
                               VALUES ($peserta_id, 0, $markah, NOW(), '$kategori')";
                $conn->query($insert_sql);
            }
        }
    }
}

header("Location: update_result.php");
exit();

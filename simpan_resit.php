<?php
include 'config.php';

$peserta_id = $_POST['peserta_id'];
$nama = $_POST['nama_peserta'];
$latihan = $_POST['latihan'];
$jumlah = $_POST['jumlah'];

// Simpan fail bukti
$target_dir = "bukti_resit/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$file_name = basename($_FILES["bukti"]["name"]);
$target_file = $target_dir . time() . "_" . $file_name;

if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
    // Masukkan ke DB
    $stmt = $conn->prepare("INSERT INTO resit (peserta_id, nama, latihan, jumlah, bukti, tarikh) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issss", $peserta_id, $nama, $latihan, $jumlah, $target_file);
    $stmt->execute();

    echo "<script>alert('Resit berjaya dihantar!'); window.location='senarai_resit.php';</script>";
} else {
    echo "<script>alert('Gagal muat naik bukti resit.'); window.history.back();</script>";
}
?>

<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $company = $_POST['company'];
    $ic = $_POST['ic'];
    $alamat = $_POST['alamat'];

    // Ambil tarikh hari ini dari PHP
    $tarikh_daftar = date('Y-m-d');

    $sql = "INSERT INTO pendaftaran (nama, company, ic, alamat, tarikh_daftar)
            VALUES ('$nama', '$company', '$ic', '$alamat', '$tarikh_daftar')";

    $sql = "INSERT INTO pendaftaran (nama, company, ic, alamat, tarikh_daftar, bulan)
        VALUES ('$nama', '$company', '$ic', '$alamat', CURRENT_DATE(), '$bulan')";


    if (mysqli_query($conn, $sql)) {
        header("Location: pendaftaran.php?status=success");
        exit();
    } else {
        echo "Gagal simpan data: " . mysqli_error($conn);
    }
}

$kategori = $_POST['kategori'];
$sql = "INSERT INTO pendaftaran (nama, company, ic, alamat, tarikh_daftar, kategori)
        VALUES ('$nama', '$company', '$ic', '$alamat', CURRENT_DATE(), '$kategori')";

?>

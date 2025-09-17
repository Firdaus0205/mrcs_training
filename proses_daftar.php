<?php
include 'config.php'; // fail sambungan DB

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];

    $sql = "INSERT INTO pendaftaran (nama) VALUES ('$nama')";
    $result = mysqli_query($conn, $sql);
    $company = $_POST['company'];

    if ($result) {
        header("Location: dashboard_admin.php?status=berjaya");
    } else {
        echo "Gagal simpan data.";
    }
}
?>

<?php
include 'config.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'finances') {
    header("Location: finances_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Update status jika belum bayar
    $check = mysqli_query($conn, "SELECT status_bayar FROM peserta WHERE id = $id");
    $peserta = mysqli_fetch_assoc($check);

    if ($peserta['status_bayar'] !== 'Sudah Bayar') {
        mysqli_query($conn, "UPDATE peserta SET status_bayar = 'Sudah Bayar' WHERE id = $id");
    }

    // Buka sijil & kad hanya sekali
    echo "
    <script>
        window.open('cetak_sijil.php?id=$id', '_blank');
        setTimeout(function() {
            window.open('cetak_kad.php?id=$id', '_blank');
        }, 1000);
        window.location.href = 'finances_dashboard.php';
    </script>
    ";
    exit();
}
?>


<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Selamatkan ID

    $sql = "DELETE FROM pendaftaran WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?status=deleted");
        exit();
    } else {
        echo "Gagal padam data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak sah.";
}
?>

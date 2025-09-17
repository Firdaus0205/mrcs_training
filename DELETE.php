<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM peserta WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Berjaya padam – balik ke dashboard
        header("Location: admin_dashboard.php?status=deleted");
        exit();
    } else {
        echo "Gagal padam peserta.";
    }
} else {
    echo "ID tidak sah.";
}
?>

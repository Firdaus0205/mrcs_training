<?php
include 'config.php'; // sambungan DB

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $sql = "DELETE FROM peserta WHERE id = $id";
    mysqli_query($conn, $sql);

    header("Location: senarai_peserta.php?msg=padam_berjaya");
    exit;
} else {
    echo "❌ Tiada ID peserta diberikan.";
}
?>


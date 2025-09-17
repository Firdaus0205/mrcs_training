<?php
session_start(); // Penting!
include 'config.php';

// Pastikan admin masih login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Proses simpanan keputusan...
// Lepas berjaya simpan:
header("Location: result_training.php");
exit();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $markah_id = $_POST['markah_id'];
    $markah_baru = $_POST['markah'];

    $sql = "UPDATE markah SET markah = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $markah_baru, $markah_id);

    if ($stmt->execute()) {
        header("Location: result_training.php?status=success");
        exit();
    } else {
        echo "Ralat semasa mengemas kini markah.";
    }
}
?>


<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Kemaskini Keputusan Peserta | MRCS</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { margin: 0; }
    </style>
</head>
<body>
    <h2>Kemaskini Keputusan Peserta - MRCS Training System</h2>

    <?php if (isset($mesej)) echo "<p style='color: green;'>$mesej</p>"; ?>

    <table>
        <tr>
            <th>Nama Peserta</th>
            <th>No IC</th>
            <th>Nama Kursus</th>
            <th>Markah</th>
            <th>Tindakan</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <form method="POST" action="">
                    <td><?= htmlspecialchars($row['nama_peserta']) ?></td>
                    <td><?= htmlspecialchars($row['no_ic']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kursus']) ?></td>
                    <td>
                        <input type="number" name="markah" value="<?= $row['markah'] ?>" min="0" max="100" required>
                        <input type="hidden" name="markah_id" value="<?= $row['markah_id'] ?>">
                    </td>
                    <td>
                        <button type="submit">Kemaskini</button>
                    </td>
                </form>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Proses kemaskini markah & keputusan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markah'])) {
    foreach ($_POST['markah'] as $id => $markah) {
        $markah = intval($markah);
        $keputusan = ($markah >= 60) ? "LULUS" : "GAGAL";

        $update = $conn->prepare("UPDATE peserta SET markah = ?, keputusan = ? WHERE id = ?");
        $update->bind_param("isi", $markah, $keputusan, $id);
        $update->execute();
    }
    $msg = "✅ Markah berjaya dikemaskini!";
}

// Kursus sasaran: Advanced First Aid & CPR
$kursus_keyword = "%Advanced First Aid%";

$sql = "SELECT id, nama, no_ic, nama_kursus, tarikh_kursus, bulan, markah, keputusan
        FROM peserta
        WHERE nama_kursus LIKE ?
        ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kursus_keyword);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Kemaskini Markah - Advanced First Aid & CPR</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        header { background: #b31217; color: #fff; text-align: center; padding: 18px; }
        header h1 { margin: 0; font-size: 22px; }
        .container { max-width: 1000px; margin: 30px auto; background: #fff; padding: 25px 30px;
                     border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .msg { text-align: center; padding: 10px; background: #c8e6c9; color: #256029;
               border-radius: 6px; margin-bottom: 15px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: #b31217; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        input[type="number"] { width: 70px; padding: 5px; text-align: center; }
        .btn { margin-top: 20px; padding: 10px 18px; background: #d32f2f; color: #fff; border: none;
               border-radius: 6px; cursor: pointer; font-size: 14px; }
        .btn:hover { background: #9a0007; }
        .btn-kembali { display: inline-block; margin-top: 20px; padding: 10px 18px;
                       background: #555; color: #fff; text-decoration: none; border-radius: 6px; }
        .btn-kembali:hover { background: #333; }
        .status-lulus { color: green; font-weight: bold; }
        .status-gagal { color: red; font-weight: bold; }
    </style>
</head>
<body>
<header>
    <h1>Kemaskini Markah - Advanced First Aid & CPR</h1>
</header>

<div class="container">
    <?php if (!empty($msg)): ?>
        <div class="msg"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <table>
            <tr>
                <th>Bil</th>
                <th>Nama</th>
                <th>No IC</th>
                <th>Kursus</th>
                <th>Tarikh Kursus</th>
                <th>Markah</th>
                <th>Keputusan</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php $bil = 1; while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $bil++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['no_ic']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kursus']) ?></td>
                        <td>
                            <?php
                            $tarikh = trim($row['tarikh_kursus']);
                            $bulan  = trim($row['bulan']);
                            if (!empty($tarikh) && $tarikh !== '0000-00-00' && $tarikh !== '0') {
                                echo date("d.m.Y", strtotime($tarikh));
                            } elseif (!empty($bulan)) {
                                echo htmlspecialchars($bulan);
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                        <td>
                            <input type="number" name="markah[<?= $row['id'] ?>]"
                                   value="<?= htmlspecialchars($row['markah']) ?>" min="0" max="100">
                        </td>
                        <td>
                            <?php
                            if ($row['markah'] !== null && $row['markah'] !== '') {
                                echo ($row['markah'] >= 60)
                                    ? '<span class="status-lulus">LULUS</span>'
                                    : '<span class="status-gagal">GAGAL</span>';
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">Tiada peserta untuk kursus ini.</td></tr>
            <?php endif; ?>
        </table>
        <button type="submit" class="btn">💾 Simpan Markah</button>
    </form>

    <a href="result_training.php" class="btn-kembali">⬅️ Kembali ke Senarai Kategori</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>





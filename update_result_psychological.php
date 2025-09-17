<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$kategori_latihan = "Psychological First Aid";

// Simpan markah jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markah'])) {
    foreach ($_POST['markah'] as $peserta_id => $mark) {
        $markah = intval($mark);
        if ($markah < 0) $markah = 0;
        if ($markah > 100) $markah = 100;

        $cek = mysqli_query($conn, "SELECT id FROM keputusan_latihan WHERE peserta_id = $peserta_id");
        if (mysqli_num_rows($cek) > 0) {
            mysqli_query($conn, "UPDATE keputusan_latihan SET psychological = $markah WHERE peserta_id = $peserta_id");
        } else {
            mysqli_query($conn, "INSERT INTO keputusan_latihan (peserta_id, psychological) VALUES ($peserta_id, $markah)");
        }
    }
    header("Location: update_result_psychological.php?saved=1");
    exit();
}

// Dapatkan peserta dan markah bersama keputusan
$sql = "
SELECT p.id, p.nama, p.no_ic, p.kategori, p.bulan, k.psychological AS markah
FROM peserta p
LEFT JOIN keputusan_latihan k ON p.id = k.peserta_id
WHERE p.kategori = 'Psychological First Aid'
ORDER BY p.nama ASC
";

$result = mysqli_query($conn, $sql);

$msg = '';
if (isset($_GET['saved'])) {
    $msg = "<p style='color:green; text-align:center;'>✅ Markah berjaya disimpan.</p>";
}

?>

<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8" />
<title>Kemaskini Markah - <?= htmlspecialchars($kategori_latihan) ?></title>
<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #fff; }
    h2 { text-align: center; color: #c8102e; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #c8102e; color: white; }
    input[type=number] { width: 70px; padding: 5px; text-align: center; border-radius: 4px; border: 1px solid #aaa; }
    .submit-btn { background: #c8102e; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; margin: 10px auto; display: block; }
    .submit-btn:hover { background: #a40c24; }
    .btn-kembali { text-align: center; margin-top: 20px; }
    .btn-kembali a { background: #c8102e; color: white; padding: 10px 25px; border-radius: 6px; text-decoration: none; }
    .btn-kembali a:hover { background: #a40c24; }
    .lulus { color: green; font-weight: bold; }
    .gagal { color: red; font-weight: bold; }
    p.message { text-align: center; font-weight: bold; margin-bottom: 20px; }
</style>
</head>
<body>

<h2>Kemaskini Markah - <?= htmlspecialchars($kategori_latihan) ?></h2>

<?= $msg ?>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p style="text-align:center;">Tiada peserta dalam kategori ini.</p>
<?php else: ?>
<form method="POST" action="update_result_psychological.php">
    <table>
        <thead>
            <tr>
                <th>Nama Peserta</th>
                <th>No. IC</th>
                <th>Organisasi</th>
                <th>Tarikh Kursus</th>
                <th>Markah (0-100)</th>
                <th>Keputusan</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php
                $markah = $row['markah'];
                if ($markah === null || $markah === '') {
                    $keputusan = "-";
                    $kelas = "";
                } elseif ($markah >= 60) {
                    $keputusan = "Lulus";
                    $kelas = "lulus";
                } else {
                    $keputusan = "Gagal";
                    $kelas = "gagal";
                }
            ?>
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ic']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['bulan']) ?></td>
                <td>
                    <input type="number" name="markah[<?= $row['id'] ?>]" min="0" max="100" value="<?= htmlspecialchars($markah) ?>" />
                </td>
                <td class="<?= $kelas ?>"><?= $keputusan ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <button type="submit" class="submit-btn">💾 Simpan Markah</button>
</form>
<?php endif; ?>

<div class="btn-kembali">
    <a href="update_result.php">← Kembali ke Senarai Kategori</a>
</div>

</body>
</html>




























<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data peserta Basic Life Support (BLS) termasuk tarikh & bulan kursus
$sql = "SELECT id, nama, no_ic, nama_kursus, tarikh_kursus, bulan, markah, keputusan
        FROM peserta
        WHERE nama_kursus LIKE '%Basic Life Support%'
        ORDER BY nama ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Proses kemaskini markah & keputusan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markah'])) {
    foreach ($_POST['markah'] as $id_peserta => $markah) {
        $markah = intval($markah);
        $status = ($markah >= 60) ? 'LULUS' : 'GAGAL';

        $update = $conn->prepare("UPDATE peserta SET markah = ?, keputusan = ? WHERE id = ?");
        $update->bind_param("isi", $markah, $status, $id_peserta);
        $update->execute();
    }
    header("Location: update_result_bls.php?saved=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>MRCS - Kemaskini Keputusan Basic Life Support (BLS)</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; }
        header { background-color: #b30000; color: white; padding: 15px 30px; text-align: center; font-size: 1.5em; font-weight: bold; }
        .container { max-width: 1000px; margin: 30px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .success { background-color: #d4edda; padding: 12px; margin-bottom: 15px; color: #155724; border-radius: 5px; border: 1px solid #c3e6cb; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th { background-color: #b30000; color: white; padding: 10px; }
        td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        input[type="number"] { width: 80px; padding: 5px; border-radius: 5px; border: 1px solid #bbb; text-align: center; }
        .btn { background-color: #b30000; color: white; padding: 10px 18px; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; }
        .btn:hover { background-color: #8c0000; }
        .status-lulus { color: green; font-weight: bold; }
        .status-gagal { color: red; font-weight: bold; }
        .button-group { margin-top: 25px; text-align: center; }
        .button-group a { background: #ffffff; color: #b30000; border: 2px solid #b30000; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-right: 15px; }
        .button-group a:hover { background-color: #f3f3f3; }
    </style>
</head>
<body>

<header>MRCS - Kemaskini Keputusan Basic Life Support (BLS)</header>

<div class="container">
    <?php if (isset($_GET['saved'])): ?>
        <div class="success">✅ Markah berjaya disimpan!</div>
    <?php endif; ?>

    <form method="POST">
        <table>
            <tr>
                <th>Nama Peserta</th>
                <th>No. IC</th>
                <th>Kursus</th>
                <th>Tarikh Kursus</th>
                <th>Markah</th>
                <th>Keputusan</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['no_ic']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kursus']) ?></td>
                        <td>
                            <?php
                            $tarikh = trim($row['tarikh_kursus']);
                            $bulan  = trim($row['bulan']);
                            echo (!empty($tarikh) && $tarikh !== '0')
                                ? htmlspecialchars($tarikh)
                                : (!empty($bulan) ? htmlspecialchars($bulan) : '-');
                            ?>
                        </td>
                        <td>
                            <input type="number"
                                   name="markah[<?= $row['id'] ?>]"
                                   value="<?= htmlspecialchars($row['markah']) ?>"
                                   min="0" max="100">
                        </td>
                        <td>
                            <?php if ($row['keputusan'] === 'LULUS'): ?>
                                <span class="status-lulus">LULUS</span>
                            <?php elseif ($row['keputusan'] === 'GAGAL'): ?>
                                <span class="status-gagal">GAGAL</span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">❌ Tiada peserta didaftarkan untuk kursus ini.</td>
                </tr>
            <?php endif; ?>
        </table>

        <div class="button-group">
            <a href="update_result.php">← Kembali ke Senarai Kategori</a>
            <button type="submit" class="btn">💾 Simpan Keputusan</button>
        </div>
    </form>
</div>

</body>
</html>


























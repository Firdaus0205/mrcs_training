<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$sql = "SELECT id, nama, no_ic, nama_kursus, tarikh_kursus, bulan, markah, keputusan
        FROM peserta
        WHERE nama_kursus LIKE '%Basic Life Support%'
        ORDER BY nama ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Peserta - Basic Life Support (BLS)</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; }
        header { background: #b30000; color: white; padding: 15px; text-align: center; font-size: 1.5em; font-weight: bold; }
        .container { max-width: 1000px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #b30000; color: white; padding: 10px; }
        td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .status-lulus { color: green; font-weight: bold; }
        .status-gagal { color: red; font-weight: bold; }

        /* Butang versi MRCS */
        .btn-kembali {
            display: inline-block;
            margin-bottom: 18px;
            padding: 10px 20px;
            background: #b30000;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn-kembali:hover {
            background: #8c0000;
            transform: translateY(-2px);
        }
        .btn-kembali:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<header>Senarai Peserta - Basic Life Support (BLS)</header>

<div class="container">
    <!-- Butang kembali MRCS -->
    <a href="result_training.php" class="btn-kembali">⬅️ Kembali ke Senarai Kategori</a>

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
                    <td><?= (!empty($row['markah'])) ? htmlspecialchars($row['markah']) : '-' ?></td>
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
            <tr><td colspan="6">❌ Tiada peserta didaftarkan.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>




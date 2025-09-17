<?php
session_start();
include 'config.php';

// Semak jika admin telah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$kategori_latihan = "Introduction First Aid";

// Simpan markah bila admin tekan submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markah'])) {
    foreach ($_POST['markah'] as $id => $nilai) {
        $markah = (int)$nilai;
        $keputusan = ($markah >= 60) ? "Lulus" : "Gagal"; // ← Tukar syarat 60

        // Kemaskini jadual peserta
$stmt1 = $conn->prepare("UPDATE peserta SET markah = ?, keputusan = ? WHERE id = ?");
$stmt1->bind_param("isi", $markah, $keputusan, $id);
$stmt1->execute();

// Semak jika peserta_id wujud dalam keputusan_latihan
$check = $conn->prepare("SELECT id FROM keputusan_latihan WHERE peserta_id = ?");
$check->bind_param("i", $id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    // Kemaskini jika wujud
    $stmt2 = $conn->prepare("UPDATE keputusan_latihan SET introduction = ? WHERE peserta_id = ?");
    $stmt2->bind_param("ii", $markah, $id);
    $stmt2->execute();
} else {
    // Insert jika belum wujud
    $stmt3 = $conn->prepare("INSERT INTO keputusan_latihan (peserta_id, introduction) VALUES (?, ?)");
    $stmt3->bind_param("ii", $id, $markah);
    $stmt3->execute();
}

    }
    header("Location: update_result_introduction.php?saved=1");
    exit();
}

// Ambil senarai peserta
$result = mysqli_query($conn, "SELECT id, nama, no_ic, kategori, bulan, markah, keputusan 
                               FROM peserta 
                               WHERE kategori = '$kategori_latihan'
                               ORDER BY nama ASC");

// Mesej berjaya simpan
$msg = isset($_GET['saved']) ? "<div style='color:green; text-align:center; margin:10px;'>✅ Markah berjaya disimpan.</div>" : "";
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Keputusan <?= htmlspecialchars($kategori_latihan) ?> - MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #c8102e;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(200,0,47,0.2);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #c8102e;
            color: white;
        }
        input[type="number"] {
            width: 60px;
            padding: 4px;
            text-align: center;
        }
        .lulus {
            color: green;
            font-weight: bold;
        }
        .gagal {
            color: red;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background: #c8102e;
            color: white;
            padding: 10px 18px;
            margin: 10px 5px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn:hover {
            background: #a40c24;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        .submit-btn {
            display: block;
            margin: 30px auto;
            padding: 10px 30px;
            background-color: #c8102e;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #a40c24;
        }
    </style>
</head>
<body>

<h2>Keputusan <?= htmlspecialchars($kategori_latihan) ?> - MRCS</h2>
<?= $msg ?>

<form method="POST">
    <table>
        <thead>
            <tr>
                <th>Nama Peserta</th>
                <th>No. IC</th>
                <th>Kategori</th>
                <th>Tarikh Kursus</th>
                <th>Markah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    $markah = $row['markah'];
                    $status = $row['keputusan'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['no_ic']) ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td><?= htmlspecialchars($row['bulan']) ?></td>
                    <td>
                        <input type="number" name="markah[<?= $row['id'] ?>]" min="0" max="100" 
                               value="<?= ($markah !== null ? $markah : '') ?>">
                    </td>
                    <td class="<?= ($status === 'Lulus') ? 'lulus' : (($status === 'Gagal') ? 'gagal' : '') ?>">
                        <?= $status ?: '-' ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button type="submit" class="submit-btn">💾 Simpan Markah</button>
</form>

<div class="actions">
    <a href="admin_dashboard.php" class="btn">← Kembali ke Dashboard</a>
    <a href="update_result.php" class="btn">📋 Senarai Kategori</a>
</div>

</body>
</html>





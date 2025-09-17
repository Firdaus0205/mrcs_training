<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$sql = "
  SELECT p.nama, p.no_ic, p.syarikat, k.basic AS markah
  FROM peserta p
  LEFT JOIN keputusan_latihan k ON p.id = k.peserta_id
  WHERE p.kategori = 'Basic First Aid'
  ORDER BY p.nama ASC
";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Basic First Aid & CPR + AED</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #fff; }
    h2 { text-align: center; color: #c8102e; }
    table { width:100%; border-collapse: collapse; margin: 30px 0; }
    th, td { padding: 8px; border:1px solid #ccc; text-align: center; }
    th { background: #c8102e; color: white; }
    .gagal { color: red; font-weight: bold; }
    .lulus { color: green; font-weight: bold; }
    .btn-kembali { text-align: center; margin-top: 30px; }
    .btn-kembali a {
      background: #c8102e; color: white; padding: 10px 25px; border-radius: 6px;
      text-decoration: none;
    }
    .btn-kembali a:hover { background: #a40c24; }
  </style>
</head>
<body>

<h2>Basic First Aid & CPR + AED</h2>

<?php if (mysqli_num_rows($res) == 0): ?>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Nama Peserta</th>
        <th>No. IC</th>
        <th>Organisasi</th>
        <th>Markah</th>
        <th>Keputusan</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($r = mysqli_fetch_assoc($res)):
        $score = $r['markah'];
        $keputusan = ($score !== null && $score !== '' && is_numeric($score))
            ? ($score >= 60 ? "LULUS" : "GAGAL")
            : "-";
        $kelas = ($keputusan === "LULUS") ? "lulus" : (($keputusan === "GAGAL") ? "gagal" : "");
      ?>
      <tr>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['no_ic']) ?></td>
        <td><?= htmlspecialchars($r['syarikat']) ?></td>
        <td><?= ($score !== null && $score !== '') ? htmlspecialchars($score) : "-" ?></td>
        <td class="<?= $kelas ?>"><?= $keputusan ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>

<div class="btn-kembali">
  <a href="result_training.php">← Kembali ke Senarai Kategori</a>
</div>

</body>
</html>



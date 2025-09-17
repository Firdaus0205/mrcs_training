<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// mapping kolum markah dalam keputusan_latihan
$kategori_mapping = [
    "Introduction First Aid & CPR" => [
        "col" => "introduction",
        "keywords" => ["%Introduction%", "%Intro First Aid%", "%IFA%"]
    ],
    "Basic First Aid & CPR + AED"  => [
        "col" => "basic",
        "keywords" => [
            "%Basic First Aid%",
            "%CPR%",
            "%AED%",
            "%Basic FA%",
            "%BFA%"
        ]
    ],
    "Advanced First Aid & CPR"     => [
        "col" => "advanced",
        "keywords" => [
            "%Advanced%",
            "%Advance%",
            "%Adv First Aid%",
            "%Advanced First Aid%",
            "%AFA%"
        ]
    ],
    "Psychological First Aid"      => [
        "col" => "psychological",
        "keywords" => [
            "%Psychological%",
            "%PFA%",
            "%Psy First Aid%"
        ]
    ],
    "Basic Life Support"           => [
        "col" => "bls",
        "keywords" => [
            "%Basic Life Support%",
            "%BLS%",
            "%B L S%",
            "%Life Support%",
            "%BLS Course%"
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>MRCS - Paparan Markah Peserta</title>
  <style>
    body { font-family: Arial; background: #f4f6f9; margin:0; padding:0; }
    header { background:#b30000; color:#fff; padding:15px; text-align:center; font-size:20px; font-weight:bold; }
    .container { max-width:1100px; margin:20px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,.1); }
    h2 { margin-top:30px; background:#b30000; color:#fff; padding:8px 12px; border-radius:5px; }
    table { width:100%; border-collapse:collapse; margin-top:12px; }
    th, td { border:1px solid #ddd; padding:8px; text-align:center; }
    th { background:#b30000; color:white; }
    .lulus { color:green; font-weight:bold; }
    .gagal { color:red; font-weight:bold; }
    .empty { text-align:center; padding:10px; color:#777; }
    .btn-back {
        display:inline-block;
        margin:20px 10px 0;
        padding:10px 18px;
        background:#b30000;
        color:#fff;
        text-decoration:none;
        border-radius:6px;
        font-weight:bold;
    }
    .btn-back:hover { background:#8d0000; }
  </style>
</head>
<body>
<header>MRCS - Paparan Markah Peserta</header>
<div class="container">

<?php
foreach ($kategori_mapping as $kategori => $data):
    $col = $data['col'];
    $keywords = $data['keywords'];

    // bina kondisi LIKE
    $conds = [];
    $params = [];
    foreach ($keywords as $kw) {
        $conds[] = "p.nama_kursus LIKE ?";
        $params[] = $kw;
    }
    $where = implode(" OR ", $conds);

    $sql = "
      SELECT p.nama, p.no_ic, p.nama_kursus, p.tarikh_kursus, p.bulan, k.$col AS markah
      FROM peserta p
      LEFT JOIN keputusan_latihan k ON p.id = k.peserta_id
      WHERE $where
      ORDER BY p.nama ASC
    ";

    $stmt = $conn->prepare($sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
?>
  <h2><?= htmlspecialchars($kategori) ?></h2>
  <table>
    <tr>
      <th>Nama Peserta</th>
      <th>No. IC</th>
      <th>Kursus</th>
      <th>Tarikh Kursus</th>
      <th>Markah</th>
      <th>Status</th>
    </tr>
    <?php if ($res->num_rows > 0): 
      while ($r = $res->fetch_assoc()):
        // Format tarikh
        $tarikh = "-";
        if (!empty($r['tarikh_kursus']) && $r['tarikh_kursus'] !== "0000-00-00") {
            $tarikh = date("d.m.Y", strtotime($r['tarikh_kursus']));
        } elseif (!empty($r['bulan'])) {
            $tarikh = htmlspecialchars($r['bulan']);
        }

        // Markah & Status
        $score = $r['markah'];
        $status = "-";
        $kelas = "";

        if (is_numeric($score)) {
            $status = ($score >= 60) ? "LULUS" : "GAGAL";
            $kelas = strtolower($status);
        }
    ?>
    <tr>
      <td><?= htmlspecialchars($r['nama']) ?></td>
      <td><?= htmlspecialchars($r['no_ic']) ?></td>
      <td><?= htmlspecialchars($r['nama_kursus']) ?></td>
      <td><?= $tarikh ?></td>
      <td><?= is_numeric($score) ? htmlspecialchars($score) : "-" ?></td>
      <td class="<?= $kelas ?>"><?= $status ?></td>
    </tr>
    <?php endwhile; else: ?>
    <tr><td colspan="6" class="empty">Tiada peserta dalam kategori ini.</td></tr>
    <?php endif; ?>
  </table>
<?php endforeach; ?>

<div style="text-align:center;">
    <a href="admin_dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
</div>

</div>
</body>
</html>


































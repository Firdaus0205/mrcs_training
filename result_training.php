<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$kategoriMap = [
    "introduction.php"  => "Introduction First Aid & CPR",
    "basic.php"         => "Basic First Aid & CPR + AED",
    "advanced.php"      => "Advanced First Aid & CPR",
    "psychological.php" => "Psychological First Aid",
    "bls.php"           => "Basic Life Support"
];
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keputusan Latihan Peserta MRCS</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; padding: 40px; margin: 0; }
        h2 { text-align: center; color: #c8102e; }
        .btn-container { max-width: 500px; margin: 40px auto; }
        .btn-category, .btn-dashboard {
            display: block;
            background-color: #c8102e;
            color: white;
            text-align: center;
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn-category:hover,
        .btn-category:focus,
        .btn-dashboard:hover,
        .btn-dashboard:focus {
            background-color: #a40c24;
            outline: none;
        }
    </style>
</head>
<body>

<h2>📋 Keputusan Latihan Peserta MRCS</h2>

<div class="btn-container" role="navigation" aria-label="Kategori Latihan">
    <?php foreach ($kategoriMap as $file => $label): ?>
        <a href="<?= htmlspecialchars($file) ?>" class="btn-category" tabindex="0"><?= htmlspecialchars($label) ?></a>
    <?php endforeach; ?>

    <!-- Button Kembali ke Admin Dashboard -->
    <a href="admin_dashboard.php" class="btn-dashboard" tabindex="0">← Kembali ke Dashboard Admin</a>
</div>

</body>
</html>









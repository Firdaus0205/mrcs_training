<?php
session_start();
if (!isset($_SESSION['peserta_id'])) {
    header("Location: login_peserta.php");
    exit();
}

include 'config.php';

$peserta_id = $_SESSION['peserta_id'];
$result = mysqli_query($conn, "SELECT * FROM peserta WHERE id = $peserta_id");
$peserta = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Peserta - MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #fefefe;
        }

        h2 {
            color: #b60000;
        }

        .mrcs-button {
            padding: 10px 20px;
            background-color: #b60000;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }

        .mrcs-button:hover {
            background-color: #8f0000;
        }

        .info-box {
            background-color: #fff5f5;
            padding: 15px;
            border: 1px solid #b60000;
            border-radius: 5px;
            margin-top: 20px;
        }

        .info-table {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }

        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .label {
            background-color: #f9f9f9;
            font-weight: bold;
            width: 30%;
        }

        .course-buttons {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
        }

        .course-buttons form {
            margin: 5px;
        }

        .course-buttons button {
            background-color: #b60000;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            min-width: 250px;
            text-align: center;
        }

        .course-buttons button:hover {
            background-color: #8f0000;
        }
    </style>
</head>
<body>

   <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['peserta_nama']) ?>!</h2>
<p>Anda telah berjaya log masuk ke sistem pendaftaran latihan MRCS.</p>

<a href="index_peserta.php" class="mrcs-button">← Kembali ke Halaman Utama</a>
<a href="logout.php" class="mrcs-button" style="background-color:#555;">🚪 Log Keluar</a>


    <div class="info-box">
        <h2>Maklumat Pendaftaran Anda</h2>
        <table class="info-table">
            <tr>
                <td class="label">Nama Penuh</td>
                <td><?= htmlspecialchars($peserta['nama']) ?></td>
            </tr>
            <tr>
                <td class="label">No. Kad Pengenalan</td>
                <td><?= htmlspecialchars($peserta['no_ic']) ?></td>
            </tr>
            <tr>
                <td class="label">Kategori Latihan</td>
                <td><?= htmlspecialchars($peserta['kategori']) ?></td>
            </tr>
            <tr>
                <td class="label">Tarikh Kursus</td>
                <td><?= htmlspecialchars($peserta['bulan']) ?></td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td><?= $peserta['verified'] ? "✅ Telah Disahkan" : "⏳ Menunggu Pengesahan" ?></td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <h2>Pembayaran Online MRCS</h2>
        <p>Sila buat pembayaran secara atas talian melalui FPX (Online Banking semua bank).</p>
        <p><strong>Nama Akaun:</strong> MALAYSIAN RED CRESCENT SOCIETY</p>
        <p><strong>No. Akaun:</strong> 514422105668 (Maybank)</p>
        <a href="payment_online.php?id=<?= $peserta['id'] ?>" class="mrcs-button">💳 Buat Pembayaran</a>
        <p><em>Sila pastikan anda isi <strong>nama penuh</strong> dan <strong>kategori latihan</strong> semasa membuat bayaran.</em></p>
    </div>

        <!-- Butang Latihan Mengikut Kategori Kursus -->
    <div class="info-box">
        <h2>Latihan Kursus Anda</h2>
        <p>Anda hanya boleh akses latihan untuk kursus yang anda daftar:</p>

        <div class="course-buttons">
            <?php
            // Mapping kategori peserta -> kursus_id + nama kursus
            $kursus_map = [
                "Introduction First Aid"      => ["id" => 1, "nama" => "Introduction First Aid & CPR"],
                "Basic First Aid"             => ["id" => 2, "nama" => "Basic First Aid & CPR + AED"],
                "Advanced First Aid"          => ["id" => 3, "nama" => "Advanced First Aid & CPR"],
                "Basic Life Support"          => ["id" => 4, "nama" => "Basic Life Support (BLS)"],
                "Psychological First Aid"     => ["id" => 5, "nama" => "Psychological First Aid"],
            ];

            $kategori_peserta = $peserta['kategori'];

            if (isset($kursus_map[$kategori_peserta])) {
                $kursus = $kursus_map[$kategori_peserta];
                ?>
                <form method="get" action="soalan_kursus.php">
                    <input type="hidden" name="kursus_id" value="<?= $kursus['id'] ?>">
                    <button type="submit"><?= $kursus['nama'] ?></button>
                </form>
                <?php
            } else {
                echo "<p style='color:red;'>❌ Kategori kursus tidak sah atau tiada dalam senarai.</p>";
            }
            ?>
        </div>
    </div>


</body>
</html>






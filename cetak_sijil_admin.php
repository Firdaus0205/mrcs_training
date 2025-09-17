<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil semua peserta termasuk bulan & tarikh kursus
$sql = "SELECT nama, no_ic, nama_kursus, bulan, tarikh_kursus FROM peserta ORDER BY nama ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SIJIL PENYERTAAN - MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }
        .buttons {
            text-align: center;
            margin: 20px 0;
        }
        button {
            background-color: #b30000;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        button:hover {
            background-color: #800000;
        }
        .certificate {
            width: 100%;
            height: 1000px;
            position: relative;
            background-image: url('sijil.png');
            background-size: cover;
            background-position: center;
            page-break-after: always;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 50px 20px;
            box-sizing: border-box;
        }
        .header-text {
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 5px;
        }
        .logo-mrcs {
            width: 100px;
            margin: 10px auto 10px auto;
        }
        .certificate-content {
            max-width: 800px;
            color: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 20px;
        }
        .certificate h1 {
            font-size: 36px;
            color: #b30000;
            margin: 0;
        }
        .subtitle {
            font-size: 18px;
        }
        .name {
            font-size: 24px;
            font-weight: bold;
            text-decoration: underline;
        }
        .details {
            font-size: 16px;
        }
        .course {
            font-size: 20px;
            font-weight: bold;
        }
        .date {
            font-size: 16px;
        }
        .signature {
            position: absolute;
            bottom: 80px;
            right: 100px;
            text-align: center;
            font-size: 14px;
        }
        @media print {
            .buttons {
                display: none;
            }
            .certificate {
                page-break-after: always;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

<div class="buttons">
    <button onclick="window.print();">Cetak Sijil</button>
    <button onclick="window.location.href='admin_dashboard.php';">Kembali ke Dashboard</button>
</div>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Tentukan tarikh kursus ikut senarai_peserta.php (tarikh_kursus atau bulan)
        $tarikh   = trim($row['tarikh_kursus']);
        $bulan    = trim($row['bulan']);
        $tarikh_kursus = (!empty($tarikh) && $tarikh !== '0')
            ? date("d F Y", strtotime($tarikh)) // contoh: 11 September 2025
            : (!empty($bulan) ? $bulan : "-");
?>
    <div class="certificate">
        <!-- Header teks dan logo MRCS -->
        <div class="header-text">DI BAWAH NAUNGAN</div>
        <div class="header-text">SERI PADUKA BAGINDA YANG DIPERTUAN AGONG</div>

        <img src="logo_mrcs.jpg" alt="Logo MRCS" class="logo-mrcs">

        <div class="header-text" style="margin-top: -5px;">PERSATUAN BULAN SABIT MERAH MALAYSIA</div>
        <div class="header-text">(MALAYSIAN RED CRESCENT SOCIETY)</div>

        <!-- Kandungan sijil -->
        <div class="certificate-content">
            <h1>SIJIL PENYERTAAN</h1>
            <div class="subtitle">Malaysian Red Crescent Society (MRCS)</div>
            <p>Dengan ini mengesahkan bahawa</p>
            <div class="name"><?php echo strtoupper(htmlspecialchars($row['nama'])); ?></div>
            <div class="details">No. Kad Pengenalan: <?php echo htmlspecialchars($row['no_ic']); ?></div>
            <p>telah menyertai dan menamatkan kursus berikut:</p>
            <div class="course"><?php echo htmlspecialchars(ucwords($row['nama_kursus'])); ?></div>
            <div class="date">
                Tarikh: <?php echo htmlspecialchars($tarikh_kursus); ?>
            </div>
        </div>

        <div class="signature">
            <hr style="width:150px;">
            Tandatangan Rasmi
        </div>
    </div>
<?php
    }
} else {
    echo "<p style='text-align:center;'>Tiada peserta dijumpai.</p>";
}
?>

</body>
</html>























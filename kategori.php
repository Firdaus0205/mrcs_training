<?php
include 'config.php';

$kategoriDipilih = $_GET['kategori'] ?? '';
$bulanDipilih = $_GET['bulan'] ?? '';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Pendaftaran Peserta - MRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <a href="admin_dashboard.php" class="btn-back-mrcs">
    ← Kembali ke Dashboard
</a>
    <style> 
        .btn-back-mrcs {
    display: inline-block;
    padding: 12px 28px;
    background-color: #c4002f;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.btn-back-mrcs:hover {
    background-color: #a00026;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #c4002f;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        select, button {
            padding: 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #c4002f;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #c4002f;
            color: white;
        }
        .message {
            background-color: #ffe6e6;
            color: #c4002f;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Senarai Pendaftaran Peserta Mengikut Kategori - MRCS</h2>

        <form method="get" action="">
            Kategori:
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Advanced First Aid & CPR + AED" <?= ($kategoriDipilih == "Advanced First Aid & CPR + AED") ? "selected" : "" ?>>Advanced First Aid & CPR + AED</option>
                <option value="Basic First Aid & CPR + AED">Basic First Aid & CPR + AED</option>
                <option value="Introduction First Aid & CPR + AED">Introduction First Aid & CPR + AED</option>
                <option value="Psychological First Aid">Psychological First Aid</option>

                
                <!-- Tambah kategori lain di sini -->
            </select>

            Bulan:
            <select name="bulan" required>
                <option value="">-- Pilih Bulan --</option>
                <?php
                $bulanList = ["Januari","Februari","Mac","April","Mei","Jun","Julai","Ogos","September","Oktober","November","Disember"];
                foreach ($bulanList as $b) {
                    $selected = ($bulanDipilih == $b) ? "selected" : "";
                    echo "<option value=\"$b\" $selected>$b</option>";
                }
                ?>
            </select>

            <button type="submit">Semak</button>
        </form>

        <?php
        if (!empty($kategoriDipilih) && !empty($bulanDipilih)) {
            echo "<div class='message'>Menunjukkan peserta untuk kategori: <b>$kategoriDipilih</b> dan bulan: <b>$bulanDipilih</b></div>";

            $sql = "SELECT * FROM peserta WHERE kategori = ? AND bulan = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $kategoriDipilih, $bulanDipilih);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<table>
                    <tr>
                        <th>Nama</th>
                        <th>Syarikat</th>
                        <th>IC</th>
                        <th>Alamat</th>
                        <th>Tarikh Daftar</th>
                        <th>Tindakan</th>
                    </tr>";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['nama']}</td>
            <td>{$row['syarikat']}</td>
            <td>{$row['no_ic']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['tarikh_daftar']}</td>
            <td><a href='lihat.php?id={$row['id']}'>Lihat</a></td>
          </tr>";
}

            } else {
                echo "<tr><td colspan='6'>Tiada data ditemui</td></tr>";
            }

            echo "</table>";
        }
        
        ?>
    </div>
</body>
</html>

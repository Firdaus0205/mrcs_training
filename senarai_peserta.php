<?php
session_start();
include 'config.php';

// Dapatkan keyword carian (jika ada)
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Query asas
$sql = "SELECT id, nama, no_ic, syarikat, telefon, emel, kategori, bulan, tarikh_kursus 
        FROM peserta";

// Jika ada carian
if (!empty($search)) {
    $searchEscaped = $conn->real_escape_string($search);
    $sql .= " WHERE nama LIKE '%$searchEscaped%' 
              OR no_ic LIKE '%$searchEscaped%' 
              OR syarikat LIKE '%$searchEscaped%' 
              OR emel LIKE '%$searchEscaped%'";
}

$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Peserta Kursus MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background: #b31217;
            color: #fff;
            text-align: center;
            padding: 18px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-kembali {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 18px;
            background: #d32f2f;
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .btn-kembali:hover {
            background: #9a0007;
        }

        .search-box {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-box input[type="text"] {
            padding: 8px 12px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .search-box input[type="submit"] {
            padding: 8px 14px;
            margin-left: 6px;
            background: #b31217;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .search-box input[type="submit"]:hover {
            background: #7f0e12;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        th, td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #b31217;
            color: white;
            font-size: 15px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Butang Lihat */
        .btn-lihat {
            background-color: #0275d8;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 5px;
            display: inline-block;
        }
        .btn-lihat:hover {
            background-color: #025aa5;
        }

        /* Butang Padam */
        .btn-padam {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-padam:hover {
            background-color: #c9302c;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-top: 30px;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Senarai Peserta Kursus MRCS</h1>
    </header>

    <div class="container">
        <!-- Butang kembali -->
        <a href="admin_dashboard.php" class="btn-kembali">⬅️ Kembali ke Dashboard</a>

        <!-- Borang carian -->
        <div class="search-box">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Cari nama / no ic / syarikat / emel..."
                       value="<?= htmlspecialchars($search) ?>">
                <input type="submit" value="Cari">
            </form>
        </div>

        <table>
            <tr>
                <th>Bil</th>
                <th>Nama</th>
                <th>No IC</th>
                <th>Syarikat</th>
                <th>No Telefon</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Tarikh Kursus</th>
                <th>Tindakan</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php $bil = 1; while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $bil++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['no_ic']) ?></td>
                        <td><?= htmlspecialchars($row['syarikat']) ?></td>
                        <td><?= htmlspecialchars($row['telefon']) ?></td>
                        <td><?= htmlspecialchars($row['emel']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td>
                            <?php
                            $tarikh = trim($row['tarikh_kursus']);
                            $bulan = trim($row['bulan']);
                            echo (!empty($tarikh) && $tarikh !== '0') 
                                ? htmlspecialchars($tarikh) 
                                : (!empty($bulan) ? htmlspecialchars($bulan) : '-');
                            ?>
                        </td>
                        <td>
                            <!-- Butang Lihat -->
                            <a href="lihat.php?id=<?= $row['id'] ?>" class="btn-lihat">👁️ Lihat</a>
                            <!-- Butang Padam -->
                            <form method="POST" action="padam_peserta.php" style="display:inline;"
                                  onsubmit="return confirm('Anda pasti mahu padam peserta ini?');">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn-padam">🗑️ Padam</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9">Tiada peserta ditemui.</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="footer">
        &copy; <?= date("Y") ?> Malaysian Red Crescent Society - Sistem Latihan MRCS
    </div>
</body>
</html>

<?php $conn->close(); ?>
















































    

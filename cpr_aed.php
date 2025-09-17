<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - CPR & AED</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h2 {
            color: #c8102e;
            text-align: center;
        }
        .menu {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu a {
            background-color: #c8102e;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 5px;
            display: inline-block;
            font-weight: bold;
        }
        .menu a:hover {
            background-color: #a60c23;
        }
        .filter {
            margin-bottom: 20px;
            text-align: center;
        }
        select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #c8102e;
            color: white;
        }
    </style>
</head>
<body>

<h2>Senarai Pendaftaran - CPR & AED</h2>

<div class="menu">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="introduction.php">Introduction</a>
    <a href="basic.php">Basic</a>
    <a href="psychological.php">Psychological</a>
    <a href="cpr_aed.php">CPR & AED</a>
    <a href="bls.php">Basic Life Support</a>
</div>

<div class="filter">
    <form method="GET" action="">
        <label for="bulan">Sort by Bulan:</label>
        <select name="bulan" id="bulan" onchange="this.form.submit()">
            <option value="">-- Pilih Bulan --</option>
            <?php
            $nama_bulan = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
            for ($i = 1; $i <= 12; $i++) {
                $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '';
                echo "<option value='$i' $selected>{$nama_bulan[$i-1]}</option>";
            }
            ?>
        </select>
    </form>
</div>

<?php
include 'config.php';

$filter = "kategori = 'CPR & AED'";

if (isset($_GET['bulan']) && is_numeric($_GET['bulan'])) {
    $bulan = str_pad($_GET['bulan'], 2, '0', STR_PAD_LEFT);
    $filter .= " AND MONTH(tarikh_daftar) = $bulan";
}

$sql = "SELECT * FROM pendaftaran WHERE $filter ORDER BY tarikh_daftar DESC";
$result = mysqli_query($conn, $sql);
?>

<table>
    <tr>
        <th>Nama</th>
        <th>Company</th>
        <th>No. IC</th>
        <th>Alamat</th>
        <th>Tarikh Daftar</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['company']; ?></td>
            <td><?php echo $row['ic']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['tarikh_daftar']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
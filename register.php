<?php
// Sambung ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "mrcs_training";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}

// Ambil senarai latihan dari DB
$sql = "SELECT id, tajuk_latihan, tarikh FROM latihan ORDER BY tarikh ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Latihan MRCS</title>
</head>
<body>
    <h2>Borang Pendaftaran Latihan MRCS</h2>
    <form action="proses_pendaftaran.php" method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>No Kad Pengenalan:</label><br>
        <input type="text" name="ic" required><br><br>

        <label>Nama Syarikat:</label><br>
        <input type="text" name="syarikat"><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" rows="4" cols="50" required></textarea><br><br>

        <label>Pilih Latihan:</label><br>
        <select name="latihan_id" required>
            <option value="">-- Sila Pilih --</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['id'].'">'.$row['tajuk_latihan'].' - '.$row['tarikh'].'</option>';
                }
            } else {
                echo '<option value="">Tiada latihan tersedia</option>';
            }
            ?>
        </select><br><br>

        <input type="submit" value="Daftar">
    </form>
</body>
</html>

<?php
$conn->close();
?>

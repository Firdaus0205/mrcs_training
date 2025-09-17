<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // kosong jika default XAMPP
$dbname = 'mrcs_training';

$conn = new mysqli($host, $user, $pass, $dbname);

// Semak sambungan
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}
?>


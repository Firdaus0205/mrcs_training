<?php
session_start();
include 'config.php';

$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama        = trim($_POST['nama_penuh'] ?? '');
    $no_ic       = trim($_POST['no_kad_pengenalan'] ?? '');
    $kata_laluan = $_POST['kata_laluan'] ?? '';
    $syarikat    = trim($_POST['syarikat'] ?? '');
    $alamat      = trim($_POST['alamat'] ?? '');
    $telefon     = trim($_POST['no_telefon'] ?? '');
    $emel        = trim($_POST['email'] ?? '');
    $kategori    = $_POST['kategori'] ?? '';
    $bulan       = $_POST['bulan'] ?? '';
    $tarikh_kursus = $bulan;
    $yuran       = $_POST['jumlah_yuran'] ?? 0;
    $verified    = 0;

    $nama_kursus = $kategori;

    $errors = [];

    // Validasi asas
    if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
        $errors[] = "❌ Nama penuh tidak boleh mengandungi nombor.";
    }

    if (!preg_match("/^[0-9]{12}$/", $no_ic)) {
        $errors[] = "❌ No IC mesti 12 digit nombor sahaja tanpa dash.";
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $syarikat)) {
        $errors[] = "❌ Nama syarikat tidak boleh mengandungi nombor.";
    }

    if (!preg_match("/^[0-9]{10,11}$/", $telefon)) {
        $errors[] = "❌ No telefon mesti 10 atau 11 digit nombor sahaja tanpa dash.";
    }

    if (!filter_var($emel, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "❌ Alamat emel tidak sah.";
    } elseif (preg_match("/[0-9]/", explode("@", $emel)[0])) {
        $errors[] = "❌ Alamat emel tidak boleh mengandungi nombor pada bahagian username.";
    }

    if (!preg_match("/^[a-zA-Z\s,\/]+$/", $alamat)) {
        $errors[] = "❌ Alamat tidak boleh mengandungi nombor.";
    }

    // Semak duplicate (nama + no_ic + emel sahaja)
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id FROM peserta WHERE nama=? AND no_ic=? AND emel=?");
        $check->bind_param("sss", $nama, $no_ic, $emel);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "⚠️ Pendaftaran gagal. Peserta <b>$nama</b> dengan IC <b>$no_ic</b> dan emel <b>$emel</b> sudah pernah mendaftar.";
        }
    }

    // Simpan jika tiada ralat
    if (empty($errors)) {
        $kata_laluan_hash = password_hash($kata_laluan, PASSWORD_DEFAULT);

        $sql = "INSERT INTO peserta 
                (nama, no_ic, kata_laluan, syarikat, alamat, telefon, emel, kategori, bulan, nama_kursus, tarikh_kursus, yuran, verified)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssdii",
            $nama, $no_ic, $kata_laluan_hash, $syarikat, $alamat, $telefon, $emel,
            $kategori, $bulan, $nama_kursus, $tarikh_kursus, $yuran, $verified
        );

        if ($stmt->execute()) {
            header("Location: login_peserta.php?status=berjaya");
            exit();
        } else {
            $status = "❌ Ralat semasa menyimpan data: " . $conn->error;
        }
    } else {
        $status = implode("<br>", $errors);
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Kursus MRCS</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 700px; margin: auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c8102e; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 12px; margin-top: 6px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
        input[readonly] { background-color: #e9ecef; }
        button { margin-top: 24px; width: 100%; background: #c8102e; color: white; padding: 14px; border: none; font-size: 16px; border-radius: 8px; cursor: pointer; }
        button:hover { background: #a40c24; }
        .error { background: #ffe6e6; border: 1px solid red; padding: 12px; color: red; margin-bottom: 15px; border-radius: 6px; }
        .btn-kembali { display: inline-block; margin-top: 16px; color: #700000; text-decoration: underline; font-size: 14px; }
        .checkbox-label { font-weight: normal; font-size: 14px; display: flex; align-items: center; cursor: pointer; user-select: none; }
        #kategori-output { margin-top: 10px; font-weight: bold; color: #c8102e; }
    </style>
</head>
<body>
<div class="container">
    <h2>Pendaftaran Kursus MRCS</h2>

    <?php if (!empty($status)): ?>
        <div class="error"><?= $status ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nama_penuh" placeholder="Nama Penuh" required>
        <input type="text" name="no_kad_pengenalan" placeholder="No Kad Pengenalan (12 digit)" required maxlength="12">

        <div style="display: flex; align-items: center; gap: 4px; margin-top: 15px;">
            <input type="password" id="kata_laluan" name="kata_laluan" placeholder="Kata Laluan" required style="flex: 1;">
            <label class="checkbox-label">
                <input type="checkbox" onclick="togglePassword()" style="margin-right: 4px;">Tunjuk
            </label>
        </div>

        <input type="text" name="syarikat" placeholder="Syarikat" required>
        <input type="text" name="no_telefon" placeholder="No Telefon (10/11 digit)" required maxlength="11">
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="alamat" placeholder="Alamat Penuh" required></textarea>

        <label for="kategori">Kategori Latihan:</label>
        <select name="kategori" id="kategori" required onchange="paparKategoriDanTarikh()">
            <option value="">-- Pilih Kategori --</option>
            <option value="Basic First Aid">Basic First Aid</option>
            <option value="Introduction First Aid">Introduction First Aid</option>
            <option value="Psychological First Aid">Psychological First Aid</option>
            <option value="Advanced First Aid">Advanced First Aid</option>
            <option value="Basic Life Support">Basic Life Support</option>
        </select>

        <div id="kategori-output"></div>

        <div id="tarikh-kursus-container" style="display:none; margin-top:15px;">
            <label for="bulan">Pilih Tarikh Kursus:</label>
            <select name="bulan" id="bulan" required></select>
        </div>

        <label>Jumlah Yuran (RM):</label>
        <input type="text" id="jumlah_yuran" name="jumlah_yuran" readonly required>

        <button type="submit" name="submit">Daftar Peserta</button>
    </form>

    <a href="login_peserta.php" class="btn-kembali">← Kembali ke Halaman Utama</a>
</div>

<script>
function togglePassword() {
    const input = document.getElementById("kata_laluan");
    input.type = input.type === "password" ? "text" : "password";
}

function paparKategoriDanTarikh() {
    const kategori = document.getElementById("kategori").value;
    const output = document.getElementById("kategori-output");
    const tarikhContainer = document.getElementById("tarikh-kursus-container");
    const tarikhSelect = document.getElementById("bulan");
    const yuranField = document.getElementById("jumlah_yuran");

    output.textContent = kategori ? `✔️ Kategori dipilih: ${kategori}` : "";
    tarikhSelect.innerHTML = "";

    const tarikhByKategori = {
        "Basic First Aid": ["JAN 20-21 (BM)", "FEB 24-25 (BI)", "MAR 24-25 (BM)", "APR 21-22 (BI)", "MAY 26-27 (BM)", "JUN 23-24 (BI)",
            "JUL 21-22 (BM)", "AUG 18-19 (BI)", "SEPT 22-23 (BM)", "OCT 27-28 (BI)", "NOV 17-18 (BM)", "DEC 15-16 (BI)"],
        "Introduction First Aid": ["JAN 13.1.25 (BI)", "FEB 17.2.25 (BM)", "MAR 10.3.25 (BI)", "APR 14.4.25 (BM)", "MAY 19.5.25 (BI)",
            "JUN 16.6.25 (BM)", "JUL 14.7.25 (BI)", "AUG 11.8.25 (BM)", "SEPT 8.9.25 (BI)", "OCT 13.10.25 (BM)", "NOV 10.11.25 (BI)", "DEC 8.12.25 (BM)"],
        "Psychological First Aid": ["FEB 5-6 (DWI)", "APR 9-10 (DWI)", "JUN 11-12 (DWI)", "AUG 6-7 (DWI)", "OCT 8-9 (DWI)", "DEC 3-4 (DWI)"],
        "Advanced First Aid": ["APR 28-30 (DWI)", "OCT 7-9 (DWI)"],
        "Basic Life Support": ["MAY 5.5.25 (DWI)", "NOV 3.11.25 (DWI)"]
    };

    const yuranByKategori = {
        "Introduction First Aid": 230.00,
        "Basic First Aid": 350.00,
        "Advanced First Aid": 420.00,
        "Basic Life Support": 280.00,
        "Psychological First Aid": 500.00
    };

    if (kategori && tarikhByKategori[kategori]) {
        tarikhByKategori[kategori].forEach(function(tarikh) {
            const option = document.createElement("option");
            option.value = tarikh;
            option.textContent = tarikh;
            tarikhSelect.appendChild(option);
        });
        tarikhContainer.style.display = "block";
        yuranField.value = yuranByKategori[kategori] ?? "0.00";
    } else {
        tarikhContainer.style.display = "none";
        yuranField.value = "";
    }
}
</script>
</body>
</html>














<?php
session_start();
include 'config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_ic = trim($_POST['no_ic'] ?? '');
    $kata_laluan = trim($_POST['kata_laluan'] ?? '');

    if (empty($no_ic) || empty($kata_laluan)) {
        $error = "❗ Sila isi semua maklumat yang diperlukan.";
    } else {
        try {
            $sql = "SELECT * FROM peserta WHERE no_ic = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no_ic);
            $stmt->execute();
            $result = $stmt->get_result();
            $peserta = $result->fetch_assoc();

            if ($peserta) {
                if (password_verify($kata_laluan, $peserta['kata_laluan'])) {
                    $_SESSION['peserta_id'] = $peserta['id'];
                    $_SESSION['peserta_nama'] = $peserta['nama'];
                    $_SESSION['kategori'] = $peserta['kategori'];
                    $_SESSION['bulan'] = $peserta['bulan'];

                    header("Location: dashboard_peserta.php");
                    exit();
                } else {
                    $error = "❌ Kata laluan tidak sah. Sila cuba semula.";
                }
            } else {
                $error = "❌ No. IC tidak dijumpai. Sila pastikan anda telah mendaftar.";
            }

        } catch (Exception $e) {
            $error = "⚠️ Ralat sistem: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Log Masuk Peserta | MRCS</title>
  <style>
    * { box-sizing: border-box; }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      background-color: #f2f6fc;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: white;
      padding: 40px 50px;
      max-width: 420px;
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    .logo {
      display: block;
      margin: 0 auto 20px;
      max-width: 120px;
    }

    h2 {
      margin-bottom: 10px;
    }

    p {
      margin-bottom: 20px;
    }

    p a {
      color: #d90429;
      text-decoration: none;
    }

    p a:hover {
      text-decoration: underline;
    }

    form input,
    form button {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 15px;
      border-radius: 6px;
      font-size: 16px;
    }

    form input {
      border: 1px solid #ccc;
    }

    form button {
      background-color: #d90429;
      color: white;
      border: none;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    form button:hover {
      background-color: #c40324;
    }

    .show-password {
      display: flex;
      align-items: center;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 10px;
    }

    .show-password input[type="checkbox"] {
      margin-right: 5px;
      width: 16px;
      height: 16px;
      cursor: pointer;
    }

    .error {
      color: red;
      text-align: center;
      font-weight: bold;
      margin-top: 10px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <img src="logo_mrcs.jpg" alt="Logo MRCS" class="logo">
  <h2>Log Masuk Peserta</h2>
  <p>Baru di MRCS? <a href="daftar_peserta.php">Daftar akaun</a></p>

  <?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="no_ic" placeholder="No. Kad Pengenalan (tanpa '-')" required>
    
    <input type="password" name="kata_laluan" id="kata_laluan" placeholder="Kata Laluan" required>

    <div class="show-password">
      <input type="checkbox" id="togglePassword">
      <label for="togglePassword">Tunjuk Kata Laluan</label>
    </div>

    <button type="submit">Log Masuk</button>
  </form>

  <div class="links">
    <a href="lupa_kata_laluan.php">Lupa kata laluan?</a>
  </div>
</div>

<script>
  document.getElementById("togglePassword").addEventListener("change", function () {
    const passwordInput = document.getElementById("kata_laluan");
    passwordInput.type = this.checked ? "text" : "password";
  });
</script>

</body>
</html>


















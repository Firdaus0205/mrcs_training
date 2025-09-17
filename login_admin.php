<?php
session_start();
include 'config.php';

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emel = trim($_POST['emel'] ?? '');
    $katalaluan = trim($_POST['katalaluan'] ?? '');

    if (!empty($emel) && !empty($katalaluan)) {
        $stmt = $conn->prepare("SELECT id, nama, katalaluan FROM admin WHERE emel = ?");
        $stmt->bind_param("s", $emel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if ($katalaluan === $admin['katalaluan']) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_nama'] = $admin['nama'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $login_error = "❌ Emel atau katalaluan salah.";
            }
        } else {
            $login_error = "❌ Akaun tidak dijumpai.";
        }

        $stmt->close();
    } else {
        $login_error = "❗ Sila isi semua maklumat.";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Log Masuk Admin | MRCS</title>
  <style>
    * { box-sizing: border-box; }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      background-color: #f2f6fc;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .left-panel {
      background: white;
      padding: 40px 50px;
      width: 100%;
      max-width: 420px;
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
      margin-bottom: 20px;
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
    }

    @media (max-width: 600px) {
      .left-panel {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="left-panel">
    <!-- ✅ LOGO MRCS DIBIARKAN -->
    <img src="logo_mrcs.jpg" alt="Logo MRCS" class="logo">
    <h2>Log Masuk Admin</h2>

    <?php if (!empty($login_error)): ?>
      <div class="error"><?= $login_error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="email" name="emel" placeholder="Email Admin" required>
      
      <input type="password" name="katalaluan" id="katalaluan" placeholder="Kata Laluan" required>
      
      <div class="show-password">
        <input type="checkbox" id="togglePassword">
        <label for="togglePassword">Tunjuk Kata Laluan</label>
      </div>

      <button type="submit">Log Masuk (Admin)</button>
    </form>
  </div>
</div>

<script>
  document.getElementById("togglePassword").addEventListener("change", function () {
    const passwordInput = document.getElementById("katalaluan");
    passwordInput.type = this.checked ? "text" : "password";
  });
</script>

</body>
</html>












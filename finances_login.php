<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dan sanitasi asas
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // ✅ Maklumat login sah (boleh tukar ikut keperluan anda)
    $valid_email = 'harmain.shah@redcrescent.org.my';
    $valid_password = 'MRCS@2025!@#';

    if ($email === $valid_email && $password === $valid_password) {
        // Tetapkan session untuk admin kewangan
        $_SESSION['finance_id'] = 1; // ID contoh
        $_SESSION['finance_nama'] = 'Harmain Shah';

        // Redirect ke dashboard kewangan
        header("Location: dashboard_finances.php");
        exit();
    } else {
        $error = "Emel atau kata laluan tidak sah.";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Login Kewangan MRCS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: #b40000;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .show-password {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #b40000;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #900000;
        }
        .error {
            color: red;
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Kewangan MRCS</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Emel</label>
        <input type="email" id="email" name="email" required placeholder="Contoh: harmain.shah@redcrescent.org.my" autofocus>

        <label for="password">Kata Laluan</label>
        <input type="password" id="password" name="password" required placeholder="Kata laluan anda">

        <!-- Kotak kecil Tunjuk kata laluan -->
        <div class="show-password">
            <input type="checkbox" id="togglePassword">
            <label for="togglePassword">Tunjuk kata laluan</label>
        </div>

        <button type="submit">Log Masuk</button>
    </form>
</div>

<script>
    // JavaScript untuk toggle kata laluan
    document.getElementById("togglePassword").addEventListener("change", function() {
        const passwordField = document.getElementById("password");
        passwordField.type = this.checked ? "text" : "password";
    });
</script>

</body>
</html>













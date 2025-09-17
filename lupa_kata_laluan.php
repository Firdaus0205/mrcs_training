<?php
// mula session jika perlukan (contoh untuk pesan notifikasi)
session_start();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lupa Kata Laluan – MRCS</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fafafa;
            margin: 0; padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 420px;
            width: 100%;
        }
        h2 {
            color: #b30000;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }
        input[type="email"]:focus {
            border-color: #b30000;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #b30000;
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #8a0000;
        }
        .info {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
            text-align: center;
        }
        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lupa Kata Laluan – Peserta MRCS</h2>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="message <?= $_SESSION['msg_type'] === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_SESSION['msg']) ?>
            </div>
            <?php
            unset($_SESSION['msg']);
            unset($_SESSION['msg_type']);
            ?>
        <?php endif; ?>

        <form action="proses_reset.php" method="POST" novalidate>
            <label for="email">Masukkan Emel Berdaftar Anda</label>
            <input type="email" id="email" name="email" placeholder="emel@contoh.com" required autofocus>
            <button type="submit">Hantar Permintaan</button>
            <p style="text-align:center; margin-top: 25px;">
  <a href="login_peserta.php" style="
    display: inline-block;
    background-color: #b30000;
    color: #fff;
    padding: 12px 28px;
    border-radius: 6px;
    font-weight: 700;
    text-decoration: none;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 4px 8px rgba(179, 0, 0, 0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  " 
  onmouseover="this.style.backgroundColor='#8a0000'; this.style.boxShadow='0 6px 12px rgba(138, 0, 0, 0.5)';" 
  onmouseout="this.style.backgroundColor='#b30000'; this.style.boxShadow='0 4px 8px rgba(179, 0, 0, 0.3)';"
  >
    Kembali ke Log Masuk
  </a>
</p>

        </form>

        <p class="info">Satu pautan untuk reset kata laluan akan dihantar ke emel anda jika alamat yang dimasukkan wujud dalam sistem MRCS.</p>
    </div>
    
</body>
</html>

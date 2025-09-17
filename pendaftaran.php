<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran MRCS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #b30000;
        }

        p {
            color: #333;
            font-size: 16px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #b30000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #800000;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="logo_mrcs.jpg" alt="Logo MRCS" class="logo">

    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "<h2>Pendaftaran Berjaya!</h2>";
        echo "<p>Maklumat anda telah dihantar dan akan dipaparkan di dashboard admin.</p>";
    } else {
        echo "<h2>Akses Tidak Sah</h2>";
        echo "<p>Sila daftar terlebih dahulu melalui borang yang sah.</p>";
    }
    ?>

    <a href="login.php">← Kembali ke Log Masuk</a>
</div>

</body>
</html>

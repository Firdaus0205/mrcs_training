<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Log Keluar | MRCS Finance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="3;url=finances_login.php">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white border border-red-600 shadow-lg rounded-xl p-10 text-center max-w-md">
        <div class="mb-4">
            <img src="logo_mrcs.jpg" alt="MRCS Logo" class="mx-auto w-24 mb-4"> <!-- Ganti dengan logo sebenar jika ada -->
            <h1 class="text-2xl font-bold text-red-700">Log Keluar Berjaya</h1>
        </div>
        <p class="text-gray-700 text-sm">Anda telah berjaya log keluar daripada sistem kewangan MRCS.</p>
        <p class="text-gray-500 text-xs mt-2">Anda akan dialihkan ke halaman log masuk dalam beberapa saat...</p>

        <div class="mt-6">
            <a href="finances_login.php" class="text-white bg-red-600 hover:bg-red-700 font-semibold px-4 py-2 rounded-md shadow">
                🔒 Log Masuk Semula
            </a>
        </div>
    </div>
</body>
</html>
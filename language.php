<?php
// TIDAK PERLU session_start() di sini
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : "bm";

$translations = [
    "bm" => [
        "welcome" => "Selamat Datang",
        "register" => "Daftar",
        "name" => "Nama",
        "ic" => "Nombor Kad Pengenalan",
        "submit" => "Hantar",
        "language" => "Bahasa",
    ],
    "en" => [
        "welcome" => "Welcome",
        "register" => "Register",
        "name" => "Name",
        "ic" => "IC Number",
        "submit" => "Submit",
        "language" => "Language",
    ]
];

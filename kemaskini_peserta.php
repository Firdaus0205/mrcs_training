<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$id_peserta = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dapatkan maklumat peserta
$stmt = $conn->prepare("SELECT * FROM peserta WHERE id = ?");
$stmt->bind_param("i", $id_peserta);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();

// Jadual kursus penuh
$kategori_latihan = [
    "Basic First Aid CPR & AED" => [
        "JAN 20-21 (BM)", "FEB 24-25 (BI)", "MAR 24-25 (BM)", "APR 21-22 (BI)",
        "MAY 26-27 (BM)", "JUN 23-24 (BI)", "JUL 21-22 (BM)", "AUG 18-19 (BI)",
        "SEPT 22-23 (BM)", "OCT 27-28 (BI)", "NOV 17-18 (BM)", "DEC 15-16 (BI)"
    ],
    "Introduction First Aid & CPR + AED" => [
        "JAN 13.1.25 (BI)", "FEB 17.2.25 (BM)", "MAR 10.3.25 (BI)", "APR 14.4.25 (BM)",
        "MAY 19.5.25 (BI)", "JUN 16.6.25 (BM)", "JUL 14.7.25 (BI)", "AUG 11.8.25 (BM)",
        "SEP 8.9.25 (BI)", "OCT 13.10.25 (BM)", "NOV 10.11.25 (BI)", "DEC 8.12.25 (BM)"
    ],
    "Psychological First Aid" => [
        "FEB 5-6 (DWI)", "APR 9-10 (DWI)", "JUN 11-12 (DWI)",
        "AUG 6-7 (DWI)", "OCT 8-9 (DWI)", "DEC 3-4 (DWI)"
    ],
    "Advanced First Aid & CPR + AED" => [
        "APR 28-30 (DWI)", "OCT 7-9 (DWI)"
    ],
    "Basic Life Support (BLS)" => [
        "MAY 5.5.25 (DWI)", "NOV 3.11.25 (DWI)"
    ]
];

// Proses kemaskini
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $emel = trim($_POST['emel']);
    $telefon = trim($_POST['telefon']);
    $kategori = trim($_POST['kategori']);
    $tarikh_kursus = trim($_POST['tarikh_kursus']);

    $stmt = $conn->prepare("UPDATE peserta SET nama = ?, emel = ?, telefon = ?, kategori = ?, tarikh_kursus = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama, $emel, $telefon, $kategori, $tarikh_kursus, $id_peserta);
    $stmt->execute();

    header("Location: admin_dashboard.php?kemaskini=berjaya");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Kemaskini Peserta | MRCS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8 border border-red-600">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-red-700">🩺 Kemaskini Maklumat Peserta</h2>
        <a href="admin_dashboard.php" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
    </div>

    <form method="post" class="space-y-5">
        <div>
            <label class="block text-gray-700 font-semibold">👤 Nama Peserta</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($peserta['nama'] ?? '') ?>" required
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" />
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">📧 Emel</label>
            <input type="email" name="emel" value="<?= htmlspecialchars($peserta['emel'] ?? '') ?>" required
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" />
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">📱 No. Telefon</label>
            <input type="text" name="telefon" value="<?= htmlspecialchars($peserta['telefon'] ?? '') ?>" required
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600" />
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">🎓 Kategori Latihan</label>
            <select id="kategori_latihan" name="kategori_latihan" required
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600">
                <?php foreach ($kategori_latihan as $kategori_option => $tarikh_list): ?>
                    <option value="<?= htmlspecialchars($kategori_option) ?>" 
                        <?= ($peserta['kategori_latihan'] ?? '') === $kategori_option ? 'selected' : '' ?>>
                        <?= $kategori_option ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-red-700 font-semibold mt-2" id="kategori_terpilih">
                <?php if (!empty($peserta['kategori_latihan'])): ?>
                    ✔ Kategori yang dipilih: <?= htmlspecialchars($peserta['kategori_latihan']) ?>
                <?php endif; ?>
            </p>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">📅 Tarikh Kursus</label>
            <select id="tarikh_kursus" name="tarikh_kursus" required
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"></select>
        </div>

        <div class="pt-4 text-right">
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-lg">
                💾 Simpan Kemaskini
            </button>
        </div>
    </form>
</div>

<script>
const kategoriLatihan = <?= json_encode($kategori_latihan); ?>;
const kategoriSelect = document.getElementById('kategori_latihan');
const tarikhSelect = document.getElementById('tarikh_kursus');
const kategoriTerpilih = document.getElementById('kategori_terpilih');

function populateTarikh(selectedKategori, selectedTarikh = '') {
    tarikhSelect.innerHTML = '';
    if (kategoriLatihan[selectedKategori]) {
        kategoriLatihan[selectedKategori].forEach(tarikh => {
            const option = document.createElement('option');
            option.value = tarikh;
            option.textContent = tarikh;
            if (tarikh === selectedTarikh) {
                option.selected = true;
            }
            tarikhSelect.appendChild(option);
        });
    }
}

kategoriSelect.addEventListener('change', () => {
    const kategori = kategoriSelect.value;
    kategoriTerpilih.textContent = `✔ Kategori yang dipilih: ${kategori}`;
    populateTarikh(kategori);
});

window.onload = () => {
    const kategori = kategoriSelect.value;
    const tarikhPeserta = <?= json_encode($peserta['tarikh_kursus'] ?? '') ?>;
    populateTarikh(kategori, tarikhPeserta);
};
</script>
</body>
</html>








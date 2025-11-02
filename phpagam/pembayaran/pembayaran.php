<?php
// pembayaran/pembayaran.php
require '../includes/config.php';

// Pastikan koneksi ada
if (!isset($mysqli)) {
    die("Koneksi ke database gagal!");
}

// Ambil ID pesanan dari URL (GET)
$id_pesanan = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id_pesanan <= 0) {
    // Kalau id tidak valid -> beri pesan dan link balik
    echo "<p>ID pesanan tidak valid. <a href='index.php'>Kembali ke daftar pembayaran</a></p>";
    exit;
}

// Ambil data pesanan berdasarkan id
$stmt = $mysqli->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_assoc();

if (!$pesanan) {
    echo "<p>Pesanan dengan ID <strong>$id_pesanan</strong> tidak ditemukan. <a href='index.php'>Kembali</a></p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran - Pesanan #<?= htmlspecialchars($pesanan['id_pesanan']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color:#D8E3E7; padding:30px; }
        .card { background:#fff; padding:20px; border-radius:10px; width:360px; box-shadow:0 2px 6px rgba(0,0,0,0.12); }
        h2 { color:#496A74; margin-top:0; }
        label { display:block; margin-top:10px; }
        input, select { width:100%; padding:8px; margin-top:6px; box-sizing:border-box; }
        button { margin-top:12px; background:#496A74; color:#fff; padding:10px; border:none; border-radius:6px; cursor:pointer; width:100%;}
        a { color:#496A74; text-decoration:none; display:inline-block; margin-top:10px;}
    </style>
</head>
<body>

<div class="card">
    <h2>Proses Pembayaran</h2>

    <p><strong>Nama Pelanggan:</strong><br>
       <?= htmlspecialchars($pesanan['nama_pelanggan']) ?></p>

    <p><strong>Total Harga:</strong><br>
       Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></p>

    <form action="simpan_pembayaran.php" method="POST">
        <input type="hidden" name="id_pesanan" value="<?= (int)$pesanan['id_pesanan'] ?>">

        <label for="metode">Metode Pembayaran</label>
        <select id="metode" name="metode_pembayaran" required>
            <option value="">-- Pilih Metode --</option>
            <option value="Tunai">Tunai</option>
            <option value="NonTunai">Non Tunai</option>
        </select>

        <label for="jumlah">Jumlah Bayar (Rp)</label>
        <input id="jumlah" type="number" name="jumlah_bayar" step="100" min="0" required>

        <button type="submit">Bayar Sekarang</button>
    </form>

    <a href="index.php">← Kembali ke Daftar Pembayaran</a>
</div>

</body>
</html>

<?php
session_start();
require '../includes/config.php';

// Cek koneksi database
if (!isset($mysqli)) {
    die("Koneksi ke database gagal!");
}

// Cek apakah kasir sudah login
if (!isset($_SESSION['id_kasir'])) {
    echo "<script>alert('Sesi kasir tidak ditemukan, silakan login ulang!'); window.location='../index.php';</script>";
    exit;
}

$id_kasir = $_SESSION['id_kasir'];
$id_pesanan = $_POST['id_pesanan'] ?? null;
$metode_pembayaran = $_POST['metode_pembayaran'] ?? null;
$jumlah_bayar = $_POST['jumlah_bayar'] ?? null;

// Validasi input
if (!$id_pesanan || !$metode_pembayaran || !$jumlah_bayar) {
    echo "<script>alert('Data tidak lengkap!'); history.back();</script>";
    exit;
}

// Ambil total harga dari pesanan
$stmt = $mysqli->prepare("SELECT total_harga FROM pesanan WHERE id_pesanan = ?");
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_assoc();

if (!$pesanan) {
    echo "<script>alert('Pesanan tidak ditemukan!'); history.back();</script>";
    exit;
}

$total_harga = $pesanan['total_harga'];
$kembalian = $jumlah_bayar - $total_harga;
$tanggal = date('Y-m-d H:i:s');

// Simpan data pembayaran
$stmt = $mysqli->prepare("
    INSERT INTO pembayaran (id_pesanan, id_kasir, metode_pembayaran, jumlah_bayar, kembalian, tanggal_pembayaran)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("iisdss", $id_pesanan, $id_kasir, $metode_pembayaran, $jumlah_bayar, $kembalian, $tanggal);

if ($stmt->execute()) {
    // Update status pesanan
    $update = $mysqli->prepare("UPDATE pesanan SET status_pesanan='Sudah Dibayar' WHERE id_pesanan=?");
    $update->bind_param("i", $id_pesanan);
    $update->execute();

    // Tambahkan data ke laporan_penjualan
    $tanggal_laporan = date('Y-m-d');
    $total_transaksi = 1; // setiap pembayaran dianggap 1 transaksi
    $total_pendapatan = $total_harga;

    $laporan = $mysqli->prepare("
        INSERT INTO laporan_penjualan (tanggal_laporan, total_transaksi, total_pendapatan, id_kasir)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            total_transaksi = total_transaksi + VALUES(total_transaksi),
            total_pendapatan = total_pendapatan + VALUES(total_pendapatan)
    ");
    $laporan->bind_param("sidi", $tanggal_laporan, $total_transaksi, $total_pendapatan, $id_kasir);
    $laporan->execute();

    echo "<script>
        alert('Pembayaran berhasil! Kembalian: Rp " . number_format($kembalian, 0, ',', '.') . "');
        window.location='../pesanan/daftar_pesanan.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyimpan pembayaran!\\nError: " . addslashes($stmt->error) . "');
        history.back();
    </script>";
}
?>

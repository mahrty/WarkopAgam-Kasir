<?php
session_start();
require '../includes/config.php';

// Cek login
if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

// Cek apakah id dikirim
if (!isset($_GET['id'])) {
  header('Location: daftar_pesanan.php');
  exit;
}

$id_pesanan = intval($_GET['id']);
if ($id_pesanan <= 0) {
  header('Location: daftar_pesanan.php');
  exit;
}

// Hapus dulu detail pesanan
if (!$mysqli->query("DELETE FROM detail_pesanan WHERE id_pesanan = $id_pesanan")) {
  die("Gagal hapus detail pesanan: " . $mysqli->error);
}

// Baru hapus pesanan utama
if (!$mysqli->query("DELETE FROM pesanan WHERE id_pesanan = $id_pesanan")) {
  die("Gagal hapus pesanan utama: " . $mysqli->error);
}

// Kembali ke daftar pesanan
header('Location: daftar_pesanan.php');
exit;
?>

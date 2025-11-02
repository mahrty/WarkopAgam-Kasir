<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

$id = $_GET['id'] ?? 0;

// ambil nama gambar biar bisa dihapus juga
$result = $mysqli->query("SELECT gambar FROM menu WHERE id_menu=$id");
$data = $result->fetch_assoc();

if ($data && $data['gambar'] && file_exists("../uploads/" . $data['gambar'])) {
  unlink("../uploads/" . $data['gambar']);
}

$mysqli->query("DELETE FROM menu WHERE id_menu=$id");
header("Location: kelola_menu.php");
exit;
?>

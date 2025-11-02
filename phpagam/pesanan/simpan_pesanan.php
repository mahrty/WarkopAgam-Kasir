<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_pelanggan = trim($_POST['nama_pelanggan']);
  $tanggal = date('Y-m-d H:i:s');
  $total_harga = 0;

  if (!empty($_POST['menu'])) {
    $menu_ids = $_POST['menu'];

    // Hitung total harga pesanan
    foreach ($menu_ids as $id_menu) {
      $jumlah = (int)$_POST['jumlah_' . $id_menu];
      $result = $mysqli->query("SELECT harga FROM menu WHERE id_menu = '$id_menu'");
      if ($result && $menu = $result->fetch_assoc()) {
        $subtotal = $menu['harga'] * $jumlah;
        $total_harga += $subtotal;
      }
    }

    // Simpan ke tabel pesanan (status default: Belum Dibayar)
    $stmt = $mysqli->prepare("INSERT INTO pesanan (tanggal_pesanan, nama_pelanggan, total_harga, status_pesanan) VALUES (?, ?, ?, 'Belum Dibayar')");
    if (!$stmt) {
      die("Query Error: " . $mysqli->error);
    }

    $stmt->bind_param('ssd', $tanggal, $nama_pelanggan, $total_harga);
    $stmt->execute();
    $id_pesanan = $stmt->insert_id;

    // Simpan ke detail_pesanan
    foreach ($menu_ids as $id_menu) {
      $jumlah = (int)$_POST['jumlah_' . $id_menu];
      $result = $mysqli->query("SELECT harga FROM menu WHERE id_menu = '$id_menu'");
      if ($result && $menu = $result->fetch_assoc()) {
        $subtotal = $menu['harga'] * $jumlah;

        $stmt_detail = $mysqli->prepare("INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");
        $stmt_detail->bind_param('iiid', $id_pesanan, $id_menu, $jumlah, $subtotal);
        $stmt_detail->execute();
      }
    }

    echo "<script>
      alert('Pesanan berhasil disimpan!');
      window.location.href = 'daftar_pesanan.php';
    </script>";

  } else {
    echo "<script>
      alert('Tidak ada menu yang dipilih!');
      history.back();
    </script>";
  }
}
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warkop Agam - Kasir</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #D8E3E7;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background-color: #89A6A8;
      padding: 15px 25px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      font-weight: bold;
    }
    .navbar a:hover {
      text-decoration: underline;
    }
    main {
      padding: 30px;
    }
    .card {
      background-color: #BEDADC;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .btn {
      background-color: #496A74;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover {
      background-color: #2d4b53;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div><strong>Warkop Agam</strong></div>
    <div>
      <a href="/phpagam/dashboard.php">Home</a>
      <a href="/phpagam/menu/kelola_menu.php">Kelola Menu</a>
      <a href="/phpagam/pesanan/input_pesanan.php">Input Pesanan</a>
      <a href="/phpagam/pembayaran/index.php">Pembayaran</a>
      <a href="/phpagam/laporan/laporan_penjualan.php">Laporan</a>
      <a href="/phpagam/logout.php">Logout</a>
    </div>
  </div>

  <main>

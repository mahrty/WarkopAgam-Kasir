<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['kasir_logged']) || $_SESSION['kasir_logged'] !== true) {
    header('Location: index.php');
    exit;
}

$nama = $_SESSION['nama_kasir'] ?? 'Kasir';
include 'includes/header.php';
?>

<style>
  body, html {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
  }

  .hero {
    height: 100vh;
    background: linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,0.6)),
                url('uploads/warkop.png') center/cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hero-content {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(6px);
    border-radius: 16px;
    padding: 50px 60px;
    text-align: center;
    max-width: 700px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    animation: fadeIn 1s ease-in-out;
  }

  .hero-content h1 {
    font-size: 48px;
    font-weight: 700;
    color: #2f3e46;
    margin-bottom: 10px;
  }

  .hero-content h2 {
    font-size: 20px;
    color: #496A74;
    font-weight: 500;
    margin-bottom: 25px;
  }

  .hero-content p {
    color: #333;
    font-size: 17px;
    line-height: 1.7;
  }

  .btn-start {
    margin-top: 25px;
    background: #496A74;
    color: #fff;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
  }

  .btn-start:hover {
    background: #35545b;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 768px) {
    .hero-content {
      padding: 40px 25px;
    }

    .hero-content h1 {
      font-size: 36px;
    }
  }
</style>

<div class="hero">
  <div class="hero-content">
    <h1>Selamat Datang, <?= htmlspecialchars($nama) ?></h1>
    <h2>di Warkop Agam</h2>
    <p>
      Tempat di mana kopi, tawa, dan cerita sederhana bertemu.  
      Yuk mulai hari ini dengan semangat baru dan pelayanan terbaik  
      untuk setiap pelanggan yang datang.
    </p>
    <button class="btn-start" onclick="window.location.href='pesanan/input_pesanan.php'">
      Mulai Input Pesanan
    </button>
  </div>
</div>


</main>
</body>
</html>

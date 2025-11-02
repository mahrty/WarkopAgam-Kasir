<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

include '../includes/header.php';

// ambil daftar menu dari database
$menu = $mysqli->query("SELECT * FROM menu WHERE status='Tersedia' ORDER BY nama_menu ASC");
?>

<h2>Input Pesanan</h2>

<form action="simpan_pesanan.php" method="POST">
  <div class="card">
    <label>Nama Pelanggan:</label><br>
    <input type="text" name="nama_pelanggan" required><br><br>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
      <tr style="background-color:#89A6A8;color:white;">
        <th>Pilih</th>
        <th>Nama Menu</th>
        <th>Harga</th>
        <th>Jumlah</th>
      </tr>

      <?php while ($row = $menu->fetch_assoc()) { ?>
        <tr>
          <td><input type="checkbox" name="menu[]" value="<?= $row['id_menu'] ?>"></td>
          <td><?= $row['nama_menu'] ?></td>
          <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
          <td><input type="number" name="jumlah_<?= $row['id_menu'] ?>" min="1" value="1"></td>
        </tr>
      <?php } ?>
    </table>

    <br>
    <button type="submit" style="background-color:#496A74;color:white;padding:6px 12px;border:none;border-radius:5px;">
      Simpan Pesanan
    </button>
  </div>
</form>

</main>
</body>
</html>

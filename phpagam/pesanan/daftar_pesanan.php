<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

include '../includes/header.php';
?>

<h2>Daftar Pesanan</h2>

<div class="card">
  <a href="input_pesanan.php" class="btn" style="background-color:#496A74;color:white;padding:6px 12px;border-radius:5px;text-decoration:none;">+ Tambah Pesanan</a>
  <br><br>

  <table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr style="background-color:#89A6A8;color:white;">
      <th>ID Pesanan</th>
      <th>Tanggal</th>
      <th>Nama Pelanggan</th>
      <th>Total Harga</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>

    <?php
    $result = $mysqli->query("SELECT * FROM pesanan ORDER BY id_pesanan DESC");

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $total = "Rp " . number_format($row['total_harga'], 0, ',', '.');

        echo "<tr>
                <td>{$row['id_pesanan']}</td>
                <td>{$row['tanggal_pesanan']}</td>
                <td>{$row['nama_pelanggan']}</td>
                <td>{$total}</td>
                <td>{$row['status_pesanan']}</td>
                <td>";

        // tombol Bayar muncul kalau statusnya Belum Dibayar
        if ($row['status_pesanan'] === 'Belum Dibayar') {
          echo "<a href='../pembayaran/pembayaran.php?id={$row['id_pesanan']}' 
                 style='background-color:#4CAF50;color:white;padding:4px 8px;border-radius:4px;text-decoration:none;margin-right:5px;'>
                 Bayar</a>";
        }

        echo "<a href='hapus_pesanan.php?id={$row['id_pesanan']}' 
                onclick='return confirm(\"Yakin mau hapus pesanan ini?\")' 
                style='background-color:#d9534f;color:white;padding:4px 8px;border-radius:4px;text-decoration:none;'>
                Hapus</a>";

        echo "</td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='6' align='center'>Belum ada pesanan.</td></tr>";
    }
    ?>
  </table>
</div>

</main>
</body>
</html>

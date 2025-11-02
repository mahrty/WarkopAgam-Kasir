<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

include '../includes/header.php';
?>

<h2>Kelola Menu</h2>

<div class="card">
  <a href="tambah_menu.php" class="btn">+ Tambah Menu</a>
  <br><br>

  <table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr style="background-color:#89A6A8;color:white;">
      <th>ID</th>
      <th>Nama Menu</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Status</th>
      <th>Deskripsi</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>

    <?php
    $result = $mysqli->query("SELECT * FROM menu ORDER BY id_menu DESC");
    while ($row = $result->fetch_assoc()) {
      $img = $row['gambar'] ? "<img src='../uploads/{$row['gambar']}' width='70'>" : "-";
      echo "<tr>
        <td>{$row['id_menu']}</td>
        <td>{$row['nama_menu']}</td>
        <td>{$row['kategori']}</td>
        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
        <td>{$row['stok']}</td>
        <td>{$row['status']}</td>
        <td>{$row['deskripsi']}</td>
        <td>{$img}</td>
        <td>
          <a href='edit_menu.php?id={$row['id_menu']}' style='color:blue;'>Edit</a> |
          <a href='hapus_menu.php?id={$row['id_menu']}' onclick='return confirm(\"Yakin mau hapus?\")' style='color:red;'>Hapus</a>
        </td>
      </tr>";
    }
    ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>

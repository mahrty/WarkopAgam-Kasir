<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

$id = $_GET['id'] ?? 0;
$result = $mysqli->query("SELECT * FROM menu WHERE id_menu = $id");
$menu = $result->fetch_assoc();

include '../includes/header.php';

if (isset($_POST['update'])) {
  $nama_menu = $_POST['nama_menu'];
  $kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $status = $_POST['status'];
  $deskripsi = $_POST['deskripsi'];
  $gambar = $menu['gambar'];

  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
      move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath);
      $gambar = $fileName;
    }
  }

  $stmt = $mysqli->prepare("UPDATE menu SET nama_menu=?, kategori=?, harga=?, stok=?, status=?, deskripsi=?, gambar=? WHERE id_menu=?");
  $stmt->bind_param('ssdisssi', $nama_menu, $kategori, $harga, $stok, $status, $deskripsi, $gambar, $id);
  $stmt->execute();

  header("Location: kelola_menu.php");
  exit;
}
?>

<div class="card">
  <h3>Edit Menu</h3>
  <form method="post" enctype="multipart/form-data">
    <label>Nama Menu</label><br>
    <input type="text" name="nama_menu" value="<?= htmlspecialchars($menu['nama_menu']) ?>" required><br>

    <label>Kategori</label><br>
    <select name="kategori">
      <option value="Makanan" <?= $menu['kategori']=='Makanan'?'selected':'' ?>>Makanan</option>
      <option value="Minuman" <?= $menu['kategori']=='Minuman'?'selected':'' ?>>Minuman</option>
    </select><br>

    <label>Harga</label><br>
    <input type="number" name="harga" value="<?= $menu['harga'] ?>" required><br>

    <label>Stok</label><br>
    <input type="number" name="stok" value="<?= $menu['stok'] ?>" required><br>

    <label>Status</label><br>
    <select name="status">
      <option value="Tersedia" <?= $menu['status']=='Tersedia'?'selected':'' ?>>Tersedia</option>
      <option value="Tidak Tersedia" <?= $menu['status']=='Tidak Tersedia'?'selected':'' ?>>Tidak Tersedia</option>
    </select><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi" rows="2"><?= htmlspecialchars($menu['deskripsi']) ?></textarea><br>

    <label>Gambar</label><br>
    <?php if ($menu['gambar']) echo "<img src='../uploads/{$menu['gambar']}' width='70'><br>"; ?>
    <input type="file" name="gambar"><br><br>

    <button class="btn" type="submit" name="update">Update</button>
  </form>
</div>

</main>
</body>
</html>

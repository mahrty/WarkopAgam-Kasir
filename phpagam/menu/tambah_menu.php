<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['kasir_logged'])) {
  header('Location: ../index.php');
  exit;
}

include '../includes/header.php';

if (isset($_POST['tambah'])) {
  $nama_menu = $_POST['nama_menu'];
  $kategori = $_POST['kategori'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $status = $_POST['status'];
  $deskripsi = $_POST['deskripsi'];
  $gambar = '';

  // Upload gambar
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
      if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
        $gambar = $fileName;
      } else {
        echo "<div class='card' style='color:red;'>Gagal upload gambar!</div>";
      }
    } else {
      echo "<div class='card' style='color:red;'>Format file tidak diizinkan!</div>";
    }
  }

  $stmt = $mysqli->prepare("INSERT INTO menu (nama_menu, kategori, harga, stok, status, deskripsi, gambar) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param('ssdisss', $nama_menu, $kategori, $harga, $stok, $status, $deskripsi, $gambar);
  $stmt->execute();

  header("Location: kelola_menu.php");
  exit;
}
?>

<div class="card">
  <h3>Tambah Menu Baru</h3>
  <form method="post" enctype="multipart/form-data">
    <label>Nama Menu</label><br>
    <input type="text" name="nama_menu" required><br>

    <label>Kategori</label><br>
    <select name="kategori" required>
      <option value="Makanan">Makanan</option>
      <option value="Minuman">Minuman</option>
    </select><br>

    <label>Harga</label><br>
    <input type="number" name="harga" required><br>

    <label>Stok</label><br>
    <input type="number" name="stok" required><br>

    <label>Status</label><br>
    <select name="status" required>
      <option value="Tersedia">Tersedia</option>
      <option value="Tidak Tersedia">Tidak Tersedia</option>
    </select><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi" rows="2"></textarea><br>

    <label>Upload Gambar</label><br>
    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif"><br><br>

    <button class="btn" type="submit" name="tambah">Simpan</button>
  </form>
</div>

</main>
</body>
</html>

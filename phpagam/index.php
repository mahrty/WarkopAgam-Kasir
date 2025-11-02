<?php
session_start();
require 'includes/config.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $err = 'Username dan password wajib diisi.';
    } else {
        $stmt = $mysqli->prepare("SELECT id_kasir, username, password, nama_kasir FROM kasir WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $row = $res->fetch_assoc()) {
            if ($password === $row['password']) {
                $_SESSION['kasir_logged'] = true;
                $_SESSION['id_kasir'] = $row['id_kasir'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['nama_kasir'] = $row['nama_kasir'];
                header('Location: dashboard.php');
                exit;
            } else {
                $err = 'Password salah.';
            }
        } else {
            $err = 'Username tidak ditemukan.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Kasir - Warkop Agam</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #D8E3E7, #BEDADC);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      padding: 40px 50px;
      width: 100%;
      max-width: 380px;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      color: #496A74;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 18px;
      text-align: left;
    }

    label {
      font-weight: 500;
      color: #333;
      font-size: 14px;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #BEDADC;
      border-radius: 10px;
      font-size: 15px;
      margin-top: 5px;
      box-sizing: border-box;
    }

    input:focus {
      outline: none;
      border-color: #496A74;
      box-shadow: 0 0 6px rgba(73,106,116,0.3);
    }

    .btn {
      width: 100%;
      background: #496A74;
      color: #fff;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background: #35525c;
    }

    .error {
      color: #c0392b;
      background: #fceaea;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 14px;
      font-weight: 500;
    }

    .footer {
      margin-top: 20px;
      font-size: 13px;
      color: #777;
    }

    .footer code {
      background: #f0f4f5;
      padding: 2px 5px;
      border-radius: 4px;
    }

  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login Kasir</h2>
    <?php if ($err): ?>
      <div class="error"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <button class="btn" type="submit">Masuk</button>
    </form>

    <div class="footer">
      Belum punya akun? Daftar
    </div>
  </div>
</body>
</html>

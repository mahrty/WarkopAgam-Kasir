<?php

    $host = 'localhost';
    $user = 'root';
    $pass = ''; // default XAMPP kosong
    $db   = 'agam_kasir';

    $mysqli = new mysqli($host, $user, $pass, $db);

    if ($mysqli->connect_errno) {
        die("Gagal koneksi database: " . $mysqli->connect_error);
    }

    // set timezone (opsional)
    date_default_timezone_set('Asia/Jakarta');
?>

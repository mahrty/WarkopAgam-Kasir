<?php
session_start();
require '../includes/config.php';

// Pastikan kasir login
if (!isset($_SESSION['kasir_logged']) || $_SESSION['kasir_logged'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../includes/header.php';
?>

<style>
    body {
        background-color: #BEDADC;
        font-family: "Poppins", sans-serif;
    }

    .container {
        max-width: 1000px;
        margin: 50px auto;
        background-color: #D8E3E7;
        padding: 20px 30px;
        border-radius: 10px;
    }

    h2 {
        text-align: left;
        color: #000;
        margin-bottom: 20px;
        font-weight: 600;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #D8E3E7;
    }

    th, td {
        border: 1px solid #000000;
        padding: 10px 15px;
        text-align: center;
    }

    th {
        background-color: #89A6A8;
        color: #fff;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #BEDADC;
    }

    .total-box {
        background-color: #89A6A8;
        color: #fff;
        text-align: center;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px;
        margin-top: 20px;
    }

    .alert {
        text-align: center;
        background-color: #BEDADC;
        padding: 10px;
        border-radius: 5px;
        font-weight: 500;
    }
</style>

<div class="container">
    <h2>Laporan Penjualan</h2>

    <?php
    $query = "
        SELECT lp.*, k.nama_kasir
        FROM laporan_penjualan lp
        JOIN kasir k ON lp.id_kasir = k.id_kasir
        ORDER BY lp.tanggal_laporan DESC
    ";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0):
    ?>
        <table>
            <thead>
                <tr>
                    <th>ID Laporan</th>
                    <th>Tanggal</th>
                    <th>Nama Kasir</th>
                    <th>Total Transaksi</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPendapatanKeseluruhan = 0;
                while ($row = $result->fetch_assoc()):
                    $totalPendapatanKeseluruhan += $row['total_pendapatan'];
                ?>
                    <tr>
                        <td><?= $row['id_laporan'] ?></td>
                        <td><?= date('Y-m-d', strtotime($row['tanggal_laporan'])) ?></td>
                        <td><?= htmlspecialchars($row['nama_kasir']) ?></td>
                        <td><?= $row['total_transaksi'] ?></td>
                        <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-box">
            Total Pendapatan Keseluruhan: Rp <?= number_format($totalPendapatanKeseluruhan, 0, ',', '.') ?>
        </div>

    <?php else: ?>
        <div class="alert">
            Belum ada data laporan penjualan.
        </div>
    <?php endif; ?>
</div>

</main>
</body>
</html>

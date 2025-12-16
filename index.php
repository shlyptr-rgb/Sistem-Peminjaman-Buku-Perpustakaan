<?php
require_once "../config/koneksi.php";

$data = mysqli_query($koneksi, "
    SELECT t.*,
           p.Nama_Peminjam,
           b.Judul,
           g.Nama_Petugas
    FROM transaksi_peminjaman t
    JOIN peminjam p ON t.ID_Peminjam = p.ID_Peminjam
    JOIN buku b ON t.ID_Buku = b.ID_Buku
    JOIN petugas g ON t.ID_Petugas = g.ID_Petugas
    ORDER BY t.ID_Transaksi DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-journal-text"></i> Data Transaksi Peminjaman
        </h3>
        <p class="text-muted mb-0">Daftar transaksi peminjaman buku</p>
    </div>

    <!-- BUTTON -->
    <div class="d-flex justify-content-between mb-3">
        <a href="../index.php" class="btn btn-secondary">
            <i class="bi bi-house-door"></i> Home
        </a>

        <a href="tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Petugas</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($r = mysqli_fetch_assoc($data)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $r['Nama_Peminjam'] ?></td>
                        <td><?= $r['Judul'] ?></td>
                        <td><?= $r['Nama_Petugas'] ?></td>

                        <td>
                            <?= $r['Tanggal_Pinjam']
                                ? date('d-m-Y', strtotime($r['Tanggal_Pinjam']))
                                : '-' ?>
                        </td>

                        <td>
                            <?= $r['Jatuh_Tempo']
                                ? date('d-m-Y', strtotime($r['Jatuh_Tempo']))
                                : '-' ?>
                        </td>

                        <td>
                            <?php if ($r['Status_Pinjam'] == 'Dipinjam') { ?>
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            <?php } else { ?>
                                <span class="badge bg-success">Dikembalikan</span>
                            <?php } ?>
                        </td>

                        <td>
                            <a href="edit.php?id=<?= $r['ID_Transaksi'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="hapus.php?id=<?= $r['ID_Transaksi'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus transaksi ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <p class="text-center mt-4 text-muted">
        © Sistem Peminjaman Buku | by Sherly
    </p>

</div>

</body>
</html>

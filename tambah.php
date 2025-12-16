<?php
require_once "../config/koneksi.php";

$peminjam = mysqli_query($koneksi, "SELECT * FROM peminjam");
$buku     = mysqli_query($koneksi, "SELECT * FROM buku");
$petugas  = mysqli_query($koneksi, "SELECT * FROM petugas");

if (isset($_POST['simpan'])) {

    $id_peminjam = $_POST['id_peminjam'];
    $id_buku     = $_POST['id_buku'];
    $id_petugas  = $_POST['id_petugas'];
    $tgl_pinjam  = $_POST['tgl_pinjam']; // format dari input: YYYY-MM-DD

    // ❗ VALIDASI WAJIB
    if ($tgl_pinjam == '') {
        die("Tanggal pinjam kosong");
    }

    // 🔥 HITUNG JATUH TEMPO (AMAN & PASTI BENAR)
    $datePinjam = new DateTime($tgl_pinjam);
    $datePinjam->modify('+7 days');
    $jatuh_tempo = $datePinjam->format('Y-m-d');

    mysqli_query($koneksi, "
        INSERT INTO transaksi_peminjaman 
        (ID_Peminjam, ID_Buku, ID_Petugas, Tanggal_Pinjam, Jatuh_Tempo, Status_Pinjam)
        VALUES 
        ('$id_peminjam', '$id_buku', '$id_petugas', '$tgl_pinjam', '$jatuh_tempo', 'Dipinjam')
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <h3 class="text-center mb-4 fw-bold text-primary">Tambah Transaksi Peminjaman</h3>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label>Peminjam</label>
                    <select name="id_peminjam" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php while ($p = mysqli_fetch_assoc($peminjam)) { ?>
                            <option value="<?= $p['ID_Peminjam'] ?>">
                                <?= $p['Nama_Peminjam'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php while ($b = mysqli_fetch_assoc($buku)) { ?>
                            <option value="<?= $b['ID_Buku'] ?>">
                                <?= $b['Judul'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Petugas</label>
                    <select name="id_petugas" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php while ($g = mysqli_fetch_assoc($petugas)) { ?>
                            <option value="<?= $g['ID_Petugas'] ?>">
                                <?= $g['Nama_Petugas'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" class="form-control" required>
                    <small class="text-muted">Jatuh tempo otomatis +7 hari</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button name="simpan" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <p class="text-center mt-4 text-muted">© Sistem Peminjaman Buku | by Sherly</p>
</div>

</body>
</html>

<?php
require_once "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi, "
    SELECT * FROM transaksi_peminjaman 
    WHERE ID_Transaksi = '$id'
");
$r = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $tgl_kembali = $_POST['tgl_kembali'];
    $status      = $_POST['status'];

    mysqli_query($koneksi, "
        UPDATE transaksi_peminjaman SET
        Tanggal_Pengembalian = '$tgl_kembali',
        Status_Pinjam = '$status'
        WHERE ID_Transaksi = '$id'
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<h3 class="mb-4 text-primary">Edit Transaksi</h3>

<div class="card shadow">
<div class="card-body">

<form method="POST">

    <div class="mb-3">
        <label>Tanggal Pengembalian</label>
        <input type="date" name="tgl_kembali" class="form-control"
               value="<?= $r['Tanggal_Pengembalian'] ?>">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Dipinjam"
                <?= $r['Status_Pinjam']=='Dipinjam'?'selected':'' ?>>
                Dipinjam
            </option>
            <option value="Dikembalikan"
                <?= $r['Status_Pinjam']=='Dikembalikan'?'selected':'' ?>>
                Dikembalikan
            </option>
        </select>
    </div>

    <button name="update" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>

</form>

</div>
</div>

</div>
</body>
</html>

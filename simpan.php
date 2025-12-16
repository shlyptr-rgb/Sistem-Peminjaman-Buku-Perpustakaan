<?php
require_once "../config/koneksi.php";

$nik = $_POST['nik'];
$tgl = $_POST['tgl'];

// ambil batas pinjam
$batas = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT Batas_Pinjam FROM peminjam WHERE NIK='$nik'")
)['Batas_Pinjam'];

$kembali = date('Y-m-d', strtotime("+$batas days", strtotime($tgl)));

mysqli_query($koneksi,"
INSERT INTO transaksi_peminjaman
(NIK, ID_Buku, ID_Petugas, Tanggal_Pinjam, Tanggal_Pengembalian, Status_Pinjam)
VALUES
('$nik','$_POST[buku]','$_POST[petugas]','$tgl','$kembali','Dipinjam')
");

header("location:index.php");

<?php
require_once "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "
    DELETE FROM transaksi_peminjaman 
    WHERE ID_Transaksi = '$id'
");

header("Location: index.php");
exit;

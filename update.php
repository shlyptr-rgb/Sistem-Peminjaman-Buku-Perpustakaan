<?php
require_once "../config/koneksi.php";

mysqli_query($koneksi,"
UPDATE transaksi_peminjaman
SET Status_Pinjam='$_POST[status]'
WHERE ID_Transaksi='$_POST[id]'
");

header("location:index.php");

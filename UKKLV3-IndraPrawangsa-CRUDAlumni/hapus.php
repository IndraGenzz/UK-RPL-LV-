<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus data
    mysqli_query($conn, "DELETE FROM alumni WHERE id_alumni = $id");

    // Menyusun ulang ID agar urut lagi dari 1
    mysqli_query($conn, "SET @num := 0");
    mysqli_query($conn, "UPDATE alumni SET id_alumni = @num := @num + 1 ORDER BY id_Alumni");
    
    // Reset auto increment agar lanjut dari ID terakhir
    mysqli_query($conn, "ALTER TABLE alumni AUTO_INCREMENT = 1");
}

// Kembali ke halaman utama
header("Location: index.php");
exit;
<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Tambah alumni</h2>
    <form method="POST">
        <input type="text" name="Nama_Lengkap" placeholder="Nama" required>
        <input type="number" name="Tahun_Lulus" placeholder="Tahun lulus" required>
        <input type="text" name="Jurusan" placeholder="jurusan" required>
        <input type="text" name="Pekerjaan_Saat_Ini" placeholder="Pekerjaan Saat Ini" required>
        <input type="number" name="Nomor_Telepon" placeholder="no telpon" required>
        <input type="text" name="Email" placeholder="email" required>
        <textarea name="Alamat" placeholder="Alamat" required></textarea>
        <button type="submit" name="submit">Simpan</button
        </form>

        <?php
if (isset($_POST['submit'])) {
    // Sanitasi input untuk keamanan
    $nama = mysqli_real_escape_string($conn, $_POST['Nama_Lengkap']);
    $tahun = mysqli_real_escape_string($conn, $_POST['Tahun_Lulus']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['Jurusan']);
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['Pekerjaan_Saat_Ini']);
    $telepon = mysqli_real_escape_string($conn, $_POST['Nomor_Telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);
    
    // Cek apakah email sudah ada
    $check_sql = "SELECT Email FROM alumni WHERE Email = '$email'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color: red;'>Error: Email '$email' sudah terdaftar! <a href='tambah.php'>Coba lagi</a></p>";
    } else {
        // Insert data jika email belum ada
        $sql = "INSERT INTO alumni (Nama_Lengkap, Tahun_Lulus, Jurusan, Pekerjaan_Saat_Ini, Nomor_Telepon, Email, Alamat)
                VALUES ('$nama', '$tahun', '$jurusan', '$pekerjaan', '$telepon', '$email', '$alamat')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>Data berhasil disimpan! <a href='index.php'>Kembali</a></p>";
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($conn) . " <a href='tambah.php'>Coba lagi</a></p>";
        }
    }
}
?>
</body>

</html>
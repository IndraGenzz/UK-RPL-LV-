<?php
include 'koneksi.php';
$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alumni WHERE Id_Alumni=$id"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Data Alumni</h2>
    <form method="POST">

    Nama Lengkap:
    <input type="text" name="Nama_Lengkap" value="<?= $row['Nama_Lengkap'] ?>" required>
    Tahun Lulus:
    <input type="number" name="Tahun_Lulus" value="<?= $row['Tahun_Lulus'] ?>" required>
    <select name="Jurusan" requaired>
        <option value="RPL" <?= $row['Jurusan'] == 'RPL' ? 'selected' : '' ?>>RPL</option>
        <option value="TKJ" <?= $row['Jurusan'] == 'TKJ' ? 'selected' : '' ?>>TKJ</option>
        <option value="TJAT" <?= $row['Jurusan'] == 'TJAT' ? 'selected' : '' ?>>TJAT</option>
        <option value="ANIMASI" <?= $row['Jurusan'] == 'ANIMASI' ? 'selected' : '' ?>>ANIMASI</option>
    </select>
    <label>Pekerjaan Saat Ini</label>
    <input type="text" name="Pekerjaan_Saat_Ini" value="<?= $row['Pekerjaan_Saat_Ini'] ?>" required>
        <label>Nomor Telepon</label>
        <input type="text" name="Nomor_Telepon" value="<?= $row['Nomor_Telepon'] ?>" required>
        <label>Email</label>
        <input type="email" name="Email" value="<?= $row['Email'] ?>" required>
        <label>Alamat</label>
        <textarea name="Alamat" required><?= $row['Alamat'] ?></textarea>
        <button type="submit" name="update">Update Data</button>
        <a href="index.php" style="margin-left: 10px;">Batal</a>
    </form>

<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM alumni WHERE Id_Alumni=$id"));

// Proses UPDATE ketika form disubmit
if (isset($_POST['update'])) {
    $id = $_GET['id']; // Ambil ID dari URL, bukan dari POST
    $email = $_POST['Email'];
    
    // Cek email duplikat (kecuali email sendiri)
    $check_stmt = $conn->prepare("SELECT Email FROM alumni WHERE Email = ? AND Id_Alumni != ?");
    $check_stmt->bind_param("si", $email, $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Error: Email sudah digunakan alumni lain!'); window.location.href='edit.php?id=$id';</script>";
    } else {
        // UPDATE dengan prepared statement
        $stmt = $conn->prepare("UPDATE alumni SET 
            Nama_Lengkap = ?, 
            Tahun_Lulus = ?, 
            Jurusan = ?, 
            Pekerjaan_Saat_Ini = ?, 
            Nomor_Telepon = ?, 
            Email = ?, 
            Alamat = ? 
            WHERE Id_Alumni = ?");
            
        $stmt->bind_param("sssssssi", 
            $_POST['Nama_Lengkap'], 
            $_POST['Tahun_Lulus'], 
            $_POST['Jurusan'], 
            $_POST['Pekerjaan_Saat_Ini'], 
            $_POST['Nomor_Telepon'], 
            $_POST['Email'], 
            $_POST['Alamat'],
            $id
        );
        
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil diupdate!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='edit.php?id=$id';</script>";
        }
        $stmt->close();
    }
    $check_stmt->close();
}
?>
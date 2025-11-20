<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Alumni</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Data Alumni Sekolah</h2>
    <a href="tambah.php" id="tambahdata">+ Tambah Data</a>

    <!-- FORM PENCARIAN -->
    <form method="GET" style="margin-bottom: 20px;">
        <input type="text" name="cari" placeholder="Cari Nama Lengkap / Tahun Lulus / Jurusan / Pekerjaan Saat Ini..."
            value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
        <button type="submit">Cari</button>
    </form>

    <table>
        <tr>
            <th>id_alumni</th>
            <th>Nama_Lengkap</th>
            <th>tahun_lulus</th>
            <th>Jurusan</th>
            <th>Pekerjaan_Saat_Ini</th>
            <th>Nomor_Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
            
        </tr>

        <?php
        // PENCARIAN
        if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
            $result = mysqli_query($conn, "SELECT * FROM alumni 
                WHERE Id_Alumni LIKE '%$cari%'
                OR Tahun_lulus LIKE '%$cari%' 
                OR Jurusan LIKE '%$cari%' 
                OR Nama_Lengkap LIKE '%$cari%' 
                OR Pekerjaan_Saat_Ini LIKE '%$cari%' ");
        } else {
            $result = mysqli_query($conn, "SELECT * FROM alumni");
        }

        // TAMPILKAN DATA
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['Id_Alumni']}</td>
                <td>{$row['Nama_Lengkap']}</td>
                <td>{$row['Tahun_Lulus']}</td>
                <td>{$row['Jurusan']}</td>
                <td>{$row['Pekerjaan_Saat_Ini']}</td>
                <td>{$row['Nomor_Telepon']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['Alamat']}</td>
                <td>
                    <a href='edit.php?id={$row['Id_Alumni']}'>Edit</a> |
                    <a href='hapus.php?id={$row['Id_Alumni']}' onclick=\"return confirm('Yakin ingin hapus?')\">Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>

</html>
<?php
include 'db.php';
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location = "login.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100&display=swap" rel="stylesheet">
    <title>Dashboard | TokoMusik</title>
</head>

<body>
    <!-- Kepala -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">TokoMusik</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </header>

    <!-- Konten -->
    <div class="section">
        <div class="container">
            <h3>Data Produk</h3>
            <div class="box">
                <div class="btn-tambah">
                    <p><a href="tambah-produk.php">Tambah Produk</a></p>
                </div>
                <table border="1" cellspacing="0" class="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
                        if (mysqli_num_rows($produk) > 0) {
                            while ($row = mysqli_fetch_array($produk)) {
                        ?>
                                <tr>
                                    <td width="50px"><?php echo $no++ ?></td>
                                    <td><?php echo $row['category_name'] ?></td>
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td>Rp <?php echo number_format($row['product_price'])  ?></td>
                                    <td><?php echo $row['product_description'] ?></td>
                                    <td> <a href="product/<?php echo $row['product_image'] ?>" target="_blank"> <img src="product/<?php echo $row['product_image'] ?>" width="50px"></a></td>
                                    <td><?php echo ($row['product_status'] == 0) ? 'Tidak Aktif' : 'Aktif';  ?></td>
                                    <td width="140px">
                                        <a href="edit-produk.php?id=<?php echo $row['product_id'] ?> " class="btn-edit">Edit</a> ||
                                        <a href="hapus.php?idp=<?php echo $row['product_id'] ?>" class="btn-hapus" onclick="return confirm('Apakah data ingin di HAPUS ???')">Hapus</a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="8">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Kaki -->
    <footer>
        <div class="container">
            <small>Copyright &copy; YTTA :)</small>
        </div>
    </footer>
</body>

</html>
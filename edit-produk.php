<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location = "login.php"</script>';
}
$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '" . $_GET['id'] . "' ");
$p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
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
            <h3>Edit Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="kategori" class="input-control" required>
                        <option value="">--Pilih--</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                            <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : '' ?>>
                                <?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="nama" placeholder="Nama Produk" class="input-control" value="<?php echo $p->product_name ?>" required>
                    <input type="text" name="harga" placeholder="Harga" class="input-control" value="<?php echo $p->product_price ?>" required>
                    <img src="product/<?php echo $p->product_image ?>" width="100px"><br>
                    <input type="hidden" name="foto" value="<?php echo $p->product_image ?>">
                    <input type="file" name="gambar" style="padding-bottom: 10px;">
                    <textarea name="deskripsi" class="input-control" placeholder="Deskripsi" value="<?php echo $p->product_description ?>"></textarea><br>
                    <select name="status" class="input-control">
                        <option value=""> --Pilih-- </option>
                        <option value="1" <?php echo ($p->product_status == 1) ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?php echo ($p->product_status == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    // menampung data dari form 
                    $kategori   = $_POST['kategori'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];
                    $foto    = $_POST['foto'];
                    // menampung data gambar terbaru
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    // jika admin mengganti gambar
                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'produk' . time() . '.' . $type2;

                    // menampung format file yang diizinkan
                    $type_diizinkan = array('jpg', 'jpeg', 'png', 'jfif', 'gif');

                    // validasi format file
                    if ($filename != '') {
                        if (!in_array($type2, $type_diizinkan)) {

                            // jika tidak sesuai array diizinkan
                            echo '<script>alert("Format file tidak diizikan!")</script>';
                        } else {
                            unlink('./product/' . $foto);
                            move_uploaded_file($tmp_name, './product/' . $newname);
                            $namagambar = $newname;
                        }
                    } else {
                        // jika admin tidak mengganti gambar
                        $namagambar = $foto;
                    }
                    // query update data product
                    $update = mysqli_query($conn, "UPDATE tb_product SET 
                                                    category_id = '" . $kategori . "',
                                                    product_name = '" . $nama . "',
                                                    product_price = '" . $harga . "',
                                                    product_description = '" . $deskripsi . "',
                                                    product_image = '" . $namagambar . "',
                                                    product_status = '" . $status . "'
                                                    WHERE product_id = '" . $p->product_id . "' ");
                    if ($update) {
                        echo '<script>alert("Ubah data  produk berhasil")</script>';
                        echo '<script>window.location ="data-produk.php"</script';
                    } else {
                        echo 'gagal' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Kaki -->
    <footer>
        <div class="container">
            <small>Copyright &copy; YTTA :)</small>
        </div>
    </footer>
    <script>
        CKEDITOR.replace('deskripsi');
    </script>
</body>
<!-- note: deskripsi blom muncul -->

</html>
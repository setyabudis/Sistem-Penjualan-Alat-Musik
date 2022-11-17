<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location = "login.php"</script>';
}
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '" . $_SESSION['id'] . "' ");
$d = mysqli_fetch_object($query);
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
            <h3>Tambah Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="kategori" class="input-control" required>
                        <option value="">--Pilih--</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                            <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="nama" placeholder="Nama Produk" class="input-control" required>
                    <input type="text" name="harga" placeholder="Harga" class="input-control" required>
                    <input type="file" name="gambar" style="padding-bottom: 10px;" required>
                    <textarea name="deskripsi" class="input-control" placeholder="Deskripsi"></textarea><br>
                    <select name="status" class="input-control">
                        <option value="">--Pilih--</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    // menampung inputan dari form
                    $kategori   = $_POST['kategori'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];
                    // menampung file data upload
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'produk' . time() . '.' . $type2;

                    // menampung format file yang diizinkan
                    $type_diizinkan = array('jpg', 'jpeg', 'png', 'jfif', 'gif');

                    // validasi format file yang di upload
                    if (!in_array($type2, $type_diizinkan)) {

                        // jika tidak sesuai array diizinkan
                        echo '<script>alert("Format file tidak diizikan!")</script>';
                    } else {

                        // jika format file sesuai array diizinkan
                        // proses upload ke web dan database
                        move_uploaded_file($tmp_name, './product/' . $newname);

                        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES(
                            null,
                            '" . $kategori . "',
                            '" . $nama . "',
                            '" . $harga . "',
                            '" . $deskripsi . "',
                            '" . $newname . "',
                            '" . $status . "',
                            null
                        ) ");
                        if ($insert) {
                            echo '<script>alert("Tambah produk berhasil")</script>';
                            echo '<script>window.location ="data-produk.php"</script';
                        } else {
                            echo 'gagal' . mysqli_error($conn);
                        }
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

</html>
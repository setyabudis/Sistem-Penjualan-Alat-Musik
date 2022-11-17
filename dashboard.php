<?php
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
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat datang <?php echo $_SESSION['a_global']->admin_name ?> di Dashboard TokoMusik</h4>
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
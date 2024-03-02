<?php
include "koneksi.php";
session_start();
$userid = $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}
?>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Home</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
    <?php
    $page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama halaman saat ini
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">website gallery foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <?php if (!isset($_SESSION['userid'])) { ?>
                        <a href="register.php" class="btn btn-outline-primary m-1">Register</a>
                        <a href="login.php" class="btn btn-outline-primary m-1">Login</a>
                    <?php } else { ?>
                        <a class="nav-link <?= ($page == 'dashboard.php') ? 'active' : '' ?>" aria-current="page" href="dashboard.php">Dashboard</a>
                        <a class="nav-link <?= ($page == 'home.php') ? 'active' : '' ?>" aria-current="page" href="home.php">Home</a>
                        <a class="nav-link <?= ($page == 'album.php') ? 'active' : '' ?>" href="album.php">Album</a>
                        <a class="nav-link <?= ($page == 'foto.php') ? 'active' : '' ?>" href="foto.php">Foto</a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <!-- Form Pencarian -->
        <form action="home.php" method="GET" class="mt-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari foto..." name="search" autocomplete="off">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <div class="row">
            <?php
            // Memeriksa apakah ada parameter pencarian yang dikirimkan
            if (isset($_GET['search'])) {
                // Jika ada, simpan kata kunci pencarian dalam variabel $search
                $search = $_GET['search'];
                // Modifikasi query untuk mencari foto berdasarkan judul foto yang mengandung kata kunci pencarian
                $sql = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid WHERE foto.userid='$userid' AND judulfoto LIKE '%$search%'");
            } else {
                // Jika tidak ada parameter pencarian, tampilkan semua foto yang diunggah oleh user tersebut
                $sql = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid WHERE foto.userid='$userid'");
            }

            // Menampilkan hasil query
            while ($data = mysqli_fetch_array($sql)) {
                // Tampilkan daftar foto sesuai dengan query yang dieksekusi
            ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 12rem;" alt="">
                        <div class="card-footer">
                            <div>
                                <p style="font-size: 25px;"><b><?php echo $data['judulfoto'] ?></b></p>
                            </div>
                            <div>
                                Lihat secara <a href="#" type="" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="" style="margin-left: px;">Detail</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="m-2">
                                                <div class="overflow-auto">
                                                    <div>
                                                        <p style="font-size: 25px;"><b><?php echo $data['judulfoto'] ?></b></p>
                                                        <p>Pengunggah Gambar : <span><?php echo $data['namalengkap'] ?></span></p>
                                                        <p>Tanggal Unggah : <span><?php echo $data['tanggalunggah'] ?></span></p>
                                                        <p>Nama Album : <span><?php echo $data['namaalbum'] ?></span>
                                                    </div>
                                                    <p align="left">
                                                        <strong>Komentar</strong><br>
                                                    </p>
                                                    <hr>
                                                    <?php
                                                    $fotoid = $data['fotoid'];
                                                    $komentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                                                    while ($row = mysqli_fetch_array($komentar)) {
                                                    ?>
                                                        <p align="left">
                                                            <strong><?= $row['namalengkap'] ?></strong> :
                                                            <?= $row['isikomentar'] ?>
                                                        </p>
                                                    <?php } ?>
                                                    <hr>
                                                    <div class="sticky-bottom">
                                                        <form action="tambah_komentar.php" method="post">
                                                            <input type="text" name="fotoid" value="<?= $data['fotoid'] ?>" hidden>
                                                            <input type="text" name="isikomentar" class="form-control" placeholder="tambah komentar">
                                                            <div class="input-group">
                                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>


    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>UKK 2024</p>
    </footer>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

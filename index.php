<?php
include "koneksi.php";
session_start();
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
?>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Landing</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index1.php">website gallery foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">

                    <a href="register.php" class="btn btn-outline-primary m-1">Register</a>
                    <a href="login.php" class="btn btn-outline-primary m-1">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <!-- Album:
    <?php
    // Hapus pengecekan session $_SESSION['userid']
    $album = mysqli_query($conn, "select * from album");
    while ($row = mysqli_fetch_array($album)) { ?>
        <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="btn btn-outline-primary"><?php echo $row['namaalbum'] ?></a>
    <?php } ?> -->

        <br>
        <div class="row">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid");
            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <div class="col-md-3">
                    <!-- <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"> -->
                    <div class="card">
                        <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 12rem;" alt="">
                        <div class="card-footer">
                            <!-- <?php
                                    $fotoid = $data['fotoid'];
                                    $ceksuka = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");
                                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }
                                    $like = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
                                    echo mysqli_num_rows($like) . ' Suka';
                                ?> -->
                            <!-- <?php
                                    $jmlkomentar = mysqli_query($conn, "select * from komentarfoto where fotoid='$fotoid'");
                                    echo mysqli_num_rows($jmlkomentar) . ' Komentar';
                                    ?> -->

                            <div>
                                <p style="font-size: 25px;"><b><?php echo $data['judulfoto'] ?></b></p>
                            </div>
                            <div>
                                Lihat secara <a href="#" type="" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="" style="margin-left: px;">Detail</i></a>
                            </div>
                        </div>
                    </div>
                    </a>

                    <!-- modal komentar -->
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
                                                        <!-- <form action="tambah_komentar.php" method="post">
                                                            <input type="text" name="fotoid" value="<?= $data['fotoid'] ?>" hidden>
                                                            <input type="text" name="isikomentar" class="form-control" placeholder="tambah komentar">
                                                            <div class="input-group">
                                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                                            </div>
                                                        </form> -->
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
<?php
include "inc/config.php";
include "layout/header.php";
$loop_index = 0; // Initialize loop index before the loop

?>
<?php if (!empty($_GET['id'])) { ?>

    <?php
    extract($_GET);
    $k = mysqli_query($konek, "SELECT * FROM produk WHERE id='$id'");
    $data = mysqli_fetch_array($k);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div class="col-md-9">
            <font color="black">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-color-heading">Detail : <?php echo $data['nama'] ?></h3>
                        <br />
                        <div class="col-md-10 content-menu" style="margin-top:-20px;">
                            <?php $kat = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM kategori_produk WHERE id='$data[kategori_produk_id]'")); ?>
                            <middle>Kategori :<a href="<?php echo $url; ?>menu.php?kategori=<?php echo $kat['id'] ?>"><?php echo $kat['nama'] ?></a></middle>
                            <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>">
                                <img src="<?php echo $url; ?>uploads/<?php echo $data['gambar'] ?>" width="100%">
                            </a>
                            <br><br>
                            <p><?php echo $data['deskripsi'] ?></p>
                            <p style="font-size:18px">Harga : <strong>Rp
                                    <?php echo number_format($data['harga'], 0, ',', '.') ?></strong> </p>
                            <p>
                                <a href="<?php echo $url; ?>keranjang.php?act=beli&&produk_id=<?php echo $data['id'] ?>" class="btn btn-warning" href="#" role="button">Pesan</a>
                            </p>
                        </div>
                    </div>
                </div>
        </div>

    <?php } elseif (!empty($_GET['kategori'])) { ?>

        <?php
        extract($_GET);
        $kat = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM kategori_produk WHERE id='$kategori'"));
        ?>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <font color="black">
                        <h3 class="text-color-heading" align="center">Kategori : <strong> <?php echo $kat['nama'] ?>
                            </strong> </h3>
                        <?php
                        $k = mysqli_query($konek, "SELECT * FROM produk WHERE kategori_produk_id='$kategori'");
                        while ($data = mysqli_fetch_array($k)) {
                        ?>
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>">
                                            <img src="<?php echo $url; ?>uploads/<?php echo $data['gambar'] ?>" width="100%">
                                            <h4><?php echo $data['nama'] ?></h4>
                                        </a>
                                        <p style="font-size:18px">Harga : <strong> Rp
                                                <?php echo number_format($data['harga'], 0, ',', '.') ?> </strong> </p>
                                        <p>
                                            <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm" href="#" role="button">Lihat Detail</a>
                                            <a href="<?php echo $url; ?>keranjang.php?act=beli&&produk_id=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm" href="#" role="button">Pesan</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php if ($loop_index % 3 == 2) { ?>
                                <div class="clearfix"></div>
                            <?php } ?>
                        <?php 
                        $loop_index++;
                        } ?>
                </div>
            </div>
        </div>

    <?php } else { ?>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-14">
                    <h2 align="center">
                        <font class="text-color-heading"> <b>Daftar Semua Menu</b></font>
                    </h2>
                    <br>
                    <?php
                    $k = mysqli_query($konek, "SELECT * FROM produk");
                    $loop_index = 0; // Initialize a loop index
                    while ($data = mysqli_fetch_array($k)) {
                    ?>
                        <div class="col-sm-4">
                            <font color="black">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>">
                                            <img src="<?php echo $url; ?>uploads/<?php echo $data['gambar'] ?>" width="100%">
                                            <h4><?php echo $data['nama'] ?></h4>
                                        </a>
                                        <p style="font-size:18px">Harga : <strong>Rp
                                                <?php echo number_format($data['harga'], 0, ',', '.') ?></strong> </p>
                                        <p>
                                            <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm" href="#" role="button">Lihat Detail</a>
                                            <a href="<?php echo $url; ?>keranjang.php?act=beli&&produk_id=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm" href="#" role="button">Pesan</a>
                                        </p>
                                    </div>
                                </div>
                            </font>
                        </div>
                        <?php if ($loop_index % 3 == 2) { ?>
                            <div class="clearfix"></div>
                        <?php } ?>
                    <?php 
                    $loop_index++;
                    } ?>
                </div>
            </div>
        </div>
    </body>
    </html>

<?php } ?>
<?php include "layout/footer.php"; ?>

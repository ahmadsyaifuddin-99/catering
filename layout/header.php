<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title><?php echo $title; ?></title>

    <link href="<?php echo $url ?>assets/bootstrap/css/bootstrap_old.min.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/bootstrap/css/datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="<?php echo $url ?>assets/css/navbar-fixed-top.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/css/full-slider.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Helvetica', arial, sans-serif;
            font-size: 15px;
        }
        .navbar .user-icon {
            float: right;
            margin-right: 5px;
        }
        @media (max-width: 767px) {
            .navbar .user-icon {
                margin-right: 0;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top navbar-orange">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Asai's 🍴🍝</a>
                <ul class="nav navbar-nav navbar-right user-icon">
                    <?php if (!empty($_SESSION['iam_user'])) { 
                        $user = mysqli_fetch_object(mysqli_query($konek, "SELECT*FROM user where id='$_SESSION[iam_user]'"));
                    ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> Hi <?php echo $user->username; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $url ?>profile.php"> <i class="fa-solid fa-address-card"></i> Profile</a></li>
                                <li><a href="<?php echo $url ?>logout.php"> <i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $url ?>login.php"> <i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
                                <li><a href="<?php echo $url ?>register.php"> <i class="fa-solid fa-user-plus"></i> Register</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                
            </div>

            

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo $url ?>"> <i class="fa-solid fa-house"></i> Home</a></li>
                    <li><a href="<?php echo $url ?>menu.php"> <i class="fa-solid fa-cart-plus"></i> Menu Makanan & Minuman</a></li>
                    <li><a href="<?php echo $url ?>kontak.php"> <i class="fa-solid fa-message"></i> Kontak Kami</a></li>
                    <li><a href="<?php echo $url ?>info.php"> <i class="fa-solid fa-circle-info"></i> Info Pembayaran</a></li>
                    <?php if (!empty($_SESSION['iam_user'])) { ?>
                        <li><a href="<?php echo $url ?>pembayaran.php"> <i class="fa-regular fa-money-bill-1"></i> Pembayaran</a></li>
                    <?php } ?>
                </ul>
                
                

            </div>

            

        </div>
    </nav>

    <?php if ('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] == $url . 'index.php') { ?>
        <div class="container">

            <!-- Full Page Image Background Carousel Header -->
            <header id="myCarousel" class="carousel slide">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                    <li data-target="#myCarousel" data-slide-to="5"></li>
                    <li data-target="#myCarousel" data-slide-to="6"></li>
                </ol>

                <!-- Wrapper for Slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <!-- Set the first background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/gb1.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/cat1.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/Ikan Bakar.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/ayam bakar.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/cat7.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/ayam-chicken.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                    <div class="item">
                        <!-- Set the second background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?php $url ?>assets/img/Jus Buah.jpg');"></div>
                        <div class="carousel-caption">
                            <!-- <h2>AS</h2> -->
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="icon-prev"></span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="icon-next"></span>
                </a>

            </header>
        </div> <!-- /container -->
    <?php } ?>

    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-3">
                <img class="img-center" src="<?php echo $url . 'assets/img/logo2.png'; ?>" width="200" height="200">
                <br>
                <div class="warna-head-bg" style="width:100%; height:auto; padding-top: 1px; padding-bottom:1px; padding-left:10px;">
                    <h4>
                        <font color="white">Kategori Menu <i class="fa-solid fa-utensils"></i>
                    </h4>
                </div>
                <ul class="kategori-menu">
                    <?php
                    $kategori = mysqli_query($konek, "SELECT * FROM kategori_produk");
                    while ($data = mysqli_fetch_array($kategori)) {
                    ?>
                        <li><a href="<?php echo $url; ?>menu.php?kategori=<?php echo $data['id'] ?>"><?php echo $data['nama']; ?>
                                <i class="fa-solid fa-tag fa-shake fa-lg"></i> (
                                <?php
                                $ck = mysqli_num_rows(mysqli_query($konek, "SELECT * FROM produk WHERE kategori_produk_id='$data[id]'"));
                                if ($ck > 0) {
                                    echo $ck;
                                } else {
                                    echo 0;
                                } ?>
                                )</a></li>
                    <?php } ?>
                </ul>

                <div class="warna-head-bg" style="width:100%; height:auto; padding-top:1px; padding-bottom:1px; padding-left:10px; ">
                    <h4>
                        <font color="white">Keranjang Belanja <i class="fa-solid fa-basket-shopping"></i>
                    </h4>
                </div>
                <div class="warna-jumlah" style=" width:100%; height:auto; padding-top:3px;padding-bottom:3px; padding-left:10px; margin-bottom:15px; border: 1px dashed #fff;">

                    <?php
                    if (isset($_SESSION['cart'])) {
                        $total = 0;
                        $cart = unserialize($_SESSION['cart']);
                        if ($cart == '') {
                            $cart = [];
                        }
                        foreach ($cart as $id => $qty) {
                            $product = mysqli_fetch_array(mysqli_query($konek, "select * from produk WHERE id='$id'"));
                            if (isset($product)) {
                                $t = $qty * $product['harga'];
                                $total += $t;
                            }
                        }
                        echo '<h4 style="color:#f00;">Rp. ' . number_format($total, 0, ',', '.') . '</h4>';
                    } else {
                        echo '<h4 style="color:#f00;">Rp. 0</h4>';
                    }

                    ?>
                    <div class="keranjang">
                        <a href="<?php echo $url; ?>keranjang.php">Lihat Keranjang Belanja <i class="fa-solid fa-basket-shopping"></i> </a>
                    </div>
                </div>

            </div>

</body>
<?php
include "inc/config.php";
include "layout/header.php";

if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = '';
}
if (!empty($_GET['produk_id']) && $_GET['act'] == 'beli') {
    $cart = unserialize($_SESSION['cart']);
    if ($cart == '') {
        $cart = [];
    }
    $pid = $_GET['produk_id'];
    $qty = 1;

    if (isset($_GET['update_cart'])) {
        if (isset($cart[$pid]))
            if ($_GET['qty'] >= 1)
                $cart[$pid] = $_GET['qty'];
            else
                alert('Minimal Quantity 1');
        redir('keranjang.php');
    } elseif (isset($_GET['delete_cart'])) {
        if (isset($cart[$pid])) {
            unset($cart[$pid]);
        }
        //$arr = unserialize($str);


        //}else{

        //redir($url.'keranjang.php');
        //}
        // foreach($cart as $key => $value){
        // if ($cart[$key] == $_GET['delete_cart']) 
        // unset($cart[$key]);
        // }
        // $cart = serialize($cart);
    } else {

        if (isset($cart[$pid]))
            $cart[$pid] += $qty;
        else
            $cart[$pid] = $qty;
    }
    $_SESSION['cart'] = serialize($cart);
    redir($url . 'keranjang.php');
}
//unset($_SESSION['cart']);
//print_r($_SESSION['cart']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    @media (max-width: 480px) {
            .form-control {
                font-size: 16px;
                padding: 10px;
            }
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .table th {
            font-weight: bold;
            background: #c3ebf8;
        }

        .CartProductThumb img {
            max-width: 100%;
            height: auto;
        }

        .CartDescription h3 a {
            font-size: 1.4rem;
            color: #000;
        }

        .CartDescription .price {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <font color="black">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-color-heading">Keranjang anda </h2>
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr style="background:#c3ebf8;font-weight:bold;">
                                <td style="width:15%"> Produk </td>
                                <td style="width:15%">Details</td>
                                <td style="width:20%">QTY</td>
                                <td style="width:12%">Total</td>
                                <td style="width:1%" class="delete">Hapus</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $cart = unserialize($_SESSION['cart']);
                            if ($cart == '') {
                                $cart = [];
                            }
                            foreach ($cart as $id => $qty) {
                                $product = mysqli_fetch_array(mysqli_query($konek, "select * from produk WHERE id='$id'"));
                                if (!empty($product)) {
                                    $t = $qty * $product['harga'];
                                    $total += $t;
                            ?>
                                    <tr class="barang-shop">
                                        <td class="CartProductThumb">
                                            <div> <a href="<?php echo $url; ?>menu.php?id=<?php echo $product['id'] ?>"><img src="<?php echo $url . 'uploads/' . $product['gambar']; ?>" alt="img" width="120px"></a> </div>
                                        </td>
                                        <td>
                                            <div class="CartDescription">
                                                <h3 style="font-weight:bold;"> <a style="font-size: 1.5rem;" href="<?php echo $url; ?>menu.php?id=<?php echo $product['id'] ?>"><?= $product['nama'] ?></a>
                                                </h3>
                                                <!-- 1.Harga Satuan -->
                                                <div class="price" style="font-size: 1.6rem;">
                                                    <?php echo "<b> Rp  " . number_format($product['harga'], 0, ',', '.') ?>
                                                    </b>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <form action="<?php echo $url; ?>keranjang.php" method="GET">
                                                <input type="hidden" name="update_cart" value="update">
                                                <input type="hidden" name="act" value="beli">
                                                <input type="hidden" name="produk_id" value="<?= $id ?>">
                                                <input class="form-control" type="number" name="qty" value="<?php echo $qty; ?>" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <!-- 2.Harga (Satuan * Jumlah) -->
                                        <td style="font-weight:bold; font-size: 1.6rem;" class="price">
                                            <?php echo number_format($t, 0, ',', '.') ?>
                                        </td>
                                        <td><a href="<?php echo $url; ?>keranjang.php?delete_cart=yes&&act=beli&&produk_id=<?php echo $id; ?>" title="Delete"> <i class="glyphicon glyphicon-trash fa-2x"></i></a></td>
                                    </tr>
                            <?php }
                            } ?>
                            <tr style="background:#c3ebf8;font-weight:bold;">
                                <td colspan="3">SUB TOTAL</td>
                                <!-- 3.Harga SUB TOTAL -->
                                <td style="font-size: 1.7rem;"><?php echo number_format($total, 0, ',', '.') ?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div style="float:right;" class="col-sm-6 col-md-6">
                    <h4><b>Total Keranjang Belanja</b></h4>
                    <table class="table table-bordered">

                        <tr>
                            <td style="background:#fafafa;"><b>TOTAL</b></td>
                            <!-- 4.HARGA ALL TOTAL -->
                            <td style="font-size: 2rem"> <?php echo "<b> Rp " . number_format($total, 0, ',', '.') ?>
                                </b> </td>
                        </tr>
                    </table>
                    <form action="<?php echo  $url . 'order.php' ?>" method="POST">
                        <input type="hidden" name="okay" value="cart">
                        <button <?php echo ($total == 0) ? 'disabled' : '' ?> type="submit" class="btn btn-primary">Selesai
                            Belanja ✓</button>
                    </form>
                </div>

            </div>
        </div>
</body>

</html>

<?php include "layout/footer.php"; ?>
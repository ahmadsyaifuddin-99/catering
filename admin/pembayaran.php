<?php
include "../inc/config.php";
// Check if the admin is not logged in, redirect to login page
if (empty($_SESSION['iam_admin'])) {
    redir("index.php");
    exit; // Stop further execution if the user is not logged in
}

if (!empty($_GET)) {
    if ($_GET['act'] == 'delete') {

        $q = mysqli_query($konek, "delete from pembayaran WHERE id='$_GET[id]'");
        if ($q) {
            alert("Success");
            redir("pembayaran.php");
        }
    }
}


include "inc/header.php";

?>
<div class="container">
    <?php
    $q = mysqli_query($konek, "select*from pembayaran order by status asc");
    $j = mysqli_num_rows($q);
    ?>
    <!--a class="btn btn-sm btn-primary" href="pesanan.php?act=create">Add Data</a-->
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($_GET)) {
                if ($_GET['act'] == "info") {
                    $qInfo = mysqli_query($konek, "Select * from info_pembayaran limit 1") or die(mysqli_error());
                    $dInfo = mysqli_fetch_object($qInfo);
                    if (!empty($_POST)) {
                        extract($_POST);
                        $query = mysqli_query($konek, "Update info_pembayaran set info='$info' where id='1'") or die(mysqli_error());
                        if ($query) {
                            alert('Info Pembayaran Berhasil Diupdate');
                            redir('pembayaran.php');
                        }
                    }
            ?>
            <div class="col-md-6">
                <div class="row">
                    <h3>Info Pembayaran</h3>
                    <form action="" method="POST">
                        <textarea class="form-control" name="info"><?php echo $dInfo->info; ?></textarea>
                        <div class="form-group">
                            <br>
                            <input type="submit" name="submit" value="Submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
            <hr />
            <?php
                }
                if ($_GET['act'] == "verified") {
                    extract($_GET);
                    $updatePembayaran = mysqli_query($konek, "update pembayaran set status = 'verified' where id='$_GET[id]'");
                    if ($updatePembayaran) {
                        $qPembayaran = mysqli_query($konek, "Select * from pembayaran where id_pesanan='$id_pesanan' and status='verified'") or die(mysqli_error());
                        $totalPembayaran = 0;
                        while ($d = mysqli_fetch_object($qPembayaran)) {
                            $totalPembayaran += $d->total;
                        }
                        $q1 = mysqli_query($konek, "select*from detail_pesanan where pesanan_id='$id_pesanan'");
                        $totalBayar = 0;
                        while ($data2 = mysqli_fetch_object($q1)) {
                            $katpro1 = mysqli_query($konek, "select*from produk where id='$data2->produk_id'");
                            $a = mysqli_fetch_object($katpro1);
                            $totalBayar += ($a->harga * $data2->qty);
                        }

                        $q3 = mysqli_query($konek, "select*from pesanan where id='$id_pesanan'") or die(mysqli_error());
                        $pesanan = mysqli_fetch_object($q3);

                        $totalBayar += $pesanan->ongkir;
                        if ($totalBayar <= $totalPembayaran) {
                            $updatePesanan = mysqli_query($konek, "update pesanan set status='lunas' where id='$id_pesanan'") or die(mysqli_error());
                            if ($updatePesanan) {
                                alert("Pembayaran Lunas");
                            }
                        }
                        alert("Pembayaran Telah Di Verifikasi");
                        redir('pembayaran.php');
                    }
                }
                if ($_GET['act'] == "detail") {
                    $dataPembayaran = mysqli_fetch_object(mysqli_query($konek, "Select * from pembayaran where id=$_GET[id]"));
                    $dataPesanan = mysqli_fetch_object(mysqli_query($konek, "Select*from pesanan where id='$dataPembayaran->id_pesanan'"))
                ?>
            <div class="col-md-6">
                <h3> Detail Pembayaran</h3>

                <div class="table-responsive">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nama</td>
                                <td><?php echo $dataPesanan->nama; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td><?php echo "Rp. " . number_format($dataPembayaran->total); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td> <?php echo $dataPembayaran->keterangan; ?></td>
                            </tr>
                            <tr>
                                <td>Bukti Transaksi</td>
                                <td><a href="../uploads/<?php echo $dataPembayaran->file; ?>" target="_newtab">Bukti
                                        Transaksi</a></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php
                                            if ($dataPembayaran->status == "pending") {
                                            ?>
                                    <a href="pembayaran.php?act=verified&id=<?php echo $dataPembayaran->id; ?>&id_pesanan=<?php echo $dataPembayaran->id_pesanan; ?>"
                                        class="btn btn-sm btn-success">Verified <i
                                            class="fa-regular fa-circle-check fa-bounce fa-lg"></i> </a>
                                    <?php
                                            }
                                            ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <link rel="stylesheet" href="../assets/css/border.css">
    <h4>Daftar pembayaran Masuk (<?php echo ($j > 0) ? $j : 0; ?>)</h4>
    <a href="pembayaran.php?act=info" class="btn btn-info"> <i class="fa-solid fa-circle-info"></i> Info </a>
    <hr>
    <div class="table-responsive">


        <table class="table">
            <thead style="background:#00b4d8">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_object($q)) { ?>
                <tr <?php
                        if ($data->status == "pending") {
                            echo 'style="background:#DF826C !important;"';
                        } elseif ($data->status == "verified") {
                            echo 'style="background:#9ADE7B !important;"';
                        }
                        ?>>
                    <th scope="row"><?php echo $no++; ?></th>
                    <?php
                        $katpro = mysqli_query($konek, "select*from user where id='$data->id_user'");
                        $user = mysqli_fetch_array($katpro);
                        ?>
                    <td><?php echo $user['nama'] ?></td>
                    <td><?php echo 'Rp. ' . number_format($data->total, 0, ',', '.') ?></td>
                    <td><?php echo $data->status ?></td>
                    <td>
                        <a class="btn btn-sm btn-info" href="pembayaran.php?act=detail&id=<?php echo $data->id ?>">Cek
                            <i class="fa-solid fa-circle-info"></i> </a>
                        <a class="btn btn-sm btn-success"
                            href="detail_pesanan.php?id=<?php echo $data->id_pesanan ?>">Pesanan <i
                                class="fa-solid fa-comment-dots"></i> </a>
                        <a class="btn btn-sm btn-danger"
                            href="pembayaran.php?act=delete&&id=<?php echo $data->id ?>">Delete
                            <i class="fa-solid fa-trash"></i> </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
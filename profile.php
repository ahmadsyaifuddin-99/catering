<?php
include "inc/config.php";

if (empty($_SESSION['iam_user'])) {
    redir("index.php");
}
$user = mysqli_fetch_object(mysqli_query($konek, "SELECT*FROM user WHERE id='$_SESSION[iam_user]'"));

include "layout/header.php";

$q = mysqli_query($konek, "select*from pesanan where user_id='$_SESSION[iam_user]'");
$j = mysqli_num_rows($q);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile User</title>
</head>

<body>

    <font color="black">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12 content-menu">
                    <h3>Profile : <?php echo $user->nama; ?></h3>
                    <br>
                    <div class="col-md-6" style="margin-top:-20px;">
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?php echo $user->nama; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $user->email; ?></td>
                            </tr>
                            <tr>
                                <td>Telephone</td>
                                <td>:</td>
                                <td><?php echo $user->telephone; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?php echo $user->alamat; ?></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>:</td>
                                <td>--- *** --</td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-md-12 content-menu">
                        <h3>Riwayat Pemesanan </h3>
                        <br>
                        <table class="table table-bordered table-striped table-hove">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pemesan</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Tanggal Digunakan</th>
                                    <th>Telephone</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = mysqli_fetch_object($q)) { ?>
                                    <tr <?php if ($data->read == 0) {
                                            echo 'style="background:#cce9f8 !important;"';
                                        } ?>>
                                        <th scope="row"><?php echo $no++; ?></th>
                                        <?php
                                        $katpro = mysqli_query($konek, "select*from user where id='$data->user_id'");
                                        $user = mysqli_fetch_array($katpro);
                                        ?>
                                        <td><?php echo $data->nama ?></td>
                                        <td><?php echo substr($data->tanggal_pesan, 0, 10) ?></td>
                                        <td><?php echo $data->tanggal_digunakan ?></td>
                                        <td><?php echo $data->telephone ?></td>
                                        <td><?php echo $data->alamat ?></td>
                                        <!--td>  
						<a class="btn btn-sm btn-danger" href="pesanan.php?act=delete&&id=<?php echo $data->id ?>">Batalkan</a>
					</td-->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>



                </div>
            </div>
        </div>

</body>

</html>

<?php include "layout/footer.php"; ?>
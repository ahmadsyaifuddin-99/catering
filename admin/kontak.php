<?php
include "../inc/config.php";
// Check if the admin is not logged in, redirect to login page
if (empty($_SESSION['iam_admin'])) {
    redir("index.php");
    exit; // Stop further execution if the user is not logged in
}


if (!empty($_GET)) {
	if ($_GET['act'] == 'delete') {

		$q = mysqli_query($konek, "delete from kontak WHERE id='$_GET[id]'");
		if ($q) {
			alert("Success");
			redir("kontak.php");
		}
	}
}
if (!empty($_GET['act']) && $_GET['act'] == 'create') {
	if (!empty($_POST)) {
		extract($_POST);

		$q = mysqli_query($konek, "insert into kontak Values(NULL,'$nama','$email','$subjek','$pesan')");
		if ($q) {
			alert("Success");
			redir("kontak.php");
		}
	}
}
if (!empty($_GET['act']) && $_GET['act'] == 'edit') {
	if (!empty($_POST)) {
		extract($_POST);

		$q = mysqli_query($konek, "update kontak SET nama='$nama',email='$email',subjek='$subjek',pesan='$pesan' where id=$_GET[id]") or die(mysqli_error());
		if ($q) {
			alert("Success");
			redir("kontak.php");
		}
	}
}


include "inc/header.php";

?>
<link rel="stylesheet" href="../assets/css/border.css">

<div class="container">
    <?php
	$q = mysqli_query($konek, "select*from kontak");
	$j = mysqli_num_rows($q);
	?>
    <h4>Daftar Kontak Masuk (<?php echo ($j > 0) ? $j : 0; ?>)</h4>
    <a class="btn btn-sm btn-primary" href="kontak.php?act=create">Add Data <i class="fa-solid fa-user-plus"></i> </a>
    <hr>
    <?php
	if (!empty($_GET)) {
		if ($_GET['act'] == 'create') {
	?>
    <div class="row col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
            <label>Nama</label><br>
            <input type="text" class="form-control" name="nama" required><br>
            <label>Email</label><br>
            <input type="email" class="form-control" name="email" required><br>
            <label>Subjek</label><br>
            <input type="text" class="form-control" name="subjek" required><br>
            <label>Pesan</label><br>
            <textarea class="form-control" name="pesan" required></textarea><br>
            <input type="submit" name="form-input" value="Simpan" class="btn btn-success">
        </form>
    </div>
    <div class="row col-md-12">
        <hr>
    </div>
    <?php
		}
		if ($_GET['act'] == 'edit') {
			$data = mysqli_fetch_object(mysqli_query($konek, "select*from kontak where id='$_GET[id]'"));
		?>
    <div class="row col-md-6">
        <form action="kontak.php?act=edit&&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
            <label>Nama</label><br>
            <input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>" required><br>
            <label>Email</label><br>
            <input type="email" class="form-control" name="email" value="<?php echo $data->email; ?>" required><br>
            <label>Subjek</label><br>
            <input type="text" class="form-control" name="subjek" value="<?php echo $data->subjek; ?>" required><br>
            <label>Pesan</label><br>
            <textarea class="form-control" name="pesan" required><?php echo $data->pesan; ?></textarea><br>
            <input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
        </form>
    </div>
    <div class="row col-md-12">
        <hr>
    </div>
    <?php
		}
	}
	?>

    <div class="table-responsive">

        <table class="table">
            <thead style="background:#00b4d8">
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>




                <?php while ($data = mysqli_fetch_object($q)) { ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><?php echo $data->nama ?></td>
                    <td><?php echo $data->email ?></td>
                    <td><?php echo $data->subjek ?></td>
                    <td><?php echo $data->pesan ?></td>
                    <td>
                        <a class="btn btn-sm btn-success" href="kontak.php?act=edit&&id=<?php echo $data->id ?>">Edit <i
                                class="fa-solid fa-user-pen"></i> </a>
                        <a class="btn btn-sm btn-danger" href="kontak.php?act=delete&&id=<?php echo $data->id ?>">Delete
                            <i class="fa-solid fa-trash"></i> </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
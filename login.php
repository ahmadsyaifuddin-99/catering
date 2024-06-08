<?php
include "inc/config.php";
if (!empty($_SESSION['iam_user'])) {
    redir("index.php");
}
include "layout/header.php";

$message = '';
$alertType = '';

if (!empty($_POST)) {
    extract($_POST);
    $password = md5($password);
    $q = mysqli_query($konek, "SELECT * FROM `user` WHERE email='$email' AND password='$password' AND status='user'") or die(mysqli_error());
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_object($q);
        $_SESSION['iam_user'] = $r->id;
        $message = "Anda berhasil login!";
        $alertType = "success";
    } else {
        $message = "Maaf, email dan password Anda salah.";
        $alertType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <font color="black">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-color-heading">Login User</h3>
                    <br>
                    <div class="col-md-7 content-menu" style="margin-top:-20px;">
                        <form action="" method="post" enctype="multipart/form-data">
                            <label>Email</label><br>
                            <input type="email" class="form-control" name="email" placeholder="Email" required="" autofocus="" /><br>
                            <label>Password</label><br>
                            <input type="password" class="form-control" name="password" placeholder="Password" required="" /> <br>
                            <input type="submit" name="form-input" value="Login" class="btn btn-success">
                        </form>
                    </div>
                    <div class="col-md-7 content-menu">
                        Belum Punya Akun ? <a href="register.php">Buat Akun Sekarang !</a>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($message)): ?>
            <script type="text/javascript">
                Swal.fire({
                    title: '<?php echo $alertType == "success" ? "Berhasil" : "Gagal"; ?>',
                    text: '<?php echo $message; ?>',
                    icon: '<?php echo $alertType; ?>',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    <?php if ($alertType == "success"): ?>
                        window.location.href = 'index.php';
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>
</body>

</html>

<?php include "layout/footer.php"; ?>

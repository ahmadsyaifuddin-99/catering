<?php
date_default_timezone_set("Asia/Ujung_Pandang");

include "inc/config.php";
if (!empty($_SESSION['iam_user'])) {
    redir("index.php");
}
include "layout/nav.php";

$message = '';
$alertType = '';
$emailOrUsername = isset($_POST['email_or_username']) ? $_POST['email_or_username'] : '';

if (!empty($_POST)) {
    extract($_POST);
    $password = md5($password);
    $login_time = date('l/d/M/Y-H:i:s:a');
    $q = mysqli_query($konek, "SELECT * FROM `user` WHERE (email='$emailOrUsername' OR username='$emailOrUsername') AND password='$password' AND status='user'") or die(mysqli_error($konek));
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_object($q);
        $_SESSION['iam_user'] = $r->id;
        
        // Simpan waktu login ke dalam basis data
        mysqli_query($konek, "UPDATE `user` SET last_login='$login_time' WHERE id='$r->id'");

        $message = "Anda berhasil login!";
        $alertType = "success";
    } else {
        $message = "Maaf, email atau username dan password Anda salah.";
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
        <div class="container centered-form">
            <div class="row">
                <div class="col-md-12 form-container">
                    <h3 class="text-color-heading"><b>Login User</b></h3>
                    <br>
                    <div class="col-md-7 centered-form" style="margin-top:-20px;">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="email_or_username">Username atau Email</label>
                                <input type="text" placeholder="Username atau Email" class="form-control"
                                    id="email_or_username" name="email_or_username" placeholder="" required=""
                                    autofocus="" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required="" />
                            </div>
                            <input type="hidden" name="login_time" value="<?php echo date('l/d/M/Y-H:i:s:a'); ?>">
                            <button type="submit" class="btn btn-success">Login</button>
                        </form>
                    </div>
                    <div class="col-md-7 content-menu">
                        Belum Punya Akun? <a href="register.php">Buat Akun Sekarang!</a>
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
            window.location.href = 'menu.php';
            <?php endif; ?>
        });
        </script>
        <?php endif; ?>
</body>

</html>

<?php include "layout/footer.php"; ?>
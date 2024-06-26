<?php
include "../inc/config.php";

// Check if the admin is not logged in, redirect to login page
if (empty($_SESSION['iam_admin'])) {
    redir("index.php");
    exit; // Stop further execution if the user is not logged in
}

include "inc/header.php";

?>

<div class="container">
	<?php
	$q = mysqli_query($konek, "select*from pesanan where id='$_GET[id]'");
	$data = mysqli_fetch_object($q);
	$ongkir = $data->ongkir;
	$kota = $data->kota;
	$dataPembayaran = mysqli_query($konek, "select * from pembayaran where id_pesanan='$data->id' and status='verified'");
	$totalPembayaran = 0;
	while ($d =  mysqli_fetch_array($dataPembayaran)) {
		$totalPembayaran += $d['total'];
	}

	$q1 = mysqli_query($konek, "select*from detail_pesanan where pesanan_id='$data->id'");
	$totalBayar = 0;
	while ($data2 = mysqli_fetch_object($q1)) {
		$katpro1 = mysqli_query($konek, "select*from produk where id='$data2->produk_id'");
		$a = mysqli_fetch_object($katpro1);
		$totalBayar += ($a->harga * $data2->qty);
	}
	$totalBayar += $ongkir;
	?>
	<h4 class="pull-left">Pesanan Detail</h4>
	<a class="btn btn-sm btn-primary pull-right" href="pesanan.php"> <i class="fa-solid fa-arrow-left-long"></i>
		Kembali</a>
	<br>
	<hr>
	<div class="row col-md-12">
		<table class="table table-striped table-hove">
			<tr>
				<td width="200">Nama Pemesan</td>
				<?php
				$katpro = mysqli_query($konek, "select*from user where id='$data->user_id'");
				$user = mysqli_fetch_array($katpro);
				?>
				<td><?php echo $user['nama'] ?></td>
			</tr>
			<tr>
				<td>Tanggal Pesan</td>
				<td><?php echo substr($data->tanggal_pesan, 0, 10); ?></td>
			</tr>
			<tr>
				<td>Tanggal Digunakan</td>
				<td><?php echo $data->tanggal_digunakan ?></td>
			</tr>
			<tr>

				<td>Telephone</td>
				<td><?php echo $data->telephone ?></td>
			</tr>
			<td>Alamat</td>

			<td><?php echo $data->alamat ?></td>
			</tr>
			<tr>
				<td>Total Bayar</td>
				<td><b><?php echo "Rp. " . number_format($totalBayar, 0, ",", "."); ?></b></td>
			</tr>
			<tr>
				<td>Dibayar</td>
				<td><?php echo "Rp. " . number_format($totalPembayaran, 0, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Kekurangan</td>
				<td><?php echo "Rp. " . number_format($totalBayar - $totalPembayaran, 0, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo $data->status; ?></td>
			</tr>
		</table>
	</div>
	<div class="row col-md-12">
		<h4>List Pesanan</h4>
		<hr>
		<table class="table table-striped table-hove">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Satuan</th>
					<th>QTY</th>
					<th>Harga *</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$q = mysqli_query($konek, "select*from detail_pesanan where pesanan_id='$_GET[id]'");
				$total = 0;
				while ($data = mysqli_fetch_object($q)) { ?>
					<tr>
						<th scope="row"><?php echo $no++; ?></th>
						<?php
						$katpro = mysqli_query($konek, "select*from produk where id='$data->produk_id'");
						$p = mysqli_fetch_object($katpro);
						?>
						<td><?php echo $p->nama ?></td>
						<td><?php echo number_format($p->harga, 0, ',', '.')  ?></td>
						<td><?php echo $data->qty ?></td>
						<?php $t = $data->qty * $p->harga;
						$total += $t;
						?>
						<td><?php echo number_format($t, 0, ',', '.')  ?></td>
						<!--td>
						<a class="btn btn-sm btn-warning" href="detail_pesanan.php?id=<?php echo $data->id ?>">Detail</a>
						<a class="btn btn-sm btn-success" href="pesanan.php?act=edit&&id=<?php echo $data->id ?>">Edit</a>
						<a class="btn btn-sm btn-danger" href="pesanan.php?act=delete&&id=<?php echo $data->id ?>">Delete</a>
					</td-->
					</tr>
				<?php } ?>
				<tr>
					<td colspan="3" class="text-center">
						<h5><b>KOTA & ONGKIR</b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo $kota ? $kota : "Tidak di ketahui"; ?></b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo number_format($ongkir, 0, ',', '.') ?></b></h5>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="text-center">
						<h5><b>TOTAL HARGA</b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo number_format($total + $ongkir, 0, ',', '.') ?></b></h5>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div> <!-- /container -->
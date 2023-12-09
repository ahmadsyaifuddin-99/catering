<?php 
	include"../inc/config.php"; 

	
	
	if(!empty($_GET)){
		if($_GET['act'] == 'delete'){
			
			$q = mysqli_query($konek, "delete from kota WHERE id='$_GET[id]'");
			if($q){ alert("Success"); redir("kota.php"); }
		}  
	}
	if(!empty($_GET['act']) && $_GET['act'] == 'create'){
		if(!empty($_POST)){
			extract($_POST);
			$q = mysqli_query($konek, "insert into kota Values(NULL,'$nama','$ongkir')");
			if($q){ 
				alert("Success"); redir("kota.php");
			}
		}
	}
	if(!empty($_GET['act']) && $_GET['act'] == 'edit'){
		if(!empty($_POST)){ 
			extract($_POST);
			$q = mysqli_query($konek, "update kota SET nama='$nama',ongkir='$ongkir' where id=$_GET[id]") or die(mysqli_error());
			if($q){
				alert("Success"); redir("kota.php");
			}
		}
	}
	
	
	include"inc/header.php";
	
?> 
	
	<div class="container">
		<?php
			$q = mysqli_query($konek, "select*from kota");
			$j = mysqli_num_rows($q);
		?>
		<h4>Daftar Produk (<?php echo ($j>0)?$j:0; ?>)</h4>
		<a class="btn btn-sm btn-primary" href="kota.php?act=create">Tambah Kota & Ongkir <i class="fa-solid fa-plus"></i> </a>
		<hr>
		<?php
			if(!empty($_GET)){
				if($_GET['act'] == 'create'){
				?>
					<div class="row col-md-6">
					<form action="" method="post">
						<label>Nama</label><br>
						<input type="text" class="form-control" name="nama" required><br>
						<label>Ongkir</label><br>
						<input type="number" class="form-control" name="ongkir" required><br>
						<input type="submit" name="form-input" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php	
				} 
				if($_GET['act'] == 'edit'){
					$data = mysqli_fetch_object(mysqli_query($konek, "select*from kota where id='$_GET[id]'"));
				?>
					<div class="row col-md-6">
					<form action="kota.php?act=edit&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
						<label>Nama</label><br>
						<input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>"><br>
						<label>Ongkir</label><br>
						<input type="number" class="form-control" name="ongkir" required value="<?php echo $data->ongkir; ?>"><br>
						<input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php
				} 
			}
		?>
		
		<table class="table table-striped table-hover">
			<thead> 
				<tr> 
					<th>#</th> 
					<th>Nama</th> 
					<th>Ongkir</th> 
					<th>*</th> 
				</tr> 
			</thead> 
			<tbody> 
				

			
			
		<?php while($data=mysqli_fetch_object($q)){ ?> 
				<tr> 
					<th scope="row"><?php echo $no++; ?></th> 
					<td><?php echo $data->nama ?></td> 
					<td><?php echo number_format($data->ongkir, 2, ',', '.') ?></td> 
					<td>
						<a class="btn btn-sm btn-success" href="kota.php?act=edit&&id=<?php echo $data->id ?>">Edit <i class="fa-solid fa-pen-to-square"></i> </a>
						<a class="btn btn-sm btn-danger" href="kota.php?act=delete&&id=<?php echo $data->id ?>">Delete <i class="fa-solid fa-trash"></i> </a>
					</td> 
				</tr>
		<?php } ?>
			</tbody> 
		</table> 
    </div> <!-- /container -->
	
<?php include"inc/footer.php"; ?>
<?php 
session_start();
if (! isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}


require 'function.php'; 


$id= $_GET["id"];


//setelah membuat id yang isinya didapat dari id diatas 
//selanjutnya kita mengambil data/ atau query data bedasarkan id

$liq= query("SELECT * FROM tb_liq WHERE id = $id")[0];


//mengecek tombol submit sudah ditekan sprt pd materi sebelumnya

if (isset($_POST["submit"])) {
//cek data berhasil diubah atau tidak
	if (ubah ($_POST)>0 ) {
		
		//SCRIPT adalah syntax dari java script, disini digunakan untuk setelah data diubah langsung mendirect ke halaman index 
		//jika pada php bisa menggunakan header.location 'name.file' seperti pada materi sebelumnya. 

		echo "
			<script>
			alert('data berhasil diubah!');
			document.location.href='index.php' ; 
			</script>" ;
	}
	else
	{
		echo	"	<script>
			alert('data gagal diubah!');
			document.location.href='index.php' ; 
			</script>

		"; 
	
	}



		



}


	

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Ubah data liquid</title>
</head>
<body>
	<h1>Ubah Data Liquid</h1>
	
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $liq["id"];  ?>">
		<input type="hidden" name="gambarlama" value="<?= $liq["gambar"];  ?>">
		<ul>
			<li>
				<label for="product"> Product : </label>
				<input type="text" name="product" id="product" required="" 
				value="<?= $liq["product"];  ?>">
			</li>
			<li>
				<label for="nama"> Nama Liquid : </label>
				<input type="text" name="nama" id="nama" required="" 
				value="<?= $liq["nama"];  ?>">
			</li>
			<li>
				<label for="type"> Type Liquid : </label>
				<input type="text" name="type" id="type" 
				value="<?= $liq["type"];  ?>">
			</li>	
			<li>
				<label for="flavor"> Flavor Liquid : </label>
				<input type="text" name="flavor" id="flavor" 
				value="<?= $liq["flavor"];  ?>">
			</li>
			<li>
				<label for="nicotine"> Nicotine : </label>
				<input type="text" name="nicotine" id="nicotine" 
				value="<?= $liq["nicotine"];  ?>">
			</li>
			<li>
				<label for="gambar"> Gambar : </label><br>
				<img src="img/<?= $liq["gambar"] ?>" width="100" ><br>
				<input type="file" name="gambar" id="gambar" >
			</li>
			<li>
				<button type="submit" name="submit"> Ubah Data Liquid !</button>
			</li>

		</ul>

	</form>


</body>
</html>
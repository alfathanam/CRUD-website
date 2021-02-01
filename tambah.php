<?php 
session_start();
if (! isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}


require 'function.php'; 

if (isset($_POST["submit"])) {
//cek data berhasil ditambahkan atau tidak
	


	if (tambah ($_POST)>0 ) {

		echo "
			<script>
			alert('data berhasil ditambahkan!');
			document.location.href='index.php' ; 
			</script>" ;
	}
	else
	{
		echo	"	<script>
			alert('data gagal ditambahkan!');
			document.location.href='index.php' ; 
			</script>

		"; 
	var_dump(mysqli_affected_rows($conn));
	}



		



}


	
//selanjutnya kita akan membuat tombol upload dimana pengguna bisa mengupload berupa file.
//variabel global $_FILES, Move uploaded file, enctype, input type. 

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Tambah data liquid</title>
</head>
<body>
	<h1>Tambah Data Liquid</h1>
	
	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="product"> Product : </label>
				<input type="text" name="product" id="product" required="">
			</li>
			<li>
				<label for="nama"> Nama Liquid : </label>
				<input type="text" name="nama" id="nama" required="">
			</li>
			<li>
				<label for="type"> Type Liquid : </label>
				<input type="text" name="type" id="type">
			</li>	
			<li>
				<label for="flavor"> Flavor Liquid : </label>
				<input type="text" name="flavor" id="flavor">
			</li>
			<li>
				<label for="nicotine"> Nicotine : </label>
				<input type="text" name="nicotine" id="nicotine">
			</li>
			<li>
				<label for="gambar"> Gambar : </label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit"> Tambah Data Liquid !</button>
			</li>

		</ul>

	</form>


</body>
</html>
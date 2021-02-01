<?php 
session_start();
if (! isset($_SESSION["login"])) {
	header("location: login.php");
	exit;
}



require'function.php';
//pagination
//konfigurasi logika untuk pagination
$jumlahDataPerhalaman = 2;

$totalDataLiq = count(query("SELECT * FROM tb_liq") );
//$result = mysqli_query($conn, "SELECT * FROM tb_liq"); 
//$totalDataLiq= mysqli_num_rows($result);
//mysqli_query mengembalikan nilai berupa Object. 
//jika menggunakan query mengembalikan nilai berupa array karena query mengahasil kan array assoc maka akan dikembalikan menjadi assoc
//mysqli num rows akan menampilkan berapa baris yang ada dalam result, atau tb_liq

//$liquid yang ini menampilkan semua data liquid pada halaman ini 

 
$jumlahHalaman = ceil($totalDataLiq / $jumlahDataPerhalaman); 
//ceil membulatkan pecahan keatas misal 1,2 menjadi 2.
//floor membulatkan pecahan kebawah, misal 1,2 menjadi 1.
//round membulatkan bilangan pecahan ke yang terdekat, misal ,2 menjadi 1. jika 1,5 menjadi 2.

if (isset($_GET["hal"])) {
	$halamanAktif = $_GET["hal"];
	//untuk mengetahui halaman yang kita klik atau aktif kita mengambil data. 
//menggunakan get 

}else{
	$halamanAktif = 1;
}
//hal 1 jika jika data perhalaman 2 bedasarkan index= 0,1
//hal 2 = 2,3
//hal 3 = 4,5 dst
//data yang ditampilkan pada tb_liq ada 8. data awal dimulai dengan index 0
$awalData= ($jumlahDataPerhalaman * $halamanAktif ) - $jumlahDataPerhalaman;

$liquid = query("SELECT * FROM tb_liq LIMIT $awalData, $jumlahDataPerhalaman"); 


if (isset($_POST["cari"])) {
	$liquid= cari($_POST ["keyword"]);
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<title> Halaman Admin</title>
</head>
<body>
<a href="logout.php"> Logout </a>
<h1> Daftar Liquid</h1>
<a href="tambah.php"> Tambah Data Liquid </a>

<br><br>

<form action="" method="post">
	
	<input type="text" name="keyword" size="25" autofocus="" placeholder="Masukan keyword disini.." autocomplete="off">

	<button type="submit" name="cari"> Cari Liquid </button>
</form>
<br><br>
<!-- Navigasi Pagination atau halaman -->

<?php if($halamanAktif > 1) :?>
	<a href="?hal=<?= $halamanAktif - 1;  ?>">&laquo;</a>
<?php endif; ?>

<?php for($i=1; $i <= $jumlahHalaman; $i++ ) : ?>
	<?php if($i == $halamanAktif) : ?>
	<a href="index.php?hal=<?= $i;?>" style="font-weight: bold; color: red"> <?php echo $i; ?>  	</a>
	<?php else : ?>
		<a href="index.php?hal=<?= $i;?>"> <?php echo $i; ?>  	</a>
	<?php endif ; ?>	
<?php endfor; ?>


<?php if($halamanAktif < $jumlahHalaman) :?>
	<a href="?hal=<?= $halamanAktif + 1;  ?>">&raquo;</a>
<?php endif; ?>

<br>

<table border="1" cellpadding="10" cellspacing="0">
	
	<tr>
		<th>No.</th>
		<th>Aksi</th>
		<th>Gambar</th>
		<th>Product</th>
		<th>Nama</th>
		<th>Type </th>
		<th>Flavor</th>
		<th>Nicotine</th>


	</tr>	
<!-- kalo diatas kita sudah bisa menghubungkan kedatabase dan mengambil data dengan querry, sekarang kita masukan data dari tabel tb_liq ke tabel yang ada html -->


<?php $i= 1; 
//pada id kita tidak mengambil data dari database kitabuat phpnya dengan variabel baru dan kita ubah jadi i++
?>
<?php foreach ($liquid as $row) :?>	

	<tr>
		<td><?= $i; ?></td>
		<td>
			<a href="ubah.php?id=<?php echo $row ["id"]; ?>" >ubah</a>|

			<a href="hapus.php?id=<?php echo $row ["id"]; ?>" onclick="return confirm ('yakin?');" >hapus</a>

		</td>
		<td><img src="img/<?php echo $row ["gambar"]; ?>" 
			width="50"></td>
		<td><?= $row["product"]; ?></td>
		<td><?= $row ["nama"]; ?></td>
		<td><?= $row ["type"];  ?> </td>
		<td><?= $row ["flavor"]; ?></td>
		<td><?= $row ["nicotine"];  ?></td>
	</tr>

	<?php  $i++;  ?>
	
<?php endforeach;  ?>







</table>


</body>
</html>
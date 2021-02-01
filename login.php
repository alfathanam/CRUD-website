<?php 
session_start();
require 'function.php'; 

//cek cookie ada atau tidak
//cek ada tidak cookie id dan key
if (isset($_COOKIE["id"])&& isset($_COOKIE["key"]) ) {
	$id = $_COOKIE["id"];
	$key =$_COOKIE["key"];

	//jika id ada maka akanditampung dalam variabel $id


	//ambil username bedasarkan id
	//pertama kita ambil data dengan querry
	$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id") ;
	$row = mysqli_fetch_assoc($result);

	//cek cookie dan username
	if ($key === hash("sha256", $row["username"])) {
		$_SESSION["login"]=true;

	}

}



if ( isset($_SESSION["login"])) {
	header("location: index.php");
	// jika login tidak sesuai atau belum disi maka akan kembali ke halaman login. tidak bisa langsung ke index
	//tetapi jika login==true maka akan mendirect ke halaman index, selama browser tidak dikeluarkan maka session tetap berjalan.
	//login==true ada di line 39
}




if (isset($_POST["submit"])) {
	
	$username = $_POST["user"];
	$password = $_POST["password"];
//cek satu satu, ada tidak username dalam database. jika ada cek password
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username= '$username' ");

//cek username
		//mysqli_num_row mengembalikan nilai 1 jika ada bari yang diterima.
	//misal didatabase kita ada username aris, lalu ketika login kita memasukan username aris maka akan dikembalikan 1 baris. 

	if (mysqli_num_rows($result) ===1) {
			
			//cek password 
			//setelah username ada didatabase cek password

		$row = mysqli_fetch_assoc($result);

		if(password_verify($password, $row["password"]) ){
			//set session
			//membuat variabel login yang dimana 
			//setiap halaman mengecek session [login] kalau tidak ada maka akan balik ke halaman login

			$_SESSION["login"] = true; 

			
			//set remember me
			if (isset($_POST["remember"])) {
				//set cookie
				setcookie("id", $row["id"], time() +60); 
				setcookie("key", hash("sha256", $row["username"]), time()+60);

				}

				//sudah membuat cookie, sekarang agar aman cookienya kita tambahkan hash jika ada org menduplikat cookie tidak bisa langsung masuk
				//cookie yang bagus disimpan didalam database
				//pertama kita buat cookie id 
				//kedua, buat cookie kedua username dimana username yang di masukan user baik akan otomatis dihash atau diencrpyt. menggunakan algo sha256. cek php documentation
				// selesai cek algoritma diline pertama, karena ketika kita buka php pertama akan mengecek cookienya ada atau tidak
			


				header("location: index.php");
		//penulisan location: harus sama , jika location :   yang terjadi akan server error.
				exit; 

		}

		}	
		$error = true; 
//logika mysqli_querry membutuhkan paramater $conn, setelah itu mengambil data dari tabel users yang ada database, dimana username= akan bernilai $username yang kita masukan dalam form login . 

// setelah itu num_rows memeberikan hasil bolean jika 1 rows-baris diambil. misal 1 rows ada username alfathan dan password 123 yang ada didatabase. 
		//setelah itu data tersebut disimpan dalam variabel row seperti pada pertemua sblumnnya setelah rows. cek password verify merupakan function yang ada didalam php, dengan dua parameter, password yang dimasukan dalam form, dan password yang sudah disimpan dalam row,atau kotak kecil yang datanya diambil dari database. 
//jika bener maka akan mendirect ke index.php
// jika password salah atau username langsung menjalankan error		
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Membuat Login </title>
	<link rel="stylesheet" href="style.css">
	<style>
		label{
			display: block;
		}
	</style>
</head>
<body>
<?php if (isset($error)) : ?>
	<p style="color: red; font-style: italic;" > Username / Password salah </p>

	<?php endif; ?>	


<div class="login-box">
<h1> Halaman Login </h1>
<form action="" method="post">
		<div class="textbox">
			<i class="fas fa-user"></i>
			<input type="text" name="user" placeholder="Username" id="username">
	
		  </div>
		


		<div class="textbox">
			<i class="fas fa-lock"></i>
			<input type="password" name="password" placeholder="Password" id="password">
		</div>

			<input type="checkbox" name="remember" id="remember">
			<label class="textbox" for="remember" > Remember me</label>
		
			<button class="btn" type="submit" name="submit" value="Sign in"> Sign in </button>
		
		</div>


	

</form>

</body>
</html>
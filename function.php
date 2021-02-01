<?php 

$conn= mysqli_connect("localhost", "root", "", "db_liquid");




function query($data) {

	global $conn; 
	$result = mysqli_query($conn, $data); 



	$rows = []; 
		while ( $row = mysqli_fetch_assoc($result) ) {
			
			$rows [] = $row; 
		}
		return $rows; 
}


function tambah($data){
	global $conn; 
	$product=htmlspecialchars($data ["product"]);
	$nama=htmlspecialchars($data["nama"]);
	$type=htmlspecialchars($data["type"]);
	$flavor=htmlspecialchars($data["flavor"]);
	$nicotine=htmlspecialchars($data["nicotine"]);
	$gambar= upload();
		if (!$gambar) {
		 	return false; 
		 } 
//sekarang ketika gambar dikirim dari upload akan masuk ke variabel gambar. 
//nanti kita buat function uploadnya sendiri 
//jika gambar tidak dikirimkan maka function akan menjalankan false atau mengembalikan nilai
//maka tidak akan menjalankan query insert into 		



	$query= "INSERT INTO tb_liq
				VALUES 
				('', '$product', '$nama', '$type', '$flavor', '$nicotine', '$gambar'  )";


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);


}
function upload(){
	$namefile = $_FILES ['gambar']['name'];
	$ukuranfile = $_FILES ['gambar']['size'];
	$erorr = $_FILES ['gambar'] ['error'];
	$tmpname = $_FILES ['gambar'] ['tmp_name']; 
//cek apakah tidak ada gambar yang di upload
	if ($erorr === 4) {
		echo "
			<script>
			alert('pilih gambar terlebih dahulu!');
			</script>" ;
			return false;

	}
//cek apakah file yang di upload adalah gambar. agar user tidak bisa mengupload selain gambar atau beberapa jenis extensi
	$ekstensigambarvalid =['jpg', 'jpeg', 'png']; 
	$ekstensigambar = explode('.', $namefile); 
	$ekstensigambar =strtolower(end($ekstensigambar));

	if (! in_array($ekstensigambar, $ekstensigambarvalid)) {
		echo "
			<script>
			alert('Yang anda upload bukan gambar!');
			</script>" ;
			return false;

	}
	if ($ukuranfile > 1000000) {
		echo "
			<script>
			alert('ukuran gambar terlalu besar!');
			</script>" ;
			return false;
	}

//JIKA sudah tidak error yang diupload oleh user, (ukuran jenisfile, atau gambar blum diupload). maka akan jalankan upload
	// lalu agar file yang diupload tidak sama, karena jika seperti ini ada kemungkinan data tertimpa. misal upload mhs a 1.filegambar ,  lalu mhs b 1.filegambar , maka data akan tertimpa yang mhs a
//mengenerate namafile baru dengan angka random
	$namefilebaru = uniqid(); 
	$namefilebaru.= '.'; 
	$namefilebaru.= $ekstensigambar ; 	  


move_uploaded_file($tmpname, 'img/' .$namefilebaru ) ;
	
	return $namefilebaru; 









}










function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM tb_liq WHERE id=$id" );
	return mysqli_affected_rows($conn) ; 
}

function ubah($data){
	global $conn;
	$id=$data["id"];
	$product=htmlspecialchars($data ["product"]);
	$nama=htmlspecialchars($data["nama"]);
	$type=htmlspecialchars($data["type"]);
	$flavor=htmlspecialchars($data["flavor"]);
	$nicotine=htmlspecialchars($data["nicotine"]);
	$gambarlama = htmlspecialchars($data["gambarlama"]);

//cek apakah user memilih gambar baru atau tidak 
	//'gambar didapat dari input type, name= gambar , nah error merupakan elemen array dari gambar karena gambar merupakan array multidimension 
//4 adalah salah satu pesan , jika 0 maka tidak ada error , jika 4 gambar tidak diupload
//cari pesan error gambar yang lainnya 
//jadi jika gambar tidak diupload maka gambar akan menampilkan gambar lama. tetapi selain 4, maka menjalankan else, gambar memanggil fungsi upload.
//liat fungsi upload dan gambar berhasil diubah 	
	if ($_FILES ['gambar']['error']===4 ) {
		$gambar = $gambarlama;
	}else{
		$gambar = upload() ; 
	}



	$query= "UPDATE tb_liq SET 
			product='$product', 
			nama='$nama',
			type='$type',
			flavor='$flavor',
			nicotine='$nicotine',
			gambar='$gambar'

				WHERE id=$id" ;


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);




}
function cari($keyword){

	$query= "SELECT * FROM tb_liq 
			WHERE 
			nama LIKE '%$keyword%' OR 
			type LIKE '%$keyword%' OR
			product Like '%$keyword%'
			 ";

	return query($query);

}

function register($data) { 
 global $conn; 

 	$username = strtolower(stripcslashes($data["username"]));
 	$password = mysqli_real_escape_string ($conn, $data["password"]); 
 	$password2 = mysqli_real_escape_string ($conn, $data["password2"]); 

//cek username sudah ada didalam database atau belum 

	$result = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'"); 
	
	if (mysqli_fetch_assoc($result)) {
	
		echo "<script>
			alert('username sudah terdaftar'); 
			</script>" ;
			return false; 
	}


//cek konfirmasi password sama atau tidak 
 	if ($password !== $password2) {
 		echo "<script>
 				alert('Password tidak sama ! Ulangi');
 		</script>";

 		return false; 
 	}

//enkripsi password
 	$password = password_hash($password, PASSWORD_DEFAULT); 


//menambahkan user ke dalam database
 	mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')"); 

 	return mysqli_affected_rows($conn ); 


 }





 ?>
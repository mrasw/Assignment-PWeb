<?php 
	session_start();
	require 'koneksi.php';

	if(!$_FILES || !key_exists('gambar', $_FILES)){
		$upload_path = 'uploads';

		require 'koneksi.php';

		$username = $db_connection->real_escape_string($_POST['username']);
		$password = $db_connection->real_escape_string(md5($_POST['password']));

		$q = $db_connection->query('SELECT * FROM log WHERE username = \''.$username.'\' AND password = \''.$password.'\'');
		$r = $q->num_rows;

		if($r < 1){
			die('Username/Password tidak cocok!');
		}

		$image_path = $upload_path . '/' . $username;
		$file = $_POST['gambar'];
		// Create new folder if not exists
		if (!file_exists($image_path)) {
			if (!mkdir($image_path)) {
				die('Tidak bisa membuat folder.');
			}
		}

		// base64_decode
		$fi = new FilesystemIterator($image_path, FilesystemIterator::SKIP_DOTS);
		$fileCount = iterator_count($fi) + 1;
		$fullName = $image_path."/X_".$fileCount."_". date("YmdHis") .".png";
		$ifp = fopen($fullName, "wb");
		fwrite($ifp, base64_decode($file));
		fclose($ifp);
		if (!$ifp){
			die('Tidak bisa memindahkan file.');
		}

		// Log
		$q = $db_connection->query('INSERT INTO user (uploader, nama_file, waktu_upload) VALUES (\''.$username.'\', \''.$fullName.'\', NOW())');
		if($db_connection->affected_rows > 0){
			$_SESSION['success'] = TRUE;
			die('Gambar berhasil diunggah');
		}else{
			die('Gambar gagal diunggah');
		}
		die('Mohon upload file foto Anda.');
	}else{
		if(!isset($_SESSION['log'])){
			header('Location: login.php');
		}
	
		$tmp = $_FILES['gambar']['tmp_name'];
		$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
		$upload_path = 'uploads';
		$username = $_SESSION['username'];
		
		// Check the MIME type
		$whitelist = ['image/jpg', 'image/jpeg', 'image/png'];
		if(!in_array(mime_content_type($tmp), $whitelist)){
			die('Mohon hanya unggah file JPG, JPEG, atau PNG.');
		}

		// Check the extension
		$whitelist = ['jpg', 'jpeg', 'png'];
		if(!in_array(strtolower($ext), $whitelist)){
			die('Mohon unggah file dengan ekstensi yang benar.');
		}

		// Check size of image to verify the image type
		if(getimagesize($tmp) == 0){
			die('File gambar Anda tidak valid.');
		}

		// base64_encode the file
		$tmpb64 = base64_encode(file_get_contents($tmp));
		$image_path = $upload_path . '/' . $username;

		// Create new folder if not exists
		if (!file_exists($image_path)) {
			if (!mkdir($image_path)) {
				die('Tidak bisa membuat folder.');
			}
		}

		// base64_decode
		$fi = new FilesystemIterator($image_path, FilesystemIterator::SKIP_DOTS);
		$fileCount = iterator_count($fi) + 1;
		$fullName = $image_path."/X_".$fileCount."_". date("YmdHis") .".png";
		$ifp = fopen($fullName, "wb");
		fwrite($ifp, base64_decode($tmpb64));
		fclose($ifp);
		if (!$ifp){
			die('Tidak bisa memindahkan file.');
		}

		// Log
		//$q = $db_connection->query('INSERT INTO log (pengunggah, nama_file, waktu_upload) VALUES (\''.$username.'\', \''.$fullName.'\', NOW())');
		/*if($db_connection->affected_rows > 0){
			$_SESSION['success'] = TRUE;
			header('Location: dashboard.php');
		}else{
			$_SESSION['success'] = FALSE;
			header('Location: dashboard.php');
		}*/
		$queri=mysqli_query($db_connection,"INSERT INTO user (pengunggah, nama_file, waktu_upload) VALUES ('$username', '$fullName', NOW())");
		if($queri){
			$_SESSION['success'] = TRUE;
			header('Location: dashboard.php');
		}else{
			$_SESSION['success'] = FALSE;
			header('Location: dashboard.php');
		}

}
?>

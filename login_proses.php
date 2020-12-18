<?php session_start();
include "koneksi.php";

$username=$_POST['username'];
$password=$_POST['password'];

$put= "select * from log where username='$username' and password='$password'";
$query=mysqli_query($db_connection,$put);
$cek=mysqli_num_rows($query);
if($cek){
$_SESSION['username']=$username;
$_SESSION['log'] = 1;
?>Anda berhasil login. silahkan menuju <a href="dashboard.php">Halaman DASHBOARD</a><?php
}else{
?>Anda gagal login. silahkan <a href="index.php">Login kembali</a><?php
echo mysqli_error($koneksi);
}
?>

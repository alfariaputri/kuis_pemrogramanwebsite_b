<?php 
session_start();
if(!isset($_SESSION['session_username'])){
    header("location:login.php");
    exit();
}
print_r($_SESSION);
print_r($_COOKIE);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>
<body>
INI HALAMAN ADMIN <a href="logout.php">Keluar</a>
</body>
</html>
<?php
session_start();
include 'connect.php';

if(isset($_POST['email'])){
	$email=$_POST['email'];
	 $password=$_POST['password'];
	$password=md5($password);
	$res=mysqli_query($conn,"SELECT * FROM admin WHERE email='$email' and password='$password'");
	$num=mysqli_num_rows($res);
	if($num>=1){
		$row=mysqli_fetch_array($res);
		$_SESSION['login']=true;
		$_SESSION['name']=$row['name'];
		$_SESSION['email']=$row['email'];
		header('location:index');

	}
	else{
		$_SESSION['wrong']=true;
		header('location:login.php');
	}
}

?>
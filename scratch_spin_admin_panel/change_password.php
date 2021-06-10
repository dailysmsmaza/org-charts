
<?php
session_start();
 include 'connect.php' ; 
include 'demo.php';
?>
<?php
if($demo){
	$_SESSION['message']="This is a demo mode you can't change password contact to owner !";
header("location:profile.php");
	 echo "<script>window.location.href='index.php';</script>";
}
else{
if(isset($_POST['oldpass'])){
	$oldpass=$_POST['oldpass'];
	$oldpass=md5($oldpass);
	$pass=$_POST['pass'];
	$cpass=$_POST['cpass'];
	if($cpass!=$pass){
		$_SESSION['message']='NEW PASSWORD AND CONFRIM PASSWORD NOT MATCH !';
		header("location:profile.php");
 echo "<script>window.location.href='profile.php';</script>";
	}
	else{
		 $query="SELECT * FROM admin WHERE email='admin@gmail.com' and password='$oldpass'";
		$res=mysqli_query($conn,$query);
		$num=mysqli_num_rows($res);
		if($num==0){
				$_SESSION['message']='OLD PASSWORD NOT MATCH !';
		header("location:profile.php");
		 echo "<script>window.location.href='profile.php';</script>";
		}
		else{
			$pass=md5($pass);
			$query="UPDATE admin SET password='$pass' WHERE email='admin@gmail.com'";
			$res=mysqli_query($conn,$query);
			if($res){
				$_SESSION['message']='PASSWORD UPDATED !';
				header("location:profile.php");
			}
			else{
				$_SESSION['message']='SOMETHING WENT WRONG TRY AGAIN !';
				header("location:profile.php");
			}
		}
	}
}
}
 echo "<script>window.location.href='profile.php';</script>";
?>

<?php include 'connect.php' ; 
include 'demo.php';
?>
<?php
if($demo){


header('location:userlist.php');
 }
else {
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$status=$_GET['status'];
	$res=mysqli_query($conn,"UPDATE users SET status='$status' WHERE id='$id'");
	
}
}
header('location:userlist.php');
 echo "<script>window.location.href='userlist.php';</script>";
?>

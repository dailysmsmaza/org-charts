
<?php include 'connect.php' ; 
include 'demo.php';
?>
<?php
if($demo){
	header('location:config.php');
	 echo "<script>window.location.href='config.php';</script>";
}
else{
$email=$_REQUEST['email'];

$type=$_REQUEST['type'];
	if($type=='editemail'){
		$id=$_REQUEST['id'];
		$email=$_REQUEST['email'];
	mysqli_query($conn,"UPDATE config SET froms='$email' WHERE id='$id'");
		
	}
		if($type=='editpoint'){
		$id=$_REQUEST['id'];
		$email=$_REQUEST['email'];
	
	mysqli_query($conn,"UPDATE config SET froms='$email' WHERE id='$id'");
			
	}
   echo "<script>window.location.href='config.php';</script>";
    exit;
}

?>
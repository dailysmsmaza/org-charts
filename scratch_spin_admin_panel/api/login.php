<?php
include 'connect.php';

if(isset($_REQUEST['get_login'])){
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$password=md5($password);
	$res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' and password='$password'");
	$num=mysqli_num_rows($res);
	if($num>=1){
		$response=array();
		$response['status']=True;
		$row=mysqli_fetch_array($res);
		array_push($response, $row);
		
		
	}
	else{
		$response['status']=False;
		$response['message']='Wrong email or password';
	}
	echo json_encode($response);
}
?>
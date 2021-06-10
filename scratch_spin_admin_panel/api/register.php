<?php
include 'connect.php';
if(isset($_REQUEST['register'])){
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$number=$_REQUEST['number'];
	$password=$_REQUEST['password'];
	$password=md5($password);
	$referral_code='';
	if(isset($_REQUEST['referral_code'])){
		$referral_code=$_REQUEST['referral_code'];

	}
	
	$referral_with='';
	if(isset($_REQUEST['referral_with'])){
	$referral_with=$_REQUEST['referral_with'];
	$query="SELECT * FROM users WHERE referraled_with='$referral_with'";
		$res=mysqli_query($conn,$query);
		$num=mysqli_num_rows($res);
		if($num<1){
			 $response['status']=False;
      	$response['message']='Not valid code';
      	echo json_encode($response);
      	exit();
		}
      }
      $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
      $num=mysqli_num_rows($res);
      if($num>=1){
      	$response['status']=False;
      	$response['message']='Already Registered';
      }
      else{
      	$res=mysqli_query($conn,"INSERT INTO users (name,email,contact,password,referral_code,referraled_with,status) VALUES ('$name','$email','$number','$password','$referral_code','$referral_with','1')");
      	if($res){
              $response['status']=True;
      	$response['message']='Registered';
      	}
      	else{
          $response['status']=False;
      	$response['message']='Somthing wrong';
      	}
      }

echo json_encode($response);
}
?>
<?php 
include 'connect.php';
if(isset($_REQUEST['update_profile'])){
		$name=$_REQUEST['name'];
		$id=$_REQUEST['user_id'];
	$email=$_REQUEST['email'];
	$number=$_REQUEST['number'];
	$target_dir = "images/";
	$img=$_FILES["img"]["name"];
	$target_file = $target_dir . basename($_FILES["img"]["name"]);
	if($img!='' or !empty($img)){
move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
$query="UPDATE users SET name='$name',email='$email',number='$number',image='$img' WHERE id='$id'";
} else{
	$query="UPDATE users SET name='$name',email='$email',number='$number' WHERE id='$id'";
}
$res=mysqli_query($conn,$query);
if($res){
	$response=array();
	$response['status']=True;
	$query="SELECT * FROM users WHERE id='$id'";
	$data=mysqli_query($conn,$query);
	$row=mysqli_fetch_array($data);
   array_push($response,$row);
}
else{
     $response['status']=False;
     $response['message']='Profile not updated';
}
echo json_encode($response);
}
?>
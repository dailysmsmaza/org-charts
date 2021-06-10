<?php 
include 'connect.php';
if(isset($_REQUEST['top_users'])){

 $query="SELECT * FROM users ORDER BY points DESC LIMIT 10";
$res=mysqli_query($conn,$query);
$num=mysqli_num_rows($res);
if($num>=1){
	$temp=array();
	$response=array();
	$response['status']=True;

	while($row=mysqli_fetch_array($res)){
		array_push($temp, $row);
	}
	array_push($response, $row);
}
else{
	$response['status']=false;
	$response['message']='No Record There';
}
echo json_encode($response);
}
?>

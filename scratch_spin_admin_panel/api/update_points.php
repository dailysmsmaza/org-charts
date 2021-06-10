
   <?php
include 'connect.php';
if(isset($_REQUEST['redeem_point'])){
    $id=$_REQUEST['user_id'];
    $new_point=$_REQUEST['new_point'];
    $reddemed_point=$_REQUEST['redeemed_point'];
    $payment_mode=$_REQUEST['payment_mode'];
   $referraled_with='';
   $payment_info=$_REQUEST['payment_info'];

   if(isset($_REQUEST['referraled_with']) and $_REQUEST['referraled_with']!='' and !empty($_REQUEST['referraled_with'])){
   	$referraled_with=$_REQUEST['referraled_with'];
   	$query="SELECT * FROM users WHERE referral_code='$referraled_with'";
   	$res=mysqli_query($conn,$query);
        $num=mysqli_num_rows($res);
        if($num==0){
        $response['status']=False;
   		$response['message']='Not Valid Referral code';
   		echo json_encode($response);
   		exit();
        
        }
        
   	$sl="SELECT * FROM config WHERE type='point'";
    $rs=mysqli_query($conn,$sl);
    $rows=mysqli_fetch_array($rs);
   echo  $incrment=$rows['froms'];
   	$query="UPDATE users SET points=points+'".$incrment."'  WHERE referral_code='$referraled_with'";
   	$res=mysqli_query($conn,$query);
   	if($res){
   		    $query="UPDATE users SET referraled_with='$referraled_with' WHERE id='$id'";
    $res=mysqli_query($conn,$query);
   		$response['message']='Updated';
   	}
   	else{
   		$response['status']=False;
   		$response['message']='Not Updated';
   		echo json_encode($response);
   		exit();
   	}
   }  
    $query="UPDATE users SET points='$new_point' WHERE id='$id'";
    $res=mysqli_query($conn,$query);
    if($res){
    	$query="INSERT INTO transactions (redeem_point,payment_mode,payment_info,user_id,payment_time) VALUES ('$reddemed_point','$payment_mode','$payment_info','$id',now())";
    	$res=mysqli_query($conn,$query);
    	if($res){
    		$response['status']=True;
    		$response['message']='Points Updated ';
    	}
    	else{
    		$response['status']=False;
    		$response['message']='User points updated but transaction not recored !';
    	}
    }
echo json_encode($response);

}
if(isset($_REQUEST['update_point'])){
  
  $new_point=$_REQUEST['new_point'];
  $id=$_REQUEST['user_id'];
  $query="UPDATE users SET points='$new_point' WHERE id='$id'";
  $res=mysqli_query($conn,$query);
  if($res){
  	$response['status']=True;
  	$response['message']='Points Updated';
  }
  else{
  	$response['status']=False;
  	$response['message']='Points not updated';
  }
echo json_encode($response);
}
 
?>

 <?php
include 'connect.php';
if(isset($_REQUEST['recover'])){
	$toemail=$_REQUEST['email'];
	$otp=$_REQUEST['otp'];
 $query="SELECT * FROM config WHERE type='email'";
	$res=mysqli_query($conn,$query);
	$row=mysqli_fetch_array($res);
 $fromemail=$row['froms'];
	
$subject = "Reset Password";

$message = 'Dear '.$toemail.' your password recover opt is '.$otp.' valid till 5 min';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'Reply-To: <'.$fromemail.'>' . "\r\n";
$headers .= 'From: <'.$fromemail.'>' . "\r\n";

// More headers
// $headers .= array(
//     'From' => $fromemail,
//     'Reply-To' => $fromemail
// );
$res=mysqli_query($conn,"SELECT * FROM users where email='$toemail'");
$num=mysqli_num_rows($res);
if($num>=1){

mail($toemail,$subject,$message,$headers);
	$response['status']=True;
    		$response['message']='recovery mail otp send ';
    		echo json_encode($response);

    	}
    	else{
    		$response['status']=False;
    		$response['message']='Mail not exits';
    		echo json_encode($response);
    	}
} 



?>
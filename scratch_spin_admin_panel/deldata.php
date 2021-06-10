
<?php include 'connect.php' ; 
include 'demo.php';
?>
<?php
if($demo){
if($_GET['del']=='user'){
	$loc='userlist.php';
		 echo "<script>window.location.href='userlist.php';</script>";
}
else{
$loc='listtransaction.php';
	 echo "<script>window.location.href='listtransaction.php';</script>";

}


	header("location:$loc");
	 echo "<script>window.location.href='index.php';</script>";
}
else{ 
 if(isset($_GET['del'])){
	        $id=$_GET['id'];


			if($_GET['del']=='user'){
			$query="DELETE FROM users WHERE id='$id'";
			$loc='userlist.php';
			 mysqli_query($conn,$query);
			 echo "<script>window.location.href='userlist.php';</script>";
			}
			elseif($_GET['del']=='transactions'){
				$query="DELETE FROM transactions WHERE id='$id'";
				$loc='listtransaction.php';
				 mysqli_query($conn,$query);
				 echo "<script>window.location.href='listtransaction.php';</script>";
				
			}
        mysqli_query($conn,$query);
        header("location:$loc");
        


  }
}
?>
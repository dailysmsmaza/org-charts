<?php
if(!empty($_POST["id"])) {
require_once("dbcontroller.php");
$db_handle = new DBController();
	switch($_POST["action"]){
		case "like":
			$query = "INSERT INTO like_ipaddress (ip_address,sms_id) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','" . $_POST["id"] . "')";
			$result = $db_handle->insertQuery($query);
			if(!empty($result)) {
				$query ="UPDATE message SET likes = likes + 1 WHERE id='" . $_POST["id"] . "'";
				$result = $db_handle->updateQuery($query);				
			}			
		break;		
		case "unlike":
			$query = "DELETE FROM like_ipaddress WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' and sms_id = '" . $_POST["id"] . "'";
			$result = $db_handle->deleteQuery($query);
			if(!empty($result)) {
				$query ="UPDATE message SET likes = likes - 1 WHERE id='" . $_POST["id"] . "' and likes > 0";
				$result = $db_handle->updateQuery($query);
			}
		break;		
	}
}
?>
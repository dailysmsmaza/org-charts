<?php
class DBController {

	// private $host = "localhost";
	// private $user = "root";
	// private $password = "";
	// private $database = "dailysmsmaza";
	

	private $host = "localhost";
	private $user = "hurvotmy_dsmadmin";
	private $password = "xB@U&1g&T&AU";
	private $database = "hurvotmy_dailysmsmaza";


	var $conn;

	function __construct() {
		$this->conn = $this->connectDB();
		/*if(!empty($conn)) {
			$this->selectDB($conn);
		}*/
	}
	
	function connectDB() {
		$this->conn = mysqli_connect($this->host,$this->user,$this->password, $this->database);
		return $this->conn;
	}
	
	function selectDB($conn) {
		mysql_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	
	function updateQuery($query) {
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}
	
	function insertQuery($query) {
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}
	
	function deleteQuery($query) {
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}
}
?>
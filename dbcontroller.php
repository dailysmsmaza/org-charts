<?php
class DBController
{

	public $host = "";
	public $user = "";
	public $password = "";
	public $database = "";

	public $conn;

	function __construct($CURRENT_MODE, $PRODUCTION)
	{
		

		$this->conn = $this->connectDB($CURRENT_MODE, $PRODUCTION);
		/*if(!empty($conn)) {
			$this->selectDB($conn);
		}*/
	}

	public function connectDB($CURRENT_MODE, $PRODUCTION)
	{
		if ($CURRENT_MODE == $PRODUCTION) {
			$this->host = "localhost";
			$this->user = "hurvotmy_dsmadmin";
			$this->password = "xB@U&1g&T&AU";
			$this->database = "hurvotmy_dailysmsmaza";
		} else {
			$this->host = "localhost";
			$this->user = "root";
			$this->password = "";
			$this->database = "dailysmsmaza";
		}
		$this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		return $this->conn;
	}

	function selectDB($conn)
	{
		mysql_select_db($this->database, $conn);
	}

	function runQuery($query)
	{
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if (!empty($resultset))
			return $resultset;
	}

	function numRows($query)
	{
		$result  = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}

	function updateQuery($query)
	{
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}

	function insertQuery($query)
	{
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}

	function deleteQuery($query)
	{
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			return $result;
		}
	}
}

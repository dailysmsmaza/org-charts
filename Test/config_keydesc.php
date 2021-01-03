<?Php
/////// Update your database login details here /////
$dbhost_name = "localhost"; // Your host name 
$database = "dailysms_maza";       // Your database name
$username = "dailysms_dsmuser";            // Your login userid 
$password = "RVTzHBX.D;XK";            // Your password 
//////// End of database details of your server //////

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host='.$dbhost_name.';dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
?> 
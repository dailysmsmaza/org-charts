<?php
    namespace Emojione;
 
    require('../lib/php/autoload.php');
 
    $client = new Client(new Ruleset());
 
?>

<?php

	require("connect.php");
	
	$q = mysqli_query($c,"select * from emoji");
	
	while($r = mysqli_fetch_array($q))
	{
		echo $client->shortnameToUnicode($r["name"]);
		echo "<br>";
	}


?>
<?php
		namespace Emojione;
 
		// include the PHP library (if not autoloaded)
		require('../lib/php/autoload.php');
	 
		require('connect.php');
		
		$client = new Client(new Ruleset());

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
  <meta charset="UTF-8">
  <title>Emojione-area by mervick</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' type='text/css' href='../dist/open_sans.css'>
  <link rel="stylesheet" type="text/css" href="../dist/normalize.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../dist/emojione.sprites.css" media="screen">
  
  <link rel="stylesheet" type="text/css" href="../dist/emojionearea.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../dist/font-awesome.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../dist/tomorrow.css" media="screen">
  <script type="text/javascript" src="../dist/jquery.min.js"></script>
  
  <script type="text/javascript" src="../dist/prettify.js"></script>
  <script type="text/javascript" src="../dist/emojionearea.js"></script>

</head>
<body>


 
        <form method="post"> 
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
		<textarea id="demo2" name="demo"></textarea>
		<input type="submit" value="ok">
		</form>
    

  <script type="text/javascript">
    $(document).ready(function() {
      $("#demo2").emojioneArea({
        hideSource: true,
        useSprite: true
      });
    });
  </script>


</body>
</html>

<?php
	
	if(isset($_POST["demo"]))
	{
	 
		if(isset($_POST['demo'])) {
		 $dt = $client->toShort($_POST['demo']);
		}

		$q = mysqli_query($c,"insert into emoji (name) values('$dt')");
		
	}
?>

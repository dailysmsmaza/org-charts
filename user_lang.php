<?php

	include_once("names.php");
	include_once("connect.php");

	$ip_address = $_SERVER['REMOTE_ADDR'];
	
?>

<html>
<head>

<link rel="stylesheet" href="bootstrap/bootstrap.min.css">

<script src="bootstrap/jquery.min.js"></script>

<script>
$(document).ready(function()
{
	$(function()
	{
 
		// add multiple select / deselect functionality
		$("#selectall").click(function () {
			  $('.case').attr('checked', this.checked);
		});
	 
		// if all checkbox are selected, check the selectall checkbox
		// and viceversa
		
		$(".case").click(function()
		{
	 
			if($(".case").length == $(".case:checked").length) 
			{
				$("#selectall").attr("checked", "checked");
			} else 
			{
				$("#selectall").removeAttr("checked");
			}
	 
		});
	});
	
	$('#submit').click(function()
	{
		var lang = [];
			
		$('.case').each(function()
		{
			if($(this).is(":checked"))
			{
					lang.push($(this).val());
			}
		});

		lang = lang.toString();
			
		$.ajax(
		{
			url: "add_lang.php",
			method: "POST",
			data: {insert:lang},
			success:function(data)
			{
				window.location.reload(true);
			}
		});
	});	
	
});
</script>

</head>

<body>
		
		<?php

		$ip_address_get = mysqli_query($c,"select * from lang_ipaddress where ip_address='".$ip_address."'");
		$ip_address_count = mysqli_num_rows($ip_address_get);
		
		while($ip_address_data = mysqli_fetch_array($ip_address_get))
		{
			$ip_lang_name = $ip_address_data["lang_name"];
			
			if($ip_lang_name=="English")
			{
				$english = $ip_lang_name;
			}
			else if($ip_lang_name=="Hindi")
			{
				$hindi = $ip_lang_name;
			}
			else if($ip_lang_name=="Gujarati")
			{
				$gujarati = $ip_lang_name;
			}
			else
			{
				continue;
			}
		}
		
		?>
		
		<ul class="w3-ul w3-card-4">
                  <li class="w3-cyan"> <center> Choose Language </center> </li>
        </ul>
		
		<div class="list-group">
			<ul> </ul>
			<ul class="w3-ul w3-card-4">
					
				<li> 
					<input type="checkbox" class="case" value="English" <?php if($english=="English") { echo "checked"; } ?> > 
					<label> English </label>	
				</li>
			
				<li> 
					<input type="checkbox" class="case" value="Hindi" <?php if($hindi=="Hindi") { echo "checked"; } ?> > 
					<label> Hindi </label>	
				</li>
				
				<li> 
					<input type="checkbox" class="case" value="Gujarati" <?php if($gujarati=="Gujarati") { echo "checked"; } ?> > 
					<label> Gujarati </label>	
				</li>
			
				<li>
					<input type="checkbox" id="selectall"> All
				</li>
				
				<li>
				</li>
				
				<li>
					<center> <button type="button" class="btn btn-success btn-sm" name="submit" id="submit"> Save </button> </center>
				</li>
			</ul>
		</div>
</body>

</html>
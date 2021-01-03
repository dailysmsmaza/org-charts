<?php
	include_once("names.php");
	include_once("connect.php");

	$ip_address = $_SERVER['REMOTE_ADDR'];
	
?>

<html>
<head>


  	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">

<script>
$(document).ready(function()
{
	$(function(){
 
    // add multiple select / deselect functionality
		$("#selectall").click(function () {
			  $('.case').attr('checked', this.checked);
		});
	 
		// if all checkbox are selected, check the selectall checkbox
		// and viceversa
		$(".case").click(function(){
	 
			if($(".case").length == $(".case:checked").length) {
				$("#selectall").attr("checked", "checked");
			} else {
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
			
			while($ip_langdata = mysqli_fetch_array($ip_address_get))
			{
					$langName = $ip_langdata["lang_name"];
					
					if($langName=="English")
					{
						echo $English = $langName;
					}
					else if($langName=="Hindi")
					{
						echo $Hindi = $langName;
					}
					else if($langName=="Gujarati")
					{
						echo $Gujarati = $langName;
					}
					else
					{
						continue;
					}
			}
		?>
		
		<div class="visible-sm visible-xs">
		 
		 <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#smsby">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                        <a class="navbar-brand"> Choose Language :  </a>
                </div>   
                <div>  
                <div class="collapse navbar-collapse" id="smsby">
                    <ul class="nav navbar-nav navbar-right">
                       
						<li> 
							<input type="checkbox" class="case" name="case" value="English" <?php if($English=="English") { echo "checked"; } ?>> 
							<label> English </label>	
						</li>						
						
						<li> 
							<input type="checkbox" class="case" name="case" value="Hindi" <?php if($Hindi=="Hindi") { echo "checked"; } ?> > <label> Hindi </label> 
						</li>
						
						<li> 
							<input type="checkbox" class="case" name="case" value="Gujarati" <?php if($Gujarati=="Gujarati") { echo "checked"; } ?>> 
							<label> Gujarati </label> 
						</li>
						
						<li> 
							<input type="checkbox" id="selectall"/> 
							<label> All </label> 
						</li>
											
						<button type="button" class="btn btn-success btn-sm" name="submit" id="submit"> Save </button>

                      						
                    </ul>
                 </div>
                </div>
			</div>      
        </nav>
	</div>	
	
</body>

</html>
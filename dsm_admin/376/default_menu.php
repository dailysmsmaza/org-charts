<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
if(isset($_SESSION["username"]))
{
	include("header.php");
	include("connect.php");
	
?>

<html>
<head>

	<link rel="stylesheet" type="text/css" href="style.css" />
        
	<script type="text/javascript">
		
		function edit_menu(id)
		{
			window.location = "edit_menu.php?id="+id;
		}
	</script>
    
</head>
<body>
<div class="path">
	<span class="title">
    	Updates
    </span>
</div>

<div class="mainContent">

<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
    <tr>
     </tr>
     <tr>
		<td colspan="1">
		 <table cellpadding="0" cellpadding="1" border="0" width="100%" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
     		<tr>
            	<th class="subtitle" align="center" width="10%">ID</th>
				<th class="subtitle" align="center" width="70%">Name</th>
                <th class="subtitle" align="center" width="10%"> Default </th>
				<th class="subtitle" align="center" colspan="1" width="10%">Action</th>
			</tr>
              <tr><td colspan="8" class="borderbottom"></td></tr>
              
        	<?php
		 	$default = mysqli_query($c,"select * from default_id");
             while($default_data = mysqli_fetch_array($default))
			 {
				 $default_id = $default_data["id"];
				 $default_name = $default_data["name"];
				 $default_pid = $default_data["pid"];
			?>
            
            <tr class="detail">
            	<td align="center" style="word-wrap:break-word;"> <?=$default_id?> </td>
         		 <td align="center" style="word-wrap:break-word;"> <?=$default_name?> </td>
                 <td align="center" style="word-wrap:break-word;"> <?=$default_pid?> </td>
                 <td align="center" style="word-wrap:break-word;">
                    	<img src="images/edit.png" align="absmiddle" class="action" onClick="edit_menu(<?=$default_id?>)"/>
						&nbsp;&nbsp;
               </td>
              </tr>
            <?php
			 }
			?>
          </table>
         </td>
       </tr>
</table>
</div>
</body>
</html>

<?php
	include("footer.php");
}
else
{
	header("location:".$url);
}
?>
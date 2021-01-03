<?php
	ob_end_flush();
	ob_start();
	session_start();
if(isset($_SESSION['username']))
{
	include("header.php");
	include("connect.php");
	include("names.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Advertise :: My Songs </title>
<link rel="stylesheet" type="text/css" href="style.css">
<script>
function show(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("filedata").innerHTML=xmlhttp.responseText;
    }
  }
    xmlhttp.open('POST', 'gettext.php');
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("filename=" + str);

}

</script>
</head>

<body>

<div id="mainContent" >
<form method="post" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
				
					<tr>
							<td class="field" width="150" valign="top"><strong>File Name<span class="sep">:</span></strong></td>
							<td class="field" >
								<select name="filename" onchange="show(this.value);">
                                
									<option> Select File </option>
								
                                	<option value="m_top">m_top</option>
									<option value="m_bottom">m_bottom</option>
									<option value="m_betweenfile">m_betweenfile</option>		
									<option value="p_top">p_top</option>
									<option value="p_bottom">p_bottom</option>
									<option value="p_betweenfile">p_betweenfile</option>
							
								</select>
								
							</td>
					</tr>
					<tr>
							<td class="field" width="150" valign="top"><strong>File Data<span class="sep">:</span></strong></td>
							<td class="field" ><textarea rows="20" cols="80" id="filedata" name="filedata"></textarea></td>
					</tr>
					<td  colspan="2" class="subtitle1" style="padding-left:150px;">
                    <input type="submit" name="submit" style="width:110px"  class="medium green awesome" value="Save" />&nbsp;
					<input type="reset" name="Reset" style="width:110px"  class="medium green awesome" value="Reset" />
                    </td>
                     </tr>
</table>
</form>
</div>
</body>
</html>

<?php

	if(isset($_POST["submit"]) && $_POST["filename"]!="Select File")
	{
		$filename = $_POST["filename"];
		$fopen = fopen("../../advertise/".$_POST["filename"].".php","w+");
		$filedata = $_POST["filedata"];
		$fwrite = fwrite($fopen,$filedata);
		$ad_in = mysqli_query($c,"update advertise set file_description='$filedata' where file_name='$filename'");
		fclose($fopen);
	}


	include("footer.php");
}
else
{
	header("location:$url");
}

?>
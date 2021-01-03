<html>

<head>

	<link href="<?php echo base_url('css/admin/style.css'); ?>" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
	<title> Add Category :: <?= TITLE ?> : Admin Panel </title>


</head>

<?php

?>

<body>

	<div id="mainContent">
		<form name="f1" method="post">
			<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
				<tr>
					<td class="subtitle" colspan="5">Add Auth Key</td>
				</tr>
				<tr>
					<td class="field" width="150" valign="top"><strong>Auth Key<span class="sep">:</span></strong></td>
					<td class="field" colspan="1"><textarea name="auth_key" cols="50" rows="6"></textarea></td>
				</tr>
				<tr>
					<td class="subtitle1" style="padding-left:150px;" colspan="2">
						<input type="submit" class="medium green awesome" style="width:110px" name='save' value="Save" />
					</td>
				</tr>
			</table>
		</form>
	</div>

	</div>

</body>

</html>

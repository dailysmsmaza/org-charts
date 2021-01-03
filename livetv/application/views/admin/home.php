<html>
<head>

	<script src="jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="jquery.tablednd_0_5.js" type="text/javascript"></script>
	<script src="core.js" type="text/javascript"></script>

	<link href="<?php echo base_url('css/admin/style.css'); ?>" rel="stylesheet">

	<meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">

	<script>
		function add_auth_key() {
			window.location = "<?php echo base_url(); ?>admin/main/add_auth_key";
		}
	</script>

</head>

<body>



	<!-- start #mainContent -->
	<div id="mainContent">
		<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">

			<tr>
				<td class="subtitle1" colspan="1" align=''>

					<input type="button" value="Add New Auth Key" onClick="add_auth_key()">

				</td>
			</tr>

			<tr>
				<td colspan=1>
					<table cellpadding="0" cellspacing="1" border="0" width="100%" id="" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">


						<tr>
							<th class="subtitle" align="center" width="5%">&nbsp;ID</th>
							<th class="subtitle" align="center" width="70%">&nbsp;Auth Key</th>
							<th class="subtitle" align="center" width="10%">&nbsp;Date Time</th>
							<th class="subtitle" align="center" colspan="1" width="15%">&nbsp;Action</th>
						</tr>
						<tr>
							<td colspan="8" class="borderbottom"></td>
						</tr>
						<tbody>

							<?php
							foreach ($data as $row) {
							?>
								<tr id="order_<?php echo $row->id; ?>" class="detail">

									<td align="center" style="word-wrap:break-word;"> <?php echo $row->id; ?>
									</td>

									<td style="word-wrap:break-word;">
										<?php echo $row->auth_key; ?>
									</td>
									<td align="center" style="word-wrap:break-word;">
										<?php echo $row->date_time; ?>
									</td>
									<td style="word-wrap:break-word;">

									</td>
								</tr>
							<?php
							}
							?>

						</tbody>
					</table>

	</div>
	</div>
</body>

</html>
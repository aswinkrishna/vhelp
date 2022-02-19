<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
	<?php

	$profileImage    =   $result->user_image!=""?base_url()."uploads/user/".$result->user_image:base_url()."images/placeholder.jpg";   

	if (strpos($result->user_dial_code, '+') === false)
		$result->user_dial_code = "+".$result->user_dial_code;
	?>
	<tr>
		<td style="width: 253px;">Staff Name</td>
		<td><?php echo $result->user_first_name?> <?php echo $result->user_last_name?></td>
		<td rowspan="2"><img src="<?php echo $profileImage;?>" class="profileIcon" style="width:100px !important;height:100px !important" width="100px" height="100px"></td>
	</tr>

	<tr>
		<td>Email</td>
		<td><?php echo $result->user_email?></td>
	</tr>
	<tr>
		<td>Mobile</td>
		<td colspan="2"><?php echo $result->user_dial_code?> <?php echo $result->user_phone?></td>
	</tr>
	<tr>
		<td>Country</td>
		<td colspan="2"><?php echo $result->country_name?> </td>
	</tr>
	<tr>
		<td>Emirates ID</td>
		<td colspan="2"><?php echo $result->emirates_id?> </td>
	</tr>
	<tr>
		<td>Passport ID</td>
		<td colspan="2"><?php echo $result->passport_id?> </td>
	</tr>
<table>
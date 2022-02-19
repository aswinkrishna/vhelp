

<?php
   	if(isset($result) && count($result)>0){
   		foreach($result as $key=> $rows){
   			$image = 'uploads/user/'.$rows->user_image;
   			if(file_exists($image) && is_file($image))
   				$image = base_url().$image;
   			else
   				$image = base_url().'images/user_dummy.png';
   			$name = $rows->user_first_name.' '.$rows->user_last_name;

   			$checked = $rows->user_status == 1 ? "checked" : "";
		?>
				<tr>
					<td><?=$key+1?></td>
					<td><img src="<?=$image?>" style="height: 80px;"></td>
					<td><?=$name?></td>
					<td><?=$rows->country_name?></td>
					<td><?=$rows->user_dial_code.' '.$rows->user_phone?></td>
					<td><?=$rows->user_email?></td>
					<td>
						<label class="switch">
	                        <input type="checkbox" <?=$checked?> data-role="active-switch" data-href="<?=base_url()?>website/User/updateUserStatus/<?=$rows->user_id?>">
	                        <span class="slider round"></span>
	                    </label>
					</td>
					<td>
						<!-- <a class="remove" href="#"  data-toggle="modal" data-target="#confirm-modal">
                            <i class="fa fa-trash-o removeThis" for="<?php echo $rows->user_id ?>"></i>
                        </a> -->
                        <a class="edit" href="#" onclick="addEditForm(<?=$rows->user_id?>);"><i class="fa fa-pencil" i></i></a>
                        <a class="edit" href="#" onclick="deleteStaff(<?=$rows->user_id?>);"><i class="fa fa-trash" i></i></a>
					</td>
				</tr>
			<?php

   		}

   	if(isset($links) && $links!=""){
?>
	<tr class="ash-bg-light">
		<td class="bable_title" colspan="7">
			<?php   echo $links;?>  
		</td>
	</tr>
<?php
   	}
   	
  }else{
?>  
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan=4>
            No record found...
        </td>
        
    </tr>
<?php
  }
?>


<script type="text/javascript">
	
	$('body').off('change', '[data-role="active-switch"]');
        $('body').on('change', '[data-role="active-switch"]', function(e) {
            var $this = $(this);
            var status = $this.is(':checked') == 1 ? 1 : 0;
            // alert(status);
            $.post($this.data('href'), {
                'status': status
            }, function(res) {
                if ( res['status'] == 1 ) {
            } else {
                showToast([[ res['message'], 'error' ]]);
            }
        });
    });
</script>
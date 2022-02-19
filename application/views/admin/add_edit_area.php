<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-edit"></i> Area</h1>
		</div>
	</div>
	<?php

	$label = "registration";
	$saveButtonName  = "Add";

	if($id>0)
	{
		$label = "Updation";
		$saveButtonName  = "Update";

		$englishName   =   $records1->area_name;
		$arabicName    =   $records2->area_name;
		$countryId     =   $records1->country_id;
		$cityId        =   $records1->city_id;
		$status        =   $records1->area_status;
	}
	else
	{
		$englishName   =   "";
		$arabicName    =   "";
		$countryId     =   "";
		$status        =   "1";
	}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<h3 class="tile-title"><?=$saveButtonName?> Area</h3>
				<div class="tile-body">
					<form name="item"  id="cityForm" method="post" enctype="multipart/form-data" autocomplete="off">
						<?php if($id>0) { ?>
							<input type="hidden" class="form-control boxed" placeholder="" name="area_id" value="<?php echo $id; ?>"> 
						<?php } ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">City <?=$records1->area_name?></label>
									<select class="c-select form-control boxed" name="city_id">
										<option value="">Select</option>
										<?php
										if(isset($city_list) && count($city_list)>0)
										{
											foreach($city_list as $rows) 
											{
												?>
												<option value="<?php echo $rows->city_id; ?>" <?php  if($cityId==$rows->city_id){ echo "selected" ;} ?> ><?php echo $rows->city_name; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div> 
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Status</label>
									<select class="c-select form-control boxed controll-wdth" name="txtStatus">

										<option value="1" <?php echo ($status==1?"selected":"");  ?>>Active</option>
										<option value="0" <?php echo ($status==0?"selected":"");  ?>>Inactive</option>

									</select>
								</div> 
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Area Name English</label>
									<input type="text" class="form-control boxed" placeholder="" name="txtEnglish" value="<?php echo $englishName; ?>" maxlength="40">
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Area Name Arabic</label>
									<input type="text" class="form-control boxed" placeholder="" name="txtArabic" value="<?php echo $arabicName; ?>" maxlength="40"> 
								</div> 
							</div>
							
						</div>

					</form>
				</div>
				<div class="tile-footer">
					<button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					<span id="registerLoader"></span>
				</div>
			</div>
		</div>


	</div>
</main>
<script>
	$(document).delegate("#btnRegister","click",function(e){
		$("#cityForm").submit();
	});

	var validator=$("#cityForm").validate({
		ignore: [],
		onfocusout: false,
		onkeyup :false,
		onclick :false,
		onchange :false,
		rules: 
		{
			city_id:
			{
				required: true
			},
			txtEnglish: 
			{
				required: true,
				maxlength:100,
				lettersonly:true,

			},
			txtArabic: 
			{
				required: true,
				maxlength:100,
			}

		},
		messages: 
		{
		},
		submitHandler: function ()
		{
			$(".errorSpan1").html("");	               
			$("#btnRegister").attr("disabled", "disabled");
			$("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");

			dataString = $('#cityForm').serialize();
			var formData = new FormData($("#cityForm")[0]);
			csrf_value  =   getCookie('csrf_cookie_name');        
			formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);

			$.ajax({
				url: '<?php echo base_url();?>admin/C_admin/saveArea',
				type: 'POST',
				data: formData,
				async: true,
				success: function (data) 
				{
					$("#registerLoader").html("");
					$('#btnRegister').prop("disabled", false);
					data =  jQuery.parseJSON(data);

                   if(data['status']==1)
                   {
                         $(".error").html("");
                         swal("Well done!", "Saved Successfully!", "success");
                         window.location= "<?php echo base_url();?>admin/area_list";  
                     }
                     else if(data['status']==0)
                     {
                     	if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value)
                            {
                                $('[name='+key+']').parents('.form-group').find('.error').html(value);
                            });                          
                        }
                        else
                        {    
                        	swal("Sorry!", "Failed to save! Try again later", "error");
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

			return false;
		}
	});  
</script>


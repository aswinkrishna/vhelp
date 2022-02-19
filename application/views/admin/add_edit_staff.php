<style type="text/css">
	#displayPassword
	{
		position: absolute;
		margin: 40px 0px 0px 410px;
		cursor: pointer;
	}
</style>
<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-edit"></i> Staff</h1>
		</div>
	</div>
	<?php

	$label = "registration";
	$saveButtonName  = "Add";
	if($id>0)
	{
		$label = "Updation";
		$saveButtonName  = "Update";
	}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<h3 class="tile-title">Staff <?php  echo $label; ?></h3>
				<div class="tile-body">
					<form name="item"  id="userForm" method="post" enctype="multipart/form-data" autocomplete="off">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">First Name</label>
									<input class="form-control" type="text" placeholder="Enter first name" maxlength="40" id="fname"  name="fname"  value="<?php echo $row->user_first_name!=''?$row->user_first_name:'' ?>" >
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Last Name</label>
									<input class="form-control" type="text" placeholder="Enter last name" maxlength="40" id="lname"  name="lname"  value="<?php echo $row->user_last_name!=''?$row->user_last_name:'' ?>">
								</div> 
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Email id</label>
									<input class="form-control" type="text" placeholder="Enter email id" maxlength="40" id="email" name="email"  <?php echo $id>0?'readonly':'' ?>  value="<?php echo $row->user_email!=''?$row->user_email:'' ?>">
								</div> 
							</div>
							
							<input type="hidden" value="<?php echo ($id > 0) ? 0 : 1; ?>" name="save_password" id="save_password">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Password</label>
									<?php if($id): ?>
										<span style="cursor: pointer;float: right;font-weight: bold;" class="changePassword">Change Password</span>
									<?php endif; ?>
									<?php $display = ($id==0 ? '' : 'none'); ?>
									<i class="fa fa-eye" id="displayPassword" style="display: <?=$display?>"></i>
									<input class="form-control" type="password" placeholder="Enter password" maxlength="20" id="staff_password" name="staff_password" value="<?php echo $row->user_password!=''?'00#sd123s':'' ?>">
								</div> 
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Passport ID</label>
									<input class="form-control" type="text" placeholder="Enter passport id" maxlength="40" id="passport_id" name="passport_id" value="<?php echo $row->passport_id!=''?$row->passport_id:'' ?>">
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Emirates ID</label>
									<input class="form-control" type="text" placeholder="Enter password" maxlength="20" id="emirates_id" name="emirates_id" value="<?php echo $row->emirates_id!='' ? $row->emirates_id :'' ?>">
								</div> 
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Country</label>
									<select class="form-control"  id="country_id"  name="country_id">
										<option value="">Select</option>
										<?php
										if(count($country_list)>0)
										{
											foreach($country_list as $rows)
											{
												?>
												<option value="<?php  echo $rows->country_id ?>" data-foo="<?php echo $rows->country_dial_code; ?>"  <?php echo $row->country_id==$rows->country_id?'selected':'' ?>><?php  echo $rows->country_name ?></option>
												<?php
											}
										}
										?>

									</select>
								</div> 
							</div>
							<input type="hidden" value="0" name="select_city" id="select_city">
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Dial code</label>
									<input class="form-control" type="text" placeholder="Dial code" maxlength="5"  id="dial_code" name="dial_code" readonly value="<?php echo $row->user_dial_code!=''?$row->user_dial_code:'' ?>">
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Phone</label>
									<input class="form-control" type="text" placeholder="Enter phone number" maxlength="10"  id="phone_no" name="phone_no" value="<?php echo $row->user_phone!=''?$row->user_phone:'' ?>">
								</div> 
							</div> 
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Profile picture (Accepts .jpg, .jpeg & .png only)</label>
									<input class="form-control" type="file" accept=".jpg, .png, .jpeg" id="image" name="image">
									<p>Recommended size is 250 x 250 px</p>
								</div> 
							</div>
							<div class="col-md-3">
								<div class="form-group">

									<img src="<?php echo $row->user_image!=""?base_url().'uploads/user/'.$row->user_image:base_url().'images/placeholder.jpg' ;?>"  class="previewImage" id="imagePreview">
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

	$(document).delegate("#btnRegister","click",function(e)
	{
		$("#userForm").submit();
	});
	$(document).delegate("#cancelBtn","click",function(e)
	{
		alert();
		$("#userForm")[0].reset();
	});

	var validator=$("#userForm").validate(
			//alert();
			{
				ignore: [],
				rules: 
				{

					fname: 
					{
						required: true,
						maxlength:100,
						lettersonly:true,

					},
					lname: 
					{
						required: true,
						maxlength:100,
						lettersonly:true,
					},
					email: 
					{
						required: true,
						email: true,
						maxlength:100,
					},   
					country_id: 
					{
						required: true,
						number:true
					},
					emirates_id: 
					{
						required: true
					},
					passport_id: 
					{
						required: true
					},
					staff_password: 
					{
						required: true,
						minlength: 8,
						maxlength:20 ,
						passwordCheck:true
					},
					'phone_no': 
					{
						required: true,
						minlength: 5,
						maxlength:10,
						number:true
					},
				},
				messages: 
				{
					txt_password: 
					{
						passwordCheck:'Password field must contain atleast one letter , number and special character'
					},
				},
				submitHandler: function ()
				{
					$(".errorSpan1").html("");                 
					$("#btnRegister").attr("disabled", "disabled");
					$("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");   
					$(".errorSpan1").html();
					dataString = $('#userForm').serialize();
					var formData = new FormData($("#userForm")[0]);
					csrf_value  =   getCookie('csrf_cookie_name');        
					formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);

					$.ajax({
						url: '<?php echo base_url();?>admin/C_admin/saveStaff',
						type: 'POST',
						data: formData,
						async: true,
						success: function (data) 
						{

							$("#registerLoader").html("");
							$('#btnRegister').prop("disabled", false);
							data =  jQuery.parseJSON(data);
							console.log(data['status']);


							if(data['status']==1)
							{
								var url = '<?php echo base_url("staffs-list/").$this->common_functions->encryptId($provider_id) ?>';
								swal("Well done!", "Saved Successfully!", "success");
								window.location.href=url;

							}
							else if(data['status']==3)
							{
								swal("Sorry!", "Email id already exists", "error");
							}
							else if(data['status']==0)
							{
								if(data['errors'] !== ""){
									$.each(data['errors'], function(key, value) {console.log(key); console.log(value);
								//$('input[name='+key+']').addClass('is-invalid');

								$( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

							});                          
								}else{    
									swal("Sorry!", "Failed to save! Try again later", "error");
								}


							}
							else
							{

								swal("Sorry!", "Failed to save! Try again later", "error");


							}



						},
						cache: false,
						contentType: false,
						processData: false
					});

					return false;


				}

			});  
	$(document).delegate("#country_id","change",function(e)
	{

		var selected = $(this).find('option:selected');
		var dialCode = selected.data('foo'); 
		$("#dial_code").val(dialCode);
		csrf_value  =   getCookie('csrf_cookie_name');        

		$.ajax({
			url: '<?php echo base_url();?>admin/C_admin/loadCityDropDown',
			type: 'POST',
			data: {countryId:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
			success: function (data) 
			{

				$("#select_city").html(data);

			}
		});

	});
	$("#image").change(function() {
	    var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#image").val('');
            swal('Error','You are trying to upload an invalid file format','error');
            return false;
        }
		readURL(this,'imagePreview');
	});

	$('#displayPassword').click(function(){
		var myClass = $(this).attr('class');
		if(myClass=='fa fa-eye'){
			$(this).attr('class','fa fa-eye-slash');
			$('#staff_password').attr('type','text');
		}
		else{
			$(this).attr('class','fa fa-eye');
			$('#staff_password').attr('type','password');
		}
	});

	$('input#user_phone').keypress(function(e){
		if(this.value.length < 2 && e.which == 48)
		{
			return false;
		}
	});

	$('.changePassword').click(function(){
		$('input#save_password').val(1);
		$('input#staff_password').val('');
		$('input#staff_password').attr('readonly',false);
		$('#displayPassword').show();
	});
</script>


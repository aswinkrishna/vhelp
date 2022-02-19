<style type="text/css">
	.error{
		color: red;
	}
</style>

<?php
	if($user_details){
		$readonly   = "readonly";
		$heading    = "Edit";
		$id 		= $user_details->user_id;
		$fname 		= $user_details->user_first_name;
		$lname 		= $user_details->user_last_name;
		$country	= $user_details->country_id;
		$dialcode	= $user_details->user_dial_code;
		$mob		= $user_details->user_phone;
		$email		= $user_details->user_email;
		$emirates_id= $user_details->emirates_id;
		$passport_id = $user_details->passport_id;
		$image 		= 'uploads/user/'.$user_details->user_image;
		if(file_exists($image) && is_file($image))
			$image = base_url().$image;
		else
			$image = base_url().'images/user_dummy.png';
	}else{
		$readonly   = "";
		$heading    = 'Add';
		$id 		= '';
		$fname 		= '';
		$lname 		= '';
		$country	= '';
		$dialcode	= '';
		$mob		= '';
		$email		= '';
		$emrites_id = '';
		$passports_id = '';
		$image = base_url().'images/user_dummy.png';
	}
	
	// print_r($country);

    $attributes = array('method' => 'post', 'id' => 'staff_form', 'name' => 'staff-form', 'autocomplete' => 'off');
    echo form_open_multipart(site_url('user/save'), $attributes);
?>
	
	<div class="row">
        <div class="col-lg-5">
            <div class="align-items-baseline">
                <h3 class="text-dark mb-3">
                	<?=$heading?> Staff
                </h3>
                <button type="submit" class="btn btn-sm btn-primary" id="saveStaff">SAVE</button>
                <input type="hidden" name="id" value="<?php echo $id ?>" />
			</div>
        </div>
	</div>

	<div class="row mt-4" >
        <div class="col-12">
            <div class="card p-4">
                <div class="card-body" style="background-color:#0231;">

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>First Name</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="text" name="fname" id="fname" value="<?=$fname?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Last Name</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="text" name="lname" id="lname" value="<?=$lname?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Email</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="text" name="email" id="email" value="<?=$email?>" <?=$readonly?> class="form-control">
                    		<span class="error errorSpan1"></span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Password</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="password" name="staff_password" id="staff_password" value="" class="form-control" maxlength="24">
                    		<a href="#" id="changePassword" style="color:red;">Change password</a>
                    		<span class="error errorSpan1"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Country</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<select id="country_id" name="country_id">
                    			<option value="">Choose country</option>
	                    		<?php
	                    			foreach ($country_list as $key => $value) {
	                    				if($value->country_id == $country)
	                    					$selected = "selected";
	                    				else
	                    					$selected = "";
	                    		?>
	                    			<option value="<?=$value->country_id?>" <?=$selected?> data-foo="<?=$value->country_dial_code?>" ><?=$value->country_name?></option>
	                    		<?php
	                    			}
	                    		?>
                    		</select>
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Phone Number</label>
                        </div>
                    	<div class="col-lg-2 col-md-2 col-2">
                    		<input type="text" name="dial_code" readonly value="<?=$dialcode?>" id="dial_code" class="form-control">
                        </div>
                        <div class="col-lg-4">
                        	<input type="text" name="phone_no" value="<?=$mob?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Emirates ID</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="text" name="emirates_id" id="emirates_id" value="<?=$emirates_id?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Passport ID</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="text" name="passport_id" id="passport_id" value="<?=$passport_id?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label></label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<img src="<?=$image?>" style="width:100px;">
                        </div>
                    </div>

					<div class="form-group row">
                    	<div class="col-lg-2 col-md-6 col-12">
                            <label>Image</label>
                        </div>
                    	<div class="col-lg-6 col-md-6 col-12">
                    		<input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>                    

                </div>
            </div>
        </div>
    </div>


<?php echo form_close(); ?>

<script type="text/javascript">

    $(document).ready(function(){
       var id = '<?=$id?>';
       if(id){
           $('#staff_password').hide();
           $('#changePassword').show();
       }else{
           $('#staff_password').show();
           $('#changePassword').hide();
       }
    });
    
    $('#changePassword').click(function(){
        $('#staff_password').show();
        $('#changePassword').hide();
    });

	// $(document).delegate("#saveStaff","click",function(e){
    	
 //    	$("#staff_form").submit();  
 //  	});

  	var validator = $('#staff_form').validate({
    	ignore: [],
    	rules:{
	      	fname : {
	        	required :true,
	      	},
	      	lname : {
	      		required :true,
	      	},
	      	email : {
	      		required : true,
	      		email: true,
                maxlength: 100,
	      	},
	      	<?php
	      	    if(!$id){
	      	?>
	      	staff_password : {
	      		required : true,
                maxlength: 24,
	      	},
	      	
	      	<?php
	      	    }
	      	?>
	      	
	      	country_id : {
	      		// required : true,
	      	},
	      	phone_no :{
	      		required : true,
	      		number: true,
                minlength: 5,
                maxlength: 10
	      	},
	      	emirates_id : {
	      		required :true,
	      	},
	      	passport_id : {
	      		required : true,
	      	}

	    },

    	messages: {
    
    	},
    	submitHandler: function (){
    		// alert('hai');
    		// profile_image = $('#image').get(0).files[0];
    		var formData = new FormData($("#staff_form")[0]);
    		// formData.append("profile_image", profile_image);

    		$.ajax({
    			url : "<?=base_url()?>website/User/saveStaffData",
    			type: 'POST',
             	data: formData,
             	async: false,
             	success: function (data) {
             		$(".errorSpan1").html("");
                    data =  jQuery.parseJSON(data);

                    if(data['status']==1){
                        swal(data['message']);
                        setTimeout($('#staff').trigger('click'), 5000);
                    }else{
                         
                        if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {
                                 $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
                            });                               
                        }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                        }
                    }
             	},

             	cache: false,
             	contentType: false,
             	processData: false
    		});

      		return false;
    	},
  	});
    
    $('#country_id').change(function(e){
        var selected = $(this).find('option:selected');
        var dialCode = '+'+selected.data('foo');
        $("#dial_code").val(dialCode);
    });

</script>
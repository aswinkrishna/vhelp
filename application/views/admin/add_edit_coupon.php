<?php
	
  $id              =  $this->uri->segment(3);

  $coupon_title 		= "";
  $coupon_code 			= "";
  $description			= "";
  $amount				= "";
  $individual_use_only  = "";
  $expiry_date			= "";

  $usage_limit_per_coupon = "";
  $usage_limit_per_user   = "";
  $minimum_spend  		= "";
  $maximum_spend 		= "";

  $label = "registration";
  $saveButtonName  = "Add";

  if($id>0)
  {
      $heading      	=     "Edit ";
      $saveButtonName 	=   "Update";

	  $records1                    =   $this->M_admin->getCoupon($id);
	  
	  if($records1) {

		$coupon_title 			= $records1->coupon_title;
		$coupon_code 			= $records1->coupon_code;
		$description			= $records1->coupon_description	;
		$amount					= $records1->coupon_amount	;
		$individual_use_only  	= $records1->individual_use	;
		$expiry_date			= date('Y-m-d',strtotime($records1->coupon_end_date));
	  
		$usage_limit_per_coupon = $records1->coupon_usage_percoupon	;
		$usage_limit_per_user   = $records1->coupon_usage_peruser	;

		$minimum_spend  		= $records1->coupon_minimum_spend;
  		$maximum_spend 			= $records1->coupon_maximum_spend;

	  }
	  else {
		$heading      =     "Add new ";
		$id = 0;
	  }
	  	


     // print_r($records1);
      
  }
  else
  {
      $heading      =     "Add new ";
      $englishName                 =   "";
      $arabicName                  =   "";
      $countryId                    =   "";
      $status                      =   "1";

  }

?>


<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-edit"></i> Coupon</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<h3 class="tile-title"><?=$saveButtonName?> Coupon</h3>
				<div class="tile-body">
					

					<form role="form" method="post" enctype="multipart/form-data" id="basicDetails" action="<?php echo base_url(); ?>admin/C_admin/saveCoupon">

			
           					 <input type="hidden" class="form-control boxed" placeholder="" name="id" value="<?php echo $id; ?>"> 

								<div class="form-group row">
									<div class="col-sm-12">

										<div class="row">

											<div class="col-md-6">
												<label class="control-label">Coupon Code</label>
												<input class="form-control class_mandatory" id="txt_code" value="<?php echo $coupon_code ?>"  name="txt_code" type="text" maxlength="40">
												<div class="error"></div>
											</div>

											<div class="col-md-6 priceTab">
												<label class="control-label">Coupon Amount (%)</label>
												<input class="form-control number class_mandatory" id="txt_coupon_amount" value="<?php echo $amount ?>"  name="txt_coupon_amount" type="text" maxlength="2">
												<div class="error"></div>
											</div>

											<div class="col-md-6">
												<label class="control-label">Title</label>
												<input class="form-control class_mandatory" id="txt_title" value="<?php echo $coupon_title ?>"  name="txt_title" type="text" maxlength="40">
												<div class="error"></div>
											</div>

											<div class="col-md-6">
												<label class="control-label"> Description</label>
												<span id="short_span" class="error"></span>
												<input class="form-control class_mandatory" name="txt_coupon_desc" id="txt_coupon_desc" value="<?php echo $description ?>" maxlength="150">
												<div class="error"></div>
											</div>											

											<div class="col-md-6" style="display:none">
												<label class="control-label">Discount Type</label>
												<select class="form-control" name="txt_discount_type"  >
													<option value="1">Reedem Points</option>
												</select>
												<div class="error"></div>
											</div>											

											<div class="col-md-6 priceTab" >
												<label class="control-label">Expiry date</label>
												<input class="form-control class_mandatory" id="txt_expiry_date" value="<?php echo $expiry_date ?>"  name="txt_expiry_date" type="text" autocomplete="off" readonly="readonly">
												<div class="error"></div>
											</div>

											<!-- <div class="col-md-6">
												<label class="control-label">Usage limit per coupon</label>
												<input class="form-control number" id="txt_limit_per_coup"  name="txt_limit_per_coup" value="<?php echo $usage_limit_per_coupon ?>" type="text" maxlength="7">
												<div class="error"></div>
											</div> -->

											<div class="col-md-6">
												<label class="control-label">Usage limit per user</label>
												<input class="form-control number" id="txt_limit_user"  name="txt_limit_user" value="<?php echo $usage_limit_per_user ?>" type="text" maxlength="7">
												<div class="error"></div>
											</div>

											<div class="col-md-6">
												<label class="control-label">Minimum Spend</label>
												<input class="form-control number" id="txt_minimum_spend"  name="txt_minimum_spend" value="<?php echo $minimum_spend ?>" type="text" maxlength="6">
												<div class="error"></div>
											</div>

											<div class="col-md-6">
												<label class="control-label">Maximum Redeem Allowed</label>
												<input class="form-control number" id="txt_maximum_spend"  name="txt_maximum_spend" value="<?php echo $maximum_spend ?>" type="text" maxlength="7">
												<div class="error"></div>
											</div>

										</div>


										</span>

						       </div>
						   	</div>
							<!-- <div class="form-group row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">&nbsp;</label>

											<div>
												<label>
													<input class="checkbox class_individul_use" type="checkbox" <?php echo (!empty($individual_use_only) ? "checked" : "")?>  value="1" id="class_individul_use" name="class_individul_use" >
													<span>Individual Use Only</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div> -->

                          </form>

					
				</div>
				<div class="tile-footer">
					<button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					<span id="registerLoader"></span>
				</div>
			</div>
		</div>


	</div>
</main>

<script type="text/javascript">


	// document.multiselect('#products');
	// document.multiselect('#products_category');


	$(document).delegate("#class_individul_use", "change", function(e) {

		if( $(e.target).is(":checked") ) {
			$("#txt_limit_per_coup").attr("disabled", "disabled");
			$("#txt_limit_user").attr("disabled", "disabled");
		}
		else {
			$("#txt_limit_per_coup").removeAttr("disabled");
			$("#txt_limit_user").removeAttr("disabled");
		}

	});

	$(document).delegate("#btnSave","click",function(e)
    {
        $("#basicDetails").submit();
    });
/*
	$(document).delegate("#btnSave","click",function(e)
    {
		var error 	= 0;
		var values 	= $('#example-getting-started_input').val();

		//alert(values);
		// classError  = 0;

		$('.class_mandatory').each(function() {

            if ($.trim($(this).val()) == '')
			{
                isValid = false;
                $(this).css('border-color', 'red');
				error =1;
				//alert(34);
            }
            else
			{
                $(this).css('border-color', '');
			}
			
        });

		 if(error==1)
		 {
		    $("#validationSpan").html("Please enter all mandatory fields.");
		    return false;
		 }

		 if(error == 0)
		 {

			// alert(1);

			$("#validationSpan").html("<img src='<?php echo base_url() ?>images/loader3.gif' class='image-loader'>");

			// return false;

			var fd = new FormData();
			var other_data = $("#basicDetails").serializeArray();
			$.each(other_data,function(key,input){
				fd.append(input.name,input.value);
			});			

			csrf_value  =   getCookie('csrf_cookie_name');
			fd.append('<?php echo $this->security->get_csrf_token_name(); ?>',csrf_value);

			$.ajax( {
				type: 'POST',
				url: '<?php echo base_url(); ?>admin/C_admin/saveCoupon',
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {

					data =  jQuery.parseJSON(data);
					console.log(data['status']);

					if(data['status']==1)
					{
							$(".error").html("");// clear all errors
							swal("Well done!", "Saved Successfully!", "success");
							window.location="<?php echo base_url(); ?>admin/list_coupon";
					}

					else if(data['status']==0)
					{
						if(data['errors'] !== ""){
							$.each(data['errors'], function(key, value) {//alert(key); alert(value);
								//$('input[name='+key+']').addClass('is-invalid');
								//$('[name="'+key+'"]').
								$('[name="'+key+'"]').parents('.col-md-6').find('.error').html(value);

							});
						}
						else{
							swal("Sorry!", "Failed to save! Try again later", "error");
						}


					}
					else{
						swal("Sorry!", "Some technical issue occured", "error");
					}
					$("#validationSpan").html("");

				}
			});
		 }
		 else
		 {
			 return false;
		 }
		// $("input:empty").length == 0;

	});*/



	var validator=$("#basicDetails").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_code: 
          {
            required: true,
           	maxlength:100
            
          },
          txt_coupon_amount: 
          {
            required: true,
          },
          txt_title: 
          {
            required: true,
          },
          txt_coupon_desc: 
          {
            required: true,
          },
          txt_expiry_date: 
          {
            required: true,
          },
          txt_limit_user:{
            min:1  
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
				dataString = $('#basicDetails').serialize();
				var formData = new FormData($("#basicDetails")[0]);
				csrf_value  =   getCookie('csrf_cookie_name');        
				formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);

				$.ajax({
					url: '<?php echo base_url(); ?>admin/C_admin/saveCoupon',
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
                        $(".error").html("");// clear all errors
                        swal("Well done!", "Saved Successfully!", "success");
                        window.location="<?php echo base_url(); ?>admin/list_coupon";
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
                                //$('[name='+key+']').parents('.form-group').find('.error').html(value);
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
      
        
                }
       
 });

	$(document).delegate("#txt_product_type","change",function(e)
    {

		productType  = $(this).val();

		if(productType==1)
		{
			// $("#variationControls").css("display","none");
			$("#radioCustom").trigger("click");
		}
		else
		{
			//$("#variationControls").css("display","block");
			$("#radioCustom").trigger("click");
		}

	});

	$(document).delegate(".class_variation_enable","click",function(e)
    {
		productType  = $("#txt_product_type").val();

		if(productType==1)
		{
			// $("#variationControls").css("display","none");
			$("#radioCustom").trigger("click");
		}
		else
		{
			// $("#variationControls").css("display","block");
			$("#radioCustom").trigger("click");
		}
	});

</script>
<script>

$(document).ready(function(){

    $("#txt_expiry_date").datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		minDate: 0
		//yearRange: new Date().getFullYear().toString() + ':' + new Date().getFullYear().toString()
	});

});

</script>
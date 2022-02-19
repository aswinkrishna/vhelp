 <?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  

 $saveButtonName  = "Save";
?> 
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Website basic details</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
 <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Website basic details</h3>
            <div class="tile-body">
						
							<?php
							$attributes = array('method' => 'post', 'id' => 'basicDetails', 'name' => 'item', 'autocomplete' => 'off');
                             echo  form_open_multipart(base_url().'admin/C_product/saveProduct', $attributes);
                        ?>	
							 <div class="form-group row">
								      <div class="col-sm-12">
									  <div class="row">
									   <input type="hidden" name="table_id" value="<?php echo $admin_basics->id;?>">
								           <div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Email Address</label>
                                            <input class="form-control" id="txt_email"  name="txt_email" type="text" value="<?php echo $admin_basics->email_id;?>"> 
                                            <div class="error"></div>
											</div>
												<div class="col-md-6">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Contact Address</label>
											<textarea class="form-control" name="txt_address" id="txt_address"><?php echo $admin_basics->address;?></textarea>
                                            <div class="error"></div>
										</div>
										<?php
										$phone = $admin_basics->phone_no;
										$phoneArray  = explode("-",$phone);
										
										?>
											<div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Dial Code</label>
                                            <input class="form-control" id="txt_dial"  name="txt_dial" type="text" value="<?php echo $phoneArray[0];?>"> 
                                            <div class="error"></div>
											</div>
										<div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Phone</label>
                                            <input class="form-control" id="txt_phone"  name="txt_phone" type="text" value="<?php echo $phoneArray[1];?>"> 
                                            <div class="error"></div>
											</div>
			<div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Facebook</label>
                                            <input class="form-control" id="txt_facebook"  name="txt_facebook" type="text" value="<?php echo $admin_basics->fb_link;?>"> 
                                            <div class="error"></div>
											</div>
                                                                           <div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Twitter</label>
                                            <input class="form-control" id="txt_twitter"  name="txt_twitter" type="text" value="<?php echo $admin_basics->twitter_link;?>"> 
                                            <div class="error"></div>
											</div>
                                                                           <div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Google +</label>
                                            <input class="form-control" id="txt_google"  name="txt_google" type="text" value="<?php echo $admin_basics->google_link;?>"> 
                                            <div class="error"></div>
											</div>
                                                                           <div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Instagram</label>
                                            <input class="form-control" id="txt_insta"  name="txt_insta" type="text" value="<?php echo $admin_basics->insta_link;?>"> 
                                            <div class="error"></div>
											</div>
                                                                           <div class="col-md-6">
                                            <label class="control-label" for="formGroupExampleInput">Youtube</label>
                                            <input class="form-control" id="txt_youtube"  name="txt_youtube" type="text" value="<?php echo $admin_basics->youtube_link;?>"> 
                                            <div class="error"></div>
											</div>
									</div>
                                             </div>
                                                         </div>
                                                        <?php  echo form_close(); ?>
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
       // alert();
        
           error        =0;
       var validator=$("#basicDetails").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
         txt_email: 
          {
            required: true,
           email:true
            
          },
           txt_address: 
          {
            required: true
            
          },
           txt_dial: 
          {
            required: true,
            number:true,
            maxlength:4
          },
           txt_phone: 
          {
            required: true,
            number:true,
            maxlength:10,
            minlength:5
          },
          txt_google: 
          {
            required: true,
            url: true
            
          },
          txt_insta: 
          {
           required: true,
            url: true
          },
         
                     txt_youtube: 
          {
           required: true,
            url: true
            
          },
          txt_facebook: 
          {
           required: true,
            url: true
          },
           txt_twitter: 
                   { 
                       required: true,
            url: true
                  }
            
        },
       
        messages: 
        {
       txt_google: "Enter the product name",
       txt_twitter: "Enter a product unique identifier",
       txt_product_desc:
               {
                        required:"Please enter short description",
                        minlength:"Please enter 10 characters"


                    },
                     txt_product_desc_full:
               {
                        required:"Please enter full description",
                        minlength:"Please enter 10 characters"


                    },
                     txt_sale_datefrom: "Please select sale date from",
                  txt_sale_dateto: "Please select sale date to",
        }
       
 });  
     
      if (!$("#basicDetails").valid() ) 
      {
          
           error     = 1; 
         //  console.log("invalid");
         ///  $("#categoryDetails").validate({    });
          return;
      } else
      { 
          
          
                               $(".errorSpan1").html("");	               
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                	
                                          var fd = new FormData();
                                           var other_data = $("#basicDetails").serializeArray();
    $.each(other_data,function(key,input){
        fd.append(input.name,input.value);
    });
    
       csrf_value  =   getCookie('csrf_cookie_name');        
                 fd.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 
	      
                                       
                                       $.ajax( {
						type: 'POST',
						url: '<?php echo base_url();?>admin/C_admin/saveAdminDetails',
						data: fd,
						cache: false,
                        contentType: false,
                        processData: false,
						success: function(data) {
                   

				                   $("#registerLoader").html("");
                    $('#btnRegister').prop("disabled", false);
				                     data =  jQuery.parseJSON(data);
				                     console.log(data['status']);

				                    if(data['status']==1)
				                    {
				                         $(".error").html("");// clear all errors
				                          swal("Well done!", "Admin details Saved Successfully!", "success");
				                              
				                    }
				                    else if(data['status']==0)
				                    {
				                          if(data['errors'] !== ""){
				                            $.each(data['errors'], function(key, value) {//alert(key); alert(value);
				                                //$('input[name='+key+']').addClass('is-invalid');

				                                $('[name='+key+']').parents('.col-md-6').find('.error').html(value);

				                            });                          
				                          }else{    
				                           swal("Sorry!", "Failed to save! Try again later", "error");
				                          }


				                    }

                  
                   
                             }
					});
          
          
      }
        
             });
    </script>
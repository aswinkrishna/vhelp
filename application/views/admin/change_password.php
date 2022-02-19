<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Change password</h1>
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
            <!--<h3 class="tile-title">Change password</h3>-->
            <div class="tile-body">

                                <!-- <form role="form" method="post" action="<?php echo base_url();?>admin/C_product/saveAttribute" id="itemForm" enctype="multipart/form-data"> -->
                                <?php
                                 $attributes = array('method' => 'post', 'id' => 'itemForm', 'name' => 'item','role'=>'form');
                                 echo  form_open_multipart(base_url().'admin/C_product/saveAttribute', $attributes);
                                ?>
                                    
								 <div class="form-group row">
								<div class="col-md-6">
                                          
                                            <label class="control-label" for="formGroupExampleInput">Old password</label>
                                            <input class="form-control" id="txt_old_password"  name="txt_old_password" placeholder="Old password" type="password" maxlength="20"> 
                                            <div class="error"></div>
											</div>
										<div class="col-md-6">
                                       
                                            <label class="control-label" for="formGroupExampleInput">New password</label>
                                            <input class="form-control" id="txt_new_password"  name="txt_new_password" type="password" placeholder="New password" maxlength="20"> 
                                            <div class="error"></div>
										</div>
										<div class="col-md-6">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Confirm password</label>
                                            <input class="form-control" id="txt_conf_password"  name="txt_conf_password" type="password" placeholder="Confirm password" maxlength="20"> 
                                            <div class="error"></div>
										</div>
								
									 </div>
								 <?php  echo form_close(); ?>
								 
								 </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
              &nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>
        </div>
        
        
      </div>
    </main>

               <script>         

$(document).delegate("#btnRegister","click",function(e)
    {
        $("#itemForm").submit();
    });

       var validator=$("#itemForm").validate(
            //alert();
        {
           ignore: [],
            onfocusout: false,
           onkeyup :false,
             onclick :false,
               onchange :false,
        rules: 
        {
          
          txt_old_password: 
          {
            required: true,
            minlength: 8,
            maxlength:20
            
          },
          txt_new_password: 
          {
            required: true,
            minlength: 8,
            maxlength:20
          },
          txt_conf_password: 
          {
             required: true,
             minlength: 8,
             maxlength:20,
             equalTo: "#txt_new_password"
          },
        },
        messages: 
        {
       
    },
     submitHandler: function ()
                {
                    // return false;
              

			
              
                dataString = $('#itemForm').serialize();
                var formData = new FormData($("#itemForm")[0]);
                    csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveChangePassword',
             type: 'POST',
             data: formData,
             async: false,
             success: function (data) 
                {
                   

                      //alert(data);
                   // console.log(data);

                    data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    if(data['status']==1)
                    {
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Password has been changed successfully!", "success");
                          location.reload();
                              
                    }
					else if(data['status']<0)
					{
						
						 swal("Sorry!", "Old password is not correct", "error");
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

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;



			  //$("#itemForm").submit();
                      
                }
       
 });  

       $(document).delegate(".removeThis","click",function(e)
    {


         id  = $(this).attr("for") ;

         $("#txtDelete").val(id) ;
         
          
         
    });

       $(document).delegate(".confirmDelete","click",function(e)
    {


        

      id =   $("#txtDelete").val() ;
         
        deleteAttribute(id);  
         
    });

        $(document).delegate(".cancelConfirm","click",function(e)
    {


        

        $("#txtDelete").val("") ;
         
       
         
    });

       

       function deleteAttribute(id)
       {
           
               csrf_value  =   getCookie('csrf_cookie_name');        
               
             $.ajax({
            url:  '<?php echo base_url();?>admin/C_product/deleteAttribute',
            type: 'POST',
            data: {id:id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			     //alert(data);

			      if(data>0)
                    {
                       
                          swal("Well done!", "Deleted Successfully!", "success");
                              location.reload(); 
                    }
                    else
                    {
                              
                          swal("Sorry!", "Failed to delete! Try again later", "error");


                    }

			   
            }
        });    
       }
       function editAttribute(name,arabic,id)
       {
           $("#attr_id").val(0);
           $("#txt_attr_name").val(name);
           $("#txt_attr_name_arabic").val(arabic);
           $("#attr_id").val(id);
       }
       
                </script>
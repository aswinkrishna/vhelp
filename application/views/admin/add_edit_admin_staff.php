<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Admin Staff</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                     $label = "registration";
                     $saveButtonName  = "Add";
                      if($id>0)
                      {
                               $label = "updation";
                              $saveButtonName  = "Update";
                               
                                $englishName                 =   $records1->service_type_name;
                                $arabicName                   =   $records2->service_type_name;
                                $parentId                         =   $records1->service_type_parent_id;
                                $status                              =   $records1->service_type_status;
                                $method                           =   $records1->service_methode;
                      }
                      else
                      {
                               $englishName                 =   "";
                                $arabicName                  =   "";
                                $parentId                        =  0;
                                $status                            =   "1";
                                $method                         ="";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Admin staff <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="adminForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_service_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
                   <div iv class=" row">
								        <div class="col-md-6">
                                          
                                            <label class="control-label" for="formGroupExampleInput">First Name</label>
                                            <input class="form-control" id="txt_first_name"  name="txt_first_name" type="text" value="<?php echo $results->admin_first_name ?>"> 
                                            <div class="error"></div>
											</div>
										<div class="col-md-6">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Last Name</label>
                                            <input class="form-control" id="txt_last_name"  name="txt_last_name" type="text" placeholder="" value="<?php echo $results->admin_last_name ?>" > 
                                            <div class="error"></div>
										</div>
										 <div class="col-md-6">
                                          
                                            <label class="control-label" for="formGroupExampleInput">User Name</label>
                                            <input class="form-control" id="txt_user_name"  name="txt_user_name" type="text" value="<?php echo $results->admin_user_name ?>" > 
                                            <div class="error"></div>
											</div>
											<div class="col-md-6">
                                          
                                            <label class="control-label" for="formGroupExampleInput">Email</label>
                                            <input class="form-control" id="txt_email"  name="txt_email" type="text" value="<?php echo $results->admin_user_email ?>"> 
                                            <div class="error"></div>
											</div>
											<?php
											if($results->admin_user_id<=0)
											{
											?>
										<div class="col-md-6">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Password</label>
                                            <input class="form-control" id="txt_password"  name="txt_password" type="password" placeholder=""> 
                                            <div class="error"></div>
										</div>
										<?php
											}
										?>
									<div class="col-sm-6">
								 <label class="col-sm-3 form-control-label text-xs-right"> Designation </label>
                                    <select class="c-select form-control boxed" name="txt_designation">
                                        
                                        
                                       
                                        <option value="" >Select Designation</option>
                                        <?php
                                        if(count($designation)>0)
                                        {
                                            foreach($designation as $rows)
                                            {
                                        ?>
                                        <option value="<?php echo $rows->designation_master_id ?>" <?php echo $results->designation_id==$rows->designation_master_id?"selected":"" ?> ><?php echo $rows->designation ?></option> 
                                        <?php
                                            }
                                        }
                                        ?>
                                        
                                       
                                    </select>
                                </div>
									<input type="hidden" class="form-control" id="admin_user_id"  name="id" type="text" value="<?php echo $results->admin_user_id>0?$results->admin_user_id:0?>"> 
                               
                                <div class="col-sm-6">
								 <label class="col-sm-3 form-control-label text-xs-right"> Status </label>
                                    <select class="c-select form-control boxed" name="txtStatus">
                                       
                                        <option value="1" <?php echo ($status==1?"selected":"");  ?>>Active</option>
                                        <option value="0" <?php echo ($status==0?"selected":"");  ?>>Inactive</option>
                                       
                                    </select>
                                </div>
								 </div>
              </form>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>
        </div>
        
        
      </div>
    </main>
<script>         

  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#adminForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#adminForm").validate(
            //alert();
        {
           ignore: [],
        
        rules: 
        {
          
          txt_first_name: 
          {
            required: true,
            maxlength:100,
              lettersonly:true,
            
          },
          txt_last_name: 
          {
            required: true,
            maxlength:100,
             lettersonly:true,
          },
           txt_user_name: 
          {
            required: true,
           maxlength:50,
            alphnumeric:true
          },
          txt_email: 
          {
            required: true,
            email:true,
            maxlength:100
          },
           txt_password: 
          {
            required: true,
            minlength:8,
            maxlength:20,
             passwordCheck:true
          },
           txt_designation: 
          {
            required: true
          },
          
        },
        messages: 
        {
       
    },
     submitHandler: function ()
                {
                    // return false;
              

                $(".error").html("");		
                $("#btnSave").attr("disabled", "disabled");
               $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                dataString = $('#adminForm').serialize();
                var formData = new FormData($("#adminForm")[0]);
                csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveAdminUsers',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                      //alert(data);
                   // console.log(data);
                     $('#btnSave').prop("disabled", false);
                     $("#registerLoader").html("");
                     data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    if(data['status']==1)
                    {
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Saved Successfully!", "success");
                          window.location="<?php echo base_url(); ?>admin/admin_user_list";
                              
                    }
				else if(data['status']==3)
                    {
                          $(".error").html("");// clear all errors
                          swal("Email id already exists");
                          
                              
                    }
                    	else if(data['status']==4)
                    {
                         $(".error").html("");// clear all errors
                          swal("Username exists");
                          
                              
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
  $("#categoryIcon").change(function() {
  readURL(this,'imagePreview');
});
 $("#categoryImage").change(function() {
  readURL(this,'imagePreview2');
});
 </script>


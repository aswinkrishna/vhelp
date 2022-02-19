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
          <h1><i class="fa fa-edit"></i> User</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                      $label                        = "registration";
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
            <h3 class="tile-title">User <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="userForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                         $row     =        $user_basic[0];
                        $row2    =        $user_details[0];
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_user_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
                   <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input class="form-control" type="text" placeholder="Enter first name" maxlength="40" id="txt_first_name"  name="txt_first_name"  value="<?php echo $row->user_first_name!=''?$row->user_first_name:'' ?>" >
                                 </div> 
                        </div>
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input class="form-control" type="text" placeholder="Enter last name" maxlength="40" id="txt_last_name"  name="txt_last_name"  value="<?php echo $row->user_last_name!=''?$row->user_last_name:'' ?>">
                                 </div> 
                        </div>
                   </div>
                   <input type="hidden" value="<?php echo ($id > 0) ? 0 : 1; ?>" name="save_password" id="save_password">
                    <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Email id</label>
                                <input class="form-control" type="text" placeholder="Enter email id" maxlength="40" id="txt_email" name="txt_email"  <?php echo $id>0?'readonly':'' ?>  value="<?php echo $row->user_email!=''?$row->user_email:'' ?>">
                                 </div> 
                        </div>
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Password</label>
                                <?php if($id): ?>
                                  <span style="cursor: pointer;float: right;font-weight: bold;" class="changePassword">Change Password</span>
                                <?php endif; ?>
                                <?php $display = ($id==0 ? '' : 'none'); ?>
                                <i class="fa fa-eye" id="displayPassword" style="display: <?=$display?>"></i>
                                <input class="form-control" type="password" placeholder="Enter password" maxlength="20"  <?php echo $id>0?'readonly':'' ?>  id="txt_password" name="txt_password" value="<?php echo $row->user_password!=''?'00#sd123s':'' ?>">
                                 </div> 
                        </div>
                   </div>
                     <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Country</label>
                                <select class="form-control"  id="select_country"  name="select_country">
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
                        <?php /*
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">City</label>
                              <select class="form-control" id="select_city"  name="select_city">
                                    <option value="">Select</option>
                                    <?php
                                   if($id>0 && $row->country_id>0)
                             {
                                       
                                 $con['city_country_id']                   =       $row->country_id;   
                                 $con['city_status']                            =       1;  
                                 $con['city_language_code']           =       1;  
                                $city                                                      =      $this->M_admin->getCitiesCondition($con);  
                                if(count($city)>0)
                                {
                                        foreach($city as $cities)
                                        {
                                            ?>
                                    <option value="<?php  echo $cities->city_id ?>"  <?php echo $row->city_id==$cities->city_id?'selected':'' ?>><?php  echo $cities->city_name ?></option>
                                    <?php

                                        }
                                }
                            }
                                    ?>
                                    
                                </select>
                                 </div> 
                        </div>
                        */ ?>
                        <div class="col-md-2">
                                 <div class="form-group">
                                <label class="control-label">Dial code</label>
                                <input class="form-control" type="text" placeholder="Dial code" maxlength="5"  id="txt_dial" name="txt_dial" readonly value="<?php echo $row->user_dial_code!=''?$row->user_dial_code:'' ?>">
                                 </div> 
                        </div>
                     <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input class="form-control" type="text" placeholder="Enter phone number" maxlength="10"  id="txt_phone" name="txt_phone" value="<?php echo $row->user_phone!=''?$row->user_phone:'' ?>">
                                 </div> 
                        </div> 
                   </div>
                    <div class="row">
                        
                         <div class="col-md-6" style="display:none;">
                                 <div class="form-group">
                                <label class="control-label">Zip code</label>
                                <input class="form-control" type="text" placeholder="Enter zip code" maxlength="10"  id="txt_zip" name="txt_zip" value="<?php echo $row->user_zip!=''?$row->user_zip:'' ?>">
                                 </div> 
                        </div>
                   </div>
                 <div class="row">
                     <div class="col-md-6" style="display:none;">
                                 <div class="form-group">
                                <label class="control-label">Building</label>
                                <input class="form-control" type="text" placeholder="Enter building" maxlength="100" id="txt_building" name="txt_building" value="<?php echo $row2->building!=''?$row2->building:'' ?>">
                                 </div> 
                        </div>
                         <div class="col-md-6" style="display:none;">
                                 <div class="form-group">
                                <label class="control-label">Appartment</label>
                                <input class="form-control" type="text" placeholder="Enter apprtment" maxlength="100" id="txt_apprtment" name="txt_apprtment" value="<?php echo $row2->appartment!=''?$row2->appartment:'' ?>">
                                 </div> 
                        </div>
                   </div>
                    <div class="row">
                     <div class="col-md-6" style="display:none;">
                                 <div class="form-group">
                                <label class="control-label">Area</label>
                                <input class="form-control" type="text" placeholder="Enter area" maxlength="100" id="txt_area" name="txt_area" value="<?php echo $row2->area!=''?$row2->area:'' ?>">
                                 </div> 
                        </div>
                         <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Profile picture (Accepts .jpg, .jpeg & .png only)</label>
                                <input class="form-control" type="file" accept=".jpg, .png, .jpeg" id="txt_profile" name="txt_profile">
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
           txt_email: 
          {
            required: true,
           email: true,
           maxlength:100,
          },   
            
         select_country: 
          {
            required: true,
            number:true
          },
         txt_password: 
          {
              required: true,
               minlength: 8,
               maxlength:20 ,
               passwordCheck:true
          },
        /*'select_city': 
          {
            required: true,
            number:true
          },*/
         'txt_phone': 
          {
            required: true,
            minlength: 5,
           maxlength:10,
           number:true
          },
       /* 'txt_zip': 
          {
            required: true,
            number:true,
            minlength: 5,
            maxlength:6,
          },
          'txt_building': 
          {
            required: true,
           maxlength:100,
           specialChars:true,
          },
         'txt_apprtment': 
          {
             required: true,
           maxlength:100,
           specialChars:true,
          },
          'txt_area': 
          {
              required: true,
             maxlength:100,
             specialChars:true,
          },*/
//            'txt_profile': 
//          {
//              required: true,
//          },
          <?php if(!$id>0) { ?>
            'txt_profile': 
          {
              required: true,
          },
          <?php } ?>
          
      
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
             url: '<?php echo base_url();?>admin/C_admin/saveUser',
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
                       
                          swal("Well done!", "Saved Successfully!", "success");
                          window.location="<?php echo base_url(); ?>admin/user_list";
                              
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
 $(document).delegate("#select_country","change",function(e)
    {
  
         var selected = $(this).find('option:selected');
         var dialCode = selected.data('foo'); 
          $("#txt_dial").val(dialCode);
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
    $("#txt_profile").change(function() {
  readURL(this,'imagePreview');
});

    $('#displayPassword').click(function(){
      var myClass = $(this).attr('class');
      if(myClass=='fa fa-eye'){
        $(this).attr('class','fa fa-eye-slash');
        $('#txt_password').attr('type','text');
      }
      else{
        $(this).attr('class','fa fa-eye');
        $('#txt_password').attr('type','password');
      }
    });

  $('input#txt_phone').keypress(function(e){
    if(this.value.length < 2 && e.which == 48)
    {
      return false;
    }
  });
  
  $('.changePassword').click(function(){
    $('input#save_password').val(1);
    $('input#txt_password').val('');
    $('input#txt_password').attr('readonly',false);
    $('#displayPassword').show();
  });
 </script>
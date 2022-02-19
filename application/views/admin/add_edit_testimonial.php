<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Testimonial</h1>
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
                              
                       $records         =    $testi[0];
                       $first_name    =   $records->first_name;
                       $last_name    =   $records->last_name;
                       $user_type    =   $records->user_type;
                       $status    =   $records->testimonial_status;
                       $testimonial    =   $records->testimonial;
                       $testimonial_arabic    =   $records->testimonial_arabic;
                       $profile_image    =   $records->profile_image;
                       
                       $testimonial_desig    =   $records->designation;
                       $testimonial_desig_arabic    =   $records->designation_arabic;
                      }
                      else
                      {
                               $first_name    =   "";
                       $last_name    =  "";
                       $user_type    =  "";
                       $status    =  "";
                       $testimonial    =   "";
                       $testimonial_arabic    =   "";
                       $profile_image    =  "";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Testimonial <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="testimonialForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_test_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
                                 <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                              <div class="form-group row">
                  <label class="control-label col-md-3">User type</label>
                  <div class="col-md-9">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="user_type" value="1"  <?php echo $user_type!=2?"checked" :""?> >User
                      </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="user_type" value="2" <?php echo $user_type==2?"checked" :""?>>Provider
                      </label>
                    </div>
                
                  </div>
                </div> 
                                 </div> 
                        </div>
                                 </div>
                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">First name</label>
                             <input type="text" class="form-control boxed" placeholder="" name="txtFirstname" value="<?php echo $first_name; ?>" maxlength="100"> 
                                 </div> 
                        </div>
                   <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Last name</label>
                                 <input type="text" class="form-control boxed" placeholder="" name="txtLastName" value="<?php echo $last_name; ?>" maxlength="100" >
                                 </div> 
                        </div>
                     
                   </div>
                    <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Testimonial english</label>
                                <textarea class="form-control boxed" name="txtEnglish"><?php  echo $testimonial ?></textarea>
                                 </div> 
                        </div>
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Testimonial english</label>
                                <textarea class="form-control boxed" name="txtArabic"><?php  echo $testimonial_arabic ?></textarea>
                                 </div> 
                        </div>
                    </div>
                                   <div class="row">
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Status</label>
                              <select class="c-select form-control boxed controll-wdth" name="txtStatus">
                                       
                                        <option value="1" <?php echo ($status==1?"selected":"");  ?>>Active</option>
                                        <option value="0" <?php echo ($status==0?"selected":"");  ?>>Inactive</option>
                                       
                                    </select>
                                 </div> 
                        </div>
                                       <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Profile Image</label>
                               <input type="file" class="form-control boxed" id="categoryImage" placeholder="" name="txt_profile" value=""> 
                                 </div> 
                        </div>
                                      <div class="col-md-2">
                                 <div class="form-group">
                                
                                     <img src="<?php echo $profile_image!=""?base_url().'uploads/user/'.$profile_image:base_url().'images/placeholder.jpg' ;?>" class="previewImage" id="imagePreview2">
                                 </div> 
                        </div>
                                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Designation</label>
                                <input type="text" class="form-control boxed" id="txt_desig" placeholder="" name="txt_desig" value="<?php echo $testimonial_desig;?>" maxlength="100"> 
                                 </div> 
                        </div>
                                            <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Designation arabic</label>
                               <input type="text" class="form-control boxed" id="txt_desig_arb" placeholder="" name="txt_desig_arb" value="<?php echo $testimonial_desig_arabic;?>" maxlength="100"> 
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
        $("#testimonialForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#testimonialForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
           user_type:  
          {
             required: true,
          },
          txtFirstname:  
          {
            required: true,
           maxlength:100,
           lettersonly:true,
           
          },
           txtLastName: 
          {
            required: true,
           maxlength:100,
           lettersonly:true,
            
          },
          txtArabic: 
          {
            required: true,
            maxlength:1000,
          }, 
            txtEnglish: 
          {
            required: true,
            maxlength:1000,
          },
            txt_desig: 
          {
            required: true,
            maxlength:100,
          },
            txt_desig_arb: 
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
                dataString = $('#testimonialForm').serialize();
                var formData = new FormData($("#testimonialForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveTestimonial',
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
                           window.location= "<?php echo base_url();?>admin/testimonial_list";    
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                                $('[name='+key+']').parents('.form-group').find('.error').html(value);

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
  $("#categoryIcon").change(function() {
  readURL(this,'imagePreview');
});
 $("#categoryImage").change(function() {
  readURL(this,'imagePreview2');
});
 </script>


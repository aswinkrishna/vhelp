<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i>Promotion slider</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                     $label = "Add";
                     $saveButtonName  = "Save";
                      if($id>0)
                      {
                                $label = "Edit";
                                $saveButtonName  = "Update";
                                $records1        =  $this->M_admin->getPromotionSliderById($id);
                                $englishName                 =   $records1->slider_title;
                                $arabicName                  =   $records1->slider_title_arabic;
                                $serviceTyeId                =   $records1->slider_service_type;
                                $sliderStatus               =    $records1->slider_status;
                                $sliderImage                 =   'uploads/app_slider/'.$records1->slider_image;
                                if(file_exists($sliderImage) && is_file($sliderImage))
                                  $sliderImage  = base_url().$sliderImage;
                                else
                                  $sliderImage  = base_url().'images/placeholder.jpg';
                      }
                      else
                      {
                                $englishName               =   "";
                                $arabicName               =   "";
                                $sliderStatus             =   1;;
                                $sliderImage              = base_url().'images/placeholder.jpg';
                                $serviceTyeId             = '';
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title"> <?php  echo $label; ?> Promotion Slider</h3>
            <div class="tile-body">
                <form name="item"  id="sliderForm" method="post" enctype="multipart/form-data" autocomplete="off">
                  
                  <input type="hidden" class="form-control boxed" placeholder="" name="slider_id" value="<?php echo $id; ?>"> 
                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Slider Title English</label>
                             <input type="text" class="form-control boxed" placeholder="" name="txtEnglish" value="<?php echo $englishName; ?>" maxlength="100"> 
                                 </div> 
                        </div>
                   <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Slider Title  Arabic</label>
                                 <input type="text" class="form-control boxed" placeholder="" name="txtArabic" value="<?php echo $arabicName; ?>" maxlength="100" dir="rtl">
                                 </div> 
                        </div>
                     
                   </div>
                  
                                  <div class="row">
                                      
                                      <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Slider Image (270 X 250)</label>
                               <input type="file" class="form-control boxed" id="categoryThumb" placeholder="" name="txtFile3" value="" accept=".jpg, .png, .jpeg">
                               <p>Upload .jpg, .jpeg, & .png formats only</p>
                                 </div> 
                        </div>
                                          <div class="col-md-2">
                                 <div class="form-group">
                                
                                     <img src="<?=$sliderImage?>" class="previewImage" id="imagePreview3">
                                 </div> 
                        </div>
                        <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Services Type</label>
                        <select class="form-control boxed" id="service_type" id="service_type">
                          <option value="">Select service type</option>
                          <?php
                            foreach ($service_list as $key => $value) {
                              if($value->service_type_id == $serviceTyeId)
                                $selected = 'selected';
                              else
                                $selected = "";
                          ?>
                            <option value="<?=$value->service_type_id?>" <?=$selected?> > <?=$value->service_type_name?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                        
                  </div>

                  <div class="row">

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
        $("#sliderForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#sliderForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
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
          },
          <?php
           if($id<=0)
                      {
          ?>
          txtFile3: {
                required: {
                    depends: function (element) {
                        return $("#txt_service_id").not(":filled");
                    }
                }
            }
            
            <?php
                      }
            ?>
          /* txtmethod: 
          {
            required: true,
            number:true
          },*/
          /*txt_commission:
          {
            required: true,
            number:true
          }*/
          
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {

              $(".errorSpan1").html("");                 
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                dataString = $('#sliderForm').serialize();
                var formData = new FormData($("#sliderForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name');        
                  formData.append('service_type',$('#service_type').val());
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/savePromotionSlider',
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
                           // window.location= "<?php echo base_url();?>admin/service_type_list";    
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
$("#categoryThumb").change(function() {
    var fileExtension = ['jpeg', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        $("#categoryThumb").val('');
        swal('Error!','You are trying to upload an invalid file format','error');
        return false;
    }
    readURL(this,'imagePreview3');
});

 </script>


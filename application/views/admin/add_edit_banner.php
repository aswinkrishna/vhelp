<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Banner</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                     $label = "Management";
                     $saveButtonName  = "Add";
                      if($id>0)
                      {
                               $label = "Updation";
                               $saveButtonName  = "Update";
                              $records1 = $banner[0];
                               
                                $englishName            =   $records1->banner_title;
                                $arabicName              =   $records1->banner_title_arabic;
                                $url                               =   $records1->banner_url;
                                $status                         =   $records1->banner_status;
                                $image                        =    $records1->banner_image;
                      }
                      else
                      {
                               $englishName                 =   "";
                               $arabicName                  =   "";
                               $url                        =   "";
                               $status                              =   "";
                               $image                = "";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Banner <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="countryForm" method="post" enctype="multipart/form-data" autocomplete="off">
                
                    
                   
                                <input type="hidden" class="form-control boxed" placeholder="" name="banner_id" id="banner_id" value="<?php echo $id>0?$id:0; ?>"> 
                      
                     
         
                   <div class="row">
                   <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Banner title</label>
                                  <input type="text" class="form-control boxed" placeholder="" name="txtEnglish" value="<?php echo $englishName; ?>" maxlength="100" autocomplete="off">
                                 </div> 
                        </div>
                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Banner title Arabic</label>
                                  <input type="text" class="form-control boxed" placeholder="" name="txtArabic" value="<?php echo $arabicName; ?>" dir="rtl" maxlength="100" autocomplete="off">
                                 </div> 
                        </div>
                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Url</label>
                                  <input type="text" class="form-control boxed" placeholder="" name="txtUrl" value="<?php echo $url; ?>" maxlength="1000" autocomplete="off">
                                 </div> 
                        </div>
                         <div class="col-md-4">
                                 <div class="form-group">
                                    <label class="control-label">Banner image (upload .jpg, .jpeg & .png only)</label>
                                    <input type="file" class="form-control boxed" placeholder="" name="txt_banner" id="txt_banner"  autocomplete="off"> 
                                    <p>Maximum upload file size is 2MB (1358 x 550 px).</p>
                                </div> 
                        </div>
                          <div class="col-md-2">
                                 <div class="form-group">
                                
                                     <img src="<?php  echo base_url()?>uploads/banner/<?php echo $image;?>" class="previewImage" id="imagePreview2">
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
        $("#countryForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#countryForm")[0].reset();
    });


       var validator=$("#countryForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          txtEnglish: 
          {
            required: true,
           maxlength:100,
           //lettersonly:true,
            
          },
          txtArabic: 
          {
            required: true,
           maxlength:100,
          // lettersonly:true,
            
          },
          txtUrl: 
          {
            required: true,
           maxlength:1000,
          // lettersonly:true,
          },
          txt_banner: {
    required: function(element){
            return $("#banner_id").val()<=0;
        }
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
                dataString = $('#countryForm').serialize();
                var formData = new FormData($("#countryForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveBanner',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                     $("#registerLoader").html("");
                    $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                    // console.log(data['status']);

                    if(data['status']==1)
                    {
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Banner uploaded successfully!", "success");
                           window.location= "<?php echo base_url();?>admin/banner_list"; 
                          
                              
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {//alert(key); alert(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                                $('input[name='+key+']').parents('.form-group').find('.error').html(value);

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
  $("#txt_banner").change(function() {
    var fileExtension = ['jpeg', 'jpg', 'png'];
    if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
    {
        $("#txt_banner").val('');
        swal("Sorry!", "You are trying to upload an invalid file.", "error");
        return false;
    }
    readURL(this,'imagePreview2');
});
 </script>


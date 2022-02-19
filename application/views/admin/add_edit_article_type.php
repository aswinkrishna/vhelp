<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Content type</h1>
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
                      if($id>0)
                      {
                          $saveButtonName  = "Update";
                               $label = "updation";
                             $records1        =         $article_type_eng[0];
                             $records2        =         $article_type_arabic[0];
                               
                                $englishName                 =   $records1->article_type_desc;
                                $arabicName                   =   $records2->article_type_desc;
                             
                                $status                              =   $records1->article_type_status;
                              
                      }
                      else
                      {
                               $saveButtonName         = "Add";
                               $englishName                 =   "";
                                $arabicName                  =   "";
                            
                                $status                            =   "1";
                               
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Content type <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="categoryForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_type_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Article type name english</label>
                             <input type="text" class="form-control boxed" placeholder="" name="txtEnglish" value="<?php echo $englishName; ?>" maxlength="100"> 
                                 </div> 
                        </div>
                   <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Article type name  arabic</label>
                                 <input type="text" class="form-control boxed" placeholder="" name="txtArabic" value="<?php echo $arabicName; ?>" maxlength="100" dir="rtl">
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
                                </div>
                   
              </form>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>
              &nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
           <span id="registerLoader"></span>
            </div>
          </div>
        </div>
        
        
      </div>
    </main>
<script>         

  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#categoryForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#categoryForm").validate(
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
                dataString = $('#categoryForm').serialize();
                var formData = new FormData($("#categoryForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveArticleType',
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
                           window.location= "<?php echo base_url();?>admin/article_type_list";    
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


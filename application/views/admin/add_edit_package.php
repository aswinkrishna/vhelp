<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Packages</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
<!--    <div class="row">
          <div class="col-md-12">
                <div class="col-md-8 col-md-offset-12">
                    <a href="javascript:void(0)" class="addNewQues"> <button class="btn btn-primary" type="button">New Question</button></a>
                </div>
              </div>
    </div>-->
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
        </div>
     <?php
     
     //print_r($records1);
           
                     $label = "Add Packages";
                     $saveButtonName  = "Add";
                      if($packageIdDecrypted>0)
                      {
                              $con['packages_id']      =  $packageIdDecrypted;
                              $package_list                 =  $this->M_admin->getPackagesCondition($con)     ;     
                              $records1                        =  $package_list[0];
                           
                           
                               $label = "Edit Packages ";
                             $saveButtonName  = "Update";
                               
                                $englishName                                      =   $records1->packages_name;
                                $arabicName                                        =   $records1->packages_name_arabic;
                                $packages_quotaion_limit                         =   $records1->packages_quotaion_limit;
                                $packages_recomended_provider                  =   $records1->packages_recomended_provider;
                                $status                              =   $records1->packages_status;
                                $packages_price                       =   $records1->packages_price;
                      }
                      else
                      {
                                $englishName                 =   "";
                                $arabicName                   =   "";
                                $packages_quotaion_limit                         =   "";
                                $packages_recomended_provider                  =  0;
                                $status                              =   "";
                                $packages_price                       =   "";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title"> <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="dynamicForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                  
                    
                    if($packageIdDecrypted>0)
                      {
                        
                      
                        
                        ?>
                        <input type="hidden" class="form-control boxed" placeholder="" name="txt_package_id" value="<?php echo $packageId; ?>"> 
                        <?php
                      
                      } 
                   
                     $timeStamp  =     date("YmdHis");
               ?>
                                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Package name</label>
                             <input type="text"  class="c-select form-control boxed" name="txt_package_name"  id="txt_package_name" value="<?php echo $englishName;?>">
                                </div> 
                        </div>
                                          <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Package name arabic</label>
                            <input type="text"  class="c-select form-control boxed" name="txt_package_name_arabic" id="txt_package_name_arabic" value="<?php echo $arabicName;?>">
                                </div> 
                                          </div>
                                                  <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">No of quotations to participate</label>
                             <input type="text"  class="c-select form-control boxed number" name="txt_no_of_qtns"  id="txt_no_of_qtns" maxlength="6" value="<?php echo $packages_quotaion_limit;?>">
                                </div> 
                        </div>
                                          <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Eq recommended provider?</label>
                            <div class="form-check">
                                                           
                    <label class="form-check-label">
                        <input class="form-check-input " id="radio_recomended1" name="radio_recomended" type="radio" value="1" data-error="#errNmQ20"  <?php  echo $packages_recomended_provider==1?"checked":""?> >Yes  </label>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                                                              
                    <label class="form-check-label">
                      <input class="form-check-input " id="radio_recomended2" name="radio_recomended" type="radio" value="0" data-error="#errNmQ20" <?php  echo $packages_recomended_provider==0?"checked":""?> >No  </label>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                                                              
                    
                               </div>
                                </div> 
                                          </div>
                                   <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Price</label>
                            <input type="text"  class="c-select form-control boxed number" name="txt_package_price" id="txt_package_price" maxlength="6" value="<?php echo $packages_price;?>">
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
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            <span id="registerLoader"></span>
            </div>
                           </form>
          </div>
        </div>
        
        
      </div>
    </main>
<script>         
    function validateForm()
    {
        
    }
    

  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#dynamicForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        //alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#dynamicForm").validate(
            //alert();
        {
           ignore: [],
             
        rules: 
        {
          
          txt_package_name: 
          {
            required: true,
           maxlength:1000,
          // lettersonly:true,
            
          },
          txt_package_name_arabic: 
          {
            required: true,
            maxlength:1000,
          },
            txt_no_of_qtns: 
          {
            required: true,
            number:true,
            maxlength:6
          },
          txt_package_price:
          {
               required: true,
             maxlength:6
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
                dataString = $('#dynamicForm').serialize();
                var formData = new FormData($("#dynamicForm")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 //formData.append('serviceTypeId',<?php echo $this->common_functions->decryptId($this->uri->segment(3));?>); 
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/savePackages',
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
                          window.location= "<?php echo base_url();?>admin/package_list";    
                     
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
$("#txtParentQuest").change(function()
{
                 csrf_value  =   getCookie('csrf_cookie_name');        
         
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/loadAnswers',
            type: 'POST',
            data: {questionId:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			 
				 $("#txtParentAnswer").html(data);
				
                                                                 }
        });
});

 </script>


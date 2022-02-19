<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Home page labels</h1>
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
           
                    $txt_label1            = $labels->home_labels1;
                    $txt_label1_arabic     = $labels->home_labels_arabic1;
                    $txt_label2            = $labels->home_labels2;
                    $txt_label2_arabic     = $labels->home_labels2_arabic;
                    $saveButtonName  ="Update";
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title"> <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="dynamicForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    
                                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Lable 1 english</label>
                             <input type="text"  class="c-select form-control boxed" name="txt_label1"  id="txt_label1" value="<?php echo $txt_label1;?>">
                                </div> 
                        </div>
                                          <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Lable 1 arabic</label>
                            <input type="text"  class="c-select form-control boxed" name="txt_label1_arabic" id="txt_label1_arabic" value="<?php echo $txt_label1_arabic;?>">
                                </div> 
                                          </div>
                                                 
                                         
                                      
                                 <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Lable 2 english</label>
                             <input type="text"  class="c-select form-control boxed" name="txt_label2"  id="txt_label2" value="<?php echo $txt_label2;?>">
                                </div> 
                        </div>
                                          <div class="col-md-6">
                                 <div class="form-group">
                             <label class="control-label">Lable 2 arabic</label>
                            <input type="text"  class="c-select form-control boxed" name="txt_label2_arabic" id="txt_label2_arabic" value="<?php echo $txt_label2_arabic;?>">
                                </div> 
                                          </div>
                                
                              
                                    
                              
                              
                              
           
            </div>
            <?php
                                                        if($permission->perm_add==1)
                                                        {
                                                        ?>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            <span id="registerLoader"></span>
            </div>
            <?php
                                                        }
            ?>
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
          
          txt_label1: 
          {
            required: true,
           maxlength:500,
          // lettersonly:true,
            
          },
          txt_label1_arabic: 
          {
            required: true,
            maxlength:500,
          },
            txt_label2: 
          {
            required: true,
            maxlength:500
          },
          txt_label2_arabic:
          {
               required: true,
             maxlength:500
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
             url: '<?php echo base_url();?>admin/C_admin/saveHomelabels',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                    $("#registerLoader").html("");
                    $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                     //console.log(data['status']);

                    if(data['status']==1)
                    {
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Saved Successfully!", "success");
                         // window.location= "<?php echo base_url();?>admin/package_list";  
                         
                         location.reload();
                     
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


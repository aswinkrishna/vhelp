<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Questions</h1>
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
                <div class="col-md-8 col-md-offset-12">
                    <a href="javascript:void(0)" class="addNewQues"> <button class="btn btn-primary" type="button">New Question</button></a>
                </div>
              </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
        </div>
     <?php
           
                     $label = "Add Questions";
                      if($id>0)
                      {
                               $label = "Edit Questions ";
                              
                               
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
            <h3 class="tile-title"> <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="dynamicForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_service_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     $timeStamp  =     date("YmdHis");
               ?>
                                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Parent question</label>
                                <textarea class="form-control boxed question" placeholder="" name="txtEnglish[][<?php echo $timeStamp;?>]" value="" maxlength="" id="txtEnglish<?php echo $timeStamp;?>"> </textarea>
                                 </div> 
                        </div>
                                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Parent  answer</label>
                                <textarea class="form-control boxed question" placeholder="" name="txtEnglish[][<?php echo $timeStamp;?>]" value="" maxlength="" id="txtEnglish<?php echo $timeStamp;?>"> </textarea>
                                 </div> 
                        </div>
                                   </div>
                   <div class="row">
                           <div class="col-md-3">
                                 <div class="form-group">
                                <label class="control-label">Question english</label>
                                <textarea class="form-control boxed question" placeholder="" name="txtEnglish[][<?php echo $timeStamp;?>]" value="" maxlength="" id="txtEnglish<?php echo $timeStamp;?>"> </textarea>
                                 </div> 
                        </div>
                  <div class="col-md-3">
                                 <div class="form-group">
                                <label class="control-label">Question arabic</label>
                                <textarea class="form-control boxed" placeholder="" name="txtArabic[][<?php echo $timeStamp;?>]" value="" maxlength="" id="txtArabic<?php echo $timeStamp;?>"> </textarea>
                                 </div> 
                        </div>
                       <div class="col-md-3">
                                 <div class="form-group">
                                <label class="control-label">Answer Input type</label>
                               <select class="c-select form-control boxed" name="txtInputType[][<?php echo $timeStamp;?>]" id="txtInputType<?php echo $timeStamp;?>">
                                      <option value="0">Sub heading</option>

                                      <?php


                             if(isset($form_control) && count($form_control)>0)
                             {
                              foreach($form_control as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo $rows->form_control_id; ?>" <?php  if($parentId==$rows->form_control_id){ echo "selected" ;} ?> ><?php echo $rows->form_control_name; ?></option>
                                       
                                       <?php
                                     }
                              }

                                       ?>
                                       
                                    </select>
                                 </div> 
                        </div>
                       
                        
                          <div class="col-md-1">
                                 <div class="form-group">
                                <label class="control-label">Answers</label>
                             <a class="btn btn-primary addAnswer" href="javascript:void(0)" title="add answer options" for="<?php echo $timeStamp;?>" id="btn_add_answer<?php echo $timeStamp;?>"><i class="fa fa-lg fa-plus"></i></a>
                                 </div> 
                        </div>
                        
                          <div class="col-md-1">
                                 <div class="form-group">
                                <label class="control-label">Sub ques</label>
                             <a class="btn btn-primary addSubQues" href="javascript:void(0)" title="add sub questions" for="<?php echo $timeStamp;?>" id="btn_sub_qes<?php echo $timeStamp;?>"><i class="fa fa-lg fa-plus"></i></a>
                                 </div> 
                        </div>
                          <div class="col-md-1">
                                 <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                   &nbsp;
                                 </div> 
                        </div>
                   </div>
                                <div  class="row dynamicAnswer" id="dynamicAnswer<?php echo $timeStamp;?>">
                                    
                                </div>
                                <div  id="dynamicNewQues1" class="dynamicNewQues">
                                    
                                </div>
                                <div  id="dynamicSubQues1" class="dynamicSubQues">
                                    
                                </div>
              </form>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>
        </div>
        
        
      </div>
    </main>
<script>         
    function validateForm()
    {
        
    }
    $(document).delegate(".addAnswer","click",function(e)
    {
       rowid = $(this).attr("for");
       //currentRow  = parseInt(rowid)+1;
       var html='  <div class="col-md-6">';
               html+=' <div class="form-group">';
                              html+='   <label class="control-label">Enter option values english</label>';
                            html+=' <input type="text" class="form-control boxed answerBox" placeholder="Enter values english" name="txtOptionEng['+rowid+'][]" value="" maxlength="100"> ';
                              html+='    </div> ';
                        html+=' </div>';
  html+='  <div class="col-md-6">';
               html+=' <div class="form-group">';
                              html+='   <label class="control-label">Enter option values arabic</label>';
                            html+=' <input type="text" class="form-control boxed answerBox" placeholder="Enter values arabic" name="txtOptionArabic['+rowid+'][]" value="" maxlength="100"> ';
                              html+='    </div> ';
                        html+=' </div>';
                        $("#dynamicAnswer"+rowid).append(html);
                        //$("#dynamicAnswer"+rowid).html(html);
      
    });
     $(document).delegate(".addSubQues","click",function(e)
    {
        
        
    });
  $(document).delegate(".addNewQues","click",function(e)
    {
        //  var numItems = $('.question').length;
        //alert(numItems);
       //  rowid = numItems;
       var dt = new Date();
       var  currentRow  = dt.getHours() + "" + dt.getMinutes() + "" + dt.getSeconds()+""+dt.getMilliseconds();
          var html ='  <div class="row '+currentRow+'"> <div class="col-md-3">';
               html+=' <div class="form-group">';
                              html+='   <label class="control-label">Question english</label>';
                                     html+='   <textarea class="form-control boxed question" placeholder="" name="txtEnglish[]['+currentRow+']" value="" maxlength="" id="txtEnglish1"> </textarea> ';
                              html+='    </div> ';
                        html+=' </div>';
                        html+='  <div class="col-md-3">';
               html+=' <div class="form-group">';
                              html+='   <label class="control-label">Question arabic</label>';
                                     html+='   <textarea class="form-control boxed" placeholder="" name="txtArabic[]['+currentRow+']" value="" maxlength="" id="txtArabic1"> </textarea> ';
                              html+='    </div> ';
                        html+=' </div>';
                                html+='  <div class="col-md-3">';
               html+=' <div class="form-group">';
                              html+='   <label class="control-label">Answer Input type</label>';
                                     html+='  <select class="c-select form-control boxed" name="txtInputType[]['+currentRow+']" id="txtInputType1">';
                                     html+=' <option value="0">Sub heading</option>';

                                      <?php


                             if(isset($form_control) && count($form_control)>0)
                             {
                              foreach($form_control as $rows) 
                                    {

                            ?>
                                       
                                   html+='       <option value="<?php echo $rows->form_control_id; ?>" <?php  if($parentId==$rows->form_control_id){ echo "selected" ;} ?> ><?php echo $rows->form_control_name; ?></option>';
                                       
                                       <?php
                                     }
                              }

                                       ?>
                                       
                                    html+='  </select> ';
                              html+='    </div> ';
                        html+=' </div>';
                           html+='  <div class="col-md-1">';
                         html+=' <div class="form-group">';
                              html+='   <label class="control-label">Answers</label>';
                                     html+='    <a class="btn btn-primary addAnswer" href="javascript:void(0)" title="add answer options" for="'+currentRow+'" id="btn_add_answer'+currentRow+'"><i class="fa fa-lg fa-plus"></i></a> ';
                              html+='    </div> ';
                        html+=' </div>';
                         html+='  <div class="col-md-1">';
                         html+=' <div class="form-group">';
                              html+='   <label class="control-label">Sub ques</label>';
                                     html+='   <a class="btn btn-primary addSubQues" href="javascript:void(0)" title="add sub questions" for="'+currentRow+'" id="btn_sub_qes'+currentRow+'"><i class="fa fa-lg fa-plus"></i></a>';
                              html+='    </div> ';
                        html+=' </div>';
                           html+='  <div class="col-md-1">';
                         html+=' <div class="form-group">';
                              html+='   <label class="control-label">Remove</label>';
                                     html+='   <a class="btn btn-primary removeSubQues" href="javascript:void(0)" title="Remove questions" for="'+currentRow+'" id="btn_rem_sub_qes'+currentRow+'"><i class="fa fa-lg fa-minus"></i></a> ';
                              html+='    </div> ';
                        html+=' </div></div>';
                          
                               html+=' <div  class="row '+currentRow+'" id="dynamicAnswer'+currentRow+'">  </div>';
                                    
                              
                                html+='  <div class="'+currentRow+'" id="dynamicNewQues'+currentRow+'"> </div>';
                                    
                               
                               html+='   <div class="'+currentRow+'"  id="dynamicSubQues'+currentRow+'"></div>';
                                    
                          $( ".dynamicNewQues" ).last().append(html);     
                       //  $("#dynamicNewQues"+rowid).append(html);
        
    });
     $(document).delegate(".removeSubQues","click",function(e)
    {
        rowid = $(this).attr("for");
        $("."+rowid).remove();
        
    });
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
              onfocusout: false,
           onkeyup :false,
             onclick :false,
               onchange :false,
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
           txtmethod: 
          {
            required: true,
            number:true
          },
          txt_commission:
          {
            required: true,
            number:true
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
                  formData.append('serviceTypeId',<?php echo $this->common_functions->decryptId($this->uri->segment(3));?>); 
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveDynamicForm',
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
                       //    window.location= "<?php echo base_url();?>admin/service_type_list";    
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
 </script>


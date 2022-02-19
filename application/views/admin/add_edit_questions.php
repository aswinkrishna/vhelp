<?php 
//echo $has_child;exit;
?>
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
           
                     $label = "Add Questions";
                     $saveButtonName  = "Add";
                      if($question_id>0)
                      {
                               $label = "Edit Questions ";
                               $saveButtonName  = "Update";
                              $records1 = $records1[0];
                               
                                $englishName                 =   $records1->question;
                                $arabicName                   =   $records1->question_arb;
                                $parentId                         =   $records1->question_parent_id;
                                $parentIdAns                  =   $records1->answer_parent_id;
                                $status                              =   $records1->question_status;
                                $inputType                       =   $records1->question_form_type;
                      }
                      else
                      {
                                $englishName                 =   "";
                                $arabicName                   =   "";
                                $parentId                         =   "";
                                $parentIdAns                  =  "";
                                $status                              =   "";
                                $inputType                       =   "";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title"> <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="dynamicForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                  
                    
                    if($service_type_id>0)
                      {
                        
                      
                        
                        ?>
                        <input type="hidden" class="form-control boxed" placeholder="" name="txt_service_id" value="<?php echo $service_type_id; ?>"> 
                        <?php
                      
                      } 
                        if($question_id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_question_id" value="<?php echo $question_id; ?>"> 
                        <?php
                      
                      } 
                     $timeStamp  =     date("YmdHis");
               ?>
                                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Parent question</label>
                             <select class="c-select form-control boxed" name="txtParentQuest" id="txtParentQuest">
                                      <option value="0">No parent</option>

                                      <?php
                                      
                                      if($parentId>0)
                                      {
                                          $con123['question_id']                        =         $parentId;
                                           $answers                                                 =         $this->M_admin->getAnswers($con123);
                                      }
                                      else
                                      {
                                          $answers     = array();
                                      }


                             if(isset($form_questions) && count($form_questions)>0)
                             {
                              foreach($form_questions as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo $rows->question_id; ?>" <?php  if($parentId==$rows->question_id){ echo "selected" ;} ?> ><?php echo $rows->question; ?></option>
                                       
                                       <?php
                                     }
                              }

                                       ?>
                                       
                                    </select>
                                 </div> 
                        </div>
                                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Parent  answer</label>
                              <select class="c-select form-control boxed" name="txtParentAnswer" id="txtParentAnswer">
                                      <option value="0">No parent</option>

                                      <?php


                             if(isset($answers) && count($answers)>0)
                             {
                              foreach($answers as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo  $rows->answer_options_id ?>" <?php  if($parentIdAns==$rows->answer_options_id){ echo "selected" ;} ?> ><?php echo $rows->answer_option; ?></option>
                                       
                                       <?php
                                     }
                              }

                                       ?>
                                       
                                    </select>
                                 </div> 
                        </div>
                                   </div>
                   <div class="row">
                           <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Question english</label>
                                <textarea class="form-control boxed question" placeholder="" name="txtEnglish" value="" maxlength="" id="txtEnglish<?php echo $timeStamp;?>"><?php echo $englishName;?></textarea>
                                 </div> 
                        </div>
                  <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Question arabic</label>
                                <textarea class="form-control boxed" placeholder="" name="txtArabic" value="" maxlength="" id="txtArabic<?php echo $timeStamp;?>"><?php echo $arabicName;?></textarea>
                                 </div> 
                        </div>

                        <input type="hidden" name="txtInputType" id="txtInputType" value="4">
                        
                       <div class="col-md-3">
                                 <div class="form-group">
                                <label class="control-label">Answer Input type</label>
                               <select class="c-select form-control boxed" name="txtInputType" id="txtInputType" <?php echo $has_child>0?"":""?>>
                                      <option value="">Select</option>

                                      <?php
                                      
                                      


                             if(isset($form_control) && count($form_control)>0)
                             {
                              foreach($form_control as $rows) 
                                    {
                                        
                                        if($has_child>0)
                                      {
                                          if($inputType==$rows->form_control_id)
                                          {
                                          ?>
                                            <option value="<?php echo $rows->form_control_id; ?>" <?php  if($inputType==$rows->form_control_id){ echo "selected" ;} ?> ><?php echo $rows->form_control_name; ?></option>
                                          <?php
                                      }
                                          
                                      }
                                      else
                                      {
                            ?>
                                       
                                        <option value="<?php echo $rows->form_control_id; ?>" <?php  if($inputType==$rows->form_control_id){ echo "selected" ;} ?> ><?php echo $rows->form_control_name; ?></option>
                                       
                                       <?php
                                      }
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
<!--                        
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
                        </div>-->
                   </div>
                                
                                <div  id="dynamicNewQues1" class="row">
                                     <?php
                                    if(count($records2)>0)
                                    {
                                        $p=1;
                                        foreach($records2 as $rows)
                                        {
                                            ?>
                                    <div class="col-md-4 deleteClass<?php echo $p;?>">
               <div class="form-group">
                            <label class="control-label">Enter option values english</label>
                            <input type="hidden" class="form-control boxed answerBox"  name="txtOptionoldid[]" value="<?php echo $rows->answer_options_id ?>" maxlength="100">
                            <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" placeholder="Enter values english" name="txtOptionEng[]" value="<?php echo $rows->answer_option ?>" maxlength="100">
                              </div>
                    </div>
            
           <div class="col-md-4 deleteClass<?php echo $p;?>">
             <div class="form-group">
                           <label class="control-label">Enter option values arabic</label>
                           <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" placeholder="Enter values english" name="txtOptionArabic[]" value="<?php echo $rows->answer_option_arabic ?>" maxlength="100"> 
                              </div> 
                     </div>
            <div class="col-md-2 deleteClass<?php echo $p;?>">
             <div class="form-group">
                           <label class="control-label">Price</label>
                           <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode ==46)" placeholder="Price" name="txtOptionPrice[]" value="<?php echo $rows->price ?>" maxlength="7"> 
                              </div> 
                     </div>
               <div class="col-md-2 deleteClass<?php echo $p;?>">
                    <div class="form-group">
                           <label class="control-label">Delete</label><br>
                          <a class="btn btn-primary deleteAnswer" href="javascript:void(0)" title="delete answer options" for="<?php echo $p;?>" id="btn_delete_answer<?php echo $timeStamp;?>"><i class="fa fa-lg fa-minus"></i></a>
                         </div>
                        </div>
                                    <?php
                                         $p++;   
                                        }
                                        
                                    }
                                    
                                    ?>
                                    
                                </div>
                                <div  class="row dynamicAnswer" id="dynamicAnswer<?php echo $timeStamp;?>">
                                   
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
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            <span id="registerLoader"></span>
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
       
          var dt = new Date();
       var  currentRow  = dt.getHours() + "" + dt.getMinutes() + "" + dt.getSeconds()+""+dt.getMilliseconds();
        var conveniancecount = $(".deleteAnswer").length;
        nextElement = parseInt(conveniancecount)+1;
        //alert(currentRow);
       rowid = $(this).attr("for");
       //alert(rowid);
       //currentRow  = parseInt(rowid)+1;
        var html='  <div class="col-md-4 deleteClass'+currentRow+'"">';
            html+=' <div class="form-group">';
            html+='   <label class="control-label">Enter option values english</label>';
            html+=' <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" placeholder="Enter values english" name="txtOptionEng[]" value="" maxlength="100"> ';
            html+='    </div> ';
            html+=' </div>';
                        
          html+='  <div class="col-md-4 deleteClass'+currentRow+'"">';
          html+=' <div class="form-group">';
          html+='   <label class="control-label">Enter option values arabic</label>';
          html+=' <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" placeholder="Enter values arabic" name="txtOptionArabic[]" value="" maxlength="100"> ';
          html+='    </div> ';
          html+=' </div>';

          html+='  <div class="col-md-2 deleteClass'+currentRow+'"">';
          html+=' <div class="form-group">';
          html+='   <label class="control-label">Price</label>';
          html+=' <input type="text" class="form-control boxed answerBox answerBoxVal dynamicValues" placeholder="Price" name="txtOptionPrice[]" value="" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode ==46)" maxlength="7"> ';
          html+='    </div> ';
          html+=' </div>';
                        
          html+='  <div class="col-md-2 deleteClass'+currentRow+'">';
          html+=' <div class="form-group">';
          html+='   <label class="control-label">Delete</label><br>';
          html+='<a class="btn btn-primary deleteAnswer" href="javascript:void(0)" title="delete answer options" for="'+currentRow+'"" id="btn_delete_answer<?php echo $timeStamp;?>"><i class="fa fa-lg fa-minus"></i></a> ';
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
           maxlength:1000,
          // lettersonly:true,
            
          },
          txtArabic: 
          {
            required: true,
            maxlength:1000,
          },
           txtInputType: 
          {
            required: true
          },
          /*'txtOptionEng[]':
          {
             selectAnswer:true 
          },*/
          txtParentAnswer: 
          {
            selectParentAnswer: true
          }
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {
            
            $('label.error').remove();
            var totalError = 0;

            if($('input.dynamicValues').length > 0)
            {
                $('input.dynamicValues').each(function(){
                if($(this).val().trim()=="")
                {
                  totalError++;
                  $(this).after('<label class="error">This field is required.</label>');
                }
              });
            }
            else
            {
              totalError=1;
              swal("Atleast one answer option is needed");
              return false;
            }
            
            if(totalError==0)
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
                        answer =0;
                        var collection = $(".answerBoxVal");
                        collection.each(function() {
                            answer =1;
                            if($(this).val()=="")
                            {
                                textbOXEmpty =1;
                            }
                        }); 
    
                        qtype =  $('#txtInputType').val(); 
          
                        if(qtype!=6 && qtype!=1 && answer==0)
                        {
                            $("#registerLoader").html("");
                                        $('#btnRegister').prop("disabled", false);
                            swal("Atleast one answer is needed");
                            return false;
                        }
    
                        $("#registerLoader").html("");
                        $('#btnRegister').prop("disabled", false);
                        data =  jQuery.parseJSON(data);
    
                        if(data['status']==1)
                        {
                             $(".error").html("");// clear all errors
                              swal("Well done!", "Saved Successfully!", "success");
                           //    window.location= "<?php echo base_url();?>admin/service_type_list";    
                           location.reload();
                        }
                        else if(data['status']==0)
                        {
                            if(data['errors'] !== "")
                            {
                                $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                    $('[name='+key+']').parents('.form-group').find('.error').html(value);
                                });                          
                            }
                            else
                            {
                               swal("Sorry!", "Failed to save! Try again later", "error");
                            }
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }


                
            
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

 $(document).delegate(".deleteAnswer","click",function(e)
    {
        rowid = $(this).attr("for");
        $(".deleteClass"+rowid).remove();
        
    });
    $( document ).ready(function() {
   jQuery.validator.addMethod("selectAnswer", function(value, element, parameter) 
   {
     //  alert();
       textbOXEmpty =0;
       answer =0;
      var collection = $(".answerBoxVal");
collection.each(function() {
    answer =1;
    if($(this).val()=="")
    {
        textbOXEmpty =1;
    }
}); 
      qtype =  $('#txtInputType').val(); 
      
    if(qtype!=6 && qtype!=1 && textbOXEmpty==1)
    {
        return false;
    }
    else if(qtype!=6 && qtype!=1 && answer==0)
    {
        return false;
    }
    else
    {
    return true;
    }
}, "Fill all answer options");
jQuery.validator.addMethod("selectParentAnswer", function(value, element, parameter) 
   {
     //  alert();
      
     var parentQues =  $('#txtParentQuest').val(); 
     var parentAn =  $('#txtParentAnswer').val(); 
      
    if(parentQues>0 && parentAn<=0)
    {
        return false;
    }
    else
    {
    return true;
    }
}, "Select Parent answer");
});
    
 </script>


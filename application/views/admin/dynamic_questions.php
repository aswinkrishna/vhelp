<?php
if(count($questions) > 0 )
{
      $languageCode               =   ($this->session->userdata('language')==2?$this->session->userdata('language'):1); 
      $k=0;
    foreach($questions as $rows)
    {
        $con['question_id']    = $rows->question_id;
        $answers =   $this->M_admin->getAnswers($con)     ;        
        //print_r($answers);
    ?>
<div class="col-md-6" id="dyanmicDiv<?php echo $rows->question_id ?>">
                                 <div class="form-group">
                                <label class="control-label"><?php echo $languageCode==2?$rows->question_arb:$rows->question ?></label>
                                <?php
                                if($rows->question_form_type==1)
                                {
                                ?>
                                 <input type="text" class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php  echo $k?>" value="" maxlength="100" autocomplete="off">
                                <?php
                                }
                               
                              else  if($rows->question_form_type==6)
                                {
                                ?>
                                 <textarea class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php  echo $k?>" value=""  autocomplete="off"></textarea>
                                <?php
                                }
                                else if($rows->question_form_type==2)
                                {
                                ?>
                                <select class="form-control dynamicQues" for="<?php echo $rows->question_id ?>"    name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php  echo $k?>">
                                    <option value="">Select</option>
                                    <?php
                                    if(count($answers)>0)
                                    {
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows2->answer_options_id ?>" ><?php  echo $rows2->answer_option ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                                <?php
                                }
                                 else if($rows->question_form_type==4)
                                {
                                      if(count($answers)>0)
                                    {
                                          ?>
                                 <div class="form-check">
                                 <?php
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                          
                     <label class="form-check-label">
                      <input class="form-check-input dynamicQues" for="<?php echo $rows->question_id ?>" id="dynamicQues<?php  echo $k?>" name="question[<?php echo $rows->question_id ?>][]" type="radio" value="<?php  echo $rows2->answer_options_id ?>" data-error="#errNmQ<?php echo $rows->question_id ?>"><?php  echo $rows2->answer_option ?>
                    </label>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                                    <?php
                                        }
                                        ?>
                                 <span id="errNmQ<?php echo $rows->question_id ?>"></span>
                               </div>
                                        <?php
                                    }
                                }
                                else if($rows->question_form_type==5)
                                {
                                      if(count($answers)>0)
                                    {
                                          ?>
                                 <div class="form-check">
                                 <?php
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                          
                    <label class="form-check-label">
                      <input class="form-check-input dynamicQues" for="<?php echo $rows->question_id ?>" id="dynamicQues<?php  echo $k?>" name="question[<?php echo $rows->question_id ?>][]" type="checkbox" value="<?php  echo $rows2->answer_options_id ?>" data-error="#errNmQ<?php echo $rows->question_id ?>"><?php  echo $rows2->answer_option ?>
                    </label>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                                    <?php
                                        }
                                        ?>
                                 <span id="errNmQ<?php echo $rows->question_id ?>"></span>
                               </div>
                                        <?php
                                    }
                                }
                                else if($rows->question_form_type==3)
                                {
                                    ?>
                                 <select class="form-control demoSelect dynamicQues" for="<?php echo $rows->question_id ?>" name="question[<?php echo $rows->question_id ?>][]" multiple="multiple" id="dynamicQues<?php  echo $k?>">
                <optgroup label="Select answer">
                  <?php
                  if(count($answers)>0)
                                    {
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows2->answer_options_id ?>" ><?php  echo $rows2->answer_option ?></option>
                                    <?php
                                        }
                                    }
                  ?>
                </optgroup>
              </select>
                                 <?php
                                }
                                ?>
                                 </div> 
                        </div>
<div id="dyanmicSpan<?php echo $rows->question_id ?>" ></div>
<?php
$k++;
    }
}
?>


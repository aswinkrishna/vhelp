<?php
 $cityId = $_GET['c'];
if($cityId>0)
{
  $labelHead = " in ".$this->M_common->getCityName($cityId);
}
else 
{
    $labelHead  = "";
}

$defaultLattittude = "25.204849";
$defaultlongittude = "55.270782";
$defaultLocation   ="Dubai - United Arab Emirates";
$defaultCity       ="Dubai"; 
$defaultState      = "United Arab Emirates";

$language          = $this->session->userdata("language")>0? $this->session->userdata("language"):1;       

?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
    .summery_row h3
    {
        color:white !important;
    }
    .slot_disabled{
        background: #299a06 !important;
        color: #1e7504 !important;
        cursor: not-allowed !important;
    }
    /* .summaryUl
    {
        display:none;
    }*/
</style>
<section class="">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row housecleaning_banner arc_concultency" style="background:url(<?php echo $baner_image;?>);">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    
                    <div class="col-md-9 auto">
                    <h3><?php  echo $question_list->service_type_name;?></h3>

                    <h5><?php echo $question_list->sub_label ?></h5>                        

                    </div>

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end banner section-->


<!--start section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row tab_padd">
                    
                    <!-- <div class="col-md-12 tab_menu_box">
                        <ul class="nav nav-pills n" id="pills-tab" role="tablist">
                      <li class="nav-item tab-nav tab1">
                           <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#homecleaning" role="tab" aria-controls="pills-home" aria-selected="true"><aside></aside>  <?php  echo $question_list->service_type_name;?></a>
                      </li>
                      <li class="nav-item tab-nav tab2">
                           <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#description" role="tab" aria-controls="pills-profile" aria-selected="false"><aside></aside>  Description </a>
                     </li>
                     
                      <li class="nav-item tab-nav tab3">
                           <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#faq" role="tab" aria-controls="pills-contact" aria-selected="false"><aside></aside>  Faq</a>
                      </li>
                      
                      
                      <li class="nav-item tab-nav tab4">
                           <a class="nav-link" id="ri" data-toggle="pill" href="#review" role="tab" aria-controls="pills-contact" aria-selected="false"><aside></aside>  Review</a>
                      </li>
                   </ul>
                    </div> -->

                   <!--start tab-->
                   
                   
                   
                   
<div class="tab-content container-fluid" id="pills-tabContent">
 
 
 <!--tab 1-->                          
<div class="tab-pane  show active row tab_content_padd " id="homecleaning" role="tabpanel" aria-labelledby="pills-home-tab">
    <h4 class="service-title"> <?php  echo $question_list->service_type_name;?></h4>
  <!--start col md 11-->
     <div class="col-md-11 auto">
      

     <div class="line-hr"></div>
     <div class="row tab_inner">
         
         <div class="bullet need-user first-bullet"> <span>Your needs</span> </div>
         <div class="bullet location-selection pan" id="locationPan"> <span>your location</span> </div>
         <div class="bullet payment-selection pan" id="selectOption"> <span>Quotation / Select Provider</span> </div>
         <div class="bullet done pan" id="page-succes"> <span>done</span> </div>
     </div>

     </div><!--end col md 11-->
     
 <!--start page wrapp-->
 <div class="pageWrapp questionArea" id="questionArea">

     
 <div class="col-md-12 auto">
     
     <!--start container fluid-->
     <div class="container-fluid">
         <!--start row-->
         <div class="row row_margin_top">
             
            <input type="hidden" value="1" id="currentQyestion">
            <form id="dynamicForm" class="col-md-8 col-sm-6 select_services">
            
            <div class="choose_options col-md-8 col-sm-6 select_services" id="requestModePanel">
                <aside class="steps stepsfield step_uploads">
                    <div class="col-md-12">
                        <div class="radiobuttons shedule-management-set">
                              
                            <div class="rdio rdio-primary radio-inline"> 
                                <input name="service_request_type" value="<?=REQUESTMODE_ONETIME?>" id="radio1" type="radio" checked>
                                <label for="radio1">
                                    <div class="managment-wrapper">
                                        <img src="<?php echo base_url();?>frontend_assets/images/icons/time-s.png"/>
                                        <div>
                                            <h5> One Time <span>Service</span></h5>                                     
                                        </div>
                                    </div>                                    
                                </label>
                            </div>
                            
                            <div class="rdio rdio-primary radio-inline" style="<?=($service_details->is_weekly_available == 0)? 'display: none;':''?>">
                                <input name="service_request_type" value="<?=REQUESTMODE_WEEKLY?>" id="radio2" type="radio">
                                <label for="radio2">
                                    <div class="managment-wrapper">
                                        <img src="<?php echo base_url();?>frontend_assets/images/icons/weekly.png"/>
                                        <div>
                                            <h5>Weekly <span>Service</span></h5>                                     
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="rdio rdio-primary radio-inline" style="<?=($service_details->is_monthly_available == 0)? 'display: none;':''?>">
                                <input name="service_request_type" value="<?=REQUESTMODE_MONTHLY?>" id="radio3" type="radio">
                                <label for="radio3">
                                     <div class="managment-wrapper">
                                        <img src="<?php echo base_url();?>frontend_assets/images/icons/monthly.png"/>
                                        <div>
                                            <h5> Monthly <span>Service</span></h5>                                 
                                        </div>
                                    </div>
                                </label>
                            </div>         

                        </div>
                    </div>  
                </aside>
                <div class="row">                
                     <div class="col-md-4">
                        <span href="#" class="continue" id="requestModeNext">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
                     </div>
                </div>
            </div>   
                
           <!--start col md 8-->
            <div class="col-md-8 col-sm-6 select_services" id="dynamicQuestionArea" style="display:none;">
                 
             <?php
             $language           = $this->session->userdata("language")>0? $this->session->userdata("language"):1;     
             $i=1;
             $is_home_category =0;
             // print_r($question_list);
             if (count($question_list)>0)
             {
              
                    $rows = $question_list;
                      $is_home_category  = $rows->is_home_category;
                 if($i==1)
                 {
                     $style= "";
                 }
                 else
                 {
                     $style ="none";
                 }
                 $con['question_id']    =  $rows->question_id;
                  $answers                     =   $this->M_request->getAnswers($con)     ; 
                  
                   if($rows->question_parent_id<=0)
                   {
                        $lastParent  =  $rows->question_id;
                   }
                   else
                   {
                        $lastParent  =  $rows->question_id;
                   }
             ?>
<!--start row-->
<span id="span<?php echo $rows->question_id ?>" class="commonDisplayQuestion">
<div class="row choose_options" style="display:<?php echo $style;?>" id="div<?php echo $rows->question_id ?>" data-element-type="<?=$rows->question_form_type?>">
<h3><?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?></h3>

    
      <?php
      $k=1;
                            if($rows->question_form_type==1)
                                {
                                ?>
                              
                                 <input type="text" class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>" value="" maxlength="100" autocomplete="off" style="display:block">
                                <?php
                                }
                                else  if($rows->question_form_type==6)
                                {
                                ?>
                                 <textarea class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>" value=""  autocomplete="off"></textarea>
                                <?php
                                }
                                    if(count($answers)>0)
                                    {
                                        
                                        if($rows->question_form_type==2 || $rows->question_form_type==3)
                                   {
                                    ?>
                                    <select class="form-control dynamicQues" for="<?php echo $rows->question_id ?>"    name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>" <?php echo $rows->question_form_type==3?"multiple":"" ?>>
                                    <option value="">Select</option>
                                   <?php
                                   }
                                 /*   if($rows->question_form_type==4)
                                {
                                    ?>
                                   <ul class="options">     
                                   <?php
                                }else if($rows->question_form_type==5)
                                {
                                  ?>
                                    <ul class=""> 
                                  <?php
                                }
                                        */
                                        ?>
                                        <ul class="options">   
                                        <?php
                                        foreach($answers as $rows2)
                                        {
                                    ?>
<li>
    <?php
    
    if($rows->question_form_type==4)
                                {
                                   
    ?>
 <input data-question="<?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?>" data-text="<?php  echo $rows2->answer_option ?>"  for="<?php echo $rows->question_id ?>" id="dynamicQues<?php  echo $rows2->answer_options_id ?>" name="question[<?php echo $rows->question_id ?>][]" type="radio" value="<?php  echo $rows2->answer_options_id ?>" data-error="#errNmQ<?php echo $rows->question_id ?>" data-price="<?php  echo $rows2->price ?>" class="hide radio<?php echo $rows->question_id ?> answerRadios"  >
  <label for="dynamicQues<?php  echo $rows2->answer_options_id ?>"><?php  echo $rows2->answer_option ?></label>   
   
  <?php
                                 }
                                  if($rows->question_form_type==5)
                                {
                                   
    ?>
    
                  <label class="form-check-label"> <input class="form-check-input dynamicQues radio<?php echo $rows->question_id ?> answerCheck" data-text="<?php  echo $rows2->answer_option ?>" for="<?php echo $rows->question_id ?>" id="dynamicQues<?php  echo $k?>" name="question[<?php echo $rows->question_id ?>][]" type="checkbox" value="<?php  echo $rows2->answer_options_id ?>" data-error="#errNmQ<?php echo $rows->question_id ?>" data-price="<?php  echo $rows2->price ?>" data-question="<?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?>" > <?php  echo $rows2->answer_option ?> <span class="dynamicCheckSpan"></span>  </label>  
  <?php
                                 }
                                 else if($rows->question_form_type==2)
                                 {
                                     ?>
                                      <option value="<?php  echo $rows2->answer_options_id ?>"  data-text="<?php  echo $rows2->answer_option ?>" data-price="<?php  echo $rows2->price ?>"><?php  echo $rows2->answer_option ?></option>
                                     <?php
                                     
                                 }
                                 ?>

</li>
 <?php
 $k++;
                                        }
                                        
                                        
                                       if($rows->question_form_type==2)
                                   {
                                       ?>
                                       </select>
                                       <?php
                                   }
                                        
                                        
                                    }
                                    ?>

</ul>
 
</div>
   <div class="row">
       <?php
        if ($rows->question_id>0)
             {
                 ?>
             
            <div class="col-md-12">               
                <?php
                if($service_details->is_weekly_available != 0 && $service_details->is_weekly_available !=0)
                {
                    ?><span href="#" class="continue back" style="margin-right: 30px;" id="backtoRequestMode"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back</span>
                    <?php 
                }
                ?>
            
                <span style="visibility:hidden;" id="firstButton" href="#" class="continue btnCountinue" id="next<?php echo $rows->question_id ?>" data-qtype="<?php echo $rows->question_form_type;?>" data-offset="0" data-current="<?php echo $rows->question_id ?>"  data-parent="<?php echo $lastParent ?>">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
     </div>
      <?php
               $remarkStyle = "display: none;";
             }
             else
             {
                $remarkStyle = "display: block;"; 
             }
                 ?>
    </div>
</span>
<?php
$i++;
   
}

?>

</div>
            </form>
<!-- Step 4 -->

<div class="choose_options col-md-8 col-sm-6 select_services" id="Upload_section" style="<?php echo $remarkStyle;?>">
<!-- <h1>File Upload!</h1>-->

<aside class="steps stepsfield step_uploads">
       <div class="form-group">
                                        <label class="col-form-label">Describe the task or project in more details *</label>
                                        <textarea class="form-control" id="txtRemark" placeholder=""></textarea>
                                        <span style="display: none;color: red;" class="txtRemarkError">This field is required.</span>


                                    </div>
    <label class="col-form-label">Please upload the relevant documents (Optional) </label>
    
<div class="bootstrap-filestyle input-group">
    <div class="custom-file">
<!--  <input type="file" class="custom-file-input" id="customFile" disabled>-->
 <label class="custom-file-label" for="customFile1" id="labelcustomFile1">Upload Your File</label>
  <input type="file" class="custom-file-input" id="customFile1" name="document">
 
  <span class="buttonText" style="display:none"><i class="fa fa-plus"></i></span>
</div>
<!--    <input type="text" class="form-control" id="filepath" placeholder="Upload Your File" disabled=""> -->
    <span class="group-span-filestyle input-group-btn AddRow" tabindex="0" style="display:none">
        <label for="filestyle-0" class="btn btn-default "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> 
        <span class="buttonText"><i class="fa fa-plus"></i></span></label>
    </span>
    <span class="fileUplaodWarning instruction">Max upload size:20MB, (pdf,doc,jpg,jpeg,png)</span>
    </div>
  <!--  <div class="input-group filestyle-group">
        <input type="file" class="filestyle" placeholder="Text" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" ><div class="bootstrap-filestyle input-group">
                                            <input type="text" class="form-control" id="filepath" placeholder="Upload Your File"  disabled="disabled">
                                            <span class="group-span-filestyle input-group-btn" tabindex="0">
                                                <label for="filestyle-0" class="btn btn-default "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText"><i class="fa fa-plus"></i></span></label></span></div>
                                    </div>-->

                                 

                                </aside>
<div class="row">
    
   <?php
        if ($rows->question_id>0)
             {
                 ?>
    <div class="col-md-4" id="divBackFromRemark">
            <span href="#" class="continue back" id="backFromRemark"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back</span>
          
     </div>   
     
     <?php
             }
     ?>
     <div class="col-md-4">
<!--            <span href="#" class="continue back" id="back-3"><span><img src="images/icons/right-arow.png"/></span> Back</span>-->
            <span href="#" class="continue" id="fileUploadNext">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
     </div>
</div>
</div>
<!--end row-->
 <!--start col md 4-->
             <div class="col-md-4 col-sm-6">
                 <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                     <div class="call-center-pattern"></div>
                     <h3>Service Summary</h3>
                     <span class="spanSummery">
                            <ul class="summaryUl">
                                  <p class="noselect">You didn't choose any Services</p>
                            </ul>
                     </span>
                     <p class="serviceTotPrice"><strong></strong></p>

                 </div>
                 
                 

                 <!--end summery_row-->
                 <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
                 </div>
             </div>
             <!--end col md 4-->
             </div>
             <!--end col md 8-->
             
            
            
         </div>
         <!--end row-->
         
         
     </div>
     </div>
     <!--end container fluid-->
     
     
     <?php 
     if($is_home_category==1)
     {
     ?>
     
 <!--start page wrapper 2-->
 <div class="pageWrapp page-ctrl locationPan">
  <div class="select_services">
  <h3>Please choose your location</h3>
<br>
     
</div>   
 <div class="row">
 <div class="col-md-8">
<!--
     <div class="row">
         <div class="col-sm">
             <div class="location_button active">
                 <span class="icons"><img src="images/icons/home_work.png" /></span>
                 <span>Home</span>
             </div>
         </div>
         <div class="col-sm">
             <div class="location_button">
                 <span class="icons"><img src="images/icons/work_whit.png" /></span>
                 <span>Work</span>
             </div>
         </div>
         <div class="col-sm">
             <div class="location_button">
                 <span class="icons"><img src="images/icons/other_works.png" /></span>
                 <span>Other</span>
             </div>
         </div>
     </div>
-->
<!--     <h1>Page2</h1>-->
     <div class="card_step ">
         <div class="row">
             <div class="col-md-6">
                 <div class="calender_wrap">
<!--                     <h3>Select Date</h3>-->
<!--                     <div id="my-calendar"></div>-->
                     <div class="map">
                        <div id="MAP1" style="width: 100%; height: 280px;"></div>
                     </div>

                 </div>
             </div>
             <div class="col-md-6">
             <div class="form">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Street:</div>
                                                </div>
                                                <input class="form-control autocomplete" id="us5-street1" name="us5-street1" value="<?php echo $defaultLocation;?>" >
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">City:</div>
                                                </div>
                                                <input class="form-control" id="us5-city" name="us5-city"  disabled="disabled" value="<?php echo $defaultCity;?>" >
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">State or Province:</div>
                                                </div>
                                                <input class="form-control" id="us5-state" name="us5-state"  disabled="disabled" value="<?php echo $defaultState;?>">
                                            </div>
                                            <div class="input-group mb-3 d-none">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Postal code:</div>
                                                </div>
                                                <input class="form-control" id="us5-zip" disabled="disabled">
                                            </div>
                                            <div class="input-group mb-3 d-none">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Country:</div>
                                                </div>
                                                <input class="form-control" id="us5-country" disabled="disabled">
                                            </div>
                  <input  type="hidden" class="form-control" id="us2-lat"  name="us2-lat" value="<?php echo $defaultLattittude;?>">
                   <input type="hidden" class="form-control" id="us2-lon"  name="us2-lon" value="<?php echo $defaultlongittude;?>">
             
                                        </div>
<!--
                 <div class="select_time">
                     <h3>Select Time</h3>
                     <div class="time_slotes owl-carousel">
                         <span class="badge active badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                     </div>
                 </div>
                 <div class="price_range">
                     <h3>Price Range</h3>
                      <div id="time-range">
    
    <div class="sliders_step1">
        <div id="slider-range"></div>
    </div>
    <div class="price_wrap">
        <p class="slider-amount-1">Min Price <span>AED 100</span></p>
        <p class="slider-amount-2">Max Price <span>AED 3000</span></p>
    </div>
</div>
                 </div>
-->
                 
                 <div class="time_date">
                    <div class="row">
                     <div class="col-sm-6">
                         <h3>Work Expiry Date</h3>
                        <div class="form-group">
                            <div class="input-group date" data-target-input="nearest">
                                <input type="text" id="datetimepicker4" class="form-control datetimepicker-input" data-target="#datetimepicker4" placeholder="" readonly />
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         <h3>Work Expiry Time</h3>
                        <div class="form-group">
                            <div class="input-group date" data-target-input="nearest">
                    <input type="text" id="datetimepicker3" class="form-control datetimepicker-input" data-target="#datetimepicker3" placeholder=""/>
                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                </div>
                        </div>
                    </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
        <div class="row">
        <div class="col-md-4">
                 <span href="#" style="margin-right: 11px;width;auto" class="continue back" id="homeSettingsBack"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back
                
         </div>
          <div class="col-md-4">
                 
                 &nbsp;<span style="margin-right: 11px;width;auto" href="#" class="continue" id="btnLocationNext">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
         </div>
         
         </div>
     </div>
     <div class="col-md-4">
         <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                     <h3>Service Summary</h3>
                     
                     <span class="spanSummery">
                      <ul class="summaryUl">
                                  <p class="noselect">You didn't choose any Services</p>
                            </ul>
                     </span>
                     <p class="serviceTotPrice"><strong></strong></p>

                 </div>
                 
                 <!--end summery_row-->
                   <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
                 </div>
     </div>
 </div>
 </div>
 
 <?php
     }else
     {
 ?>
 <div class="pageWrapp page-ctrl  locationPan">
 <div class="row">
 <div class="col-md-8">
     <!--<div class="row">-->
     <!--    <div class="col-sm">-->
     <!--        <div class="location_button active" for="1">-->
     <!--            <span class="icons"><img src="<?php echo base_url();?>frontend_assets/images/icons/home_work.png" /></span>-->
     <!--            <span>Home</span>-->
     <!--        </div>-->
     <!--    </div>-->
     <!--    <div class="col-sm">-->
     <!--        <div class="location_button" for="2">-->
     <!--            <span class="icons"><img src="<?php echo base_url();?>frontend_assets/images/icons/work_whit.png" /></span>-->
     <!--            <span>Work</span>-->
     <!--        </div>-->
     <!--    </div>-->
     <!--    <div class="col-sm">-->
     <!--        <div class="location_button" for="3">-->
     <!--            <span class="icons"><img src="<?php echo base_url();?>frontend_assets/images/icons/other_works.png" /></span>-->
     <!--            <span>Other</span>-->
     <!--        </div>-->
     <!--    </div>-->
     <!--</div>-->
     
     
<!--     <h1>Page2</h1>-->

      <div class="radio-wrapper" style="display:none;">
         <div class="row">
            <div class="col-md-12">
                <div class="radiobuttons shedule-management-set">
                        
                        <!--
                        <div class="rdio rdio-primary radio-inline"> 
                            <input name="service_request_type" value="1" id="radio1" type="radio" checked>
                            <label for="radio1">
                                <div class="managment-wrapper">
                                     <img src="<?php echo base_url();?>frontend_assets/images/icons/time-s.png"/>
                                    <div>
                                        <h5> One Time <span>Service</span></h5>
                                      
                                    </div>
                                </div>
                                
                               </label>
                        </div>
                        
                        <div class="rdio rdio-primary radio-inline">
                            <input name="service_request_type" value="<?=REQUESTMODE_WEEKLY?>" id="radio2" type="radio" <?=($service_details->is_weekly_available == 0)? 'disabled':''?>>
                            <label for="radio2">
                        <div class="managment-wrapper">
                                                                      <img src="<?php echo base_url();?>frontend_assets/images/icons/weekly.png"/>

                                    <div>
                                        <h5>Weekly <span>Service</span></h5>
                                      
                                    </div>
                                </div>
                                </label>
                        </div>

                        <div class="rdio rdio-primary radio-inline">
                            <input name="service_request_type" value="<?=REQUESTMODE_MONTHLY?>" id="radio3" type="radio" <?=($service_details->is_monthly_available == 0)? 'disabled':''?>>
                            <label for="radio3">
                                 <div class="managment-wrapper">
                                                                        <img src="<?php echo base_url();?>frontend_assets/images/icons/monthly.png"/>

                                    <div>
                                        <h5> Monthly <span>Service</span></h5>
                                     
                                    </div>
                                </div>
                               </label>
                        </div>
                        -->
                    </div>
                </div>
            </div>
         </div>
         
         
        <div class="checkbox-wrapper" id="day_selector" style="display:none">
           <div class="row">
              <div class="col-md-12">
                 <div class="cust-checkbox">
                    <?php
                    $weekdays   = $this->config->item('weekdays','app');
                    foreach($weekdays as $key => $day)
                    {
                        ?>
                        <div class="custom-checkbox">
                           <input name="day_<?=$key?>" class="checkbox-custom week_days" id="day_<?=$key?>" value="<?=$key?>" type="checkbox">
                           <label class="checkbox-custom-label" for="day_<?=$key?>"><?=$day?></label>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- <div class="custom-checkbox">
                       <input name="day_1" class="checkbox-custom week_days" id="day_1" value="1" type="checkbox">
                       <label class="checkbox-custom-label" for="day_1">Monday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_2" class="checkbox-custom week_days" id="day_2" value="2" type="checkbox">
                       <label class="checkbox-custom-label" for="day_2">Tuesday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_3" class="checkbox-custom week_days" id="day_3" value="3" type="checkbox">
                       <label class="checkbox-custom-label" for="day_3">Wednesday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_4" class="checkbox-custom week_days" id="day_4" value="4" type="checkbox">
                       <label class="checkbox-custom-label" for="day_4">Thursday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_5" class="checkbox-custom week_days" id="day_5" value="5" type="checkbox">
                       <label class="checkbox-custom-label" for="day_5">Friday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_6" class="checkbox-custom week_days" id="day_6" value="6" type="checkbox">
                       <label class="checkbox-custom-label" for="day_6">Saturday</label>
                    </div>
                    <div class="custom-checkbox">
                       <input name="day_7" class="checkbox-custom week_days" id="day_7" value="7" type="checkbox">
                       <label class="checkbox-custom-label" for="day_7">Sunday</label>
                    </div> -->
                 </div>
              </div>
           </div>
        </div>
         
     <div class="card_step calendar-elegance">
         <div class="row">
             <div class="col-md-6">
                 <div class="calender_wrap">
                     <h3>Select Date</h3>
                     <!--<div class="label-indicate"><div><span class="blue"></span><p>Not Available</p></div><div><span class="green"></span><p>Today Date</p></div><div><span class="light-blue"></span><p>Available</p></div></div>-->
                     
                     <div id="my-calendar"></div>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="select_time">
                     <h3>Select Time</h3>
                        <!--<div class="label-indicate">
                            <div><span class="dark-green"></span><p> Available</p></div>
                            </div>-->
                     <!--owl-carousel-->
                    <div class="time_slotes test" id="today_slot">
                        <?=$slot_list?>
                    </div>
                    <div class="time_slotes test" id="new_slot" style="display:none;">
                        
                         <span class="badge badge-pill active">09:00 AM</span>
                         <span class="badge badge-pill">09:30 AM</span>
                         <span class="badge badge-pill">10:00 AM</span>
                         <span class="badge badge-pill">10:30 AM</span>
                         <span class="badge badge-pill">11:00 AM</span>
                         <span class="badge badge-pill">11:30 AM</span>
                         <span class="badge badge-pill">12:00 PM</span>
                         <span class="badge badge-pill">12:30 PM</span>
                         <span class="badge badge-pill">01:00 PM</span>
                         <span class="badge badge-pill">01:30 PM</span>
                         <span class="badge badge-pill">02:00 PM</span>
                         <span class="badge badge-pill">02:30 PM</span>
                         <span class="badge badge-pill">03:00 PM</span>
                         <span class="badge badge-pill">03:30 PM</span>
                         <span class="badge badge-pill">04:00 PM</span>
                         <span class="badge badge-pill">04:30 PM</span>
                         <span class="badge badge-pill">05:00 PM</span>
                         <span class="badge badge-pill">05:30 PM</span>
                         <span class="badge badge-pill">06:00 PM</span>
                                                  
                     </div>
                 </div>
                 <div class="price_range">
                     <h3>Price Range</h3>
                      <div id="time-range">
    
    <div class="sliders_step1">
        <div id="slider-range"></div>
    </div>
    <div class="price_wrap">
        <p class="slider-amount-1">Min Price <span>AED <span id="price_from">100</span></span></p>
        <p class="slider-amount-2">Max Price <span>AED<span id="price_to"> 3000</span></span></p>
    </div>
</div>
                 </div>
                 
                 <div class="time_date job_validity">
                    <div class="row">
                     <div class="col-sm-6">
                         <h3>Job Validity Period</h3>
                        <div class="form-group">
                            <div class="input-group date" data-target-input="nearest">
                                <input type="hidden" id="service_date" value="<?php  echo date('Y-m-d'); ?>">
                                <input type="hidden" id="uae_time" value="<?php  echo date('Y-m-d'); ?>">
                                <input type="text" id="datetimepicker4" class="form-control datetimepicker-input" data-target="#datetimepicker4" placeholder="" readonly />
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         <h3>Job Validity Time</h3>
                        <div class="form-group">
                            <div class="input-group date" data-target-input="nearest">
                    <input type="text" id="datetimepicker3" class="form-control datetimepicker-input" data-target="#datetimepicker3" placeholder=""/>
                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                    </div>
                </div>
                        </div>
                    </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
     
     
     
     
     
     
     
        <div class="row">
        <div class="col-md-4">
                 <span href="#" style="margin-right: 11px;width;auto" class="continue back" id="backFromValidity"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back
                
         </div>
        <div class="col-md-4">
<!--                 <span href="#" class="continue back" id="back-3"><span><img src="images/icons/right-arow.png"/></span> Back</span>-->
                 <span href="#" class="continue homeType" id="btnLocationNext">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
         </div></div>
     </div>
     <div class="col-md-4">
         <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                     <h3>Service Summary</h3>
                     
                        <span class="spanSummery">
                        <ul class="summaryUl">
                                  <p class="noselect">You didn't choose any Services</p>
                            </ul>
                     </span>
                     <p class="serviceTotPrice"><strong></strong></p>

                 </div>
                 <!--end summery_row-->
                   <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
                 </div>
     </div>
 </div>
 </div>
 
 
    <div class="pageWrapp page-ctrl  addresPan">
    
        <div class="row">
             <div class="col-md-8">
                 <div class="d-flex align-items-center justify-content-between" style="padding: 0 15px;"><h5>Address Book</h5> <a class="btn btn-primary fa fa-plus fa-edit" href="javascript:void()"  data-target="#addressBook">Add New</a></div>
                    <div class="address-wrapper-stored" id = "addressList">
                                            
                        </div>
                                        
                        <div class="row">
                            <div class="col-md-4">
                                     <span href="#" style="margin-right: 11px;width;auto" class="continue back" id="backFromAddressList"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back
                                    
                             </div>
                              <div class="col-md-4">
                                   <span style="margin-right: 11px;width;auto" href="#" class="continue" id="btnAddressNext">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
                             </div>
                     
                     </div>
               </div>

               <div class="col-md-4">
         <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                     <h3>Service Summary</h3>
                     
                        <span class="spanSummery">
                        <ul class="summaryUl">
                                  <p class="noselect">You didn't choose any Services</p>
                            </ul>
                     </span>
                     <p class="serviceTotPrice"><strong></strong></p>

                 </div>
                 <!--end summery_row-->
                   <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
                 </div>
     </div>
     </div>
    </div> 

 <?php
     }
 
 ?>
 <!--end page wrapp 2-->
 <input type="hidden" id="paymentOptionChoosed">
 <input type="hidden" id="serviceAddress">
 <input type="hidden" id="serviceLocation">
 <input type="hidden" id="serviceTotPrice">
 <input type="hidden" id="serviceTotPricePass">
 <input type="hidden" id="lastPrice">
 <input type="hidden" id="serviceCurrency" value="<?=$this->config->item("currency");?>
">
  <!--start page wrapper 3-->
<div class="pageWrapp paymentOption" style="display: none;">
    <div class="row" >
      <div class="col-md-8">
        <div class="card_step">
          <div class="row">
              <div class="payment-wrapper-option">
                  
              
            <h3>Pay On Delivery</h3>
            
            <label class="custom-selection options">
  <input for="payOn" id="payOn" name="paymentOptionChoose" type="radio" value="1" class="paymentOptionChoose">
  <div  class="payment-items-wrapper">
      <img src="<?= base_url(); ?>/frontend_assets/images/icons/money-icon.png">
      <div>
          <h5>CASH</h5>
      </div>
  </div>
  <span class="checkmark"></span>
  <p>Please keep exact change handy to help us serve you better.</p>
</label>
</div>
<input type="hidden" id="grant_total_amount" value="0">
<?php 
        $wallet_balance =0;
        if(!empty($_SESSION) && $_SESSION["eq_user_id"] !="" ) { 
        $getUserDetails = $this->M_request->getUserDetails($_SESSION["eq_user_id"]); //print_r($getUserDetails);
        if(!empty($getUserDetails)) {
            $wallet_balance = $getUserDetails->wallet_balance;
            }
        }
         ?>   
        
<div class="payment-wrapper-option">
          
              
            <h3>Wallet (Balance : <?= $this->config->item('currency') ?>  <span id="balance_txt"><?= $wallet_balance ?></span>)</h3>
            
            <label class="custom-selection options">
  <input for="payOn" id="payOn" name="paymentOptionChoose" type="radio" value="3" class="paymentOptionChoose">
  <div  class="payment-items-wrapper">
      <img src="<?= base_url(); ?>/frontend_assets/images/icons/money-icon.png">
      <div>
          <h5>Wallet</h5>
      </div>
  </div>
  <span class="checkmark"></span>
  <p>Please keep exact change handy to help us serve you better.</p>
</label>
</div>

<input type="hidden" name="wallet_balance" id="wallet_balance" value="<?= $wallet_balance ?>">
            <!--<ul class="options">-->
            <!--  <li>-->
            <!--    <input >-->
            <!--    <label for="payOn">CASH</label>   -->
            <!--  </li>-->
            <!--</ul>-->
            
            <div class="payment-wrapper-option">
            
            <h3>Credit/Debit Cards</h3>
            
             <label class="custom-selection options">
  <input for="card" id="card" name="paymentOptionChoose" type="radio" value="2" class="paymentOptionChoose">
  <div class="payment-items-wrapper">
      <img src="<?= base_url(); ?>/frontend_assets/images/icons/credit-cards.png">
      <div>
          <h5>PAY BY DEBIT /CREDIT CARD</h5>
      </div>
  </div>
  <span class="checkmark"></span>
  <img src="<?= base_url(); ?>/frontend_assets/images/icons/card-brand.png">
</label>
</div>


            <!--<ul class="options">-->
            <!--  <li>-->
            <!--    <input >-->
            <!--    <label for="card">PAY BY DEBIT/CREDIT CARD</label>   -->
            <!--  </li>-->
            <!--</ul>-->
          </div>
          <div class="row">
            <div class="col-md-4">
              <span href="#" style="margin-right: 11px;width;auto" class="continue back" id="backfromPaymentOption"><span><img src="<?= base_url(); ?>/frontend_assets/images/icons/right-arow.png"></span> Back
              </span>
            </div>
            <div class="col-md-4">
                 <span href="#" class="continue" id="btnPaymentNext">Continue <span><img src="<?= base_url(); ?>/frontend_assets/images/icons/right-arow.png"></span></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                      <h3>Service Summary</h3>
                     
                      <span class="spanSummery">
                        <ul class="summaryUl">
                          <p class="noselect">You didn't choose any Services</p>
                        </ul>
                      </span>
                      <p class="serviceTotPrice"><strong></strong></p>
                 </div>
                 <!--end summery_row-->
                   <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
        </div>
      </div>
    </div>
</div>

<div class="pageWrapp summarySection" style="display: none;">
    <div class="row" >
      <div class="col-md-8">
        <div class="card_step ">
          <div class="row p-2">
            <h3>Service Summary</h3>
            <div class="summery_row ">
                <ul class="">
                    <li><label><strong><?php  echo $question_list->service_type_name;?></strong></label></li>
                </ul>
                <ul class="summaryUl">
                          <p class="noselect">You didn't choose any Services</p>
                        </ul>
            </div>
            
            <div class="summery_row ">
                <ul class="">
              <li><label><strong>Schedule at</strong> <span id="service_summary_datetime"></span></label></li>
              <li>
                <label><strong><span id="service_summary_location_type"></span>  </strong><span id="service_summary_address"></span></label>
              </li>
              <li><label><strong>Payment Mode : <span id="service_summary_payment_option"></span></strong></label></li>
            </ul>
            </div>
          
          </div>
          <div class="row">
            <div class="col-md-4">
              <span href="#" style="margin-right: 11px;width;auto" class="continue back" id="backfromSummarySection"><span><img src="<?= base_url(); ?>/frontend_assets/images/icons/right-arow.png"></span> Back
              </span>
            </div>
            <div class="col-md-4">
                 <button href="#" class="continue" id="btnBookNow">Book Now <span><img src="<?= base_url(); ?>/frontend_assets/images/icons/right-arow.png"></span></button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                      <h3>Bill Details</h3>
                     
                  
                      <span class="spanSummery">
                        
                      </span>
                      <!-- <p class="serviceTotPrice"><strong></strong></p> -->
                    <form id="coupon-form" method="post">
                        <div class="input-group mb-3 coupon-block">
                          <input type="text" id="coupon_code" name="coupon_code" class="form-control" placeholder="Apply Coupon Code" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <a href="" class="btn btn-primary" id="coupon">Apply</a>
                          </div>
                        </div>
                    </form>

                    <table class="table table-bordered bill-info">
                        <tr>
                             <td>Total Price</td>
                               <td id="totalPrice">AED 0</td>
                         </tr>
                         <tr>
                             <td>VAT <?=VAT?> %</td>
                               <td id="vatAmount">AED 0</td>
                         </tr>
                          <tr>
                             <td>Discount Amount</td>
                               <td id="discount"> AED 0</td>
                         </tr>
                          <tr class="grand-total-block">
                            <td>Grand Total</td>
                            <td id="grandTotal">AED 0</td>
                         </tr>
                     </table>
                 </div>
                 <!--end summery_row-->
        </div>
    </div>
</div>

<div class="providers_wrap" style="display: none">
     
        <div class="row">
             <div class="col-md-6">
                     <input type="text" class="form-control" placeholder="Keyword" id="txt_keyword"/>
            </div>
             <div class="col-md-2" style="display:none;">
                     <div class="form-group">
                        <select class="form-control" id="txt_distance" >
                          <option>Filter by Distance</option>
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </div>
             </div>
             <div class="col-md-2">
                     <div class="form-group">
                        <select class="form-control" id="txt_rating">
                          <option>Filter by Rating</option>
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </div>
             </div>
             <div class="col-md-2">
                     <button type="submit" class="search_btn">Search</button>
             </div>
         </div>
        <div class="row">
 <div class="col-md-8">
<!--     <h1>Page2</h1>-->
     <div class="">
         <div class="row" >
             <div class="col-md-12">
                     <div class="provider_list">
                         <div class="row" id="divProvider">
                             
                             
                             
                         </div>
                     </div>

<!-- Modal -->
<div class="modal fade provider_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" id="detailDiv">
    
  </div>
</div>
             </div>
         </div>
     </div>
     </div>
     <div class="col-md-4">
         <div class="row">
                 <!--start summery_row-->
                 <div class="summery_row">
                      <div class="call-center-pattern"></div>
                     <h3>Service Summary</h3>
                     
                        <span class="spanSummery">
                             <ul class="summaryUl">
                                  <p class="noselect">You didn't choose any Services</p>
                            </ul>
                            
                       
                     </span>
                     <span class="serviceTotPrice"></span>
                 </div>
                 <!--end summery_row-->
                   <div class="caricature-call-center">
                     <img src="<?php echo base_url();?>frontend_assets/images/icons/call-center.png"/>
                 </div>
                 </div>
     </div>
 </div>
    <div class="row">
         <div class="col-md-4">

         <span href="#" class="continue back" id="backFromProviderSelection"> <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"></span> Back</span>
                             </div>
                     <div class="col-md-4">

<!--                                     <span href="#" class="continue back" id="back-2"> <span><img src="images/icons/right-arow.png"></span> Back</span>-->
                                     <span href="#" style="margin-left: -148px;" class="continue" id="select_provider">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"></span></span>

                             </div>
                             </div>
 </div>



 </div>
 <!--end page wrapp 3-->
 
 <!--select providers-->

 

<!-- select providers-->
   <!--start page wrapper 4-->
 <div class="pageWrapp  page-ctrl page-succes">
<!--     <h1>Page4</h1>-->
<div class="row">
 <div class="col-md-12">
 <div class="card_thanku">
                                        <!--<div class="img_wra">-->
                                        <!--    <img src="<//?php echo base_url();?>frontend_assets/images/icons/icon-done.png" class="img-fluid" alt="">-->
                                        <!--</div>-->
                                            <article>
                                                <h3 class="">YOU'RE ALL SET!</h3>
                                                <h6>What happen next?</h6>
                                                <p class="">We will send you an email shortly once your booking is comfirmed</p>
                                                 <p class="">A customer service agent may get in touch with you to confirm details of your request</p>
                                                  <p class="">You will pay cash on delivery when the service is completed</p>
                                                <a href="#" target="_blank" class="btn-view-book mb-3">VIEW BOOKING DETAILS</a>
                                                   <a href="<?php echo base_url();?>" class="btn btn-primary">CONTINUE SERVICES</a>
                                            </article>
                 </div>
                                </div>
                                </div>
 </div>
 <!--end page wrapp 4-->
 
 
     
</div>
<!--tab 1-->


    <!--start row-->
<!--
         <div class="row">
             
                 <a href="#" class="continue" id="next">Continue <span><img src="images/icons/right-arow.png"/></span></a>
             
         </div>
-->
         <!--end row-->

                               
                         
                         
                         
  <div class="tab-pane fade row tab_content_padd" id="description" role="tabpanel" aria-labelledby="pills-profile-tab">
      <h4>Description</h4>
  
<!--      <h1>Tab2</h1>-->
 <div class="main">
            <!--start container-->
            <div class="container">
                <!--start row-->
                  <div class="content">
                      <p><?php  echo $question_list->service_type_desc;?></p>
                  </div>
    
                </div>
                <!--end row-->
            </div>
  </div>
  
  <div class="tab-pane fade row tab_content_padd" id="faq" role="tabpanel" aria-labelledby="pills-contact-tab">
<!--      <h1>Tab3</h1>-->
      <h4>FAQ</h4>
 
 <div class="main">
            <!--start container-->
            <div class="container">
                <!--start row-->
              
                   <div id="accordion" class="accordion">
        <div class="card mb-0">
            <?php if(count($faq)>0)
            { 
                $k=1;
            foreach($faq as $rows)
            {
            
            ?>
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne<?php echo $k;?>">
                <a class="card-title">
                    <?php echo $rows->service_faq ?>
                </a>
            </div>
            <div id="collapseOne<?php echo $k;?>" class="card-body collapse" data-parent="#accordion" >
                <p><?php echo $rows->service_faq_answer ?>
                </p>
            </div>
            <?php
            $k++;
            }
            }
            ?>
            
            
            
        </div>
    </div>
    
                </div>
                <!--end row-->
            </div>
  </div>
  
<div class="tab-pane fade row tab_content_padd review" id="review" role="tabpanel" aria-labelledby="pills-contact-tab ">
      <h4>Latest Reviews</h4>
      
      <!--start container fluid -->
      <div class="container-fluid">
          <!--start row-->
          <div class="row">
              <!--start col md 12-->
              <div class="col-md-12">
                  
                  <?php   
                  if(count($testimonial)>0)
                  {
                      $j=1;
                      foreach($testimonial as $rows)
                      {
                          if($j<=5)
                          {
                              $firstCharacterfirstName  = substr($rows->first_name, 0, 1);
                              $firstCharacterlastName  = substr($rows->last_name, 0, 1);
                              $displayName =  $firstCharacterfirstName.$firstCharacterlastName;
                  ?>
                 <!--start row-->
                 <div class="row review_pannel">
                     <h5><span><i class="fas fa-quote-left"></i></span>  <span><?php echo $rows->testimonial_arabic!="" && $this->session->userdata("language")==2?$rows->testimonial_arabic:$rows->testimonial?></span> </h5>
                     <div class="wrapper_row name-col"><aside><?php echo strtoupper($displayName); ?></aside> <span><?php echo $rows->first_name." ".$rows->last_name?></span></div>
                 </div>
                 <!--end row-->
                 
                 <?php
                          }
                 $j++;
                      }
                  }
                 
                 ?>
                 
                              
                 
                 
              </div>
              <!--end col md 12-->
          </div>
          <!--end row-->
      </div>
      <!--end container fluid-->
  </div>
  
</div>
                   <!--end tab-->
             </div><!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->
    
    











<!--start section-->
<?php $this->load->view('how_is_it_work'); ?>

<!--end section-->
    




















<style>
    .modal-dialog.update-address{
        max-width:1000px;
    }
</style>

<!--end section-->
<!-- Modal -->

<div class="modal fade provider_pop" id="addressBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog update-address modal-dialog-centered modal-dialog-scrollable" role="document" id="">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addressBookTitle">Add Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          
          <div class="container-fluid" id="dynamicAddressForm">
            <form id="formDynamicAddress" class="row" method="post">
               <div class="col-lg-6">
                     <div class="form-group">
                             <label>Address Type</label>
                            <div class="custom-control d-flex p-0">
              <label for="Company">
                <input class="select_radiobtn" type="radio" name="address_type" value="1" checked="checked">Home &nbsp; &nbsp; &nbsp; </label>
                <label for="Freelancer">
                <input class="select_radiobtn" type="radio" name="address_type" value="2" >Office &nbsp;</label>
                
                <label for="Freelancer">
                <input class="select_radiobtn" type="radio" name="address_type" value="3">Other &nbsp;</label>
            </div>
                         </div>
    
    
    
                     <div class="location_wrap">
                       <div class="form-group">
                            <label for="exampleFormControlInput1" id="addressTypeLabel" style="color:#0e688d"><i class="far fa-check-circle"></i> Home</label>
                            <input type="text" class="form-control" id="pickup-input2" name="pickup-input2" placeholder="Location" value="<?php echo $homeLocation ?>">
                            <input type="hidden" class="form-control" id="pickup-lattitude2" name="pickup-lattitude2" value="<?php echo $homeLattitude ?>">
                            <input type="hidden" class="form-control" id="pickup-longittude2" name="pickup-longittude2" placeholder="Type Your Location" value="<?php echo $homeLongitude ?>">
                            <input type="hidden" class="form-control" id="selected_address_type" name="selected_address_type"  value="1">
                          </div>
                          
                        <div id="map2" style="height: 250px;"></div>
                      
                     </div>
       </div>
       
                  <div class="col-lg-6">
            
             <div class="row">
                       <div class="col-md-6">
                    <div class="form-group">
                             <label>First Name</label>
                             <input class="form-control" placeholder="First Name" name="first_name" id="first_name">
                         </div>
                         
               </div>
            
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Last Name</label>
                             <input class="form-control" placeholder="Last Name" name="last_name">
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Email Address</label>
                             <input class="form-control" placeholder="Email addresss" name ="email">
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Mobile Number</label>
                           <div class="form-group nuber-text">
                                 <input type="text" class="form-control" id="dial_code" name="dial_code" style="width:30%;float: left;padding:0" readonly>
             
              <input type="number" class="form-control" placeholder="Mobile Phone" id="user_phone" name="user_phone" style="width:70%;">
            </div>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Country</label>
                             <select class="form-control" name="country" id="country">
                                <option>Choose country...</option>
                            <?php
                                foreach ($country_list as $key => $value) {
                                    if($value->country_id == $address_details->user_adresses_country)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                            ?>
                             <option value="<?=$value->country_id?>" for="<?=$value->country_dial_code?>" <?=$selected?>><?=$value->country_name?></option>
                            <?php
                                }
                            ?>
                         </select>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>City</label>
                         <select class="form-control" name="city" id="city">
                             <option value="">Choose country first</option>
                         </select>
                         </div>
               </div>
               
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Area</label>
                         <select class="form-control" name="area" id="area">
                             <option value="">Choose city first</option>
                         </select>
                         </div>
               </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building Name</label>
                        <input class="form-control" placeholder="" name="building_name" city="building_name">         
                    </div>
               </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Street Name</label>
                        <input class="form-control" name="street_name" id="street_name" placeholder="">
                    </div>
               </div>
             
               
           
           
               <div class="col-md-12 text-center">
                    <input type="submit"  class="btn btn-primary mt-2" value="SAVE" id="addressSaveBtn">
               </div>
                  </div>
        </div>
             
              
            </form>   
             
       
      </div>
     
    </div>
  </div>
</div>
</div>

<!--<div class="modal fade provider_pop" id="loactionUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--  <div class="modal-dialog update-address modal-dialog-centered modal-dialog-scrollable" role="document" id="loactionUpdateDIv">-->
<!--     <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="exampleModalCenterTitle">Update location</h5>-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">×</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
          
  
                    
<!--                   <form id="formDynamicLocation">-->
<!--      <div  id="locationDynamic">-->
<!--         <div class="row">-->
                  
<!--                     <div class="col-md-12">-->
<!--                     <div class="location_wrap">-->
<!--                       <div class="form-group">-->
<!--                            <label for="exampleFormControlInput1" id="addressTypeLabel" style="color:#0e688d"><i class="far fa-check-circle"></i> Home</label>-->
<!--                            <input type="text" class="form-control" id="pickup-input2" name="pickup-input2" placeholder="Location" value="<?php echo $homeLocation ?>">-->
<!--                            <input type="hidden" class="form-control" id="pickup-lattitude2" name="pickup-lattitude2" placeholder="Type Your Location" value="<?php echo $homeLattitude ?>">-->
<!--                            <input type="hidden" class="form-control" id="pickup-longittude2" name="pickup-longittude2" placeholder="Type Your Location" value="<?php echo $homeLongitude ?>">-->
<!--                            <input type="hidden" class="form-control" id="selected_address_type" name="selected_address_type"  value="1">-->
<!--                          </div>-->
                          
<!--                        <div id="map2" style="height: 250px;"></div>-->
                      
<!--                     </div>-->
<!--                    </div>-->
                   
<!--            </div>-->
<!--      </div>-->
<!--       </form>-->
                                        
<!--                                          <button class="submit_btn" id="saveDynamicAddress" type="button"> -->
<!--                         CONFIRM LOCATION & PROCEED</button>-->
               
             
<!--      </div>-->
     
<!--    </div>-->
<!--  </div>-->
<!--</div>-->






<style>
    .pac-container{
        z-index: 9999999999;;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/mdtimepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/zabuto_calendar.min.css"/>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/jquery-ui.theme.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<!-- <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/zabuto_calendar.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/zabuto_calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/toggle-script_new.js"></script>
 <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&libraries=places&sensor=false'></script>
 <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/locationpicker.jquery.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/mdtimepicker.min.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/scrollSpeed.js"></script> -->
  <!-- <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/scrollSpeedScript.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/moment.js"></script>
<script>
  window.user_id               = "<?php echo  (int)$this->session->userdata('eq_user_id') ;?>";
  window.user_type             = "<?php echo  (int)$this->session->userdata('eq_user_type') ;?>";
  
    $(document).delegate(".btnCountinue","click",function(e)
    {
      //alert(window.user_id);
    //  alert(window.user_type);
       inputType               = $(this).attr("data-qtype");
       className              = "radio"+$(this).attr("data-current");
       selectedQuestion  =  $(this).attr("data-current");
      //user_id             = "<?php echo  $this->session->userdata('eq_user_id') ;?>";
     // user_type        = "<?php echo  $this->session->userdata('eq_user_type') ;?>";
      
      
      if(inputType ==4)
      {
            selectedAnswer     =  $("input:radio."+className+":checked").val();

      }
      else if(inputType ==5)
      {
        
        selectedAnswer = ""; 
           // selectedAnswer     = $('.'+className+':checkbox:checked').val();
           $.each($(".answerCheck:checked"), function(){
                selectedAnswer = selectedAnswer+','+$(this).attr("value");
            });
           //alert(selectedAnswer);
      }
      else
      {
           selectedAnswer     = $('#dynamicQues'+selectedQuestion).val();
      }
    
     
       offset                       =  $(this).attr("data-offset");
       last_parent                  =  $(this).attr("data-parent");
      // alert(last_parent);
       if(last_parent>0)
       {
           sessionStorage.removeItem("last_parent");
           sessionStorage.setItem("last_parent", last_parent);
       }
       else
       {
           last_parent = sessionStorage.getItem("last_parent");
       }
      // alert(offset);
       
       buttonId                  =  $(this).attr("id");
       is_home_category ='<?php echo $is_home_category ?>';
        
       if((selectedAnswer>0 || selectedAnswer!="" ) &&  typeof selectedAnswer !="undefined")
       {
           
                 var formData = new FormData($("#dynamicForm2")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 formData.append('selectedAnswer',selectedAnswer);
                 formData.append('offset',offset);
                 formData.append('selectedQuestion',selectedQuestion);
                 formData.append('buttonId',buttonId);
                 formData.append('serviceTypeid',"<?php echo $_GET['sid'];?>");
                 formData.append('last_parent',last_parent);
             $.ajax({
             url: '<?php echo base_url();?>website/Request/checkValidation',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                  lastQuestion =  $(".lastQue:last-child").val();
                  
                 /*  if(is_home_category==1)
                         {
                         $("#backFromRemark").attr("data-current",selectedQuestion);
                         }
                         else
                         {
                             $("#backFromValidity").attr("data-current",selectedQuestion);
                             
                         }*/
                     $("#backFromRemark").attr("data-current",selectedQuestion);
                   if(data!="")
                   {
                       dat =data.split("^");
                         data =dat[1];
                         $(".parent"+selectedQuestion).remove();
                         $(".commonDisplayQuestion").css("display","none");
                         $("#span"+dat[0]).remove();
                         $(data).insertAfter("#span"+selectedQuestion);
                         // alert(sessionStorage.getItem("dynamicQues53"));
                         
                        //   populateOldData();
                          //alert($(".lastQue:last-child").val());
                          
                   }
                   else
                   {
                        $(".commonDisplayQuestion").css("display","none");
                            $("#Upload_section").css("display","block");
                     /* if(is_home_category==1)
                      {
                            $(".commonDisplayQuestion").css("display","none");
                            $("#Upload_section").css("display","block");
                            
                      }
                      else
                      {
                             goToLocationTab();
                      }*/
                   }
               },
             cache: false,
             contentType: false,
             processData: false
         });
         }
         else
         {
            // $("#questionError").css("display","block")
            // $("#questionError").html("select any answer");
            // myFunctionTiming("#questionError");
            swal("Please answer the question");
         }
    });
    function myFunctionTiming(inputElement) {
  setTimeout(function(){ $(inputElement).css("display","none") }, 3000);
}
     $(document).delegate(".back","click",function(e)
    {
           selectedQuestion  =  $(this).attr("data-current");
           $(".commonDisplayQuestion").css("display","none");
           $(".questionArea").css("display","block");
           $(".locationPan").css("display","none");
           $("#span"+selectedQuestion).css("display","block");
           $("#Upload_section").css("display","none");
        //   populateOldData();
           
    });
    
    $(document).delegate("#fileUploadNext","click",function(e){
        var ext = $('#customFile1').val().split('.').pop().toLowerCase();
        if(ext){
            if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','doc']) == -1) {
                swal('Selected file format is not allowed !');
                return false;
            }
        }
         fileName     = $('#filestyle-0').val();
         discription = $('#txtRemark').val();
         
         if(discription.length > 150 ){
            swal('Maximum allowed characters 150 !');
            return false;
         }
         
         $("#filepath").val(fileName);
         error=0;
         $('.txtRemarkError').css("display","none");
        if(discription=="")
        {
            $('#txtRemark').css("border-color","red");
            $('.txtRemarkError').css("display","");
              error=1;
        }
        else
        {
            $('#txtRemark').css("border-color","");
        }
        if(fileName=="")
        {
            $("#filepath").css("border-color","red");
             error=1;
        }
        else
        {
             $("#filepath").css("border-color","");
        }
        
        questionList = "<?=count($question_list)?>";
        if(questionList <= 0 ){
            swal('Please select question');
            return false;
        }
        
        if(error==0)
              goToLocationTab();
              
     });
       $(document).delegate("#btnLocationNext","click",function(e)
     {

           error=0; 
           is_home_category ='<?php echo $is_home_category ?>';
           vdate = $("#my-calendar").data("date");
           var valdate = $("#service_date").val();
           var valTime  =  $(".badge-pill.active").html();
           if(valdate=="")
           {
               
                 swal("Please select a valid Date and time");
                 $("#datetimepicker4").css("border-color","red");
                 error=1;
                 return false;
           }
           else
           {
                $("#datetimepicker4").css("border-color","");
           }
             if(valTime=="" || typeof(valTime) === "undefined")
           {
                swal("Please select job validity time");
                 $("#datetimepicker3").css("border-color","red");
                 error=1;
                 return false;
           }
           else
           {
                 $("#datetimepicker3").css("border-color","");
           }
           
           if(is_home_category==1 && $("#us5-street1").val()=="")
           {
                error=1;
               $("#us5-street1").css("border-color","red");
           }
           else
           {
                $("#us5-street1").css("border-color","");
           }
          if(is_home_category==1 && $("#us5-city").val()=="")
           {
                error=1;
               $("#us5-city").css("border-color","red");
           }
           else
           {
                $("#us5-city").css("border-color","");
           }
            if(is_home_category==1 && $("#us5-state").val()=="")
           {
                error=1;
               $("#us5-state").css("border-color","red");
           }
           else
           {
                $("#us5-state").css("border-color","");
           }

            service_request_mode    = $("input[name=service_request_type]:checked").val();
            selected_days   = "";
            $(".week_days:checked").each(function(){
                selected_days+=$(this).val()+",";
            });

            if(service_request_mode == "<?=REQUESTMODE_WEEKLY?>")
            {
                if($(".week_days:checked").length <= 1)
                {
                    error=1;
                    swal("Please select atleast two days in a week !");
                }
            }

            if(service_request_mode == "<?=REQUESTMODE_MONTHLY?>")
            {
                if($(".week_days:checked").length == 0)
                {
                    error=1;
                    swal("Please select atleast one day in a week !");
                }
            }
           
          if(error==0)
          {
           
              if(is_home_category==1)
              {
               goToSelectOption();
              }
              else
              {
                   var addressType          =  $(".location_button.active").attr("for");
                   var valdate              = $("#datetimepicker4").val();
                   var  service_date        =  $('#service_date').val();
                   
                  
                  formated =  moment(valdate).format("YYYY-MM-DD");
                 // alert(valdate);
                 // alert(formated);
                  //var d1 = new Date(formated);
                 // var d2 = new Date(valdate);
                /*  
                  if(d1>d2)
                  {
                      alert("s");
                  }
                 */
                 var valTime         =  $("#service_date").val();
                 var serviceTime     =  $(".badge-pill.active").html();
                 d2 = formated+" "+valTime;
                 d1 = service_date+" "+serviceTime;
                 //alert(d2);
                 var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;
                 var beginningTime = moment(d2, 'YYYY-MM-DD h:mma');
                 var endTime = moment(dateTime, 'YYYY-MM-DD h:mma');
                // alert(beginningTime);
                //  alert(endTime);
                 // alert(dateTime);
                // alert(endTime);
                 // if(beginningTime.isBefore(endTime)==true)
                 //    {
                 //         swal("Validity date should be greater than  current time");
                 //         return false;
                 //    }
                    
                   // alert("ser-"+service_date);
                   // alert("val-"+formated);
                   // alert("<?php echo date('Y-m-d h:i A'); ?>");
                  var beginningTime3 = moment(d2, 'YYYY-MM-DD h:mma');
                 var endTime3 = moment(d1, 'YYYY-MM-DD h:mma');
                 //  if(beginningTime3.isBefore(endTime3)==false)
                 // {
                 //     swal("Validity date should not exceed service date");
                 //     return false;
                 // }
                 if(service_date==formated)
                 {
                   
                  // var today = new Date();
                   //var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                   //alert(date);
                   // var d1 = date+" "+serviceTime;
                    //var d2 = date+" "+valTime;
                    //var aDate = Date.parse(d1);
                    //var bDate = Date.parse(d2);

                   // alert(d1);
                   // alert(d2);
                  //  alert(aDate);
                  //  alert(bDate);
                  var beginningTime2 = moment(serviceTime, 'h:mma');
                  var endTime2 = moment(valTime, 'h:mma');
                //alert(beginningTime.isBefore(endTime));
                    if(beginningTime2.isBefore(endTime2)==true)
                    {
                         swal("Validity date/time should not exceed service date/time");
                         return false;
                    }
                 }
                   //alert(service_date);
                    // alert(formated);
                   // if(addressType == 1)
                   // {
                   //             swal({
                   //        title: "Are you sure to proceed with home address?",
                   //        text: "",
                   //        icon: "warning",
                   //        buttons: true,
                   //        dangerMode: true,
                   //      })
                   //      .then((willDelete) => {
                   //        if (willDelete) 
                   //        { 
                          
                   //         goToSelectOption();
                           
                   //        } else 
                   //        {
                              
                           
                   //        }
                   //      });
                   // }
                   // else
                   // {
                        goToSelectOption();
                   //}
                  
                  
                                 
              }
          }
             
              
     });

      $(document).delegate("#btnPaymentNext","click",function(e)
     {
            

         var paymentOptionChoosed = $("#paymentOptionChoosed").val(); 
       
        if($("input:radio.paymentOptionChoose:checked").length == 1) {

           // serviceTotPricePass  wallet_balance
        
          $('#paymentOptionChoosed').val($("input:radio.paymentOptionChoose:checked").val());
          var paymentOptionChoosed = $("#paymentOptionChoosed").val(); 
          var addressType  =  $('input[name="address"]:checked').attr("for");
          var serviceLocation = $("#serviceLocation").val();
          var valdate = $("#service_date").val();
          var valTime  =  $(".badge-pill.active").html();
            

           var totalPrice = $('#serviceTotPricePass').val();
           var walletbalance = $('#wallet_balance').val();
           var err = 0;
           if(paymentOptionChoosed ==3) { 
                updateWallet();
                if(parseInt(totalPrice,10) > parseInt(walletbalance,10) ){
                    swal("Your wallet not have enough balance..Pleae top up");
                    err =1;
                    return false;
                }
           }
          if(err ==0) {


            $('.paymentOption').hide();
            $('.summarySection').show();
              d = new Date(valdate);
              var day = d.getDate();
              var year = d.getFullYear();
              var month = d.toLocaleString('default', { month: 'short' });
              valDate = day+' '+month+' '+year;
            //   alert(addressType);
              if(paymentOptionChoosed == 1) {
                paymentOptionText = ' Cash On Delivery';
              }
              if(paymentOptionChoosed == 2) {
                paymentOptionText = 'Debit/Credit Card Payment';
              }
              if(paymentOptionChoosed == 3) {
                paymentOptionText = 'Wallet Payment';
              }
              addressTypeLabel = "";
              if(addressType==1)
              {
                 addressTypeLabel = 'Address Type : Home';
              }
              else
              {
                 addressTypeLabel = 'Address Type : Office';
              }
              $('#service_summary_datetime').text(valDate+' '+valTime);
              $('#service_summary_address').text(serviceLocation);
              $('#service_summary_payment_option').text(paymentOptionText);
              $('#service_summary_location_type').text(addressTypeLabel);
               
                billDetails(0);
            }


        } else {
          swal("Please choose payment option");
          return false;
        }
     });
      $(document).delegate("#backfromSummarySection","click",function(e)
     {
        $(".questionArea").css("display","none");
        $(".locationPan").css("display","none");
        $('.paymentOption').show();
        $('.summarySection').hide();
        $('#btnBookNow').attr('disabled',false);
     });
         $(document).delegate("#filestyle-0","change",function(e)
     {
         fileName     = $('#filestyle-0').val();        
         $("#filepath").val(fileName);
 });
    
    $(document).delegate("#btnBookNow","click",function(e) {
        var paymentOptionChoosed   = $('input[name="paymentOptionChoose"]:checked').val();
         if(paymentOptionChoosed ==3) {   
           updateWallet();
        }
        saveRequest(2);
    });
    function updateWallet()
    {
          $.ajax({

                url: '<?php echo base_url();?>website/Request/getUserWallet',
                type: 'POST',
                data: {},
                dataType:'json',
                async: true,
                success: function (data){   
                   
                    $('#balance_txt').html(data.wallet_balance);
                    $('#wallet_balance').val(data.wallet_balance);
                    
                },
                cache: false,
                contentType: false,
                processData: false
            });
    }

     $(document).delegate(".selectOptions","click",function(e)
     {
          sessionStorage.setItem("lastAction", "question");
                  if(window.user_id<=0)
              {
                   $("#exampleModal").modal("show");
                   return false;
              }
              else  if(window.user_type!=1)
              {
                  swal("Please login as an user");
                  return false;
              }
              var option              =  $(this).attr("for");
              
              if(option==1)
              {
                   saveRequest(1);
              }
              else if(option==2)
              {
                    $(".providers_wrap").css("display","block"); 
                    $(".selectOptionSub").css("display","none");
                    getProviders();
                    return false;
              }
              else
              {
                  swal("Invalid section");
              }
              
           
             
          
   });

   function saveRequest(option)
   {
        var paymentOptionChoosed   = $('input[name="paymentOptionChoose"]:checked').val();
        var totalPrice = $('#grant_total_amount').val();
        var walletbalance = $('#wallet_balance').val();
        var err = 0;  
        if(paymentOptionChoosed ==3) {   
            if(parseInt(totalPrice,10) > parseInt(walletbalance,10) ){
                swal("Your wallet not have enough balance..Pleae top up");
                err =1;
                return false;
            }
        }


    //   alerts(option);
       sessionStorage.setItem("lastAction", "question");
    // alert(window.user_type);
      if(window.user_id<=0)
      {
           $("#exampleModal").modal("show");
           return false;
      }
      else  if(window.user_type!=1)
      {
          swal("Please login as an user");
          return false;
      }
      $('#btnBookNow').attr('disabled',true);
       
            //   var serviceAddress = $('#serviceAddress').val();
            //   serviceAddress = JSON.parse(serviceAddress);

              
               var valdate            = $('#service_date').val();
               var valTime            = $(".badge-pill.active").html();
            //   var street               =  serviceAddress.user_adresses_location
            //   var city                    =  $("#us5-city").val();
            //   var state                 =  $("#us5-state").val();             
               var  discription      =  $('#txtRemark').val();
               var  service_date  =  $('#service_date').val();
               var serviceTime     =  $(".badge-pill.active").html();
               var price_from       = $("#price_from").html();
               var price_to            = $("#price_to").html();
               var serviceTotPricePass            = $("#serviceTotPricePass").val();
               var payment_option   = $('input[name="paymentOptionChoose"]:checked').val();
               var coupon_code      = $('#coupon_code').val();
            //   var addressType  =  $(".location_button.active").attr("for"); 
            //   var lattitude         =  serviceAddress.user_adresses_lattitude
            //   var longitude       =  serviceAddress.user_adresses_longitude
              // alert(price_from);
               
              // var  file_data = $('#filestyle-0').get(0).files[0];
              
              address_id = $('input[name="address"]:checked').val();
              var  is_home_category ='<?php echo $is_home_category ?>'; 
               var formData = new FormData($("#dynamicForm")[0]);
                i=0;           
    $('.custom-file-input').each(function() 
    {
         //  alert();                             
         file_data = $('.custom-file-input').get(i).files[0];
       formData.append('document[]',file_data);
        i++;
    }); 
              
               
               
  //              if(option==2)
  //              {
  //                   mappedItems =    $( ".providerSelectDiv > .selected" )
  // .map(function() {
  //   return $(this).attr("for");
  // })
  // .get()
  // .join();
  
  //          if(mappedItems=="")
        //    {
        //     swal("Select atleast one provider");
               
        //     return false;
        //    }
  //              }
  //              else
  //              {
                   mappedItems="";
               //}
               
               csrf_value     =   getCookie('csrf_cookie_name');        
               formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
               formData.append('option',option);
               formData.append('valdate',valdate);
               formData.append('valTime',valTime);
               formData.append('address_id',address_id);
            //   formData.append('city',city);
            //   formData.append('state',state);
               formData.append('discription',discription);
               
               formData.append('is_home_category',is_home_category);
               formData.append('is_home_category',is_home_category);
               formData.append('service_date',service_date);
               formData.append('serviceTime',serviceTime);
               formData.append('price_from',price_from);
               formData.append('price_to',price_to);
               formData.append('coupon_code',coupon_code);
               formData.append('payment_option',payment_option);
            //   formData.append('addressType',addressType);
            //   formData.append('lattitude',lattitude);
            //   formData.append('longitude',longitude);
               formData.append('serviceTotPricePass',serviceTotPricePass);
               formData.append('service_type_id',<?php echo $this->common_functions->decryptId($_GET['sid']);?>);
               formData.append('mappedItems',mappedItems);
               formData.append('selectedAnsOptions',JSON.stringify(selectedAnsOptions));



                service_request_mode    = $("input[name=service_request_type]:checked").val();
                selected_days   = "";
                $(".week_days:checked").each(function(){
                    selected_days+=$(this).val()+",";
                });

                if(service_request_mode == 2)
                {
                    if($(".week_days:checked").length <= 1)
                    {
                        swal("Please select atleast two days in a week !");
                        return false;
                    }
                }

                if(service_request_mode == 3)
                {
                    if($(".week_days:checked").length == 0)
                    {
                        swal("Please select atleast one day in a week !");
                        return false;
                    }
                }

                formData.append('service_request_mode',service_request_mode);
                formData.append('selected_days',selected_days);

                if(payment_option== 1 || payment_option== 3 ){
                $.ajax({
                    url: '<?php echo base_url();?>website/Request/saveRequest',
                    type: 'POST',
                    data: formData,
                    async: true,
                    success: function (data) 
                    {
                        
                       if(data>0)
                       {
                            $('.btn-view-book').attr('href','<?php echo base_url();?>booking_details/'+data) 
                            goToSuccesspage(option);
                       }else{
                           $('#btnBookNow').attr('disabled',false);
                       }
                       
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }else{
                $.ajax({
                    url: '<?php echo base_url();?>website/Request/payment_init',
                    type: 'POST',
                    data: formData,
                    async: true,
                    success: function (ret_res) 
                    {
                        ret_res = jQuery.parseJSON(ret_res)
                        if(ret_res.status=="200"){
                            location.replace(ret_res.url);
                        }else{
                            swal(ret_res.message,{button: "Ok"}); 
                        }
                       
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
          
          
   }
     function goToLocationTab()
     {
            // sessionStorage.clear();
             $currElement= $("#locationPan");
             $(".bullet").removeClass('bullet_solid');
             $(".pan").css("background", "");
             $currElement.css('background-color', '#d52d2f');
             $currElement.addClass('bullet_solid');
             $(".first-bullet").css("background-color", "#299a06");
             $(".pageWrapp").css("display","none");
             $(".locationPan").css("display","block");
     }
     function goToSelectOption()
     {
            $(".providers_wrap").css("display","none"); 
           $(".selectOptionSub").css("display","-webkit-box");
            // $("#divProvider").html("");
             //added 20-06-2019       
                    
                    
             $currElement= $("#selectOption");
             $(".bullet").removeClass('bullet_solid');
             $(".pan").css("background", "");
             $currElement.css('background-color', '#d52d2f');
             $currElement.addClass('bullet_solid');
             $(".first-bullet").css("background-color", "#299a06");
             $('#locationPan').css("background-color", "#299a06");
             $('#loginAsRequest').val(1)
             $('#registerAsRequest').val(1)
             //$(".pageWrapp").css("display","none");
             
              sessionStorage.setItem("lastAction", "question");
              if(window.user_id<=0)
              {
                   $("#exampleModal").modal("show");
                   return false;
              }
              else  if(window.user_type!=1)
              {
                  swal("Please login as an user");
                  return false;
              }
                        var addressType  =  $(".location_button.active").attr("for"); 

             // swal("Please update your address");
            //   $("#loactionUpdate").modal("show");
            //   $("#selected_address_type").val(addressType);
            //   if(addressType==1)
            //   {
            //       $("#addressTypeLabel").text("Home");
            //   }
            //   else if(addressType==2)
            //   {
            //       $("#addressTypeLabel").text("Office");
            //   }
            //   else
            //   {
            //       $("#addressTypeLabel").text("Other");
            //   }
            
            goToAddressList();
     }
     
      function goToPaymentOption(){

        $(".pageWrapp").css("display","none"); 
        $(".selectOptionSub").css("display","-webkit-box");
        
         $.ajax({

            url: '<?php echo base_url();?>website/Request/getUserWallet',
            type: 'POST',
            data: {},
            dataType:'json',
            async: true,
            success: function (data){   
               
                $('#balance_txt').html(data.wallet_balance);
                $('#wallet_balance').val(data.wallet_balance);
                
            },
            cache: false,
            contentType: false,
            processData: false
        });
        $('.paymentOption').show();
     }


   
     
       function goToSuccesspage(option)
     {
             sessionStorage.clear();
             $currElement= $("#page-succes");
             $(".bullet").removeClass('bullet_solid');
             $(".pan").css("background", "");
             $currElement.css('background-color', '#d52d2f');
             $currElement.addClass('bullet_solid');
             
            $(".first-bullet").css("background-color", "#299a06");
            $('#locationPan').css("background-color", "#299a06");
            $('#selectOption').css("background-color", "#299a06");
            
             $(".pageWrapp").css("display","none");
             $(".page-succes").css("display","block");
             if(option==1)
             {
                 $(".text-white").html("Thank You For Submiting Enquiry");
                 $(".text-white_sub").html("You will Receive Quotation Soon");
             }
              if(option==2)
             {
                 $(".text-white").html("Thank You For Submiting Service Request");
                 $(".text-white-sub").html("You will get the reply soon");
             }
     }
     function goToFileUploadPage()
     {
         //alert();questionArea
            $currElement= $(".questionArea");
             $(".bullet").removeClass('bullet_solid');
             $(".pan").css("background", "");
             //$currElement.css('background-color', '#d52d2f');
            // $currElement.addClass('bullet_solid');
            //  $(".first-bullet").css("background-color", "#d52d2f");
            // $(".pageWrapp").css("display","block");
            $(".questionArea").css("display","block");
                            $(".locationPan").css("display","none");
                            $("#Upload_section").css("display","block");
                         //   alert(2);
     }
     
     
     
      $(document).delegate("#homeSettingsBack,#backFromValidity","click",function(e){
         goToFileUploadPage();
     });
      $(document).delegate("#backFromProviderSelection","click",function(e)
    {
         goToSelectOption();
     });
     
      $(document).delegate("#backFromSelectOption,#backfromPaymentOption","click",function(e) {
        goToAddressOption();    // goToLocationTab();
     });
     
     
    var validator=$("#dynamicForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
         
          'question[]':
                  {
                      required: true
                  }
          
          
        },
        messages: 
        {
       
    },
    
    errorPlacement: function(error, element) {
        alert();
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
        $(".form-errors").html("All fields must be completed before you submit the form.");
    },
   
//     showErrors: function(errorMap, errorList) {
//        $(".form-errors").html("All fields must be completed before you submit the form.");
//    },
     submitHandler: function ()
        {
            
             
                dataString = $('#dynamicForm').serialize();
                var formData = new FormData($("#dynamicForm")[0]);
                csrf_value  =   getCookie('csrf_cookie_name');        
                formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>website/Request/checkValidation',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   if(data==1)
                   {
                      alert(1); 
                   }
                   else
                   {
                       alert(2); 
                   }
               },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
 
 
    $(function () {
            $( "#datetimepicker3" ).mdtimepicker();

            $( "#datetimepicker4" ).datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'd M yy',
               minDate: 0
            });
//                $('#datetimepicker4').datetimepicker({
//                    format: 'L'
//                });
//                $('#datetimepicker3').datepicker();
            });
        $("#my-calendar").zabuto_calendar({
            today: false,
            show_previous: false,
            action: function () {
                return myDateFunction(this.id, false);
            },
            nav_icon: {
              prev: '<i class="fa fa-chevron-left"></i>',
              next: '<i class="fa fa-chevron-right"></i>'
            },
        });
        function myDateFunction(id, fromModal) {
            var date = $("#" + id).data("date");
            $("#service_date").val(date);
            //alert(date);
            var hasEvent = $("#" + id).data("hasEvent");
           // alert('You clicked on date ' + date);
            $("div.day").removeClass('today');
            $("#" + id + "> div").addClass('today');
//            $("#date-popover-content").html('You clicked on date ' + date);

            updateSlotTime();
            return true;
        }
       


 $(document).ready(function(){
          $('.search button').click(function(){
              $('.search-box').addClass('search-box-add');
          });
          $('.close_button').click(function(){
              $('.search-box').removeClass('search-box-add');
          });
          
          
          $('.min-search button').click(function(){
              $('.search-box').addClass('search-box-add');
          });
          
          function updateControls(addressComponents) {
              
             // alert();
              console.log(addressComponents);
                $('#us5-street1').val(addressComponents.addressLine1);
                $('#us5-city').val(addressComponents.city);
              //  $('#us5-state').val(addressComponents.stateOrProvince);
              $('#us5-state').val(addressComponents.country);
                $('#us5-zip').val(addressComponents.postalCode);
                $('#us5-country').val(addressComponents.country);
                
                
            }
         
                             var lat = 25.204849;
                              lng = 55.270782;
                              
                             var myLatLng = {lat: '<?php echo $defaultLattittude;?>', lng: '<?php echo $defaultlongittude;?>'};
                              var myLatLng = {lat: 25.204849, lng: 55.270782};
                             image = '<?php echo base_url();?>frontend_assets/images/icons/map_pin.png';
                             var MAP1 = new google.maps.Map(document.getElementById('MAP1'), {
                              zoom: 10,
                              disableDefaultUI: true,
                              center: myLatLng
                            });
                        latlng = new google.maps.LatLng(lat, lng);     
                      marker = new google.maps.Marker({
            position: latlng,
            map: MAP1,
            draggable: true,
            animation: google.maps.Animation.DROP,
           // icon: image
         });      
         
         var input = document.getElementById('us5-street1'); 
         
           var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["geocode"]
    });                        
        autocomplete.bindTo('bounds', MAP1); 
        
         var infowindow = new google.maps.InfoWindow(); 
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        console.log(place);
       //results[0]= place;
         if (place.geometry.viewport) {
            MAP1.fitBounds(place.geometry.viewport);
        } else {
            MAP1.setCenter(place.geometry.location);
            MAP1.setZoom(17);
        }
         latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
        //moveMarker(place.name, place.geometry.location);
        moveMarker(marker, latlng);
        document.getElementById("us2-lat").value=place.geometry.location.lng();
        document.getElementById("us2-lon").value=place.geometry.location.lat();
         $('#us5-street1').val(place['address_components'][0].long_name);
                     $('#us5-city').val(place['address_components'][1].long_name!=""?place['address_components'][1].long_name:place['address_components'][1].long_name);
                     $('#us5-state').val(place['address_components'][2].long_name!=""?place['address_components'][2].long_name:place['address_components'][2].long_name);
                   
       
    });
        google.maps.event.addListener(marker, 'dragend', function() {
          //alert();
          var infowindow = new google.maps.InfoWindow(); 
    var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
           
            if (status == google.maps.GeocoderStatus.OK) 
            {
                if (results[0]) 
                {
                    //console.log(results[0]);
                    
                    //alert();
                  
                     $('#us5-street1').val(results[0]['address_components'][0].long_name);
                     $('#us5-city').val(results[0]['address_components'][1].long_name!=""?results[0]['address_components'][1].long_name:results[0]['address_components'][1].long_name);
                     $('#us5-state').val(results[0]['address_components'][2].long_name!=""?results[0]['address_components'][2].long_name:results[0]['address_components'][2].long_name);
                     $('#us2-lat').val(marker.getPosition().lng());
                     $('#us2-lon').val(marker.getPosition().lat());
                    
                    
                    
                    //infowindow.setContent(results[0].formatted_address);
                    
                    
                    
                       //  infowindow.open(map, marker);
                    //infoWindow.close();
                    //map.setCenter(marker.getPosition());
                    //ShowNext();
                }
            }
        });
    });  
        
          /*  $('#MAP1').locationpicker({
                location: {
                    latitude: '<?php echo $defaultLattittude;?>',
                    longitude: '<?php echo $defaultlongittude;?>'
                },
                radius: 400,
                 inputBinding: {
            latitudeInput: $('#us2-lat'),
            longitudeInput: $('#us2-lon'),
         
        },
                onchanged: function (currentLocation, radius, isMarkerDropped) {
                    var addressComponents = $(this).locationpicker('map').location.addressComponents;
                    updateControls(addressComponents);
                },
                oninitialized: function (component) {
                    var addressComponents = $(component).locationpicker('map').location.addressComponents;
                    //var place = $(component).locationpicker('map').location.getPlace();
                    //console.log($(component).locationpicker('map').location);
                   //console.log(place);
                   // updateControls(addressComponents);
                     $('#us5-street1').val('<?php echo $defaultLocation;?>');
                     $('#us5-city').val('<?php echo $defaultCity;?>');
                     $('#us5-state').val('<?php echo $defaultState;?>');
                     $('#us2-lat').val('<?php echo $defaultLattittude;?>');
                     $('#us2-lon').val('<?php echo $defaultlongittude;?>');
                }
            });*/
          
          
      });
      
//       function getProviders()
//       {
          
//           csrf_value  =   getCookie('csrf_cookie_name');    
//           var lattitude         =  $("#us2-lat").val(); 
//           var longitude       =  $("#us2-lon").val(); 
//           var txt_keyword       =  $("#txt_keyword").val(); 
//           var txt_rating       =  $("#txt_rating").val(); 
//           var txt_distance       =  $("#txt_distance").val(); 
          
//           var addressType  =  $(".location_button.active").attr("for"); 
             
//               // alert(price_from);
               
//               // var  file_data = $('#filestyle-0').get(0).files[0];
//               var  is_home_category ='<?php echo $is_home_category ?>'; 
          
//           $("#divProvider").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif'  style='    float: none;position:absolute; top: 42px;left: 32%; width: 110px;height: 76px;'>");
//          //alert(lattitude);
//         // return false;
//           $.ajax({
//             url: '<?php echo base_url();?>website/Request/getProviders',
//             type: 'POST',
//             data: {is_home_category:is_home_category,addressType:addressType,txt_keyword:txt_keyword,txt_rating:txt_rating,txt_distance:txt_distance,lattitude:lattitude,longitude:longitude,'service_type_id':'<?php echo $this->common_functions->decryptId($_GET["sid"]);?>','<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
//             success: function (data) 
//              {  
//                   $("#divProvider").html("");
                                                                                
//                  if(data==0)
// });
// $('input.dynamicQues[type="text"]').each(function() {
 
//   selectedSummary+="<li>"+$(this).val()+"</li>";
// });
 //var selectedText = $(".dynamicQues option:selected").html();
//alert(selectedText);
// if(scheduleDate!="")
//     {
//     selectedSummary+='<li> <b>Schedule</b> <span class="Adddate">'+scheduleDate+'</span> <span class="Addtime">'+scheduleTime+'</span></li>';
//     }
//  //selectedSummary+='<li> <b>Schedule</b> <span class="Adddate">29 May 2019</span> <span class="Addtime">6:45 PM</span></li>';
// selectedSummary+="</ul>";
// $(".spanSummery").html(selectedSummary);
//     }*/
    
     $(document).delegate(".answerRadios","click",function(e)
    {
        if($(this).prop("checked") == true)
            {
                appendHtmlValue2("radio",$(this).attr("id"),$(this).attr('for'));
            }
            else
            {
                id= $(this).attr("id");
                $("#li"+id).remove();
            }
       
    });

    $(document).delegate(".answerCheck","click",function(e)
    {   
        appendHtmlValue2("checkbox",$(this).attr("id"),$(this).attr('for'));       
    });


   
    $(document).delegate("#datetimepicker4,#datetimepicker3","change",function(e)
    {
           appendHtmlValue2("dummy","dummy");
           
    });
    

    function removeLastData(id){ 
        priceArr =JSON.parse($("#serviceTotPrice").val());
        var newAr=[];
        $.each(priceArr, function( index, valItem ) {
          if(priceArr[index]['qnId'] == id) {

              
          }else{
            newAr.push(valItem);
          }
        });
      //   for (var i = 0; i < priceArr.length; i++) {
      //   console.log(priceArr[i]['qnId']+" --- "+i);
      //   console.log(priceArr);
      //   if(priceArr[i]['qnId'] == id) {

      //       priceArr.splice(i, 1);
      //   }
      //   console.log("====");
      //   console.log(priceArr);
      //   console.log("====----+");
        
      // }
      $("#serviceTotPrice").val(JSON.stringify(newAr));
      loadSummaryUI(newAr);
    }
     
    $(document).delegate("select.dynamicQues","change",function(e)
    {
       // alert('Hai');
           appendHtmlValue2("drop",$(this).attr("id"));
           
    }); 
     $(document).delegate("input.dynamicQues[type='text'],textarea.dynamicQues","keyup",function(e)
    {
        //alert();
           appendHtmlValue2("text",$(this).attr("id"));
           
    }); 
    
    var selectedOptions = {};
    var selectedAnsOptions = {};
    function removeOldElements(item)
    {
      $("#li"+item).remove();
     $("."+item).remove();
    }
    var question_list_ids = [];
    function appendHtmlValue2(type,elementId, forID=0)
    {
        
      var qnId = document.getElementById(elementId).getAttribute('for');
      var price = parseInt(($('#'+elementId).data('price')));
      var priceArr = [];
      

      $('#lastPrice').val(price);
    //   if($("#serviceTotPrice").val() != '') {
    //     var priceArr = JSON.parse($("#serviceTotPrice").val());
    //   }
      if(type != 'checkbox'){
        if($("#serviceTotPrice").val() != '') {
         var priceArr = JSON.parse($("#serviceTotPrice").val());
       }
        for (var i = 0; i < priceArr.length; i++) {
            
            if(priceArr[i]['qnId'] == qnId) {
              priceArr.splice(i, 1);
            }
          }

          priceArr.push({
              qnId : qnId, 
              price : price
          });

        $("#serviceTotPrice").val(JSON.stringify(priceArr));
    }

      // (sessionStorage.getItem("serviceTotPrice") === undefined) ? sessionStorage.setItem("serviceTotPrice", price) : sessionStorage.setItem("serviceTotPrice", (sessionStorage.getItem("serviceTotPrice") + price))
      // var serviceTotPrice = sessionStorage.getItem("serviceTotPrice");
         

       // alert(type);
       // alert(elementId);
       selectedSummary="";
       scheduleDate = $("#datetimepicker4").val();
        scheduleTime = $("#datetimepicker3").val(); 
 //selectedSummary+= "<ul>";
 $('.answerRadios').each(function() {
     
    // $("#li"+$(this).attr("id")).remove();
     
     if($(this).prop("checked") == false)
            {
                id= $(this).attr("id");
                $("#li"+id).remove();
            }
            else
            {
                
            }
 
  // selectedSummary+="<li>"+$(this).attr("data-text")+"</li>";
});

 $('.answerCheck').each(function() {
     
    // $("#li"+$(this).attr("id")).remove();
     
     if($(this).prop("checked") == false)
            {
                id= $(this).attr("id");
                $("#li"+id).remove();
            }
            else
            {
                
            }
 
  // selectedSummary+="<li>"+$(this).attr("data-text")+"</li>";
});
/*$('select.dynamicQues:not(:selected)').each(function() 
{
 $(this).attr("id");
});*/
if(type=="radio")
{
    if(jQuery.inArray(qnId, question_list_ids) == -1){
      question_list_ids.push(qnId);
    }
    delete selectedOptions[forID];
    delete selectedAnsOptions[forID];
    selectedAnsOptions[forID]=$('#'+elementId).val();
    for(var AnsOptions in selectedAnsOptions)
    {
      if(forID < AnsOptions){
        //sessionStorage.removeItem(selectedAnsOptions[AnsOptions]);
        delete selectedAnsOptions[AnsOptions];
      }
    }
    
    // console.log('selectedAnsOptions=>',selectedAnsOptions)
    
    selectedOptions[forID]="<li id='li"+elementId+"' class='"+elementId+"'>"+$('#'+elementId).attr("data-question")+"</li>";
    selectedOptions[forID]+="<li id='li"+elementId+"' class='"+elementId+"'>Ans: "+$('#'+elementId).attr("data-text")+"</li>";
    
    $("#li"+elementId).remove();
     $("."+elementId).remove();
     selectedSummary="";
     for (var optionKey in selectedOptions) {
      if(forID >= optionKey)
        selectedSummary+=selectedOptions[optionKey];
      else
        delete selectedOptions[optionKey];

     }
     
     sessionStorage.removeItem(elementId);
     sessionStorage.setItem(elementId, $('#'+elementId).val());
     //console.log('=>',sessionStorage.getItem(elementId))
    // alert(selectedSummary);
}


if(type == 'checkbox'){
      var selectedOp = selectedAnsOptions[forID]||'';
      var sOpt = selectedOp.split(',');
    if($("#"+elementId).prop("checked") == true){
      
      sOpt.push($("#"+elementId).val());
      sOpt = sOpt.filter(function (el) {
        return el != null && el != "";
      });
      
      
    }else{
      sOpt.splice($.inArray($("#"+elementId).val(), sOpt),1);
    }
    selectedAnsOptions[forID] = sOpt.join();
    question_list_ids.push(qnId);
      if($("#serviceTotPrice").val() != '') {
           var priceArr = JSON.parse($("#serviceTotPrice").val());
         }
    i=0;
    $.each($(".answerCheck:checked"), function(){ 
        if(i == 0 ){
            selectedSummary+="<li id='li"+elementId+"' class='"+elementId+"'>"+$('#'+elementId).attr("data-question")+"</li>";
            i++;
        }
        selectedSummary+="<li id='li"+elementId+"' class='"+elementId+" checkAnswer'>Ans: "+$(this).attr("data-text")+"</li>";
        for(j=0;j< priceArr.length;j++){

            if(priceArr[j]['price'] == $(this).attr("data-price")){
               priceArr.splice(i, 1);
               break;
            }
        }

        price = $(this).attr("data-price");
        priceArr.push({
            qnId : qnId, 
            price : price
        });
    });
    
    $.each($(".answerCheck:unchecked"), function(){ 
        // var aloted = selectedAnsOptions[forID];
        // var aloted_ar = aloted.split(",");
        // var remove_Item = $("#"+elementId).val();
        // if(jQuery.inArray(remove_Item, aloted_ar)!== -1){
        //   aloted_ar.splice($.inArray(remove_Item, aloted_ar),1);
        //   // aloted_ar = $.grep(aloted_ar, function(value) {
        //   //   return value != remove_Item;
        //   // });
        //   console.log(aloted_ar.join());
        //   selectedAnsOptions[qd] = aloted_ar.join();
        // }
        for(j=0;j< priceArr.length;j++){

            value = $(this).attr("data-price");
            var qd= $(this).attr("for");

            if(priceArr[j]['price'] == value  && priceArr[j]['qnId']==qd){ 
               priceArr.splice(j, 1);
               break;
            }
        }
    });
    $("#serviceTotPrice").val(JSON.stringify(priceArr));
    // console.log(selectedOptions);
    sessionStorage.removeItem(elementId);
    sessionStorage.setItem(elementId, $('#'+elementId).val());
    // console.log(priceArr);
}
//console.log(selectedAnsOptions);
if(type=="drop")
{
     valus = $('#'+elementId+' option:selected').html();
     //$(this).children("option:selected").val();
     $("#li"+elementId).remove();
     $("."+elementId).remove();
     if(valus!="Select" && valus!="select")
     {
     selectedSummary+="<li id='li"+elementId+"' class='"+elementId+"'>"+valus+"</li>";
     sessionStorage.removeItem(elementId);
     sessionStorage.setItem(elementId, $('#'+elementId).val());
     }else
     {
          sessionStorage.removeItem(elementId);
     }
}
if(type=="text")
{
     $("#li"+elementId).remove();
     $("."+elementId).remove();
     selectedSummary+="<li id='li"+elementId+"' class='"+elementId+"'>"+$('#'+elementId).val()+"</li>";
     sessionStorage.removeItem(elementId);
     sessionStorage.setItem(elementId, $('#'+elementId).val());
}


// alert(type);
 //var selectedText = $(".dynamicQues option:selected").html();
//alert(selectedText);
if(scheduleDate!="")
    {
     $("#sheduleLi").remove();
     $(".sheduleLi").remove();
    selectedSummary+='<li id="sheduleLi" class="sheduleLi"> <b>Schedule </b> <span class="Adddate">'+scheduleDate+'</span> <span class="Addtime">'+scheduleTime+'</span></li>';
    }
 //selectedSummary+='<li> <b>Schedule</b> <span class="Adddate">29 May 2019</span> <span class="Addtime">6:45 PM</span></li>';
//selectedSummary+="</ul>";
       var priceArr = JSON.parse($("#serviceTotPrice").val());
       var currency = $("#serviceCurrency").val();
       serviceTotPrice = 0;
       for (var i = 0; i < priceArr.length; i++) {
        
        serviceTotPrice = +serviceTotPrice +  +priceArr[i]['price'];
        
      }
       // alert(selectedSummary); 
        $(".summaryUl").html('');
        loadSummaryUI(priceArr);
       //$(".summaryUl").append(selectedSummary);
       $(".serviceTotPrice").text('Price '+currency+' '+serviceTotPrice);
       $("#serviceTotPricePass").val(serviceTotPrice);
       $(".noselect").html("");
    }
    function loadSummaryUI(priceArr){
      var $uniqueQids = [];
      $.each(priceArr, function( index, value ) {
          if(jQuery.inArray(value['qnId'], $uniqueQids) == -1){
            $uniqueQids.push(value['qnId']);
          }
      });
      var html = '';
      $.each($uniqueQids, function( index, value ){
        var question = $("#div"+value+" h3").html();
        html = html + '<li id="lidynamicQues2140" class="dynamicQues'+value+'">'+question+'</li>';
        var option_type = $("#div"+value).attr("data-element-type");
        if(option_type == 5){
          //checkbox
          $(".radio"+value+":checked").each(function(){
            if($(this).prop("checked",true)){
              var op= $(this).val();
              var opttext = $(this).parent().text();
              html = html + '<li class="checkAnswer">'+opttext+'</li>';
            }
          });
        }else if(option_type == 2){
          var op= $("#dynamicQues"+value).val();
          var option = $('#dynamicQues'+value).find('option:selected').attr('data-text')||'';
          html  = html + '<li class="checkAnswer">'+option+'</li>';
        }else{
          var op= $(".radio"+value+":checked").val();
          html  = html + '<li class="checkAnswer">'+$('[for="dynamicQues'+op+'"]').html()+'</li>';
        }
      });
      $(".summaryUl").html(html);
    }
   function populateOldData()
   {
       $('.answerRadios').each(function() {
        $(this).prop("checked",false);
         id = $(this).attr("id");
         //alert(id);
        // alert(sessionStorage.getItem(id));
        if(sessionStorage.getItem(id)!="" && sessionStorage.getItem(id)!=null) 
        {
           // alert(sessionStorage.getItem(id));
            $(this).prop("checked",true);
        }
   
});
$('select.dynamicQues').each(function() {
 
     id = $(this).attr("id");
        if(sessionStorage.getItem(id)!="") 
        {
            $(this).val(sessionStorage.getItem(id));
        }
});

$('textarea.dynamicQues').each(function() {
 
          id = $(this).attr("id");
        if(sessionStorage.getItem(id)!="") 
        {
            $(this).val(sessionStorage.getItem(id));
        }
});
$('input.dynamicQues[type="text"]').each(function() {
 
   id = $(this).attr("id");
        if(sessionStorage.getItem(id)!="") 
        {
            $(this).val(sessionStorage.getItem(id));
        }
});
   }
    $( document ).ready(function() 
    {
        
    sessionStorage.clear();
    $("#firstButton").css("visibility","visible");
});
 $(document).delegate("#saveDynamicAddress","click",function(e)
    {
        
        $("#formDynamicLocation").submit();
           
    });

var validator=$("#formDynamicLocation").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          "pickup-input2": 
          {
            required: true,
            maxlength: 100
            
          }
        },
       
        messages: 
        {
       
         },
     submitHandler: function ()
        {
            
        
            
                var formData = new FormData($("#formDynamicLocation")[0]);

                csrf_value  =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/updateDynamicLocation',
             type: 'POST',
             data: formData,
             async: false,
             success: function (data) 
                {
                   
                     data =  jQuery.parseJSON(data);
                    if(data['status']==1)
                    {
                        $(".pageWrapp").hide();
                         swal("Location has been updated successfully");
                         $("#formDynamicLocation")[0].reset();
                         $("#loactionUpdate").modal("hide");
                         $("#serviceLocation").val(data['address'].user_adresses_location);
                         $("#serviceAddress").val(JSON.stringify(data['address']));
                         $('.paymentOption').show();
                        
                        if($("input:radio.paymentOptionChoose:checked").length==0)
                        {
                            $("input:radio.paymentOptionChoose:first").prop("checked", true).trigger("click");
                        }
                    }
                    else
                    {
                         
                        if(data['errors'] !== "")
                          {
                            $.each(data['errors'], function(key, value) 
                            {
                              
                                 $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
                                

                            });   
                            
                            
                          }else
                          {    
                           
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
 /* $(document).delegate(".homeType","click",function(e)
    {
        
        alert();
           
    });*/
 
</script>


<script>
    
     $(document).delegate("#backFromAddressList","click",function(e){
        goToLocationTab();
     });

    $(document).delegate('#btnAddressNext','click',function(e){

            error = 0 ;
            
            if($("input:radio[name='address']").is(":checked")) {
                address_id = $('input[name="address"]:checked').val();
                // alert(address_id);
                if(address_id > 0 && address_id !="undefined" ){

                    goToPaymentOption();
                }else{
                    swal("Please select an address");
                    error = 1;
                    return false;
                }
            }else{
                swal("Please select an address");
                    error = 1;
            }
            
       });
    
    function goToAddressList(){

        getAddressList();

        $(".pageWrapp").css("display","none");
        $(".addresPan").css("display","block");
     }
     
     function goToAddressOption(){
        $(".pageWrapp").css("display","none");
        $(".addresPan").css("display","block");
     }
     
     function getAddressList(){
       
        $.ajax({

            url: '<?php echo base_url();?>website/Request/getUserAddressList',
            type: 'POST',
            data: {},
            async: true,
            success: function (data){
                $('#addressList').html(data);
                //getUserWallet();
                // console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    
    
    $(document).delegate('.fa-trash','click',function(e){
        id = $(this).attr("for");
        deleteThis(id);
    });
    
    function deleteThis(id){
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        
        .then((willDelete) => {
            
            if (willDelete) {
                $.ajax({
                    url: '<?php echo base_url();?>website/Request/deleteAddressData',
                    type: 'POST',
                    data: {id:id},
                    success: function (data){
                        if(data == 1 ){
                            swal('Address deleted successfully');
                            getAddressList();
                        }else if(data == -1 ){
                            swal("Sorry!", "You are trying to delete default address", "error");
                        }else{
                            swal("Sorry!", "Failed to delete address please try again", "error");
                        }
                    }
                });
            }
        });
    }
    
    $(document).delegate(".fa-edit","click",function(e){

    id = $(this).attr("for");
    // alert(id);
    $.ajax({
 
            url: '<?php echo base_url();?>website/Request/getUserAddressDetails',
            type: 'POST',
            data: {id:id},
            success: function (data){
               $('#formDynamicAddress').html(data);
            }
        });
    $('#addressBook').modal('show'); 
}); 
    
    $('#addNewAddress').click(function(){
        $('#formDynamicAddress').trigger("reset");
        $('#addressBook').modal('show'); 
    });

    var validator = $('#formDynamicAddress').validate({
        ignore: [],
        rules : {
            'pickup-input2' :{
                required : true,

            },
            first_name :{
                required : true,
            },
            'last_name' : {
                required : true,
            },

            'email' : {
                required :true,
                email:true
            },

            'user_phone' : {
                required : true,
            },

            'country' :{
                required : true,
            },

            'city' : {
                required : true,
            },

            'area' : {
                required : true,
            },
            'street_name' : {
                required : true,
            },
            'building_name' :{
                required : true,
            }


        },
        messages : {
            'pickup-input2' :{
                required : "Location  is required",
            },
            first_name :{
                required : "First name  is required",
            },
            'last_name' : {
                required : "Last name  is required",
            },

            'email' : {
                required :"Email id  is required",
                email: "Enter a valid email"
            },

            'user_phone' : {
                required : "Mobile number  is required",
            },

            'country' :{
                required : "Country name is required",
            },

            'city' : {
                required : "City name is required",
            },

            'area' : {
                required : "Area name is required",
            },
            'street_name' : {
                required : "Street name is required",
            },
            'building_name' :{
                required : "Building name is required",
            }
        },
        
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
            $(".form-errors").html("All fields must be completed before you submit the form.");
        },

        submitHandler : function(){
            // alert('Hai');
            // switchStatus = $('#defalut_address').is(':checked');
            // if ($('#defalut_address').is(":checked"))
                // alert('defalut address');
            var formData = new FormData($("#formDynamicAddress")[0]);
            $.ajax({
                url: '<?php echo base_url();?>website/Request/saveUserAddress',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data){
                    data =  jQuery.parseJSON(data);
                    if(data['status']==1){
                        $('#form_id').trigger("reset");
                        $('#addressBook').modal('hide'); 
                        swal(data['message']);
                        getAddressList();
                    }else{
                        if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value){
                                $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
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
    
    $('body').on('change', '#country', function(e) {
        // country_code = '+'+$("#country option:selected").attr("for");
        // // $('#dial_code').val(country_code);
        country_id = $('#country').val();
        getCityList(country_id);
    });

    function getCityList(country_id){
        // alert(country_id);
        $.ajax({
             url: '<?php echo base_url();?>website/Request/getCityListByCountryId',
             type: 'POST',
             data: {country_id:country_id},
             success: function (data){
                $('#city').html(data);
                console.log(data);
            }
        });
    }
    
  
    
    $('body').on('change', '#city', function(e) {
        city_id = $('#city').val();
        $.ajax({
             url: '<?php echo base_url();?>website/Request/getAreaByCityId',
             type: 'POST',
             data: {city_id:city_id},
             success: function (data){
                $('#area').html(data);
            }
        });
    });
    
   //  $('div.day').on('click', function(){
   //      var todayDate = new Date();
   //      var selectedDate= $('#service_date').val();
   //      alert(selectedDate);
   //      selectedDate = new Date(selectedDate);

   //      if(selectedDate.setHours(0,0,0,0) == todayDate.setHours(0,0,0,0)) {
   //          alert('Today');
   //      }else{
   //          alert(selectedDate.setHours(0,0,0,0) +' another day '+todayDate.setHours(0,0,0,0));
   //      }
   // });

   function updateSlotTime(){

        var todayDate = new Date();
        var selectedDate= $('#service_date').val();
        // alert(selectedDate);
        selectedDate = new Date(selectedDate);

        if(selectedDate.setHours(0,0,0,0) == todayDate.setHours(0,0,0,0)) {
            $('#today_slot').css("display","block");
            $('#new_slot').css("display","none");
        }else{
            $('#today_slot').css("display","none");
            $('#new_slot').css("display","block");
        }
   }
    

    function billDetails(discount){
        vatAmount   = 0; 
        totalPrice  = $('#serviceTotPricePass').val();//Number($("#price_to").html());
        totalPrice  = totalPrice-discount;
        vat         = '<?=VAT?>';
        if(vat)
            vatAmount   = ( totalPrice * vat ) / 100;
        grandTotal  = vatAmount + totalPrice;
        
        $('#totalPrice').html('AED ' +totalPrice);
        $('#vatAmount').html('AED ' +vatAmount);
        $('#discount').html('AED ' +discount);
        $('#grandTotal').html('AED ' +grandTotal);
          $('#grant_total_amount').val(grandTotal);


    }

    $(document).delegate("#coupon","click",function(e){
        if($('#coupon').text() =='remove'){
            $('#coupon').text('Apply');
            $('#coupon_code').val('');
            $('#coupon_code').prop("readonly", false);
            billDetails(0);
            
        }else{
            $("#coupon-form").submit();
        }
        
        return false;

    });

    var validator = $('#coupon-form').validate({
        ignore: [],
        rules: {
            coupon_code :{
                required : true,
            }
        },
        messages: {
            coupon_code :{
                required : 'Enter a coupon code',
            }
        },

        // errorPlacement: function(error, element) {
        //     var placement = $(element).data('error');
        //     if (placement) {
        //     $(placement).append(error)
        //   } else {
        //     error.insertAfter(element);
        //   }
        // },

        submitHandler: function (){

            coupon_code = $('#coupon_code').val();
            totalPrice  = $('#serviceTotPricePass').val();//Number($("#price_to").html());
            // alert(coupon_code);
            $.ajax({    
                url : '<?=base_url()?>website/user/validateCouponCode',
                type: 'POST',
                data: {coupon_code:coupon_code,total_price:totalPrice},
                success: function (data){
                    data =  jQuery.parseJSON(data);
                    if(data['status'] > 0 ){
                        // $('#coupon').text('Cancel coupon');
                        // $('#totalPrice').html('AED ' +totalPrice);
                        $('#vatAmount').html('AED ' +data['vat_amount']);
                        $('#discount').html('AED ' +data['discount']);
                        $('#grandTotal').html('AED ' +data['grand_total']);
                        $('#coupon_code').prop("readonly", true);
                        $('#coupon').text('remove');
                        $('#grant_total_amount').val(data['grand_total']);

                    }else{
                        billDetails(0);
                        swal("Sorry!",data['message'] , "error");
                    }
                },
            }); 
            return false;
        }
    });
    
    $(document).ready(function(){
        // check request mode
        $("input[name=service_request_type]").change(function(){

            $('.week_days').prop("checked",false);
            if($(this).val() == 1)
            {
                $("#day_selector").hide();
            }
            else
            {
                $("#day_selector").show();
            }
            WeeklyCalculation();
        });

        // calculation with weekly days change
        $(".week_days").click(function(){
            WeeklyCalculation();
        });

        function WeeklyCalculation()
        {
            var priceArr = JSON.parse($("#serviceTotPrice").val());
            var currency = $("#serviceCurrency").val();
            serviceTotPrice = 0;
            for (var i = 0; i < priceArr.length; i++) {
              
                serviceTotPrice += priceArr[i]['price'];
              
            }

            selected_days   = $('.week_days:checked').length;
            finalAmount     = serviceTotPrice;
            if(selected_days > 0 && $("input[name=service_request_type]:checked").val() == 3)
            {
                finalAmount = finalAmount*selected_days*4;
            }
            else if(selected_days > 0 && $("input[name=service_request_type]:checked").val() == 2)
            {
                finalAmount = finalAmount*selected_days*1;
            }
            else
            {
                finalAmount = serviceTotPrice;
            }

            $('#serviceTotPricePass').val(finalAmount);
            $(".serviceTotPrice").text('Price '+currency+' '+finalAmount);
        }


        
    });

    $(document).delegate("#requestModeNext","click",function(e){

        $("#requestModePanel").hide();
        $("#dynamicQuestionArea").show();
        $(".commonDisplayQuestion").show();
    });
    $(document).delegate("#backtoRequestMode","click",function(e){

        $("#requestModePanel").show();
        $("#dynamicQuestionArea").hide();
        $(".commonDisplayQuestion").hide();
    });
</script>
<?php
if($service_details->is_weekly_available == 0 && $service_details->is_weekly_available ==0)
{
    ?>
    <script type="text/javascript">
        $("#requestModeNext").trigger("click");
    </script>
    <?php
}

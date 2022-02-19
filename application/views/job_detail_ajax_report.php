    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="<?php echo base_url();?>frontend_assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/mediaquery.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/style_sheet.css"/>
  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/fontawesome.css"/>
   <link rel="stylesheet" href="<?php echo base_url();?>admin_assets/swal/sweetalert.css"> 
    <!--carousel CSS-->
    <link href="<?php echo base_url();?>frontend_assets/css/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>frontend_assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>frontend_assets/css/style_new.css">
    <body>
 <?php
 //print_r($result);
                             $date = new DateTime($result->job_time);
   
                             $timeFormated = $date->format('h:i A') ;
                             $date2 = new DateTime($result->job_date);
                             $daeFormated = $date2->format('d-m-Y') ;
                             
                             $date3 = new DateTime($result->job_validity_time);
                             $timeFormated2 = $date3->format('h:i A') ;
                             $date4 = new DateTime($result->job_validity_date);
                             $daeFormated2 = $date4->format('d-m-Y') ;
                             $user_id =$result->user_id;
                              if($result->is_home_category==0)
                                       {
                                           if($user_id>0)
                                           {
                                               $addressType        = $result->address_type;
                                               
                                               $alternateLocation  =   $this->M_request->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                              // $overallAddress =$alternateLocation->user_adresses_location.",".$alternateLocation->city.",".$alternateLocation->state;
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $result->job_longitude!=""?$result->job_longitude:"";
                                           $latiTude = $result->job_lattitude!=""?$result->job_lattitude:"";
                                           $location = $result->job_location!=""? $result->job_location.",".$result->city.",".$result->state:"";
                                       }
                                       
                                       $languageCode          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
                                       
                                      $priceRange = $result->job_price_to!=""?"AED ".$result->job_price_from."-".$result->job_price_to:"NA";
                                      
                                       if($result->job_request_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                          
                                       }
                                        else if($result->job_request_status==5)
                                       {
                                           $jobStatus = $this->lang->line("completed");
                                          
                                       }
                                       else if($result->job_request_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                          
                                       }
                                       else
                                       {
                                           $jobStatus = $this->lang->line("pending");
                                       }
                                       
                                       $encJobId = $this->common_functions->encryptId($result->job_request_id) ;
 ?>
 <div class="row margin_none">
          <div class="col-md-6 col-sm-12">
              <h3><?php echo $result->job_request_type=="1"?"Quotation Details":"Job Request Details" ?></h3>
          </div>
          <div class="col-md-6 col-sm-12">
          <a href="<?php echo base_url()."website/Request/printJobDetails?id=".$encJobId;?>"><button type="button" class="reject button-width" style="width:165px;color:#fff">Download pdf</button></a>
          </div>
          <div class="red-bar">
              <div class="title">Job Category : <?php echo $result->service_type_name;?></div>
              <div class="time"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/time_wht.png" /></i>Time : <?php echo $timeFormated; ?></div>
              <div class="date"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/calender_wht.png" /></i>Date : <?php echo $daeFormated;?></div>
          </div>
      </div>
      <div class="row margin_none">
          <div class="col-md-6">
              <div class="section">
                 <h4>
                     <div class="row">
                     <div class="col-md-6">
                     Job Number : <?php echo $result->job_request_display_id;?>
                    </div>
                    <div class="col-md-6">
                     Status : <?php echo $jobStatus;?>
                    </div>
                    </div>
                 </h4>
                 <div class="row">
                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/calender.png" /></i> Work Expiry Date : <?php echo date("d-m-Y",strtotime($result->job_validity_date));?></span>
                     </div>
                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/time.png" /></i> Work Expiry Time : <?php echo date("h i A",strtotime($result->job_validity_time));?></span>
                     </div>
                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/locations.png" /></i> Location : <?php echo $location;?></span>
                     </div>
                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/price.png" /></i> Price Range : <?php echo $priceRange ;?> </span>
                     </div>
                 </div>
              </div>
          </div>
          <?php
          $confirmed  =   $this->M_request->checkConfirmedStatus($result->job_request_id); 
          
          if($confirmed>0)
          {
          
          ?>
          <div class="col-md-6">
              <div class="section">
                 <h4>Customer Details</h4>
                 <div class="row">
                     <div class="col-md-12">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/customer.png" /></i> Name : <?php echo $result->user_first_name." ".$result->user_last_name;?></span>
                     </div>
                     <div class="col-md-12">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/call.png" /></i> Mob :  <?php echo  $result->user_dial_code;?> <?php echo  $result->user_phone;?></span>
                     </div>
                     <div class="col-md-12">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/email.png" /></i> Email : <?php echo  $result->user_email;?></span>
                     </div>
                 </div>
              </div>
          </div>
          <?php
          }
          else
          {  if($this->session->userdata('eq_user_type')==1)
            {
                if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=2)
                {
              ?>
               <div class="col-md-6">
                <div class="section">
                  <div class="btn_wrap">
                    <button type="button" class="reject button-width changeStatus" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>">Cancel</button>
                  </div>
                  </div>
                </div>
              <?php
                }
            }
            if($this->session->userdata('eq_user_type')==2)
            {
                 if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=2)
                {
                ?>
                
                <div class="col-md-6">
                <div class="section">
                  <div class="btn_wrap">
                      <?php
                         $providerId      =  $this->session->userdata('eq_user_id');
                         $assignedStatus  =  $this->M_request->getAssignedStatus($providerId,$result->job_request_id); 
                         
                        // print_r($assignedStatus);
                    if($assignedStatus->assign_status!=2 && $assignedStatus->user_response_status<=0 && $assignedStatus->provider_id>0)
                     {
                      ?>
                    <button type="button" class="reject button-width changeStatus" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>">Cancel</button>
                    
                     <?php
                     }
                     
                   
                     
                     if($result->job_request_type==2 && $assignedStatus->assign_status==0 && $assignedStatus->user_response_status<=0)
                     {
                    ?>
                     <button type="button" class="accept button-width changeStatus" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(1);?>">Accept</button>
                    <?php
                     }
                    ?>
                  </div>
                  </div>
                </div>
                <?php
                }
                
            }
          }
          ?>
          <div class="col-md-6">
              <div class="section">
                 <h4>Service Summary</h4>
                 <div class="row">
                     <div class="col-md-6">
                         <?php
                         //print_r($question);
                         $question_id =0;
                          if(count($question)>0)
                             {
                                 $k=0;
                                 foreach($question as $rows)
                                 {
                                     
                                     $answer =($languageCode==2 && $rows->answer_option_arabic!=""?$rows->answer_option_arabic:$rows->answer_option);
                                     $answer                                        =  $answer!=""?$answer:$rows->answer;
                                    
                                     ?>
                                 <?php 
                                  if($question_id!=$rows->question_id)
                                     {
                                         ?>
                                         <span><b>
                                         <?php
                                 echo ($languageCode==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question);?>  : </b>
                                 <?php
                                     }
                                     $question_id  = $rows->question_id;
                                 ?>
                                 <br></span>
                                 <?php echo $answer ?>
                        
                                     <?php
                                    
                                 }
                                 
                                 
                             }
                             else
                             {
                                echo "No results found";
                             }
                         ?>
                      
                         <span><b>Relevant Documents : </b><br>
                         
                         <?php if(count($files)>0){ ?>
                         <ul class="documents">
                             
                             <?php  foreach($files as $rows)
                                 {
                                     //$rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:"";
                                     ?>
                                      <li><a target="_blank" href="<?php echo $rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png" /></i><span><?php echo $rows->documents_name;?></span></a></li>
                                  
                                  <?php   
                                 }
                                 ?>
                            
                         </ul>
                         <?php } ?>
                         </span>
                         <span><b>
                                        Remarks: </b>
                                                                  <br><?php echo $result->description; ?></span>
                       
                         
                     </div>
                   <div class="col-md-6">
                       <?php
                       if($this->session->userdata('eq_user_type')==2)
                       {
                           $provider_id   =  $this->session->userdata('eq_user_id');
                           $markedPrice   = $this->M_request->getMarkedPrice($provider_id,$result->job_request_id); 
                           
                           if($markedPrice->provider_amount>0)
                           {
                           ?>
                            <span><b>Provider Document : </b><br>
                            <ul class="documents">
                                 <li><?php if($markedPrice->document_name!=""){ ?><a target="_blank" href="<?php echo base_url().'uploads/quotations/'.$markedPrice->document_name ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png"></i><span><?php ?></span></a><?php } ?></li>
                            </ul></span>
                            <ul class="documents">
                                 <li><h4><b>Marked price : AED <?php echo $markedPrice->provider_amount; ?></b></h4></li>
                            </ul>
                           <?php
                           }
                       }
                       ?>
                    </div>
                     <?php
                      // echo $result->assign_status."syam";
                      // print_r($result);
                     
                     if($result->job_request_type=="1" && $staus->assign_status!=2 && $staus->user_response_status!=2 && $staus->user_response_status!=4 && $staus->assign_status!=3 && $this->session->userdata('eq_user_type')==2 && $result->job_request_status!=2 && $result->job_request_status!=5 && $result->job_request_status!=4) { ?>
                     <div class="col-md-12">
                       <form id="formMarkPrice"  method="post">
                        <div class="input-group mt-3" id="fileDiv">
                          <input class="form-control" type="text" placeholder="Enter Price" name="txt_price" id="txt_price" maxlength="5">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile02" name="file_doc">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02" id="labelUploadDoc">Upload Document(max size 20MB)</label>
                          </div>
                         
                        </div>
                        &nbsp;<button type="button" class="btn btn-secondary" id="btnMarkPrice" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>">Submit</button>
                        </form>
                     </div>
                     <?php
                     }
                     ?>
                 </div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="section">
                 <h4>Work Location : <span><?php echo $location;?></span></h4>
                 <div class="row">
                     <div class="col-md-12">
                        <div id="map3" style="height: 250px;"></div>
                        
                     </div>
                     
                 </div>
              </div>
          </div>
      </div>
    </body>
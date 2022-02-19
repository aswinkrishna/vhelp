 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

<!-- date picker JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
 
 
 <?php
    $service_request_mode_labels    = $this->config->item('service_request_mode_labels','app');

    if($this->session->userdata('eq_user_type') == 1 && $result->job_request_status == 5 ){
        
        $rating_details = $this->M_user->getRatingByRequestId($result->job_request_id);
        if($rating_details)
            $rating = 0;
        else
            $rating = 1;
    }else{
        $rating = 0;
    }

                             $date = new DateTime($result->job_time);
   
                             $timeFormated = $date->format('h:i A') ;
                             $date2 = new DateTime($result->job_date);
                             
                             $daeFormated = date("d-m-Y",strtotime($result->job_request_created_time)) ;
                             $timeFormated = date("h:i A",strtotime($result->job_request_created_time)) ;
                             
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
                                       
                                      $priceRange = $result->job_total_price> 0? $this->config->item('currency').' '.$result->job_total_price : "NA";
                                      
                                      if($result->job_request_status == 10 ){
                                            $jobStatus = 'Canceled';

                                      }else if($result->job_request_status==4)
                                       {
                                           $jobStatus = 'On-going';//$this->lang->line("approved");
                                          
                                       }
                                        else if($result->job_request_status==5)
                                       {
                                           $jobStatus = $this->lang->line("completed");
                                          
                                       }else if($result->job_request_status==3)
                                       {
                                           $jobStatus = 'Staff assigned';//$this->lang->line("approved");
                                          
                                       }

                                       else if($result->job_request_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                          
                                       }else if($result->job_request_status== 1 ){
                                          $jobStatus = "Accepted";
                                       }
                                       else
                                       {
                                           $jobStatus = $this->lang->line("pending");
                                       }
                                       
                                       $encJobId = $this->common_functions->encryptId($result->job_request_id) ;
                                       
                                       $confirmed  =   $this->M_request->checkConfirmedStatus($result->job_request_id); 
                                       
                                       
 ?>
 <div class="row margin_none">
          <div class="col-md-10 col-sm-12">
              <h3><?php echo $result->job_request_type=="1"?"Quotation Details":"Job Request Details" ?></h3>
          </div>
          <div class="col-md-2 col-sm-12">
          <a href="<?php echo base_url()."website/Request/printJobDetails?id=".$encJobId;?>"><button type="button" class="reject button-width" style="width:165px;color:#fff;background: #44a726;">Download pdf</button></a>
          </div>
          <div class="red-bar" >
              <div class="title">Job Category : <?php echo $result->service_type_name;?></div>
              
              <?php if($result->job_date!="") { ?>
              <div class="time" ><i><img src="<?php echo base_url();?>frontend_assets/images/icons/time_wht.png" /></i>Time : <?php echo $timeFormated; ?></div>
              <div class="date" ><i><img src="<?php echo base_url();?>frontend_assets/images/icons/calender_wht.png" /></i>Date : <?php echo $daeFormated;?></div>
              <?php } ?>
          </div>
      </div>
      <div class="row margin_none">
          <div class="col-md-8">
              <div class="section">
                 <h4>
                     <div class="row">
                     <div class="col-md-6">
                     Job Number : <?php echo $result->job_request_display_id;?>
                    </div>
                    <div class="col-md-6">
                        <?php
                            if($result->job_request_status == 10 )
                                $jobStatus = "Canceled ";
                            else if($result->job_request_status == 5 )
                                $jobStatus = "Completed";
                            else if($result->job_request_status == 4 )
                                $jobStatus = "Ongoing";
                            else if($result->job_request_status == 3 )
                                $jobStatus = "Staff accepted";
                            else if($result->job_request_status == 2 )
                                $jobStatus = "Rejected";
                            else if($result->job_request_status == 1 ){
                                if($assigned_staff->user_id > 0 && $assigned_staff->job_status != 2 )
                                    $jobStatus = "Assigned to staff";
                                else
                                    $jobStatus = "Accepted";
                            }else 
                                $jobStatus = "Pending";
                        ?>
                     Status : <?php  echo $jobStatus ?>
                    </div>
                    </div>
                 </h4>
                 <div class="row job-description">
                     
                    <div class="col-md-6">
                         <span><i class="fa fa-briefcase"></i> Service Type : <?=$service_request_mode_labels[$result->request_mode]?></span>
                     </div>

                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/calender.png" /></i> Service Date : <?php echo date("d-m-Y",strtotime($result->job_validity_date));?></span>
                     </div>
                     <div class="col-md-6">
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/time.png" /></i> Service Time : <?php echo date("h i A",strtotime($result->job_validity_time));?></span>
                     </div>
                     <div class="col-md-6">
                         <!--<span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/locations.png" /></i> Location : <?php echo $location;?></span>-->
                         <?php
                            if($result->address_type == 1 )
                                $address_type = "Home";
                            else
                                $address_type = "Office";
                        ?>
                         <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/locations.png" /></i> Address Type : <?=$address_type?></span>
                     </div>
                     
                    <div class="col-md-6">
                        <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/price.png" /></i> Price : <?php echo $result->grand_total ;?> </span>
                    </div>
                    
                    <?php
                            if($assigned_staff->job_status != 2  ){
                              $assignedStaff    = $assigned_staff->user_first_name.' '.$assigned_staff->user_last_name;
                              $assignedStaffId  = $assigned_staff->user_id;
                              $staffStatus      =  $assigned_staff->job_status;
                            }else{
                                $staffStatus = 0;
                            }
                            
                        if($staffStatus > 0 ){
                    ?>
                    <div class="col-md-6" style="<?=($result->request_mode != REQUESTMODE_ONETIME)?'display: none;':''?>">
                        <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/staff.png" /></i> Staff Name : <?=$assignedStaff?> </span>
                    </div>
                    
                    <?php
                        }
                        if($result->job_request_status == 5 ){
                    ?>  
                        <div class="col-md-6">
                            <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/time.png" /></i> Job duration : <?=$result->time_taken?> </span>  
                        </div>
                    <?php
                        }
                    ?>
                    <div class="col-md-6">
                        <?php
                            if($result->payment_method == 1 )
                                $payment = "Cash on delivery";
                            else
                                $payment = "Debit/Credit Card";
                        ?>
                        <span><i><img src="<?php echo base_url();?>frontend_assets/images/icons/money.png" /></i> Payment : <?=$payment?></span>
                     </div>
                 </div>

              </div>
          </div>
          <?php
          
          
          if($confirmed>0)
          {
          
          ?>
          <div class="col-md-10">
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
                if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=1 && $result->job_request_status!=2 && $result->job_request_status!= 10 )
                {
              ?>
               <div class="col-md-4">
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
                $currentDate   = date("Y-m-d H:i:s");
                $validityTotal = date("Y-m-d H:i:s",strtotime($result->job_validity_date." ".$result->job_validity_time));
                
                 if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=2)
                {
                    if(0){
                ?>
                
                <div class="col-md-6">
                <div class="section">


                     <?php
                      // echo $result->assign_status."syam";
                      // print_r($result);
                      
                      
                     
                     if($staus->assign_status!=2 && $staus->user_response_status!=2 && $staus->user_response_status!=4 && $staus->assign_status!=3 && $this->session->userdata('eq_user_type')==2 && $result->job_request_status!=2 && $result->job_request_status!=5 && $result->job_request_status!=4 && $currentDate<$validityTotal) { ?>
                     <h4>Submit Proposal</h4>
                     <div class="col-md-12" style="display:none;">
                       <form id="formMarkPrice"  method="post">
                        <span><b>Upload Document: </b></span>
                        <div class="input-group mt-3" id="fileDiv">
                          <input class="form-control" type="text" placeholder="Enter Price" name="txt_price" id="txt_price" maxlength="5">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile02" name="file_doc">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02" id="labelUploadDoc"><span class="fileUplaodWarning instruction" style="margin-top: 2px;">Max upload size:20MB, (pdf,doc,jpg,jpeg,png)</span></label>
                            
                          </div>
                         
                        </div>
                        &nbsp;<button type="button" class="btn btn-secondary" id="btnMarkPrice" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>">Submit</button>
                        </form>
                     </div>
                     <?php
                     }
                     ?>



                  <div class="btn_wrap">
                      <?php
                         $providerId      =  $this->session->userdata('eq_user_id');
                         $assignedStatus  =  $this->M_request->getAssignedStatus($providerId,$result->job_request_id); 
                         
                        // print_r($assignedStatus);
                    if($assignedStatus->assign_status!=2 && $assignedStatus->user_response_status<=0 && $assignedStatus->provider_id>0 && $this->session->userdata('eq_user_type')==1)
                     {
                      ?>
                    <button type="button" class="reject button-width changeStatus" for="<?php echo $this->common_functions->encryptId($result->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>">Cancel</button>
                    
                     <?php
                     }
                     
                   
                     
                     if($result->job_request_type==2 && $assignedStatus->assign_status==0 && $assignedStatus->user_response_status<=0 && $this->session->userdata('eq_user_type')==2 && 1==2)
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
          }
          ?>
          </div>

          <div class="row margin_none">
          <div class="col-md-4">
              <div class="section">
                 <h4>Service Summary</h4>
                 <div class="row">
                     <div class="col-md-12">
                        <h6><?=$result->service_type_name?></h6>
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
                                 <br></span>Answer : 
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
                         
                         <?php if($result->document){ ?>
                            <ul class="documents">
                                <li><a target="_blank" href="<?php echo $rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/view.png" /></i><span><?php echo $rows->document;?></span></a></li> 
                            </ul>
                         <?php } ?>
                         </span>
                         <span><b>
                                       <?php echo $this->session->userdata('eq_user_type')==2?"Additional Information":"Your requirements"?>: </b>
                                                                  <br><?php echo $result->description; ?></span>
                       
                         
                     </div>
                   <div class="col-md-12">
                       <?php
                       if($this->session->userdata('eq_user_type')==2)
                       {
                           $provider_id   =  $this->session->userdata('eq_user_id');
                           $markedPrice   = $this->M_request->getMarkedPrice($provider_id,$result->job_request_id);
                           //print_r($markedPrice);
                           
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
                 </div>
              </div>
          </div>
        
        <?php
            $userDetails =$this->M_request->getUserDetailsById($user_id);
            $image = 'uploads/user/'.$userDetails->user_image;
            if(file_exists($image) && is_file($image))
                $image = base_url().$image;
            else
                $image = base_url().'frontend_assets/images/profile-img.jpg';
        ?>        
        
        <?php
            if($this->session->userdata('eq_user_type') == 2 ){
        ?>
        <div class="col-md-4">
              <div class="section">
                 <h4>User Details</h4>
                 <div class="row">
                     <div class="col-md-12">
                        <div class="user-details">
                            <img src="<?=$image?>" />
                            <p>Name : <?=$userDetails->user_first_name.' '.$userDetails->user_last_name?> </p>
                            <p>Phone : <?=$userDetails->user_dial_code?> <?=$userDetails->user_phone?></p>
                            <p>Country : <?=$userDetails->country_name?></p>
                            <p>E-mail : <?=$userDetails->user_email?></p>
                        </div>
                     </div>
                 </div>
              </div>
          </div>
          
        <?php
            }
            if(0){
            if($assigned_staff->user_id > 0 && $assigned_staff->job_status != 2){
            $staff_details = $this->M_request->getUserDetailsById($assignedStaffId);
            $image = 'uploads/user/'.$staff_details->user_image;
            if(file_exists($image) && is_file($image))
                $image = base_url().$image;
            else
                $image = base_url().'frontend_assets/images/profile-img.jpg';
        ?>
        <div class="col-md-4" style="<?=($result->request_mode != REQUESTMODE_ONETIME)?'display: none;':''?>">
              <div class="section">
                 <h4>Staff Details</h4>
                 <div class="row">
                     <div class="col-md-12">
                        <div class="user-details">
                            <img src="<?=$image?>" />
                            <p>Name : <?=$staff_details->user_first_name.' '.$staff_details->user_last_name?> </p>
                            <p>Phone : <?=$staff_details->user_dial_code?> <?=$staff_details->user_phone?></p>
                            <p>Country : <?=$staff_details->country_name?></p>
                            <p>E-mail : <?=$staff_details->user_email?></p>
                        </div>
                     </div>
                 </div>
              </div>
          </div>
          <?php 
            }
            // print_r($assigned_staff);
          ?>
          

          <?php
          
            }
            $userDetails = $this->M_request->getUserAddress($result->address_id);
          ?>
          
          
        <div class="col-md-4 price-row">
              <div class="summery_row">
                <?php
                    $total_price = $result->job_total_price;
                    $discount    = $result->discount;
                    $total_price = $total_price-$discount;
                    $tax_amount  = ($total_price * $result->vat_percentage)/ 100; 
                ?>
                    <h3>Price Details</h3>
                    <h5>Total : <span><?=$result->job_total_price?> <?=CURRENCY_CODE?></span></h5>
                    <h5>Discount : <span><?=$result->discount?> <?=CURRENCY_CODE?></span></h5>
                    <h5>VAT <?=$result->vat_percentage?>% : <span><?=$tax_amount?> AED</span></h5>
                    <h5>Grand Total : <span> <?=$result->grand_total?> <?=CURRENCY_CODE?></span></h5>
                    
                 </div>
          </div>
          </div>
          
          
          <div class="row margin_none">
        
            <div class="col-md-12">
              <div class="section">
                 <h4>Work Location : <span><?php echo $location;?></span></h4>
                 <p>Area : <?=$userDetails->area_name?></p>
                <?php
                    if($this->session->userdata('eq_user_type') == 2 ){
                ?>
                 <div class="row">
                     <div class="col-md-12">
                        <div id="map_new" style="height: 250px;"></div>
                        
                     </div>
                     
                 </div>
                <?php
                    }
                ?>
              </div>

            </div>
            <?php
            if($result->request_mode != REQUESTMODE_ONETIME):?>
            <div class="col-md-12">
                <div class="section">
                    <h4>Job Days </h4>
                    <table width="100%">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach($job_days as $day)
                        {
                            $status     = "";
                            if($day->job_status == 0)
                            {
                                $status     = "<span class='badge badge-warning'>Pending</span>";
                            }
                            else if($day->job_status == 2)
                            {
                                $status     = "<span class='badge badge-danger'>Canceled</span>";
                            }
                            else if($day->job_status == 3)
                            {
                                $status     = "<span class='badge badge-primary'>Staff Accepted</span>";
                            }
                            else if($day->job_status == 4)
                            {
                                $status     = "<span class='badge badge-primary'>Job Started</span>";
                            }
                            else if($day->job_status == 5)
                            {
                                $status     = "<span class='badge badge-success'>Job Completed</span>";
                            }
                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=date('d M , Y',strtotime($day->job_date))." (".date('l',strtotime($day->job_date)).")"?></td>
                                <td><?=date('h:i A',strtotime($day->job_time))?></td>
                                <td><?=$status?></td>
                                <td><button class="btn btn-primary" data-toggle="modal" data-target="#ChangeDateModal">Change Date</button></td>
                            </tr>   
                            <?php
                            $i++;
                        }
                        ?>  
                        </tbody>
                    </table>
            </div>
            <?php endif; ?>
          <!--<input type="" value="<?=$result->job_request_status?>" >-->
          <input type="hidden" value="<?=$result->job_request_id?>" id="job_request_id">
          <?php
            if($this->session->userdata('eq_user_type')==2){
                if($result->job_request_status <= 0){
          ?>
            <div class="col-md-6">
              <button class="btn btn-primary accept-button" onclick="updateStatus(1);">Accept</button>
            </div>
          <?php
            }else if($result->job_request_status == 1 && $staffStatus == 0 ){
                
          ?>
          
          <?php
            if(!$assigned_staff || $assigned_staff->job_status == 2 ){
          ?>
          <div class="col-md-6">
            <form method="post" id="assign-staff-form">
            <div class="section">
                <h4>Assign Staff </span></h4>
                <div>
                  <div class="form-group row">
                      <div class="col-lg-5 col-md-6 col-12">
                        <input type="hidden" value="<?=$result->job_request_id?>" name="job_request_id">
                          <select class="form-control" name="staff" id="staff">
                            <option value="">Choose staff</option>
                            <?php
                              foreach ($staff_list as $key => $value) {
                                if($value->user_id == $assignedStaffId)
                                  $selected = "selected";
                                else
                                  $selected = "";
                                $name = $value->user_first_name.' '.$value->user_last_name;
                            ?>
                              <option value="<?=$value->user_id?>" <?=$selected?> ><?=$name?></option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                      <div class="col-lg-4 col-md-2 col-2">
                        <button type="submit" class="btn btn-sm btn-primary" id="assignStaff" style ="margin-top: 0px;">Assign Staff</button>  
                      </div>
                    </div>
                </div>
              </div>
            </form>
          </div>
        <?php       
                    }
                }
            }
        ?>
          
          
      </div>
      
      
<script type="text/javascript">

  function updateStatus(status){
    var job_request_id = $('#job_request_id').val();
    $.ajax({
        url   : '<?=base_url()?>website/User/updateStatus',
        type  : 'POST',
        data  : {job_request_id:job_request_id,status:status},
        success :function(data){
          data =  jQuery.parseJSON(data);
            if(data['status']==1){
              swal(data['message']);
              
              var itemId = $('#tempItemId').val();
              var type   = $('#tempType').val();
              var typeFor= $('#typeFor').val();
              
              viewDetails(itemId,type,typeFor);
              
            }else{
              swal(data['message']);
            }
        },
    });
  }
  
  
  

  var validator = $('#assign-staff-form').validate({
      ignore: [],
      rules:{
        staff : {
          required :true,
        }
      },

      messages: {
    
      },

      submitHandler: function (){
        // alert('hai');
        var formData = new FormData($("#assign-staff-form")[0]);
        $.ajax({
          url : "<?=base_url()?>website/User/assignStaff",
          type: 'POST',
          data: formData,
          async: false,
          success: function (data) {
            data =  jQuery.parseJSON(data);
            if(data['status']==1){
              swal(data['message']);
              var itemId = $('#tempItemId').val();
              var type   = $('#tempType').val();
              var typeFor= $('#typeFor').val();
              
              viewDetails(itemId,type,typeFor);
              
              // $('#assign-staff-form').hide();
              // setTimeout($('#staff').trigger('click'), 5000);
            }else{
              swal(data['message']);
            }
          },
          processData: false,
          contentType: false
        });

        return false;
      },

  });
</script>

<?php
    if($rating == 1 ){
?>
    <script>
        $(document).ready(function(){
           $('#reviewOnspot').modal('show');
        });
        
        $("#reviewYo").rateYo({
         starWidth: "60px"
        });
        $(function () {
      
        $("#reviewYo").rateYo().on("rateyo.change", function (e, data) {
            $('#rating').val(data.rating);
           });
        });

        var validator = $('#rate-form').validate({
              ignore: [],
              rules:{
                title : {
                  required :true,
                },
                description :{
                    required :true,
                }
              },
        
              messages: {
            
              },
              
              submitHandler: function (){
                debugger
                var rating = $('#rating').val();
                
                if(rating > 0 ){
                    var formData = new FormData($("#rate-form")[0]);
                    $.ajax({
                      url : "<?=base_url()?>website/User/rateJob",
                      type: 'POST',
                      data: formData,
                      async: false,
                      success: function (data) {
                        data =  jQuery.parseJSON(data);
                        if(data['status']==1){
                          swal(data['message']);
                          $('#reviewOnspot').modal('hide');
                        }else{
                          swal(data['message']);
                        }
                      },
                      processData: false,
                      contentType: false
                    });
                }else{
                    swal('Please give a rating');
                }
                return false;
              }
          });
    </script>
<?php
    }
?>


<div class="modal fade" id="reviewOnspot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="rate-form" method="post">
      <div class="modal-body">
            <div id="reviewYo" class="mt-2 mb-2 m-auto"></div>
            <input type="text" class="form-control" name="title" placeholder="Title"> <br>
      <textarea class="form-control" name="description" placeholder="Write a review" rows="3" cols="4"></textarea>
      <input type="hidden" value="0" name="rating" id="rating">
      <input type="hidden" value="<?=$result->job_request_id?>" name ="job_request_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ChangeDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Date And Timr</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="rate-form" method="post">
      <div class="modal-body">
          <div class="row">
                                    <div class="form-group col-md-6">
                                      <label>Date</label>
                                      <div class="input-group date" id="datepicker">
                                        <input class="form-control" name="call_back_date" readonly placeholder="YYYY-MM-DD"/><span style="padding: 0" class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
                                      </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label>Time</label>
                                      <div class="input-group time" id="timepicker">
                                        <input class="form-control" name="call_back_time"  placeholder="HH:MM AM/PM"/><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                      </div>
                                    </div>
                                    </div>
                                    
                                    
        <!--<input type="text" class="form-control" name="title" placeholder="Title"> <br>-->
        <!--<textarea class="form-control" name="description" placeholder="Write a review" rows="3" cols="4"></textarea>-->
        <!--<input type="hidden" value="0" name="rating" id="rating">-->
        <!--<input type="hidden" value="<//?=$result->job_request_id?>" name ="job_request_id">-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    
      $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '0d',
            endDate: new Date('<?=$currentplan["enddate"]?>'),
        });
      $("#timepicker").datetimepicker({
        format: "LT",
        icons: {
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down"
        }
      });
      
    function initMap() {
        var myLatLng = {lat: <?=$result->job_lattitude?>, lng: <?=$result->job_longitude?>};
        var lat = <?=$result->job_lattitude?>;
        var lng = <?=$result->job_longitude?>;
        // $("#pickup-lattitude").val(lat);
        // $("#pickup-longittude").val(lng);
        latlng = new google.maps.LatLng(lat, lng);
        image = '<?php echo base_url();?>frontend_assets/images/icons/map-pin.png';
        var map3 = new google.maps.Map(document.getElementById('map_new'), {
            zoom: 13,
            disableDefaultUI: true,
            center: myLatLng
        });
        
        latlng = new google.maps.LatLng(lat, lng);     
        marker = new google.maps.Marker({
            position: latlng,
            map: map3,
            draggable: true,
            animation: google.maps.Animation.DROP,
            icon: image
        });     
        
    }
</script>

    
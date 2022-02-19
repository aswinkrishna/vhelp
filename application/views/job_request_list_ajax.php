 <?php
 //print_r($result);
 //exit;
   if(isset($result) && count($result)>0)
                             {
                                 
                                 foreach($result as $rows)
                                 {
                                     
                                     $isRead = 1;//$this->M_request->isReadRequest($rows->job_request_id,$this->session->userdata('eq_user_id'));
                                     if($rows->is_home_category==0 && $rows->address_type>0)
                                     {
                                         $locationDetails = $this->M_request->getHomeLocation($this->session->userdata('eq_user_id'),$rows->address_type);
                                         $location = $locationDetails->user_adresses_location;
                                     }
                                     else
                                     {
                                         $location = $rows->job_location;
                                        
                                     }
                                     
                                       if($rows->is_home_category==0 && $rows->address_type>0)
                                       {
                                           $user_id =$rows->user_id;
                                           
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_request->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                              // $overallAddress =$alternateLocation->user_adresses_location.",".$alternateLocation->city.",".$alternateLocation->state;
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                                
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location.",".$rows->city.",".$rows->state:"";
                                       }
                                   
                            
                            // $assignedStatus = $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$rows->job_request_id); 
       $awrdedLabel  = 0;
         if($rows->job_request_status==4)
        {
            $status = "Ongoing";
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = 1;
            $completeDisable = "";
        }
        elseif($rows->job_request_status==5)
        {
            $status = $this->lang->line("completed");;
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled"; 
            // $awrdedLabel  = 1;
            $completeDisable = "disabled";
        }
        else if($rows->job_request_status==3)
        {
            $status = 'Staff assigned';
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        
        else if($rows->job_request_status==2 || $rows->job_request_status == 10 )
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        } 
        else if($rows->job_request_status==1)
        {
            $status = 'Accepted';
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        else
        {
            
        
                if($assignedStatus->assign_status<=0)
                {
                     $status     = "Pending";
                     $buttonClas = "pending";
                     $accePtDisable = "";
                     $rejecttDisable = "";
                     $completeDisable = "disabled";
                }
                if($assignedStatus->user_response_status==2 || $assignedStatus->assign_status==2)
                {
                    $status = "Cancelled";//"Cancelled";
                    $buttonClas = "reject";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
                if($assignedStatus->assign_status==1 && $assignedStatus->user_response_status<=0)
                {
                    $status     = "Accepted";
                    $buttonClas = "accept";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
                  if($assignedStatus->assign_status==3 && $assignedStatus->user_response_status<=0)
                {
                    $status     = "Staff assigned";
                    $buttonClas = "accept";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
            
        }
                            
                            ?>

 <tr class="ash-bg-light <?php  if($isRead <=0){ echo "not_readed"; }; ?>">
  
      <td class="bable_title">
          <!--<?php  if($isRead <=0){ echo "<span class='new_badge'>New</span>"; }; ?>-->
          <!--<h4>Job Category : <?php  echo $rows->service_type_name; ?></h4>-->
          <!--<span class="newJobnumber"><h4>Job number : <?php  echo $rows->job_request_display_id; if($isRead <=0){ echo ""; }; ?></h4></span> -->
         <?php
         if($awrdedLabel==1)
         {
             ?>
             <span class="newawrd">
            <img  src="<?php echo base_url();?>frontend_assets/images/content-icon/awarded.png">
            </span>
            <?php
         }
            ?>
          </span>
<span class="th_span">
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/calender.png"/></span>
        <span><b></b><?=$rows->job_request_display_id?></b></span>
        <!--<span>Validity Date : <?php  echo date('d-m-Y', strtotime($rows->job_validity_date));?></span>-->
    </aside>
    
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/locations.png"/></span>
        <span>Location : <?php  echo $location; ?></span>
    </aside>    
</span>

<span class="th_span">
    <aside>
        <!--<span><img src="<?php echo base_url();?>frontend_assets/images/icons/time.png"/></span>-->
        <!--<span>Validity Time : <?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></span>-->
    </aside>
    <br>
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/price.png"/></span>
        <?php
        if($rows->job_price_from=="" || $rows->job_price_to=="")
        {
        ?>
        <span>Price  : NA </span>
        <?php
        }
        else
        {
            ?>
            <span>Price  : AED <?php  echo $rows->grand_total; ?> </span>
            <?php
            
        }
          
        ?>
    </aside>    
</span>
      </td>
      <td class="top_padding_top" style="text-align:center;"><?php  echo $rows->job_date!=""?date("d-m-Y",strtotime($rows->job_date)):""; ?> <?=date('h:i:A',strtotime($rows->job_validity_time))?></td>
      <td class="table_button top_padding_top" style="text-align:center;"><button type="button" class="<?php echo $buttonClas;?> button-width"><?php echo $status?></button></td>
      <td class="table_button top_padding_top" style="text-align:center;">
          
         
          <button id="view<?php echo $rows->job_request_id;?>" type="button top_padding_top" class="view" data-id="<?php echo $rows->job_request_type;?>" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/eye.png"/> <span>View Job request</span></button>
           <?php
          if($rows->job_request_type==2 && 1==2)
          {
          ?>
          <button <?php echo $accePtDisable; ?> type="button top_padding_top" class="accept changeStatus" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(1);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/ticks.png"/> <span>Accept</span></button>
          <button <?php echo $rejecttDisable; ?> type="button top_padding_top" class="reject changeStatus" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"/> <span>Reject</span></button>
          <?php
          }
          if($rows->job_request_status==4 && $assignedStatus->user_response_status==1)
          {
          ?>
          <!--<button  type="button top_padding_top" class="accept changeStatus" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(5);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"/> <span>Complete</span></button>-->
           <?php
          }
          else
          {
              ?>
              <!--<button <?php echo $completeDisable; ?> type="button top_padding_top" class="accept" for="" data-id=""><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"/> <span>Complete</span></button>-->
             <?php 
          }
           ?>
      </td>
    </tr>
    <?php
                                 }
         }
         else
         {
             ?>
              <tr class="ash-bg-light">
  
              <td class="bable_title" colspan="4"  style="text-align: center;">
                  No results found
              </td>
          </tr>
             <?php
             
         }
    ?>
    <?php

if(isset($links) && $links!="")
{
    ?>
   <tr class="ash-bg-light">
  
              <td class="bable_title" colspan="4"> <?php   echo $links;;?>  </td>
          </tr>
 
    <?php
     
 }
?>
 <?php
 //print_r($result);
 //exit;
   if(isset($result) && count($result)>0)
                             {
                                 
                                 foreach($result as $rows)
                                 {
                                     
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
        $awrdedLabel  = 0;
         if($rows->job_request_status==10)
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
        }
        else if($rows->job_request_status==4)
        {
            $status = "Ongoing";
            $buttonClas = "accept";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = 1;
        }
        else if($rows->job_request_status==5)
        {
            $status = "Completed";
            $buttonClas = "accept";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = 1;
        }else if($rows->job_request_status==3){
            $status = "Staff assigned";
            $buttonClas = "accept";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = 1;
        }else if($rows->job_request_status==1){
            $status = "Accepted";
            $buttonClas = "accept";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = 1;
        }
        else if($rows->job_request_status==2)
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "";
            $rejecttDisable = "disabled";
        }
        else
        {
             $status     = "Pending";
             $buttonClas = "pending";
             $accePtDisable = "";
             $rejecttDisable = "";
        }
                            ?>

 <tr class="ash-bg-light">
  
      <td class="bable_title">
          
          <h4>Job Category : <?php  echo $rows->service_type_name; ?> </h4>
          <span class="newJobnumber"><h4>Job number : <?php  echo $rows->job_request_display_id; ?></h4></span> 
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
       
<span class="th_span">
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/calender.png"/></span>
        <span>Service Date : <?php  echo date('d-m-Y', strtotime($rows->job_validity_date)); ?></span>
    </aside>
    
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/locations.png"/></span>
        <span>Location : <?php  echo $location; ?></span>
    </aside>    
</span>

<span class="th_span">
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/time.png"/></span>
        <span>Service Time : <?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></span>
    </aside>
    
    <aside>
        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/price.png"/></span>
        <?php
        if($rows->job_price_from=="" || $rows->job_price_to=="")
        {
        ?>
        <span>Price : NA </span>
        <?php
        }
        else
        {
            ?>
            <span>Price : <?= $rows->grand_total > 0 ? $this->config->item('currency').' '.$rows->grand_total : 'NA'; ?> </span>
            <?php
            
        }
        
    
        
      $offerCount =   $this->M_request->getOffersCount($rows->job_request_id);
      
      if($rows->is_approoved==0)
      {
            $approvalStatus         = "Not approved";
            $ApprovalbuttonClas     = "reject";
            $accePtDisable  = "disabled";
            $rejecttDisable = "";
      }
      else
      {
          $approvalStatus          = "Approved";
           $ApprovalbuttonClas     = "accept";
      }
        
        ?>
    </aside>    
</span>
      </td>
      <!--<td class="top_padding_top" style="text-align:center;"><?php  echo $rows->job_date; ?></td>-->
      <!--<td class="table_button top_padding_top" style="text-align:center;"><button type="button" class="<?php echo $ApprovalbuttonClas;?> button-width"><?php echo $approvalStatus;?></button></td>-->
      <td class="table_button top_padding_top" style="text-align:center;"><button type="button" class="<?php echo $buttonClas;?> button-width"><?php echo $status;?></button></td>
      <td class="table_button top_padding_top" style="text-align:center;">
          
         
          <button id="view<?php echo $rows->job_request_id;?>" type="button top_padding_top" class="view" data-id="<?php echo $rows->job_request_type;?>" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/eye.png"/> <span>View job request</span></button>
           <?php
          if($rows->job_request_type==2)
          {
          ?>
         <!--  <button <?php echo $accePtDisable; ?> type="button top_padding_top"  class="accept viewOffers" data-foo="" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(1);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/ticks.png"/> <span>View Quotations(<?php echo $offerCount;?>)</span></button> -->
          <button <?php echo $rejecttDisable; ?> type="button top_padding_top" class="reject changeStatus" data-foo="" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"/> <span>Cancel</span></button>
          <?php
          }
          if($this->session->userdata('eq_user_type')==1 && $rows->job_request_type==1)
          {
              ?>
              <button <?php echo $accePtDisable; ?> type="button top_padding_top"  class="accept viewOffers" data-foo="" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(1);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/ticks.png"/> <span>View Quotations(<?php echo $offerCount;?>)</span></button>
               <button <?php echo $rejecttDisable; ?> type="button top_padding_top" class="reject changeStatus" data-foo="" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"/> <span>Cancel</span></button>
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
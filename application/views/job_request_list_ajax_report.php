<?php
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
                                   
                            
                            // $assignedStatus = $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$rows->job_request_id); 
       $awrdedLabel  = "";
        //  if($rows->job_request_status==4 && $assignedStatus->user_response_status==1)
        if($rows->job_request_status==4 )
        {
            $status = "Ongoing";
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "";
        }
         if($rows->job_request_status==5 )
        {
            $status = $this->lang->line("completed");;
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled"; 
            // $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "disabled";
        }else if($assignedStatus->assign_status==3){
            $status     = "Staff assigned";
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }else if($rows->job_request_status==2 || $rows->job_request_status== 10 )
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        } else if($rows->job_request_status==1 ){
                    $status     = "Accepted";
                    $buttonClas = "accept";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
        }else if($rows->job_request_status==0)
                {
                     $status     = "Pending";
                     $buttonClas = "pending";
                     $accePtDisable = "";
                     $rejecttDisable = "";
                     $completeDisable = "disabled";
                }
                

                            
                            ?>
                            
                <tr>
      <td><?php  echo $rows->job_request_display_id; ?></td>
      <td><?php  echo $rows->service_type_name; ?></td>
      <td><?php  echo $location; ?></td>
      <td><?php  echo date('d-m-Y', strtotime($rows->job_validity_date));?></td>
      <td><?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></td>
      <td><?=CURRENCY_CODE.' '.$rows->grand_total?></td>
      <td><?php echo $status;?></td>
    </tr>            

 
             <?php
             
         }
    ?>
    <?php

if(isset($links) && $links!="")
{
    ?>
   <tr class="ash-bg-light">
  
              <td class="bable_title" colspan="7"> <?php   echo $links;;?>  </td>
          </tr>
 
    <?php
     
 }
                             }
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Sl No</th>
      <th>Company Image</th>
      <th>View company profile</th>
      <th>Price marked</th>
      <th>View Quotation</th>
      <th>Responded Date</th>
      <th>Job status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
      <?php if(count($result)>0)
      {
         //print_r($result);
          $i=1;
          foreach($result as $rows)
          {
                $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/logo.png"; 
                
                                     if($rows->assign_status==1)
                                       {
                                           $status  =   "Accepted";
                                       }
                                       else if($rows->assign_status==2)
                                       {
                                           $status  =   "Cancelled";
                                       }
                                       else if($rows->assign_status==0)
                                       {
                                           $status  =   $this->lang->line("pending");
                                       }
                                         else if($rows->assign_status==3)
                                       {
                                           $status  =   $this->lang->line("price_marked")."(AED ".$rows->provider_amount.")";
                                       }
                                         else if($rows->assign_status==4)
                                       {
                                           $status  =   $this->lang->line("approved");
                                       }
                                         else if($rows->assign_status==5)
                                       {
                                           $status  =   $this->lang->line("completed");
                                       }
                                       else
                                       {
                                           $status ="";
                                       }
                                       
                                       $disableFurther =0;
                                       $jobStatus ="Pending";
                                       if($rows->job_request_status==4 && $rows->user_response_status==1)
                                       {
                                           $jobStatus  =   "Confirmed";
                                           $disableFurther =1;
                                       }
                                        else if($rows->job_request_status==5 && $rows->assign_status==5)
                                       {
                                           $jobStatus  =   $this->lang->line("completed");
                                            $disableFurther =1;
                                       }
                                       else if($rows->job_request_status==2 || $rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                           $jobStatus  =   "Cancelled";
                                           $disableFurther =1;
                                       }
                                       else
                                       {
                                           $jobStatus ="Pending";
                                       }
                                       
                                       
      ?>
    <tr>
      <td><?php echo $i.$rows->assign_status;?></td>
      <td><a href="javascript:getProviderDetails(<?php echo $rows->provider_id;?>)" title="view company profile"><span><img src="<?php echo $profileImage;?>"></span></a></td>
      <td><a href="javascript:getProviderDetails(<?php echo $rows->provider_id;?>)" title="view company profile"><?php  echo $rows->company_name; ?></a></td>
      <td><?php echo $status;?></td>
      <td><?php if($rows->document_name!=""){ ?><a target="_blank" href="<?php echo base_url().'uploads/quotations/'.$rows->document_name ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png"></i><span><?php ?></span></a><?php } ?></td>
      <td><?php  echo date("d-m-Y h i A",strtotime($rows->assigned_date)); ?></td>
      <td><?php  echo $jobStatus; ?></td>
      <td class="action">
          <?php if($rows->job_request_status!=4 && $rows->job_request_status!=2 && $rows->job_request_status!=3 && $disableFurther!=1){ 
          if($rows->assign_status==1 || $rows->assign_status==3)
                    {
          ?>
          <button type="button top_padding_top" class="accept changeStatus" data-foo="<?php echo $this->common_functions->encryptId($rows->provider_id);?>" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(1);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/ticks.png"> <span>Confirm</span></button>
          <?php
                     }
          ?>
          
          <button type="button top_padding_top" class="reject changeStatus" data-foo="<?php echo $this->common_functions->encryptId($rows->provider_id);?>" for="<?php echo $this->common_functions->encryptId($rows->job_request_id);?>" data-id="<?php echo $this->common_functions->encryptId(2);?>"><img src="<?php echo base_url();?>frontend_assets/images/icons/closes.png"> <span>Cancel</span></button>
      <?php
          }
      ?>
      </td>
    </tr>
    <?php
    $i++;
          }
      }
      else
      {
    ?>
    
    <?php
      }
    ?>
    
    
   
  </tbody>
</table>
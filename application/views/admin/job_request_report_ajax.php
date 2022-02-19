<?php

$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  9;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  

//print_r($result);
                             if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
   <!-- <caption><?php echo date("Y-m-d H:i A");?></caption>-->
                                                    <thead>
                                                        <tr>
                                                               <th>Sl no</th>
                                                               <th>Job number</th>
                                                                 <!--<th>Customer Image</th>  -->
                                                               <th>Customer name</th>   
                     <th>Service type</th>
                     <th>Service date & time</th>
                     <!--<th>Validity date & time </th>
                     <th>Price range</th>
                     <th>Location</th>                   
                     <th>Request type</th> -->
                    <th>Created date</th>
                    <th>Status</th>
                     <th>Action</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 
//print_r($result);
$p=1;
 foreach($result as $rows) 
 {


$profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png"; 
$postedDate      =  date("Y-m-d H:i:s",strtotime($rows->audit_time));    
 $assignedProvider = $this->M_admin->getAssignedServiceProvider($rows->job_request_id);
  ?>
                                                        <tr>
                     <td><?php  echo $p; ?></td>
                     <td><?php  echo $rows->job_request_display_id; ?></td>
                      <!--<td><img src="<?php echo $profileImage;?>" class="profileIcon"> </td>-->
                     <td> <?php  echo $rows->user_first_name.' '.$rows->user_last_name; ?></td>
                    <td><?php  echo $rows->service_type_name; ?></td>
                    
                    <?php
                    if($rows->is_home_category==0)
                    {
                    ?>
                    <td><?php  echo date("d-m-Y",strtotime($rows->job_date)); ?> <?php echo date('h:i A', strtotime($rows->job_time)) ?></td>
                    
                    <?php
                    }
                    else
                    {
                    ?>
                     <td>&nbsp;</td>
                    <?php
                    }
                    ?>
                    <!--<td><?php  echo date("d-m-Y",strtotime($rows->job_validity_date)); ?> <?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></td>
                     <td><?= $rows->job_total_price > 0 ? $this->config->item('currency').' '.$rows->job_total_price : 'NA'; ?></td>  -->
                     
                     <?php
                     if($rows->address_type>0)
                     {
                        $location = $this->M_admin->getHomeLocation($rows->user_id,$rows->address_type);
                        
                        $locationName = $location->user_adresses_location;
                     }
                     else
                     {
                       $locationName =  $rows->job_location;
                     }
                     ?>
                    <!--<td><?php  echo $locationName; ?></td> -->
                    <?php
                    if($rows->job_request_type==0)
                    {
                        $job_request_type =  "";
                    }
                    else if($rows->job_request_type==1)
                    {
                        $job_request_type =  "Receive quotation";
                    }
                    else if($rows->job_request_type==2)
                    {
                         $job_request_type =  "Contact service provider";
                    }
                    
                     if($rows->job_request_status==0)
                    {
                        $job_request_status =  "Pending";
                    }
                    else if($rows->job_request_status==3)
                    {
                        $job_request_status =  "Staff Accepted";
                    }
                    else if($rows->job_request_status==4)
                    {
                        $job_request_status =  "Ongoing";
                    }
                    else if($rows->job_request_status==5)
                    {
                        $job_request_status =  "Completed";
                    }
                    else if($rows->job_request_status==2)
                    {
                        $job_request_status =  "Cancelled";
                    }
                    else if($rows->job_request_status==1)
                    {
                        $job_request_status =  "Accepted";
                    }
                    else if($rows->job_request_status== 10 ){
                        $job_request_status = "Cancelled";
                    }else if($rows->job_request_status== 3 ){
                        $job_request_status = "Staff Assigned";
                    }
                    else
                    {
                        $job_request_status =  "Pending";
                    }
                    ?>
                    <!--<td><?php  echo $job_request_type; ?></td>                  -->
                    <td><?php  echo date("d-m-Y H:i:A",strtotime($rows->job_request_created_time)); ?></td>
                      <td><?php  echo $job_request_status; ?></td> 
                       <td> 
                                                             <?php
                                                        if($permission->perm_edit==1 && 1==2)
                                                        {
                                                        ?> 
			<a class="edit" href="<?php echo base_url().'admin/update_request/'.$this->common_functions->encryptId($rows->job_request_id) ?> ">
                                                            <i class="fa fa-pencil" i></i>
                                                        </a>
                                                    &nbsp; &nbsp; 
                                                        <?php
                                                        }
                                                       ?>
                                                       <?php
                                                        /*if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                        <a class="remove" href="#"  data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>"></i>
                                                        </a>
                                                        <?php
                                                        }*/
                                                        if($permission->perm_view==1)
                                                        {
                                                        ?>
                                                     &nbsp; &nbsp; 
                                                     <a class="detailView" href="#"  data-toggle="modal" data-target="#myModal" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>">
                                                            <i class="fa fa-eye" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>"></i>
                                                        </a>
                                                      &nbsp; &nbsp;  
                                                    <!--<a class="viewersList" href="#"  data-toggle="modal" data-target="#myModal2" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>">
                                                            <i class="fa fa-users" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>"></i>
                                                        </a>   -->
                                                        
                                                     <?php
                                                        }
                                                        if($permission->perm_edit==1)
                                                        {
                                                        
                                                         if($rows->is_approoved==-1)
                                                         {
                                                           ?>
                                                            <a style="background-color: #d5c5c5;border-color: #c0b1b1;" class="btn btn-primary" href="javascript:void(0)" title="Reject">Rejected</a>
                                                           <?php
                                                             
                                                         }else if($rows->job_request_status==10){
                                                             
                                                        ?>
                                                            <a style="background-color: #d5c5c5;border-color: #c0b1b1;" class="btn btn-primary" href="javascript:void(0)" title="Cancelled">Cancelled</a>
                                                        <?php
                                                         }
                                                         else if($rows->is_approoved==0 && $rows->job_request_status!=10)
                                                         {
                                                              $labelApprove =   $rows->is_approoved==1?"Reject":"Approve";
                                                              $nextStatus   =   $rows->is_approoved==1?"0":"1";
                                                              
                                                              $labelApprove =   $rows->is_approoved==1?"Reject":"Approve";
                                                              $nextStatus   =   $rows->is_approoved==1?"0":"1";
                                                        ?>
                                                         <a  class="btn btn-primary" id="app<?php echo $rows->job_request_id;?>" href="javascript:approveJobRequest('app<?php echo $rows->job_request_id;?>','1','<?php echo $this->common_functions->encryptId($rows->job_request_id )?>')" title="Approve">Approve</a>
                                                          &nbsp;
                                                         <a class="btn btn-primary" id="ref<?php echo $rows->job_request_id;?>" href="javascript:approveJobRequest('ref<?php echo $rows->job_request_id;?>','-1','<?php echo $this->common_functions->encryptId($rows->job_request_id )?>')" title="Reject">Reject</a>
                                                         <div class="spinnerClass" ></div> 
                                                          <?php
                                                         }
                                                         else if($rows->is_approoved==1)
                                                         {
                                                             ?>
                                                             <?php
                                                                if(count($assignedProvider) > 0) {
                                                            ?>
                                                            <a  class="btn btn-primary" href="javascript:void(0)">Assigned To Provider</a>
                                                        <?php } else {

                                                            ?>
                                                             <a  class="btn btn-primary" id="app<?php echo $rows->job_request_id;?>" href="javascript:assignProvider('<?php echo $this->common_functions->encryptId($rows->job_request_id )?>', '<?php echo $rows->job_request_id;?>')" title="Approve">Assign Provider</a>
                                                             <?php
                                                                }
                                                            ?>
                                                       <!--  <a class="btn btn-primary" id="ref<?php echo $rows->job_request_id;?>" href="javascript:approveJobRequest('ref<?php echo $rows->job_request_id;?>','-1','<?php echo $this->common_functions->encryptId($rows->job_request_id )?>')" title="Reject">Reject</a> -->
                                                        <div class="spinnerClass"></div>    
                                                            <?php
                                                             
                                                         }
                                                        }
                                                     ?>
                                                        
                                                        
                                                    </td>                                     
                                                        </tr>
                                                        <?php
                                                        $p++;
                                    }
                            ?>
                                                    </tbody>
                                                </table>
                                                
                                                <?php
                                                echo $links;
                                                ?>



  <?php

}
else
{


          echo  "No Results Found";

}


                    ?>
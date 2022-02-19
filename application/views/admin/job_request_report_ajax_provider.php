<?php

$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  6;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  


                             if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                               <th>Sl no</th>
                                                                <th>ID</th>
                                                                <th>Customer Image</th>  
                                                                 <th>Customer name</th>   
                     <th>Service type</th>
                     <th>Service date & time</th>
                     <th>Validity date & time </th>
                     <th>Price range</th>
                     <th>Location</th>                   
<!--                     <th>Request type</th> -->
                    <th>Status</th>
                     <th>Details</th>
                    <th>Marked price</th>
                    
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 

$p=1;
 foreach($result as $rows) 
 {
     
    $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";  
     
 if($posts['provider_id']>0)
 {
$response =     $this->M_admin->getProviderResponseStatus($rows->job_request_id,$posts['provider_id'])     ;  
 }
 else
 {
     $response  = array();
 }
//print_r($response);
$postedDate = date("Y-m-d H:i:s",strtotime($rows->job_request_id));    

  ?>
                                                        <tr>
                     <td><?php  echo $p; ?></td>
                     <td><?php  echo $rows->job_request_display_id; ?></td>
                      <td><img src="<?php echo $profileImage;?>" class="profileIcon"> </td>
                     <td>  <?php  echo $rows->user_first_name.' '.$rows->user_last_name; ?></td>
                    <td><?php  echo $rows->service_type_name; ?></td>
                    <td><?php  echo $rows->job_date; ?> <?php echo date('h:i A', strtotime($rows->job_time)) ?></td>
                    <td><?php  echo $rows->job_validity_date; ?> <?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></td>
                     <td>AED <?php  echo $rows->job_price_from; ?>-<?php  echo $rows->job_price_to; ?></td>  
                    <td><?php  echo $rows->job_location; ?></td> 
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
                    else if($rows->job_request_type==1)
                    {
                        $job_request_status =  "Confirmed";
                    }
                    else if($rows->job_request_type==2)
                    {
                        $job_request_status =  "Rejected";
                    }
                    
                      if($response->user_response_status==0)
                    {
                        $user_response_status =  "Pending";
                    }
                    else if($response->user_response_status==1)
                    {
                        $user_response_status =  "Confirmed";
                    }
                    else if($response->user_response_status==2 || $response->assign_status==2)
                    {
                        $user_response_status =  "Cancelled";
                    }
                    else if($response->assign_status==5)
                    {
                        $user_response_status =  "Completed";
                    }
                    ?>
<!--                    <td><?php  echo $job_request_type; ?></td>                  -->
                    <td><?php  echo $user_response_status; ?></td>
                    <td> <a class="detailView" href="#"  data-toggle="modal" data-target="#myModal" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>">
                                                            <i class="fa fa-eye" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>"></i>
                                                        </a></td>
                      <td>  
                          <?php
                          if($rows->is_approoved!=1)
                          {
                            if($rows->is_approoved==0)
                            {
                                echo "Pending approval";
                            }
                            else
                            {
                                echo "Request Refused";
                            }
                          }
                        else if($response->provider_amount<=0 && $response->user_response_status!=2 && $response->assign_status!=2 && $rows->job_request_status!=5 && $rows->job_request_status!=4 && $rows->job_request_status!=2 && $rows->is_approoved==1)
                          {
                              ?>
                           <a href="javascript:void(0)" class="btn btn-primary btn-sm rounded-s radius markPrice" for="<?php echo $this->common_functions->encryptId($rows->job_request_id )?>" data-id="<?php echo $posts['provider_id'];?>"> Mark price</a>
                         
                          <?php
                              
                          }
                          else if($response->provider_amount>0)
                          {
                              ?>
                               <?php  echo "AED ".$response->provider_amount;?>
                           <?php
                              
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
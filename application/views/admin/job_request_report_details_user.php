<h4><?php echo $result_job->job_request_type==2?"Job request details":"Quotation details" ?></h4>
<?php
//print_r($result_job);
if(count($result_job)>0)
{
    if($result_job->job_request_status==0)
    {
        $mainStatus = "Pending";
    }
    else if($result_job->job_request_status==1)
    {
         $mainStatus = "Confirmed";
    }
     else if($result_job->job_request_status==2)
    {
         $mainStyle="style='color:red;'";
         $mainStatus = "Cancelled";
    }
       else if($result_job->job_request_status==3)
    {
         $mainStatus = "Price marked";
    }
      if($result_job->job_request_status==4 )
    {
          $mainStyle="style='color:green;'";
         $mainStatus = "Confirmed";
    }
     if($result_job->job_request_status==5 )
    {
          $mainStyle="style='color:green;'";
         $mainStatus = "Completed";
    }
    ?>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
    <?php
    ?>
    <tr><th colspan="2" >Job number:<?php echo $result_job->job_request_display_id ?></th><th><span <?php echo $mainStyle; ?>>Status : <?php echo $mainStatus; ?></span></th></tr>
     <tr><td>Customer name  : <?php echo $result_job->user_first_name?> </td><td>Service  type  : <?php echo $result_job->service_type_name?> </td> <td><?php if($result_job->job_date!=""){ ?>Service date & time  : <?php  echo date("d-m-Y",strtotime($result_job->job_date)); ?> <?php echo date('h:i A', strtotime($result_job->job_time)) ;} ?></td></tr>
<tr><td>Validity  :<?php  echo date("d-m-Y",strtotime($result_job->job_validity_date)); ?> <?php echo date('h:i A', strtotime($result_job->job_validity_time)) ?></td><td>Price range  : AED <?php  echo $result_job->job_price_from; ?>-<?php  echo $result_job->job_price_to; ?> </td> <td>Location  : <?php  echo $result_job->job_location; ?> </td></tr>
</table>
   <?php 
}
else
{
    echo "No results found";
}
if(count($result_questions)<=0 && count($result_assigned_providers)<=0)
{
    echo "No results found";
}
else
{
    ?>
<h4>Customer Needs</h4>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr><th>Sl no</th><th>Questions </th><th>Answers</th></tr>
                                                       </thead>
                                                    <tbody>
                                                        <?php 
                                                        $i=1;
                                                        foreach ($result_questions as $rows)
                                                        {
                                                            $data = $rows->answer_option;
$data=str_replace('{',"",$data);
$data=str_replace('}',"",$data);
$data=str_replace('"',"",$data);
                                                            ?>
                                                        
                                                         <tr><td><?php echo $i;?></td><td><?php echo $rows->question;?> </td><td><?php echo $data;?></td></tr>  
                                                        <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <?php if(count($files)>0){ ?>
                         
                             
                             <?php  foreach($files as $rows)
                                 {
                                     //$rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:"";
                                     ?>
                                      <tr><td colspan="3"><a target="_blank" href="<?php echo $rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png" style="height:30px;width:30px" /></i><span><?php echo $rows->documents_name;?></span></a></td></tr>
                                  
                                  <?php   
                                 }
                                 ?>
                            
                         
                         <?php } ?>
                                                    <tr><td colspan="2">Remarks</td><td><?php echo $result_job->description;?></td></tr>
</table>
<h4><?php echo $result_job->job_request_type==2?"Received quotations":"Received quotations " ?></h4>
<?php
//print_r($result_assigned_providers);
if(count($result_assigned_providers) >0)
{
    ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                     <tr><th>Sl no</th><th>Company Image </th><th>View Company profile </th><th>Document</th><th><?php echo "Marked price" ?></th><th>Responded date</th><th>Action/status</th></tr>
                                                     </thead>
                                                    <tbody>
<?php
$i=1;
      foreach($result_assigned_providers as $rows2)
      {
          // print_r($result_assigned_providers);
          
          $profile_document      =  $rows2->profile_document!=""?base_url()."uploads/user/".$rows2->profile_document:"#";
           
          if($rows2->assign_status==0) 
          {
              $assign_status   =  "Pending" ;
          }
          else if($rows2->assign_status==1)
          {
              $assign_status   =  "Confirmed" ;
          }
           else if($rows2->assign_status==5)
          {
              $assign_status   =  "Completed" ;
          }
          else if($rows2->assign_status==2 || $rows2->user_response_status==2)
          {
              $assign_status   =  "Cancelled" ;
          }
          else if($rows2->assign_status==3)
          {
              $assign_status   =  "Price marked" ;
          }
          
           $profileImage    =   $rows2->user_image!=""?base_url()."uploads/user/".$rows2->user_image:base_url()."images/logo.png";   
    ?>

<tr><td><?php echo $i;?></td><td><img src="<?php echo $profileImage;?>" class="profileIcon"><td><a title="view profile" target="_blank" href="<?php echo $profile_document; ?>"><?php echo $rows2->company_name;?></a> </td>
<td>
    <?php if($rows2->provider_doc!=""){ ?>
    <a target="_blank" href="<?php echo $rows2->provider_doc!=""?base_url()."uploads/quotations/".$rows2->provider_doc:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png"  style="height:30px;width:30px"/></i><span><?php echo $rows2->provider_doc;?></span></a>
    <?php 
    }
    
    ?>
    </td>
<td><?php echo  $rows2->provider_amount>0?"AED ".$rows2->provider_amount:"" ?></td><td><?php echo date("d-m-Y h:i A",strtotime($rows2->assigned_date));?></td>
<?php
if(($rows2->assign_status==1 || $rows2->assign_status==3 ) && $result_job->job_request_status!=4 && $result_job->job_request_status!=2 && $rows2->user_response_status!=2 && $result_job->job_request_status!=5)
{
    ?>
    <td> <a href="javascript:void(0)" class="btn btn-primary btn-sm rounded-s radius btnApprove" for="<?php  echo $result_job->job_request_id;?>" data-id="<?php  echo $rows2->user_id;?>">Confirm</a></td>
   <?php 
}
else
{
   // echo $rows2->assign_status;
    if($rows2->assign_status==0)
    {
        $st = "Pending";
    }
    else if($rows2->assign_status==1)
    {
         $st = "Confirmed";
    }
     else if($rows2->assign_status==2)
    {
         $style="style='background:red;'";
         $st = "Cancelled";
    }
       else if($rows2->assign_status==3)
    {
         $st = "Price marked";
    }
      if(($rows2->user_response_status==1 || $rows2->user_response_status==4) && $result_job->job_request_status==4)
    {
          $style="style='background:green;'";
         $st = "Confirmed";
    }
      if($rows2->user_response_status==1 && $result_job->job_request_status==5)
    {
          $style="style='background:green;'";
         $st = "Completed";
    }
      if($rows2->user_response_status==2 || $rows2->assign_status==2)
    {
         $style="style='background:red;'";
         $st = "Cancelled";
    }
    ?>
    <td> <a href="javascript:void(0)" class="btn btn-primary btn-sm rounded-s radius "  <?php echo $style;?>><?php echo $st;?></a></td>
    <?php
}
?>
</tr> 
<?php
$i++;
      }
    ?>
                </tbody>
</table>
                                                        <?php
}
else
{
    echo "No results found" ;
}
}

?>
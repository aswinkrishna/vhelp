<!--<h4><?php echo $result_job->job_request_type==2?"Job request details":"Quotation details" ?></h4>-->
<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  9;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId); 

$service_request_mode_labels 	= $this->config->item('service_request_mode_labels','app');

//print_r($result_job);
if(count($result_job)>0)
{
	if($result_job->job_request_status==0)
	{
		$mainStatus = "Pending";
	}
	else if($result_job->job_request_status==1)
	{
		$mainStatus = "Accepted";
	}
	else if($result_job->job_request_status==2)
	{
		$mainStyle="style='color:red;'";
		$mainStatus = "Cancelled";
	}
	else if($result_job->job_request_status==3)
	{
		$mainStatus = "Staff Assigned";
	}
	if($result_job->job_request_status==4 )
	{
		$mainStyle = "style='color:green;'";
		$mainStatus = "Ongoing";
	}
	if($result_job->job_request_status==5 )
	{
		$mainStyle = "style='color:green;'";
		$mainStatus = "Completed";
	}
	if($result_job->job_request_status==10 )
	{
		$mainStyle = "style='color:green;'";
		$mainStatus = "Cancelled";
	}
	if($result_job->is_approoved==-1 )
	{
		$mainStyle = "style='color:red;'";
		$mainStatus = "Refused";
	}
	if($result_job->is_approoved==0 )
	{
		$mainStyle = "style='color:red;'";
		$mainStatus = "Pending Approval";
	}
	?>
	<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
		<?php
		?>
		
		<tr>
			<th colspan="2" >Job number:<?php echo $result_job->job_request_display_id ?></th>
			<th><span <?php echo $mainStyle; ?>>Status : <?php echo $mainStatus; ?></span></th>
		</tr>
		<tr>
			<td colspan="3">Service Request Mode : <?=$service_request_mode_labels[$result_job->request_mode]?> </td>
		</tr>
		<tr>
			<td>Customer name  : <?php echo $result_job->user_first_name?> </td>
			<td>Service  type  : <?php echo $result_job->service_type_name?> </td> 
			<td>Service date & time  :<?php if($result_job->job_date!=""){ ?> <?php  echo date("d-m-Y",strtotime($result_job->job_date)); ?> <?php echo date('h:i A', strtotime($result_job->job_time)); } ?></td>
		</tr>
		<tr>
			<td>Price  : AED <?=$result_job->grand_total?> </td> <td colspan="2">Location  : <?php  echo $result_job->job_location; ?> </td>
		</tr>
		<tr>
			<td colspan="3">Area  : <?php  echo $result_job->area; ?> </td>
		</tr>
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
			<tr><th style="width: 10%">Sl no</th><th style="width: 60%">Questions </th><th style="width: 20%">Answers</th></tr>
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

			<tr><td colspan="2">Task / Project Details</td><td><?php echo $result_job->description;?></td></tr>
			<?php $file='uploads/quotations/'.$result_job->document;
				if(is_file($file) && file_exists($file)): ?>
			<tr><td colspan="2">Optional Document</td><td><a download href="<?php echo base_url().$file ?>">Download</a></td></tr>
			<?php endif; ?>
			<?php 
			$file='uploads/job/'.$result_job->signature;
			if(is_file($file) && file_exists($file)):
			?>
			<tr>
				<td colspan="2">Signature</td>
				<td><img src="<?php echo base_url().$file; ?>" style="width:75px;height:75px;" /><br>
				<a download href="<?php echo base_url().$file ?>">Download</a>
				</td>
			</tr>
			<?php endif; ?>
			<?php 
			$file='uploads/job/'.$result_job->image;
			if(is_file($file) && file_exists($file)):
			?>
			<tr>
				<td colspan="2">Staff Document</td>
				<td><img src="<?php echo base_url().$file; ?>" style="width:75px;height:75px;" /><br>
				<a download href="<?php echo base_url().$file ?>">Download</a>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<h4><?php echo $result_job->job_request_type==2?"Provider details":"Provider details " ?></h4>
	<?php

	if(count($result_assigned_providers) >0)
	{

		
		?>

		<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Sl no</th>
					<th>Company Image </th>
					<th>Provider company name </th>
					<!-- <th>Download Quotation</th> -->
					<th>Price</th>
					<!--<th>Responded date</th>-->
					<th>Action/status</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				// print_r($result_assigned_providers);
				foreach($result_assigned_providers as $rows2)
				{
					if($rows2->assign_status==0 ) 
					{
						$assign_status   =  "Pending" ;
					}
					else if($rows2->assign_status==1)
					{
						$assign_status   =  "Accepted" ;
					}
					else if($rows2->assign_status==5)
					{
						$assign_status   =  "Completed" ;
					}
					else if($rows2->assign_status==2)
					{
						$assign_status   =  "Cancelled" ;
					}
					else if($rows2->assign_status==3)
					{
						$assign_status   =  "Staff Assigned" ;
					}
					else if($rows2->assign_status==4)
					{
						$assign_status   =  "Ongoing" ;
					}else if($rows2->assign_status==10)
					{
						$assign_status   =  "Cancelled" ;
					}
					$profileImage    =   $rows2->user_image!=""?base_url()."uploads/user/".$rows2->user_image:base_url()."images/logo.png";   
					?>

					<tr><td><?php echo $i;?></td><td><img src="<?php echo $profileImage;?>" class="profileIcon"></td><td><?php echo $rows2->company_name;?></td>
					
<!-- 					<td>
							<?php if($rows2->provider_doc!=""){ ?>
								<a target="_blank" href="<?php echo $rows2->provider_doc!=""?base_url()."uploads/quotations/".$rows2->provider_doc:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/pdf.png"  style="height:30px;width:30px"/></i><span><?php echo $rows2->provider_doc;?></span></a>
								<?php 
							}

							?>
					</td> -->

						<td>
							AED <?=$rows2->grand_total?>
						</td>
						
						<td>
							<?php
								if($rows2->assign_status==0){
									$st = "Pending";
								}else if($rows2->assign_status == 1 ){
									$st = "Accepted";
									$style="style='background:green;'";
								}else if($rows->assign_status == 2 ){
									$st = "Rejected";
									$style="style='background:red;'";
								}

								if($rows2->assign_status == 0 ){
							?>
							    <a href="javascript:void(0)" class="btn btn-primary btn-sm rounded-s radius assignJobToProvider " id="<?=$rows2->assign_job_provider_id?>" >Assign Provider</a>
								
							<?php
								}
								else if($rows2->assign_status == 1)
								{
								?>
    							    <a href="javascript:void(0)" class="btn btn-primary btn-sm rounded-s radius assignJobToStaff " id="<?=$rows2->assign_job_provider_id?>" >Assign Staff</a>
    							<?php
								}
								else{
							    ?>
								<button class="btn btn-primary btn-sm rounded-s radius "  <?php echo $style;?> disabled><?php echo $assign_status;?></button>
							<?php
								}
							?>
						</td>
					</tr> 
					<tr>

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
		<h4>Job Days</h4>
		<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
			<thead>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
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
                </tr>   
                <?php
                $i++;
            }
            ?>  
            </tbody>
		</table>


		<?php
			if($result_job->job_request_status >= 3 &&  $result_job->job_request_status <= 5 ){	

				$staff_details = $this->M_admin->getStaffDetailsById($result_job->job_request_id);

		?>
<h4>Staff Details</h4>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
		<?php

			$profileImage    	=   "uploads/user/".$staff_details->user_image; 
			
			if(file_exists($profileImage) && is_file($profileImage))
				$profileImage 	= base_url().$profileImage;
			else
				$profileImage 	= base_url()."frontend_assets/images/avatar.jpg";
		?>
		<tr>
			<th rowspan=2>
				<img src="<?=$profileImage?>" style="height: 80px;">
			</th>
			<th >Staff Name:<?php echo $staff_details->user_first_name .' '.$staff_details->user_last_name ?></th>
			<th><span>Contact Number : <?php echo $staff_details->user_dial_code . ' '.$staff_details->user_phone; ?></span></th>
		</tr>
		<tr>
		    
			<td>Email  : <?php echo $staff_details->user_email?> </td>
			<td>Country  : <?php echo $staff_details->country_name?> </td> 
			<!--<td>city  :<?php echo $staff_details->city_name?></td>-->
		</tr>
	
</table>

<?php
	}
?>
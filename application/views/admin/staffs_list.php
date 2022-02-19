<main class="app-content">
	<div class="app-title">
		<div>
			<h1><i class="fa fa-th-list"></i> Staffs List</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-8 col-md-offset-12">
				<?php /*if($permission->perm_add==1) {*/ ?>
					<a href="<?php echo base_url();?>admin/add_edit_staff/<?php echo $provider_id?>"> <button class="btn btn-primary" type="button">Add Staff</button></a>
					<?php /*}*/ ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">
						<table id="sampleTable" class="table table-striped table-bordered table-hover">
							<thead>
								<tr >
									<th>ID</th>
									<th>Staff Name</th>
									<th>Email</th>       
									<th>Phone Number</th>
									<th>Approve</th>
									<th>Published Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(!empty($staffs_list)){
									$sid = 0;
									foreach ($staffs_list as $rows)
									{
										if (strpos($rows->user_dial_code, '+') === false)
											$rows->user_dial_code = '+'.$rows->user_dial_code;

										$sid++;
										$postedDate = get_date_in_timezone("Asia/Dubai", $rows->user_created_time, "F j, Y, g:i a");
										?>
										<tr class="">
											<td><?php echo $sid; ?></td>
											<td>
												<?php echo $rows->user_first_name.' '.$rows->user_last_name; ?>
											</td>
											<td>
												<?php echo $rows->user_email ?> </h4>
											</td>
											<td>
												<?php echo $rows->user_dial_code.' '.$rows->user_phone; ?></div>
											</td>
											<td>
												<label class="switch">
													<?php
													/*if($permission->perm_edit!=1 && isset($permission->perm_edit))
													{
														$disabled= "disabled";
													}
													else
													{
														$disabled= "";
													}*/
													?>
													<input type="checkbox" <?php echo ($rows->user_status==1?"checked":"") ;?> for="<?php echo $rows->user_id ?>" class="swichCheck" <?php //echo $disabled;?>>
													<span class="slider round"></span>
												</label>
											</td>
											<td>
												<div><?php echo $postedDate; ?></div>
											</td>
											<td>
												<a class="detailView" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" href="javascript:void(0)" > <i class="fa fa-eye" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;
												<a class="edit" href="<?php echo base_url();?>admin/add_edit_staff/<?php echo $provider_id?>/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;
												<a class="remove removeThis" for="<?php echo $this->common_functions->encryptId($rows->user_id);?>" href="javascript:void(0)" > <i class="fa fa-trash-o"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;
											</td>
										</tr>
									<?php }} else { ?> 
										<tr><td colspan="6" style="text-align: center;">No Staff(s) found.</td> </tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</main>

		<!-- Modal -->
		<div id="myModalDetails" class="modal fade" role="dialog">
			<div class="modal-dialog" style="    max-width: 996px">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">

						<h4 class="modal-title">Details</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body" id="detailDiv">
						<p>Staff details not found.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal -->

		<script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
			$('#sampleTable').DataTable({
				"order": [],
			});

			$(document).delegate(".removeThis","click",function(e)
			{
				var deleteId     = $(this).attr("for");
				deleteThis(deleteId);
			});

			function deleteThis(deleteId)
			{
				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this data!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {

						csrf_value  =   getCookie('csrf_cookie_name');        

						$.ajax({
							url: '<?php echo base_url();?>admin/C_admin/deleteStaff',
							type: 'POST',
							data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
							success: function (data) 
							{
								if(data==1)
								{
									swal("Staff Deleted!");
									setTimeout(()=>{
										location.reload();
									}, 3000);
									
								}
								else if(data==2)
								{
									swal("Error","This staff having job request","error");
								}
								else
									swal("Cannot delete user!");
							}
						});
					}
				});
			}

			$(document).delegate(".swichCheck","change",function(e){

				id  = $(this).attr("for") ;

				if($(this).is(':checked')==1)
					status   =  1;
				else
					status   =  0;

				csrf_value  =   getCookie('csrf_cookie_name');    

				$.ajax({
					url:  '<?php echo base_url();?>admin/C_admin/approveUser',
					type: 'POST',
					data: {id:id,status:status,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
					success: function (data) 
					{
						location.reload();
					}
				});    
			});

			$(document).delegate(".detailView","click",function(e){
				id  = $(this).attr("for") ;
				$("#detailDiv").html("");
				csrf_value  =   getCookie('csrf_cookie_name');    
				$.ajax({
					url:  '<?php echo base_url();?>admin/C_admin/staffDetails',
					type: 'POST',
					data: {id:id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
					success: function (data) 
					{
						$("#myModalDetails").modal("show");
						$("#detailDiv").html(data);

					}
				});  
			});
		</script>
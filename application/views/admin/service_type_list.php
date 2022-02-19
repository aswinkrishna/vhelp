<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Service type</h1>
<!--          <p>Table to display analytical data effectively</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>-->
      </div>
    <div class="row">
          <div class="col-md-12">
                <div class="col-md-8 col-md-offset-12">
                                                <?php
                                                          if($permission->perm_add==1)
                                                        {
                                                       ?>
                    <a href="<?php echo base_url();?>admin/add_edit_service_type"> <button class="btn btn-primary" type="button">Add service type</button></a>
                                                 <?php
                                                        }
                                                       ?>
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
              <table class="table table-striped table-bordered table-hover" id="sampleTable">
                <thead>
                    <?php
                    if(count($service_type_list)>0)
                    {
                    ?>
                  <tr>
                     <th>Sl no</th>
                     <th>Service type name</th>
                     <th>Service type name arabic</th>
                     <th>Icon</th>
                     <th>Banner</th>
                     <th>Thumb</th>
                    <th>Parent </th>                                      
                    <th>Created date</th>
                    <th>Status</th>
<!--                    <th>Approve</th>-->
                     <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $p=1;
                    foreach($service_type_list as $rows)
                    {
                        $rows->service_type_created_date = get_date_in_timezone('Asia/Dubai', $rows->service_type_created_date, 'F j, Y, g:i a');
                    ?>
                  <tr>
                     <td><?php  echo $p; ?></td>
                    <td><?php  echo $rows->englishname; ?></td>
                    <td><?php  echo $rows->arbicname; ?></td>
                     <td>  <img src="<?php echo base_url().'uploads/service_type/'.$rows->service_type_icon ;?>" class="previewImage" id="imagePreview"></td>
                      <td>  <img src="<?php echo base_url().'uploads/service_type/'.$rows->service_type_banner_image ;?>" class="previewImage" id="imagePreview"></td>
                      <td>  <img src="<?php echo base_url().'uploads/service_type/'.$rows->service_type_thumbnail ;?>" class="previewImage" id="imagePreview"></td>
                    <td><?php  echo $rows->parentname!=""?$rows->parentname:"-"; ?></td>                 
                    <td><?php  echo $rows->service_type_created_date; ?></td>                  
                    <td><?php  echo $rows->service_type_status==1?"Active":"Inactive"; ?></td>
                 <!--   <td><label class="switch">
                                                                 <?php
                                                        if($permission->perm_edit!=1 && isset($permission->perm_edit))
                                                        {
                                                            $disabled= "disabled";
                                                        }
                                                         else
                                                        {
                                                             $disabled= "";
                                                        }
                                                        ?>
                                                        
  <input type="checkbox" <?php echo ($rows->country_status==1?"checked":"") ;?> for="<?php echo $rows->country_id ?>" class="swichCheck" <?php echo $disabled;?>>
  <span class="slider round"></span>
</label></td>-->
                    <td>
                                                    <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?>
                                                 <a class="edit" href="<?php echo base_url();?>admin/add_edit_service_type/<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;    
                                                <?php
                                                        }
                                                       ?>
                                                 <?php
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                 <a class="remove" href="javascript:void(0)" > <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;  
                                                  <?php
                                                        }
                                                       ?>
                                                   <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?>
                                                 <a  href="<?php echo base_url();?>admin/question_list/<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>"  title="View questions">   <i class="fa fa-eye" id="detailView" for="476"></i> </a>&nbsp; &nbsp;&nbsp; &nbsp;  
                                                  <?php
                                                        }
                                                       ?>  
                                                        <?php
                                                        if($permission->perm_add==1)
                                                        {
                                                        ?>
                                                 <a class="btn btn-primary" href="<?php echo base_url();?>admin/add_edit_questions/<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>" title="add/edit questions">Add Questions</a>
                                                     &nbsp;
                                                     <?php /*<a href="<?php echo base_url();?>admin/add_faq/<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">Add FAQ</a> */ ?>
                                                      <?php
                                                        }
                                                       ?>  
<!--                                                 <i class="fa fa-eye" id="detailView" for="476"></i>                                                 -->
                    </td>
                  </tr>
              
                      <?php
                      $p++;
                    }
                    }
                    else
                    {
                      ?>
                      
                      <?php
                    }
                      ?>
                <input type="hidden" id="txtDelete" value="0">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
 <script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable({
    "order": [],
    // Your other options here...
});
</script>
<script>
    $(document).delegate(".removeThis","click",function(e)
    {
       // $("#txtDelete").val("");
        var deleteId     = $(this).attr("for");
       // $("#txtDelete").val(deleteId);
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
            url:  '<?php echo base_url();?>admin/C_admin/deleteServiceType',
            type: 'POST',
            data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			     {

              if(data==1)
              {
                 
                    swal("Well done!", "Deleted Successfully!", "success");
                    location.reload(); 
              }
              else if(data==2)
              {
                swal("Unable to Delete!", "This service contains child service(s)", "error");
              }
              else if(data==3)
              {
                swal("Unable to Delete!", "This service is booked by the user(s)", "error");
              }
              else
              {
                swal("Sorry!", "Failed to delete! Try again later", "error");
              }
            }
        });    
   
    
    
  } else {
    
  }
});
    }
     $(document).delegate(".swichCheck","change",function(e)
    {
        id  = $(this).attr("for") ;
		if($(this).is(':checked')==1)
		{
			status   =  1;
		}
		else
		{
			 status   =  0;
			
			
			}
			csrf_value  =   getCookie('csrf_cookie_name');    
			 $.ajax({
            url:  '<?php echo base_url();?>admin/C_admin/approveUser',
            type: 'POST',
            data: {id:id,status:status,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			   

			// alert(data);

			// console.log(data);   

         	  

			   
            }
        });    
		
	});
       
    </script>

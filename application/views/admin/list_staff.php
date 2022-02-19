<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  2;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?> 
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>&nbsp;Admin users list</h1>
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
                                        <a href="<?php echo base_url(); ?>admin/add_stafs" class="btn btn-primary btn-sm rounded-s radius"><span>+</span> Add New </a>
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
                    if(count($results)>0)
                    {
                    ?>
                  <tr>
                     <th class="border-pann">Id</th>
                                                            <th class="border-pann">Name</th>
                                                            <th class="border-pann">Email id</th>
                                                            <th class="border-pann">User name</th>
															<th class="border-pann">Designation</th>
                                                            <th class="border-pann">Created date</th>
                                                             <th class="border-pann">Status</th>
                                                            <th class="border-pann">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
//print_r($productList);

 foreach($results as $rows) 
 {



$postedDate = date("Y-m-d H:i:s",strtotime($rows->admin_user_created_date));    

  ?>
                                                        <tr>
                                                            <td><?php echo $rows->admin_user_id ?> </td>
                                                            <td><?php echo $rows->admin_first_name ?> <?php echo $rows->admin_last_name ?></td>
                                                            <td><?php echo $rows->admin_user_email ?> </td>
                                                            <td><?php echo $rows->admin_user_name ?> </td>
															<td><?php echo $rows->designation ?> </td>
                                                            <td><?php echo $postedDate ?></td>
                                                            
                                                            <td> 
                                                            <?php
                                                        if($permission->perm_edit!=1 ||  $rows->admin_user_id==1)
                                                        {
                                                            $disabled= "disabled";
                                                        }
                                                        else
                                                        {
                                                             $disabled= "";
                                                        }
                                                        ?>
															<label class="switch">
  <input type="checkbox" <?php echo ($rows->admin_user_status==1?"checked":"") ;?> for="<?php echo $rows->admin_user_id ?>" class="swichCheck" <?php echo $disabled;?>>
  <span class="slider round"></span>
</label>
															
															</td>
                                                            
                                                            <td>
                                                                <?php
                                                                if($permission->perm_edit==1)
                                                                {
                                                                ?>
                                                                <a class="edit" title="Edit" href="<?php echo base_url().'admin/add_stafs/'.$this->common_functions->encryptId($rows->admin_user_id); ?> ">
                                                                <i class="fa fa-pencil" i></i></a>
                                                            	&nbsp; &nbsp; 
                                                            	<?php
                                                            	if($this->session->userdata('admin_designation')==1 && 1==2)
                                                            	{
                                                            	?>
                                                            	
                                                            	
                                                            	<a  title="Change password" href="javascript:void(0)" class="changePassword" for="<?php echo $this->common_functions->encryptId($rows->admin_user_id) ?>">
                                                                <i class="fa fa-key" i></i></a>
                                                            	&nbsp; &nbsp; 
                                                            	
                                                            	<?php
                                                            	  }
                                                                }
                                                            	?>
                                                                <?php
                                                                if($rows->admin_user_id!=1)
                                                                {
                                                                
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                         <a title="Delete" class="remove" href="#"  data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o removeThis" for="<?php echo $rows->admin_user_id ?>"></i>
                                                        </a>
                                                        <?php
                                                        }
                                                        
                                                                }
                                                        ?>
			&nbsp;&nbsp;
                                                        <?php
                                                                if($rows->admin_user_id!=1)
                                                                {
                                                                    ?>
                                                           <a href="<?php echo base_url();?>admin/set_permission/<?php echo $this->common_functions->encryptId($rows->admin_user_id); ?>" class="btn btn-primary btn-sm rounded-s radius update">Update permission</a>
                                                        
                                                        <?php
                                                                }
                                                        ?>
                                                        </td>
                                                        </tr>
                                                        <?php
                                    }
                            ?>
                </tbody>
              </table>
                <?php

}
else
{


          echo  "No Results Found";

}
?>
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
             
           
           
          // alert(id);
           csrf_value  =   getCookie('csrf_cookie_name');  
             $.ajax({
            url:  '<?php echo base_url();?>admin/C_admin/deleteAdmin',
            type: 'POST',
            data: {admin_user_id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			    // alert(data);

			      if(data==1)
                    {
                       
                          swal("Well done!", "Deleted Successfully!", "success");
						  
						  location.reload();
                              
                    }
                    else if(data==3)
                    {
                        swal("Sorry!", "Admin super user cannot be deleted", "error");
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
            url:  '<?php echo base_url();?>admin/C_admin/approveAdmin',
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

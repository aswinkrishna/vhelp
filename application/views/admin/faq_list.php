<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?> 
 <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> FAQ list</h1>
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
            &nbsp;

        </div>
        </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <h3 class="title">
                                    
                                        <?php
                                        if($permission->perm_add==1) {
                                            ?>
                                            <a href="<?php echo base_url();?>admin/add_faq" class="btn btn-primary btn-sm rounded-s radius float-right"><span>+</span> Add New </a>
                                            <?php
                                        }
                                        ?>
                                       
                                    </h3><br>

              <?php

                                        if(isset($data_list) && count($data_list)>0) {
                                        ?>

                                            <table border="0" cellspacing="0" cellpadding="0" id="example" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th style="width:60%">Title</th>                                                       
                                                        <th>Status</th>
                                                        <th>Published</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    //print_r($countrylist);

                                                    foreach($data_list as $rows)  {

                                                        $postedDate = date("F j, Y, g:i a",strtotime($rows->updated_at));     ?>
                                                            <tr>
                                                                <td><?php echo $rows->faq_id   ?> </td>
                                                                <td><?php echo $rows->faq_title ?> </td>                                                         
                                                                <td> <?php echo ($rows->status==1?"Active":"Inactive") ;?></td>
                                                                <td> <?php echo $postedDate;?> </td>
                                                                <td> 
                                                                <?php
                                                                if($permission->perm_edit==1) {
                                                                    ?> 
                                                                        <a class="edit" href="<?php echo base_url().'admin/add_faq/'.$rows->faq_id ?> ">
                                                                        <i class="fa fa-pencil" i></i>
                                                                    </a>
                                                                    &nbsp; &nbsp; 
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if($permission->perm_delete==1) {
                                                                    ?>
                                                                    <a class="remove" href="#"  data-toggle="modal" data-target="#confirm-modal">
                                                                        <i class="fa fa-trash-o removeThis" for="<?php echo $rows->faq_id ?>"></i>
                                                                    </a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                            </tr>
                                                            <?php
                                                    } ?>
                                                </tbody>
                                            </table>

                                        <?php
                                        }
                                        else {
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
                <script>
                     $(document).ready(function() {
    var table = $('#sampleTable').DataTable({    "order": [],
    // Your other options here...
});
 });
             $(document).delegate(".removeThis","click",function(e)
    {
       // $("#txtDelete").val("");
        var deleteId     = $(this).attr("for");
       // $("#txtDelete").val(deleteId);
        deleteThis(deleteId);
      
    });


       function deleteThis(id)
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
            url:  '<?php echo base_url();?>admin/C_admin/delete_faq',
            type: 'POST',
            data: {id:id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			  //  alert(data);

			      if(data>0)
                    {
                       
                          swal("Well done!", "Deleted Successfully!", "success");
						  
	location.reload();
                              
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
           
         //  return false;
           
           
             
       }
                </script>
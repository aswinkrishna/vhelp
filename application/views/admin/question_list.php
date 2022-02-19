<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Question list</h1>
<!--          <p>Table to display analytical data effectively</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>-->
      </div>
<!--    <div class="row">
          <div class="col-md-12">
                <div class="col-md-8 col-md-offset-12">
                    <a href="<?php echo base_url();?>admin/add_edit_city"> <button class="btn btn-primary" type="button">Add new city</button></a>
                </div>
              </div>
    </div>-->
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
                    $p=1;
                    if(count($question_list)>0)
                    {
                    ?>
                  <tr>
                     <th>Sl no</th>
                     <th>Question</th>
                     <th>Input type</th>
                    <th>Answer options</th>      
                     <th>Service type</th>     
                    <th>Created date</th>
                    <th>Status</th>
<!--                    <th>Approve</th>-->
                     <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                     $language =($this->session->userdata('language')>0?$this->session->userdata('language'):1);
                    foreach($question_list as $rows)
                    {
                        $con['question_id']         =              $rows->question_id;
                        $answers                           =              $this->M_admin->getAnswers($con);     
                     //  print_r($answers);
                        
                    ?>
                  <tr>
                        <td><?php  echo $p; ?></td>
                    <td><?php  echo $language==2?$rows->question_arb:$rows->question; ?></td>
                    <td><?php  echo $rows->form_control_name; ?></td>
                    <td><?php  
                   if(count($answers)>0)
                   {
                       $k=1;
                       foreach($answers as $subRow)
                       {
                           $ans =  $language==2?$subRow->answer_option_arabic:$subRow->answer_option ;
                           ?>
                        <p><?php echo $k.". ".$ans ?></p>
                          <?php
                           $k++;
                       }
                   }
                    ?></td>  
                    <td><?php  echo $rows->service_type_name; ?></td>  
                    <td><?php  echo get_date_in_timezone('Asia/Dubai', $rows->question_created_time, 'd-m-Y h:i A'); ?></td>
                    <td><?php  echo $rows->question_status==1?"Active":"Inactive"; ?></td>
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
                                                 <a class="edit" href="<?php echo base_url();?>admin/add_edit_questions/<?php echo $this->common_functions->encryptId($rows->service_type_id);  ?>/<?php echo $this->common_functions->encryptId($rows->question_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;    
                                                  <?php
                                                        }
                                                       ?>
                                                  <?php
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                 <a class="remove" href="javascript:void(0)" > <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->question_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
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
            url:  '<?php echo base_url();?>admin/C_admin/deleteQuestion',
            type: 'POST',
            data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			

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

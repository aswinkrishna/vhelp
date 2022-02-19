<style>
    .table > thead > tr > th {
    border-color: #fff !important;
    font-size: 14px !important;
    border-bottom:0 !important;
    border-top:0 !important;
}
</style>
<?php

$adminUserid  = $this->common_functions->decryptId($this->uri->segment(3));

$adminUserDetails =	$this->M_admin->getAdminUserDetails($adminUserid);

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
          <div class="col-md-9">
                <div >
                    &nbsp;
                </div>
              </div>
           <div class="col-md-3">
                <div >
                    <a href="javascript:void(0)" id="savePerm"> <button class="btn btn-primary" type="button">SAVE</button></a>
                </div>
              </div>
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
<?php
   $attributes = array('method' => 'post', 'id' => 'itemForm', 'name' => 'item','role'=>'form');
                                 echo  form_open_multipart(base_url().'admin/C_product/saveAttribute', $attributes);

                             if(isset($menu) && count($menu)>0)
                             {
                            ?>
<select id="admin_user_id" name="admin_user_id" class="form-controll" style="display:none;">
<option value="<?php echo $adminUserDetails->admin_user_id ?>"><?php echo $adminUserDetails->admin_first_name ?> <?php echo $adminUserDetails->admin_last_name ?></option>
</select>
<table border="0" cellspacing="0" cellpadding="0"  id="example12" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">Sl No</th>
                                                            <th rowspan="2">Menu</th>
                                                            <th colspan="4">Actions</th>
                                                          
                                                        </tr>
                                                         <tr>
                                                            <th>view</th>
                                                            <th>Add</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 
//print_r($productList);
$i=1;
 foreach($menu as $rows) 
 {

if($adminUserid>0)
{
   $oldData = $this->M_admin->getAdminPermissionsByMenu($adminUserid,$rows->admin_menu_id);  
  // print_r($oldData);
}



  ?>
                                                        <tr>
                                                            <td><?php echo $i ?> </td>
                                                            <td><?php echo $rows->admin_menu_name ?></td>
                                                            <td>
                                                                <label class="control-label" for="formGroupExampleInput">&nbsp;</label>                                                 
<div><label><input <?php echo $oldData->perm_view==1?"checked":""; ?>  class="checkbox class_sold_ind" type="checkbox" value="1" id="txt_sold_individual" name="txt_view[<?php echo $rows->admin_menu_id ?>]"> 
 <span>&nbsp;</span></label></div>  
                                                            </td>
                                                            <td>
                                                                <label class="control-label" for="formGroupExampleInput">&nbsp;</label>                                                 
<div><label><input <?php echo $oldData->perm_add==1?"checked":""; ?> class="checkbox class_sold_ind" type="checkbox" value="1" id="txt_sold_individual" name="txt_add[<?php echo $rows->admin_menu_id ?>]"> 
 <span>&nbsp;</span></label></div>  
                                                                </td>
                                                            <td>
                                                                <label class="control-label" for="formGroupExampleInput">&nbsp;</label>                                                 
<div><label><input <?php echo $oldData->perm_edit==1?"checked":""; ?> class="checkbox class_sold_ind" type="checkbox" value="1" id="txt_sold_individual" name="txt_edit[<?php echo $rows->admin_menu_id ?>]"> 
 <span>&nbsp;</span></label></div>  
                                                             </td>
                                                            <td>
                                                                <label class="control-label" for="formGroupExampleInput">&nbsp;</label>                                                 
<div><label><input <?php echo $oldData->perm_delete==1?"checked":""; ?> class="checkbox class_sold_ind" type="checkbox" value="1" id="txt_sold_individual" name="txt_delete[<?php echo $rows->admin_menu_id ?>]"> 
 <span>&nbsp;</span></label></div>  
                                                             </td>
                                                            
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


          echo  "No Results Found";

}


                    ?>
<?php  echo form_close(); ?>
                   </div>
            </div>
        </div>
      </div>
    </main>
                <script>
              
     
	   $(document).delegate("#savePerm","click",function(e)
    {
        
        //alert();
        
        
        dataString = $('#itemForm').serialize();
                 var formData = new FormData($("#itemForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name'); 
                  
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveAdminPermission',
             type: 'POST',
             data: formData,
             async: false,
             success: function (data) 
                {
                    
                    //alert();
                    if(data==1)
                    {
                        swal("Permission added successfully");
                    }
                    else
                    {
                         swal("Something went wrong! try again later");
                    }
                   
              },
             cache: false,
             contentType: false,
             processData: false
         });
        
        
        
        
		
	});
	  
	
   </script>
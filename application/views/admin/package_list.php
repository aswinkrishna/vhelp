<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Package list</h1>
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
                    <a href="<?php echo base_url();?>admin/add_edit_package"> <button class="btn btn-primary" type="button">Add new package</button></a>
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
                    <span style="float: right;">
                                
                                               
                                             <input type="text" id="min" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="From Date">  &nbsp;&nbsp; <input type="text" id="max" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="To Date">
                                                
                                            </span>
              <table class="table table-striped table-bordered table-hover" id="sampleTable">
                <thead>
                    <?php
                    if(count($package_list)>0)
                    {
                    ?>
                  <tr>
                     <th>Sl no</th>
                     <th> Package name</th>  
                    <th>Package name arabic</th>
                    <th>Quotation limit</th>
                    <th>Eq recommended</th>
                    <th>Package price</th>
                    <th>Created date</th>
                    <th>Status</th>
                    
                     <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $p=1;
                    foreach($package_list as $rows)
                    {
                         
                    ?>
                  <tr>
                     <td><?php  echo $p; ?></td>
                     <td><?php  echo $rows->packages_name; ?></td>
                    <td><?php  echo $rows->packages_name_arabic; ?></td>
                    <td><?php  echo $rows->packages_quotaion_limit; ?></td>
                    <td><?php echo ($rows->packages_recomended_provider==1?"Yes":"No") ;?></td>
                    <td><?php  echo $rows->packages_price; ?></td>

                    <td><?php  echo $rows->packages_created_time; ?></td>
                    <td><?php  echo $rows->packages_status==1?"Active":"Inactive"; ?></td>
                    
                    <td>
                        <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?>
                                                 <a class="edit" href="<?php echo base_url();?>admin/add_edit_package/<?php echo $this->common_functions->encryptId($rows->packages_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;    
                                                 <?php
                                                        }
                                                       ?>
                                                 <?php
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                 <a class="remove" href="javascript:void(0)" > <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->packages_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                                    <?php
                                                         }
                                                             
                                                     ?>
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
  $(document).ready(function() {
    var table = $('#sampleTable').DataTable({
    "order": [],
    // Your other options here...
});
     
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').change( function() {
     
        table.draw();
    } );
    
    $("#min").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                onClose: function (selectedDate) {
                    $("#max").datepicker("option", "minDate", selectedDate);
                }
            });
    $("#max").datepicker({
                dateFormat:'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                onClose: function (selectedDate) {
                    $("#min").datepicker("option", "maxDate", selectedDate);
                }
            });  
     $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            var max = $('#max').datepicker("getDate");
            
//            if(min!=null && max==null)
//            {
//                max=min;
//            }
//            if(max!=null && min==null)
//            {
//                min=max;
//            }
//           
            var startDate = new Date(data[6]);
            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
       //     return false;
        }
        );
    
} );
   
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
            url: '<?php echo base_url();?>admin/C_admin/deletePackage',
            type: 'POST',
            data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 
				if(data>0)
                                                                                    {
                                                                                         swal("Package Deleted!");
                                                                                         location.reload();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        swal("Cannot delete package!");
                                                                                    }
				
                                                                 }
        });
   
    
    
  } else {
    
  }
});
    }
    
    </script>

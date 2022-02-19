<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  3;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
$permission2    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,9);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>User list</h1>
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
                    <a href="<?php echo base_url();?>admin/add_edit_user"> <button class="btn btn-primary" type="button">Add new user</button></a>
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
                                             &nbsp;&nbsp;
                                             <button type="button" class="btn btn-danger" onclick="clearData();">Reset</button>
                                                
                                            </span>
              <table class="table table-striped table-bordered table-hover" id="sampleTable">
                <thead>
                    <?php
                    if(count($user_list)>0)
                    {
                    ?>
                  <tr>
                    <th>Sl no</th>
                    <th>Name</th>
                    <!--<th>Company name</th>-->
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Wallet Balance(<?= $this->config->item('currency') ?>)</th>
                    <th>Created date</th>
                    <th>Approve</th>
                     <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $p=1;
                    foreach($user_list as $rows)
                    {
                        if (strpos($rows->user_dial_code, '+') === false)
                            $rows->user_dial_code = '+'.$rows->user_dial_code;
                        //$profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";   
                    ?>
                  <tr>
                    <td><?php  echo $p; ?></td>
                    <td><?php  echo $rows->user_first_name." ".$rows->user_last_name; ?></td>
                    <td><?php  echo $rows->user_email; ?></td>
                    <td><?php  echo $rows->user_dial_code."- ".$rows->user_phone; ?></td>
                    <td><?php  echo $rows->wallet_balance; ?></td>
                    <td><?php  echo date("Y/m/d",strtotime($rows->user_created_time)); ?></td>
                    <td><label class="switch">
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
                                                        
  <input type="checkbox" <?php echo ($rows->user_status==1?"checked":"") ;?> for="<?php echo $rows->user_id ?>" class="swichCheck" <?php echo $disabled;?>>
  <span class="slider round"></span>
</label></td>
                    <td>
                        <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?>
                                                 <a class="edit" href="<?php echo base_url();?>admin/add_edit_user/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;    
                                                 <?php
                                                        }
                                                     ?>
                                                      <?php
                                                  if($permission->perm_view==1)
                                                        {
                                                        ?>
                                                 <a class="detailView" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" href="javascript:void(0)" > <i class="fa fa-eye" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                                    &nbsp;  &nbsp;
                                                    <?php
                                                         }
                                                 ?> <a class="add_wallet"  href="<?php echo base_url();?>admin/manage_wallet/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" ><img src="<?= base_url()?>images/userwallet.png"></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                                 <?php
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                 <a class="remove" href="javascript:void(0)" > <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                               <?php
                                                         }
                                                     ?>
                                                     <a class="add_wallet"  href="<?php echo base_url();?>admin/manage_wallet/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" ><i class="fa fa-wallet"></i>Wallet</a>&nbsp; &nbsp;&nbsp; &nbsp;    

                                               <?php  if($rows->user_status==1 && $permission2->perm_view==1) { 
                                               if($permission2->perm_add==1)
                                               {
                                               ?>
                                               <!--<a href="<?php echo base_url();?>admin/send_request/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">Send Request</a>-->
                                               
                                               <?php
                                               }
                                               ?>
                                                <!--&nbsp;  &nbsp;   <a href="<?php echo base_url();?>admin/view_user_jobs/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">View EQ Recommended</a>-->
                                              <!--&nbsp;  &nbsp;  <a href="<?php echo base_url();?>admin/view_user_quotations/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">View quotations</a>-->
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
        <p>Some text in the modal.</p>
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

            var startDate = new Date(data[4]);
            if (
                ( min === null && max === null ) ||
                ( min === null && startDate <= max ) ||
                ( min <= startDate   && max === null ) ||
                ( min <= startDate   && startDate <= max )
            ) {
                return true;
            }
            return false;
        });
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
            url: '<?php echo base_url();?>admin/C_admin/deleteUser',
            type: 'POST',
            data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
             {
             
                if(data>0)
                                                                                    {
                                                                                         swal("User Deleted!");
                                                                                         location.reload();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        swal("Cannot delete user!");
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
               
            location.reload();
            // alert(data);

            // console.log(data);   

              

               
            }
        });    
        
    });
      $(document).delegate(".detailView","click",function(e)
    {
            id  = $(this).attr("for") ;
            $("#detailDiv").html("");
            csrf_value  =   getCookie('csrf_cookie_name');    
             $.ajax({
            url:  '<?php echo base_url();?>admin/C_admin/userDetails',
            type: 'POST',
            data: {id:id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
            {
               $("#myModalDetails").modal("show");
               $("#detailDiv").html(data);
               
            }
        });  
    });
    
    function clearData()
    {
      $('input').val('');
      $('input#min').trigger('change');

    }
    </script>

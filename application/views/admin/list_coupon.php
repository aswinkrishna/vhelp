<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>All Coupons</h1>
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
                    <a href="<?php echo base_url();?>admin/add_edit_coupon"> <button class="btn btn-primary" type="button">Add Coupons</button></a>
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
              <table id="sampleTable" class="table table-striped table-bordered table-hover">
                                                <thead >
                                                    <tr >
                                                        <th class="">ID</th>
                                                        <th class="">Code</th>
                                                        <th class="">Title</th>       
                                                        <th class="">Amount (%)</th>
                                                        <th class="">Expiry Date</th>
                                                        <th>Min. Spend</th>
                                                        <th>Max. Redeem</th>
                                                        <th class="">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    //  print_r($productList);
                                                    $sid = 0;
                                                    foreach ($coupon_list as $rows) {
                                                        $sid++;
                                                        $postedDate = get_date_in_timezone("Asia/Dubai", $rows->coupon_end_date, "F j, Y");

                                                        ?>
                                                        <tr class="">

                                                            <td><?php echo $sid; ?></td>

                                                            <td>
                                                                <?php echo $rows->coupon_code; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rows->coupon_title ?> </h4>
                                                            </td>
                                                           
                                                            <td>
                                                                <?php echo $rows->coupon_amount; ?></div>
                                                            </td>

                                                            <!--<td class="item-col item-col-sales">
                                                                    <div> Camel</div>
                                                            </td>-->
                                                            <td>
                                                                <div><?php echo $postedDate; ?></div>
                                                            </td>

                                                            <td><?php echo $rows->coupon_minimum_spend ?></td>
                                                            <td><?php echo $rows->coupon_maximum_spend ?></td>

                                                            <td >
                                                            <?php
                                                                if($permission->perm_edit==1) {
                                                                    ?>
                                                                    <a class="edit" href="<?php echo base_url().'admin/add_edit_coupon/'.$rows->coupon_id ?> ">
                                                                        <i class="fa fa-pencil" i></i>
                                                                    </a>
                                                            
                                                                    &nbsp; &nbsp; 
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if($permission->perm_delete==1){
                                                                    ?>   
                                                                   <a style="margin-left:10px" class="remove removeThis" for="<?php echo $rows->coupon_id; ?>"  href="#" data-toggle="modal" data-target="#confirm-modal">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                    <?php
                                                                }
                                                                ?>
                                                           
                                                                             
                                                                            
                                                            </td>

                                                            

                                                    </tr>
                                                    <?php
                                                    }?>
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
            url:  '<?php echo base_url();?>admin/C_admin/deleteCoupon',
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
     
       
    </script>

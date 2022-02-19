<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  5;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Provider list</h1>
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
                    <a href="<?php echo base_url();?>admin/add_edit_provider"> <button class="btn btn-primary" type="button">Add new provider</button></a>
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
                    <th>Company name</th>
                    <th>Email</th>
                    <th>Phone</th>
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
                         $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/logo.png";  
                  $con['user_id']                   =       $rows->user_id;                  
               
                  $data['user_details']         =      $this->M_admin->getProvidersDetailsCondition($con);  
                  $packageName="";
                  $packageId =  $data['user_details'][0]->package_id;
                  if($packageId>0)
                  {
                      $packageDetails         =      $this->M_admin->getPackageName($packageId);  
                      
                      $packageName  =  $packageDetails->packages_name;
                  }
                  
                    if(strpos($rows->user_dial_code, '+') === false)
                        $rows->user_dial_code = '+'.$rows->user_dial_code;
               
                    ?>
                  <tr>
                     <td><?php  echo $p; ?></td>
                     
                    <td><?php  echo $rows->user_first_name." ".$rows->user_last_name; ?></td>
                    <td><?php  echo $data['user_details'][0]->company_name; ?></td>
                    <td><?php  echo $rows->user_email; ?></td>
                    <td><?php  echo $rows->user_dial_code."- ".$rows->user_phone; ?></td><td><?php  echo get_date_in_timezone('Asia/Dubai', $rows->user_created_time, 'Y/m/d'); ?></td>
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
                                                 <a class="edit" href="<?php echo base_url();?>admin/add_edit_provider/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>">  <i class="fa fa-pencil" i=""></i></a> &nbsp; &nbsp;&nbsp; &nbsp;    
                                                 <?php
                                                        }
                                                       ?>
                                                 <?php
                                                 if($permission->perm_view==1)
                                                        {
                                                        ?>
                                                 <a title="View Staff(s)" href="<?php echo base_url('staffs-list/').$this->common_functions->encryptId($rows->user_id); ?>" > <i class="fa fa-users"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;
                                                    <?php
                                                         }
                                                  if($permission->perm_view==1)
                                                        {
                                                        ?>
                                                 <a class="detailView" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" href="javascript:void(0)" > <i class="fa fa-eye" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                                    &nbsp;  &nbsp;
                                                    <?php
                                                         }
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                 <a class="remove" href="javascript:void(0)" > <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->user_id);  ?>"></i></a>&nbsp; &nbsp;&nbsp; &nbsp;    
                                                    <?php
                                                         }
                                                              if($rows->user_status==1)
                                                        {
                                                         ?>
                                         <!--&nbsp;  &nbsp;-->
                                         <!--        <a href="<?php echo base_url();?>admin/view_provider_jobs/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">View EQ Recommended</a>-->
                                         <!--       &nbsp;  &nbsp;-->
                                               
                                                 <!--<a href="<?php echo base_url();?>admin/view_provider_quotations/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>" class="btn btn-primary btn-sm rounded-s radius update">View quotaions</a>-->
                    &nbsp;  &nbsp;
                                               
                                                 <!--<a href="javascript:void(0);" class="btn btn-primary btn-sm rounded-s radius assignPack" for="<?php echo $rows->user_id;?>" data-id="<?php echo $packageId;?>">Assign package</a>-->
 <?php
    
                                                                 }
            $result = $this->M_admin->getRatingList($rows->user_id);
                        if(count($result) > 0){
 ?>
                                                     
                <a href="<?=base_url()?>admin/rating_list/<?php echo $this->common_functions->encryptId($rows->user_id);  ?>">Rating</a>
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
<!-- Modal -->
<div id="assignPackage" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    max-width: 537px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Assign Package</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <form id="packageForm">
      <div class="modal-body" >
          <?php
          $con22['packages_status']      =  1;
          $package_list                         =  $this->M_admin->getPackagesCondition($con22)     ;     
       //  $records1                                =  $package_list[0];
          ?>
         <div class="col-md-12">
                                 <div class="form-group">
                                <label class="control-label">Select package</label>
                              <select class="c-select form-control boxed controll-wdth" name="package" id="package">
                                  <option value="">Select</option>
                                  <?php
                                  foreach($package_list as $rows)
                                  {
                                  ?>
                                       
                                        <option value="<?php echo $rows->packages_id  ;?>" ><?php echo $rows->packages_name  ;?></option>
                                        
                                        
                                        <?php
                                  }
                                        ?>
                                       
                                    </select>
                                <input type="hidden" id="assigned_user" name="assigned_user">
                                 </div> 
                        </div>
      </div>
        </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  id="btnAssignPackage">Assign</button>
      </div>
    </div>

  </div>
</div>
 <!-- Modal -->
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
			   

			// alert(data);
 location.reload();
			// console.log(data);   

         	  

			   
            }
        });    
		
	});
        
        $(document).delegate(".assignPack","click",function(e)
    {
        
        $("#assigned_user").val($(this).attr("for"));
        packageId =$(this).attr("data-id") ;
        if(packageId>0)
        {
            $("#package").val(packageId);
        }
        else
        {
             $("#package").val("");
        }
        $("#assignPackage").modal("show");
    });
      $(document).delegate("#btnAssignPackage","click",function(e)
    {
        $("#packageForm").submit();
       
    });
       var validator=$("#packageForm").validate(
            //alert();
        {
           ignore: [],
             
        rules: 
        {
          
          package: 
          {
            required: true
            
          }
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {
              var userid = $("#assigned_user").val();
                $(".errorSpan1").html("");	               
                $("#btnAssignPackage").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
             //   dataString = $('#dynamicForm').serialize();
                var formData = new FormData($("#packageForm")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 formData.append('user_id',userid); 
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/assignPackage',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                    $("#registerLoader").html("");
                    $('#btnAssignPackage').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                   //  console.log(data['status']);

                    if(data['status']==1)
                    {
                       //  $("#assignPackage").modal("hide");
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Saved Successfully!", "success");
                        location.reload();
                     
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                                $('[name='+key+']').parents('.form-group').find('.error').html(value);

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
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

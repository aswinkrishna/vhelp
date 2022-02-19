<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  6;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Rating list</h1>
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
                  <span style="float: right;">
                                
                                               
                                             <input type="text" id="min" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="From Date">  &nbsp;&nbsp; <input type="text" id="max" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="To Date">
                                                
                                            </span>
              <table class="table table-striped table-bordered table-hover" id="sampleTable">
                <thead>
                    <?php
                    if(count($user_list)>0)
                    {
                    ?>
                  <tr>
                     <th>Sl no</th>
                    <th>Provider name</th>  
                    <th>Staff name</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th>Customer name</th>
                    <th>Added adte</th> 
                     <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $p=1;
                        foreach($user_list as $rows){
                    ?>
                  <tr>
                    <td><?php  echo $p; ?></td>
                    <td><?php  echo $rows->company_name; ?> </td>
                    <td><?php  echo $rows->staff_first_name; ?> <?php  echo $rows->staff_last_name; ?></td>
                    <td><?php  echo $rows->user_rating; ?></td>
                    <td><?php  echo $rows->feedback; ?></td>
                     <td><?php  echo $rows->user_first_name." ".$rows->user_last_name; ?></td>
                     <td><?php  echo date("Y M d",strtotime($rows->date)); ?></td>
                    <td>
                        <?php
                            if($permission->perm_view==1){
                        ?>
                            <a class="detailView" for="<?php echo $this->common_functions->encryptId($rows->id);  ?>" href="javascript:void(0)" > <i class="fa fa-eye"></i></a>
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
<div id="myModalDetails" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    max-width: 996px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Order Details</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="detailDiv">
        
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
            url: '<?php echo base_url();?>admin/C_admin/deleteRating',
            type: 'POST',
            data: {id:deleteId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 
				if(data>0)
                                                                                    {
                                                                                         swal("Rating Deleted!");
                                                                                         location.reload();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        swal("Cannot delete Rating");
                                                                                    }
				
                                                                 }
        });
   
    
    
  } else {
    
  }
});
    }
     $(document).delegate(".swichCheck","change",function(e)
    {
       // alert();
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
            url:  '<?php echo base_url();?>admin/C_admin/approveRating',
            type: 'POST',
            data: {id:id,status:status,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			   

			if(data==1)
                        {
                            location.reload();
                        }

			// console.log(data);   

         	  

			   
            }
        });    
		
	});
    </script>

    <script type="text/javascript">
        $(document).delegate(".detailView","click",function(e){
            id  = $(this).attr("for") ;
            // alert(id);
            $("#detailDiv").html("");
            csrf_value  =   getCookie('csrf_cookie_name');    
             $.ajax({
            url:  '<?php echo base_url();?>admin/C_admin/getOrderDetailsByRating',
            type: 'POST',
            data: {id:id},
            success: function (data) 
            {
               $("#myModalDetails").modal("show");
               $("#detailDiv").html(data);
               
            }
        });  
    });
    </script>
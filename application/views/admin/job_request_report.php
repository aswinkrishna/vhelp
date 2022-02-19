<?php
$adminUserid   =  $this->session->userdata('admin_id'); 

$menuId        =  9;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
 $url            =  $_SERVER['REQUEST_URI'];
 $urlArray  =  explode("/",$url);
 $urlArray    =  array_reverse($urlArray);
if (in_array("quotation_list", $urlArray) )
  {
  $labelrequests      =  "Job Request Report";
  $typeJob =1;
  }
  else if(in_array("request_list", $urlArray))
  {
      $labelrequests      =  "Job Request Report";
      $typeJob =2;
  } 
  else if (in_array("view_provider_quotations", $urlArray) )
  {
     $labelrequests      =  "Job Request Report(Provider)";
     $typeJob =1;
  }
  else
  {
      $labelrequests      =  "Job Request Report";
      $typeJob =2;
  }
?> 
<style>
    table a.btn {
        position: relative;
        padding-right: 30px;
    }
</style>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>&nbsp;<?php  echo $labelrequests;?></h1>
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
                                                        if($permission->perm_add==1 && 1==2)
                                                        {
                                                        ?>
                                        <a href="<?php echo base_url();?>admin/add_edit_testimonial" class="btn btn-primary btn-sm rounded-s radius"><span>+</span> Add New </a>
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
        
        <input type="hidden" id="details_id">
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body" >
              <section class="example">
                                            <span style="float: right;">
                                
                                               
                                             <input type="text" id="search_key" class="radius select-border" autocomplete="off"  placeholder="search">  &nbsp;&nbsp;     <input type="text" id="txt_sale_datefrom" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="From Date">  &nbsp;&nbsp; <input type="text" id="txt_sale_dateto" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="To Date">&nbsp;&nbsp;<button type="submit" class="btn btn-primary radius button-padd" id="btnSave" onclick="listJobRequests();"> Apply </button>&nbsp;&nbsp;
                                                
                                            </span>
                                          
                                             <div class="table-responsive" id="listTable">







                   </div>
               </section>
            </div>
          </div>
        </div>
      </div>
    </main>
 <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    max-width: 996px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Job request details</h4>
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
  <!-- Modal -->
<div id="myModalRefuseReason" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    max-width: 996px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Refuse reason</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Select any reason</label>
                                <select class="form-control"  id="txt_reason"  name="txt_reason">
                                    <option value="">Select</option>
                                    <?php
                                   $reason = $this->M_job_admin->getRefuseReason();
                                    if(count($reason)>0)
                                    {
                                        foreach($reason as $rows)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows->refuse_reason_id ?>" ><?php  echo $rows->refuse_reason ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                                
                                <input type="hidden" id="refuceJob" >
                                 </div> 
                        </div>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id="btnRefuse" >Refuse</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="myModalAssignProvicer" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 996px">
    <!-- Modal content-->
  
    <div class="modal-content modal-lg">
      <form method="post" id="assignProvider">
        <div class="modal-header">     
          <h4 class="modal-title">Assign Service Provider</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Select any Service Provider</label>
                <select class="form-control"  id="service_provider" name="service_provider">
                  <option value="">select</option>                    
                </select>                                
                <input type="hidden" id="request_id">
                <input type="hidden" id="job_request_id">
              </div> 
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn" name="assign">Assign</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>    
  </div>
</div>
 <!-- Modal -->
  <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    max-width: 996px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">ViewersList</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="divVeiwers">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 <!-- Modal -->
 
 <div id="staff-assign-modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 996px">
    <form name="staff-assign-form" method="post" id="assignStaff">
    <!-- Modal content-->
    <input type="hidden" name="hid_request_id" id="hid_request_id" value="0"/>
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Assign Staff</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="staffListing">
        <div class="row">
          <div class="col-md-6">
            <select class="form-control" name="staff_id" id="staff_id">
              <option value="">Select Staff</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Assign</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>
<script>

  function assignProvider(enc_request_id, job_request_id)
  {
    $("#request_id").val(enc_request_id);
    $("#job_request_id").val(job_request_id);
    $("#myModalAssignProvicer").modal("show");
    $.ajax({
      type:"POST",
      data:{job_request_id:job_request_id},
      url:"<?=base_url()?>admin/C_admin/getServiceProviders",
      success:function(response)
      {
        $("#service_provider").html(response);
      },
    });
  }

  $('body').on('submit', '#assignProvider', function(e) { 
           
            e.preventDefault();
            var validation = $.Deferred();
            var $form = $(this);
            var formData = new FormData(this);

            $form.validate({
                rules: {
                  service_provider: {
                        required: true,
                    },                    
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    element.addClass('is-invalid');
                    error.addClass('invalid-feedback');
                    error.insertAfter(element);
                }
            });

            if ( $form.valid() ) {
                validation.resolve();
            } else {
              var error = $form.find('.is-invalid').eq(0);
                $('html, body').animate({
              scrollTop: (error.offset().top - 10),
          }, 500);
              validation.reject();
            }

            validation.done(function() {
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('div.invalid-feedback').remove();
                $form.find('button[type="submit"]').text('Saving...').attr('disabled', true);
                formData.append("enc_request_id",$("#request_id").val());              
                formData.append("job_request_id",$("#job_request_id").val());              
                
                 $.ajax(
                {
                    type:"POST",
                    url: "<?=base_url()?>admin/C_admin/assignServiceProvider",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (data) 
                    {                       
                      if(data.status == 1)
                      {
                        $("#myModalAssignProvicer").modal("hide");
                        listJobRequests();

                        swal("Assigned Provider successfully");
                      }
                      else
                      {
                        if ( typeof data.validationErrors !== 'undefined' ) 
                        {                                
                          var error_def = $.Deferred();
                          var error_index = 0;
                          jQuery.each(data.validationErrors, function (e_field, e_message) {
                            if ( e_message != '' ) {
                              $('[name="'+ e_field +'"]').eq(0).addClass('is-invalid');
                              $('<div class="invalid-feedback">'+ e_message +'</div>').insertAfter($('[name="'+ e_field +'"]').eq(0));
                              if ( error_index == 0 ) {
                                error_def.resolve();
                              }
                              error_index++;
                            }
                          });
                          error_def.done(function() {
                            var error = $form.find('.is-invalid').eq(0);
                            $('html, body').animate({scrollTop: (error.offset().top - 10),}, 500);
                          });
                        }else {
                          App.alert(data.message||"faild to sent otp please try agian","Opss");
                        }
                      }
                      $form.find('button[type="submit"]').text('Assign').attr('disabled', false);
                    }                 
                }
            );
          });
      });
	

 $(document).ready(function(){
    
    listJobRequests();
    var interval = 20000;
    setInterval(listJobRequests, interval);
    
    $("#txt_sale_datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                onClose: function (selectedDate) {
                    $("#txt_sale_dateto").datepicker("option", "minDate", selectedDate);
                }
            });
    $("#txt_sale_dateto").datepicker({
                dateFormat:'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                onClose: function (selectedDate) {
                    $("#txt_sale_datefrom").datepicker("option", "maxDate", selectedDate);
                }
            });  
			    });
function listJobRequests()
{
    
			      // alert();
            
             txt_sale_datefrom  = $("#txt_sale_datefrom").val();
             txt_sale_dateto    = $("#txt_sale_dateto").val();
             search_key         = $("#search_key").val();
             formVal  = $('#searchForm').serializeArray();
             formVal.push({ name: "limit_per_page", value:10 });
             formVal.push({ name: "txt_sale_datefrom", value:txt_sale_datefrom });
             formVal.push({ name: "txt_sale_dateto", value:txt_sale_dateto });
             formVal.push({ name: "search_key", value:search_key });
             formVal.push({ name: "user_type", value:2});
             
             <?php if($job_request_type>0) {?>
                       formVal.push({ name: "job_request_type", value:<?php  echo $job_request_type;?> });
                     <?php 
             }
                     ?>
              <?php if($provider_id>0) {?>
                       formVal.push({ name: "provider_id", value:<?php  echo $provider_id;?> });
                     <?php 
             }
                     ?>
             
              csrf_value  =   getCookie('csrf_cookie_name'); 
                formVal.push({ name: "<?php echo $this->security->get_csrf_token_name();?>", value:csrf_value });
              $("#listTable").html("");
          
          $.ajax( {
						type: 'POST',
						url: '<?php echo base_url();?>admin/C_admin/listJobRequestsAjax',
						data: formVal ,
                        success: function(data) 
                       {
                           
                           
                           // alert(data);
                           $("#listTable").html(data);
                       }
					}); 
}
			    
$("#listTable").on("click", ".pagination a", function (e) 
{
             e.preventDefault();
  	         txt_sale_datefrom  = $("#txt_sale_datefrom").val();
             txt_sale_dateto    = $("#txt_sale_dateto").val();
             search_key         = $("#search_key").val();
             formVal  = $('#searchForm').serializeArray();
             formVal.push({ name: "limit_per_page", value:10 });
             formVal.push({ name: "txt_sale_datefrom", value:txt_sale_datefrom });
             formVal.push({ name: "txt_sale_dateto", value:txt_sale_dateto });
             formVal.push({ name: "search_key", value:search_key });
             formVal.push({ name: "user_type", value:2});
              <?php if($job_request_type>0) {?>
                       formVal.push({ name: "job_request_type", value:<?php  echo $job_request_type;?> });
                     <?php 
             }
                     ?>
              <?php if($provider_id>0) {?>
                       formVal.push({ name: "provider_id", value:<?php  echo $provider_id;?> });
                     <?php 
             }
                     ?>
              csrf_value  =   getCookie('csrf_cookie_name'); 
                formVal.push({ name: "<?php echo $this->security->get_csrf_token_name();?>", value:csrf_value });
              $("#listTable").html("");
         $.ajax({
            url: $(this).attr("href"),
            type: 'POST',
            data: formVal,
            success: function (data) 
		 {
                                                                                                                               
           
        //   alert(data);
           $("#listTable").html(data);
         }
        });
        
        return false;
    });
    /*$("#filterForm").submit( function(eventObj) {
        alert();
            csrf_value  =   getCookie('csrf_cookie_name'); 
             
      $('<input />').attr('type', 'hidden')
          .attr('name', "<?php echo $this->security->get_csrf_token_name();?>")
          .attr('value', csrf_value)
          .appendTo('#filterForm');
      return true;
  });*/
    $(document).delegate("#exportToPdf","click",function(e)
    {
      //  alert();
        $("#filterForm").submit();
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
            url:  '<?php echo base_url();?>admin/C_admin/deleteJobRequest',
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
     $(document).delegate(".detailView","click",function(e)
    {
        
        $('#details_id').val($(this).attr("for"));
         csrf_value  =   getCookie('csrf_cookie_name');        
          $("#detailDiv").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/getJobRequestDetails',
            type: 'POST',
            data: {job_request_id:$(this).attr("for"),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 
				 $("#detailDiv").html(data);
				
                                                                 }
        });
       
    });  
    
    
    
    function approveJobRequest(id=0,nextStatus,jobRequestId)
    {
         $("#"+id).append( "<img class='jobLoader' src='<?php echo base_url();?>frontend_assets/images/loader-new-resized.gif'  style='    float: none;     width: 25px; height: 25px; position: absolute; right: 1px; top: 3px;'>" );
         //return false;
         $("#txt_reason").css("border-color","");
         csrf_value  =   getCookie('csrf_cookie_name');       
         if(nextStatus<0)
         {
             $("#refuceJob").val("");
             $("#myModalRefuseReason").modal("show");
             $("#refuceJob").val(jobRequestId);
             
         }
         else
         {
             approveJobRequestGo(nextStatus,jobRequestId,"");
         }
        
        
    }
     $(document).delegate("#btnRefuse","click",function(e)
    {
        nextStatus   =  "-1";
        jobRequestId = $("#refuceJob").val();
        reason       = $("#txt_reason").val();
        if(reason<=0)
        {
            $("#txt_reason").css("border-color","red");
            return false;
        }
       approveJobRequestGo(nextStatus,jobRequestId,reason);
    });  
      function approveJobRequestGo(nextStatus,jobRequestId,reason="")
      {
          
         
          
            $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/approveJobRequest',
            type: 'POST',
            data: {reason:reason,nextStatus:nextStatus,jobRequestId:jobRequestId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			  
			   $("#myModalRefuseReason").modal("hide");
			   $(".jobLoader").remove();
				if(data==1)
				{
				    listJobRequests();
				   <?php  if($typeJob==1)
				   {
				       ?>
				       if(nextStatus==1)
				       {
				       swal("Request approved successfully");
				       }
				       else
				       {
				           swal("Request rejected successfully");
				       }
				     <?php  
				   }
				   else
				   {
				       ?>
				        if(nextStatus==1)
				       {
				       swal("Job request approved successfully");
				       }
				       else
				       {
				           swal("Job request rejected successfully");
				       }
				      <?php 
				   }
				   
				   ?>
				}
				else if(data==-1)
				{
				    swal("Job has been assigned to providers,cannot refuse");
				}
				else
				{
				    swal("Something went wrong try again later");
				}
				
            }
        });
      }
       $(document).delegate(".viewersList","click",function(e)
    {
         csrf_value  =   getCookie('csrf_cookie_name');        
          $("#detailDiv").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/viewersList',
            type: 'POST',
            data: {job_request_id:$(this).attr("for"),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 
				 $("#divVeiwers").html(data);
				
                                                                 }
        });
    });  
    
     $(document).delegate(".btnApprove","click",function(e)
    {
         csrf_value  =   getCookie('csrf_cookie_name');     
         provider_id =   $(this).attr("data-id");
         // $("#detailDiv").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/confirmJob',
            type: 'POST',
            data: {job_request_id:$(this).attr("for"),provider_id:provider_id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			     $("#myModal").modal("hide");
			  if(data==1)
			  {
			      swal("Status has been changed ");
			  }
			  else
			  {
			       swal("Failed to change the status");
			  }
				
				
            }
        });
    });    
    
    $(document).delegate(".assignJobToProvider","click",function(e){
        
        assign_job_provider_id = $(this).attr("id");
        assignJob(assign_job_provider_id);
    });

    function assignJob(assign_job_provider_id){

      $.ajax({
        url: '<?php echo base_url();?>admin/C_admin/assignJobToProvider',
        type: 'POST',
        data: {assign_job_provider_id : assign_job_provider_id},
        success : function(data){

          data =  jQuery.parseJSON(data);
          if(data['status'] == 1 ){
            swal(data.message);
            getDetailsView();
          }else{
            App.alert(data.message,"Opss");
          }
        }
      });
    }
    
    function getDetailsView(job_request_id){
        job_request_id = $('#details_id').val();
        csrf_value  =   getCookie('csrf_cookie_name');        
          $("#detailDiv").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/getJobRequestDetails',
            type: 'POST',
            data: {job_request_id:job_request_id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 
				 $("#detailDiv").html(data);
				
                                                                 }
        });
    }
    
    $(document).delegate(".assignJobToStaff","click",function(e){
        assign_job_provider_id = $(this).attr("id");
        $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/getProviderStaffs',
            type: 'POST',
            data: {assign_job_provider_id : assign_job_provider_id},
            dataType: "html",
            success : function(response)
            {
                $('#hid_request_id').val(assign_job_provider_id);
                $('select#staff_id').html(response);
                setTimeout(()=>{
                    $('#staff-assign-modal').modal('show');
                }, 400);
                
            }
          });
        
    });
    
    $('body').on('submit', '#assignStaff', function(e) { 

        e.preventDefault();
        var validation = $.Deferred();
        var $form = $(this);
        var formData = new FormData(this);
        
        $form.validate({
          rules: {
            staff_id: {
                  required: true,
              },                    
          },
          messages: {
            staff_id: {
                  required: 'Please select a staff to assign job request.',
              },                    
          },
          errorElement: 'div',
          errorPlacement: function(error, element) {
              element.addClass('is-invalid');
              error.addClass('invalid-feedback');
              error.insertAfter(element);
          }
        });
        
        if($form.valid())
        {
          validation.resolve();
        }
        else
        {
        var error = $form.find('.is-invalid').eq(0);
        $('html, body').animate({
          scrollTop: (error.offset().top - 10),
        }, 500);
        validation.reject();
        }
        
            validation.done(function() {
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('div.invalid-feedback').remove();
                $form.find('button[type="submit"]').text('Saving...').attr('disabled', true);
                formData.append("assign_job_provider_id",$("#hid_request_id").val());
        
                $.ajax({
                    type:"POST",
                    url: "<?=base_url()?>admin/C_admin/assignStaff",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (data) 
                    {                       
                      if(data.status == 1)
                      {
                        swal(data.message);
                        $("#staff-assign-modal,#myModal").modal("hide");
                        setTimeout(()=>{
                    		listJobRequests();
                    	}, 600);
                      }
                      else if(data.status == 0)
                      {
                        swal(data.message);
                      }
                      else
                      {
                        if ( typeof data.validationErrors !== 'undefined' ) 
                        {                                
                          var error_def = $.Deferred();
                          var error_index = 0;
                          jQuery.each(data.validationErrors, function (e_field, e_message) {
                            if ( e_message != '' ) {
                              $('[name="'+ e_field +'"]').eq(0).addClass('is-invalid');
                              $('<div class="invalid-feedback">'+ e_message +'</div>').insertAfter($('[name="'+ e_field +'"]').eq(0));
                              if ( error_index == 0 ) {
                                error_def.resolve();
                              }
                              error_index++;
                            }
                          });
                          error_def.done(function() {
                            var error = $form.find('.is-invalid').eq(0);
                            $('html, body').animate({scrollTop: (error.offset().top - 10),}, 500);
                          });
                        }else {
                          App.alert(data.message||"faild to sent otp please try agian","Opss");
                        }
                      }
                      $form.find('button[type="submit"]').text('Assign').attr('disabled', false);
                    }
                });
            });
        });
    </script>

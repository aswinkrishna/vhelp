<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  2;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
 $url            =  $_SERVER['REQUEST_URI'];
 $urlArray  =  explode("/",$url);
 $urlArray    =  array_reverse($urlArray);
if (in_array("quotation_list", $urlArray) )
  {
  $labelrequests      =  "Quotation list";
  }
  else if(in_array("request_list", $urlArray))
  {
      $labelrequests      =  "Job requests list";
  } 
  else if (in_array("view_provider_quotations", $urlArray) )
  {
     $labelrequests      =  "Quotation list(Provider)";
  }
  else
  {
      $labelrequests      =  "Job requests list";
  }
?> 
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
 
 <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Mark Provider Response</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="providerResponseDiv">
         Note: <textarea id="providerResponseNote" rows="4" cols="50"></textarea>
         <input type="hidden" id="response_status" value="">
         <input type="hidden" id="job_request_id" value="">
         <input type="hidden" id="provider_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn btn-primary radius button-padd" id="btnSaveResponse">SAVE</button>
      </div>
    </div>

  </div>
</div>
 <!-- Modal -->
  <!-- Modal -->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
     
        <h4 class="modal-title">Mark price</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="providerResponseDiv">
          Enter price in AED: <input type="text" id="price" name="price" class="form-control boxed number" placeholder=" Enter price" maxlength="5">
         
         <input type="hidden" id="job_request_id2" value="">
         <input type="hidden" id="provider_id2" value="">
      </div>
      <div class="modal-body" id="providerResponseDiv">
          Document(pdf/doc/jpeg/jpg/png Max 20 MB): <input type="file" id="priceFile" name="priceFile" class="form-control boxed number" >
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn btn-primary radius button-padd" id="btnSavePrice">SAVE</button>
      </div>
    </div>

  </div>
</div>
 <!-- Modal -->
<script>
   
	

 $(document).ready(function(){
       listJobRequests();
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
    
			     //  alert();
            
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
						url: '<?php echo base_url();?>admin/C_admin/listJobRequestsAjaxProvider',
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
            url:  '<?php echo base_url();?>admin/C_admin/deleteTestimonials',
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
     $(document).delegate(".changeStatus","change",function(e)
    {
            $("#myModal2").modal("show");
        
           response_status     =             $(this).val();
          job_request_id        =            $(this).attr("for");
          provider_id               =            $(this).attr("data-id");
          $("#response_status").val("");
          $("#job_request_id").val("");
          $("#provider_id").val("");
          $("#response_status").val(response_status);
          $("#job_request_id").val(job_request_id);
          $("#provider_id").val(provider_id);
                                            
       
    });  
    $(document).delegate("#btnSaveResponse","click",function(e)
    {
       
        csrf_value                   =   getCookie('csrf_cookie_name');        
          response_status      =        $("#response_status").val();
          job_request_id        =        $("#job_request_id").val();
          provider_id               =        $("#provider_id").val();
          note               =        $("#providerResponseNote").val();
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/setProviderResponse',
            type: 'POST',
            data: {job_request_id:job_request_id,provider_id:provider_id,response_status:response_status,note:note,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			 {
			 if(data==1)
                         {
                             swal("success");
                         }
                         else
                         {
                              swal("failed");
                         }
                         $("#myModal2").modal("hide");
				
                         }	
                  });        
    });
      $(document).delegate(".markPrice","click",function(e)
     {
          $("#myModal3").modal("show");
        
           job_request_id        =            $(this).attr("for");
          provider_id               =            $(this).attr("data-id");
       
          $("#job_request_id2").val("");
          $("#provider_id2").val("");
       
          $("#job_request_id2").val(job_request_id);
          $("#provider_id2").val(provider_id);
    
     });
     
    $(document).delegate("#btnSavePrice","click",function(e)
    {
           var formData = new FormData($("#myformd")[0]);
           csrf_value                   =   getCookie('csrf_cookie_name');        
          price      =        $("#price").val();
          job_request_id        =        $("#job_request_id2").val();
          provider_id               =        $("#provider_id2").val();
          var  file_data = $('#priceFile').get(0).files[0];
          csrf_value     =   getCookie('csrf_cookie_name');        
               formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
               formData.append('job_request_id',job_request_id);
               formData.append('price',price);
               formData.append('provider_id',provider_id);
               formData.append('file_doc',file_data);
          
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/markProviderPrice',
            type: 'POST',
            data:formData ,
            success: function (data) 
	  {
              data =  jQuery.parseJSON(data);
              if(data['status']==1)
                    {
                       
                         swal("Well done!", "Saved Successfully!", "success");
                         $("#myModal3").modal("hide");
                        listJobRequests();      
                    }                 
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                             $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }
                    else if(data['status']<0)
                    {    
                           swal("Sorry!", "Price already marked", "error");
                     }
                    else
                    {
                              
                          swal("Sorry!", "Failed to save! Try again later", "error");


                    }
                        
				
                         },
                          cache: false,
             contentType: false,
             processData: false
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
    </script>

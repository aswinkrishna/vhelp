<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  2;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?> 
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>&nbsp;Audit trail</h1>
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
            <div class="tile-body" >
              <section class="example">
                                            <span style="float: right;">
                                             <input type="text" id="search_key" class="radius select-border" autocomplete="off"  placeholder="search">  &nbsp;&nbsp;     <input type="text" id="txt_sale_datefrom" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="From Date">  &nbsp;&nbsp; <input type="text" id="txt_sale_dateto" class="radius select-border" autocomplete="off" readonly="readonly" placeholder="To Date">&nbsp;&nbsp;<button type="submit" class="btn btn-primary radius button-padd" id="btnSave" onclick="listAuditTrails();"> Apply </button>&nbsp;&nbsp;</span>
                                            <div class="table-responsive" id="listTable">







                   </div>
               </section>
            </div>
          </div>
        </div>
      </div>
    </main>
 <script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script>
   
	

 $(document).ready(function(){
       listAuditTrails();
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
function listAuditTrails()
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
             
              csrf_value  =   getCookie('csrf_cookie_name'); 
                formVal.push({ name: "<?php echo $this->security->get_csrf_token_name();?>", value:csrf_value });
              $("#listTable").html("");
          
          $.ajax( {
						type: 'POST',
						url: '<?php echo base_url();?>admin/C_admin/listAuditTrailsAjax',
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
    
       
    </script>

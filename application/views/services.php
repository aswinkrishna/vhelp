<?php
$cityId = $_GET['c'];
if($cityId>0)
{
  $labelHead = "Services in ".$this->M_common->getCityName($cityId);
}
else if($_GET['s']!="")
{
    $labelHead  = "Search results";
}
else
{
    $labelHead  = "Our Services";
}
//exit;
?>
<!--start banner section-->
<section>
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row how_it_work_banner">
      <h3>
       Services
      </h3>

            <!--start container-->
      <div class="container">
        <div class="row">
       

         </div>
      </div>
      <!--end container-->
    </div>
    <!--end row-->


  </div>
  <!--end container fluid-->
  
</section>
<!--end banner section-->
<!--start section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            <!--start container-->
            <div class="container">
                
                <!--start  row-->
                <div class="row main">
                    <h3><?php echo $labelHead; ?></h3>
                    
                </div>
                <!--end row-->
                <div class="service_search">
                <div class="row">
                  <!--start container-->
                    <div class="search_wrap">
                      <div class="row">
                      <div class="text-filed col-md-10 col-9">
                        <div class="row">
                           <input type="text" id="serviceSearch" name="" placeholder="Search">
                        </div>
                        
                      </div>
                      <div class="search_button col-md-2 col-3">
                        <div class="row">
                        <button id="btnServiceSearch"><img src="https://a2itproducts.com/emirates_quotations/frontend_assets/images/icons/search-btn.png"></button>
                        </div>
                      </div>


                      </div>
                  </div>
                </div>
            </div>

                <!--start row-->
  <div class="row service-wrapp" id="serviceSpan">
      
      
   
                
                
                
<!--start row-->
 <!--start pagination-->
<!--<div class="row">
   
    <div class="col-md-6 col-sm-6 col-12 services-pagination">
<nav aria-label="Page navigation example">
<ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active">
      <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">4</a></li>
    <li class="page-item"><a class="page-link" href="#">5</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
    </div>
    
</div>-->

<!--end pagination-->
<!--end row-->
                
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->
<script>
$(document).ready(function(){
  loadServices();
});


     function loadServices()
                          {
                                 // alert();
                                 
                                        search_key  = "<?php echo $_GET['s'] ; ?>";
                                        city_id ="<?php echo $_GET['c'] ; ?>";
                                        //alert(search_key);
                                 search_key = $("#serviceSearch").val()!=""?$("#serviceSearch").val():search_key;
                                     // var keyword  = $("#jobOrder").val();
                                     
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>Welcome/servicesList',
                                        type: 'POST',
                                        data: {search_key:search_key,city_id:city_id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			         //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#serviceSpan").html(data);
                                                // initMap();
                                         }
                                    });
                          }
                $("#serviceSpan").on("click", ".pagination a", function (e) 
            {
                         e.preventDefault();
                         search_key  = "<?php echo $_GET['s'] ; ?>";
                         city_id ="<?php echo $_GET['c'] ; ?>";
                         
                         search_key = $("#serviceSearch").val()!=""?$("#serviceSearch").val():search_key;
                                      
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {search_key:search_key,city_id:city_id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			      //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#serviceSpan").html(data);
                                                // initMap();
                                         }
                                    });
                         
                         
            });
            
      $(document).delegate("#serviceSearch","keyup",function(event)
    {
        
      loadServices();
     
	});  
	  $(document).delegate("#btnServiceSearch","click",function(event)
    {
        
      loadServices();
     
	}); 
	
</script>













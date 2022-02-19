<style>
    .select2
    {
        width:470px !important;
    }
     #gmap {
    width: 100% !important;
  
    overflow: hidden;
    height:300px !important;
  }
</style>
<?php
//print_r($service_type);
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Send Request</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                    // $label = "registration";
//                      if($id>0)
//                      {
//                            $label = "Updation";
//                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Send Request <?php  echo $label; ?></h3>
         
                   
               
                   
                        <div class="form-errors error"></div>
                                 
                                
           
            
            
   <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#serviceType" role="tab" aria-controls="home" aria-selected="true">Service type</a>
  </li>
 
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#needs" role="tab" aria-controls="profile" aria-selected="false">Your needs</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="add-info-tab" data-toggle="tab" href="#addInfo" role="tab" aria-controls="home" aria-selected="true">Additional info</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#location" role="tab" aria-controls="contact" aria-selected="false">Location</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#option" role="tab" aria-controls="contact" aria-selected="false">Quotation/select provider</a>
  </li>
</ul>
    <div class="tile-body">
                <form name="item"  id="userForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                         $row     =        $user_basic[0];
                        $row2    =        $user_details[0];
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_user_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
<div class="tab-content" id="myTabContent">
    <br>
  <div class="tab-pane fade show active" id="serviceType" role="tabpanel" aria-labelledby="home-tab">
     <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Select service type</label>
                                <select class="form-control"  id="select_service_type"  name="select_service_type">
                                    <option value="">Select</option>
                                    <?php
                                    if(count($service_type)>0)
                                    {
                                        foreach($service_type as $rows)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows->service_type_id ?>" data-id="<?php  echo $rows->is_home_category ?>"><?php  echo $rows->service_type_name ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                                <input id="is_home" type="hidden" name="is_home">
                                 </div> 
                        </div>
                         <div class="col-md-6">
                                &nbsp;
                        </div>
                   </div>
  </div>
  <div class="tab-pane fade" id="addInfo" role="tabpanel" aria-labelledby="profile-tab">
       
    <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label">Select time</label>
                    <textarea class="form-control boxed" name="txt_additional_info"></textarea>
                    </div> 
             </div>
             <div class="col-md-6">
                    &nbsp;
             </div>
             </div>
             <div class="row" id="dynamicFileUpload">
             
                 <div class="col-md-5">
                    <div class="form-group">
                    <label class="control-label">Upload files</label>
                    <input type="file" name="txt_doc[]"  class="form-control boxed additionalFiles">
                    </div> 
                </div>
                <div class="col-md-1">
                                 <div class="form-group">
                                <label class="control-label"></label>
                                  <a class="btn btn-primary  addFiles" href="javascript:void(0)" title="add files" for="20190629165202" id="btnAddFiles"><i class="fa fa-lg fa-plus"></i></a>
                                 </div> 
                </div>
             
           </div>
       
  </div>
  <div class="tab-pane fade" id="needs" role="tabpanel" aria-labelledby="profile-tab">
       
      <br>
                              <div class="row" id="dynamicQuestionDiv">
                     
                                </div>
       
  </div>
  <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="contact-tab">
      <br>
       <div class="row">
                     <div class="col-md-6 addressTypeTab">
                                 <div class="form-group">
                                <label class="control-label">Address type</label>
                                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" name="address_type" type="radio" value="1" data-error="#errNm1">Home
                    </label>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <label class="form-check-label">
                      <input class="form-check-input" name="address_type" type="radio" value="2" data-error="#errNm1">Work
                    </label>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <label class="form-check-label">
                      <input class="form-check-input" name="address_type" type="radio" value="3" data-error="#errNm1">Other
                    </label>
                                      <span id="errNm1"></span>
                  </div>
                                 </div> 
                        </div>
                          <div class="col-md-4 locationTab">
                                 <div class="form-group">
                                <label class="control-label">Location</label>
                                  <input type="text" class="form-control boxed autocomplete" placeholder="" name="txt_location" id="txt_location" value="" maxlength="100" autocomplete="off">
                              <input type="hidden" id="txt_longitude" name="txt_longitude" value="">
                                <input type="hidden" id="txt_lattitude" name="txt_lattitude" value="">
                                 </div> 
                        </div>
                        <div class="col-md-2 locationTab">
                                 <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                  <i class="fa fa-map-marker" aria-hidden="true" id="btnMap"></i>
                                 </div> 
                        </div>
                        <div class="col-md-4 locationTab">
                                               <label class="control-label">City</label>
                                                <input class="form-control" id="us5-city" name="us5-city" >
                                            </div>
                                            <div class="col-md-4 locationTab">
                                                <label class="control-label">State</label>
                                                <input class="form-control" id="us5-state" name="us5-state"  >
                                            </div>
                     </div>
       <div class="row">
                                         <div class="col-md-3 jobDatetab">
                   <div class="form-group">
                                <label class="control-label">Select date</label>
                                <input type="text" class="form-control boxed " placeholder="" name="txt_date" id="txt_date" value=""  autocomplete="off">
                                 </div> 
                                         </div>
                                     <div class="col-md-3 jobDatetab">
                   <div class="form-group">
                                <label class="control-label">Select time</label>
                                <input type="text" class="form-control boxed " placeholder="" name="txtTime" id="txtTime" value=""  autocomplete="off">
                                 </div> 
                                         </div>
                               
                         <div class="col-md-3 priceTab">
                             <div class="form-group">
                                <label class="control-label">Price range from</label>
                               <select class="form-control"  id="select_price_from"  name="select_price_from">
                                    <option value="">Select</option>
                                    <?php
                                  $i=0;
                                        for($i=0;$i<10000;$i=$i+1000)
                                        {
                                    ?>
                                            <option value="<?php  echo $i ?>" ><?php  echo "AED ".$i ?></option>
                                    <?php
                                        }
                                   
                                    ?>
                                    
                                </select>
                                 </div> 
                        </div>
                                    <div class="col-md-3 priceTab">
                             <div class="form-group">
                                <label class="control-label">Price range to</label>
                                <select class="form-control"  id="select_price_to"  name="select_price_to">
                                    <option value="">Select</option>
                                    <?php
                                  $i=0;
                                        for($i=0;$i<10000;$i=$i+1000)
                                        {
                                    ?>
                                            <option value="<?php  echo $i ?>" ><?php  echo "AED ".$i ?></option>
                                    <?php
                                        }
                                   
                                    ?>
                                    
                                </select>
                                 </div> 
                        </div>
                                  </div>
      
                                  <div class="row">
                                         <div class="col-md-3">
                   <div class="form-group">
                                <label class="control-label">Validty date</label>
                                <input type="text" class="form-control boxed " placeholder="" name="txt_valid_date" id="txt_valid_date" value=""  autocomplete="off">
                                 </div> 
                                         </div>
                                     <div class="col-md-3">
                   <div class="form-group">
                                <label class="control-label">Validity time</label>
                                <input type="text" class="form-control boxed " placeholder="" name="txtValidTime" id="txtValidTime" value=""  autocomplete="off">
                                 </div> 
                                         </div>
                                  </div>
     
  </div>
<div class="tab-pane fade" id="option" role="tabpanel" aria-labelledby="contact-tab">
    <div class="row">
                                         <div class="col-md-6">
                   <div class="form-group">
                                <label class="control-label">Select option</label>
                                <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input select_option" name="select_option" type="radio" value="1" data-error="#errNm2">Receive quotation
                    </label>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <label class="form-check-label">
                      <input class="form-check-input select_option" name="select_option" type="radio" value="2" data-error="#errNm2">Contact service provider
                    </label>
                                      <span id="errNm2"></span>
                                    
                  </div>
                                 </div> 
                                         </div>
                             
                            </div>
                                <div class="row" id="selectServiceProvider">
                                    
                                </div>
</div>
</div>
            
         </form>
            </div>      
            
            
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            <span id="registerLoader"></span>
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
     
        <h4 class="modal-title">Map</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="gmap">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 <!-- Modal -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&libraries=places&sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url()?>admin_assets/js/plugins/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>       
    loadMultiSelect();
function initialize2() {
        
      //  alert();

    var acInputs = document.getElementsByClassName("autocomplete");

    for (var i = 0; i < acInputs.length; i++) {
		j=i+1;
		

        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
        autocomplete.inputId = acInputs[i].id;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
			
           // document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
			var place = autocomplete.getPlace();
			//alert(place.name+place.geometry.location.lat()+place.geometry.location.lng());
			
			document.getElementById("txt_longitude").value=place.geometry.location.lng();
			document.getElementById("txt_lattitude").value=place.geometry.location.lat();
            $('#us5-city').val(place.address_components[1].long_name);
            $('#us5-state').val(place.address_components[2].long_name);         
           
        });
    }
}
initialize2();
  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#userForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
       // alert();
        $("#userForm")[0].reset();
    });

       var validator=$("#userForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          select_service_type: 
          {
            required: true
            
          },
          address_type: 
          {
            required:  function(element){
            return $("#is_home").val()==0;
        }
          }, 
            txt_location: 
          {
            required:  function(element){
            return $("#is_home").val()==1;
        },
           maxlength:2000
          },  
              txt_date: 
          {
            required:  function(element){
            return $("#is_home").val()==0;
        }
          },
           txtTime: 
          {
            required:  function(element){
            return $("#is_home").val()==0;
        }
          },   
            
         select_price_from: 
          {
            required:  function(element){
            return $("#is_home").val()==0;
        }
          },
         select_price_to: 
          {
              required:  function(element){
            return $("#is_home").val()==0;
        }
          },
        'txt_valid_date': 
          {
            required: true
          },
         'txtValidTime': 
          {
            required: true
          },
          select_option:
                  {
                      required: true
                  },
          'question[]':
                  {
                      required: true
                  },
                  txt_additional_info:
                  {
                       required: true
                  }
          
		  
        },
        messages: 
        {
       
    },
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
        $(".form-errors").html("All fields must be completed before you submit the form.");
    },
//     showErrors: function(errorMap, errorList) {
//        $(".form-errors").html("All fields must be completed before you submit the form.");
//    },
     submitHandler: function ()
        {
			
                $(".errorSpan1").html("");	               
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                $(".errorSpan1").html();
                dataString = $('#userForm').serialize();
                var formData = new FormData($("#userForm")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveRequest',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                     $("#registerLoader").html("");
                     $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    
                    if(data['status']==1)
                    {
                       
                          swal("Well done!", "Saved Successfully!", "success");
                           $("#userForm")[0].reset();
                       //   window.location="<?php echo base_url(); ?>admin/job_request_report";
                              
                    }
                    else if(data['status']==3)
                    {
                             swal("Sorry!", "Email id already exists", "error");
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                              swal("validation error");
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                             $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


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

                     return false;
      
        
                }
       
 });  
 $(document).delegate("#select_service_type","change",function(e)
    {
	     // $("#userForm")[0].reset();
         $(".select_option").prop('checked', false);
         $("#selectServiceProvider").html("");
          var selected = $(this).find('option:selected');
         var is_home = selected.data('id'); 
        // is_home   = $(this).attr("data-id");
        // alert(is_home);
         $("#is_home").val(is_home);
         if(is_home==0)
         {
             $(".addressTypeTab").css("display","block");
             $(".jobDatetab").css("display","block");
             $(".priceTab").css("display","block");
             $(".locationTab").css("display","none");
         }
         else
         {
              $(".addressTypeTab").css("display","none");
              $(".jobDatetab").css("display","none");
              $(".priceTab").css("display","none");
              $(".locationTab").css("display","block");
         }
         
         csrf_value  =   getCookie('csrf_cookie_name');        
          $("#dynamicQuestionDiv").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/getDynamicQuestions',
            type: 'POST',
            data: {select_service_type:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			 
				 $("#dynamicQuestionDiv").html(data);
				loadMultiSelect();
                                                                 }
        });
		  
    });
    $("#txt_profile").change(function() {
  readURL(this,'imagePreview');
});
 $("#txt_doc").change(function() {
  readURL(this,'imagePreview2');
});
function loadMultiSelect()
{
$('.demoSelect').select2();
}

$(document).ready(function(){
   
    $("#txt_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                  minDate: 0
               
            });
              $("#txt_valid_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear:true,
                minDate: 0
               
            });
            
            $('#txtTime').timepicker();
            $('#txtValidTime').timepicker();
			    });
               $(document).delegate("#select_price_from","change",function(e)
    {
	
     
         csrf_value  =   getCookie('csrf_cookie_name');        
          $("#select_price_to").html("");
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/dynamicToPrice',
            type: 'POST',
            data: {currentValue:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			 
				 $("#select_price_to").html(data);
				loadMultiSelect();
                                                                 }
        });
		  
    });             
       $(document).delegate(".select_option","click",function(e)
    {
	
     
          csrf_value  =    getCookie('csrf_cookie_name');        
          checkval     =    $(this).val();         
           $("#selectServiceProvider").html("");
           var serviceType = $("#select_service_type").val();
         
          if(checkval==2)
          {
              if(serviceType<=0)
              {
                  swal("select service type");
                  return false;
              }
         

                                $.ajax({
                                  url: '<?php echo base_url();?>admin/C_admin/getProviderMultiSelect',
                                  type: 'POST',
                                  data: {currentValue:$(this).val(),serviceType:serviceType,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                  success: function (data) 
                                              {

                                                       $("#selectServiceProvider").html(data);
                                                      loadMultiSelect();
                                                 }
                              });
          }	  
    });                          
var map;
        function initialize() {
            var myLatlng = new google.maps.LatLng(25.204849,55.270782);
            var myOptions = {
                zoom:7,
                center: myLatlng,
               
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("gmap"), myOptions);
            var geocoder = new google.maps.Geocoder()
            // marker refers to a global variable
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                 draggable: true,
            });

            google.maps.event.addListener(map, "click", function(event) {
                // get lat/lon of click
                var clickLat = event.latLng.lat();
                var clickLon = event.latLng.lng();
                //locationname ="";
               // alert(event.latLng);
               // alert(clickLat);
                //alert(clickLon);
                // show in input box
//                document.getElementById("lat").value = clickLat.toFixed(5);
//                document.getElementById("lon").value = clickLon.toFixed(5);
//
//                  var marker = new google.maps.Marker({
//                        position: new google.maps.LatLng(clickLat,clickLon),
//                        map: map
//                     });
                     geocoder.geocode({
    'latLng': event.latLng
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
      //  alert(results[0].formatted_address);
        locationname =results[0].formatted_address;
       // alert(locationname);
        document.getElementById("txt_location").value = locationname;
      }
    }
  });      
             
             document.getElementById("txt_lattitude").value = clickLat;
             document.getElementById("txt_longitude").value = clickLon;
  
            });
            google.maps.event.addListener(marker, 'drag', function(evt){
       //alert("marker is being dragged");
    });  
    }   

    window.onload = function () { initialize() };
      $(document).delegate("#btnMap","click",function(e)
    {
                   $("#myModal").modal("show");
    });
    
   $(document).ready(function() {
    

     
        $('#userForm').on('submit', function(event) {

            // adding rules for inputs with class 'comment'
            $('.dynamicQues').each(function() {
                $(this).rules("add", 
                    {
                        required: true
                    })
            });            

            // prevent default submit action         
            event.preventDefault();

            // test if form is valid 
            if($('#userForm').validate().form()) {
                console.log("validates");
            } else {
                console.log("does not validate");
            }
        })

        // set handler for addInput button click
     

   });
     $(document).delegate(".dynamicQues","change",function(e)
    {
	
     
          csrf_value  =    getCookie('csrf_cookie_name');        
          answerOption     =    $(this).val();    
          questionId          =    $(this).attr("for");   
          
           $.ajax({
                                  url: '<?php echo base_url();?>admin/C_admin/getSubQuestions',
                                  type: 'POST',
                                  data: {answerOption:answerOption,questionId:questionId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                  success: function (data) 
                                                {         //  $("").insertAfter( $( "#dyanmicDiv"+questionId ) );
                                                          //  $(data).insertAfter( $( "#dyanmicDiv"+questionId ) );
                                                          $("#dyanmicSpan"+questionId).html(data);
                                                 }
                              });
         /*  $("#selectServiceProvider").html("");
           var serviceType = $("#select_service_type").val();
         
              if(serviceType<=0)
              {
                  swal("select service type");
                  return false;
              }
         

                                $.ajax({
                                  url: '<?php echo base_url();?>admin/C_admin/getProviderMultiSelect',
                                  type: 'POST',
                                  data: {currentValue:$(this).val(),serviceType:serviceType,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                  success: function (data) 
                                              {

                                                       $("#selectServiceProvider").html(data);
                                                      loadMultiSelect();
                                                 }
                              });*/
      	  
    });          
   
     $(document).delegate(".addFiles","click",function(e)
    {
      // alert($(".additionalFiles").length) ;
       var fileLength= $(".additionalFiles").length;
       if(fileLength<=4)
       {
        var dt = new Date();
       var  currentRow  = dt.getHours() + "" + dt.getMinutes() + "" + dt.getSeconds()+""+dt.getMilliseconds();
                 var html ="";
                 html+='<div class="col-md-5 '+currentRow+'">';
                    html+=' <div class="form-group">';
                   html+='  <label class="control-label">Upload files</label>';
                    html+=' <input type="file" name="txt_doc[]"  class="form-control boxed additionalFiles">';
                   html+='  </div> ';
                html+=' </div>';
                html+=' <div class="col-md-1  '+currentRow+'">';
                                 html+=' <div class="form-group">';
                               // html+=' <label class="control-label"></label>';
                            html+='  <a class="btn btn-primary  removeFiles" href="javascript:void(0)" title="remove files" for="'+currentRow+'" ><i class="fa fa-lg fa-minus"></i></a>';
                               html+='   </div> ';
                html+=' </div>';
                $("#dynamicFileUpload").append(html);
       }
    });
      $(document).delegate(".removeFiles","click",function(e)
    {
        className = $(this).attr("for");
         $("."+className).remove();
    });

 </script>



<style>

.default-address .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  float:right;
}

.default-address .switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.default:checked + .slider {
  background-color: #444;
}

input.success:checked + .slider {
  background-color: #299a06;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
<?php
    
    if($address_details){
        $first_name  =  $address_details->first_name;
        $last_name   =   $address_details->last_name;
        $email       =   $address_details->email;
        $country_id  =   $address_details->user_adresses_country;
        $user_phone  =   $address_details->user_phone;
        $btnName     = "Update";
    }else{
        
        // $user_id  = $this->session->userdata('eq_user_id');
        // $user_details = $this->M_user->getUserDetailsById($user_id);
        
        $first_name  =  $user_details->user_first_name;
        $last_name   =  $user_details->user_last_name;
        $email       =  $user_details->user_email;
        $country_id  =  $user_details->country_id;
        $user_phone =  $user_details->user_phone; 
        $btnName     = "Create";
    }
    
    if($country_id > 0 )
      $city_list = $this->M_request->getCityListByCountryId($country_id);
    
?>


<div class="container-fluid">
    <div class="row">
   <div class="col-lg-6">
                     <div class="form-group">
                             <label>Address Type</label>
                            <div class="custom-control d-flex p-0">
              <label for="home_address">
                <input class="select_radiobtn" type="radio" <?=($address_details->user_adresses_type_id == 1)?"checked":''?> name="address_type" id="home_address" value="1" checked="checked">Home &nbsp; &nbsp; &nbsp; </label>
              <label for="office_address">
                <input class="select_radiobtn" type="radio" <?=($address_details->user_adresses_type_id == 2)?"checked":''?> value="2" id="office_address" name="address_type">Office &nbsp;</label>
                
                <!--<label for="other">-->
                <!--<input class="select_radiobtn" type="radio" id="other" name="address_type" <?=($address_details->user_adresses_type_id == 3)?"checked":''?> value="3">Other &nbsp;</label>-->
            </div>
                         </div>

                          <div class="location_wrap">
                       <div class="form-group">
                            <!--<label for="exampleFormControlInput1" id="addressTypeLabel" style="color:#0e688d"><i class="far fa-check-circle"></i> Home</label>-->
                            <input type="text" class="form-control" id="pickup-input2" name="pickup-input2" placeholder="Enter your location" value="<?php echo $address_details->user_adresses_location ?>">
                            <input type="hidden" class="form-control" id="pickup-lattitude2" name="pickup-lattitude2" value="<?php echo $address_details->user_adresses_lattitude ?>">
                            <input type="hidden" class="form-control" id="pickup-longittude2" name="pickup-longittude2" placeholder="Type Your Location" value="<?php echo $address_details->user_adresses_longitude ?>">
                            <input type="hidden" class="form-control" id="selected_address_type" name="selected_address_type"  value="1">
                          </div>
                          
                        <div id="map2" style="height: 250px;"></div>
                      
                     </div>
    
    </div>
        <div class="col-lg-6">
        
                  <div class="row">
                      
                       <div class="col-md-6">
                             <input type="hidden" value="<?php echo $address_details->user_adresses_id?>" name="address_id" id="address_id">
                    <div class="form-group">
                             <label>First Name</label>
                             <input class="form-control" placeholder="First Name" name="first_name" id="first_name" value="<?=$first_name?>">
                         </div>
                         
               </div>
            
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Last Name</label>
                             <input class="form-control" placeholder="Last Name" name="last_name" value="<?=$last_name?>">
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Email Address</label>
                             <input class="form-control" placeholder="Email addresss" name ="email" value="<?=$email?>" >
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Mobile Number</label>
                           <div class="form-group nuber-text">
                               <select class="form-control" id="dial_code" name="dial_code" style="width:40%;float: left; padding: 0 12px">
                                   <option value=""></option>
                                   <?php
                                        foreach ($country_list as $key => $value) {
                                            if($value->country_id == $country_id)
                                                $selected = "selected";
                                            else
                                                $selected = "";
                                   ?>
                                        <option value="+<?=$value->country_dial_code?>" <?=$selected?> >+<?=$value->country_dial_code?></option>
                                   <?php
                                        }
                                   ?>
                               </select>
                                 <!--<input type="text" class="form-control" id="dial_code" name="dial_code" style="width:30%;float: left; padding: 0 12px" readonly value="<?=$address_details->dial_code?>" >-->
             
              <input type="number" class="form-control" placeholder="Mobile Phone" id="user_phone" name="user_phone" style="width:60%;" value="<?=$user_phone?>" >
            </div>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Country</label>
                             <select class="form-control" name="country" id="country">
                                <option value="">Choose country...</option>
                            <?php
                                foreach ($country_list as $key => $value) {
                                    if($value->country_id == $country_id)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                            ?>
                             <option value="<?=$value->country_id?>" for="<?=$value->country_dial_code?>" <?=$selected?>><?=$value->country_name?></option>
                            <?php
                                }
                            ?>
                         </select>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>City</label>
                         <select class="form-control" name="city" id="city">
                             <option value="" >Choose City</option>
                            <?php
                                foreach($city_list as $key=>$value){
                                    if($value->city_id == $address_details->city_id)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                            ?>
                                <option value="<?=$value->city_id?>" <?=$selected?>><?=$value->city_name?></option>
                            <?php
                                }
                            ?>
                         </select>
                         </div>
               </div>
               
               <div class="col-md-12">
                    <div class="form-group">
                             <label>Area</label>
                         <select class="form-control" name="area" id="area">
                             <?php
                                if($address_details->area_id > 0 ){
                             ?>
                                <option value="<?=$address_details->area_id?>"><?=$address_details->area_name?></option>
                            <?php
                                }else{
                            ?>
                                <option value="">Choose City...</option>
                            <?php
                                }
                            ?>
                         </select>
                         </div>
               </div>
               
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Building Name /No ,Floor , Apartment </label>
                        <input class="form-control" placeholder="" value="<?=$address_details->building_name?>" name="building_name" city="building_name">         
                    </div>
               </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Street Name</label>
                        <input class="form-control" name="street_name" id="street_name" value="<?=$address_details->street_name?>" placeholder="">
                    </div>
               </div>
               
               <div class="col-md-6">
                    <div class="form-group">
                        <label>Nearest Landmark</label>
                        <input class="form-control" name="land_mark" id="land_mark" value="<?=$address_details->land_mark?>" placeholder="">
                    </div>
               </div>
             
                    <div class="col-md-12">
                       <div class="form-group">
                          <div class="default-address">
                             Set As Default Address
                             <label class="switch ">
                             <input type="checkbox" name="defalut_address" id="defalut_address" <?=$address_details->default_address?'checked':''?> class="success">
                             <span class="slider round"></span>
                             </label>
                          </div>
                       </div>
                    </div>
               
           
                  </div>
              </div> 
    
    
               <div class="col-md-12 text-center">
                    <input type="submit"  class="btn btn-primary mt-2" value="<?=$btnName?>" id="addressSaveBtn">
               </div>
</div>
</div>

<script>

    
    
    var map;
      function initialize() {

    //var acInputs = document.getElementsByClassName("autocomplete");
    
    var input = document.getElementById('us5-street1');
    
   // alert(acInputs.length);
    
     var autocomplete = new google.maps.places.Autocomplete(input);
       // autocomplete.inputId = acInputs[i].id;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
           // alert();
            
           // document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
            var place = autocomplete.getPlace();
            
             //console.log(place);
             
              
                $('#us5-city').val("Dubai");
                $('#us5-state').val("Dubai");
                $('#us2-lat').val(25.204849);
                $('#us2-lon').val(55.270782);
                
             /*  var myLatlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
        marker = new google.maps.Marker({
            position: myLatlng,
            map: MAP1,
            title: ""
        }); 
                
                */
                
        //  alert(place.name+place.geometry.location.lat()+place.geometry.location.lng());
            
        });

   /* for (var i = 0; i < acInputs.length; i++) {
        j=i+1;
        

        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
        autocomplete.inputId = acInputs[i].id;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            
           // document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
            var place = autocomplete.getPlace();
            //alert(place.name+place.geometry.location.lat()+place.geometry.location.lng());
            
            document.getElementById("longi"+j).value=place.geometry.location.lng();
            document.getElementById("latti"+j).value=place.geometry.location.lat();
           
        });
    }*/
    var homeLat = '<?=($address_details->user_adresses_lattitude)?$address_details->user_adresses_lattitude:'25.0711436'?>';
       homeLong = '<?=($address_details->user_adresses_longitude)?$address_details->user_adresses_longitude:'55.2440753'?>';
     
         var iconBase = '<?php echo base_url();?>frontend_assets/images/icons/map-pin.png';
        latlng  = new google.maps.LatLng(homeLat, homeLong);
     map2 = new google.maps.Map(document.getElementById('map2'), {
                              center: new google.maps.LatLng(homeLat, homeLong),           
            zoom: 15,           
            disableDefaultUI: true,
            scaleControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP  
                            });  
                             marker2 = new google.maps.Marker({
            position: latlng,
            map: map2,
            draggable: true,
            animation: google.maps.Animation.DROP,
            icon: iconBase
         }); 
         infowindow = null;
        var input2 = document.getElementById('pickup-input2'); 
         var autocomplete2 = new google.maps.places.Autocomplete(input2, {
        types: ["geocode"]
    });  
    autocomplete2.bindTo('bounds', map2);
      google.maps.event.addListener(autocomplete2, 'place_changed', function() {
        //  alert();
        //infowindow.close();
        var place = autocomplete2.getPlace();
         if (place.geometry.viewport) {
            map2.fitBounds(place.geometry.viewport);
        } else {
            map2.setCenter(place.geometry.location);
            map2.setZoom(17);
        }
         latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
        //moveMarker(place.name, place.geometry.location);
        moveMarker(marker2, latlng);
        document.getElementById("pickup-longittude2").value=place.geometry.location.lng();
        document.getElementById("pickup-lattitude2").value=place.geometry.location.lat();
        
    }); 
     google.maps.event.addListener(marker2, 'dragend', function() {
          //alert();
         // var infowindow = new google.maps.InfoWindow(); 
    var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'latLng': marker2.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#pickup-input2').val(results[0].formatted_address);
                   $('#pickup-lattitude2').val(marker2.getPosition().lat());
                    $('#pickup-longittude2').val(marker2.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map2, marker);
                    infoWindow.close();
                    map.setCenter(marker2.getPosition());
                    ShowNext();
                }
            }
        });
    });
         
}
 function moveMarker(markerName, latlng) 
            {
                infowindow = null;
        markerName.setIcon(null);
        markerName.setPosition(latlng);
       // infowindow.setContent(placeName);
    }
initialize();
</script>

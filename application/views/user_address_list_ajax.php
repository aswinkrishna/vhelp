<?php
    if($address_list){
    foreach($address_list as $value){
?>
    <div class="col-md-12 col-sm-12">
        <div class="card-address">
              <div class="content-area">
                 <img class="icon" src="<?php echo base_url();?>frontend_assets/images/location-pin.png" alt="">
                 <p>
                    <b><?=$value->first_name.' '.$value->last_name?></b><br>
                    <?=$value->email?><br>
                    (<?=$value->dial_code?>) <?=$value->user_phone?><br>
                    <?=$value->user_adresses_location?><br>
                    <?=$value->country_name?><br>
                 </p>
              </div>
             <div class="adress-action">
                  <a class="editAddress" for="<?=$value->user_adresses_id?>" ><i class="fa fa-pencil-square-o" for="<?=$value->user_adresses_id?>" ></i>Edit</a>
                  <a class="removeAddress" for="<?=$value->user_adresses_id?>"><i class="fa fa-trash-o" for="<?=$value->user_adresses_id?>" ></i>Delete</a>
              </div>
           </div>
        </div>
        
<?php
    }
    }else{
?>
        <p style="text-align:center;">No Address found</p>
<?php
    }
?>
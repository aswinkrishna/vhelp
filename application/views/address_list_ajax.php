<?php
    // print_r($address_list);
    if($address_list){
    foreach($address_list as $value){
?>
    <div>
        

        <label class="container-selection">
        <input type="radio" name="address" value="<?=$value->user_adresses_id?>" for="<?=$value->user_adresses_type_id?>" <?=$value->default_address?'checked':''?> >
        <address>
            <?php
            $type = "";
            if($value->user_adresses_type_id == 1 ){
                $type = "Home";
            }else if($value->user_adresses_type_id == 2 ){
                $type = "Office";
            }
        ?>
        <h6><?=$type?></h6>
        
            <p><strong><?=$value->first_name.' '.$value->last_name?></strong></p>
            <p><?=$value->user_adresses_location?></p>
            <p>Mobile: (<?=$value->dial_code?>) <?=$value->user_phone?></p>
        </address>
        
        <div class="action-address-book">
           
                  <div class="check-btn sqr-btn"><i class="fa fa-edit" for="<?=$value->user_adresses_id?>"></i></div>
            <div class="check-btn sqr-btn "><i class="fa fa-trash" for="<?=$value->user_adresses_id?>"></i></div>
         
        
             
             
        </div>
         <span class="checkmark"></span>
      
        </label>
    </div>
<?php
    }
    }else{
?>
        <p style="text-align:center;">No Address found</p>
<?php
    }
?>
<?php
if(count($result)>0)
{
    foreach($result as $rows)
{
        
    $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/logo.png";       
?>
<div class="col-lg-6 col-md-12">
                                 <div class="provider"> 
                                     <div class="row">
                                         <div class="col-md-4 providerDetails" for="<?php echo $rows->user_id;?>">
                                             <div class="pro_image">
                                                 <img src="<?php echo $profileImage;?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-8 pl-0">
                                             <h4  class="providerDetails" for="<?php echo $rows->user_id;?>"><?php  echo $rows->company_name; ?></h4>
                                             <div class="star_rate">
                                                 <div id="rateYo" class="rateYoLoop2" data-rating='<?php  echo $rows->rating>0?$rows->rating:0; ?> '></div>
                                                 <span>( <?php  echo $rows->rating>0?$rows->rating:0; ?> )</span>
                                             </div>
                                             <div class="bottom_tool">
                                                 <div class="offer" style="visibility:hidden">
                                                     <span>50% OFF</span>
                                                 </div>
                                                 <div class="distance" style="visibility:hidden">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                     <span><?php  echo round($rows->distance,1); ?> KM</span>
                                                 </div>
                                                 <div class="action providerSelectDiv">
                                                     <button type="button" class="select_button" id="btn<?php echo $rows->user_id;?>" for="<?php echo $rows->user_id;?>">Select</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

<?php
  }
}
else
{
    echo "No results found";
}
?>
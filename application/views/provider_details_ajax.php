<?php
//print_r($basic_details);
$profileImage          =   $basic_details->user_image!=""?base_url()."uploads/user/".$basic_details->user_image:base_url()."images/logo.png";    
$provider_id           =   $basic_details->user_id; 

$elgibleForRating =0;

if($this->session->userdata('eq_user_type')==1 && $provider_id>0)
{
    
 $alreadyConfirmed =   $this->M_request->checkAlreadyConfirmedJob($provider_id) ;
 
 if($alreadyConfirmed>0)
 {
    $elgibleForRating =1; 
 }
    
}
else
{
    $elgibleForRating =0;
}




?>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Company Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="provider">
                                     <div class="row">
                                         <div class="col-md-3">
                                             <div class="pro_image">
                                                 <img src="<?php echo $profileImage;?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-7 pl-0">
                                             <h4  data-toggle="modal" data-target="#exampleModalCenter"><?php  echo $basic_details->company_name; ?></h4>
                                             <div class="star_rate">
                                                 <div id="rateYo" class="rateYo"></div>
                                                 <div>
                                                     <span><?php echo $basic_details->rating;?> / 5</span>
                                                     <span><?php echo count($ratings);?>  Reviews</span>
                                                 </div>
                                             </div>
                                             <div class="action mt-3" style="visibility:hidden">
                                                 <a href="#" class="shoWMob">Show Phone Number
                                                 </a>
                                                 <span style="display: none" class="phone">+<?php  echo $basic_details->user_dial_code; ?> <?php  echo $basic_details->user_phone; ?></span>
                                                 <a href="#" target="_blank">Visit Website</a>
                                             </div>
                                         </div>
                                         <div class="col-md-2 pl-0" style="display:none">
                                                 <div class="action">
                                                     <button type="button" id="select_button_detail" for="<?php echo $basic_details->user_id ?>">Select</button>
                                                 </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="about">
                                     <h3>About <?php if($basic_details->profile_document!=""){ ?>(<a target="_blank" href="<?php echo base_url()?>uploads/user/<?php echo $basic_details->profile_document; ?>">View profile</a>) <?php } ?></h3>
                                     <p><b><i class="fas fa-building"></i> Established</b>  2013 <b><i class="fas fa-user"></i> Contact Person</b> <?php  echo $basic_details->user_first_name; ?> <?php  echo $basic_details->user_last_name; ?></p>
                                     <p><b><i class="fas fa-map-marker-alt"></i> Location</b>
                                   <?php  echo $basic_details->location; ?></p> 
                                     <p><b>Services Offered :</b> <?php 
                                     
                                          $data =$services->array_agg;
                                $data=str_replace('{',"",$data);
                                 $data=str_replace('}',"",$data);
                                $data=str_replace('"',"",$data);
                                  echo $data;
                                   //  echo $services->array_agg ;
                                     
                                     ?></p>
                                 </div>
                                 <?php if($option==1 && $elgibleForRating==1){ ?>
                                 <div class="rate_this">
                                     <h3>Post your ratings and reviews</h3>
                                     <div id="rateYo1" class="rateYo1"></div>
                                          <span class="error" id="error_txt_rating"></span>
                                     <form id="rating_form" method="post">
                                     <div class="form-group">
                                        <textarea class="form-control" placeholder="Write a Review..." name="txt_feedback" id="txt_feedback"></textarea>
                                        <span class="error" id="error_txt_feedback"></span>
                                        <input type="hidden" name="txt_provider" id="txt_provider" value="<?php echo $basic_details->user_id ?>">
                                     </div>
                                     </form>
                                     <div class="action">
                                        <button type="button" id="btnAddRating">Submit</button>
                                        <div class="clearfix"></div>
                                     </div>
                                 </div>
                                 
                                 <?php } ?>
                                 <div class="reviews">
                                     <h3>Review (<?php echo count($ratings);?> )</h3>
                                     
                                     <?php
                                     foreach($ratings as $rows)
                                     {
                                     ?>
                                     <div class="review_item">
                                         <div class="user_activity">
                                             <div class="user">
                                                 <span><?php  echo $rows->user_first_name; ?> <?php  echo $rows->user_last_name; ?></span>
                                                 <div class="star">
                                                     <div id="rateYo3" class="rateYoLoop" data-rating='<?php  echo $rows->user_rating; ?> '></div> 
                                                     <?php  echo $rows->user_rating; ?> / 5
                                                 </div>
                                             </div>
                                             <div class="servie">
                                                 <span>Deep cleaning services</span>
                                                 <dd>02 / 06 / 2019</dd>
                                             </div>
                                         </div>
                                         <div class="content">
                                             <h4>"Fast and Good Attitude"</h4>
                                             <p><?php echo $rows->feed_back?></p>
                                         </div>
                                     </div>
                                     <?php
                                     }
                                     ?>
                                     
                                 </div>
      </div>
    </div>
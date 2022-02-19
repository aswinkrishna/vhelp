 <?php
 if(count($result)>0)
 {
     $i=1;
     foreach($result as $rows)
     {
 ?>
 <div class="col-md-6">
                      <div class="item">
                          <div class="pro_image">
                              <?php
                               $img                                     =      base_url()."uploads/user/".$rows->user_image;
                               if($rows->user_image!="")
                               {
                                   
                               }
                               else
                               {
                                  $img = base_url().'images/user_dummy.png'; 
                               }
                              ?>
                              <img src="<?php echo $img ;?>" />
                          </div>
                          <div class="content">
                              <h4><?php echo $rows->user_first_name." ".$rows->user_last_name ?></h4>
                              <p><?php echo $rows->feed_back ?></p>
                              <div class="rating">
                                <div id="rateYo<?php echo $i;?>" class="rateYoLoop" data-rating="<?php echo $rows->user_rating;?>"></div>
                                <span>( <?php echo $rows->user_rating;?> )</span>
                              </div>
                              <span><?php echo date('d-m-Y h:i A', strtotime($rows->added_date)); ?></span>
                          </div>
                      </div>
                  </div>
                  
                  <?php
                  $i++;
     }
 }
 else
 {
     echo "No results found";
 }
                  ?>
                  <?php

if(isset($links) && $links!="")
{
    ?>
  <table> <tr class="ash-bg-light">
  
              <td class="bable_title" colspan="4"> <?php   echo $links;;?>  </td>
          </tr>
 </table>
    <?php
     
 }
?>
<?php

//print_r($_SESSION);
//Array ( [__ci_last_regenerate] => 1547113665 [admin_email] => admin@admin.com [admin_id] => 1 [admin_name] => Admin )

                             if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                              <th>Sl no</th>
                                                                 <th> Image</th>  
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                             <th>Country</th>
                                                             <?php if($result[0]->user_type == 2 ) {?>
                                                             <th>City</th>
                                                             <?php } ?>
                                                            <th>Created date</th>
                                                            <th>Status</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 
//print_r($productList);
$p=1;
 foreach($result as $rows) 
 {

if (strpos($rows->user_dial_code, '+') === false)
    $rows->user_dial_code  = '+'.$rows->user_dial_code;

$postedDate = date("Y-m-d H:i:s",strtotime($rows->audit_time));    
  $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";   
  ?>
                                                        <tr>
                                                             <td><?php  echo $p; ?></td>
                                                               <td><img src="<?php echo $profileImage;?>" class="profileIcon"> </td>
                                                            <td><?php  echo $rows->user_first_name." ".$rows->user_last_name; ?></td>
                                                            <td><?php  echo $rows->user_email; ?></td>
                                                            <td><?php  echo $rows->user_dial_code."- ".$rows->user_phone; ?></td>
                                                           <td><?php  echo $rows->country_name; ?></td>
                                                           <?php if($rows->user_type == 2) { ?>
                                                           <td><?php  echo $rows->city_name; ?></td>
                                                           <?php } ?>
                                                            <td><?php  echo $rows->user_created_time; ?></td>
                                                            <td><?php  echo $rows->user_status==1?"Active":"Inactive"; ?></td>
                                                            
                                                        </tr>
                                                        <?php
                                                        $p++;
                                    }
                            ?>
                                                    </tbody>
                                                </table>
                                                
                                                <?php
                                                echo $links;
                                                ?>



  <?php

}
else
{


          echo  "No Results Found";

}


                    ?>
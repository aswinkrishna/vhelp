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
                     <th>Service type name</th>
                     <th>Main description</th>
                     <th>Icon</th>
                     <th>Image</th>
                    <th>Parent </th>                                      
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



$postedDate = date("Y-m-d H:i:s",strtotime($rows->audit_time));    

  ?>
                                                        <tr>
                                                               <td><?php  echo $p; ?></td>
                    <td><?php  echo $rows->service_type_name; ?></td>
                    <td><?php  echo $rows->arbicname; ?></td>
                     <td>  <img src="<?php echo base_url().'uploads/service_type/'.$rows->service_type_icon ;?>" class="previewImage" id="imagePreview"></td>
                      <td>  <img src="<?php echo base_url().'uploads/service_type/'.$rows->service_type_banner_image ;?>" class="previewImage" id="imagePreview"></td>
                    <td><?php  echo $rows->parentname!=""?$rows->parentname:"-"; ?></td>                 
                    <td><?php  echo $rows->service_type_created_date; ?></td>                  
                    <td><?php  echo $rows->service_type_status==1?"Active":"Inactive"; ?></td>
                                                            
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
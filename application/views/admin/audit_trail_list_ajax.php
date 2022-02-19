<?php

//print_r($_SESSION);
//Array ( [__ci_last_regenerate] => 1547113665 [admin_email] => admin@admin.com [admin_id] => 1 [admin_name] => Admin )

                             if(isset($trail) && count($trail)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-pann">Sl no</th>
                                                            <th class="border-pann">Menu</th>
                                                            <th class="border-pann">Module</th>
                                                            <th class="border-pann">Action</th>
                                                            <th class="border-pann">Admin Name</th>
                                                            <th class="border-pann">Admin Email id</th>
                                                            <th class="border-pann">User name</th>
                                                            <th class="border-pann">Action date</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 
//print_r($productList);
$p=1;
 foreach($trail as $rows) 
 {



$postedDate = date("Y-m-d H:i:s",strtotime($rows->audit_time));    

  ?>
                                                        <tr>
                                                            <td><?php echo $p ?> </td>
                                                            <td><?php echo $rows->admin_menu_name ?> </td>
                                                            <td><?php echo $rows->module_name ?> </td>
                                                            <td><?php echo $rows->action_name ?> </td>
                                                            <td><?php echo $rows->admin_first_name ?> <?php echo $rows->admin_last_name ?></td>
                                                            <td><?php echo $rows->admin_user_email ?> </td>
                                                            <td><?php echo $rows->admin_user_name ?> </td>
                                                            <td><?php echo $postedDate ?></td>
                                                            
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
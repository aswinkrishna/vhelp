<?php

$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  6;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  


                             if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                               <th>Sl no</th>
                                                                 <th>Photo </th>   
                     <th>Name</th>
                     <th>User Type</th>
                     <th>Testimonial </th>
                     <th>Testimonial arabic</th>
                                                     
                    <th>Created date</th>
                    <th>Status</th>
                     <th>Action</th>
                                                            
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
                      <td>  <img src="<?php echo base_url().'uploads/user/'.$rows->profile_image ;?>" class="previewImage" id="imagePreview"></td>
                    <td><?php  echo $rows->first_name.' '.$rows->last_name; ?></td>
                    <td><?php  echo $rows->user_type_name_eng; ?></td>
                    <td><?php  echo $rows->testimonial; ?></td>
                      
                    <td><?php  echo $rows->testimonial_arabic; ?></td>                 
                    <td><?php  echo $rows->testimonial_created_time; ?></td>                  
                    <td><?php  echo $rows->testimonial_status==1?"Active":"Inactive"; ?></td>
                       <td> 
                                                             <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?> 
			<a class="edit" href="<?php echo base_url().'admin/add_edit_testimonial/'.$this->common_functions->encryptId($rows->testimonial_id) ?> ">
                                                            <i class="fa fa-pencil" i></i>
                                                        </a>
                                                    &nbsp; &nbsp; 
                                                        <?php
                                                        }
                                                       ?>
                                                       <?php
                                                        if($permission->perm_delete==1)
                                                        {
                                                        ?>
                                                        <a class="remove" href="#"  data-toggle="modal" data-target="#confirm-modal">
                                                            <i class="fa fa-trash-o removeThis" for="<?php echo $this->common_functions->encryptId($rows->testimonial_id )?>"></i>
                                                        </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>                                     
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
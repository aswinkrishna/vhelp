<?php
$adminUserid   =  $this->session->userdata('admin_id'); 
$menuId        =  6;
$permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid,$menuId);  
?> 
 <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Content list</h1>
<!--          <p>Table to display analytical data effectively</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>-->
      </div>
    <div class="row">
          <div class="col-md-12">
                <div class="col-md-8 col-md-offset-12">
                                    
                                                     <?php
                                                        if($permission->perm_add==1)
                                                        {
                                                        ?>
                                        <a href="<?php echo base_url();?>admin/add_edit_article" class="btn btn-primary btn-sm rounded-s radius"><span>+</span> Add New </a>
                                                       <?php
                                                        }
                                                        ?>
                                       
                                    </div>
              </div>
    </div>
      <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
        </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">

<?php
//print_r($article_list);
                             if(isset($article_list) && count($article_list)>0)
                             {
                            ?>

<table class="table table-striped table-bordered table-hover" id="sampleTable">
                                                    <thead>
                                                        <tr>
                                                             <th>id</th>
                                                            <th>Type</th>
<!--                                                            <th>Article</th>
                                                            <th>Article(Arb)</th>                                                           -->
                                                            <th>Status</th>
                                                            <th>Published</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<?php 
//print_r($countrylist);

 foreach($article_list as $rows) 
 {


$postedDate = date("F j, Y, g:i a",strtotime($rows->articles_created_date));    

  ?>
                                                        <tr>
                                                            <td><?php echo $rows->articles_type_id ?> </td>
                                                            <td><?php echo $rows->article_type_desc ?> </td>
<!--                                                            <td><?php //echo $rows->englishname ?> </td>
                                                            <td><?php echo $rows->arbicname ?></td>                                                           -->
                                                            <td> <?php echo ($rows->articles_status==1?"Active":"Inactive") ;?></td>
                                                            <td> <?php echo $postedDate;?> </td>
                                                            <td> 
                                                             <?php
                                                        if($permission->perm_edit==1)
                                                        {
                                                        ?> 
			<a class="edit" href="<?php echo base_url().'admin/add_edit_article/'.$this->common_functions->encryptId($rows->articles_id) ?> ">
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
                                                            <i class="fa fa-trash-o removeThis" for="<?php echo $rows->articles_id ?>"></i>
                                                        </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                        </tr>
                                                        <?php
                                    }
                            ?>
                                                    </tbody>
                                                </table>



  <?php
}
else
{


          echo  "No Results Found";

}


                    ?>

                   </div>
          </div>
        </div>
      </div>
    </main>
				
				
				

                <script>
             $(document).delegate(".removeThis","click",function(e)
    {
       // $("#txtDelete").val("");
        var deleteId     = $(this).attr("for");
       // $("#txtDelete").val(deleteId);
        deleteThis(deleteId);
      
    });


       function deleteThis(id)
       {
         
        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
      csrf_value  =   getCookie('csrf_cookie_name');        
         $.ajax({
            url:  '<?php echo base_url();?>admin/C_admin/deleteArticle',
            type: 'POST',
            data: {id:id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			  //  alert(data);

			      if(data>0)
                    {
                       
                          swal("Well done!", "Deleted Successfully!", "success");
						  
	location.reload();
                              
                    }
                    else
                    {
                              
                          swal("Sorry!", "Failed to delete! Try again later", "error");


                    }

			   
            }
        });    
    
    
  } else {
    
  }
});
           
         //  return false;
           
           
             
       }
                </script>
<?php
  
  $id              =  $this->common_functions->decryptId($this->uri->segment(3));

  if($id>0)
  {
      $heading      =     "Edit ";
        $saveButtonName  = "Update";
      $records1                    =   $this->M_admin->getArticlesById(1,$id);
      $records2                    =   $this->M_admin->getArticlesById(2,$id);
      $englishName                 =   $records1->articles_desc;
      $arabicName                  =   $records2->articles_desc;    
      $status                      =   $records1->articles_status;
      $articleTypeid               =   $records1->articles_type_id;
     // print_r($records1);
      
  }
  else
  {
      $saveButtonName  = "Add";
      $heading                     =     "Add New ";
      $englishName                 =     "";
      $arabicName                  =      "";
      $countryId                   =     "";
      $status                      =      "1";
      $articleTypeid               =     "";
  }

?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Articles</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
     <?php
           
                     $label = "registration";
                      if($id>0)
                      {
                            $label = "Updation";
                      }
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Articles <?php  echo $label; ?></h3>
            <div class="tile-body">
                   

                        <?php
                         $attributes = array('method' => 'post', 'id' => 'itemForm', 'name' => 'item');
                        echo  form_open_multipart('', $attributes);
if($id>0)
  {
    ?>
            <input type="hidden" class="form-control boxed" placeholder="" name="id" value="<?php echo $id; ?>"> 
    <?php
  }
  ?>
 

                   

                                <form role="form" method="post" enctype="multipart/form-data">
								 <div class="form-group row">
								 <div class="col-sm-12">
								          
                                                                     <div class="col-md-6">
                                          
                                            <label class="control-label" for="formGroupExampleInput">Article Type</label>
                                             <select class="c-select form-control boxed" name="txt_article_type">
                                           <option value="">Select</option>
                                           <?php
                                           if(count($article_type)>0)
                                           {
                                               foreach ($article_type as $rows)
                                               {
                                           ?>
                                            <option value="<?php echo $rows->article_type_id  ?>" <?php echo ($articleTypeid==$rows->article_type_id?"selected":"") ?>><?php echo $rows->article_type_desc ?></option>
                                           <?php
                                               }
                                           }
                                           
                                           ?>
											
                                             </select>      
                                              <div class="error"></div>  
                                                                     
                                                                     </div>
						<div class="col-md-12">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Article English</label>
                                            <textarea class="form-control" id="txt_article" name="txt_article"><?php echo $englishName ?></textarea>
                                             <div class="error"></div>
										</div>
						<div class="col-md-12">
                                          
                                            <label class="control-label title-padd" for="formGroupExampleInput">Article Arabic</label>
                                          <textarea class="form-control" id="txt_article_arb" name="txt_article_arb"><?php echo $arabicName ?></textarea>	
                                          <div class="error"></div>
                                          									</div>
							
                                                                 </div>
                        
                                                                 </div>
						
                        <!--end form group-->
                        
                    <?php  echo form_close(); ?>
           
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
           <span id="registerLoader"></span>
            </div>
          </div>
        </div>
        
        
      </div>
      </div>
    
    </main>
				<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&libraries=places&sensor=false"></script>
               
    

			   <script>         

var editor = CKEDITOR.replace( 'txt_article' );
var editor = CKEDITOR.replace( 'txt_article_arb' );
$(document).delegate("#btnRegister","click",function(e)
    {
        $("#itemForm").submit();
    });
       var validator=$("#itemForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_article_type: 
          {
            required: true
            
          },
          txt_article: {
                         required: function() 
                        {
                         CKEDITOR.instances.txt_article.updateElement();
                        },

                         minlength:10
                    },
           txt_article_arb:{
                         required: function() 
                        {
                         CKEDITOR.instances.txt_article_arb.updateElement();
                        },

                         minlength:10
                    }
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {
			
              
                dataString = $('#itemForm').serialize();
                var formData = new FormData($("#itemForm")[0]);
                
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveArticle',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                     // alert(data);
                     data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    if(data['status']==1)
                    {
                          $(".error").html("");// clear all errors
                          swal("Well done!", "Saved Successfully!", "success");
                           window.location= "<?php echo base_url();?>admin/article_list";        
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {//alert(key); alert(value);
                                //$('input[name='+key+']').addClass('is-invalid');
                                //$('[name="'+key+'"]').
                                $('[name="'+key+'"]').parents('.col-md-12').find('.error').html(value);

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }else{
                      swal("Sorry!", "Some technical issue occured", "error");
                    }

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 }); 
 
        </script>
		
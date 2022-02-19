<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> FAQ</h1>
<!--          <p>Sample forms</p>-->
        </div>
<!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
      </div>
<!--    <div class="row">
          <div class="col-md-12">
                <div class="col-md-8 col-md-offset-12">
                    <a href="javascript:void(0)" class="addNewQues"> <button class="btn btn-primary" type="button">New Question</button></a>
                </div>
              </div>
    </div>-->
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
        </div>
     
               

<?php
  
  $id              =  $this->uri->segment(3);

  $data_row = $this->M_admin->get_faq($id);
  $meta_data = $this->M_admin->get_faq_meta_data();
  $meta_title  ="";
  $meta_keyword  ="";
  $meta_description  ="";
  if($meta_data){
    $meta_title       =   $meta_data->meta_title;
    $meta_keyword       =   $meta_data->meta_keyword;
    $meta_description       =   $meta_data->meta_description; 
  }

  if($data_row)
  {
      $heading      =     "Edit ";

      $title_english        = $data_row->faq_title;
      $title_arabic         = $data_row->faq_title_arabic;    

      $descp_english        = $data_row->faq_description;
      $descp_arabic         = $data_row->faq_description_arabic;

      $status               = $data_row->status;
      $faq_id               = $data_row->faq_id;
 
      
  }
  else
  {
      $heading              =     "Add New ";

      $title_english        = "";
      $title_arabic         = "";    

      $descp_english        = "";
      $descp_arabic         = "";

      $status               = "";
      $faq_id    = "";
  }

?>


                <div class="sidebar-overlay" id="sidebar-overlay"></div>
                <div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
                <div class="mobile-menu-handle"></div>
                <article class="content item-editor-page">
                    <div class="title-block">
                        <h3 class="title">

                         <?php echo $heading;?> FAQ
                            <span class="sparkline bar" data-type="bar"></span>
                        </h3>
                    </div>
                   

                        <?php
                        $attributes = array('method' => 'post', 'id' => 'itemForm', 'name' => 'item');
                        echo  form_open_multipart('', $attributes);

                        if($id>0) {
                            ?>
                                    <input type="hidden" class="form-control boxed" placeholder="" name="id" value="<?php echo $faq_id; ?>"> 
                            <?php
                        }
                        ?>
 

                        <div class="card card-block">

                            <form role="form" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-md-12">
                                        
                                            <label class="control-label" for="formGroupExampleInput">Title English</label>
                                            <input type="text" class="form-control" name="txt_title_english" value="<?php echo $title_english; ?>" />
                                            <div class="error"></div>  
                                                                        
                                        </div>

                                        <div class="col-md-12">
                                            
                                            <label class="control-label" for="formGroupExampleInput">Title Arabic</label>
                                            <input type="text" class="form-control" name="txt_title_arabic" value="<?php echo $title_arabic; ?>"  />
                                            <div class="error"></div>  
                                                                    
                                        </div>

                                        <div class="col-md-12">
                                        
                                            <label class="control-label" for="formGroupExampleInput">Article English</label>
                                            <textarea class="form-control" id="txt_descp_english" name="txt_descp_english"><?php echo $descp_english ?></textarea>
                                            <div class="error"></div>

                                        </div>

                                        <div class="col-md-12">
                                            
                                            <label class="control-label title-padd" for="formGroupExampleInput">Article Arabic</label>
                                            <textarea class="form-control" id="txt_descp_arabic" name="txt_descp_arabic"><?php echo $descp_arabic ?></textarea> 
                                            <div class="error"></div>

                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label title-padd"> Status: </label>

                                            <select class="c-select form-control " name="txtStatus">
                                            
                                                <option value="1" <?php echo ($status==1?"selected":"");  ?>>Active</option>
                                                <option value="0" <?php echo ($status==0?"selected":"");  ?>>Inactive</option>
                                            
                                            </select>
                    
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="control-label">Meta Title</label>
                                        <input type="text" class="form-control boxed" placeholder="" name="txt_meta_title" value="<?php echo $meta_title; ?>"  >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="control-label">Meta Keyword</label>
                                        <input type="text" class="form-control boxed" placeholder="" name="txt_meta_keyword" value="<?php echo $meta_keyword; ?>" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="control-label">Meta Description</label>
                                        <textarea class="form-control boxed" placeholder="" name="txt_meta_description" value="<?php echo $meta_description; ?>"  ><?php echo $meta_description; ?></textarea>
                                        </div> 
                                    </div>  
                                
                                    </div>
                            
                                </div>
                                <!--start form group-->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="col-md-12 submit-button-cover">
                                            <button type="submit" class="btn btn-primary"> Submit </button>
                                        </div>
                                        
                                                        
                                    </div>
                                </div>
                                <!--end form group-->
                                
                            <?php  echo form_close(); ?>
                        </article>
                        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&libraries=places&sensor=false"></script>
               
    

         <script>         

                var editor = CKEDITOR.replace( 'txt_descp_english' );
                var editor = CKEDITOR.replace( 'txt_descp_arabic', { contentsLangDirection: "rtl" } );

                var validator=$("#itemForm").validate({
                    ignore: [],
                    rules: {
          
                        txt_title_english: {
                            required: true
                        },
                        txt_title_arabic: {
                            required: true
                        },
                        txt_descp_english: {
                            required: function() {
                                CKEDITOR.instances.txt_descp_english.updateElement();
                            },
                            minlength:10
                        },
                        txt_descp_arabic:{
                            required: function() {
                                CKEDITOR.instances.txt_descp_arabic.updateElement();
                            },
                            minlength:10
                        }
                    },
                    messages: {
       
                    },
                    submitHandler: function () {
      
              
                        dataString = $('#itemForm').serialize();
                        var formData = new FormData($("#itemForm")[0]);
                
                
                        $.ajax({
                            url: '<?php echo base_url();?>admin/C_admin/save_faq',
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (data)  {
                    
                                // alert(data);
                                data =  jQuery.parseJSON(data);
                                console.log(data['status']);

                                if(data['status']==1) {
                                    $(".error").html("");// clear all errors
                                    swal("Well done!", "Saved Successfully!", "success");
                                    window.location= "<?php echo base_url();?>admin/faq_list";  
                                        
                                }
                                else if(data['status']==0) {
                                    if(data['errors'] !== ""){
                                        $.each(data['errors'], function(key, value) {//alert(key); alert(value);
                                            //$('input[name='+key+']').addClass('is-invalid');
                                            //$('[name="'+key+'"]').
                                            $('[name="'+key+'"]').parents('.col-md-12').find('.error').html(value);

                                        });                          
                                    }
                                    else{    
                                        swal("Sorry!", "Failed to save! Try again later", "error");
                                    }


                                }
                                else{
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
    
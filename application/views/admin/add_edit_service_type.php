<style type="text/css">
    .card{
        padding: 10px;
        margin-bottom: 20px;
    }
    .fa-times-circle-o{
        float: right;
        color: red;
        margin-top: -30px;
    }
    
    .fa-times-circle{
        float: right;
        color: red;
    }
</style>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Service type</h1>
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
                     $saveButtonName  = "Add";
                      if($id>0)
                      {
                               $label = "updation";
                                $saveButtonName  = "Update";
                              
                               
                                $englishName                 =   $records1->service_type_name;
                                $arabicName                   =   $records2->service_type_name;
                                $parentId                         =   $records1->service_type_parent_id;
                                $status                              =   $records1->service_type_status;
                                $method                           =   $records1->service_methode;
                                $isHomeCategory          =    $records1->is_home_category;
                                $include_mega_menu       =   $records1->include_mega_menu;

                                $weekly_service_status  = $records1->is_weekly_available;
                                $monthly_service_status = $records1->is_monthly_available;

                                if($parentId <= 0 )
                                    $h_data = $this->M_admin->getHowItsWork($id);
                      }
                      else
                      {
                               $englishName               =   "";
                                $arabicName               =   "";
                                $parentId                 =   0;
                                $status                   =   "1";
                                $method                   =   "";
                                $include_mega_menu        =   "";

                                $weekly_service_status  = 0;
                                $monthly_service_status = 0;
                      }


               ?>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Service type <?php  echo $label; ?></h3>
            <div class="tile-body">
                <form name="item"  id="categoryForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    
                    if($id>0)
                      {
                        
                      
                        
                        ?>
                                <input type="hidden" class="form-control boxed" placeholder="" name="txt_service_id" value="<?php echo $id; ?>"> 
                        <?php
                      
                      }
                     
               ?>
                   <div class="row">
                           <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Service type name english</label>
                             <input type="text" class="form-control boxed" placeholder="" name="txtEnglish" value="<?php echo $englishName; ?>" maxlength="60"> 
                                 </div> 
                        </div>
                   <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Service type name  arabic</label>
                                 <input type="text" class="form-control boxed" placeholder="" name="txtArabic" value="<?php echo $arabicName; ?>" maxlength="60" dir="rtl">
                                 </div> 
                        </div>
                     
                   </div>
                    <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Parent</label>
                               <select class="c-select form-control boxed" name="txtParent" id="txtParent">
                                      <option value="0">No Parent</option>

                                      <?php


                             if(isset($service_type_list) && count($service_type_list)>0)
                             {
                              foreach($service_type_list as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo $rows->service_type_id; ?>" <?php  if($parentId==$rows->service_type_id){ echo "selected" ;} ?> ><?php echo $rows->service_type_name; ?></option>
                                       
                                       <?php
                                     }
                              }

                                       ?>
                                       
                                    </select>
                                 </div> 
                        </div>
                         <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Status</label>
                              <select class="c-select form-control boxed controll-wdth" name="txtStatus">
                                       
                                        <option value="1" <?php echo ($status==1?"selected":"");  ?>>Active</option>
                                        <option value="0" <?php echo ($status==0?"selected":"");  ?>>Inactive</option>
                                       
                                    </select>
                                 </div> 
                        </div>
                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Weekly Service</label>
                                    <select class="c-select form-control boxed controll-wdth" name="txtWeeklyAvailable">
                                        <option value="1" <?php echo ($weekly_service_status==1?"selected":"");  ?>>Available</option>
                                        <option value="0" <?php echo ($weekly_service_status==0?"selected":"");  ?>>Not Available</option>
                                    </select>
                                 </div> 
                        </div>
                        <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Monthly Service</label>
                                    <select class="c-select form-control boxed controll-wdth" name="txtMonthlyAvailable">
                                        <option value="1" <?php echo ($monthly_service_status==1?"selected":"");  ?>>Available</option>
                                        <option value="0" <?php echo ($monthly_service_status==0?"selected":"");  ?>>Not Available</option>
                                    </select>
                                 </div> 
                        </div>
                   </div>
                                  <div class="row">
                                      
                                      <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Service type thumbnail (270 X 250)</label>
                               <input type="file" class="form-control boxed" id="categoryThumb" placeholder="" name="txtFile3" accept=".jpg, .png, .jpeg" value=""> 
                               <p>Accepts .jpg, .jpeg, .png formats only.</p>
                                 </div> 
                        </div>
                                          <div class="col-md-2">
                                 <div class="form-group">
                                
                                     <img src="<?php echo $records1->service_type_thumbnail!=""?base_url().'uploads/service_type/'.$records1->service_type_thumbnail:base_url().'images/placeholder.jpg' ;?>" class="previewImage" id="imagePreview3">
                                 </div> 
                        </div>
                        
                         <div class="col-md-4">
                                 <div class="form-group">
                                <label class="control-label">Service type Icon (270 X 250)</label>
                               <input type="file" class="form-control boxed" id="categoryIcon" placeholder="" name="txtFile" accept=".jpg, .png, .jpeg" value=""> 
                               <p>Accepts .jpg, .jpeg, .png formats only.</p>
                                 </div> 
                        </div>
                                          <div class="col-md-2">
                                 <div class="form-group">
                                
                                     <img src="<?php echo $records1->service_type_icon!=""?base_url().'uploads/service_type/'.$records1->service_type_icon:base_url().'images/placeholder.jpg' ;?>" class="previewImage" id="imagePreview">
                                 </div> 
                        </div>
                   </div>
                    <div class="row" style="display:none;">
                     <div class="col-md-6" >
                         <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="4" name="txtmethod" <?php echo $method==4?"checked":"" ?> >Featured service?
                      </label>
                    </div>
                                
                        </div>
                      <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Service type template</label>
                                <select class="c-select form-control boxed" name="isHomeCategory">
                                      <option value="0"  <?php  if($isHomeCategory==0){ echo "selected" ;} ?> >General</option>
                                     <option value="1" <?php  if($isHomeCategory==1){ echo "selected" ;} ?>>Construction</option>
                                      
                                       
                                    </select>
                                 </div> 
                        </div>
                   </div>
                                 <div class="row" style="display:none;">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Main label english</label>
                                <textarea class="form-control boxed" name="txtMainLabel"><?php  echo $records1->main_label; ?></textarea>
                                 </div> 
                        </div>
                       <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Main label arabic</label>
                                <textarea class="form-control boxed" name="txtMainLabelArb"><?php  echo $records2->main_label; ?></textarea>
                                 </div> 
                        </div>
                   </div>
                                    <div class="row" style="display:none;">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Sub label english</label>
                                <textarea class="form-control boxed" name="txtSubLabel"><?php  echo $records1->sub_label; ?></textarea>
                                 </div> 
                        </div>
                       <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Sub label arabic</label>
                                <textarea class="form-control boxed" name="txtSubLabelArb"><?php  echo $records2->sub_label; ?></textarea>
                                 </div> 
                        </div>
                   </div>
                                    <div class="row">
                     <div class="col-md-6" style="display:none;">
                                 <div class="form-group">
                                <label class="control-label">Description english</label>
                                <textarea class="form-control boxed" name="txtDesc"><?php  echo $records1->service_type_desc; ?></textarea>
                                 </div> 
                        </div>
                       <div class="col-md-6" style="display: none;">
                                 <div class="form-group">
                                <label class="control-label">Description arabic</label>
                                <textarea class="form-control boxed" name="txtDescArb" maxlength="500"><?php  echo $records2->service_type_desc; ?></textarea>
                                 </div> 
                        </div>


                                     
                        <div class="col-md-6" style="display:none;">
                         <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="txtMega" <?php echo $include_mega_menu==1?"checked":"" ?> >Include in mega menu?
                      </label>
                    </div>
                                
                        </div>
                        <div class="col-md-6"></div>
                        

                   </div>
                   
                   <div class="col-md-12">
                                       
                                            <label class="control-label" for="formGroupExampleInput">Description</label>
                                            <textarea class="form-control" id="txtDesc" name="txtDesc"><?php echo $records1->service_type_desc ?></textarea>
                                             <div class="error"></div>
										</div>

                      <br>
                    <h3>Baner Images <i class="fa fa-plus-circle add_baner" style="display:none;" aria-hidden="true"></i></h3>
                    <div id="dynamicBanerImage">
                        
                        <?php
                            if(count($baner_image)<=0){
                        ?>
                            <div class="card hcard" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Service type Banner for web(1500 X 350 )</label>
                                            <input type="file" class="form-control boxed formImage" i="" placeholder="" name="webImage[]" for="imagePreview" accept=".jpg, .png, .jpeg" value="">
                                            <p>Accepts .jpg, .jpeg, .png formats only.</p> 
                                        </div> 
                                    </div>
    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <img src="https://dxb.co.com/vhelp3/images/placeholder.jpg" class="previewImage" id="imagePreview">
                                        </div> 
                                    </div>
    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Service type Banner for app (1500 X 350 )</label>
                                            <input type="file" class="form-control boxed formImage" for="imagePreview00" placeholder="" name="appImage[]" accept=".jpg, .png, .jpeg" value="">
                                            <p>Accepts .jpg, .jpeg, .png formats only.</p> 
                                        </div> 
                                    </div>
    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <img src="https://dxb.co.com/vhelp3/images/placeholder.jpg" class="previewImage" id="imagePreview00">
                                        </div> 
                                    </div>
    
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        
                    </div>
                        


                    <div class="row">
                        <?php 
                            foreach($baner_image as $key=>$value){
                                $image = 'uploads/service_type/'.$value->image;
                                if(file_exists($image) && is_file($image))
                                    $image = base_url().$image;
                        ?>
                            <div class="col-md-3" id="<?=$value->id?>">
                                <i class="fa fa-times-circle deleteBannerThis" for="<?=$value->id?>" serviceid="<?php if(isset($id)) echo $id;?>"   aria-hidden="true"></i>
                                <img src="<?=$image?>" style="width: 100%; height:50px;" >
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                   <br>
                   
                   <h3 class="tile-title" id="how-it-work" style="display:none;">How it's works <i class="fa fa-plus-circle add_hwork" aria-hidden="true"></i></h3>
                   <div class id="dynamicForms">
                       <?php
                        if($h_data){
                            foreach ($h_data as $key => $value) {
                       ?>
                            <div class="card hcard" id="<?=$value->h_id?>">
                                <h3><i class="fa fa-times-circle-o" for="<?=$value->h_id?>" delete="1" aria-hidden="true"></i></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Title</label>
                                        <input type="text" name="h_title[]" value="<?=$value->title?>" class="form-control">
                                        <input type="hidden" value="<?=$value->h_id?>" name="h_id[]">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Icon</label>
                                        <input type="file" name="h_image[]" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                            $image = 'uploads/service_type/'.$value->image;
                                            if(file_exists($image) && is_file($image)){
                                                $image = base_url().$image;
                                        ?>
                                            <img src="<?=$image?>" style="height: 50px;">
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Description</label>
                                        <textarea name="h_decription[]" class="form-control"><?=$value->decription?></textarea>
                                    </div>
                                </div></div>
                       <?php
                                }
                            }
                       ?>
                    </div>
                    <div class="col-md-4">
                                 <div class="form-group">
                                    <h3>Homepage Banner</h3>
                              <!--   <label class="control-label">Homepage Banner</label> -->
                               <input type="file" class="form-control boxed" id="homepage_banner" placeholder="" name="homepage_banner" accept=".jpg, .png, .jpeg" value=""> 
                               <p>Accepts .jpg, .jpeg, .png formats only.</p>
                                 </div> 
                        </div>
                        <div class="col-md-2">
                                 <div class="form-group">
                                    <i class="fa fa-times-circle deleteHomepageBanner" for="<?php if(isset($id)) echo $id;?>"  aria-hidden="true"></i>
                                     <img src="<?php  echo base_url().'uploads/banner/'.$records2->homepage_banner; ?>" class="previewImage" id="imagePreviewHomepage">
                                 </div> 
                        </div>
              </form>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
             <span id="registerLoader"></span>
            </div>
          </div>
        </div>
        
        
      </div>
    </main>
<script>         
    var id =0;
    var j  = 0;
    var editor = CKEDITOR.replace( 'txtDesc' );
    
    $(document).delegate("#btnRegister","click",function(e)
    {
        $("#categoryForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#cityForm")[0].reset();
    });


       var validator=$("#categoryForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txtEnglish: 
          {
            required: true,
           maxlength:100,
           lettersonly:true,
            
          },
          txtArabic: 
          {
            required: true,
            maxlength:100,
          },

          h_title:{
            required:true,
          }

          <?php
           if($id<=0)
                      {
          ?>
          ,
          
           txtFile2: {
                required: {
                    depends: function (element) {
                        return $("#txt_service_id").not(":filled");
                    }
                }
            },
          txtFile3: {
                required: {
                    depends: function (element) {
                        return $("#txt_service_id").not(":filled");
                    }
                }
            }
            
            <?php
                      }
            ?>
          /* txtmethod: 
          {
            required: true,
            number:true
          },*/
          /*txt_commission:
          {
            required: true,
            number:true
          }*/
          
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {
            var txtDesc = editor.getData();
              $(".errorSpan1").html("");	               
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                dataString = $('#categoryForm').serialize();
                var formData = new FormData($("#categoryForm")[0]);
                  csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 formData.append('txtDesc',txtDesc);
                
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveServiceType',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                    $("#registerLoader").html("");
                    $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    if(data['status']==1)
                    {
                         $(".error").html("");// clear all errors
                          swal("Well done!", "Saved Successfully!", "success");
                           window.location= "<?php echo base_url();?>admin/service_type_list";    
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                                $('[name='+key+']').parents('.form-group').find('.error').html(value);

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
$("#categoryIcon").change(function() {
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
  {
      $("#categoryIcon").val('');
      swal("Sorry!", "You are trying to upload an invalid file.", "error");
      return false;
  }
  readURL(this,'imagePreview');
});
 $("#categoryImage").change(function() {
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
  {
      $("#categoryImage").val('');
      swal("Sorry!", "You are trying to upload an invalid file.", "error");
      return false;
  }
  readURL(this,'imagePreview2');
});
$("#categoryThumb").change(function() {
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
  {
      $("#categoryThumb").val('');
      swal("Sorry!", "You are trying to upload an invalid file.", "error");
      return false;
  }
  readURL(this,'imagePreview3');
});

    $('.add_hwork').click(function(){
        id++;
        var html = `<div class="card hcard" id="`+id+`">
                        <h3><i class="fa fa-times-circle-o" for="`+id+`" delete="0" aria-hidden="true"></i></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Title</label>
                                <input type="text" name="h_title[]" class="form-control">
                                <input type="hidden" value="" name="h_id[]">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Icon</label>
                                <input type="file" name="h_image[]" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Description</label>
                                <textarea name="h_decription[]" class="form-control"></textarea>
                            </div>
                        </div></div>`;

        $('#dynamicForms').append(html);
    });


    $(document).delegate(".fa-times-circle-o","click",function(e){
       var id       = $(this).attr("for");
       var isDelete = $(this).attr("delete");
       if(isDelete > 0 )
            deleteThis(id);
        else
            $('#'+id).remove();

   });

    function deleteThis(id,isDelete){
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                if(id > 0 && isDelete > 0 ){
                    $.ajax({
                        url: '<?=base_url()?>admin/C_admin/deleteHowItsWork',
                        type:'post',
                        data: {h_id:id},
                        success:function(data){
                            if(data > 0 ){
                                swal("Well done!", "Data deleted successfully!", "success");
                                $('#'+id).remove();
                            }else{
                                swal("Sorry!", "Failed to save! Try again later", "error");
                            }
                        }
                    })
                }else{
                    $('#'+id).remove();
                }
            }
        });
    }

    $('#txtParent').change(function(){
        txtParent = $('#txtParent').val();
        if(txtParent > 0){
            $('#how-it-work').hide();
            $('.hcard').remove();
            $('.add_baner').hide();
        }
        else{
            $('#how-it-work').show();
            $('.add_baner').show();
        }
    });



 </script>

 <?php
    if(!$parentId){
 ?>
        <script type="text/javascript">
            
            $(document).ready(function(){
                $('#how-it-work').show();
                $('.add_baner').show();
            });
        </script>

 <?php
    }
 ?>


<script type="text/javascript">
    
    $('.add_baner').click(function(){
        j++;
        var html = `<div class="card hcard" id="b`+j+`">
                            <h3><i class="fa fa-times-circle " for="`+j+`" delete="1" aria-hidden="true"></i></h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Service type Banner for web(1500 X 350 )</label>
                                        <input type="file" class="form-control boxed formImage" i placeholder="" name="webImage[]" for="imagePreview1`+j+`" accept=".jpg, .png, .jpeg" value="">
                                        <p>Accepts .jpg, .jpeg, .png formats only.</p> 
                                    </div> 
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <img src="<?=base_url()?>images/placeholder.jpg" class="previewImage" id="imagePreview1`+j+`">
                                    </div> 
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Service type Banner for app (1500 X 350 )</label>
                                        <input type="file" class="form-control boxed formImage" for="imagePreview2`+j+`"  placeholder="" name="appImage[]" accept=".jpg, .png, .jpeg" value="">
                                        <p>Accepts .jpg, .jpeg, .png formats only.</p> 
                                    </div> 
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <img src="<?=base_url()?>images/placeholder.jpg" class="previewImage" id="imagePreview2`+j+`">
                                    </div> 
                                </div>

                            </div>
                        </div>`;
        $('#dynamicBanerImage').append(html);

    });


    $(document).delegate('.fa-times-circle','click',function(e){
        var id       = $(this).attr("for");
        $('#b'+id).remove();
    });
    
    $(document).delegate('.deleteThis','click',function(e){
        var id       = $(this).attr("for");
        $.ajax({
            url : '<?=base_url()?>admin/c_admin/deleteBanerImage',
            type:'post',
            data: {id:id},
            success:function(data){
                if(data == 1 ){
                    swal("Well done!", "Data deleted successfully!", "success");
                    $('#'+id).remove();
                }else if(data == -1 ){
                    swal("Sorry!", "Failed to delete baner image", "error");
                }
            }
        });
    });
    
     function readURL(input,imageId) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#'+imageId).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#homepage_banner").change(function()
{
  
  readURL(this,'imagePreviewHomepage');
});
    $('.deleteHomepageBanner').on('click',function(){
      var id       = $(this).attr("for");
        $.ajax({
            url : '<?=base_url()?>admin/c_admin/deleteHomepageBanner',
            type:'post',
            data: {id:id},
            dataType:'json',
            success:function(data){
                if(data.status == 1 ){
                    swal("Well done!", "Data deleted successfully!", "success");
                    $('#imagePreviewHomepage').attr('src','');
                }else if(data.status == -1 ){
                    swal("Sorry!", "Failed to delete baner image", "error");
                }
            }
        });
    });
    $('.deleteBannerThis').on('click',function(){
      var id       = $(this).attr("for");
       var serviceid       = $(this).attr("serviceid");
        $.ajax({
            url : '<?=base_url()?>admin/c_admin/deleteBanerImage',
            type:'post',
            data: {
                    id:id,
                   serviceid:serviceid },
            dataType:'json',
            success:function(data){
                if(data.status == 1 ){
                    swal("Well done!", "Data deleted successfully!", "success");
                    $('#'+id).remove();
                }else if(data.status == -1 ){
                    swal("Sorry!", "Failed to delete baner image", "error");
                }
            }
        });
    });

    </script>
<style>
    .forget_password{
        width: 100%;
        max-width: 500px;
        border: 1px solid #ccc;
        margin: 0 auto;
        padding: 30px;
        margin-bottom: 50px;
    }
    .forget_password h3{
        text-align: center;
        margin-bottom: 40px;
    }
    .forget_password form{
        width: 100%;
    }
    .forget_password input{
        width: 100%;
        height: 45px;
        font-size: 1rem;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: .375rem .75rem;
        margin-bottom: 1rem;
        height: calc(3rem + 2px);
    }
    .forget_password .container{
        width: auto;
        max-width: auto;
    }
    .forget_password button{
        /*background: #d52d2f;
        border-color: #d52d2f;
        padding: 10px 30px;
        float: right;*/
        float: right;
        background: #d52d2f;
        color: #fff;
        text-transform: capitalize;
        font-size: 15px;
        width: 150px;
        height: 39px;
        border-radius: 6px;
        text-align: center;
        display: block;
        text-decoration: none;
    }
     .forget_password button:hover{
        background: #de3032;
        border-color: #d52d2f;
    }
    
    h2{
        text-align:center;
    }
</style>
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row main">
           <div class="forget_password">
            <!-- <h3><?php echo $this->lang->line('forgot_pwd2'); ?></h3> -->
           
            <!--start container-->
             <?php
           // echo $user_id;
            if($error==0)
            {
            ?>
                 <h3>Forgot Password</h3>
                <div class="container">
                    <!--start row-->
                    <div class="row min-content-pf">
                       <span id="validationSpan" class="error"></span>
<form id="formForgotPwd">
                         <div>

 <input name="new_password" id="new_password" placeholder="<?php echo $this->lang->line('enter_new_password'); ?>" value="" type="password">
</div>

<div>

 <input name="confirm_password" placeholder="<?php echo $this->lang->line('confirm_new_password'); ?>" value="" type="password">
</div>
                          <button class="submit" id="btnForgotPwd"><?php echo $this->lang->line('submit'); ?></button>
                        </form>
                    </div>
                </div>
                <?php
            }
            else if($error==1)
            {
                echo "<h2>Invalid Session</h2>";
            }
            else if($error==2)
            {
                 echo "<h2>Link Expired</h2>";
            }
          ?>
                <!--end container-->
            </div>
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>

<script>
      $(document).delegate("#btnForgotPwd","click",function(e)
    {
        
          var validator=$("#formForgotPwd").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
         
          new_password: 
          {
              required: true,
              minlength : 8,             
              maxlength:15 ,
              passwordCheck:true
          }	,
          confirm_password: 
          {
             required: true,
             minlength : 8,
             maxlength:15 ,
             passwordCheck:true,
             equalTo : "#new_password"
          }	
        },
       
        messages: 
        {
            new_password: {
                passwordCheck:"Password field must contain atleast one letter , number and special characters",
            }
        },
     submitHandler: function ()
        {
			
               $("#btnForgotPwd").attr("disabled", "disabled");
               $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                dataString = $('#formChangePwd').serialize();
                var formData = new FormData($("#formForgotPwd")[0]);
                csrf_value  =   getCookie('csrf_cookie_name');
             formData.append('<?php echo $this->security->get_csrf_token_name(); ?>',csrf_value);
             formData.append('user_id','<?php echo $user_id; ?>');
                
                     $.ajax({
             url: '<?php echo base_url(); ?>website/User/saveNewPassword',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                     $('#btnForgotPwd').prop("disabled", false);
                     $("#registerLoader").html("");
                      data =  jQuery.parseJSON(data);
                    // console.log(data);
      $(".errorSpan1").html("");// clear all errors
                    if(data['status']==1)
                    {
                               
                              swal( "<?php echo $this->lang->line('pswd_reset_succes'); ?>");
                              //$('#formChangePwd')[0].reset();
                              window.location="<?php echo base_url();?>";
                              
                    }
                    
                    else if(data['status']==0)
                    {
                   
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {//alert(key); alert(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                              $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

                            });                          
                          }else
                          {    
                           swal("<?php echo $this->lang->line('reset_failed'); ?>");
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
        
    });
      
  </script>
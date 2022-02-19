<style>
    .forget_password{
        width: 100%;
        max-width: 500px;
        border: 1px solid #ccc;
        margin: 0 auto;
        padding: 30px;
        margin-bottom: 50px;
        border-radius: .3rem;
    }
    .forget_password h3{
        text-align: center;
        margin-bottom: 40px;
        font-size: 40px;
    }
    .forget_password form{
        width: 100%;
    }
    .forget_password input{
        /*width: 100%;
        height: 45px;*/
        display: block;
        width: 100%;
        /*height: calc(2.25rem + 2px);*/
        height: calc(3rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .forget_password .container{
        width: auto;
        max-width: auto;
    }
    .forget_password button{
        /*background: #d52d2f;
        border-color: #d52d2f;
        padding: 10px 30px;*/
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
        /*border-color: #d52d2f;*/
    }
</style>
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row main">
           <div class="forget_password">
            <!-- <h3><?php echo $this->lang->line('forgot_pwd2'); ?></h3> -->
            <h3>Forgot Password</h3>
            <!--start container-->
                <div class="container">
                    <!--start row-->
                    <div class="row min-content-pf">
                        <form id="formForgotPwd">
                          <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?></label>
                          <input type="text" name="txt_email" placeholder="<?php echo $this->lang->line('email'); ?>" value="">
                          </div>
                          <button class="submit" id="btnForgotPwd"><?php echo $this->lang->line('submit'); ?></button>
                        </form>
                    </div>
                </div>
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
        {
           ignore: [],
        rules: 
        {
          
       
           txt_email: 
          {
            required: true,
			email: true
          }
		  
        },
        messages: 
        {
       
    },
     submitHandler: function ()
        {
			
               $("#btnForgotPwd").attr("disabled", "disabled");
               $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
                dataString = $('#formForgotPwd').serialize();
                var formData = new FormData($("#formForgotPwd")[0]);
                    csrf_value  =   getCookie('csrf_cookie_name');  
                  formData.append( "<?php echo $this->security->get_csrf_token_name();?>",csrf_value);
                     $.ajax({
             url: '<?php echo base_url();?>website/User/processPassword',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   

                     $('#btnForgotPwd').prop("disabled", false);
                     $("#registerLoader").html("");

 if(data==1)
                    {
                       
                          swal("<?php echo $this->lang->line('pas_reset_email_sent'); ?>");
                          $('#formForgotPwd')[0].reset();
                              
                    }
                    else if(data==3)
                    {
                             swal("<?php echo $this->lang->line('email_not_exists'); ?>");
                    }
                      else if(data==0)
                    {
                             swal( "<?php echo $this->lang->line('reset_failed'); ?>");
                    }
                    else
                    {
                              
                           $("#validationSpan").html(data);


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
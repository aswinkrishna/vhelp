<script src="<?=base_url()?>template/js/jquery-migrate-1.4.1.min.js"></script>
<script src="<?=base_url()?>template/js/tether.min.js"></script>
<script src="<?=base_url()?>template/js/bootstrap.min.js"></script>   
<script src="<?=base_url()?>template/js/jquery-waypoints.js"></script>
<script src="<?=base_url()?>template/js/slick.min.js"></script>
<script src="<?=base_url()?>template/js/imagesloaded.min.js"></script>
<script src="<?=base_url()?>template/js/jquery-isotope.js"></script>
<script src="<?=base_url()?>template/js/jquery.prettyPhoto.js"></script>
<script src="<?=base_url()?>template/js/numinate.min.js"></script>
<script src="<?=base_url()?>template/js/circle-progress.min.js"></script>
<script src="<?=base_url()?>template/js/main.js"></script>
<script src="<?=base_url()?>template/js/comboTreejs.js"></script>
<script src="<?=base_url()?>template/js/icontains.js"></script>
<!-- Revolution Slider -->
<script src="<?=base_url()?>template/revolution/js/slider.js"></script>
<!-- SLIDER REVOLUTION 6.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->    
<script  src='<?=base_url()?>template/revolution/js/revolution.tools.min.js'></script>
<script  src='<?=base_url()?>template/revolution/js/rs6.min.js'></script>

<script src="https://apis.google.com/js/platform.js" async defer></script>

<?php  
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
$urlsegment = $this->uri->segment(1);
?>     



<!-- Modal -->
<div class="modal fade" id="change-phoneModal" tabindex="-1" role="dialog" aria-labelledby="change-phoneModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content change-phone-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="change-phoneModalTitle">Add Phone Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="change_phone_number" method="post">
          <div class="form-group">
            <label>Phone Number</label>
            <div class="row">
             <div class="col-md-3">
                <div class="form-group">
                <select class="form-control" id="dial_code" name="dial_code">
                  <option>+971</option>
                  <option>+966</option>
                  <option>+977</option>
                </select>
                </div>
             </div>
             <div class="col-md-9 pl-0">
                <div class="form-group">
                     <input type="phone" id="mobile_number" name="mobile_number" class="form-control"> 
                     <!--<label class="error"></label>-->
                     <label for="mobile_number" class="error-msg" style="color:red;"></label>
                </div>
             </div>
             <input type="hidden" id="m_country_id" name="m_country_id" >
             <div class="col-md-12">
                 <button type="submit" class="otp-btn">Submit</button>
             </div>
             
            </div>
          </div>
        </form>
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
      <!--</div>-->
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalTitle">OTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center container">
    <div class="card">
        <form method="post" id="verifyOtp">
            <div class="d-flex flex-row mt-5">
                <input type="text" name="otpData" id="otpData" class="form-control" autofocus="">
                <input type="hidden" id="otpId" name="otpId">
                <button type="submit" class="otp-btn" id="otpSubmit" >Submit</button>
            </div>
        </form>
        <div class="text-center mt-5">
        <a href="#" class="d-block mobile-text">Don't receive the code?</a>
        <a href="#" class="font-weight-bold text-success cursor" id="resendOTP">Resend</a>
        </div>
    </div>
</div>
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
      <!--</div>-->
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><img src="<?php echo base_url();?>frontend_assets/images/logo/logo.png" alt="" class="logo"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form_pannel">
       
       <!--start form 1-->   
      <div class="form1">    
          
        <ul>
            <!--<li><button class="fb-login login_btn">Facebook</button></li>-->
            <!--<li><a href="<?php echo base_url();?>hauth/login/Google"><button class="google-login login_btn">Google</button></a></li>-->
            <li><div class="g-signin2" data-width="60" data-height="60" data-longtitle="true" data-onsuccess="onSignIn"></div></li>
            <!-- <li><div class="g-signin2" data-width="60" data-height="60" data-longtitle="true"></li> -->
            <li> <p>or<br>Log in or sign up with email</p></li>
        </ul>
        <div class="row sign_part">
           <div class="col-md-6 col-sm-6 sign login" id="loginModal"><button>Login</button></div>
           <div class="col-md-6 col-sm-6 sign sign_up"><button>Sign Up</button></div>
           <p>By signing up you agree to our <a target="_blank" href="<?php echo base_url()?>articles/1">Terms of Use</a> and <a target="_blank" href="<?php echo base_url()?>articles/10">Privacy Policy.</a></p>
        </div>
        
      </div><!--end form 1-->
      
      
      <!--start form 2 login-->
      <div class="form2 login_page col-md-12">
          <form id="loginForm" autocomplete="off">
              <ul>
                  <li class="rorm-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" txt_user_email="email" name="txt_user_email">
                      <input type="hidden" class="form-control" id="loginAsRequest" value="0">
                  </li>
                  
                 
                        
                  
                  <li class="rorm-group">
                      <label>Password</label>
                      <div class=" password-eye-wrapper">
                         <input type="password" class="form-control" id="txt_user_pwd" name="txt_user_pwd">
                         
                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                        </div>
                        
                  </li>
                  
                  <li class="forgot">
                      <!--<a href="<?php echo base_url();?>forgot_password">Forgot password?</a>-->

                       <a id="forgot_password" href="javascript:void(0);">Forgot password?</a> 
                  </li>
                  
                  <li><button class="my_login" id="loginBtn">Login</button></li>
              </ul>
          </form>
          
      </div>
      <!--end form 2 login-->
      
      
      <!--start form 3 sign up-->
      <div class="form3 sign_up_page col-md-12" id="userSignup">
          <form id="userForm" autocomplete="off" method="post">
              <ul>
                  <li class="form-group">
                      <label>First Name</label>
                      <input type="name" class="form-control" id="txt_first_name" name="txt_first_name">
                      <input type="hidden" id="registerAsRequest" value="0">
                  </li>
                  
                  <li class="form-group">
                      <label>Last Name</label>
                      <input type="txt_last_name" class="form-control" id="txt_last_name" name="txt_last_name">
                  </li>
                  <li class="form-group" style ="display:none;">
                      <label>Company Name</label>
                      <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" maxlength="100">
                  </li>
                  
                  <li class="form-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" id="txt_email" name="txt_email">
                  </li>
                  
                  <li class="form-group">
                      <label>Password</label>
                      
                       <div class=" password-eye-wrapper">
                         <input type="password" class="form-control" id="txt_password" name="txt_password">
                         
                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                        </div>
                        
                        
                    
                  </li>
                  
                  <li class="form-group">
                      <label>Country</label>
                      
                       <div class=" password-eye-wrapper">
                            <select class="form-control" id="country_id" name="country_id">
                                
                            </select>
                        </div>
                        
                        
                    
                  </li>
                  
                  <li class="form-group nuber-text">
                        <label>Contact Number</label>
                        
                        <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"> 
        
        <input type="text"  maxlength="5" id="txt_dial" name="txt_dial" readonly="" placeholder="Dial code"   style="padding: 0;background: transparent;border:0; width: 90px;">
</span>
  </div>
                    <input type="text" class="form-control number" maxlength="10" id="txt_phone" name="txt_phone" placeholder="Contact Number" style="border-radius: 0px 5px 5px 0px;">

</div>


                </li>
                  <li class="pf">
                  <p>
                    <label class="custom_check">
By clicking below and creating an account, I agree to<br> Vhelp <a target="_blank" href="<?php echo base_url()?>articles/1">Terms of Service</a> and <a target="_blank" href="<?php echo base_url()?>articles/10">Privacy Policy.</a>
                      <input type="checkbox" name="txt_agree">
                      <span class="checked"></span>
                    </label>
                      </p>
                  </li>
                  
                  <li class="createaccount">
                      <button id="btnRegister" class="loaderButton">Create account<span id="registerLoader1"></span></button>
                  </li>
              </ul>
          </form>
      </div>
      <!--end form 3 sign up-->
         <div class="col-md-12" id="userOtp" style="display:none;">
          <form id="userOtpForm" autocomplete="off" method="post">
               <div class="alert alert-danger" id="OtpError" style="display:none">
              
               </div>
               <div class="alert alert-success" id="OtpErrorSuc" style="display:none">
              
               </div>
              <ul>
                  <li class="form-group">
                      <label>Enter otp</label>
                      <input type="password"   class="form-control" id="txt_otp" name="txt_otp" maxlength="4">
                      <input type="hidden" class="form-control" id="txt_ver" name="txt_ver">
                  </li>
                  <li>
                      <ul>
                          <li style="display:inline">
                               <button class="my_login" id="submitOtp" style="position:relative;width:auto;margin-left:10px;padding: 10px 70px;">Submit<span id="registerLoaderOtp" ></span></button>
                          </li>
                             <li  style="display:inline">
                               <button class="my_login" id="resendOtp" style="position:relative;width:auto;margin-left:10px;padding: 10px 44px;">Resend OTP<span id="registerLoaderresendOtp" ></span></button>
                          </li>
                      </ul>
                      
                     </li>
               </ul>
            </form>
          </div>


            <!--start form 4 Forgot Password-->
            
             <div class="forgot_pass_page col-md-12">
              <form id="forgotPsaForm" autocomplete="off" method="post">
                  <ul>
                      
                      <li style="text-align: center"><h4>Forgot Password</h4></li>
                      <li class="rorm-group">
                          <label>Email Address</label>
                          <input type="text"  name="txt_email" class="form-control"  placeholder="<?php echo $this->lang->line('email'); ?>" value="">
                      </li>
                      
                      <li><button class="my_login" id="btnForgotPwd" type="submit">Submit</button></li>
                  </ul>
             
              </form>
          </div> 
           
          <!--end form 4 Forgot Password-->
                  
        
      </div>

    </div>
  </div>
</div>


<?php

$admin_basics        =   $this->M_common->getAdminBasics();
// print_r($admin_basics);
?>
<!-- Footer -->
        <footer class="footer cmt-bgcolor-darkgrey widget-footer clearfix">
            <div class="second-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 widget-area">
                            <div class="widget widget_text clearfix">
                                <div class="footer-logo">
                                    <img id="footer-logo-img" class="img-center" src="<?= base_url(); ?>template/images/footer-logo.png" alt="footer-logo">
                                </div>
                                <ul class="widget_contact_wrapper">
                                    <li><i class="fa fa-map-marker cmt-textcolor-skincolor"></i>
                                        <?=$admin_basics->address?>
                                    </li>
                                    <li><i class="fa fa-envelope-o cmt-textcolor-skincolor"></i><a href="mailto:<?=$admin_basics->email_id?>"><?=$admin_basics->email_id?>
                                    </a></li>
                                    <li><i class="fa fa-phone cmt-textcolor-skincolor"></i><?=$admin_basics->phone_no?></li>
                                </ul>
                                <div class="social-icons pt-30">
                                    <ul class="list-inline">
                                        <li>
                                            <a class="tooltip-top" target="_blank" href="<?=$admin_basics->fb_link?>" data-tooltip="Facebook"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a class="tooltip-top" target="_blank" href="<?=$admin_basics->twitter_link?>" data-tooltip="Twitter"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a class=" tooltip-top" target="_blank" href="<?=$admin_basics->youtube_link?>" data-tooltip="YouTube"><i class="fa fa-youtube-play"></i></a>
                                        </li>
                                        <li>
                                            <a class="tooltip-top" target="_blank" href="<?=$admin_basics->insta_link?>" data-tooltip="instagram"><i class="fa fa-instagram"></i></a>
                                        </li>
            
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 col-6 widget-area">
                            <div class="widget widget_nav_menu">
                               <h3 class="widget-title">Popular Services</h3>
                               <?php
                               $language           = $this->session->userdata("language")>0? $this->session->userdata("language"):1; 
                               $con2['is_home_category']                                 =  0;
                                $con2['service_type_status']                                               =  1;
                                $con2['service_type_language_code']                              =  $language;
                               $popular_cate = $this->M_common->getServiceTypes($con2,5);
                                if(count($popular_cate) > 0)
                                {
                              ?>
                              <ul class="menu-footer-quick-links">
                              <?php

                                foreach ($popular_cate as $rows)
                                {
                                  $dislayName  =  strtolower($rows->service_type_name);
                                  $urlCategoryName  =  $rows->service_type_name;
                                  $string = str_replace(' ', '-', $urlCategoryName); 
                                  $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                                  $urlCategoryName  = strtolower($urlCategoryName);
                                  
                                  $subServices    = $this->M_common->getSubServices($rows->service_type_id);
                                  if(count($subServices) > 0 ){
                                        $url  = base_url('sub_services/').$rows->service_type_id;
                                  }else{
                                      $url = base_url().'request/'. $urlCategoryName.'?sid='.$this->common_functions->encryptId($rows->service_type_id);
                                  }
                              ?>
                                    <li><a href="<?php  echo $url;?>" style="text-transform: capitalize !important;"><?= $dislayName ?></a></li>
                              <?php
                                }
                              ?>
                                <!-- <li><a href="<?php  echo base_url();?>services_list">View More</a></li> -->
                                </ul>
                                 <?php
                                }

                               
                              ?>
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 widget-area">
                            <div class="widget widget_nav_menu useful-links">
                               <h3 class="widget-title">Useful Links</h3>
                                <ul class="menu-footer-quick-links">
                                    <li><a href="<?= base_url(); ?>articles/2">About Us</a></li>
                                    <!--<li><a href="#">Blog</a></li>-->
                                    <!--<li><a href="<?= base_url(); ?>provider_reg"> Join as a Partner</a></li>-->
                                    <li><a href="<?=base_url()?>contact">Contact Us</a></li>
                                    <li><a href="<?= base_url(); ?>articles/1">Terms and Conditions</a></li>
                                    <li><a href="<?= base_url(); ?>articles/10">Privacy policy</a></li>
                                 </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 widget-area">
                            <div class="widget widget-text">
                                <h3 class="widget-title">Newsletter Signup</h3>
                                <p>Subscribe To Our Newsletter And Get 10% Off Your First Order</p>
                                <form  id="subscribe-form" class="newsletter-form" method="post" action="#" data-mailchimp="true">
                                    <div class="mailchimp-inputbox" id="subscribe-content"> 
                                        <p>
                                            <input type="email" name="txt_user_email" id="txt_user_email" placeholder="Email ID">
                                        </p>
                                        <p><button type="submit" id="subscribeBtn" class="cmt-btn cmt-btn-size-md cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-skincolor">Subscribe</button></p>
                                    </div>
                                    <div id="subscribe-msg"></div>
                                </form>
                                <div class="mt-30 apps">
                                    <img class="img-fluid" src="<?= base_url(); ?>template/images/playstore.png" alt="cards">
                                    <img class="img-fluid" src="<?= base_url(); ?>template/images/applestore.png" alt="cards">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-footer-text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="copyright">
                                <div class="row">
                                    <div class="col-md-12 p-0">
                                        <span>© 2020&nbsp;<a href="#">VEE HELP TECHNOLOGIES PVT LTD. INDIA</a></span>
                                    </div>
                                  <!--   <div class="col-md-5 p-0">
                                        <div id="menu-footer-menu" class="d-flex align-items-center justify-content-end">
                                            <ul class="footer-nav-menu">                  
                                                <li><a href="#"><b>Active In</b></a></li>
                                                <li><a href="#">Al Basha</a></li>
                                                <li><a href="#">Al Furjan</a></li>
                                                <li><a href="#">Al Jaddaf</a></li>
                                            </ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            

        </footer>
        <!-- Footer end-->

        <!--back-to-top start-->
        <a id="totop" href="#top">
            <i class="fa fa-angle-up"></i>
        </a>
        <!--back-to-top end-->

    </div><!-- page end -->

    <!-- Javascript -->

</body>

<!-- Mirrored from www.cymolthemes.com/html/mrhandy/cleaning/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Mar 2021 06:56:50 GMT -->
</html>

  </body>
</html>
<script>        
setTimeout(function () {
        $('#DivID div div span span:last').text("Sign up with Google");
        $('#DivID div div span span:first').text("Sign up with Google");
    }, 3000);

  $(document).ready(function () {
$('#txt_appdate').datepicker({
    format: 'dd-mm-yyyy',
    startDate: new Date(),
});
});
  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#userForm").submit();
    });
 
       var validator=$("#userForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_first_name: 
          {
            required: true,
           maxlength:100,
           // lettersonly:true,
            
          },
          txt_last_name: 
          {
            required: true,
           maxlength:100,
           // lettersonly:true,
          },
           txt_email: 
          {
            required: true,
           email: true,
           maxlength:100,
          },   
            
         select_country: 
          {
            required: true,
            number:true
          },
         txt_password: 
          {
              required: true,
               minlength: 8,
               maxlength:20 ,
               // passwordCheck:true
          },
        'select_city': 
          {
            required: true,
            number:true
          },
         'txt_phone': 
          {
            required: true,
            minlength: 5,
           maxlength:10,
           number:true
          },
        'txt_zip': 
          {
            required: true,
            number:true,
            minlength: 5,
            maxlength:6,
          },
          'txt_building': 
          {
            required: true,
           maxlength:100,
           specialChars:true,
          },
         'txt_apprtment': 
          {
             required: true,
           maxlength:100,
           specialChars:true,
          },
          'txt_area': 
          {
              required: true,
             maxlength:100,
             specialChars:true,
          },
          'txt_company_name': 
         {
             maxlength:100
         },
          'txt_agree': 
         {
             required:true
         },
         'country_id':{
             required:true
         },
		  
        },
        messages: 
        {
            txt_first_name:{
                required : 'First name is required',
            },
            txt_last_name:{
                required : 'Last name is required',
            },
            txt_email:{
                required : 'Email is required',
            },
            country_id:{
                required : 'Country is required',
            },
            txt_password:{
                required: 'Password is required',
            },
            txt_phone:{
                required: 'Phone number is required',
            },
            txt_agree:{
                required: 'Agree terms of service',
            }
            
        },
        submitHandler: function ()
        {
                $(".errorSpan1").html("");	               
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader1").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");		
                $(".errorSpan1").html();
                //return false;
                dataString = $('#userForm').serialize();
                var formData = new FormData($("#userForm")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/saveUser',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                    $("#registerLoader1").html("");
                    $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                  //   console.log(data['status']);
                   // $("#exampleModal").modal("hide");
                    
                    if(data['status']>0)
                    {
                       
                         // swal("Registration  Successfully completed!");
                         // $("#loginModal").trigger("click");
                         // window.location="<?php echo base_url(); ?>admin/user_list";
                          $("#userOtp").css("display","block");
                          $("#userSignup").css("display","none");
                          $(".forgot_pass_page").css("display","none");
                          
                          $(".form1").css("display","none");
                          $("#txt_ver").val(data['ver']);
                          $('#exampleModal').modal({backdrop: 'static', keyboard: false}) 
                              
                    }
                    else if(data['status']<0)
                    {
                             $("#exampleModal").modal("hide");
                             swal("Email id already exists");
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                             $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

                            });                          
                          }else{ 
                              $("#exampleModal").modal("hide");
                           swal("Failed to save! Try again later");
                          }


                    }
                    else
                    {
                          $("#exampleModal").modal("hide");    
                          swal("Failed to save! Try again later");


                    }

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
 $(document).delegate("#select_country","change",function(e)
    {
	
         var selected = $(this).find('option:selected');
         var dialCode = selected.data('foo'); 
          $("#txt_dial").val(dialCode);
         csrf_value  =   getCookie('csrf_cookie_name');        
         
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/loadCityDropDown',
            type: 'POST',
            data: {countryId:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			{
			 
				 $("#select_city").html(data);
				
                                                                 }
        });
		  
    });
    $("#txt_profile").change(function() {
  readURL(this,'imagePreview');
});

$(document).delegate("#loginBtn","click",function(e)
    {
       
    
         var validator=$("#loginForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_user_email: 
          {
            required: true,
           email: true
            
          },
          txt_user_pwd: 
          {
            required: true
          }	  
        },
       
        messages: 
        {
       
      },
     submitHandler: function ()
        {
			
              
                dataString = $('#loginForm').serialize();
                var formData = new FormData($("#loginForm")[0]);
                formData.append('user_type', '1');
                      csrf_value  =   $("#csrf_token").val()!=""?$("#csrf_token").val():'<?php echo $this->security->get_csrf_hash();?>';
                         csrf_value  =   getCookie('csrf_cookie_name');  
                 formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/userLogin',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                    data =  jQuery.parseJSON(data);
                 $("#exampleModal").modal("hide");

               if(data['status']>0)
                    {
                          window.user_id   = data['status'];
                          window.user_type = data['type'];
                          loginAsRequest =  $('#loginAsRequest').val();                     
                          if(loginAsRequest==1)
                          {
                                var addressType  =  $(".location_button.active").attr("for"); 

                                $("#loactionUpdate").modal("show");
                                $("#selected_address_type").val(addressType);
                                if(addressType==1)
                                {
                                   $("#addressTypeLabel").text("Home");
                                }
                                else if(addressType==2)
                                {
                                   $("#addressTypeLabel").text("Office");
                                }
                                else
                                {
                                   $("#addressTypeLabel").text("Other");
                                }
                              $( "#link_myaccout" ).replaceWith( '<li class="nav-item" id="link_myaccout"><a class="nav-link" href="<?php echo base_url()?>myaccount" >My Account</a></li>' );
                              sessionStorage.removeItem('lastAction');
                              // location.reload();
                          }
                          else
                          {
                              swal( "<?php echo $this->lang->line('login_success'); ?>"); 
                              userType = '<?=$this->session->userdata('eq_user_id')?>';
                            //   alert(userType);
                              if(userType== 2)
                                window.location = "<?=base_url()?>vhelp2/myaccount";
                              else
                                window.location="<?php echo $CurPageURL ;?>";
                          }
                            
                    }
                    else if(data['status']==-1)
                    {
                             swal("<?php echo $this->lang->line('account_not_approved'); ?>"); 
                    }
                    else if(data['status']==0)
                    {
                              
                        swal('Invalid Email address/ Password');//swal("<?php echo $this->lang->line('login_failed'); ?>"); 


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
  
  $(document).delegate("#submitOtp","click",function(e)
    {
       
    
         var validator=$("#userOtpForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_otp: 
          {
            required: true,
            number: true,
            maxlength:4
            
          }
        },
       
        messages: 
        {
       
      },
     submitHandler: function ()
        {
			
              
               $("#submitOtp").attr("disabled", "disabled");
                $("#registerLoaderOtp").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none;position: absolute;top: -27px;left: 40%;'>");
               // return false;
                $("#OtpError").css("display","none");
                var formData = new FormData($("#userOtpForm")[0]);
                //formData.append('user_type', 'U');
                csrf_value  =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                     $.ajax({
             url: '<?php echo base_url();?>website/User/verifyOtp',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   $("#registerLoaderOtp").html("");  
                   $("#submitOtp").prop("disabled", false);
                 data =  jQuery.parseJSON(data);
                 $("#otpError").html(""); 
                 $("#txt_otp").html("");
                  $("#txt_ver").html("");
                   $("#otpError").html(""); 
                   $("#OtpError").css("display","none");
                   $("#OtpErrorSuc").css("display","none");
                   $("#OtpErrorSuc").html(""); 
                   $("#txt_otp").val("");
               if(data['status']>0)
                    {
                         
                          swal("Registration  Successfully completed!");
                          
                          registerAsRequest =  $("#registerAsRequest").val();                     
                           location.reload();
                          if(registerAsRequest==1)
                          {

                               // $("#userSignup").css("display","block");                                
                               // $(".form1").css("display","none");
                                //alert();
                                $("#userOtp").css("display", "none");
                                $("#loginAsRequest").val(1);      
                                $("#loginModal").trigger("click");
                                //sessionStorage.clear();
                                return false;
                          }
                          else
                          {
                              $("#exampleModal").modal("show");
                          }
                          
                        $('#exampleModal').modal('hide');
                    }
                    else if(data['status']==-1)
                    {        $("#OtpError").css("display","block");
                             $("#OtpError").html("<strong>Danger!</strong> OTP has been expired."); 
                    }
                    else if(data['status']==-2)
                    {
                             $("#OtpError").css("display","block");  
                            $("#OtpError").html(" Invalid OTP."); 


                    }
                    else
                    {
                         $("#OtpError").css("display","block");
                         $("#OtpError").html("<strong>Danger!</strong> Please fill all mandatory fields."); 
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
   $(document).delegate("#resendOtp","click",function(e)
    {
        
        
			
              
                $("#resendOtp").attr("disabled", "disabled");
                $("#registerLoaderresendOtp").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none;position: absolute;top: -27px;left: 40%;'>");
               // return false;
                $("#OtpError").css("display","none");
                var formData = new FormData($("#userOtpForm")[0]);
                //formData.append('user_type', 'U');
                csrf_value   =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                oldOtpId     =  $("#txt_ver").val();
                formData.append( "ver_id", oldOtpId );
               
                     $.ajax({
             url: '<?php echo base_url();?>website/User/resendOtp',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   $("#registerLoaderresendOtp").html("");  
                   $("#resendOtp").prop("disabled", false);
                   data =  jQuery.parseJSON(data);
                   $("#otpError").html(""); 
                   $("#OtpError").css("display","none");
                   $("#OtpErrorSuc").css("display","none");
                   $("#OtpErrorSuc").html(""); 
                   $("#txt_otp").html("");
                   $("#txt_ver").html("");

               if(data['status']>0)
                    {
                          $("#OtpErrorSuc").css("display","block");
                          $("#OtpErrorSuc").html("<strong>Success!</strong> OTP send to your mobile and email."); 
                          $("#resendOtp").remove();
                          
                    }
                    else if(data['status']==-1)
                    {        $("#OtpError").css("display","block");
                             $("#OtpError").html("<strong>Danger!</strong> OTP has been expired."); 
                    }
                    else if(data['status']==-2)
                    {
                             $("#OtpError").css("display","block");  
                            $("#OtpError").html("<strong>Danger!</strong> Invalid OTP."); 


                    }
                    else
                    {
                         $("#OtpError").css("display","block");
                         $("#OtpError").html("<strong>Danger!</strong> Please fill all mandatory fields."); 
                    }
                  
                   
               },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
         
    
  });

   $(document).delegate("#btnForgotPwd","click",function(e)
    {
        //alert();
       
         var validator=$("#forgotPsaForm").validate(
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
               // dataString = $('#formForgotPwdOrg').serialize();
                var formData = new FormData($("#forgotPsaForm")[0]);
                    // csrf_value  =   getCookie('csrf_cookie_name');  
                //   formData.append( "<?php echo $this->security->get_csrf_token_name();?>",csrf_value);
                 // formData.append( "<?php echo $this->security->get_csrf_token_name();?>",csrf_value);
                  
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
                          $('#forgotPsaForm')[0].reset();
                          $(".close").trigger("click");
                              
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
  
   $(document).delegate("#link_myaccout","click",function(e)
    {
             $("#userOtp").css("display","none");
             $("#userForm")[0].reset();
             $(".forgot_pass_page").css("display","none");
    });
 </script>
 
 <script type="text/javascript">
   
      $(document).ready(function() 
          {
           
            //addmethod //addmethod //addmethod //addmethod //addmethod
    
jQuery.validator.addMethod("lettersonly", function(value, element) {  
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("letters_only"):"Only letters allowed")?>'); 


jQuery.validator.addMethod("alphnumeric", function(value, element) {  
  return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("letters_numbers_only"):"Only allows letters and numbers")?>'); 

jQuery.validator.addMethod("passwordCheck",
        function(value, element, param) {
            if (this.optional(element)) 
            {
                return true;
                
            } else if (!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i.test(value)) 
            {
                return false;
                
            }

            return true;
        },
        '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("strict_password"):"Password field must contain atleast one letter , number and special charcter")?>');
jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z0-9 \b/\/s_,-]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    },  '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("no_special_char"):"Special characters not allowed")?>');

jQuery.validator.addMethod("greaterThan", 
function(value, element, params) {

    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');

 //addmethod //addmethod //addmethod //addmethod
         } );
            function getCookie(name) {
                var cookieValue = null;
                if (document.cookie && document.cookie != '') {
                    var cookies = document.cookie.split(';');
                    for (var i = 0; i < cookies.length; i++) {
                        var cookie = jQuery.trim(cookies[i]);
                        // Does this cookie string begin with the name we want?
                        if (cookie.substring(0, name.length + 1) == (name + '=')) {
                            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                            break;
                        }
                    }
                }
                return cookieValue;
            }
            function readURL(input,previewControl) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) 
    {
      $('#'+previewControl).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
 function toggleLanguage(value)
        {
            csrf_value  =   getCookie('csrf_cookie_name');
          
                   $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/toggleLanguage',
             type: 'POST',
             data: {value:value,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
             async: true,
             success: function (data) 
                {
                   

                     // alert(data);
                 // console.log(data); 
                  location.reload();

               },
             cache: false
         });

        }
        $(document).delegate(".number","keypress",function(evt)
    {
	var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
			{
			$(this).attr("placeholder","Enter numbers");
             return false;
			}else{

                return true;
			}
	});	

	 $(document).delegate(".number","keyup",function(evt)
    {
       // alert($(this).val());
     /*   
        str = $(this).val();
        
        
        occuranceOfDot = str.replace(/[^.]/g, "").length;
        
        if(occuranceOfDot>1)
        {
             $(this).val("");
             return false;
        }
        
           if (str.indexOf(".") > 0) {
                    var txtlen = str.length;
                    var dotpos = str.indexOf(".");
                    if ((txtlen - dotpos) > 3)
                    {
                       // alert(1);
                        str = str.substring(0, str.length - 1);
                        $(this).val(str);
                    }
                    else
                    {
                       // alert(2);
                    }
                        
                             }*/
        
    });
     $(document).delegate("#btnTopSearch","click",function(evt)
    {
        var topSearch = $("#topSearch").val();
       if(topSearch!="")
       {
           window.location ="<?php echo base_url()?>services_list?s="+topSearch;
       }
        
	});	
       
     $(document).delegate("input:text","keyup",function(event)
    {
          var str =  $(this).val();
       res = str.charAt(0);
      
       st = res.match(/^[^a-zA-Z0-9]+$/) ? true : false;
       if(st==1 && $(this).attr("id")!="mainSearch")
       {
            $(this).val("");
           // $(this).attr("placeholder","First character should not be special character");
           
       }
	});
        $(document).delegate("input:text","paste",function(event)
    {
     
          var str =  $(this).val();
       res = str.charAt(0);
      
       st = res.match(/^[^a-zA-Z0-9]+$/) ? true : false;
       if(st==1 && $(this).attr("id")!="mainSearch")
       {
            $(this).val("");
           // $(this).attr("placeholder","First character should not be special character");
           
       }
	});
	$('#topSearch').keyup(function(){
         $('#sugUl').html("");
        if($(this).val()!="")
        {
            getSuggestion($(this).val());
       
        }
  });
  /*$('#topSearch').focusout(function(){
        $('#search_suggestion').hide();
  });*/
  
  function getSuggestion(keyWord)
  {
              $('#sugUl').html("");
            csrf_value  =   getCookie('csrf_cookie_name');
          
                   $.ajax({
             url: '<?php echo base_url();?>website/Request/getSuggestion',
             type: 'POST',
             data: {search_key:keyWord,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
             async: true,
             success: function (data) 
                {
                   
                   if(data!="")
                   {
                       
                      $('#sugUl').html(data);
                      $('#search_suggestion').show();
                   }

               },
             cache: false
         });
  }
   $(document).delegate("#sugUl .sugLi","click",function(event)
    {
        searchKey  = $(this).attr("for");
         searchva  =  $(this).attr("data-id");
        //alert(searchKey);
        $('#topSearch').val(searchKey);
        $('#search_suggestion').hide();
       // $("#btnTopSearch").trigger("click");
         window.location="<?php echo base_url(); ?>request/"+searchva;
 });

$(document).on('click', function (e) {
   $('#topSearch').val("");
    $('#sugUl').html("");
});

	 $(document).delegate("#link_myaccout2","click",function(event)
    {
          $("#userOtp").css("display","none");
    });
    


    $(document).delegate("#subscribeBtn","click",function(e)
    {
       
    
         var validator=$("#subscribe-form").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_user_email: 
          {
            required: true,
           email: true
            
          },
          
        },
       
        messages: 
        {
       
      },
     submitHandler: function ()
        {
      
              
                var formData = new FormData($("#subscribe-form")[0]);
               
                      csrf_value  =   $("#csrf_token").val()!=""?$("#csrf_token").val():'<?php echo $this->security->get_csrf_hash();?>';
                         csrf_value  =   getCookie('csrf_cookie_name');  
                 formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/usersubscribe',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                    data =  jQuery.parseJSON(data);
                    if(data > 0) {
                       swal( "<?php echo $this->lang->line('subscriber_success'); ?>"); 
                     } else {
                      swal( "<?php echo $this->lang->line('subscriber_failed'); ?>"); 
                     }
                  
                   
               },
               cache: false,
               contentType: false,
               processData: false
             });

                     return false;
      
        
                }
       
 });  
         
    
  });$(document).delegate("#appoinmentBtn","click",function(e)
    {
       
    
         var validator=$("#appoinment_form").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          email: 
          {
            required: true,
           email: true
            
          },
          txt_name: 
          {
            required: true,
            
          },
          comments: 
          {
            required: true,
            
          }, 
          phone: 
          {
            required: true,
            
          },
          
        },
       
        messages: 
        {
       
      },
     submitHandler: function ()
        {
      
              
                var formData = new FormData($("#appoinment_form")[0]);
               
                      csrf_value  =   $("#csrf_token").val()!=""?$("#csrf_token").val():'<?php echo $this->security->get_csrf_hash();?>';
                         csrf_value  =   getCookie('csrf_cookie_name');  
                 formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                    $.ajax({
             url: '<?php echo base_url();?>website/User/saveContactus',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                    data =  jQuery.parseJSON(data);
                    if(data > 0) {
                       swal( "Message sent successfully"); 
                     } else {
                      swal( "Failed to send message"); 
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
  
$('#search_query_top').on('keyup', function() {
    var searchKey = this.value;
    $.ajax({
        url: '<?php echo base_url();?>website/User/searchServicesList',
        type: 'POST',
        data: {searchKey : searchKey},
        async: true,
        dataType:'json',
        success: function (response){
            $('#search-result').html(response.oData);
        },
    });
    return false;
});




        $("body").on('click', '.toggle-password', function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#txt_user_pwd");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
        
        
        $("body").on('click', '.toggle-password', function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#txt_password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
        
        // txt_password
        
        
        
</script>



<script type="text/javascript">

// var SampleJSONData = [
//     {
//         id: 0,
//         title: 'Horse'
//     }, {
//         id: 1,
//         title: 'Birds',
// 		isSelectable: false,
//         subs: [
//             {
//                 id: 10,
//                 title: 'Pigeon',
// 				isSelectable: false
//             }, {
//                 id: 11,
//                 title: 'Parrot'
//             }, {
//                 id: 12,
//                 title: 'Owl'
//             }, {
//                 id: 13,
//                 title: 'Falcon'
//             }
//         ]
//     }, {
//         id: 2,
//         title: 'Rabbit'
//     }, {
//         id: 3,
//         title: 'Fox'
//     }, {
//         id: 5,
//         title: 'Cats',
//         subs: [
//             {
//                 id: 50,
//                 title: 'Kitty'
//             }, {
//                 id: 51,
//                 title: 'Bigs',
//                 subs: [
//                     {
//                         id: 510,
//                         title: 'Cheetah'
//                     }, {
//                         id: 511,
//                         title: 'Jaguar'
//                     }, {
//                         id: 512,
//                         title: 'Leopard'
//                     }
//                 ]
//             }
//         ]
//     }, {
//         id: 6,
//         title: 'Fish'
//     }
// ];
// var SampleJSONData2 = [
//     {
//         id: 1,
//         title: 'Four Wheels',
// 		subs: [
// 			{
// 				id: 10,
// 				title: 'Car'
// 			}, {
// 				id: 11,
// 				title: 'Truck'
// 			}, {
// 				id: 12,
// 				title: 'Transporter'
// 			}, {
// 				id: 13,
// 				title: 'Dozer'
// 			}
// 		]
//     }, {
//         id: 2,
//         title: 'Two Wheels',
//         subs: [
//             {
//                 id: 20,
//                 title: 'Cycle'
//             }, {
//                 id: 21,
//                 title: 'Motorbike'
//             }, {
//                 id: 22,
//                 title: 'Scooter'
//             }
//         ]
//     }, {
//         id: 2,
//         title: 'Van'
//     }, {
//         id: 3,
//         title: 'Bus'
//     }
// ];


// var comboTree1, comboTree2;

// jQuery(document).ready(function($) {

// 		comboTree1 = $('#justAnInputBox').comboTree({
// 			source : SampleJSONData,
// 			isMultiple: true,
// 			cascadeSelect: false,
// 			collapse: true,
// 			selectableLastNode: true

// 		});
		
// 		comboTree3 = $('#justAnInputBox1').comboTree({
// 			source : SampleJSONData,
// 			isMultiple: true,
// 			cascadeSelect: true,
// 			collapse: false
// 		});

// 		comboTree3.setSource(SampleJSONData2);


// 		comboTree2 = $('#justAnotherInputBox').comboTree({
// 			source : SampleJSONData,
// 			isMultiple: false
// 		});
// });

    var SampleJSONData2 = [];
    SampleJSONData2     = '<?=$service_list?>';
    if(SampleJSONData2)
        SampleJSONData2     = JSON.parse(SampleJSONData2);
    
    var comboTree3;
    
    jQuery(document).ready(function($) {
    		
    		comboTree3 = $('#justAnInputBox1').comboTree({
    			source : SampleJSONData2,
    			isMultiple: true,
    			cascadeSelect: true,
    			collapse: false,
    // 			selected: ['0']
    		});
    		
    		$("#justAnInputBox1").change(function(){
                ids = comboTree3.getSelectedIds();
                $('#txt_service').val(ids);
        });
    

    });
    
    
  
  
</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<script>
      $('#customFile1').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#customFile1')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('.sign_up').click(function(){
     $.ajax({
             url: '<?php echo base_url();?>website/User/getCountryList',
             type: 'POST',
             async: true,
             success: function (data) {
                $('#country_id').html(data);
                $('#dial_code').html(data); 
                
             }
     });
});
// $('#country_id').change(function(e){
$(document).delegate("#country_id","change",function(e){

    var dialCode = $("#country_id option:selected").attr('foo');
    if(dialCode > 0)
	    $("#txt_dial").val('+'+dialCode);
	else
	    $("#txt_dial").val('');
});

// $(document).delegate("#otpSubmit","click",function(e){
//          $("#verifyOtp").submit();
        
//  });
 
 var validator = $('#verifyOtp').validate({
    ignore: [],
    rules:{
        otpData : {
            required: true,
            maxlength:4,
            minlength:4,
        }    
    },
    
    messages:{
       
    },
    
    submitHandler: function (){
        var otpData  = $('#otpData').val();
        var otpId    = $('#otpId').val();
        // console.log(formData);
        $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>website/User/changePhoneNumberVerify',
            data: {otpData:otpData,otpId:otpId},
            success: function (data) {
              if(data > 0){
                $('#otpModal').modal("hide");
                swal('phone verified successfully');
              }else{
                swal('Failed to verify OTP');
              }
            }
        });
    }
 });
 
 $('#resendOTP').click(function(){
     var otpId = $('#otpId').val();
     $.ajax({
            type: 'post',
            url: '<?php echo base_url();?>website/User/resendOtp',
            data: {txt_ver:otpId},
            success: function (data) {
              if(data){
                swal('OTP send successfully');
              }else{
                swal('Failed to send OTP');
              }
            }
        });
 });
 
 
 
 var validator = $('#formDynamicAddress').validate({
        
        ignore: [],
        rules : {
            'pickup-input2' :{
                required : true,

            },
            first_name :{
                required : true,
            },
            'last_name' : {
                required : true,
            },

            'email' : {
                required :true,
                email:true
            },

            'user_phone' : {
                required : true,
            },

            'country' :{
                required : true,
            },

            'city' : {
                required : true,
            },

            'area' : {
                required : true,
            },
            'street_name' : {
                required : true,
            },
            'building_name' :{
                required : true,
            }


        },
        messages : {
            'pickup-input2' :{
                required : "Location  is required",
            },
            first_name :{
                required : "First name  is required",
            },
            'last_name' : {
                required : "Last name  is required",
            },

            'email' : {
                required :"Email id  is required",
                email: "Enter a valid email"
            },

            'user_phone' : {
                required : "Mobile number  is required",
            },

            'country' :{
                required : "Country name is required",
            },

            'city' : {
                required : "City name is required",
            },

            'area' : {
                required : "Area name is required",
            },
            'street_name' : {
                required : "Street name is required",
            },
            'building_name' :{
                required : "Building name is required",
            }
        },
        
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
            $(".form-errors").html("All fields must be completed before you submit the form.");
        },

        submitHandler : function(){
            // alert('Hai');
            // switchStatus = $('#defalut_address').is(':checked');
            // if ($('#defalut_address').is(":checked"))
                // alert('defalut address');
                // alert('Hi');
            var formData = new FormData($("#formDynamicAddress")[0]);
            $.ajax({
                url: '<?php echo base_url();?>website/Request/saveUserAddress',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data){
                    data =  jQuery.parseJSON(data);
                    if(data['status']==1){
                        $('#form_id').trigger("reset");
                        $('#addressBook').modal('hide'); 
                        swal(data['message']);
                        getAddressList();
                    }else{
                        if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value){
                                $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
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
    
    
     $(document).delegate('.removeAddress','click',function(e){
        debugger
        id = $(this).attr("for");
        deleteThis(id);
    });
    
    function deleteThis(id){
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        
        .then((willDelete) => {
            
            if (willDelete) {
                $.ajax({
                    url: '<?php echo base_url();?>website/Request/deleteAddressData',
                    type: 'POST',
                    data: {id:id},
                    success: function (data){
                        if(data == 1 ){
                            swal('Address deleted successfully');
                            getAddressList();
                        }else if(data == -1 ){
                            swal("Sorry!", "You are trying to delete default address", "error");
                        }else{
                            swal("Sorry!", "Failed to delete address please try again", "error");
                        }
                    }
                });
            }
        });
    }
    
    $('.search_btn').click(function(){
       $('#search_query_top').val(''); 
       $('#search-result').html('');
    });
     
    function onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      var name    = profile.getName();
      var image   = profile.getImageUrl();
      var email   = profile.getEmail();
      var userId  = '<?=$this->session->userdata('eq_user_id')?>';
      
      if(!userId){
          $.ajax({
                url: '<?php echo base_url();?>website/User/socialLogin',
                type: 'POST',
                data: {name:name,email:email,image:image},
                success: function (data){
                        
                    data = JSON.parse(data);
                    if(data['status'] == 1 ){
                        swal(data['message']);
                        $( "#link_myaccout" ).replaceWith( '<li class="nav-item" id="link_myaccout"><a class="nav-link" href="<?php echo base_url()?>myaccount" >My Account</a></li>' );
                        $('#vendorLoginDiv').hide();
                        $('#exampleModal').modal('hide');
                    }else if(data['status'] == 2 ){
                        swal(data['message']);
                    }else if(data['status'] == 3){
                        swal(data['message']);
                        $( "#link_myaccout" ).replaceWith( '<li class="nav-item" id="link_myaccout"><a class="nav-link" href="<?php echo base_url()?>myaccount" >My Account</a></li>' );
                        getDialCode();
                        $('#change-phoneModal').modal('show');
                        $('#vendorLoginDiv').hide();
                        $('#exampleModal').modal('hide');
                    }else{
                        swal(data['message']);
                    }
                }
            });
      }
    }
    
    
    function getDialCode(){
        $.ajax({
             url: '<?php echo base_url();?>website/User/getDialCode',
             type: 'POST',
             async: true,
             success: function (data) {
                $('#dial_code').html(data); 
                
             }
        });
    }
    
    
    var validator = $('#change_phone_number').validate({
        ignore: [],
        rules : {
            dial_code :{
                required: true,
            },
            mobile_number:{
                required: true,
                minlength: 4,
                // maxlength:10,
            }
        },
        messages : {
        
        },
        
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
            $(".form-errors").html("All fields must be completed before you submit the form.");
        },
        
        submitHandler : function(){
    
            // var formData = new FormData($("#change_phone_number")[0]);
            var dial_code = $('#dial_code').val();
            var mobile_number = $('#mobile_number').val();
            var country_id    = $('#m_country_id').val();
            $.ajax({
                 url: '<?php echo base_url();?>website/User/changePhoneNumber',
                 type: 'POST',
                 data:{dial_code:dial_code,mobile_number:mobile_number,country_id:country_id},
                 success: function (data) {
                    data =jQuery.parseJSON(data);
                    
                    if(data['status'] > 0 ){
                        $('.error-msg').html('');
                        $('#otpModal').modal('show');
                        $('#change-phoneModal').modal('hide');
                        $('#otpId').val(data['otp_id']);
                    }else{
                        if(data['errors'] !== ""){
                            
                            $.each(data['errors'], function(key, value) {//alert(key); alert(value);
                                $('[name='+key+']').parents('.form-group').find('.error-msg').html(value);
                            }); 
                        }    
                    }
                }
            });
            return false;
        }
            
    });
     
    $('#dial_code').change(function(e){
    
        var country_id = $("#dial_code option:selected").attr('for');
        $('#m_country_id').val(country_id);
    });
    
</script>

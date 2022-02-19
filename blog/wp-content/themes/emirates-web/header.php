<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Emirates Quotation</title>

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/mediaquery.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_sheet.css"/>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style_new.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/fontawesome.css"/>

    <!--carousel CSS-->
    <link href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css">


  </head>
  <body>
    <!--start header-->
    <header>
        
        
        
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><img src="<?php echo get_template_directory_uri(); ?>/images/logo/logo.png" alt="" class="logo"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form_pannel">
       
       <!--start form 1-->   
      <div class="form1">    
          
        <ul>
            <li><button class="fb-login login_btn">Facebook</button></li>
            <li><button class="google-login login_btn">Google</button></li>
            <li> <p>or<br>Log in or sign up with email</p></li>
        </ul>
        <div class="row sign_part">
           <div class="col-md-6 col-sm-6 sign login"><button>Login</button></div>
           <div class="col-md-6 col-sm-6 sign sign_up"><button>Sign Up</button></div>
           <p>By signing up you agree to our <a href="#">Terms of Use</a> and <a href="">Privacy Policy.</a></p>
        </div>
        
      </div><!--end form 1-->
      
      
      <!--start form 2 login-->
      <div class="form2 login_page col-md-12">
          <form>
              <ul>
                  <li class="rorm-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" id="email">
                  </li>
                  
                  
                  <li class="rorm-group">
                      <label>Password</label>
                      <input type="password" class="form-control" id="pwd">
                  </li>
                  
                  <li class="forgot">
                      <a href="#">Forgot password?</a>
                  </li>
                  
                  <li><button class="my_login">Login</button></li>
              </ul>
          </form>
          
      </div>
      <!--end form 2 login-->
      
      
      <!--start form 3 sign up-->
      <div class="form3 sign_up_page col-md-12">
          <form>
              <ul>
                  <li class="form-group">
                      <label>First Name</label>
                      <input type="name" class="form-control" id="firstName" name="firstName">
                  </li>
                  
                  <li class="form-group">
                      <label>Last Name</label>
                      <input type="lastName" class="form-control" id="lastName" name="lastName">
                  </li>
                  
                  
                  <li class="form-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" id="email" name="email">
                  </li>
                  
                  <li class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" id="pwd" name="pswd">
                  </li>
                  
                  
                    <li class="form-group">
                      <label>Zip code</label>
                      <input type="number" class="form-control" id="zipcode" name="zipcode">
                  </li> 
                  <li class="pf">
                      <p>
                          
By clicking below and creating an account, I agree to<br> TaskRabbit’s <a href="#">Terms of Service</a> and <a href="#">Privacy Policy.</a>
                      </p>
                  </li>
                  
                  <li class="createaccount">
                      <button>Create account</button>
                  </li>
              </ul>
          </form>
      </div>
      <!--end form 3 sign up-->
        
        
      </div>

    </div>
  </div>
</div>
        
        <!--start secrch box-->
        <!-- <div class="search-box">
            <div class="search_box_pannel">
                <input type="text" name="search" placeholder="search">
                <button><i class="fas fa-search"></i></button>
                <button class="close_button">X</button>
            </div>
        </div> -->
        <!--end search box-->
        
        
        
 <div class="container-fluid top_bar">
     <div clss="row">
         <div class="container">
             <div class="row">
               <div class="min-search"><button><i class="fas fa-search"></i>  Search</button></div>
               <div class="register"><a href="<?php echo base_url(); ?>provider_reg">Register as Vendor</a></div>
            </div>
         </div>
     </div>
 </div>
<nav class="navbar navbar-expand-lg navbar-dark bg-fff static-top">
  <div class="container padd_control">
    <div class="row">
<div class="position-control-left">     
    <a class="navbar-brand" href="<?php echo base_url(); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/images/logo/logo.png" alt="" class="logo" />
    </a>

    <!-- <a href="#" class="arabic"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/arabic.png"/></a> -->
</div>   

        
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        
          <aside></aside>
          <aside></aside>
          <aside></aside>
          <aside></aside>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav left_ctrl nav_position">

        <li class="nav-item drop_list"><a class="nav-link" href="#">Services<span><i class="fas fa-angle-down"></i></span></a>
          <ul class="drop_list_pannel">
          
            <li><a href="<?php echo base_url(); ?>request/l2Y=">AC</a></li>
            <li><a href="<?php echo base_url(); ?>request/mw==">Car service</a></li>
            <li><a href="<?php echo base_url(); ?>request/mg==">Cleaning</a></li>
            <li><a href="<?php echo base_url(); ?>request/lw==">Consultant Services</a></li>
            <li><a href="<?php echo base_url(); ?>request/mA==">Contracting Services</a></li>
            <li><a href="<?php echo base_url(); ?>request/l2s=">Driving service</a></li>
            <li><a href="<?php echo base_url(); ?>request/l2c=">Electrical</a></li>
            <li><a href="<?php echo base_url(); ?>request/ng==">Fitness</a></li>
            <li><a href="<?php echo base_url(); ?>request/nw==">Manpower supplies</a></li>
            <li><a href="<?php echo base_url(); ?>request/mQ==">Material Suppliers</a></li>
            <li><a href="<?php echo base_url(); ?>request/l2w=">Pest Control</a></li>
            <li><a href="<?php echo base_url(); ?>request/nA==">Pet care</a></li>
            <li><a href="<?php echo base_url(); ?>request/l2U=">Plumbing</a></li>

       </ul>      
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>articles/8">How It Works</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal">Log In</a></li>
        <li class="nav-item search"><button><img src="<?php echo get_template_directory_uri(); ?>/images/icons/search.png"/> Search</button></li>
        <li><a href="<?php echo base_url(); ?>provider_reg" class="vendor">Register as Vendor</a></li>






      </ul>
    </div>

   </div> -->

   </div>


     </div>
    <!--end row-->
  </div><!--end container-->
</nav>
<!--end nav-->
<?php wp_head();?>        
</header>
<!--end header-->

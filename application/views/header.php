    
<?PHP
header('Access-Control-Allow-Origin: *');
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from www.cymolthemes.com/html/mrhandy/cleaning/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Mar 2021 06:53:32 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="vhelp" />
<meta name="description" content="Vhelp " />
<!--<meta name="author" content="https://www.cymolthemes.com/" />-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="google-signin-client_id" content="463653848254-pnmornhohr0j9s3vsdl98q4chj9iq9vo.apps.googleusercontent.com">

<title> VHELP - Home Page</title>

<link rel="shortcut icon" href="images/favicon.ico" />

<!--CSS EQ-->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/comboTreeCss.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>frontend_assets/css/style_sheet.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>frontend_assets/css/style_new.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>frontend_assets/css/jquery-ui.theme.css"/>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/vendor.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/shortcodes.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/main.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/megamenu.css"/>
<!--Customize css style for vhelp new date 28/04/2021. Please update this fible css-->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/custom.css"/>
<!--End-->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>template/css/responsive.css"/>

<!-- REVOLUTION LAYERS STYLES -->
<link rel='stylesheet' id='rs-plugin-settings-css' href="<?=base_url()?>template/revolution/css/rs6.css"> 

<!-- Old CSS start-->
<link rel="stylesheet" href="<?php echo base_url();?>admin_assets/swal/sweetalert.css"> 
<!--carousel CSS-->
<link href="<?php echo base_url();?>frontend_assets/css/owl.carousel.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>frontend_assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>template/css/bootstrap-datepicker.min.css">
<!-- End old CSS -->
<script src="<?=base_url()?>template/js/jquery.min.js"></script>
<!-- old script start -->
<script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/login.js"></script>
<script src="<?php echo base_url();?>admin_assets/js/jquery.validate.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>frontend_assets/js/carosel.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>template/js/bootstrap-datepicker.min.js"></script>
<!-- old script end -->
<!-- Javascript end-->
<style>
    .abcRioButton{
        width:100% !important;
        height:100% !important;
    }
</style>
</head>
<body>

    <!--page start-->
    <div class="page">

        <!--<div id="preloader" class="blobs">-->
        <!--    <div class="loader-blob-center"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--    <div class="loader-blob"></div>-->
        <!--</div>  -->


        <!--header start-->
        <header id="masthead" class="header cmt-header-style-01">
        <?php
            $admin_basics        =   $this->M_common->getAdminBasics();
        // print_r($admin_basics);
        ?>
            <!-- top_bar -->
            <div class="top_bar cmt-bgcolor-darkgrey clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 d-flex flex-row align-items-center">
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><i class="fa fa-phone"></i></div>TOLL FREE 800 VHELP
                            </div>
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><i class="fa fa-envelope-o"></i>
                                </div><a href="mailto:support@vhelptechnologies.com">support@vhelptechnologies.com</a>
                            </div>
                            <!-- <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><i class="fa fa-clock-o"></i></div>Monday - Friday: 10:00 - 19:00
                            </div> -->
                            <div class="top_bar_contact_item top_bar_social ml-auto p-0">
                                <ul class="social-icons d-flex">
                                    <li><a href="<?=$admin_basics->fb_link?>" target="_blank" tabindex="-1"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="<?=$admin_basics->twitter_link?>" target="_blank" tabindex="-1"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="<?=$admin_basics->youtube_link?>" target="_blank" tabindex="-1"><i class="fa fa-youtube-play"></i></a></li>
                                    <li><a href="<?=$admin_basics->insta_link?>" target="_blank" tabindex="-1"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div><!-- top_bar end-->
            <!-- site-header-menu -->
            <div id="site-header-menu" class="site-header-menu cmt-bgcolor-white">
                <div class="site-header-menu-inner cmt-stickable-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <!--site-navigation -->
                                <div class="site-navigation d-flex flex-row">
                                    <!-- site-branding -->
                                    <div class="site-branding mr-auto">
                                        <a class="home-link" href="<?= base_url(); ?>" title="Cleaning" rel="home">
                                            <img id="logo-img" class="img-center" src="<?= base_url();?>template/images/header-logo.png" alt="logo-img">
                                        </a>
                                    </div><!-- site-branding end -->
                                    <div class="btn-show-menu-mobile menubar menubar--squeeze">
                                        <span class="menubar-box">
                                            <span class="menubar-inner"></span>
                                        </span>
                                    </div>
                                    <!-- menu -->
                                    <nav class="main-menu menu-mobile" id="menu">
                                        <ul class="menu">
                                            <li class="mega-menu-item active"><a href="<?= base_url(); ?>">Home</a></li>
                                            <!--<li class="mega-menu-item"><a href="#">Blog</a></li>-->
                                            <?php
                                            if($this->session->userdata("eq_user_id")<=0){
                                            ?>
                                            <li class="mega-menu-item" id="link_myaccout"><a href="#" data-toggle="modal" data-target="#exampleModal" >Login / Sign Up</a></li>
                                            <?php
                                            } else {
                                            ?>
                                            <li class="mega-menu-item"><a href="<?php echo base_url()?>myaccount">My Account</a></li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </nav>
                                    <?php
                                        if(!$this->session->userdata('eq_user_type') ){
                                    ?>
                                        <div class="header_extra d-flex flex-row align-items-center justify-content-end" id="vendorLoginDiv">
                                            <div class="header_btn">
                                                <a class="cmt-btn cmt-btn-size-md cmt-btn-shape-round cmt-btn-style-fill cmt-icon-btn-right cmt-btn-color-dark" href="<?php  echo base_url();?>vendor-login">Login/Register as Vendor<i class="fa fa-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div><!-- site-navigation end-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- site-header-menu end-->
        </header>
        <!--header end-->


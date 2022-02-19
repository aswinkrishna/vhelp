<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Recycle</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/fontawesome.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/font-awesome/fontawesome.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/font-awesome/font-awesome.min.css" />
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/logo/favicon.ico">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css">


</head>

<body>
  <!--start header-->
  <header>
    <!--start nav-->
    <nav class="navbar navbar-expand-lg navbar-light nav-bg">
      <div class="container">
        <a class="navbar-brand logo" href="#"><span><img src="<?php echo get_template_directory_uri(); ?>/images/logo/header-logo.png" /></span>
          <aside><img src="<?php echo get_template_directory_uri(); ?>/images/logo/header-logofff.png" /></aside>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
              <aside></aside>
              <aside></aside>
              <aside></aside>
          </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link menu-link" href="https://recycleassociation.com/home"><span><img
                    src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-1.png" /></span>
                <aside><img src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-1fff.png" /></aside> Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="https://recycleassociation.com/about/"><span><img
                    src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-2.png" /></span>
                <aside><img src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-2fff.png" /></aside> About
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link menu-link js-anchor-link" href="https://recycleassociation.com/home/#work"><span><img
                    src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-3.png" /></span>
                <aside><img src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-3fff.png" /></aside>How It Work
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link menu-link" href="https://recycleassociation.com/blog/"><span><img
                    src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-4.png" /></span>
                <aside><img src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-4fff.png" /></aside> Blog
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link menu-link" href="https://recycleassociation.com/contact"><span><img
                    src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-5.png" /></span>
                <aside><img src="<?php echo get_template_directory_uri(); ?>/images/icons/menu-icons/recycle-menu-5fff.png" /></aside>Contact
              </a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
    <!--end nnav-->
  <?php wp_head();?>   
  </header>
  <!--end header-->
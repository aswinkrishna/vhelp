<?php
    $url            =  $_SERVER['REQUEST_URI'];
    $urlArray  =  explode("/",$url);
    $urlArray    =  array_reverse($urlArray);
    $segment   =  $urlArray[0];
   
      $id                              =      $this->common_functions->decryptId($segment);
      if($segment>0 || $id>0)
      {
          $segment  =  $urlArray[1];
      }
    
  $adminUserid   =  $this->session->userdata('admin_id');
    ?>
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?=base_url()?>frontend_assets/images/avatar.jpg" alt="User Image">
        <div style="margin-left:-15px;">
          <p class="app-sidebar__user-name"><?php  echo $this->session->userdata("admin_display_name"); ?></p>
          <p class="app-sidebar__user-designation"><?php  //echo $this->session->userdata("admin_designation"); ?></p>
        </div>
      </div>
      <ul class="app-menu">
         
          
        <li><a class="app-menu__item <?php if (in_array('dashboard', $urlArray)){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <?php
                                 
                                 $arrayAdminMenu  = array("admin_user_list","add_stafs","list_audit_trial","set_permission");
                                 if (in_array($segment, $arrayAdminMenu))
                                         { 
                                $adminMenuExpanded="is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $adminMenuExpanded="";
                                 }
     $menuId     =  2;
  $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  if($permission->perm_view==1)
  {  
                  
                   ?>
        <!-- <li class="treeview <?php echo $adminMenuExpanded; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="fa fa-users"></i><span class="app-menu__label">&nbsp;Admin Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
        <!--  <ul class="treeview-menu">-->
        <!--    <li><a class="treeview-item <?php if ($segment=='admin_user_list' ||$segment== 'add_stafs' ||$segment== 'set_permission'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/admin_user_list"><i class="fa fa-user"></i> &nbsp;Admin user list</a></li>-->
            <?php /* <li><a class="treeview-item <?php if ($segment=='list_audit_trial'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/list_audit_trial"  rel="noopener"><i class="fa fa-user-secret"></i>&nbsp; Admin audit trail</a></li> */ ?>
           
        <!--  </ul>-->
        <!--</li>-->
        
          <?php
  }
                                 
                                 $arrayUserMenu  = array("user_list","provider_list","add_edit_user","add_edit_provider");
                                 if (in_array($segment, $arrayUserMenu))
                                         { 
                                $userMenuExpanded="is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $userMenuExpanded="";
                                 }
  $menuId        =  3;
  $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  if($permission->perm_view==1)
  {        
                   
                   ?>
        
        <li class="treeview <?php echo $userMenuExpanded; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="fa fa-users"></i><span class="app-menu__label">&nbsp;Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item <?php if ($segment=='user_list' ||$segment== 'add_edit_user'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/user_list"><i class="fa fa-user"></i> &nbsp;User list</a></li>
            <li><a class="treeview-item <?php if ($segment=='provider_list' ||$segment== 'add_edit_provider'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/provider_list" ><i class="fa fa-user-secret"></i>&nbsp; Providers list</a></li>
           
          </ul>
        </li>
         <?php
  }
                                 
                                 $arrayRequestMenu  = array("quotation_list","request_list");
                                 if (in_array($segment, $arrayRequestMenu))
                                         { 
                                $requestMenuExpanded="is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $requestMenuExpanded="";
                                 }
  $menuId      =  9;
  $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  //if($permission->perm_view==1)
  if(0)
  {     
                
                   ?>
         <li class="treeview <?php echo $requestMenuExpanded; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="fa fa-reply-all"></i><span class="app-menu__label">&nbsp;Requests</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <!--<li><a class="treeview-item <?php if ($segment=='quotation_list' ){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/quotation_list"><i class="fa fa-adjust"></i> &nbsp;Quotation list</a></li>-->
            <li><a class="treeview-item <?php if ($segment=='request_list' ){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/request_list" ><i class="fa fa-adjust"></i>&nbsp; Request List</a></li>
           
          </ul>
        </li>
         <?php
  }
                                 
                                 $arrayMastertableMenu  = array("home_page_labels","web_basic","add_edit_banner","banner_list","add_edit_package","package_list","country_list","add_edit_country","city_list","add_edit_city","service_type_list","add_edit_service_type","question_list","add_edit_questions","area_list","add_edit_area","list_coupon","add_edit_coupon","app_slider","add_edit_slider");
                                 if (in_array($segment, $arrayMastertableMenu))
                                { 
                                $masterMenuExpanded="is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $masterMenuExpanded="";
                                 }
   $menuId        =  5;
   $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  if($permission->perm_view==1)
  {    
                 
                   ?>
        <li class="treeview <?php echo $masterMenuExpanded; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Master Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
              <li><a class="treeview-item <?php if ($segment=='country_list' ||$segment== 'add_edit_country'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/country_list"><i class="icon fa fa-circle-o"></i> Country list</a></li>
            <li><a class="treeview-item <?php if ($segment=='city_list' ||$segment== 'add_edit_city'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/city_list"><i class="icon fa fa-circle-o"></i> City  list</a></li> 
            <li><a class="treeview-item <?php if ($segment=='area_list' ||$segment== 'add_edit_area'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/area_list"><i class="icon fa fa-circle-o"></i> Area  list</a></li> 
            <li><a class="treeview-item <?php if ($segment=='service_type_list' ||$segment== 'add_edit_service_type'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/service_type_list"><i class="icon fa fa-circle-o"></i> Service type list</a></li> 
            <li><a class="treeview-item <?php if ($segment=='question_list' ||$segment== 'add_edit_questions'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/question_list"><i class="icon fa fa-circle-o"></i> Question list</a></li> 
             <?php /* <li><a class="treeview-item <?php if ($segment=='package_list' ||$segment== 'add_edit_package'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/package_list"><i class="icon fa fa-circle-o"></i> Package list</a></li> */ ?>
             <li><a class="treeview-item <?php if ($segment=='banner_list' ||$segment== 'add_edit_banner'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/banner_list"><i class="icon fa fa-circle-o"></i> Banner list</a></li> 
              <li><a class="treeview-item <?php if ($segment== 'web_basic'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/web_basic"><i class="icon fa fa-circle-o"></i> Website basic details</a></li> 
               <!--<li><a class="treeview-item <?php if ($segment== 'faq_list'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/faq_list"><i class="icon fa fa-circle-o"></i> Service  FAQ list</a></li> -->
               <li><a class="treeview-item <?php if ($segment== 'home_page_labels'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/home_page_labels"><i class="icon fa fa-circle-o"></i> Home page labels</a></li> 
            <li><a class="treeview-item <?php if ($segment== 'app_slider' || $segment=='add_edit_slider'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/app_slider"><i class="icon fa fa-circle-o"></i> App Slider</a></li> 
              <li><a class="treeview-item <?php if ($segment== 'promotion_slider' || $segment=='add_edit_promotion_slider'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/promotion_slider"><i class="icon fa fa-circle-o"></i> Promotion Slider</a></li> 
            <li><a class="treeview-item <?php if ($segment== 'list_coupon'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/list_coupon"><i class="icon fa fa-circle-o"></i> Coupons </a></li> 
          </ul>
        </li>
        <?php
  }
                                 
                                 $arrayReportsMenu  = array("user_report","provider_report","service_type_report","job_request_report");
                                 if (in_array($segment, $arrayReportsMenu))
                                { 
                                     
                                       $arrayReportsMenu="is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $arrayReportsMenu="";
                                 }
   $menuId        =  7;
   $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  if($permission->perm_view==1)
  {              
                  
                   ?>
        <li class="treeview <?php echo $arrayReportsMenu; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
              <li><a class="treeview-item <?php if ($segment=='user_report'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/user_report"><i class="icon fa fa-circle-o"></i> User report</a></li>
              <li><a class="treeview-item <?php if ($segment=='provider_report'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/provider_report"><i class="icon fa fa-circle-o"></i> Provider report</a></li>
            <!--<li><a class="treeview-item <?php if ($segment=='service_type_report'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/service_type_report"><i class="icon fa fa-circle-o"></i> Service type report</a></li>-->
             <li><a class="treeview-item <?php if ($segment=='job_request_report'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/job_request_report"><i class="icon fa fa-circle-o"></i> Job request report</a></li>
          </ul>
        </li>
         <?php
  }
                                 
                                 $arrayContentMenu  =       array("rating_list","article_type_list","faq_list","article_list","add_edit_article_type","add_edit_article","testimonial_list","add_edit_article_type");
                                 
                                 if (in_array($segment, $arrayContentMenu))
                                { 
                                     
                                       $arrayContentMenu    =   "is-expanded";
                                     
                                 } 
                                 else
                                 {
                                      $arrayContentMenu     =    "";
                                 }
                  
              $menuId        =  6;
   $permission    =  $this->M_admin->getAdminPermissionsByMenu($adminUserid, $menuId);   
  if($permission->perm_view==1)
  {        
                  
                   ?>
         <li class="treeview <?php echo $arrayContentMenu; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-adjust"></i><span class="app-menu__label">Contents</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item <?php if ($segment=='rating_list' || $segment=='rating_list'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/rating_list"><i class="icon fa fa-circle-o"></i> User rating</a></li> 
            <li><a class="treeview-item <?php if ($segment=='article_type_list' || $segment=='add_edit_article_type'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/article_type_list"><i class="icon fa fa-circle-o"></i> Content Type  list</a></li>
            <li><a class="treeview-item <?php if ($segment=='article_list' || $segment=='add_edit_article'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/article_list"><i class="icon fa fa-circle-o"></i> Content list</a></li>
            <li><a class="treeview-item <?php if ($segment=='testimonial_list' || $segment=='add_edit_article_type'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/testimonial_list"><i class="icon fa fa-circle-o"></i> Testimonial</a></li>
            <li><a class="treeview-item <?php if ($segment=='faq_list' || $segment=='add_edit_article_type'){ echo 'active'; } ?>" href="<?php  echo base_url() ;?>admin/faq_list"><i class="icon fa fa-circle-o"></i> Faq</a></li>
          </ul>
        </li>
        
        <?php
  }
        ?>
      </ul>
    </aside>
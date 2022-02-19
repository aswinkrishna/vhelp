<?php
$banner        =   $this->M_common->getActiveBanner();
//print_r($banner);

?>

<!--start banner section-->
<section>
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row banner">
        <div class="banner_wrap">
        <div id="owl-banner" class="owl-carousel owl-theme main_banner_slider">
        <?php foreach($banner as $bann){
        
        $bannerPath = base_url()."uploads/banner/".$bann->banner_image;
        ?>
    	
		  <div class="item">
		      <div  class="bg-banner">
		            <div class="bg-banner-b"></div>
		  <h3 class="main_banner_title">
        <?php echo $bann->banner_title!=""?$bann->banner_title:"" ?>
         <p class="banner_subt">You dream it, we help you realise your dreams. Get in touch with best engineering contractors in UAE.<br> Selecting a vendor now made easy.</p>
         </h3>
       
    
                  <img src="<?php echo $bannerPath;?>" alt="">
       
         </div>
         </div>
		 
		 
		
		<?php
        }
		?>
      </div>
</div>
            <!--start container-->
      <div class="container for_mob_search">
        <div class="row">
        <div class="col-md-10 col-lg-8  auto">
          <!--start row-->
          <form class="min-form" action="#">
        <div class="search_wrap">
            <div class="row">
              <div class="select_list col-md-3 col-3">
                <div class="row">
                <select id="cityDrop">
               <?php
               $language   =  ($this->session->userdata('language')?$this->session->userdata('language'):1);
               $condition  =   array('city_language_code' => $language,'city_status'=>1,'city_country_id'=>2);
               $cityList   =   $this->M_admin->getCitiesCondition($condition);
			 
                             if(isset($cityList) && count($cityList)>0)
                             {
								 ?>
                                       
                                        <option value="" >Select Emirate</option>
                                       
                                       <?php
                              foreach($cityList as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo $rows->city_id; ?>" ><?php echo $rows->city_name; ?></option>
                                       
                                       <?php
                                     }
                              }
               ?>

              </select>
              </div>
            </div>


            <div class="text-filed col-md-8 col-8">
              <div class="row">
                 <input type="text" id="citySearch" name="" placeholder="Need something different?"  autocomplete="off">
                 <div class="search_result" id="search_suggestiondj" style="display: none;">
                  <ul id="sugUl2">              
                 </ul>
              </div>
              </div>
              
            </div>

            <div class="search_button col-md-1 col-1">
              <div class="row">
              <button id="btnCitySearch"><img src="<?php echo base_url();?>frontend_assets/images/icons/search-btn.png"/></button>
              </div>
            </div>


            </div>
            </div>
     
          </form><!--end row-->

          
        </div><!--end col md 8-->

         </div>
      </div>
      <!--end container-->
    </div>
    <!--end row-->


  </div>
  <!--end container fluid-->
  
</section>
<!--end banner section-->






<!--start section-->
<section class="section-first">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--start col md 3-->
                    <div class="col-md-3 col-sm-6 center_panel col-6">
                        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/icon-1.png"/></span>
                        <h4><?php  echo $user_count;?></h4>
                        <h5>Members Worldwide </h5>
                    </div>
                    <!--end col md 3-->
                    
                    
                    <!--start col md 3-->
                    <div class="col-md-3 col-sm-6 center_panel col-6">
                        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/icon-2.png"/></span>
                        <h4><?php echo $completed_count;?></h4>
                        <h5>Jobs Completed</h5>
                    </div>
                    <!--end col md 3-->
                    
                    
                    
                      <!--start col md 3-->
                    <div class="col-md-3 col-sm-6 center_panel col-6">
                        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/icon-3.png"/></span>
                        <h4><?php  echo $vendor_count;?></h4>
                        <h5>Vendors</h5>
                    </div>
                    <!--end col md 3-->
                    
                    
                    
                    
                         <!--start col md 3-->
                    <div class="col-md-3 col-sm-6 center_panel col-6">
                        <span><img src="<?php echo base_url();?>frontend_assets/images/icons/icon-4.png"/></span>
                        <h4><?php echo $turnOver; ?></h4>
                        <h5>Turnover</h5>
                    </div>
                    <!--end col md 3-->                   
                    
                    
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->








<!--start section-->
<section class="section_bg_one">
    

    <!--start container fluid-->
    <div class="container-fluid bg-dbl">
            <h3>
                
        Want to build a house? We are here to help you. <br>  
Select a vendor in simple steps
    </h3>
        <!--start row-->
        <div class="row ">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--strt col md 6-->
                    <div class="col-md-6 auto">
                        <!--start row-->
                        <div class="row">
                            <!--start col md 6-->
                            <div class="col-md-6 col-sm-6 emirats-btn">
                                <?php
                                 $urlCategoryName  =  "Consultant";
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                    $urlCategoryName  = strtolower($urlCategoryName);
                                ?>
                              <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId(1); ?>"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/em-1.png"/></span>Consultant</a>
                            </div>
                            <!--end col md 6-->
                            <?php
                             $urlCategoryName  =  "Contractor";
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                    $urlCategoryName  = strtolower($urlCategoryName);
                            ?>
                            
                             <!--start col md 6-->
                            <div class="col-md-6 col-sm-6 emirats-btn">
                              <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId(2); ?>"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/em-2.png"/></span>Contractor</a>
                            </div>
                            <!--end col md 6-->                           
                            
                            
                        </div>
                        <!--end row-->
                        <?php
                             $urlCategoryName  =  "Material Suppliers";
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                    $urlCategoryName  = strtolower($urlCategoryName);
                            ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 btm_border auto">
                              <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId(3); ?>"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/bx.png"/></span>Material Suppliers</a>
                            </div>
                            <?php
                             $urlCategoryName  =  "Manpower Supply";
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                    $urlCategoryName  = strtolower($urlCategoryName);
                            ?> 
                            
                             <div class="col-md-6 col-sm-6 btm_border auto">
                              <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId(9); ?>"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/manpower.png"/></span>Manpower Supply</a>
                            </div>
                        </div>
                    </div>
                    <!--end col md 6-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->




<!--sgtart section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid min_services">
        <!--start row-->
        <div class="row main">
            <h3><?php echo $this->session->userdata("language")==2?$labels->home_labels_arabic1:$labels->home_labels1; ?></h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row padd-left">
                    <div id="owl-example" class="owl-carousel row">
               <?php
                        if(count($popular_cate) > 0)
                        {
                            foreach ($popular_cate as $rows)
                                    
                        {
                                $image = ($rows->service_type_thumbnail!=""? base_url()."uploads/service_type/".$rows->service_type_thumbnail:"");
                                $urlCategoryName  =  $rows->service_type_name;
                                $string = str_replace(' ', '-', $urlCategoryName); 
                                $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                                $urlCategoryName  = strtolower($urlCategoryName);
                                
                        ?>
                        <div class=" custom_mrgn">
               <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                <div class="col-md-12 fff custom content-drop">
                    <div class="min-cover-slider">
                        <div class="title-cover"><h4><?php  echo substr($rows->service_type_name,0,19);?><?php echo strlen($rows->service_type_name)>19?"...":""?></h4></div>
                    
                    <img src="<?php echo $image;?>"/>
                    </div>
                </div></a>
              </div>
              
              <?php
                        }
                        }
                        ?>
</div>       
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
        
    </div>
    <!--end container fluid-->
</section>
<!--end section-->







<!--start section-->
<!--sgtart section-->
<section class="light-bg-for-services">
    <!--start container fluid-->
    <div class="container-fluid min_services">
        <!--start row-->
        <div class="row main">
            <h3><?php echo $this->session->userdata("language")==2?$labels->home_labels2_arabic:$labels->home_labels2;?></h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row padd-left">
                    <div id="owl-example2" class="owl-carousel row">
                        <?php
                        if(count($non_home_cate) > 0)
                        {
                            foreach ($non_home_cate as $rows)
                                    
                        {
                                $image = ($rows->service_type_thumbnail!=""? base_url()."uploads/service_type/".$rows->service_type_thumbnail:"");
                                $urlCategoryName  =  $rows->service_type_name;
                                $string = str_replace(' ', '-', $urlCategoryName); 
                                $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                                $urlCategoryName  = strtolower($urlCategoryName);
                        ?>
              <div class=" custom_mrgn">
               <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                <div class="col-md-12 fff custom content-drop">
                    <div class="min-cover-slider">
                        <div class="title-cover"><h4><?php  echo substr($rows->service_type_name,0,19);?><?php echo strlen($rows->service_type_name)>19?"...":""?></h4></div>
                    
                    <img src="<?php echo $image;?>"/>
                    </div>
                   </div></a>
              </div>
              
             
                        <?php
                        }
                        }
                        ?>
</div>       
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
        
    </div>
    <!--end container fluid-->
</section>
<!--end section-->





<!--start section-->
<section>
    <!--end container fluid-->
    <div class="container-fluid section-repeat">
        <!--start row-->
        <div class="row main">
            <h3>How it works</h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--start col md 8-->
                    <div class="col-md-8 auto">
                        <!--start row-->
                        <div class="row">
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control block">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/resetlogin.png"/>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col md 4-->
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control media_padd">
                                <!--start row-->
                                <div class="row center_panel position-relative">
                                    <aside>1</aside>
                                    <span></span>
                                    
                                    <div class="line"></div>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control">
                                <!--start row-->
                                <div class="row center_panel_content">
                                    <h3>REGISTER / LOGIN</h3>
                                    <h4>
                                       Login/Register to get instant access to all service providers.
                                 Get free quotes now!

                                    </h4>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->                              
                            
                            
                            
                       <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control none">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/resetlogin.png"/>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col md 4-->
                            
                            
                        </div>
                        <!--end row-->
                        
                        
                        
                        
                        
                        
                        
                        <!--start row-->
                        <div class="row row_margin">
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control none">
                                <!--start row-->
                                <div class="row center_panel">
                                    <aside>2</aside>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control ">
                                <!--start row-->
                                <div class="row center_panel_content">
                                    <h3>Choose your service at EQ</h3>
                                    <h4>
                                       Choose from a huge list of service providers and make life easy.
Get free quotes now!

                                    </h4>
                                   
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col md 4-->
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control block">
                                <!--start row-->
                                <div class="row center_panel">
                                    <aside>2</aside>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control col-padding">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/selectservicess.png">
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->                              
                            
                            
                            
                            
                        </div>
                        <!--end row--> 
                        
                        
                        
                        
                        
                        
                        
                        
                          <!--start row-->
                        <div class="row row_margin">

                            
                        <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control block">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/send-qupte.png">
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control">
                                <!--start row-->
                                <div class="row center_panel">
                                    <aside>3</aside>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            
                            
                                 <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control">
                                <!--start row-->
                                <div class="row center_panel_content">
                                    <h3>Send Job Request to vendors</h3>
                                    <h4>
                                       Place job request and get free quotes instantly.<br>
Pick right vendors who fit your budget.

                                    </h4>
                                   
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col md 4-->  
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control none">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/send-qupte.png">
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4--> 
                            
                            
                            
                            
                        </div>
                        <!--end row-->
                        
                        
                        
                        
                        <!--start row-->
                        <div class="row row_margin">

                           <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control none">
                                <!--start row-->
                                <div class="row center_panel">
                                    <aside>4</aside>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  

                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control">
                                <!--start row-->
                                <div class="row center_panel_content">
                                    <h3>Connect with affordable service providers</h3>
                                    <h4>
                                       Hassle free service from start to end. Request free quotes!<br>
Live smart.

                                    </h4>
                                   
                                </div>
                                <!--end row-->
                            </div>
                            <!--end col md 4-->                         
                            
                            
                            
                            <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control block">
                                <!--start row-->
                                <div class="row center_panel">
                                    <aside>4</aside>
                                   
                                </div>
                                <!--end row-->
                             
                            </div>
                            <!--end col md 4-->  
                            
                            
                            
                            
                        <!--start col md 4-->
                            <div class="col-md-4 col-sm-4 col-control col-padding">
                                <!--start row-->
                                <div class="row">
                                   <img src="<?php echo base_url();?>frontend_assets/images/icons/live.png">
                                </div>
                                <!--end row-->
                             
                            </div>
                        <!--end col md 4-->                      
                            
                            
                            
                            
                        </div>
                        <!--end row-->                        
                        
                    </div>
                    <!--end col md 8-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->


<!--start section-->
<section class="light-bg-for-services">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row main">
            <h3 class="padd-controler">What Vendor Say About Us</h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row padd-left">
                    <div id="owl-example3" class="owl-carousel row">
                        
                        <?php
                        if(count($testimonial)>0)
                        {
                            foreach($testimonial as $rows)
                            {
                                  $image = ($rows->profile_image!=""? base_url()."uploads/user/".$rows->profile_image:"");
                                
                        ?>
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom">
                    <div class="wrapper_fluid">
                        <aside><img src="<?php echo $image;?>"/></aside>
                        <p>
                          <?php echo $rows->testimonial_arabic!="" && $this->session->userdata("language")==2?$rows->testimonial_arabic:$rows->testimonial?>
                        </p> 
                        <div class="bottom_underline"><aside></aside></div>
                        
                        <h4><?php echo $rows->first_name." ".$rows->last_name?></h4>
                        <h5><?php echo $rows->designation_arabic!="" && $this->session->userdata("language")==2?$rows->designation_arabic:$rows->designation?></h5>
                    </div>

                </div>
              </div>
              <?php
                            }
                        }
              ?>
              
</div>       
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->










<?php/*
<!--start section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row main">
            <?php
            
             $articles               =   $this->M_common->getArticles(9);
              echo html_entity_decode($articles->articles_desc) ;
            ?>
            
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->
*/?>

<!--start section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row main">
            <h3 class="padd-controler">Everything You Need To Know... </h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                     <?php
                     //print_r($blogArr);
                     if(!empty($blogArr['item'][0])){
                         ?>
                    <!--start col md 6-->
                    <div class="col-md-6 col-sm-6">
                        <!--start col-fluid-->
                        <div class="col-fluid">
                            <img src="<?php echo $blogArr['item'][0]['post_image'];?>">
                        </div>
                        <!--end col-fluid-->
                    </div>
                    <!--end col md 6-->
                    <?php } ?>
                    
                    
                    <!--start col md 6-->
                    <div class="col-md-6 col-sm-6">
                        <!--start col-fluid-->
                        <div class="col-fluid-panel">
                            <h3><?php echo $blogArr['item'][0]['post_title'];?></h3>
                            <p>
                         <?php $post_content = strip_tags($blogArr['item'][0]['post_content']);
                         $post_url = base_url().'blog/'.$blogArr['item'][0]['post_title'];
                          $out = strlen($post_content) > 150 ? substr($post_content, 0, 150).'<span style="color:#d52d2f;"> <a href="'.$post_url.'"  style="color: #d52d2f;"> Continue reading</a></span>' : $post_content; 
                             echo $out;
                          ?>
                            </p>
                        </div>
                        <!--end col-fluid-->
                    </div>
                    <!--end col md 6--> 
                    
                    
                    
                    
                    <!--start col md 6-->
                    <div class="col-md-6 colm-6">
                        <!--start row-->
                        <div class="row">
                            <!--start col md 6-->
                            <div class="col-md-6 col-sm-6">
                                <!--start col md 12-->
                                <div class="col-md-12 left-margin-block">
                                    <div class="content-img row">
                                        <img src="<?php echo $blogArr['item'][1]['post_image'];?>">
                                    </div>
                                    
                                </div>
                                <!--end col md 12-->
                            </div>
                            <!--end col md 6-->
                            
                            
                            
                            
                            
                            <!--start col md 6-->
                            <div class="col-md-6 col-sm-6">
                        <!--start col-fluid-->
                        <div class="col-fluid-panel-wrapp">
                            <h3><?php echo $blogArr['item'][1]['post_title'];?></h3>
                            <p>
                             <?php $post_content = strip_tags($blogArr['item'][1]['post_content']);
                             $post_url = base_url().'blog/'.$blogArr['item'][1]['post_title'];
                             $out = strlen($post_content) > 80 ? substr($post_content, 0, 80).'<span style="color:#d52d2f;"> <a href="'.$post_url.'"  style="color: #d52d2f;"> Continue reading</a></span>' : $post_content; 
                             echo $out;
                             ?>
                        
                            </p>
                        </div>
                        <!--end col-fluid-->
                    </div>
                            <!--end col md 6-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end col md 6-->
                    
                    
                    
                    <!--start col md 6-->
                    <div class="col-md-6">
                        <!--start row-->
                        <div class="row">
                            <!--start col md 6-->
                            <div class="col-md-6 col-sm-6">
                                <!--start col md 12-->
                                <div class="col-md-12 left-margin-block-right">
                                    <div class="content-img row">
                                        <img src="<?php echo $blogArr['item'][2]['post_image'];?>">
                                    </div>
                                    
                                </div>
                                <!--end col md 12-->
                            </div>
                            <!--end col md 6-->
                            
                            
                            
                            
                            
                            <!--start col md 6-->
                            <div class="col-md-6 col-sm-6">
                        <!--start col-fluid-->
                        <div class="col-fluid-panel-wrapp">
                            <h3><?php echo $blogArr['item'][2]['post_title'];?></h3>
                            <p>
                             <?php     $post_content = strip_tags($blogArr['item'][2]['post_content']);
                             $post_url = base_url().'blog/'.$blogArr['item'][2]['post_title'];
                             $out = strlen($post_content) > 80 ? substr($post_content, 0, 80).'<span style="color:#d52d2f"> <a href="'.$post_url.'"  style="color: #d52d2f;"> Continue reading</a></span>' : $post_content; 
                             echo $out;
                            ?>
                        
                            </p>
                        </div>
                        <!--end col-fluid-->
                    </div>
                            <!--end col md 6-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end col md 6-->                    
                    
                    
                    
                </div>
                <!--end row-->
            </div>
            <!--end container-->        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->
        
    







<!--start section-->
<section class="section_bg_one">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <?php
            
            $articles               =   $this->M_common->getArticles(11);
              echo html_entity_decode($articles->articles_desc) ;
            ?>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->



<!--start section-->
<section class="btm-section">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--start col md 3-->
                    <div class="col-md-3 col-sm-4 bottom-tl">
                        <h3>Trusted by 10K <br>Customers</h3>
                    </div>
                    <!--end col md 3-->
                    
                    <!--start col md 9-->
                    <div class="col-md-9 col-sm-8">
                        <!--start row-->
                        <div class="row">
                            <!--start carocel-->
                            <div id="owl-example-btm" class="owl-carousel row">
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img1.png"/>
                </div>
              </div>
              
              <div class="custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img2.png"/>
                </div>
              </div>
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img3.png"/>

                </div>
              </div>
              
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img4.png"/>
 
                </div>
              </div>
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img1.png"/>
                </div>
              </div>
              
              <div class="custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img2.png"/>
                </div>
              </div>
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img3.png"/>

                </div>
              </div>
              
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img4.png"/>
 
                </div>
              </div>
</div>     
                            <!--end carocel-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end col md 9-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->
<script>
  $(document).delegate("#btnCitySearch","click",function(evt)
    {
         evt.preventDefault();
         var topSearch = $("#citySearch").val();
        //alert(topSearch);
       
        var city      = $("#cityDrop").val();
       //  alert(city);
       if(topSearch!="" || city>0)
       {
           window.location ="<?php echo base_url()?>services_list?s="+topSearch+"&c="+city;
       }
        e.stopPropagation();
	});	

  /***********************************
  ********* Search Suggestion ********
  ***********************************/

  /*$('#citySearch').focus(function(){
        console.log(454545);
        $('#search_suggestiondj').show();
  });
  $('#citySearch').focusout(function(){
        $('#search_suggestiondj').hide();
  });
*/

function getSuggestion2(keyWord)
  {
              $('#sugUl2').html("");
            csrf_value  =   getCookie('csrf_cookie_name');
            city      = $("#cityDrop").val();
          
                   $.ajax({
             url: '<?php echo base_url();?>website/Request/getSuggestion',
             type: 'POST',
             data: {city:city,search_key:keyWord,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
             async: true,
             success: function (data) 
                {
                   
                   if(data!="")
                   {
                       
                      $('#sugUl2').html(data);
                      $('#search_suggestiondj').show();
                   }

               },
             cache: false
         });
  }
   $('#citySearch').keyup(function(){
         $('#sugUl2').html("");
        if($(this).val()!="")
        {
            getSuggestion2($(this).val());
       
        }
  }); 
   $(document).delegate("#sugUl2 .sugLi","click",function(event)
    {
        searchKey  = $(this).attr("for");
        searchva  =  $(this).attr("data-id");
        city      = $("#cityDrop").val();
        //alert(searchva);
        //alert(searchKey);
        $('#citySearch').val(searchKey);
        $('#search_suggestiondj').hide();
       // $("#btnCitySearch").trigger("click");
       window.location="<?php echo base_url(); ?>request/"+searchva+"&c="+city;
     
	});
	 $('#citySearch').focusout(function()
	 {
	    // $('#citySearch').val("");
	 });


$(document).on('click', function (e) {
   $('#citySearch').val("");
    $('#sugUl2').html("");
});
</script>
        
    
    

    
    

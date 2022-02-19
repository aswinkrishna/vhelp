<?php
$banner  =   $this->M_common->getActiveBanner();
?>
<rs-module-wrap id="rev_slider_1_1_wrapper" data-source="gallery" style="background:transparent;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
    <rs-module id="rev_slider_1_1" style="" data-version="6.2.22">
        
        
        <rs-slides>
            <?php
                if($banner) {
                    $i = 1;
                    foreach($banner as $bann) {
                        $bannerPath = base_url()."uploads/banner/".$bann->banner_image;
            ?>
            <a href="<?=$bann->banner_url?>">
            <rs-slide data-key="rs-<?= $i; ?>" data-title="Slide" data-thumb="images/slides/slider-mainbg-01.jpg" data-anim="ei:d;eo:d;s:1000;r:0;t:fade;sl:0;">

                <img src="<?= $bannerPath; ?>" title="mainslider-img01" width="1920" height="700" class="rev-slidebg" data-no-retina>
                <!-- <rs-layer
                    id="slider-1-slide-<?= $i; ?>-layer-0" 
                    data-type="text"
                    data-color="#fff"
                    data-rsp_ch="on"
                    data-xy="x:l,l,c,c;xo:50px,50px,0,430px;yo:225px,225px,103px,73px;"
                    data-text="w:normal;s:16,16,18,11;l:25,25,25,15;"
                    data-dim="minh:0px,0px,none,none;"
                    data-vbility="t,t,t,f"
                    data-frame_0="x:50,50,31,19;"
                    data-frame_1="st:100;sp:500;sR:100;"
                    data-frame_999="o:0;st:w;sR:8400;"
                    style="z-index:9;font-family:Jost;"
                >-->
                <!--<?php echo $bann->banner_title!=""?$bann->banner_title:"" ?>-->
                </rs-layer> 
       <!--          <rs-layer
                    id="slider-1-slide-<?= $i; ?>-layer-1" 
                    data-type="text"
                    data-color="#fff"
                    data-rsp_ch="on"
                    data-xy="x:l,l,c,c;xo:50px,50px,0,0;yo:263px,263px,135px,65px;"
                    data-text="w:normal;s:50,50,55,40;l:65,65,65,55;fw:600;"
                    data-dim="minh:0px,0px,none,none;"
                    data-frame_0="x:50,50,31,19;"
                    data-frame_1="st:220;sp:900;sR:220;"
                    data-frame_999="o:0;st:w;sR:7880;"
                    style="z-index:10;font-family:Jost;"
                > -->
                <!--<?php echo $bann->banner_title!=""?$bann->banner_title:"" ?>-->
                </rs-layer>
               <rs-layer
                    id="slider-1-slide-<?= $i; ?>-layer-2" 
                    data-type="text"
                    data-color="#fff"
                    data-rsp_ch="on"
                    data-xy="x:center,center,c,c;xo:0,0,0,0;yo:100px,100px,104px,85px;"
                    data-text="w:normal;s:50,50,45,30;l:50,50,50,30;fw:600;"
                    data-textAlign="['center', 'center', 'center', 'center']"
                    data-dim="minh:0px,0px,none,none;"
                    data-frame_0="x:50,50,31,19;"
                    data-frame_1="st:390;sp:900;sR:390;"
                    data-frame_999="o:0;st:w;sR:7710;"
                    style="z-index:11; font-family: Jost, sans-serif; text-transform: capitalize; text-shadow: 0px 9px 7px rgba(235, 225, 225, 0.35);"
                >
                   <!--<?php echo $bann->banner_title!=""?$bann->banner_title:"" ?>-->
                </rs-layer>
               <!--<rs-layer-->
               <!--     id="slider-1-slide-<?= $i; ?>-layer-3" -->
               <!--     data-rsp_ch="on"-->
               <!--     data-xy="x:center,center,c,c"-->
               <!--     data-width="1210,1210,778,480"-->
               <!--     data-height="450,450,450,350"-->
               <!--     data-dim="minh:0px,0px,none,none;"-->
               <!--     data-frame_0="x:50,50,31,19;"-->
               <!--     data-frame_1="st:390;sp:900;sR:390;"-->
               <!--     data-frame_999="o:0;st:w;sR:7710;"-->
               <!--     style="z-index:9;"-->
               <!-- >-->
               <!-- </rs-layer>-->
               <!--<rs-layer-->
               <!--     id="slider-2-slide-<?= $i; ?>-layer-2" -->
               <!--     data-frames='[{"delay": 500, "speed": 300, "from": "opacity: 0", "to": "opacity: 1"},-->
               <!--    {"delay": "wait", "speed": 300, "to": "opacity: 0"}]'-->
               <!--      data-x="center"-->
               <!--      data-y="center"-->
               <!--      data-hoffset="0"-->
               <!--      data-voffset="0"-->
               <!--      data-width="400"-->
               <!--      data-height="300"-->
               <!--      data-basealign="slide"-->
               <!--      style="background-color: rgba(0, 0, 0, 0.5); border-radius: 5px">-->
               <!-- </rs-layer>-->
                <!--  </rs-layer><a
                    id="slider-1-slide-1-layer-4" 
                    class="rs-layer cmt-btn cmt-btn-size-md cmt-btn-shape-round cmt-btn-style-fill cmt-icon-btn-right cmt-btn-color-dark"
                    href="#" target="_self" rel="nofollow"
                    data-type="text"
                    data-rsp_ch="on"
                    data-xy="x:l,l,c,c;xo:50px,50px,-60px,0;yo:414px,414px,295px,185px;"
                    data-text="w:normal;s:15,15,16,14;l:15,15,16,18;fw:500;"
                    data-padding="t:15,15,15,12;r:32,32,32,30;b:15,15,15,12;l:32,32,32,30;"
                    data-border="bor:100px,100px,100px,100px;"
                    data-frame_0="y:100%;"
                    data-frame_1="e:power4.inOut;st:700;sp:500;sR:700;"
                    data-frame_999="o:0;st:w;sR:7800;"
                    data-frame_hover="c:#222;bor:100px,100px,100px,100px;bos:none;"
                    style="z-index:12;background-color:#004976;font-family:Jost;"
                >Read More <i class="fa fa-long-arrow-right"></i> 
                </a> -->
            </rs-slide>
            </a>
            <?php
                        $i++;
                    }
                }
            ?>
        </rs-slides>
        
                        <div class=" job-search-form">
                            <!--<h2 class="text-center">GET YOUR DESIRED SERVICE AT DOORSTEP</h2>-->
                            <!--<h3>Discover the best services nearest to you</h3>-->
                            <form id="searchbox">
                                <div class="input-group search-service-block">
                                    <!-- <i class="ti ti-location-pin"></i> -->
                                    <!-- <input type="text" class="form-control"
                                        placeholder="Search location"> -->

                                        <!--<select name="" id="" class="select-search-form form-control">-->
                                        <!--    <option value="">Select Emirates</option>-->
                                        <!--    <option value="">Abu Dhabi</option>-->
                                        <!--    <option value="">Ajman</option>-->
                                        <!--    <option value="">Al Ain</option>-->
                                        <!--    <option value="">Dubai</option>-->
                                        <!--    <option value="">Fujairah</option>-->
                                        <!--    <option value="">Ras Al Khaimah</option>-->
                                        <!--    <option value="">Sharjah</option>-->
                                        <!--</select>-->
                                        <div class="search-field">
                                            <input type="text" class=" form-control" placeholder="Search your services" id="search_query_top" >
                                            <button type="button" class="btn close-search"><i class="fa fa-search"></i></button>
                                            <div id="search-result">
                                                
                                            </div>
                                        </div>
                                    <!--<div class="input-group-prepend">-->
                                    <!--    <button class="site-button">Search</button>-->
                                    <!--</div>-->
                                </div>
                            </form>
                        </div>
    </rs-module>
</rs-module-wrap>
<style>
    rs-slide:after{
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#000000+0,000000+100&0+0,0.3+100 */
        background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.3) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.3) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#4d000000',GradientType=0 ); /* IE6-9 */

    }
    .job-search-form{
        position: relative;
        z-index: 99;
        max-width: 600px;
        margin: 0 auto;
        transform: translateY(-50%);
        top: 70%;
    }
    .job-search-form .form-control{
        height: 54px;
    }
    .job-search-form .search-field{
        flex-grow: 8;
    }
    .job-search-form select.form-control{
        /*flex-grow: 4;*/
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
        flex: 0 0 auto;
        width: auto;
    }
    .job-search-form .search-field{
        position: relative;
    }
    /*.job-search-form .search-field::before{*/
    /*    content: "\f002";*/
    /*    position: absolute;*/
    /*    left: 0;*/
    /*    top: 0;*/
    /*    font: normal normal normal 14px/1 FontAwesome;*/
    /*    font-size: inherit;*/
    /*    text-rendering: auto;*/
    /*    -webkit-font-smoothing: antialiased;*/
    /*    -moz-osx-font-smoothing: grayscale;*/
    /*    width: 55px;*/
    /*    height: 54px;*/
    /*    display: flex;*/
    /*    align-items: center;*/
    /*    justify-content: center;*/
    /*    font-size: 20px;*/
    /*}*/
    .job-search-form .search-field .form-control{
        padding-left: 20px;
        /*border-top-right-radius: 50px;*/
        /* border-bottom-right-radius: 50px;*/
        border-radius: 50px;
    }
    /*rs-fullwidth-wrap{*/
    /*    height: 400px;*/
    /*}*/
    .featured-imagebox .featured-content .featured-title h5{
        color: #44a726;
        font-size: 15px !important;
        line-height: 20px !important;
        position: relative;
        z-index: 1;
        text-transform: uppercase;
    }
    .featured-imagebox-services.style1 .featured-content .cmt-icon:before{
        width: 110px;
        height: 100px;
    }
    .featured-imagebox-services.style1 .featured-content .cmt-icon{
        width: 110px;
        height: 110px;
    }
    .featured-imagebox-services.style1 .featured-content{
        padding: 10px 10px 15px;
        height: 197px;
    }
    .cmt-row.services-section {
        padding: 30px 0 75px;
    }
</style>
<div class="site-main">


            

            
            <!-- features_row-section -->
            <section class="cmt-row features_row-section vhelp-features clearfix">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="cmt-col-bgcolor-yes cmt-bgcolor-darkgrey cmt-bg cmt-left-span spacing-1 border-rad_80">
                                <div class="cmt-col-wrapper-bg-layer cmt-bg-layer  border-rad_80 overflow-hidden">
                                    <div class="cmt-col-wrapper-bg-layer-inner"></div>
                                </div>
                                <div class="layer-content">
                                    <div class="row cmt-vertical_sep">
                                        <div class="col-lg-4">
                                            <!-- featured-icon-box -->
                                            <div class="featured-icon-box icon-align-before-content style1">
                                                <div class="featured-icon">
                                                    <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-white cmt-icon_element-size-md">
                                                        <i class="flaticon-house"></i>
                                                    </div>
                                                </div>
                                                <div class="featured-content">
                                                    <div class="featured-desc">
                                                        <p>Opening Hours <br>
                                                           Sun-Thu: 08:00 - 20:00</p>
                                                    </div>
                                                </div>
                                            </div><!-- featured-icon-box end-->
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- featured-icon-box -->
                                            <div class="featured-icon-box icon-align-before-content style1">
                                                <div class="featured-icon">
                                                    <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-white cmt-icon_element-size-md">
                                                        <i class="flaticon flaticon-mop"></i>
                                                    </div>
                                                </div>
                                                <div class="featured-content">
                                                    <div class="featured-desc">
                                                        <p>Where You Can Find Us <br>
                                                            184 Main Rd, Dubai - UAE</p>
                                                    </div>
                                                </div>
                                            </div><!-- featured-icon-box end-->
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- featured-icon-box -->
                                            <div class="featured-icon-box icon-align-before-content style1">
                                                <div class="featured-icon">
                                                    <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-white cmt-icon_element-size-md">
                                                        <i class="flaticon flaticon-spray"></i>
                                                    </div>
                                                </div>
                                                <div class="featured-content">
                                                    
                                                    <div class="featured-desc">
                                                        <p>24/7 We Support You <br>
                                                            +971 213456687</p>
                                                    </div>
                                                </div>
                                            </div><!-- featured-icon-box end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- row end -->
                </div>
            </section>
            <!--features_row-section end-->



        <!--services-section-->
        <section class="cmt-row services-section bg-img1 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 m-auto">

                        <!-- section title -->
                        <div class="section-title title-style-center_text">
                            <div class="title-header">
                                <h2 class="title"><?php echo $this->session->userdata("language")==2?$labels->home_labels_arabic1:$labels->home_labels1; ?></h2>
                            </div>
                            <!-- <div class="title-desc">Discover the best services nearest to you</div> -->
                        </div><!-- section title end -->

                    </div>
                </div>
                <div class="row">
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
                    <div class="cmt-box-col-wrapper col-lg-2 col-6">
                        <!-- featured-imagebox -->
                        <div class="featured-imagebox featured-imagebox-services style1">
                            <?php
                                if($rows->is_sub){
                            ?>
                                <a href="<?=base_url('sub_services/').$rows->service_type_id?>">
                            <?php
                                }else{
                            ?>
                                <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                            <?php
                                }
                            ?>
                            <div class="featured-content">
                                <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-skincolor cmt-icon_element-size-lg">
                                <img src="<?= $image; ?>" alt="">
                                </div>
                                <div class="featured-title">
                                    <h5><?php  echo substr($rows->service_type_name,0,19);?><?php echo strlen($rows->service_type_name)>19?"...":""?></h5>
                                </div> 
                            </div>
                            </a>
                        </div><!-- featured-imagebox end -->
                    </div>
                    <?php } 
                        if(count($popular_cate ) == 11 ){
                    ?>
                        <div class="cmt-box-col-wrapper col-lg-2 col-6">
                            <div class="featured-imagebox featured-imagebox-services style1">
                                <a href="<?=base_url('services_list')?>">
                                    <div class="featured-content">
                                        <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-skincolor cmt-icon_element-size-lg">
                                            <img src="<?=base_url('template/images/icons/12.png')?>" alt="">
                                        </div>
                                        <div class="featured-title">
                                            <h5>View More</h5>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- featured-imagebox end -->
                        </div>
                    <?php } 
                        }
                    ?>
                </div>

            </div>
        </section>
        <!--services-section end-->
        

            <!--about-section-->
            <section class="cmt-row about-section clearfix">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-10 mx-auto">
                            <div class="position-relative pr-30 res-991-pr-0">
                                <!-- cmt_single_image-wrapper -->
                                <div class="cmt_single_image-wrapper text-lg-left text-center ml_15 res-991-ml-0">
                                    <img class="img-fluid" src="<?= base_url(); ?>template/images/single_image-01.png" alt="">
                                </div>
                                <!-- cmt-fid -->
                                <div class="fid cmt-fid inside fid-highlight-box-1 cmt-bgcolor-skincolor">
                                    <div class="cmt-fid-contents">
                                        <h4 class="cmt-fid-inner">
                                        <span   data-appear-animation="animateDigits" 
                                                data-from="0" 
                                                data-to="9" 
                                                data-interval="2" 
                                                data-before="" 
                                                data-before-style="sup" 
                                                data-after="" 
                                                data-after-style="sub">09
                                        </span><span>+</span>
                                        </h4>
                                        <h3 class="cmt-fid-title">Years Of Experience</h3>
                                    </div>
                                </div>
                                <!-- cmt-fid end -->
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                            <div class="pr-50 res-1199-pr-0 res-1170-mr_200 res-1199-mr-0">
                                <!-- section title -->
                                <div class="section-title clearfix">
                                    <div class="title-header">
                                        <h2 class="title">About VHELP Services</h2>
                                    </div>
                                    <div class="title-desc">
                                    <?php 
                                        if(isset($aboutus->articles_desc) && !empty($aboutus->articles_desc)) {
                                            $aboutus = htmlspecialchars_decode($aboutus->articles_desc);
                                            echo strlen($aboutus)>1000 ? substr($aboutus,0,1000).'...' : $aboutus;
                                        }
                                   ?>
                                    </div>
                                </div>
                                <!-- section title end -->
                                
                                <a class="cmt-btn cmt-btn-size-md cmt-btn-shape-round cmt-btn-style-fill cmt-icon-btn-right cmt-btn-color-dark" href="<?= base_url().'articles/2'; ?>" title="">Read More<i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-xl-2"></div>
                    </div><!-- row end -->
                </div>
            </section>
            <!--about-section end-->




            

  <!-- procedure-section -->
<?php $this->load->view('how_is_it_work'); ?>

<!-- procedure-section end -->

            <!-- portfolio_row-section end -->
            <section class="cmt-row portfolio_row-section clearfix">
                <div class="container-fluid p-0">
                    <div class="row cmt-boxes-spacing-5px slick_slider ml_10 mr_10" data-slick='{"slidesToShow": 5, "slidesToScroll": 5, "arrows":false, "autoplay":false, "infinite":true}'>
                        <?php
                            if(count($popular_cate) > 0)
                            {
                                foreach ($popular_cate as $rows)
                                {
                                    $image = ($rows->homepage_banner!=""? base_url()."uploads/banner/".$rows->homepage_banner:base_url().'uploads/banner-dummy.jpg');
                                    $urlCategoryName  =  $rows->service_type_name;
                                    $string = str_replace(' ', '-', $urlCategoryName); 
                                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                                    $urlCategoryName  = strtolower($urlCategoryName);
                                    $desc = $rows->service_type_desc;
                                    $desc = strlen($desc)>20 ? substr($desc,0,20).'...' : '';
                                    if($rows->is_sub)
                                        $url = base_url('sub_services/').$rows->service_type_id;
                                    else
                                        $url = base_url().'request'.$urlCategoryName.'?sid='.$this->common_functions->encryptId($rows->service_type_id);
                                    
                        ?>


                        <div class="cmt-box-col-wrapper col-lg-4 col-md-4 col-sm-6">
                            <!-- featured-imagebox -->
                            <div class="featured-imagebox featured-imagebox-portfolio style1">
                                <!-- cmt-box-view-overlay -->
                                <div class="cmt-box-view-overlay">
                                    <!-- featured-thumbnail -->
                                    <div class="featured-thumbnail">
                                        <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                                         <img class="img-fluid" src="<?= $image; ?>" alt="image">
                                        </a>
                                    </div><!-- featured-thumbnail end-->
                                    <div class="featured-content">
                                        <div class="featured-desc">
                                            <!-- <p><?= $desc; ?></p> -->
                                        </div>
                                        <div class="featured-title">
                                            <h5><a href="<?=$url?>"><?= $rows->service_type_name; ?></a></h5>
                                        </div>
                                        <a class="cmt-btn cmt-btn-size-sm cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-skincolor" href="<?=$url?>">Read More</a>
                                    </div>
                                </div><!-- cmt-box-view-overlay end-->
                            </div><!-- featured-imagebox -->
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pt-35 pb-40 res-991-pb-15">
                                <!-- section title -->
                                <div class="section-title d-lg-flex">
                                    <div class="title-header w-100">
                                        <h2 class="title">Stay Safe Stay Home</h2>
                                            <p>Service Professionals in your doorsteps</p>
                                    </div>
                                    <div class="title-desc w-100 pl-50 res-991-pl-0">
                                        <p>VHELP provides a platform that allows skilled and experienced professionals to connect with users looking for specific services.</p>
                                    </div>
                                </div>
                                <!-- section title end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- portfolio_row-section end -->


            <!--broken-section-->
            <section class="cmt-row broken-section bg-layer-equal-height clearfix">
                <div class="container-fluid">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12">
                            <div class="cmt-col-bgcolor-yes cmt-bgcolor-darkgrey cmt-left-span cmt-bg spacing-3">
                                <div class="cmt-col-wrapper-bg-layer cmt-bg-layer"></div>
                                <div class="layer-content">
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12">
                                            <!-- section title -->
                                            <div class="section-title title-style-center_text">
                                                <div class="title-header">
                                                    <h2 class="title">What Do Our Clients Say</h2>
                                                </div>
                                            </div>
                                            <!-- section title end -->
                                        </div>
                                        <div class="col-xl-10 m-auto">
                                            
                                                                <!-- testimonials -->
                                            <div class="testimonials-info pt-15">
                                                <?php
                                            if(count($testimonial)>0)
                                            {
                                                foreach($testimonial as $rows)
                                                {
                                                      $image = ($rows->profile_image!=""? base_url()."uploads/user/".$rows->profile_image:"");
                                                    
                                            ?>
                                                <div class="testimonials text-center">
                                                    <div class="testimonial-content">
                                                        <!-- <div class="star-ratings">
                                                            <ul class="rating">
                                                                <li class="active"><i class="fa fa-star"></i></li>
                                                                <li class="active"><i class="fa fa-star"></i></li>
                                                                <li class="active"><i class="fa fa-star"></i></li>
                                                                <li class="active"><i class="fa fa-star"></i></li>
                                                                <li class="active"><i class="fa fa-star"></i></li>
                                                            </ul>
                                                        </div> -->
                                                        <blockquote class="testimonial-text"><?php echo $rows->testimonial_arabic!="" && $this->session->userdata("language")==2?$rows->testimonial_arabic:$rows->testimonial?>
                                                        </blockquote>
                                                        <div class="testimonial-caption">
                                                            <h5><?php echo $rows->first_name." ".$rows->last_name?><span><?php echo $rows->designation_arabic!="" && $this->session->userdata("language")==2?$rows->designation_arabic:$rows->designation?></span></h5>
                                                        </div>
                                                    </div>
                                                </div><!-- testimonials end -->
                                                <!-- testimonials -->
                                               <?php
                                                }
                                            }
                                            ?>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-12 col-md-12 mt-35 m-auto">
                                            <div class="testimonials-nav">
                                                <?php
                                            if(count($testimonial)>0)
                                            {
                                                foreach($testimonial as $rows)
                                                {
                                                      $image = ($rows->profile_image!=""? base_url()."uploads/user/".$rows->profile_image:"");
                                                    
                                            ?>
                                                <div class="testimonial-avatar">
                                                    <div class="testimonial-img">
                                                        <img class="img-fluid" src="<?php echo $image;?>" alt="testimonial-img" onError="this.onerror=null;this.src='<?= base_url();?>template/images/testimonial/01.jpg';" >
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="col-bg-img-three cmt-col-bgimage-yes cmt-bg cmt-col-bgcolor-yes cmt-bgcolor-skincolor cmt-right-span spacing-4">
                                <div class="cmt-col-wrapper-bg-layer cmt-bg-layer">
                                    <div class="cmt-col-wrapper-bg-layer-inner"></div>
                                </div>
                                <!-- section title -->
                                <div class="layer-content">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <!-- section title -->
                                            <div class="section-title title-style-center_text">
                                                <div class="title-header">
                                                    <h2 class="title">Contact Us</h2>
                                                </div>
                                            </div>
                                            <!-- section title end -->
                                        </div>
                                        <div class="col-xl-10 m-auto">
                                            <form id="appoinment_form" class="wrap-form appoinment_form pt-15 clearfix" method="post" action="#">
                                                <div class="row no-gutters">
                                                    <div class="col-lg-12">
                                                        <label>
                                                            <span class="text-input">
                                                                <i class="ti-user"></i>
                                                                <input name="txt_name" id="txt_name" type="text" placeholder="Enter Name*">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label>
                                                            <span class="text-input">
                                                                <i class="ti-email"></i>
                                                                <input name="email" id="email" type="text" placeholder="Enter Email*">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" value="+971" name="txt_dial" id="txt_dial">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <label>
                                                            <span class="text-input">
                                                                <i class="ti-user"></i>
                                                                <input name="phone" id="phone" type="text" placeholder="Contact Number*">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12">
                                                        <label>
                                                            <span class="text-input">
                                                                <i class="ti-user"></i>
                                                                <textarea name="comments" id="comments"></textarea>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--<div class="col-xl-6 col-lg-12">-->
                                                    <!--    <label>-->
                                                    <!--        <span class="text-input">-->
                                                    <!--            <i class="ti-calendar"></i>-->
                                                    <!--            <input name="txt_appdate" id="txt_appdate" type="text" value="" placeholder="dd-mm-yyyy*" required="required">-->
                                                    <!--        </span>-->
                                                    <!--    </label>-->
                                                    <!--</div>-->
                                                </div>
                                                <div class="ml-5 mr-5">
                                                    <button class="submit cmt-btn cmt-btn-size-md  cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-dark w-100" type="submit" id="appoinmentBtn">Send Message</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--broken-section end-->





                   <!--hero section start-->
        <section class="apps-sec cmt-row services-section cmt-bg bg-img2 clearfix">
            <div class="background-image-wraper"></div>
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-10 col-lg-6">
                        <div class="section-heading text-dark py-5">
                            <h1 class="text-dark font-weight-bold">Creative Way to Showcase Your App</h1>
                            <p>Start working with that can provide everything you need to generate awareness, drive traffic, connect. Efficiently transform granular value with client-focused content. Energistically redefine market.</p>
                            <div class="action-btns mt-4">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="#" class="d-flex align-items-center app-download-btn btn btn-dark btn-rounded">
                                            <span><img src="<?= base_url(); ?>template/images/apple.png" alt=""></span>
                                            <div class="download-text text-left">
                                                <small>Download form</small>
                                                <h5 class="mb-0">App Store</h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="d-flex align-items-center app-download-btn btn btn-dark btn-rounded">
                                            <span><img src="<?= base_url(); ?>template/images/play-store.png" alt=""></span>
                                            <div class="download-text text-left">
                                                <small>Download form</small>
                                                <h5 class="mb-0">Google Play</h5>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-5">
                        <div class="img-wrap">
                            <img src="<?= base_url(); ?>template/images/app-mobile-image.png" alt="shape" class="img-fluid">
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>
        <!--hero section end-->




        </div><!-- site-main end -->
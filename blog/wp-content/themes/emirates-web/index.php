<?php
/*
 * Template Name:Blog
 */
get_header();
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
?>
<!--start section-->

<div class="row margin-ctrl-none how_it_work_banner">
      <h3>
        Blog      </h3>

            <!--start container-->
      <div class="container">
        <div class="row">
       

         </div>
      </div>
      <!--end container-->
    </div>
<section class="first-section">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        
            <!--start container-->
            <div class="container">


                        <div class="col-md-12 pagination-ctrl" style="margin: 50px 0;">
                                <?php

                                $url = $_SERVER['REQUEST_URI'];
                                $urlArr = explode("/", $url);

                                $posttitle = $urlArr[3];//2 or 3 based on server hosting



                                $postid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . urldecode($posttitle) . "' ORDER BY ID DESC LIMIT 1");







                                if (!empty($postid)) {
                                    ?>

                            <!--2.use get_post($post_id) to get whatever you want to echo-->
                                    <?php
                                    $getpost= get_post($postid);
                                    setup_postdata($getpost);
                             
                                    ?>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                            <div class="bp">
                                
                                
                                <h2><?php echo $getpost->post_title; ?></h2>
                                
                                
                                
                                <h5 style="margin-top: 0px;"><?php $post_date=date_create($getpost->post_date);
                                    echo date_format($post_date, "d-m-Y H:i a"); ?></h5>
                                    
                                    
                                    </div>
                                

                                    <?php
                                    $img_url = getTheFirstImage($getpost->post_parent);

                                    if (!empty($img_url)) {
                                        ?>




                                           <p><img src="<?php echo $img_url; ?>" style="width:1260px"  class="img-fluid">
                                </p>
                                  
                             
                                

                                
                                        <?php
                                    }
                                    ?>
                            <div class="para">
                                <p>
                                    <?php
                                    $post_content = preg_replace('/<img[^>]+./', '', get_the_content());
                                    echo $post_content;
                                    ?>

                                </p>
                            </div>
                               </div>
                            </div>        
                              </div>
                                    <?php
                                } else {
                                    ?>          
                                       


                                    <?php
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                    $args = array(
                                    'post_type'=>'post', // Your post type name
                                    'posts_per_page' => 5,
                                    'paged' => $paged,
                                    );

                                    $loop = new WP_Query($args);
                                    if ($loop->have_posts()) {
                                        while ($loop->have_posts()) :
                                            $loop->the_post();
                                            

                                                 // YOUR CODE
                                                 //
                                                 //
                                            ?>                                               
<div class="bp-1">
                                        <h4 class="font-weight-bold blog-t"><?php the_title(); ?></h4>
                                        <a href="<?php echo home_url().'/'.$post->post_title; ?>" style="margin-top: 20px; color: rgb(0, 0, 0); text-decoration: none;">
                                            <div class="row">
                                                <div class="col-md-3 col-lg-3">
                                                             <?php
                                                    
                                                                $img_url = getTheFirstImage();
                                                                if (empty($img_url)) {
                                                                                $img_url = get_template_directory_uri().'/images/logo/logo.png';
                                                                } ?>
                                                     
                                                    <img class="img-fluid" src="<?php echo $img_url; ?>" style="z-index: 2; position: relative;">
                                                </div>
                                                <div class="col-md-9 col-lg-9">
                                                    <h5 class="pub-t">Published on <?php
                                                    $post_date=date_create($post->post_date);
                                                    echo date_format($post_date, "d-m-Y H:i a"); ?></h5>
                                                    <p><?php
                                                        $post_content = wp_strip_all_tags(get_the_content());
                                                    $out = strlen($post_content) > 300 ? substr($post_content, 0, 300).'<span style="color:rgb(43, 195, 107);"> Continue reading</span>' : $post_content;
                                                    echo $out;
                                                    ?>
                                                    
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                            <?php
                                        endwhile;

                                        $total_pages = $loop->max_num_pages;

                                        if ($total_pages > 1) {
                                            $current_page = max(1, get_query_var('paged'));

                                            echo paginate_links(array(
                                                'base' => get_pagenum_link(1) . '%_%',
                                                'format' => '/page/%#%',
                                                'current' => $current_page,
                                                'total' => $total_pages,
                                                'prev_text'    => __('« prev'),
                                                'next_text'    => __('next »'),
                                            ));
                                        }
                                    }
                                    wp_reset_postdata();
                                    ?>


                                        <?php
                                        /*$lastposts = get_posts(array(
                                        'posts_per_page' => 10,
                                        'paged' => $paged,
                                        ));





                                        if ($lastposts) {
                                            foreach ($lastposts as $post) :
                                                setup_postdata($post); ?>



                                    <div class="bp-1">
                                        <h4 class="font-weight-bold blog-t"><?php the_title(); ?></h4>
                                        <a href="<?php echo home_url().'/'.$post->post_title; ?>" style="margin-top: 20px; color: rgb(0, 0, 0); text-decoration: none;">
                                            <div class="row">
                                                <div class="col-md-3 col-lg-3">
                                                             <?php

                                                                $img_url = getTheFirstImage();
                                                                if (empty($img_url)) {
                                                                                $img_url = get_template_directory_uri().'/images/logo/header-logo.png';
                                                                } ?>

                                                    <img class="img-fluid" src="<?php echo $img_url; ?>" style="z-index: 2; position: relative;">
                                                </div>
                                                <div class="col-md-9 col-lg-9">
                                                    <h5 class="pub-t">Published on <?php
                                                    $post_date=date_create($post->post_date);
                                                    echo date_format($post_date, "d-m-Y H:i a"); ?></h5>
                                                    <p><?php
                                                        $post_content = wp_strip_all_tags(get_the_content());
                                                    $out = strlen($post_content) > 300 ? substr($post_content, 0, 300).'<span style="color:rgb(43, 195, 107);"> Continue reading</span>' : $post_content;
                                                    echo $out;
                                                    ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                                <?php
                                            endforeach;
                                            wp_reset_postdata();
                                        }*/
                                }?>



                        </div>
                <!--end col-md-12-->
            </div>
            <!--end container-->
       
    </div>
    <!--end container fluid-->
</section>
<!--end section-->

<?php get_footer();   ?>

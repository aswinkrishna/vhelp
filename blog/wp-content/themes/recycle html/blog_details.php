<?php
/*
 * Template Name:Blog details
 */
get_header();
?>


<!--start section-->
  <section>
    <!--start container fluid-->
    <div class="container-fluid">
      <!--start row-->
      <div class="row min-col">

        

        <h2>Blog</h2>
        <!--start container-->
        <div class="container">
          <!--start row-->
          <div class="col-md-8 mx-auto ">
  <?php

$url = $_SERVER['REQUEST_URI'];
$urlArr = explode("/", $url);

$posttitle = $urlArr[2];



$postid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $posttitle . "'");

if (!empty($postid)) {
    ?>

<!--2.use get_post($post_id) to get whatever you want to echo-->
<?php
$getpost= get_post($postid);
setup_postdata($getpost);

?>
<div style="width: 100%;"><div class="ui vertically padded container grid"><div class="sixteen wide mobile sixteen wide tablet sixteen wide computer sixteen wide large screen column"><h2><?php echo $getpost->post_title; ?></h2><h5 style="margin-top: 0px;"><?php $post_date=date_create($getpost->post_date);
        echo date_format($post_date, "d-m-Y H:i a"); ?></h5></div></div></div>

<?php
 $img_url = getTheFirstImage();

if(!empty($img_url)){
 ?>


<div class="sixteen wide mobile sixteen wide tablet sixteen wide computer sixteen wide large screen column"><div><p><img src="<?php echo $img_url; ?>" style="width: 1200px;" class="fr-fic fr-dib"></p></div></div>        

<?php   
  }
  ?>
<div class="sixteen wide mobile sixteen wide tablet sixteen wide computer sixteen wide large screen column">
  <div>
    <?php
    $post_content = wp_strip_all_tags(get_the_content());
    echo $post_content;
    ?>

    </div>
</div>
<?php
} else {
    ?>          
           

            <?php
$lastposts = get_posts(array(
    'posts_per_page' => 10
));
 
    if ($lastposts) {
        foreach ($lastposts as $post) :
        setup_postdata($post); ?>
        
       
        
        <div class="sixteen wide mobile sixteen wide tablet sixteen wide computer sixteen wide large screen column pull-down post-square">
          <h4><?php the_title(); ?></h4>
          <a href="<?php the_permalink(); ?>" style="margin-top: 20px; color: rgb(0, 0, 0);">
            <div class="ui grid">
              <div class="sixteen wide mobile four wide tablet four wide computer four wide large screen column">
                 <?php
                        
                           $img_url = getTheFirstImage();
        if (empty($img_url)) {
            $img_url = get_template_directory_uri().'/images/logo/header-logo.png';
        } ?>
                         
                <img src="<?php echo $img_url; ?>" style="z-index: 2; position: relative;">
              </div>
              <div class="sixteen wide mobile twelve wide tablet twelve wide computer twelve wide large screen column">
                <h5>Published on <?php
                        $post_date=date_create($post->post_date);
        echo date_format($post_date, "d-m-Y H:i a"); ?></h5>
                <p><?php
                            $post_content = wp_strip_all_tags(get_the_content());
        $out = strlen($post_content) > 250 ? substr($post_content, 0, 250).'<span style="color: rgb(254, 194, 16);">Continue reading</span>' : $post_content; ?>
                
                </p>
              </div>
            </div>
          </a>
        </div>
    <?php
    endforeach;
        wp_reset_postdata();
    }
}?>



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







 











<?php get_footer();   ?>
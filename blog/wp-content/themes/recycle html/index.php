<?php
/*
 * Template Name:Blog
 */
get_header();
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
?>
   <!--Breadcrumb-->
<section>
        <div class="breadcrumb-re">
            <div class="container">
                <h3>Blog</h3>
                <!-- <p>"Human behavior is incredibly pliable, plastic."- Philip Zimbardo</p> -->
                <nav aria-label="breadcrumb" style="position:unset;" class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="https://recycleassociation.com/">Home</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>

        </div>
    </section>
    <!--End Breadcrumb-->
<!--start section-->
  <section>
    <!--start container fluid-->
    <div class="container-fluid">
      <!--start row-->
      <div class="row">

        <!--start container-->
        <div class="container-fluid">
          <!--start row-->
          <div class="col-md-12" style="margin: 50px 0;">
  <?php

$url = $_SERVER['REQUEST_URI'];
$urlArr = explode("/", $url);
$posttitle = $urlArr[2];



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

if(!empty($img_url)){
 ?>




               <p><img src="<?php echo $img_url; ?>" style="width:1260px"  class="img-fluid">
    </p>
      
 
    

    
<?php   
  }
  ?>
<div class="para">
	<p>
		<?php
		$post_content = preg_replace('/<img[^>]+./','',get_the_content());
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
$lastposts = get_posts(array(
    'posts_per_page' => 10
));
 
    if ($lastposts) {
        foreach ($lastposts as $post) :
        setup_postdata($post); ?>
        
       
        
        <div class="bp-1">
        	<h4 class="font-weight-bold blog-t"><?php the_title(); ?></h4>
        	<a href="<?php echo home_url().'/'.$post->post_title; ?>" style="margin-top: 20px; color: rgb(0, 0, 0);">
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
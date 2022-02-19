<?php
add_filter('types_information_table', '__return_false');


/** custom logo in admin login *****/
function custom_loginlogo()
{
  
    $wp_admin_logo = get_template_directory_uri().'/images/logo/logo.png';
    echo '<style type="text/css">
h1 a {background-image: url(';
    echo $wp_admin_logo;
    echo ') !important; }
</style>';
}
add_action('login_head', 'custom_loginlogo');
/**  end custom logo in admin login *****/

function getTheFirstImage($post_id = "")
{
//echo  "post id ->".$post_id; echo "get id ->".get_the_ID();
    if (!empty($post_id)) {
        $files = get_children('post_parent='.$post_id.'&post_type=attachment&post_mime_type=image');
    } else {
        $files = get_children('post_parent='.get_the_ID().'&post_type=attachment&post_mime_type=image');
    }
    
    if ($files) :
        //$keys = array_reverse(array_keys($files)); for first image
        $keys = (array_keys($files));// for latest
        $j=0;
        $num = $keys[$j];
        $image=wp_get_attachment_image($num, 'large', false);
        $imagepieces = explode('"', $image);
        $imagepath = $imagepieces[1];
        //$thumb=wp_get_attachment_thumb_url($num);
        $thumb=$imagepieces[5];// for full size image
        //echo "<img src='$thumb' class='thumbnail' />";
        return  $thumb;
    endif;
}


function base_url()
{
    return "https://a2itproducts.com/emirates_quotations/";
}

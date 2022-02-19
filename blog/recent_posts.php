<?php
define('WP_USE_THEMES', false);
require('./wp-blog-header.php');

global $wpdb;
$num = $_GET["numberposts"] ?: '3';
$cat = $_GET["catid"];
$postID = $_GET["postid"];
$type = $_GET["type"];

switch ($type) {
    case "singlePost":
        $posts = get_posts('p='.$postID.'&numberposts=1');
        break;
    case "catFeed":
        $posts = get_posts('category='.$cat.'&numberposts='.$num.'&order=DESC');
     
        break;
    default:
        $posts = get_posts('numberposts='.$num.'&order=DESC');
}

//echo "<pre>";print_r($posts);

        $dom = new DOMDocument();

        $dom->encoding = 'utf-8';

        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;

        $xml_file_name = 'recent_blog.xml';
        
        $root = $dom->createElement('items');
        
        

?>

      
     
     
        <?php foreach ($posts as $post) :
            
            start_wp(); ?>
            <?php
 

            $item_node = $dom->createElement('item');

            $child_node_id = $dom->createElement('post_id', $post->ID);

            $item_node->appendChild($child_node_id);
       
            $child_node_date = $dom->createElement('post_date', $post->post_date);

            $item_node->appendChild($child_node_date);
       
            $child_node_title = $dom->createElement('post_title', $post->post_title);

            $item_node->appendChild($child_node_title);
       
            $child_node_content = $dom->createElement('post_content', $post->post_content);

            $item_node->appendChild($child_node_content);
            
            $child_node_author = $dom->createElement('post_author', $post->post_author);

            $item_node->appendChild($child_node_author);
       
            $child_node_url = $dom->createElement('post_url', $post->guid);

            $item_node->appendChild($child_node_url);

            $Featured_image = $wpdb->get_results("
    SELECT p.*
      FROM wp_postmeta AS pm
     INNER JOIN wp_posts AS p ON pm.meta_value=p.ID 
     WHERE pm.post_id = $post->ID
       AND pm.meta_key = '_thumbnail_id' 
     ORDER BY p.post_date DESC 
     LIMIT 15
", 'ARRAY_A');



            if (!empty($Featured_image)) {
                $post_image = $Featured_image[0]['guid'];
            } else {
                $post_image = getTheFirstImage($post->ID);
                //$pos_image = "No image";
            }

            $child_node_image = $dom->createElement('post_image', $post_image);

            $item_node->appendChild($child_node_image);

            $root->appendChild($item_node);


            ?>
    
       



    
        
      
           
        <?php endforeach; ?>
      
        <?php
        $dom->appendChild($root);

        $dom->save($xml_file_name);
        ?>
  
<?php
        /*$dom = new DOMDocument();

        $dom->encoding = 'utf-8';

        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;

        $xml_file_name = 'recent_blog.xml';

        $root = $dom->createElement('items');

        $item_node = $dom->createElement('item');



    $child_node_title = $dom->createElement('Title', 'The Campaign');

        $item_node->appendChild($child_node_title);

        $child_node_year = $dom->createElement('Year', 2012);

        $item_node->appendChild($child_node_year);

    $child_node_genre = $dom->createElement('Genre', 'The Campaign');

        $item_node->appendChild($child_node_genre);

        $child_node_ratings = $dom->createElement('Ratings', 6.2);

        $item_node->appendChild($child_node_ratings);

        $root->appendChild($item_node);

        $dom->appendChild($root);

    $dom->save($xml_file_name);

    echo "$xml_file_name has been successfully created";*/
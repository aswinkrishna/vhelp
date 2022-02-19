<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$parts = explode("/",$_SERVER["PHP_SELF"]);
  
  if (in_array("services", $parts))
  {
      
$hook['post_controller_constructor'] = array(
    'class' => 'Authentication',
    'function' => 'authenticateApp',
    'filename' => 'Authentication.php',
    'filepath' => 'hooks',
    'params' => array()
);



  }

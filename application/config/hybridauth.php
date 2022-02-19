<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| HybridAuth settings
| -------------------------------------------------------------------------
| Your HybridAuth config can be specified below.
|
| See: https://github.com/hybridauth/hybridauth/blob/v2/hybridauth/config.php
*/
$config['hybridauth'] = array(
    "base_url" => base_url()."hauth/endpoint",
  "providers" => array(
    "OpenID" => array(
      "enabled" => FALSE,
    ),
    "Yahoo" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
    "Google" => array(	"enabled" => true,
				"keys"    => array ( "id" => "535501964610-f4effalrgnik5t5e0sg86hank6qp93n2.apps.googleusercontent.com", "secret" => "DpxltQVv1U-VNAsb8V_CUa42" ),
				"redirect_uri" => "https://a2itproducts.com/emirates_quotations/hauth/endpoint?hauth.done=Google"
    ),
    "Facebook" => array(
      	"enabled" => true,
				"keys"    => array ( "id" => "224951851748230", "secret" => "21792978f7f635248f295c78238df336" ),
					"redirect_uri" => "https://a2itproducts.com/emirates_quotations/hauth/login/Facebook",
      "trustForwarded" => FALSE,
    ),
    "Twitter" => array(
      "enabled" => FALSE,
      "keys" => array("key" => "", "secret" => ""),
      "includeEmail" => FALSE,
    ),
    "LinkedIn" => array(
      "enabled" => FALSE,
      "keys" => array("id" => "", "secret" => ""),
    ),
  ),
  // If you want to enable logging, set 'debug_mode' to true.
  // You can also set it to
  // - "error" To log only error messages. Useful in production
  // - "info" To log info and error messages (ignore debug messages)
  "debug_mode" => ENVIRONMENT === 'development',
  // Path to file writable by the web server. Required if 'debug_mode' is not false
  "debug_file" => APPPATH . 'logs/hybridauth.log',
);

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Stripe API Configuration
| -------------------------------------------------------------------
|
| You will get the API keys from Developers panel of the Stripe account
| Login to Stripe account (https://dashboard.stripe.com/)
| and navigate to the Developers >> API keys page
|
|  stripe_api_key            string   Your Stripe API Secret key.
|  stripe_publishable_key    string   Your Stripe API Publishable key.
|  stripe_currency           string   Currency code.
*/
$config['stripe_api_key']         = 'sk_test_51J5wUgHeyC7j7ltIg0RGy9IliFMjMiB9FXbcSr69rmR6T8Dg9rQFv9FeIVcUPkHDtfFjprvvHbm0VQwJq8ZHjy2800Gn27Mq6G';
$config['stripe_publishable_key'] = 'pk_test_51J5wUgHeyC7j7ltItxE1jdLAVTuvgeIg5bCt1bubSQffm3CL7gHMMe5E1LCEbriUwm2faISHFH1swoOnDl1LsF6R009FIsmvoX';
//test data
//$config['stripe_api_key']         = 'sk_test_gWJUsUyb5Fbl2Oed7m1Tk8ur00WXBtSIpu';
//$config['stripe_publishable_key'] = 'pk_test_ZQsS0Dbp8BANJfRURw2xUdT8008h3b8JaJ';

// if(ip_info("Visitor", "Country Code") == "IN"){
//     $config['stripe_currency']        = 'inr';
// }else{
//     $config['stripe_currency']        = 'usd';
// }

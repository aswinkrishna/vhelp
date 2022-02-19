<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stripe Library for CodeIgniter 3.x
 *
 * Library for Stripe payment gateway. It helps to integrate Stripe payment gateway
 * in CodeIgniter application.
 *
 * This library requires the Stripe PHP bindings and it should be placed in the third_party folder.
 * It also requires Stripe API configuration file and it should be placed in the config directory.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      CodexWorld
 * @license     http://www.codexworld.com/license/
 * @link        http://www.codexworld.com
 * @version     2.0
 */

class Stripe_lib{
    var $CI;
    var $api_error;

    function __construct(){
        $this->api_error = '';
        $this->CI =& get_instance();
        $this->CI->load->config('stripe');

        // Include the Stripe PHP bindings library
        require APPPATH .'third_party/stripe-php/init.php';

        // Set API key
        \Stripe\Stripe::setApiKey($this->CI->config->item('stripe_api_key'));
    }
    function create_session($data){
        //\Stripe\Stripe::setApiKey('sk_test_gWJUsUyb5Fbl2Oed7m1Tk8ur00WXBtSIpu');
        $currency = $this->CI->config->item('stripe_currency')??'AED';
        $session = \Stripe\Checkout\Session::create([
          'payment_method_types' => ['card'],
          'line_items' => [[
            'name' => $data['product'],
            'description' => $data['description'],
            'images' => [$data['image']],
            'amount' => $data['amount'],
            'currency' => $currency,
            'quantity' => $data['quantity']
            

          ]
          ],
          'client_reference_id' => $data['client_reference_id'],
          'success_url' => $data['success_url'],
          'cancel_url' => $data['cancel_url'],
          'billing_address_collection' => 'auto',
          
          'customer_email'=>$data['email']??'',

        ]);
        return $session;
    }
    function retrieve_session($session_id){
        $session = \Stripe\Checkout\Session::retrieve($session_id);
        return $session;
    }
    function retrieve_customer($cusomer_id){
        $customer = Stripe\Customer::retrieve($cusomer_id);
        return $customer;
    }
    function retrieve_payment($payment_id){
        $payment = \Stripe\PaymentIntent::retrieve($payment_id);
        return $payment;
    }
    function addCustomer($email, $token, $name = 'user'){
        try {
            // Add customer to stripe
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source'  => $token,
                'name'      =>  $name
            ));
            return $customer;
        }catch(Exception $e) {
            $this->api_error = $e->getMessage();
            return false;
        }
    }

    function createCharge($customerId, $itemName, $itemPrice, $orderID){
        // Convert price to cents
        $itemPriceCents = ($itemPrice*100);
        $currency = $this->CI->config->item('stripe_currency');

        try {
            // Charge a credit or a debit card
            $charge = \Stripe\Charge::create(array(
                'customer' => $customerId,
                'shipping' => [
                    'name' => 'Jenny Rosen',
                    'address' => [
                      'line1' => 'streat line 1',
                      'postal_code' => '10005',
                      'city' => 'newyork',
                      'state' => 'nys',
                      'country' => 'us',
                    ],
                  ],
                'amount'   => $itemPriceCents,
                'currency' => $currency,
                'description' => $itemName,
                'metadata' => array(
                    'order_id' => $orderID
                )
            ));

            // Retrieve charge details
            $chargeJson = $charge->jsonSerialize();
            return $chargeJson;
        }catch(Exception $e) {
            $this->api_error = $e->getMessage();
            return false;
        }
    }


    public function api_charge($amount,$currency,$address=array()){
        if(empty($address)){
            $shipping = [
                    'name' => 'Amal Thankachan',
                    'address' => [
                      'line1' => 'streat line 1',
                      'postal_code' => '10005',
                      'city' => 'newyork',
                      'state' => 'nys',
                      'country' => 'us',
                    ],
                  ];
        }else{
            $shipping = [
                    'name' => $address->first_name,
                    'address' => [
                      'line1' => $address->building_name,
                      'postal_code' => 12345,
                      'city' => $address->city_name,
                      'state' => $address->user_adresses_location,
                      'country' => $address->country_name,
                    ],
                  ];
        }
        
    //4242	\Stripe\Stripe::setApiKey('sk_live_H84IimCXNH6dGLmXcnUm8HKO005x5cK5iQ');

        //https://stripe.com/docs/india-exports READ THIS LINK AND fix it

        $city = "city";
        $country="india";
        $address="kochi";
        $zipCode="683514";
        $state ="";

    	$intent = \Stripe\PaymentIntent::create([
    	    'amount' => $amount * 100,
    	    'currency' => $currency,
          'description' => 'Product Purchase',
          'shipping' => $shipping

    	]);
    // 	$customer = \Stripe\Customer::create([
    //       'name' => 'sooraj sabu',
    //       'address' => [
    //         'line1' => '510 Townsend St',
    //         'postal_code' => '98140',
    //         'city' => 'San Francisco',
    //         'state' => 'CA',
    //         'country' => 'US',
    //       ],
    //     ]);
    	$client_secret = $intent->client_secret;
      return $client_secret;
    }

}

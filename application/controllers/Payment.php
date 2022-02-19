<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller 
{
    public function __construct()
     {
        parent::__construct();       
        // $this->load->model('website/M_account', "model_account");
        // $this->load->model('website/User_model','model_user');
        // $this->load->model("website/cart_model","model_cart");
        // $this->load->model("website/product_model","model_product");
        // $this->load->model("website/tickets_model","model_tickets");
        
        $this->load->helper('file');

        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );        
        // $this->load->model('M_product');
        load_user_language();
        $this->user_id  = 0; 
        $this->userTimezone = ($this->session->userdata('user_time_zone')?$this->session->userdata('user_time_zone'):config_item('user_time_zone'));
     }
     function index()
     {
         echo "hi";
     }
     public function stripe($session_id=''){
         if($session_id){
             $data['session_id'] = $session_id;
            $this->load->view('stripe_myview',$data);
         }else{
             echo "something went wrong";
         }
     }
     public function init(){
         $data = [];
         $this->load->view("payment/init_form",$data);
     }
     public function success_url(){
         echo "success";
     }
     public function cancel_url(){
         var_dump($_POST);
     }
     public function ipn_url(){
         
         $merchant_id = '7489bd8607d71bfc517c459b41cb6eca';
        $secret = 'dAaV5852';
        
        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
          die("No HMAC signature sent");
        }
        
        $merchant = isset($_POST['merchant']) ? $_POST['merchant']:'';
        if (empty($merchant)) {
          die("No Merchant ID passed");
        }
        
        if ($merchant != $merchant_id) {
          die("Invalid Merchant ID");
        }
        
        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
          die("Error reading POST data");
        }
        
        $hmac = hash_hmac("sha512", $request, $secret);
        if ($hmac != $_SERVER['HTTP_HMAC']) {
          die("HMAC signature does not match");
        }
         
         $data = 'Some file data '.json_encode($_POST);
        if ( ! write_file('./file_write.txt', $data,"a+"))
        {
                echo 'Unable to write the file';
        }
        else
        {
                echo 'File written!';
        }
        
        // HMAC Signature verified at this point, load some variables.

        $ipn_type = $_POST['ipn_type'];
        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $amount1 = floatval($_POST['amount1']);
        $amount2 = floatval($_POST['amount2']);
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];
    
        if ($ipn_type != 'button') { // Advanced Button payment
            die("IPN OK: Not a button payment");
        }
    
        //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point
    
        // Check the original currency to make sure the buyer didn't change it.
        if ($currency1 != $order_currency) {
            errorAndDie('Original currency mismatch!');
        }
    
        // Check amount against order total
        if ($amount1 < $order_total) {
            errorAndDie('Amount is less than order total!');
        }
     
        if ($status >= 100 || $status == 2) {
            // payment is complete or queued for nightly payout, success
        } else if ($status < 0) {
            //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
        } else {
            //payment is pending, you can optionally add a note to the order page
        }
        die('IPN OK');
     }
}
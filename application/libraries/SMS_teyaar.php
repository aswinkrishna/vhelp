<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  SMS {

    //API Doc URL : https://www.smscountry.com/bulk-smsc-api-documentation

    //SMS Country User ID
    private $username;

    //SMS Country Password
    private $password;

    //SMS Country Sender ID; 
    private $sender_id;

    //Type of Message, Default N: Normal Message, for more check the above url
    private $message_type;

    //Delivery Reports, Default:Y, for more check the above url
    private $delivery_report;

    //sms country Url
    private $url;

    //proxy ip address if the server is behind a proxy server
    private $proxy_ip;

    //proxy server port
    private $proxy_port;

    public $curl_response;

    public $curl_error;

    public $curl_info;

    function __construct() {

        $this->username         = "teyaar";//username
        $this->password         = "06046347";//password
       
        $this->sender_id        = "smscntry";
        $this->message_type     = "N";
        $this->delivery_report  = "Y";
        $this->url              = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
        $this->proxy_ip         = "";
        $this->proxy_port       = "";


    }

    function init($config = array()) {
        foreach($config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function send_normal_SMS($message, $mobile_numbers, $sender_id="") {
        $this->message_type = "N";

        $message    = urlencode($message);

        $this->sender_id = (!empty($sender_id)) ? $sender_id : $this->sender_id; 

        $ch = curl_init();

        if (!$ch)  {
            $this->curl_error = "Couldn't initialize a cURL handle";
            return false;
        }
        //echo $this->url."User=".$this->username."&passwd=".$this->password."&mobilenumber=".$mobile_number ."&message=".$message."&sid=".$this->sender_id."&mtype=".$this->message_type."&DR=".$this->delivery_report;
        //$ret = curl_setopt($ch, CURLOPT_URL,$this->url."?User=".$this->username."&passwd=".$this->password."&mobilenumber=".$mobile_number ."&message=".$message."&sid=".$this->sender_id."&mtype=".$this->message_type."&DR=".$this->delivery_report);
        $ret = curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"User=".$this->username."&passwd=".$this->password."&mobilenumber=".$mobile_numbers ."&message=".$message."&sid=".$this->sender_id."&mtype=".$this->message_type."&DR=".$this->delivery_report);
        
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(!empty($this->proxy_ip))
            $ret = curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip.":".$this->proxy_port);

        $this->curl_response = curl_exec($ch); 

        if(curl_errno($ch)) 
            $this->curl_error = curl_error($ch);

        if (empty($ret)) {
            curl_close($ch);
            return false;
        } 
        else {
            $this->curl_info = curl_getinfo($ch);
            curl_close($ch);
            return true;
        }

    }


}
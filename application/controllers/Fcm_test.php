<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FCM_test extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("FCM_Notification");

        $this->fcm_notification->init(array(
            "project_id" => "13001275007",
            "authorization_key" => "AAAAAwbvtn8:APA91bHfre0XDCcMlngy7Q_ZujUFNlg8mYqaIh3C1j49JrtRUvD6y3iTQ5zh1Dy8Y2EXpdcer4NpkR2IStjw4Zj7e1mylkondnP7rD8c4LNa-iHksG7Le_4h6eD72Wynb0XN0ljgwrTi"
          ));


    }

    public $topic_id = "APA91bGTHkLOPkLSH6sEsZcXAxxJL89aBdkKydXYmF6Z9bVtsX_6LoRWpjLHyvhjEdwYxvwYF5rcUQhCLlt90x597gsi1wPr9m6VRFeoriLytReC-4RTdUu-W5BtVL7ZKAGqh0vg51UT";
    
    function create_mebuycar_dealers() {
        var_dump($this->fcm_notification->create_notification("mebuycar_dealer_live_bid",array("edyuXbmbeZk:APA91bGSNsOEhwdobJTkfzJXGmzkiRhSyEaaMJxODccIIyTliQHRotDZnf_9HYDOU6oVCCQA1eJ_2CktBTr2GoYgCuDN28BdsIFyZ7xZNzWhOjPuwEj1ajasdKtWO1zMzVZJeQZ7_PJx")));
         
     }

    function add_device() {
        $this->fcm_notification->add_notification_device($this->topic_id,"test_n",array("fEj-ACY-tvs:APA91bGh7yqz7DmkoTrrKlQF6QnYigwCDar1eggO7FQGvjEt0LZPs1pEonlUV5mEsFTWACG37sFT8fpAntjxFojsq4fUezeUWqUVgdSeqJIaLYxWqTzoa0CylxoCtsTue-uI6dzvY41S"));
        var_dump($this->fcm_notification->curl_response);
    }

    function sendM() {
        $this->fcm_notification->send_notification($this->topic_id, array(
                                                                        "title"=>"MeBuy Car", 
                                                                        "body"=>"This is a test notification (MeBuyCar)"
                                                                    ),
                                                                    array(
                                                                        "type"=>"Live",
                                                                        "channel_id"=>"123",
                                                                        "user_id"=>2
                                                                    ));
    var_dump($this->fcm_notification->curl_response);
    }

    function create() {
       var_dump($this->fcm_notification->create_notification("test_n",array('f9ABboZrNx8:APA91bGpyixmpWlf5Yp-dOtgMFiVqmtCjn07pTz3892DoQNrj2qphg3RYT-SYIT3nsPOHQN2WYArvIIVziMmICVHvfftjIYWqz8h1iKbihAbKaOeOhoMXEfXR8d-v9slapG3BfZNV02x')));
        
    }
}
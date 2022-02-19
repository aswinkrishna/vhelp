<?php

class FCM_Notification {

    //Firebase project id
    private $project_id;

    //Firebase project authorization key
    private $authorization_key;

    //Url
    private $url;

    //proxy ip address if the server is behind a proxy server
    private $proxy_ip;

    //proxy server port
    private $proxy_port;

    public $curl_response;

    public $curl_error;

    public $curl_info;


    public function __construct() {
        
        $this->url                  = "https://fcm.googleapis.com/fcm/notification";
        $this->project_id           = "vhelp-eb526";
        $this->authorization_key    = "AAAAa_PsRL4:APA91bGf6xV1OVIgKuoj2_KVi6GHdfSjudS6q9csrCsN2koHDTlUQwPFmnlfogN9-IrOvJ4NwHJr85k0i5LC2gzaxZ9LqUUj9pG-2Vky6Cac8ilN7HVdIl0RyJHwDFNr8ABbPDTGTs3w";

    }

    public function init($config = array()) {
        foreach($config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    private function headers() {
        return array(
            "Authorization: key=". $this->authorization_key,
            "Content-Type: application/json",
            "project_id: " . $this->project_id
        );
    }

    public function create_notification_group($notification_group_name, $registeration_ids = array()) {
        $fields = array(
            "operation" => "create",
            "notification_key_name" => $notification_group_name,
            "registration_ids" => $registeration_ids
        );

       if ($this->send(json_encode($fields)) ) {
            return json_decode($this->curl_response);
       }
       else
            return false;
    }

    public function add_notification_device($notification_key, $notification_group_name, $registeration_ids = array()) {
        $fields = array(
            "operation" => "add",
            "notification_key_name" => $notification_group_name,
            "notification_key" => $notification_key,
            "registration_ids" => $registeration_ids
        );

       if ($this->send(json_encode($fields)) ) {
            return json_decode($this->curl_response);
       }
       else
            return false;
      
    }

    public function remove_notification_device($notification_key, $notification_group_name, $registeration_ids = array()) {
        $fields = array(
            "operation" => "remove",
            "notification_key_name" => $notification_group_name,
            "notification_key" => $notification_key,
            "registration_ids" => $registeration_ids
        );

       if ($this->send(json_encode($fields)) ) {
            return json_decode($this->curl_response);
       }
       else
            return false;
      
    }

    public function send_single_notification($fcm_token, $notification, $data, $priority = 'high') {
        $fields = array(
            'notification' => $notification,
            'data'=>$data,
            'content_available' => true,
            'priority' =>  $priority,
            'to' => $fcm_token
        );
      //  print_r($fields);

        if ( $this->send(json_encode($fields), "https://fcm.googleapis.com/fcm/send") ) {
            return json_decode($this->curl_response);
        }
        else
            return false;
    }

    public function send_notification($notification_key, $notification, $data, $priority = 'high') {
        $fields = array(
            'notification' => $notification,
            'data'=>$data,
            'content_available' => true,
            'priority' =>  $priority ,
            'to' => $notification_key
        );

        if ( $this->send(json_encode($fields), "https://fcm.googleapis.com/fcm/send") ) {
            return json_decode($this->curl_response);
       }
       else
            return false;

    }

    public function send($fields,  $url ="", $headers = array() ) {

        if(empty($url)) $url = $this->url;

        $headers = array_merge($this->headers(), $headers);

        $ch = curl_init();

        if (!$ch)  {
            $this->curl_error = "Couldn't initialize a cURL handle";
            return false;
        }

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $this->curl_response = curl_exec($ch); 

        if(curl_errno($ch)) 
            $this->curl_error = curl_error($ch);

        if ($this->curl_response == FALSE) {
            return false;
        } 
        else {
            $this->curl_info = curl_getinfo($ch);
            curl_close($ch);
            return true;
        }

    }

}

/* -------- Usage --------- 
$response = $fcmNotification->send_notification(TOPIC ID / NOTIFICATION KEY, array(
                                                        "title"=>"TITLE", 
                                                        "body"=>"MESSAGE",
                                                        "icon"=>'myicon',
                                                        "sound" =>'default'
                                                    ),
                                                    array(
                                                        "type"=>"NOTIFICATION TYPE",
                                                        "ADDITIONAL DATA 1"=>"",
                                                        "ADDITIONAL DATA 2"=>""
                                                    )); 

$response = $fcmNotification->send_single_notification(FCMTOKEN, array(
                                                                    "title"=>"TITLE", 
                                                                    "body"=>"MESSAGE",
                                                                    "icon"=>'myicon',
                                                                    "sound" =>'default'
                                                                ),
                                                                array(
                                                                    "type"=>"NOTIFICATION TYPE",
                                                                    "ADDITIONAL DATA 1"=>"",
                                                                    "ADDITIONAL DATA 2"=>""
                                                                )); */

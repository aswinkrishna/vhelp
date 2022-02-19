<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller 
{
    public function __construct()
     {
          parent::__construct();
          $this->load->model('services/M_chat');           
          error_reporting(E_ERROR | E_PARSE);
          load_user_language();
          $this->load->library("FCM_Notification");
          $this->load->helper('eq_helper');  
     }
     public function initiateChat()
	{
		 $language       =  ($_POST['language'] == 2 ? $_POST['language'] : 1);
         $senderId       =  $_POST['sender_id'];
         $recieverId     =  $_POST['reciever_id'];
         $message        =  $_POST['message'];
         $reciever_id    =  $recieverId;
         $sender_id      =  $senderId;
        
          if ($senderId <= 0) 
         {
            $output['status'] = "0";
            $output['message'] = "sender_id is required";
            echo json_encode($output);
            exit;
        }
        else if ($recieverId<=0) 
        {
            
            $output['status']  = "0";
            $output['message'] = "reciever_id is required";
            echo json_encode($output);
            exit;
        }
         else if ($message=="") 
        {
            
            $output['status']  = "0";
            $output['message'] = "message is required";
            echo json_encode($output);
            exit;
        }
        else
        { 
            
            $database                    =  get_firebase_refrence();
            $input['reciever_id']        =  $recieverId;
            $input['sender_id']          =  $senderId;
            $input['chat_message']       =  $message!=""?$message:" ";
            $input['chat_started_time']  =   round(microtime(true) * 1000);  //added milli second format
            $input['chat_status']        =  1;
            $result                      =  $this->M_chat->initiateChat($input);

if($result>0)
{


 
  $newPost3 = $database
 ->getReference('chat/'.$sender_id.'/last_chat/'.$result.'/')
 ->set([
        "last_chated_time" =>$input['chat_started_time'],
        "sender_id" =>$sender_id,
        "reciever_id" =>$reciever_id,
        "message" =>$message,       
        "unseen_msg_count"=>"0" 
        ]);




 $newPost4 = $database
 ->getReference('chat/'.$reciever_id.'/last_chat/'.$result.'/')
 ->set([
      "last_chated_time" =>$input['chat_started_time'],
        "sender_id" =>$sender_id,
        "reciever_id" =>$reciever_id,
        "message" =>$message,
        "unseen_msg_count"=>"1",
 ]);
  
  $newPost1 = $database
 ->getReference('chat/'.$sender_id.'/'.$result.'/messages/')
 ->push([
        "sender_id" =>$sender_id,
        "reciever_id" =>$reciever_id,
        "message" =>$message,
        "status" =>1,
        "date"=>$input['chat_started_time']
 ]);
 $newPost2 = $database
 ->getReference('chat/'.$reciever_id.'/'.$result.'/messages/')
 ->push([
        "sender_id" =>$sender_id,
        "reciever_id" =>$reciever_id,
        "message" =>$message,
        "status" =>1,
        "date"=>$input['chat_started_time']
 ]);
 
 if($newPost1!="")
 {
            $i = 0;
            $output['status']  = "1";
            $output['message'] = "chat started";
            $thirdperson                                 =   $reciever_id;
            $output['data']['second_person_id']      =   (string)$thirdperson;
            $resultRow                                   =   $this->M_chat->getNameAndImage($thirdperson);
            $output['data']['second_person_name']    =   $resultRow->user_first_name." ".$resultRow->user_last_name;
            $secondpersonname                            =   $resultRow->user_first_name." ".$resultRow->user_last_name;;
            $output['data']['second_person_fcm']     =   $resultRow->fcm_token!=""?$resultRow->fcm_token:"";            
            $imagePathProf                               =   $resultRow->image!=""?base_url().'uploads/user/'.$resultRow->image:base_url().'frontend_assets/images/avatar.jpg.jpg';
            $output['data']['second_person_image']   =   $imagePathProf;
            $message                                     =   "New message recieved from - ".$secondpersonname;
            // $this->FCM_notification->sendGCM($message,$fcmtoken,$sender_id);
            //single push
        
           $extraData['title']          =  "Emirates quotation";
           $extraData['id']             =   $result;
           $extraData['type']           =  "chat";
           $extraData['click_action']   =  "chat";
           $message['title']            =  "Emirates quotation"; 
           $message['body']             =   $message;
           $message['click_action']             =   "chat";
            $this->fcm_notification->send_notification($resultRow->fcm_token,$message,$extraData);
            
            $output['chat_id'] = (string)$result;
            echo json_encode($output);
            exit;
 }
 else
 {
            $output['status']  = "0";
            $output['message'] = "Something went wrong,try again later";
            $output['data']    = (object) array();
            echo json_encode($output);
            exit;
 }
}
else
{
            $output['status'] = "0";
            $output['message'] = "Something went wrong";
            $output['data']    = (object) array();
            echo json_encode($output);
            exit;
}

//echo json_encode($response);exit;
            
        }
        
  } 
  public function checkAlreadyChatted()
	{

         $language       =  ($_POST['language'] == 2 ? $_POST['language'] : 1);
         $senderId       =  $_POST['sender_id'];
         $recieverId     =  $_POST['reciever_id'];
         $message        =  $_POST['message'];
        
          if ($senderId <= 0) 
          {
            $output['status'] = "0";
            $output['message'] = "sender_id is required";
            echo json_encode($output);
            exit;
        }
        else if ($recieverId<=0) 
        {
            
            $output['status']  = "0";
            $output['message'] = "reciever_id is required";
            echo json_encode($output);
            exit;
        }
        else
        { 
            
            
             $result = $this->M_chat->checkAlreadyChatted($_POST);
             
            if(count($result)>0)
            {

              $resultRow                     =   $this->M_chat->getNameAndImage($recieverId);
              $output['second_person_id']    =   (string)$recieverId;
              $output['second_person_name']  =   $resultRow->user_first_name." ".$resultRow->user_last_name;
              $output['second_person_image'] =   $resultRow->image!=""?base_url().'uploads/user/'.$resultRow->image:base_url().'frontend_assets/images/avatar.jpg.jpg';
              $output['second_person_fcm']   =   $resultRow->fcm_token;
               
                  
              $output['status']     = "1";
              $output['message']    = "success";

              $output['chat_id'] = (string)$result;
              echo json_encode($output);
              exit;
            
            }
            else
            {
              $resultRow                       =   $this->M_chat->getNameAndImage($recieverId);
              $output['second_person_id']      =   (string)$recieverId;
              $output['second_person_name']    =   $resultRow->user_first_name." ".$resultRow->user_last_name;
              $output['second_person_fcm']     =   $resultRow->fcm_token!=""?$resultRow->fcm_token:"";
              $output['second_person_image']   =   $resultRow->image!=""?base_url().'uploads/user/'.$resultRow->image:base_url().'frontend_assets/images/avatar.jpg.jpg';
              $output['status']                =   "0";
              $output['message']               =   "failed";
              $output['chat_id']               =    "";
              echo json_encode($output);
              exit;
            }
            
        }
	} 
     
}
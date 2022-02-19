<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct()
     {
         parent::__construct();
         $this->load->model('services/M_user');      
         $this->load->model('M_admin');  
         error_reporting(E_ERROR | E_PARSE);
        // header('Content-Type: application/json');
        $this->load->helper('eq_helper');  
     }
   public function login()
    {
            
             
       
            

    }
    public function userRegistration()
    {
                             $inputArray     = array();	    
	         $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
	         
	         if($languageCode==2)
	         {
                     
	               $this->lang->load("message","arabic");
                      
	         }
	         else
	         {
	              $this->lang->load("message","english");
                      
	         }
	        
            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|max_length[100]|xss_clean');
            
            if($_POST['user_id']<=0)
            {
            $this->form_validation->set_rules('user_email', 'user_email', 'trim|required|valid_email|max_length[100]');
            $this->form_validation->set_rules('user_password', 'user_password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
            // $this->form_validation->set_rules('user_device_token', 'user_device_token', 'required|max_length[500]');
            //$this->form_validation->set_rules('user_device_type', 'user_device_type', 'required|max_length[20]|alpha');
            }
           // $this->form_validation->set_rules('user_gender', 'user_gender', 'required|numeric');
            $this->form_validation->set_rules('user_country', 'user_country', 'required|numeric');
           // $this->form_validation->set_rules('user_city', 'user_city', 'required|numeric');
            $this->form_validation->set_rules('user_dial_code', 'user_dial_code', 'required|numeric|max_length[5]');
            $this->form_validation->set_rules('user_phone', 'user_phone', 'required|numeric|max_length[12]');
           
          //$this->form_validation->set_rules('newsletter_subscribe_status', 'newsletter_subscribe_status', 'required|numeric');
            
                if ($this->form_validation->run() == FALSE)
                {  
                        $output['status']   =  "0";
                        $output['message']  =  strip_tags(validation_errors());                   
                        echo json_encode($output);
                        exit;
                }
                else
                {
                                             $input['user_first_name']                    =                 trim($this->input->post("first_name"));
                                             $input['user_last_name']                     =                 trim($this->input->post("last_name"));
                 if($_POST['user_id']<=0)
            {
                                             $input['user_email']                              =                 trim($this->input->post("user_email"));
                                             $input['user_password']                      =                 MD5($this->input->post("user_password"));
                                             
                                             
            }
                                             $input['user_company_name']                       =                 $this->input->post("company_name");
                                             $input['country_id']                              =                 trim($this->input->post("user_country"));
                                             
                                             if($this->input->post("user_city")>0)
                                             {
                                              $input['city_id']                                      =                 trim($this->input->post("user_city"));
                                             }
                                             $input['user_phone']                            =                 trim($this->input->post("user_phone"));
                                             $input['user_dial_code']                      =                 trim($this->input->post("user_dial_code"));
                                             $input['user_type']                                =                1;
                                             $input['user_zip']                                   =                 trim($this->input->post("user_zip"));
                                            // $input['user_company_name']                                   =                 trim($this->input->post("txt_company_name"));
                                             $input['user_status']                             =                 1;
                                             $input['user_created_methode']       =                 "mob";                                             
                                             $input2["building"]                               =               trim($this->input->post("user_building"));
                                             $input2["appartment"]                        =               trim($this->input->post("user_apprtment"));
                                             $input2["area"]                                      =               trim($this->input->post("user_area"));
                                             
                                             
                                             if($this->input->post("user_id")>0)
                                             {
                                                 unset($input['user_email']);
                                                 unset($input['user_password']);
                                                 $input['user_id']                                 =                 trim($this->input->post("user_id"));
                                                 $input['user_updated_by']              =                 $input['user_id'] ;
                                                 $input['user_updated_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                             else
                                             {
                                                 $input['user_created_by']              =                 0;
                                                 $input['user_created_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                             
                                             
                                          if($_FILES["profile_image"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$user_id;
                                   
                                    $filename2 = $_FILES["profile_image"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                   // $config2['max_size']             =  1000;
                                    //$config2['max_width']            =  1024;
                                    //$config2['maxprofile_image_height']           =  768;
                                   $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
									 $this->load->library('upload', $config2);
                                     $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('profile_image'))
                                   {
                                      // print_r($_FILES['image']['error']);
                                     //  die("profile upload failed");
                                     
                                     
                                    $output['status']                =  "0";
                                    $output['message']               =  "profile upload failed"; 
                                    echo json_encode($output);
                                    exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input['user_image']  =   $config2['file_name']  ;
                                   }
                                   
                                
				 
			 }   
			 
			                                 $digits                                      =                 4;
                                             $generatedOtp                                =                 rand(pow(10, $digits-1), pow(10, $digits)-1);
                                             $otp['otp']                                  =                 $generatedOtp;
                                             $otp['otp_send_time']                        =                 gmdate("Y-m-d H:i:s");
                                             $otp['otp_validity_end_time']                =                 date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
                                             
                                             
                                            $result          =   $this->M_user->saveUser($input,$input2,$otp);
                                            
                                            if($result>0)
                                            {
                                                
                                                 $output['status']              =   "1";
                                                 $output['message']             =   $this->input->post("user_id")<=0?"success":"Profile has been updated successfully";
                                                 $output['otp_id']              =   $this->input->post("user_id")<=0?(string)$result:"";
                                                 $output['user_id']             =   $this->input->post("user_id")>0?(string)$result:"";
                                                 
                                                 echo json_encode($output);
                                                 
                                                 if($this->input->post("user_id")<=0)
                                                 {
                                                     
                                                 
                                                  $this->load->library("SMS");
                                                  $this->load->library("parser");
                                                  $customer_mobile_no =   trim($this->input->post("user_dial_code")).trim($this->input->post("user_phone"));
                                                  $customer_name      =   $this->input->post("first_name");
                                                    
                                                  $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                                            array("customer_name"=>$customer_name,
                                                                  "otp"=> $generatedOtp,
                                                                 ),TRUE),$customer_mobile_no); 
                                                  
                                                    
                                                    
                                                       $subject                 =  "Welcome to Emirates Quotation ";
                                                       $userMaiArray['message'] =  "Your one time password OTP is ".$generatedOtp.". This is valid for the next 10 minutes"; 
                                                       $userMaiArray['name']    =   $customer_name;
                                                       $to                      =   trim($this->input->post("user_email"));
                                                       $userMaiArray['subject'] =  $subject;
                                                       //$this->load->library('parser');
                                                       $email_message  = $this->parser->parse('email/status_change', $userMaiArray, true);
                                                       $this->load->library("Mail_function");
                                                       $this->mail_function->SendEmail($email_message,$subject,$to);
                                                    }
                                                    else
                                                    {
                                                        $user                        =     $this->M_user->getRequiredFieldsforNotification($this->input->post("user_id"));
                                                        $userFullname                =     $user->user_first_name." ".$user->user_last_name;  
                                                        $database                    =     get_firebase_refrence();
                                                        $database->getReference("user_details/" . $this->input->post("user_id")."/")->update(["fcm_token"=>trim($user->fcm_token),"user_first_name"=>$user->user_first_name,"user_last_name"=>$user->user_last_name,"user_type"=>$user->user_type,"image"=>$user->user_image,"user_name"=>$userFullname]);
                    
                    
                    
                                                    }
                                                       exit;
                                            }
                                            else if($result==0)
                                            {
                                                 $output['status']              =   "0";
                                                 $output['message']             =   $this->lang->line("reg_fail");
                                                 $output['otp_id']              =    "";
                                                 $output['user_id']             =   "";
                                            }
                                             else if($result<0)
                                            {
                                                 $output['status']              =   "0";
                                                 $output['message']             =   $this->lang->line("email_exist");
                                                 $output['otp_id']              =   "";
                                                 $output['user_id']             =   "";
                                            }
                                           echo json_encode($output);exit;     
                     
                }
    }
    function verifyOtp()
    {
                $this->form_validation->set_rules('otp_id', 'otp_id', 'required|numeric');
                $this->form_validation->set_rules('otp', 'otp', 'required|numeric|max_length[4]');
                if ($this->form_validation->run() == FALSE)
                {  
                        $output['status']   =  "0";
                        $output['message']  =  strip_tags(validation_errors());                   
                        echo json_encode($output);
                        exit;
                }
                else
                {
                    $result         =   $this->M_user->verifyOtp($this->input->post());
                    
                    if($result>0)
                    {
                        $output['status']   =  "1";
                        $output['message']  =  "Registration has been completed"; 
                        
                             echo json_encode($output);
                        
                              $userDetails              =  $this->M_user->getRequiredFieldsforNotification($result); 
                                
                              $subject                  = "Welcome to Emirates Quotation ";
                              $userMaiArray['message']  = "Thankyou for registering with emirates quotation. Please proceed to log in to your account and request services."; 
                              $userMaiArray['name']     = $userDetails->user_first_name;
                              $to                       = $userDetails->user_email;
                              $userMaiArray['subject']  = $subject;
                              $this->load->library('parser');
                              $email_message            = $this->parser->parse('email/welcome', $userMaiArray, true);
                              $this->load->library("Mail_function");
                              $this->mail_function->SendEmail($email_message,$subject,$to);
                              
                              exit;
                    }
                    else if($result==-1)
                    {
                        $output['status']   =  "0";
                        $output['message']  =  "OTP has been expired"; 
                    }
                     else if($result==-2)
                    {
                        $output['status']   =  "0";
                        $output['message']  =  "Invalid OTP"; 
                    }
                     else
                    {
                        $output['status']   =  "0";
                        $output['message']  =  "Failed to validate OTP"; 
                    }
                    
                    echo json_encode($output);exit;   
                   
                    
                }
    }
    function resendOtp()
    {
        
                $this->form_validation->set_rules('otp_id', 'otp_id', 'required|numeric');
                if ($this->form_validation->run() == FALSE)
                {  
                        $output['status']   =  "0";
                        $output['message']  =  strip_tags(validation_errors());                   
                        echo json_encode($output);
                        exit;
                }
        
                   $digits                                      =                 4;
                   $generatedOtp                                =                 rand(pow(10, $digits-1), pow(10, $digits)-1);
                   $otp['otp']                                  =                 $generatedOtp;
                   $otp['otp_send_time']                        =                 gmdate("Y-m-d H:i:s");
                   $otp['otp_validity_end_time']                =                 date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
                   $_POST['txt_ver']                            =                 $this->input->post("otp_id");
                   $result         =   $this->M_user->resendOtp($this->input->post(),$otp);
                   $data['status'] =   $result;
                   //echo json_encode($data);
                    if($result>0)
                    {
                          $output['status']   =  "1";
                          $output['message']  =  "OTP sent to your email and mobile";
                          echo json_encode($output);
                        
                          $userDetails              = $this->M_user->getRequiredFieldsforNotificationFromTemp($result); 
                          $this->load->library("SMS");
                          $this->load->library("parser");
                          $customer_mobile_no =   trim($userDetails->user_dial_code).trim($userDetails->user_phone);
                          $customer_name      =   $userDetails->user_first_name;
                          $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                    array("customer_name"=>$customer_name,
                                          "otp"=> $generatedOtp,
                                         ),TRUE),$customer_mobile_no); 
                            
                           $subject                 =  "Welcome to Emirates Quotation ";
                           $userMaiArray['message'] =   "Your one time password OTP is ".$generatedOtp.". This is valid for the next 10 minutes";
                           $userMaiArray['name']    =   $customer_name;
                           $to                      =   trim($userDetails->user_email);
                           $userMaiArray['subject'] =  $subject;
                           //$this->load->library('parser');
                           $email_message  = $this->parser->parse('email/status_change', $userMaiArray, true);
                           $this->load->library("Mail_function");
                           $this->mail_function->SendEmail($email_message,$subject,$to);
                          exit;
                    }
                    else
                    {
                        $output['status']   =  "0";
                        $output['message']  =  "Cannot resend OTP,try again later"; 
                        echo json_encode($output);
                    }
    }
      function loginUser()
    {
             $this->load->library("FCM_Notification");
             $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
             
              
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
             
            //$this->form_validation->set_rules('user_type_id', 'user type id', 'required');
             $this->form_validation->set_rules('user_mail_id', 'user_mail_id', 'trim|required|valid_email');
             $this->form_validation->set_rules('user_password', 'user_password', 'trim|required');
             $this->form_validation->set_rules('user_type', 'user_type', 'trim|required');
             $this->form_validation->set_rules('fcm_token', 'fcm_token', 'trim|required|xss_clean');
             $this->form_validation->set_rules('user_device_type', 'user_device_type', 'trim|required|max_length[20]|xss_clean|alpha_numeric');
            // $this->form_validation->set_rules('user_type_id', 'user_type_id', 'required');
             
             

                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                    
             $_POST = $this->security->xss_clean($_POST);                                     
             $inputArray['user_email'] =    $this->input->post('user_mail_id');
             $inputArray['user_password'] =  md5($this->input->post('user_password'));
             $inputArray['user_type']   =   $this->input->post('user_type');    
             $device_id =    $this->input->post('device_id');
     
                  
                             
                    $result= $this->M_user->userLoginnew($inputArray);

               

                    
                    if (count($result)>0) 
                    {
                       
                        
                        if($result->user_status=="1")
                        {
                            
                            $your_user_login    =   $this->input->post('user_mail_id');
                           $access_token          =   trim(md5(uniqid($your_user_login, true)));
                            
$data1=array(
'user_device_token'=>trim($this->input->post('user_device_token')),
'user_device_type'=>trim($this->input->post('user_device_type')),
 'user_last_login'=>gmdate('Y-m-d H:i:s'),
 "user_access_token"=>$access_token,
  "login_type"=>'N',
  'fcm_token'=>$this->input->post('fcm_token')
    
);

$reslt=$this->M_user->commonupdate('user_table',$data1,array('user_id'=>$result->user_id));

if($this->input->post('fcm_token')!="" && $result->user_type==2)
{

    // $reslt2=$this->M_user->addToFcmGroups($result->user_id,$this->input->post('fcm_token'));
}


$output['status']                                                                        =       "1";
$output['message']                                                                   =      $this->lang->line("login_success");
$output['data']['user_id']                                                        =     $result->user_id;
$output['data']['edit_status']                                                 =      $result->user_created_by==0 ?"1":"0";                                   
$output['data']['user_first_name']                                        =      ($result->user_first_name!=""?$result->user_first_name:"");
$output['data']['user_last_name']                                         =       ($result->user_last_name!=""?$result->user_last_name:"");
$output['data']['user_type']                                                    =        (string) ($result->user_type!=""?$result->user_type:"");
$img                                                         =                                                 base_url()."uploads/user/".$result->user_image;
$output['data']['image']                    =                           ($result->user_image!=""?$img:base_url().'images/user_dummy.png');
$output['data']['login_type']        =   ($result->login_type!=""?$result->login_type:"");
                                
$output['data']['user_country_id'] = ($result->user_country_id!=""?$result->user_country_id:"");      
$country_name=$this->M_user->get_single_row(array('country_id'=>$result->user_country_id),'country'); 
$output['data']['country_name']=$country_name->country_name!=""?$country_name->country_name:"";
$output['data']['access_token']=$access_token;

                                
          if($result->user_type==2)
          {
              $package= $this->M_user->getCurrentPackagePlan($result->user_id);
                
               $output['data']['package_name']=$package->packages_name_arabic!="" && $languageCode==2?$package->packages_name_arabic:$package->packages_name;
               $output['data']['package_id']   =$package->packages_id>0?(string)$package->packages_id:"";
          }
          else
          {
               $output['data']['package_name'] = "";
               $output['data']['package_id']   = "";
          }
                              
                    $userFullname                =     $result->user_first_name." ".$result->user_last_name;  
                    
                    $database                    =     get_firebase_refrence();
                         
                    $database->getReference("user_details/" . $result->user_id."/")->update(["fcm_token"=>trim($this->input->post('fcm_token')),"user_first_name"=>$output['data']['user_first_name'],"user_last_name"=>$output['data']['user_last_name'],"user_type"=>$this->input->post('user_type'),"image"=>$output['data']['image'],"user_name"=>$userFullname]);
                    
                    
                    
                    

                        }
                        else
                        {
                                $output['status']=   "0";
                                $output['message']=   $this->lang->line("not_activated");
                                $output['data']['user_id']               =    "";
                    
                            
                        }
                    }
                    else
                    {
                                $output['status']                        =    "0";
                                $output['message'] = $this->lang->line("incorrect_password");
                                $output['data']['user_id']               =    "";
                        
                    }
                            
                    
                     echo json_encode($output);exit;
                    
                }
               
        
    }
    

function Userlogout()   
{
 $this->load->library("FCM_Notification");
  
 $languageCode         =   ($this->input->post('language')==2?$this->input->post('language'):1);
 
$this->form_validation->set_rules('user_id','user_id','required|numeric'); 

if($this->form_validation->run() == FALSE)
{ 
$output['status']="0";
$output['message']=strip_tags(validation_errors());
}
else
{
$data=array(
'user_device_token'=>"",
'user_device_type'=>""    ,
    'user_access_token'=>"",
    'fcm_token'=>""
);    
$res=$this->M_user->commonupdate('user_table',$data,array('user_id'=>trim($this->input->post('user_id'))));    


if($res)
{
    
$res2 = $this->M_user->removeFcmGroups($this->input->post('user_id'));

$output['status']="1";
$output['message']="success";

}
else
{
$output['status']="0";
$output['message']="fail";
}
}
echo json_encode($output);
}

         function changePassword()
	{
         
                       
            
	        $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
	         
	         if($languageCode==2)
	         {
	              $this->lang->load("message","arabic");
	         }
	         else
	         {
	              $this->lang->load("message","english");
	         }
	        $acces_token             =   trim($this->input->post("access_token"));                     
                             $checkCode               =   $this->common_functions->validateAccessToken($acces_token);               
              if($checkCode<=0)
              {
                     echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                     exit;
              }
              else
              {
                  $user_id                             =   $checkCode ;
                  $_POST['user_id']            =   $user_id;
              }  
	  $this->form_validation->set_rules('user_old_password', 'user_old_password', 'trim|required|max_length[20]|min_length[8]');
                       $this->form_validation->set_rules('user_new_password', 'user_new_password', 'trim|required|max_length[20]|min_length[8]|callback_valid_password');
             

                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());
                  
                    echo json_encode($output);exit;
                }
                 
	  
                $paramArray  =  array("user_password" => ltrim(rtrim(MD5($_POST['user_old_password']))),"user_id"=>$user_id);
                $detail      =  $this->M_user->getUserRowByArray($paramArray);
                if(count($detail)>0)
                     {
                        
                           $inputArray  =  array("user_password"=>MD5($_REQUEST['user_new_password']));
//                           $result = $this->M_user->updateUser($inputArray);
$result = $this->M_user->commonupdate('user_table',$inputArray,array('user_id'=>$_POST['user_id']));

//echo $_POST['user_id'];
//print_r($result);
//print_r($inputArray);

                        if($result==true)
                        {
                            
                               $inputArray['user_id']           =   $user_id;
                               
                                               
                                                $result= $this->M_user->userLoginnew($inputArray);
                                                
                                                $to  = $result->user_email;

                                $output['message']  = $this->lang->line("pwd_change_success");;
                                $output['status'] =  "1" ;
                                echo json_encode($output);
                               
                           
                                $subject     = "Password Change";

                      $message ='<div style="background: #000000;max-width: 663px;
    margin: 0 auto;">
    <div style="background:url('.base_url().'frontend_assets/images/logo/logo.png);background-size:cover;text-align:center;width:257px;height:100px;">
	      <table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_-821489321370324384m_-5972142880707153026m_-5318728848388664051m_-847687700298387831template_header" style="background-color:black;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif">
                                                        <tbody>
                                                            <tr>
                                                                <td id="m_-821489321370324384m_-5972142880707153026m_-5318728848388664051m_-847687700298387831header_wrapper" style="padding:36px 48px;display:block">
                                                                    <h1 style="color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left"><img src="'.base_url().'"frontend_assets/images/logo/logo.png"></h1>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>	
	</div> 
   <div style="padding: 10px 20px">
		<div style="background: #fff;padding: 9px 30px;border-top: 7px solid #ef5b25;    padding-bottom: 0;overflow: hidden;margin: 20px 7px;border-radius: 0 0 3px 3px;">
			<h3 style="text-align: left;">'.$subject.'</h3>
			
			<p>Dear '.$result->user_first_name.',</p>
			<p>Your password has been reset successfully.</p>
			
			<p style="margin-bottom:5px">Thanks</p>
			<p style="margin:0">Emirates Quotations</p>
			<span style="display: block;
    text-align: center;
    color: #000000a6;
    padding: 14px 0;
    font-size: 11px;">&copy; 2019 Emirates Quotations All rights reserved.</span>
		</div>
	</div>
</div>';


                        $this->load->library("Mail_function");
                         $this->mail_function->SendEmail($message,$subject,$to);
                        }
                        else
                        {
                              $output['message']=$this->lang->line("pwd_change_failed"); 
                              $output['status'] =  "0" ;
                              echo json_encode($output);
                              exit;   
                        }
                         
                     }
                     else
                     {
                          $output['message']=$this->lang->line("old_pwd_not_match"); 
                          $output['status'] =  "0" ;
                          echo json_encode($output);
                          exit;
                     }
	     
	    
	}
    public function getCountryDropdowns()
	{


        
	        $language   = ($this->input->post('language')>0?$this->input->post('language'):1);
	        $condition=array('country_language_code' => $language,'country_status'=>1);
            $country=$this->M_admin->getCountriesCondition($condition);


	          
	        if (count($country)>0) 
	        {
	            $output['status']       =  "1";
	            $output['message']      =  "success";
	            $i = 0;
                foreach ($country as $row)
                {

                    $output['data'][$i]['name'] = ($row->country_name!="")?$row->country_name:"";
                    $output['data'][$i]['id']   =($row->country_id!="")?$row->country_id:"";
                    $output['data'][$i]['dial_code']=$row->country_dial_code;
                        
                        $i++;
                }
	        }
	        else
	        {  
	            $output['status']       =     "0";
	            $output['message']      =  "failed";
	            $output['data']         =  array();
	        }
	        
	        echo json_encode($output);exit;
	}

function getAllMasterS()
	{
	   
	        $language   = ($this->input->post('language')>0?$this->input->post('language'):1);
	        $condition=array('country_language_code' => $language,'country_status'=>1);
            $country=$this->M_admin->getCountriesCondition($condition);

            $output['status']       =  "1";
	        $output['message']      =  "success";
	          
	        if (count($country)>0) 
	        {
	           
	            $i = 0;
                foreach ($country as $row)
                {

                    $output['data']['country'][$i]['name'] = ($row->country_name!="")?$row->country_name:"";
                    $output['data']['country'][$i]['id']   =($row->country_id!="")?$row->country_id:"";
                    $output['data']['country'][$i]['dial_code']=$row->country_dial_code;
                        
                        $i++;
                }
	        }
	        else
	        {  
	            $output['status']                  =     "0";
	            $output['message']                 =  "failed";
	            $output['data']['country']         =  array();
	        }
	         $con['service_type_language_code']   = $language;
             $con['service_type_status']          = 1;
             $constServices                       =   $this->M_admin->getServiceTypes($con);  
            
                if (count($constServices)>0) 
	        {
	           
	            $i = 0;
                foreach ($constServices as $row)
                {

                    $output['data']['service_type'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                    $output['data']['service_type'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:"";
                    $output['data']['service_type'][$i]['icon']         = ($row->service_type_icon!="")?base_url().'uploads/service_type/'.$row->service_type_icon:"";
                    $output['data']['service_type'][$i]['banner']    = ($row->service_type_banner_image!="")?base_url().'uploads/service_type/'.$row->service_type_banner_image:"";
                    $output['data']['service_type'][$i]['main_label']      = ($row->main_label!="")?$row->main_label:"";
                    $output['data']['service_type'][$i]['sub_label']                     = ($row->sub_label!="")?$row->sub_label:"";
                    $output['data']['service_type'][$i]['service_type_desc']      = ($row->service_type_desc!="")?$row->service_type_desc:"";
                    $output['data']['service_type'][$i]['has_child']      =  $this->M_user->checkServiceTypeChildExist($row->service_type_id)>0?"1":"0";
                    $output['data']['service_type'][$i]['service_type_thumbnail']    = ($row->service_type_thumbnail!="")?base_url().'uploads/service_type/'.$row->service_type_thumbnail:"";
                    $output['data']['service_type'][$i]['is_home']      = "1"; 
                            
                        $i++;
                }
	        }
	        else
	        {  
	          
	                 $output['data']['service_type']         =  array();
	            
	        }
	        echo json_encode($output);exit; 
	}



            function getCityDropdowns()
            {

            





                $language   = ($this->input->post('language')>0?$this->input->post('language'):1);
              //  $this->form_validation->set_rules('language', 'Language', 'required');
                $this->form_validation->set_rules('country_id', 'country_id', 'required');



 if ($this->form_validation->run() == FALSE)
                {  
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());
                    //$output['message']  =  strip_tags(validation_errors());
                    echo json_encode($output);exit;
                }
                else
                {
                    
            $language   =  ($this->session->userdata('language')?$this->session->userdata('language'):1);
            $condition  =   array('city_language_code' => $language,'city_status'=>1,'city_country_id'=>$_POST['country_id']);
            $cityList   =   $this->M_admin->getCitiesCondition($condition);



            if(isset($cityList) && count($cityList)>0)
            {
           

if(count($cityList)>0)
{
    $output['status']   =  "1";
                    $output['message']  = "success";
       $i=0;
            foreach($cityList as $rows) 
            {


                    $output['data'][$i]['name'] = ($rows->city_name!="")?$rows->city_name:"";
                    $output['data'][$i]['id']   =($rows->city_id!="")?(string)$rows->city_id:"";
                    //$output['data'][$i]['dial_code']=$row->country_dial_code;
                    $i++;

         
               }

            }
                    $output['status']        =  "1";
                    $output['message']      =  "success";
                   // $output                        =          $dta;
                    echo json_encode($output);exit;
            }
            else
            {
                    $output['status']       =  "1";
                    $output['message']      =  "success";
                    $output['data']        =  array();
                    echo json_encode($output);exit;
            }
           



            }





           


         }

public function getServiceTypes()
	{


        
	        $language         =          ($this->input->post('language')>0?$this->input->post('language'):1);
	        $condition        =          array('service_type_language_code' => $language,'service_type_status'=>1);
                             if($this->input->post('parent_id')>0)
                             {
                                 $condition['service_type_parent_id']      = $this->input->post('parent_id');
                             }
                             $serviceType    =          $this->M_admin->getServiceTypes($condition);


	          
	        if (count($serviceType)>0) 
	        {
	            $output['status']       =  "1";
	            $output['message']      =  "success";
	            $i = 0;
                foreach ($serviceType as $row)
                {

                    $output['data'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                    $output['data'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:"";
                    $output['data'][$i]['icon']         = ($row->service_type_icon!="")?base_url().'uploads/service_type/'.$row->service_type_icon:"";
                    $output['data'][$i]['banner']    = ($row->service_type_banner_image!="")?base_url().'uploads/service_type/'.$row->service_type_banner_image:"";
                    $output['data'][$i]['main_label']      = ($row->main_label!="")?$row->main_label:"";
                    $output['data'][$i]['sub_label']                     = ($row->sub_label!="")?$row->sub_label:"";
                    $output['data'][$i]['service_type_desc']      = ($row->service_type_desc!="")?$row->service_type_desc:"";
                    $output['data'][$i]['has_child']      =  $this->M_user->checkServiceTypeChildExist($row->service_type_id)>0?"1":"0";
                    $output['data'][$i]['service_type_thumbnail']    = ($row->service_type_thumbnail!="")?base_url().'uploads/service_type/'.$row->service_type_thumbnail:"";
                    
                            
                        $i++;
                }
	        }
	        else
	        {  
	            $output['status']       =     "0";
	            $output['message']      =  "failed";
	            $output['data']         =  array();
	        }
	        
	        echo json_encode($output);exit;
	}
function forgotPassword()
	{
                            $user_email_id=$this->input->post('user_email_id');                            
                            $this->form_validation->set_rules('user_email_id', 'user_email_id', 'trim|required|valid_email|max_length[100]');
             
             

                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());
                    //$output['message']  =  strip_tags(validation_errors());
                    echo json_encode($output);exit;
                }
                            
	       $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
	         
	         if($languageCode==2)
	         {
	              $this->lang->load("message","arabic");
	         }
	         else
	         {
	              $this->lang->load("message","english");
	         }

             



                     $paramArray  =  array("user_email" => ltrim(rtrim($user_email_id)));

                     $detail      =  $this->M_user->getUserRowByArray($paramArray);



                     
                     
                     if(count($detail)>0)
                     {
                        if($detail[0]->login_type=='S')
                        {
                                              $output['message']= "You are using socialmedia login.So unable to sent password";
                                              $output['status'] =  "0" ;
                                              echo json_encode($output);
                                              exit;
                            
                        }
                          $userId                  =             $detail[0]->user_id;
                          $six_digit_random_number = mt_rand(100000, 999999);
//                        $inputArray  =  array("user_id" => $userId,"user_password"=>MD5($six_digit_random_number));
//                        $result = $this->M_user->updateUser($inputArray);
                        
                      
                        
                        $result=1 ;
                        
                        if($result==1)
                        { 

                                    $input['user_id']              =      $userId;
                                    $input['session_start_time']   =      gmdate("Y-m-d H:i:s");
                                    $currentDate                   =      strtotime($input['session_start_time']);
                                    $futureDate                    = $currentDate+(60*5);
                                    $formatDate                    = date("Y-m-d H:i:s", $futureDate);
                                    $input['session_end_time']     =      $formatDate;
                                    $this->db->where('user_id', $userId);
                                    $this->db->delete('password_reset');
                                    $this->db->insert('password_reset',$input);
                       
                                $firstname        =     $detail[0]->user_first_name;
                                $to               =     $detail[0]->user_email;
                                $subject          =     "Account Password Reset";
                                
                                 $encryptedUserId= $this->common_functions->encryptId($userId);
                                 $link=base_url()."reset_password/".$encryptedUserId;
                                 $output['message']         =            $this->lang->line("pwd_reset_success");
                                 $output['status']              =              "1" ;
                                 echo json_encode($output);
                                
                                $userMaiArray['message'] =  "We received a request to change your password.Please click <a href='".$link."'>here</a> to set up a new password for your account. This link expires after 5 minutes."; 
                                $userMaiArray['name']    =   $firstname;
                                $to                      =   $to;
                                $userMaiArray['subject'] =  $subject;
                                $this->load->library('parser');
                                $email_message  = $this->parser->parse('email/reset', $userMaiArray, true);
                                $this->load->library("Mail_function");
                                $this->mail_function->SendEmail($email_message,$subject,$to);  
                                 
                                 
                                 
                               /*// $mailMessge ="<p style='margin-top:-7px;'>Your account password reset successfull your current password is ".$six_digit_random_number."</p>" ;
                                $message ='<div style="background: #c9c0bf;max-width: 663px;
    margin: 0 auto;">
    <div style="background:url('.base_url().'frontend_assets/images/logo/logo.png);background-size:cover;text-align:center;width:57%;height:147px;">
		
	</div> 
   <div style="padding: 10px 20px">
		<div style="background: #fff;padding: 9px 30px;border-top: 7px solid #ef5b25;    padding-bottom: 0;overflow: hidden;margin: 20px 7px;border-radius: 0 0 3px 3px;">
			<h3 style="text-align: left;">'.$subject.'</h3>
			
			<p>Dear '.$firstname.',</p>
			<p>Please click <a href="'.$link.'">here</a> to reset your password ,the link will expire after 5 minutes .</p>
			
			<p style="margin-bottom:5px">Emirates Quotations</p>
			<p style="margin:0">Thanks</p>
			<span style="display: block;
    text-align: center;
    color: #000000a6;
    padding: 14px 0;
    font-size: 11px;">&copy; 2019 Emirates Quotations.</span>
		</div>
	</div>
</div>';
                                                                                                   
                                                                                                     
                                                                                           
                                
                         //SEND EMAIL SMTP
                         $this->load->library("Mail_function");
                         $this->mail_function->SendEmail($message,$subject,$to);
                        //        $this->M_homes->sendMail_new($tomailId,$denot,$subject,$mailMessge);*/
                        }
                        else
                        {
                         
                         $output['message']  = $this->lang->line("pwd_reset_failed");;
                         $output['status'] =  "0" ;
                         echo json_encode($output);
                         exit;   
                        }
                        
                        
                        
                         
                     }
                     else
                     {
                         
                        $output['message']= $this->lang->line("email_not_exist");
                        $output['status'] =  "0" ;
                        echo json_encode($output);
                        exit;
                         
                     }
                    
                    
              
	    
	    
	}
        public function providerRegistration()
    {
             $inputArray      = array();	    
	         $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
	         $this->load->library("FCM_Notification");
	         
	         if($languageCode==2)
	         {
                     
	               $this->lang->load("message","arabic");
                      
	         }
	         else
	         {
	              $this->lang->load("message","english");
                      
	         }
	        
	        $this->form_validation->set_rules('company_type', 'company_type', 'trim|required');
            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|max_length[100]|xss_clean');
            
            
            if($this->input->post("user_id")<=0)
            {
                $this->form_validation->set_rules('service_type_ids', 'service_type_ids', 'required');
                $this->form_validation->set_rules('user_email', 'user_email', 'trim|required|valid_email|max_length[100]');
                $this->form_validation->set_rules('user_password', 'user_password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
               // $this->form_validation->set_rules('user_gender', 'user_gender', 'required|numeric');
              //  $this->form_validation->set_rules('user_country', 'user_country', 'required|numeric');
              //  $this->form_validation->set_rules('user_city', 'user_city', 'required|numeric');
            }
            else
            {
                $this->form_validation->set_rules('company_name', 'company_name', 'required');
            }
            $this->form_validation->set_rules('user_dial_code', 'user_dial_code', 'required|numeric|max_length[5]');
            $this->form_validation->set_rules('user_phone', 'user_phone', 'required|numeric|max_length[12]');
           // $this->form_validation->set_rules('user_device_token', 'user_device_token', 'required|max_length[500]|alpha_numeric');
          //  $this->form_validation->set_rules('user_device_type', 'user_device_type', 'required|max_length[20]|alpha');
             // $this->form_validation->set_rules('txt_doc','Document typ','trim|required');
           //  $this->form_validation->set_rules('document_number', 'document_number', 'required|max_length[100]');
           if(empty($_FILES['file_doc']['name']) && $this->input->post("user_id")<=0 && $this->input->post("company_type")==1)
           {
               $this->form_validation->set_rules('file_doc','file_doc','trim|required');
           }
            
                if ($this->form_validation->run() == FALSE)
                {  
                        $output['status']   =  "0";
                        $output['message']  =  strip_tags(validation_errors());                   
                        echo json_encode($output);
                        exit;
                }
                else
                {
                                             $input['user_first_name']                    =                 trim($this->input->post("first_name"));
                                             $input['user_last_name']                     =                 trim($this->input->post("last_name"));
                                              if($this->input->post("user_id")<=0)
            {
                                             $input['user_email']                         =                 trim($this->input->post("user_email"));
                                             $input['user_password']                      =                 MD5($this->input->post("user_password"));
            }
            if($this->input->post("user_country")>0)
            {
                                             $input['country_id']                         =                 trim($this->input->post("user_country"));
            }
            if($this->input->post("user_city")>0)
            {
                    $input['city_id']                            =                 trim($this->input->post("user_city"));
            }
                                         
                                             $input['user_phone']                        =                 trim($this->input->post("user_phone"));
                                             $input['user_dial_code']                      =                 trim($this->input->post("user_dial_code"));
                                             $input['user_type']                                =                2;
                                             $input['user_zip']                                   =                 trim($this->input->post("user_zip"));
                                             $input['user_status']                             =                 $this->input->post("user_id")<=0?0:1;
                                             $input['user_created_methode']         =                 "mob";                                             
                                             $input2["document_type"]                       =              $this->input->post("document_type")>0?trim($this->input->post("document_type")):1;
                                             $input2["document_number"]                        =               trim($this->input->post("document_number"));
                                             $input2['company_name']         =              trim($this->input->post("company_name"));
                                             $input2['company_type']         =              trim($this->input->post("company_type"));
                                             
                    if($_FILES["file_doc"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                   
                                    $filename2 = $_FILES["file_doc"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =   $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']       =   'gif|jpg|png|jpeg|pdf|doc';
                                    //$config2['max_size']                 =   1000;
                                   // $config2['max_width']             =   1024;
                                   // $config2['max_height']            =   768;                                    
                                    $config2['file_name']                =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
	                                $this->load->library('upload', $config2);
                                    $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('file_doc'))
                                   {
                                       
                                      // echo $this->upload->display_errors();
                                       
                                       //die("file upload failed");
                                        $data['status'] = 0;
                                        $data['message'] ="file_doc=".$this->upload->display_errors();
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $input2['document_name']                 =   $config2['file_name'];
                                      
                                  }
				 
			 }
			        
                 if($_FILES["profile_image"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$user_id;
                                   
                                    $filename2 = $_FILES["profile_image"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                   // $config2['max_size']             =  1000;
                                    //$config2['max_width']            =  1024;
                                    //$config2['maxprofile_image_height']           =  768;
                                   $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
									 $this->load->library('upload', $config2);
                                     $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('profile_image'))
                                   {
                                      // print_r($_FILES['image']['error']);
                                     //  die("profile upload failed");
                                     
                                     
                                    $output['status']                =  "0";
                                    $output['message']               =  "profile upload failed"; 
                                    echo json_encode($output);
                                    exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input['user_image']  =   $config2['file_name']  ;
                                   }
                                   
                                
				 
			 }   
			  if($_FILES["profile_document"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$user_id.date("Ymdis");
                                   
                                    $filename2 = $_FILES["profile_document"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                   // $config2['max_size']             =  1000;
                                    //$config2['max_width']            =  1024;
                                    //$config2['maxprofile_image_height']           =  768;
                                   $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
									 $this->load->library('upload', $config2);
                                     $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('profile_document'))
                                   {
                                      // print_r($_FILES['image']['error']);
                                     //  die("profile upload failed");
                                     
                                     
                                    $output['status']                =  "0";
                                    $output['message']               =  "profile_document upload failed"; 
                                    echo json_encode($output);
                                    exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input2['profile_document']  =   $config2['file_name']  ;
                                   }
                                   
                                
				 
			 }   
			                                 $input2['website_url']  =    trim($this->input->post("website_url")); 
			 
                                             if($this->input->post("user_id")>0)
                                             {
                                                 unset($input['user_email']);
                                                 unset($input['user_password']);
                                                 $input['user_id']                                 =                 trim($this->input->post("user_id"));
                                                 $input['user_updated_by']              =                 $input['user_id'] ;
                                                 $input['user_updated_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                             else
                                             {
                                                 $input['user_created_by']              =                 0;
                                                 $input['user_created_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                              
                                            $input3['service_type_ids']  =  trim($this->input->post("service_type_ids"));
                                             
                                            $result         =   $this->M_user->saveProvider($input,$input2,$input3);
                                            if($result>0)
                                            {
                                                 $output['status']            =   "1";
                                                 $output['message']           =   $this->input->post("user_id")<=0?$this->lang->line("reg_success_pr"):$this->lang->line("reg_update_success_pr");
                                                 $output['user_id']           =   $result;
                                                 $inputArray['user_id']       =   $result;
                                                 echo json_encode($output);
                                                 $result= $this->M_user->userLoginnew($inputArray);
                                                 
                                                 if($this->input->post("user_id")>0)
                                                 {
                                                        $user                        =     $this->M_user->getRequiredFieldsforNotification($this->input->post("user_id"));
                                                        $userFullname                =     $user->user_first_name." ".$user->user_last_name;  
                                                        $database                    =     get_firebase_refrence();
                                                        $database->getReference("user_details/" . $this->input->post("user_id")."/")->update(["fcm_token"=>trim($user->fcm_token),"user_first_name"=>$user->user_first_name,"user_last_name"=>$user->user_last_name,"user_type"=>$user->user_type,"image"=>$user->user_image,"user_name"=>$userFullname]);
                    
                                                 }
                                                 
                                                   if(($result->user_type==1 || $result->user_type==2) && $this->input->post("user_id")<=0)
                                {
                                   
                                                                                                   $subject  =  "Welcome to Emirates Quotation! ";
                                                                                                   $to      =   $result->user_email;
                                                                                                   //$to      =  "syamca2s@gmail.com";
                                                                                                  // $from    =  "info@teyaar.com";
                                                                                                   
                             
                                                                                                   
                                                                                                   
              $subject = "Welcome to Emirates Quotation ";
              $userMaiArray['message'] = "Congratulations on successful registration. You can proceed with logging into your account after  account activation."; 
              $userMaiArray['name'] = $this->input->post("first_name");
              //$to               = $input1['user_email'];
              $userMaiArray['subject']  = $subject;
              $this->load->library('parser');
              $email_message  = $this->parser->parse('email/welcome', $userMaiArray, true);
              $this->load->library("Mail_function");
              $this->mail_function->SendEmail($email_message,$subject,$to);
              exit;
              
              
                                }
                                           exit;        
                                            }
                                            else if($result==0)
                                            {
                                                 $output['status']              =   "0";
                                                 $output['message']         =   $this->lang->line("reg_fail");
                                                 $output['user_id']          =    "";
                                            }
                                             else if($result<0)
                                            {
                                                 $output['status']              =   "0";
                                                 $output['message']         =   $this->lang->line("email_exist");
                                                 $output['user_id']          =   "";
                                            }
                                           echo json_encode($output);exit;     
                     
                }
    }
    function socialmediaLogin()//teyaar
    {

          
             $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
             
              //device id
             $device_id =    $this->input->post('device_id');
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
             
        // $this->form_validation->set_rules('user_type_id', 'user type id', 'required');
        $this->form_validation->set_rules('user_mail_id', 'user_mail_id', 'required|valid_email');
        //$this->form_validation->set_rules('user_password', 'User Password', 'required');
        $this->form_validation->set_rules('user_device_token', 'user_device_token', 'trim|required|max_length[500]|xss_clean');
        $this->form_validation->set_rules('user_device_type', 'user_device_type', 'trim|required|max_length[20]|xss_clean|alpha_numeric');


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());
                    //$output['message']  =  strip_tags(validation_errors());
                    echo json_encode($output);exit;
                }
                else
                {
                    $_POST = $this->security->xss_clean($_POST);
                    $image=$this->input->post('user_image');



                    $arr_fields=array();
                    $arr_where=array(); 

                    if(count($_FILES['user_image'])>0)
                    {
                        $digits   =  6;
                        $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                        $filename = $_FILES["user_image"]["name"];
                        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
                        $config['upload_path']='uploads/user';
                        $config['allowed_types']='gif|jpg|png|jpeg|JPEG|JPG|PNG';
                        //                                    $config['max_size']             =  100;
                        //                                    $config['max_width']            =  1024;
                        //                                    $config['max_height']           =  768;
                        $config['file_name']=substr($this->input->post('user_mail_id'), 0, 5)."_".$randomNo.".".$file_ext;
                        $this->load->library('upload', $config);
                        if ( ! $this->upload->do_upload('user_image'))
                        {
                        $output['status']   =  "0";
                        $output['message']  =  $this->upload->display_errors();
                        echo json_encode($output);exit;
                        }
                        else
                        {
                         $arr_fields['image']   =   $config['file_name'];
                        }
                    }


                    $inputArray['user_email_id'] =    $this->input->post('user_mail_id');                    
                    $arr_fields['user_password']=md5(rand());
                    $arr_fields['user_device_token']=$this->input->post('user_device_token');
                    $arr_fields['user_type']=1;
                    $arr_fields['user_device_type']=$this->input->post('user_device_type');
                    $arr_fields['user_first_name'] =$this->input->post('first_name');
                    $arr_fields['user_last_name'] = $this->input->post('last_name');
                    $arr_fields['login_type']="S";
                    $arr_fields['user_status']=1;
                    $arr_fields['user_email']=$this->input->post('user_mail_id');
                    $arr_where['user_email']=$this->input->post('user_mail_id');

                
                   $res   =  $this->M_user->socialmediaLogin($arr_fields,$this->input->post('user_mail_id'));

                  

                   if($res>0)
                   {
                       
                      $input['user_id']   = $res;
                       
                        $result= $this->M_user->userLoginnew($input);

               

                    
                    if (count($result)>0) 
                    {
                       
                        
                        if($result->user_status=="1")
                        {
                            
                            $your_user_login      =   $this->input->post('user_mail_id');
                           $access_token          =   trim(md5(uniqid($your_user_login, true)));
                            
$data1=array(
'user_device_token'=>trim($this->input->post('user_device_token')),
'user_device_type'=>trim($this->input->post('user_device_type')),
 'user_last_login'=>gmdate('Y-m-d H:i:s'),
 "user_access_token"=>$access_token,
  "login_type"=>'S',
  'fcm_token'=>$this->input->post('fcm_token')  
);

$reslt=$this->M_user->commonupdate('user_table',$data1,array('user_id'=>$result->user_id));

$output['status']                                                                        =       "1";
$output['message']                                                                   =      $this->lang->line("login_success");
$output['data']['user_id']                                                        =     $result->user_id;
$output['data']['edit_status']                                                 =      $result->user_created_by==0 ?"1":"0";                                   
$output['data']['user_first_name']                                        =      ($result->user_first_name!=""?$result->user_first_name:"");
$output['data']['user_last_name']                                         =       ($result->user_last_name!=""?$result->user_last_name:"");
$output['data']['user_type']                                                    =        (string) ($result->user_type!=""?$result->user_type:"");
$img                                                         =                                                 base_url()."uploads/user/".$result->user_image;
$output['data']['image']                    =                           ($result->user_image!=""?$img:base_url().'images/user_dummy.png');
$output['data']['login_type']        =   ($result->login_type!=""?$result->login_type:"");
                                
$output['data']['user_country_id'] = ($result->user_country_id!=""?$result->user_country_id:"");      
$country_name=$this->M_user->get_single_row(array('country_id'=>$result->user_country_id),'country'); 
$output['data']['country_name']=$country_name->country_name!=""?$country_name->country_name:"";
$output['data']['access_token']=$access_token;

                                
                    $userFullname                =     $result->user_first_name." ".$result->user_last_name;  
                    
                    $database                    =     get_firebase_refrence();
                         
                    $database->getReference("user_details/" . $result->user_id."/")->update(["fcm_token"=>trim($this->input->post('fcm_token')),"user_first_name"=>$output['data']['user_first_name'],"user_last_name"=>$output['data']['user_last_name'],"user_type"=>"1","image"=>$output['data']['image'],"user_name"=>$userFullname]);
                    
                               
                              
                                
                         


                        }
                        else
                        {
                                $output['status']=   "0";
                                $output['message']=   $this->lang->line("not_activated");
                                $output['data']['user_id']               =    "";
                    
                            
                        }
                    }
                    else
                    {
                                $output['status']                        =    "0";
                                $output['message'] = $this->lang->line("incorrect_password");
                                $output['data']['user_id']               =    "";
                        
                    }





                  


                   }
                   else
                   {
                        $output['status']=   "0";
                        $output['message']=   $this->lang->line("not_activated");
                        $output['data']=array();

                   }


                   
                  
                    

                   

                    
                  
        
    }
                   echo json_encode($output);exit;
  }
   function getUserFullDetails()
   {
       
             $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
          
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
    
        $this->form_validation->set_rules('access_token', 'access_token', 'required');
   


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                 $acces_token              =   trim($this->input->post("access_token"));    
              $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                             =   $checkCode ;
                            $_POST['user_id']             =   $user_id;
                        }
                        
                          $result= $this->M_user->getUserFullDetails($user_id,$languageCode);
                          
                         // print_r($result);
                          
                       if($result->userid>0)
                       {
                           $output['status']                                              =       "1";
$output['message']                                                                   =                      "success";
$output['data']['user_id']                                                        =     $result->userid;
$output['data']['edit_status']                                                 =      $result->user_created_by==0 ?"1":"0";                                   
$output['data']['user_first_name']                                        =      ($result->user_first_name!=""?$result->user_first_name:"");
$output['data']['user_last_name']                                         =       ($result->user_last_name!=""?$result->user_last_name:"");
$output['data']['user_type']                                                    =        (string) ($result->user_type!=""?$result->user_type:"");
$img                                                         =                                                 base_url()."uploads/user/".$result->user_image;
$output['data']['image']                    =                           ($result->user_image!=""?$img:base_url().'images/user_dummy.png');

                                
$output['data']['user_country_id'] = (string)($result->country_id!=""?$result->country_id:"");      

$output['data']['country_name']=$result->country_name!=""?$result->country_name:"";
$output['data']['user_city_id'] =(string)($result->city_id>0?$result->city_id:"");      

$output['data']['city_name']=$result->city_name!=""?$result->city_name:"";

$output['data']['building']=$result->building!=""?$result->building:"";
$output['data']['appartment']=$result->appartment!=""?$result->appartment:"";
$output['data']['area']=$result->area!=""?$result->area:"";
$output['data']['user_zip']=$result->user_zip!=""?$result->user_zip:"";
$output['data']['user_dial_code']=$result->user_dial_code!=""?$result->user_dial_code:"";
$output['data']['user_phone']=$result->user_phone!=""?$result->user_phone:"";
$output['data']['user_email']=$result->user_email!=""?$result->user_email:"";
$output['data']['company_name']=$result->user_company_name!=""?$result->user_company_name:"";
                       }
                       else
                       {
                            $output['status']=   "0";
                            $output['message']=   "failed";
                           $output['data']=array();
                       }
                       echo json_encode($output);exit; 
                }
   }
    function getProviderFullDetails()
    {
        
       
             $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
          
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
    
        $this->form_validation->set_rules('access_token', 'access_token', 'required');
   


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                 $acces_token              =   trim($this->input->post("access_token"));    
              $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                             =   $checkCode ;
                            $_POST['user_id']             =   $user_id;
                        }
                        
                          $result= $this->M_user->getProviderFullDetails($user_id,$languageCode);
                          
                         // print_r($result);
                          
                       if($result->userid>0)
                       {
                           $output['status']                                              =       "1";
$output['message']                                                                   =                      "success";
$output['data']['user_id']                                                        =     $result->userid;
$output['data']['edit_status']                                                 =      $result->user_created_by==0 ?"1":"0";                                   
$output['data']['user_first_name']                                        =      ($result->user_first_name!=""?$result->user_first_name:"");
$output['data']['user_last_name']                                         =       ($result->user_last_name!=""?$result->user_last_name:"");
$output['data']['user_type']                                                    =        (string) ($result->user_type!=""?$result->user_type:"");
$img                                                         =                                                 base_url()."uploads/user/".$result->user_image;
$output['data']['image']                    =                           ($result->user_image!=""?$img:base_url().'images/user_dummy.png');

                                
$output['data']['user_country_id'] = (string)($result->country_id!=""?$result->country_id:"");      

$output['data']['country_name']=$result->country_name!=""?$result->country_name:"";
$output['data']['user_city_id'] =(string)($result->city_id>0?$result->city_id:"");      

$output['data']['city_name']=$result->city_name!=""?$result->city_name:"";

$output['data']['document_type']=$result->document_type!=""?$result->document_type:"";
$output['data']['document_number']=$result->document_number!=""?$result->document_number:"";
$output['data']['document_path']=$result->document_name!=""?base_url()."uploads/user/".$result->document_name:"";
$output['data']['user_zip']=$result->user_zip!=""?$result->user_zip:"";
$output['data']['user_dial_code']=$result->user_dial_code!=""?$result->user_dial_code:"";
$output['data']['user_phone']=$result->user_phone!=""?$result->user_phone:"";
$output['data']['user_email']=$result->user_email!=""?$result->user_email:"";
$output['data']['company_name']=$result->company_name!=""?$result->company_name:"";
$output['data']['company_type_id']=$result->company_type!=""?$result->company_type:"";
$output['data']['profile_document']=$result->profile_document!=""?base_url().'uploads/user/'.$result->profile_document:"";
$output['data']['website_url']=$result->website_url!=""?$result->website_url:"";
                       }
                       else
                       {
                            $output['status']=   "0";
                            $output['message']=   "failed";
                           $output['data']=array();
                       }
                       echo json_encode($output);exit; 
                }
    }
    function addProviderRating()
    {
              $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
          
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
    
        $this->form_validation->set_rules('access_token', 'access_token', 'required');
        $this->form_validation->set_rules('provider_id', 'provider_id', 'required|numeric');
       // $this->form_validation->set_rules('feedback', 'feedback', 'required|max_length[500]|xss_clean');
        $this->form_validation->set_rules('rating', 'rating', 'required|callback_weight_check');
   


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                      $acces_token                     =   trim($this->input->post("access_token"));    
                     $checkCode                         =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                             =    $checkCode ;
                             $input['provider_id']      =     $this->input->post('provider_id');
                             $input['user_id']             =     $user_id;
                             $input['user_rating']     =     $this->input->post('rating');
                             $input['feed_back']       =      $this->input->post('feedback');
                             
                             if($this->input->post('rating_id')>0)
                             {
                                 $input['provider_rating_id']       =      $this->input->post('rating_id');
                             }
                          
                              $result= $this->M_user->addProviderRating($input);
                              
                              if($result > 0)
                              {
                                  $output['status']                =       "1";
                                  $output['message']            =       $this->lang->line("rating_done");
                              }
                              else if($result<0)
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                   =  $this->lang->line("rating_already");
                              }
                              else
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                   =  $this->lang->line("rating_failed");
                                  
                              }
                              echo json_encode($output);exit;
                        }
                }
    }
    function setAddressType()
    {
        
              $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
          
                 if($languageCode==2)
                 {
                      $this->lang->load("message","arabic");
                 }
                 else
                 {
                      $this->lang->load("message","english");
                 }
    
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                 $this->form_validation->set_rules('location', 'location', 'required');
                 $this->form_validation->set_rules('longitude', 'longitude', 'required');
                 $this->form_validation->set_rules('lattitude', 'lattitude', 'required');
                 $this->form_validation->set_rules('address_type_id', 'address_type_id', 'required');


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                 $acces_token                  =   trim($this->input->post("access_token"));    
                 $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                              =   $checkCode ;
                             $_POST['user_id']                     =   $user_id;
                             
                             
                             
                            
                              $result= $this->M_user->setAddressType($_POST);
                              
                              if($result > 0)
                              {
                                  $output['status']                =       "1";
                                  $output['message']            =       $this->lang->line("user_adress_added_success");
                              }
                              else if($result<0)
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                   =  $this->lang->line("user_adress_added_fialed");
                              }
                              
                               echo json_encode($output);exit;
                        }
                }
    }
    function setProviderSettings()
    {
        
                $this->load->library("FCM_Notification");
                
                $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
          
                 if($languageCode==2)
                 {
                      $this->lang->load("message","arabic");
                 }
                 else
                 {
                      $this->lang->load("message","english");
                 }
    
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                 $this->form_validation->set_rules('location', 'location', 'required');
                 $this->form_validation->set_rules('longitude', 'longitude', 'required');
                 $this->form_validation->set_rules('lattitude', 'lattitude', 'required');
                 $this->form_validation->set_rules('service_type_ids', 'service_type_ids', 'required');
                 $this->form_validation->set_rules('fcm_token', 'fcm_token', 'required');
                 
                 $this->form_validation->set_rules('country_id', 'country_id', 'required');
                 $this->form_validation->set_rules('city_id', 'city_id', 'required');

                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                 $acces_token                  =   trim($this->input->post("access_token"));    
                 $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                              =   $checkCode ;
                             $_POST['user_id']                     =   $user_id;
                             
                             
                             
                            
                              $result= $this->M_user->setProviderSettings($_POST);
                              
                              if($result > 0)
                              {
                                 
                                  $output['status']                =       "1";
                                  $output['message']               =       $this->lang->line("settings_success");
                              }
                              else if($result<0)
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                   =  $this->lang->line("settings_fialed");
                              }
                              
                               echo json_encode($output);exit;
                        }
                }
    }
    function getProviderRatings()
    {
                 $acces_token                  =   trim($this->input->post("access_token"));    
                 $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                              =   $checkCode ;
                             $_POST['user_id']                     =   $user_id;
                             
                             
                             
                            
                              $result= $this->M_user->getProviderRatings($_POST);
                              
                              if(count($result) > 0)
                              {
                                  $output['status']                 =       "1";
                                  $output['message']                =       "success";
                                  $i  = 0;
                                  foreach($result as $rows)
                                  {
                                      $output['data'][$i]['user_first_name']   =      ($rows->user_first_name!=""?$rows->user_first_name:"");
                                      $output['data'][$i]['user_last_name']    =      ($rows->user_last_name!=""?$rows->user_last_name:"");
                                      $output['data'][$i]['user_type']         =      (string) ($rows->user_type!=""?$rows->user_type:"");
                                      $img                                     =      base_url()."uploads/user/".$rows->user_image;
                                      $output['data'][$i]['image']             =      ($rows->user_image!=""?$img:base_url().'images/user_dummy.png');
                                      $output['data'][$i]['user_rating']       =      ($rows->user_rating	!=""?$rows->user_rating	:"");
                                      $output['data'][$i]['user_feedback']     =      ($rows->feed_back	!=""?$rows->feed_back	:"");
                                      $newDateTime = date('Y-m-d h:i A', strtotime($rows->added_date));
                                      $output['data'][$i]['added_time']        =      ($newDateTime	!=""?date("d-m-Y h:i A",strtotime($newDateTime)):"");
                                      
                                      $i++;
                                  }
                                  
                              }
                              else
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                       =   "failed";
                                   $output['data']                          =    array();
                              }
                              
                               echo json_encode($output);exit;
                        }
    }
    function getArticles()
    {
               $languageCode   = ($this->input->post('language')==2?$this->input->post('language'):1);
               
               $_POST['language'] = $languageCode;
          
                 if($languageCode==2)
                 {
                      $this->lang->load("message","arabic");
                 }
                 else
                 {
                      $this->lang->load("message","english");
                 }
                 
                  $this->form_validation->set_rules('article_type', 'article_type', 'required');


                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                    $result= $this->M_user->getArticles($_POST);
                              
                              if(count($result) > 0)
                              {
                                   $output['status']                        =    "1";
                                   $output['message']                       =   "success";
                                   $output['data']['article']               =    html_entity_decode($result->articles_desc);
                              }
                              else
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                       =   "failed";
                                   $output['data']                          =    array();
                              }
                }
                
                echo json_encode($output);exit;
    }
    function getUserLocation()
    {
           $languageCode               =   ($this->input->post('language')==2?$this->input->post('language'):1); 
           if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
        
                 $acces_token                  =   trim($this->input->post("access_token"));    
                 $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                              =   $checkCode ;
                             $_POST['user_id']                     =   $user_id;
                             
                             
                              $output['status']                 =       "1";
                              $output['message']                =       "success";
                            
                              $rows                             =       $this->M_user->getHomeLocation($user_id,1);
                             
                              if(count($rows) > 0)
                              {
                                  
                                      $output['data']['home']['type_id']       =      "1";
                                      $output['data']['home']['addrss_id']  =      ($rows->user_adresses_id!=""?$rows->user_adresses_id:"");
                                      $output['data']['home']['location']   =      ($rows->user_adresses_location!=""?$rows->user_adresses_location:"");
                                      $output['data']['home']['longitude']  =      ($rows->user_adresses_longitude!=""?$rows->user_adresses_longitude:"");
                                      $output['data']['home']['lattitude']  =      ($rows->user_adresses_lattitude!=""?$rows->user_adresses_lattitude:"");
                                      $output['data']['home']['city']       =      ($rows->user_adresses_city!=""?$rows->user_adresses_city:"");
                                      $output['data']['home']['date']       =      ($rows->user_adresses_created_time!=""?$rows->user_adresses_created_time:"");
                                      
                                 
                                  
                              }
                              else
                              {
                               
                                   $output['data']['home']                          =   (object) array();
                              }
                              
                              $rows                             =       $this->M_user->getHomeLocation($user_id,2);
                             
                              if(count($rows) > 0)
                              {
                                  
                                      $output['data']['work']['type_id']       =      "2";
                                      $output['data']['work']['addrss_id']  =      ($rows->user_adresses_id!=""?$rows->user_adresses_id:"");
                                      $output['data']['work']['location']   =      ($rows->user_adresses_location!=""?$rows->user_adresses_location:"");
                                      $output['data']['work']['longitude']  =      ($rows->user_adresses_longitude!=""?$rows->user_adresses_longitude:"");
                                      $output['data']['work']['lattitude']  =      ($rows->user_adresses_lattitude!=""?$rows->user_adresses_lattitude:"");
                                      $output['data']['work']['city']       =      ($rows->user_adresses_city!=""?$rows->user_adresses_city:"");
                                      $output['data']['work']['date']       =      ($rows->user_adresses_created_time!=""?$rows->user_adresses_created_time:"");
                                      
                                 
                                  
                              }
                              else
                              {
                               
                                   $output['data']['work']                          =    (object) array();
                              }
                               
                                $rows                             =       $this->M_user->getHomeLocation($user_id,3);
                             
                              if(count($rows) > 0)
                              {
                                  
                                      $output['data']['others']['type_id']       =      "3";
                                      $output['data']['others']['addrss_id']  =      ($rows->user_adresses_id!=""?$rows->user_adresses_id:"");
                                      $output['data']['others']['location']   =      ($rows->user_adresses_location!=""?$rows->user_adresses_location:"");
                                      $output['data']['others']['longitude']  =      ($rows->user_adresses_longitude!=""?$rows->user_adresses_longitude:"");
                                      $output['data']['others']['lattitude']  =      ($rows->user_adresses_lattitude!=""?$rows->user_adresses_lattitude:"");
                                      $output['data']['others']['city']       =      ($rows->user_adresses_city!=""?$rows->user_adresses_city:"");
                                      $output['data']['others']['date']       =      ($rows->user_adresses_created_time!=""?$rows->user_adresses_created_time:"");
                                      
                                 
                                  
                              }
                              else
                              {
                               
                                   $output['data']['others']                          =   (object) array();
                              }
                               echo json_encode($output);exit;
                        }
    }
    function upgradepackage()
    {
                    $languageCode              =   ($this->input->post('language')==2?$this->input->post('language'):1); 
           
                           if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
        
                        $acces_token                  =   trim($this->input->post("access_token"));    
                        $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                                $user_id                              =   $checkCode ;
                                $_POST['user_id']    =  $user_id;
                                
                                $this->form_validation->set_rules('current_package_id', 'current_package_id', 'required');

                                if ($this->form_validation->run() == FALSE)
                                { 
                                    $output['status']   =  "0";
                                    $output['message']  =  strip_tags(validation_errors());                    
                                    echo json_encode($output);exit;
                                }
                                else
                                {
                                   $result  =    $this->M_user->upgradepackage($_POST);
                                }
                            
                              if($result ==1)
                              {
                                   $output['status']                        =    "1";
                                   $output['message']                       =   "Package Upgraded successfully";
                                   
                              }
                              else
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                       =   "Failed to upgrade package";
                                  
                              }
                              echo json_encode($output);exit;
                        }
    }
    function gettransactionSummary()
    {
                     $languageCode              =   ($this->input->post('language')==2?$this->input->post('language'):1); 
           
                           if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
        
                        $acces_token                  =   trim($this->input->post("access_token"));    
                        $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                                $user_id                              =   $checkCode ;
                                $_POST['user_id']    =  $user_id;
                                
                                 $result  =    $this->M_user->gettransactionSummary($_POST);
                                 
                                 if(count($result) > 0)
                                 {
                                     $output['status']                        =    "1";
                                     $output['message']                       =   "success";
                                     $i = 0;
                                      foreach($result as $rows)
                                      {
                                         
                                      $output['data'][$i]['package_name'] =$rows->packages_name_arabic!="" && $languageCode==2?$rows->packages_name_arabic:$rows->packages_name;
                                      $output['data'][$i]['package_id']   =$rows->packages_id>0?(string)$rows->packages_id:"";
                                      $output['data'][$i]['packages_price']   =$rows->packages_price>0?(string)$rows->packages_price:"";
                                      $output['data'][$i]['purchase_date']   =date("d-m-Y",strtotime($rows->package_purchase_date));
                                      $output['data'][$i]['purchase_time']   =date("h i A",strtotime($rows->package_purchase_date));
                                      $output['data'][$i]['purchase_serial']   =$rows->package_purchase_serial!=""?$rows->package_purchase_serial:"";
                                      $output['data'][$i]['vat']   ="";
                                          $i++;
                                      }
                                 }
                                 else
                                 {
                                     $output['status']                        =    "0";
                                     $output['message']                       =   "No results found";
                                     $output['data']                          =   array();
                                 }
                                 
                                 echo json_encode($output);exit;
                        }
    }
    function getPackages()
    {
                        $result  =    $this->M_user->getPackages();
                                 
                                 if(count($result) > 0)
                                 {
                                     $output['status']                        =    "1";
                                     $output['message']                       =   "success";
                                     $i = 0;
                                      foreach($result as $rows)
                                      {
                                         
                                      $output['data'][$i]['package_name'] =$rows->packages_name_arabic!="" && $languageCode==2?$rows->packages_name_arabic:$rows->packages_name;
                                      $output['data'][$i]['package_id']   =$rows->packages_id>0?(string)$rows->packages_id:"";
                                      $output['data'][$i]['packages_price']   =$rows->packages_price>0?(string)$rows->packages_price:"";
                                      $output['data'][$i]['packages_quotaion_limit']   =$rows->packages_quotaion_limit>0?(string)$rows->packages_quotaion_limit:"";
                                   
                                          $i++;
                                      }
                                 }
                                 else
                                 {
                                     $output['status']                        =    "0";
                                     $output['message']                       =   "No results found";
                                     $output['data']                          =   array();
                                 }
                                 
                                  echo json_encode($output);exit;
    }
    function getProviderSettings()
    {
        
         $languageCode              =   ($this->input->post('language')==2?$this->input->post('language'):1); 
           
                           if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
                 $acces_token                  =   trim($this->input->post("access_token"));    
                 $checkCode                    =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId      =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                              =   $checkCode ;
                             $_POST['user_id']                     =   $user_id;
                             
                             $_POST['language_code']                     =   $languageCode;
                             
                            
                              $result= $this->M_user->getProviderSettings($_POST);
                              
                              $basic = $result;
                              
                             // print_r($result);
                              
                              if(count($result) > 0)
                              {
                                  $output['status']                 =       "1";
                                  $output['message']                =       "success";
                                  $i  = 0;
                                  foreach($result as $row)
                                  {
                                     
                                     $output['data']['service_type'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                                     $output['data']['service_type'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:""; 
                                     if($row->provider_id>0)
                                     {
                                          $already =  "1";
                                     }
                                     else
                                     {
                                          $already =  "0";
                                     }
                                     $output['data']['service_type'][$i]['already_selected']             = $already;
                                      $i++;
                                  }
                                  
                              }
                              else
                              {
                                   $output['status']                        =    "0";
                                   $output['message']                       =   "failed";
                                   $output['data']['service_type']                          =   (object) array();
                              }
                              $condition=array('country_language_code' => $languageCode,'country_status'=>1);
                             $country=$this->M_admin->getCountriesCondition($condition);


	          
	        if (count($country)>0) 
	        {
	            $output['status']       =  "1";
	            $output['message']      =  "success";
	            $i = 0;
                foreach ($country as $row)
                {

                    $output['data']['country'][$i]['name'] = ($row->country_name!="")?$row->country_name:"";
                    $output['data']['country'][$i]['id']   =($row->country_id!="")?$row->country_id:"";
                    $output['data']['country'][$i]['dial_code']=$row->country_dial_code;
                    if($row->country_id==$basic[0]->country_id)
                    {
                        $output['data']['country'][$i]['isSelected']="1";
                    }
                    else
                    {
                        $output['data']['country'][$i]['isSelected']="0";
                    }
                        
                        $i++;
                }
	        }
	        else
	        {  
	            $output['status']                  =     "0";
	            $output['message']                 =  "failed";
	            $output['data']['country']         =  (object)array();
	        }
	        
	        if($basic[0]->country_id>0)
	        {
	            
	            //$condition = array();
	            $condition=array('city_language_code' => $languageCode,'city_status'=>1,'city_country_id'=>$basic[0]->country_id);
	            $city=$this->M_admin->getCitiesCondition($condition);


	          
	        if (count($city)>0) 
	        {
	            $output['status']       =  "1";
	            $output['message']      =  "success";
	            $i = 0;
                foreach ($city as $row)
                {

                    $output['data']['city'][$i]['name'] = ($row->city_name!="")?$row->city_name:"";
                    $output['data']['city'][$i]['id']   =($row->city_id!="")?$row->city_id:"";
                   
                    if($row->city_id==$basic[0]->city_id)
                    {
                        $output['data']['city'][$i]['isSelected']="1";
                    }
                    else
                    {
                        $output['data']['city'][$i]['isSelected']="0";
                    }
                        
                        $i++;
                }
	        }
    	        else
    	        {  
    	            $output['status']                  =     "0";
    	            $output['message']                 =  "failed";
    	            $output['data']['city']         =  (object)array();
    	        }
	        }
	        else
	        {
	                $output['status']                =     "0";
    	            $output['message']              =  "failed";
    	            $output['data']['city']         =  (object)array();
	        }
	        
	                           $locations  = $this->M_user->getProviderLocationDetails($user_id);
	                           
	                           $output['data']['location']          =  $locations->location!=""?$locations->location:"";
	                           $output['data']['lattitude']         =  $locations->lattitude!=""?$locations->lattitude:"";
	                           $output['data']['longitude']         =  $locations->longitude!=""?$locations->longitude:"";
                     
                     
                               echo json_encode($output);exit;
                        }
    }
    
function check_default($array)
{
  foreach($array as $element)
  {
    if($element == '0' || $element == "")
    { 
      return FALSE;
    }
  }
 return TRUE;
}
    public function valid_password($password = '')
	{
		$password = trim($password);
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
		if (empty($password))
		{
			$this->form_validation->set_message('valid_password', 'The {field} field is required.');
			return FALSE;
		}
//		if (preg_match_all($regex_lowercase, $password) < 1)
//		{
//			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
//			return FALSE;
//		}
		if (preg_match_all($regex_uppercase, $password) < 1 && preg_match_all($regex_lowercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one  letter.');
			return FALSE;
		}
		if (preg_match_all($regex_number, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
			return FALSE;
		}
		if (preg_match_all($regex_special, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.');
			return FALSE;
		}
		if (strlen($password) < 8)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
			return FALSE;
		}
		if (strlen($password) >20)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 20 characters in length.');
			return FALSE;
		}
		return TRUE;
	}
      public  function check_inavlid_char($string="")
        {
                 $regex_special = '/[!@#$%^&*()\=+{};:<.>§~]/';
                
            
                 if (preg_match_all($regex_special, $string) >0)
		{
			$this->form_validation->set_message('check_inavlid_char', 'The {field} field contains invalid characters.');
			return FALSE;
		}
                                    return TRUE;
            }
         public function weight_check($val)
    { 
     if ( !is_numeric($val) ) {
            $this->form_validation->set_message('weight_check', 'The {field} field must be number or decimal.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
        public function percent_check($val)
    { 
     if ( $val>100 ) {
            $this->form_validation->set_message('percent_check', 'The {field} field must be less than or equals 100.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function valid_url($url)
{
    $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
    if (!preg_match($pattern, $url))
    {
        return FALSE;
    }

    return TRUE;
}
  function alpha_space($fullname){
    if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
        $this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & White spaces');
        return FALSE;
    } else {
        return TRUE;
    }
}
public function custom_minlength_check($field_value="") 
    {
        $field_value = strip_tags($field_value);
        if (strlen($field_value) < 10 )
        {
            $this->form_validation->set_message('custom_minlength_check', "Please enter atleast 10 characters");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct()
     {
         parent::__construct();
         $this->load->model('website/M_user');    
         
          error_reporting(E_ERROR | E_PARSE);
          load_user_language();
          $this->load->helper('eq_helper');  
          $this->load->library("FCM_Notification");
           $this->wstatus = ['1'=>'Applied','2'=>'Pending'];
     }
     function loadProviderRegistrationForm()
     {      
            $userType = $this->session->userdata('eq_user_type');
            if($userType == 2)
                redirect(base_url('myaccount'));
         
             $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
             $data['country_list']           = $this->M_common->getCountries($language,0,1);  
             
             $con['service_type_language_code']   =  $language;
             $con['service_type_status']          =  1; 
             $data['service_type']                =  $this->M_common->getServiceTypes($con);
             
             $service_list = $this->M_user->get_service_list();
             $service_data = [];

             foreach($service_list as $key=>$value){
                $temp_data['id']     = $value->service_type_id;
                $temp_data['title']  = $value->service_type_name;
                // $temp_data['isSelectable'] = 'false';

                $sub_list = $this->M_user->get_service_list($value->service_type_id);
                $sub_data = [];
                // echo "<pre>";print_r($sub_list);
                if($sub_list){
                    foreach ($sub_list as $key1 => $value1) {
                        $temp_sub['id'] = $value1->service_type_id;
                        $temp_sub['title'] = $value1->service_type_name;
                        // $temp_sub['isSelectable'] = 'false';
                        $sub_data[]       = $temp_sub;
                    }
                    // print_r($sub_data);
                    // echo json_encode($sub_data);exit;
                }
                if($sub_data)
                    $temp_data['subs'] = $sub_data;
                $service_data[] =$temp_data;
             }

             $data['service_list'] =json_encode($service_data);
             
            // echo "<pre>"; print_r($service_data);exit;
             
             
             $this->load->view("header");
             $this->load->view("registration_provider",$data);
             $this->load->view("footer");
     }

    function saveUser()
     {
         
         
         $data = array();
   
       $this->form_validation->set_rules('txt_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
       $this->form_validation->set_rules('txt_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
       $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]');
       $this->form_validation->set_rules('txt_phone', 'Mobile Number', 'required|max_length[100]|callback_validate_phone_number');
       $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
       
       if ($this->form_validation->run() == FALSE) 
           {
                            $data['status'] = 0;
                            $data['errors'] = array(
                                              'txt_first_name' => form_error('txt_first_name'),
                                              'txt_last_name' => form_error('txt_last_name'),
                                              'txt_email' => form_error('txt_email'),                                             
                                              'txt_password' => form_error('txt_password'),
                                              'txt_phone'  => form_error('txt_phone'),                                             
                                              );
                                       echo json_encode($data);
                                     exit();
        } 
        else
        {
            
            
            
           
            
            
		
                                            $_POST = $this->security->xss_clean($_POST);  
                                            
                                             $input['user_first_name']                    =                 trim($this->input->post("txt_first_name"));
                                             $input['user_last_name']                     =                 trim($this->input->post("txt_last_name"));
                                             $input['user_email']                         =                 trim($this->input->post("txt_email"));
                                             $input['user_password']                      =                 MD5($this->input->post("txt_password"));                                             
                                             $input['user_created_methode']               =                 "web";   
                                             $input['country_id']                         =                 trim($this->input->post('country_id')); 
                                             $input['user_type']                          =                 1;      
                                             //$input['user_dial_code']                     =                 trim($this->input->post("txt_dial"));
                                             $input['user_dial_code']                     =                 $this->input->post("txt_dial");
                                             $input['user_phone']                         =                 trim($this->input->post("txt_phone")); 
                                             $input['user_status']                        =                 1; 
                                             $input['user_company_name']                  =                 trim($this->input->post("txt_company_name"));
                                             
                                             if($this->input->post("txt_user_id")>0)
                                             {
                                                 unset($input['user_email']);
                                                 unset($input['user_password']);
                                                 $input['user_id']                        =                 trim($this->input->post("txt_user_id"));
                                                 $input['user_updated_by']                =                 $input['user_id'] ;
                                                 $input['user_updated_time']              =                 gmdate("Y-m-d H:i:s");
                                             }
                                             else
                                             {
                                                 $input['user_created_by']                =                 0;
                                                 $input['user_created_time']              =                 gmdate("Y-m-d H:i:s");
                                             }
                                             $digits                                      =                 4;
                                             $generatedOtp                                =                 "1111";//rand(pow(10, $digits-1), pow(10, $digits)-1);
                                             
                                             $otp['otp']                                  =                 $generatedOtp;
                                             $otp['otp_send_time']                        =                 gmdate("Y-m-d H:i:s");
                                             $otp['otp_validity_end_time']                =                 date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
                                                                    
                                             
                                                    
                                            
		  if(count($_POST)>0)
		  {
			    
			 $result         =   $this->M_user->saveUser($input,$otp);	
			  
		  }else
		  {
			  
			  $result= 0 ;	
			  
		  }
		                                   $data['status'] = $result;
		                                   if($result>0)
		                                   {
		                                       $data['status'] = 1;
		                                       $data['ver']    = $this->common_functions->encryptId($result);
		                                   }
		                                   else
		                                   {
		                                      $data['status'] = $result; 
		                                   }
		                                   if($result>0)
		                                   {
		                                          $this->load->library("SMS");
                                                  $this->load->library("parser");
                                                  $customer_mobile_no =   trim($this->input->post("txt_dial")).trim($this->input->post("txt_phone"));
                                                  $customer_name      =   $this->input->post("txt_first_name").' '.$this->input->post("txt_last_name");
                                                    
                                                  $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                                            array("customer_name"=>$customer_name,
                                                                  "otp"=> $generatedOtp,
                                                                 ),TRUE),$customer_mobile_no); 
                                                  
                                                    
                                                    
                                                       $subject                 =  "Welcome to Vhelp";
                                                       $userMaiArray['message'] =  "Your one time password OTP is ".$generatedOtp.". This is valid for the next 10 minutes"; 
                                                       $userMaiArray['user_name']    =   $customer_name;
                                                       $to                      =   trim($this->input->post("txt_email"));
                                                       $userMaiArray['subject'] =  $subject;
                                                       $this->load->library('parser');
                                                       $email_message  = $this->parser->parse('email/otp', $userMaiArray, true);
                                                       $this->load->library("Mail_function");
                                                       $this->mail_function->SendEmail($email_message,$subject,$to);
		                                   }
                                           echo json_encode($data);
       
        }
     }
     function verifyOtp()
     {
               $this->form_validation->set_rules('txt_otp', 'OTP', 'trim|required|max_length[4]|xss_clean|numeric');
               if ($this->form_validation->run() == FALSE) 
                {
                                    $data['status'] = 0;
                                    $data['errors'] = array(
                                                      'txt_otp' => form_error('txt_otp')                                           
                                                      );
                                               echo json_encode($data);
                                             exit();
                } 
                else
                {
                    
                    $result         =   $this->M_user->verifyOtp($this->input->post());
                    $data['status'] = $result;
                    echo json_encode($data);
                    if($result>0)
                    {
                      $userDetails              = $this->M_user->getRequiredFieldsforNotification($result); 
                        
                      $subject                  = "Welcome to vhelp ";
                      $userMaiArray['message']  = "Thankyou for registering with vhelp. Please proceed to log in to your account and request services."; 
                      $userMaiArray['user_name']     = $userDetails->user_first_name;
                      $to                       = $userDetails->user_email;
                      $userMaiArray['subject']  = $subject;
                      $this->load->library('parser');
                      $email_message            = $this->parser->parse('email/welcome', $userMaiArray, true);
                      $this->load->library("Mail_function");
                      $this->mail_function->SendEmail($email_message,$subject,$to);
              
                    }
                     
                }
     }
     function resendOtp()
     {
                   $digits                                      =                 4;
                   $generatedOtp                                =                 rand(pow(10, $digits-1), pow(10, $digits)-1);
                   $otp['otp']                                  =                 $generatedOtp;
                   $otp['otp_send_time']                        =                 gmdate("Y-m-d H:i:s");
                   $otp['otp_validity_end_time']                =                 date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
                   $result         =   $this->M_user->resendOtp($this->input->post(),$otp);
                   
                //   print_r($otp);
                    if($result>0)
                    {
                        $data['status'] =   '1';
                          $userDetails              = $this->M_user->getRequiredFieldsforNotificationFromTemp($result); 
                          $this->load->library("SMS");
                          $this->load->library("parser");
                          $customer_mobile_no =   trim($userDetails->user_dial_code).trim($userDetails->user_phone);
                          $customer_name      =   $userDetails->user_first_name;
                          $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                    array("customer_name"=>$customer_name,
                                          "otp"=> $generatedOtp,
                                         ),TRUE),$customer_mobile_no); 
                            
                        $subject                 =  "Welcome to Vhelp";
                        $userMaiArray['message'] =  "Your one time password OTP is ".$generatedOtp.". This is valid for the next 10 minutes"; 
                        $userMaiArray['user_name']    =   $customer_name;
                        $to                      = $userDetails->user_email;  //trim($this->input->post("txt_email"));
                        $userMaiArray['subject'] =  $subject;
                        // print_r($userMaiArray);
                        $this->load->library('parser');
                        $email_message  = $this->parser->parse('email/otp', $userMaiArray, true);
                        $this->load->library("Mail_function");
                        $this->mail_function->SendEmail($email_message,$subject,$to);
              
                    }else{
                        $data['status'] =   '0';
                    }
            echo json_encode($data);
     }
     function  userLogin()
     {
         
     
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_user_email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('txt_user_pwd', 'Password', 'required');
    if ($this->form_validation->run() == FALSE)
                {
                       echo validation_errors();
                }
                else
                {
        
         $data['user_email']                    =         $_POST['txt_user_email'];
         $data['user_password']                 =        Md5($_POST['txt_user_pwd']);
        // $data['user_status']                 =        1;
	    $user_type                              =  $_POST['user_type'];   
        $result                                           =   $this->M_user->userLogin($data);
          
        if(isset($result) && count($result)>0 && $result->user_type < 3) {            
            if($result->user_status==1 && $result->user_type == $user_type ){ 
                $this->load->library('session');
                $res    =    $result->user_id ;
                $type = $result->user_type;
                //$this->session->unset_userdata("social_media");
                $this->session->unset_userdata("eq_user_email");
                $this->session->unset_userdata("eq_user_id");
                
                            $this->session->unset_userdata("eq_user_type");
                            $this->session->unset_userdata("eq_user_name");
                            
                            $this->session->set_userdata("eq_user_email",$result->user_email);
                            $this->session->set_userdata("eq_user_id",$result->user_id);
                            $this->session->set_userdata("eq_user_name",$result->user_first_name);
                            $this->session->set_userdata("eq_user_type",$result->user_type);
                            $user                        =     $this->M_user->getRequiredFieldsforNotification($result->user_id);
                            $userFullname                =     $user->user_first_name." ".$user->user_last_name;  
                            // $database                    =     get_firebase_refrence();
                            // $database->getReference("user_details/" .$result->user_id."/")->update(["fcm_token"=>trim($user->fcm_token),"user_first_name"=>$user->user_first_name,"user_last_name"=>$user->user_last_name,"user_type"=>$user->user_type,"image"=>$user->user_image,"user_name"=>$userFullname]);
        
            // print_r($result);exit;            
        }else{
                                  $res = -1 ;
                                  $type =0;
                       }
        }else{
            $res =  0;
            $type =0;
        }
          
            $data['status'] = $res;
            $data['type']   = $type;
            echo json_encode($data);
        }
               
         // print_r($result);
     }
      function saveProvider()
    {
        
         
         $data = array();
        // print_r($_POST);
      
       $this->form_validation->set_rules('txt_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
       $this->form_validation->set_rules('txt_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
       $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]');           
       $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
       $this->form_validation->set_rules('select_country', 'Country', 'trim|required');
      // $this->form_validation->set_rules('select_city', 'City', 'trim|required');
       $this->form_validation->set_rules('txt_phone', 'Phone', 'trim|required|numeric|min_length[5]|max_length[15]|xss_clean');       
      // $this->form_validation->set_rules('txt_doc_no', 'Document no', 'trim|required|max_length[100]|callback_check_inavlid_char');
       $this->form_validation->set_rules('txt_company_name', 'Company name', 'trim|required|max_length[200]|callback_check_inavlid_char');
       
   
     
        if(empty($_FILES['txt_doc']['name']) && trim($this->input->post("company_type"))==1){
        $this->form_validation->set_rules('txt_doc','Upload Document','trim|required');
       }
       if ($this->form_validation->run() == FALSE) 
           {
                            $data['status'] = 0;
                            $data['errors'] = array(
                                              'txt_first_name' => form_error('txt_first_name'),
                                              'txt_last_name' => form_error('txt_last_name'),
                                              'txt_email' => form_error('txt_email'),
                                              'select_city' => form_error('select_city'),
                                              'select_country' => form_error('select_country'),
                                              'txt_password' => form_error('txt_password'),
                                              'txt_phone' => form_error('txt_phone'),
                                              'select_city' => form_error('select_city'),
                                              'select_document_type' => form_error('select_document_type'),
                                              'txt_doc_no' => form_error('txt_doc_no'),
                                              'txt_doc' => form_error('txt_doc'),
                                              'txt_company_name' => form_error('txt_company_name'),
                                            
                                              );
                                       echo json_encode($data);  
                                     exit();
        } 
        else
        {
            
            $input2 = array();
            
          
             if($_FILES["txt_doc"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                   
                                    $filename2 = $_FILES["txt_doc"]["name"];
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
                  
                                  if ( ! $this->upload->do_upload('txt_doc'))
                                   {
                                       //die("file upload failed");
                                        $data['status'] = 0;
                                        $data['errors'] = array(
                                         'txt_doc' =>  $this->upload->display_errors(),
                                        );
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $input2['document_name']                 =   $config2['file_name'];
                                      
                                  }
				 
			 }
            
		
                                            $_POST = $this->security->xss_clean($_POST);  
                                            
                                             $input['user_first_name']                    =                 trim($this->input->post("txt_first_name"));
                                             $input['user_last_name']                     =                 trim($this->input->post("txt_last_name"));
                                             $input['user_email']                              =                 trim($this->input->post("txt_email"));
                                             $input['user_password']                      =                 MD5($this->input->post("txt_password"));
                                             $input['country_id']                              =                 trim($this->input->post("select_country"));
                                             $input['city_id']                                      =                 trim($this->input->post("select_city"));
                                             $input['user_phone']                            =                 trim($this->input->post("txt_phone"));
                                             $input['user_dial_code']                      =              $this->input->post("txt_dial"); 
                                             $input['user_type']                                =                2;
                                            
                                             $input['user_status']                             =                 0;
                                             $input['user_created_methode']       =                 "web";                                             
                                         
                                             $input['user_created_by']                     =                 0;
                                             $input['user_created_time']                =                 gmdate("Y-m-d H:i:s");
                                             
                                             $input2['document_number']                 =    trim($this->input->post("txt_doc_no"));
                                             $input2['document_type']                       =    trim($this->input->post("select_document_type")); 
                                             $input2['company_name']                       =    trim($this->input->post("txt_company_name")); 
                                             $input2['company_type']                         =    trim($this->input->post("company_type")); 
                                             
                                            $input3['service_type_ids']  =  trim($this->input->post("txt_service"));
                                            $input4['area_list_ids']     =  trim($this->input->post('mappedAreaItems'));
                                        
		  if(count($_POST)>0)
		  {
			    
			 $result         =   $this->M_user->saveProvider($input,$input2,$input3,$input4);	
			 if($result > 0){
			     
			 }	
			  
		  }else
		  {
			  
			  $result= 0 ;	
			  
		  }
		                                  $data['status'] = $result;
                                           echo json_encode($data);
       
        }
    }
    function logout()
    {
        session_destroy();
        redirect(base_url());
    }
      function myaccount()
     {
          $data      = array();  
          $this->load->model('website/M_request'); 
        //   echo "<pre>";print_r( $this->M_user->getPendingJobRequest() );
        //   echo $this->db->last_query();
        //   exit;

         if($this->session->userdata("eq_user_id")<=0)
         {
             redirect(base_url());
         }
             $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
             
             
             $con2['user_id']                      =  $this->session->userdata('eq_user_id');
             
             $limit_per_page                      =  5;
             
             $start_index                         =   0;
             
            
            
         if($this->session->userdata('eq_user_type')==2){
            
            $data['job_list']                    =  $this->M_request->getJobRequestsListByVendor($con2,$limit_per_page,$start_index);
            $data['request_list']                =  $this->M_request->getJobRequestsListByVendor($con2,$limit_per_page,$start_index);
             
            $data['user_details']                =  $this->M_user->getProviderFullDetails($this->session->userdata('eq_user_id'),$language);
             
            $data['trans_details']               =  $this->M_user->getTransactionFullDetails($this->session->userdata('eq_user_id'),$language);
             
            $data['packages']                    =  $this->M_user->getPackages();
            $data['provider_area']               =  $this->M_user->getProviderAreaList();
            //  print_r($data['provider_area']);exit;
            $this->load->model('M_admin');
            $con['service_type_language_code'] =  1;
            $con['service_type_status']           =  1;
            $data['service_type']         =  $this->M_admin->getServiceTypes($con);
            
             $data['provider_service_type']       =  $this->M_user->getProviderServiceType($this->session->userdata('eq_user_id'));
             //$language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
             $data['country_list']                = $this->M_common->getCountries($language,0,1);
             
             
             
             $this->load->view("header");
             $this->load->view("my_account",$data);
             $this->load->view("footer");
         }else{ 
              $data['job_list']                    =  $this->M_request->getJobRequestsList($con2,$limit_per_page,$start_index);
             $data['request_list']                =  $this->M_request->getJobRequestsList($con2,$limit_per_page,$start_index);
            //   echo "<pre>".$this->db->last_query() ;print_r($data['request_list'] );exit;
             $con3['user_id']                     =  $this->session->userdata('eq_user_id');
             
             $data['user_details']                =  $this->M_user->userLogin($con3);
             $data['user_address']                =  $this->M_user->getUserLocations($this->session->userdata('eq_user_id'));
             
             $data['country_list']                = $this->M_user->getCountryList();
             
            $data['wallet_log']                 =      $this->M_request->getWalletLog($con2['user_id']);
            $data['trasnStatus']                =      $this->wstatus;     
            
             $this->load->view("header");

             $this->load->view("my_account_user",$data);
             $this->load->view("footer");
         }
     }
     function updateProviderProfile()
     {
         
        // print_r($_POST);
        // print_r($_FILES);
         //exit;
         $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
         $this->form_validation->set_rules('user_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
         $this->form_validation->set_rules('user_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
         $this->form_validation->set_rules('txt_company_name', 'Comapny name', 'trim|required|max_length[100]|xss_clean');
         $this->form_validation->set_rules('txt_phone', 'Phone number', 'trim|required|max_length[12]|xss_clean|numeric|callback_validate_phone_number');
         $this->form_validation->set_rules('pickup-input2', 'Location', 'trim|required|max_length[300]|xss_clean');
         
         $error =0;
         
          if ($this->form_validation->run() == FALSE) 
           {
                          //  $data['status'] = 0;
                            $data['errors'] = array(
                                              'user_first_name' => form_error('user_first_name'),
                                              'user_last_name' => form_error('user_last_name'),
                                              'txt_company_name' => form_error('txt_company_name'),
                                              'txt_phone' => form_error('txt_phone'),
                                              'pickup-input2' => form_error('pickup-input2')
                                            
                                              );
                                     //  echo json_encode($data);  
                                     //exit();
                                     
                                     $error =1;
          } 
          $serviceTypes =   explode(",",$this->input->post("mappedItems"));
          $serviceTypes =   array_filter($serviceTypes);
          
          //print_r($serviceTypes);
          // exit;
          
          if($this->input->post("mappedItems")=="" || count($serviceTypes)<=0)
          {
               
               $data['errors']['txt_service_type'] = "Select atleast one service type";
               $error =1;
          }
          
          if($this->input->post("txt_current_pwd")!="" &&  $this->input->post("txt_new_pwd")=="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter new password field";
               $error =1;
          }
         if($this->input->post("txt_current_pwd")!="" &&   $this->input->post("txt_confirm_pwd")=="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter confirm password field";
               $error =1;
          }
           if($this->input->post("txt_current_pwd")=="" &&   $this->input->post("txt_confirm_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter current password field";
               $error =1;
          }
          if($this->input->post("txt_current_pwd")=="" &&   $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter current password field";
               $error =1;
          }
          if($this->input->post("txt_confirm_pwd")=="" &&   $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter confirm password field";
               $error =1;
          }
        if($this->input->post("txt_new_pwd")=="" &&   $this->input->post("txt_confirm_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter new password field";
               $error =1;
          }
          if( $this->input->post("txt_new_pwd")!=""  && trim($this->input->post("txt_new_pwd"))!=trim($this->input->post("txt_confirm_pwd")) )
          {
               $data['errors']['txt_confirm_pwd'] = "New and confirm password shoud match";
               $error =1;
          }
          if(strlen($this->input->post("txt_new_pwd"))<8 && $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Password should be minimum 8 characters";
               $error =1;
          }
           if(strlen($this->input->post("txt_new_pwd"))>21 && $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Password should be maximum 20 characters";
               $error =1;
          }
          
          $userDetails              =  $this->M_user->getProviderFullDetails($this->session->userdata('eq_user_id'),$language);
          
          $profileImage            =   $userDetails->user_image;
          $document                =   $userDetails->document_name;
          /* if($profileImage=="" && count($_FILES['profile_image'])<=0)
          {
               $data['errors']['profile_error'] = "Please upload profile image";
               $error =1;
          }*/
            if($document=="" && $this->input->post("customRadioInline1")==1 && count($_FILES['trade_license'])<=0)
          {
               $data['errors']['doc_error'] = "Please upload trade license";
               $error =1;
          }
          
          if($error == 1)
          {
               $data['status'] = 0;
               echo json_encode($data);  
               exit();
          }
          else
          {
                    $input['user_first_name']                       =                 trim($this->input->post("user_first_name"));
                    $input['user_last_name']                        =                 trim($this->input->post("user_last_name"));
                    $input['user_dial_code']                            =                 trim($this->input->post("txt_dial_code"));
                    $input['user_phone']                            =                 trim($this->input->post("txt_phone"));
                    $input['user_updated_by']                       =                 $this->session->userdata('eq_user_id');
                    $input['user_updated_time']                     =                 gmdate("Y-m-d H:i:s");
                    
                    $input['country_id']                            =                 trim($this->input->post("select_country"));
                    $input['city_id']                               =                 trim($this->input->post("select_city"));
                    
                    if(trim($this->input->post("txt_new_pwd"))!="" && trim($this->input->post("txt_confirm_pwd"))!="" && trim($this->input->post("txt_current_pwd"))!="")
                    {
                    
                        
                       $res =   $this->M_user->checkOldPassword($this->input->post("txt_current_pwd"));
                       
                       if($res<=0)
                       {
                           $data['status']             = 0;
                           $data['errors']['txt_confirm_pwd'] = "Old password not matching";
                           echo json_encode($data);  
                           exit();
                       }
                       else
                       {
                           $newPassword                                =               trim($this->input->post("txt_new_pwd"));
                           $input['user_password']                     =                mD5($newPassword);
                       }
                        
                    }
                    
                   //provider details //provider details//provider details//provider details
                    
                    $input2['company_name']                         =                  trim($this->input->post("txt_company_name"));
                    $input2['lattitude']                            =                  trim($this->input->post("pickup-lattitude2"));
                    $input2['longitude']                            =                  trim($this->input->post("pickup-longittude2"));
                    $input2['location']                             =                  trim($this->input->post("pickup-input2"));
                    $input2['company_type']                             =                  trim($this->input->post("customRadioInline1"));
                    $input2['website_url']                             =                  trim($this->input->post("txt_web_url"));
                    
                  //provider service details//service details//service details//service details
                    
                    if(count($serviceTypes)>0)
                    {
                         $i=0;
                         foreach($serviceTypes as $rows)
                         {
                                 $input3[$i]['provider_id']          =  $this->session->userdata('eq_user_id');
                                 $input3[$i]['service_type_id']      =  $rows;
                                 $i++;
                         }
             
             
                    }
                 //provider service details//service details//service details//service details
                                        
                if($_FILES["profile_image"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."PF".date("Ymdhis");
                                   
                                    $filename2 = $_FILES["profile_image"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|jpeg';
                                    $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    
									 $this->load->library('upload', $config2);
                                     $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('profile_image'))
                                   {
                                     
                                    $output['status']                =  "0";
                                    $output['message']               =  "profile upload failed"; 
                                    $output['errors']['file']                =  $this->upload->display_errors();
                                    echo json_encode($output);
                                    exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input['user_image']  =   $config2['file_name']  ;
                                   }
                                   
                                
				 
			 }
			 if($_FILES["trade_license"]["name"]!="" && $this->input->post("customRadioInline1")==1)
			 {
			     $config2 = array();
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."TRD".date("Ymdhis");
                                   
                                    $filename2 = $_FILES["trade_license"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                    $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    
								$this->load->library('upload', $config2);
                                   $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('trade_license'))
                                   {
                                     
                                    $output['status']                =  "0";
                                    $output['message']               =  "profile upload failed"; 
                                    echo json_encode($output);
                                    exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input2['document_name']  =   $config2['file_name']  ;
                                   }
                                   
                                
				 
			 } 
			 if($this->input->post("customRadioInline1")==2)
			 {
			     $input2['document_name']  =   ""  ;
			 }
			 // print_r($_FILES);
			// print_r($input2);
			 //exit;
			  if($_FILES["company_profile"]["name"]!="")
			 {
			                        $config2 = array();
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."TRD".date("Ymdhis");
                                   
                                    $filename2 = $_FILES["company_profile"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                    $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    
								   $this->load->library('upload', $config2);
                                   $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('company_profile'))
                                   {
                                     
                                        $output['status']                =  "0";
                                        $output['message']               =  "profile upload failed"; 
                                        echo json_encode($output);
                                        exit;
                                       
                                     
                                    }
                                   else
                                   {                                      
                                     
									  $input2['profile_document']  =   $config2['file_name']  ;
									  
                                   }
                                   
                                
				 
			 } 
			 //print_r($input3);exit;
			          $result         =   $this->M_user->updateProviderProfile($input,$input2,$input3);
			          
			          if($result==1)
			          {
			               $data['status'] = 1;
			               $data['errors'] = "";
                           
			          }
			          else
			          {
			              $data['status']  = 0;
			               $data['errors'] = "";
			          }
			          
			          echo json_encode($data);  
                      exit();
          }
     }
     function forgotPassword()
     {
             $this->load->view("header");
             $this->load->view("forgot_password");
             $this->load->view("footer");
     }
     function processPassword()
    {
        $_POST                          = $this->security->xss_clean($_POST);
        $data['user_email']          =        $_POST['txt_email'];
        // $data['user_status']         = 1;
                 
          $this->load->library('form_validation');     
         
          $this->form_validation->set_rules('txt_email', 'Email', 'required|valid_email');
       
          
      if ($this->form_validation->run() == FALSE)
                {
                       echo validation_errors();
                }
                else
                {
                 
                        echo   $this->M_user->forgotPassword($data);
                }
               //  print_r($_POST);
    }
    function resetPassword()
    {
            $data    =   array();
            
            $userId  =   $this->common_functions->decryptId( $this->uri->segment(2));
            
            $data['user_id']        =  $userId;
            
            if($userId<=0)
            {
               $data['error']        =  1; 
            }
            else 
            {
                $session  =   $this->M_user->checkLinkExpired($userId);
                
               if(count($session)>0)
               {
                $data['error']                =  0; 
                   $data['session']           =  $session; 
               }
               else
               {
                   $data['error']        =  2; 
               }
                
            }
        
        
             $this->load->view("header");
             $this->load->view("reset_password",$data);
             $this->load->view("footer");
    }
    function saveNewPassword()
        {
                   $this->form_validation->set_rules('new_password', 'New password', 'required|min_length[8]|max_length[20]|callback_valid_password');
                   $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[new_password]');
                     if ($this->form_validation->run() == FALSE)
                         {
                        $data['status'] = 0;
                        $data['errors'] = array(
                                          
                                          'new_password' => form_error('new_password'),
                                          'confirm_password' => form_error('confirm_password')
                                          );
                        echo json_encode($data);
                        exit();
                      } 
             else   {
                             $result                =   $this->M_user->resetPassword($_POST);
                             $data['status']  =  $result;
                             echo json_encode($data);
                             exit();
                    }
       }
       function updateUserProfile()
     {
       
         $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
         $this->form_validation->set_rules('user_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
         $this->form_validation->set_rules('user_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
         
         $this->form_validation->set_rules('txt_phone', 'Phone number', 'trim|required|max_length[12]|xss_clean|numeric');
        //  $this->form_validation->set_rules('pickup-input2', 'Home location', 'trim|required|max_length[300]|xss_clean');
       //  $this->form_validation->set_rules('pickup-input4', 'Office location', 'trim|required|max_length[300]|xss_clean');
        // $this->form_validation->set_rules('pickup-input5', 'Other location', 'trim|required|max_length[300]|xss_clean');
         
         $error =0;
         
          if ($this->form_validation->run() == FALSE) 
           {
                           //  $data['status'] = 0;
                            $data['errors'] = array(
                                              'user_first_name' => form_error('user_first_name'),
                                              'user_last_name' => form_error('user_last_name'),
                                             // 'txt_company_name' => form_error('txt_company_name'),
                                              'txt_phone' => form_error('txt_phone'),
                                            //   'pickup-input2' => form_error('pickup-input2'),
                                            //   'pickup-input4' => form_error('pickup-input4'),
                                            //   'pickup-input5' => form_error('pickup-input5')
                                            
                                              );
                                     //  echo json_encode($data);  
                                     //exit();
                                     
                                     $error =1;
          } 
        
          
          if($this->input->post("txt_current_pwd")!="" &&  $this->input->post("txt_new_pwd")=="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter new password field";
               $error =1;
          }
         if($this->input->post("txt_current_pwd")!="" &&   $this->input->post("txt_confirm_pwd")=="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter confirm password field";
               $error =1;
          }
           if($this->input->post("txt_current_pwd")=="" &&   $this->input->post("txt_confirm_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter current password field";
               $error =1;
          }
          if($this->input->post("txt_current_pwd")=="" &&   $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter current password field";
               $error =1;
          }
          if($this->input->post("txt_confirm_pwd")=="" &&   $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter confirm password field";
               $error =1;
          }
        if($this->input->post("txt_new_pwd")=="" &&   $this->input->post("txt_confirm_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Enter new password field";
               $error =1;
          }
          if( $this->input->post("txt_new_pwd")!=""  && trim($this->input->post("txt_new_pwd"))!=trim($this->input->post("txt_confirm_pwd")) )
          {
               $data['errors']['txt_confirm_pwd'] = "New and confirm password shoud match";
               $error =1;
          }
          if(strlen($this->input->post("txt_new_pwd"))<8 && $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Password should be minimum 8 characters";
               $error =1;
          }
           if(strlen($this->input->post("txt_new_pwd"))>21 && $this->input->post("txt_new_pwd")!="")
          {
               $data['errors']['txt_confirm_pwd'] = "Password should be maximum 20 characters";
               $error =1;
          }
          
          $con['user_id']           = $this->session->userdata('eq_user_id');
          $userDetails              =  $this->M_user->userLogin($con);
          
          $profileImage             =   $userDetails->user_image;
          //$document                =   $userDetails->document_name;
        /*   if($profileImage=="" && count($_FILES['profile_image'])<=0)
          {
               $data['errors']['profile_error'] = "Please upload profile image";
               $error =1;
          }*/
          
          if($error == 1)
          {
               $data['status'] = 0;
               echo json_encode($data);  
               exit();
          }
          else
          {         
                // print_r($userDetails);exit;
                    $dial_code                                      =                 trim($this->input->post("txt_dial_code"));
                    $phone_number                                   =                 trim($this->input->post("txt_phone"));
                    
                    if($this->M_user->checkPhoneNumber($phone_number,$dial_code)){
                        $data['status']             = 0;
                           $data['errors']['txt_confirm_pwd'] = "Phone number already exists";
                           echo json_encode($data);  
                           exit();
                    }
                    
                    $input['user_first_name']                       =                 trim($this->input->post("user_first_name"));
                    $input['user_last_name']                        =                 trim($this->input->post("user_last_name"));                
                    $input['user_updated_by']                       =                 $this->session->userdata('eq_user_id');
                    $input['user_updated_time']                     =                 gmdate("Y-m-d H:i:s");
                    // $input['user_company_name']                     =                 trim($this->input->post("txt_company"));
                   //// $input2
                    
                    if(trim($this->input->post("txt_new_pwd"))!="" && trim($this->input->post("txt_confirm_pwd"))!="" && trim($this->input->post("txt_current_pwd"))!="")
                    {
                    
                        
                       $res =   $this->M_user->checkOldPassword($this->input->post("txt_current_pwd"));
                       
                       if($res<=0)
                       {
                           $data['status']             = 0;
                           $data['errors']['txt_confirm_pwd'] = "Old password not matching";
                           echo json_encode($data);  
                           exit();
                       }
                       else
                       {
                           $newPassword                                =               trim($this->input->post("txt_new_pwd"));
                           $input['user_password']                     =                mD5($newPassword);
                       }
                        
                    }
                    
                 
                  
                                        
                if($_FILES["profile_image"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."PF".date("Ymdhis");
                                   
                                    $filename2 = $_FILES["profile_image"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
                                    $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    
									 $this->load->library('upload', $config2);
                                     $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('profile_image'))
                                   {
                                     
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
			 
			
			 
			 
			          $result         =   $this->M_user->updateUserProfile($input);
			          
			          if($result==1)
			          {
			               $data['status'] = 1;
			               $data['errors'] = "";
			               
			               $user_deatils = $this->M_user->getUserDetailsById($this->session->userdata('eq_user_id'));
			             //  print_r($user_deatils);echo $phone_number;
			               if( $user_deatils->user_phone !=$phone_number){
			                   $data['status'] = 2;
			                   $otp['phone_no']    = $phone_number;
                               $otp['dial_code']   = $dial_code;
                               $generatedOtp         =  1111; //rand(pow(10, $digits-1), pow(10, $digits)-1);
                               $otp['otp']           = (string) $generatedOtp;
                               $otp['user_id']       = $this->session->userdata('eq_user_id');
                               $otp['otp_send_time']  = gmdate("Y-m-d H:i:s");
                               $otp['otp_validity_end_time'] = date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
                               
                               $otp_id    = (string) $this->M_user->newOtp($otp);
                               $data['otp_id'] = $this->common_functions->encryptId($otp_id);
                               $this->load->library("SMS");
                               $this->load->library("parser");
                               
                               $customer_mobile_no =   $dial_code.$phone_number;
                               $customer_name      =   $input['user_first_name'].' '.$input['user_last_name'];
                               $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                        array("customer_name"=>$customer_name,
                                              "otp"=> $generatedOtp,
                                             ),TRUE),$customer_mobile_no); 
			               }
			         }else
			          {
			              $data['status']  = 0;
			               $data['errors'] = "";
			          }
			          
			          echo json_encode($data);  
                      exit();
          }
     }
     function upgradePackage()
     {
          $input['current_package_id']   =   $this->input->post("current_package_id");
          $input['user_id']              =   $this->session->userdata('eq_user_id');
          echo $result                   =   $this->M_user->upgradepackage($input);
     }
     function searchServices()
     {
         
       $data['result']         =   $this->M_user->searchServices($this->input->post());
       $this->load->view("registration_service_type",$data);
       
     }
     function changePassword()
     {
                $this->form_validation->set_rules('txt_new_pwd', 'Current password', 'trim|required');
                $this->form_validation->set_rules('txt_new_pwd', 'New passsword', 'trim|required|max_length[20]|min_length[8]|callback_valid_password');
                $this->form_validation->set_rules('txt_confirm_pwd', 'Confirm password', 'trim|required|max_length[20]|min_length[8]');
             

                if ($this->form_validation->run() == FALSE)
                { 
                  echo strip_tags(validation_errors());
                  exit;
                }
                else
                {
                    
                    
                     $res =   $this->M_user->checkOldPassword($this->input->post("txt_current_pwd"));
                       
                       if($res<=0)
                       {
                            echo  -1;
                            exit();
                       }
                       else
                       {
                           $newPassword                                =               trim($this->input->post("txt_new_pwd"));
                           $input['user_password']                     =                mD5($newPassword);
                           echo $result                                =               $this->M_user->changePassword($input);
                       }
                        
                    
                  
                }
                 
     }
     function updateDynamicLocation()
     {
                $this->form_validation->set_rules('pickup-input2', 'Location', 'trim|required|max_length[100]');
                if ($this->form_validation->run() == FALSE)
                { 
                       $data['errors'] = array(
                                              'pickup-input2' => form_error('pickup-input2')
                                              );
                                   
                }
                else
                {
                     $address['user_adresses_location']     =   $this->input->post("pickup-input2");
        			 $address['user_adresses_longitude']    =   $this->input->post("pickup-longittude2");
        			 $address['user_adresses_lattitude']    =   $this->input->post("pickup-lattitude2");
        			 $address['user_adresses_created_time'] =   gmdate("Y-m-d H:i:s");
        			 $address['user_id']                    =   $this->session->userdata('eq_user_id');
        			 $address['user_adresses_type_id']      =   $this->input->post("selected_address_type"); 
        			 $address['user_adresses_status']       =   1;
        			 //print_r($address);
                     $res =   $this->M_user->updateDynamicLocation($address);
                     $data['status'] = $res;
                     $data['address'] = $address;
                     
                }
                
                   echo json_encode($data);  
                    exit();
     }
      function saveContactus()
    {
         // print_r($_POST);
        if (count($_POST)>0) {
             echo  $this->M_user->saveContactus($_POST);
        } else 
		{
             echo 0;
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


public function usersubscribe()
     {
                    $this->form_validation->set_rules('txt_user_email', 'Email', 'required|valid_email');

             

                if ($this->form_validation->run() == FALSE)
                { 
                  echo -1;
                  exit;
                }
                else
                {
                    
                    
                   $_POST = $this->security->xss_clean($_POST);  
                 $email     =               trim($this->input->post("txt_user_email"));
                 $input['email']  =                $email;
                 echo $result   =               $this->M_user->usersubscribe($input);
                      
                        
                    
                  
                }
                 
     }

     public function appoinment_form()
     {
                    $this->form_validation->set_rules('txt_email', 'Email', 'required|valid_email');
                    $this->form_validation->set_rules('txt_name', 'Name', 'required');
                    $this->form_validation->set_rules('txt_cat', 'Category', 'required');
                    $this->form_validation->set_rules('txt_appdate', 'Date', 'required');

             

                if ($this->form_validation->run() == FALSE)
                { 
                  echo -1;
                  exit;
                }
                else
                {
                    
                    
                   $_POST = $this->security->xss_clean($_POST);  
                 $email     =               trim($this->input->post("txt_email"));
                 $name     =               trim($this->input->post("txt_name"));
                 $category     =               trim($this->input->post("txt_cat"));
                 $date     =               trim($this->input->post("txt_appdate"));
                 $input['email']  =                $email;
                 $input['name']  =                $name;
                 $input['category']  =                $category;
                 $input['date']  =                date('Y-m-d', strtotime($date));
                 echo $result   =               $this->M_user->appoinment_form($input);
                      
                        
                    
                  
                }
                 
     }
     
     function booking_details($job_request_id=0)
     {
      $this->load->model('website/M_request');
         //$job_request_id    =  $this->common_functions->decryptId($this->input->post('itemId')) ;
         $language          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
         $data['result']    =  $this->M_request->getJobSummary($job_request_id,$language); 
         $data['question']  =  $this->M_request->getQuestionsAgainstJobRequest($job_request_id); 
         $data['files']     =  $this->M_request->getUploadedFiles($job_request_id); 
         $data['staus']     =  $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$job_request_id); 
         if($this->session->userdata('eq_user_type')==2)
         {
             $userId = $this->session->userdata('eq_user_id');
             $this->M_request->recordViewCount($userId,$job_request_id);
         }
         //$printString       =  $this->load->view("job_detail_ajax",$data,true);
         //$data['print']     =  $printString ;
          $this->load->view("header");
          $this->load->view("booking_details",$data);
          $this->load->view("footer");
     }
     
    public function updateStatus(){
        $userId = $this->session->userdata('eq_user_id');
        $job_request_id = $this->input->post('job_request_id');
        $status         = $this->input->post('status');
        if($status == 1)
          $result = $this->M_user->acceptJobRequest($job_request_id,$status);
        if($result > 0){
          $output['status'] = 1;
          $output['message']= "Job request accepted...";
          
          $job_details      = $this->M_user->getJobRequestDetailsByRequestId($job_request_id);
          $user_details     = $this->M_user->getUserDetailsById($job_details->user_id);
          $provider_details = $this->M_user->getProviderFullDetails($userId,1);

          $description      = "Hi ".$user_details->user_first_name." ".$user_details->user_last_name.", Your job request is accepted by ".$provider_details->company_name;
          $data = array('title'         => 'Vendor accepted job request',
                        'description'   => $description,
                        'ntype'         => 'order-accepted',
                        'click_action'  => 'notification',
                        'id'            => $job_details->job_request_id
                    );
            
          $this->sendPushNotification($user_details,$job_details,$data);
          
          $description            =  "Hi ".$provider_details->company_name.", You have accepted job request  ".$job_details->job_request_display_id ." sent by ".$user_details->user_first_name." ".$user_details->user_last_name;
          $data = array('title'         => 'Job request accepted',
                        'description'   => $description,
                        'ntype'         => 'order-accepted',
                        'click_action'  => 'vendor_notification',
                        'id'            => $result,
                    );
        //   print_r($data);
          $this->sendPushNotification($provider_details,$job_details,$data);
          
        }else{
          $output['status'] = 1;
          $output['message']= "Failed to accept job request...";
        }
        echo json_encode($output);
    }

    public function updateUserStatus($id){
        $status = $this->input->post('status');
        $result = $this->M_user->updateUserStatus($id,$status);
        if($result)
          $output['status'] = 1;
        else{
          $output['status'] = 0;
          $output['message'] = 'Failed to update status...';
        }
        echo json_encode($output);
    }
    
    function saveStaffData(){

        $user_id             =  $this->input->post('id');

        $this->form_validation->set_rules('fname', 'First name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('lname', 'Last name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('emirates_id', 'Emirates ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('passport_id', 'Passport ID', 'trim|required|xss_clean');
        

        if(!$user_id){
          $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[user_table.user_email]');
          $this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean|is_unique[user_table.user_phone]');
          $this->form_validation->set_rules('staff_password', 'Password', 'trim|required|xss_clean');
        }

        if ($this->form_validation->run() == false) {
          $output['errors'] = array('fname' => form_error('fname'), 
                                 'lname' => form_error('lname'),
                                 'emirates_id' => form_error('emirates_id'),
                                 'passport_id' => form_error('passport_id')
                              );
          if(!$user_id){
            $output['errors']['email']    = form_error('email');
            $output['errors']['phone_no'] = form_error('phone_no');
            $output['errors']['staff_password'] = form_error('staff_password');
          }
          $output['status'] = 0;
        }else{
            $data = array('user_first_name' => $this->input->post('fname'), 
                        'user_last_name'  => $this->input->post('lname'),
                        'user_email'      => $this->input->post('email'),
                        'country_id'      => $this->input->post('country_id'),
                        'user_dial_code'  => $this->input->post("dial_code"),
                        'user_phone'      => $this->input->post('phone_no'),
                        'emirates_id'     => $this->input->post('emirates_id'),
                        'passport_id'     => $this->input->post('passport_id'),
                        'user_type'       => 3,
                        'user_status'     => 1,
                        'vendor_id'       => $this->session->userdata('eq_user_id'),
                        'user_created_by' => $this->session->userdata('eq_user_id'),
                        'user_created_time'=> date('Y/m/d H:i:s')
                      );
                      
            if($this->input->post('staff_password',true)){
                $data['user_password'] =MD5($this->input->post('staff_password',true));
            }
            
          if($_FILES["image"]["name"]!=""){
            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."PF".date("Ymdhis");
            $filename2 = $_FILES["image"]["name"];
            $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);

            $config2['upload_path']          =  $this->config->item('upload_path').'user/';
            $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
            $config2['file_name']            =  $randomNo.".".$file_ext2;

            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            if ( ! $this->upload->do_upload('image')){
              $output['status']                =  "0";
              $output['message']               =  "Profile image upload failed"; 
              echo json_encode($output);
              exit;
            }else{
              $data['user_image']  =  $config2['file_name'];
            }
          }

          $result = $this->M_user->saveUserDetails($data,$user_id);
          if($result){
            $output['status'] = "1";
            if($user_id)
              $output['message']= "Staff  data updated... ";
            else{
                  $userDetails = $this->M_user->getUserDetailsById($this->session->userdata('eq_user_id'));
                  $output['message']= "Staff created successfully...";
                  
                  $subject                  = "Welcome to vhelp";
                  $userMaiArray['message']  = 'Hi Vendor,<br> Staff '.$data['user_first_name'].' has been registered succesfully.Staff can login to their app using the valid credentials.';
                  $userMaiArray['user_name']= $this->input->post('fname').' '.$this->input->post('lname');
                  $to                       = $userDetails->user_email;
                  $userMaiArray['subject']  = $subject;
                  $this->load->library('parser');
                  $email_message            = $this->parser->parse('email/register', $userMaiArray, true);
                  $this->load->library("Mail_function");
                  $this->mail_function->SendEmail($email_message, $subject, $to);
                  
                  
                }
            }else{
              $output['status'] = '0';
              $output['message']= 'Failed to save staff details...';
            }

        } 

        echo json_encode($output);
     }
     
     public function deleteUser(){
         
        $staff_id = $this->input->post('staff_id');
        if($staff_id > 0 ){
            if($this->M_user->deleteUser($staff_id))
                echo 1;
            else 
                echo 0;
        }else{
            echo 0;
        }
     }
     
     public function assignStaff(){
        $userId = $this->session->userdata('eq_user_id');
        $output['errors'] = '';
        $this->form_validation->set_rules('staff', 'staff', 'required');
        if ($this->form_validation->run() == FALSE){
          $output['errors'] = array('staff' => form_error('staff') );
          $output['status'] = '0';
        }else{
          $staff_id = $this->input->post('staff');
          $job_request_id = $this->input->post('job_request_id');

          $data = array('staff_id' => $staff_id, 
                        'job_request_id' => $job_request_id,
                        'job_status' => 0,
                        'job_assigned_at' => date('Y/m/d H:i:s')
                      );
          $result = $this->M_user->assignStaff($data);
        //   echo $result;exit;
          if ($result == 1 ) {
            $output['status'] = 1;
            $output['message']= 'Staff assigned to job';
            
            $job_details        = $this->M_user->getJobRequestDetailsByRequestId($job_request_id);
            $staff_details      = $this->M_user->getUserDetailsById($staff_id);
            $provider_details   = $this->M_user->getProviderFullDetails($userId,1);

            $description        = 'Hi Staff, you have received a new request from '.$provider_details->company_name;
            $data = array('title'         => 'Job request received',
                        'description'   => $description,
                        'ntype'         => 'recive-job',
                        'click_action'  => 'driver_notification',
                        'id'            => $job_request_id
                    );
            // print_r($data);
            $this->sendPushNotification($staff_details,$job_details,$data);
            
            $job_requestDetails     = $this->M_user->getVendorRequestDetails($job_request_id);
            $description            = "Hi Vendor, job request ".$job_requestDetails->job_request_display_id." is assigned successfully to staff ".$staff_name;
            $data = array('title'         => 'Job assigned to staff',
                          'description'   => $description,
                          'ntype'         => 'recive-job',
                          'click_action'  => 'vendor_notification',
                          'id'            => $job_requestDetails->assign_job_provider_id,
                        );
            // print_r($data);
            $this->sendPushNotification($provider_details,$job_details,$data);
          }else if($result == -1 ){
            $output['status'] = 0;
            $output['message']= 'Job already assigned to staff';
          }else{
            $output['status'] = 0;
            $output['message']= 'Failed to assign staff';
          }
        }

        echo json_encode($output);
     }
     
    public function getAreaList(){

      $data['result']  = $this->M_user->searchArea($this->input->post());
      $this->load->view("area_list",$data);
    }

    public function searchServicesList()
    {
        $status         = 1;
        $message        = "";
        $search_key     = $this->input->post("searchKey");
        if($search_key !="")
        {
            $search_result  = $this->M_user->get_search_result($search_key);
            $search_result_html = "";

            if(!empty($search_result))
            {
                $search_result_html     .= '<ul>';
                foreach($search_result as $service)
                {
                    if($service->service_type_parent_id ==0)
                    {
                        $url    = base_url()."sub_services/".$service->service_type_id;
                        $search_result_html .= '<li><a href="'.$url.'">'.$service->service_type_name.'</a></li>';
                    }
                    else
                    {
                        $urlCategoryName  =  $service->service_type_name;
                        $string = str_replace(' ', '-', $urlCategoryName); 
                        $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                        $urlCategoryName  = strtolower($urlCategoryName);

                        $url    = base_url()."request/".$urlCategoryName."/?sid=".$this->common_functions->encryptId($service->service_type_id);
                        $search_result_html .= '<li><a href="'.$url.'">'.$service->service_type_name.'</a></li>';
                    }
                }
                $search_result_html     .= '</ul>';
            }   
            else
            {
                $search_result_html     = "Search result not found...";
            }
        }
        else
        {
            $search_result_html     = "";
        }

        $output['status']           = $status;
        $output['message']          = $message;
        $output['oData']            = $search_result_html;
        echo json_encode($output);    
    }
    
    public function rate_seller(){

        $output['status']              = "0";
        $output['message']             = "";
        
        $access_token       = (string) $this->input->post("access_token");
        if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {

            $user_id  = $user_token_data->user_id;

            $this->form_validation->set_rules('job_request_id', 'Job request id', 'required|numeric');
            $this->form_validation->set_rules('rating', 'rating', 'required|numeric');
            $this->form_validation->set_rules('feedback', 'feedback', 'required|min_length[10]');
            $this->form_validation->set_rules('title', 'title', 'trim|min_length[3]');

            if ($this->form_validation->run() !== false) {  
                $job_request_id = (int) $this->input->post("job_request_id", true);
                $rating         = (float) $this->input->post("rating", true);
                $title          = (string) $this->input->post("title", true);
                $feedback       = (string) $this->input->post("feedback", true);

                $provider_data  =  $this->M_user->getVendorDetailsByJobId($job_request_id);
                if($provider_data){
                    $seller_rating_row = $this->M_user->get_seller_rating($user_id,$provider_data->vendor_id);
                    if(empty($seller_rating_row)){
                        $data = array(
                                "user_id"       => $user_id,
                                "provider_id"   => $provider_data->vendor_id,
                                "user_rating"   => $rating,
                                "title"         => $title,
                                "feedback"      => $feedback,
                                "date"          => gmdate("Y-m-d H:i:s") 
                            );
                        $this->M_user->create_seller_rating($data);
                    }else{
                        $data = array(
                                "user_rating"   => $rating,
                                "title"         => $title,
                                "feedback"      => $feedback,
                                "date"          => gmdate("Y-m-d H:i:s") 
                            );
                        $this->M_user->update_seller_rating($data,$seller_rating_row->id);
                    }

                    $seller_rating_data = $this->M_user->get_seller_ratings_summary($provider_data->vendor_id);

                    if($seller_rating_data){
                        $data = array(
                                    "rating"        => $seller_rating_data->rating,
                                    "rated_users"   => $seller_rating_data->rated_users
                                );
                        $result = $this->M_user->update_seller($data,$provider_data->vendor_id);
                        if($result){
                            $output['status']   = "1";
                            $output['message']  = "You have rated the vendor successfully";
                            
                            $output['data']['rating'] = $seller_rating_data->rating;
                            $output['data']['rated_users'] = $seller_rating_data->rated_users;
                        }else{
                            $output['status']   = "0";
                            $output['message']  = "Unable to rate the designer";
                        }
                    }
                    // print_r($seller_rating_data);exit;
                }else{
                    $output['status']   = "0";
                    $output['message']  = "You will not be able to rate this provider unless you get a service.";
                } 
            }else{
                $output['status']   = "0";
                $output['message']  = strip_tags(validation_errors());
            }
        }else{
            $this->output->set_status_header(401);
            $output['status']     = "4";
            $output['message']    = 'User session expired';

        }

        echo json_encode($output);
    }
    
    public function validateCouponCode(){

        $coupon_code = $this->input->post('coupon_code');
        $user_id     = $this->session->userdata('eq_user_id');
        $total_price = $this->input->post('total_price');

        if($couponData = $this->validate_coupon_code($coupon_code,$user_id)){
            $output['status']  = 1;
            $output['message'] = "";
            // print_r($couponData);
            if($total_price >= $couponData[0]->coupon_minimum_spend){
                $discount       = $couponData[0]->coupon_amount;
                $discount       = ( $total_price * $discount ) / 100 ;

                if($couponData[0]->coupon_maximum_spend > 0 ){
                            
                    if($discount > $couponData[0]->coupon_maximum_spend ){
                        $discount  = $couponData[0]->coupon_maximum_spend;
                    }            
                }

                $total_price  = $total_price - $discount;
                $vat          = VAT;
                if($vat > 0) 
                    $vat_amount = ($total_price * $vat )/ 100;
                else
                    $vat_amount = 0;
                $grand_total    = $total_price + $vat_amount;
                
                $output['vat_amount']  = $vat_amount;
                $output['grand_total'] = $grand_total;
                $output['discount']    = $discount;

            }else{
                $output['status']  = "0";
                $output['message'] = "Minimum ".$couponData[0]->coupon_minimum_spend.' amount for apply this coupon code';
            }
            
        }else{
            $output['status']  = "0";
            $output['message'] = "Invalid coupon";
        }

        echo json_encode($output);
    }

    private function validate_coupon_code($coupon_code,$user_id){

        if($coupon_code){
            $condition = array('coupon_code' => $coupon_code);
            $result = $this->M_user->validate_coupon_code($condition,$user_id);
            return $result;    

        }else{
            return FALSE;
        }
    }
    
    private function sendPushNotification($user_fcm,$job_details,$data){
        // print_r($user_fcm);exit;
        $notification_id = time();
        $this->load->library("FCM_Notification");

        if (!empty($user_fcm->firebase_user_key)) {
            $notification_data["Notifications/".$user_fcm->firebase_user_key."/".$notification_id] = [
                            "title" => $data['title'],
                            "description" => $data['description'],
                            "notificationType" => $data['ntype'],
                            "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                            "orderID" => (string) $data['id'],
                            "service_type_name" => $job_details->service_type_name,
                            "url" => "",
                            "imageURL" => "",
                            "read" => "0",
                            "seen" => "0"
                        ];

                        $fb_database = get_firebase_refrence();
                        $fb_database->getReference()->update($notification_data);
        }
                    
        if (! empty($user_fcm->fcm_token) ) {
                        
            $this->fcm_notification->send_single_notification($user_fcm->fcm_token, [
                            "title" => $data['title'],
                            "body" => $data['description'],
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => $data['click_action']],
                            ["type" => $data['ntype'],
                            "notificationID" => $notification_id,
                            "orderID" => (string) $data['id'],
                            "service_type_name" => $job_details->service_type_name,
                            "imageURL" => ""
                        ]);
        }
    }
    
    public function validate_phone_number( $phone_number ,$type = 0 ){
        
        if (! empty($phone_number) ) {
            
            $zero_pos = strpos($phone_number, '0');
            if( $zero_pos !== false)
            {
                if($zero_pos == 0)
                {
                    $this->form_validation->set_message('validate_phone_number', 'Contact Number should not start with 0.');
                    return FALSE;
                }
            }
            
            $condition = ['user_phone' => $phone_number];
            $dial_code = $this->input->post('user_dial_code', true);
            if (! empty($dial_code) ) {
                $condition['user_dial_code'] = $dial_code;
            }
            if($type){
                $record = $this->M_user->get_user($condition);
                // print_r($record);exit;
                if (! empty($record) ) {
                    $this->form_validation->set_message('validate_phone_number', '{field} is already registered.');
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
    
    
    public function socialLogin(){
        
        $email = $this->input->post('email');
        $user_details = $this->M_user->getuserByEmail($email);
        // print_r($user_details);exit;
        if($user_details){
            
            // if($user_details->phone_verified == 1 ){
                $this->session->unset_userdata("eq_user_email");
                $this->session->unset_userdata("eq_user_id");
                $this->session->unset_userdata("eq_user_type");
                $this->session->unset_userdata("eq_user_name");
                
                $this->session->set_userdata("eq_user_email",$user_details->user_email);
                $this->session->set_userdata("eq_user_id",$user_details->user_id);
                $this->session->set_userdata("eq_user_name",$user_details->user_first_name);
                $this->session->set_userdata("eq_user_type",$user_details->user_type);
                $this->session->set_userdata('eq_login_type','S');
                
                $output['message']  = "Login successfully";
                $output['status']   = 1;
            // }else{
                if(!$user_details->user_phone){
                    $output['message']  = "Add your mobile number...";
                    $output['status']   = 3;
                }
            // }
        }else{
            $name  = $this->input->post('name');
            $name = explode(" ",$name);
            
            $i_data['user_first_name']  = $name[0];
            $i_data['user_last_name']   = $name[1];
            $i_data['user_email']       = $email;
            $i_data['user_type']        = 1;
            $i_data['login_type']       = 'S';
            
            $result = $this->M_user->socialLogin($i_data);
            if($result){
                
                $user_details = $this->M_user->getUserDetailsById($result);
                $this->session->set_userdata("eq_user_email",$user_details->user_email);
                $this->session->set_userdata("eq_user_id",$user_details->user_id);
                $this->session->set_userdata("eq_user_name",$user_details->user_first_name);
                $this->session->set_userdata("eq_user_type",$user_details->user_type);
                
                if($user_details->phone_verified == 1 ){
                    $output['message']  = "Registration successfull";
                    $output['status']   = 1;
                    $this->session->set_userdata("eq_user_type",$user_details->user_type);
                }else{
                    $output['message']  = "Add your mobile number...";
                    $output['status']   = 3;
                }
                
            }else{
                $output['message']  = "Failed to register";
                $output['status']   = 0;
            }
            
        }
        
        echo json_encode($output);
        
    }
    
    public function test(){
        $this->load->library("SMS");
        $this->load->library("parser");
        $customer_mobile_no =   '+971505041860';
                    $customer_name      =   'Sir';//$this->input->post("first_name").' '.$this->input->post("last_name");

        $result =   $this->sms->send_normal_sms($this->parser->parse(
                        "sms/plain_otp",
                        array(
                            "customer_name" => $customer_name,
                            "otp" => '1234',
                        ),
                        TRUE
                    ), $customer_mobile_no);
        // print_r($result);
    }
    
    public function getCountryList(){
        $country_list = $this->M_user->getCountryList();
        $html = "<option value='' foo='0'>Choose country</option>";
        
        foreach($country_list as $key=> $value){
            $html .= '<option value="'.$value->country_id.'" foo="'.$value->country_dial_code.'">'.$value->country_name.'</option >'; //"<option value=".." fo=".'+'.$value->country_dial_code.">".$value->country_name."</option>"  
        }
        
        echo $html;
    }
    
    public function getDialCode(){
        $country_list = $this->M_user->getCountryList();
        $html = "<option value='' foo='0'>Choose Dial Code</option>";
        
        foreach($country_list as $key=> $value){
            $html .= '<option value="+'.$value->country_dial_code.'" for="'.$value->country_id.'" >+'.$value->country_dial_code.'</option >'; //"<option value=".." fo=".'+'.$value->country_dial_code.">".$value->country_name."</option>"  
        }
        
        echo $html;
    }
    
    
    public function rateJob(){
        
        $job_request_id = $this->input->post('job_request_id');
        $provider_data  =  $this->M_user->getVendorDetailsByJobId($job_request_id);
        // print_r($provider_data);exit;
        if($provider_data){
            $seller_rating_row = $this->M_user->get_seller_rating($job_request_id);
            // print_r($seller_rating_row);
            if(empty($seller_rating_row)){
                $data = array(
                            "user_id"       => $this->session->userdata('eq_user_id'),
                            "provider_id"   => $provider_data->vendor_id,
                            "user_rating"   => $this->input->post('rating'),
                            "title"         => $this->input->post('title'),
                            "feedback"      => $this->input->post('description'),
                            'service_type_id'=> $provider_data->service_type_id,
                            'job_request_id' => $job_request_id,
                            "date"          => gmdate("Y-m-d H:i:s") 
                        );
                $this->M_user->create_seller_rating($data);
            }else{
                $data = array(
                            "user_rating"   => $this->input->post('rating'),
                            "title"         => $this->input->post('title'),
                            "feedback"      => $this->input->post('description'),
                            // "date"          => gmdate("Y-m-d H:i:s") 
                        );
                $this->M_user->update_seller_rating($data,$seller_rating_row->id);
                
            }
            $output['status']   = "1";
            $output['message']  = "You have rated the service successfully";
        }else{
            $output['status']   = "0";
            $output['message']  = "Failed to rate services";
        }
        
        echo json_encode($output);
    }
    
    public function changePhoneNumberVerify(){
        
        $otpId  = $this->input->post('otpId');
        $otpId  = $this->common_functions->decryptId($otpId);
        $otp    = $this->input->post('otpData');
        
        $result = $this->M_user->validatePhoneOtp($otpId,$otp);
        echo $result;
    }
    
    public function changePhoneNumber(){
        // echo $this->input->post('dial_code');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|max_length[100]|callback_validate_phone_number[1]');
        if ($this->form_validation->run() == FALSE){
            $data['status'] = 0;
            $data['errors'] = array(
                'mobile_number'  => form_error('mobile_number'),                                             
            );
            echo json_encode($data);
            exit();
        }else{
            $dial_code      = $this->input->post('dial_code');
            $mobile_number  = $this->input->post('mobile_number');
            
            $otp['phone_no']    = $mobile_number;
            $otp['dial_code']   = $dial_code;
            $otp['country_id']  = $this->input->post('country_id');
            
            $generatedOtp         =  1111; //rand(pow(10, $digits-1), pow(10, $digits)-1);
            $otp['otp']           = (string) $generatedOtp;
            $otp['user_id']       = $this->session->userdata('eq_user_id');
            $otp['otp_send_time']  = gmdate("Y-m-d H:i:s");
            $otp['otp_validity_end_time'] = date('Y-m-d H:i:s', strtotime("+10 minutes", strtotime($otp['otp_send_time'])));
            
            $user_details = $this->M_user->get_user(['user_id'=>$this->session->userdata('eq_user_id')]);
            // echo $user_details[0]->user_first_name;
            // print_r($user_details);
            // exit;
            
            $otp_id    = (string) $this->M_user->newOtp($otp);
            if($otp_id > 0 ){
                $data['otp_id'] = $this->common_functions->encryptId($otp_id);
                $this->load->library("SMS");
                $this->load->library("parser");
                
                 
                
                $customer_mobile_no =   $dial_code.$phone_number;
                $customer_name      =   $user_details[0]->user_first_name.' '.$user_details[0]->user_last_name;
                $this->sms->send_normal_sms($this->parser->parse("sms/plain_otp",
                                            array("customer_name"=>$customer_name,
                                                  "otp"=> $generatedOtp,
                                                 ),TRUE),$customer_mobile_no); 
                $data['status']     = 1;
            }else{
                $data['status']     = 0;
            }
            
        }
        
        echo json_encode($data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller 
{
    public function __construct()
     {
         parent::__construct();
         $this->load->model('services/M_user');      
         $this->load->model('M_admin');  
         $this->load->model('services/M_quotation');  
         error_reporting(E_ERROR | E_PARSE);
         $this->load->library("FCM_Notification");
         
         $this->load->helper('eq_helper');  
     }
     
     function getQuestions()
     {
                 $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required|numeric');
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                    $languageCode         =   ($this->input->post('language')==2?$this->input->post('language'):1); 
                    $serviceTypeId          =   $this->input->post('service_type_id');
                    $result                         =   $this->M_quotation->getQuestions($serviceTypeId);
                    if(count($result) > 0)
                    {
                                                 $output['status']              =       "1";
                                                 $output['message']          =      "success";
                                                 $i=0;
                                                 foreach ($result as $rows)
                                                 {
                                                     $output['data'][$i]['id']          =    $rows->question_id;
                                                     $output['data'][$i]['name']                =   $languageCode==2?$rows->question_arb:$rows->question;
                                                     $output['data'][$i]['input_type']                =   $rows->form_control_name;
                                                     
                                                     $answers                         =    $this->M_quotation->getAnswerOptions($rows->question_id);
                                                     if(count($answers) >0 )
                                                     {
                                                         $k=0;
                                                         foreach($answers as $rows2)
                                                         {
                                                          $output['data'][$i]['options'][$k]["id"]               =   $rows2->answer_options_id;
                                                          $output['data'][$i]['options'][$k]["name"]        =   $languageCode==2?$rows2->answer_option_arabic:$rows2->answer_option;
                                                          
                                                          $k++;
                                                         }
                                                     }
                                                     else
                                                     {
                                                         $output['data'][$i]['options']               =          array();
                                                     }
                                                     
                                                     
                                                   $i++;  
                                                 }
                                                 
                                                 
                    }
                    else
                    {
                                           $output['data'] =  array();
                    }
                                 echo json_encode($output);exit;  
                }
     }
     function createJobRequest()
     {
         
      //  print_r($_FILES["document"]);
        // exit;
      
           if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
               $this->form_validation->set_rules('option', 'option', 'trim|required');
               $this->form_validation->set_rules('valTime', 'valTime', 'trim|required');
               $this->form_validation->set_rules('valdate', 'valdate', 'required'); 
              // $this->form_validation->set_rules('question_answer[]', 'question_answer', 'required'); 
               $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required'); 
               $this->form_validation->set_rules('is_home_category', 'is_home_category', 'required'); 
               
               
                if($this->input->post("is_home_category")==0)
                {
                    $this->form_validation->set_rules('service_date', 'service_date', 'trim|required');
                    $this->form_validation->set_rules('serviceTime', 'serviceTime', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('price_from', 'price_from', 'trim|required');
                    $this->form_validation->set_rules('price_to', 'price_to', 'trim|required');
                    $this->form_validation->set_rules('addressType', 'addressType', 'trim|required');
                    
                }
                else if($this->input->post("is_home_category")==1)
                {
                    $this->form_validation->set_rules('street', 'street', 'trim|required');
                    $this->form_validation->set_rules('city', 'city', 'trim|required');
                    $this->form_validation->set_rules('state', 'state', 'trim|required');
                    $this->form_validation->set_rules('discription', 'discription', 'trim|required');
                    
                    
                }
                 
             if(empty($_FILES['document']['name']) && $this->input->post("is_home_category")==1)
          {
             // $this->form_validation->set_rules('document','Upload supporting document','trim|required');
         }  
         
                $providers  =              $this->input->post('providers');
                
                if($this->input->post('option')==1)
                {
                   $providers = array(); 
                }
                    
               if($this->input->post('option')==2 && count($providers)<=0)
               {
                   $this->form_validation->set_rules('providers','providers','trim|required');
               }
                   
                if($this->input->post("is_home_category")==0)
                {
              
                              $input['address_type']                         =           $this->input->post('addressType');
                              $input['job_date']                             =           date("Y-m-d",strtotime($this->input->post('service_date')));
                              $input['job_time']                             =           date("H:i:s",strtotime($this->input->post('serviceTime'))); 
                              $input['job_price_from']                       =           $this->input->post('price_from');
                              $input['job_price_to']                         =           $this->input->post('price_to');
                              
                              
                          
                              
                              
               
                    
                }
                else if($this->input->post("is_home_category")==1)
                {
                  
                    $input['job_location']                           =           $this->input->post('street');
                    $input['job_longitude']                        =           $this->input->post('longitude');
                    $input['job_lattitude']                          =           $this->input->post('lattitude');
                    $input['city']                                           =           $this->input->post('city');
                    $input['state']                                        =           $this->input->post('state');
                    
                    
                }
                   
               $input['description']                             =           $this->input->post('discription'); 
               
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                    $languageCode               =   ($this->input->post('language')==2?$this->input->post('language'):1); 
                    $acces_token                =   trim($this->input->post("access_token"));    
                    $checkCode                  =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                              $user_id                                                   =           $checkCode ;
                              
                          //    $_POST['user_id'] = $user_id;
                              
                  $_POST                      =        $this->security->xss_clean($_POST);
                  
                  if($this->input->post("is_home_category")==0 && $this->input->post('addressType')>0)
                  {
                        $locationDetails                           =           $this->M_user->getHomeLocation($user_id,$this->input->post('addressType')); 
                        $input['job_location']                     =           $locationDetails->user_adresses_location;
                        $input['job_longitude']                    =           $locationDetails->user_adresses_longitude;
                        $input['job_lattitude']                    =           $locationDetails->user_adresses_lattitude;
                  }
                  
                //  echo count($_FILES["document"]["name"]);
        if(count($_FILES["document"]["name"])>0)
	 {
	     
				 for($i=0;$i<count($_FILES["document"]["name"]);$i++)
				 {
				                  
				 $abc = FALSE;   
				 
			/*	$_FILES['docs']['name']     = $_FILES['document']['name'][$i];
                $_FILES['docs']['type']     = $_FILES['document']['type'][$i];
                $_FILES['docs']['tmp_name'] = $_FILES['document']['tmp_name'][$i];
                $_FILES['docs']['error']     = $_FILES['document']['error'][$i];
                $_FILES['docs']['size']     = $_FILES['document']['size'][$i];*/
                
                $temp_name =$_FILES['document']['tmp_name'][$i];
                
                 $real_name  = strtolower($_FILES['document']['name'][$i]);
                 $img_ext = end(explode(".", $real_name));
                
                 
               $upload_dir    =   $this->config->item('upload_path').'quotations/';
               
               $digits =6;
               
               $up_file_name="";
                 
               $up_file_name   =   str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis").".".$img_ext;
               
               $file_path      =  $upload_dir . $up_file_name;

           // echo "<br>";
        
         $abc =   move_uploaded_file($temp_name, $file_path);
        // var_dump($abc);
         
         if($abc===FALSE)
         {
             $data['status'] = 0;
                                        $data['errors'] = array(
                                         'document' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
             
         }
         else
         {
              $input['document'][$i]                 =   $up_file_name;
         }
				     
			//echo "syam".$i;	                  
                                  
				 }
	 }
	 
//	 exit;
         
          if($this->input->post("is_home_category")==0)
                {
              
                              $input['address_type']                         =           $this->input->post('addressType');
                              $input['job_date']                                 =           date("Y-m-d",strtotime($this->input->post('service_date')));
                              $input['job_time']                                 =           date("H:i:s",strtotime($this->input->post('serviceTime'))); 
                              $input['job_price_from']                     =           $this->input->post('price_from');
                              $input['job_price_to']                          =           $this->input->post('price_to');
                              
                              
                               $this->load->model('services/M_user');
                               
                               $ad = $this->M_user->getHomeLocation($user_id,$this->input->post('addressType'));
                               
                               if($ad->user_adresses_id<=0)
                               {
                                     $output['status']                        =    "3";
                                     $output['message']                       =     "Address details not added";
                                     $output['job_request_id']                =    "";
                                     
                                     echo json_encode($output);exit; 
                               }
               
                    
                }
                else if($this->input->post("is_home_category")==1)
                {
                  
                    $input['job_location']                           =           $this->input->post('street');
                    $input['job_longitude']                        =           $this->input->post('longitude');
                    $input['job_lattitude']                          =           $this->input->post('lattitude');
                    $input['city']                                           =           $this->input->post('city');
                    $input['state']                                        =           $this->input->post('state');
                    $input['description']                             =           $this->input->post('discription'); 
                    
                }
                    $input['user_id']                                    =          $user_id;
                    $input['service_type_id']                     =           $this->input->post('service_type_id');
                    $input['job_validity_date']                  =            date("Y-m-d",strtotime($this->input->post('valdate')));;
                    $input['job_validity_time']                  =            date("H:i:s",strtotime($this->input->post('valTime'))); 
                    $input['job_request_status']              =           0;
                    $input['job_request_created_time'] =           date("Y-m-d H:i:s");
                    $input['job_request_type']                 =           $this->input->post('option');
                    
                    if($this->input->post('option')==1)
                    {
                        $firstString = "Q";
                    }
                    else
                    {
                        $firstString = "R";
                    }
                    
                    $this->load->library("Common_functions");
                    $randomString =  $this->common_functions->incrementalHash(2);
                    
                    $input['job_request_display_id']         =           $firstString.$randomString.$user_id.date("mdHis");
                    
                    
                     $questions                              =          $this->input->post('question_answer');
                     
                  
                              
                              $result                    =            $this->M_quotation->createJobRequest($input,$this->input->post('question_answer'),$providers); 
                              
                              if($result>0)
                              {
                              
                                $output['status']                        =    "1";
                                $output['message']                       =    $this->lang->line("request_created");
                                $output['job_request_id']                =    (string)$result;
                                
                                   /* if($this->input->post('option')==1)
                                    {
                                        $type="quotation";
                                        
                                        $fcm =   $this->M_user->getFcmGroupDetails($this->input->post('service_type_id'));
                                        
                                        $extraData['title']  =  "Emirates quotation";
                                        $extraData['id']     =   $result;
                                        $extraData['type']   =  "Job request";
                                        $extraData['click_action']   =  "notification";
                                        
                                        $message['title']        =  "Emirates quotation"; 
                                        $message['body']         =  "New quotation invitation"; 
                                        
                                        if($fcm->notification_group_name!="" && $fcm->fcm_key!="")
                                        {
                                            $this->fcm_notification->send_notification($fcm->fcm_key,$message,$extraData);
                                            
                                            $providersArray =  $this->M_quotation->getProvidersAgainsServiceType($this->input->post('service_type_id'));
                                        
                                            foreach($providersArray as $notiFicationUsers)
                                            {
                                                
                                                $saveData =  $this->M_quotation->updateToFirbase($notiFicationUsers->provider_id,"P",$message['body'],$message['title'],$type,$output['job_request_id']);
                                                
                                            }
                                        }
                                        
                                       
                                       
                                    }
                                    else
                                    {
                                        $type="request";
                                         
                                        $message['title']        =  "Emirates quotation"; 
                                        $message['body']         =  "New job request"; 
                                         
                                        
                                          $providerArray  = explode(",",$providers);
                                          
                                          $extraData['title']  =  "Emirates quotation";
                                          $extraData['id']     =   $result;
                                          $extraData['type']   =  "Job request";
                                          $extraData['click_action']   =  "notification";
                                          if(count($providerArray)>0)
                                          {
                                                
                                                foreach($providerArray as $pr)
                                                {
                                                    
                                                     $fcm =   $this->M_user->getUsersFcmTokens($pr);
                                                     
                                                     if($fcm->fcm_token!="")
                                                     {
                                                           $this->fcm_notification->send_single_notification($fcm->fcm_token,$message,$extraData);
                                                           
                                                           $saveData =  $this->M_quotation->updateToFirbase($pr,"P",$message['body'],$message['title'],$type,$output['job_request_id']);
                                                     }
                                                    
                                                    
                                                }
                                          }
                                        
                                        //for job request sending user
                                        
                                       
                                    }*/
                                    
                                       $fcm            =   $this->M_user->getUsersFcmTokens($user_id);
                                     // echo  $fcm->fcm_token;
                                       /* if($fcm->fcm_token!="")
                                        {
                                            
                                        $message['title']        =  "Emirates quotation"; 
                                        $message['body']         =  "Request has been sent"; 
                                        
                                         $r =  $this->fcm_notification->send_single_notification($fcm->fcm_token,$message,$extraData);
                                         
                                         
                                         //var_dump($this->fcm_notification->curl_response);
                                        }
                                        $saveData =  $this->M_quotation->updateToFirbase($user_id,"U",$message['body'],$message['title'],$type,$output['job_request_id']);*/
                              
                              }
                              else
                              {
                                  $output['status']                        =    "0";
                                  $output['message'] = $this->lang->line("request_created_failed");
                                  $output['job_request_id']               =   "";
                              }
                              echo json_encode($output);exit;  
                        }
                    
                }
               
     }
     function getJobSummary()
     {
                $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
			
			
			         $acces_token                 =   trim($this->input->post("access_token"));    
			         if($acces_token!="")
			         {
                     $checkCode                   =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                                   =           $checkCode ;
                        }
			         }
			
			$languageCode                             =            ($this->input->post('language')==2?$this->input->post('language'):1);       
                      if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
                    $job_request_id                           =            $this->input->post('job_request_id');                
                    $languageCode              =   ($this->input->post('language')==2?$this->input->post('language'):1); 
                    $result                                            =            $this->M_quotation->getJobSummary($job_request_id,$languageCode); 
                   // print_r($result);
                    if(count($result) >0 )
                    {
                                $output['status']                                                     =    "1";
                                $output['message']                                                =   "success";
                                $output['data']['job_request_id']                                    =    (string)$result->job_request_id;
                                $output['data']['job_id_dispaly']                                    =    $result->job_request_display_id!=""?$result->job_request_display_id:"";
                                $output['data']['service_type_id']                                   =    (string)$result->service_type_id;
                                $output['data']['service_type']                                        =     $result->service_type_name;
                                $output['data']['service_type_desc']                             =     $result->service_type_desc!=""? $result->service_type_desc:"";
                                $output['data']['job_date']                                               =    $result->job_date!=""?$result->job_date:"";
                                $output['data']['job_time']                                               =    $result->job_time!=""?$result->job_time:"";
                                $output['data']['job_validity_date']                               =    $result->job_validity_date!=""?date("d-m-Y",strtotime($result->job_validity_date)):"";
                                $output['data']['job_validity_time']                               =    $result->job_validity_time!=""?date("h:i A",strtotime($result->job_validity_time)):"";
                                $output['data']['job_price_from']                                  =    $result->job_price_from!=""?$result->job_price_from:"";
                                $output['data']['job_price_currency']                          =    "AED";
                                $output['data']['job_price_to']                                       =    $result->job_price_to!=""?$result->job_price_to:"";
                                
                                
                                
                                
                                
                                 if($result->job_location=="")
                                       {
                                           if($result->user_id>0 && $result->address_type>0)
                                           {
                                               $addressType        =   $result->address_type;
                                               
                                               $alternateLocation  =   $this->M_user->getHomeLocation($result->user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $result->job_longitude!=""?$result->job_longitude:"";
                                           $latiTude = $result->job_lattitude!=""?$result->job_lattitude:"";
                                           $location = $result->job_location!=""? $result->job_location:"";
                                       }
                                       
                                $output['data']['job_location']                                      =    $location!=""?$location:"";
                                $output['data']['job_longitude']                                     =    $longiTude!=""?$longiTude:"";
                                $output['data']['job_lattitude']                                     =    $latiTude!=""?$latiTude:"";
                                
                                
                                $output['data']['is_home_category']                                  =    $result->is_home_category!=""?$result->is_home_category:"";
                                $output['data']['remarks']                                           =    $result->description!=""?$result->description:"";
                                
                                 if($result->is_approoved==1)
                                       {
                                         
                                          
                                       }
                                       else
                                       {
                                           
                                            $disableFurther =1;
                                       }
                                       
                                   // $output['data']['approval_status_d']                        =   $result->is_approoved==1?"1":"0";
                                    //$output['data']['approval_status']                          =   $result->is_approoved==1?"Approved":"Pending Approval";  
                                    
                                    if($result->is_approoved==1)
                                    {
                                        $output['data']['approval_status_d']                     =   "1";
                                        $output['data']['approval_status']                       =   "Approved"; 
                                    }
                                    else if($result->is_approoved==0)
                                    {
                                        $output['data']['approval_status_d']                     =   "0";
                                        $output['data']['approval_status']                       =   "Pending Approval";
                                    }
                                    else if($result->is_approoved==-1)
                                    {
                                        $output['data']['approval_status_d']                     =   "-1";
                                        $output['data']['approval_status']                       =   "Refused";
                                    }
                                    else
                                    {
                                         $output['data']['approval_status_d']                     =   "0";
                                         $output['data']['approval_status']                       =   "Pending Approval";
                                    }
                                       
                                
                                 if($result->job_request_status==5)
                                       {
                                            $jobStatus = $this->lang->line("completed");
                                            $disableFurther =1;
                                       }
								      else if($result->job_request_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           $disableFurther =1;
                                       }
                                       else if($result->job_request_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                           $disableFurther =1;
                                       }
                                       else
                                       {
                                           $jobStatus = $this->lang->line("pending");
                                       }
									   
									   $displayCancel ="no";
									   
									   if($disableFurther!=1)
									   {
										   $displayCancel ="yes";
									   }
									   
                                $output['data']['job_request_status']                            =    $jobStatus;
							//	$output['data']['display_cancel_button']                                     =  $displayCancel;
							
							        
							
                                
                                $displayMarkPrice ="no";
                                $displayQuotationPrice ="no";
                                $markedPrice ="";
                                if($user_id>0)
                                {
                                    
                                  $mark  =    $this->M_quotation->checkPriceAlreadyMarked($job_request_id,$user_id); 
                                  //print_r($mark);
                                  if($disableFurther!=1 && $mark->user_response_status!=2 && $mark->assign_status!=2 && $mark->assign_status!=3 && $mark->user_response_status!=1) 	
                                  {
                                       $displayMarkPrice ="yes";
                                  }
                                  if($mark->provider_amount>0)
                                  {
                                      $markedPrice            =   	 $mark->provider_amount>0?$mark->provider_amount:"";
                                      $displayQuotationPrice  =      "yes";
                                  }
                                 
                                    
                                }
                                
                                $currentDate   = date("Y-m-d H:i:s");
                                $validityTotal = date("Y-m-d H:i:s",strtotime($result->job_validity_date." ".$result->job_validity_time));
                                
                                if($validityTotal<$currentDate)
                                {
                                    $displayMarkPrice ="no";
                                }
                                
                                $output['data']['provider_doc']                                              =  $mark->document_name!=""?base_url()."uploads/quotations/".$mark->document_name:"";
                                $output['data']['display_price_section']                                     =  $displayMarkPrice;
                                $output['data']['display_marked_price']                                      =  $displayQuotationPrice;
                                $output['data']['marked_price']                                              =  $markedPrice;
                                
                                if($result->job_request_status==4 || $result->job_request_status==5)
                                {
                                    $confirmedProvider = $this->M_quotation->getConfirmedProviderDetals($job_request_id); 
                                }
                                
                                
                                
                                 $output['data']['confirmed_provider_id']                                   =  $confirmedProvider->user_id>0?$confirmedProvider->user_id:"";
                                 $output['data']['confirmed_provider_mobile']                               =  $confirmedProvider->user_phone!=""?$confirmedProvider->user_dial_code." ".$confirmedProvider->user_phone:"";
                                 $output['data']['confirmed_provider_first_name']                           =  $confirmedProvider->user_first_name!=""?$confirmedProvider->user_first_name:"";
                                 $output['data']['confirmed_provider_last_name']                            =  $confirmedProvider->user_last_name!=""?$confirmedProvider->user_last_name:"";
                                 
                                 if($confirmedProvider->user_id==$user_id && $confirmedProvider->user_id>0)
                                 {
                                     $displayCustomerDetails                 =  "yes";
                                     $output['data']['awarded']              =  "yes"; 
                                 }
                                 else
                                 {
                                      $displayCustomerDetails                =  "no";
                                      $output['data']['awarded']             =  "no"; 
                                 }
                                 $output['data']['display_customer_details']                          =   $displayCustomerDetails;
                                 
                                 if($output['data']['awarded']=="yes" || $result->job_request_status<4)
                                 {
                                     $output['data']['dispaly_overall_status']             =  "yes"; 
                                 }
                                 else
                                 {
                                     $output['data']['dispaly_overall_status']             =  "no"; 
                                 }
                               
//                               $output['data']['job_lattitude']                                     =    $result->job_lattitude!=""?$result->job_lattitude:"";
                                        $date = new DateTime($output['job_time']);
                                $timeFormated = $date->format('h:i A') ;
                                $date2 = new DateTime($output['job_date']);
                                $daeFormated = $date2->format('d-m-Y') ;
                             
                                $timeFormated = date("h i A",strtotime($result->job_time));
                                $daeFormated = date("d-m-Y",strtotime($result->job_date));
                             
                             // $date3 = new DateTime($output['job_validity_time']);
                            // $timeFormated2 = $date3->format('h:i A') ;
                              //  $date4 = new DateTime($output['job_validity_date']);
                             //$daeFormated2 = $date4->format('d-m-Y') ;
                             $timeFormated2  = date("h:i A",strtotime($result->job_validity_time));
                             $daeFormated2 =    date("d-m-Y",strtotime($result->job_validity_date));
                             
                              $output['data']['job_date_time']                                 =    $output['data']['is_home_category']!=1?$daeFormated.",".$timeFormated:"";
                              if($output['job_price_to']!="")
                              {
                               $output['data']['price_range']                                 =    "AED ".$output['job_price_from']."-"."AED ".$output['job_price_to'];
                              }
                              else
                              {
                                 $output['data']['price_range']                                 =    ""; 
                              }
                              $output['data']['job_validity']                                 =     $daeFormated2.",".$timeFormated2;
                              
                              
                              //handling status//handling status//handling status//handling status//handling status//handling
                              
                              
                              $userDetails =  $this->M_quotation->getUerType($user_id);
                              //print_r($userDetails);
                              
                              $displayAcceptButton         = "no";
                              $displayCancelButton         = "no";
                              
                               $flag = 0;
                              
                               $assignDetails =  $this->M_quotation->getAssignedStatus($job_request_id,$user_id);
                               // print_r($assignDetails);
                              
                              if($result->job_request_status==4 || $result->job_request_status==5 || $result->job_request_status==2)
                              {
                                  $displayCancelButton         = "no";
                                  $displayAcceptButton         = "no";
                                  
                                  $flag =1;
                                  
                              }
                               if($userDetails->user_type==1 && $flag==0)
                              {
                                  $displayAcceptButton         = "no";
                                  
                                  if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=2)
                                  {
                                    $displayCancelButton         = "yes";
                                   
                                  }
                              }
                              else if($userDetails->user_type==2 && $flag==0)
                              {
                                  
                                   
                                  
                                  
                                   if($result->job_request_status!=4 && $result->job_request_status!=5 && $result->job_request_status!=2)
                                  {
                                      
                                    $displayCancelButton         = "yes";
                                    
                                  }
                                  if($result->is_approoved==1 && $assignDetails->user_response_status!=2 && $result->job_request_type==2 && $assignDetails->provider_id>0 && $assignDetails->assign_status!=1 && $assignDetails->assign_status!=3 && $assignDetails->assign_status!=2)
                                  {
                                      //echo "dsd";
                                      $displayAcceptButton         = "yes";
                                  }
                              }
                              
                              $displayJobCompleteButton         = "no";
                              
                              if($result->job_request_status==4 && $userDetails->user_type==2 && $assignDetails->user_response_status==1)
                              {
                                  $displayJobCompleteButton         = "yes";
                                  //echo "ds";
                              }
                              
                              if(($assignDetails->user_response_status==2 || $assignDetails->assign_status==2) && $userDetails->user_type==2)
                              {
                                  $displayCancelButton         = "no";
                              }
                               if($result->is_approoved==-1)
                                    {
                                       $displayCancelButton         = "no";
                                    }
                                    if($userDetails->user_type==2 && $result->job_request_type==1)
                                    {
                                        $displayCancelButton         = "no";
                                    }
                            
                                $output['data']['display_complete_button']                                   =   $displayJobCompleteButton;
                                $output['data']['display_cancel_button']                                     =   $displayCancelButton;
                                //$output['data']['display_accept_button']                                   =   $displayAcceptButton;
                              $output['data']['display_accept_button']                                       =   "no";
                              
                              //handling status//handling status//handling status//handling status//handling status//handling 
                              
                              $output['data']['customer']['customer_name']                   =    $result->user_first_name." ".$result->user_last_name;
                              $output['data']['customer']['image']                                     =                           ($result->user_image!=""?base_url().'uploads/user/'.$result->user_image:base_url().'images/user_dummy.png');
                              $output['data']['customer']['phone']                                     =    $result->user_phone!=""?$result->user_dial_code."-".$result->user_phone:"";
                              $output['data']['customer']['user_email']                                     =    $result->user_email!=""?$result->user_email:"";
                              $output['data']['customer']['address']                                     =   $result->job_location!=""?$result->job_location:"";
                              $output['data']['customer']['id']                                     =   $result->user_id!=""?$result->user_id:"";
                             
                             $service =     $this->M_quotation->getQuestionsAgainstJobRequest($job_request_id); 
                             //print_r($service);
                             if(count($service)>0)
                             {
                                 $k=0;
                                 foreach($service as $rows)
                                 {
                                     $output['data']['questions'][$k]['question']                                     =  ($languageCode==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question);
                                    
                                     $answer =($languageCode==2 && $rows->answer_option_arabic!=""?$rows->answer_option_arabic:$rows->answer_option);
                                     $output['data']['questions'][$k]['answer']                                        =  $answer!=""?$answer:$rows->answer;
                                 $k++;
                                     
                                 }
                             }
                             else
                             {
                                 $output['data']['questions'] = array();
                             }
                               
                           $files =     $this->M_quotation->getUploadedFiles($job_request_id); 
                            // print_r($files);
                             if(count($files)>0)
                             {
                                 $k=0;
                                 foreach($files as $rows)
                                 {
                                     $output['data']['files'][$k]['path']                                     =  $rows->documents_name!=""?base_url()."uploads/quotations/".$rows->documents_name:"";
                                    
                                    
                                 $k++;
                                     
                                 }
                             }
                             else
                             {
                                 $output['data']['files'] = array();
                             }
                             
                             
                             if($user_id>0)
                             {
                                 
                               $userType =   $this->M_quotation->getUerType($user_id); 
                               
                               if($userType->user_type==2)
                               {
                                   $this->M_quotation->recordViewCount($user_id,$job_request_id); 
                               }
                                 
                             }
                    }
                    else
                    {
                                $output['status']                                                    =    "0";
                                $output['message']                                                =   "failed";
                                $output['data']                                 =   array();
                                /*$output['service_type_id']                                   =    "";
                                $output['service_type']                                        =    "";
                                $output['job_date']                                               =    "";
                                $output['job_time']                                               =    "";
                                $output['job_validity_date']                               =   "";
                                $output['job_validity_time']                               =    "";
                                $output['job_price_from']                                  =   "";
                                $output['job_price_currency']                          =    "AED";
                                $output['job_price_to']                                       =    "";
                                $output['job_location']                                       =    "";
                                $output['job_longitude']                                    =    "";
                                $output['job_lattitude']                                       =   "";
                                $output['service_type_desc']                                        ="";
                                $output['job_date_time']                                     ="";
                                 $output['price_range']                                      ="";
                                  $output['job_validity']                                  =""; */
                    }
                    
                     echo json_encode($output);exit;
                    
                }
     }
     function setRequestType()
     {
                 $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');
                 $this->form_validation->set_rules('request_type', 'request_type', 'required|numeric');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                    $job_request_id                            =            $this->input->post('job_request_id');                
                    $languageCode                             =            ($this->input->post('language')==2?$this->input->post('language'):1);       
                      if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
                    $result                                             =            $this->M_quotation->setRequestType($_POST,$languageCode); 
                    if($result==1)
                    {
                               $output['status']                =    "1";
                                $output['message']          = $this->lang->line("request_type_done");
                               
                    }
                    else
                    {
                                $output['status']                        =    "0";
                                $output['message'] = $this->lang->line("request_type_failed");
                    }
                    echo json_encode($output);exit;
                }
     }
     function listProvidersForRequest()
     {
                 $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required|numeric');
                 //$this->form_validation->set_rules('longitude', 'longitude', 'required');
                 //$this->form_validation->set_rules('lattitude', 'lattitude', 'required');
                
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                                    $job_request_id                            =            $this->input->post('job_request_id');                
                                    $languageCode                             =            ($this->input->post('language')==2?$this->input->post('language'):1);       
                                    
                                  

$pageLimit   =   $_POST['page_limit']>0?$_POST['page_limit']:20;
$page            =   $_POST['page_no']>0?$_POST['page_no']:1;
$offset                              =         ($page-1) * $pageLimit;  
$_POST['page_limit']                   =        $pageLimit;        
$_POST['page_offset']                =         $offset;        
                                    
                                 if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
                    $result                                             =            $this->M_quotation->listProvidersForRequest($_POST,$languageCode); 
                    if(count($result) >0 )
                    {
                                $output['status']                =    "1";
                                $output['message']            =      "success";
                                $i=0;
                                $providerArray= array();
                            foreach($result as $rows)
                            { 
                                if(!in_array($rows->provider_id,$providerArray))
                                {
                                $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                $output['data'][$i]['service_type_name']    =   $rows->service_type_name!=""?$rows->service_type_name:"";
                                $output['data'][$i]['company_lattitude']                        =   $rows->lattitude!=""?$rows->lattitude:"";
                                $output['data'][$i]['company_longitude']                       =   $rows->longitude!=""?$rows->longitude:"";
                                $output['data'][$i]['company_location']                         =   $rows->location!=""?$rows->location:"";
                                $output['data'][$i]['job_longitude']               =   $rows->job_longitude!=""?$rows->job_longitude:"";
                                $output['data'][$i]['job_lattitude']                =   $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                $output['data'][$i]['job_location']                =   $rows->job_location!=""? $rows->job_location:"";
                                $output['data'][$i]['provider_id']                  =   $rows->provider_id>0?(string)$rows->provider_id:"";
                                $output['data'][$i]['company_name']          =   $rows->company_name!=""?$rows->company_name:"";
                                
                                $output['data'][$i]['user_image']                  =   $rows->user_image!=""?base_url().'uploads/user/'.$rows->user_image:base_url().'uploads/user/dummy_image.png';
                                $output['data'][$i]['rating']                            =    $rows->rating>0?$rows->rating:"0";
                                $output['data'][$i]['distance']                        =   $rows->distance!=""?round($rows->distance,2)." KM":"";
                                $output['data'][$i]['offer']                               =   "0";
                                
                                $providerArray[] = $rows->provider_id>0?(string)$rows->provider_id:"";
                                
                                $i++;
                                }
                            }
                    }
                    else
                    {
                                 $output['status']                 =      "0";
                                 $output['message']            =      "failed";
                                 $output['data']                    =      array();
                    }
                    
                     echo json_encode($output);exit;
               }
     }
     function assignJobToProvider()
     {
                   $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');
                   $this->form_validation->set_rules('provider_id', 'provider_id', 'required|numeric');
               
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                    
                                     $job_request_id                          =            $this->input->post('job_request_id');                
                                     $languageCode                           =            ($this->input->post('language')==2?$this->input->post('language'):1);  
                                          if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
                                    
                                       $input['job_request_id']        =       $job_request_id; 
                                       $input['provider_id']              =       $this->input->post('provider_id');
                                       $input['assigned_date']         =       date("Y-m-d H:i:s");
                                       $input['assign_status']          =       0;
                                     
                                    
                                    $result                                             =            $this->M_quotation->assignJobToProvider($input); 
                                    
                                    if($result>0)
                                    {
                                                 $output['status']                 =      "1";
                                                 $output['message']            =      $this->lang->line("job_assign_done");
                                                 
                                    }
                                    else if($result<0)
                                    {
                                                 $output['status']                 =      "0";
                                                 $output['message']            =      $this->lang->line("job_assign_already");
                                                 
                                    }
                                       else
                                    {
                                                 $output['status']                 =      "0";
                                                 $output['message']            =      $this->lang->line("job_assign_failed");
                                                
                                    }
                                    echo json_encode($output);exit;
                }
     }
     function getJobListForProvider()
     {
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                                                    =           $checkCode ;
                            $_POST['user_id']                                    =           $user_id;
                            $pageLimit                                                =   $_POST['page_limit']>0?$_POST['page_limit']:20;
                            $page                                                         =   $_POST['page_no']>0?$_POST['page_no']:1;
                            $offset                                                       =         ($page-1) * $pageLimit;  
                            $_POST['page_limit']                             =        $pageLimit;        
                            $_POST['page_offset']                           =         $offset;  
                              
                               $result                                                       =            $this->M_quotation->getJobListForProvider($_POST,$languageCode); 
                               
                              if(count($result) >0)
                              {
                                  
                                  $output['status']                =    "1";
                                 $output['message']            =      "success";
                                 $i=0;
                                   foreach($result as $rows)
                                   {
									  
                                        $output['data'][$i]['job_request_id']           =   $rows->job_request_id>0?(string)$rows->job_request_id:"";
                                        $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                        $output['data'][$i]['service_type_name']    =   $rows->service_type_name!=""?$rows->service_type_name:"";                               
                                        $output['data'][$i]['job_request_display_id']           =   $rows->job_request_display_id;
                                        
                                        if($rows->job_location=="")
                                       {
                                           $customerId = $rows->user_id;
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_user->getHomeLocation($customerId,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location:"";
                                       }
                                        
                                        $output['data'][$i]['job_longitude']                =   $longiTude;
                                        $output['data'][$i]['job_lattitude']                =   $latiTude;
                                        $output['data'][$i]['job_location']                 =   $location;
                                        $output['data'][$i]['provider_id']                  =   $rows->provider_id>0?(string)$rows->provider_id:"";            
                                
                                         $output['data'][$i]['user_id']                         =   $rows->user_id>0?(string)$rows->user_id:"";
                                         $output['data'][$i]['assigned_date']                              =   $rows->job_validity_date!=""?date("d-m-Y",strtotime($rows->job_validity_date)):"";
										 $output['data'][$i]['assigned_time']                              =   $rows->job_validity_time!=""?date("h i A",strtotime($rows->job_validity_time)):"";
                                         $output['data'][$i]['job_price_from']                              =   $rows->job_price_from>0?(string)$rows->job_price_from:"";
                                         $output['data'][$i]['job_price_to']                              =   $rows->job_price_to>0?(string)$rows->job_price_to:"";
                                         if($output['data'][$i]['job_price_to']=="")
                                         {
                                         $output['data'][$i]['price_range']                              =   "NA";
                                         }
                                         else
                                         {
                                            $output['data'][$i]['price_range']                          =   "AED ".$output['data'][$i]['job_price_from']."-".$output['data'][$i]['job_price_to'];  
                                         }
                                     if($rows->assign_status==1)
                                       {
                                           $status  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->assign_status==2)
                                       {
                                           $status  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->assign_status==0)
                                       {
                                           $status  =   $this->lang->line("pending");
                                       }
                                         else if($rows->assign_status==3)
                                       {
                                           $status  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->assign_status==4)
                                       {
                                           $status  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $status ="";
                                       }
                                       $output['data'][$i]['provider_response_status_id']                                           =  $rows->assign_status>0?$rows->assign_status:"0";
                                       $output['data'][$i]['provider_response_status']                                     =  $status;
                                       
                                    if($rows->user_response_status==1)
                                       {
                                           $cstatus  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->user_response_status==2)
                                       {
                                           $cstatus  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->user_response_status==0)
                                       {
                                           $cstatus  =   $this->lang->line("pending");
                                       }
                                         else if($rows->user_response_status==3)
                                       {
                                           $cstatus  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->user_response_status==4)
                                       {
                                           $cstatus  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $cstatus ="";
                                       }    
                                       $output['data'][$i]['customer_response_status_id']                                           =  $rows->user_response_status>0? $rows->user_response_status:"0";
                                       $output['data'][$i]['customer_response_status']                                     =  $cstatus;
                                       
                                       $disble  = 0;
                                       if($rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                            $jobStatus = $this->lang->line("rejected");
                                            $disble=1;
                                       }                                       
                                      else if($rows->job_request_status==4 && $rows->user_response_status==1)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           $disble=1;
                                           
                                       }
                                        else if($rows->assign_status==5)
                                       {
                                           
                                           $jobStatus = $this->lang->line("completed");
                                           $disble=1;
                                           
                                       }
                                       else
                                       {
                                            $jobStatus = $this->lang->line("pending");
                                       }
                                       
                                       $output['data'][$i]['display_accept_button']                                     =  "yes";
                                       
                                       if($rows->assign_status==1 || $rows->job_request_status>=2 || $disble==1)
                                       {
                                           
                                          $output['data'][$i]['display_accept_button']                                     =  "no";
                                           
                                       }
 
                                       
                                       $output['data'][$i]['over_all_job_status']                                     =  $jobStatus;
                                       $output['data'][$i]['over_all_job_status_id']                                  =  (string)$rows->job_request_status;
                                       
                                       
                                     $confirmedProvider = $this->M_quotation->getConfirmedProviderDetals($rows->job_request_id); 
                                
                                   $output['data'][$i]['confirmed_provider_id']                                   =  $confirmedProvider->user_id>0?$confirmedProvider->user_id:"";  
                                   if($output['data'][$i]['confirmed_provider_id']>0 && $output['data'][$i]['confirmed_provider_id']==$user_id)
                                   {
                                     $output['data'][$i]['awarded']                                   =  "yes";   
                                   }
                                   else
                                   {
                                       $output['data'][$i]['awarded']                                   =  "no";  
                                   } 
                                       
                                       
                                       
                                       $result2                                                       =            $this->M_quotation->getQuestionsAgainstJobRequest($rows->job_request_id); 
                                       if(count($result2) > 0)
                                       {
                                           $k=0;
                                           foreach($result2 as $rows2)
                                           {
                                                $output['data'][$i]['question_answer'][$k]['question_id']                                =  (string)$rows2->question_id;
                                                $output['data'][$i]['question_answer'][$k]['question']                                     =  $languageCode==2?$rows2->question_arb:$rows2->question;
                                                $output['data'][$i]['question_answer'][$k]['answer_id']                                  =  (string)$rows2->answer_options_id;
                                                $output['data'][$i]['question_answer'][$k]['answer']                                       =  $languageCode==2?$rows2->answer_option:$rows2->answer_option_arabic;
                                               $anseweValue   = $rows2->answer!=""?$rows2->answer:"";
                                                $output['data'][$i]['question_answer'][$k]['answer']                            =   $output['data'][$i]['question_answer'][$k]['answer']!=""?$output['data'][$i]['question_answer'][$k]['answer']:$anseweValue;
                                                $k++;
                                           }
                                           
                                       }
                                       else
                                       {
                                           $output['data'][$i]['question_answer']                                     =  array();
                                       }
                                       $i++;
                                   }
                              }
                              else
                              {
                                    $output['status']                 =      "0";
                                    $output['message']             =      "failed";
                                    $output['data']                    =      array();
                              }
                              
                                  echo json_encode($output);exit;
                        }
                }
         
     }
     function setProviderResponse()
     {
         
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');                   
                 $this->form_validation->set_rules('status', 'status', 'required');  
                 $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');  
                 
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $input['note'] =   trim($this->input->post("note"));    
                             $input['response_status'] =   trim($this->input->post("status"));    
                             $input['provider_id'] =   $checkCode;   
                             $input['job_request_id'] =   $this->common_functions->encryptId($this->input->post("job_request_id")); 
                             $result                                                       =            $this->M_quotation->setProviderResponse($input); 
                               
                              if($result==1)
                              {
                                  
                                          $output['status']                 =    "1";
                                          $output['message']                =     $this->lang->line("provider_respnse_success");
                                          $this->load->model('website/M_request');
                                          $user_Id = $this->M_request->getUserIdFromJobRequest($this->input->post("job_request_id"));
                                          if($user_Id>0)
                                          {
                                               $this->M_request->sendCustomerMail($user_Id,$this->input->post("job_request_id"),$input['response_status'],0);
                                          }
                                    
                              }
                              else if($result==-1)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =      "Job  already cancelled";
                              }
                              else if($result==-2)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed";
                              }
                               else if($result==-3)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already cancelled for the provider";
                              }
                               else if($result==-4)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed for the provider";
                              }
                              else
                              {
                                  $output['status']                 =    "0";
                                  $output['message']            =      $this->lang->line("provider_respnse_fialed");
                              }
                                echo json_encode($output);exit;
                        }
                }
         
     }
     function getJobRequestListForUser()
     {
         
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                                                    =           $checkCode ;
                            $_POST['user_id']                                    =           $user_id;
                            $pageLimit                                                =   $_POST['page_limit']>0?$_POST['page_limit']:5000;
                            $page                                                         =   $_POST['page_no']>0?$_POST['page_no']:1;
                            $offset                                                       =         ($page-1) * $pageLimit;  
                            $_POST['page_limit']                             =        $pageLimit;        
                            $_POST['page_offset']                           =         $offset;  
                              
                            $result                                                     =            $this->M_quotation->getJobListForUser($_POST,$languageCode); 
                               
                              if(count($result) >0)
                              {
                                  
                                  $output['status']                =    "1";
                                 $output['message']            =      "success";
                                 $i=0;
                                   foreach($result as $rows)
                                   {
                                       $output['data'][$i]['job_display_id']           =   $rows->job_request_display_id!=""?$rows->job_request_display_id:"";
                                       $output['data'][$i]['job_request_id']           =   $rows->job_request_id>0?(string)$rows->job_request_id:"";
                                       $output['data'][$i]['service_type_id']          =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                       $output['data'][$i]['service_type_name']        =   $rows->service_type_name!=""?$rows->service_type_name:"";   
                                       
                                        if($rows->job_location=="")
                                       {
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_user->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location:"";
                                       }
                                       $output['data'][$i]['job_longitude']            =   $longiTude;
                                       $output['data'][$i]['job_lattitude']            =   $latiTude;
                                       $output['data'][$i]['job_location']             =   $location;
                                       $output['data'][$i]['provider_id']              =   $rows->provider_id>0?(string)$rows->provider_id:"";            
                                
                                       $output['data'][$i]['user_id']                  =   $rows->user_id>0?(string)$rows->user_id:"";
                                       $output['data'][$i]['assigned_date']                              =   $rows->assigned_date!=""?date("d-m-Y",strtotime($rows->assigned_date)):"";
                                       $output['data'][$i]['job_price_from']                              =   $rows->job_price_from>0?(string)$rows->job_price_from:"";
                                       $output['data'][$i]['job_price_to']                              =   $rows->job_price_to>0?(string)$rows->job_price_to:"";
                                       
                                       if($output['data'][$i]['job_price_from']!="")
                                       {
                                       $output['data'][$i]['price_range']                              =   "AED ".$output['data'][$i]['job_price_from']."-".$output['data'][$i]['job_price_to'];
                                       }
                                       else
                                       {
                                           $output['data'][$i]['price_range']                          ="NA";
                                       }
                                       $output['data'][$i]['city']                 =   $rows->city!=""? $rows->city:"";
                                       $output['data'][$i]['state']                =   $rows->state!=""? $rows->state:"";
                                       $output['data'][$i]['description']          =   $rows->description!=""? $rows->description:"";
                                       $output['data'][$i]['job_date']             =   $rows->job_validity_date!=""? date("d-m-Y",strtotime($rows->job_validity_date)):"";
                                       $output['data'][$i]['job_time']             =   $rows->job_validity_time!=""? date("h i A",strtotime($rows->job_validity_time)):"";
                                       
                                             
                                      
									 $status ="";
                                     $output['data'][$i]['provider_response_status_id']                                           =  "";
                                     $output['data'][$i]['provider_response_status']                                     =  $status;
                                       
                                    if($rows->user_response_status==1)
                                       {
                                           $cstatus  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->user_response_status==2)
                                       {
                                           $cstatus  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->user_response_status==0)
                                       {
                                           $cstatus  =   $this->lang->line("pending");
                                       }
                                         else if($rows->user_response_status==3)
                                       {
                                           $cstatus  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->user_response_status==4)
                                       {
                                           $cstatus  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $cstatus ="";
                                       }  
                                       $cstatus ="";									   
                                       $output['data'][$i]['customer_response_status_id']                                           =  "";
                                       $output['data'][$i]['customer_response_status']                                     =  $cstatus;
                                       
                                       
         if($rows->job_request_status==4 || $rows->job_request_status==5)
        {
            $status = $rows->job_request_status==4?$this->lang->line("confirm"):$this->lang->line("completed");
            $buttonClas = "accept";
            $accePtDisable = "1";
            $rejecttDisable = "1";
        }
        else if($rows->job_request_status==2)
        {
            $status = $this->lang->line("rejected");
            $buttonClas = "reject";
            $accePtDisable = "1";
            $rejecttDisable = "1";
        }
        else
        {
             $status     = $this->lang->line("pending");
             $buttonClas = "pending";
             $accePtDisable = "0";
             $rejecttDisable = "0";
        }
		                       //$output['data'][$i]['disable_cancel']                                     =  $cstatus;
							  // $output['data'][$i]['customer_response_status']                                     =  $cstatus;
		
                               /*
                                       if($rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                            $jobStatus = $this->lang->line("rejected");
                                       }                                       
                                      else if($rows->user_response_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           
                                       }
                                       else
                                       {
                                            $jobStatus = $this->lang->line("pending");
                                       }*/
                                       
                                       $output['data'][$i]['over_all_job_status']                     =  $status;
                                       $output['data'][$i]['over_all_job_status_id']                                     =  (string)$rows->job_request_status;
                                       //$output['data'][$i]['approval_status_d']                       =  $rows->is_approoved==1?"1":"0";
                                      // $output['data'][$i]['approval_status']                       =  $rows->is_approoved==1?"Approved":"Pending Approval";
                                      
                                     if($rows->is_approoved==1)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "1";
                                        $output['data'][$i]['approval_status']                       =   "Approved"; 
                                    }
                                    else if($rows->is_approoved==0)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "0";
                                        $output['data'][$i]['approval_status']                       =   "Pending Approval";
                                    }
                                    else if($rows->is_approoved==-1)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "-1";
                                        $output['data'][$i]['approval_status']                       =   "Refused";
                                    }
                                    else
                                    {
                                         $output['data'][$i]['approval_status_d']                     =   "0";
                                         $output['data'][$i]['approval_status']                       =   "Pending Approval";
                                    }
                                       
                                       
                                       
                                       $result2                                                       =            $this->M_quotation->getQuestionsAgainstJobRequest($rows->job_request_id); 
                                       if(count($result2) > 0)
                                       {
                                           $k=0;
                                           foreach($result2 as $rows2)
                                           {
                                                $output['data'][$i]['question_answer'][$k]['question_id']                                =  (string)$rows2->question_id;
                                                $output['data'][$i]['question_answer'][$k]['question']                                     =  $languageCode==2?$rows2->question_arb:$rows2->question;
                                                $output['data'][$i]['question_answer'][$k]['answer_id']                                  =  (string)$rows2->answer_options_id;
                                                $output['data'][$i]['question_answer'][$k]['answer']                                       =  $languageCode==2?$rows2->answer_option:$rows2->answer_option_arabic;
                                               $anseweValue   = $rows2->answer!=""?$rows2->answer:"";
                                                $output['data'][$i]['question_answer'][$k]['answer']                            =   $output['data'][$i]['question_answer'][$k]['answer']!=""?$output['data'][$i]['question_answer'][$k]['answer']:$anseweValue;
                                                $k++;
                                           }
                                           
                                       }
                                       else
                                       {
                                           $output['data'][$i]['question_answer']                                     =  array();
                                           
                                       }
                                       $i++;
                                   }
                              }
                              else
                              {
                                    $output['status']                 =      "0";
                                    $output['message']                =      "failed";
                                    $output['data']                   =      array();
                              }
                              
                                  echo json_encode($output);exit;
                        }
                }
                
         
         
     }
     function getUserQuotations()
     {
         
                   $languageCode               =   ($this->input->post('language')==2?$this->input->post('language'):1); 
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                                                    =           $checkCode ;
                            $_POST['user_id']                                    =           $user_id;
                            $pageLimit                                                =   $_POST['page_limit']>0?$_POST['page_limit']:20;
                            $page                                                         =   $_POST['page_no']>0?$_POST['page_no']:1;
                            $offset                                                       =         ($page-1) * $pageLimit;  
                            $_POST['page_limit']                             =        $pageLimit;        
                            $_POST['page_offset']                           =         $offset;  
                              
                             $result                                                     =            $this->M_quotation->getUserQuotations($_POST,$languageCode); 
                               
                              // print_r($result);
                              if(count($result) >0)
                              {
                                  
                                  $output['status']                =    "1";
                                 $output['message']            =      "success";
                                 $i=0;
                                   foreach($result as $rows)
                                   {
                                       $output['data'][$i]['job_request_id']           =   $rows->job_request_id>0?(string)$rows->job_request_id:"";
                                       $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                       $output['data'][$i]['service_type_name']    =   $rows->service_type_name!=""?$rows->service_type_name:"";                               
                                       
                                       if($rows->job_location=="")
                                       {
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_user->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location:"";
                                       }
                                       $output['data'][$i]['job_longitude']            =   $longiTude;
                                       $output['data'][$i]['job_lattitude']            =   $latiTude;
                                       $output['data'][$i]['job_location']             =   $location;
                                       $output['data'][$i]['provider_id']                   =   $rows->provider_id>0?(string)$rows->provider_id:"";            
                                
                                         $output['data'][$i]['user_id']                         =   $rows->user_id>0?(string)$rows->user_id:"";
                                         $output['data'][$i]['assigned_date']                              =   $rows->assigned_date!=""?date("d-m-Y",strtotime($rows->assigned_date)):"";
                                         $output['data'][$i]['job_price_from']                              =   $rows->job_price_from>0?(string)$rows->job_price_from:"";
                                         $output['data'][$i]['job_price_to']                              =   $rows->job_price_to>0?(string)$rows->job_price_to:"";
                                         if($rows->job_price_to!="")
                                         {
                                           $output['data'][$i]['price_range']                              =   "AED ".$output['data'][$i]['job_price_from']."-".$output['data'][$i]['job_price_to'];
                                         }
                                         else
                                         {
                                             $output['data'][$i]['price_range']                              = "NA";
                                         }
                                       $offerCount =   $rows->job_request_id>0?$this->M_quotation->getOffersCount($rows->job_request_id):"0"; 
                                       $output['data'][$i]['offer_count']                              =   $offerCount; 
                                       
                                       $output['data'][$i]['city']                 =   $rows->city!=""? $rows->city:"";
                                       $output['data'][$i]['state']                =   $rows->state!=""? $rows->state:"";
                                       $output['data'][$i]['description']                 =   $rows->description!=""? $rows->description:"";
                                       $output['data'][$i]['job_date']             =   $rows->job_validity_date!=""? date("d-m-Y",strtotime($rows->job_validity_date)):"";
                                       $output['data'][$i]['job_time']             =   $rows->job_validity_time!=""?date("h:i A",strtotime($rows->job_validity_time)):"";
                                       if($rows->job_request_status==2)
                                       {
                                           $overalJobStatus = "Cancelled";
                                           $overalJobStatusId = "2";
                                       }
                                       else if($rows->job_request_status==4)
                                       {
                                           $overalJobStatus = "Confirmed";
                                           $overalJobStatusId = "4";
                                       }
                                        else if($rows->job_request_status==5)
                                       {
                                           $overalJobStatus = "Completed";
                                           $overalJobStatusId = "5";
                                       }
                                       else
                                       {
                                           $overalJobStatus   = "Pending";
                                           $overalJobStatusId = "0";
                                       }
                                       
                                       if($rows->job_request_status==2 || $rows->job_request_status==4 || $rows->job_request_status==5)
                                       {
                                           $displayCancel = "no";
                                       }
                                       else
                                       {
                                          $displayCancel = "yes"; 
                                       }
                                       
                                      
                                      // $output['data'][$i]['approval_status_d']                     =   $rows->is_approoved==1?"1":"0";
                                      // $output['data'][$i]['approval_status']                       =   $rows->is_approoved==1?"Approved":"Pending Approval";
                                      if($rows->is_approoved==1)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "1";
                                        $output['data'][$i]['approval_status']                       =   "Approved"; 
                                    }
                                    else if($rows->is_approoved==0)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "0";
                                        $output['data'][$i]['approval_status']                       =   "Pending Approval";
                                    }
                                    else if($rows->is_approoved==-1)
                                    {
                                        $output['data'][$i]['approval_status_d']                     =   "-1";
                                        $output['data'][$i]['approval_status']                       =   "Refused";
                                        $displayCancel = "no";
                                    }
                                    else
                                    {
                                         $output['data'][$i]['approval_status_d']                     =   "0";
                                         $output['data'][$i]['approval_status']                       =   "Pending Approval";
                                    }
                                       $output['data'][$i]['display_cancel_button']                 =   $displayCancel;
                                       $output['data'][$i]['over_all_job_status']                   =   $overalJobStatus;
                                       $output['data'][$i]['over_all_job_status_id']                =   $overalJobStatusId;  
                                       
                                   /*    if($rows->assign_status==1)
                                       {
                                           $status  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->assign_status==2)
                                       {
                                           $status  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->assign_status==0)
                                       {
                                           $status  =   $this->lang->line("pending");
                                       }
                                         else if($rows->assign_status==3)
                                       {
                                           $status  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->assign_status==4)
                                       {
                                           $status  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $status ="";
                                       }
                                       $output['data'][$i]['provider_response_status_id']                                           =  $rows->assign_status>0?$rows->assign_status:"0";
                                       $output['data'][$i]['provider_response_status']                                     =  $status;
                                       
                                    if($rows->user_response_status==1)
                                       {
                                           $cstatus  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->user_response_status==2)
                                       {
                                           $cstatus  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->user_response_status==0)
                                       {
                                           $cstatus  =   $this->lang->line("pending");
                                       }
                                         else if($rows->user_response_status==3)
                                       {
                                           $cstatus  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->user_response_status==4)
                                       {
                                           $cstatus  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $cstatus ="";
                                       }    
                                       $output['data'][$i]['customer_response_status_id']                                           =  $rows->user_response_status>0? $rows->user_response_status:"0";
                                       $output['data'][$i]['customer_response_status']                                     =  $cstatus;
                                       
                                       
                                       if($rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                            $jobStatus = $this->lang->line("rejected");
                                       }                                       
                                      else if($rows->user_response_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           
                                       }
                                       else
                                       {
                                            $jobStatus = $this->lang->line("pending");
                                       }
                                       
                                       $output['data'][$i]['over_all_job_status']                                     =  $jobStatus;
                                       */
                                       
                                       $result2                                                       =            $this->M_quotation->getQuestionsAgainstJobRequest($rows->job_request_id); 
                                       if(count($result2) > 0)
                                       {
                                           $k=0;
                                           foreach($result2 as $rows2)
                                           {
                                                $output['data'][$i]['question_answer'][$k]['question_id']                                =  (string)$rows2->question_id;
                                                $output['data'][$i]['question_answer'][$k]['question']                                     =  $languageCode==2?$rows2->question_arb:$rows2->question;
                                                $output['data'][$i]['question_answer'][$k]['answer_id']                                  =  (string)$rows2->answer_options_id;
                                                $output['data'][$i]['question_answer'][$k]['answer']                                       =  $languageCode==2?$rows2->answer_option:$rows2->answer_option_arabic;
                                               $anseweValue   = $rows2->answer!=""?$rows2->answer:"";
                                                $output['data'][$i]['question_answer'][$k]['answer']                            =   $output['data'][$i]['question_answer'][$k]['answer']!=""?$output['data'][$i]['question_answer'][$k]['answer']:$anseweValue;
                                                $k++;
                                           }
                                           
                                       }
                                       else
                                       {
                                           $output['data'][$i]['question_answer']                                     =  array();
                                       }
                                       $i++;
                                   }
                              }
                              else
                              {
                                    $output['status']                 =      "0";
                                    $output['message']             =      "failed";
                                    $output['data']                    =      array();
                              }
                              
                                  echo json_encode($output);exit;
                        }
                }
                
         
         
     }
     function viewProvidersOffers()
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
                $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required');  
                $this->form_validation->set_rules('longitude', 'longitude', 'required');  
                $this->form_validation->set_rules('lattitude', 'lattitude', 'required');   
                $pageLimit                                                =   $_POST['page_limit']>0?$_POST['page_limit']:20;
                            $page                                                         =   $_POST['page_no']>0?$_POST['page_no']:1;
                            $offset                                                       =         ($page-1) * $pageLimit;  
                            $_POST['page_limit']                             =        $pageLimit;        
                            $_POST['page_offset']                           =         $offset;  
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                     $result                                                      =            $this->M_quotation->viewProvidersOffers($_POST,$languageCode);
                     //print_r($result);
                       if(count($result) >0)
                              {
                                  
                                  $output['status']                =    "1";
                                  $output['message']            =      "success";
                                  $i=0;
                                   foreach($result as $rows)
                                   {
                                        $output['data'][$i]['job_request_id']            =   $rows->job_request_id>0?(string)$rows->job_request_id:"";
                                        $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                        $output['data'][$i]['service_type_name']    =   $rows->service_type_name!=""?$rows->service_type_name:"";                               
                                        $output['data'][$i]['job_longitude']              =   $rows->job_longitude!=""?$rows->job_longitude:"";
                                        $output['data'][$i]['job_lattitude']                =   $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                        $output['data'][$i]['job_location']                 =   $rows->job_location!=""? $rows->job_location:"";
                                        $output['data'][$i]['provider_id']                   =   $rows->provider_id>0?(string)$rows->provider_id:"";    
                                        $output['data'][$i]['provider_name']            =   $rows->company_name!=""?$rows->company_name:"";   
                                        
                                        $output['data'][$i]['provider_image']            =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:"";  
                                        $output['data'][$i]['provider_longitude']              =   $rows->longitude!=""?$rows->longitude:"";
                                        $output['data'][$i]['provider_lattitude']                =   $rows->lattitude!=""?$rows->lattitude:"";
                                        $output['data'][$i]['provider_location']                 =   $rows->location!=""? $rows->location:"";
                                        $output['data'][$i]['marked_price']              =   $rows->provider_amount>0?$this->config->item("currency")." ".$rows->provider_amount:"";
                                        $output['data'][$i]['provider_doc']              =   $rows->document_name!=""?base_url()."uploads/quotations/".$rows->document_name:"";
                                
                                         //$output['data'][$i]['user_id']                         =   $rows->user_id>0?(string)$rows->user_id:"";
                                         $output['data'][$i]['assigned_date']                 =   $rows->assigned_date!=""?date("d-m-Y",strtotime($rows->assigned_date)):"";
                                       
                                       
                                      if($rows->assign_status==1)
                                       {
                                           $status  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->assign_status==2)
                                       {
                                           $status  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->assign_status==0)
                                       {
                                           $status  =   $this->lang->line("pending");
                                       }
                                         else if($rows->assign_status==3)
                                       {
                                           $status  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->assign_status==4)
                                       {
                                           $status  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $status ="";
                                       }
                                      // $output['data'][$i]['provider_response_status_id']                                           =  $rows->assign_status>0?$rows->assign_status:"0";
                                       $output['data'][$i]['provider_response_status']                                     =  $status;
                                       $output['data'][$i]['rating']                            =    $rows->rating>0?$rows->rating:"0";
                                       $ratingCount =   $rows->provider_id>0?$this->M_quotation->getTotalRating($rows->provider_id):"0"; 
                                       $output['data'][$i]['total_ratings']                              =   $ratingCount; 
                                         
                                    if($rows->user_response_status==1)
                                       {
                                           $cstatus  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->user_response_status==2)
                                       {
                                           $cstatus  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->user_response_status==0)
                                       {
                                           $cstatus  =   $this->lang->line("pending");
                                       }
                                         else if($rows->user_response_status==3)
                                       {
                                           $cstatus  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->user_response_status==4)
                                       {
                                           $cstatus  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $cstatus ="";
                                       }    
                                       $output['data'][$i]['customer_response_status_id']                                           =  $rows->user_response_status>0? $rows->user_response_status:"0";
                                       $output['data'][$i]['customer_response_status']                                     =  $cstatus;
                                      
                                       $jobStatus = $this->lang->line("pending");
                                       $disableFurther=0;
                                       $statusId  =0;
                                       if($rows->assign_status==1)
                                       {
                                            $jobStatus = "Accepted";
                                            $statusId = "1";
                                       }
                                        if($rows->assign_status==3)
                                       {
                                            $jobStatus = "Price Marked";
                                            $statusId = "3";
                                       }
                                       if($rows->job_request_status==5 && $rows->user_response_status==1)
                                       {
                                           $jobStatus = $this->lang->line("completed");
                                           $disableFurther =1;
                                           $statusId = "5";
                                       }
                                     if($rows->job_request_status==4 && $rows->user_response_status==1)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           $disableFurther =1;
                                           $statusId = "4";
                                       }
                                        if($rows->job_request_status==2 || $rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                           $disableFurther =1;
                                           $statusId = "2";
                                       }
                                      
									   $displayApprove ="no";
									   $displayCancel ="no";
									   //echo $disableFurther;
									   
									   	if($rows->job_request_status!=4 && $rows->job_request_status!=5 && $rows->job_request_status!=2  && $disableFurther!=1)
								      { 
										    
								        if($rows->assign_status==1)
										{
											$displayApprove ="yes";
										}
					
					                      $displayCancel ="yes";
									   }
									   $output['data'][$i]['provider_response_status_id']                               =  $statusId;
									   $output['data'][$i]['display_cancel_button']                                     =  $displayCancel;
									   $output['data'][$i]['display_approve_button']                                    =  $displayApprove;
                                       $output['data'][$i]['provider_response_status']                                  =  $jobStatus;
                                       $output['data'][$i]['over_all_job_status']                                       =  $jobStatus;
                                       $output['data'][$i]['distance']                                                  =  $rows->distance!=""?round($rows->distance,2)." KM":"";
                                       
                                    
                                       $i++;
                                   }
                              }
                              else
                              {
                                    $output['status']                 =      "0";
                                    $output['message']             =      "failed";
                                    $output['data']                    =      array();
                              }
                              
                                  echo json_encode($output);exit;
                     
                     
                   
                }
     }
     function setUserResponse()
     {
         
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');                   
                 $this->form_validation->set_rules('status', 'status', 'required');  
                 $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');  
               //  $this->form_validation->set_rules('provider_id', 'provider_id', 'required|numeric');  
               
               if($_POST['provider_id']<=0 && $_POST['status']==1)
               {
                    $output['status']            =          "0";
                    $output['message']           =           "provider_id is mandatory for confirm";                    
                    echo json_encode($output);exit;
               }
                
                 
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $input['note']                     =   trim($this->input->post("note"));    
                             $input['response_status']          =   trim($this->input->post("status"));    
                             $input['user_id']                  =   $checkCode;   
                                     
                             
                             
                             $input['provider_id']              =   trim($this->input->post("provider_id"));   
                             $input['job_request_id']           =   $this->common_functions->encryptId($this->input->post("job_request_id")); 
                             $result                            =   $this->M_quotation->setUserResponse($input); 
                               
                              if($result>0)
                              {
                                  
                                   $output['status']                 =    "1";
                                   $output['message']            =     $this->lang->line("user_respnse_success");
                                  
                                   $user_Id  = $input['provider_id'];
                              
                                  if($user_Id>0)
                                  {
                                       $this->load->model('website/M_request');
                                       $this->M_request->sendProviderMail($user_Id,$input['job_request_id'],$input['response_status'],0);
                                       if($_POST['status']==1)
                                       {
                                           $this->M_request->sendCustomerMailConfirmation($input['user_id'],$input['job_request_id'],$input['response_status'],0);
                                       }
                                  }
                                  
                              }
                              else if($result==-1)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =      "Job  already cancelled";
                              }
                              else if($result==-2)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed";
                              }
                               else if($result==-3)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already cancelled for the provider";
                              }
                               else if($result==-4)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed for the provider";
                              }
                              else
                              {
                                  $output['status']                 =    "0";
                                  $output['message']            =      $this->lang->line("user_respnse_fialed");
                              }
                                echo json_encode($output);exit;
                        }
                }
         
     }
     function getProvidersQuotations()
     {
         
         
                   $languageCode               =   ($this->input->post('language')==2?$this->input->post('language'):1); 
         
                 $this->form_validation->set_rules('access_token', 'access_token', 'required');
                   
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
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
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                             $user_id                                                    =           $checkCode ;
                            $_POST['user_id']                                    =           $user_id;
                            $pageLimit                                                =   $_POST['page_limit']>0?$_POST['page_limit']:20;
                            $page                                                         =   $_POST['page_no']>0?$_POST['page_no']:1;
                            $offset                                                       =         ($page-1) * $pageLimit;  
                            $_POST['page_limit']                             =        $pageLimit;        
                            $_POST['page_offset']                           =         $offset;  
                              
                             $result                                                     =            $this->M_quotation->getProvidersQuotations($_POST,$languageCode); 
                              // print_r($result);
                              if(count($result) >0)
                              {
                                  
                                  $output['status']                =    "1";
                                 $output['message']            =      "success";
                                 $i=0;
                                   foreach($result as $rows)
                                   {
                                        $output['data'][$i]['job_request_id']            =   $rows->job_request_id>0?(string)$rows->job_request_id:"";
                                        $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                        $output['data'][$i]['service_type_name']         =   $rows->service_type_name!=""?$rows->service_type_name:"";                               
                                       // $output['data'][$i]['job_longitude']             =   $rows->job_longitude!=""?$rows->job_longitude:"";
                                       // $output['data'][$i]['job_lattitude']             =   $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                        //$output['data'][$i]['job_location']              =   $rows->job_location!=""? $rows->job_location:"";
                                        
                                        $isRead = $this->M_quotation->isReadRequest($rows->job_request_id,$user_id);
                                        $output['data'][$i]['is_new_request']         =   $isRead>0?"no":"yes";
                                        
                                      if($rows->job_location=="")
                                       {
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_user->getHomeLocation($rows->user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location:"";
                                       }
                                       $output['data'][$i]['job_longitude']            =   $longiTude;
                                       $output['data'][$i]['job_lattitude']            =   $latiTude;
                                       $output['data'][$i]['job_location']             =   $location;  
                                        
                                      //  $output['data'][$i]['provider_id']                   =   $rows->provider_id>0?(string)$rows->provider_id:"";            
                                
                                         $output['data'][$i]['user_id']                         =   $rows->user_id>0?(string)$rows->user_id:"";
                                         $output['data'][$i]['assigned_date']                              =   $rows->assigned_date!=""?date("d-m-Y",strtotime($rows->assigned_date)):"";
                                         $output['data'][$i]['job_price_from']                              =   $rows->job_price_from>0?(string)$rows->job_price_from:"";
                                         $output['data'][$i]['job_price_to']                              =   $rows->job_price_to>0?(string)$rows->job_price_to:"";
                                         //$output['data'][$i]['price_range']                              =   "AED ".$output['data'][$i]['job_price_from']."-".$output['data'][$i]['job_price_to'];
                                          if($rows->job_price_to!="")
                                         {
                                           $output['data'][$i]['price_range']                              =   "AED ".$output['data'][$i]['job_price_from']."-".$output['data'][$i]['job_price_to'];
                                         }
                                         else
                                         {
                                             $output['data'][$i]['price_range']                              = "NA";
                                         }
                                       $offerCount =   $rows->job_request_id>0?$this->M_quotation->getOffersCount($rows->job_request_id):"0"; 
                                       $output['data'][$i]['offer_count']                              =   $offerCount; 
                                      if($rows->assign_status==1)
                                       {
                                           $status  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->assign_status==2)
                                       {
                                           $status  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->assign_status==0)
                                       {
                                           $status  =   $this->lang->line("pending");
                                       }
                                         else if($rows->assign_status==3)
                                       {
                                           $status  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->assign_status==4)
                                       {
                                           $status  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $status ="";
                                       }
                                       $output['data'][$i]['provider_response_status_id']                                           =  $rows->assign_status>0?$rows->assign_status:"0";
                                       $output['data'][$i]['provider_response_status']                                     =  $status;
                                       
                                    if($rows->user_response_status==1)
                                       {
                                           $cstatus  =   $this->lang->line("confirm");
                                       }
                                       else if($rows->user_response_status==2)
                                       {
                                           $cstatus  =   $this->lang->line("rejected");
                                       }
                                       else if($rows->user_response_status==0)
                                       {
                                           $cstatus  =   $this->lang->line("pending");
                                       }
                                         else if($rows->user_response_status==3)
                                       {
                                           $cstatus  =   $this->lang->line("price_marked");
                                       }
                                         else if($rows->user_response_status==4)
                                       {
                                           $cstatus  =   $this->lang->line("approved");
                                       }
                                       else
                                       {
                                           $cstatus ="";
                                       }    
                                       $output['data'][$i]['customer_response_status_id']                                           =  $rows->user_response_status>0? $rows->user_response_status:"0";
                                       $output['data'][$i]['customer_response_status']                                     =  $cstatus;
                                       
                                       
                                       if($rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                            $jobStatus = $this->lang->line("rejected");
                                       }                                       
                                      else if($rows->user_response_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           
                                       }
                                       else if($rows->assign_status==5)
                                       {
                                           $jobStatus = $this->lang->line("completed");
                                           
                                       }
                                       else
                                       {
                                            $jobStatus = $this->lang->line("pending");
                                       }
                                       
                                       
                                    $confirmedProvider = $this->M_quotation->getConfirmedProviderDetals($rows->job_request_id); 
                                
                                   $output['data'][$i]['confirmed_provider_id']                                   =  $confirmedProvider->user_id>0?$confirmedProvider->user_id:"";  
                                   if($output['data'][$i]['confirmed_provider_id']>0 && $output['data'][$i]['confirmed_provider_id']==$user_id)
                                   {
                                     $output['data'][$i]['awarded']                                   =  "yes";   
                                   }
                                   else
                                   {
                                       $output['data'][$i]['awarded']                                   =  "no";  
                                   }
                                       
                                      
                                       
                                       $output['data'][$i]['over_all_job_status']                            =   $jobStatus;
                                       $output['data'][$i]['over_all_job_status_id']                         =   (string)$rows->job_request_status;
                                       $output['data'][$i]['job_validity_date']                              =   $rows->job_validity_date!=""?date("d-m-Y",strtotime($rows->job_validity_date)):"";
                                       $output['data'][$i]['job_validity_time']                              =   $rows->job_validity_time!=""?date("h i A",strtotime($rows->job_validity_time)):"";
                                       
                                       
                                       $result2                                                       =            $this->M_quotation->getQuestionsAgainstJobRequest($rows->job_request_id); 
                                       if(count($result2) > 0)
                                       {
                                           $k=0;
                                           foreach($result2 as $rows2)
                                           {
                                                $output['data'][$i]['question_answer'][$k]['question_id']                                =  (string)$rows2->question_id;
                                                $output['data'][$i]['question_answer'][$k]['question']                                     =  $languageCode==2?$rows2->question_arb:$rows2->question;
                                                $output['data'][$i]['question_answer'][$k]['answer_id']                                  =  (string)$rows2->answer_options_id;
                                                $output['data'][$i]['question_answer'][$k]['answer']                                       =  $languageCode==2?$rows2->answer_option:$rows2->answer_option_arabic;
                                                $anseweValue   = $rows2->answer!=""?$rows2->answer:"";
                                                $output['data'][$i]['question_answer'][$k]['answer']                            =   $output['data'][$i]['question_answer'][$k]['answer']!=""?$output['data'][$i]['question_answer'][$k]['answer']:$anseweValue;
                                                $k++;
                                           }
                                           
                                       }
                                       else
                                       {
                                           $output['data'][$i]['question_answer']                                     =  array();
                                       }
                                       $i++;
                                   }
                              }
                              else
                              {
                                    $output['status']                 =      "0";
                                    $output['message']             =      "failed";
                                    $output['data']                    =      array();
                              }
                              
                                  echo json_encode($output);exit;
                        }
                }
                
         
         
         
     }
     function markPrice()
     {
         
               $languageCode               =   ($this->input->post('language')==2?$this->input->post('language'):1); 
         
                $this->form_validation->set_rules('access_token', 'access_token', 'required');
                $this->form_validation->set_rules('price', 'price', 'required|callback_weight_check');  
                $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');  
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']            =          "0";
                    $output['message']       =           strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                { 
                       $languageCode                =   ($this->input->post('language')==2?$this->input->post('language'):1); 
                       if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
                    $acces_token                  =   trim($this->input->post("access_token"));    
                    $checkCode                     =   $this->common_functions->validateAccessToken($acces_token);               
                        if($checkCode<=0)
                        {
                               echo $userId        =     $this->common_functions->showAccessTokenErrorMesssage($checkCode,$languageCode);
                               exit;
                        }
                        else
                        {
                               $user_id                                                     =           $checkCode ;
                              $_POST['provider_id']                                    =           $user_id;
                                if($_FILES["document"]["name"]!="")
	          {
	               $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                    $filename2 = $_FILES["document"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);                        
                                    $config2['upload_path']          =   $this->config->item('upload_path').'quotations/';
                                    $config2['allowed_types']       =   'gif|jpg|png|jpeg|pdf|doc';                                                 
                                    $config2['file_name']               =    $randomNo.".".$file_ext2;                    
	               $this->load->library('upload', $config2);
                                  if ( ! $this->upload->do_upload('document'))
                                   {
                                      
                                        $data['status'] = "0";
                                        $data['errors'] = array(
                                         'document_name' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $_POST['document_name']                 =   $config2['file_name'];
                                     
                                   }
				 
	            }
                    
                               $result                                                       =            $this->M_quotation->markPrice($_POST);
                               
                                if($result==1)
                              {
                                  
                                    $output['status']             =    "1";
                                    $output['message']            =     $this->lang->line("provider_respnse_success");
                                    $job_request_id               =     $this->input->post("job_request_id");
                                    $this->load->model('website/M_request'); 
                                    $user_Id                      =     $this->M_request->getUserIdFromJobRequest($job_request_id);
                                    if($user_Id>0)
                                    {
                                       $this->M_request->sendCustomerMail($user_Id,$job_request_id,3,0);
                                    }
                              }
                              else if($result==-5)
                              {
                                  $output['status']                 =    "0";
                                  $output['message']            =      $this->lang->line("price_already");
                              }
                              else if($result==-1)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =      "Job  already cancelled";
                              }
                              else if($result==-2)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed";
                              }
                               else if($result==-3)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already cancelled for the provider";
                              }
                               else if($result==-4)
                              {
                                  $output['status']             =    "0";
                                  $output['message']            =     "Job  already confirmed for the provider";
                              }
                              else
                              {
                                  $output['status']                 =    "0";
                                  $output['message']            =      $this->lang->line("provider_respnse_fialed");
                              }
                                echo json_encode($output);exit;
                              
                        }
                }
     }
     function getHomePageServices()
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
                            
                            
                       $con['service_type_language_code']   = $languageCode;
                       $con['is_home_category']   = 1;
                       $con['service_type_status']   = 1;
                       
                $constServices =   $this->M_admin->getServiceTypes($con);  
                $output['status']       =  "1";
	            $output['message']      =  "success"; 
	            
	            $conLabe['home_labels_status'] =1;
	            $labels =   $this->M_admin->getHomeLabels($conLabe);  
	            
	            
	           // $constServices =   $this->M_quotation->getMaintenanceServiceTypes($languageCode);  
	            
	            $output['data']['category_title'][0]['title']      = $languageCode==2?$labels->home_labels_arabic1:$labels->home_labels1;
	            $output['data']['category_title'][0]['id']         = "1";
	            $output['data']['category_title'][1]['title']      = $languageCode==2?$labels->home_labels2_arabic:$labels->home_labels2;
	            $output['data']['category_title'][1]['id']         = "2";
	            
                if (count($constServices)>0) 
	        {
	           
	            $i = 0;
                foreach ($constServices as $row)
                {

                    $output['data']['construction'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                    $output['data']['construction'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:"";
                    $output['data']['construction'][$i]['icon']         = ($row->service_type_icon!="")?base_url().'uploads/service_type/'.$row->service_type_icon:"";
                    $output['data']['construction'][$i]['banner']    = ($row->service_type_banner_image!="")?base_url().'uploads/service_type/'.$row->service_type_banner_image:"";
                    $output['data']['construction'][$i]['main_label']      = ($row->main_label!="")?$row->main_label:"";
                    $output['data']['construction'][$i]['sub_label']                     = ($row->sub_label!="")?$row->sub_label:"";
                    $output['data']['construction'][$i]['service_type_desc']      = ($row->service_type_desc!="")?$row->service_type_desc:"";
                    $output['data']['construction'][$i]['has_child']      =  $this->M_user->checkServiceTypeChildExist($row->service_type_id)>0?"1":"0";
                    $output['data']['construction'][$i]['service_type_thumbnail']    = ($row->service_type_thumbnail!="")?base_url().'uploads/service_type/'.$row->service_type_thumbnail:"";
                    $output['data']['construction'][$i]['is_home']      = "1"; 
                            
                        $i++;
                }
	        }
	        else
	        {  
	           // $output['status']       =     "0";
	           // $output['message']      =  "failed";
	            $output['data']['construction']         =  array();
	        }
	        
	         $con = array();
	         $constServices = array();
	         $con['service_type_language_code']   = $languageCode;
             $con['is_home_category']   = 0;
             $con['service_type_status']   = 1;
             $con['service_key_word']   = $_POST['key_word'];
             $con['city_id']   = $_POST['city_id'];
                       
             $constServices =   $this->M_admin->filterServiceType($con); 
             
          //   $constServices =   $this->M_quotation->getPopularServiceTypes($languageCode); 
              
                if (count($constServices)>0) 
	        {
	           
	            $i = 0;
                foreach ($constServices as $row)
                {

                    $output['data']['popular'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                    $output['data']['popular'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:"";
                    $output['data']['popular'][$i]['icon']         = ($row->service_type_icon!="")?base_url().'uploads/service_type/'.$row->service_type_icon:"";
                    $output['data']['popular'][$i]['banner']    = ($row->service_type_banner_image!="")?base_url().'uploads/service_type/'.$row->service_type_banner_image:"";
                    $output['data']['popular'][$i]['main_label']      = ($row->main_label!="")?$row->main_label:"";
                    $output['data']['popular'][$i]['sub_label']                     = ($row->sub_label!="")?$row->sub_label:"";
                    $output['data']['popular'][$i]['service_type_desc']      = ($row->service_type_desc!="")?$row->service_type_desc:"";
                    $output['data']['popular'][$i]['has_child']      =  $this->M_user->checkServiceTypeChildExist($row->service_type_id)>0?"1":"0";
                    $output['data']['popular'][$i]['service_type_thumbnail']    = ($row->service_type_thumbnail!="")?base_url().'uploads/service_type/'.$row->service_type_thumbnail:"";
                    $output['data']['popular'][$i]['is_home']      = "0"; 
                            
                        $i++;
                }
	        }
	        else
	        {  
	           // $output['status']       =     "0";
	            //$output['message']      =  "failed";
	            $output['data']['popular']         =  array();
	        }
	        
	        
	          $result =   $this->M_admin->getActiveBanner($con);
	          
	       if (count($result)>0) 
	        {
	            $i=0;
	            foreach($result  as $banner)
	            {
	             $output['data']['banner'][$i]['link_url']          = ($banner->banner_url!="")?$banner->banner_url:"";
	             $output['data']['banner'][$i]['title']             = ($banner->banner_title!="")?$banner->banner_title:"";
	             $output['data']['banner'][$i]['title_arabic']      = ($banner->banner_title_arabic!="")?$banner->banner_title_arabic:"";
	             $output['data']['banner'][$i]['banner_image']      = ($banner->banner_image!="")?base_url()."uploads/banner/".$banner->banner_image:"";
	             
	             $i++;
	            }
	        }
	        else
	        {
	             $output['data']['banner']         =  array();
	        }
	        
	        echo json_encode($output);exit;
                            
     }
     function getQuestionSingle()
     {
         
                 $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required|numeric');
                 
                 $parentQuestionId = $_POST['previous_question_id']>0?$_POST['previous_question_id']:0;
                 $parentAnswerId   = $_POST['previous_answer_id']>0?$_POST['previous_answer_id']:0;
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                     $output['status']              =       "1";
                                                 $output['message']          =      "success";
                    
                    $languageCode         =   ($this->input->post('language')==2?$this->input->post('language'):1); 
                    $serviceTypeId          =   $this->input->post('service_type_id');
                    $rows                         =   $this->M_quotation->getQuestionsSingle($serviceTypeId,$parentQuestionId,$parentAnswerId);
                    
                    //print_r($result);exit;
                    if(count($rows) > 0)
                    {
                                                
                                                 $i=0;
                                                
                                                     $output['data']['question']['id']          =    $rows->question_id;
                                                     $output['data']['question']['name']                =   $languageCode==2?$rows->question_arb:$rows->question;
                                                     $output['data']['question']['input_type']                =   $rows->form_control_name;
                                                     
                                                     $answers                         =    $this->M_quotation->getAnswerOptions($rows->question_id);
                                                     if(count($answers) >0 )
                                                     {
                                                         $k=0;
                                                         foreach($answers as $rows2)
                                                         {
                                                          $output['data']['options'][$k]["id"]               =   $rows2->answer_options_id;
                                                          $output['data']['options'][$k]["name"]        =   $languageCode==2?$rows2->answer_option_arabic:$rows2->answer_option;
                                                          
                                                          $k++;
                                                         }
                                                     }
                                                     else
                                                     {
                                                         $output['data']['options']               =          array();
                                                     }
                                                     
                                                
                                                 
                                                 
                    }
                    else
                    {
                                               $output['status']              =       "0";
                                                 $output['message']          =      "failed";
                                           $output['data']['question'] = new stdClass();
                                           $output['data']['options']               =          array();
                    }
                                 echo json_encode($output);exit;  
                }
     }
     function getProviderDetails()
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
                            
                              $this->form_validation->set_rules('provider_id', 'provider_id', 'required|numeric');
                              $this->form_validation->set_rules('longitude', 'longitude', 'required|numeric');
                              $this->form_validation->set_rules('lattitude', 'lattitude', 'required|numeric');
                              
                              $lattitude = $this->input->post('lattitude');
                              $longitude = $this->input->post('longitude');
             
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                    $this->load->model('website/M_common');   
                    
                     $providerId     =    $this->input->post('provider_id'); 
                     
                     $basic_details  =  $this->M_quotation->getProviderDetails($providerId,$longitude,$lattitude); 
                              
                     $ratings        =  $this->M_common->getAllRatings($providerId);      
                     
                     $services       =  $this->M_common->getAllServiceTypesForProvider($providerId);  
                     
                     
                    $data =$services->array_agg;
                                $data=str_replace('{',"",$data);
                                 $data=str_replace('}',"",$data);
                                $data=str_replace('"',"",$data);
                                  $services_offered = $data;
                     
                     
                    $output['status']   =  "1";
                    $output['message']  =  "success";  
                    $profileImage    =   $basic_details->user_image!=""?base_url()."uploads/user/".$basic_details->user_image:base_url()."images/logo.png";  
                    $output['data']['company_logo'] =     $profileImage;
                    $output['data']['company_name'] =     $basic_details->company_name!=""?$basic_details->company_name:"";
                    $output['data']['rating']       =     $basic_details->rating!=""?$basic_details->rating:"0";
                    $output['data']['rating_count'] =     (string)count($ratings);
                    $output['data']['phone_no']     =     "+".$basic_details->user_dial_code."-".$basic_details->user_phone;
                    $output['data']['contact_person'] =     $basic_details->user_first_name." ".$basic_details->user_last_name;
                    $output['data']['location'] =     $basic_details->location!=""?$basic_details->location:"";
                    $output['data']['services_offered'] =     $services_offered!=""?$services_offered:"";
                    $output['data']['provider_id']  =     $basic_details->user_id!=""?(string)$basic_details->user_id:"";
                    $output['data']['established'] =    "";
                    $output['data']['distance'] =    round($basic_details->distance,2)." KM";
                    $output['data']['profile_document']=$basic_details->profile_document!=""?base_url().'uploads/user/'.$basic_details->profile_document:"";
                    $output['data']['website_url']=$basic_details->website_url!=""?$basic_details->website_url:"";
                    if(count($ratings) > 0)
                    {
                        $i=0;
                     foreach($ratings as $rows)
                                     {
                                        $output['data']['rating_feedback'][$i]['rating'] = $rows->user_rating;
                                        $output['data']['rating_feedback'][$i]['user_name'] = $rows->user_first_name." ".$rows->user_last_name;
                                        $output['data']['rating_feedback'][$i]['feed_back'] = $rows->feed_back;
                                        $i++; 
                                     }
                    }
                    else
                    {
                         $output['data']['rating_feedback'] =    array();
                    }
                    
                }
         echo json_encode($output);exit;
     }
     function getRespondedProviders()
     {
                              $this->form_validation->set_rules('job_request_id', 'job_request_id', 'required|numeric');
                             
                            
             
   
                if ($this->form_validation->run() == FALSE)
                { 
                    $output['status']   =  "0";
                    $output['message']  =  strip_tags(validation_errors());                    
                    echo json_encode($output);exit;
                }
                else
                {
                     $languageCode                             =            ($this->input->post('language')==2?$this->input->post('language'):1); 
                      if($languageCode==2)
                            {
                                 $this->lang->load("message","arabic");
                            }
                            else
                            {
                                  $this->lang->load("message","english");
                            }
                    $result                                             =            $this->M_quotation->getRespondedProviders($_POST['job_request_id'],$languageCode); 
                   // print_r($result);
                    
                    if(count($result) >0 )
                    {
                                $output['status']                =    "1";
                                $output['message']            =      "success";
                                $i=0;
                                $providerArray= array();
                            foreach($result as $rows)
                            { 
                                if(!in_array($rows->provider_id,$providerArray))
                                {
                                $output['data'][$i]['service_type_id']           =   $rows->service_type_id>0?(string)$rows->service_type_id:"";
                                $output['data'][$i]['service_type_name']    =   $rows->service_type_name!=""?$rows->service_type_name:"";
                                $output['data'][$i]['company_lattitude']                        =   $rows->lattitude!=""?$rows->lattitude:"";
                                $output['data'][$i]['company_longitude']                       =   $rows->longitude!=""?$rows->longitude:"";
                                $output['data'][$i]['company_location']                         =   $rows->location!=""?$rows->location:"";
                                $output['data'][$i]['job_longitude']               =   $rows->job_longitude!=""?$rows->job_longitude:"";
                                $output['data'][$i]['job_lattitude']                =   $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                $output['data'][$i]['job_location']                =   $rows->job_location!=""? $rows->job_location:"";
                                $output['data'][$i]['provider_id']                  =   $rows->provider_id>0?(string)$rows->provider_id:"";
                                $output['data'][$i]['company_name']          =   $rows->company_name!=""?$rows->company_name:"";
                                
                                $output['data'][$i]['user_image']                  =   $rows->user_image!=""?base_url().'uploads/user/'.$rows->user_image:base_url().'uploads/user/dummy_image.png';
                                $output['data'][$i]['rating']                            =    $rows->rating>0?$rows->rating:"0";
                                $output['data'][$i]['distance']                        =   $rows->distance!=""?round($rows->distance,2)." KM":"";
                                $output['data'][$i]['offer']                               =   "0";
                                $output['data'][$i]['response_status_id']                   =  $rows->assign_status;
                                
                                $disableFurther =0;
                                
                                if($rows->job_request_status==4 && $rows->user_response_status==1)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                           $disableFurther =1;
                                       }
                                       else if($rows->job_request_status==2 || $rows->user_response_status==2 || $rows->assign_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                           $disableFurther =1;
                                       }
                                       else
                                       {
                                           $jobStatus = $this->lang->line("pending");
                                       }
									   
									   $displayApprove        ="no";
									   $displayCancel         ="no";
									   $displayQuotationPrice ="no";
									  // echo $rows->user_response_status.$disableFurther;exit;
									   //echo $disableFurther."-".$rows->job_request_status;
									   if($rows->job_request_status!=4 && $rows->job_request_status!=2 && $rows->job_request_status!=5 && $disableFurther!=1)
									   { 
                                                               if($rows->assign_status==3 && $rows->user_reponse_status!=2)
                                                                {
                                            						$displayApprove ="yes";
                                            						$displayQuotationPrice ="yes";
                                            					}
                                            					
                        					$displayCancel ="yes";
                                				/*	if($rows->assign_status==2 || $rows->user_response_status==2)
                                                    {
                                                        $displayCancel ="no";
                                                    }*/
									   }
									   if($rows->provider_amount!="")
									   {
									       $displayQuotationPrice ="yes";
									   }
								$output['data'][$i]['provider_doc']                                              =  $rows->document_name!=""?base_url()."uploads/quotations/".$rows->document_name:"";
                                $output['data'][$i]['display_marked_price']                                      =  $displayQuotationPrice;
                                $output['data'][$i]['marked_price']                                              =  $rows->provider_amount>0?$rows->provider_amount:"";
							    $output['data'][$i]['display_cancel_button']                                     =  $displayCancel;
								$output['data'][$i]['display_approve_button']                                    =  $displayApprove;
                                $output['data'][$i]['response_status']                   =  $jobStatus;
                                $providerArray[] = $rows->provider_id>0?(string)$rows->provider_id:"";
                                
                                $i++;
                                }
                            }
                    }
                    else
                    {
                                 $output['status']                 =      "0";
                                 $output['message']            =      "failed";
                                 $output['data']                    =      array();
                    }
                    
                     echo json_encode($output);exit;
                }
     }
     function getDynamicCategoryLabel()
     {
                                $output['status']                               =        "1";
                                $output['message']                              =         "success";
                                $output["data"]["category_label1"]              =        "Popular Services";
                                $output["data"]["category_label2"]              =        "Maintenance Services";
                                echo json_encode($output);exit;
     }    
     function searchServiceType()
     {  
             $languageCode         =   ($this->input->post('language')==2?$this->input->post('language'):1); 
             $con = array();
	         $constServices = array();
	         $con['service_type_language_code']   = $languageCode;
             $con['service_type_status']   = 1;
             $con['service_key_word']   = $_POST['key_word'];
             $con['city_id']   = $_POST['city_id'];
                       
             $constServices =   $this->M_quotation->searchServiceType($con); 
             
          
              
              if (count($constServices)>0) 
	        {
	            $output['status']       =  "1";
	            $output['message']      =  "success";
	            $i = 0;
                foreach ($constServices as $row)
                {

                    $output['data']['popular'][$i]['name']      = ($row->service_type_name!="")?$row->service_type_name:"";
                    $output['data']['popular'][$i]['id']             = ($row->service_type_id!="")?$row->service_type_id:"";
                    $output['data']['popular'][$i]['icon']         = ($row->service_type_icon!="")?base_url().'uploads/service_type/'.$row->service_type_icon:"";
                    $output['data']['popular'][$i]['banner']    = ($row->service_type_banner_image!="")?base_url().'uploads/service_type/'.$row->service_type_banner_image:"";
                    $output['data']['popular'][$i]['main_label']      = ($row->main_label!="")?$row->main_label:"";
                    $output['data']['popular'][$i]['sub_label']                     = ($row->sub_label!="")?$row->sub_label:"";
                    $output['data']['popular'][$i]['service_type_desc']      = ($row->service_type_desc!="")?$row->service_type_desc:"";
                    $output['data']['popular'][$i]['has_child']      =  $this->M_user->checkServiceTypeChildExist($row->service_type_id)>0?"1":"0";
                    $output['data']['popular'][$i]['service_type_thumbnail']    = ($row->service_type_thumbnail!="")?base_url().'uploads/service_type/'.$row->service_type_thumbnail:"";
                    $output['data']['popular'][$i]['is_home']      = ($row->is_home_category>0)?"1":"0";;  
                            
                        $i++;
                }
	        }
	        else
	        {  
	            $output['status']                  =   "0";
	            $output['message']                 =  "failed";
	            $output['data']['popular']         =  array();
	        }
	        
	         echo json_encode($output);exit;
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

  public function saveQuestions(){

    
  }
  
  
  public function saveUserQuestionAnswer()
    {
        $this->form_validation->set_rules('device_cart_id', 'device_cart_id', 'required');
        // $this->form_validation->set_rules('question_id', 'question_id','required');
        // $this->form_validation->set_rules('answer_id', 'answer_id', 'required');
        $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required');


        if ($this->form_validation->run() == FALSE) {
            $output['status']   =  "0";
            $output['message']  =  strip_tags(validation_errors());
        }else{
            $device_cart_id = $this->input->post('device_cart_id');
            $acces_token    = $this->input->post('acces_token');
            
            if(($user_token_data = AUTHORIZATION::validateToken( $access_token)) &&
            $this->common_functions->validateAccessToken( md5($access_token) ))
                $user_id = $user_token_data->user_id;
            else
                $user_id = 0;

            if ($_FILES["document"]["name"] != "") {
                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
                $filename2 = $_FILES["document"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
                $config2['upload_path']          =   $this->config->item('upload_path') . 'quotations/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg|pdf|doc';
                $config2['file_name']               =    $randomNo . "." . $file_ext2;
                $this->load->library('upload', $config2);
                if (!$this->upload->do_upload('document')) {

                    $data['status'] = "0";
                    $data['errors'] = array(
                        'document_name' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $_POST['document_name']                 =   $config2['file_name'];
                }
            }
            
                $this->M_user->saveQuestionAnswer($_POST);
            
            
        }

        echo json_encode($output);
    }

}
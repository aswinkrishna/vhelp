<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller 
{
    public function __construct()
     {
         parent::__construct();
         $this->load->model('services/M_user');      
         $this->load->model('M_admin');  
         $this->load->model('services/M_vendor');  
         $this->load->model('services/M_quotation');  

         error_reporting(E_ERROR | E_PARSE);
        // header('Content-Type: application/json');
        $this->load->helper('eq_helper');  
    }

    public function getVendorJobRequest(){

        $output['status']     = "0";
        $output['message']    = '';
        $output['data']       = [];

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());
    
        } else {

            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {
                $output['status']     = "1";
                $user_id    = $user_token_data->user_id;   
                $status     = $this->input->post('status'); 
                
                $limit  = (int) $this->input->post("page_limit");
                $page   = (int) $this->input->post("page");

                $page   = ($page <= 0) ? 1 : $page;
                $limit  = ($limit <= 0) ? 10 : $limit;
                $offset = ($page - 1) * $limit;
                
                $language   = 1;
                
                $sort       = $this->input->post('sort_key');
                $search_param = compact('user_id','status','language');
                
                // $result_count = $this->M_vendor->getJobRequestCount($user_id);
                // echo $result_count;exit;
                $job_list   = $this->M_vendor->getJobRequestList($search_param,$sort,$limit,$offset);
                // print_r($job_list);
                // echo $this->db->last_query();exit;
                $output['all_muted'] = (string) $this->M_vendor->getMuteStatus($user_id);
                if($job_list  ){
                    // $job_list   = $this->M_vendor->getJobRequestList($search_param,$sort,$limit,$offset);
                    $output['data'] = $this->process_job_request($job_list);
                    // print_r($this->db->last_query());exit;
                }else{
                    $output['message']    = "No job request available";
                } 
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        
        echo json_encode($output);
    }
    
    private function process_job_request($job_list){

        $service_request_mode_labels    = $this->config->item('service_request_mode_labels','app');

        $o_data = [];
        foreach ($job_list as $key => $value) {
            // print_r($value);exit;
            $data['assign_job_provider_id']     = $value->assign_job_provider_id;
            $data['job_request_id']             = $value->job_request_id;
            $data['assign_status']              = $value->assign_status;
            $data['provider_id']                = $value->provider_id;
            $data['assigned_date']              = $value->assigned_date;
            $data['service_type_name']          = $value->service_type_name;

            $service_type_icon = 'uploads/service_type/'.$value->service_type_icon;
            
            if (file_exists($service_type_icon) && is_file($service_type_icon)) {
                $data['service_type_icon']      = base_url().$service_type_icon;

            }else{
                $data['service_type_icon']      = "";
            }

            $data['job_validity_date']          = $value->job_date;
            $data['job_validity_time']          = date('h:i A',strtotime($value->job_time)); //$value->job_time;

            $vat_percentage                     = (string) $value->vat_percentage;
            $job_total_price                    = $row->job_total_price - $row->discount;
            $vat_amount                         =( $job_total_price * $row->vat_percentage ) / 100;

            $data['grand_total']                = (string) $value->grand_total;
            $data['job_location']               = $value->job_location;
            $data['job_longitude']              = $value->job_longitude;
            $data['job_latitude']               = $value->job_lattitude;         
            $data['payment_method']             = $value->payment_method;
            $data['muted_status']               = (string) $value->muted_status;
            
            $data['assign_staff_status']        = "0";
            $data['staff_response_status']      = "0";
            $data['staff_image']                = "";

            $data['service_mode']               = $value->request_mode;
            $data['service_mode_label']         = $service_request_mode_labels[$value->request_mode];
                    
            // echo $value->assign_status;exit;
            if($value->assign_status > 0 ){

                $assigned_staff = $this->M_vendor->getAssignedStaffDetails($value->job_request_id);
                if($assigned_staff){
                    // print_r($assigned_staff);exit;
                    $data['assign_staff_status']      = "1";
                    $data['staff_response_status']    = $assigned_staff->job_status;
                    $image = 'uploads/user/'.$assigned_staff->user_image;
                    if(file_exists($image) && is_file($image))
                        $image = base_url().$image;
                    else
                        $image = base_url().'uploads/user_dummy.png';
                    $data['staff_image']    = $image;
                }
            }
            
            $o_data[]                           = $data;
        }

        return $o_data;
    }
    
    
    public function updateRequestStatus(){

        $output['status']     = "0";
        $output['message']    = '';
        $output['data']       = [];

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('assign_job_provider_id', 'assign_job_provider_id', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());
 
        } else {
            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {

                $user_id    = $user_token_data->user_id;   
                $status     = $this->input->post('status'); 
                $assign_job_provider_id = $this->input->post('assign_job_provider_id');
                $result     = $this->M_vendor->updateRequestStatus($user_id,$status,$assign_job_provider_id);
                if($result == 1 ){
                    $output['status']     = "1";
                    if($status == 1 )
                        $output['message']    = 'Job request accepted successfully';
                    else
                        $output['message']    = 'Status updated successfully';

                    $user_details  = $this->M_vendor->getUserByAssignJobProviderId($assign_job_provider_id);
                    $service        = $this->M_user->getServiceTypeById ($user_details->service_type_id);
                    if($status == 1){
                        
                        $provider_details = $this->M_user->getProviderFullDetails($user_id);
                        $title                  =  "Vendor accepted job request"; 
                        $description            =  "Hi ".$user_details->user_first_name." ".$user_details->user_last_name.", Your job request is accepted by ".$provider_details->company_name;
                        $notification_id        =  time();
                        $ntype                  = "order-accepted";
                        // echo $description;
                        if (!empty($user_details->firebase_user_key)) {
                            $notification_data["Notifications/".$user_details->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $user_details->job_request_id,
                                "service_type_name" => $service->service_type_name,
                                "url" => "",
                                "imageURL" => "",
                                "read" => "0",
                                "seen" => "0"
                            ];

                            $fb_database = get_firebase_refrence();
                            $fb_database->getReference()->update($notification_data);
                        }

                        if (! empty($user_details->fcm_token) ) {
                            $this->load->library("FCM_Notification");
                            $this->fcm_notification->send_single_notification($user_details->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "notification"],
                                ["type" => "order-recived",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $user_details->job_request_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                            ]);
                        }
                        
                        $to = $user_fcm->user_email; // 'amal.a2solution@gmail.com';
                        $e_array['heading'] = $title;
                        $e_array['message'] = "Hi ".$user_details->user_first_name." ".$user_details->user_last_name.", Your job request ".$user_details->job_request_display_id." is accepted by ".$provider_details->company_name;
                        
                        $this->sendMail($user_details,$e_array,$user_details->job_request_id);
                    
                        $email_message  = $this->parser->parse('email/status_change', $e_array, true);
                        $this->mail_function->SendEmail($email_message,$e_array['heading'],$to);
                        
                        $title                  =  "Job request accepted"; 
                        $description            =  "Hi ".$provider_details->company_name.", You have accepted job request  ".$user_details->job_request_display_id ." sent by ".$user_details->user_first_name." ".$user_details->user_last_name;
                        $notification_id        =  time();
                        $ntype                  = "order-accepted";
                        
                        if (!empty($provider_details->firebase_user_key)) {
                            $notification_data["Notifications/".$provider_details->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $assign_job_provider_id,
                                "service_type_name" => $service->service_type_name,
                                "url" => "",
                                "imageURL" => "",
                                "read" => "0",
                                "seen" => "0"
                            ];

                            $fb_database = get_firebase_refrence();
                            $fb_database->getReference()->update($notification_data);
                        }

                        if (! empty($provider_details->fcm_token) ) {
                            $this->load->library("FCM_Notification");
                            $this->fcm_notification->send_single_notification($provider_details->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "vendor_notification"],
                                ["type" => "order-recived",
                                "notificationID" => $notification_id,
                                "orderID" => (string)$assign_job_provider_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                            ]);
                        }
                        
                    }
                    

                    // print_r($user_details);exit();
                }else if($result == -1){
                    $output['status']     = "0";
                    $output['message']    = 'Job request already assigned';
                }else if($result == -2){
                    $output['status']     = "1";
                    $output['message']    = 'Job request cancelled by user';
                }else {
                    $output['status']     = "0";
                    if($status == 1 )
                        $output['message']    = "Failed to accept job request";
                    else
                        $output['message']    = "Failed to update status";
                }
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        echo json_encode($output);
    }
    
    public function updateMuteStatus(){

        $output['status']     = "0";
        $output['message']    = '';
        $output['muted_status']= '';

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');
        $this->form_validation->set_rules('assign_job_provider_id', 'assign_job_provider_id', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());

        } else {
            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {
                $user_id    = $user_token_data->user_id; 
                $assign_job_provider_id = $this->input->post('assign_job_provider_id');

                $result = $this->M_vendor->updateMuteStatus($user_id,$assign_job_provider_id);
                if($result){
                    $output['status']     = "1";
                    $output['message']    = 'Job request muted successfully';
                }else{
                    $output['status']     = "0";
                    $output['message']    = 'Failed to mute job request';
                }

                $output['muted_status']   = (string) $this->M_vendor->getMuteStatus($user_id);
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        echo json_encode($output);
    }
    
    public function getVendorJobSummary(){

        $output['status']     = "0";
        $output['message']    = '';
        $output['data']       = [];

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');
        $this->form_validation->set_rules('assign_job_provider_id', 'assign_job_provider_id', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());

        } else {

            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {
                
                $output['status']     = "1";
                
                $user_id                = $user_token_data->user_id;
                $assign_job_provider_id = $this->input->post('assign_job_provider_id');
                $job_details            = $this->M_vendor->getVendorJobSummary($assign_job_provider_id,$user_id);
                //  print_r($job_details);exit;
                if($job_details){

                    $service_request_mode_labels    = $this->config->item('service_request_mode_labels','app');


                    $output['data']['job_request_display_id'] = $job_details->job_request_display_id;
                    $output['data']['assign_status']          = $job_details->assign_status;
                    
                    // print_r($output);exit;
                    $_odata = [];
                    $output['data']['assign_staff_status']      = "0";
                    $output['data']['staff_response_status']    = "0";

                    $o_data['staff_name']                       = "";
                    $o_data['staff_email']               = "";
                    $o_data['staff_dial_code']           = "";
                    $o_data['staff_phone']               = "";
                    $o_data['staff_image']               = "";        
                            
                    if($job_details->assign_status > 0 ){
                        
                        $assigned_staff = $this->M_vendor->getAssignedStaffDetails($job_details->job_request_id);
                        // print_r($assigned_staff);exit();

                        if($assigned_staff){
                            $output['data']['assign_staff_status']      = "1";
                            $output['data']['staff_response_status']    = $assigned_staff->job_status;
                            
                            $o_data['staff_name']                       = $assigned_staff->user_first_name.' '.$assigned_staff->user_last_name;
                            $o_data['staff_email']               = $assigned_staff->user_email;
                            $o_data['staff_dial_code']           = $assigned_staff->user_dial_code;
                            $o_data['staff_phone']               = $assigned_staff->user_phone;
                            // print_r($assigned_staff);exit();
                            $image      = "uploads/user/".$assigned_staff->user_image;
                            
                            if(file_exists($image) && is_file($image))
                                $image = base_url().$image;
                            else
                                $image = base_url()."uploads/user_dummy.png";
                            
                            $o_data['staff_image']              =   $image;
                            
                            
                        }
                    }
                    
                    $output['data']['staff_details']                    =   $o_data;
                    
                    $service =  $this->M_vendor->getQuestionsAgainstJobRequest($job_details->job_request_id);
                    $question = [];
                    
                    foreach($service as $key => $value){
                        $data['question_id'] = $value->question_id;
                        $data['question']    = $value->question;
                        $data['answer_options_id'] = $value->answer_options_id;
                        $data['answer_option'] = $value->answer_option;
                        $question [] = $data;
                    } 
                    $output['data']['question_answer']  = $question;
                    $output['data']['job_date']         = $job_details->job_date;
                    $output['data']['job_time']         = date('h:i A',strtotime($job_details->job_time));
                    // echo $job_details->job_time;exit;
                    $document = 'uploads/quotations/'.$job_details->document;   
                    if(file_exists($document) && is_file($document))
                        $document = base_url().$document;
                    else
                        $document = "";    
                    $output['data']['description']  = $job_details->description?$job_details->description:'';
                    $total_price  =  $job_details->job_total_price - $job_details->discount;
                    $vat_amount = ( $total_price * $job_details->vat_percentage ) / 100 ;
                    $output['data']['total_price']      = $job_details->job_total_price;
                    $output['data']['vat_percentage']  = $job_details->vat_percentage;
                    $output['data']['discount']         = $job_details->discount;
                    $output['data']['vat_amount']       = (string) $vat_amount;
                    $output['data']['grand_total']      = $job_details->grand_total;
                    $output['data']['service_type_name']= $job_details->service_type_name;
                    $output['data']['payment_method']   = $job_details->payment_method;
                    
                    $service_icon               = "uploads/service_type/".$job_details->service_type_icon;
                    if(file_exists($service_icon) && is_file($service_icon))
                        $service_icon = base_url().$service_icon;
                    else
                        $service_icon = "";
                        
                    $service_type_banner_image = 'uploads/service_type/'.$job_details->service_type_banner_image;
                    if(file_exists($service_type_banner_image) && is_file($service_type_banner_image))
                        $service_type_banner_image = base_url().$service_type_banner_image;
                    else
                        $service_type_banner_image = "";
                        
                    $output['data']['service_type_banner_image'] = $service_type_banner_image;
                        
                    // print_r($job_details);exit;
                        
                    $document   = "uploads/quotations/".$job_details->document;
                    $document_details = pathinfo($document);
                    $document_type = $document_details['extension'];
                    if($document_type =='jpg' || $document_type == 'png' || $document_type == 'jpeg'){
                        $output['data']['document_type']    = 'image';
                    }else{
                        $output['data']['document_type']    = 'file';
                    }
                    // print_r();exit;
                    // print_r($document);exit;
                    if(file_exists($document) && is_file($document)){
                        $document   = base_url().$document;
                    }else{
                        $document   = ""; 
                    }
                    
                    $output['data']['document']     = $document;
                    $output['data']['service_icon'] = $service_icon;
                    
                    $signature = 'uploads/job/'.$job_details->signature;
                        
                        if(file_exists($signature) && is_file($signature))
                            $signature = base_url().$signature;
                        else
                            $signature = "";
                            
                        $image = 'uploads/job/'.$job_details->image;
                        
                        if(file_exists($image) && is_file($image))
                            $image = base_url().$image;
                        else
                            $image = "";
                            
                        // print_r($result);exit;
                            
                        $output['data']['signature']            =   $signature; 
                        $output['data']['job_image']            =   $image; 
                        
                    // print_r($job_details);exit;
                    $output['data']['user_name']        = $job_details->user_first_name.' '.$job_details->user_last_name;
                    $output['data']['user_email']       = $job_details->user_email;
                    $output['data']['user_dial_code']   = $job_details->user_dial_code;
                    $output['data']['user_phone']       = $job_details->user_phone;
                    
                    $user_image = "uploads/user/".$job_details->user_image;
                    // echo $user_image;exit;
                    if(file_exists($user_image) && is_file($user_image))
                        $user_image = base_url().$user_image;
                    else
                        $user_image = base_url()."uploads/user_dummy.png";
                        
                    $output['data']['user_image']       = $user_image;
                    
                    $output['data']['job_location']     = $job_details->job_location;
                    $output['data']['job_longitude']    = $job_details->job_longitude;
                    $output['data']['job_latitude']     = $job_details->job_lattitude;
                    $output['data']['job_lattitude']    = $job_details->job_lattitude;
                    $output['data']['city']             = $job_details->city?$job_details->city:'';
                    $output['data']['area']             = $job_details->area?$job_details->area:'';
                    $output['data']['assign_job_provider_id'] = $job_details->assign_job_provider_id;
                    $output['data']['job_request_id']   = $job_details->job_request_id;  
                    $output['all_muted'] = (string) $this->M_vendor->getMuteStatus($user_id);
                    $output['data']['muted_status'] = (string) $job_details->muted_status;
                    $output['data']['time_taken']       = $job_details->time_taken?$job_details->time_taken:'';

                    $output['data']['service_mode']               = $job_details->request_mode;
                    $output['data']['service_mode_label']         = $service_request_mode_labels[$job_details->request_mode];

                    $job_days       = $this->M_vendor->get_request_job_days($job_details->job_request_id);
                    
                    foreach($job_days as $key=>$value)
                    {
                        $staff_data['staff_name']                = "";
                        $staff_data['staff_email']               = "";
                        $staff_data['staff_dial_code']           = "";
                        $staff_data['staff_phone']               = "";
                        $staff_data['staff_image']               = ""; 
                        $staff_data['assign_staff_status']       = "";     
                        $staff_data['staff_response_status']     = "";  
                                
                        if($job_details->assign_status > 0 ){
                            
                            $assigned_staff = $this->M_vendor->getAssignedStaffDetailsDayWise(['staff_jobs.job_request_id'=>$job_details->job_request_id,'staff_jobs.job_day_id'=>$value->days_id]);

                            if($assigned_staff)
                            {
                                $staff_data['assign_staff_status']      = "1";
                                $staff_data['staff_response_status']    = $assigned_staff->job_status;
                                
                                $staff_data['staff_name']                = $assigned_staff->user_first_name.' '.$assigned_staff->user_last_name;
                                $staff_data['staff_email']               = $assigned_staff->user_email;
                                $staff_data['staff_dial_code']           = $assigned_staff->user_dial_code;
                                $staff_data['staff_phone']               = $assigned_staff->user_phone;
                                $image      = "uploads/user/".$assigned_staff->user_image;
                                
                                if(file_exists($image) && is_file($image))
                                    $image = base_url().$image;
                                else
                                    $image = base_url()."uploads/user_dummy.png";
                                
                                $staff_data['staff_image']              =   $image;
                            }
                        }
                        $job_days[$key]->staff_data     = $staff_data;
                    }

                    $output['data']['job_days'] = $job_days;

                    // print_r($job_details);exit;
                }else{
                    $output['status']     = "0";
                    $output['message']    = 'Job details not found';
                    $data                 = [];
                    $output['data']       = (object) $data;
                }
                
                $temp_images = $this->M_quotation->getCompletedJobImage($job_details->job_request_id);
                $completed_job_image = [];
                foreach($temp_images as $key=> $value){
                    $image = base_url().'uploads/job/'.$value->image;
                    $completed_job_image[$key] = $image;
                }
                    
                $output['data']->completed_job_image  = $completed_job_image;
                
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        echo json_encode($output);
    }
    
    public function getVendorStaffList(){
        $output['status']     = "0";
        $output['message']    = '';
        $output['data']       = '';

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());

        } else {

            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {
                $output['status']     = "1";
                $staff_list  = $this->M_vendor->getAllVendorList($user_token_data->user_id);
                // echo $this->db->last_query();
                // print_r($stff_list);exit;
                $staff_data = [];
                foreach ($staff_list as $key => $value) {
                    $o_data['staff_id']         = $value->user_id;
                    $o_data['staff_name']       = $value->user_first_name.' '.$value->user_last_name;
                    $o_data['staff_dail_code']  = (string) $value->user_dail_code;
                    $o_data['mobile_number']    = (string) $value->user_phone;
                    $o_data['staff_email']      = $value->user_email;
                    
                    $image = 'uploads/user/'.$value->user_image;
                    // echo $image;exit;
                    if(file_exists($image) && is_file($image))
                        $image = base_url().$image;
                    else
                        $image = base_url().'uploads/user_dummy.png';
                    $o_data['staff_image']    = $image;
                    
                    $staff_data[]               = $o_data;
                }
                $output['data'] = $staff_data;
                
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        echo json_encode($output);
    }
    
    public function assignStaff(){
        
        $output['status']     = "0";
        $output['message']    = '';
        $output['data']       = '';

        $this->form_validation->set_rules('access_token', 'access_token', 'trim|required|xss_clean');
        $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('staff_id', 'staff_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('day_id', 'Day ID', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $output['status']   = "0";
            $output['message']  = strip_tags(validation_errors());

        } else {
            $access_token = (string) $this->input->post("access_token");
            if (($user_token_data = AUTHORIZATION::validateToken($access_token)) &&
                $this->common_functions->validateAccessToken(md5($access_token))
            ) {
                $output['status']     = "1";
                $job_request_id = $this->input->post('job_request_id');
                $staff_id       = $this->input->post('staff_id');
                $day_id         = $this->input->post('day_id');

                $data = array('staff_id' => $staff_id,  
                              'job_request_id' => $job_request_id,
                              'job_status' => 0,
                              'job_assigned_at' => date("Y-m-d H:i:s"),
                              'job_day_id'  => $day_id,
                            );
                $result = $this->M_vendor->assignStaff($data);
                // $result = 1;
                if($result == -1){
                    $output['status']   = "0";
                    $output['message']    = 'This staff working on another country';                            

                }else if($result > 0  ){
                    $output['message']    = "Job request assigned to staff successfully";
                    
                    $vendor_data = $this->M_user->getProviderFullDetails($user_token_data->user_id);
                    $title                  =  "Job request received ";//.$vendor_data->company_name; 
                    
                    $staff_data = $this->M_quotation->getStaffJobDetails($job_request_id);
                    $staff_name = $staff_data->user_first_name.' '.$staff_data->user_last_name;
                    
                    $job_details = $this->M_vendor->getJobDetails($job_request_id);

                    $job_requestDetails = $this->db->select('job_request_display_id')->where(['job_request_id'=>$job_request_id])->get('job_request')->row();
                    $description            =  'Hi Staff, you have received a new request from '.$vendor_data->company_name; //"Job request ".$job_requestDetails->job_request_display_id." is assigned to ".$staff_name." successfully";

                    $notification_id        =  time();
                    $user_fcm = $this->M_user->getUsersFcmTokens($staff_id);
                    $ntype      = "recive-job";
                    
                    // print_r($user_fcm);exit;
                    $service  = $this->M_vendor->getServiceByJobRequestId($job_request_id);
                    
                    $to = $user_fcm->user_email; // 'amal.a2solution@gmail.com';
                    $e_array['heading'] = $title;
                    $e_array['message'] = $description;
                        
                    $this->load->library("Mail_function");
                    $this->load->library('parser');
                    
                    $email_message  = $this->parser->parse('email/status_change', $e_array, true);
                    $this->mail_function->SendEmail($email_message,$e_array['heading'],$to);

                    if (!empty($user_fcm->firebase_user_key)) {
                        $notification_data["Notifications/".$user_fcm->firebase_user_key."/".$notification_id] = [
                            "title" => $title,
                            "description" => $description,
                            "notificationType" => $ntype,
                            "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                            "orderID" => (string) $job_request_id,
                            "service_type_name" => $service->service_type_name,
                            "url" => "",
                            "imageURL" => "",
                            "read" => "0",
                            "seen" => "0"
                        ];

                        $fb_database = get_firebase_refrence();
                        $fb_database->getReference()->update($notification_data);
                    }
                    
                    if (! empty($user_fcm->fcm_token) ) {
                        $this->load->library("FCM_Notification");
                        $this->fcm_notification->send_single_notification($user_fcm->fcm_token, [
                            "title" => $title,
                            "body" => $description,
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => "driver_notification"],
                            ["type" => "order-recived",
                            "notificationID" => $notification_id,
                            "orderID" => (string) $job_request_id,
                            "service_type_name" => $service->service_type_name,
                            "imageURL" => ""
                        ]);
                    }
                    
                    if($vendor_data->firebase_user_key){
                        
                        $vendor_job_details = $this->M_vendor->getVendorJobDetails($job_request_id,$user_token_data->user_id);
                        $title                  = "Job assigned to staff";
                        $description            = "Hi Vendor, job request ".$job_requestDetails->job_request_display_id." is assigned successfully to staff ".$staff_name;
                        
                        $notification_data["Notifications/".$vendor_data->firebase_user_key."/".$notification_id] = [
                            "title" => $title,
                            "description" => $description,
                            "notificationType" => $ntype,
                            "createdAt" => gmdate("d-m-Y H:i:s"),
                            "orderID" => (string) $vendor_job_details->assign_job_provider_id,
                            "service_type_name" => $service->service_type_name,
                            "url" => "",
                            "imageURL" => "",
                            "read" => "0",
                            "seen" => "0"
                        ];

                        $fb_database = get_firebase_refrence();
                        $fb_database->getReference()->update($notification_data);
                        
                        $this->load->library("FCM_Notification");
                        $this->fcm_notification->send_single_notification($vendor_data->fcm_token, [
                            "title" => $title,
                            "body" => $description,
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => "vendor_notification"],
                            ["type" => "order-recived",
                            "notificationID" => $notification_id,
                            "orderID" => (string) $vendor_job_details->assign_job_provider_id,
                            "service_type_name" => $service->service_type_name,
                            "imageURL" => ""
                        ]);
                    }
                    
                    
                }else{
                    $output['status']   = "0";
                    $output['message']    = 'Failed to assign job request';
                }
            }else{
                $this->output->set_status_header(401);
                $output['status']     = "4";
                $output['message']    = 'User session expired';
            }
        }

        echo json_encode($output);
    }
    
    public function sendMail($user_data,$data,$job_request_id){
        
        $this->load->model('services/M_quotation');
        $this->load->library("Mail_function");
        $this->load->library('parser');
                    
        $order_details = $this->M_quotation->getJobDetailsById($job_request_id);
        $address       = $this->M_quotation->getUserAddressById($order_details['address_id']);
        
        $to = $user_data->user_email;
        $e_array['subject'] = $data['title'];
        $e_array['message'] = $data['description'];
        $e_array['order_details']  = $order_details;
        $e_array['address'] = $address;
                        
        $email_message  = $this->parser->parse('email/order', $e_array, true);
        $this->mail_function->SendEmail($email_message,$e_array['subject'],$to);
        
    }
}


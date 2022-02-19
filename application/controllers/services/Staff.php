<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public $language_code;
    public $server_timezone;
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('services/M_user');
        $this->load->model('M_admin');
        $this->load->model('services/staff_model', 'model_staff');
        $this->load->library("FCM_Notification");

        $this->language_code = (int)$this->input->post('language');
        $this->language_code = $this->language_code == 2 ? 2 : 1; 

        $this->server_timezone =  date_default_timezone_get();
    }

    public function login() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $form_input_errors = [];
        $access_token = "";

        $this->form_validation->set_rules('user_mail_id', 'user email', 'trim|required|valid_email');
        $this->form_validation->set_rules('user_password', 'user password', 'trim|required');
        $this->form_validation->set_rules('fcm_token', 'fcm token', 'trim|required');
        $this->form_validation->set_rules('user_device_type', 'device type', 'trim|required|max_length[20]|alpha_numeric');
        

        if ($this->form_validation->run() == TRUE) {

            $i_data['user_email']   = strtolower($this->input->post('user_mail_id', true));
            $i_data['user_password'] =  md5($this->input->post('user_password', true));
            $i_data['user_type'] = 3;
            $i_data['is_deleted'] = 0;
            $inputArray['user_status'] = 1;

            $user_data = $this->M_user->userLoginnew($i_data);

            if ($user_data) { 

                if ($user_data->user_status == "1") {

                    $access_token   = AUTHORIZATION::generateToken([
                        "user_name" => $user_data->user_first_name,
                        "user_email" => $user_data->user_email,
                        "user_id" => $user_data->user_id,
                        "staff_vendor_id" => $user_data->vendor_id,
                        "timestamp" =>  time(),
                        "user_type" => 3
                    ]);

                    $user_full_details = $this->M_user->getUserFullDetails($user_data->user_id, 1);

                    $image= 'uploads/user/' . $user_data->user_image;


                    if (file_exists($image) && is_file($image))
                        $image = base_url() . $image;
                    else
                        $image = base_url() . 'images/user_dummy.png';

                    // $user_data = (array) $user_data;
                    $o_data = [
                        "edit_status"  =>  $user_data->user_created_by == 0 ? "1" : "0",
                        "user_first_name"  =>  ($user_data->user_first_name != "" ? $user_data->user_first_name : ""),
                        "user_last_name" => ($user_data->user_last_name != "" ? $user_data->user_last_name : ""),
                        "user_type" => 3,
                        "image" => $image,
                        "user_country_id" =>  (string) $user_data->country_id,
                        "country_name" =>  !empty($user_full_details->country_name) ? $user_full_details->country_name : "",
                        "user_city_id" =>  (string)($user_full_details->city_id > 0 ? $user_full_details->city_id : ""),
                        "city_name" => !empty($user_full_details->city_name) ? $user_full_details->city_name : "",
                        "building" => !empty($user_full_details->building) ? $user_full_details->building : "",
                        "appartment" => !empty($user_full_details->appartment) ? $user_full_details->appartment : "",
                        "area" => !empty($user_full_details->area) ? $user_full_details->area : "",
                        "user_zip" =>  !empty($user_full_details->user_zip) ? $user_full_details->user_zip : "",
                        "user_dial_code" =>  !empty($user_full_details->user_dial_code) ? $user_full_details->user_dial_code : "",
                        "user_phone" =>  $user_data->user_phone != "" ? $user_data->user_phone : "",
                        "user_email" =>  $user_data->user_email != "" ? $user_data->user_email : "",
                        "company_name" => !empty($user_full_details->user_company_name) ? $user_full_details->user_company_name : ""
                    ];

                    $i_date = array(
                        'user_device_token' => trim($this->input->post('fcm_token')),
                        'user_device_type' => trim($this->input->post('user_device_type')),
                        'user_last_login' => gmdate('Y-m-d H:i:s'),
                        "user_access_token" => md5($access_token),
                        "login_type" => 'N',
                        'fcm_token' => $this->input->post('fcm_token'),
                    );

                    
                    $database = get_firebase_refrence();

                   

                    if (empty($user_data->firebase_user_key)) {

                        $fb_user_refrence = $database->getReference('Users/')
                                                     ->push([
                                                        "fcm_token" => trim($this->input->post('fcm_token', true)),
                                                        "user_name" => $o_data['user_first_name'],
                                                    ]);

                        $social_key = $fb_user_refrence->getKey();

                        $o_data['firebase_user_key']    = $social_key;
                        $i_date['firebase_user_key']    = $social_key;
                    } 
                    else {
                        $o_data['firebase_user_key']  = $user_data->firebase_user_key;
                        $database->getReference("Users/" . $user_data->firebase_user_key . "/")->update(["fcm_token" => trim($this->input->post('fcm_token', true))]);
                    }

                    $result = $this->M_user->commonupdate('user_table', $i_date, array( 'user_id' => $user_data->user_id ) );

                    $status = "1";
                    $message = "";

                }
                else {
                    $status = "2";
                    $message = "You are not authorised to login this application";
                    $o_data['user_id'] = "";
                }
            }
            else {
                $status =    "0";
                $message = "User name or password entered is incorrect. Please try again";
                $o_data['user_id'] = ""; //(object) $o_data;
            }
        }
        else {
            $output['status'] = "0";
            $output['message'] =  strip_tags(validation_errors());
            echo json_encode($output);exit;
            // $form_input_errors = [
            //     "user_mail_id" => form_error('user_mail_id'),
            //     "user_password" => form_error('user_password'),
            //     "fcm_token" => form_error('fcm_token'),
            //     "user_device_type" => form_error('user_device_type'),
            // ];
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
                 "access_token" => $access_token,
                 "validation_errors" => $form_input_errors,
                 "data" =>  $o_data
             ] ));

    }

    private function process_job_request(object $row, string $user_timezone) : ? array {

        // print_r($row);exit;
        $document_file = "";
        $job_customer_started_approved_uts = "0";
        
        $document = "uploads/quotations/".$row->document;
        $document_details = pathinfo($document);
        $document_type = "";
        
        if( file_exists($document) && is_file($document)){ 
            $document_type = $document_details['extension'];
            if($document_type =='jpg' || $document_type == 'png' || $document_type == 'jpeg'){
                $document_type    = 'image';
            }else{
                $document_type    = 'file';
            }
            $document_file = base_url()."uploads/quotations/".$row->document;
        }else
            $document_file = "";
        
        $job_assigned_at = "";
        if(!empty($row->job_assigned_at))
            $job_assigned_at =  get_date_in_timezone($user_timezone, $row->job_assigned_at , "d-m-Y h:i A", $this->server_timezone);

        $job_accepted_at = "";
        if(!empty($row->job_accepted_at))
            $job_accepted_at =  get_date_in_timezone($user_timezone, $row->job_accepted_at , "d-m-Y h:i A", $this->server_timezone);

        $job_started_at = "";
        if(!empty($row->job_started_at))
            $job_started_at =  get_date_in_timezone($user_timezone, $row->job_started_at , "d-m-Y h:i A", $this->server_timezone);

        $job_finished_at = "";
        if(!empty($row->job_finished_at))
            $job_finished_at =  get_date_in_timezone($user_timezone, $row->job_finished_at , "d-m-Y h:i A", $this->server_timezone);

        $job_customer_started_approved_at = "";
        $job_customer_started_approved_at_new = "";
        if(!empty($row->job_customer_started_approved_at)) {
            $job_customer_started_approved_at =  date_format( date_create($row->job_customer_started_approved_at),"d-m-Y H:i:s");//get_date_in_timezone($user_timezone, $row->job_customer_started_approved_at , "d-m-Y h:i:s", $this->server_timezone);
            $job_customer_started_approved_uts = (string) strtotime( $job_customer_started_approved_at );
            $job_customer_started_approved_at_new = date_format( date_create($row->job_customer_started_approved_at),"d-m-Y h:i:s A");
        }

        $job_customer_approved_finished_at = "";
        if(!empty($row->job_customer_approved_finished_at))
            $job_customer_approved_finished_at =  get_date_in_timezone($user_timezone, $row->job_customer_approved_finished_at , "d-m-Y h:i:s ", $this->server_timezone);
            
        $signature = 'uploads/job/'.$row->signature;
        if(file_exists($signature) && is_file($signature))
            $signature = base_url().$signature;
        else
            $signature = "";
            
        $job_image = 'uploads/job/'.$row->image;
        if(file_exists($job_image) && is_file($job_image))
            $job_image = base_url().$job_image;
        else
            $job_image = "";
        $job_total_price = $row->job_total_price - $row->discount;
        $vat_amount =( $job_total_price * $row->vat_percentage ) / 100;
        $data = [
            "staff_job_id"      => (string) $row->staff_job_id,
            "job_request_id" => (string) $row->job_request_id,
            "job_dt" => date_format( date_create($row->job_days_date),"d-m-Y "), //get_date_in_timezone($user_timezone, $row->job_date ." ". $row->job_time, "d-m-Y h:i A", $this->server_timezone),
            "job_tm" => date_format(date_create($row->job_days_time) , 'h:i A'),
            "job_validity_dt" => get_date_in_timezone($user_timezone, $row->job_validity_date ." ". $row->job_validity_time, "d-m-Y h:i A", $this->server_timezone),

            "job_date" => get_date_in_timezone($user_timezone, $row->job_days_date ." ". $row->job_days_time, "d-m-Y h:i A", $this->server_timezone),
            "job_request_status" => (string) $row->job_request_status,
            "job_location" => (string) $row->job_location,
            "job_latitude" => (string) $row->job_lattitude,
            "job_longitude" => (string) $row->job_longitude,
            "job_city" => (string) $row->city,
            "job_state" => (string) $row->state,
            "job_description" => (string) $row->description,
            "job_request_display_id" => (string) $row->job_request_display_id,
            "job_document" => $document_file,
            "job_document_type" => $document_type,
            "payment_type" => (string) $row->payment_method,//($row->payment_method==1) ? "Card" : "COD",
            "total_price"  => $row->job_total_price,
            "vat_percentage" =>$row->vat_percentage,
            "vat_amount"     => (string) $vat_amount,
            "discount"       => $row->discount,
            "grand_total" => (string) $row->grand_total,
            "staff_job_status" => $row->job_status,
            "staff_job_assigned_at" => $job_assigned_at,
            "staff_job_accepted_at" => $job_accepted_at,
            "staff_job_started_at" => $job_started_at,
            "staff_job_finished_at" => $job_finished_at,
            "staff_job_customer_started_approved_at" => $job_customer_started_approved_at,
            "staff_job_customer_started_approved_uts" => $job_customer_started_approved_uts,
            "staff_job_customer_finished_approved_at" => $job_customer_approved_finished_at,
            "job_customer_started_approved_at_new"    => $job_customer_started_approved_at_new,
            "customer_job_approve_status" => (string) $row->customer_job_approve_status,
            "muted_status" => (string) $row->muted_status,
            "signature" => $signature,
            "job_image" => $job_image,
            "time_taken" => $row->time_taken?$row->time_taken:'',
        ];
        // print_r($row);exit;
        if($row->service_type_name)
            $data['service_type_name']  = $row->service_type_name;
        else
            $data['service_type_name']  = "";
        $service_baner = 'uploads/service_type/'.$row->service_type_banner_image;
        if(file_exists($service_baner) && is_file($service_baner))
            $service_baner = base_url().$service_baner;
        else
            $service_baner = "";
        $data['service_baner'] = $service_baner;
        // print_r($row);exit;
        return $data;
    }

    public function update_muted_status() {
        $status     = "0";
        $message    = "";

        $access_token   = trim($this->input->post("access_token"));  

        $user_timezone  = !empty($user_timezone) ? $user_timezone : date_default_timezone_get();
        $user_token_data = AUTHORIZATION::validateToken($access_token);

        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job request id', 'required|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff job id', 'required|numeric');
            $this->form_validation->set_rules('muted_status', 'muted status', 'required|in_list[0,1]|numeric');

            if ($this->form_validation->run() == TRUE) {

                $job_request_id = (int) $this->input->post("job_request_id");
                $staff_job_id   = (int) $this->input->post('staff_job_id',true);
                $muted_status   = (int) $this->input->post("muted_status");

                $muted_status = ($muted_status == 1) ? 1 : 0;

                $job_data = $this->model_staff->get_job(["staff_jobs.job_request_id" => $job_request_id,"staff_jobs.staff_job_id"=>$staff_job_id]);

                if($job_data) {

                    $this->model_staff->update_job(["muted_status" => $muted_status], ["job_request_id" => $job_request_id,"staff_job_id"=>$staff_job_id]);

                    $status     = "1";
                    $message    = $muted_status == 1 ? "Job muted succesfully" : "Job umuted succesfully";
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                    "staff_job_id"      => form_error("staff_job_id"),
                ];
            }
            
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message
             ] ));


    }

    public function jobs() {

        $status     = "0";
        $message    = "";
        $o_data     = [
            "pending_job_list" => [],
            "pending_job_list_count" => "0",
            "accepted_job_list" => [],
            "accepted_job_list_count" => "0",
            "started_job_list" => [],
            "stared_job_list_count" => "0",
            "finished_job_list" => [],
            "finished_job_list_count" => "0",
            "all_jobs_muted" => "0"
        ];
        
        $access_token   = trim($this->input->post("access_token"));  
        $user_timezone  = trim($this->input->post("user_timezone", true));

        $limit  = (int) $this->input->post("limit");
        $offset  = 0;

        $user_timezone = (int) $this->input->post("user_timezone");
        $user_timezone  = !empty($user_timezone) ? $user_timezone : date_default_timezone_get();
        $user_token_data = AUTHORIZATION::validateToken($access_token);

        $o_data["timezone"] = $user_timezone;


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            
            //PENDING
            $jobs_list = $this->model_staff->get_jobs(["job_status" => 0, "staff_id" => $user_token_data->user_id], $limit, $offset, ["job_assigned_at", "ASC"]);

            $o_data["pending_job_list_count"] = (string) $this->model_staff->get_jobs_count(["job_status" => 0, "staff_id" => $user_token_data->user_id]);
            foreach($jobs_list as $key=>$row)
                $o_data["pending_job_list"][$key] = $this->process_job_request($row, $user_timezone);
            
            //ACCEPTED
            $jobs_list = $this->model_staff->get_jobs(["job_status" => 1, "staff_id" => $user_token_data->user_id], $limit, $offset, ["job_accepted_at","ASC"]);
            $o_data["accepted_job_list_count"] = (string) $this->model_staff->get_jobs_count(["job_status" => 1, "staff_id" => $user_token_data->user_id]);
            foreach($jobs_list as $key=>$row)
                $o_data["accepted_job_list"][$key] =$this->process_job_request($row, $user_timezone);
               
            //STARTED
            $jobs_list = $this->model_staff->get_jobs(["job_status" => 3, "staff_id" => $user_token_data->user_id], $limit, $offset, ["job_customer_started_approved_at", "DESC"]);
            $o_data["stared_job_list_count"] = (string) $this->model_staff->get_jobs_count(["job_status" => 3, "staff_id" => $user_token_data->user_id]);
            foreach($jobs_list as $key=>$row)
                $o_data["started_job_list"][$key] =$this->process_job_request($row, $user_timezone);

            //COMPLETED
            $jobs_list = $this->model_staff->get_jobs(["job_status" => 4, "staff_id" => $user_token_data->user_id], $limit, $offset, ["job_customer_approved_finished_at", "DESC"]);
            $o_data["finished_job_list_count"] = (string) $this->model_staff->get_jobs_count(["job_status" => 3, "staff_id" => $user_token_data->user_id]);
            foreach($jobs_list as $key=>$row)
                $o_data["finished_job_list"][$key] =$this->process_job_request($row, $user_timezone);


            $jobs_muted_count = $this->model_staff->get_jobs_count(["muted_status" => 1]);
            $all_jobs_count = $this->model_staff->get_jobs_count();

            $o_data["all_jobs_muted"] = ($all_jobs_count - $jobs_muted_count) == 0 ? "1" : "0";

            $status     = "1";
            $message    = "";
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
                 "data" =>  $o_data
             ] ));


    }

    public function jobs_paginater() {

        $status     = "0";
        $message    = "";
        $o_data     = [
            "job_list" => [],
            "job_list_count" => "0",
        ];
        
        $access_token   = trim($this->input->post("access_token"));  
        $user_timezone  = trim($this->input->post("user_timezone", true));

        $limit  = (int) $this->input->post("limit");
        $offset  = (int) $this->input->post("offset");
        $job_status  = (int) $this->input->post("job_status");

        $offset = (int) $this->input->post("user_timezone");

        $user_timezone  = !empty($user_timezone) ? $user_timezone : date_default_timezone_get();
        $user_token_data = AUTHORIZATION::validateToken($access_token);

        $o_data["timezone"] = $user_timezone;


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            
            if($job_status > 0 && $job_status < 5) {
        
                $jobs_list = $this->model_staff->get_jobs(["job_status" => $job_status, "staff_id" => $user_token_data->user_id], $limit, $offset, ["job_assigned_at", "ASC"]);

                $o_data["pending_job_list_count"] = (string) $this->model_staff->get_jobs_count(["job_status" => 0, "staff_id" => $user_token_data->user_id]);
                foreach($jobs_list as $key=>$row)
                    $o_data["job_list_count"][$key] = $this->process_job_request($row, $user_timezone);

                $status     = "1";
                $message    = "";
            }
            else {
                $status     = "2";
                $message    = "Invalid job status";
            }
           
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
                 "data" =>  $o_data
             ] ));


    }

    public function get_job() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $all_muted  = "0";
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);

        $user_timezone = (int) $this->input->post("user_timezone");

        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff_job_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = $this->input->post("job_request_id");
                $staff_job_id   = (int) $this->input->post("staff_job_id",true);

                $job_data = $this->model_staff->get_job(["staff_jobs.job_request_id" => $job_request_id,"staff_id"=>$user_token_data->user_id,"staff_jobs.staff_job_id"=>$staff_job_id]);

                $all_muted = (string) $this->model_staff->getMuteStatus($user_token_data->user_id);
                
                if($job_data) {
                    // print_r($job_data);exit;
                    // print_r($job_data);exit; echo $this->db->last_query();
                    $o_data = $this->process_job_request($job_data, $user_timezone);

                    $o_data["vendor_details"] = [];
                    $o_data["customer_details"] = [];

                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->model_staff->get_vendor_data_by_id($staff_data->vendor_id);
                    $customer_data = $this->model_staff->get_user_data_by_job_request_id($job_request_id);

                    if($vendor_data) {
                        $vendor_full_details = $this->M_user->getUserFullDetails($vendor_data->user_id, 1);

                        $image= 'uploads/user/' . $vendor_data->user_image;


                        if (file_exists($image) && is_file($image))
                            $image = base_url() . $image;
                        else
                            $image = base_url() . 'images/user_dummy.png';

                        $o_data["vendor_details"] = [
                            "edit_status"  =>  $vendor_data->user_created_by == 0 ? "1" : "0",
                            "user_first_name"  =>  ($vendor_data->user_first_name != "" ? $vendor_data->user_first_name : ""),
                            "user_last_name" => ($vendor_data->user_last_name != "" ? $vendor_data->user_last_name : ""),
                            "user_type" => 3,
                            "image" => $image,
                            "user_country_id" =>  (string) $vendor_data->country_id,
                            "country_name" =>  !empty($vendor_full_details->country_name) ? $vendor_full_details->country_name : "",
                            "user_city_id" =>  (string)($vendor_full_details->city_id > 0 ? $vendor_full_details->city_id : ""),
                            "city_name" => !empty($vendor_full_details->city_name) ? $vendor_full_details->city_name : "",
                            "building" => !empty($vendor_full_details->building) ? $vendor_full_details->building : "",
                            "appartment" => !empty($vendor_full_details->appartment) ? $vendor_full_details->appartment : "",
                            "area" => !empty($vendor_full_details->area) ? $vendor_full_details->area : "",
                            "user_zip" =>  !empty($vendor_full_details->user_zip) ? $vendor_full_details->user_zip : "",
                            "user_dial_code" =>  !empty($vendor_full_details->user_dial_code) ? $vendor_full_details->user_dial_code : "",
                            "user_phone" =>  $vendor_data->user_phone != "" ? $vendor_data->user_phone : "",
                            "user_email" =>  $vendor_data->user_email != "" ? $vendor_data->user_email : "",
                            "company_name" => $vendor_data->company_name,//!empty($vendor_full_details->user_company_name) ? $vendor_full_details->user_company_name : ""
                        ];
                    }

                    if($customer_data) {
                        $customer_full_details = $this->M_user->getUserFullDetails($customer_data->user_id, 1);
                        
                        $image= 'uploads/user/'.$customer_full_details->user_image;
                        
                        if (file_exists($image) && is_file($image))
                            $image = base_url() . $image;
                        else
                            $image = base_url() . 'images/user_dummy.png';

                        $o_data["customer_details"] = [
                            "edit_status"  =>  $customer_data->user_created_by == 0 ? "1" : "0",
                            "user_first_name"  =>  ($customer_data->user_first_name != "" ? $customer_data->user_first_name : ""),
                            "user_last_name" => ($customer_data->user_last_name != "" ? $customer_data->user_last_name : ""),
                            "user_type" => 3,
                            "image" => $image,
                            "user_country_id" =>  (string) $customer_data->country_id,
                            "country_name" =>  !empty($customer_full_details->country_name) ? $customer_full_details->country_name : "",
                            "user_city_id" =>  (string)($customer_full_details->city_id > 0 ? $customer_full_details->city_id : ""),
                            "city_name" => !empty($customer_full_details->city_name) ? $customer_full_details->city_name : "",
                            "building" => !empty($customer_full_details->building) ? $customer_full_details->building : "",
                            "appartment" => !empty($customer_full_details->appartment) ? $customer_full_details->appartment : "",
                            "area" => !empty($customer_full_details->area) ? $customer_full_details->area : "",
                            "user_zip" =>  !empty($customer_full_details->user_zip) ? $customer_full_details->user_zip : "",
                            "user_dial_code" =>  !empty($customer_full_details->user_dial_code) ? $customer_full_details->user_dial_code : "",
                            "user_phone" =>  $customer_data->user_phone != "" ? $customer_data->user_phone : "",
                            "user_email" =>  $customer_data->user_email != "" ? $customer_data->user_email : "",
                            "company_name" => !empty($customer_full_details->user_company_name) ? $customer_full_details->user_company_name : ""
                        ];
                    }

                    $q_and_o_data = [];
                    $question_and_options = $this->model_staff->get_job_request_quest_n_options(["job_request_id" => $job_request_id]);

                    foreach( $question_and_options as $key => $row ){
                        $q_and_o_data[$key] = [
                            "question" => (string) ($this->language_code == 2 ? $row->question_arb :  $row->question),
                            "option" => (string) ($this->language_code == 2 ? $row->answer_option_arabic :  $row->answer_option),
                        ];
                    }

                    $o_data["questions_n_options"] = $q_and_o_data;
                    $temp_images= $this->model_staff->getCompletedJobImage($job_request_id);
                    $completed_job_image = [];
                    foreach($temp_images as $key=> $value){
                        $image = base_url().'uploads/job/'.$value->image;
                        // if(file_exists($image) && is_file($image))
                        //     $image = base_url().$image;
                        $completed_job_image[$key] = $image;
                    }
                    
                    
                    $o_data['completed_job_image']  =$completed_job_image;
                    
                    $status     = "1";
                    $message    = "";
                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                    $o_data     = (object) $o_data;
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id"    => form_error('job_request_id'),
                    "staff_job_id"      => form_error("staff_job_id"),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
                 "data" =>  $o_data,
                 'all_muted' => $all_muted,
             ] ));

    }

    public function job_accept() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $language   = 1; 
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff_job_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = (int) $this->input->post("job_request_id");
                $staff_job_id   = (int) $this->input->post('staff_job_id');
                $job_data       = $this->model_staff->get_job([ "staff_jobs.staff_job_id" => $staff_job_id]);

                if($job_data) {
                    
                    $this->model_staff->update_job(["customer_job_approve_status" => 1,"job_status" => 1, "job_accepted_at" => date("Y-m-d H:i:s")],["staff_jobs.job_request_id" => $job_request_id,"staff_jobs.job_status"=>0,"staff_jobs.staff_job_id"=>$staff_job_id]);
                    
                    $this->model_staff->update_job_request_by_day(["job_status" => 3], ["days_id" => $job_data->job_day_id]);
                    
                    $this->model_staff->updateVendorStatus($job_request_id,3);
                    
                    $customer_data = $this->model_staff->get_user_data_by_job_request_id($job_request_id);
                    
                    
                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $vendor_data = $this->M_user->getProviderFullDetails($staff_data->vendor_id,$language);//$this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    
                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                    
                    if($vendor_data){
                        $vendor_full_name = $vendor_data->user_first_name ." ".$vendor_data->user_last_name;
                        $data = array('title' => 'Job accepted by staff', 
                                  'description'  => "Hi ".$vendor_data->company_name.", Job " . $job_data->job_request_display_id . " has been accepted by  ". $staff_full_name,
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_data->assign_job_provider_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'vendor_notification',
                            );
                        $this->sendPushNotmification($vendor_data,$data);        
                    }
                    
                    if($customer_data){
                        $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;
                        $data = array('title' => 'Staff assigned for job', 
                                  'description'  => "Hi, Your Job request " . $job_data->job_request_display_id . " is assigned to  ". $staff_full_name." successfully",
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($customer_data,$data);        
                    }
                    
                    if($staff_data){
                        $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        $data = array('title' => 'Job Accepted', 
                                  'description'  => "Hi ".$staff_full_name.",  You have accepted job request " . $job_data->job_request_display_id . " sent by ". $vendor_data->company_name,
                                  'ntype'  => 'staff_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($staff_data,$data);        
                    }
                    
                    // print_r($customer_data);exit;
                    $status     = "1";
                    $message    = "Job accepted successfully"; 
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                    "staff_job_id"   => form_error("staff_job_id"),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message
             ] ));

    }

    public function job_accept_old() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $language   = 1; 
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = (int) $this->input->post("job_request_id");
                $job_data = $this->model_staff->get_job([ "staff_jobs.job_request_id" => $job_request_id]);

                if($job_data) {
                    
                    $this->model_staff->update_job(["job_status" => 1, "job_accepted_at" => date("Y-m-d H:i:s")],["staff_jobs.job_request_id" => $job_request_id,"staff_jobs.job_status"=>0]);
                    
                    $this->model_staff->update_job_request(["job_request_status" => 3], ["job_request_id" => $job_request_id]);
                    
                    $this->model_staff->updateVendorStatus($job_request_id,3);
                    
                    $customer_data = $this->model_staff->get_user_data_by_job_request_id($job_request_id);
                    
                    
                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $vendor_data = $this->M_user->getProviderFullDetails($staff_data->vendor_id,$language);//$this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    
                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                    
                    if($vendor_data){
                        $vendor_full_name = $vendor_data->user_first_name ." ".$vendor_data->user_last_name;
                        $data = array('title' => 'Job accepted by staff', 
                                  'description'  => "Hi ".$vendor_data->company_name.", Job " . $job_data->job_request_display_id . " has been accepted by  ". $staff_full_name,
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_data->assign_job_provider_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'vendor_notification',
                            );
                        $this->sendPushNotmification($vendor_data,$data);        
                    }
                    
                    if($customer_data){
                        $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;
                        $data = array('title' => 'Staff assigned for job', 
                                  'description'  => "Hi, Your Job request " . $job_data->job_request_display_id . " is assigned to  ". $staff_full_name." successfully",
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($customer_data,$data);        
                    }
                    
                    if($staff_data){
                        $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        $data = array('title' => 'Job Accepted', 
                                  'description'  => "Hi ".$staff_full_name.",  You have accepted job request " . $job_data->job_request_display_id . " sent by ". $vendor_data->company_name,
                                  'ntype'  => 'staff_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-accepted",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($staff_data,$data);        
                    }
                    
                    // print_r($customer_data);exit;
                    $status     = "1";
                    $message    = "Job accepted successfully"; 
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message
             ] ));

    }

    public function job_reject() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $language   = 1;
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff_job_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id     = (int) $this->input->post("job_request_id");
                $staff_job_id       = (int) $this->input->post("staff_job_id",true);
                $rejected_reason    = (string) $this->input->post("rejected_reason", true);

                $job_data = $this->model_staff->get_job(["staff_jobs.job_status" => 0, "staff_jobs.job_request_id" => $job_request_id,"staff_jobs.staff_job_id"=>$staff_job_id]);
                // print_r($job_data);exit;
                if($job_data) {

                    // $this->model_staff->update_job(["reject_reason" => $rejected_reason, "job_status" => 2, "job_rejected_at" => date("Y-m-d H:i:s")],["job_request_id" => $job_request_id]);
                    $this->model_staff->rejectJobRequest_by_day($staff_job_id,$job_data->job_day_id);
                    // exit;
                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->M_user->getProviderFullDetails($staff_data->vendor_id,$language);//$this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);

                    
                    if($vendor_data ) {
    
                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                    $vendor_full_name = $vendor_data->company_name;//$vendor_data->user_first_name ." ".$vendor_data->user_last_name;
                    
                    $description = "Hi {$vendor_full_name}, Job " . $job_data->job_request_display_id . " is rejected by ". $staff_full_name ;

                    $service_type = $this->model_staff->getServiceDetailsById($job_data->service_type_id);

                    $data = array('title' => 'Job rejected by staff', 
                                  'description'  => $description,
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $service_type->service_type_name,
                                  'orderID' => $job_data->assign_job_provider_id,
                                  'type'    => "order-rejected",
                                  'clickAction' => 'vendor_notification',
                            );
                    $this->sendPushNotmification($vendor_data,$data);  
                    
                    
                    if($staff_data){
                        $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        $data = array('title' => 'Job Rejected', 
                                  'description'  => "Hi ".$staff_full_name.",  You have cancelled the job " . $job_data->job_request_display_id . " assigned by ". $vendor_data->company_name,
                                  'ntype'  => 'staff_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-rejected",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($staff_data,$data);        
                    }
                    
                    // print_r($vendor_data);exit;

                   

                    $status     = "1";
                    $message    = "job has been rejected";
                } 
                else {
                    $status     = "2";
                    $message    = "There is some issue with your job selected";
                }

                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id"    => form_error('job_request_id'),
                    "staff_job_id"      => form_error("staff_job_id"),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message
             ] ));

    }

    public function job_start() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $language   = 1;
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff_job_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = $this->input->post("job_request_id");
                $staff_job_id   = (int) $this->input->post("staff_job_id",true);

                $job_data = $this->model_staff->get_job(["staff_jobs.job_status" => 1, "staff_jobs.job_request_id" => $job_request_id,"staff_jobs.staff_job_id"=>$staff_job_id]);

                if($job_data) {

                    // $this->model_staff->update_job(["job_status" => 3, "job_accepted_at" => date("Y-m-d H:i:s")],["job_request_id" => $job_request_id]);

                    $this->model_staff->start_job_request(["staff_job_id"=>$staff_job_id,"job_day_id"=>$job_data->job_day_id,"job_request_id"=>$job_request_id]);

                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    $customer_data = $this->model_staff->get_user_data_by_job_request_id($job_request_id);
                    
                    $vendor_data = $vendor_data = $this->M_user->getProviderFullDetails($staff_data->vendor_id,$language);
                    
                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                    if($vendor_data){
                        $data = array('title' => 'Job started', 
                                  'description'  => "Hi {$vendor_data->company_name}, job " . $job_data->job_request_display_id . " has been started by ". $staff_full_name ,
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_data->assign_job_provider_id,
                                  'type'    => "Job-start-request",
                                  'clickAction' => 'vendor_notification',
                        );
                        
                        $this->sendPushNotmification($vendor_data,$data);

                    }

                    if($customer_data){
                        $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;
                        $data = array('title' => 'Job started', 
                                  'description'  => "Hi {$customer_full_name}, your Job " . $job_data->job_request_display_id . " is started by ". $staff_full_name,
                                  'ntype'  => 'vendor_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-start-request",
                                  'clickAction' => 'notification',
                        );

                        $this->sendPushNotmification($customer_data,$data);
                    }
                    if($staff_data){
                        $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        $data = array('title' => 'Job Started', 
                                  'description'  => "Hi ".$staff_full_name.",  You have started the " . $job_data->job_request_display_id . " assigned by ".$vendor_data->company_name,
                                  'ntype'  => 'staff_notification',
                                  'service_type_name' => $job_data->service_type_name,
                                  'orderID' => (string) $job_request_id,
                                  'type'    => "Job-started",
                                  'clickAction' => 'notification'
                            );
                        $this->sendPushNotmification($staff_data,$data);        
                    }
                    
                    $status = "1";
                    $message = "Job start successfully";
                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message
             ] ));

    }

    public function customer_job_start_confirm() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = $this->input->post("job_request_id");
                $job_data = $this->model_staff->get_job(["job_status" => 3, "staff_jobs.job_request_id" => $job_request_id]);

                if($job_data) {

                    $this->model_staff->update_job([  "customer_job_approve_status" => 1, "job_customer_started_approved_at" => date("Y-m-d H:i:s")],["job_request_id" => $job_request_id]);

                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    $customer_data = $this->model_staff->get_user_data([ "user_id" => $job_data->user_id]);

                    if($vendor_data && $customer_data) {

                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                    $vendor_full_name = $vendor_data->user_first_name ." ".$vendor_data->user_last_name;
                    $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;

                    $this->fcm_notification->send_notification($staff_data->fcm_token,[
                        "title"=>"Customer Approved",
                        "body"=>"Hi {$staff_full_name}, Your Job " . $job_data->job_request_display_id . " start request confirmed by ". $customer_full_name ,
                        "icon"=>'myicon',
                        "sound" =>'default'],
                        [
                            "type" => "job_start_confirmed",
                            "job_request_id" => $job_data->job_request_id,
                        ]);

                  
                        $status     = "1";
                        $message    = "Job started confirmed successfully";
                    } 
                    else {
                        $status     = "2";
                        $message    = "There is some issue with your job selected";
                    }

                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
             ] ));

    }

    public function job_finished() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        $language   = 1;
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('staff_job_id', 'staff_job_id', 'trim|required|xss_clean|numeric');
            // $this->form_validation->set_rules('signature', 'signature', 'trim|required|xss_clean|numeric');
            // $this->form_validation->set_rules('image', 'image', 'trim|required|xss_clean|numeric');
            

            if ($this->form_validation->run() == TRUE) {

                $job_request_id = $this->input->post("job_request_id");
                $staff_job_id   = (int) $this->input->post('staff_job_id',true);

                $job_data = $this->model_staff->get_job(["staff_jobs.job_status" => 3, "staff_jobs.job_request_id" => $job_request_id,'staff_jobs.staff_job_id'=>$staff_job_id]);

                if($job_data) {

                    $images = [];
                    if($_FILES)
                        $images = multipleFileUpload( $_FILES["image"] , 'job');

                    if(!empty($images))
                        $this->model_staff->insertJobImages($job_request_id,$images);
                        
                    $time_taken = $this->input->post('time_taken');
                        // $this->model_staff->update_job([ "job_status" => 4, "job_finished_at" => date("Y-m-d H:i:s")],["job_request_id" => $job_request_id]);
                        
                    $this->model_staff->job_finished(['staff_job_id'=>$staff_job_id,'job_request_id'=>$job_request_id,'job_day_id'=>$job_data->job_day_id]);

                    $this->model_staff->updateTimeTaken($time_taken,$job_data->job_day_id,$user_token_data->user_id);
                        
                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    $customer_data = $this->model_staff->get_user_data_by_job_request_id($job_request_id);
                    $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        
                    $vendor_data = $vendor_data = $this->M_user->getProviderFullDetails($staff_data->vendor_id,$language);
                        
                    if($vendor_data){
                        $data = array('title' => 'Job Completed', 
                                      'description'  => "Hi {$vendor_data->company_name}, Job " . $job_data->job_request_display_id . " has been completed by ". $staff_full_name  ,
                                      'ntype'  => 'vendor_notification',
                                      'service_type_name' => $job_data->service_type_name,
                                      'orderID' => (string)  $job_data->assign_job_provider_id,
                                      'type'    => "Job-complete-request",
                                      'clickAction' => 'vendor_notification',
                            );
                            
                            $this->sendPushNotmification($vendor_data,$data);
                            // print_r($data);exit;
                    }

                    if($customer_data){
                            $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;
                            $data = array('title' => 'Job Completed', 
                                      'description'  => "Hi {$customer_full_name}, your Job  " . $job_data->job_request_display_id . " is completed by ". $staff_full_name ,
                                      'ntype'  => 'vendor_notification',
                                      'service_type_name' => $job_data->service_type_name,
                                      'orderID' => (string) $job_request_id,
                                      'type'    => "Job-complete-request",
                                      'clickAction' => 'notification',
                            );
                            
                            $this->sendPushNotmification($customer_data,$data);
                        }
                        if($staff_data){
                            $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                            $data = array('title' => 'Job Completed', 
                                      'description'  => "Hi ".$staff_full_name.",  You have completed the job " . $job_data->job_request_display_id . " assigned by ". $vendor_data->company_name,
                                      'ntype'  => 'staff_notification',
                                      'service_type_name' => $job_data->service_type_name,
                                      'orderID' => (string) $job_request_id,
                                      'type'    => "Job-completed",
                                      'clickAction' => 'notification'
                                );
                            $this->sendPushNotmification($staff_data,$data);        
                        }
                        
                        
                        $status     = "1";
                        $message    = "Job finished succesfully";
                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
             ] ));

    }

    public function staff_job_finish_confirm() {

        $status     = "0";
        $message    = "";
        $o_data     = [];
        
        $access_token    = trim($this->input->post("access_token"));  
        $user_token_data = AUTHORIZATION::validateToken($access_token);


        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {

            $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
            if ($this->form_validation->run() == TRUE) {

                $job_request_id = $this->input->post("job_request_id");
                $job_data = $this->model_staff->get_job(["job_status" => 4, "staff_jobs.job_request_id" => $job_request_id]);

                if($job_data) {

                    $this->model_staff->update_job([ "customer_job_approve_status" => 2, "job_customer_approved_finished_at" => date("Y-m-d H:i:s")],["job_request_id" => $job_request_id]);

                    $staff_data = $this->model_staff->get_user_data([ "user_id" => $user_token_data->user_id]);
                    $vendor_data = $this->model_staff->get_user_data([ "user_id" => $staff_data->vendor_id]);
                    $customer_data = $this->model_staff->get_user_data([ "user_id" => $job_data->user_id]);

                    if($vendor_data && $customer_data) {

                        $staff_full_name = $staff_data->user_first_name ." ".$staff_data->user_last_name;
                        $vendor_full_name = $vendor_data->user_first_name ." ".$vendor_data->user_last_name;
                        $customer_full_name = $customer_data->user_first_name ." ".$customer_data->user_last_name;

                        $this->fcm_notification->send_notification($staff_data->fcm_token,[
                            "title"=>"Customer Confirmed Job Completion",
                            "body"=>"Hi {$staff_full_name}, Customer " .$customer_full_name ." has approved your Job completion request for job " . $job_data->job_request_display_id,
                            "icon"=>'myicon',
                            "sound" =>'default'],
                            [
                                "type" => "job_finish_confirmed",
                                "job_request_id" => $job_data->job_request_id,
                            ]);

                        $this->fcm_notification->send_notification($vendor_data->fcm_token,[
                            "title"=>"Customer Confirmed Job Completion",
                            "body"=>"Hi {$vendor_full_name}, Customer " .$customer_full_name ." has marked  Job  " .$job_data->job_request_display_id ." as completed ",
                            "icon"=>'myicon',
                            "sound" =>'default'],
                            [
                                "type" => "job_finish_confirmed",
                                "job_request_id" => $job_data->job_request_id,
                            ]);

                        $status     = "1";
                        $message    = "Job marked as finished";
                    } 
                    else {
                        $status     = "2";
                        $message    = "There is some issue with your job selected";
                    }

                   
                }
                else {
                    $status     = "2";
                    $message    = "invalid job id";
                }
            }
            else {
                $status     = "2";
                $message    = strip_tags(validation_errors());

                $form_input_errors = [
                    "job_request_id" => form_error('job_request_id'),
                ];
            }
        }
        else {

            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
             ] ));

    }
    
    
    public function getStaffJobList(){

        $status     = "0";
        $message    = "";
        $o_data     = [
            "job_list"          => [],
            "job_list_count"    => "0",
        ];
        
        $all_muted  = "0";
        $user_timezone = $this->input->post('timezone');
        
        $language = $this->input->post('language')?$this->input->post('language'): 1;
        $user_timezone  = !empty($user_timezone) ? $user_timezone : date_default_timezone_get();

        $access_token   = trim($this->input->post("access_token"));  
        
        $user_token_data = AUTHORIZATION::validateToken($access_token);
        if ( $user_token_data 
             && $this->common_functions->validateAccessToken(md5($access_token)) 
             && property_exists($user_token_data, "user_type") 
             && $user_token_data->user_type == 3 ) {
            
            $user_id = $user_token_data->user_id; 
            $limit  = (int) $this->input->post("limit");
            $page   = (int) $this->input->post("page");

            $page   = ($page <= 0) ? 1 : $page;
            $limit  = ($limit <= 0) ? 10 : $limit;
            $offset = ($page - 1) * $limit;

            $status = $this->input->post("status");
            $sort_key = $this->input->post('sort_key');

            $search_params = compact('user_id','status','language');
            $jobs_list = $this->model_staff->get_job_list($search_params,$sort_key,$limit,$offset);
            $all_muted = (string) $this->model_staff->getMuteStatus($user_id);
    
            if($jobs_list){
                $status = "1";
                foreach ($jobs_list as $key => $row) {
                    $jobs_list[$key]= $this->process_job_request($row, $user_timezone);
                }
                $o_data     = [
                    "job_list"          => $jobs_list,
                    "job_list_count"    => count($jobs_list),
                ];
            }else{
                $status = "1";
                $message = "No data found";
            }
            

        }else{
            
            $status     = "4";
            $message    = $this->lang->line("user_session_expire");

            $this->output->set_status_header(401);
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode( [
                 "status" => $status,
                 "message" => $message,
                 "data" =>  $o_data,
                 "all_muted" => $all_muted,
             ] ));
    } 
    
    
    public function updateGobDate(){
        
        $this->db->select('*');
        $result = $this->db->get('job_request')->result();
        foreach($result as $row){
            if($row->job_validity_date == '20201-03-07'){
                
                $date = date_create('2021-03-07');//date('Y-m-d');//
                $date = date_format($date,'Y-m-d');
                $o_data['job_date'] = $date;
                $o_data['job_validity_date'] = $date;
                // print_r($date);exit;
                $this->db->where('job_request_id',$row->job_request_id);
                // $this->db->set('job_date',$o_data);
                $this->db->update('job_request',$o_data);
            }
        }
        $this->db->select('*');
        $result = $this->db->get('job_request')->result();
        echo "<pre>",print_r($result);
    }


    private function sendPushNotmification($user_fcm,$data){

        $notification_id = time();

        if (!empty($user_fcm->firebase_user_key)) {
            $notification_data["Notifications/".$user_fcm->firebase_user_key."/".$notification_id] = [
                            "title" => $data['title'],
                            "description" => $data['description'],
                            "notificationType" => $data['ntype'],
                            "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                            "orderID" => (string) $data['orderID'],
                            "service_type_name" => $data['service_type_name'],
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
                            "title" => $data['title'],
                            "body" => $data['description'],
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => $data['clickAction']],
                            ["type" => $data['type'],
                            "notificationID" => $notification_id,
                            "orderID" => (string) $data['orderID'],
                            "service_type_name" => $data['service_type_name'],
                            "imageURL" => ""
                        ]);
                    }
                    
    }
    
} 
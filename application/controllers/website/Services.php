<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('website/M_request');        
		$this->load->model('website/M_common');           
		error_reporting(E_ERROR | E_PARSE);
		load_user_language();
		$this->load->library("FCM_Notification");
		$this->load->helper('eq_helper'); 
	}

	public function services_list()
	{
		$this->load->model('M_admin');

		$language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
	     
     	if($language==2)
     		$this->lang->load("web","arabic");
        else
            $this->lang->load("web","english");

		$data = [];

		$con2['is_home_category']          	=  0;
		$con2['service_type_status']        =  1;
		$con2['service_type_language_code'] =  $language;
		$popular_cate                       =   $this->M_common->getServiceTypes($con2);

		foreach ($popular_cate as $key => $value)
		{
            $subServices    = $this->M_common->getSubServices($value->service_type_id);
            $popular_cate[$key]->is_sub = count($subServices);
        }

        $data['popular_cate'] = $popular_cate;

        $conLabe['home_labels_status'] =1;
		$data['labels']       =   $this->M_admin->getHomeLabels($conLabe);

		$this->load->view("header");
        $this->load->view("services_list",$data);
        $this->load->view("footer");
	}
}
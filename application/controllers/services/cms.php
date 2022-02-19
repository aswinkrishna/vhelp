<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cms extends CI_Controller {


	public function __construct()
     {
         parent::__construct();
         $this->load->model('services/M_user');      
         $this->load->model('M_common');  
         error_reporting(E_ERROR | E_PARSE);
        // header('Content-Type: application/json');
        $this->load->helper('eq_helper');  
     }

     public function page(){
     	$output['status']   =  "0";
        $output['message']  =  '';  

     	$this->form_validation->set_rules('uid', 'uid', 'trim|required|xss_clean');
     	if ( $this->form_validation->run() !== FALSE ) {
     		$uid = (string) $this->input->post('uid', true);
     		$output['data']['article'] = $this->M_common->getArticles($uid);
     	}else{
     		$output['status']   =  "0";
            $output['message']  =  strip_tags(validation_errors());                   
     	}

     	echo json_encode($output);
     }
}
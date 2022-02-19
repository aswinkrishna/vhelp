<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
    public function __construct(){
         parent::__construct();
         $this->load->model('services/Home_model');      
         $this->load->model('M_admin');  
         $this->load->model('M_common');  
         error_reporting(E_ERROR | E_PARSE);
        // header('Content-Type: application/json');
        $this->load->helper('eq_helper');  
    }

    public function index(){

    	$output['status']   =  "1";
        $output['message']  =  ""; 

        $appSliders = $this->Home_model->getAppSlider();
        // print_r($appSliders);exit;
        $appSlider  = [];
        foreach ($appSliders as $key => $value) {
            $appSlider[$key]->slider_id = $value->slider_id;
        	$image = 'uploads/app_slider/'.$value->slider_image;
        	if (file_exists($image) && is_file($image))
        		$image = base_url().$image;
        	else
        		$image = '';
        	$appSlider[$key]->slider_image = $image;
        	
        	if($value->slider_service_type){
        	    
        	    if($this->Home_model->checkSubServices($value->slider_service_type))
        	        $appSlider[$key]->target = '2';
        	    else
        	        $appSlider[$key]->target = '1';
        	   
        	    $appSlider[$key]->slider_service_id = $value->slider_service_type;
        	    if($value->service_type_name){
                    $appSlider[$key]->title  = $value->service_type_name;
                    $appSlider[$key]->service_type_name = strtoupper($value->service_type_name);
                }else{
                    $appSlider[$key]->title  = "";
                    $appSlider[$key]->service_type_name = "";
                }
        	}else{
        	    $appSlider[$key]->slider_service_id = "0";
        	    $appSlider[$key]->target = '0';
        	    $appSlider[$key]->title  = "";
        	}
            $appSlider[$key]->slider_title  = $value->slider_title;
        }
        //  print_r($appSlider);exit;
        
        $share_link         = $this->M_user->getShareLinks();
        
        $output['data']['twitter_link'] = $share_link->twitter_link;
        $output['data']['fb_link'] = $share_link->fb_link;
        $output['data']['google_link'] = $share_link->google_link;
        $output['data']['twitter_link'] = $share_link->twitter_link;
        $output['data']['youtube_link'] = $share_link->youtube_link;
        $output['data']['insta_link'] = $share_link->insta_link;
        $output['data']['snapchat_link'] = $share_link->snapchat_link;
        
        $output['data']['app_slider'] = $appSlider;

        $popular_service_list = $this->Home_model->getPopularServices(8);
        // echo count($popular_service_list);exit;
        // print_r($share_link);exit;
        foreach ($popular_service_list as $key => $value) {
            $popular_service_list[$key]->service_type_name = strtoupper($value->service_type_name);
            $popular_service_list[$key]->is_sub = (string) $this->Home_model->checkSubServices($value->service_type_id);
            
        	$icon = 'uploads/service_type/'.$value->service_type_icon;
        	if(file_exists($icon) && is_file($icon))
        		$icon = base_url().$icon;
        	else
        	 	$icon = "";
        	$popular_service_list[$key]->service_type_icon = $icon;

        	$banner = 'uploads/service_type/'.$value->service_type_banner_image;
        	if(file_exists($banner) && is_file($banner))
        		$banner = base_url().$banner;
        	else
        		$banner = '';
        	$popular_service_list[$key]->service_type_banner_image = $banner;

        	$thumbnail = 'uploads/service_type/'.$value->service_type_thumbnail;

        	if(file_exists($thumbnail) && is_file($thumbnail))
        		$thumbnail = base_url().$thumbnail;
        	else
        		$thumbnail = '';

        	$popular_service_list[$key]->service_type_thumbnail = $thumbnail;

        	    
        }
       $promotionSliders = $this->Home_model->getPromotionSlider();
        // print_r($promotionSliders);exit;
        $promotionSliderList  = [];
        foreach ($promotionSliders as $key => $value) {
            $image = 'uploads/app_slider/'.$value['slider_image'];
            if (file_exists($image) && is_file($image))
                $image = base_url().$image;
            else
                $image = '';
            $value['slider_image'] = $image;
            unset($value['created_on']);
            if($value['slider_service_type']){
                 if($this->Home_model->checkSubServices($value['slider_service_type']))
                    $value['target'] = '2';
                else
                    $value['target'] = '1';
            } else {
                 $value['target'] = '0';
            }
            $promotionSliderList[]  = $value;

        }
        $output['data']['promotionSliders'] = $promotionSliderList;
        $output['data']['popular_service'] = $popular_service_list;
        echo json_encode($output);exit;   
    }

    public function service_list(){

    	$output['status']   =  "1";
        $output['message']  =  "";

        $service_type_id = $this->input->post('service_type_id');
        $parent_id		 = $this->input->post('parent_id');
        
        if($parent_id > 0 ){
            $output['how_works'] = $this->Home_model->getHowItsWork($parent_id);
            
            foreach($output['how_works'] as $key=> $value){
                $image = "uploads/service_type/".$value->image;
                if(file_exists($image) && is_file($image))
                    $image = base_url().$image;
                else
                    $image = base_url().'template/images/howitworks-1.png';
                $output['how_works'][$key]->image = $image;
            }
            
            $service_details     = $this->Home_model->getServiceDetails($parent_id);
            $icon                = 'uploads/service_type/'.$service_details->service_type_icon;
            if(file_exists($icon) && is_file($icon))
                $icon  = base_url().$icon;
            else
                $icon   = base_url().'uploads/dummy_icon';
            $service_details->service_type_icon = $icon;
            $output['service_details']  = $service_details;
            
            $slider_images_list              = $this->Home_model->getSliderList($parent_id);
            $slider_images              = [];
            foreach($slider_images_list as $key=>$Value){
                $image  = "uploads/service_type/".$Value->image;
                if(file_exists($image) && is_file($image))
                    $image  = base_url().$image;
                else
                    $image   = base_url().'uploads/banner-dummy.jpg';
                $slider_images[$key]       =   $image;
            }
            $output['service_details']->slider_images = $slider_images;
        }
        
        $language   = ($this->input->post('language')>0?$this->input->post('language'):1);
        $search_key = $this->input->post('search_key');
        $param['search_key']    = $search_key;
        $param['language']      = $language;
        // echo $service_type_id;exit();
        $service_list = $this->Home_model->getAllServiceList($service_type_id,$parent_id,$param);
    //   print_r($this->db->last_query());exit;
        $output['data']['service_list'] = $this->process_services_type($service_list);
        echo json_encode($output);
    }

    public function services_question(){
        $output['status']   =  "0";
        $output['message']  =  "";
        
    	$this->form_validation->set_rules('service_type_id', 'service_type_id', 'required|numeric');

    	if ($this->form_validation->run() == FALSE){
    	    
            $output['errors'] = array('service_type_id' => form_error('service_type_id'));                  
            echo json_encode($output);
            exit;
        }else{
            
            $output['status']   = '1';
            
        	$language = $this->session->userdata('language')>0?$this->session->userdata('language'):1;
        	$con2              = ['language'=> $language,
        						  'questions_service_type_id'=> $this->input->post('service_type_id'),
        						  'question_parent_id'       => $this->input->post('question_parent_id'),
        						  'answer_options_id'        => $this->input->post('answer_options_id'),
        						  'question_status'          => 1,
        						];
        // 	print_r($con2);exit;
        	$service_questions = $this->Home_model->getQuestionsWithService($con2); 
        
        	if($service_questions){
        		$answer_option = $this->Home_model->getAnswerOption($service_questions->question_id);
        		foreach($answer_option as $key1 => $value1){
        		    $answer_option[$key1]->is_sub =(string) $this->Home_model->checkAnsSubQuestion($value1->answer_options_id,$service_questions->question_id);
        		  //  echo $this->db->last_query();exit;
        		}
        		$service_questions->options = $answer_option;
        
        	}

        	$output['data'] =  $service_questions; //$this->process_services_type($service_questions);
        	
        	echo json_encode($output);
        }
    }



    public function process_services_type($service_list){

    	foreach ($service_list as $key => $value) {
    	    
    	    $service_list[$key]->service_type_name = strtoupper($value->service_type_name);
        	$icon = 'uploads/service_type/'.$value->service_type_icon;
        	if(file_exists($icon) && is_file($icon))
        		$icon = base_url().$icon;
        	else
        	 	$icon = "";
        	$service_list[$key]->service_type_icon = $icon;
        	$service_list[$key]->is_sub = (string) $this->Home_model->checkSubServices($value->service_type_id);

        	$banner = 'uploads/service_type/'.$value->service_type_banner_image;
        	if(file_exists($banner) && is_file($banner))
        		$banner = base_url().$banner;
        	else
        		$banner = '';
        	$service_list[$key]->service_type_banner_image = $banner;

        	$thumbnail = 'uploads/service_type/'.$value->service_type_thumbnail;

        	if(file_exists($thumbnail) && is_file($thumbnail))
        		$thumbnail = base_url().$thumbnail;
        	else
        		$thumbnail = '';

        	$service_list[$key]->service_type_thumbnail = $thumbnail;
        	
        }
        return $service_list;
    }

    
    public function page(){
     	$output['status']   =  "0";
        $output['message']  =  '';  

     	$this->form_validation->set_rules('uid', 'uid', 'trim|required|xss_clean');
     	if ( $this->form_validation->run() !== FALSE ) {
     	    $output['status'] = "1";
     		$uid     = (string) $this->input->post('uid', true);
     		$data = $this->M_common->getArticles($uid);

            $data->articles_desc= html_entity_decode($data->articles_desc);
            $data->articles_desc= htmlentities($data->articles_desc);
            $data->articles_desc= htmlspecialchars_decode($data->articles_desc);

            // $data->articles_desc = utf8_decode($data->articles_desc);
            // $data->articles_desc = str_replace("&nbsp;", " ", $data->articles_desc);
            // $data->articles_desc = str_replace(, "", $data->articles_desc);
            $data->articles_desc = preg_replace("/\s+/", " ", $data->articles_desc);

            $output['data']     = $data;
     	}else{
     		$output['status']   =  "0";
            $output['message']  =  strip_tags(validation_errors());                   
     	}

     	echo json_encode($output);
     }
     
     public function getServiceRating(){
         
        $output['status']   =  "1";
        $output['message']  =  ''; 
        
        
        $service_type_id    = $this->input->post('service_type_id');
        $sub_service_list   = $this->Home_model->getSubServices($service_type_id);
        $service_ids = [];
        foreach($sub_service_list as $key => $value){
            $service_ids[$key] = $value->service_type_id;
        }
        $service_ids[$key+1]        = $service_type_id;
        
        $rating_count               = count($this->Home_model->get_rating_list($service_ids));
        $output['rating_count']     = $rating_count;
        
        $output['data']['rating']   = $this->Home_model->get_seller_ratings_summary($service_ids);
        $page                       = $this->input->post('page');
        if($page){
            $limit_per_page             =     8;
            $start_index                =     ($page > 0 ? $page  * $limit_per_page : 0);
            $rating_list_temp           = $this->Home_model->get_rating_list($service_ids,$limit_per_page,$start_index);
        }else{
            $rating_list_temp           = $this->Home_model->get_rating_list($service_ids);
        }
        
        $rating_list                = [];
        if($rating_count > 0 ){
            foreach($rating_list_temp as $key => $value){
                $temp_data  =   [];
                $temp_data['user_name']     = $value->user_first_name.' '.$value->user_last_name;
                $temp_data['rated_date']    = date('d M Y',strtotime($value->date));
                $temp_data['user_rating']   = $value->user_rating;
                $temp_data['title']         = $value->title;
                $temp_data['feedback']      = $value->feedback;
                
                $image                      = 'uploads/user/'.$value->user_image;
                
                if(file_exists($image) && is_file($image))
                    $image  = base_url().$image;
                else
                    $image  = base_url().'uploads/user_dummy.png';
                    
                $temp_data['user_image']         = $image;
                
                $rating_list[] =  $temp_data; 
            }
            $output['data']['rating_list']      =  $rating_list;
        }else{
            $output['status']   =  "0";
            $output['message']  =  ''; 
            $rating_list = (object) [];
        }
        
        echo json_encode($output);
     }

    public function weekdays()
    {
        $output['status']   =  "1";
        $output['message']  =  "success";
            
        $weekdays       = $this->config->item('weekdays','app');
        $days           = [];       
        foreach($weekdays as $key=>$day)
        {
            $days[]     = ["id"=>$key,"day"=>$day];
        } 
        $output['data'] = $days;
        echo json_encode($output);
    }     
}
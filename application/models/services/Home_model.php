<?php 
class Home_model extends CI_Model {

	public function getAllServiceList($service_type_id,$parent_id,$param){
		$language   =   $param['language'];
		if($param['search_key']){
		    $search_key = strtolower($param['search_key']);
		     $this->db->like('LOWER(service_type_name)', $search_key );     //like('service_type_name',$param['search_key']);
		}else{
		    if($parent_id <= 0 )
		        $this->db->where('service_type_parent_id',0);
		}
		   
		
		if($service_type_id)
			$this->db->where('service_type_id',$service_type_id);

		if($parent_id > 0 )
			$this->db->where('service_type_parent_id',$parent_id);

		$this->db->select('*');
		$this->db->where('service_type_status',1);
		$this->db->where("service_type_language_code",$language);
		$this->db->order_by('service_type_name','asc');
		return	$this->db->get('service_type')->result();
	}

// 	public function getAppSlider($language = 1){

// 		$this->db->select('app_slider.*,service_type.service_type_name,s2.service_type_id as sub_service_type_id,s2.service_type_name as sub_service_type_name');
// 		$this->db->where('slider_status',1);
// 		$this->db->join('service_type','service_type.service_type_id = app_slider.slider_service_type','left');
// 		$this->db->join('service_type s2','s2.service_type_parent_id=service_type.service_type_id','left');
// 		$this->db->where('service_type.service_type_language_code',$language);
// 		$this->db->where('s2.service_type_language_code',$language);
// 		return $this->db->get('app_slider')->result();
		 
// 	}

    public function getAppSlider($language = 1){
        
        $this->db->select('app_slider.*,service_type.service_type_name');
        $this->db->where('slider_status',1);
        $this->db->join('service_type ', 'service_type.service_type_id = app_slider.slider_service_type and service_type.service_type_language_code = '.$language, 'left');
        $this->db->order_by('slider_id','desc');
        return $this->db->get('app_slider')->result();
    }

	public function getPopularServices($limit,$language = 1){
		$this->db->select('*');
// 		$this->db->where('is_home_category',1);
		$this->db->where('service_type_status',1);
		$this->db->where('service_type_parent_id',0);
		$this->db->limit($limit);
        $this->db->where('service_type_language_code',$language);
        $this->db->order_by('service_type_name','asc');
		return $this->db->get('service_type')->result();
	}
    
    public function getQuestionsWithService($data){
        $this->db->select('*');
        $this->db->from('question c');  
        if($data['questions_service_type_id']>0){
			$this->db->where('c.questions_service_type_id',$data['questions_service_type_id']);
        }
        $this->db->join('service_type c2','c2.service_type_id =c.questions_service_type_id','left');
        
        if($data['question_parent_id'] > 0)
            $this->db->where('c.question_parent_id',$data['question_parent_id']);
        else
            $this->db->where('c.question_parent_id',0);
            
        if($data['answer_options_id'] > 0 )
            $this->db->where('answer_parent_id',$data['answer_options_id']);
        $this->db->where('question_status',1);
            
        return $this->db->get()->row();
    }
    
	function getQuestionsWithService_old($data){
                    // print_r($data);
		$language =($data['language']>0?$data['language']:1);       
         //exit;
                     
        $this->db->select('*');
        $this->db->from('question c');  
        $this->db->join('service_type c2','c2.service_type_id =c.questions_service_type_id','left'); 
        // $this->db->join('form_controls c3','c3.form_control_id =c.question_form_type','left'); 
        $this->db->where('c2.service_type_language_code',$language);          
        if($data['questions_service_type_id']>0){
			$this->db->where('c2.service_type_id',$data['questions_service_type_id']);
        }
        if($data['question_parent_id'] > 0)
            $this->db->where('c.question_parent_id',$data['question_parent_id']);
        else
            $this->db->where('c.question_parent_id',0);
        $this->db->order_by('c.question_id','desc');
        // $this->db->limit($limit, $start);
       
        return $this->db->get()->row();
	}

	public function getAnswerOption($question_id){

		$this->db->select('*');
		$this->db->where('question_id',$question_id);
		$this->db->where('answer_options_status',1);
		return $this->db->get('answer_options')->result();
	}
	
	public function checkAnsSubQuestion($answer_options_id,$question_id){
	    $this->db->select('*');
	    $this->db->from('question');
	    $this->db->where('question_parent_id',$question_id);
	    $this->db->where('answer_parent_id',$answer_options_id);
	    $this->db->where('question_status',1);
	    $result = $this->db->get()->num_rows();
	    if($result > 0)
	        return 1;
	    else
	        return 0;
	}
	
	public function checkSubServices($service_type_id){
	    $this->db->select('*');
	    $this->db->where('service_type_parent_id',$service_type_id);
	    $this->db->where('service_type_status',1);
	    $result = $this->db->get('service_type')->num_rows();
	    if($result > 0)
	        return 1;
	    else
	        return 0;
	}
	
	public function get_seller_ratings_summary($service_ids) {
        $this->db->where_in('service_type_id',$service_ids);
        $this->db->select("round((sum(user_rating) / count(user_rating))::numeric,1) as rating,
                                    count(user_rating) as rated_users");
        return $this->db->get('user_rating_for_seller')->row();
    }
	
	public function get_rating_list($service_ids,$limi_per_page = 0,$start_index = 0 ){
        $this->db->select('*');
        $this->db->where_in('service_type_id',$service_ids);
        $this->db->join('user_table','user_table.user_id = urs.user_id','left');
        
        if($limi_per_page > 0 )
            $this->db->limit($limi_per_page,$start_index);
            
        return $this->db->get('user_rating_for_seller urs')->result();
    }
	
	public function getServiceList($service_type_id){
	    $this->db->select('*');
	    $this->db->where('service_type_id',$service_type_id);
	    return $this->db->get('service_type')->row();
	}
	
	public function getSubServices($service_type_parent_id){
            $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
            
            $this->db->select('*');
            $this->db->where('service_type_parent_id',$service_type_parent_id);
            $this->db->where('service_type_language_code',$language);
            return $this->db->get('service_type')->result();
    }
    
    public function getHowItsWork($service_type_id){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get('how_its_work')->result();
    }
    
    public function getServiceDetails($service_type_id , $language = 1){
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('service_type')->row();
    }
    
    public function getSliderList($service_type_id){
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('type',1);
        return $this->db->get('service_type_baner_image')->result();
    }

    public function getPromotionSlider($language = 1){
        
        $this->db->select('promotion_slider.*,service_type.service_type_name');
        $this->db->where('slider_status',1);
        $this->db->join('service_type ', 'service_type.service_type_id = promotion_slider.slider_service_type and service_type.service_type_language_code = '.$language, 'left');
        $this->db->order_by('slider_id','desc');
        return $this->db->get('promotion_slider')->result_array();
    }
}
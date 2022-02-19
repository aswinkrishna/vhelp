<?php 
class M_vendor extends CI_Model {

	public function getJobRequestCount($user_id){
		$this->db->select('*');
		$this->db->where('provider_id',$user_id);
		return $this->db->get('assign_job_provider')->num_rows();
	}

	public function getJobRequestList($search_param,$sort,$limit =10,$offset){
        
        $this->db->select('*');
        
        
            
        if($sort == 'asc')
            $this->db->order_by('st.service_type_name','asc');
        else if($sort == 'desc')
            $this->db->order_by('st.service_type_name','desc');
        else if($sort == 'price_low')
            $this->db->order_by('grand_total','asc');
        else if($sort == 'price_high')
            $this->db->order_by('grand_total','desc');
        else if($sort == 'order_asc')
            $this->db->order_by('aj.assign_job_provider_id','asc');
        else if($sort == 'order_desc')
            $this->db->order_by('aj.assign_job_provider_id','desc');
        else
            $this->db->order_by('aj.assign_job_provider_id','desc');
            
        if($search_param['status']){
            if($search_param['status'] == 1 ){
                $this->db->where_in('assign_status',[1,3,4]);
                
            }else if($search_param['status'] == 3 ){
                $this->db->where('assign_status',5);
            }
        }else{
             $this->db->where('assign_status',0);
        }
        
        
        
        $this->db->where('provider_id',$search_param['user_id']);
        $this->db->join('job_request jr','jr.job_request_id = aj.job_request_id','left');
        $this->db->join('service_type st','st.service_type_id = jr.service_type_id','left');
        $this->db->where('st.service_type_language_code',$search_param['language']);
        $this->db->join('user_table ut','ut.user_id = jr.user_id','left');
        
        if ( $limit && $limit > 0 ) { 
                if ( $offset && $offset > 0 ) {
                    $this->db->limit($limit, $offset);
                } else {
                    $this->db->limit($limit);
                }
            }
        
        
        return $this->db->get('assign_job_provider aj')->result();
	}
	
	public function updateRequestStatus($user_id,$status,$assign_job_provider_id){

		$this->db->select('job_request_id');
		$this->db->where('assign_job_provider_id',$assign_job_provider_id);
		$result = $this->db->get('assign_job_provider')->row();
		$job_request_id = $result->job_request_id;
		
		$this->db->select('*');
		$this->db->where('job_request_id',$job_request_id);
		$this->db->where_in('job_request_status',[1,10]);
		$job_accepted = $this->db->get('job_request')->row();
// 		print_r($job_accepted);exit;
		if($job_accepted){
		    
		    if($job_accepted->job_request_status == 10 ){
		        return -2;exit;
		    }else{
			    return -1;exit;
		    }
		}

		$this->db->trans_start();  

		if($status == 1 ){

			$this->db->where('job_request_id',$job_request_id);
			$this->db->set('job_request_status',1);
			$this->db->update('job_request');

			$this->db->where('assign_job_provider_id',$assign_job_provider_id);
			$this->db->set('assign_status',$status);
			$this->db->update('assign_job_provider');

			$this->db->where('job_request_id',$job_request_id);
			$this->db->where('assign_status',0);
			$this->db->delete('assign_job_provider');
			
			$this->db->where('job_request_id',$job_request_id);
			$this->db->set('vendor_id',$user_id);
			$this->db->update('job_request');
			
		}else{

			$this->db->where('assign_job_provider_id',$assign_job_provider_id);
			$this->db->set('assign_status',$status);
			$this->db->update('assign_job_provider');
		}


		$this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE){
        	return 0;
		}else{
            return 1;
        }
	}
	
	public function updateMuteStatus($user_id,$assign_job_provider_id){

		$this->db->where('provider_id',$user_id);
		$this->db->where('assign_job_provider_id',$assign_job_provider_id);
		$this->db->set('muted_status',1);
		$this->db->update('assign_job_provider');
		if($this->db->affected_rows()){
			return 1;
		}else{
			return 0;
		}
	}

	public function getMuteStatus($user_id){
        $date = date('Y-m-d');
        
		$this->db->select('*');
		$this->db->where('provider_id',$user_id);
		$this->db->where('muted_status',0);
// 		$this->db->where('assigned_date >=',$date);
		$result =	$this->db->get('assign_job_provider')->num_rows();
        // echo $user_id; print_r($result);exit;
		if($result > 0)
			return 0;
		else
			return 1;
	}
	
	public function getVendorJobSummary($assign_job_provider_id,$user_id,$language = 1){
	    
		$this->db->select('*,aj.job_request_id as job_request_id,aj.muted_status as muted_status');
		$this->db->where('aj.assign_job_provider_id',$assign_job_provider_id);
// 		$this->db->where('provider_id',$user_id);
		$this->db->join('job_request jr','jr.job_request_id = aj.job_request_id','left');
		$this->db->join('staff_jobs sj','sj.job_request_id = aj.job_request_id','left');
		$this->db->join('service_type','service_type.service_type_id = jr.service_type_id and service_type_language_code ='.$language,'left');
// 		$this->db->where('service_type_language_code',$language);
		$this->db->join('user_table','user_table.user_id = jr.user_id','left');
		return $this->db->get('assign_job_provider aj')->row();
	}
	
	
	public function getAllParentServices($service_type_id){
	    $this->db->select('*');
	    $this->db->where('service_type_id',$service_type_id);
	    return $this->db->get('service_type')->row();
	}
	
	public function getAllVendorList($user_id){

		$this->db->select('*');
		$this->db->where('user_status',1);
		$this->db->where('vendor_id',$user_id);
		$this->db->where('user_type',3);
		$this->db->order_by('user_id','desc');
		return $this->db->get('user_table')->result();
	}
	
	public function getAssignedStaffDetails($job_request_id){
	    
	    $this->db->select('*');
	    $this->db->where('job_request_id',$job_request_id);
	    $this->db->where('job_status !=',2);
	    $this->db->join('user_table','user_table.user_id = staff_jobs.staff_id','left');
	    return $this->db->get('staff_jobs')->row();
	}
	
	public function getQuestionsAgainstJobRequest($job_request_id){
	   
	    $this->db->select('question.question_id,question.question,question.question_arb,answer_options.answer_options_id,answer_options.answer_option,answer_options.answer_option_arabic');
	    $this->db->where('job_request_id',$job_request_id);
	    $this->db->join('question','question.question_id = request_question_option.question_id','left');
	    $this->db->join('answer_options','answer_options.answer_options_id = request_question_option.answer','left');
	    return $this->db->get('request_question_option')->result();
	}
	
	public function assignStaff($data){
	    
	    $result = $this->checkStaffCountry($data['staff_id'],$data['job_request_id']);
		if($result==false)
	    	return -1;
	    
	    $this->db->where('job_request_id',$data['job_request_id']);
		$this->db->where('staff_id',$data['staff_id']);
		$this->db->where('job_day_id',$data['job_day_id']);
		$this->db->delete('staff_jobs');

		$this->db->insert('staff_jobs',$data);
		return $this->db->insert_id();
		
	}
	
	public function checkStaffCountry($staff_id,$job_request_id){

		$this->db->select('*');
		$this->db->where('user_id',$staff_id);
		$staff_details 	= $this->db->get('user_table')->row();

		$this->db->select('*');
		$this->db->where('job_request_id',$job_request_id);
		$this->db->join('user_adresses','user_adresses.user_adresses_id = job_request.address_id','left');
		$user_details = $this->db->get('job_request')->row();
        
        return true;
		if($staff_details->country_id == $user_details->user_adresses_country)
			return true;
		else
			return false;
	}
	
	public function getServiceByJobRequestId($job_request_id){

		$this->db->select('*');
		$this->db->where('job_request_id',$job_request_id);
		$this->db->join('service_type','service_type.service_type_id = job_request.service_type_id');
		return $this->db->get('job_request')->row();
	}
	
	public function getUserByAssignJobProviderId($assign_job_provider_id){

		$this->db->select('*');
		$this->db->where('assign_job_provider_id',$assign_job_provider_id);
		$this->db->join('job_request','job_request.job_request_id = aj.job_request_id','left');
		$this->db->join('user_table','user_table.user_id = job_request.user_id','left');
		return $this->db->get('assign_job_provider aj')->row();
	}
	
	public function getJobDetails($job_request_id){
	    $this->db->select('*');
	    $this->db->where('job_request_id',$job_request_id);
	    return $this->db->get('job_request')->row();
	}
	
	public function getVendorJobDetails($job_request_id,$provider_id){
	    $this->db->select('*');
	    $this->db->where('job_request_id',$job_request_id);
	    $this->db->where('provider_id',$provider_id);
	    return $this->db->get('assign_job_provider')->row();
	}
	
	public function getCompletedJobImage($job_request_id){
        
        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        return $this->db->get('job_images')->result();
    }

    public function get_request_job_days($job_request_id)
    {
    	$this->db->select('job_request_days.*, COALESCE (sj.job_status,-1) as staff_job_status');
        $this->db->where(['job_request_days.job_request_id'=>$job_request_id]);
        $this->db->join('staff_jobs sj','sj.job_day_id = job_request_days.days_id','left');
    	return $this->db->get_where('job_request_days')->result();
    }

    public function getAssignedStaffDetailsDayWise($condition = []){
	    
	    if($condition)
	    {
	    	$this->db->where($condition);
	    }
	    $this->db->select('*');
	    $this->db->where('job_status !=',2);
	    $this->db->join('user_table','user_table.user_id = staff_jobs.staff_id','left');
	    return $this->db->get('staff_jobs')->row();
	}
}
    
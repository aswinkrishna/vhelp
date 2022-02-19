<?php 
class Staff_model extends CI_Model {

    public function get_jobs(array $condition = [], int $limit = 0, int $offset = 10, array $order_by = []) : ? array  {

        if( count($order_by) > 0 )
            $this->db->order_by($order_by[0], $order_by[1]);

        if($limit > 0 && $offset > 0)
            $this->db->limit($limit, $offset);
        else if($limit > 0)
            $this->db->limit($limit);

        return $this->db->select("*")
                        ->from("staff_jobs")
                        ->join("job_request", "staff_jobs.job_request_id = job_request.job_request_id")
                        ->join('service_type','service_type.service_type_id = job_request.service_type_id','left')
                        ->where('service_type_language_code',1)
                        ->where($condition)
                        ->get()
                        ->result();
    }

    public function get_jobs_count(array $condition = []) : ? int  {

        return $this->db->select("count(*) as count")
                        ->from("staff_jobs")
                        ->join("job_request", "staff_jobs.job_request_id = job_request.job_request_id")
                        ->where($condition)
                        ->get()
                        ->row()
                        ->count;
    }

    public function get_job(array $condition) : ? object {

        return $this->db->select("*,staff_jobs.muted_status as muted_status,job_request_days.job_date as job_days_date,job_request_days.job_time as job_days_time,staff_jobs.job_request_id as job_request_id,COALESCE(staff_jobs.job_status,0) as job_status")
                    ->from("staff_jobs")
                    ->join("job_request", "staff_jobs.job_request_id = job_request.job_request_id")
                    ->join("user_table", "user_table.user_id = staff_jobs.staff_id")
                    ->join('assign_job_provider','assign_job_provider.job_request_id = staff_jobs.job_request_id')
                    ->join('service_type','service_type.service_type_id = job_request.service_type_id','left')
                    ->join('job_request_days','job_request_days.days_id = staff_jobs.job_day_id','left')
                    ->where('service_type_language_code',1)
                    ->where('staff_jobs.job_status !=',2)
                    ->where($condition)
                    ->get()
                    ->row();
        
    }

    public function rejectJobRequest_by_day($staff_job_id,$job_day_id){
        $this->db->where('staff_job_id',$staff_job_id);
        $this->db->delete('staff_jobs');

        $this->db->where('days_id',$job_day_id);
        $this->db->update('job_request_days',['job_status'=>0]);
        return $this->db->affected_rows();
    }
    
    public function rejectJobRequest($job_request_id,$user_id){
        $this->db->where('job_request_id',$job_request_id);
        $this->db->where('staff_id',$user_id);
        $this->db->delete('staff_jobs');
        return $this->db->affected_rows();
    }
    
    public function update_job(array $data, array $condition) : ? int {

        $this->db->where( $condition )
                 ->update("staff_jobs", $data);

        return $this->db->affected_rows();
    }

    public function update_job_request_by_day($data,$condition)
    {
        $this->db->where( $condition )
                 ->update("job_request_days", $data);

        return $this->db->affected_rows();
    }

    public function update_job_request(array $data, array $condition) : ? int {

        $this->db->where( $condition )
                 ->update("job_request", $data);

        return $this->db->affected_rows();
    }

    //NOT IN USE
    public function get_job_assign_provider(array $condition) : ? object {
        return $this->db->select("user_table.*")
                        ->from("assign_job_provider")
                        ->join("user_table", "user_table.user_id=assign_job_provider.provider_id")
                        ->get()
                        ->row();

    }

    public function get_job_request_quest_n_options(array $condition) : ? array {
        return $this->db->select("question, question_arb, answer_option, answer_option_arabic")
                        ->from("request_question_option")
                        ->join("question", "question.question_id=request_question_option.question_id")
                        ->join("answer_options", "answer_options.answer_options_id=request_question_option.answer::integer","inner",FALSE)
                        ->where($condition)
                        ->get()
                        ->result();
    }

    public function get_user_data(array $condition) : ? object {
        return $this->db->get_where("user_table", $condition )->row();
    }
    
    public function get_vendor_data_by_id($user_id){
        
        $this->db->select('*');
        $this->db->where('user_table.user_id',$user_id);
        $this->db->join('provider_details','provider_details.user_id = user_table.user_id','left');
        return $this->db->get('user_table')->row();
    }
    
    public function get_job_list($search_params,$sort_key,$limit =10,$offset =NULL){
        
        
        if($sort_key == 'asc')
            $this->db->order_by('staff_job_id','asc');
        else if($sort_key == 'desc')
            $this->db->order_by('staff_job_id','desc');

        else if($sort_key == 'price_low')
            $this->db->order_by('job_total_price','asc');
        else if($sort_key == 'price_high')
            $this->db->order_by('job_total_price','desc');
        else
            $this->db->order_by('staff_job_id','desc');
        
        if ( $limit && $limit > 0 ) { 

            if ( $offset && $offset > 0 ) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }
        
        $this->db->select('*,job_request_days.job_date as job_days_date,job_request_days.job_time as job_days_time,staff_jobs.job_request_id as job_request_id,  COALESCE(staff_jobs.job_status,0) as job_status');
        $this->db->where('staff_jobs.staff_id',$search_params['user_id']);
        $this->db->where('staff_jobs.job_status',$search_params['status']);
        $this->db->join("job_request", "job_request.job_request_id = staff_jobs.job_request_id");
        $this->db->join('service_type','service_type.service_type_id = job_request.service_type_id','left');
        $this->db->join('job_request_days','job_request_days.days_id = staff_jobs.job_day_id','left');
        $this->db->where('service_type_language_code',$search_params['language']);
        $this->db->order_by('staff_jobs.staff_job_id','desc');
        return $this->db->get('staff_jobs')->result();
    }
    
     public function get_job_list_old($search_params,$sort_key,$limit =10,$offset =NULL){

        if($sort_key == 'asc')
            $this->db->order_by('staff_job_id','asc');
        else if($sort_key == 'desc')
            $this->db->order_by('staff_job_id','desc');

        else if($sort_key == 'price_low')
            $this->db->order_by('job_total_price','asc');
        else if($sort_key == 'price_high')
            $this->db->order_by('job_total_price','desc');
        
        if ( $limit && $limit > 0 ) { 

            if ( $offset && $offset > 0 ) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }
        
        

        $this->db->select('*');
        $this->db->from('staff_jobs');
        $this->db->where('staff_id',$search_params['user_id']);
        $this->db->join("job_request", "job_request.job_request_id = job_request.job_request_id");
        $this->db->join('service_type','service_type.service_type_id = job_request.service_type_id','left');
        $this->db->where('service_type_language_code',$search_params['language']);
        $this->db->where('job_status',$search_params['status']);
        return $this->db->get()->result();
    }
    
    public function getMuteStatus($user_id){
        $date = date('Y-m-d');
        
        $this->db->select('*');
        $this->db->where('staff_id',$user_id);
        $this->db->where('muted_status',0);
        $this->db->where('job_status !=',2);
        // $this->db->where('job_assigned_at >=',$date);
        $result =   $this->db->get('staff_jobs')->num_rows();
        // print_r($result);exit;
        if($result > 0)
            return 0;
        else
            return 1;
    }
    
    public function get_user_data_by_job_request_id($job_request_id){

        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->join('user_table','user_table.user_id = job_request.user_id','left');
        return $this->db->get('job_request')->row();
    }
    
    public function getServiceDetailsById($service_type_id,$language= 1){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('service_type')->row();
    }
    
    public function updateJobRequest($job_request_id,$data){
        $this->db->where('job_request_id',$job_request_id);
        $this->db->update('job_request',$data);
        
        return $this->db->affected_rows();
    }
    
    
    public function updateVendorStatus($job_request_id,$status){
        
        $this->db->where('job_request_id',$job_request_id);
        $this->db->set('assign_status',$status);
        $this->db->update('assign_job_provider');
        return $this->db->affected_rows();
    }
    
    public function updateData($table,$condition,$data){
        
        $this->db->where($condition);
        $this->db->update($table,$data);
    }
    
    // public function getCustomerDataByJobRequestId($job_request_id){
        
    //     $this->db->select('*');
    //     $this->db->where('job_request_id',$job_request_id);
    //     $this->db->get('')
    // }
    
    public function updateTimeTaken($time_taken,$job_day_id,$user_id){
        
        $this->db->set('time_taken',$time_taken);
        $this->db->where('days_id',$job_day_id);
        $this->db->update('job_request_days');
    }

    public function updateTimeTaken_old($time_taken,$job_request_id,$user_id){
        
        $this->db->set('time_taken',$time_taken);
        $this->db->where('job_request_id',$job_request_id);
        $this->db->update('job_request');
    }

    public function start_job_request($condition){
      
      $this->db->where('days_id',$condition['job_day_id']);
      $this->db->set('job_status',4);
      $this->db->update('job_request_days');
      
      $this->db->where('job_request_id',$condition['job_request_id']);
      $this->db->set('assign_status',4);
      $this->db->update('assign_job_provider');
      
      $this->db->where('staff_job_id',$condition['staff_job_id']);
      $this->db->set('customer_job_approve_status',1);
      $this->db->set('job_status',3);
      $this->db->set('job_customer_started_approved_at',gmdate('Y-m-d H:i:s'));
      $this->db->where('job_status !=',2);
      $this->db->update('staff_jobs');
     
      return $this->db->affected_rows();
    }
    
    public function start_job_request_old($job_request_id){
      
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('job_request_status',4);
      $this->db->update('job_request');
      
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('assign_status',4);
      $this->db->update('assign_job_provider');
      
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('customer_job_approve_status',1);
      $this->db->set('job_status',3);
      $this->db->set('job_customer_started_approved_at',gmdate('Y-m-d H:i:s'));
      $this->db->where('job_status !=',2);
      $this->db->update('staff_jobs');
     
      return $this->db->affected_rows();
    }

    public function job_finished($condition){
        
      $this->db->where('staff_job_id',$condition['staff_job_id']);
      $this->db->set('customer_job_approve_status',2);
      $this->db->set('job_status',4);
      $this->db->where('job_status !=',2);
      $this->db->set('job_customer_approved_finished_at',gmdate('Y-m-d H:i:s'));
      $this->db->update('staff_jobs');
    
      $this->db->where('job_request_id',$condition['job_request_id']);
      $this->db->set('assign_status','5');
      $this->db->update('assign_job_provider');
    
      $this->db->where('days_id',$condition['job_day_id']);
      $this->db->set('job_status',5);
      $this->db->update('job_request_days');

      return $this->db->affected_rows();
    }
    
    public function job_finished_old($job_request_id){
        
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('customer_job_approve_status',2);
      $this->db->set('job_status',4);
      $this->db->where('job_status !=',2);
      $this->db->set('job_customer_approved_finished_at',gmdate('Y-m-d H:i:s'));
      $this->db->update('staff_jobs');
    
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('assign_status','5');
      $this->db->update('assign_job_provider');
    
      $this->db->where('job_request_id',$job_request_id);
      $this->db->set('job_request_status',5);
    //   $this->db->set('signature',$signature);
      $this->db->update('job_request');

      return $this->db->affected_rows();
    }
    
    public function insertJobImages($job_request_id,$images){
        
        foreach($images as $key => $value){
            $i_data['job_request_id'] = $job_request_id;
            $i_data['image']          = $value;
            $i_data['created_at']     = date('Y-m-d H:i:s');
            
            $this->db->insert('job_images',$i_data);
        }
    }
    
    public function getCompletedJobImage($job_request_id){
        
        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        return $this->db->get('job_images')->result();
    }
}
<?php
class M_request extends CI_Model
{
    function getQuestionsWithService($data)
    {

        $language = ($data['language'] > 0 ? $data['language'] : 1);


        $this->db->select('*');
        $this->db->from('question c');
        $this->db->join('service_type c2', 'c2.service_type_id =c.questions_service_type_id', 'left');
        $this->db->join('form_controls c3', 'c3.form_control_id =c.question_form_type', 'left');
        $this->db->where('c2.service_type_language_code', $language);
        if ($data['questions_service_type_id'] > 0) {
            $this->db->where('c2.service_type_id', $data['questions_service_type_id']);
        }
        $this->db->order_by('c.question_id', 'asc');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    function getDynamicQuestions($data)
    {
        $language           = $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;

        $sql = " select * from form_controls f,question q  LEFT JOIN service_type s ON s.service_type_id=questions_service_type_id and service_type_language_code=" . $language . " where   f.form_control_id=question_form_type and question_status=1";
        $sql .= "  and questions_service_type_id=" . $data['select_service_type'] . " and question_parent_id<=0";
        $sql .= "  order by question_id ASC limit 1";
        /*    echo   $sql = " select * from  service_type s LEFT JOIN question q  ON s.service_type_id=questions_service_type_id  and 
	 service_type_language_code=".$language." INNER JOIN form_controls f ON f.form_control_id=question_form_type and question_status=1 
	 and questions_service_type_id=".$data['select_service_type']." and question_parent_id<=0 and s.service_type_id=".$data['select_service_type']." order by question_id ASC limit 1 ";
                  */
        $rs = $this->db->query($sql);
        return   $row = $rs->row();
    }
    function getAnswers($data)
    {
        $query = $this->db->order_by('answer_options_id', 'asc')->get_where('answer_options', $data);
        return $query->result();
    }
    function getNextQuestion($data)
    {
        if ($data['answerOption'] > 0) {
            $sql = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1";
            $sql .= " ";
            if ($data['questionId'] > 0) {
                $sql .= "  and question_parent_id=" . $data['questionId'] . "";
            }
            if ($data['answerOption'] > 0) {
                $sql .= "  and answer_parent_id=" . $data['answerOption'] . "";
            }
            $sql .= "  order by question_id ASC limit 1";
            $rs = $this->db->query($sql);
            return  $result =   $row = $rs->row();
        } else {
            return array();
        }
    }
    function nextParentQuestion($data)
    {
        $offset = $data['offset'];
        $sql = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1 and questions_service_type_id=" . $data['serviceTypeid'] . " and question_parent_id<=0  ";
        if ($data['last_parent'] > 0) {
            $sql .= "  and question_id>" . $data['last_parent'] . " ";
        }
        $sql .= "  order by question_id ASC limit 1 ";
        $rs = $this->db->query($sql);
        return  $result =   $row = $rs->row();
    }
    function saveRequest_old($data, $question, $providers)
    {
        // print_r($data);exit;

        $documents = $data['document'];

        unset($data['document']);

        $this->db->trans_start();
        $this->db->insert('job_request', $data);
        $insertId                   =              $this->db->insert_id();
        $return                     =              $insertId;

        if ($providers != "") {
            $providerArray  = explode(",", $providers);
            if (count($providerArray) > 0) {
                $l = 0;
                foreach ($providerArray as $pr) {
                    $provider[$l]['job_request_id']           =        $return;
                    $provider[$l]['assign_status']              =        0;
                    $provider[$l]['provider_id']                  =        $pr;
                    $provider[$l]['assigned_date']             =        date("Y-m-d H:i:s");

                    $l++;
                }

                $this -> db -> where('job_request_id', $return);
                $this -> db -> delete('assign_job_provider');
                $this -> db -> insert_batch('assign_job_provider',$provider);
            }
        }
        //  print_r($question);
        if (count($question) > 0) {
            $i = 0;
            foreach ($question as $key => $value) {
                $input[$i]['job_request_id']           =        $return;
                $input[$i]['question_id']                 =        $key;
                $input[$i]['service_type_id']          =        $data['service_type_id'];
                $input[$i]['user_id']                         =        $data['user_id'];


                //  $answer                                              =         explode(",",$value);

                //   print_r($value);

                //  print_r($answer);
                if (count($value) > 1) {
                    $k = 1;
                    foreach ($value as $row) {
                        $input[$i]['job_request_id']           =        $return;
                        $input[$i]['question_id']                 =        $key;
                        $input[$i]['service_type_id']          =        $data['service_type_id'];
                        $input[$i]['user_id']                         =        $data['user_id'];
                        $input[$i]['answer']                         =        $row;
                        if ($k != count($answer))
                            $i++;

                        $k++;
                    }
                } else {
                    $input[$i]['answer']                         =        $value[0];
                }
                $i++;
            }

            $this->db->where('job_request_id', $return);
            $this->db->delete('request_question_option');
            $this->db->insert_batch('request_question_option', $input);
        }
        if (count($documents) > 0) {
            $j = 0;
            foreach ($documents as $docs) {
                $docsArray[$j]["documents_name"] = $docs;
                $docsArray[$j]["job_request_id"] = $return;
                $j++;
            }
            $this->db->insert_batch('documents', $docsArray);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return $return;
        }
    }
    function getJobRequestsListCount($data)
    {
        //print_r($_SESSION);
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id and job_request_type=2 ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%' or  LOWER(job_request_display_id) like  '%" . $search_key . "%') ";
        }
        if ($data['from_date'] != "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['from_date'] != "" && $data['to_date'] == "") {
            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['from_date'] . "' ";
        }
        if ($data['from_date'] == "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['to_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " ) ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 1) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 2) {
            $sql .=      " and j.job_request_id in (select job_request_id from assign_job_provider where provider_id=" . $data['user_id'] . ")";
        }
        
        
        if ($data['quotation_status'] == "pending") {
            $sql.= "and j.job_request_status = 0";
        }
        
        if ($data['quotation_status'] == "confirmed") {
            $sql .=      " and j.job_request_status=1 ";
        }
        
        if ($data['quotation_status'] == "ongoing") {
            $sql .=      " and j.job_request_status=4 ";
        }
        
        if ($data['quotation_status'] == "completed") {
            $sql .=      " and j.job_request_status=5 ";
        }
        
        if ($data['quotation_status'] == "cancelled") {
            $sql .=      " and j.job_request_status=10 ";
        }
        
        
        
        
        // echo $sql;
        // $date = date("Y-m-d");
        // $sql.= "     and j.job_validity_date >='".$date."'";

        $date = date("Y-m-d H:i:s");
        // $sql.= "     and (j.job_validity_date|| ' '||job_validity_time)::timestamp >='".$date."'::timestamp ";  


        // if ($this->session->userdata('eq_user_type') == 2) {
        //     $sql .= "     and j.is_approoved=1 ";
        // }

        // echo $sql;
        $rs      = $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    
    function getJobRequestsListByVendorCount($data){
        $search_key  = strtolower($data['search_key']);
         if ($search_key != "") {
            $this->db->like('LOWER(user_first_name)',$search_key);
            $this->db->or_like('LOWER(user_last_name)',$search_key);
            $this->db->or_like('LOWER(service_type_name)',$search_key);
         }
         
         if ($data['from_date'] != "" && $data['to_date'] != "") {
            $this->db->where('job_validity_date >=',$data['from_date']);   
         }
         
         if ($data['from_date'] != "" && $data['to_date'] == "") {
               $this->db->where('job_validity_date >=',$data['from_date']);  
               $this->db->where('job_validity_date <=',$data['from_date']); 
         }

         if ($data['from_date'] == "" && $data['to_date'] != "")  {
               $this->db->where('job_validity_date >=',$data['to_date']);  
               $this->db->where('job_validity_date <=',$data['to_date']); 
         }
         
         if ($data['job_request_type'] != "") {
             $this->db->where('job_request_type',$data['job_request_type']);
         }
         
         if ($this->session->userdata('eq_user_type') == 2) {
            $this->db->where('provider_id',$this->session->userdata('eq_user_id'));
         }
         
         if ($data['quotation_status'] == "pending") {
            $this->db->where('job_request_status',0);// $sql.= "and j.job_request_status = 0";
        }
        
        if ($data['quotation_status'] == "confirmed") {
            $this->db->where('job_request_status',1);// $sql .=      " and j.job_request_status=1 ";
        }
        
        if($data['quotation_status'] == "staff_assigned"){
            $this->db->where('job_request_status',3);
        }
        
        if ($data['quotation_status'] == "ongoing") {
           $this->db->where('job_request_status',4);// $sql .=      " and j.job_request_status=4 ";
        }
        
        if ($data['quotation_status'] == "completed") {
            $this->db->where('job_request_status',5);//$sql .=      " and j.job_request_status=5 ";
        }
        
        if ($data['quotation_status'] == "cancelled") {
            $this->db->where('job_request_status',10);//$sql .=      " and j.job_request_status=10 ";
        }
        
        
         
         
         $this->db->select('*');
         $this->db->join('job_request','job_request.job_request_id = assign_job_provider.job_request_id','left');
         $this->db->join('user_table','user_table.user_id = job_request.user_id','left');
         $this->db->join('service_type','service_type.service_type_id=job_request.service_type_id and service_type_language_code = 1','left');
         $result = $this->db->get('assign_job_provider')->result();
         $count = count($result);
         $array['count']          = $count;
         $array = (object) $array;
         return $array;
    }
    
    
     function getJobRequestsListByVendor($data, $limit_per_page, $start_index){
         
         $search_key  = strtolower($data['search_key']);
         if ($search_key != "") {
            $this->db->like('LOWER(user_first_name)',$search_key);
            $this->db->like('LOWER(user_first_name)',$search_key);
            $this->db->or_like('LOWER(user_last_name)',$search_key);
            $this->db->or_like('LOWER(service_type_name)',$search_key);
            $this->db->or_like('LOWER(job_request_display_id)',$search_key);
         }
         
         if ($data['from_date'] != "" && $data['to_date'] != "") {
            $this->db->where('job_validity_date >=',$data['from_date']);   
         }
         
         if ($data['from_date'] != "" && $data['to_date'] == "") {
               $this->db->where('job_validity_date >=',$data['from_date']);  
               $this->db->where('job_validity_date <=',$data['from_date']); 
         }

         if ($data['from_date'] == "" && $data['to_date'] != "")  {
               $this->db->where('job_validity_date >=',$data['to_date']);  
               $this->db->where('job_validity_date <=',$data['to_date']); 
         }
         
         if ($data['job_request_type'] != "") {
             $this->db->where('job_request_type',$data['job_request_type']);
         }
         
         if ($this->session->userdata('eq_user_type') == 2) {
            $this->db->where('provider_id',$this->session->userdata('eq_user_id'));
         }
         
         if ($data['quotation_status'] == "pending") {
            $this->db->where('job_request_status',0);// $sql.= "and j.job_request_status = 0";
        }
        
        if ($data['quotation_status'] == "confirmed") {
            $this->db->where('job_request_status',1);// $sql .=      " and j.job_request_status=1 ";
        }
        
        if($data['quotation_status'] == "staff_assigned"){
            $this->db->where('job_request_status',3);
        }
        
        if ($data['quotation_status'] == "ongoing") {
           $this->db->where('job_request_status',4);// $sql .=      " and j.job_request_status=4 ";
        }
        
        if ($data['quotation_status'] == "completed") {
            $this->db->where('job_request_status',5);//$sql .=      " and j.job_request_status=5 ";
        }
        
        if ($data['quotation_status'] == "cancelled") {
            $this->db->where('job_request_status',10);//$sql .=      " and j.job_request_status=10 ";
        }
         
         
         
         
         $this->db->select('*');
         $this->db->join('job_request','job_request.job_request_id = assign_job_provider.job_request_id','left');
         $this->db->join('user_table','user_table.user_id = job_request.user_id','left');
         $this->db->join('service_type','service_type.service_type_id=job_request.service_type_id and service_type_language_code = 1','left');
         
         if ($limit_per_page > 0) {
             $this->db->limit($limit_per_page,$start_index);
            // $sql .= "    offset " . $start_index . "   limit  " . $limit_per_page . "";
        }
        
        if($data['jobOrder']){
            if($data['jobOrder'] == "oldest")
                $this->db->order_by('assign_job_provider_id','asc');
            else
                $this->db->order_by('assign_job_provider_id','desc');
         }else{
             $this->db->order_by('assign_job_provider_id','desc');
         }
         
         return $this->db->get('assign_job_provider')->result();
     }
    
    function getJobRequestsList($data, $limit_per_page, $start_index)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id and job_request_type=2 ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%' or  LOWER(job_request_display_id) like  '%" . $search_key . "%') ";
        }
        if ($data['from_date'] != "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['from_date'] != "" && $data['to_date'] == "") {
            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['from_date'] . "' ";
        }
        if ($data['from_date'] == "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['to_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " )";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 1) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 2 && $data['quotation_status'] =="pending") {
            $sql .=" and j.job_request_id in (select job_request_id from assign_job_provider where provider_id=" . $data['user_id'] . ")";
        }
        if ($this->session->userdata('eq_user_type') == 2 ) {
            $sql .= "and j.vendor_id =".$data['user_id'];
        }

        if ($data['quotation_status'] == "pending") {
            $sql.= "and j.job_request_status = 0";
        }
        
        if ($data['quotation_status'] == "confirmed") {
            $sql .=      " and j.job_request_status=1 ";
        }
        
        if ($data['quotation_status'] == "ongoing") {
            $sql .=      " and j.job_request_status=4 ";
        }
        
        if ($data['quotation_status'] == "completed") {
            $sql .=      " and j.job_request_status=5 ";
        }
        
        if ($data['quotation_status'] == "cancelled") {
            $sql .=      " and j.job_request_status=10 ";
        }
        
        // $date = date("Y-m-d");
        // $sql.= "     and j.job_validity_date >='".$date."'";
        $date = date("Y-m-d H:i:s");
        //  $sql.= "     and (j.job_validity_date|| ' '||job_validity_time)::timestamp >='".$date."'::timestamp ";  

        // if ($this->session->userdata('eq_user_type') == 2) {
        //     $sql .= "     and j.is_approoved=1 ";
        // }

        if ($data['jobOrder'] == "oldest") {
            $sql .= " order by job_request_id ASC";
        } else {
            $sql .= " order by job_request_id DESC";
        }

        if ($limit_per_page > 0) {
            $sql .= "    offset " . $start_index . "   limit  " . $limit_per_page . "";
        }
        // echo $sql;exit;
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getHomeLocation($userId, $type)
    {
        $sql = " select *  from user_adresses where user_id=" . $userId . " and user_adresses_type_id=" . $type . " ";
        $rs = $this->db->query($sql);
        return  $rs->row();
    }
    function changeStatus($data)
    {
        $status     =  $this->common_functions->decryptId($data['action']);
        $requestId  =  $this->common_functions->decryptId($data['itemId']);
        $providerId =  $this->session->userdata('eq_user_id');

        $verifyCurrentStatus =   $this->common_functions->changedStatus($requestId, $status, $providerId);

        if ($verifyCurrentStatus < 0) {

            return $verifyCurrentStatus;
        }

        $input['assign_status']  =  $status;
        $this->db->trans_start();

        $this->db->where('job_request_id', $requestId);
        $this->db->where('provider_id', $providerId);
        $this->db->update('assign_job_provider', $input);

        if ($status == 5) {
            $job['job_request_status']       =  $status;
            $this->db->where('job_request_id', $requestId);
            $this->db->update('job_request', $job);
        }
        // echo $this->db->last_query();
        $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $requestId . "";
        $rs     = $this->db->query($sql);
        $count  =   $rs->row()->count;
        if ($count == 1 && $status == 2) {
            //echo "2-";
            $res['job_request_status'] = 2;
            $this->db->where('job_request_id', $requestId);
            $this->db->where('job_request_type', 2);
            $this->db->update('job_request', $res);
        }

        if ($status == 2) {
            $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $requestId . " and (user_response_status=2 or assign_status=2) ";
            $rs     = $this->db->query($sql);
            $count  =   $rs->row()->count;

            $sql2    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $requestId . " ";
            $rs2     = $this->db->query($sql2);
            $count2  =   $rs2->row()->count;
            if ($count == $count2) {
                // echo "1-";
                $res['job_request_status'] = 2;
                $this->db->where('job_request_id', $requestId);
                $this->db->where('job_request_type', 2);
                $this->db->update('job_request', $res);
            }
        }



        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            if ($this->session->userdata('eq_user_type') == 2) {

                $userId = $this->getUserIdFromJobRequest($requestId);
                if ($userId > 0) {
                    $this->sendCustomerMail($userId, $requestId, $status, 0);
                }
            }

            return 1;
        }
    }
    function getAssignedStatus($providerid, $jobRequestId)
    {
        $sql = " select *  from assign_job_provider where provider_id=" . $providerid . " and job_request_id=" . $jobRequestId . " ";
        $rs = $this->db->query($sql);
        return  $rs->row();
    }
    function getAssignedStatusUser($userId, $jobRequestId)
    {
        $sql = " select *  from assign_job_provider a ,job_request r  where user_id=" . $userId . " and r.job_request_id=" . $jobRequestId . " and a.job_request_id=r.job_request_id ";
        $rs = $this->db->query($sql);
        return  $rs->row();
    }
    function getJobSummary($job_request_id, $language)
    {
        $sql = " select * from job_request r, service_type s,user_table u where r.service_type_id=s.service_type_id and  service_type_language_code=" . $language . " and   job_request_id=" . $job_request_id . " and r.user_id=u.user_id ";
        $rs = $this->db->query($sql);
        return   $row = $rs->row();
    }
    
    public function getQuestionsAgainstJobRequest($job_request_id){

        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->join('question','question.question_id = request_question_option.question_id','left');
        $this->db->join('answer_options','answer_options.answer_options_id = request_question_option.answer','left');
        return $this->db->get('request_question_option')->result();
    }
    
    function getQuestionsAgainstJobRequest_old($jobRequestId = "")
    {
        $sql = " select q.question_id,question,question_arb,answer_options_id,answer,answer_option,answer_option_arabic from question q,request_question_option ro 
LEFT JOIN answer_options a ON  a.question_id=ro.question_id  and answer_options_id = answer and a.question_id=ro.question_id
where  q.question_id=ro.question_id   ";
        if ($jobRequestId > 0) {
            $sql .= " and  ro.job_request_id=" . $jobRequestId . " ";
        }

        $sql .= " order by question_id ASC ";
        // echo $sql;
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function getUploadedFiles($jobRequestId)
    {
        $sql = "select * from documents  WHERE job_request_id=" . $jobRequestId . "  ";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->result();
    }
    function getJobQuotaionListCount($data)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id and job_request_type=1 ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%' or  LOWER(job_request_display_id) like  '%" . $search_key . "%') ";
        }
        if ($data['from_date'] != "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['from_date'] != "" && $data['to_date'] == "") {
            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['from_date'] . "' ";
        }
        if ($data['from_date'] == "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['to_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " ) ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 1) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 2) {
            $sql .=      " and s.service_type_id in (select service_type_id from provider_service_type where provider_id=" . $data['user_id'] . ")";

            //   $sql.=      " and j.job_request_id not in(select job_request_id from assign_job_provider a2s where provider_id!=".$data['user_id']." and a2s.job_request_id=j.job_request_id and user_response_status=1  ) ";
        }

        if ($data['quotation_status'] == "pending") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and j.job_request_status not in(2,4) and j.job_request_id not in  (select job_request_id from assign_job_provider a2 where assign_status in(2,4) and a2.provider_id=" . $this->session->userdata('eq_user_id') . " ) and j.job_request_id not in  (select job_request_id from assign_job_provider a3 where user_response_status in(2,4) and a3.provider_id=" . $this->session->userdata('eq_user_id') . " ) ";
            } else {
                $sql .=      " and j.job_request_status not in(2,4) and j.job_request_id not in  (select job_request_id from assign_job_provider a2 where assign_status in(2,4) and j.user_id=" . $this->session->userdata('eq_user_id') . " ) and j.job_request_id not in  (select job_request_id from assign_job_provider a3 where user_response_status in(2,4) and j.user_id=" . $this->session->userdata('eq_user_id') . " ) ";
            }
        }
        if ($data['quotation_status'] == "cancelled") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and ( j.job_request_status=2 or j.job_request_id in (select job_request_id from assign_job_provider a2 where assign_status=2 and a2.provider_id=" . $this->session->userdata('eq_user_id') . " )  or j.job_request_id in (select job_request_id from assign_job_provider a3 where user_response_status=2 and a3.provider_id=" . $this->session->userdata('eq_user_id') . " )) ";
            } else {
                $sql .=      " and j.job_request_status=2 ";
                // $sql.=      " and ( j.job_request_status=2 or j.job_request_id in (select job_request_id from assign_job_provider a2 where assign_status=2 and j.user_id=".$this->session->userdata('eq_user_id')." ) or j.job_request_id in (select job_request_id from assign_job_provider a3 where user_response_status=2 and j.user_id=".$this->session->userdata('eq_user_id')." ) ) ";  
            }
        }
        if ($data['quotation_status'] == "confirmed") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and j.job_request_id in (select job_request_id from assign_job_provider a2 where user_response_status=1 and a2.provider_id=" . $this->session->userdata('eq_user_id') . " )  ";
            } else {
                $sql .=      " and j.job_request_id in (select job_request_id from assign_job_provider a2 where user_response_status=1 and j.user_id=" . $this->session->userdata('eq_user_id') . " )  ";
            }
        }

        $date = date("Y-m-d H:i:s");
        // $sql.= "     and (j.job_validity_date|| ' '||job_validity_time)::timestamp >='".$date."'::timestamp ";

        if ($this->session->userdata('eq_user_type') == 2) {
            $sql .= "     and j.is_approoved=1 ";
        }
        $rs = $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }

    function getJobQuotaionList($data, $limit_per_page, $start_index)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id and job_request_type=1 ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%' or  LOWER(job_request_display_id) like  '%" . $search_key . "%') ";
        }
        if ($data['from_date'] != "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['from_date'] != "" && $data['to_date'] == "") {
            $sql .=      " and date(job_validity_date)>='" . $data['from_date'] . "' and  date(job_validity_date)<='" . $data['from_date'] . "' ";
        }
        if ($data['from_date'] == "" && $data['to_date'] != "") {

            $sql .=      " and date(job_validity_date)>='" . $data['to_date'] . "' and  date(job_validity_date)<='" . $data['to_date'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " )";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 1) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        }
        if ($data['user_id'] > 0 && $this->session->userdata('eq_user_type') == 2) {
            $sql .=      " and s.service_type_id in (select service_type_id from provider_service_type where provider_id=" . $data['user_id'] . ")";
            // $sql.=      " and j.job_request_id not in(select job_request_id from assign_job_provider a2s where provider_id!=".$data['user_id']." and a2s.job_request_id=j.job_request_id and user_response_status=1  ) ";
        }

        if ($data['quotation_status'] == "pending") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and j.job_request_status not in(2,4) and j.job_request_id not in  (select job_request_id from assign_job_provider where assign_status in(2,4) and provider_id=" . $this->session->userdata('eq_user_id') . " ) and j.job_request_id not in  (select job_request_id from assign_job_provider where user_response_status in(2,4) and provider_id=" . $this->session->userdata('eq_user_id') . " ) ";
            } else {
                $sql .=      " and j.job_request_status not in(2,4) and j.job_request_id not in  (select job_request_id from assign_job_provider where assign_status in(2,4) and j.user_id=" . $this->session->userdata('eq_user_id') . " ) and j.job_request_id not in  (select job_request_id from assign_job_provider where user_response_status in(2,4) and j.user_id=" . $this->session->userdata('eq_user_id') . " ) ";
            }
        }
        if ($data['quotation_status'] == "cancelled") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and ( j.job_request_status=2 or j.job_request_id in (select job_request_id from assign_job_provider where assign_status=2 and provider_id=" . $this->session->userdata('eq_user_id') . " )  or j.job_request_id in (select job_request_id from assign_job_provider where user_response_status=2 and provider_id=" . $this->session->userdata('eq_user_id') . " )) ";
            } else {
                $sql .=      " and j.job_request_status=2 ";
                //  $sql.=      " and ( j.job_request_status=2 or j.job_request_id in (select job_request_id from assign_job_provider where assign_status=2 and j.user_id=".$this->session->userdata('eq_user_id')." ) or j.job_request_id in (select job_request_id from assign_job_provider where user_response_status=2 and j.user_id=".$this->session->userdata('eq_user_id')." ) ) ";  
            }
        }
        if ($data['quotation_status'] == "confirmed") {
            if ($this->session->userdata('eq_user_type') == 2) {
                $sql .=      " and j.job_request_id in (select job_request_id from assign_job_provider where user_response_status=1 and provider_id=" . $this->session->userdata('eq_user_id') . " )  ";
            } else {
                $sql .=      " and j.job_request_id in (select job_request_id from assign_job_provider where user_response_status=1 and j.user_id=" . $this->session->userdata('eq_user_id') . " )  ";
            }
        }
        $date = date("Y-m-d H:i:s");

        //  $sql.= "     and (j.job_validity_date|| ' '||job_validity_time)::timestamp >='".$date."'::timestamp ";

        if ($this->session->userdata('eq_user_type') == 2) {
            $sql .= "     and j.is_approoved=1 ";
        }
        if ($data['jobOrder'] == "oldest") {
            $sql .= " order by job_request_id ASC";
        } else {
            $sql .= " order by job_request_id DESC";
        }
        if ($limit_per_page > 0) {
            $sql .= "   offset " . $start_index . "   limit  " . $limit_per_page . "";
        }

        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function markPrice($data)
    {


        $sql = "select  count(job_request_id) as count from assign_job_provider where job_request_id= " . $this->common_functions->decryptId($data['job_request_id']) . " and provider_id=" . $data['provider_id'] . " and provider_amount>0";
        $rs = $this->db->query($sql);
        $count = $result = $rs->row()->count;
        if ($count > 0) {
            return -5;
        } else {

            $verifyCurrentStatus =   $this->common_functions->changedStatus($this->common_functions->decryptId($data['job_request_id']), 0, $data['provider_id']);

            if ($verifyCurrentStatus < 0) {

                return $verifyCurrentStatus;
            }


            $provider['provider_amount']                  =        $data['price'];
            $provider['provider_response_time']           =        date("Y-m-d H:i:s");
            $provider['job_request_id']                   =        $this->common_functions->decryptId($data['job_request_id']);
            $provider['assign_status']                    =        3;
            $provider['provider_id']                      =        $data['provider_id'];
            $provider['assigned_date']                    =        date("Y-m-d H:i:s");
            $provider['provider_response_time']           =        date("Y-m-d H:i:s");
            $provider['document_name']                    =        $data['document_name'];

            // $type       =  $this->getJobRequestType($this->common_functions->decryptId($data['job_request_id']));
            // print_r($provider);
            // exit;

            $this->db->trans_start();

            $sql = "select  count(job_request_id) as count from assign_job_provider where job_request_id= " . $this->common_functions->decryptId($data['job_request_id']) . " and provider_id=" . $data['provider_id'] . " ";
            $rs = $this->db->query($sql);
            $count = $result = $rs->row()->count;
            //exit;
            if ($count <= 0) {
                $this->db->insert('assign_job_provider', $provider);
            } else {
                unset($provider['job_request_id']);
                $this->db->where('provider_id', $this->session->userdata('eq_user_id'));
                $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
                $this->db->update('assign_job_provider', $provider);
            }
            //echo $this->db->last_query();
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        }
    }
    function getRatingCount()
    {
        $provider_id           =  $this->session->userdata('eq_user_id');

        $sql = "select r.provider_id from provider_rating r,user_table u where u.user_id=r.user_id and  provider_id=" . $provider_id . " and rating_status=1 ";
        $rs = $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function getRatingList($data, $limit_per_page, $start_index)
    {
        $provider_id           =  $this->session->userdata('eq_user_id');

        $sql = "select u.user_first_name,u.user_last_name,u.user_image,r.* from provider_rating r,user_table u where u.user_id=r.user_id and provider_id=" . $provider_id . " and rating_status=1 ";
        $sql .= " order by provider_rating_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";
        $rs  =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function savePrimarySettings($data)
    {
        $serviceTypes  = explode(",", $data['mappedItems']);
        $providerId    = $this->session->userdata('eq_user_id');

        if (count($serviceTypes) > 0) {
            $i = 0;
            foreach ($serviceTypes as $rows) {
                $input[$i]['provider_id']          =  $providerId;
                $input[$i]['service_type_id']      =  $rows;
                $i++;
            }


            $locationDetails['location']  =  $data['location_name'];
            $locationDetails['lattitude'] =  $data['lattitude'];
            $locationDetails['longitude'] =  $data['longittude'];

            $this->db->trans_start();

            $this->db->insert_batch("provider_service_type", $input);

            $this->db->where("user_id", $providerId);
            $this->db->update("provider_details", $locationDetails);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
    function getOffersCount($jobRequestId)
    {
        $sql = "select count( r.job_request_id ) AS count from assign_job_provider aj, job_request r,provider_service_type ps,service_type s

WHERE aj.job_request_id=r.job_request_id and s.service_type_id=r.service_type_id and 

service_type_language_code=1  and ps.service_type_id=r.service_type_id and aj.provider_id=ps.provider_id

 and r.job_request_id=" . $jobRequestId . "  ";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->row()->count;
    }
    function getRespondedProviders($jobRequestId, $language)
    {
        $sql = "select provider_amount,user_response_status,r.job_request_id,job_request_status,assigned_date,assign_status,r.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,job_longitude,job_lattitude,job_location,company_name,user_image ,ap.document_name

from job_request r,user_table u,provider_details d,service_type s,provider_service_type ps,assign_job_provider ap



WHERE u.user_id=d.user_id and ps.provider_id=u.user_id and ps.service_type_id=r.service_type_id  and s.service_type_id=r.service_type_id and 

service_type_language_code=" . $language . "  and user_status=1  and ap.provider_id=u.user_id and r.job_request_id=ap.job_request_id and r.job_request_id=" . $jobRequestId . " 
";

        // $sql.= " GROUP BY assign_status,r.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,job_longitude,job_lattitude,job_location,company_name,user_image";             


        $sql .= "  order by assign_status ASC ";
        // echo $sql;        
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function changeStatusUser($data)
    {
        
        // print_r($data);exit;
        $input['user_note']                 =   $data['note'];
        $input['user_response_status']      =   $data['response_status'];
        $input['user_response_time']        =   date("Y-m-d H:i:s");
        $this->db->trans_start();

        $providerId          =  $data['provider_id'] > 0 ? $data['provider_id'] : 0;

        $verifyCurrentStatus =   $this->common_functions->changedStatus($this->common_functions->decryptId($data['job_request_id']), $data['response_status'], $providerId);

        if ($verifyCurrentStatus < 0) {

            return $verifyCurrentStatus;
        }

        if ($data['response_status'] == 1) {
            $input2['user_response_status']      =  2;
            $input2['user_response_time']        =   date("Y-m-d H:i:s");
            $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
            $this->db->update('assign_job_provider', $input2);
        }

        $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
        if ($data['provider_id'] > 0) {
            $this->db->where('provider_id', $data['provider_id']);
        }
        $this->db->update('assign_job_provider', $input);
        //echo $this->db->last_query();
        //exit;
        if ($data['response_status'] == 1) {
            $res['job_request_status'] = 4;
            $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
            $this->db->update('job_request', $res);
        }
        if ($data['provider_id'] <= 0 && $data['response_status'] == 2) {
            // echo "3-";
            $res['job_request_status'] = 10;
            $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
            $this->db->update('job_request', $res);
        }

        $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $this->common_functions->decryptId($data['job_request_id']) . "";
        $rs     = $this->db->query($sql);
        $count  =   $rs->row()->count;
        if ($count == 1 && $data['response_status'] == 2) {
            //echo "2-";
            
            $res['job_request_status'] = 10;
            $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
            $this->db->where('job_request_type', 2);
            $this->db->update('job_request', $res);
        }
        if ($data['response_status'] == 2) {
            $this->canelServiceRequest($this->common_functions->decryptId($data['job_request_id']));
            // echo "cancel";exit;
            // $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $this->common_functions->decryptId($data['job_request_id']) . " and (user_response_status=2 or assign_status=2) ";
            // $rs     = $this->db->query($sql);
            // $count  =   $rs->row()->count;

            // $sql2    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=" . $this->common_functions->decryptId($data['job_request_id']) . " ";
            // $rs2     = $this->db->query($sql2);
            // $count2  =   $rs2->row()->count;
            // if ($count == $count2) {
            //     // echo "1-";
            //     $res['job_request_status'] = 2;
            //     $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
            //     $this->db->where('job_request_type', 2);
            //     $this->db->update('job_request', $res);
            // }
        }

        // echo $this->db->last_query();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {

            return 1;
        }
    }
    
    public function canelServiceRequest($job_request_id){
        
        $this->db->trans_start();  
        
        $this->db->where('job_request_id',$job_request_id);
        $this->db->set('job_request_status',10);
        $this->db->update('job_request');
        
        $this->db->set('assign_status',10);
        $this->db->where('job_request_id',$job_request_id);
        $this->db->set('muted_status',1);
        $this->db->update('assign_job_provider');
        
        $this->db->where('job_request_id',$job_request_id);
        $this->db->delete('staff_jobs');
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE){
            return 0;
        }else{
            return 1;
        }

    }
    
    function getFaq($data)
    {
        $language           = $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;

        $sql = " select * from service_faq where service_type_id=" . $data['select_service_type'] . " and service_faq_language_code=" . $language . " order by service_faq ASC ";
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function checkIsparent($question_id)
    {
        $language           = $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;

        $sql = " select count(question_id) as count from question where question_parent_id>0 and question_id=" . $question_id . " ";
        $rs = $this->db->query($sql);
        return   $row = $rs->row()->count;
    }
    function checkConfirmedStatus($jobRequestId)
    {
        $provider_id   =  $this->session->userdata('eq_user_id');
        $sql           =  " select count(job_request_id) as count from assign_job_provider a where  user_response_status=1 and provider_id=" . $provider_id . " and job_request_id=" . $jobRequestId . "";
        $rs            =  $this->db->query($sql);
        return   $row  =  $rs->row()->count;
    }
    function getSuggestion($data)
    {
        $provider_id   =  $this->session->userdata('eq_user_id');
        $search_key    =  strtolower($data['search_key']);
        $language                           =   $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;
        $sql           =  " select distinct s.service_type_id,service_type_name from service_type s where  LOWER(service_type_name) like  '%" . $search_key . "%' and service_type_status=1 and service_type_language_code=" . $language . "";
        if ($data['city'] > 0) {
            $sql .=  " and s.service_type_id in(select distinct service_type_id from provider_service_type ps ,user_table u where u.user_id=ps.provider_id and u.city_id=" . $data['city'] . ")";
        }
        $rs            =  $this->db->query($sql);
        return   $row  =  $rs->result();
    }
    function sendCustomerMail($userId, $jobRequestId = 0, $status = 0, $vendorStatus = 0)
    {

        $id2            = (int)$jobRequestId;
        $jobRequestId   = $id2 <= 0 ? $this->common_functions->decryptId($jobRequestId) : $jobRequestId;

        $this->load->model('website/M_user');
        $user    =  $this->M_user->getRequiredFieldsforNotification($userId);
        $subject =  "Your job status has been changed by the customer";

        $type = "request";

        if ($status == 3) {
            $userMaiArray['message'] = "Price marked for your quotaion request,Please login to verify";
        }
        if ($status == 1) {
            $userMaiArray['message'] = "Congrats! Your request has been accepted by the provider. Login to verify.";
        } else if ($status == 2) {
            $userMaiArray['message'] = "Sorry! Your job request has been cancelled by the service provider.Login to learn more.";
        } else if ($status == 5) {
            $userMaiArray['message'] = "Job has been completed by the provider,Please login to verify";
        }

        $userMaiArray['name']     = $user->user_first_name;
        $to                       =  $user->user_email;
        $userMaiArray['subject']  = $subject;
        $this->load->library('parser');
        $email_message  = $this->parser->parse('email/change_status2', $userMaiArray, true);
        $this->load->library("Mail_function");
        $this->mail_function->SendEmail($email_message, $subject, $to);

        //$fcm =   $this->M_user->getFcmGroupDetails($this->input->post('service_type_id'));
        $extraData['title']          =  "Emirates quotation";
        $extraData['id']             =   $jobRequestId;
        $extraData['type']           =  "change_status";
        if ($status == 3) {
            $extraData['type']           =  "mark_price";
            $type                        =  "mark_price";
        }
        //$extraData['click_action']   =  "notification";
        $message['title']            =  "Emirates quotation";
        $message['body']             =  $userMaiArray['message'];
        $message['click_action']   =  "notification";
        // $message['data']             =   $extraData;
        //print_r($message);
        if ($user->fcm_token != "") {
            $this->fcm_notification->send_single_notification($user->fcm_token, $message, $extraData);
        }
        $saveData =  $this->updateToFirbase($userId, "U", $message['body'], $message['title'], $type, $jobRequestId);
        // $this->fcm_notification->send_single_notification($user->fcm_token,$message,$extraData);



    }
    function sendProviderMail($userId, $jobRequestId = 0, $status = 0, $vendorStatus = 0)
    {
        $id2            = (int)$jobRequestId;
        $jobRequestId   = $id2 <= 0 ? $this->common_functions->decryptId($jobRequestId) : $jobRequestId;


        $this->load->model('website/M_user');
        $user    =  $this->M_user->getRequiredFieldsforNotification($userId);
        $subject =  "Your job status has been changed by the customer";

        if ($status == 2) {
            $userMaiArray['message'] = "Sorry! Your job request has been rejected at the moment. Please try after sometime.";
        } else if ($status == 1) {
            $userMaiArray['message'] = "Job has been confirmed by the customer,Please login to verify";
        }
        $type = "request";

        $userMaiArray['name']     = $user->user_first_name;
        $to                       =  $user->user_email;
        $userMaiArray['subject']  = $subject;
        $this->load->library('parser');
        $email_message  = $this->parser->parse('email/change_status2', $userMaiArray, true);
        $this->load->library("Mail_function");
        $this->mail_function->SendEmail($email_message, $subject, $to);
        //$fcm =   $this->M_user->getFcmGroupDetails($this->input->post('service_type_id'));
        $extraData['title']          =  "Emirates quotation";
        $extraData['id']             =   $jobRequestId;
        $extraData['type']           =  "change_status";
        // $extraData['click_action']   =  "notification";
        $message['title']            =  "Emirates quotation";
        $message['body']             =   $userMaiArray['message'];
        //$message['data']             =   $extraData;
        $message['click_action']   =  "notification";
        if ($user->fcm_token != "") {
            $this->fcm_notification->send_single_notification($user->fcm_token, $message, $extraData);
        }
        $saveData =  $this->updateToFirbase($userId, "P", $message['body'], $message['title'], $type, $jobRequestId);
        //   $this->fcm_notification->send_single_notification($user->fcm_token,$message,$extraData);
        // var_dump($this->fcm_notification->curl_response);

    }
    function sendCustomerMailConfirmation($userId, $jobRequestId = 0, $status = 0, $vendorStatus = 0)
    {
        $user    =  $this->M_user->getRequiredFieldsforNotification($userId);
        $subject =  "Welcome to eq online";
        $id2            = (int)$jobRequestId;
        $jobRequestId   = $id2 <= 0 ? $this->common_functions->decryptId($jobRequestId) : $jobRequestId;
        $confirmedVendorDetails   =    $this->getConfirmedVendorDetails($jobRequestId);
        //$userId                   =    $confirmedVendorDetails->user_id;
        $this->load->model('website/M_user');


        $type = "request";


        $message2                  =    $confirmedVendorDetails->user_first_name . " " . $confirmedVendorDetails->user_last_name . " has been approved by  you  for the job no:" . $confirmedVendorDetails->job_request_display_id;

        $userMaiArray['message'] .=  "<p>" . $message2 . "</p><br>";
        $userMaiArray['message'] .=  "<b>Vendor details</b><br>";
        $userMaiArray['message'] .=  "<p>Name : " . $confirmedVendorDetails->user_first_name . " " . $confirmedVendorDetails->user_last_name . "</p>";
        $userMaiArray['message'] .=  "<p>Email : " . $confirmedVendorDetails->user_email . "</p>";
        $userMaiArray['message'] .=  "<p>Mob No : " . $confirmedVendorDetails->user_dial_code . " " . $confirmedVendorDetails->user_phone . "</p>";

        $userMaiArray['name']     =  $user->user_first_name;
        $to                       =  $user->user_email;
        $userMaiArray['subject']  =  $subject;
        $this->load->library('parser');
        $email_message  = $this->parser->parse('email/change_status2', $userMaiArray, true);
        $this->load->library("Mail_function");
        $this->mail_function->SendEmail($email_message, $subject, $to);

        //$fcm =   $this->M_user->getFcmGroupDetails($this->input->post('service_type_id'));
        $extraData['title']          =  "Emirates quotation";
        $extraData['id']             =   $jobRequestId;
        $extraData['type']           =  "change_status";
        // $message = array();
        //$extraData['click_action'] =  "notification";
        $message['title']            =  "Emirates quotation";
        $message['body']             =  $message2;
        $message['click_action']     =  "notification";
        // $message['data']           =   $extraData;
        //print_r($message);
        if ($user->fcm_token != "") {
            $this->fcm_notification->send_single_notification($user->fcm_token, $message, $extraData);
        }
        $saveData =  $this->updateToFirbase($userId, "U", $message['body'], $message['title'], $type, $jobRequestId);
        // $this->fcm_notification->send_single_notification($user->fcm_token,$message,$extraData);
    }
    function updateToFirbase($userId, $type, $message, $title, $jobType, $id)
    {



        $touserID       =   $type . $userId;
        $t = round(microtime(true) * 1000);
        $id2  = (int)$id;
        $id   = $id2 <= 0 ? $this->common_functions->decryptId($id) : $id;


        if ($id > 0) {

            $fireBaseNode['node_reference']    =  $t;
            $fireBaseNode['job_request_id']    =  $id;
            $fireBaseNode['user_rference']     =  $touserID;
            $this->db->where('job_request_id', $id);
            $this->db->delete('job_firebase_node');

            $this->db->insert('job_firebase_node', $fireBaseNode);
        }

        $notification_data['Notification/' . $touserID . "/" . $t . ""] = [
            "createdAt"         => gmdate('Y-m-d H:i:s'),
            "createdAtUTS"      => gmdate('Y-m-d H:i:s'),
            "description"       => '' . $message,
            "notificationType"  => $jobType,
            "notification_id"   => $id,
            "hide"              => "0",
            "title"             => '' . $title,
            "viewed"            => "0",
            "read"              => "0",
        ];

        $database = get_firebase_refrence();

        $database->getReference()->update($notification_data);
    }
    function getUserIdFromJobRequest($jobRequestId)
    {
        $sql           =  " select user_id from job_request where  job_request_id=" . $jobRequestId . "";
        $rs            =  $this->db->query($sql);
        return   $row  =  $rs->row()->user_id;
    }
    function getMarkedPrice($userId, $jobRequestId)
    {
        $sql           =  " select provider_amount,document_name from assign_job_provider where  job_request_id=" . $jobRequestId . " and provider_id=" . $userId . "";
        $rs            =  $this->db->query($sql);
        return   $row  =  $rs->row();
    }
    function checkAlreadyConfirmedJob($providerId)
    {
        $user_id       =   $this->session->userdata('eq_user_id');
        if ($user_id > 0) {
            $sql           =  " select count(j.job_request_id) as count from assign_job_provider a,job_request j where  provider_id=" . $providerId . " and j.job_request_id=a.job_request_id and j.user_id=" . $user_id . " and user_response_status=1 ";
            $rs            =  $this->db->query($sql);
            return   $row  =  $rs->row()->count;
        } else {
            return 0;
        }
    }
    function recordViewCount($userId, $job_request_id)
    {
        $sql   =  "select count(provider_id) as count from job_view_count where job_request_id=" . $job_request_id . " and provider_id=" . $userId . "";
        $rs    =  $this->db->query($sql);
        $count =  $rs->row()->count;
        if ($count <= 0) {
            $view['job_request_id']    = $job_request_id;
            $view['provider_id']       = $userId;
            $this->db->insert('job_view_count', $view);
        }
    }
    function checkAddressExists($addressId)
    {
        $user_id      =   $this->session->userdata('eq_user_id');
        $sql          =  "select count(user_id) as count from user_adresses where user_adresses_type_id=" . $addressId . " and user_id=" . $user_id . "";
        $rs          =  $this->db->query($sql);
        return $count       =  $rs->row()->count;
    }
    function getJobRequestType($job_request_id)
    {
        $sql          =  "select job_request_type from job_request where job_request_id=" . $job_request_id . "";
        $rs           =  $this->db->query($sql);
        return $count =  $rs->row()->job_request_type;
    }
    function isReadRequest($job_request_id, $userId)
    {
        $sql           =  "select count(job_request_id) as count from job_view_count where job_request_id=" . $job_request_id . " and provider_id=" . $userId . "";
        $rs           =  $this->db->query($sql);
        return $count =  $rs->row()->count;
    }
    function updateFcmGroups($providerId, $input1)
    {

        $sql = " select distinct service_type_id  from provider_service_type where provider_id =" . $providerId . "";
        $rs  =   $this->db->query($sql);
        $res =  $rs->result();

        $i = 0;
        foreach ($res as $rowss) {
            $userGroup  =  array();
            $rows       =  $rowss->service_type_id;

            $sql = " select service_type_name,notification_group_name,fcm_key  from service_type where service_type_id=" . $rows . " and service_type_language_code=1";
            $rs = $this->db->query($sql);
            $res = $rs->row();

            $notification_group_name = $res->notification_group_name;

            $groupName = ltrim(rtrim(strtolower($res->service_type_name)));
            $groupName = str_replace("  ", "", $groupName);
            $groupName = str_replace(" ", "_", $groupName);
            $groupName = $groupName . "_" . date("Ymd");
            if ($notification_group_name == "" || $notification_group_name == NULL) {
                $fcmResult =  $this->fcm_notification->create_notification_group($groupName, array($input1['fcm_token']));
                $fcm_key   =  $fcmResult->notification_key != "" ? $fcmResult->notification_key : "";
                //print_r($fcmResult);
                if ($fcm_key != "") {
                    $fcmValue['notification_group_name']       =  $groupName;
                    $fcmValue['fcm_key']                       =  $fcm_key;
                    $this->db->where('service_type_id', $rows);
                    $this->db->update('service_type', $fcmValue);

                    $userGroup['notification_group_name']     = $groupName;
                    $userGroup['fcm_key']                     = $fcm_key;
                } else if ($fcmResult->error == "") {
                }
            } else {
                $fcmResult                                =  $this->fcm_notification->add_notification_device($res->fcm_key, $notification_group_name, array($input1['fcm_token']));
                $userGroup['notification_group_name']     =  $notification_group_name;
                $userGroup['fcm_key']                     =  $res->fcm_key;
            }
            if (count($userGroup) > 0) {
                $userGroup['user_id']                     =  $providerId;
                $this->db->where('user_id', $providerId);
                $this->db->where('notification_group_name', $userGroup['notification_group_name']);
                $this->db->where('fcm_key', $userGroup['fcm_key']);
                $this->db->delete('user_notification_groups');
                $this->db->insert('user_notification_groups', $userGroup);
            }



            $i++;
        }
    }
    function getConfirmedVendorDetails($job_request_id)
    {
        $sql = " select u.*,j.job_request_display_id  from user_table u,assign_job_provider a,job_request j  where a.provider_id=u.user_id and user_response_status=1 and j.job_request_id=" . $job_request_id . " and j.job_request_id=a.job_request_id ";
        $rs = $this->db->query($sql);
        return $res = $rs->row();
    }
    function getLocationsForJob($jobId)
    {
        $sql = " select user_id,address_type,job_location,job_longitude,job_lattitude  from job_request where job_request_id=" . $jobId . " ";
        $rs  =   $this->db->query($sql);
        $res =  $rs->row();
        if ($res->job_location != "") {
            $data['job_location']  = $res->job_location;
            $data['job_longitude'] = $res->job_longitude;
            $data['job_lattitude'] = $res->job_lattitude;
        } else if ($res->address_type > 0 && $res->user_id > 0) {
            $res =  $this->getHomeLocation($res->user_id, $res->address_type);
            $data['job_location']  = $res->user_adresses_location;
            $data['job_longitude'] = $res->user_adresses_longitude;
            $data['job_lattitude'] = $res->user_adresses_lattitude;
        } else {
            $data = array();
        }
    }


    public function getCountryList()
    {
        $this->db->select('*');
        $this->db->where('country_status', 1);
        $this->db->where('country_language_code', 1);
        return $this->db->get('country')->result();
    }

    function getStaffListCount()
    {
        $user_id = $this->session->userdata('eq_user_id');

        $this->db->select('*');
        $this->db->where('user_type', 3);
        $this->db->where('is_deleted',0);
        $this->db->where('vendor_id', $user_id);
        return  $this->db->get('user_table')->num_rows();
    }

    function getUsersList($limit_per_page, $start_index)
    {
        $user_id = $this->session->userdata('eq_user_id');

        $this->db->select('u.*,c.country_name');
        $this->db->from('user_table u');
        $this->db->where('u.user_type', 3);
        $this->db->order_by('user_id', 'desc');
        $this->db->where('is_deleted',0);
        $this->db->where('u.vendor_id', $user_id);

        $this->db->join('country c', 'c.country_id = u.country_id', 'left');
        $this->db->where('c.country_language_code', 1);
        if ($limit_per_page)
            $this->db->limit($limit_per_page, $start_index);
        return $this->db->get()->result();
    }

    function getUsersListByVendor()
    {
        $user_id = $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('vendor_id', $user_id);
        $this->db->where('user_type', 3);
        $this->db->where('user_status', 1);
        return $this->db->get('user_table')->result();
    }

    public function getJobAssignedStaff($job_request_id)
    {

        $this->db->select('*');
        $this->db->where('job_request_id', $job_request_id);
        $this->db->join('user_table', 'user_table.user_id = staff_jobs.staff_id', 'left');
        return  $this->db->get('staff_jobs')->row();
    }
    
    public function getUserDetails($user_id){

        $this->db->select('*');
        $this->db->where('user_id',$user_id);
        return $this->db->get('user_table')->row();
    }
    
    public function getUserAddressList($user_id){

        $this->db->select('*');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('user_adresses_id','desc');
        $this->db->join('country','country.country_id=user_adresses.user_adresses_country and country_language_code = 1','left');
        return $this->db->get('user_adresses')->result();
    }
    
     public function getCityListByCountryId($country_id,$language = 1){
        $this->db->select('*');
        $this->db->where('city_country_id',$country_id);
        $this->db->where('city_language_code',$language);
        return $this->db->get('city')->result();
    }
    
    public function getAreaListByCityId($city_id,$language = 1 ){

        $this->db->select('*');
        $this->db->where('city_id',$city_id);
        $this->db->where('area_language_code',$language);
        return $this->db->get('area')->result();
    }
    
    public function saveAddressData($data,$address_id){
        
        if($data['default_address'] > 0 ){
            $this->db->where('user_id',$data['user_id']);
            $this->db->set('default_address',0);
            $this->db->update('user_adresses');
        }
        
        
        if($address_id > 0){
            $this->db->where('user_adresses_id',$address_id);
            $this->db->update('user_adresses',$data);
        }else{
            
            // if($data['user_adresses_type_id'] == 1 || $data['user_adresses_type_id'] == 2 ){
            //     $this->db->select('*');
            //     $this->db->where('user_id',$data['user_id']);
            //     $this->db->where('user_adresses_type_id',$data['user_adresses_type_id']);
            //     $result = $this->db->get('user_adresses')->row();
                
            //     if($result){
            //         unset($data['user_adresses_created_time']);
            //         $this->db->where('user_adresses_id',$result->user_adresses_id);
            //         $this->db->update('user_adresses',$data);
            //     }else{
            //         $this->db->insert('user_adresses',$data);
            //     }
            // }else{
            //     $this->db->insert('user_adresses',$data);   
            // }
            
            $this->db->insert('user_adresses',$data);
        }
        
        return $this->db->affected_rows();
    }
    
    public function getUserAddressDetails($address_id,$language = 1){

        $this->db->select('*');
        $this->db->where('user_adresses_id',$address_id);
        $this->db->join('city','city.city_id = user_adresses.user_adresses_city and city_language_code = '.$language,'left');
        $this->db->join('area','area.area_id = user_adresses.user_adresses_area and area_language_code ='.$language,'left');
        return $this->db->get('user_adresses')->row();
    }
    
    public function deleteAddressData($address_id){
        
        $this->db->where('user_adresses_id',$address_id);
        $this->db->where('default_address',1);
        $result =  $this->db->get('user_adresses')->num_rows();

        if($result > 0 ){
            return -1;exit;
        }
        
        $this->db->where('user_adresses_id',$address_id);
        $this->db->where('default_address!=',1);
        $this->db->delete('user_adresses');
        // echo $this->db->last_query();
        return $this->db->affected_rows();
    }
    
    public function getProviderListByArea($area_id,$service_type_id){

        $this->db->select('*');
        $this->db->from('provider_areas');
        $this->db->where('area_id',$area_id);
        $this->db->where('area_status',1);
        $this->db->join('user_table','user_table.user_id = provider_areas.provider_id','left');
        $this->db->join('provider_service_type','provider_service_type.provider_id =provider_areas.provider_id','left');
        $this->db->join('provider_details','provider_details.user_id = provider_areas.provider_id','left');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get()->result();
    }
    
    function saveRequest($data, $question, $providerList){

        // print_r($providers);exit;
        $job_days   = $data['job_days'];
        unset($data['job_days']);
        $this->db->trans_start();

        $this->db->insert('job_request', $data);
        $insertId   = $this->db->insert_id();
        $return     = $insertId;

        if (count($question) > 0) {
            $i = 0;
            foreach ($question as $key => $value) {
                if(!is_array($value)){
                    $value=explode(",", $value);
                }
                
                $input[$i]['job_request_id']   = $return;
                $input[$i]['question_id']      = $key;
                $input[$i]['service_type_id']  = $data['service_type_id'];
                $input[$i]['user_id']          = $data['user_id'];

                if (count($value) > 1) { 
                    $k = 1;
                    
                    foreach ($value as $row) {

                        $input[$i]['job_request_id']           =        $return;
                        $input[$i]['question_id']                 =        $key;
                        $input[$i]['service_type_id']          =        $data['service_type_id'];
                        $input[$i]['user_id']                         =        $data['user_id'];
                        $input[$i]['answer']                         =        $row;
                        if ($k != count($answer))
                            $i++;

                        $k++;
                    }
                } else {
                    /*$input[$i]['answer']          = $value[0];*/
                    $input[$i]['job_request_id']    = $return;
                    $input[$i]['question_id']       = $key;
                    $input[$i]['service_type_id']   = $data['service_type_id'];
                    $input[$i]['user_id']           = $data['user_id'];
                    $input[$i]['answer']            = $value[0];
                }
                $i++;
            }
        }

        $this->db->where('job_request_id', $return);
        $this->db->delete('request_question_option');
        $this->db->insert_batch('request_question_option', $input);
        
        if(!empty($providerList)){
            $provider =[];
            foreach($providerList as $key=> $value){
                $provider[$key]['job_request_id'] = $return;
                $provider[$key]['assign_status']  = 0;
                $provider[$key]['provider_id']    = $value->provider_id;
                $provider[$key]['assigned_date']  = date("Y-m-d H:i:s");
            }
            // print_r($providerList);exit;
            $this -> db ->where('job_request_id', $job_request_id);
            $this -> db ->delete('assign_job_provider');
            $this -> db ->insert_batch('assign_job_provider',$provider);
        }

        foreach($job_days as $date)
        {
            $this->db->insert('job_request_days',['job_request_id'=>$return,'job_date'=>$date,'job_time'=>$data['job_validity_time']]);
        }
         /*wallet payment*/
            if($data['payment_method'] ==3 ) {   
                 $this->db->select('*');
                $this->db->where('user_id',$data['user_id']);
                $userData = $this->db->get('user_table')->row();   
                if($userData->wallet_balance >= $data['grand_total']) {
                    $walletDetails= [
                        'user_id'   => $data['user_id'],
                        'amount'    => $data['grand_total'],
                        'status'     =>2,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by'=>$data['user_id'],
                        'transaction_status'=>1,
                         'job_request_id' =>$insertId,
                         'transaction_id'=>$data['job_request_display_id']
                    ];
                    $this->db->insert('user_wallet',$walletDetails);
                    $walletid = $this->db->insert_id();
                    if($walletid >0) {
                         $userQuery =  "update user_table set wallet_balance=wallet_balance-".$data['grand_total']." where user_id=".$data['user_id'];
                        $userData = $this->db->query($userQuery);
                    }
                } else {     //update job request to COD if wallet is not having enough amount
                
                    $this->db->where('job_request_id',$insertId);
                    $this->db->set('payment_method',1);
                    $this->db->update('job_request');

                }
            }

            /*wallet payment ends here*/

        $this->db->trans_complete();

        // print_r($provider);exit;

        if ($this->db->trans_status() === FALSE) 
            return 0;
        else 
            return $return;
    }
    
    public function getAssignJobDetails($condition){
        
        $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get('assign_job_provider')->row();
    }
    
    public function userAppliedCoupon($data){
        
        $this->db->insert('coupon_usage',$data);
        return $this->db->affected_rows();
    }
    
    public function getUserDetailsById($userId){
        $this->db->select('*');
        $this->db->where('user_id',$userId);
        $this->db->join('country','country.country_id = user_table.country_id and country_language_code	= 1','left');
        return $this->db->get('user_table')->row();
    }
    
    public function getUserAddress($address_id){
        $this->db->select('*');
        $this->db->where('user_adresses_id',$address_id);
        $this->db->join('area','area.area_id = user_adresses.user_adresses_area and area_language_code = 1');
        return $this->db->get('user_adresses')->row();
    }

    public function getRequestDays($job_request_id)
    {
        $this->db->order_by('job_date','asc');
        return $this->db->get_where('job_request_days',['job_request_id'=>$job_request_id])->result();
    }
    

    public function getWalletLog($user_id){

        $this->db->select('uw.*,ut.admin_user_name');
        $this->db->from('user_wallet uw');
        $this->db->join('admin_user ut','ut.admin_user_id=uw.created_by','left');
        $this->db->where('uw.user_id',$user_id);
        $this->db->order_by('uw.wallet_id','desc');
        return $this->db->get()->result();
    }
    public function getUsersCondition($data)
    {
        $this->db->join('country c','c.country_id=user_table.country_id and c.country_language_code=1','left');
        $this->db->join('city ','city.city_id=user_table.city_id and city.city_language_code=1','left');
        $query = $this->db->order_by('user_id', 'desc')->get_where('user_table', $data);
        return $query->result();
    }

    public function saveTempRequest($data,$question){
        // print_r($data);
        $this->db->insert('job_request_temp',$data);
        $job_request_temp_id    = $this->db->insert_id();

        if (count($question) > 0) {
            $i = 0;
            foreach ($question as $key => $value) {
                $input[$i]['job_request_temp_id']   = $job_request_temp_id;
                $input[$i]['question_id']      = $key;
                $input[$i]['service_type_id']  = $data['service_type_id'];
                $input[$i]['user_id']          = $data['user_id'];

                if (count($value) > 1) {
                    $k = 1;
                    
                    foreach ($value as $row) {
                        $input[$i]['job_request_temp_id']           =        $job_request_temp_id;
                        $input[$i]['question_id']                 =        $key;
                        $input[$i]['service_type_id']          =        $data['service_type_id'];
                        $input[$i]['user_id']                         =        $data['user_id'];
                        $input[$i]['answer']                         =        $row;
                        if ($k != count($answer))
                            $i++;

                        $k++;
                    }
                } else {
                    /*$input[$i]['answer']          = $value[0];*/
                    $input[$i]['job_request_temp_id']    = $job_request_temp_id;
                    $input[$i]['question_id']       = $key;
                    $input[$i]['service_type_id']   = $data['service_type_id'];
                    $input[$i]['user_id']           = $data['user_id'];
                    $input[$i]['answer']            = $value;
                }
                $i++;
            }
        }

        $this->db->where('job_request_temp_id', $job_request_temp_id);
        $this->db->delete('request_question_temp');

        $this->db->insert_batch('request_question_temp', $input);

        return $job_request_temp_id;
    }   

    public function getServiceTypeById($service_type_id,$language= 1){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('service_type')->row();
    }

    public function get_tem_order($job_request_temp_id){
        $this->db->select('*');
        $this->db->where('job_request_temp_id',$job_request_temp_id);
        return $this->db->get('job_request_temp')->row();
    }

    public function getTempQuestionAnswer($job_request_temp_id){
        $this->db->select('*');
        $this->db->where('job_request_temp_id',$job_request_temp_id);
        return $this->db->get('request_question_temp')->result();
    }

    public function createNewJobRequest($data,$questAnsOptions,$providerList){

        $this->db->insert('job_request',$data);
        $job_request_id = $this->db->insert_id();

        $this->db->where('job_request_id',$job_request_id);
        $this->db->delete('request_question_option');
        echo "<pre>";
        foreach ($questAnsOptions as $key => $value) {

            $data = array('job_request_id' => $job_request_id, 
                          'question_id'    => $value->question_id,
                          'service_type_id'=> $value->service_type_id,
                          'user_id'        => $this->session->userdata('eq_user_id'),
                          'answer'         => $value->answer
                        );
            $this->db->insert('request_question_option', $data);
        }

        if(!empty($providerList)){
            $provider =[];
            foreach($providerList as $key=> $value){
                $provider[$key]['job_request_id'] = $return;
                $provider[$key]['assign_status']  = 0;
                $provider[$key]['provider_id']    = $value->provider_id;
                $provider[$key]['assigned_date']  = date("Y-m-d H:i:s");
            }
            // print_r($providerList);exit;
            $this -> db ->where('job_request_id', $job_request_id);
            $this -> db ->delete('assign_job_provider');
            $this -> db ->insert_batch('assign_job_provider',$provider);
        }

        $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE) 
            return 0;
        else 
            return $job_request_id;
        // exit;
    }
    
}

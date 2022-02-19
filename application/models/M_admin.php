<?php
class M_admin extends CI_Model
{

    function login($data)
    {

        $query = $this->db->get_where('admin_user', $data);
        // echo $this->db->last_query();
        return $query->row();
    }
    public function getCountriesCondition($data)
    {
        $query = $this->db->order_by('country_name', 'asc')->get_where('country', $data);

        return $query->result();
    }
    function getCountries($language = 0, $id = 0, $status = "")
    {

        $language   = $language > 0 ? $language : 1;

        $this->db->select('*');
        $this->db->from('country c');
        $this->db->where('country_language_code', $language);
        if ($id > 0) {
            $this->db->where('country_id', $id);
        }
        if ($status > 0) {
            $this->db->where('country_status', $status);
        }
        $this->db->order_by('country_language_code', 'ASC');
        $query = $this->db->get();
        if ($id <= 0) {
            return $query->result();
        } else {
            return $query->row();
        }
    }
    function saveMasterTable($inputArray, $inputArray2, $key, $languageField, $tableName)
    {







        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);




        $this->db->trans_start();
        if (isset($inputArray[$key]) && $inputArray[$key] > 0) {

            $this->db->where($key, $inputArray[$key]);
            $this->db->where($languageField, 1);
            $this->db->update($tableName, $inputArray);


            $this->db->where($key, $inputArray2[$key]);
            $this->db->where($languageField, 2);
            $this->db->update($tableName, $inputArray2);

            $entityId =  $inputArray2[$key];

            $action   = 2;
        } else {
            $this->db->select('max(' . $key . ') as maxid');
            $this->db->from('' . $tableName . ' c');
            $this->db->where($languageField, $language);
            $query = $this->db->get();
            // echo $this->db->last_query();
            $res  =  $query->row();
            $maxId              =   ($res->maxid > 0 ? $res->maxid + 1 : 1);

            //print_r($inputArray);
            $inputArray[$key]     =   $maxId;
            $inputArray2[$key]    =   $maxId;
            $this->db->insert($tableName, $inputArray);

            // echo $this->db->last_query(); exit;
            $this->db->insert($tableName, $inputArray2);



            $entityId =  $maxId;
            $action   = 1;
        }


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial
        $menu_id  = 5;

        if ($key == "country_id") {
            $moduleId = 6;
        } else if ($key == "city_id") {
            $moduleId = 7;
        } else if ($key == "service_type_id") {
            $moduleId = 8;
        } else if ($key == "article_type_id") {
            $menu_id = 6;
            $moduleId = 25;
        }
        //dragon_offer_banner?:


        $auditArray                                =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     $moduleId;
        $auditArray['entity_id']        =     $entityId;
        $auditArray['action_id']        =     $action;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     $menu_id;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial 


        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return $entityId;
        }
    }
    public function getCitiesCondition($data)
    {
        $query = $this->db->order_by('city_name', 'asc')->get_where('city', $data);
        return $query->result();
    }
    function saveUser($input1, $input2)
    {
        $this->db->select('count(user_email) as count');
        $this->db->from('user_table c');
        $this->db->where('user_email', $input1['user_email']);
        if ($input1['user_id'] > 0) {
            $this->db->where('user_id !=', $input1['user_id']);
        }
        $query = $this->db->get();
        if ($query->row()->count > 0) {
            return 3;
            exit;
        } else {
            $this->db->trans_start();


            if ($input1['user_id'] > 0) {
                $this->db->where('user_id', $input1['user_id']);
                $this->db->update('user_table', $input1);
                $this->db->where('user_id', $input1['user_id']);
                $this->db->update('user_details', $input2);
                $action =  2;
            } else {
                unset($input1['user_id']);
                $this->db->insert('user_table', $input1);
                $insertId = $this->db->insert_id();
                $input2['user_id']      =   $insertId;
                $this->db->insert('user_details', $input2);
                $action =  1;
            }
            $auditArray                              =    array();
            $auditArray['admin_id']         =    $this->session->userdata('admin_id');
            $auditArray['module_id']      =    1;
            $auditArray['entity_id']          =    $userId;
            $auditArray['action_id']         =    $action;
            $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
            $auditArray['audit_note']       =    "";
            $auditArray['menu_id']          =    3;
            $this->db->insert('admin_audit_trial', $auditArray);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        }
    }
    public function getUsersCondition($data)
    {
        $this->db->join('country c','c.country_id=user_table.country_id and c.country_language_code=1','left');
        $this->db->join('city ','city.city_id=user_table.city_id and city.city_language_code=1','left');
        $query = $this->db->order_by('user_id', 'desc')->get_where('user_table', $data);
        return $query->result();
    }
    public function getUsersDetailsCondition($data)
    {
        $query = $this->db->order_by('user_id', 'desc')->get_where('user_details', $data);
        return $query->result();
    }
    function deleteUser($userId)
    {
        $this->db->trans_start();

        $this->db->where('user_id', $userId);
        $this->db->delete('user_table');
        $this->db->where('user_id', $userId);
        $this->db->delete('user_details');
        $this->db->where('user_id', $userId);
        $this->db->delete('provider_details');
        $this->db->where('user_id', $userId);
        $this->db->delete('job_request');
        $this->db->where('provider_id', $userId);
        $this->db->delete('assign_job_provider');
        $this->db->where('provider_id', $userId);
        $this->db->delete('provider_service_type');
        $this->db->where('user_id', $userId);
        $this->db->delete('user_adresses');

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    1;
        $auditArray['entity_id']          =    $userId;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    3;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    
    function changeSliderStatus(){
        
        $this->db->set('slider_status',$_POST['status']);
        $this->db->where('slider_id',$_POST['id']);
        $this->db->update('app_slider');
        
        return $this->db->affected_rows();
    }
    
    function approveUser()
    {
        $userId          =  $_POST['id'];
        $this->db->where('user_id', $userId);
        $inputUserBasic['user_status']  =   $_POST['status'];
        $this->db->update('user_table', $inputUserBasic);
        $user = $this->getBasicUserDeatils($userId);
        
        $this->db->where('provider_id',$userId);
        $this->db->set('area_status',$_POST['status']);
        $this->db->update('provider_areas');
        
        //print_r($user);
        if ($user->user_type == 1) {
            $module = 2;
        } else if ($user->user_type == 2) {
            $module = 2;
        }

        $action =       $_POST['status'] == 1 ? 4 : 5;
        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    $module;
        $auditArray['entity_id']          =    $userId;
        $auditArray['action_id']         =    $action;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    3;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial


        if ($_POST['status'] == 1) {




            if ($user->user_type == 1 || $user->user_type == 2) {

                $subject  =  "Welcome to vhelp! ";
                $to      =   $user->user_email;
                // $to      =  "syamca2s@gmail.com";
                // $from    =  "info@teyaar.com";

                if ($user->user_type = 2) {
                    $this->db->select('*');
                    $this->db->where('user_id',$userId);
                    $provider_details = $this->db->get('provider_details')->row();
                    $content = "Congratulations ! Your account has been approved. You can now proceed with logging into your account and add services.";
                    $userMaiArray['user_name']     = $provider_details->company_name;
                } else if ($user->user_type = 1) {
                    $content = "Congratulations on successful registration. You can now proceed with logging into your account and purchase/promote products.";
                    $userMaiArray['user_name']     = $user->user_first_name.' '.$user->user_last_name;
                }
                $userMaiArray['message'] = $content;

                
                $to                       =  $to;
                $userMaiArray['subject']  = $subject;
                $this->load->library('parser');
                $email_message  = $this->parser->parse('email/register', $userMaiArray, true);
                $this->load->library("Mail_function");
                $this->mail_function->SendEmail($email_message, $subject, $to);
            }
        }
        return 1;
    }
    function getBasicUserDeatils($id)
    {
        $query = $this->db->get_where('user_table', array('user_id' => $id));
        // echo $this->db->last_query();
        return $query->row();
    }
    function deleteCountry($id)
    {
        $this->db->trans_start();

        $this->db->where('country_id', $id);
        $this->db->delete('country');

        $this->db->where('city_country_id', $id);
        $this->db->delete('city');

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     6;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "country delete from admin module";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getCitiesWithCountries()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $this->db->select('c.*,c2.city_name as arbicname,c.city_name as englishname,country_name');
        $this->db->from('city c');
        $this->db->join('city c2', 'c2.city_id =c.city_id', 'left');
        $this->db->join('country c3', 'c.city_country_id =c3.country_id', 'left');
        $this->db->where('c3.country_language_code', 1);
        $this->db->where('c.city_language_code', 1);
        $this->db->where('c2.city_language_code', 2);
        /* if($additional['searchKey']!="")
                {
                    $this->db->like('LOWER(c.city_name)', strtolower($additional['searchKey'])); 
                }*/
        $this->db->order_by('c.city_id', 'desc');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    function deleteCity($id)
    {
        $this->db->trans_start();

        $this->db->where('city_id', $id);
        $this->db->delete('city');


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     7;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "city delete from admin module";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getCities($language, $id)
    {
        $query = $this->db->get_where('city', array('city_language_code' => $language, 'city_id' => $id));
        return $query->row();
    }
    function getServiceTypeWithParent()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $this->db->select('c.*,c2.service_type_name as arbicname,c.service_type_name as englishname,c3.service_type_name as parentname');
        $this->db->from('service_type c');
        $this->db->join('service_type c2', 'c2.service_type_id =c.service_type_id', 'left');
        $this->db->join('service_type c3', '(c.service_type_parent_id =c3.service_type_id) AND (c3.service_type_language_code =1)', 'left');
        $this->db->where('c.service_type_language_code', 1);
        $this->db->where('c2.service_type_language_code', 2);
        $this->db->order_by('c.service_type_id', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    function getServiceTypes($data)
    {
        $query = $this->db->order_by('service_type_name', 'asc')->get_where('service_type', $data);
        return $query->result();
    }
    function getServiceMethods($data)
    {
        $query = $this->db->order_by('service_methode_name', 'asc')->get_where('service_methode', $data);
        return $query->result();
    }
    function getServiceTypes2($language, $id)
    {
        $query = $this->db->get_where('service_type', array('service_type_language_code' => $language, 'service_type_id' => $id));
        return $query->row();
    }
    function deleteServiceType($id)
    {
        $isChildExists      = $this->db->where(['service_type_parent_id'=>$id,'service_type_language_code'=>1])->get('service_type')->num_rows();
        $isServiceBooked    = $this->db->where(['service_type_id'=>$id])->get('job_request')->num_rows();
        if($isChildExists)
        {
            echo 2;die;
        }
        else if($isServiceBooked)
        {
            echo 3;die;
        }

        $this->db->trans_start();

        $this->db->where('service_type_id', $id);
        $this->db->delete('service_type');

        $this->db->where('service_type_parent_id', $id);
        $this->db->delete('service_type');

        $this->db->where('questions_service_type_id', $id);
        $this->db->delete('question');


        $this->db->where('service_type_id', $id);
        $this->db->delete('job_request');

        $this->db->where('service_type_id', $id);
        $this->db->delete('service_faq');

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                                =     array();
        $auditArray['admin_id']          =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     8;
        $auditArray['entity_id']           =     $id;
        $auditArray['action_id']          =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "country delete from admin module";
        $auditArray['menu_id']            =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getFormControls($data)
    {
        $query = $this->db->order_by('form_control_name', 'asc')->get_where('form_controls', $data);
        return $query->result();
    }
    function getFormQuestions($data)
    {
        $query = $this->db->order_by('question_id', 'desc')->get_where('question', $data);
        return $query->result();
    }
    function getFormQuestions2($data)
    {

        $sql     =  "   select  * from question where question_status=" . $data['question_status'] . " and questions_service_type_id=" . $data['questions_service_type_id'] . " and question_form_type in (4,2)";

        if ($data['curent_question'] > 0) {
            $sql .=  " and question_id not in(" . $data['curent_question'] . ") ";
        }
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();

        return $result;
        $query = $this->db->order_by('question_id', 'desc')->get_where('question', $data);
        return $query->result();
    }
    function saveDynamicForm($data)
    {
        //print_r($data);
        // exit;
        $language  = 1;
        $this->db->trans_start();
        if (count($data) > 0) {


            if ((int)$data['txt_question_id'] <= 0) {
                $this->db->select('max(question_id) as maxid');
                $this->db->from('question c');

                $query = $this->db->get();
                // echo $this->db->last_query();
                $res                    =   $query->row();
                $maxId              =   ($res->maxid > 0 ? $res->maxid + 1 : 1);
            } else {
                $maxId                  =    (int)$data['txt_question_id'];
            }

            $input                                                  =       array();
            $input['question_id']                       =       $maxId;
            $input['question']                             =       $data['txtEnglish'];
            $input['question_arb']                    =       $data['txtArabic'];
            $input['question_id']                       =       $maxId;
            $input['question_status']               =       $data['txtStatus'];
            $input['question_form_type']       =       $data['txtInputType'];
            $input['questions_answer_type'] =       0;
            $input['questions_service_type_id'] =       $data['serviceTypeId'];

            $input['question_parent_id']        =       $data['txtParentQuest'];
            $input['answer_parent_id']           =       $data['txtParentAnswer'];

            if ((int)$data['txt_question_id'] <= 0) {

                $input['question_created_time']        =       gmdate("Y-m-d H:i:s");
                $input['question_created_by']            =       $this->session->userdata('admin_id');
                $this->db->insert('question', $input);
                $action = 1;
            } else {
                $input['question_updated_time']        =       gmdate("Y-m-d H:i:s");
                $input['question_updated_by']            =       $this->session->userdata('admin_id');

                $this->db->where('question_id', $data['txt_question_id']);
                $this->db->update('question', $input);

                $this->db->where('question_id', $data['txt_question_id']);
                $this->db->delete('answer_options');
                $action = 2;
            }

            $j = 0;

            foreach ($data['txtOptionEng'] as $rows) {
                $answer  =  array();
                if ($data['txtOptionoldid'][$j] > 0) {
                    $answer['answer_options_id']                    =   $data['txtOptionoldid'][$j];
                }
                $answer['question_id']                                  =   $maxId;
                $answer['answer_option']                            =   $rows;
                $answer['answer_option_arabic']              =   $data['txtOptionArabic'][$j];
                $answer['answer_options_status']             =   1;
                $answer['price']   = $data['txtOptionPrice'][$j];
                $this->db->insert('answer_options', $answer);

                $j++;
            }

            //admin audit trial //admin audit trial//admin audit trial//admin audit trial

            $auditArray                                =     array();
            $auditArray['admin_id']         =     $this->session->userdata('admin_id');
            $auditArray['module_id']       =     5;
            $auditArray['entity_id']           =     $maxId;
            $auditArray['action_id']          =     $action;
            $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
            $auditArray['audit_note']       =     "";
            $auditArray['menu_id']            =     5;
            $this->db->insert('admin_audit_trial', $auditArray);
            //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        }
        //   print_r($input);
        //  print_r($answer);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getAnswers($data)
    {
        $query = $this->db->order_by('answer_options_id', 'asc')->get_where('answer_options', $data);
        return $query->result();
    }
    function getQuestionsWithService($data)
    {
        // print_r($data);
        $language = ($data['language'] > 0 ? $data['language'] : 1);
        //exit;

        $this->db->select('*');
        $this->db->from('question c');
        $this->db->join('service_type c2', 'c2.service_type_id =c.questions_service_type_id', 'left');
        $this->db->join('form_controls c3', 'c3.form_control_id =c.question_form_type', 'left');
        $this->db->where('c2.service_type_language_code', $language);
        if ($data['questions_service_type_id'] > 0) {
            $this->db->where('c2.service_type_id', $data['questions_service_type_id']);
        }
        $this->db->order_by('c.question_id', 'desc');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    function deleteQuestion($id)
    {

        $this->db->trans_start();
        $this->db->where('question_id', $id);
        $this->db->delete('answer_options');
        $this->db->where('question_id', $id);
        $this->db->delete('question');

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                                =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']       =     5;
        $auditArray['entity_id']           =     $id;
        $auditArray['action_id']          =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']            =     5;
        $this->db->insert('admin_audit_trial', $auditArray);
        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function loadDesignation()
    {



        $sql     =  "   select  * from designation_master where designation_status=1 order by designation ASC";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();

        return $result;
    }
    function getAdminUsers()
    {
        $sql     =  "   select  * from designation_master m,admin_user a where designation_status=1 and a.designation_id=designation_master_id ";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();

        return $result;
    }
    function saveAdminUsers($data)
    {

        //Array ( [txt_first_name] => bvbvcb [txt_last_name] => bvcbv [txt_user_name] => vcbvcb [txt_email] => vbvcb@gmail.com [txt_password] => 3435545454 [txt_designation] => 2 [id] => 0 [txtStatus] => 0 [ci_csrf_token] => null )
        $input['admin_user_email']        =     $data['txt_email'];
        $input['admin_user_status']       =     $data['txtStatus'];
        $input['admin_user_created_date'] =     gmdate("Y-m-d H:i:s");
        $input['admin_user_password']     =     MD5($data['txt_password']);
        $input['admin_user_name']         =     $data['txt_user_name'];
        $input['admin_first_name']        =     $data['txt_first_name'];
        $input['admin_last_name']         =     $data['txt_last_name'];
        $input['designation_id']          =     $data['txt_designation'];

        $this->db->trans_start();
        if ($data['id'] > 0) {
            unset($input['admin_user_password']);

            $this->db->select('count(admin_user_email) as count');
            $this->db->from('admin_user c');
            $this->db->where('admin_user_email', $data['txt_email']);
            $this->db->where_not_in('admin_user_id', $data['id']);
            $query = $this->db->get();
            // echo $this->db->last_query();
            if ($query->row()->count > 0) {
                return 3;
                exit;
            }

            $this->db->select('count(admin_user_email) as count');
            $this->db->from('admin_user c');
            $this->db->where('admin_user_name', $data['txt_user_name']);
            $this->db->where_not_in('admin_user_id', $data['id']);
            $query = $this->db->get();
            //    echo $this->db->last_query();
            if ($query->row()->count > 0) {
                return 4;
                exit;
            }


            $this->db->where('admin_user_id', $data['id']);
            $this->db->update('admin_user', $input);
        } else {


            $this->db->select('count(admin_user_email) as count');
            $this->db->from('admin_user c');
            $this->db->where('admin_user_email', $data['txt_email']);
            $query = $this->db->get();
            // echo $this->db->last_query();
            if ($query->row()->count > 0) {
                return 3;
                exit;
            }

            $this->db->select('count(admin_user_email) as count');
            $this->db->from('admin_user c');
            $this->db->where('admin_user_name', $data['txt_user_name']);
            $query = $this->db->get();
            //    echo $this->db->last_query();
            if ($query->row()->count > 0) {
                return 4;
                exit;
            }


            $this->db->insert('admin_user', $input);
        }

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function approveAdmin($data)
    {
        $id                                =     $data['id'];
        $input['admin_user_status']        =     $data['status'];

        $this->db->trans_start();
        $this->db->where('admin_user_id', $id);
        $this->db->update('admin_user', $input);
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getMenus()
    {
        $sql     =  "   select  * from admin_menu where admin_menu_status=1	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        return $result;
    }
    function getAdminUserDetails($adminId)
    {
        $sql     =  "   select  * from admin_user where admin_user_id=" . $adminId . "	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->row();
        return $result;
    }
    function saveAdminPermission($data)
    {

        //   print_r($data);
        $menu  =    $this->getMenus();
        $i = 0;
        foreach ($menu as $rows) {
            $input[$i]['menu_id']               =  $rows->admin_menu_id;
            $input[$i]['admin_user_id']    =  $data['admin_user_id'];
            $input[$i]['perm_view']        =  $data['txt_view'][$rows->admin_menu_id] > 0 ? $data['txt_view'][$rows->admin_menu_id] : 0;
            //  $input[$i]['perm_view']        =  1;
            $input[$i]['perm_add']         =  $data['txt_add'][$rows->admin_menu_id] > 0 ? $data['txt_add'][$rows->admin_menu_id] : 0;
            $input[$i]['perm_delete']      =  $data['txt_delete'][$rows->admin_menu_id] > 0 ? $data['txt_delete'][$rows->admin_menu_id] : 0;
            $input[$i]['perm_edit']        =  $data['txt_edit'][$rows->admin_menu_id] > 0 ? $data['txt_edit'][$rows->admin_menu_id] : 0;
            $input[$i]['perm_date']        =  gmdate("Y-m-d H:i:s");


            $i++;
        }


        $this->db->trans_start();

        $this->db->where('admin_user_id', $data['admin_user_id']);
        $this->db->delete('menu_permission');
        $this->db->insert_batch('menu_permission', $input);


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']        =    24;
        $auditArray['entity_id']        =    $data['admin_user_id'];
        $auditArray['action_id']        =    1;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    2;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial


        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getAdminPermissionsByMenu($adminId, $menuId)
    {
        if ($adminId == 1) {
            $permArray["perm_edit"]      = 1;
            $permArray["perm_view"]     = 1;
            $permArray["perm_delete"]  = 1;
            $permArray["perm_add"]      = 1;
            return (object)$permArray;
        }
        $sql     =  "   select  * from menu_permission where admin_user_id=" . $adminId . " and menu_id=" . $menuId . "	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->row();
        return $result;
    }
    function deleteAdmin($data)
    {
        $this->db->trans_start();

        $this->db->where('admin_user_id', $data['admin_user_id']);
        $this->db->delete('admin_user');

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     23;
        $auditArray['entity_id']        =     $data['admin_user_id'];
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     2;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function changePasswordAdminUser($data)
    {
        $adminId                      =  $this->M_product->decryptId($data['pwdchid']);
        $input['admin_user_password'] =  MD5($data['txt_new_pwd']);

        $this->db->trans_start();
        $this->db->where("admin_user_id", $adminId);
        $this->db->update("admin_user", $input);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getUserType($userId)
    {
        $sql     =  "   select  user_type from user_table where user_id=" . $userId . "	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->row();
        return $result;
    }
    function getAudittrails()
    {
        $sql     =  "  select * from admin_audit_trial at,action_master am,admin_menu adm,module_master mm,admin_user au
WHERE at.action_id=am.action_id and adm.admin_menu_id=at.menu_id and mm.module_id=at.module_id and au.admin_user_id=at.admin_id order by audit_time desc	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        return $result;
    }
    function listauditTrailReportCount($data)
    {
        $sql     =  "  select * from admin_audit_trial at,action_master am,admin_menu adm,module_master mm,admin_user au
WHERE at.action_id=am.action_id and adm.admin_menu_id=at.menu_id and mm.module_id=at.module_id and au.admin_user_id=at.admin_id 	";

        $search_key  = strtolower($_POST['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(admin_menu_name) like  '%" . $search_key . "%' or LOWER(module_name) like  '%" . $search_key . "%' or LOWER(action_name) like  '%" . $search_key . "%' or LOWER(admin_first_name) like  '%" . $search_key . "%' or LOWER(admin_last_name) like  '%" . $search_key . "%' or LOWER(admin_user_email) like  '%" . $search_key . "%' or LOWER(admin_user_name) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(audit_time)>='" . $data['txt_sale_datefrom'] . "' and  date(audit_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(audit_time)>='" . $data['txt_sale_datefrom'] . "' and  date(audit_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(audit_time)>='" . $data['txt_sale_dateto'] . "' and  date(audit_time)<='" . $data['txt_sale_dateto'] . "' ";
        }


        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function listauditTrailReport($data, $limit_per_page, $start_index)
    {
        $sql     =  "  select * from admin_audit_trial at,action_master am,admin_menu adm,module_master mm,admin_user au
WHERE at.action_id=am.action_id and adm.admin_menu_id=at.menu_id and mm.module_id=at.module_id and au.admin_user_id=at.admin_id 	";

        $search_key  = strtolower($_POST['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(admin_menu_name) like  '%" . $search_key . "%' or LOWER(module_name) like  '%" . $search_key . "%' or LOWER(action_name) like  '%" . $search_key . "%' or LOWER(admin_first_name) like  '%" . $search_key . "%' or LOWER(admin_last_name) like  '%" . $search_key . "%' or LOWER(admin_user_email) like  '%" . $search_key . "%' or LOWER(admin_user_name) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(audit_time)>='" . $data['txt_sale_datefrom'] . "' and  date(audit_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(audit_time)>='" . $data['txt_sale_datefrom'] . "' and  date(audit_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(audit_time)>='" . $data['txt_sale_dateto'] . "' and  date(audit_time)<='" . $data['txt_sale_dateto'] . "' ";
        }

        $sql .= " order by audit_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";

        $rs      =  $this->db->query($sql);

        return $result  =   $rs->result();
    }
    function saveProvider($input1, $input2, $input3,$area)
    {
        //print_r($input3);exit;
        $this->db->select('count(user_email) as count');
        $this->db->from('user_table c');
        $this->db->where('user_email', $input1['user_email']);
        if ($input1['user_id'] > 0) {
            $this->db->where('user_id !=', $input1['user_id']);
        }
        $query = $this->db->get();
        if ($query->row()->count > 0) {
            return 3;
            exit;
        } else {
            $this->db->trans_start();


            if ($input1['user_id'] > 0) {
                $this->db->where('user_id', $input1['user_id']);
                $this->db->update('user_table', $input1);
                $this->db->where('user_id', $input1['user_id']);
                $this->db->update('provider_details', $input2);
                $action =  2;

                $id = $input1['user_id'];
            } else {
                unset($input1['user_id']);
                $this->db->insert('user_table', $input1);
                $insertId = $this->db->insert_id();
                $input2['user_id']      =   $insertId;
                $this->db->insert('provider_details', $input2);
                $action =  1;
                $id = $insertId;
            }
            $sym = 0;
            if (count($input3) > 0) {
                $this->db->where('provider_id', $id);
                $this->db->delete('provider_service_type');
                foreach ($input3 as $ProServ) {
                    $proServIn[$sym]['provider_id']               =   $id;
                    $proServIn[$sym]['service_type_id']        =  $ProServ;
                    $sym++;
                }

                $this->db->insert_batch('provider_service_type', $proServIn);
            }
            
            $this->db->select("user_status");
            $this->db->where('user_id',$id);
            $user_status = $this->db->get('user_table')->row();
            $area_status = $user_status->user_status;
            
            if(count($area) > 0 ){
                $this->db->where('provider_id',$id);
                $this->db->delete('provider_areas');

                foreach ($area as $key => $value) {
                    $areaData[$key]['provider_id'] = $id;
                    $areaData[$key]['area_status'] = $area_status;
                    $areaData[$key]['created_at']  = gmdate("Y-m-d H:i:s");
                    $areaData[$key]['area_id']    = $value;
                }

                $this->db->insert_batch('provider_areas',$areaData);
            }
            
            $auditArray                              =    array();
            $auditArray['admin_id']         =    $this->session->userdata('admin_id');
            $auditArray['module_id']      =    2;
            $auditArray['entity_id']          =    $userId;
            $auditArray['action_id']         =    $action;
            $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
            $auditArray['audit_note']       =    "";
            $auditArray['menu_id']          =    3;
            $this->db->insert('admin_audit_trial', $auditArray);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        }
    }
    public function getProvidersDetailsCondition($data)
    {
        $query = $this->db->order_by('user_id', 'desc')->get_where('provider_details', $data);
        return $query->result();
    }
    function getArticleTypes($data)
    {

        $query = $this->db->get_where('article_type', $data);
        return $query->result();
    }
    function getArticleTypesMultiLanguage()
    {
        $sql     =  "   select  a.*,a.article_type_desc as engname,a2.article_type_desc as arabicname from article_type a ,article_type a2 where a.article_type_id=a2.article_type_id and a.article_type_language_code=1 and a2.article_type_language_code=2	";
        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        return $result;
    }
    function saveArticle($data)
    {
        $this->db->trans_start();



        $this->db->select('count(articles_id) as counter');
        $this->db->from('articles c');
        $this->db->where('articles_language_code', 1);
        $this->db->where('articles_type_id', $data['txt_article_type']);
        $query = $this->db->get();
        // echo $this->db->last_query();
        $res  =  $query->row();
        $count              =   ($res->counter > 0 ? $res->counter : 0);



        $inputArray[0]['articles_type_id']          =    $data['txt_article_type'];
        $inputArray[0]['articles_desc']             =    htmlentities($data['txt_article']);
        $inputArray[0]['articles_status']           =    1;
        $inputArray[0]['articles_created_date']     =    gmdate("Y-m-d H:i:s");
        $inputArray[0]['articles_language_code']    =    1;


        $inputArray[1]                              =    $inputArray[0];
        $inputArray[1]['articles_language_code']    =    2;
        $inputArray[1]['articles_desc']             =    $data['txt_article_arb'];

        if ($count > 0) {

            //$articleId                                  =    $data['id'];
            $inputArray[0]['articles_updated_date']     =    gmdate("Y-m-d H:i:s");
            $inputArray[1]['articles_updated_date']     =    gmdate("Y-m-d H:i:s");

            unset($inputArray[0]['articles_created_date']);
            unset($inputArray[1]['articles_created_date']);



            $this->db->where('articles_language_code', 1);
            $this->db->where('articles_type_id', $data['txt_article_type']);
            $this->db->update('articles', $inputArray[0]);

            $this->db->where('articles_language_code', 2);
            $this->db->where('articles_type_id', $data['txt_article_type']);
            $this->db->update('articles', $inputArray[1]);
            $action = 1;
        } else {

            $this->db->select('max(articles_id) as maxid');
            $this->db->from('articles c');
            $this->db->where('articles_language_code', 1);
            $query = $this->db->get();
            // echo $this->db->last_query();
            $res  =  $query->row();
            $maxId              =   ($res->maxid > 0 ? $res->maxid + 1 : 1);

            $inputArray[0]['articles_id']               =    $maxId;

            $inputArray[1]['articles_id']               =    $maxId;



            $this->db->insert_batch('articles', $inputArray);

            $action = 2;
        }


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']        =    26;
        $auditArray['entity_id']        =    $maxId > 0 ? $maxId : 0;
        $auditArray['action_id']        =    $action;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getArticles()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $language = 1;
        $this->db->select('a3.article_type_desc,a.*,a.articles_desc as arbicname,a2.articles_desc as englishname');
        $this->db->from('articles a');
        $this->db->join('articles a2', 'a2.articles_id =a.articles_id', 'inner');
        $this->db->join('article_type a3', 'a3.article_type_id =a.articles_type_id', 'inner');
        $this->db->where('a.articles_language_code', 1);
        $this->db->where('a2.articles_language_code', 2);
        $this->db->where('a3.article_type_language_code', $language);
        $this->db->order_by('a.articles_id', 'desc');
        //$this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    function getArticlesById($language, $id)
    {

        $query = $this->db->get_where('articles', array('articles_language_code' => $language, 'articles_id' => $id));
        return $query->row();
    }
    function deleteArticle($id)
    {
        $this->db->trans_start();
        $this->db->where('articles_id', $id);
        $this->db->delete('articles');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function deleteArticleType($id)
    {

        $this->db->trans_start();

        $this->db->where('article_type_id', $id);
        $this->db->delete('article_type');
        $this->db->where('articles_type_id', $id);
        $this->db->delete('articles');

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    25;
        $auditArray['entity_id']          =    $id;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function saveChangePassword($data)
    {
        $sql = "select  count(admin_user_password) as count from admin_user where admin_user_password= '" . MD5($data["txt_old_password"]) . "' ";
        $rs = $this->db->query($sql);
        $count = $result = $rs->row()->count;
        if ($count <= 0) {
            return -1;
        } else {

            $this->db->trans_start();

            $input['admin_user_password']  =  MD5($data["txt_new_password"]);

            $this->db->where('admin_user_id', $this->session->userdata('admin_id'));
            $this->db->update('admin_user', $input);

            $this->db->trans_complete();


            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        }
    }
    function listUserReportCount($data)
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        /*$sql     =  "  select * from user_table u,country c, city y where user_type=" . $data['user_type'] . " and c.country_id=u.country_id and y.city_id=u.city_id and y.city_language_code=c.country_language_code and c.country_language_code=" . $language . " ";*/
        
        $sql     =  "  select * from user_table u
        left join country c on (c.country_id=u.country_id and c.country_language_code=" . $language.")
        left join city y on (y.city_id=u.city_id and y.city_language_code=c.country_language_code )
        where user_type=".$data['user_type'];
        
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%' or LOWER(user_last_name) like  '%" . $search_key . "%' or LOWER(user_email) like  '%" . $search_key . "%' or LOWER(user_phone) like  '%" . $search_key . "%' or LOWER(user_zip) like  '%" . $search_key . "%' or LOWER(country_name) like  '%" . $search_key . "%' or LOWER(city_name) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(user_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(user_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(user_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }


        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function listUserReport($data, $limit_per_page, $start_index)
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        //$sql     =  "  select * from user_table u,country c, city y where user_type=" . $data['user_type'] . " and c.country_id=u.country_id and y.city_id=u.city_id and y.city_language_code=c.country_language_code and c.country_language_code=" . $language . " ";
        
        $sql     =  "  select * from user_table u left join country c on (c.country_id=u.country_id and c.country_language_code=" . $language.")
        left join city y on (y.city_id=u.city_id and y.city_language_code=c.country_language_code )
        where user_type=".$data['user_type'];

        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(user_first_name) like  '%" . $search_key . "%' or LOWER(user_last_name) like  '%" . $search_key . "%' or LOWER(user_email) like  '%" . $search_key . "%' or LOWER(user_phone) like  '%" . $search_key . "%' or LOWER(user_zip) like  '%" . $search_key . "%' or LOWER(country_name) like  '%" . $search_key . "%' or LOWER(city_name) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(user_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(user_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(user_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(user_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        $sql .= " order by user_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";

        $rs      =  $this->db->query($sql);

        return $result  =   $rs->result();
    }
    function listServiceTypeReportCount($data)
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $sql     =  "  select * from service_type where service_type_language_code=" . $language . " ";

        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(service_type_name) like  '%" . $search_key . "%' ) ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_datefrom'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_datefrom'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_dateto'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_dateto'] . "' ";
        }

        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function listServiceTypeReport($data, $limit_per_page, $start_index)
    {

        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $sql     =  "  select * from service_type where service_type_language_code=" . $language . " ";

        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(service_type_name) like  '%" . $search_key . "%' ) ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_datefrom'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_datefrom'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(service_type_created_date)>='" . $data['txt_sale_dateto'] . "' and  date(service_type_created_date)<='" . $data['txt_sale_dateto'] . "' ";
        }
        $sql .= " order by service_type_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";

        $rs      =  $this->db->query($sql);

        return $result  =   $rs->result();
    }
    function saveTestimonial($data)
    {
        $this->db->trans_start();

        if ($data['testimonial_id'] > 0) {
            $this->db->where('testimonial_id', $data['testimonial_id']);
            $this->db->update('testimonial', $data);
            $action = 2;
        } else {

            $this->db->insert('testimonial', $data);
            $action = 1;
        }

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    27;
        $auditArray['entity_id']          =    $id;
        $auditArray['action_id']         =    $action;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function listTestimonialReportCount($data)
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $sql     =  "  select * from testimonial t,user_type u where u.user_type_id=t.user_type ";

        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(first_name) like  '%" . $search_key . "%'  or LOWER(last_name) like  '%" . $search_key . "%'  or LOWER(testimonial) like  '%" . $search_key . "%'  or  LOWER(testimonial_arabic) like  '%" . $search_key . "%'  or  LOWER(user_type_name_eng) like  '%" . $search_key . "%'  or  LOWER(user_type_name_arb) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }

        $rs      =  $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function listTestimonialReport($data, $limit_per_page, $start_index)
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $sql     =  "  select * from testimonial t,user_type u where u.user_type_id=t.user_type ";

        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and ( LOWER(first_name) like  '%" . $search_key . "%'  or LOWER(last_name) like  '%" . $search_key . "%'  or LOWER(testimonial) like  '%" . $search_key . "%'  or  LOWER(testimonial_arabic) like  '%" . $search_key . "%'  or  LOWER(user_type_name_eng) like  '%" . $search_key . "%'  or  LOWER(user_type_name_arb) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(testimonial_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(testimonial_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        $sql .= " order by testimonial_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";
        $rs      =  $this->db->query($sql);

        return $result  =   $rs->result();
    }
    function getTestimonials($data)
    {

        $query = $this->db->get_where('testimonial', $data);
        return $query->result();
    }
    function deleteTestimonials($id)
    {

        $this->db->trans_start();


        $this->db->where('testimonial_id', $id);
        $this->db->delete('testimonial');

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    27;
        $auditArray['entity_id']          =    $id;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getDynamicQuestions($data)
    {


        $sql = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1";
        $sql .= "  and questions_service_type_id=" . $data['select_service_type'] . " and question_parent_id<=0";
        $sql .= "  order by question_id ASC";
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function getProviderAgainstServiceType($serviceTypeId)
    {
        $sql = " select * from provider_service_type ps,user_table u,provider_details p where ps.provider_id=u.user_id and u.user_id=p.user_id

and ps.service_type_id=" . $serviceTypeId . " and u.user_status=1  order by company_name ASC";

        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function saveRequest($data, $docs)
    {

        // print_r($docs);
        $this->db->trans_start();
        $job['user_id']                                                    =              $data['txt_user_id'];
        $job['service_type_id']                                            =              $data['select_service_type'];
        if ($data['is_home'] == 0) {
            $job['address_type']                                               =              $data['address_type'];
            $job['job_date']                                                   =              $data['txt_date'];
            $job['job_price_from']                                             =              $data['select_price_from'];
            $job['job_price_to']                                               =              $data['select_price_to'];
            $job['job_time']                                                   =              date("H:i:s", strtotime($data['txtTime']));
        } else {
            $job['job_location']                                               =              $data['txt_location'];
            $job['job_longitude']                                              =              $data['txt_longitude'];
            $job['job_lattitude']                                              =              $data['txt_lattitude'];
            $job['city']                                                       =              $data['us5-city'];
            $job['state']                                                      =              $data['us5-state'];
        }

        $job['job_validity_date']                                          =              $data['txt_valid_date'];
        $job['job_request_type']                                           =              $data['select_option'];
        $job['job_request_status']                                         =              0;
        $job['job_request_created_time']                                   =              gmdate("Y-m-d H:i:s");
        $job['job_validity_time']                                          =              date("H:i:s", strtotime($data['txtValidTime']));
        $job['description']                                                =              $data['txt_additional_info'];

        if ($data['select_option'] == 1) {
            $firstString = "Q";
        } else {
            $firstString = "R";
        }

        $this->load->library("Common_functions");
        $randomString =  $this->common_functions->incrementalHash(2);
        $job['job_request_display_id']         =           $firstString . $randomString . $data['txt_user_id'] . gmdate("mdHis");


        if ($data['job_request_id'] <= 0) {

            $this->db->insert('job_request', $job);
            $insertId                   =              $this->db->insert_id();
            $return                     =              $insertId;
        } else {

            $this->db->where('job_request_id', $data['job_request_id']);
            $this->db->update('job_request', $job);
            $return = $data['job_request_id'];
        }
        $question   =    $data['question'];
        if (count($question) > 0) {
            $i = 0;
            foreach ($question as $key => $value) {
                $input[$i]['job_request_id']           =        $return;
                $input[$i]['question_id']                 =        $key;
                $input[$i]['service_type_id']          =        $data['select_service_type'];
                $input[$i]['user_id']                         =        $data['txt_user_id'];
                $answer                                              =         $value;

                //print_r($answer);
                if (count($answer) > 0) {
                    $k = 1;
                    foreach ($answer as $row) {
                        $input[$i]['job_request_id']           =        $return;
                        $input[$i]['question_id']                 =        $key;
                        $input[$i]['service_type_id']          =        $data['select_service_type'];
                        $input[$i]['user_id']                         =        $data['txt_user_id'];
                        $input[$i]['answer']                         =        $row;
                        if ($k != count($answer))
                            $i++;

                        $k++;
                    }
                } else {
                    $input[$i]['answer']                         =        $value;
                }
                $i++;
            }

            $this->db->where('job_request_id', $return);
            $this->db->delete('request_question_option');
            $this->db->insert_batch('request_question_option', $input);

            // print_r($input);

            //  exit;
        }
        if ($data['select_option'] == 2) {
            if (count($data['txt_provider']) > 0) {
                $l = 0;
                foreach ($data['txt_provider'] as $prov) {
                    $provider[$l]['job_request_id']           =        $return;
                    $provider[$l]['assign_status']              =        0;
                    $provider[$l]['provider_id']                  =        $prov;
                    $provider[$l]['assigned_date']            =        gmdate("Y-m-d H:i:s");

                    $l++;
                }

                $this->db->where('job_request_id', $return);
                $this->db->delete('assign_job_provider');
                $this->db->insert_batch('assign_job_provider', $provider);
            }
        }
        if (count($docs['document']) > 0) {
            $j = 0;
            foreach ($docs['document'] as $documents) {
                $docsArray[$j]["documents_name"] = $documents;
                $docsArray[$j]["job_request_id"] = $return;
                $j++;
            }
            $this->db->insert_batch('documents', $docsArray);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getJobRequests($jobRequestId = 0)
    {
        $sql = " select q.question_id,question,question_arb,answer_options_id,answer,answer_option,answer_option_arabic from question q,request_question_option ro 
LEFT JOIN answer_options a ON  a.question_id=ro.question_id  and answer_options_id::varchar=answer and a.question_id=ro.question_id
where  q.question_id=ro.question_id  ";
        if ($jobRequestId > 0) {
            $sql .= " and  ro.job_request_id=" . $jobRequestId . " ";
        }
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function getJobRequestsListCount($data)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id  ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and (LOWER(job_request_display_id) like  '%" . $search_key . "%' or LOWER(CONCAT(user_first_name,' ',user_last_name)) like  '%" . $search_key . "%'  or LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " ) ";
        }
        if ($data['user_id'] > 0) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        } //echo $sql;
        $rs = $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function getJobRequestsList($data, $limit_per_page, $start_index)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id  ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and (LOWER(job_request_display_id) like  '%" . $search_key . "%' or LOWER(CONCAT(user_first_name,' ',user_last_name)) like  '%" . $search_key . "%' or LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['provider_id'] > 0 && $data['job_request_type'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " )";
        }
        if ($data['user_id'] > 0) {
            $sql .=      " and j.user_id=" . $data['user_id'] . " ";
        }
        $sql .= " order by job_request_id DESC   offset " . $start_index . "   limit  " . $limit_per_page . "";
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getAssignedProviders_old($jobRequestId)
    {
        $sql = " select *,a.document_name as provider_doc from assign_job_provider a,user_table u, provider_details d  WHERE d.user_id=u.user_id  and  u.user_id=a.provider_id and a.job_request_id=" . $jobRequestId . "";
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getJobRequestsDetails_old($jobRequestId)
    {
        $sql = "select q.question_id,question,question_arb,array_agg(CASE WHEN answer_option!='' THEN answer_option ELSE answer END) as  answer_option  ,
array_agg(CASE WHEN answer_option!='' THEN answer_option_arabic ELSE answer END) as  answer_option_arabic 
 from question q,request_question_option ro 
LEFT JOIN answer_options a ON  a.question_id=ro.question_id  and answer_options_id::varchar=answer and a.question_id=ro.question_id
where  q.question_id=ro.question_id   and  ro.job_request_id=" . $jobRequestId . "
GROUP BY  q.question_id,question,question_arb
";
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getProviderResponseStatus($jobRqustId, $providerId)
    {
        $sql = "select  * from assign_job_provider where  job_request_id=" . $jobRqustId . "
  and provider_id=" . $providerId . "
";
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->row();
    }
    function setProviderResponse($data)
    {
        $input['provider_note']     =  $data['note'];
        $input['assign_status']     =   $data['response_status'];
        $input['provider_response_time']     =  gmdate("Y-m-d H:i:s");
        $this->db->trans_start();
        $this->db->where('job_request_id', $this->common_functions->decryptId($data['job_request_id']));
        $this->db->where('provider_id', $data['provider_id']);
        $this->db->update('assign_job_provider', $input);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function markProviderPrice($data)
    {

        $sql = "select  count(provider_amount) as count from assign_job_provider where job_request_id= " . $this->common_functions->decryptId($data['job_request_id']) . " and provider_id=" . $data['provider_id'] . " ";
        $rs = $this->db->query($sql);
        $count = $result = $rs->row()->count;
        if ($count > 0) {
            return -1;
        } else {

            $provider['provider_amount']                  =   $data['price'];
            $provider['provider_response_time']     =  gmdate("Y-m-d H:i:s");
            $provider['job_request_id']                 =        $this->common_functions->decryptId($data['job_request_id']);
            $provider['assign_status']                    =        3;
            $provider['provider_id']                        =        $data['provider_id'];
            $provider['assigned_date']                  =        gmdate("Y-m-d H:i:s");
            $provider['provider_response_time']                  =        gmdate("Y-m-d H:i:s");

            if ($data['document_name'] != "") {
                $provider['document_name']                        =        $data['document_name'];
            }

            $this->db->trans_start();
            $sql = "select  count(job_request_id) as count from assign_job_provider where job_request_id= " . $this->common_functions->decryptId($data['job_request_id']) . " and provider_id=" . $data['provider_id'] . " ";
            $rs = $this->db->query($sql);
            $count = $result = $rs->row()->count;
            //exit;
            if ($count <= 0) {
                $this->db->insert('assign_job_provider', $provider);
            } else {
                unset($provider['job_request_id']);
                $this->db->where('provider_id', $data['provider_id']);
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
    function getJobRequestsListCountUser()
    {

        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id  ";
        $search_key  = strtolower($data['search_key']);

        if ($search_key != "") {
            $sql .=      " and (LOWER(job_request_display_id) like  '%" . $search_key . "%'  or LOWER(user_first_name) like  '%" . $search_key . "%'  or LOWER(user_last_name) like  '%" . $search_key . "%'  or LOWER(service_type_name) like  '%" . $search_key . "%'  or  LOWER(job_location) like  '%" . $search_key . "%') ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['txt_sale_datefrom'] != "" && $data['txt_sale_dateto'] == "") {
            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_datefrom'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_datefrom'] . "' ";
        }
        if ($data['txt_sale_datefrom'] == "" && $data['txt_sale_dateto'] != "") {

            $sql .=      " and date(job_request_created_time)>='" . $data['txt_sale_dateto'] . "' and  date(job_request_created_time)<='" . $data['txt_sale_dateto'] . "' ";
        }
        if ($data['job_request_type'] != "") {
            $sql .=      " and job_request_type='" . $data['job_request_type'] . "' ";
        }
        if ($data['user_id'] > 0 && $data['user_id'] == 2) {
            $sql .=      " and j.job_request_id in(select job_request_id from assign_job_provider where provider_id=" . $data['provider_id'] . " ) ";
        }
        $rs = $this->db->query($sql);
        $result  =   $rs->result();
        $result = $rs->result_array();
        $count = count($result);
        $array['count']          = $count;
        $array = (object) $array;
        return $array;
    }
    function getJobRequestBasicDetails($jobRequestId)
    {
        $sql = "select * from job_request j,user_table u,service_type s WHERE u.user_id=j.user_id and s.service_type_language_code=1 and s.service_type_id=j.service_type_id  and j.job_request_id=" . $jobRequestId . "";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->row();
    }
    function approveProvider($data)
    {
        $sql = "select  count(job_request_id) as count from assign_job_provider where job_request_id= " . $data['job_request_id'] . " and provider_id=" . $data['provider_id'] . " and user_response_status=4";
        $rs = $this->db->query($sql);
        $count = $result = $rs->row()->count;
        if ($count > 0) {
            return -1;
        }
        //$provider['assign_status']                   =  4;
        $provider['user_response_time']          =  gmdate("Y-m-d H:i:s");
        $provider['user_response_status']       =  1;
        $job["job_request_status"]                    =  4;
        $this->db->trans_start();
        //set all others cancelled
        $others['user_response_status'] = 2;
        $others['user_response_time']          =  gmdate("Y-m-d H:i:s");
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->update('assign_job_provider', $others);

        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->where('provider_id', $data['provider_id']);
        $this->db->update('assign_job_provider', $provider);
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->update('job_request', $job);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {

            return 1;
        }
    }
    function getCountOfUsers($type, $status)
    {
        $sql = "select  count(user_id) as count from user_table where user_type= " . $type . " and user_status=" . $status . "";
        $rs = $this->db->query($sql);
        return $count = $result = $rs->row()->count;
    }
    function getJobRequestsCount()
    {
        $sql = "select  count(job_request_id) as count from job_request where job_request_type=2 ";
        $rs = $this->db->query($sql);
        return $count = $result = $rs->row()->count;
    }
    function getJobQuotationCount()
    {
        $sql = "select  count(job_request_id) as count from job_request where job_request_type=1";
        $rs = $this->db->query($sql);
        return $count = $result = $rs->row()->count;
    }
    function getMonthWiseCount($type, $month)
    {
        $sql = "select count(*),date_trunc( 'month', job_request_created_time ) from job_request where job_request_type=" . $type . " and EXTRACT(MONTH FROM job_request_created_time)=" . $month . " group by
date_trunc( 'month', job_request_created_time );";
        $rs = $this->db->query($sql);
        return $result = $rs->row()->count;
    }
    function getStatuswiseJobCount($status)
    {
        $sql = "select  count(job_request_id) as count from assign_job_provider where assign_status=" . $status . "";
        $rs = $this->db->query($sql);
        return $count = $result = $rs->row()->count;
    }
    function getServiceTypesForGraph()
    {
        $sql = "select service_type_id,service_type_name from service_type where service_type_language_code=1 order by service_type_name ASC";
        $rs = $this->db->query($sql);
        return  $rs->result();
    }
    function getServiceTypewiseCount($type, $serviceTypeid)
    {
        $sql = "select  count(job_request_id) as count from job_request where service_type_id=" . $serviceTypeid . " and job_request_type=" . $type . "";
        $rs = $this->db->query($sql);
        return $count =  $rs->row()->count;
    }
    function getJobsLocations()
    {
        $sql = "select  job_longitude as longitude,job_lattitude as lattitude ,user_first_name as first_name,user_image as image,u.user_id as id  from job_request j,user_table u where job_request_type!=0 and u.user_id=j.user_id
";
        $rs = $this->db->query($sql);
        return $rs->result_array();
    }
    function getProvidersLocations()
    {
        $sql = "select  longitude as longitude,lattitude as lattitude ,company_name as first_name,user_image as image,u.user_id as id  from provider_details j,user_table u where  u.user_id=j.user_id
";
        $rs = $this->db->query($sql);
        return $rs->result_array();
    }
    function getDistinctProvidersList()
    {
        $sql = "select distinct provider_id,company_name from assign_job_provider a,provider_details d where a.provider_id=d.user_id";
        $rs = $this->db->query($sql);
        return $rs->result();
    }
    function getMonthWiseCountCompany($provider, $type, $month)
    {
        $sql = "select count(*),date_trunc( 'month', job_request_created_time ) from job_request r,assign_job_provider a where job_request_type=" . $type . " and EXTRACT(MONTH FROM job_request_created_time)=" . $month . " and a.job_request_id=r.job_request_id and a.provider_id=" . $provider . "   group by
date_trunc( 'month', job_request_created_time )";
        $rs = $this->db->query($sql);
        return $result = $rs->row()->count;
    }
    function getDynamicQuestionsChild($data)
    {


        $sql = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1";
        $sql .= " ";
        if ($data['questionId'] > 0) {
            $sql .= "  and question_parent_id=" . $data['questionId'] . "";
        }
        if ($data['answerOption'] > 0) {
            $sql .= "  and answer_parent_id=" . $data['answerOption'] . "";
        }
        $sql .= "  order by question_id ASC";
        $rs = $this->db->query($sql);
        return   $row = $rs->result();
    }
    function getProvidersServiceTypesCondition($data)
    {
        $query = $this->db->order_by('provider_id', 'asc')->get_where('provider_service_type', $data);

        return $query->result();
    }
    function savePackages($data)
    {
        $packageId                  =  $this->common_functions->decryptId($data['txt_package_id']);
        $input['packages_name']                                   =      $data['txt_package_name'];
        $input['packages_name_arabic']                     =      $data['txt_package_name_arabic'];
        $input['packages_recomended_provider']    =      $data['radio_recomended'];
        $input['packages_price']                                    =      $data['txt_package_price'];
        $input['packages_quotaion_limit']                  =      $data['txt_no_of_qtns'];
        $input['packages_status']                                 =     $data['txtStatus'];

        $this->db->trans_start();
        if ($packageId > 0) {

            $input['packages_updated_by']                      =    $this->session->userdata('admin_id');;
            $input['packages_updated_time']                  =    gmdate("Y-m-d H:i:s");

            $this->db->where('packages_id', $packageId);
            $this->db->update('packages', $input);
            $action = 2;
        } else {
            $input['packages_created_by']                    =     $this->session->userdata('admin_id');;
            $input['packages_created_time']                =    gmdate("Y-m-d H:i:s");


            $this->db->insert('packages', $input);
            $packageId  = $this->db->insert_id();
            $action = 1;
        }
        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    30;
        $auditArray['entity_id']          =    $packageId;
        $auditArray['action_id']         =    $action;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    5;
        $this->db->insert('admin_audit_trial', $auditArray);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {

            return 1;
        }
    }
    public function getPackagesCondition($data)
    {
        $query = $this->db->order_by('packages_id', 'desc')->get_where('packages', $data);

        return $query->result();
    }
    function deletePackage($packageId)
    {

        $this->db->trans_start();

        $this->db->where('packages_id', $packageId);
        $this->db->delete('packages');

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    30;
        $auditArray['entity_id']          =    $packageId;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    5;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function assignPackage($data)
    {
        $this->db->trans_start();

        $input['package_id']     =  $data['package'];
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('provider_details', $input);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getPackageName($packageId)
    {
        $sql = "select * from packages where packages_id=" . $packageId . "";
        $rs = $this->db->query($sql);
        return $result = $rs->row();
    }
    function getJobRequestsDetailsForEditModule($jobRequestId)
    {
        $sql = "select q.question_id,question,question_arb,question_form_type,array_agg(CASE WHEN answer_option!='' THEN answer_option ELSE answer END) as  answer_option  ,
array_agg(CASE WHEN answer_option!='' THEN answer_option_arabic ELSE answer END) as  answer_option_arabic 
 from question q,request_question_option ro 
LEFT JOIN answer_options a ON  a.question_id=ro.question_id  and answer_options_id::varchar=answer and a.question_id=ro.question_id
where  q.question_id=ro.question_id   and  ro.job_request_id=" . $jobRequestId . "
GROUP BY  q.question_id,question,question_arb,question_form_type
";
        $rs      =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getAllAnswerAgainstJob($jobRequestId, $questionId)
    {

        $sql       = "select answer from request_question_option ro where ro.job_request_id=" . $jobRequestId . " and question_id=" . $questionId . " order by question_id asc";
        $rs       =  $this->db->query($sql);
        return $result  =   $rs->result_array();
    }
    function saveBanner($data)
    {

        $this->db->trans_start();
        $input['banner_title']                         =        $data['txtEnglish'];
        $input['banner_title_arabic']           =        $data['txtArabic'];
        $input['banner_url']                           =        $data['txtUrl'];
        $input['banner_status']                     =        $data['txtStatus'];
        if ($data['banner_image'] != "") {
            $input['banner_image']                     =        $data['banner_image'];
        }
        if ($data['banner_id'] <= 0) {
            $input['banner_created_time']       =        gmdate("Y-m-d H:i:s");
            $this->db->insert('banner', $input);
            $id = $this->db->insert_id();
            $action = 1;
        } else {
            $this->db->where('banner_id', $data['banner_id']);
            $this->db->update('banner', $input);
            $action = 2;

            $id  = $data['banner_id'];
        }

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     28;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     $action;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    public function getBanners($data)
    {
        $query = $this->db->order_by('banner_id', 'desc')->get_where('banner', $data);

        return $query->result();
    }
    function deleteBanner($id)
    {

        $this->db->trans_start();

        $this->db->where('banner_id', $id);
        $this->db->delete('banner');



        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     28;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "country delete from admin module";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getActiveBanner()
    {
        $sql       = "select * from banner where banner_status=1";
        $rs       =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function filterServiceType($data)
    {
        $sql       = "select * from service_type where service_type_language_code=" . $data['service_type_language_code'] . " and service_type_status=" . $data['service_type_status'] . " and is_home_category=" . $data['is_home_category'] . "";
        $search_key  = strtolower($data['service_key_word']);

        if ($search_key != "") {
            $sql .=      " and LOWER(service_type_name) like  '%" . $search_key . "%' ";
        }
        if ($data['city_id'] > 0) {
            $sql .=      " and service_type_id in (select service_type_id from provider_service_type p,user_table u where city_id=" . $data['city_id'] . " and p.provider_id=u.user_id and user_status=1  ) ";
        }

        //echo $sql;

        $rs       =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function getAdminBasics()
    {
        $sql = "  select * from admin_basics limit 1 ";
        $rs = $this->db->query($sql);
        // echo $this->db->last_query();	
        return      $result  =   $rs->row();
    }
    function saveAdminDetails($data)
    {

        $this->db->trans_start();
        $input['email_id']  =  $data['txt_email'];
        $input['address']                 =  $data['txt_address'];
        $input['phone_no 	']  =  $data['txt_dial'] . "-" . $data['txt_phone'];
        $input['date']                 =  gmdate("Y-m-d H:i:s");

        $input['fb_link']     = $data['txt_facebook'];
        $input['twitter_link']            = $data['txt_twitter'];
        $input['google_link']     = $data['txt_google'];
        $input['youtube_link']     = $data['txt_youtube'];
        $input['insta_link']     = $data['txt_insta'];

        if ($data['table_id'] > 0) {
            $this->db->where('id', $data['table_id']);
            $this->db->update('admin_basics', $input);
            $action = 2;

            $entityId  = $data['table_id'];
        } else {
            $this->db->insert('admin_basics', $input);
            $entityId  = $this->db->insert_id();
            $action = 1;
        }

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']        =     22;
        $auditArray['entity_id']        =     $entityId;
        $auditArray['action_id']        =     $action;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function saveServiceFaq($data)
    {
        $input['service_faq'] = $data['txtEnglish'];
        $input['service_faq_answer'] = $data['txtAnswer'];
        $input['service_type_id'] = $data['serviceTypeId'];
        $input['service_faq_language_code'] = 1;
        $input2['service_faq'] = $data['txtArabic'];
        $input2['service_faq_answer'] = $data['txtAnswerArabic'];
        $input2['service_type_id'] = $data['serviceTypeId'];
        $input2['service_faq_language_code'] = 2;
        $key  = "service_faq_id";
        if ($data['id'] > 0) {
            $input['service_faq_id'] = $key;
            $input2['service_faq_id'] = $key;
        }


        $result =  $this->saveMasterTable($input, $input2, $key, "service_faq_language_code", "service_faq");
        if ($result == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    function getFaqList()
    {

        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $sql       = "select s.service_type_name,f.* from service_type s,service_faq f where service_type_language_code=" . $language . " and s.service_type_id	=f.service_type_id and f.service_faq_language_code=service_type_language_code	 ";


        $rs       =  $this->db->query($sql);
        return $result  =   $rs->result();
    }
    function deleteFAQ($id)
    {
        $this->db->trans_start();

        $this->db->where('service_faq_id', $id);
        $this->db->delete('service_faq');


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     6;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "country delete from admin module";
        $auditArray['menu_id']          =     5;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function checkHasChild($currentQuestion)
    {
        $sql       = "select count(question_id) from question where question_parent_id=" . $currentQuestion . "";

        $rs       =  $this->db->query($sql);
        return $result  =   $rs->row()->count;
    }
    function deleteJobRequest($id)
    {




        $this->db->trans_start();

        $this->db->where('job_request_id', $id);
        $this->db->delete('job_request');


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     31;
        $auditArray['entity_id']        =     $id;
        $auditArray['action_id']        =     3;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     9;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function approveJobRequest($data)
    {
        $jobRequestId                   =  $this->common_functions->decryptId($data['jobRequestId']);
        $input['is_approoved']          =  $data['nextStatus'];
        if ($data['reason'] > 0) {
            $input['refuse_reason']     =  $data['reason'];
            $this->db->where('job_request_id',$jobRequestId);
            $this->db->set('job_request_status',10);
            $this->db->update('job_request');
            
        }

        $sql       = "select count(job_request_id) as count from assign_job_provider where job_request_id=" . $jobRequestId . " and user_response_status=1 ";
        $rs        =  $this->db->query($sql);
        $count     =   $rs->row()->count;
        if ($count > 0 && $input['is_approoved'] == -1) {
            return -1;
        }


        $this->db->trans_start();

        $this->db->where('job_request_id', $jobRequestId);
        $this->db->update('job_request', $input);

        // echo $this->db->last_query();


        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =     array();
        $auditArray['admin_id']         =     $this->session->userdata('admin_id');
        $auditArray['module_id']        =     31;
        $auditArray['entity_id']        =     $jobRequestId;
        $auditArray['action_id']        =     $data['nextStatus'] == 1 ? 4 : 5;
        $auditArray['audit_time']       =     gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =     "";
        $auditArray['menu_id']          =     9;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            // exec("php " . FCPATH . "index.php admin/C_admin sendApproveNotification " . $jobRequestId . " " . $input['is_approoved'] . " > /dev/null 2>&1 &");
            return 1;
        }
    }
    function getUploadedFiles($jobRequestId)
    {
        $sql = "select * from documents  WHERE job_request_id=" . $jobRequestId . "  ";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->result();
    }
    function getJobDetails($jobRequestId)
    {
        $sql = "select * from job_request  WHERE job_request_id=" . $jobRequestId . "  ";
        $rs  = $this->db->query($sql);
        return  $result  =   $rs->row();
    }
    function getFcmGroupDetails($serviceTypeId)
    {
        $sql = " select fcm_key,notification_group_name from service_type s where  service_type_language_code=1 and service_type_id=" . $serviceTypeId . "";
        $rs  = $this->db->query($sql);
        return $result =  $rs->row();
    }
    function getUsersFcmTokens($userId)
    {
        $sql = " select * from user_table where  user_id=" . $userId . "";
        $rs  = $this->db->query($sql);
        return $result =  $rs->row();
    }
    function getProvidersAgainsServiceType($serviceType)
    {
        $sql = "select distinct provider_id from provider_service_type where service_type_id=" . $serviceType . "";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->result();
    }
    function updateToFirbase($userId, $type, $message, $title, $jobType, $id)
    {

        $touserID       =   $type . $userId;

        $t = round(microtime(true) * 1000);

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
    function getAssignedProvidersId($jobRequestId)
    {
        $sql = "select distinct provider_id from assign_job_provider where job_request_id=" . $jobRequestId . "";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->result();
    }
    function getHomeLocation($userId, $type)
    {
        $sql = " select *  from user_adresses where user_id=" . $userId . " and user_adresses_type_id=" . $type . " ";
        $rs = $this->db->query($sql);
        return  $rs->row();
    }
    function getRatingCondition($data)
    {
        $sql = "  select r.*,u.user_first_name as user_first_name,u.user_last_name as user_last_name,u2.user_first_name as provider_first_name,u2.user_last_name as provider_last_name,p.company_name,u2.user_image  from provider_rating  r ,user_table u, user_table u2,provider_details p where  u.user_id=r.user_id and u2.user_id=r.provider_id and u2.user_id=p.user_id order by provider_rating_id DESC ";
        $rs = $this->db->query($sql);
        return      $result  =   $rs->result();
    }
    function approveRating()
    {


        $this->db->trans_start();
        $ratingId         =  $_POST['id'];
        $this->db->where('provider_rating_id', $ratingId);
        $inputUserBasic['rating_status']  =   $_POST['status'];
        $this->db->update('provider_rating', $inputUserBasic);




        $action =       $_POST['status'] == 1 ? 4 : 5;
        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    32;
        $auditArray['entity_id']          =    $ratingId;
        $auditArray['action_id']         =    $action;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function deleteRating($id)
    {


        $this->db->trans_start();

        $this->db->where('provider_rating_id', $id);
        $this->db->delete('provider_rating');
        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    32;
        $auditArray['entity_id']          =    $userId;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getViewersList($jobRequestId)
    {
        $sql = "  select r.*,p.company_name,u.user_image,u.user_first_name as user_first_name,u.user_last_name as user_last_name  from job_view_count  r ,user_table u,provider_details p where  p.user_id=u.user_id and u.user_id=r.provider_id and r.job_request_id=" . $jobRequestId . " order by job_view_id DESC ";
        $rs = $this->db->query($sql);
        return      $result  =   $rs->result();
    }
    public function getHomeLabels($data)
    {
        $query = $this->db->order_by('home_labels_id', 'asc')->get_where('home_labels', $data);

        return $query->row();
    }
    function saveHomelabels($data)
    {



        $this->db->trans_start();

        $input['home_labels1']            =   $data['txt_label1'];
        $input['home_labels_arabic1']     =   $data['txt_label1_arabic'];
        $input['home_labels2']            =   $data['txt_label2'];
        $input['home_labels2_arabic']     =   $data['txt_label2_arabic'];
        $this->db->where('home_labels_id', 1);
        $this->db->update('home_labels', $input);

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']         =    33;
        $auditArray['entity_id']          =    1;
        $auditArray['action_id']         =    2;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    6;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function confirmJob($data)
    {

        $otherResponse['user_response_status'] = 2;
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->update('assign_job_provider', $otherResponse);

        $userResponse['user_response_status']  = 1;
        $userResponse['user_response_time']  = gmdate("Y-m-d H:i:s");

        $this->db->trans_start();

        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->where('provider_id', $data['provider_id']);
        $this->db->update('assign_job_provider', $userResponse);

        $jobStatus['job_request_status']  = 4;
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->update('job_request', $jobStatus);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $auditArray                     =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']        =    33;
        $auditArray['entity_id']        =    $ratingId;
        $auditArray['action_id']        =    2;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    9;
        $this->db->insert('admin_audit_trial', $auditArray);

        //admin audit trial //admin audit trial//admin audit trial//admin audit trial

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function getAddressFromAdressType($adressTypeId)
    {
    }
    function userDetails($data)
    {
        $userId         =     $this->common_functions->decryptId($data['id']);
        $sql            =     "  select *  from user_table u LEFT JOIN provider_details p ON p.user_id=u.user_id  LEFT JOIN country c ON c.country_id=u.country_id and country_language_code=1  LEFT JOIN city  t ON t.city_id=u.city_id and city_language_code=1 where u.user_id=" . $userId . " ";
        $rs             =     $this->db->query($sql);
        return $result  =     $rs->row();
    }
    function getProviderServiceType($id)
    {
        $sql            =     "  select *  from service_type s,provider_service_type p where p.service_type_id=s.service_type_id and provider_id=" . $id . " and service_type_language_code=1";
        $rs             =     $this->db->query($sql);
        return $result  =     $rs->result();
    }

    function assignServiceProvider_old($data)
    {
        //$data['service_provider'] 
        $provider[0]['job_request_id']           =        $data['job_request_id'];
        $provider[0]['assign_status']              =        1;
        $provider[0]['provider_id']                  =        $data['service_provider'];
        $provider[0]['assigned_date']             =        date("Y-m-d H:i:s");
        $provider[0]['provider_response_time']    = date("Y-m-d H:i:s");
        
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->delete('assign_job_provider');
        $this->db->insert_batch('assign_job_provider', $provider);
    }
    
    function assignServiceProvider($data){
        
        $i_data['job_request_id']           = $data['job_request_id'];
        $i_data['assign_status']            = 1;
        $i_data['provider_id']              = $data['service_provider'];
        $i_data['assigned_date']            = date("Y-m-d H:i:s");
        $i_data['provider_response_time']   = date("Y-m-d H:i:s");
        
        $this->db->where('job_request_id', $data['job_request_id']);
        $this->db->delete('assign_job_provider');
        
        $this->db->insert('assign_job_provider',$i_data);
        $asign_job_request_id = $this->db->insert_id();
        
        if($asign_job_request_id > 0 ){
            $this->db->where('job_request_id',$data['job_request_id']);
            $this->db->set('job_request_status',1);
            $this->db->set('vendor_id',$data['service_provider']);
            $this->db->update('job_request');
        }
        
        return $asign_job_request_id;
    }

    function getAssignedServiceProvider($id)
    {
        $sql            =     "  select *  from assign_job_provider where job_request_id=" . $id;
        $rs             =     $this->db->query($sql);
        return $result  =     $rs->result();
    }

    // function getAreaList()
    // {
    //     $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

    //     $this->db->select('c.*,c2.area_name as arbicname,c.area_name as englishname,city_name');
    //     $this->db->from('area c');
    //     $this->db->join('area c2', 'c2.area_id =c.area_id', 'left');
    //     $this->db->join('city c3', 'c.city_id =c3.city_id', 'left');
    //     $this->db->where('c3.city_language_code', 1);

    //     $this->db->where('c.area_language_code', 1);
    //     $this->db->where('c2.area_language_code', 2);
    //     $this->db->order_by('c.area_id', 'desc');

    //     $query = $this->db->get();
    //     return $query->result();
    // }
    
    function getAreaList(){
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $this->db->select('a1.*,a2.area_name as arbicname,a1.area_name as englishname,city_name');
        $this->db->join('area a2','a2.area_id = a1.area_id','left');
        
        $this->db->join('city c', 'c.city_id =a1.city_id and c.city_language_code =1', 'left');
        
        $this->db->where('a1.area_language_code',1);
        $this->db->where('a2.area_language_code',2);
        
        $this->db->order_by('a1.area_id', 'desc');
        
        return $this->db->get('area a1')->result();
    }

    function getCityList($language = 0,$condition=[])
    {
        $language   = $language > 0 ? $language : 1;

        $this->db->select('*');
        $this->db->from('city c');
        
        if(!empty($condition))
            $this->db->where($condition);

        $this->db->where('city_language_code', $language);
        return $this->db->get()->result();
    }

    public function getAreaCondition($data)
    {
        $query = $this->db->get_where('area', $data);
        return $query->row();
    }

    function deleteArea($id)
    {
        $this->db->trans_start();
        $this->db->where('area_id', $id);
        $this->db->delete('area');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
            return 0;
        else
            return 1;
    }

    function create_faq($data)
    {
        $this->db->insert("faq", $data);
        return $this->db->insert_id("faq_faq_id_seq");
    }

    function update_faq($data, $condition)
    {
        $this->db->where($condition)
            ->update("faq", $data);

        return $this->db->affected_rows();
    }

    function get_faq_list()
    {

        return $this->db->select("*")
            ->from("faq")
            ->order_by("faq_id", "desc")
            ->get()
            ->result();
    }

    public function get_faq_meta_data()
    {
        return $this->db->select("meta_title, meta_keyword, meta_description")
            ->from("faq")
            ->get()
            ->row();
    }


    function get_faq($id)
    {

        return $this->db->select("*")
            ->from("faq")
            ->where("faq_id", $id)
            ->get()
            ->row();
    }

    function delete_faq($id)
    {
        $this->db->where("faq_id", $id)
            ->delete("faq");

        return $this->db->affected_rows();
    }

    function update_faq_meta_data($data)
    {
        $this->db->update("faq", $data);
        return $this->db->affected_rows();
    }

    public function getAppSliderList($language = 1)
    {

        $this->db->select('app_slider.*,service_type.service_type_name');
        $this->db->join('service_type', 'service_type.service_type_id = app_slider.slider_service_type and service_type.service_type_language_code = '.$language, 'left');
        // $this->db->where_in('service_type_language_code',$language);
        $this->db->order_by('slider_id','desc');
        return $this->db->get('app_slider')->result();
    }

    public function getServiceList()
    {
        $this->db->select('*');
        $this->db->where('service_type_language_code', 1);
        return $this->db->get('service_type')->result();
    }

    public function saveAppSlider($data, $slider_id)
    {

        if ($slider_id > 0) {
            $this->db->where('slider_id', $slider_id);
            $this->db->update('app_slider', $data);
        } else {
            $data['created_on']  = gmdate('Y-m-d H:i:s');
            $this->db->insert('app_slider', $data);
        }
        return $this->db->affected_rows();
    }

    public function getAppSliderById($slider_id)
    {
        $this->db->select('*');
        $this->db->where('slider_id', $slider_id);
        return $this->db->get('app_slider')->row();
    }
    
    public function getUserAreaList()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $this->db->select('*');
        $this->db->where('area_status', 1);
        $this->db->where('area_language_code', $language);
        return $this->db->get('area')->result();
    }

    public function getSelectedAreaByCondition($condition)
    {

        $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get('provider_areas')->result();
    }
    
    public function getJobRequestsDetails($job_request_id){

        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->join('question','question.question_id = request_question_option.question_id','left');
        $this->db->join('answer_options','answer_options.answer_options_id = request_question_option.answer','left');
        return $this->db->get('request_question_option')->result();
    }
    
    public function getAssignedProviders($job_request_id){

        $this->db->select('*');
        $this->db->where('assign_job_provider.job_request_id',$job_request_id);
        $this->db->join('user_table','user_table.user_id = assign_job_provider.provider_id','left');
        $this->db->join('provider_details','provider_details.user_id = assign_job_provider.provider_id','left');
        $this->db->join('job_request','job_request.job_request_id = assign_job_provider.job_request_id','left');
        return $this->db->get('assign_job_provider')->result();
    }
    
    public function getCouponDetails(){

        $this->db->select('*');
        return $this->db->get('coupon')->result();
    }

    public function getServiceListByCondition($condition){

        $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get('service_type')->result();
    }

    public function getCoupon($coupon_id){

        $this->db->select('*');
        $this->db->where('coupon_id',$coupon_id);
        return $this->db->get('coupon')->row();
    }

    public function saveCoupon($data){

        $coupon['coupon_title']             = $data['txt_title'];
        $coupon['coupon_description']       = $data['txt_coupon_desc'];
        $coupon['coupon_code']              = $data['txt_code'];
        $coupon['coupon_end_date']          = $data['txt_expiry_date'];
        $coupon['coupon_amount']            = (float )$data['txt_coupon_amount'];
        $coupon['coupon_minimum_spend']     = (float) $data['txt_minimum_spend'];
        $coupon['coupon_maximum_spend']     = (float) $data['txt_maximum_spend'];
        $coupon['coupon_usage_percoupon']   = (int) $data['txt_limit_per_coup'];
        $coupon['coupon_usage_perx']        = (int) $data['txt_limit_X_coup'];
        $coupon['coupon_usage_peruser']     = (int) $data['txt_limit_user'];
        $coupon['coupon_created_date']      = gmdate("Y-m-d H:i:s");
        $coupon['individual_use']           = (int) $data['class_individul_use'];
        $coupon['coupon_vender_id']         = 0;//$data['vender_id'];

        // print_r($coupon);exit;

        $insertId = (int) $data["id"];

        //changes by Jitin to avoid db error
        if (empty($coupon['coupon_usage_percoupon']) || !is_numeric($coupon['coupon_usage_percoupon'])) {
            $coupon['coupon_usage_percoupon'] = 0;
        }
        if (empty($coupon['coupon_usage_perx']) || !is_numeric($coupon['coupon_usage_perx'])) {
            $coupon['coupon_usage_perx'] = 0;
        }
        if (empty($coupon['coupon_usage_peruser']) || !is_numeric($coupon['coupon_usage_peruser'])) {
            $coupon['coupon_usage_peruser'] = 0;
        }
        //end changes by Jitin to avoid db error        
       
        $coupon['coupon_status'] = 1;

        $this->db->trans_start();

        if ($insertId  > 0) {
            $this->db->where("coupon_id", $insertId)
                     ->update('coupon', $coupon);
        } else {
            if ( empty($coupon['coupon_code']) ) {
                $coupon['coupon_code'] = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10));
            }
            $this->db->insert('coupon', $coupon);
            $insertId = $this->db->insert_id();
        }

        // $this->db->where("coupon_category_coupon_id", $insertId)->delete('coupon_category');
        
        // $txt_category = explode(",", $data['txt_category']);
        // $txt_category = array_filter($txt_category);

        // $couponCategories = [];
        // if (count($txt_category) > 0) {
        //     $i = 0;
        //     foreach ($txt_category as $rows) {
        //         $couponCategories[$i]['coupon_category_coupon_id'] = $insertId;
        //         $couponCategories[$i]['coupon_category_category_id  '] = $rows;
        //         $i++;
        //     }
        // }

        // if (! empty($couponCategories) ) {
        //     $this->db->insert_batch('coupon_category', $couponCategories);
        // }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function getProviderJobDetails($assign_job_provider_id){

        $this->db->select('*');
        $this->db->where('assign_job_provider_id',$assign_job_provider_id);
        $this->db->join('job_request','job_request.job_request_id = assign_job_provider.job_request_id','left');
        return $this->db->get('assign_job_provider')->row();
    }


    public function assignJobToProvider($assign_job_provider_id,$job_request_id,$vendor_id){

        $this->db->trans_start();

        $this->db->where('assign_job_provider_id',$assign_job_provider_id);
        $this->db->where('job_request_id',$job_request_id);
        $this->db->set('assign_status',1);
        $this->db->set('provider_response_time',date("Y-m-d H:i:s"));
        $this->db->update('assign_job_provider');

        $this->db->where('job_request_id',$job_request_id);
        $this->db->set('job_request_status',1);
        $this->db->set('vendor_id',$vendor_id);
        $this->db->update('job_request');

        $this->db->where('job_request_id',$job_request_id);
        $this->db->where('provider_id !=',$vendor_id);
        $this->db->delete('assign_job_provider');

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function getUserDetailsById($user_id){

        $this->db->select('*');
        $this->db->where('user_table.user_id',$user_id);
        $this->db->join('provider_details pd','pd.user_id = user_table.user_id','left');
        $this->db->join('country','country.country_id = user_table.country_id','left');
        return $this->db->get('user_table')->row();
    }

    public function getServiceByJobRequestId($service_type_id,$language = 1){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('service_type')->row();
    }
    
    public function getJobRequestDetailsByRequestId($jobRequestId){

        $this->db->select('*');
        $this->db->where('job_request_id',$jobRequestId);
        $this->db->join('user_table','user_table.user_id = job_request.user_id','left');
        return $this->db->get('job_request')->row();
    }

    public function getRefuseReasonById($reason){
        $this->db->select('*');
        $this->db->where('refuse_reason_id',$reason);
        return $this->db->get('refuse_reason')->row();
    }
    
    public function getStaffsList($condition=[])
    {
        if(!empty($condition))
            $this->db->where($condition);

        return $this->db->order_by('user_id desc')->get('user_table')->result();
    }
    
    public function getProvidersListByServiceType($job_request_id){
        
        $this->db->select('service_type_id');
        $this->db->where('job_request_id',$job_request_id);
        $result = $this->db->get('job_request')->row();
        
        $this->db->select('*');
        $this->db->where('service_type_id',$result->service_type_id);
        $this->db->where(['service_type_id'=>$result->service_type_id,'user_status'=>1]);
        
        $this->db->join('user_table','user_table.user_id = provider_service_type.provider_id','left');
        return $this->db->get('provider_service_type')->result();
    }
    
    function getUsersListByVendor($provider_id=0)
    {
        $this->db->select('*');
        $this->db->where('vendor_id', $provider_id);
        $this->db->where('user_type', 3);
        $this->db->where('user_status', 1);
        return $this->db->get('user_table')->result();
    }
    
    function deleteStaff($userId)
    {
        $this->db->trans_start();

        $this->db->where('user_id', $userId);
        $this->db->delete('user_table');
        $this->db->where('user_id', $userId);
        $this->db->delete('user_details');

        $auditArray                              =    array();
        $auditArray['admin_id']         =    $this->session->userdata('admin_id');
        $auditArray['module_id']      =    1;
        $auditArray['entity_id']          =    $userId;
        $auditArray['action_id']         =    3;
        $auditArray['audit_time']       =    gmdate("Y-m-d H:i:s");
        $auditArray['audit_note']       =    "";
        $auditArray['menu_id']          =    3;
        $this->db->insert('admin_audit_trial', $auditArray);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    
    function getStaffDetails($condition=[])
    {
        $this->db->select('user_table.*,country.country_name, provider.user_first_name as provider_fname, provider.user_last_name as provider_lname');
        if(!empty($condition))
            $this->db->where($condition);

        $this->db->join('country','country.country_id=user_table.country_id and country.country_language_code=1','left');
        $this->db->join('user_table provider','provider.vendor_id=user_table.user_id','left');

        return $this->db->get('user_table');
    }

    public function get_vendor_data_by_id($user_id){
        
        $this->db->select('*');
        $this->db->where('user_table.user_id',$user_id);
        $this->db->join('provider_details','provider_details.user_id = user_table.user_id','left');
        return $this->db->get('user_table')->row();
    }
    
    public function getRatingList($id){
        $this->db->select('us.*,ut1.user_first_name,ut1.user_last_name,pd.company_name,u2.user_first_name as staf_first_name,u2.user_last_name as staff_last_name');
        $this->db->join('user_table ut1','ut1.user_id = us.user_id','left');
        $this->db->join('provider_details pd','pd.user_id = us.provider_id','left');
        $this->db->join('staff_jobs','staff_jobs.job_request_id = us.job_request_id','left');
        $this->db->join('user_table u2','u2.user_id = staff_jobs.staff_id','left');
        if($id > 0)
            $this->db->where('pd.user_id',$id);
        $this->db->order_by('id','desc');
        return $this->db->get('user_rating_for_seller us')->result();
    }

    public  function getOrderDetailsByRating($id){

        $this->db->select('jr.*,urs.*,staff_jobs.*,service_type.*');
        $this->db->where('id',$id);
        $this->db->join('job_request jr','jr.job_request_id = urs.job_request_id','left');
        $this->db->join('staff_jobs','staff_jobs.job_request_id = urs.job_request_id','left');
        $this->db->join('service_type','service_type.service_type_id = jr.service_type_id','left');
        $this->db->where('service_type_language_code',1);
        return $this->db->get('user_rating_for_seller urs')->row();
    }
    
    public function getStaffDetailsById($job_request_id){
        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->join('user_table','user_table.user_id = staff_jobs.staff_id','left');
        $this->db->join('country c','c.country_id=user_table.country_id and c.country_language_code=1','left');
        $this->db->join('city ','city.city_id=user_table.city_id and city.city_language_code=1','left');
        
        return $this->db->get('staff_jobs')->row();
    }
    
    public function updateHowItWOrk($h_title,$h_decription,$imageArray){
        $basicImageArray = array();
        foreach ($imageArray as $key => $value) {
            $exp_key = explode('_', $key);
            $basicImageArray[] = $value;
            print_r($value);exit;
        }
        print_r($basicImageArray);exit;
        if (!empty($basicImageArray)) {

            $filesCount = count($basicImageArray);

            for ($i = 0; $i < $filesCount; $i++) {
                // echo $basicImageArray[]
                $_FILES['file']['name'] = $basicImageArray[$i]['name'];
                $_FILES['file']['type'] = $basicImageArray[$i]['type'];
                $_FILES['file']['tmp_name'] = $basicImageArray[$i]['tmp_name'];
                $_FILES['file']['error'] = $basicImageArray[$i]['error'];
                $_FILES['file']['size'] = $basicImageArray[$i]['size'];

                print_r($_FILES['file']);exit;
                $digits = 6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                $filename2 = $basicImageArray[$i]['name'];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config['file_name'] = $randomNo . "." . $file_ext2;

                // File upload configuration
                $uploadPath = $this->config->item('upload_path') . 'service_type/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if ($this->upload->do_upload('file')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[] = $fileData['file_name'];
                }else{
                    // $data['status'] = 0;
                    $data['errors'] = array(
                        'txtFile2' => $this->upload->display_errors(),
                    );
                    echo json_encode($data);
                    exit();
                }

            }

            $mainImagesName = implode(",", $uploadData);
            $product['product_image'] = $mainImagesName;

        }
        print_r($product);


    }

    public function saveHowToWork($saveHowToWork){
        // print_r($saveHowToWork);exit;
        foreach ($saveHowToWork as $key => $value) {
        // print_r($value);exit;
            if($value['h_id'] > 0 ){
                if(!$value['image']){
                    unset($value['image']);
                }
                if($key == 1){
                    // print_r($value);exit;
                }
                $this->db->where('h_id',$value['h_id']);
                $this->db->update('how_its_work',$value);
            }else{
                unset($value['h_id']);
                $this->db->insert('how_its_work',$value);
            }
       }
    }
    public function getHowItsWork($service_type_id){
        // echo $service_type_id;exit;
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get('how_its_work')->result();
    }


    public function deleteHowItsWork($h_id){

        $this->db->where('h_id',$h_id);
        $this->db->delete('how_its_work');

        return $this->db->affected_rows();
    }
    
    public function addBanerImage($appBanerImage,$webBanerImage,$service_type_id){

        for ($i=0; $i < count($appBanerImage) ; $i++) { 
            $input['image'] = $appBanerImage[$i];
            $input['service_type_id '] = $service_type_id;
            $input['type']  = 1;
            $input['created_at']    =   date('Y-m-d H:i:s');

            $this->db->insert('service_type_baner_image',$input);
        }

        for ($i=0; $i < count($webBanerImage) ; $i++) { 
            $input['image'] = $webBanerImage[$i];
            $input['service_type_id '] = $service_type_id;
            $input['type']  = 2;
            $input['created_at']    =   date('Y-m-d H:i:s');

            $this->db->insert('service_type_baner_image',$input);
        }
    }
    
    public function getBanerImage($service_type_id){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get('service_type_baner_image')->result();
    }

    public function insertWalletData($data)
    {
        $this->db->trans_start(); 
        $insertdata['user_id']    =   $data['txt_user_id'];
        $insertdata['amount']     =   $data['txt_amount'];
        $insertdata['status']     =   1;
        $insertdata['transaction_status']     =   1;
        $insertdata['created_by']     =   $data['created_by'];
        $insertdata['created_at']     =   $data['created_at'];
        $insertdata['transaction_id'] =   $data['transaction_id'];

        $this->db->insert('user_wallet',$insertdata);
        $insertId = $this->db->insert_id();
        $userQuery =  "update user_table set wallet_balance=wallet_balance+".$insertdata['amount']." where user_id=".$insertdata['user_id'];
        $userData = $this->db->query($userQuery);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return $insertId;
        }
    }
    public function getWalletLog($user_id){

        $this->db->select('uw.*,ut.admin_user_name');
        $this->db->from('user_wallet uw');
        $this->db->join('admin_user ut','ut.admin_user_id=uw.created_by','left');
        $this->db->where('uw.user_id',$user_id);
        $this->db->order_by('uw.wallet_id','desc');
        return $this->db->get()->result();
    }


    public function updateSeviceType($id,$inputArray)
    {
         $this->db->where('service_type_id', $id);
        
        $this->db->update('service_type', $inputArray);
    }


    public function deleteBannerImage($id,$service_type_id)
    {
        $this->db->where('service_type_id', $service_type_id);
        $this->db->where('id', $id);
        $this->db->delete('service_type_baner_image');
    }

    /**
     * Promotion slider
     * */

    /**
     * Promotion slider
     * */

    public function getPromotionSliderList($language = 1)
    {

        $this->db->select('promotion_slider.*,service_type.service_type_name');
        $this->db->join('service_type', 'service_type.service_type_id = promotion_slider.slider_service_type and service_type.service_type_language_code = '.$language, 'left');
        // $this->db->where_in('service_type_language_code',$language);
        $this->db->order_by('slider_id','desc');
        return $this->db->get('promotion_slider')->result();
    }
    public function savePromotionSlider($data, $slider_id=0)
    {

        if ($slider_id > 0) {
            $this->db->where('slider_id', $slider_id);
            $this->db->update('promotion_slider', $data);
        } else {
            $data['created_on']  = gmdate('Y-m-d H:i:s');
            $this->db->insert('promotion_slider', $data);
        }
        return $this->db->affected_rows();
    }

    public function getPromotionSliderById($slider_id)
    {
        $this->db->select('*');
        $this->db->where('slider_id', $slider_id);
        return $this->db->get('promotion_slider')->row();
    }

    function changPromotionSliderStatus(){
        
        $this->db->set('slider_status',$_POST['status']);
        $this->db->where('slider_id',$_POST['id']);
        $this->db->update('promotion_slider');
        
        return $this->db->affected_rows();
    }

    public function getJobDaysByRequestId($requestId)
    {
        $this->db->order_by('job_date','asc');
        return $this->db->get_where('job_request_days',['job_request_id'=>$requestId])->result();
    }

}

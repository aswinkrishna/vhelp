<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->model('M_job_admin');

        //$this->lang->load("message","arabic");
        // error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
        $this->load->library("FCM_Notification");
        error_reporting(E_ERROR | E_PARSE);
        $this->wstatus = ['1'=>'Applied','2'=>'Pending'];
    }
    public function index()
    {
        $this->load->view("admin/login");
    }
    function login()
    {

        //print_r($_POST);

        $data   =     array('admin_user_email' => $_POST['username'], 'admin_user_password' => MD5($_POST['password']), 'admin_user_status' => 1);

        $result =    $this->M_admin->login($data);
        //print_r($result);

        if ($result == "") {


            echo   0;
        } else {

            if ($result->admin_user_email != "") {

                echo   1;

                //$this->session->sess_destroy();

                $this->session->unset_userdata('admin_email');
                $this->session->unset_userdata('admin_id');
                $this->session->unset_userdata('admin_name');
                $this->session->unset_userdata('user_type');
                $this->session->unset_userdata('admin_display_name');
                $this->session->unset_userdata('admin_designation');
                $this->session->unset_userdata('user_id');


                $this->session->set_userdata("admin_email", $result->admin_user_email);
                $this->session->set_userdata("admin_id", $result->admin_user_id);
                $this->session->set_userdata("admin_name", $result->admin_user_name);
                $this->session->set_userdata("user_type", "A");
                $this->session->set_userdata("admin_display_name", $result->admin_first_name . " " . $result->admin_last_name);
                $this->session->set_userdata("admin_designation", $result->designation_id);
            } else {
                echo   0;
            }
        }
    }
    function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata("admin_email");
        $this->session->unset_userdata("admin_id");
        redirect("admin");
    }
    function dashBoard()
    {

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/dashboard");
        $this->load->view("admin/footer");
    }
    function userList()
    {
        $con['user_type']           =    1;
        $data['user_list']            =   $this->M_admin->getUsersCondition($con);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/user_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditUser()
    {
        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($id > 0) {
            $data['id']                            =       $id;
            $con['user_id']                   =       $id;
            $data['user_basic']            =      $this->M_admin->getUsersCondition($con);
            $data['user_details']         =      $this->M_admin->getUsersDetailsCondition($con);
        }
        $data['country_list']           = $this->M_admin->getCountries(1, 0, 1);
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_user", $data);
        $this->load->view("admin/footer");
    }
    function saveUser()
    {

        $data = array();

        //print_r($_FILES);
        //exit;
        $this->form_validation->set_rules('txt_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]');
        if ((int)$this->input->post("txt_user_id") == 0)
        {
            $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]|is_unique[user_table.user_email]',['is_unique'=>'Email Address already exists.']);
        }
        $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
        $this->form_validation->set_rules('select_country', 'Country', 'trim|required');
        $this->form_validation->set_rules('select_city', 'City', 'trim|required');
        $this->form_validation->set_rules('txt_phone', 'Phone', 'trim|required|numeric|min_length[5]|max_length[15]|xss_clean');
        // $this->form_validation->set_rules('txt_zip', 'Zip code', 'trim|required|numeric|min_length[4]|max_length[6]|xss_clean');
        //  $this->form_validation->set_rules('txt_building', 'Building Name', 'trim|required|max_length[100]|callback_check_inavlid_char');
        //  $this->form_validation->set_rules('txt_apprtment', 'Appartment Name', 'trim|required|max_length[100]|callback_check_inavlid_char');
        // $this->form_validation->set_rules('txt_area', 'Area', 'trim|required|max_length[100]|callback_check_inavlid_char');
        if (empty($_FILES['txt_profile']['name']) && $this->input->post("txt_user_id") <= 0) {
            $this->form_validation->set_rules('txt_profile', 'Upload Profile', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_first_name' => form_error('txt_first_name'),
                'txt_last_name' => form_error('txt_last_name'),
                'txt_email' => form_error('txt_email'),
                'select_city' => form_error('select_city'),
                'select_country' => form_error('select_country'),
                'txt_password' => form_error('txt_password'),
                'txt_phone' => form_error('txt_phone'),
                'select_city' => form_error('select_city'),
                'txt_zip' => form_error('txt_zip'),
                'txt_building' => form_error('txt_building'),
                'txt_apprtment' => form_error('txt_apprtment'),
                'txt_area' => form_error('txt_area'),
                'txt_profile' => form_error('txt_profile'),
            );
            echo json_encode($data);
            exit();
        } else {



            if ($_FILES["txt_profile"]["name"] != "") {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["txt_profile"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'user/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;

                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                // $this->upload->initialize($config2);

                if (!$this->upload->do_upload('txt_profile')) {

                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txt_profile' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input['user_image']                 =   $config2['file_name'];
                }
            }



            $_POST = $this->security->xss_clean($_POST);

            $input['user_first_name']                    =                 trim($this->input->post("txt_first_name"));
            $input['user_last_name']                     =                 trim($this->input->post("txt_last_name"));
            $input['user_email']                              =                 trim($this->input->post("txt_email"));

            if((int)$this->input->post("save_password")==1)
            {
                $input['user_password']                      =                 MD5($this->input->post("txt_password"));
            }

            $input['country_id']                              =                 trim($this->input->post("select_country"));
            $input['city_id']                                      =                 trim($this->input->post("select_city"));
            $input['user_phone']                            =                 trim($this->input->post("txt_phone"));
            $input['user_dial_code']                      =                 trim($this->input->post("txt_dial"));
            $input['user_type']                                =                1;
            $input['user_zip']                                   =                 trim($this->input->post("txt_zip"));
            $input['user_status']                             =                 0;
            $input['user_created_methode']       =                 "web";
            $input2["building"]                               =               trim($this->input->post("txt_building"));
            $input2["appartment"]                        =               trim($this->input->post("txt_apprtment"));
            $input2["area"]                                      =               trim($this->input->post("txt_area"));
            if ($this->input->post("txt_user_id") > 0) {
                unset($input['user_email']);
                unset($input['user_status']);
                $input['user_id']                                 =                 trim($this->input->post("txt_user_id"));
                $input['user_updated_by']              =                 $input['user_id'];
                $input['user_updated_time']          =                 date("Y-m-d H:i:s");
            } else {
                $input['user_created_by']              =                 0;
                $input['user_created_time']          =                 date("Y-m-d H:i:s");
            }





            if (count($_POST) > 0) {

                $result         =   $this->M_admin->saveUser($input, $input2);
            } else {

                $result = 0;
            }
            $data['status'] = $result;
            echo json_encode($data);
        }
    }
    function loadCityDropDown()
    {
        $language   =  ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $condition  =   array('city_language_code' => $language, 'city_status' => 1, 'city_country_id' => $_POST['countryId']);
        $cityList   =   $this->M_admin->getCitiesCondition($condition);

        if (isset($cityList) && count($cityList) > 0) {
?>

            <option value="">Select city</option>

            <?php
            foreach ($cityList as $rows) {

            ?>

                <option value="<?php echo $rows->city_id; ?>"><?php echo $rows->city_name; ?></option>

            <?php
            }
        }
    }
    function deleteUser()
    {
        $id                  =   $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $result          =   $this->M_admin->deleteUser($id);
    }
    function approveUser()
    {

        echo $result         =   $this->M_admin->approveUser($_POST);
    }
    
    function changeSliderStatus(){
        echo $result = $this->M_admin->changeSliderStatus($_POST);
    }
    
    function countryList()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $con                                         =    array();
        $data['country_list']            =   $this->M_admin->getCountries($language, 0, 0);
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/country_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditCountry()
    {

        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));

        if ($id > 0) {
            $data['id']                            =       $id;
            $con['country_id']             =       $id;
            $data['records1']                =       $this->M_admin->getCountries(1, $id);
            $data['records2']                =       $this->M_admin->getCountries(2, $id);
        }

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_country", $data);
        $this->load->view("admin/footer");
    }
    function saveCountry()
    {

        $data        =           array();



        $this->form_validation->set_rules('txtEnglish', 'Country Name English', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtArabic', 'Country Name Arabic', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtDialCode', 'Dial Code', 'trim|required|numeric|max_length[5]');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic' => form_error('txtArabic'),
                'txtDialCode' => form_error('txtDialCode'),
            );
            echo json_encode($data);
            exit();
        }

        $inputArray['country_name']                            =    $_POST['txtEnglish'];
        $inputArray['country_language_code']          =    1;
        $inputArray['country_dial_code']                    =    $_POST['txtDialCode'];
        $inputArray['country_status']                          =    $_POST['txtStatus'];
        $inputArray['country_created_date']            =    date("Y-m-d H:i:s");
        $inputArray2                                 =    $inputArray;
        $inputArray2['country_name']                 =    ($_POST['txtArabic'] != "" ? $_POST['txtArabic'] : $_POST['txtEnglish']);
        $inputArray2['country_language_code']        =    2;






        if (isset($_POST['txt_country_id']) && $_POST['txt_country_id'] > 0) {
            $inputArray['country_id']            =     $_POST['txt_country_id'];
            $inputArray2['country_id']           =     $_POST['txt_country_id'];
            unset($inputArray['country_created_date']);
            unset($inputArray2['country_created_date']);
        }

        //  print_r($inputArray);
        /**
         * changes by jitin on 26 sep 18 for xss filtering
         */
        $inputArray = $this->security->xss_clean($inputArray);
        $inputArray2 = $this->security->xss_clean($inputArray2);

        $result =    $this->M_admin->saveMasterTable($inputArray, $inputArray2, 'country_id', 'country_language_code', 'country');
        $data['status'] = $result;
        echo json_encode($data);
    }
    function deleteCountry()
    {

        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));

        echo      $this->M_admin->deleteCountry($id);
    }
    function cityList()
    {
        $con                                       =    array();
        $data['city_list']            =   $this->M_admin->getCitiesWithCountries();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/city_list", $data);
        $this->load->view("admin/footer");
    }
    function deleteCity()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));

        echo      $this->M_admin->deleteCity($id);
    }
    function addEditCity()
    {

        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));

        if ($id > 0) {
            $data['id']                            =       $id;
            $con['country_id']             =       $id;
            $data['records1']                =       $this->M_admin->getCities(1, $id);
            $data['records2']                =       $this->M_admin->getCities(2, $id);
        }

        $data['country_list']            =   $this->M_admin->getCountries(1, 0, 1);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_city", $data);
        $this->load->view("admin/footer");
    }
    function saveCity()
    {

        $data = array();

        /**
         * changes by jitin on 26 sep 18 for server side validation
         */

        $this->form_validation->set_rules('txtEnglish', 'City Name English', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtArabic', 'City Name Arabic', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtCountry', 'Country', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic' => form_error('txtArabic'),
                'txtCountry' => form_error('txtCountry'),
            );
            echo json_encode($data);
            exit();
        }


        $inputArray['city_name']                           =    $_POST['txtEnglish'];
        $inputArray['city_language_code']         =    1;
        $inputArray['city_country_id']                 =    $_POST['txtCountry'];
        $inputArray['city_status']                          =    $_POST['txtStatus'];
        $inputArray['city_created_date']            =    date("Y-m-d H:i:s");
        $inputArray2                                                 =    $inputArray;
        $inputArray2['city_name']                         =    ($_POST['txtArabic'] != "" ? $_POST['txtArabic'] : $_POST['txtEnglish']);
        $inputArray2['city_language_code']        =    2;






        if (isset($_POST['txt_city_id']) && $_POST['txt_city_id'] > 0) {
            $inputArray['city_id']              =     $_POST['txt_city_id'];
            $inputArray2['city_id']           =     $_POST['txt_city_id'];
            unset($inputArray['city_created_date']);
            unset($inputArray2['city_created_date']);
        }

        /**
         * changes by jitin on 26 sep 18 for xss filtering
         */
        $inputArray = $this->security->xss_clean($inputArray);
        $inputArray2 = $this->security->xss_clean($inputArray2);

        $result  =    $this->M_admin->saveMasterTable($inputArray, $inputArray2, 'city_id', 'city_language_code', 'city');
        $data['status'] = $result;
        echo json_encode($data);
    }
    function serviceTypeList()
    {

        $data["service_type_list"]        =   $this->M_admin->getServiceTypeWithParent();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/service_type_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditServiceType()
    {
        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));

        if ($id > 0) {
            $data['id']                            =       $id;
            $con['country_id']             =       $id;
            $data['records1']                =       $this->M_admin->getServiceTypes2(1, $id);
            $data['records2']                =       $this->M_admin->getServiceTypes2(2, $id);
        }


        $con                                                                        =    array();
        $con['service_type_language_code']              =    1;
        $con['service_type_status']    =    1;
        if($id > 0) {
            $con['service_type_id <> ']    =    $id;
            $con['service_type_parent_id <> ']    =    $id;
        }
        $con2                                                                      =    array();
        $con2['service_methode_language_code']    =    1;
        $con2['service_methode_status']    =    1;
        $data["service_type_list"]               =   $this->M_admin->getServiceTypes($con);
        $data["service_method_list"]        =   $this->M_admin->getServiceMethods($con2);
        $data['baner_image']                =   $this->M_admin->getBanerImage($id);
        
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_service_type", $data);
        $this->load->view("admin/footer");
    }
    
    
    function saveServiceType()
    {
        //print_r($_POST);
        // exit;
        $data = array();

        $this->form_validation->set_rules('txtEnglish', 'Service type  name english', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txtArabic', 'Service type name arabic', 'trim|required|max_length[100]|xss_clean');
        //$this->form_validation->set_rules('txtmethod', 'Service method', 'trim|required|numeric|callback_check_default');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic' => form_error('txtArabic'),
                'txtmethod' => form_error('txtmethod'),
            );
            echo json_encode($data);
            exit();
        }


        if ($_FILES["txtFile"]["name"] != "") {

            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

            $filename2 = $_FILES["txtFile"]["name"];
            $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
            // echo $file_ext2;

            $config2['upload_path']          =  $this->config->item('upload_path') . 'service_type/';
            $config2['allowed_types']        =  '*';//png|gif|jpg|jpeg
            //  $config2['max_size']             =  1000;
            //  $config2['max_width']            =  1024;
            // $config2['max_height']           =  768;
            $config2['file_name']            =  $randomNo . "." . $file_ext2;

            //$this->load->library('upload', $config2);
            $this->load->library('upload', $config2);
            // $this->upload->initialize($config2);

            if (!$this->upload->do_upload('txtFile')) {

                //die("file upload failed");
                $data['status'] = 0;
                $data['errors'] = array(
                    'txtFile' => $this->upload->display_errors(),
                );
                echo json_encode($data);
                exit();
            } else {
                $inputArray['service_type_icon']                 =   $config2['file_name'];
            }
        }
        //app icon image
        if ($_FILES["txtFile2"]["name"] != "") {

            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
            $filename2 = $_FILES["txtFile2"]["name"];
            $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
            $config2['upload_path']          =  $this->config->item('upload_path') . 'service_type/';
            $config2['allowed_types']        =  '*';//gif|jpg|png|jpeg
            // $config2['max_size']               =  1000;
            // $config2['max_width']            =  1024;
            //$config2['max_height']          =  768;
            $config2['file_name']              =  $randomNo . "." . $file_ext2;

            //$this->load->library('upload', $config2);
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            if (!$this->upload->do_upload('txtFile2')) {

                //die("file upload failed");
                $data['status'] = 0;
                $data['errors'] = array(
                    'txtFile2' => "File upload failed",
                );
                echo json_encode($data);
                exit();
            } else {
                $inputArray['service_type_banner_image']                 =   $config2['file_name'];
            }
        }
        //app icon image
        if ($_FILES["homepage_banner"]["name"] != "") {

            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
            $filename2 = $_FILES["homepage_banner"]["name"];
            $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
            $config2['upload_path']          =  $this->config->item('upload_path') . 'banner/';
            $config2['allowed_types']        =  '*';//gif|jpg|png|jpeg
            // $config2['max_size']               =  1000;
            // $config2['max_width']            =  1024;
            //$config2['max_height']          =  768;
            $config2['file_name']              =  $randomNo . "." . $file_ext2;

            //$this->load->library('upload', $config2);
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            if (!$this->upload->do_upload('homepage_banner')) {

                //die("file upload failed");
                $data['status'] = 0;
                $data['errors'] = array(
                    'txtFile2' => "File upload failed",
                );
                echo json_encode($data);
                exit();
            } else {
                $inputArray['homepage_banner']                 =   $config2['file_name'];
            }
        }


        if ($_FILES["txtFile3"]["name"] != "") {

            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
            $filename2 = $_FILES["txtFile3"]["name"];
            $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
            $config2['upload_path']          =  $this->config->item('upload_path') . 'service_type/';
            $config2['allowed_types']        =  '*';//gif|jpg|png|jpeg
            // $config2['max_size']               =  1000;
            // $config2['max_width']            =  1024;
            //$config2['max_height']          =  768;
            $config2['file_name']              =  $randomNo . "." . $file_ext2;

            //$this->load->library('upload', $config2);
            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            if (!$this->upload->do_upload('txtFile3')) {

                //die("file upload failed");
                $data['status'] = 0;
                $data['errors'] = array(
                    'txtFile2' => "File upload failed",
                );
                echo json_encode($data);
                exit();
            } else {
                $inputArray['service_type_thumbnail']                 =   $config2['file_name'];
            }
        }

        // trim($this->input->post("txt_user_id"));
        $inputArray['service_type_name']                            =    trim($this->input->post("txtEnglish"));
        $inputArray['service_type_language_code']         =    1;
        $inputArray['service_type_parent_id']                   =    trim($this->input->post("txtParent"));
        $inputArray['service_type_status']                          =    trim($this->input->post("txtStatus"));
        $inputArray['service_methode']                               =     trim($this->input->post("txtmethod")) > 0 ? trim($this->input->post("txtmethod")) : 2;
        $inputArray['service_type_created_date']             =    gmdate("Y-m-d H:i:s");

        $inputArray['main_label']                                          =    trim($this->input->post("txtMainLabel"));
        $inputArray['sub_label']                                              =     trim($this->input->post("txtSubLabel"));
        $inputArray['service_type_desc']                             =     trim($this->input->post("txtDesc"));
        $inputArray['include_mega_menu']                            =     $this->input->post("txtMega") > 0 ? trim($this->input->post("txtMega")) : 0;
        $inputArray['is_home_category']                            =     trim($this->input->post("isHomeCategory"));

        $inputArray['is_weekly_available']                      = (int) $this->input->post('txtWeeklyAvailable');
        $inputArray['is_monthly_available']                     = (int) $this->input->post('txtMonthlyAvailable');

        $inputArray2                                                                  =    $inputArray;
        $inputArray2['service_type_name']                          =    ($this->input->post("txtArabic") != "" ? $this->input->post("txtArabic") : $this->input->post("txtEnglish"));
        $inputArray2['service_type_language_code']        =    2;
        $inputArray2['main_label']                                          =     trim($this->input->post("txtMainLabelArb"));
        $inputArray2['sub_label']                                            =     trim($this->input->post("txtSubLabelArb"));
        $inputArray2['service_type_desc']                            =     trim($this->input->post("txtDescArb"));
        $inputArray2['include_mega_menu']                            =      $this->input->post("txtMega") > 0 ? trim($this->input->post("txtMega")) : 0;




        if ($this->input->post("txt_service_id") > 0) {
            $inputArray['service_type_id']                                          =     $this->input->post("txt_service_id");
            $inputArray2['service_type_id']                                        =     $this->input->post("txt_service_id");
            $inputArray['service_type_updated_date']              =     gmdate("Y-m-d H:i:s");
            $inputArray2['service_type_updated_date']            =    gmdate("Y-m-d H:i:s");
            unset($inputArray['service_type_created_date']);
            unset($inputArray2['service_type_created_date']);
        }


        $inputArray = $this->security->xss_clean($inputArray);
        $inputArray2 = $this->security->xss_clean($inputArray2);


        $h_title        = $this->input->post('h_title');
        $h_decription   = $this->input->post('h_decription');
        $h_ids          = $this->input->post('h_id');
        $h_data         = [];
        $this->load->library('upload', $config);

        $imageData      = [];
        $imageData    = multipleFileUpload($_FILES['h_image'],'service_type');

        $result =   $this->M_admin->saveMasterTable($inputArray, $inputArray2, 'service_type_id', 'service_type_language_code', 'service_type');
        for ($i=0; $i < count($h_title) ; $i++) { 
            $h_data[$i]['h_id']         = $h_ids[$i]??0;
            $h_data[$i]['title']        = $h_title[$i]; 
            $h_data[$i]['decription']   = $h_decription[$i]; 
            $h_data[$i]['image']        = $imageData[$i];    
            $h_data[$i]['service_type_id'] = $result;
        }


        if($result > 0 && count($h_data) > 0 )
            $this->M_admin->saveHowToWork($h_data);

        $appBanerImage      = [];
        $appBanerImage = multipleFileUpload($_FILES['appImage'],'service_type');

        $webBanerImage      = [];
        $webBanerImage = multipleFileUpload($_FILES['webImage'],'service_type');

        if($appBanerImage || $webBanerImage && $result > 0 )
            $this->M_admin->addBanerImage($appBanerImage,$webBanerImage,$result);
        // print_r($appBanerImage);exit;

        if($result > 0 )
            $result = 1;
        $data['status'] = $result;
        echo json_encode($data);
    }
    
    
    
    function deleteServiceType()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $this->M_admin->deleteServiceType($id);
    }
    function addEditQuestions()
    {
        $data                                                =      array();
        $serviceTypeId                              =      $this->common_functions->decryptId($this->uri->segment(3));


        $questionId                                     =      $this->common_functions->decryptId($this->uri->segment(4));

        if ($questionId > 0) {
            $con3['question_id']                  =       $questionId;
            $data['records1']                     =     $this->M_admin->getFormQuestions($con3);
            $data['records2']                     =     $this->M_admin->getAnswers($con3);
            $data['has_child']                    =     $this->M_admin->checkHasChild($questionId);


            $data['question_id']              =       $questionId;

            $con2['curent_question']            = $questionId;
        }


        $con1['form_control_status']           =  1;
        // $con2['question_language_code']     =  1; 
        $con2['question_status']               =  1;
        $con2['questions_service_type_id']     =  $serviceTypeId;
        $data['form_control']                  =  $this->M_admin->getFormControls($con1);
        $data['form_questions']                =  $this->M_admin->getFormQuestions2($con2);

        if ($serviceTypeId > 0) {
            $data['service_type_id']           =  $serviceTypeId;
        }
        // print_r($data['form_control'] );exit;

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_questions", $data);
        $this->load->view("admin/footer");
    }

    function saveDynamicForm()
    {
        $serviceTypeId                              =      $_POST['serviceTypeId'];

        if ($serviceTypeId <= 0) {
            redirect(base_url());
        } else {
            $this->form_validation->set_rules('txtEnglish', 'Question in english', 'trim|required|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('txtArabic', 'Question in tamil', 'trim|required|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('txtInputType', 'Input type', 'trim|required|numeric|callback_check_default');

            if ($this->form_validation->run() == FALSE) {
                $data['status'] = 0;
                $data['errors'] = array(
                    'txtEnglish' => form_error('txtEnglish'),
                    'txtArabic' => form_error('txtArabic'),
                    'txtInputType' => form_error('txtInputType'),
                );
                echo json_encode($data);
                exit();
            } else {
                $inputArray                =          $this->security->xss_clean($_POST);
                $result                         =          $this->M_admin->saveDynamicForm($inputArray);
                $data['status']              =           $result;
                echo json_encode($data);
                exit();
            }
        }
    }
    function loadAnswers()
    {
        $con['question_id']                        =         $this->input->post("questionId");
        $answers                                          =         $this->M_admin->getAnswers($con);
        if (count($answers) > 0) {
            ?>
            <option value="0">No parent</option>

            <?php
            foreach ($answers as $rows) {
            ?>
                <option value="<?php echo  $rows->answer_options_id ?>"><?php echo  $rows->answer_option ?></option>

            <?php

            }
        } else {
            ?>
            <option value="0">No parent</option>

        <?php
        }
    }
    function QuestionList()
    {
        $data                                             =      array();
        $con2                                           = array();

        if ($this->uri->segment(3) != "") {

            $serviceTypeId                                                   =      $this->common_functions->decryptId($this->uri->segment(3));

            $con2['questions_service_type_id']           =          $serviceTypeId;
        }

        $con2['language']           =         ($this->session->userdata('language') > 0 ? $this->session->userdata('language') : 1);

        $data['question_list']                               =          $this->M_admin->getQuestionsWithService($con2);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/question_list", $data);
        $this->load->view("admin/footer");
    }
    function deleteQuestion()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $this->M_admin->deleteQuestion($id);
    }
    function listAdminUsers()
    {
        if ($this->session->userdata('admin_designation') != 1) {
            redirect(base_url() . "admin");
        }

        $data['results'] =    $this->M_admin->getAdminUsers();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/list_staff", $data);
        $this->load->view("admin/footer");
    }

    function addEditAdmin()
    {


        if ($this->session->userdata('admin_designation') != 1) {
            redirect(base_url() . "admin");
        }
        $adminId = $this->uri->segment(3) != "" ? $this->uri->segment(3) : 0;

        $adminId  = $this->common_functions->decryptId($adminId);


        if ($adminId > 0) {
            $oldData = $this->M_admin->getAdminUserDetails($adminId);
            $data['id']   =  $adminId;
        } else {
            $oldData = array();
        }

        $data['results']        = $oldData;

        $data['designation'] =    $this->M_admin->loadDesignation();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_admin_staff", $data);
        $this->load->view("admin/footer");
    }
    function saveAdminUsers()
    {



        $this->form_validation->set_rules('txt_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_user_name', 'user name', 'trim|required|max_length[50]|min_length[8]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('txt_email', 'Email id', 'trim|required|max_length[100]');
        if ($_POST['id'] <= 0) {
            $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
        }
        $this->form_validation->set_rules('txt_designation', 'Designation', 'trim|required');
        $this->form_validation->set_rules('txtStatus', 'Status', 'trim|required');





        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_first_name' => form_error('txt_first_name'),
                'txt_last_name' => form_error('txt_last_name'),
                'txt_user_name' => form_error('txt_user_name'),
                'txt_email' => form_error('txt_email'),
                'txt_password' => form_error('txt_password'),
                'txt_designation' => form_error('txt_designation'),
                'txtStatus' => form_error('txtStatus'),
            );
            echo json_encode($data);
            exit();
        }
        $_POST = $this->security->xss_clean($_POST);

        $result   =    $this->M_admin->saveAdminUsers($_POST);
        $data['status'] = $result;
        echo json_encode($data);
    }
    function approveAdmin()
    {
        echo $result   =    $this->M_admin->approveAdmin($_POST);
    }
    function setPermission()
    {
        if ($this->session->userdata('admin_designation') != 1) {
            redirect(base_url() . "admin");
        }


        $data['menu'] =    $this->M_admin->getMenus();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_permission", $data);
        $this->load->view("admin/footer");
    }
    function saveAdminPermission()
    {

        echo $result   =    $this->M_admin->saveAdminPermission($_POST);
        //print_r($_POST);
    }
    function deleteAdmin()
    {
        if ($_POST['admin_user_id'] != 1) {
            echo $result  =   $this->M_admin->deleteAdmin($_POST);
        } else {
            echo 3;
        }
    }
    function changePasswordAdminUser()
    {
        $this->form_validation->set_rules('txt_new_pwd', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
        $this->form_validation->set_rules('cnf_pwd', 'Confirm password', 'trim|required|matches[txt_new_pwd]|min_length[8]|max_length[20]');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_new_pwd' => form_error('txt_new_pwd'),
                'cnf_pwd' => form_error('cnf_pwd')
            );
            echo json_encode($data);
            exit();
        }
        $_POST = $this->security->xss_clean($_POST);
        $result   =    $this->M_admin->changePasswordAdminUser($_POST);
        $data['status'] = $result;
        echo json_encode($data);
    }
    function listAuditTrail()
    {
        if ($this->session->userdata('admin_designation') != 1) {
            redirect(base_url() . "admin");
        }


        $data['trail'] =    $this->M_admin->getAudittrails();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/audit_trail_list", $data);
        $this->load->view("admin/footer");
    }
    function listAuditTrailsAjax()
    {

        $this->load->library('pagination');




        $limit_per_page             =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                 =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->listauditTrailReportCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['trail']  =   $this->M_admin->listauditTrailReport($_POST, $limit_per_page, $start_index);

            $config['base_url']         =     base_url() . 'admin/C_admin/listAuditTrailsAjax';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }

        //   print_r($data);

        $this->load->view("admin/audit_trail_list_ajax", $data);
    }
    function providerList()
    {   
        $con['user_type']             =    2;
        $data['user_list']            =   $this->M_admin->getUsersCondition($con);
        // echo"<pre>";    print_r($data);exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/provider_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditProvider()
    {

        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($id > 0) {
            $data['id']                            =       $id;
            $con['user_id']                   =       $id;
            $con3['provider_id']                   =       $id;
            $data['user_basic']            =      $this->M_admin->getUsersCondition($con);
            $data['user_details']         =      $this->M_admin->getProvidersDetailsCondition($con);
            $data['pro_services']         =      $this->M_admin->getProvidersServiceTypesCondition($con3);
            $data['selected_area']        =   $this->M_admin->getSelectedAreaByCondition($con3);
            // echo "<pre>";    print_r($data['selected_area']);exit;
        }
        $con2['service_type_language_code'] =  1;
        //$con['service_type_parent_id=']           =  0;
        $con2['service_type_status']           =  1;

        $data['service_type']         =  $this->M_admin->getServiceTypes($con2);
        $data['country_list']           = $this->M_admin->getCountries(1, 0, 1);
        $data['area_list']            = $this->M_admin->getUserAreaList();
        // echo"<pre>"; print_r($data['area_list']);exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_provider", $data);
        $this->load->view("admin/footer");
    }
    function saveProvider()
    {

        // error_reporting(E_ALL);
        $data = array();

        //  print_r($_POST);
        //  exit;
        $this->form_validation->set_rules('txt_first_name', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_last_name', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]');
        if ((int)$this->input->post("txt_user_id") == 0)
        {
            $this->form_validation->set_rules('txt_email', 'Email Address', 'required|valid_email|max_length[100]|is_unique[user_table.user_email]',['is_unique'=>'Email Address already exists.']);
        }
        $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
        $this->form_validation->set_rules('select_country', 'Country', 'trim|required');
        $this->form_validation->set_rules('select_city', 'City', 'trim|required');
        $this->form_validation->set_rules('txt_phone', 'Phone', 'trim|required|numeric|min_length[5]|max_length[15]|xss_clean');
        $this->form_validation->set_rules('select_document_type', 'Document type', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('txt_doc_no', 'Document no', 'trim|required|max_length[100]|callback_check_inavlid_char');
        $this->form_validation->set_rules('txt_company_name', 'Company name', 'trim|required|max_length[200]|callback_check_inavlid_char');

        /*$this->form_validation->set_rules('txt_location', 'Company location', 'trim|required|max_length[1000]');
        $this->form_validation->set_rules('txt_longitude', 'Location longitude', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('txt_lattitude', 'Location lattitude', 'trim|required|max_length[30]');*/
        // $this->form_validation->set_rules('txt_apprtment', 'Appartment Name', 'trim|required|max_length[100]|callback_check_inavlid_char');
        //  $this->form_validation->set_rules('txt_area', 'Area', 'trim|required|max_length[100]|callback_check_inavlid_char');
        $this->form_validation->set_rules('txt_service_type[]', 'Service type', 'trim|required');
        if (empty($_FILES['txt_profile']['name']) && $this->input->post("txt_user_id") <= 0) {
            $this->form_validation->set_rules('txt_profile', 'Upload Profile', 'trim|required');
        }
        if (empty($_FILES['txt_doc']['name']) && $this->input->post("txt_user_id") <= 0 && $this->input->post("company_type") == 1) {
            $this->form_validation->set_rules('txt_doc', 'Upload Document', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_first_name' => form_error('txt_first_name'),
                'txt_last_name' => form_error('txt_last_name'),
                'txt_email' => form_error('txt_email'),
                'select_city' => form_error('select_city'),
                'select_country' => form_error('select_country'),
                'txt_password' => form_error('txt_password'),
                'txt_phone' => form_error('txt_phone'),
                'select_city' => form_error('select_city'),
                'select_document_type' => form_error('select_document_type'),
                'txt_doc_no' => form_error('txt_doc_no'),
                'txt_doc' => form_error('txt_doc'),
                'txt_profile' => form_error('txt_profile'),
                'txt_company_name' => form_error('txt_company_name'),
                'txt_location' => form_error('txt_location'),
                'txt_location' => form_error('txt_longitude'),
                'txt_location' => form_error('txt_lattitude'),
                'txt_service_type[]' => form_error('txt_service_type[]'),
            );
            echo json_encode($data);
            exit();
        } else {

            $input2 = array();

            if ($_FILES["txt_profile"]["name"] != "") {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["txt_profile"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'user/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;

                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                // $this->upload->initialize($config2);

                if (!$this->upload->do_upload('txt_profile')) {
                    echo $this->upload->error_string();
                    echo "hi";
                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txt_profile' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input['user_image']                 =   $config2['file_name'];
                }
            }
            if ($_FILES["txt_doc"]["name"] != "" && $this->input->post("company_type") == 1) {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["txt_doc"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'user/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg|pdf|doc';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;

                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);

                if (!$this->upload->do_upload('txt_doc')) {
                    echo $this->upload->display_errors();
                    echo "hi2";

                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txt_profile' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input2['document_name']                 =   $config2['file_name'];
                }
            } else {
                $input2['document_name']                 =   "";
            }


            $_POST = $this->security->xss_clean($_POST);

            $input['user_first_name']                    =                 trim($this->input->post("txt_first_name"));
            $input['user_last_name']                     =                 trim($this->input->post("txt_last_name"));
            $input['user_email']                              =                 trim($this->input->post("txt_email"));
            
            if((int)$this->input->post("save_password")==1)
            {
                $input['user_password']                      =                 MD5($this->input->post("txt_password"));
            }
            
            $input['country_id']                              =                 trim($this->input->post("select_country"));
            $input['city_id']                                      =                 trim($this->input->post("select_city"));
            $input['user_phone']                            =                 trim($this->input->post("txt_phone"));
            $input['user_dial_code']                      =                 trim($this->input->post("txt_dial"));
            $input['user_type']                                =                2;

            $input['user_status']                             =                 0;
            $input['user_created_methode']       =                 "web";

            if ($this->input->post("txt_user_id") > 0) {
                unset($input['user_email']);
                unset($input['user_status']);
                $input['user_id']                                 =                 trim($this->input->post("txt_user_id"));
                $input['user_updated_by']              =                 $input['user_id'];
                $input['user_updated_time']          =                 date("Y-m-d H:i:s");
            } else {
                $input['user_created_by']              =                 0;
                $input['user_created_time']          =                 date("Y-m-d H:i:s");
            }

            $input2['document_number']                 =    trim($this->input->post("txt_doc_no"));
            $input2['document_type']                       =    trim($this->input->post("select_document_type"));
            $input2['company_name']                       =    trim($this->input->post("txt_company_name"));
            $input2['lattitude']                       =    trim($this->input->post("txt_lattitude"));
            $input2['longitude']                       =    trim($this->input->post("txt_longitude"));
            $input2['location']                       =    trim($this->input->post("txt_location"));
            $input2['company_type']                       =    trim($this->input->post("company_type"));


            $input3 = $this->input->post("txt_service_type");
            $input4 = $this->input->post('txt_area');
            
            if (count($_POST) > 0) {

                $result         =   $this->M_admin->saveProvider($input, $input2, $input3,$input4);
            } else {

                $result = 0;
            }
            $data['status'] = $result;
            echo json_encode($data);
        }
    }
    function articleList()
    {

        $condition                    =    array("user_type" => "D");
        $data["article_list"]        =   $this->M_admin->getArticles();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/article_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditArticle()
    {

        $language   =  ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $data   = array();
        $con['article_type_language_code']  = 1;
        $con['article_type_status']  = 1;
        $data["article_type"]   =  $this->M_admin->getArticleTypes($con);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_article", $data);
        $this->load->view("admin/footer");
    }
    function saveArticle()
    {

        $this->form_validation->set_rules('txt_article_type', 'Article type', 'trim|required');
        $this->form_validation->set_rules('txt_article', 'Article English', 'trim|required|callback_custom_minlength_check');
        $this->form_validation->set_rules('txt_article_arb', 'Article Arabic', 'trim|required|callback_custom_minlength_check');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_article_type' => form_error('txt_article_type'),
                'txt_article' => form_error('txt_article'),
                'txt_article_arb' => form_error('txt_article_arb'),
            );
            echo json_encode($data);
            exit();
        }
        //  $_POST = $this->security->xss_clean($_POST);
        if (count($_POST) > 0) {
            $result         =   $this->M_admin->saveArticle($_POST);
        } else {
            $result = 0;
        }
        $data['status'] = $result;
        echo json_encode($data);
    }
    function deleteArticle()
    {
        $id           =       $_POST['id'];
        echo  $this->M_admin->deleteArticle($id);
    }
    function articleTypeList()
    {
        $language   =  ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $data   = array();

        $data["article_type"]   =  $this->M_admin->getArticleTypesMultiLanguage();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/article_type_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditArticleType()
    {


        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($id > 0) {

            $con1['article_type_language_code']                           =       1;
            $con2['article_type_language_code']                           =       2;
            $con2['article_type_id']                                      =      $id;
            $con1['article_type_id']                                      =      $id;
            $data["article_type_eng"]      =  $this->M_admin->getArticleTypes($con1);
            $data["article_type_arabic"]   =  $this->M_admin->getArticleTypes($con2);

            $data["id"]   =  $id;
        }

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_article_type", $data);
        $this->load->view("admin/footer");
    }
    function saveArticleType()
    {
        $this->form_validation->set_rules('txtEnglish', 'Country Name English', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtArabic', 'Country Name Arabic', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic' => form_error('txtArabic')
            );
            echo json_encode($data);
            exit();
        }

        $inputArray['article_type_desc']                             =     $_POST['txtEnglish'];
        $inputArray['article_type_language_code']          =    1;
        $inputArray['article_type_status']                          =    $_POST['txtStatus'];
        $inputArray['article_type_created_date']             =    date("Y-m-d H:i:s");
        $inputArray2                                                                 =    $inputArray;
        $inputArray2['article_type_desc']                           =    ($_POST['txtArabic'] != "" ? $_POST['txtArabic'] : $_POST['txtEnglish']);
        $inputArray2['article_type_language_code']        =    2;






        if (isset($_POST['txt_type_id']) && $_POST['txt_type_id'] > 0) {
            $inputArray['article_type_id']             =     $_POST['txt_type_id'];
            $inputArray2['article_type_id']           =     $_POST['txt_type_id'];
            unset($inputArray['article_type_created_date']);
            unset($inputArray2['article_type_created_date']);
        }

        //  print_r($inputArray);
        /**
         * changes by jitin on 26 sep 18 for xss filtering
         */
        $inputArray = $this->security->xss_clean($inputArray);
        $inputArray2 = $this->security->xss_clean($inputArray2);

        $result =    $this->M_admin->saveMasterTable($inputArray, $inputArray2, 'article_type_id', 'article_type_language_code', 'article_type');
        $data['status'] = $result;
        echo json_encode($data);
    }
    function deleteArticleType()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $this->M_admin->deleteArticleType($id);
    }
    function changePassword()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/change_password", $data);
        $this->load->view("admin/footer");
    }
    function saveChangePassword()
    {
        $this->form_validation->set_rules('txt_old_password', 'Old password', 'required|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('txt_new_password', 'New password', 'required|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('txt_conf_password', 'Confirm password', 'required|min_length[8]|max_length[20]|matches[txt_new_password]');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_old_password' => form_error('txt_old_password'),
                'txt_new_password' => form_error('txt_new_password'),
                'txt_conf_password' => form_error('txt_conf_password')
            );
            echo json_encode($data);
            exit();
        }
        $_POST = $this->security->xss_clean($_POST);
        if (count($_POST) > 0) {
            $result         =   $this->M_admin->saveChangePassword($_POST);
        } else {
            $result = 0;
        }
        $data['status'] = $result;
        echo json_encode($data);
    }
    function userReport()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/user_report", $data);
        $this->load->view("admin/footer");
    }
    function listUsersAjax()
    {


        $this->load->library('pagination');




        $limit_per_page                      =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->listUserReportCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->listUserReport($_POST, $limit_per_page, $start_index);

            $config['base_url']         =     base_url() . 'admin/C_admin/listUsersAjax';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }

        //   print_r($data);

        $this->load->view("admin/user_report_ajax", $data);
    }
    function userReportDownLoad($type)
    {
        $type = $this->uri->segment(5);
        $this->load->library('Fpdf_gen');
        $this->fpdf->SetFont('Arial', 'B', 14);
        $this->fpdf->SetFillColor(193, 229, 252);
        if ($type == 1) {
            $condition                    =    array("user_type" => 1);
            $pdfFileName = 'user_report_on' . date('Y_m_d') . '.pdf';
            $fileName = 'user_report_on' . date('Y_m_d') . '.xls';
            $data["user_list"]        =   $this->M_admin->getUsersCondition($condition);
            $this->fpdf->Cell(180, 10, 'User Report', 1, 1, C, true);
        } else if ($type == 2) {
            $condition                    =    array("user_type" => 2);
            $pdfFileName = 'provide_report_on' . date('Y_m_d') . '.pdf';
            $fileName = 'providerr_report_on' . date('Y_m_d') . '.xls';
            $data["user_list"]        =   $this->M_admin->getUsersCondition($condition);
            $this->fpdf->Cell(180, 10, 'Provider Report', 1, 1, C, true);
        } else {
            $condition                    =    array("user_type" => "U");
            $pdfFileName = 'customer_report_on' . date('Y_m_d') . '.pdf';
            $fileName = 'customer_report_on' . date('Y_m_d') . '.xls';
            $data["user_list"]        =   $this->M_admin->getUsersCondition($condition);
            $this->fpdf->Cell(180, 10, 'Customer Report', 1, 1, C, true);
        }




        $option = $this->uri->segment(4);

        if ($option == 1) {





            $this->fpdf->SetFont('Arial', 'B', 12);

            if ($type == 3) {
                //$width_cell = array(20, 30, 35, 20, 20);
                $width_cell = array(18, 37, 39, 18, 12);
            } else {
                $width_cell = array(20, 40, 40, 30);
            }

            $this->fpdf->SetFillColor(193, 229, 252); // Background color of header 
            // Header starts /// 
            $this->fpdf->Cell($width_cell[0], 10, 'Sl No', 1, 0, C, true); // First header column 
            $this->fpdf->Cell($width_cell[1], 10, 'Name', 1, 0, C, true); // Second header column
            $this->fpdf->Cell($width_cell[2], 10, 'Email', 1, 0, C, true); // Third header column 
            $this->fpdf->Cell($width_cell[2], 10, 'Phone', 1, 0, C, true);
            if ($type == 3) {
                $this->fpdf->Cell($width_cell[2], 10, 'Vehicle No', 1, 0, C, true);
            }
            $this->fpdf->Cell($width_cell[2], 10, 'Status', 1, 1, C, true);
            $this->fpdf->SetFont('Arial', '', 10);



            if (count($data["user_list"]) > 0) {
                $this->fpdf->SetFont('Arial', '', 10);
                $i = 1;
                foreach ($data["user_list"] as $rows) {
                    $this->fpdf->Cell($width_cell[0], 10, $i, 1, 0, C, false); // First header column 
                    $this->fpdf->Cell($width_cell[1], 10, $rows->user_first_name . ' ' . $rows->user_last_name, 1, 0, C, false); // Second header column
                    $this->fpdf->Cell($width_cell[2], 10, $rows->user_email, 1, 0, C, false); // Third header column 
                    $this->fpdf->Cell($width_cell[2], 10, $rows->user_dial_code . '-' . $rows->user_phone, 1, 0, C, false);
                    if ($type == 3) {
                        $this->fpdf->Cell($width_cell[2], 10, $rows->vehicle_no, 1, 0, C, false);
                    }
                    $this->fpdf->Cell($width_cell[2], 10, $rows->user_status == 1 ? "Active" : "Inactive", 1, 1, C, false);
                    $i++;
                }
            }


            echo $this->fpdf->Output($pdfFileName, 'D');
        } else {

            //$fileName = 'user_report_on'.date('Y_m_d').'.xls';
            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");

            function filterData(&$str)
            {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            // file name for download
            // $fileName = "vendor_payment_report_on" . date('Ymd') . ".xls";

            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");

            $flag = false;
            $i = 1;
            foreach ($data["user_list"] as $row) {
                if (!$flag) {
                    // display column names as first row
                    if($type==1)
                        echo implode("\t", array('Sl no', 'Name', 'Email', 'Phone','Country','Status')) . "\n";
                    else
                        echo implode("\t", array('Sl no', 'Name', 'Email', 'Phone','Country','City', 'Status')) . "\n";
                    $flag = true;
                }
                // filter data
                array_walk($row, 'filterData');

                $name = $row->user_first_name . ' ' . $row->user_last_name;
                if (strpos($row->user_dial_code, '+') === false) {
                    $row->user_dial_code = '+'.$row->user_dial_code;
                }
                if($type==1)
                    echo implode("\t", array($i, $name, $row->user_email, $row->user_dial_code . ' ' . $row->user_phone,$row->country_name, $row->user_status == 1 ? "Active" : "Inactive")) . "\n";
                else
                    echo implode("\t", array($i, $name, $row->user_email, $row->user_dial_code . ' ' . $row->user_phone,$row->country_name,$row->city_name, $row->user_status == 1 ? "Active" : "Inactive")) . "\n";
                $i++;
            }

            exit;
        }
    }
    function userReportExport()
    {
        print_r($_POST);
        exit;
    }
    function providerReport()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/provider_report", $data);
        $this->load->view("admin/footer");
    }
    function serviceTypeReport()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/service_type_report", $data);
        $this->load->view("admin/footer");
    }
    function listServiceTypeAjax()
    {



        $this->load->library('pagination');




        $limit_per_page                      =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->listServiceTypeReportCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->listServiceTypeReport($_POST, $limit_per_page, $start_index);

            $config['base_url']         =     base_url() . 'admin/C_admin/listServiceTypeAjax';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }

        //   print_r($data);

        $this->load->view("admin/service_type_report_ajax", $data);
    }
    function testimonialList()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/testimonial_list", $data);
        $this->load->view("admin/footer");
    }
    function addEditTestimonial()
    {



        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($id > 0) {

            $con1['testimonial_id']                           =       $id;

            $data["testi"]      =  $this->M_admin->getTestimonials($con1);


            $data["id"]   =  $id;
        }

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_testimonial", $data);
        $this->load->view("admin/footer");
    }
    function saveTestimonial()
    {
        $this->form_validation->set_rules('user_type', 'User type ', 'required');
        $this->form_validation->set_rules('txtFirstname', 'First name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txtLastName', 'Last name', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
        $this->form_validation->set_rules('txtArabic', 'Testimonial arabic', 'trim|required|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('txtEnglish', 'Testimonial english', 'trim|required|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('txt_desig', 'Designation', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('txt_desig_arb', 'Designation arabic', 'trim|required|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'user_type' => form_error('user_type'),
                'txtFirstname' => form_error('txtFirstname'),
                'txtLastName' => form_error('txtLastName'),
                'txtArabic' => form_error('txtArabic'),
                'txtEnglish' => form_error('txtEnglish'),
            );
            echo json_encode($data);
            exit();
        }
        $_POST = $this->security->xss_clean($_POST);
        if (count($_POST) > 0) {



            if ($_FILES["txt_profile"]["name"] != "") {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["txt_profile"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'user/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;

                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                // $this->upload->initialize($config2);

                if (!$this->upload->do_upload('txt_profile')) {

                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txt_profile' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input['profile_image']                 =   $config2['file_name'];
                }
            }
            $input['first_name']                             =                  $_POST['txtFirstname'];
            $input['last_name']                             =                  $_POST['txtLastName'];
            $input['user_type']                              =                  $_POST['user_type'];
            $input['testimonial_status']              =                  $_POST['txtStatus'];
            $input['testimonial']                           =                   $_POST['txtEnglish'];
            $input['testimonial_arabic']              =                  $_POST['txtArabic'];
            $input['designation']                           =                  $_POST['txt_desig'];
            $input['designation_arabic']             =                  $_POST['txt_desig_arb'];
            if ($_POST['txt_test_id'] > 0) {
                $input['testimonial_updated_by']                  =                    $this->session->userdata('admin_id');
                $input['testimonial_updated_time']              =                    date("Y-m-d H:i:s");
                $input['testimonial_id']                                   =                    $_POST['txt_test_id'];
            } else {
                $input['testimonial_created_by']                   =                    $this->session->userdata('admin_id');
                $input['testimonial_created_time']               =                     date("Y-m-d H:i:s");
            }

            $result         =   $this->M_admin->saveTestimonial($input);
        } else {
            $result = 0;
        }
        $data['status'] = $result;
        echo json_encode($data);
    }
    function listTestimonialAjax()
    {




        $this->load->library('pagination');




        $limit_per_page                      =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->listTestimonialReportCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->listTestimonialReport($_POST, $limit_per_page, $start_index);

            $config['base_url']         =     base_url() . 'admin/C_admin/listTestimonialAjax';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }

        //   print_r($data);

        $this->load->view("admin/testimonial_list_ajax", $data);
    }
    function deleteTestimonials()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $this->M_admin->deleteTestimonials($id);
    }
    function sendRequest()
    {




        $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($id > 0) {

            $con1['user_id']                           =       $id;


            $data["id"]   =  $id;
        }

        $con['service_type_language_code'] =  1;
        //$con['service_type_parent_id=']           =  0;
        $con['service_type_status']           =  1;

        $data['service_type']               =  $this->M_admin->getServiceTypes($con);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_request", $data);
        $this->load->view("admin/footer");
    }
    function getDynamicQuestions()
    {
        $data['questions']         =  $this->M_admin->getDynamicQuestions($_POST);
        $this->load->view("admin/dynamic_questions", $data);
    }
    function saveRequest()
    {
        //print_r($_FILES);
        //exit;
        $this->form_validation->set_rules('select_service_type', 'Service type ', 'required');
        if ($this->input->post("is_home") == 0) {
            $this->form_validation->set_rules('address_type', 'Address type', 'trim|required');
            $this->form_validation->set_rules('txt_date', 'Service date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('txtTime', 'Service time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('select_price_from', 'Price from', 'trim|required|xss_clean|callback_weight_check');
            $this->form_validation->set_rules('select_price_to', 'Price to', 'trim|required|xss_clean|callback_weight_check');

            if ($_POST['address_type'] > 0 && $_POST['txt_user_id'] > 0) {
                $location = $this->M_admin->getHomeLocation($_POST['txt_user_id'], $_POST['address_type']);

                // print_r($location);
                // $locationName = $location->user_adresses_location;
                if ($location->user_adresses_id <= 0) {
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'address_type' => "address not set",
                    );
                    echo json_encode($data);
                    exit();
                }
            }
        } else {
            $this->form_validation->set_rules('txt_location', 'Location', 'trim|required|max_length[2000]|xss_clean');
        }

        $this->form_validation->set_rules('txt_valid_date', 'Validity date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtValidTime', 'Validity time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('select_option', 'Option', 'trim|required|xss_clean');
        if ($this->input->post("select_option") == 2) {
            $this->form_validation->set_rules('txt_provider[]', 'Select provider', 'trim|required|xss_clean');
        }
        /*  if($_POST['select_service_type']>0)
        {
        $in['select_service_type']    = $_POST['select_service_type'] ;
        $questions =      $this->M_admin->getDynamicQuestions($in)     ;                 
       
        if(count($questions)>0)
        {
        foreach ($questions as $value) 
              {
  
                      $this->form_validation->set_rules('question['.$value->question_id.'][]', 'Needs', 'trim|required');
 
                } 
            }
         }*/

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'select_service_type' => form_error('select_service_type'),
                'address_type' => form_error('address_type'),
                'txt_location' => form_error('txt_location'),
                'txt_date' => form_error('txt_date'),
                'txtTime' => form_error('txtTime'),
                'select_price_from' => form_error('select_price_from'),
                'select_price_to' => form_error('select_price_to'),
                'txt_valid_date' => form_error('txt_valid_date'),
                'txtValidTime' => form_error('txtValidTime'),
                'select_option' => form_error('select_option'),
                'txt_provider[]' => form_error('txt_provider[]'),
                'question[' . $value->question_id . '][]' => form_error('question[' . $value->question_id . '][]'),
            );
            echo json_encode($data);
            exit();
        }

        if (count($_FILES["txt_doc"]["name"]) > 0) {

            for ($i = 0; $i < count($_FILES["txt_doc"]["name"]); $i++) {

                $abc = FALSE;

                $temp_name = $_FILES['txt_doc']['tmp_name'][$i];
                $real_name  = strtolower($_FILES['txt_doc']['name'][$i]);
                $img_ext = end(explode(".", $real_name));

                $upload_dir    =   $this->config->item('upload_path') . 'quotations/';

                $digits = 6;
                $up_file_name = "";

                $up_file_name   =   str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis") . "." . $img_ext;

                $file_path      =  $upload_dir . $up_file_name;

                // echo "<br>";

                $abc =   move_uploaded_file($temp_name, $file_path);
                // var_dump($abc);

                if ($abc === FALSE) {
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'document' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input['document'][$i]                 =   $up_file_name;
                }

                //echo "syam".$i;                     

            }
        }
        //print_r($_POST);exit;
        $_POST          =  $this->security->xss_clean($_POST);
        $result          =  $this->M_admin->saveRequest($_POST, $input);
        $data['status'] = $result;
        echo json_encode($data);
    }
    function dynamicToPrice()
    {
        $currentValue  =    $_POST['currentValue'];
        ?>
        <option value="">Select</option>
        <?php
        $i = 0;
        for ($i = $currentValue; $i < 10000; $i = $i + 1000) {
        ?>
            <option value="<?php echo $i ?>"><?php echo "AED " . $i ?></option>
            <?php
        }
    }
    function getProviderMultiSelect()
    {
        $serviceTypeId   =    $_POST['serviceType'];
        $providers         =  $this->M_admin->getProviderAgainstServiceType($serviceTypeId);
        if (count($providers) > 0) {
            foreach ($providers as $rows2) {
                $profileImage    =   $rows2->user_image != "" ? base_url() . "uploads/user/" . $rows2->user_image : base_url() . "images/logo.png";
            ?>
                <div class="col-md-2">
                    <div class="form-check">

                        <label class="form-check-label">
                            <input class="form-check-input dynamicQues" id="dynamicQues2" name="txt_provider[]" type="checkbox" value="<?php echo $rows2->user_id ?>"><img src="<?php echo $profileImage; ?>" class="profileIcon">&nbsp;<?php echo $rows2->company_name ?> </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



                    </div>


                </div>
            <?php
            }
        } else {
            echo "";
        }
    }
    function jobRequestReport()
    {
        //exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report", $data);
        $this->load->view("admin/footer");
    }
    function listJobRequestsAjax()
    {





        $this->load->library('pagination');




        $limit_per_page              =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                      =     $this->M_admin->getJobRequestsListCount($_POST);
        $total_records                 =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->getJobRequestsList($_POST, $limit_per_page, $start_index);

            $config['base_url']         =     base_url() . 'admin/C_admin/listJobRequestsAjax';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }



        $this->load->view("admin/job_request_report_ajax", $data);
    }
    function getJobRequestDetails()
    {
        $jobRequestId      =      $this->common_functions->decryptId($_POST['job_request_id']);
        if ($jobRequestId <= 0) {
            echo 0;
        } else {
            $data['result_questions']                     =   $this->M_admin->getJobRequestsDetails($jobRequestId);
            $data['result_assigned_providers']            =   $this->M_admin->getAssignedProviders($jobRequestId);
            $data['result_job']                           =   $this->M_admin->getJobRequestBasicDetails($jobRequestId);
            $data['files']                                =   $this->M_admin->getUploadedFiles($jobRequestId);
            $data['job_days']                             =   $this->M_admin->getJobDaysByRequestId($jobRequestId);

            $data['staff_list'] = $this->M_admin->getUsersListByVendor($data['result_job']->vendor_id);
        }

        $this->load->view("admin/job_request_report_details", $data);
    }
    function viewProviderJobs()
    {
        $data['provider_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        2;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report_provider", $data);
        $this->load->view("admin/footer");
    }
    function viewProviderQuotations()
    {
        $data['provider_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        1;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report_provider", $data);
        $this->load->view("admin/footer");
    }
    function quotataionList()
    {
        $data['provider_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        1;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report", $data);
        $this->load->view("admin/footer");
    }
    function requestList()
    {
        $data['provider_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        2;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report", $data);
        $this->load->view("admin/footer");
    }
    function listJobRequestsAjaxProvider()
    {





        $this->load->library('pagination');




        $limit_per_page                      =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->getJobRequestsListCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->getJobRequestsList($_POST, $limit_per_page, $start_index);

            $data['posts']  =   $_POST;

            $config['base_url']         =     base_url() . 'admin/C_admin/listJobRequestsAjaxProvider';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }



        $this->load->view("admin/job_request_report_ajax_provider", $data);
    }
    function setProviderResponse()
    {

        echo $result  =   $this->M_admin->setProviderResponse($_POST);
    }
    function markProviderPrice()
    {
        //print_r($_FILES);
        //exit;
        $this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean|callback_weight_check');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'price' => form_error('price')
            );
            echo json_encode($data);
            exit();
        } else {
            if ($_FILES["file_doc"]["name"] != "") {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["file_doc"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'quotations/';
                $config2['allowed_types']        =   'gif|jpg|png|jpeg|pdf|doc';
                $config2['file_name']            =   $randomNo . "." . $file_ext2;
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);

                if (!$this->upload->do_upload('file_doc')) {

                    $data['status'] = 0;
                    $data['message'] = "file_doc=" . $this->upload->display_errors();
                    echo json_encode($data);
                    exit();
                } else {
                    $_POST['document_name']                 =   $config2['file_name'];
                }
            }


            $result  =   $this->M_admin->markProviderPrice($_POST);
            $data['status'] = $result;
            echo json_encode($data);
            exit();
        }
    }
    function viewUserJobs()
    {
        $data['user_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        2;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report_user", $data);
        $this->load->view("admin/footer");
    }
    function viewUserQuotations()
    {
        $data['user_id']                       =        $this->common_functions->decryptId($this->uri->segment(3));
        $data['job_request_type']            =        1;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/job_request_report_user", $data);
        $this->load->view("admin/footer");
    }
    function listJobRequestsAjaxUser()
    {






        $this->load->library('pagination');




        $limit_per_page                      =    $_POST['limit_per_page'] > 0 ? $_POST['limit_per_page'] : 10;
        $start_index                  =     ($this->uri->segment(4) > 0 ? ($this->uri->segment(4) - 1) * $limit_per_page : 0);
        $records                     =     $this->M_admin->getJobRequestsListCount($_POST);
        $total_records                =    $records->count;

        if ($total_records > 0) {

            $data['result']  =   $this->M_admin->getJobRequestsList($_POST, $limit_per_page, $start_index);

            $data['posts']  =   $_POST;

            $config['base_url']         =     base_url() . 'admin/C_admin/listJobRequestsAjaxUser';
            $config['total_rows']         =     $total_records;
            $config['per_page']         =     $limit_per_page;
            $config["uri_segment"]         =     4;

            // custom paging configuration
            $config['num_links']             =     2;
            $config['use_page_numbers']     =     TRUE;
            $config['reuse_query_string']     =     TRUE;

            $config['full_tag_open']         =     '<ul class="pagination">';
            $config['full_tag_close']         =     '</ul>';

            $config['first_link']             =     $this->lang->line('first');
            $config['first_tag_open']         =     '<li>';
            $config['first_tag_close']         =     '</li>';

            $config['last_link']             =     $this->lang->line('last');
            $config['last_tag_open']         =     '<li>';
            $config['last_tag_close']         =     '</li>';

            $config['next_link']             =     '&gt;';
            $config['next_tag_open']         =     '<li>';
            $config['next_tag_close']         =     '</li>';

            $config['prev_link']             =     '&lt;';
            $config['prev_tag_open']         =     '<li>';
            $config['prev_tag_close']         =     '</li>';

            $config['cur_tag_open']         =     '<li class="active"><span>';
            $config['cur_tag_close']         =     '</span></li>';

            $config['num_tag_open']         =     '<li>';
            $config['num_tag_close']         =     '</li>';
            $config["num_links"]                        =     6;

            $this->pagination->initialize($config);


            $data["links"] = $this->pagination->create_links();
        }



        $this->load->view("admin/job_request_report_ajax_user", $data);
    }
    function getJobRequestDetailsForUser()
    {


        $jobRequestId      =      $this->common_functions->decryptId($_POST['job_request_id']);

        if ($jobRequestId <= 0) {
            echo 0;
        } else {
            $data['result_questions']                     =   $this->M_admin->getJobRequestsDetails($jobRequestId);
            $data['result_assigned_providers']   =   $this->M_admin->getAssignedProviders($jobRequestId);
            $data['result_job']   =   $this->M_admin->getJobRequestBasicDetails($jobRequestId);
            $data['files']        =   $this->M_admin->getUploadedFiles($jobRequestId);

            //print_r( $data['result_job']);

        }

        $this->load->view("admin/job_request_report_details_user", $data);
    }
    function approveProvider()
    {
        //print_r($_POST);
        $this->form_validation->set_rules('job_request_id', 'job_request_id', 'trim|required|xss_clean|numeric');
        $this->form_validation->set_rules('provider_id', 'provider_id', 'trim|required|xss_clean|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'provider_id' => form_error('provider_id'),
                'job_request_id' => form_error('job_request_id')
            );
            echo json_encode($data);
            exit();
        } else {
            $_POST = $this->security->xss_clean($_POST);
            $result  =   $this->M_admin->approveProvider($_POST);
            $data['status'] = $result;
            echo json_encode($data);
            exit();
        }
    }
    function toggleLanguage()
    {
        if ($_POST['value'] == 2) {
            $this->session->set_userdata("language", 2);

            echo 2;
        } else {
            $this->session->set_userdata("language", 1);
            echo 1;
        }
    }
    function getSubQuestions()
    {
        $data['questions']         =  $this->M_admin->getDynamicQuestionsChild($_POST);

        //  print_r($data);
        $this->load->view("admin/dynamic_questions", $data);
    }
    function addEditPackages()
    {

        $data["packageId"]                               =        $this->uri->segment(3);
        $data["packageIdDecrypted"]            =        $this->common_functions->decryptId($this->uri->segment(3));
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_package", $data);
        $this->load->view("admin/footer");
    }
    function savePackages()
    {

        $this->form_validation->set_rules('txt_package_name', 'Package name', 'trim|required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txt_package_name_arabic', 'Package name arabic', 'trim|required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txt_no_of_qtns', 'No of quotations', 'trim|required|xss_clean|numeric|max_length[6]');
        $this->form_validation->set_rules('txt_package_price', 'Package price', 'trim|required|xss_clean|callback_weight_check');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_package_name' => form_error('txt_package_name'),
                'txt_package_name_arabic' => form_error('txt_package_name_arabic'),
                'txt_no_of_qtns' => form_error('txt_no_of_qtns'),
                'txt_package_price' => form_error('txt_package_price'),
            );
            echo json_encode($data);
            exit();
        } else {
            $_POST = $this->security->xss_clean($_POST);
            $result  =   $this->M_admin->savePackages($_POST);
            $data['status'] = $result;
            echo json_encode($data);
            exit();
        }
    }
    function listPackages()
    {
        $con  =  array();
        $data["package_list"]            = $this->M_admin->getPackagesCondition($con);
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/package_list", $data);
        $this->load->view("admin/footer");
    }
    function deletePackage()
    {
        $id                  =   $this->common_functions->decryptId(trim($this->input->post("id")));
        echo  $result          =   $this->M_admin->deletePackage($id);
    }
    function assignPackage()
    {

        // print_r($_POST); exit;
        $this->form_validation->set_rules('package', 'Package', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'package' => form_error('package')
            );
            echo json_encode($data);
            exit();
        } else {
            $_POST = $this->security->xss_clean($_POST);
            $result  =   $this->M_admin->assignPackage($_POST);
            $data['status'] = $result;
            echo json_encode($data);
            exit();
        }
    }
    function updateRequest()
    {
        $jobRequestId                              =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($jobRequestId > 0) {




            $data["job_id"]                          =  $jobRequestId;

            $data['result_questions']                       =   $this->M_admin->getJobRequestsDetailsForEditModule($jobRequestId);
            $data['result_assigned_providers']    =   $this->M_admin->getAssignedProviders($jobRequestId);
            $data['result_job']                                  =   $this->M_admin->getJobRequestBasicDetails($jobRequestId);

            //  print_r($data);

        }

        $con['service_type_language_code'] =  1;
        //$con['service_type_parent_id=']           =  0;
        $con['service_type_status']           =  1;

        $data['service_type']               =  $this->M_admin->getServiceTypes($con);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_update_request", $data);
        $this->load->view("admin/footer");
    }
    function addEditBanner()
    {
        $bannerId                             =      $this->common_functions->decryptId($this->uri->segment(3));
        if ($bannerId > 0) {
            $con['banner_id']   = $bannerId;
            $data['id'] = $bannerId;
            $data['banner'] = $this->M_admin->getBanners($con);
        }
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_banner", $data);
        $this->load->view("admin/footer");
    }
    function saveBanner()
    {
        //   print_r($_FILES);
        $this->form_validation->set_rules('txtEnglish', 'Banner title', 'trim|required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txtUrl', 'Package name arabic', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('txtArabic', 'Banner title arabic', 'trim|required|xss_clean|max_length[100]');

        if (empty($_FILES['txt_banner']['name']) && $this->input->post("banner_id") <= 0) {
            $this->form_validation->set_rules('txt_banner', 'Upload banner', 'trim|required');
        }

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtUrl' => form_error('txtUrl'),
                'txtArabic' => form_error('txtArabic'),
                'txt_banner' => form_error('txt_banner')
            );
            echo json_encode($data);
            exit();
        } else {
            $input                                               =        $this->security->xss_clean($_POST);
            if ($_FILES["txt_banner"]["name"] != "") {

                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");

                $filename2 = $_FILES["txt_banner"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

                $config2['upload_path']          =   $this->config->item('upload_path') . 'banner/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                $config2['file_name']                =  $randomNo . "." . $file_ext2;
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);

                if (!$this->upload->do_upload('txt_banner')) {
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txt_banner' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $input['banner_image']                 =   $config2['file_name'];
                }
            }
            $result                        =        $this->M_admin->saveBanner($input);

            $data['status']            =          $result;
            echo json_encode($data);
        }
    }
    function bannerList()
    {
        $con   = array();
        $data['banner'] = $this->M_admin->getBanners($con);
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/banner_list", $data);
        $this->load->view("admin/footer");
    }
    function deleteBanner()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));

        echo      $this->M_admin->deleteBanner($id);
    }
    function websiteBasic()
    {
        $data["admin_basics"]        =   $this->M_admin->getAdminBasics();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_web_basic", $data);
        $this->load->view("admin/footer");
    }
    function saveAdminDetails()
    {
        /**
         * changes by jitin on 27 sep 18 for xss filtering
         */

        $data = array();

        $this->form_validation->set_rules('txt_email', 'Email address', 'trim|required');
        $this->form_validation->set_rules('txt_address', 'Contact Address', 'trim|required');
        $this->form_validation->set_rules('txt_dial', 'Dial Code', 'trim|required');
        $this->form_validation->set_rules('txt_phone', 'Phone', 'trim|required');

        $this->form_validation->set_rules('txt_facebook', 'face book url', 'trim|required');
        $this->form_validation->set_rules('txt_twitter', 'Twitter url', 'trim|required');
        $this->form_validation->set_rules('txt_google', 'Google plus url', 'trim|required');
        $this->form_validation->set_rules('txt_insta', 'Instagram url', 'trim|required');
        $this->form_validation->set_rules('txt_youtube', 'Youtube url', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_email' => form_error('txt_email'),
                'txt_address' => form_error('txt_address'),
                'txt_dial' => form_error('txt_dial'),
                'txt_phone' => form_error('txt_phone'),
                'txt_facebook' => form_error('txt_facebook'),
                'txt_twitter' => form_error('txt_twitter'),
                'txt_google' => form_error('txt_google'),
                'txt_insta' => form_error('txt_insta'),
                'txt_youtube' => form_error('txt_youtube')
            );
            echo json_encode($data);
            exit();
        }

        $_POST = $this->security->xss_clean($_POST);

        $result =  $this->M_admin->saveAdminDetails($_POST);
        //print_r($_POST);
        $data['status'] = $result;
        echo json_encode($data);
    }
    function addEditFaq()
    {
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_faq", $data);
        $this->load->view("admin/footer");
    }
    function saveServiceFaq()
    {
        $result =  $this->M_admin->saveServiceFaq($_POST);
        $data['status'] = $result;
        echo json_encode($data);
    }
    function listFaq()
    {
        $data['faq_list']       = $this->M_admin->getFaqList();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/faq_list", $data);
        $this->load->view("admin/footer");
    }
    function deleteFAQ()
    {
        $id           =       $_POST['id'];
        echo  $this->M_admin->deleteFAQ($id);
    }
    function deleteJobRequest()
    {
        $id           =       $this->common_functions->decryptId($_POST['id']);
        echo  $this->M_admin->deleteJobRequest($id);
    }
    
     function approveJobRequest(){
        $result =  $this->M_admin->approveJobRequest($this->input->post());
        
        $jobRequestId                   =  $this->common_functions->decryptId($_POST['jobRequestId']);
        $job_details  = $this->M_admin->getJobRequestDetailsByRequestId($jobRequestId);
        $service      = $this->M_admin->getServiceByJobRequestId($job_details->service_type_id);
        if ($result ==1) {
            
            $reason = $this->input->post('reason');
            if($reason > 0 ){
                
                $notification_id = time();
                $reason = $this->M_admin->getRefuseReasonById($reason);
                $title       =  "Job request rejected"; 
                $description =  "Hi ".$job_details->user_first_name.' '.$job_details->user_last_name .", Vhelp has cancelled your job request";

                if (!empty($job_details->firebase_user_key)) {
                    $notification_data["Notifications/".$job_details->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => 'order-canceled',
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $job_details->job_request_id,
                                "service_type_name" => $service->service_type_name,
                                "url" => "",
                                "imageURL" => "",
                                "read" => "0",
                                "seen" => "0"
                            ];

                    $fb_database = get_firebase_refrence();
                    $fb_database->getReference()->update($notification_data);
                }
                if (! empty($job_details->fcm_token) ) {
                    $this->load->library("FCM_Notification");
                    $this->fcm_notification->send_single_notification($job_details->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "notification"],
                                ["type" => "order-rejected",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $job_details->job_request_id, 
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }
                
            }else{
                
                
                // exec("php ". FCPATH . "index.php admin/C_admin sendApproveNotification ".$jobRequestId." ".$_POST['nextStatus']." >/dev/null &");
            }
            

        }
        
        echo $result;
    }
    
    function sendApproveNotification($jobRequestId = 0, $status)
    {
        $jobDetails      = $this->M_admin->getJobDetails($jobRequestId);
        $userDetails     = $this->M_admin->getUsersFcmTokens($jobDetails->user_id);


        if ($jobDetails->job_request_type == 1) {
            $typeReq  = "Quotation";
        } else {
            $typeReq  = "Job request";
        }
        if ($status == 1) {


            $subject                 = "Your " . $typeReq . " has been approved ";
            $userMaiArray['message'] = "Congrats! Your " . $typeReq . " has been approved. Click <a href='" . base_url() . "'>here<a> to login to verify.";
            $forChat['message']      = "Congrats! Your " . $typeReq . " has been approved.";
        }
        if ($status <= 0) {

            $subject                 = "Your " . $typeReq . " has been refused ";
            $userMaiArray['message'] = "Sorry! Your  " . $typeReq . " been rejected at the moment. Please try after sometime.";
            $forChat['message']      = "Sorry! Your  " . $typeReq . " been rejected at the moment. Please try after sometime.";
        }


        $userMaiArray['name']    = $userDetails->user_first_name;
        $to                      = $userDetails->user_email;
        $userMaiArray['subject'] = $subject;
        $this->load->library('parser');
        $email_message  = $this->parser->parse('email/status_change', $userMaiArray, true);
        $this->load->library("Mail_function");
        $this->mail_function->SendEmail($email_message, $subject, $to);

        $extraData['title']  =  "Vhelp";
        $extraData['id']     =   $jobRequestId;
        $extraData['type']   =  "Job request";
        //  $extraData['click_action']   =  "notification";

        if ($jobDetails->job_request_type == 1) {
            $type = "quotation";
        } else {
            $type = "Job request";
        }

        if ($userDetails->fcm_token != "") {


            $message['title']         =  "Vhelp";
            $message['body']          =  $forChat['message'];
            $message['click_action']  =  "notification";

            $r                        =  $this->fcm_notification->send_single_notification($userDetails->fcm_token, $message, $extraData);
            $saveData                 =  $this->M_admin->updateToFirbase($userDetails->user_id, "U", $message['body'], $message['title'], $type, $jobRequestId);
        }


        if ($status == 1) {

            if ($jobDetails->job_request_type == 1) {
                $type = "quotation";


                $fcm =   $this->M_admin->getFcmGroupDetails($jobDetails->service_type_id);



                $message['title']        =  "Vhelp";
                $message['body']         =  "New quotation invitation";
                $message['click_action']   =  "notification";

                if ($fcm->notification_group_name != "" && $fcm->fcm_key != "") {
                    $this->fcm_notification->send_notification($fcm->fcm_key, $message, $extraData);

                    $providersArray =  $this->M_admin->getProvidersAgainsServiceType($jobDetails->service_type_id);

                    foreach ($providersArray as $notiFicationUsers) {

                        $saveData =  $this->M_admin->updateToFirbase($notiFicationUsers->provider_id, "P", $message['body'], $message['title'], $type, $jobRequestId);
                    }
                }
            } else {
                $type = "request";

                $message['title']        =  "Vhelp";
                $message['body']         =  "New job request";
                $message['click_action']   =  "notification";

                $providerArray  =  $this->M_admin->getAssignedProvidersId($jobRequestId);

                $extraData['title']  =  "Vhlep";
                $extraData['id']     =   $jobRequestId;
                $extraData['type']   =  "Job request";
                //$extraData['click_action']   =  "notification";
                if (count($providerArray) > 0) {

                    foreach ($providerArray as $prs) {
                        $pr   =   $prs->provider_id;
                        $fcm  =   $this->M_admin->getUsersFcmTokens($pr);

                        if ($fcm->fcm_token != "") {
                            $this->fcm_notification->send_single_notification($fcm->fcm_token, $message, $extraData);

                            $saveData =  $this->M_admin->updateToFirbase($pr, "P", $message['body'], $message['title'], $type, $jobRequestId);
                        }
                    }
                }
            }
        }
    }
   function loadRatingList($id = 0)
    {   
        if($id)
            $id = $this->common_functions->decryptId($id);
        // echo $id;exit;
        $data['user_list']            =   $this->M_admin->getRatingList($id);
        // echo"<pre>"; print_r($data);exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/user_rating", $data);
        $this->load->view("admin/footer");
    }
    
    function getOrderDetailsByRating(){
        
        $id = $this->input->post('id');
        $id = $this->common_functions->decryptId($id);
        $job_details = $this->M_admin->getOrderDetailsByRating($id);
        $data['user_details']       =  $this->M_admin->getUserDetailsById($job_details->user_id);
        $data['provider_details']   =  $this->M_admin->getUserDetailsById($job_details->provider_id);
        $data['staff_details']      =  $this->M_admin->getUserDetailsById($job_details->staff_id);
        $data['job_details']        =  $job_details;
        return $this->load->view('admin/rating_job_details_ajax.php',$data);
    }
    
    function approveRating()
    {
        echo $result         =   $this->M_admin->approveRating($_POST);
    }
    function deleteRating()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        echo      $this->M_admin->deleteRating($id);
    }
    function viewersList()
    {
        $id    =      $this->common_functions->decryptId(trim($this->input->post("job_request_id")));

        $result =      $this->M_admin->getViewersList($id);
        if (count($result) > 0) {
            ?>
            <table border="0" cellspacing="0" cellpadding="0" id="example2" class="table table-striped table-bordered table-hover">
                <tr>
                    <td>Sl no</td>
                    <td>Image</td>
                    <td>Company name</td>
                    <td>Name</td>
                    <td>Time</td>
                </tr>
                <?php
                $i = 1;
                foreach ($result as $rows) {
                    $profileImage    =   $rows->user_image != "" ? base_url() . "uploads/user/" . $rows->user_image : base_url() . "images/user_dummy.png";
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><img src="<?php echo $profileImage; ?>" class="profileIcon"></td>
                        <td><?php echo $rows->company_name  ?>
                        <td><?php echo $rows->user_first_name . " " . $rows->user_last_name  ?></td>
                        <td><?php echo date("d-m-Y h:i A", strtotime($rows->first_viewed_time)) ?></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </table>
<?php
        } else {
            echo "No viewers so far";
        }
    }
    function homePageLabels()
    {
        $con['home_labels_status'] = 1;
        $data["labels"]        =   $this->M_admin->getHomeLabels($con);
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_home_labels", $data);
        $this->load->view("admin/footer");
    }
    function saveHomelabels()
    {
        $data['status']         =   $this->M_admin->saveHomelabels($_POST);
        echo json_encode($data);
        exit();
    }
    function confirmJob()
    {
        echo $data['status']         =   $this->M_admin->confirmJob($_POST);
        // echo json_encode($data);
        exit();
    }
    function userDetails()
    {
        $data['result']         =    $this->M_admin->userDetails($_POST);
        
        $userId         =     $this->common_functions->decryptId($_POST['id']);
        
        $condition = ['provider_id'=>$userId,'area.area_language_code'=>1];
        $areaList  = $this->db->select('area.area_name')->join('area','area.area_id=provider_areas.area_id','left')->where($condition)->get('provider_areas')->result();
        $data['areaList']=[];
        if(!empty($areaList))
            $data['areaList']=array_column($areaList, 'area_name');

        $this->load->view("admin/user_details_ajax", $data);
    }

    function check_default($array)
    {
        foreach ($array as $element) {
            if ($element == '0' || $element == "") {
                return FALSE;
            }
        }
        return TRUE;
    }
    public function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password)) {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        //      if (preg_match_all($regex_lowercase, $password) < 1)
        //      {
        //          $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
        //          return FALSE;
        //      }
        if (preg_match_all($regex_uppercase, $password) < 1 && preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one  letter.');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.');
            return FALSE;
        }
        if (strlen($password) < 8) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 20) {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 20 characters in length.');
            return FALSE;
        }
        return TRUE;
    }
    public  function check_inavlid_char($string = "")
    {
        $regex_special = '/[!@#$%^&*()\=+{};:<.>§~]/';


        if (preg_match_all($regex_special, $string) > 0) {
            $this->form_validation->set_message('check_inavlid_char', 'The {field} field contains invalid characters.');
            return FALSE;
        }
        return TRUE;
    }
    public function weight_check($val)
    {
        if (!is_numeric($val)) {
            $this->form_validation->set_message('weight_check', 'The {field} field must be number or decimal.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function percent_check($val)
    {
        if ($val > 100) {
            $this->form_validation->set_message('percent_check', 'The {field} field must be less than or equals 100.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function valid_url($url)
    {
        $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
        if (!preg_match($pattern, $url)) {
            return FALSE;
        }

        return TRUE;
    }
    function alpha_space($fullname)
    {
        if (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
            $this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & White spaces');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function custom_minlength_check($field_value = "")
    {
        $field_value = strip_tags($field_value);
        if (strlen($field_value) < 10) {
            $this->form_validation->set_message('custom_minlength_check', "Please enter atleast 10 characters");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getServiceProviders()
    {
        $job_request_id = $this->input->post('job_request_id');
        // echo $job_request_id;exit;
        $user_list            =   $this->M_admin->getProvidersListByServiceType($job_request_id);
        // echo $this->db->last_query();
        $user_list_options    = "<option value=''>select</option>";
        foreach ($user_list as $row) {
            $con['user_id'] = $row->user_id;
            $company  = $this->M_admin->getProvidersDetailsCondition($con);
            $userfull_name      = $company[0]->company_name;//$row->user_first_name . " " . $row->user_last_name;
            $user_list_options  .= "<option value='{$row->user_id}'>{$userfull_name}</option>";
        }
        echo ($user_list_options);
    }

    public function assignServiceProvider()
    {
        $status             = 0;
        $message            = "";
        $validationErrors   = [];
        $oData              = [];

        $this->form_validation->set_rules('service_provider', 'Service Provider', 'trim|required|numeric|xss_clean');

        if ($this->form_validation->run() == false) {
            $status           = 0;
            $message          = "validation Error";
            $validationErrors = array(
                'service_provider' => form_error('service_provider'),
            );
        } else {
            $request_id       = $this->common_functions->decryptId(trim($this->input->post("enc_request_id")));
            $post = $this->input->post();
            $assign_job_provider_id = $this->M_admin->assignServiceProvider($post);
           
            if($assign_job_provider_id > 0)
            {
                $jobRequestId = $this->input->post('job_request_id');
                $job_details  = $this->M_admin->getJobRequestDetailsByRequestId($jobRequestId);
                $service      = $this->M_admin->getServiceByJobRequestId($job_details->service_type_id);
                
                $con['user_id']  = $this->input->post('service_provider'); 
                $vendor_company  = $this->M_admin->getProvidersDetailsCondition($con);
                $vendor_data  = $this->M_admin->getUserDetailsById($this->input->post('service_provider'));
                // print_r($vendor_company);    print_r($vendor_data);exit;
                $title       =  "Job request assigned"; 
                $description =  "Hi ".$vendor_company[0]->company_name.',  the job request '.$job_details->job_request_display_id.'  is assigned to you by Vhelp';
                $notification_id =  time();
                $ntype       = "order-assigned";
                
                if (!empty($vendor_data->firebase_user_key)) {
                    
                    $notification_data["Notifications/".$vendor_data->firebase_user_key."/".$notification_id] = [
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
                
                if (! empty($vendor_data->fcm_token) ) {
                    $this->load->library("FCM_Notification");
                    $this->fcm_notification->send_single_notification($vendor_data->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "vendor_notification"],
                                ["type" => "order-placed",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $assign_job_provider_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }
                
                
                $user_details = $this->M_admin->getUserDetailsById($job_details->user_id);
                
                $title       =  "Vendor accepted job request"; 
                $description =  "Hi ".$user_details->user_first_name.' '.$user_details->user_last_name.', Your job request is accepted by '.$vendor_company[0]->company_name;
                $notification_id =  time();
                $ntype       = "order-accepted";
                
                if (!empty($user_details->firebase_user_key)) {
                    $notification_data["Notifications/".$user_details->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $job_details->job_request_id,
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
                                ["type" => "order-placed",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $job_details->job_request_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }
                
                
                $status           = 1;
                $message          = "Assigned Successfully";
            }else{
                $status           = 0;
                $message          = "Failed to asssign vendor";
            }
        }

        echo json_encode(["status" => $status, "message" => $message, "validationErrors" => $validationErrors, "oData" => $oData]);
    }

    function areaList()
    {
        $con = array();
        $data['area_list'] = $this->M_admin->getAreaList();
        // echo "<pre>";print_r($data);exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/area_list", $data);
        $this->load->view("admin/footer");
    }

    function deleteArea()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));

        echo      $this->M_admin->deleteArea($id);
    }

    function addEditArea()
    {

        $id  = $this->common_functions->decryptId($this->uri->segment(3));

        if ($id > 0) {
            $data['id']                            =       $id;
            $con['area_id']             =       $id;
            $con['area_language_code']             =       1;
            $data['records1']                =       $this->M_admin->getAreaCondition($con);
            $con['area_language_code']             =       2;
            $data['records2']                =       $this->M_admin->getAreaCondition($con);
        }

        $data['city_list']            =   $this->M_admin->getCityList(1,['city_status'=>1]);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_area", $data);
        $this->load->view("admin/footer");
    }

    function saveArea()
    {
        $data = array();

        $this->form_validation->set_rules('txtEnglish', 'City Name English', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtArabic', 'City Name Arabic', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('city_id', 'City', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic' => form_error('txtArabic'),
                'city_id' => form_error('city_id'),
            );
            echo json_encode($data);
            exit();
        }

        $inputArray['area_name']           =    $_POST['txtEnglish'];
        $inputArray['area_language_code']  =    1;
        $inputArray['city_id']             =    $_POST['city_id'];
        $inputArray['area_status']         =    $_POST['txtStatus'];
        $inputArray['area_created_date']   =    gmdate("Y-m-d H:i:s");
        $inputArray2                       =    $inputArray;
        $inputArray2['area_name']          =    ($_POST['txtArabic'] != "" ? $_POST['txtArabic'] : $_POST['txtEnglish']);
        $inputArray2['area_language_code'] =    2;

        if (isset($_POST['area_id']) && $_POST['area_id'] > 0) {
            $inputArray['area_id']              =     $_POST['area_id'];
            $inputArray2['area_id']           =     $_POST['area_id'];
            unset($inputArray['area_created_date']);
            unset($inputArray2['area_created_date']);
        }

        /**
         * changes by jitin on 26 sep 18 for xss filtering
         */
        $inputArray = $this->security->xss_clean($inputArray);
        $inputArray2 = $this->security->xss_clean($inputArray2);

        $result  =    $this->M_admin->saveMasterTable($inputArray, $inputArray2, 'area_id', 'area_language_code', 'area');
        $data['status'] = $result;
        echo json_encode($data);
    }



    public function faq_list()
    {
        $condition = array("user_type" => "D");
        $data["data_list"] = $this->M_admin->get_faq_list();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/faq_list", $data);
        $this->load->view("admin/footer");
    }

    public function add_edit_faq()
    {
        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);

        $data = array();

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_faq", $data);
        $this->load->view("admin/footer");
    }

    public function save_faq()
    {
        $this->form_validation->set_rules('txt_title_english', 'Title English', 'trim|required');
        $this->form_validation->set_rules('txt_title_arabic', 'Title English', 'trim|required');
        $this->form_validation->set_rules('txt_descp_english', 'Article English', 'trim|required');
        $this->form_validation->set_rules('txt_descp_arabic', 'Article Arabic', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_title_english' => form_error('txt_title_english'),
                'txt_title_arabic' => form_error('txt_title_arabic'),
                'txt_descp_english' => form_error('txt_descp_english'),
                'txt_descp_arabic' => form_error('txt_descp_arabic'),
            );
            echo json_encode($data);
            exit();
        }

        $_POST = $this->security->xss_clean($_POST);

        $id = (int) $this->input->post("id", true);

        $i_data["faq_title"] = $_POST["txt_title_english"];
        $i_data["faq_description"] = $_POST["txt_descp_english"];
        $i_data["faq_title_arabic"] = $_POST["txt_title_arabic"];
        $i_data["faq_description_arabic"] = $_POST["txt_descp_arabic"];
        $i_data["status"] = $_POST["txtStatus"];
        $i_data["updated_at"] = gmdate("Y-m-d H:i:s");
        $meta['meta_title'] = $_POST['txt_meta_title'];
        $meta['meta_keyword'] = $_POST['txt_meta_keyword'];
        $meta['meta_description'] = $_POST['txt_meta_description'];

        if ($id > 0) {
            $result = $this->M_admin->update_faq($i_data, ["faq_id" => $id]);
            $this->M_admin->update_faq_meta_data($meta);
        } else {
            $i_data['meta_title'] = $_POST['txt_meta_title'];
            $i_data['meta_keyword'] = $_POST['txt_meta_keyword'];
            $i_data['meta_description'] = $_POST['txt_meta_description'];
            $result = $this->M_admin->create_faq($i_data);
            $result = ($result > 0) ? 1 : 0;
        }

        $data['status'] = $result;
        echo json_encode($data);
    }

    public function delete_faq()
    {
        $id = $_POST['id'];
        echo $this->M_admin->delete_faq($id);
    }

    public function appSlider()
    {

        $data["slider_list"]        =   $this->M_admin->getAppSliderList();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/app_slider_list", $data);
        $this->load->view("admin/footer");
    }

    public function addEditSlider($slider_id = 0)
    {
        $data['service_list'] = $this->M_admin->getServiceList();
        $data['id'] = $this->common_functions->decryptId($slider_id);
        // echo "<pre>"; print_r($data['service_list']);exit();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_slider", $data);
        $this->load->view("admin/footer");
    }

    public function saveAppSlider()
    {
        $this->form_validation->set_rules('txtEnglish', 'Email address', 'trim|required');
        $this->form_validation->set_rules('txtArabic', 'Email address', 'trim|required');
        if ($this->form_validation->run() == false) {
            $status           = 0;
            $message          = "validation Error";
            $validationErrors = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic'  => form_error('txtArabic'),
            );
        } else {

            $inputData = array(
                'slider_title' => $this->input->post('txtEnglish'),
                'slider_title_arabic' => $this->input->post('txtArabic'),
                'slider_service_type' => $this->input->post('service_type'),
                'slider_status'       => 1,
            );
            //   print_r($this->input->post('service_type'));exit();

            if ($_FILES["txtFile3"]["name"] != "") {
                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
                $filename2 = $_FILES["txtFile3"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
                $config2['upload_path']          =   $this->config->item('upload_path') . 'app_slider/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;
                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                // $this->upload->initialize($config2);
                if (!$this->upload->do_upload('txtFile3')) {
                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txtFile3' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $inputData['slider_image']                 =   $config2['file_name'];
                }
            }

            $slider_id = $this->input->post('slider_id');
            // print_r($inputData);exit();
            $result = $this->M_admin->saveAppSlider($inputData, $slider_id);
            // echo $this->db->last_query();exit();
            if ($result) {
                $status   = 1;
                if ($slider_id)
                    $message  = 'Slider updated Successfully...';
                else
                    $message  = 'Slider added Successfully...';
            } else {
                if ($slider_id)
                    $message  = 'Faild to update slider...';
                else
                    $message  = 'Faild to add slider...';
            }
        }

        echo json_encode(["status" => $status, "message" => $message, "validationErrors" => $validationErrors, "oData" => $oData]);
    }
    
    
    public function listCoupon(){

        $data['coupon_list'] = $this->M_admin->getCouponDetails();
        // print_r($data);exit;
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/list_coupon", $data);
        $this->load->view("admin/footer");

    }

    public function addEditCoupon(){

        $language = ($this->session->userdata('language') ? $this->session->userdata('language') : 1);
        $condition = array('service_type_language_code' => $language, 'service_type_status' => 1);
        $data["service_list"] = $this->M_admin->getServiceListByCondition($condition);
        // echo "<pre>";   print_r($data);exit;

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar", ["segment" => "list_coupon"]);
        $this->load->view("admin/add_edit_coupon", $data);
        $this->load->view("admin/footer");
    }
    
    public function coupon_exists()
    {
        $id = (int)$this->input->post('id',true);
        if($id)
            $this->db->where(['coupon_id <>'=>$id]);
        $coupon_code = strtolower($this->input->post('txt_code',true));
        $codeExists = $this->db->where(['LOWER(coupon_code)'=>$coupon_code])->get('coupon')->num_rows();
        if($codeExists)
        {
            $this->form_validation->set_message('coupon_exists', 'This coupon code already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    
    }

    public function saveCoupon()
    {
        $this->form_validation->set_rules('txt_title', 'Title', 'trim|required');
        $this->form_validation->set_rules('txt_code', 'Coupon Code', 'trim|required|callback_coupon_exists');
        $this->form_validation->set_rules('txt_coupon_desc', 'Description', 'trim|required');
        // $this->form_validation->set_rules('txt_discount_type', 'Discount type', 'trim|required');
        $this->form_validation->set_rules('txt_coupon_amount', 'Coupon Amount', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]');
        $this->form_validation->set_rules('txt_expiry_date', 'Expiry Date', 'trim|required');
        $this->form_validation->set_rules('txt_limit_per_coup', 'Limit per coupon', 'trim|numeric');
        $this->form_validation->set_rules('txt_limit_user', 'Limit Per User', 'trim|numeric');

        if ($this->form_validation->run() == false) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_title' => form_error('txt_title'),
                'txt_code' => form_error('txt_code'),
                'txt_coupon_desc' => form_error('txt_coupon_desc'),
                'txt_discount_type' => form_error('txt_discount_type'),
                'txt_coupon_amount' => form_error('txt_coupon_amount'),
                'txt_expiry_date' => form_error('txt_expiry_date'),
                'txt_minimum_spend' => form_error('txt_minimum_spend'),
                'txt_maximum_spend' => form_error('txt_maximum_spend'),
                'txt_limit_user' => form_error('txt_limit_user'),
                'txt_limit_X_coup' => form_error('txt_limit_X_coup'),
                'txt_limit_per_coup' => form_error('txt_limit_per_coup'),
            );
            echo json_encode($data);
            exit();
        }
        // print_r($_POST);
        $_POST = $this->security->xss_clean($_POST);
        if (count($_POST) > 0) {
            $result = $this->M_admin->saveCoupon($_POST);
            $data['status'] = $result;
            echo json_encode($data);
        }
    }
    
    
    public function assignJobToProvider(){

        $output['status']       = 0;
        $output['message']      = "";

        $assign_job_provider_id = $this->input->post('assign_job_provider_id');

        $job_details            = $this->M_admin->getProviderJobDetails($assign_job_provider_id);

        if ($job_details) {
            $result = $this->M_admin->assignJobToProvider($assign_job_provider_id,$job_details->job_request_id,$job_details->provider_id);
            
                
            // print_r($job_details);exit;
            if($result){
                $output['status']       = 1;
                $output['message']      = "Job assigned to vendor sccessfully";
                
                $vendor_data  = $this->M_admin->getUserDetailsById($job_details->provider_id);
                $user_details = $this->M_admin->getUserDetailsById($job_details->user_id);
                $service      = $this->M_admin->getServiceByJobRequestId($job_details->service_type_id);

                $vendor_data = $this->M_admin->get_vendor_data_by_id($job_details->provider_id);

                $title       =  "Vendor accepted job request"; 
                $description =  "Hi ".$user_details->user_first_name." ".$user_details->user_last_name.", Your job request is accepted by ".$vendor_data->company_name;
                $notification_id =  time();
                $ntype       = "order-accepted";

                if (!empty($user_details->firebase_user_key)) {
                    $notification_data["Notifications/".$user_details->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $job_details->job_request_id,
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
                                ["type" => "order-placed",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $job_details->job_request_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }

                $con['user_id']  = $job_details->provider_id;
                $vendor_company  = $this->M_admin->getProvidersDetailsCondition($con);
                $vendor_data  = $this->M_admin->getUserDetailsById($job_details->provider_id);
                // print_r($vendor_company);    print_r($vendor_data);exit;
                $title       =  "Job request assigned"; 
                $description =  "Hi ".$vendor_company[0]->company_name.',  the job request '.$job_details->job_request_display_id.'  is assigned to you by Vhelp';
                $notification_id =  time();
                $ntype       = "order-assigned";
                
                if (!empty($vendor_data->firebase_user_key)) {
                    
                    $notification_data["Notifications/".$vendor_data->firebase_user_key."/".$notification_id] = [
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
                
                if (! empty($vendor_data->fcm_token) ) {
                    $this->load->library("FCM_Notification");
                    $this->fcm_notification->send_single_notification($vendor_data->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "vendor_notification"],
                                ["type" => "order-placed",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $assign_job_provider_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }
                    
                /*
                if(!empty($vendor_data->fcm_token)){
                    $title          = "Job assigned";
                    $description    = "You have assigned job request".$job_details->job_request_display_id ."by admin";
                    $notification_data["Notifications/".$vendor_data->firebase_user_key."/".$notification_id] = [
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

                if (! empty($vendor_data->fcm_token) ) {
                    $this->load->library("FCM_Notification");
                    $this->fcm_notification->send_single_notification($vendor_data->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "vendor_notification"],
                                ["type" => "order-placed",
                                "notificationID" => $notification_id,
                                "orderID" => (string) $assign_job_provider_id,
                                "service_type_name" => $service->service_type_name,
                                "imageURL" => ""
                    ]);
                }*/
            }else{
                $output['message']      = "Failed to assign vendor";
            }   
        }else{
            $output['message']      = "Invalid vendor details";
        } 
        echo json_encode($output);
    }
    
    function deleteAppSlider()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        $result = $this->db->where(['slider_id'=>$id])->delete('app_slider');

        if($result)
            echo 1;
        else
            echo 0;
    }
    
    function deleteCoupon()
    {
        $id   = $this->input->post("id");
        $result = $this->db->where(['coupon_id'=>$id])->delete('coupon');

        if($result){
            echo 1;
        }
        else
            echo 0;
    }
    
    public function staffs_list()
    {
        $provider_id = $this->common_functions->decryptId($this->uri->segment(2));
        $data = [];

        $condition = ['user_table.user_type'=>3,'vendor_id'=>$provider_id];

        $data['staffs_list'] = $this->M_admin->getStaffsList($condition);
        $data['provider_id'] = $provider_id;

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar", ["segment" => "staffs-list"]);
        $this->load->view("admin/staffs_list", $data);
        $this->load->view("admin/footer");
    }
    
    public function getProviderStaffs()
    {
        $assign_job_provider_id = $this->input->post('assign_job_provider_id',true);
        $job_details            = $this->M_admin->getProviderJobDetails($assign_job_provider_id);
        $staff_list = $this->M_admin->getUsersListByVendor($job_details->provider_id);

        $html = '<option value="">Select Staff</option>';

        if(!empty($staff_list))
        {
            foreach ($staff_list as $value) {
                $html .= '<option value="'.$value->user_id.'">'.$value->user_first_name.' '.$value->user_last_name.'</option>';
            }
        }

        echo $html;
    }
    
    public function assignStaff()
    {
        $output = [];
        $staff_id = $this->input->post('staff_id',true);
        $assign_job_provider_id = $this->input->post('assign_job_provider_id',true);
        $job_details            = $this->M_admin->getProviderJobDetails($assign_job_provider_id);

        $data = array('staff_id' => $staff_id, 
                        'job_request_id' => $job_details->job_request_id,
                        'job_status' => 0,
                        'job_assigned_at' => date('Y/m/d H:i:s')
                      );
        $this->load->model('website/M_user');
        $result = $this->M_user->assignStaff($data);

        if($result==1){
                
            $jobRequestId = $job_details->job_request_id;
            $job_details  = $this->M_admin->getJobRequestDetailsByRequestId($jobRequestId);
            $service      = $this->M_admin->getServiceByJobRequestId($job_details->service_type_id);
            
            $con['user_id']  = $staff_id;
            $vendor_data     = $this->M_admin->getUserDetailsById($staff_id);
            $staff_full_name = $vendor_data->user_first_name ." ".$vendor_data->user_last_name;

            $title              = "Job request received"; 
            $description        = "Hi ".$staff_full_name.',  you have received a new request from Vhelp';
            $notification_id    = time();
            $ntype              = "request-recieved";
            
            if (!empty($vendor_data->firebase_user_key)) 
            {
                $notification_data["Notifications/".$vendor_data->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                                "orderID" => (string) $jobRequestId,
                                "service_type_name" => $service->service_type_name,
                                "url" => "",
                                "imageURL" => "",
                                "read" => "0",
                                "seen" => "0"
                            ];
    
                    $fb_database = get_firebase_refrence();
                    $fb_database->getReference()->update($notification_data);
            }
            if (! empty($vendor_data->fcm_token) ) {
                $this->load->library("FCM_Notification");
                $this->fcm_notification->send_single_notification($vendor_data->fcm_token, [
                            "title" => $title,
                            "body" => $description,
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => "staff_notification"],
                            ["type" => "order-placed",
                            "notificationID" => $notification_id,
                            "orderID" => (string) $jobRequestId,
                            "service_type_name" => $service->service_type_name,
                            "imageURL" => ""
                ]);
            }
            
        }
        
        if ($result == 1 ) {
            $output['status'] = 1;
            $output['message']= 'Staff assigned to job';
        }
        else if($result == -1 )
        {
            $output['status'] = 0;
            $output['message']= 'Job already assigned to staff.';
        }
        else
        {
            $output['status'] = 0;
            $output['message']= 'Failed to assign staff';
        }
        
        echo json_encode($output);
    }
    
    public function addEditStaff($provider_id=0,$id=0)
    {
        $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
        $id                  =  ($id) ? $this->common_functions->decryptId(trim($id)) : 0;

        $data = [];
        $data['row'] = "";
        
        if($id)
            $data['row'] = $this->db->where(['user_id'=>$id])->get('user_table')->row();

        $data['provider_id']    = $provider_id;
        $data['id']             = $id;
        $data['country_list']                = $this->M_common->getCountries($language,0,1);

        $this->load->view("admin/header");
        $this->load->view("admin/sidebar", ["segment" => "staffs-list"]);
        $this->load->view("admin/add_edit_staff", $data);
        $this->load->view("admin/footer");
    }

    function saveStaff()
    {
        $user_id    =  $this->input->post('id');
        $vendor_id  =  $this->input->post('provider_id');

        $this->form_validation->set_rules('fname', 'First name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('lname', 'Last name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('emirates_id', 'Emirates ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('passport_id', 'Passport ID', 'trim|required|xss_clean');

        if(!$user_id)
        {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[user_table.user_email]');
            $this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean|is_unique[user_table.user_phone]');
            $this->form_validation->set_rules('staff_password', 'Password', 'trim|required|xss_clean');
        }

        if ($this->form_validation->run() == false)
        {
          $output['errors'] = array('fname' => form_error('fname'), 
                                 'lname' => form_error('lname'),
                                 'emirates_id' => form_error('emirates_id'),
                                 'passport_id' => form_error('passport_id')
                              );
          if(!$user_id){
            $output['errors']['email']    = form_error('email');
            $output['errors']['phone_no'] = form_error('phone_no');
            $output['errors']['staff_password'] = form_error('staff_password');
          }
          $output['status'] = 0;
        }
        else
        {
            $data = array('user_first_name' => $this->input->post('fname'), 
                        'user_last_name'  => $this->input->post('lname'),
                        'user_email'      => $this->input->post('email'),
                        'country_id'      => $this->input->post('country_id'),
                        'user_dial_code'  => $this->input->post('dial_code'),
                        'user_phone'      => $this->input->post('phone_no'),
                        'emirates_id'     => $this->input->post('emirates_id'),
                        'passport_id'     => $this->input->post('passport_id'),
                        'user_type'       => 3,
                        
                        'vendor_id'       => $vendor_id,
                        'user_created_by' => $this->session->userdata('eq_user_id'),
                        'user_created_time'=> gmdate('Y/m/d H:i:s')
                      );

            if(!$user_id)
                $data['user_status'] = 1;

            $save_password = $this->input->post('save_password',true);       

            if($this->input->post('staff_password',true) && $save_password==1)
                $data['user_password'] =MD5($this->input->post('staff_password',true));
            
            
          if($_FILES["image"]["name"]!=""){
            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$this->session->userdata('eq_user_id')."PF".date("Ymdhis");
            $filename2 = $_FILES["image"]["name"];
            $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);

            $config2['upload_path']          =  $this->config->item('upload_path').'user/';
            $config2['allowed_types']        =  'gif|jpg|png|pdf|doc|jpeg';
            $config2['file_name']            =  $randomNo.".".$file_ext2;

            $this->load->library('upload', $config2);
            $this->upload->initialize($config2);

            if ( ! $this->upload->do_upload('image')){
              $output['status']                =  "0";
              $output['message']               =  "Profile image upload failed"; 
              echo json_encode($output);
              exit;
            }else{
              $data['user_image']  =  $config2['file_name'];
            }
          }
          $this->load->model('website/M_user');
          $result = $this->M_user->saveUserDetails($data,$user_id);
          if($result){
            $output['status'] = "1";
            if($user_id)
              $output['message']= "Staff  data updated... ";
            else
              $output['message']= "Staff created successfully...";
            }else{
              $output['status'] = '0';
              $output['message']= 'Failed to save staff details...';
            }

        } 

        echo json_encode($output);
     }

    function deleteStaff()
    {
        $id                  =   $this->common_functions->decryptId(trim($this->input->post("id")));

        $job_list = $this->db->where(['staff_id'=>$id])->get('staff_jobs')->num_rows();

        if($job_list)
            echo 2;
        else
            echo  $result          =   $this->M_admin->deleteStaff($id);
    }
    
    function staffDetails()
    {
        $userId    = $this->common_functions->decryptId($_POST['id']);
        $condition = ['user_table.user_id'=>$userId];

        $data['result']         =    $this->M_admin->getStaffDetails($condition)->row();

        $this->load->view("admin/staff_details_ajax", $data);
    }
    
    public function deleteHowItsWork(){
        $h_id = $this->input->post('h_id');

        $result = $this->M_admin->deleteHowItsWork($h_id);
        echo $result;
    }
    
    public function deleteBanerImage(){
        $postvalues = $this->input->post();
        $output['status'] = 0;
        if(!empty($postvalues)) {
            $service_type_id              = $postvalues['serviceid'];
            $service_type_baner_image   = $postvalues['id'];
            $this->M_admin->deleteBannerImage($service_type_baner_image,$service_type_id);
            $output['status'] = 1;

        }  
        echo json_encode($output);
        exit; 
        
    }
    public function manageWallet($id) 
    {
  /*      
        if ($id > 0) {
            $data['id']                            =       $id;
            
            $data['user_details']         =      $this->M_admin->getUsersDetailsCondition($con);
        }
        $data['country_list']           = $this->M_admin->getCountries(1, 0, 1);*/
        $id                                 =      $this->common_functions->decryptId($this->uri->segment(3));
        $data['user_id']                    =      $id;
        $data['user_basic']                 =      $this->M_admin->getUsersCondition($data);
        $data['user_basic']                 =      array_shift($data['user_basic'] );
        $data['wallet_log']                 =      $this->M_admin->getWalletLog($data['user_id']);
        $data['trasnStatus']                =      $this->wstatus;  
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/manage_wallet", $data);
        $this->load->view("admin/footer");
    }

    public function saveWallet()
    {
        
        //exit;
        $this->form_validation->set_rules('txt_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('txt_user_id', 'User', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['errors'] = array(
                'txt_amount' => form_error('txt_amount'),
                'user_token' => form_error('user_token'),
                
            );
            echo json_encode($data);
            exit();
        } else {
            $input = $this->security->xss_clean($_POST);
            $input['created_by']    =   $_SESSION['admin_id'];
            $input['created_at']     =   date('Y-m-d H:i:s');
            $this->load->library("Common_functions");
            $randomString =  $this->common_functions->incrementalHash(2);
                    
            $firstString = "C";
        
        
            $input['transaction_id']  =           $firstString.$randomString.$insertdata['user_id'].date("mdHis");
            $$insertId =$this->M_admin->insertWalletData($input);
            $output['status']                =  "1";
            $output['message']               =  "User wallet saved successfully";
            $user_basic                      =   $this->M_admin->getUsersCondition(array('user_id'=>$input['txt_user_id'])); 
            $user_basic                     =   array_shift($user_basic);

            /**Push notiifcation*/
            $notification_id    = time();
            $ntype              = "wallet";
            $title       =  "Wallet recharge"; 
                $description =  "Hi ".$user_basic->user_first_name.' '.$user_basic->user_last_name .", Vhelp has added amount ".$this->config->item('currency')." ".$input['txt_amount']." in your wallet";

                if (!empty($user_basic->firebase_user_key)) {
                    $notification_data["Notifications/".$user_basic->firebase_user_key."/".$notification_id] = [
                                "title" => $title,
                                "description" => $description,
                                "notificationType" => $ntype,
                                "createdAt" => $input['created_at'] ,
                                "orderID" => (string) $input['transaction_id'],
                               
                                "url" => "",
                                "imageURL" => "",
                                "read" => "0",
                                "seen" => "0"
                            ];

                    $fb_database = get_firebase_refrence();
                    $fb_database->getReference()->update($notification_data);
                }
                if (! empty($user_basic->fcm_token) ) {
                    $this->load->library("FCM_Notification");
                    $this->fcm_notification->send_single_notification($user_basic->fcm_token, [
                                "title" => $title,
                                "body" => $description,
                                "icon"=>'myicon',
                                "sound" =>'default',
                                "click_action" => "notification"],
                                ["type" => $ntype,
                                "notificationID" => $notification_id,
                                
                                "orderID" => (string) $input['transaction_id'], 
                               
                               
                    ]);
                }
  
             /**Push notiifcation*/


            $output['balance']  = $user_basic->wallet_balance ;
            $output['cols']     =   sprintf('<tr><td>Transaction ID: %s <p>%s</p></td>
                                       <td>%s %s</td>
                                        <td></td>
                                        
                                                                              

                                    </td></tr>',$input['transaction_id'],date('M d,Y h:i A',strtotime($input['created_at'])) ,$this->config->item('currency'), $input['txt_amount']
                                    );
            echo json_encode($output);
            exit;
          
        }

    }

    public function deleteHomepageBanner()
    {
        $postValues = $this->input->post(); 
        $checkExist = $this->M_admin->getServiceTypes2(1,$postValues['id']); 
        $output['status'] = 0;
        if(!empty($checkExist)) {
            $updateArr = array('homepage_banner'=>"");
            $this->M_admin->updateSeviceType($postValues['id'],$updateArr);
            $output['status'] = 1;

        }  
        echo json_encode($output);
        exit; 
    }
    
public function promotionSlider()
    {

        $data["slider_list"]        =   $this->M_admin->getPromotionSliderList(); 
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/promotion_slider_list", $data);
        $this->load->view("admin/footer");
    }
    public function addEditpromotionSlider($slider_id = 0)
    {
        $data['service_list'] = $this->M_admin->getServiceList();
        $data['id'] = $this->common_functions->decryptId($slider_id);
        // echo "<pre>"; print_r($data['service_list']);exit();
        $this->load->view("admin/header");
        $this->load->view("admin/sidebar");
        $this->load->view("admin/add_edit_promotion_slider", $data);
        $this->load->view("admin/footer");
    }
    public function savePromotionSlider()
    {
        $this->form_validation->set_rules('txtEnglish', 'Email address', 'trim|required');
        $this->form_validation->set_rules('txtArabic', 'Email address', 'trim|required');
        if ($this->form_validation->run() == false) {
            $status           = 0;
            $message          = "validation Error";
            $validationErrors = array(
                'txtEnglish' => form_error('txtEnglish'),
                'txtArabic'  => form_error('txtArabic'),
            );
        } else {

            $inputData = array(
                'slider_title' => $this->input->post('txtEnglish'),
                'slider_title_arabic' => $this->input->post('txtArabic'),
                'slider_service_type' => $this->input->post('service_type'),
                'slider_status'       => 1,
            );
            //   print_r($this->input->post('service_type'));exit();

            if ($_FILES["txtFile3"]["name"] != "") {
                $digits   =  6;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . date("YmdHis");
                $filename2 = $_FILES["txtFile3"]["name"];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
                $config2['upload_path']          =   $this->config->item('upload_path') . 'app_slider/';
                $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                //$config2['max_size']                 =   1000;
                // $config2['max_width']             =   1024;
                // $config2['max_height']            =   768;                                    
                $config2['file_name']                =  $randomNo . "." . $file_ext2;
                //$this->load->library('upload', $config2);
                $this->load->library('upload', $config2);
                // $this->upload->initialize($config2);
                if (!$this->upload->do_upload('txtFile3')) {
                    //die("file upload failed");
                    $data['status'] = 0;
                    $data['errors'] = array(
                        'txtFile3' => "File upload failed",
                    );
                    echo json_encode($data);
                    exit();
                } else {
                    $inputData['slider_image']                 =   $config2['file_name'];
                }
            }

            $slider_id = $this->input->post('slider_id');
             //print_r($inputData);exit();
            $result = $this->M_admin->savePromotionSlider($inputData, $slider_id);
            // echo $this->db->last_query();exit();
            if ($result) {
                $status   = 1;
                if ($slider_id)
                    $message  = 'Slider updated Successfully...';
                else
                    $message  = 'Slider added Successfully...';
            } else {
                if ($slider_id)
                    $message  = 'Faild to update slider...';
                else
                    $message  = 'Faild to add slider...';
            }
        }

        echo json_encode(["status" => $status, "message" => $message, "validationErrors" => $validationErrors, "oData" => $oData]);
    }

    function deletePromotionSlider()
    {
        $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));
        $result = $this->db->where(['slider_id'=>$id])->delete('promotion_slider');

        if($result)
            echo 1;
        else
            echo 0;
    }
    function changePromotionSliderStatus(){
        echo $result = $this->M_admin->changPromotionSliderStatus($_POST);
    }
    

}

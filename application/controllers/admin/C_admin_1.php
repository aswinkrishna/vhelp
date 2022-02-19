<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller 
{
    public function __construct()
     {
         parent::__construct();
         $this->load->model('M_admin');
         //$this->lang->load("message","arabic");
        // error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
        error_reporting(E_ERROR | E_PARSE);
     }
   public function index()
    {
            
             
            $this->load->view("admin/login");
            

    }
    function login()
    {

          //print_r($_POST);

          $data   =     array('admin_user_email' => $_POST['username'],'admin_user_password'=>MD5($_POST['password']),'admin_user_status'=>1);       

          $result =    $this->M_admin->login($data);   
          //print_r($result);

          if($result=="")
          {
                  

                    echo   0;

          }
          else
          {

                  if($result->admin_user_email!="")
                  {

                           echo   1 ;
                           
                           //$this->session->sess_destroy();
                           
                           $this->session->unset_userdata('admin_email');
                           $this->session->unset_userdata('admin_id');
                           $this->session->unset_userdata('admin_name');
                           $this->session->unset_userdata('user_type');
                           $this->session->unset_userdata('admin_display_name');
                           $this->session->unset_userdata('admin_designation');
                           $this->session->unset_userdata('user_id');
                           
                           
                           $this->session->set_userdata("admin_email",$result->admin_user_email);
                           $this->session->set_userdata("admin_id",$result->admin_user_id);
                           $this->session->set_userdata("admin_name",$result->admin_user_name);
                           $this->session->set_userdata("user_type","A");
                           $this->session->set_userdata("admin_display_name",$result->admin_first_name." ".$result->admin_last_name);
                           $this->session->set_userdata("admin_designation",$result->designation_id);
                           
                  }
                  else
                  {
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
             $this->load->view("admin/user_list",$data);
             $this->load->view("admin/footer");
     }
     function addEditUser()
     {
             $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
             if($id>0)
             {
                  $data['id']                            =       $id;
                  $con['user_id']                   =       $id;                  
                  $data['user_basic']            =      $this->M_admin->getUsersCondition($con);  
                  $data['user_details']         =      $this->M_admin->getUsersDetailsCondition($con);  
                  
                 
                 
             }
             $data['country_list']           = $this->M_admin->getCountries(1,0,1);            
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/add_edit_user",$data);
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
       $this->form_validation->set_rules('txt_password', 'Password', 'trim|required|min_length[8]|max_length[20]|callback_valid_password');
        $this->form_validation->set_rules('select_country', 'Country', 'trim|required');
       $this->form_validation->set_rules('select_city', 'City', 'trim|required');
       $this->form_validation->set_rules('txt_phone', 'Phone', 'trim|required|numeric|min_length[5]|max_length[15]|xss_clean');
       $this->form_validation->set_rules('txt_zip', 'Zip code', 'trim|required|numeric|min_length[4]|max_length[6]|xss_clean');
       $this->form_validation->set_rules('txt_building', 'Building Name', 'trim|required|max_length[100]|callback_check_inavlid_char');
       $this->form_validation->set_rules('txt_apprtment', 'Appartment Name', 'trim|required|max_length[100]|callback_check_inavlid_char');
       $this->form_validation->set_rules('txt_area', 'Area', 'trim|required|max_length[100]|callback_check_inavlid_char');
        if(empty($_FILES['txt_profile']['name']) && $this->input->post("txt_user_id")<=0){
        $this->form_validation->set_rules('txt_profile','Upload Profile','trim|required');
       }
       
       if ($this->form_validation->run() == FALSE) 
           {
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
        } 
        else
        {
            
            
            
            if($_FILES["txt_profile"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                   
                                    $filename2 = $_FILES["txt_profile"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =   $this->config->item('upload_path').'user/';
                                    $config2['allowed_types']       =   'gif|jpg|png|jpeg';
                                    //$config2['max_size']                 =   1000;
                                   // $config2['max_width']             =   1024;
                                   // $config2['max_height']            =   768;                                    
                                    $config2['file_name']                =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
	             $this->load->library('upload', $config2);
                                    // $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('txt_profile'))
                                   {
                                       
                                       //die("file upload failed");
                                        $data['status'] = 0;
                                        $data['errors'] = array(
                                         'txt_profile' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $input['user_image']                 =   $config2['file_name'];
                                      
                                  }
				 
			 }
            
            
		
                                            $_POST = $this->security->xss_clean($_POST);  
                                            
                                             $input['user_first_name']                    =                 trim($this->input->post("txt_first_name"));
                                             $input['user_last_name']                     =                 trim($this->input->post("txt_last_name"));
                                             $input['user_email']                              =                 trim($this->input->post("txt_email"));
                                             $input['user_password']                      =                 MD5($this->input->post("txt_password"));
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
                                             if($this->input->post("txt_user_id")>0)
                                             {
                                                 unset($input['user_email']);
                                                 unset($input['user_password']);
                                                 $input['user_id']                                 =                 trim($this->input->post("txt_user_id"));
                                                 $input['user_updated_by']              =                 $input['user_id'] ;
                                                 $input['user_updated_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                             else
                                             {
                                                 $input['user_created_by']              =                 0;
                                                 $input['user_created_time']          =                 gmdate("Y-m-d H:i:s");
                                             }
                                             
                                             
                                             
                                                    
                                            
		  if(count($_POST)>0)
		  {
			    
			 $result         =   $this->M_admin->saveUser($input,$input2);	
				
			  
		  }else
		  {
			  
			  $result= 0 ;	
			  
		  }
		  $data['status'] = $result;
                                           echo json_encode($data);
       
        }
     }
     function loadCityDropDown()
     {
             $language   =  ($this->session->userdata('language')?$this->session->userdata('language'):1);
             $condition  =   array('city_language_code' => $language,'city_status'=>1,'city_country_id'=>$_POST['countryId']);
             $cityList   =   $this->M_admin->getCitiesCondition($condition);
			 
                             if(isset($cityList) && count($cityList)>0)
                             {
								 ?>
                                       
                                        <option value="" >Select</option>
                                       
                                       <?php
                              foreach($cityList as $rows) 
                                    {

                            ?>
                                       
                                        <option value="<?php echo $rows->city_id; ?>" ><?php echo $rows->city_name; ?></option>
                                       
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
     function countryList()
     {
            $con                                         =    array();
            $data['country_list']            =   $this->M_admin->getCountries(1,0,0);               
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/country_list",$data);
             $this->load->view("admin/footer");
     }
     function addEditCountry()
     {
         
             $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
             
             if($id>0)
             {
                  $data['id']                            =       $id;
                  $con['country_id']             =       $id;                  
                 $data['records1']                =       $this->M_admin->getCountries(1,$id);
                 $data['records2']                =       $this->M_admin->getCountries(2,$id);
                  
                 
                 
             }
                      
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/add_edit_country",$data);
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
             $inputArray['country_created_date']            =    gmdate("Y-m-d H:i:s");
             $inputArray2                                 =    $inputArray;
             $inputArray2['country_name']                 =    ($_POST['txtArabic']!=""?$_POST['txtArabic']:$_POST['txtEnglish']);
             $inputArray2['country_language_code']        =    2;






             if(isset($_POST['txt_country_id']) && $_POST['txt_country_id']>0)             
             {
                     $inputArray['country_id']            =     $_POST['txt_country_id'] ;
                     $inputArray2['country_id']           =     $_POST['txt_country_id'] ;
                     unset($inputArray['country_created_date']);
                     unset($inputArray2['country_created_date']);
             }

          //  print_r($inputArray);
          /**
           * changes by jitin on 26 sep 18 for xss filtering
           */
          $inputArray = $this->security->xss_clean($inputArray);
          $inputArray2 = $this->security->xss_clean($inputArray2);
          
           $result =    $this->M_admin->saveMasterTable($inputArray,$inputArray2,'country_id','country_language_code','country');
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
             $this->load->view("admin/city_list",$data);
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
             
             if($id>0)
             {
                  $data['id']                            =       $id;
                  $con['country_id']             =       $id;                  
                 $data['records1']                =       $this->M_admin->getCities(1,$id);
                 $data['records2']                =       $this->M_admin->getCities(2,$id);
                  
                 
                 
             }
             
            $data['country_list']            =   $this->M_admin->getCountries(1,0,1);       
                      
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
            $this->load->view("admin/add_edit_city",$data);
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
             $inputArray['city_created_date']            =    gmdate("Y-m-d H:i:s");
             $inputArray2                                                 =    $inputArray;
             $inputArray2['city_name']                         =    ($_POST['txtArabic']!=""?$_POST['txtArabic']:$_POST['txtEnglish']);
             $inputArray2['city_language_code']        =    2;






             if(isset($_POST['txt_city_id']) && $_POST['txt_city_id']>0)             
             {
                     $inputArray['city_id']              =     $_POST['txt_city_id'] ;
                     $inputArray2['city_id']           =     $_POST['txt_city_id'] ;
                     unset($inputArray['city_created_date']);
                     unset($inputArray2['city_created_date']);
             }

            /**
           * changes by jitin on 26 sep 18 for xss filtering
           */
          $inputArray = $this->security->xss_clean($inputArray);
          $inputArray2 = $this->security->xss_clean($inputArray2);
          
           $result  =    $this->M_admin->saveMasterTable($inputArray,$inputArray2,'city_id','city_language_code','city');
           $data['status'] = $result;
           echo json_encode($data);


    }
    function serviceTypeList()
    {
        
             $data["service_type_list"]        =   $this->M_admin->getServiceTypeWithParent();
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/service_type_list",$data);
             $this->load->view("admin/footer");
    }
    function addEditServiceType()
    {
          $id                              =      $this->common_functions->decryptId($this->uri->segment(3));
             
             if($id>0)
             {
                  $data['id']                            =       $id;
                  $con['country_id']             =       $id;                  
                 $data['records1']                =       $this->M_admin->getServiceTypes2(1,$id);
                 $data['records2']                =       $this->M_admin->getServiceTypes2(2,$id);
                  
                 
                 
             }
        
        
            $con                                                                        =    array();
            $con['service_type_language_code']              =    1;
            $con2                                                                      =    array();
            $con2['service_methode_language_code']    =    1;
            
            $data["service_type_list"]               =   $this->M_admin->getServiceTypes($con);
            $data["service_method_list"]        =   $this->M_admin->getServiceMethods($con2);
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/add_edit_service_type",$data);
             $this->load->view("admin/footer");
    }
    function saveServiceType()
    {
        
           $data = array();
                    
           $this->form_validation->set_rules('txtEnglish', 'Service type  name english', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
           $this->form_validation->set_rules('txtArabic', 'Service type name arabic', 'trim|required|max_length[100]|xss_clean|callback_alpha_space');
           $this->form_validation->set_rules('txtmethod', 'Service method', 'trim|required|numeric|callback_check_default');
           
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
		
			 
			 
			 if($_FILES["txtFile"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                   
                                    $filename2 = $_FILES["txtFile"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'service_type/';
                                    $config2['allowed_types']        =  'gif|jpg|png|jpeg';
                                  //  $config2['max_size']             =  1000;
                                  //  $config2['max_width']            =  1024;
                                   // $config2['max_height']           =  768;
                                    $config2['file_name']            =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
	              $this->load->library('upload', $config2);
                                    // $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('txtFile'))
                                   {
                                       
                                       //die("file upload failed");
                                        $data['status'] = 0;
                                        $data['errors'] = array(
                                         'txtFile' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $inputArray['service_type_icon']                 =   $config2['file_name'];
                                      
                                  }
				 
			 }
                         //app icon image
                         	 if($_FILES["txtFile2"]["name"]!="")
			 {
				 
				                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");                                   
                                    $filename2 = $_FILES["txtFile2"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);                        
                                    $config2['upload_path']          =  $this->config->item('upload_path').'service_type/';
                                    $config2['allowed_types']        =  'gif|jpg|png|jpeg';
                                   // $config2['max_size']               =  1000;
                                   // $config2['max_width']            =  1024;
                                    //$config2['max_height']          =  768;
                                    $config2['file_name']              =  $randomNo.".".$file_ext2;
                    
                                    //$this->load->library('upload', $config2);
	              $this->load->library('upload', $config2);
                                    $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('txtFile2'))
                                   {
                                       
                                      //die("file upload failed");
                                        $data['status'] = 0;
                                        $data['errors'] = array(
                                         'txtFile2' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $inputArray['service_type_banner_image']                 =   $config2['file_name'];
                                      
                                  }
				 
			 }
                         
         	// trim($this->input->post("txt_user_id"));
            $inputArray['service_type_name']                            =    trim($this->input->post("txtEnglish"));
             $inputArray['service_type_language_code']         =    1;
             $inputArray['service_type_parent_id']                   =    trim($this->input->post("txtParent"));
             $inputArray['service_type_status']                          =    trim($this->input->post("txtStatus"));
             $inputArray['service_methode']                               =     trim($this->input->post("txtmethod"));
             $inputArray['service_type_created_date']             =    gmdate("Y-m-d H:i:s");
           
             $inputArray2                                                                  =    $inputArray;
             $inputArray2['service_type_name']                          =    ($this->input->post("txtArabic")!=""? $this->input->post("txtArabic"): $this->input->post("txtEnglish"));
             $inputArray2['service_type_language_code']        =    2;

             




             if($this->input->post("txt_service_id")>0)             
             {
                     $inputArray['service_type_id']                                          =     $this->input->post("txt_service_id");
                     $inputArray2['service_type_id']                                        =     $this->input->post("txt_service_id") ;					 
                    $inputArray['service_type_updated_date']              =     gmdate("Y-m-d H:i:s"); 
                    $inputArray2['service_type_updated_date']            =    gmdate("Y-m-d H:i:s");
                    unset($inputArray['service_type_created_date']);
                    unset($inputArray2['service_type_created_date']);
             }

       
          $inputArray = $this->security->xss_clean($inputArray);
          $inputArray2 = $this->security->xss_clean($inputArray2);
          
           $result =    $this->M_admin->saveMasterTable($inputArray,$inputArray2,'service_type_id','service_type_language_code','service_type');
            
            $data['status'] = $result;
           echo json_encode($data);
    }
    function deleteServiceType()
	{
		     $id   =      $this->common_functions->decryptId(trim($this->input->post("id")));      
                                              echo  $this->M_admin->deleteServiceType($id)     ;
	}
        function addEditQuestions()
        {
            $data                                                =      array();
             $serviceTypeId                              =      $this->common_functions->decryptId($this->uri->segment(3));
             
             $con1['form_control_status']            =  1;
            // $con2['question_language_code']    =  1;
             $con2['question_status']                     =  1;
             $con2['questions_service_type_id']                     =  $serviceTypeId;
             $data['form_control']                    =   $this->M_admin->getFormControls($con1);
             $data['form_questions']                =   $this->M_admin->getFormQuestions($con2);
             
             if($serviceTypeId>0)
             {
                  $data['id']                            =       $id;             
                 
             }
         
             $this->load->view("admin/header");
             $this->load->view("admin/sidebar");
             $this->load->view("admin/add_edit_questions",$data);
             $this->load->view("admin/footer");
        }
        function saveDynamicForm()
        {
             $serviceTypeId                              =      $_POST['serviceTypeId'] ;
             
             if($serviceTypeId<=0)
             {
                 redirect(base_url());
             }
             else
             {
           $this->form_validation->set_rules('txtEnglish[]', 'Question in english', 'trim|required|max_length[1000]|xss_clean|callback_alpha_space');
           $this->form_validation->set_rules('txtArabic[][]', 'Question in tamil', 'trim|required|max_length[1000]|xss_clean|callback_alpha_space');
           $this->form_validation->set_rules('txtInputType[][]', 'Input type', 'trim|required|numeric|callback_check_default');
           
            if ($this->form_validation->run() == FALSE) {
              $data['status'] = 0;
              $data['errors'] = array(
                                'txtEnglish[]' => form_error('txtEnglish[]'),
                                'txtArabic[][]' => form_error('txtArabic[][]'),
                                'txtInputType[][]' => form_error('txtInputType[][]'),
                                );
              echo json_encode($data);
              exit();
            } 
            else
            {
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
             if(count($answers)>0)
             {
                 ?>
                                        <option value="0">No parent</option>
                                        
                                        <?php
                 foreach ($answers as $rows)
                 {
                     ?>
                                        <option value="<?php echo  $rows->answer_options_id ?>"><?php echo  $rows->answer_option ?></option>
                                        
                                        <?php
                     
                 }
             }
            else {
                                   ?>
                                        <option value="0">No parent</option>
                                        
                                        <?php
            }
              
             
          }
    
    
    
    
    
    
    
    
    
    
function check_default($array)
{
  foreach($array as $element)
  {
    if($element == '0' || $element == "")
    { 
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
		if (empty($password))
		{
			$this->form_validation->set_message('valid_password', 'The {field} field is required.');
			return FALSE;
		}
//		if (preg_match_all($regex_lowercase, $password) < 1)
//		{
//			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
//			return FALSE;
//		}
		if (preg_match_all($regex_uppercase, $password) < 1 && preg_match_all($regex_lowercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least one  letter.');
			return FALSE;
		}
		if (preg_match_all($regex_number, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
			return FALSE;
		}
		if (preg_match_all($regex_special, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.');
			return FALSE;
		}
		if (strlen($password) < 8)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
			return FALSE;
		}
		if (strlen($password) >20)
		{
			$this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 20 characters in length.');
			return FALSE;
		}
		return TRUE;
	}
      public  function check_inavlid_char($string="")
        {
                 $regex_special = '/[!@#$%^&*()\=+{};:<.>§~]/';
                
            
                 if (preg_match_all($regex_special, $string) >0)
		{
			$this->form_validation->set_message('check_inavlid_char', 'The {field} field contains invalid characters.');
			return FALSE;
		}
                                    return TRUE;
            }
         public function weight_check($val)
    { 
     if ( !is_numeric($val) ) {
            $this->form_validation->set_message('weight_check', 'The {field} field must be number or decimal.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
        public function percent_check($val)
    { 
     if ( $val>100 ) {
            $this->form_validation->set_message('percent_check', 'The {field} field must be less than or equals 100.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function valid_url($url)
{
    $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
    if (!preg_match($pattern, $url))
    {
        return FALSE;
    }

    return TRUE;
}
  function alpha_space($fullname){
    if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
        $this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & White spaces');
        return FALSE;
    } else {
        return TRUE;
    }
}
}
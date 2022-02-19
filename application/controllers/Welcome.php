<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
     public function __construct()
     {
           parent::__construct();
                
          error_reporting(E_ERROR | E_PARSE);
          load_user_language();
     }
    public function index()
    { 
        $this->load->model('M_admin');    
      $this->load->model('M_common');    
         $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
         
         if($language==2)
             {
                     
                   $this->lang->load("web","arabic");
                      
             }
             else
             {
                  $this->lang->load("web","english");
                      
             }
        
                                        $con['is_home_category']                                 =  0;
                                        $con['service_type_status']                              =  1;
                                        $language           = $this->session->userdata("language")>0? $this->session->userdata("language"):1;   
                                        $con['service_type_language_code']                              =  $language;
                                        $con['service_methode']                                                      =  4;
                                            
                                        $data['non_home_cate']         =   $this->M_common->getServiceTypes($con);
                                      
                                        $con3['testimonial_status']  = 1;
                                        
                                        $con2['is_home_category']                                 =  0;
                                        $con2['service_type_status']                                               =  1;
                                        $con2['service_type_language_code']                              =  $language;
                                        
                                        $popular_cate                                                            =   $this->M_common->getServiceTypes($con2, 11);
                                        foreach ($popular_cate as $key => $value) {
                                            $subServices    = $this->M_common->getSubServices($value->service_type_id);
                                            $popular_cate[$key]->is_sub = count($subServices);

                                        }
                                        // echo "<pre>";print_r($popular_cate);exit;
                                        $data['popular_cate'] = $popular_cate;
                                        
                                        $data['testimonial']                                                                =   $this->M_common->getTestimonials($con3);
                                        
                                        $data['user_count']                                                               =   $this->M_common->userTypeWiseCount(1);
                                        $data['vendor_count']                                                          =   $this->M_common->userTypeWiseCount(2);
                                        $data['completed_count']                                                   =   $this->M_common->jobsCompletedCount();
                                        $data['turnOver']                                                   =   $this->M_common->turnOver();
                                        
                                        $conLabe['home_labels_status'] =1;
                                        $data['labels']       =   $this->M_admin->getHomeLabels($conLabe);
                                        
                                        
                                         /** edited by jitin 
                                             * get latest blog from wordpress site
                                             **/
                                            //  $curl = curl_init();
                                    
                                            // curl_setopt_array($curl, array(
                                            //   CURLOPT_URL => base_url()."blog/recent_posts.php",
                                            //   CURLOPT_RETURNTRANSFER => true,
                                            //   CURLOPT_ENCODING => "",
                                            //   CURLOPT_MAXREDIRS => 10,
                                            //   CURLOPT_TIMEOUT => 30,
                                            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            //   CURLOPT_CUSTOMREQUEST => "GET",
                                            // ));
                                            
                                            // $response = curl_exec($curl);
                                            // $err = curl_error($curl);
                                            
                                            // curl_close($curl);
                                            
                                            // if ($err) {
                                            //   //echo "cURL Error #:" . $err;
                                            // } else {
                                              
                                            //    $curl2 = curl_init();
                                            //     curl_setopt_array($curl2, array(
                                            //       CURLOPT_URL => base_url()."blog/recent_blog.xml",
                                            //       CURLOPT_RETURNTRANSFER => true,
                                            //       CURLOPT_ENCODING => "",
                                            //       CURLOPT_MAXREDIRS => 10,
                                            //       CURLOPT_TIMEOUT => 30,
                                            //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            //       CURLOPT_CUSTOMREQUEST => "GET",
                                            //     ));
                                                
                                            //     $response = curl_exec($curl2);
                                            //     $err = curl_error($curl2);
                                                
                                            //     curl_close($curl2);
                                                
                                            //     if ($err) {
                                            //       //echo "cURL Error #:" . $err;
                                            //     } else {
                                            //      // echo $response;
                                            //       $myXMLData = $response;
                                            //       $xml=simplexml_load_string($myXMLData);
                                            //       //echo "<pre>"; print_r($xml);
                                            //       $blogArr = json_decode( json_encode($xml) , 1);
                                            //       $data['blogArr'] = $blogArr;
                                                   
                                            //        //print_r($blogArr);
                                                  
                                            //     }
                                              
                                            // }
                                        $data['aboutus'] = $this->M_common->getArticles(2);
                                        $data['how_is_it_work'] = $this->M_common->getArticles(18);
                                        
                                         $this->load->view('header');
                                         $this->load->view('index',$data);
                                         $this->load->view('footer');
    }
                    function loadHowIsItWork()
                    {
                                                     $this->load->view('header');
                                                     $this->load->view('how_is_it_work');
                                                     $this->load->view('footer');
                    }
                    function loadCareers()
                    {
                                                    $this->load->view('header');
                                                     $this->load->view('careers');
                                                     $this->load->view('footer');
                    }
                     function loadAboutUs()
                    {
                        
                         
                         $this->load->view('header');
                         $this->load->view('aboutus');
                         $this->load->view('footer');
                    }
                    function loadArticles()
                    {
                        
                        $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
                        //$con['articles_language_code']      =   $language;
                       // $con['articles_id']                 =   $this->uri->segment(2);
                        $data['articles']               =   $this->M_common->getArticles($this->uri->segment(2));
                        //print_r($data);
                       // exit; dd
                        $this->load->view('header');
                        $this->load->view('articles',$data);
                        $this->load->view('footer');
                        
                    }
                    function loadServices()
                    {
                        $data = array();
                        $this->load->view('header');
                        $this->load->view('services',$data);
                        $this->load->view('footer');
                    }
                    function contact()
                    {
                        $data['admin_basics']        =   $this->M_common->getAdminBasics();
                        $this->load->view('header');
                        $this->load->view('contact',$data);
                        $this->load->view('footer');
                    }
                    function servicesList()
                    {
                        
         
        
        
       //print_r($_POST);
       // exit;
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:16;
        $start_index                =   ($this->uri->segment(3)>0 ?($this->uri->segment(3)-1)*$limit_per_page : 0);
        $records                    =   $this->M_common->getServicesListCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_common->getServicesList($_POST,$limit_per_page, $start_index)     ;  

            $config['base_url']         =   base_url().'welcome/servicesList';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   3;
             
            // custom paging configuration
            $config['num_links']            =   2;
            $config['use_page_numbers']     =   TRUE;
            $config['reuse_query_string']   =   TRUE;
             
            $config['full_tag_open']        =   '<ul class="pagination">';
            $config['full_tag_close']       =   '</ul>';
             
            $config['first_link']           =   $this->lang->line('first');
            $config['first_tag_open']       =   '<li>';
            $config['first_tag_close']      =   '</li>';
             
            $config['last_link']            =   $this->lang->line('last');
            $config['last_tag_open']        =   '<li>';
            $config['last_tag_close']       =   '</li>';
             
            $config['next_link']            =   '&gt;';
            $config['next_tag_open']        =   '<li>';
            $config['next_tag_close']       =   '</li>';
 
            $config['prev_link']            =   '&lt;';
            $config['prev_tag_open']        =   '<li>';
            $config['prev_tag_close']       =   '</li>';
 
            $config['cur_tag_open']         =   '<li class="active"><span>';
            $config['cur_tag_close']        =   '</span></li>';
 
            $config['num_tag_open']         =   '<li>';
            $config['num_tag_close']        =   '</li>';
            $config["num_links"]                       =    6;
             
                 $this->pagination->initialize($config);
                 
           
                $data["links"] = $this->pagination->create_links();
                
           
                
            }
                
            
                       
                 $this->load->view("services_list_ajax",$data);
                   
                    }
                    
    public function subServices($service_type_id=0){
        if($service_type_id > 0 ){
            $condition = ['service_type_id'=> $service_type_id] ;
            
            $data['sub_service_list']   = $this->M_common->getSubServices($service_type_id);
            $data['service_type']       = $this->M_common->getServiceTypes($condition);
            $data['h_data']             = $this->M_common->getHowItsWork($service_type_id);
            $data['service_details']    = $this->M_common->getServiceDetails($service_type_id);
            $service_ids = [];
            foreach($data['sub_service_list'] as $key => $value){
                $service_ids[$key] = $value->service_type_id;
            }
            $service_ids[$key+1] = $service_type_id;
            $data['rating']             = $this->M_common->get_seller_ratings_summary($service_ids);
            $data['rating_list']        = $this->M_common->get_rating_list($service_ids,8,0);
            $data['service_type_id']    = $service_type_id;
            
            $this->load->view('header');
            $this->load->view('sub_services',$data);
            $this->load->view('footer');
        }else{
            redirect();
        }
    }
    
    public function getReviewsList(){
        $service_type_id = $this->input->post('service_type_id');
        $page            = $this->input->post('page');
        
        $sub_service_list = $this->M_common->getSubServices($service_type_id);
        $service_ids = [];
            foreach($sub_service_list as $key => $value){
                $service_ids[$key] = $value->service_type_id;
            }
            
        $limit_per_page             =     8;
        $start_index                =     ($page > 0 ? $page  * $limit_per_page : 0);
        $rating_list_count          = count($this->M_common->get_rating_list($service_ids));
        $data['rating_list']        = $this->M_common->get_rating_list($service_ids,$limit_per_page,$start_index);
        
        $output['result']             = $this->load->view('review_list_ajax',$data,true);
       
        if($rating_list_count > ($start_index + $limit_per_page) ){
            $page = $page+1;
            $output['next'] = $page;
        }else{
            $output['next'] = 0;
        }
        echo json_encode($output);
    }
    
    
    public function vendorLogin(){
        
        $this->load->view('vendor_login');
    }

    public function paymentSuccess($job_request_id){
        $data['job_request_id']     = $job_request_id;
        $this->load->view('header');
        $this->load->view('thanks',$data);
        $this->load->view('footer');
    }
    
    public function paymentFailed(){
        $this->load->view('header');
        $this->load->view('failed');
        $this->load->view('footer');
    }

}

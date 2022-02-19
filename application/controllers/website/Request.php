<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
class Request extends CI_Controller 
{
    public function __construct()
     {
           parent::__construct();
          $this->load->model('website/M_request');   
          $this->load->model('website/M_user');   
          $this->load->model('website/M_common');           
          $this->load->model('M_payment', "model_payment");
          error_reporting(E_ERROR | E_PARSE);
          load_user_language();
           $this->load->library("FCM_Notification");
         $this->load->helper('eq_helper'); 
     }
     function loadRequestForm()
     {
             $language           = $this->session->userdata("language")>0? $this->session->userdata("language"):1;     
             $serviceTypeId  =  $this->common_functions->decryptId($_GET['sid']);

            $data['service_details']    = $this->M_common->get_all_by_need('service_type','*',['service_type_id'=>$serviceTypeId,'service_type_language_code'=>$language]);
            
            $baner_image_temp = $this->M_common->getbanerImage($serviceTypeId);
            
            $baner_image      = "uploads/service_type/".$baner_image_temp->image;
            if(file_exists($baner_image) && is_file($baner_image))
                $baner_image = base_url().$baner_image;
            else
                $baner_image = base_url().'uploads/banner-dummy.jpg';
             
             $data['country_list']   = $this->M_request->getCountryList();
            $data['baner_image']        = $baner_image;
             if($serviceTypeId>0)
             {
                    
                  
                    
                      
                       $con2['select_service_type']                  =          $serviceTypeId;                          
                       $data['question_list']                        =          $this->M_request->getDynamicQuestions($con2);  
                       
                       if(count($data['question_list'])<=0)
                       {
                           $conser['service_type_id'] =  $serviceTypeId;
                           $conser['service_type_language_code'] =  $language;
                           $service = $this->M_common->getServiceTypes($conser);
                           $data['question_list']                        =          $service[0]; 
                           
                           
                       }
                       // var_dump($data['question_list']);exit();
                       
                        $con3['select_service_type']           =          $serviceTypeId;        
                       $data['faq']                        =          $this->M_request->getFaq($con3);  
                       
                        $data['testimonial']                        =          $this->M_common->getTestimonials(array());  
                        
                        
                        $curl = curl_init();
                                    
                                            curl_setopt_array($curl, array(
                                              CURLOPT_URL => base_url()."blog/recent_posts.php",
                                              CURLOPT_RETURNTRANSFER => true,
                                              CURLOPT_ENCODING => "",
                                              CURLOPT_MAXREDIRS => 10,
                                              CURLOPT_TIMEOUT => 30,
                                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                              CURLOPT_CUSTOMREQUEST => "GET",
                                            ));
                                            
                                            $response = curl_exec($curl);
                                            $err = curl_error($curl);
                                            
                                            curl_close($curl);
                                            
                                            if ($err) {
                                              //echo "cURL Error #:" . $err;
                                            } else {
                                              
                                               $curl2 = curl_init();
                                                curl_setopt_array($curl2, array(
                                                  CURLOPT_URL => base_url()."blog/recent_blog.xml",
                                                  CURLOPT_RETURNTRANSFER => true,
                                                  CURLOPT_ENCODING => "",
                                                  CURLOPT_MAXREDIRS => 10,
                                                  CURLOPT_TIMEOUT => 30,
                                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                  CURLOPT_CUSTOMREQUEST => "GET",
                                                ));
                                                
                                                $response = curl_exec($curl2);
                                                $err = curl_error($curl2);
                                                
                                                curl_close($curl2);
                                                
                                                if ($err) {
                                                  //echo "cURL Error #:" . $err;
                                                } else {
                                                 // echo $response;
                                                  $myXMLData = $response;
                                                  $xml=simplexml_load_string($myXMLData);
                                                  //echo "<pre>"; print_r($xml);
                                                  $blogArr = json_decode( json_encode($xml) , 1);
                                                  $data['blogArr'] = $blogArr;
                                                   
                                                   //print_r($blogArr);
                                                  
                                                }
                                              
                                            } 
    
        $courrent_time =strtotime(date('H:i'));        
        $slot = ['9:00','9:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'];
        $slot_list = "";
        $active = "active";
        foreach ($slot as $key => $value) {
            $time_slot = strtotime($value);
            if($time_slot > $courrent_time ){
                $slot_list = $slot_list.'<span class="badge '.$active.'  badge-pill">'.date('h:i A',strtotime($value)).'</span>';
                $active = '';
            }else{
                $slot_list = $slot_list.'<span class="badge slot_disabled badge-pill">'.date('h:i A',strtotime($value)).'</span>';
            }
        }                    
        
        $data['slot_list'] = $slot_list;                
                        
                        
                      //echo "<pre>";
                    //  print_r($data);
                        $this->load->view("header");
                        $this->load->view("request",$data);
                        $this->load->view("footer");
             }
             else
             {
                 redirect(base_url());
             }
     }
     function checkValidation()
     {
         //print_r($_POST);
         //exit;
         
      
         
          if(count($_POST)<=0)
          {
              echo 0;
          }
          else
          {
                $con['questionId']                 =  $_POST['selectedQuestion'];
                
               $isParent  =  $this->M_request->checkIsparent($con['questionId']);
               
               $lastParent = 0;
               
               if($isParent > 0)
               {
                   $offset = $_POST['offset']+1;
               }
               else
               {
                    $offset = $_POST['offset'];
                    $lastParent  =  $con['questionId'];
                    $con['last_parent']        =  $_POST['last_parent']>0?$_POST['last_parent']:$_POST['selectedQuestion'];
               }
                
                
                $con['answerOption']           =  $_POST['selectedAnswer'];
                $con['offset']                          =  $_POST['offset'];              
                $question_list                         = $this->M_request->getNextQuestion($con); 
                $serviceTypeid                        = $this->common_functions->decryptId($_POST['serviceTypeid']);
                $selectedAnswer                    = $_POST['selectedAnswer'];
               // print_r($question_list);
                if(count($question_list)>0)
                {
                    $ischildClass = "parent".$_POST['selectedQuestion'];
                }
                else
                {
                    $con['last_parent']        =  $_POST['last_parent'];
                    $con['serviceTypeid']      =  $serviceTypeid;
                    
                    $question_list                         = $this->M_request->nextParentQuestion($con); 
                    
                    $ischildClass   = "";
                }
                
                 $language           = $this->session->userdata("language")>0? $this->session->userdata("language"):1;     
             $i=1;
           // print_r($question_list);
             if (count($question_list)>0)
             {
                   $rows = $question_list;
                   
                   if($rows->question_parent_id<=0)
                   {
                        $lastParent  =  $rows->question_id;
                   }
                   
                 //  print_r($rows);
                 if($i==1)
                 {
                     $style= "";
                 }
                 else
                 {
                     $style ="none";
                 }
                  $con2['question_id']    =  $rows->question_id;
                  $answers                     =   $this->M_request->getAnswers($con2)     ; 
                 echo $rows->question_id."^";
             ?>
<!--start row-->
<span id="span<?php echo $rows->question_id ?>" class="commonDisplayQuestion <?php echo $ischildClass;?>">
<div class="row choose_options" style="display:<?php echo $style;?>" id="div<?php echo $rows->question_id ?>" data-element-type="<?=$rows->question_form_type?>">
<h3><?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?></h3>
<?php
//echo $rows->question_form_type;
                                if($rows->question_form_type==1)
                                {
                                ?>
                                 <input type="text" class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>" value="" maxlength="100" autocomplete="off">
                                <?php
                                }
                               
                              else  if($rows->question_form_type==6)
                                {
                                ?>
                                 <textarea class="form-control boxed dynamicQues" for="<?php echo $rows->question_id ?>" placeholder="" name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>" value=""  autocomplete="off"></textarea>
                                <?php
                                }
                                else if($rows->question_form_type==2)
                                {
                                    
                                  //  exit;
                                ?>
                                <select class="form-control dynamicQues" for="<?php echo $rows->question_id ?>"    name="question[<?php echo $rows->question_id ?>][]"  id="dynamicQues<?php echo $rows->question_id ?>">
                                    <option value="">Select</option>
                                    <?php
                                    if(count($answers)>0)
                                    {
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows2->answer_options_id ?>"  data-text="<?php  echo $rows2->answer_option ?>" ><?php  echo $rows2->answer_option ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                                <?php
                                }
                                else if($rows->question_form_type==4)
                                {
                                    ?>
                          
<ul class="options">
    
      <?php
      $k=1;
                                    if(count($answers)>0)
                                    {
                                        foreach($answers as $rows2)
                                        {
                                    ?>
<li>
    <input for="<?php echo $rows->question_id ?>" data-question="<?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?>" data-text="<?php  echo $rows2->answer_option ?>" id="dynamicQues<?php  echo $rows2->answer_options_id ?>" name="question[<?php echo $rows->question_id ?>][]" type="radio" value="<?php  echo $rows2->answer_options_id ?>" data-error="#errNmQ<?php echo $rows->question_id ?>" data-price="<?php  echo $rows2->price ?>" class="hide radio<?php echo $rows->question_id ?> answerRadios" <?php echo $selectedAnswer==$rows2->answer_options_id?"checked":"" ?>  >
  <label for="dynamicQues<?php  echo $rows2->answer_options_id ?>"><?php  echo $rows2->answer_option ?></label>     
</li>
 <?php
 $k++;
                                        }
                                    }
                                    ?>

</ul>
                                 <?php
                               } else if($rows->question_form_type==5)
                                {
                                      if(count($answers)>0)
                                    {
                                          ?>
                                 <ul class="options">
                                 <?php
                                 $k=1;
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                          <li>
                    <label class="form-check-label">
                        <input class="form-check-input dynamicQues radio<?php echo $rows->question_id ?> answerCheck" data-text="<?php  echo $rows2->answer_option ?>" for="<?php echo $rows->question_id ?>" id="dynamicQues<?php  echo $k?>" name="question[<?php echo $rows->question_id ?>][]" type="checkbox" value="<?php  echo $rows2->answer_options_id ?>" data-price="<?php  echo $rows2->price ?>" data-question="<?php echo $language==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question ; ?>"  data-error="#errNmQ<?php echo $rows->question_id ?>" ><?php  echo $rows2->answer_option ?>
                    <span class="dynamicCheckSpan"></span>  </label>
                            </li>
                  
                                    <?php
                                    $k++;
                                        }
                                        ?>
                                        </ul>
                                <!-- <span id="errNmQ<?php echo $rows->question_id ?>"></span>-->
                               
                                        <?php
                                    }
                                }
                                else if($rows->question_form_type==3)
                                {
                                    ?>
                                 <select class="form-control demoSelect dynamicQues" for="<?php echo $rows->question_id ?>" name="question[<?php echo $rows->question_id ?>][]" multiple="multiple" id="dynamicQues<?php echo $rows->question_id ?>">
                <optgroup label="Select answer">
                  <?php
                  if(count($answers)>0)
                                    {
                                        foreach($answers as $rows2)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows2->answer_options_id ?>" data-price="<?php  echo $rows2->price ?>"><?php  echo $rows2->answer_option ?></option>
                                    <?php
                                        }
                                    }
                  ?>
                </optgroup>
              </select>
                                 <?php
                                }
                                ?>
 
</div>
<span class="error" id="questionError"></span>
   <div class="row">
             
     <div class="col-md-12">
        
         <span style="margin-right: 11px;" href="#" class="back continue" onclick="removeLastData(<?=$rows->question_id?>)" id="next<?php echo $rows->question_id ?>"   data-current="<?php echo $_POST['selectedQuestion'];?>"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span> Back</span>
           &nbsp; <span href="#" style="margin-left:-4px" class="continue btnCountinue" id="next<?php echo $rows->question_id ?>"   data-qtype="<?php echo $rows->question_form_type;?>" data-offset="<?php  echo $offset;?>" data-current="<?php echo $rows->question_id ?>" data-parent="<?php echo $lastParent ?>">Continue <span><img src="<?php echo base_url();?>frontend_assets/images/icons/right-arow.png"/></span></span>
           <input type="hidden" class="lastQue" value="<?php echo $rows->question_id ?>">
     </div>
    </div>
</span>

<?php
              
             
          }
          
          
        }
     }
     function saveRequest_ol()
     {
         
      // print_r($_POST);
        //print_r($_FILES);
        //exit;
         if(count($_POST)>0)
         {
             
             
               $this->form_validation->set_rules('option', 'Request type', 'trim|required');
               $this->form_validation->set_rules('valTime', 'Work expiry time', 'trim|required');
               $this->form_validation->set_rules('valdate', 'Work expiry date', 'required'); 
              // $this->form_validation->set_rules('question[]', 'Your needs', 'required'); 
                if($this->input->post("is_home_category")==0)
                {
                    $this->form_validation->set_rules('service_date', 'service_date', 'trim|required');
                    $this->form_validation->set_rules('serviceTime', 'Service time', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('price_from', 'Price from', 'trim|required');
                    $this->form_validation->set_rules('price_to', 'Price to', 'trim|required');
                    $this->form_validation->set_rules('addressType', 'Address type', 'trim|required');
                    
                }
                else if($this->input->post("is_home_category")==1)
                {
                    $this->form_validation->set_rules('street', 'Street', 'trim|required');
                    $this->form_validation->set_rules('city', 'City', 'trim|required');
                    $this->form_validation->set_rules('state', 'state', 'trim|required');
                    $this->form_validation->set_rules('discription', 'discription', 'trim|required');
                    
                    
                }
                
                
              
        if(empty($_FILES['document']['name']) && $this->input->post("is_home_category")==1)
          {
             // $this->form_validation->set_rules('document','Upload supporting document','trim|required');
         }
       
       if ($this->form_validation->run() == FALSE) 
           {
               
              // echo validation_errors();
                            $data['status'] = 0;
                            $data['errors'] = array(
                                              'datetimepicker3' => form_error('valTime'),
                                              'datetimepicker4' => form_error('valdate'),
                                              'us5-city' => form_error('city'),
                                              'us5-state' => form_error('state'),
                                              'us5-street1' => form_error('street'),
                                              'txtRemark' => form_error('discription'),
                                              'service_date' => form_error('service_date'),
                                              'price_from' => form_error('price_from'),
                                              'price_to' => form_error('price_to')
                                              );
                                       echo json_encode($data);
                                      exit();
        } 
        else
        {
            
            
         $_POST                      =        $this->security->xss_clean($_POST);
         
              if(count($_FILES["document"]["name"])>0 )
     {
         
                 for($i=0;$i<count($_FILES["document"]["name"]);$i++)
            {
                                  
                 $abc = FALSE;   
                 
        
                $temp_name =$_FILES['document']['tmp_name'][$i];
                
                 $real_name  = strtolower($_FILES['document']['name'][$i]);
                 $img_ext = end(explode(".", $real_name));
                
                 
               $upload_dir    =   $this->config->item('upload_path').'quotations/';
               
               $digits =6;
               
               $up_file_name="";
                 
               $up_file_name   =   str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis").".".$img_ext;
               
               $file_path      =  $upload_dir . $up_file_name;

           // echo "<br>";
        
         $abc =   move_uploaded_file($temp_name, $file_path);
        // var_dump($abc);
         
         if($abc===FALSE)
         {
             $data['status'] = 0;
                                        $data['errors'] = array(
                                         'document' => "File upload failed",
                                        );
                                        echo json_encode($data);
                                        exit();
             
         }
         else
         {
              $input['document'][$i]                 =   $up_file_name;
         }
                     
                             
                                  
                }
     }
         
          if($this->input->post("is_home_category")==0)
                {
              
                              $input['address_type']                         =           $this->input->post('addressType');
                              $input['job_date']                             =           date("Y-m-d",strtotime($this->input->post('service_date')));
                              $input['job_time']                             =           date("H:i:s",strtotime($this->input->post('serviceTime'))); 
                              $input['job_price_from']                       =           $this->input->post('price_from');
                              $input['job_price_to']                         =           $this->input->post('price_to');
                              
                              if($this->input->post('addressType')>0)
                              {
                                $addressExists =   $this->M_request->checkAddressExists($this->input->post('addressType'));
                                
                                if($addressExists<=0)
                                {
                                    echo -1;
                                    exit;
                                }
                              }
                              
               
                    
                }
                // else if($this->input->post("is_home_category")==1)
                // {
                  
                    $input['job_location']                           =           $this->input->post('street');
                    $input['job_longitude']                          =           $this->input->post('longitude');
                    $input['job_lattitude']                          =           $this->input->post('lattitude');
                    // $input['city']                                   =           $this->input->post('city');
                    // $input['state']                                  =           $this->input->post('state');
                   
                    
                //}
                
                    $input['description']                            =           $this->input->post('discription'); 
                    $input['user_id']                                    =           $this->session->userdata('eq_user_id');
                    $input['service_type_id']                     =           $this->input->post('service_type_id');
                    $input['job_validity_date']                  =            date("Y-m-d",strtotime($this->input->post('valdate')));;
                    $input['job_validity_time']                  =            date("H:i:s",strtotime($this->input->post('valTime'))); 
                    $input['job_request_status']              =           0;
                    $input['job_request_created_time'] =           date("Y-m-d H:i:s");
                    $input['job_request_type']                 =           $this->input->post('option');
                    
                    $this->load->library("Common_functions");
                    $randomString =  $this->common_functions->incrementalHash(2);
                    
                     if($this->input->post('option')==1)
                    {
                        $firstString = "Q";
                    }
                    else
                    {
                        $firstString = "R";
                    }
                    
                    $input['job_request_display_id']         =           $firstString.$randomString.$input['user_id'].date("mdHis");
                    
                    $questions                                              =          $this->input->post('question');
                    
                  $providers  =              $this->input->post('mappedItems');
                  $input['job_total_price']  =              $this->input->post('serviceTotPricePass');
               echo     $result                                                     =   $this->M_request->saveRequest($input,$questions,$providers); 
                
        }
             
         }
         
     }
     function getProviders()
     {
        //      print_r($_POST);
             if($_POST['is_home_category']==1)
             {
               $this->form_validation->set_rules('lattitude', 'lattitude', 'trim|required');
               $this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
             }
             else
             {
                 
                 $type    =  $_POST['addressType']>0?$_POST['addressType']:1;
               //  $address =  $this->M_request->getHomeLocation($this->session->userdata('eq_user_id'),$type);
                 
                // $_POST['longitude'] = $address->user_adresses_longitude;
                // $_POST['lattitude'] = $address->user_adresses_lattitude;
                $_POST['longitude'] = "53.847816";
                $_POST['lattitude'] = "23.424076";
             }
               $this->form_validation->set_rules('service_type_id', 'service_type_id', 'required'); 
               if ($this->form_validation->run() == FALSE) 
        {
                          echo  -1;
                            
        } 
        else
        {
                   $result                                                     =   $this->M_common->getProviders($this->input->post()); 
                   if(count($result) > 0)
                   {
                       $data['result'] = $result;
                       
                       
                       $this->load->view("provider_list_ajax",$data);
                      
                   }
                   else
                   {
                       echo "No results found";
                   }
        }
     }
     function getProviderDetails()
     {
             $providerId     =    $this->input->post('providerId'); 
             $result =  $this->M_common->getProviderDetails($providerId); 
             $data['basic_details'] = $result;                      
             $result2 =  $this->M_common->getAllRatings($providerId);      
             $data['ratings'] = $result2;          
             $result3 =  $this->M_common->getAllServiceTypesForProvider($providerId);      
             $data['services'] = $result3;  
             $data['option']   = $this->input->post('option'); ; 
           
            $this->load->view("provider_details_ajax",$data);
     }
     function addRating()
     {
               $this->form_validation->set_rules('txt_feedback', 'Feedback', 'trim|required');
               $this->form_validation->set_rules('rateval', 'Rating', 'trim|required');
              
               if ($this->form_validation->run() == FALSE) 
           {
                           $data['status'] = 0;
                            $data['errors'] = array(
                                              'txt_feedback' => form_error('txt_feedback'),
                                              'rateval' => form_error('rateval')
                                              );
                                    
                          echo json_encode($data);
                                      exit();   
        } 
        else
        {
              $data['status'] =   $this->M_common->addRating($this->input->post());   
        }
              echo json_encode($data);
                                      exit();   
        
     }
     function loadJobRequests()
     {
         
        
        
       
        
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobRequestsListByVendorCount($_POST)     ;
        $total_records              =   $records->count;
//      echo $total_records;exit;
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobRequestsListByVendor($_POST,$limit_per_page, $start_index);
            // echo"<pre>";    print_r($this->db->last_query());exit;

            $config['base_url']         =   base_url().'website/Request/loadJobRequests';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
                
            
                       
            $this->load->view("job_request_list_ajax",$data);
     }
     function changeStatus()
     {
       echo $result =  $this->M_request->changeStatus($this->input->post())  ;
     }
     
     function detailView()
     {
         $job_request_id    =  $this->common_functions->decryptId($this->input->post('itemId')) ;
         $language          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
         $data['result']    =  $this->M_request->getJobSummary($job_request_id,$language);
         $data['question']  =  $this->M_request->getQuestionsAgainstJobRequest($job_request_id); 
         $data['files']     =  $this->M_request->getUploadedFiles($job_request_id); 
         $data['staus']     =  $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$job_request_id); 
         $data['staff_list'] = $this->M_request->getUsersListByVendor();
         $data['assigned_staff'] = $this->M_request->getJobAssignedStaff($job_request_id);

         $data['job_days']      = $this->M_request->getRequestDays($job_request_id);
         
         if($this->session->userdata('eq_user_type')==2)
         {
             $userId = $this->session->userdata('eq_user_id');
             $this->M_request->recordViewCount($userId,$job_request_id);
         }
         //$printString       =  $this->load->view("job_detail_ajax",$data,true);
         //$data['print']     =  $printString ;
         $this->load->view("job_detail_ajax",$data);
     }
     function loadJobQuotations()
     {
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobQuotaionListCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobQuotaionList($_POST,$limit_per_page, $start_index)     ;  

            $config['base_url']         =   base_url().'website/Request/loadJobQuotations';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
                
            
                      
            $this->load->view("job_request_list_ajax",$data);
     }
     function markPrice()
     {
         
         $this->form_validation->set_rules('txt_price', 'Price', 'trim|required|xss_clean|callback_weight_check');
          
        if ($this->form_validation->run() == FALSE)
         {
                $data['status'] = 0;
                $data['errors'] = array(
                                  'txt_price' => form_error('txt_price')
                                  );
                echo json_encode($data);
                exit();
          } 
          else
          {
              
                $input['job_request_id']        =  $this->input->post("jobRequestId");
                $input['price']                 =  $this->input->post("txt_price");
                $input['provider_id']           =  $this->session->userdata('eq_user_id');
                
                
                                         
                if($_FILES["file_doc"]["name"]!="")
             {
                 
                                    $digits   =  6;
                                    $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis");
                                   
                                    $filename2 = $_FILES["file_doc"]["name"];
                                    $file_ext2 = pathinfo($filename2,PATHINFO_EXTENSION);
                        
                                    $config2['upload_path']          =   $this->config->item('upload_path').'quotations/';
                                    $config2['allowed_types']        =   'gif|jpg|png|jpeg|pdf|doc';
                                    $config2['file_name']            =   $randomNo.".".$file_ext2;
                                    $this->load->library('upload', $config2);
                                    $this->upload->initialize($config2);
                   
                                  if ( ! $this->upload->do_upload('file_doc'))
                                   {
                                      
                                        $data['status'] = 0;
                                        $data['message'] ="file_doc=".$this->upload->display_errors();
                                        echo json_encode($data);
                                        exit();
                                       
                                     
                                    }
                                   else
                                   {                                      
                                      $input['document_name']                 =   $config2['file_name'];
                                      
                                   }
                 
             }
              
            // print_r($input);exit; 
              
                 $result  =   $this->M_request->markPrice($input)     ; 
                 $data['status'] = $result;
                 echo json_encode($data);
                 if($result>0)
                 {
                             $job_request_id = $this->common_functions->decryptId($input['job_request_id']);
                              $userId        = $this->M_request->getUserIdFromJobRequest($job_request_id);
                              
                              if($userId>0)
                              {
                                   $this->M_request->sendCustomerMail($userId,$job_request_id,3,0);
                              }
                 }
                 exit();
          }
         
     }
     function loadRatings()
     {
        
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getRatingCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getRatingList($_POST,$limit_per_page, $start_index)     ;  

            $config['base_url']         =   base_url().'website/Request/loadRatings';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
                
            
                      
            $this->load->view("my_rating_ajax",$data);
     }
     function savePrimarySettings()
     {
          $this->form_validation->set_rules('location_name', 'Location', 'trim|required|xss_clean');
          
          $mappedItems  = explode(",",$this->input->post("mappedItems"));
          
         
          
        if ($this->form_validation->run() == FALSE )
         {
                $data['status'] = 0;
                $data['errors']['primaryLocationError'] =form_error('location_name');
                
          } 
          else if(count($mappedItems)<=0)
          {
              $data['status'] = 0;
              $data['errors']['primaryServiceTypeError'] = "Select any service type";
              
          }
          else
          {
               $data['errors']   ="";
               $data['status']   =   $this->M_request->savePrimarySettings($this->input->post());
          
          }
         
          echo json_encode($data);
              exit();
     }
     function loadJobRequestsUser()
     {
         
         
        
        
       
        
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
      
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:5;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobRequestsListCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobRequestsList($_POST,$limit_per_page, $start_index)     ;  
            // print_r($this->db->last_query());exit;
            $config['base_url']         =   base_url().'website/Request/loadJobRequestsUser';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
                
            
                       
            $this->load->view("job_request_list_ajax_user",$data);
     }
     function loadJobQuotationsUser()
     {
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:5;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobQuotaionListCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobQuotaionList($_POST,$limit_per_page, $start_index)     ;  

            $config['base_url']         =   base_url().'website/Request/loadJobQuotationsUser';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
                
            
                      
            $this->load->view("job_request_list_ajax_user",$data);
     }
     function viewOffers()
     {
           $languageCode   = ($this->session->userdata("language_code")==2?$this->input->post('language'):1);
             
             if($languageCode==2)
             {
                  $this->lang->load("message","arabic");
             }
             else
             {
                  $this->lang->load("message","english");
             }
       $jobRequestId = $this->common_functions->decryptId($_POST['jobRequestId']);
       $data['result'] =  $this->M_request->getRespondedProviders($jobRequestId,1);
       // print_r($result);reponded_provider_list_ajax
       $this->load->view("reponded_provider_list_ajax",$data); 
     }
     function changeStatusUser()
     {
         $input['response_status'] = $this->common_functions->decryptId($_POST['action']);
         $input['provider_id']     = $this->common_functions->decryptId($_POST['provider']);
         $input['job_request_id']  = $this->input->post('itemId');
         
        // print_r($input);
         
          echo $result =  $this->M_request->changeStatusUser($input)  ;
          
          if($result==1 && $input['provider_id']>0)
          {
                              $userId  = $input['provider_id'];
                              
                            //   if($userId>0)
                            //   {
                            //       $this->M_request->sendProviderMail($userId,$this->common_functions->decryptId($this->input->post('itemId')),$input['response_status'],0);
                            //       $this->M_request->sendCustomerMailConfirmation($this->session->userdata('eq_user_id'),$this->common_functions->decryptId($this->input->post('itemId')),$input['response_status'],0);
                            //   }
          }
     }
     function exportTransaction()
     {
           $this->load->model('website/M_user');    
         $languageCode                = ($this->session->userdata("language_code")==2?$this->input->post('language'):1);
         
         $trans_details               =  $this->M_user->getTransactionFullDetails($this->session->userdata('eq_user_id'),$language);
         
         
           
            $fileName = 'transaction_report_on'.date('Y_m_d').'.xls';
            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");
            
            function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
   // $fileName = "codexworld_export_data" . date('Ymd') . ".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    
    $total =0;
    foreach($trans_details as $rows) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array('Serial Number','Package Name','Purchase Date & Time','Package price','Vat')) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($rows, 'filterData');
        
       // $name= $row['user_first_name']." ".$row['user_last_name'];
       $packageSerial  = $rows->package_purchase_serial;
       $packageName =$rows->packages_name_arabic!="" && $languageCode==2?$rows->packages_name_arabic:$rows->packages_name;
       $packageDate = date("d-m-Y h i A",strtotime($rows->package_purchase_date));
       $packagePrice = $rows->packages_price>0?(string)$rows->packages_price:"";
        echo implode("\t", array($packageSerial,$packageName,$packageDate,$packagePrice,175)) . "\n";
      //$total =$total+$row['sum'];
    }
   
    exit;
         
         
     }
     function getSuggestion()
     {
        
         $result =  $this->M_request->getSuggestion($this->input->post()) ;
         if(count($result)>0)
         {
             foreach($result as $rows)
             {
                 $urlCategoryName  =  $rows->service_type_name;
                 $string = str_replace(' ', '-', $urlCategoryName); 
                 $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                 $urlCategoryName  = strtolower($urlCategoryName);
                 
                 ?>
                  <li class="sugLi" data-id="<?php echo $urlCategoryName;?>?sid=<?php echo $this->common_functions->encryptId($rows->service_type_id);?>" for="<?php echo $rows->service_type_name;?>"><span><?php echo $rows->service_type_name;?></span></li>
                 <?php
             }
         }
         else
         {
             echo "";
         }
         
     }
      function loadJobRequestsReport()
     {
         
        
        
       
        
           
        $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobRequestsListByVendorCount($_POST)     ;
        $total_records              =   $records->count;
//      echo $total_records;exit;
//      echo $this->db->last_query();exit;
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobRequestsListByVendor($_POST,$limit_per_page, $start_index)     ;  
            
// echo $this->db->last_query();exit;
            $config['base_url']         =   base_url().'website/Request/loadJobRequestsReport';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
       
            $this->load->view("job_request_list_ajax_report",$data);
     }
     function loadQuotationRequestsReport()
     {
         $this->load->library('pagination');
        
       
        $_POST['user_id'] = $this->session->userdata('eq_user_id');
        
        $limit_per_page             =   $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index                =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $records                    =   $this->M_request->getJobQuotaionListCount($_POST)     ;
        $total_records              =   $records->count;
        
        if ($total_records > 0) 
        {
        
            $data['result']  =   $this->M_request->getJobQuotaionList($_POST,$limit_per_page, $start_index)     ;  

            $config['base_url']         =   base_url().'website/Request/loadQuotationRequestsReport';
            $config['total_rows']       =   $total_records;
            $config['per_page']         =   $limit_per_page;
            $config["uri_segment"]      =   4;
             
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
       
            $this->load->view("job_request_list_ajax_report",$data);
     }
      function  printJobReport()
        {
            
           
            $fileName = 'job_report'.date('Y_m_d').'.xls';
            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");
            
            function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
   // $fileName = "vendor_payment_report_on" . date('Ymd') . ".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    $i=1;
    $con['from_date']  = $_GET['fd']!=""?$_GET['fd']:"";
    $con['to_date']    = $_GET['td']!=""?$_GET['td']:"";
    $con['user_id'] = $this->session->userdata('eq_user_id');
    $data['job_list']  =   $this->M_request->getJobRequestsListByVendor($con,0, 0)     ;
    
    foreach($data["job_list"] as $rows) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array('Job number','Service type','Location ','Service date','Service time','Price','Status')) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($rows, 'filterData');
        
         if($rows->is_home_category==0 && $rows->address_type>0)
                                     {
                                         $locationDetails = $this->M_request->getHomeLocation($this->session->userdata('eq_user_id'),$rows->address_type);
                                         $location = $locationDetails->user_adresses_location;
                                     }
                                     else
                                     {
                                         $location = $rows->job_location;
                                        
                                     }
                                     
                                       if($rows->is_home_category==0 && $rows->address_type>0)
                                       {
                                           $user_id =$rows->user_id;
                                           
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_request->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                              // $overallAddress =$alternateLocation->user_adresses_location.",".$alternateLocation->city.",".$alternateLocation->state;
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                                
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location.",".$rows->city.",".$rows->state:"";
                                       }
                                   
                            
                            $assignedStatus = $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$rows->job_request_id); 
       $awrdedLabel  = "";
        
        if($rows->job_request_status==4 )
        {
            $status = "Ongoing";
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            // $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "";
        }
         if($rows->job_request_status==5)
        {
            $status = $this->lang->line("completed");;
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled"; 
            $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "disabled";
        }
        else if($rows->job_request_status==2)
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        else if($rows->job_request_status==3)
        {
            $status = "Staff assigned";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        else if($rows->job_request_status==1)
        {
            $status = "Accepted";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }else if($rows->job_request_status== 10 )
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }else{
            $status = "Pending";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        
        
       $price = CURRENCY_CODE .$rows->grand_total;
       echo implode("\t", array($rows->job_request_display_id,$rows->service_type_name,$location,date('d-m-Y', strtotime($rows->job_date)),date('h:i A', strtotime($rows->job_time)),$price,$status)) . "\n";
       
       $i++;
    }
    
              exit;
        }
        function printQuotReport()
        {
            
            
           
            $fileName = 'quotation_report'.date('Y_m_d').'.xls';
            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");
            
            function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
   // $fileName = "vendor_payment_report_on" . date('Ymd') . ".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    $i=1;
    $con['from_date']  = $_GET['fd']!=""?$_GET['fd']:"";
    $con['to_date']    = $_GET['td']!=""?$_GET['td']:"";
    $con['user_id']    = $this->session->userdata('eq_user_id');
    $data['job_list']  =   $this->M_request->getJobQuotaionList($con,0, 0)     ;
    foreach($data["job_list"] as $rows) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array('Job number','Service type','Location ','Validity date','Validity time','Price','Status')) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($rows, 'filterData');
        
         if($rows->is_home_category==0 && $rows->address_type>0)
                                     {
                                         $locationDetails = $this->M_request->getHomeLocation($this->session->userdata('eq_user_id'),$rows->address_type);
                                         $location = $locationDetails->user_adresses_location;
                                     }
                                     else
                                     {
                                         $location = $rows->job_location;
                                        
                                     }
                                     
                                       if($rows->is_home_category==0 && $rows->address_type>0)
                                       {
                                           $user_id =$rows->user_id;
                                           
                                           if($user_id>0)
                                           {
                                               $addressType        = $rows->address_type;
                                               
                                               $alternateLocation  =   $this->M_request->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                              // $overallAddress =$alternateLocation->user_adresses_location.",".$alternateLocation->city.",".$alternateLocation->state;
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                                
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $rows->job_longitude!=""?$rows->job_longitude:"";
                                           $latiTude = $rows->job_lattitude!=""?$rows->job_lattitude:"";
                                           $location = $rows->job_location!=""? $rows->job_location.",".$rows->city.",".$rows->state:"";
                                       }
                                   
                            
                            $assignedStatus = $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$rows->job_request_id); 
       $awrdedLabel  = "";
         if($rows->job_request_status==4 && $assignedStatus->user_response_status==1)
        {
            $status = "Confirmed";
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "";
        }
         if($rows->job_request_status==5 && $assignedStatus->assign_status==5)
        {
            $status = $this->lang->line("completed");;
            $buttonClas = "accept";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled"; 
            $awrdedLabel  = $this->lang->line("awarded");
            $completeDisable = "disabled";
        }
        else if($rows->job_request_status==2)
        {
            $status = "Cancelled";
            $buttonClas = "reject";
            $accePtDisable = "disabled";
            $rejecttDisable = "disabled";
            $completeDisable = "disabled";
        }
        else
        {
            
        
                if($assignedStatus->assign_status<=0)
                {
                     $status     = "Pending";
                     $buttonClas = "pending";
                     $accePtDisable = "";
                     $rejecttDisable = "";
                     $completeDisable = "disabled";
                }
                if($assignedStatus->user_response_status==2 || $assignedStatus->assign_status==2)
                {
                    $status = "Rejected";
                    $buttonClas = "reject";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
                if($assignedStatus->assign_status==1 && $assignedStatus->user_response_status<=0)
                {
                    $status     = "Accepted";
                    $buttonClas = "accept";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
                  if($assignedStatus->assign_status==3 && $assignedStatus->user_response_status<=0)
                {
                    $status     = "Price marked";
                    $buttonClas = "accept";
                    $accePtDisable = "disabled";
                    $rejecttDisable = "disabled";
                    $completeDisable = "disabled";
                }
            
        }
        
       $price = $rows->job_price_from=="" || $rows->job_price_to==""?"NA":"AED ".$rows->job_price_from."-".$rows->job_price_to;
       echo implode("\t", array($rows->job_request_display_id,$rows->service_type_name,$location,date('d-m-Y', strtotime($rows->job_validity_date)),date('h:i A', strtotime($rows->job_validity_time)),$price,$status)) . "\n";
       
       $i++;
    }
    
              exit;
        }
        function printJobDetails()
        {
            
                 $job_request_id    =  $this->common_functions->decryptId($_GET['id']) ;
                 //$job_request_id    =  $this->common_functions->decryptId($this->input->post('itemId')) ;
                 $language          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
                 $result    =  $this->M_request->getJobSummary($job_request_id,$language); 
                 $question  =  $this->M_request->getQuestionsAgainstJobRequest($job_request_id); 
                 $files     =  $this->M_request->getUploadedFiles($job_request_id); 
                 $staus     =  $this->M_request->getAssignedStatus($this->session->userdata('eq_user_id'),$job_request_id);
                 
                   $date = new DateTime($result->job_time);
   
                             $timeFormated = $date->format('h:i A') ;
                             $date2 = new DateTime($result->job_date);
                             $daeFormated = $date2->format('d-m-Y') ;
                             
                             $date3 = new DateTime($result->job_validity_time);
                             $timeFormated2 = $date3->format('h:i A') ;
                             $date4 = new DateTime($result->job_validity_date);
                             $daeFormated2 = $date4->format('d-m-Y') ;
                             $user_id =$result->user_id;
                              if($result->is_home_category==0)
                                       {
                                           if($user_id>0)
                                           {
                                               $addressType        = $result->address_type;
                                               
                                               $alternateLocation  =   $this->M_request->getHomeLocation($user_id,$addressType); 
                                               
                                               $longiTude = $alternateLocation->user_adresses_longitude!=""?$alternateLocation->user_adresses_longitude:"";
                                               $latiTude = $alternateLocation->user_adresses_lattitude!=""?$alternateLocation->user_adresses_lattitude:"";
                                              // $overallAddress =$alternateLocation->user_adresses_location.",".$alternateLocation->city.",".$alternateLocation->state;
                                               $location = $alternateLocation->user_adresses_location!=""?$alternateLocation->user_adresses_location:"";
                                           }
                                       }
                                       else
                                       {
                                           $longiTude = $result->job_longitude!=""?$result->job_longitude:"";
                                           $latiTude = $result->job_lattitude!=""?$result->job_lattitude:"";
                                           $location = $result->job_location!=""? $result->job_location.",".$result->city.",".$result->state:"";
                                       }
                                       
                                       $languageCode          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
                                       
                                      $priceRange = $result->job_price_to!=""?"AED ".$result->job_price_from."-".$result->job_price_to:"NA";
                                      
                                       if($result->job_request_status==4)
                                       {
                                           $jobStatus = $this->lang->line("approved");
                                          
                                       }
                                        else if($result->job_request_status==5)
                                       {
                                           $jobStatus = $this->lang->line("completed");
                                          
                                       }
                                       else if($result->job_request_status==2)
                                       {
                                           $jobStatus = $this->lang->line("rejected");
                                          
                                       }
                                       else
                                       {
                                           $jobStatus = $this->lang->line("pending");
                                       }
                 $language          =  $this->session->userdata("language")>0? $this->session->userdata("language"):1;  
                 $this->load->library('Fpdf_gen');
                 //$this->fpdf->addPage('L');
                 $this->fpdf->SetFont('Arial','',10);
                 $this->fpdf->SetFillColor(193,229,252); 
                 
                // $fileName     = 'job_details_report_on'.date('Y_m_d').'.xls';
                 
                 $image1 = base_url().'frontend_assets/images/logo/logo.png';
                 //$this->fpdf->Image(base_url().'frontend_assets/images/logo/logo.png',10,10,0);
                 $this->fpdf->Cell( 60, 60, $this->fpdf->Image($image1, $this->fpdf->GetX(), $this->fpdf->GetY(), 45.78), 0, 1, 'L', false );
                 //$data["job"]  =   $this->M_admin->getUsersCondition($condition);
                 $this->fpdf->Cell(180,10,'JOB DETAILS',1,1,C,true);
                 //$this->fpdf->SetFillColor(193,229,252); // Background color of header 
                // $width_cell=array(20,40,40,30);
                 // Header starts /// 
                 $this->fpdf->SetFont('Arial','',10);
                 $this->fpdf->SetFillColor(255,255,255); 
                 $this->fpdf->Cell(60,10,'Job number: '.$result->job_request_display_id,1,0,C,true); // First header column 
                 $this->fpdf->Cell(60,10,'Job status: '.$jobStatus,1,0,C,true); // First header column
                 $this->fpdf->Cell(60,10,'Service type: '.$result->service_type_name,1,1,C,true); // Second header column
                 $this->fpdf->Cell(60,10,'Price: '.$priceRange,1,0,C,true);
                 $this->fpdf->Cell(60,10,'Validity date: '.$daeFormated,1,0,C,true); // Second header column
                 $this->fpdf->Cell(60,10,'Validity time: '.$timeFormated,1,1,C,true); // Second header column
                 $this->fpdf->Cell(180,10,'Location: '.$location,1,1,C,true); // Second header column
                 $this->fpdf->SetFont('Arial','',10);
                 $this->fpdf->SetFillColor(193,229,252);
                 $this->fpdf->Cell(180,10,'Customer needs',1,1,C,true); // Second header column
                 $this->fpdf->SetFont('Arial','',10);
                 $this->fpdf->SetFillColor(255,255,255); 
                  $question_id =0;
                          if(count($question)>0)
                             {
                                 $k=0;
                                 foreach($question as $rows)
                                 {
                                     
                                      $answer =($languageCode==2 && $rows->answer_option_arabic!=""?$rows->answer_option_arabic:$rows->answer_option);
                                      $answer                                        =  $answer!=""?$answer:$rows->answer;
                                       if($question_id!=$rows->question_id)
                                     {
                                         $question = ($languageCode==2 && $rows->question_arb!=""?$rows->question_arb:$rows->question);
                                         
                                         $this->fpdf->Cell(120,10,$question,1,0,C,true); // Second header column
                                         $this->fpdf->Cell(60,10,$answer,1,1,C,true); // Second header column
                                     }
                                     $question_id  = $rows->question_id;
                                     
                                     
                                 }
                             }     
                  $this->fpdf->Cell(40,10,'Remarks',1,0,C,true); // Second header column
                  $this->fpdf->Cell(140,10,$result->description,1,1,C,true); // Second header column
                  $pdfFileName = "job_details_".$result->job_request_display_id."_".date("dmYHis")."."."pdf";
                 echo $this->fpdf->Output($pdfFileName,'D');
                 
                 
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
//      if (preg_match_all($regex_lowercase, $password) < 1)
//      {
//          $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
//          return FALSE;
//      }
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
  function alpha_space($fullname)
  {
    if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
        $this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & White spaces');
        return FALSE;
    } else {
        return TRUE;
    }
  }
public function custom_minlength_check($field_value="") 
    {
        $field_value = strip_tags($field_value);
        if (strlen($field_value) < 10 )
        {
            $this->form_validation->set_message('custom_minlength_check', "Please enter atleast 10 characters");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    
    function getAddEditForm(){

        $data= [];
        $id = $this->input->post('id');
        if($id > 0)
          $data['user_details'] =  $this->M_request->getUserDetails($id);
        $data['country_list']        = $this->M_request->getCountryList();
        $data['id']        = $id;
        $view = $this->load->view('add_edit_staff',$data);
     }

     function getStaffList(){

        $this->load->library('pagination');
        $limit_per_page       = $_POST['limit_per_page']>0?$_POST['limit_per_page']:10;
        $start_index            =   ($this->uri->segment(4)>0 ?($this->uri->segment(4)-1)*$limit_per_page : 0);
        $total_records          =   $this->M_request->getStaffListCount($_POST);
        // echo $records;
        if($total_records){
          $data['result'] = $this->M_request->getUsersList($limit_per_page, $start_index);
          $config['base_url']     =   base_url().'website/Request/getStaffList';
          $config['total_rows']     =   $total_records;
          $config['per_page']     =   $limit_per_page;
          $config["uri_segment"]    =   4;
             
            // custom paging configuration
          $config['num_links']      =   2;
          $config['use_page_numbers']   =   TRUE;
          $config['reuse_query_string']   =   TRUE;
             
          $config['full_tag_open']    =   '<ul class="pagination">';
          $config['full_tag_close']     =   '</ul>';
             
          $config['first_link']         =   $this->lang->line('first');
          $config['first_tag_open']     =   '<li>';
          $config['first_tag_close']    =   '</li>';
             
          $config['last_link']      =   $this->lang->line('last');
          $config['last_tag_open']    =   '<li>';
          $config['last_tag_close']     =   '</li>';
             
          $config['next_link']      =   '&gt;';
          $config['next_tag_open']    =   '<li>';
          $config['next_tag_close']     =   '</li>';
 
          $config['prev_link']      =   '&lt;';
          $config['prev_tag_open']    =   '<li>';
          $config['prev_tag_close']     =   '</li>';
 
          $config['cur_tag_open']     =   '<li class="active"><span>';
          $config['cur_tag_close']    =   '</span></li>';
 
          $config['num_tag_open']     =   '<li>';
          $config['num_tag_close']    =   '</li>';
          $config["num_links"]                     =  6;
             
          $this->pagination->initialize($config);
          $data["links"] = $this->pagination->create_links();
        }

        $this->load->view('staff_list_ajax',$data);
     }
     
     
    public function getUserAddressList(){
        $this->load->model('website/M_user');
        $user_id = $this->session->userdata('eq_user_id');
        if($user_id > 0 ){
            $data['address_list'] = $this->M_request->getUserAddressList($user_id);
            $address = $this->load->view('address_list_ajax',$data);
            return $address;
        }

    }
    
    public function getUserAddressList_ajax(){
        $this->load->model('website/M_user');
        $user_id = $this->session->userdata('eq_user_id');
        if($user_id > 0 ){
            $data['address_list'] = $this->M_request->getUserAddressList($user_id);
            $address = $this->load->view('user_address_list_ajax',$data);
            return $address;
        }

    }
    
    public function getUserAddressDetails(){
        $this->load->model('website/M_user');
        $address_id  = $this->input->post('id');
        $data['address_details'] = $this->M_request->getUserAddressDetails($address_id);
        $user_id = $this->session->userdata('eq_user_id');
        if(!$address_id)
            $data['user_details'] = $this->M_user->getUserDetailsById($user_id);
        $data['country_list']         = $this->M_request->getCountryList();
    
        return $this->load->view('edit_address_form',$data);
    }
    
    
    public function getCityListByCountryId(){
        $country_id = $this->input->post('country_id');

        $country_list = $this->M_request->getCityListByCountryId($country_id);  
        $html = "<option value='' >Choose City</option>";
        if($country_list){
            foreach ($country_list as $key => $value) {
                $html = $html."<option value ='".$value->city_id."'>".$value->city_name."</option>";
            }
        }else{
            $htlml = "<option>Selected country has no city</option>";
        }
        
        echo $this->db->last_query();
        
        echo $html;
    }
    
    public function getAreaByCityId(){

        $city_id = $this->input->post('city_id');

        $area_list = $this->M_request->getAreaListByCityId($city_id);  
        $html = "";
        if($area_list){
            $html = "<option >Choose area</option>";
            foreach ($area_list as $key => $value) {
                $html = $html."<option value ='".$value->area_id."'>".$value->area_name."</option>";
            }
        }else{
            $html = $html."<option value=''>Selected city has no area</option>";
        }
        
        echo $html;
    }

    public function validate_phone_number( $phone_number )
    {
        // $this->load->model('website/M_user'); 
        if (! empty($phone_number) ) {
            
            $zero_pos = strpos($phone_number, '0');
            if( $zero_pos !== false)
            {
                if($zero_pos == 0)
                {
                    $this->form_validation->set_message('validate_phone_number', '{field} connot contain zero at starting.');
                    return FALSE;
                }
            }
            
            $condition = ['user_phone' => $phone_number];
            $dial_code = $this->input->post('user_dial_code', true);
            if (! empty($dial_code) ) {
                $condition['dial_code'] = $dial_code;
            }
            // $record = $this->M_user->get_user($condition);
            // if (! empty($record) ) {
            //     $this->form_validation->set_message('validate_phone_number', '{field} is already registered.');
            //     return FALSE;
            // }
        }
        return TRUE;
    }
    
    public function saveUserAddress(){

        $user_id    = $this->session->userdata('eq_user_id');
        $address_id = $this->input->post("address_id");

        $this->form_validation->set_rules('pickup-input2', 'pickup-input2', 'trim|required');
        $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('user_phone', 'user_phone', 'trim|required|callback_validate_phone_number');
        $this->form_validation->set_rules('country', 'country', 'trim|required');
        $this->form_validation->set_rules('area', 'area', 'trim|required');
        $this->form_validation->set_rules('building_name', 'building name', 'trim|max_length[100]|xss_clean');
        $this->form_validation->set_rules('street_name', 'street name', 'trim|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE){
            $data['status'] = 0;
            $data['errors'] = array(
                                    'pickup-input2' => form_error('pickup-input2'),
                                    'first_name'    => form_error('first_name'),
                                    'last_name'     => form_error('last_name'),
                                    'email'         => form_error('email'),
                                    'user_phone'    => form_error('user_phone'),
                                    'country'       => form_error('country'),
                                    'area'          => form_error('area'),
                                    'city'          => form_error('city'),
                                    'building_name' => form_error('building_name'),
                                    'street_name'   => form_error('street_name'),
                                );
            echo json_encode($data);
            exit();   
        }else{

            $i_data = array('user_id' => $user_id,
                      'user_adresses_location' => $this->input->post('pickup-input2'),
                      'user_adresses_longitude' => $this->input->post('pickup-longittude2'),
                      'user_adresses_lattitude' => $this->input->post('pickup-lattitude2'),
                      'user_adresses_type_id'   => $this->input->post('address_type'),
                      'user_adresses_status'    => 1,//$this->input->post('user_adresses_status'),
                      'first_name'              => $this->input->post('first_name'),
                      'last_name'               => $this->input->post('last_name'),
                      'email'                   => $this->input->post('email'),
                      'dial_code'               => $this->input->post('dial_code'),
                      'user_phone'              => $this->input->post('user_phone'),
                      'building_name'           => $this->input->post('building_name'),
                      'street_name'             => $this->input->post('street_name'),
                      'user_adresses_country'   => $this->input->post('country'),
                      'default_address'         => $this->input->post('defalut_address')?1:0,
                      'user_adresses_area'      => $this->input->post('area'),
                      'user_adresses_city'      => $this->input->post('city'),
                      'land_mark'               => $this->input->post('land_mark'),
                    );
            // print_r($i_data);exit;
            if(!$address_id){
                $i_data['user_adresses_created_time'] = date('Y-m-d');
            }
            
            $result = $this->M_request->saveAddressData($i_data,$address_id);
            
            if($result){
                $data['status']     = 1;
                $data['message']    = "Address saved successfully"; 
            }else{
                $data['status']     = 0;
                $data['message']    = "Failed to save address"; 
            }
            
            echo json_encode($data);
        } 
    }

    public function deleteAddressData(){
        
        $address_id = $this->input->post('id');
        // echo $address_id;
        $result     = $this->M_request->deleteAddressData($address_id);
        echo $result;
    }
    
    
    public function saveRequest()
    {        
        /*print_r(json_decode($_POST['selectedAnsOptions'],true));
        print_r($_POST);die;*/
        $this->form_validation->set_rules('option', 'Request type', 'trim|required');
        $this->form_validation->set_rules('valTime', 'Work expiry time', 'trim|required');
        $this->form_validation->set_rules('valdate', 'Work expiry date', 'required'); 

        $this->form_validation->set_rules('service_date', 'service_date', 'trim|required');
        $this->form_validation->set_rules('serviceTime', 'Service time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price_from', 'Price from', 'trim|required');
        $this->form_validation->set_rules('price_to', 'Price to', 'trim|required');
        // $this->form_validation->set_rules('addressType', 'Address type', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
     
              // echo validation_errors();
            $data['status'] = 0;
            $data['errors'] = array(
              'datetimepicker3' => form_error('valTime'),
              'datetimepicker4' => form_error('valdate'),
              // 'us5-city' => form_error('city'),
              // 'us5-state' => form_error('state'),
              // 'us5-street1' => form_error('street'),
              'txtRemark' => form_error('discription'),
              'service_date' => form_error('service_date'),
              'price_from' => form_error('price_from'),
              'price_to' => form_error('price_to')
          );
            echo json_encode($data);
            exit();
        }else{
            $input = [];
            if($_FILES["document"]["name"] ){

                    $abc = FALSE; 
                    $temp_name =$_FILES['document']['tmp_name'];

                    $real_name  = strtolower($_FILES['document']['name']);
                    $img_ext = end(explode(".", $real_name));

                    $upload_dir    =   $this->config->item('upload_path').'quotations/';
                    $digits =6;

                    $up_file_name="";
                    $up_file_name   =   str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis").".".$img_ext;

                    $file_path  =  $upload_dir . $up_file_name;
                    $abc        =   move_uploaded_file($temp_name, $file_path);
                    
                    if($abc===FALSE){
                        $data['status'] = 0;
                        $data['errors'] = array(
                            'document' => "File upload failed",
                        );
                        echo json_encode($data);
                        exit();
                   }else{
                        $input['document']   = $up_file_name;
                   }
                
            }
            
            // print_r($input);exit;

            $discount                   = 0;

            $service_type_id            = $this->input->post('service_type_id');
            $address_id                 = $this->input->post('address_id');

            $address_details            = $this->M_request->getUserAddressDetails($address_id);
            $providerList               = $this->M_request->getProviderListByArea($address_details->area_id,$service_type_id);
            // print_r($providerList);exit;
            
            $input['address_type']      = $address_details->user_adresses_type_id;
            $input['city']              = $address_details->city_name;
            $input['area']              = $address_details->area_name;
            $input['address_id']        = $address_id;
            $area_id                    = $address_details->user_adresses_area;            

            $input['job_location']      = $address_details->user_adresses_location;
            $input['job_longitude']     = $address_details->user_adresses_longitude;
            $input['job_lattitude']     = $address_details->user_adresses_lattitude;

            $input['user_id']           = $this->session->userdata('eq_user_id');
            $input['service_type_id']   = $service_type_id;
            $input['job_date']          = date("Y-m-d",strtotime($this->input->post('valdate')));
            $input['job_time']          = date("H:i:s",strtotime($this->input->post('valTime')));

            $input['job_price_from']    = $this->input->post('price_from');
            $input['job_price_to']      = $this->input->post("serviceTotPricePass");
            $input['payment_method']    = $this->input->post('payment_option');            
            $input['job_total_price']  = $this->input->post('serviceTotPricePass');

            $input['description']       = $this->input->post('discription');             
            $input['job_validity_date'] = date("Y-m-d",strtotime($this->input->post('valdate')));
            $input['job_validity_time'] = date("H:i:s",strtotime($this->input->post('valTime'))); 

            $input['job_request_status']= 0;
            $input['job_request_created_time'] = date("Y-m-d H:i:s");
            
            $total_amount                = $input['job_total_price'];
            $coupon_code                 = $this->input->post('coupon_code');
            $coupon_id                   = 0; 
            if($coupon_code){ 
                if($couponData = $this->validate_coupon_code($coupon_code,$input['user_id'] )){
                    if($total_amount >= $couponData[0]->coupon_minimum_spend){
                        $discount       = $couponData[0]->coupon_amount;
                        $discount       = ( $total_amount * $discount ) / 100 ;
                        $total_amount   = $total_amount - $discount;
                        $coupon_id      = $couponData[0]->coupon_id;
                    }
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }

            $vat_amount                      = ( $total_amount * VAT ) / 100;   

            $input['grand_total']            = $vat_amount+ $total_amount;
            $input['vat_percentage']         = VAT;
            $input['discount']               = $discount;

            $input['job_request_type']       = 2;
            $input['job_request_status']     = 0;
            $input['job_request_created_time'] = date("Y-m-d H:i:s");

            // print_r($input);exit;
            $this->load->library("Common_functions");
            $randomString =  $this->common_functions->incrementalHash(2);

            $firstString = "R";
            $input['job_request_display_id'] = $firstString.$randomString.$input['user_id'].date("mdHis");

            if(!empty($providerList))
                $input['is_approoved'] = 1;
            else
                $input['is_approoved'] = 0;

            $questions      = $this->input->post('question');
            $questAnsOptions  = json_decode($_POST['selectedAnsOptions'],true);

            $input['request_mode']  = $this->input->post('service_request_mode');
            $input['selected_days'] = $this->input->post('selected_days');

            $selected_date  = date("Y-m-d",strtotime($this->input->post('valdate')));
            $service_request_mode   = $this->input->post('service_request_mode');
            $selected_days_arr      = (explode(",", $this->input->post('selected_days')));

            $job_days   = [];
            if($service_request_mode == REQUESTMODE_ONETIME)
            {
                $job_days[]     = $selected_date;
            }
            if($service_request_mode == REQUESTMODE_WEEKLY)
            {
                for($i = 0;$i <= 6;$i++)
                {
                    $day    = date('w',strtotime($selected_date . "+".$i." days"));
                    if(in_array($day, $selected_days_arr))
                    {
                        $job_days[]     = date('Y-m-d',strtotime($selected_date . "+".$i." days"));
                    }
                }
            }

            else if($service_request_mode == REQUESTMODE_MONTHLY)
            {
                $date   = $selected_date;
                for($week = 1;$week <=4;$week++)
                {
                    for($i = 0;$i <= 6;$i++)
                    {
                        $day    = date('w',strtotime($date . "+".$i." days"));
                        if(in_array($day, $selected_days_arr))
                        {
                            $job_days[]     = date('Y-m-d',strtotime($date . "+".$i." days"));
                        }
                    }
                    $date   = date('Y-m-d',strtotime($date . "+7 days"));
                }
            }

            $input['job_days']  = $job_days;
//             echo "<pre>";
// var_dump($questAnsOptions);
// foreach ($questAnsOptions as $key => $value) {
//   $value=explode(",", $value);
//   var_dump($value);
// }
//              exit;
            
            // $providers      = $this->input->post('mappedItems');
            
            // print_r($input);exit;
            //if($result = $this->M_request->saveRequest($input,$questions,$providerList)){
            if($result = $this->M_request->saveRequest($input,$questAnsOptions,$providerList)){
                
               
                if($coupon_id > 0 ){
                    $c_data['coupon_id']        = $coupon_id;
                    $c_data['coupon_used_by']   = $input['user_id'];
                    $c_data['used_date']        = gmdate('Y-m-d H:i:s');
                        
                    $this->M_request->userAppliedCoupon($c_data);
                }
                $notification_id  = time();
                if($providerList){
                    
                      $this->load->model('website/M_user'); 
                      $title                  =  "Job request received"; 
                      $description            =  "You have received a job request from user";
                      $ntype = "order-recived";
                      
                      $user_data = $this->M_user->getUserDetailsById($input['user_id']);
                      
                      foreach ($providerList as $key => $value) {
                          
                        $con['job_request_id']  = $result;
                        $con['provider_id']     = $value->user_id;
                        $description            =  "Hi ".$value->company_name.", You have received a job request from ".$user_data->user_first_name." ".$user_data->user_last_name;
                        $assign_job_details = $this->M_request->getAssignJobDetails($con);
                        
                        if (!empty($value->firebase_user_key)) {
                          $notification_data["Notifications/".$value->firebase_user_key."/".$notification_id] = [
                              "title" => $title,
                              "description" => $description,
                              "notificationType" => $ntype,
                              "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                              "orderID" => (string) $assign_job_details->assign_job_provider_id,
                              "service_type_name" => $service->service_type_name,
                              "url" => "",
                              "imageURL" => "",
                              "read" => "0",
                              "seen" => "0"
                          ];

                          $fb_database = get_firebase_refrence();
                          $fb_database->getReference()->update($notification_data);
                        }

                        if (! empty($value->fcm_token) ) {
                          $this->load->library("FCM_Notification");
                          $this->fcm_notification->send_single_notification($value->fcm_token, [
                              "title" => $title,
                              "body" => $description,
                              "icon"=>'myicon',
                              "sound" =>'default',
                              "click_action" => "vendor_notification"],
                              ["type" => "order-placed",
                              "notificationID" => $notification_id,
                              "orderID" => (string) $assign_job_details->assign_job_provider_id,
                              "service_type_name" => $service->service_type_name,
                              "imageURL" => ""
                          ]);
                        }
                      }
                    }
            }
            echo $result;

        }
    }

    private function validate_coupon_code($coupon_code,$user_id){
        $this->load->model('website/M_user'); 
        if($coupon_code){
            $condition = array('coupon_code' => $coupon_code);
            $result = $this->M_user->validate_coupon_code($condition,$user_id);
            return $result;    

        }else{
            return FALSE;
        }
    }

     public function getUserWallet(){
        $this->load->model('website/M_user');
        $user_id = $this->session->userdata('eq_user_id');
        $result     = [];
        if($user_id > 0 ){
            $getUserDetails = $this->M_request->getUserDetails($user_id); 
            $result['wallet_balance'] =$getUserDetails->wallet_balance;
            echo json_encode($result);
        }
    }


    public function payment_init(){
        $this->load->library('Stripe_lib');
        $this->form_validation->set_rules('option', 'Request type', 'trim|required');
        $this->form_validation->set_rules('valTime', 'Work expiry time', 'trim|required');
        $this->form_validation->set_rules('valdate', 'Work expiry date', 'required'); 

        $this->form_validation->set_rules('service_date', 'service_date', 'trim|required');
        $this->form_validation->set_rules('serviceTime', 'Service time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price_from', 'Price from', 'trim|required');
        $this->form_validation->set_rules('price_to', 'Price to', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
     
              // echo validation_errors();
            $data['status'] = 0;
            $data['errors'] = array(
              'datetimepicker3' => form_error('valTime'),
              'datetimepicker4' => form_error('valdate'),
              'txtRemark' => form_error('discription'),
              'service_date' => form_error('service_date'),
              'price_from' => form_error('price_from'),
              'price_to' => form_error('price_to')
          );
            echo json_encode($data);
            exit();
        }else{
            $input = [];

            if($_FILES["document"]["name"] ){

                    $abc = FALSE; 
                    $temp_name =$_FILES['document']['tmp_name'];

                    $real_name  = strtolower($_FILES['document']['name']);
                    $img_ext = end(explode(".", $real_name));

                    $upload_dir    =   $this->config->item('upload_path').'quotations/';
                    $digits =6;

                    $up_file_name="";
                    $up_file_name   =   str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).date("YmdHis").".".$img_ext;

                    $file_path  =  $upload_dir . $up_file_name;
                    $abc        =   move_uploaded_file($temp_name, $file_path);
                    
                    if($abc===FALSE){
                        $data['status'] = 0;
                        $data['errors'] = array(
                            'document' => "File upload failed",
                        );
                        echo json_encode($data);
                        exit();
                   }else{
                        $input['document']   = $up_file_name;
                   }
                
            }


            $discount                   = 0;
            $service_type_id            = $this->input->post('service_type_id');
            $address_id                 = $this->input->post('address_id');

            $address_details            = $this->M_request->getUserAddressDetails($address_id);
            // $providerList               = $this->M_request->getProviderListByArea($address_details->area_id,$service_type_id);

            $input['address_type']      = $address_details->user_adresses_type_id;
            $input['city']              = $address_details->city_name;
            $input['area']              = $address_details->area_name;
            $input['address_id']        = $address_id;
            $area_id                    = $address_details->user_adresses_area;            

            $input['job_location']      = $address_details->user_adresses_location;
            $input['job_longitude']     = $address_details->user_adresses_longitude;
            $input['job_lattitude']     = $address_details->user_adresses_lattitude;

            $input['user_id']           = $this->session->userdata('eq_user_id');
            $input['service_type_id']   = $service_type_id;
            $input['job_date']          = date("Y-m-d",strtotime($this->input->post('valdate')));
            $input['job_time']          = date("H:i:s",strtotime($this->input->post('valTime')));

            $input['job_price_from']    = $this->input->post('price_from');
            $input['job_price_to']      = $this->input->post("serviceTotPricePass");
            $input['payment_method']    = $this->input->post('payment_option');            
            $input['job_total_price']  = $this->input->post('serviceTotPricePass');

            $input['description']       = $this->input->post('discription');             
            $input['job_validity_date'] = date("Y-m-d",strtotime($this->input->post('valdate')));
            $input['job_validity_time'] = date("H:i:s",strtotime($this->input->post('valTime'))); 

            $input['job_request_status']= 0;
            $input['job_request_created_time'] = date("Y-m-d H:i:s");

            $total_amount                = $input['job_total_price'];
            $coupon_code                 = $this->input->post('coupon_code');
            // $input['coupon_code']        = $coupon_code;

            $coupon_id                   = 0; 
            if($coupon_code){ 
                if($couponData = $this->validate_coupon_code($coupon_code,$input['user_id'] )){
                    if($total_amount >= $couponData[0]->coupon_minimum_spend){
                        $discount       = $couponData[0]->coupon_amount;
                        $discount       = ( $total_amount * $discount ) / 100 ;
                        if($couponData[0]->coupon_maximum_spend > 0 ){                            
                            if($discount > $couponData[0]->coupon_maximum_spend ){
                                $discount  = $couponData[0]->coupon_maximum_spend;
                            }            
                        }
                        $total_amount   = $total_amount - $discount;
                        $coupon_id      = $couponData[0]->coupon_id;
                    }
                }else{
                    $discount = 0;
                }
            }else{
                $discount = 0;
            }

            print_r($discount);exit;
            $input['coupon_id']              = $coupon_id;

            $vat_amount                      = ( $total_amount * VAT ) / 100;   

            $input['grand_total']            = $vat_amount+ $total_amount;
            $input['vat_percentage']         = VAT;
            $input['discount']               = $discount;

            $input['job_request_type']       = 2;
            $input['job_request_status']     = 0;
            $input['job_request_created_time'] = date("Y-m-d H:i:s");

            // print_r($input);exit;
            $this->load->library("Common_functions");
            $randomString =  $this->common_functions->incrementalHash(2);

            $firstString = "R";
            $input['job_request_display_id'] = $firstString.$randomString.$input['user_id'].date("mdHis");

            $input['is_approoved'] = 0;

            $questions      = $this->input->post('question');
            $questAnsOptions  = json_decode($_POST['selectedAnsOptions'],true);

            $job_request_temp_id = $this->M_request->saveTempRequest($input,$questAnsOptions);
            $service_details = $this->M_request->getServiceTypeById($service_type_id);

            $data=array(
                'statusCode'=>'0',
                'amount'=>$input['grand_total'],
                'UserId'=>$this->session->userdata('eq_user_id'),
                'payment_type' =>2,
                'job_request_id' => $job_request_temp_id
            );

            $invoiceId = $this->model_payment->insert_to('user_invoice',$data);
            $response=array();
            $data['client_reference_id']=$invoiceId;
            $data['product'] = $service_details->service_type_name;
            // $data['description'] = $input['description'];
            $data['quantity'] = 1;
            $data['image'] = base_url().'template/images/header-logo.png';

            $data['success_url'] = base_url().'website/request/client_checkout?session_id={CHECKOUT_SESSION_ID}';
            $data['cancel_url'] = base_url().'website/requestclient_cancel?session_id={CHECKOUT_SESSION_ID}';
            $data['amount'] = $input['grand_total'] * 100;
            $data['email'] = $address_details->email??'';

            $session = $this->stripe_lib->create_session($data);
            $session_data = json_decode(json_encode($session), true);
            $data['session_id'] = $session_data['id'];
            $ref=$response['ref']= $session_data['id'];
            $response['url']= base_url('payment/stripe/'.$session_data['id']);
            $response['status']="200";
            $response['message']="success";
            $response['update']= $this->model_payment->update_where('user_invoice',array('invoiceid'=> $invoiceId),array('RefId'=>$ref));
            $this->output->set_output(json_encode($response)); 
        }
    }

    public function client_checkout(){
        $this->load->library('Stripe_lib');
        $session_id = $this->input->get('session_id');
        $session_data = $this->stripe_lib->retrieve_session($session_id);
        $my_session = json_decode(json_encode($session_data), true);
        
        $data['stripe_id'] = $id = $my_session['id'];
        $payment_data = $this->stripe_lib->retrieve_payment($my_session['payment_intent']);
        $payment_data = json_decode(json_encode($payment_data), true);
        $client_reference_id =  $my_session['client_reference_id'];

        $statuscode = ($my_session['payment_status']=="paid")?3:2; // 3-Paid | 2-On Hold
        $status = $my_session['payment_status']??'';
        $updateData=array('statusCode'=>$statuscode,'Status'=>$status,'response'=>json_encode($payment_data));

        $updateData=array('statusCode'=>$statuscode,'Status'=>$status,'response'=>json_encode($payment_data));
        $this->model_payment->update_where('user_invoice',array('invoiceid'=> $client_reference_id),$updateData);
        // echo $statuscode;
        if( $statuscode==3 || $statuscode==2 ){
            // redirect(base_url('thankyou/'.$result));
            $result = $this->place_order($client_reference_id);
            $this->load->helper('url');
            if($result > 0){ 
                redirect(base_url('thankyou/'.$result));
            }else{
                redirect(base_url('failure/'));
            }
        }else{
            redirect(base_url('failure/')); 
        }
        
    }


    public function place_order($invoiceId){

        $invoiceDetails= $this->model_payment->get_one('user_invoice',array('invoiceid'=> $invoiceId));
        $temp_order_row = $this->M_request->get_tem_order($invoiceDetails['job_request_id']);
        // echo "<pre>";print_r($temp_order_row);exit;
        $i_data = array('user_id' => $temp_order_row->user_id, 
                        'service_type_id'=>$temp_order_row->service_type_id,
                        'address_type'=>$temp_order_row->address_type,
                        'job_date'=>$temp_order_row->job_date,
                        'job_time'=>$temp_order_row->job_time,
                        'job_validity_date'=>$temp_order_row->job_validity_date,
                        'job_validity_time'=>$temp_order_row->job_validity_time,
                        'job_price_from'=>$temp_order_row->job_price_from,
                        'job_price_to'=>$temp_order_row->job_price_to,
                        'job_request_status'=>$temp_order_row->job_request_status,
                        'job_request_created_time'=>$temp_order_row->job_request_created_time,
                        'job_location'=>$temp_order_row->job_location,
                        'job_longitude'=>$temp_order_row->job_longitude,
                        'job_lattitude'=>$temp_order_row->job_lattitude,
                        'job_request_type'=>$temp_order_row->job_request_type,
                        'document'=>$temp_order_row->document,
                        'city'=>$temp_order_row->city,
                        'state'=>$temp_order_row->stat,
                        'description'=>$temp_order_row->description,
                        'job_request_display_id'=>$temp_order_row->job_request_display_id,
                        'job_total_price'=>$temp_order_row->job_total_price,
                        'address_id'=>$temp_order_row->address_id,
                        'area'=>$temp_order_row->area,
                        'payment_method'=>2,
                        'vat_percentage'=> $temp_order_row->vat_percentage,
                        'discount'=>$temp_order_row->discount,
                        'grand_total'=>$temp_order_row->grand_total

                    );
        $address_details            = $this->M_request->getUserAddressDetails($temp_order_row->address_id);
        $providerList               = $this->M_request->getProviderListByArea($address_details->area_id,$temp_order_row->service_type_id);
        
        if(!empty($providerList))
            $i_data['is_approoved'] = 1;
        else
            $i_data['is_approoved'] = 0;

        $questAnsOptions = $this->M_request->getTempQuestionAnswer($invoiceDetails['job_request_id']);
        $result          = $this->M_request->createNewJobRequest($i_data,$questAnsOptions,$providerList);
        
        if($result){
            if($temp_order_row->coupon_id > 0 ){
                $c_data['coupon_id']        = $coupon_id;
                $c_data['coupon_used_by']   = $input['user_id'];
                $c_data['used_date']        = gmdate('Y-m-d H:i:s');
                        
                $this->M_request->userAppliedCoupon($c_data);
            }

            $notification_id  = time();
            if($providerList){
                $this->load->model('website/M_user'); 
                $title                  =  "Job request received"; 
                $description            =  "You have received a job request from user";
                $ntype = "order-recived";
                      
                $user_data = $this->M_user->getUserDetailsById($input['user_id']);
                      
                foreach ($providerList as $key => $value) {
                          
                    $con['job_request_id']  = $result;
                    $con['provider_id']     = $value->user_id;
                    $description            =  "Hi ".$value->company_name.", You have received a job request from ".$user_data->user_first_name." ".$user_data->user_last_name;
                    $assign_job_details = $this->M_request->getAssignJobDetails($con);
                        
                    if (!empty($value->firebase_user_key)) {
                        $notification_data["Notifications/".$value->firebase_user_key."/".$notification_id] = [
                              "title" => $title,
                              "description" => $description,
                              "notificationType" => $ntype,
                              "createdAt" => gmdate("d-m-Y H:i:s", $notification_id),
                              "orderID" => (string) $assign_job_details->assign_job_provider_id,
                              "service_type_name" => $service->service_type_name,
                              "url" => "",
                              "imageURL" => "",
                              "read" => "0",
                              "seen" => "0"
                        ];

                        $fb_database = get_firebase_refrence();
                        $fb_database->getReference()->update($notification_data);
                    }

                    if (! empty($value->fcm_token) ) {
                        $this->load->library("FCM_Notification");
                        $this->fcm_notification->send_single_notification($value->fcm_token, [
                            "title" => $title,
                            "body" => $description,
                            "icon"=>'myicon',
                            "sound" =>'default',
                            "click_action" => "vendor_notification"],
                            ["type" => "order-placed",
                            "notificationID" => $notification_id,
                            "orderID" => (string) $assign_job_details->assign_job_provider_id,
                            "service_type_name" => $service->service_type_name,
                            "imageURL" => ""
                        ]);
                    }
                }
            }
            return $result;
        }else{
            return 0;
        }
    }
}

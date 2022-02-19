<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authentication 
{

    public function authenticateApp() 
     {
        
               $CI                   =        &get_instance();             
               $headers        =       $CI->input->request_headers();
               

               
               //print_r($CI->input->request_headers());
               
            //   $userName    =       $headers['APP-USER']!=""?$headers['APP-USER']:$headers['App-User'];
            //   $passWord    =       $headers['APP-PWD']!=""?$headers['APP-PWD']:$headers['App-Pwd'];
            
                $userName    =       $headers['APP-USER'] ?? $headers['App-User'];
               $passWord    =       $headers['APP-PWD'] ?? $headers['App-Pwd'];
               
               $CI->load->model('services/M_user');
               
               $input['user_id']              =     $userName;
               $input['password']          =     $passWord;
        /*      
             
               // $this->load->library("Email_teyaar");
                       //  $this->email_teyaar->SendEmail($message,$subject,$to);        
               $CI->load->library('Common_functions');
               
              $acces_token            =   trim($CI->input->post("acces_token"));        
              //$acces_token         =    '31dedc51dd8670b59f5c9e1db9efe2b9';
              $checkCode               =   $CI->common_functions->validateAccessToken($acces_token);               
              if($checkCode<=0)
              {
                    echo $userId      =     $CI->common_functions->showAccessTokenErrorMesssage($checkCode);
                    exit;
              }
              else
              {
                  $user_id               =   $checkCode ;
              }
             */
               $count                                      =   $CI->M_user->checkValidAppUser($input);
               if($count<=0)
               {
                   $response['status']            =  (string)0;
                   $response['message']       =   "Invalid Authentcation";
                  echo json_encode($response);
                  exit;
               }
               
            
    }

}
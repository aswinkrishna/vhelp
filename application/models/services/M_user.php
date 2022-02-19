<?php
class M_user extends CI_Model
{

   function saveUser($input1,$input2,$otp)
        {
                $this->db->select('count(user_email) as count');
                $this->db->from('user_table c');        
                $this->db->where('user_email',$input1['user_email']);        
                if($input1['user_id']>0)
                 {
                    $this->db->where('user_id !=', $input1['user_id']);
                }
                $query = $this->db->get();              
                if($query->row()->count>0)
                                {
                                        return -1;
                                        exit;
                                }
                                else
                                { 
                                            $this->db->trans_start();                                            
                                       
                                            
                                            if($input1['user_id']>0)
                                            {
                                                    $this->db->where('user_id',$input1['user_id']);
                                                    $this->db->update('user_table',$input1);                                                    
                                                    $this->db->where('user_id',$input1['user_id']);
                                                    $this->db->update('user_details',$input2);
                                                    
                                                    $return      =    $input1['user_id'];
                                            }
                                            else
                                            {
                                              /*  unset($input1['user_id']);                                                
                                                $this->db->insert('user_table',$input1);                                                
                                                $insertId = $this->db->insert_id();                                                
                                                $input2['user_id']      =   $insertId;                                                
                                                $this->db->insert('user_details',$input2);*/
                                                
                                                $this->db->where("user_email",$input1['user_email']);
                                                $this->db->delete('user_table_temp'); 
                                                
                                                $this->db->insert('user_table_temp',$input1);                                                
                                                $insertId = $this->db->insert_id();                                                
                                                
                                                $otp['user_id']       =  $insertId;
                                                
                                                $this->db->where("user_id",$insertId);
                                                $this->db->delete('otp'); 
                                                
                                                $this->db->insert('otp',$otp); 
                                                $insertId2 = $this->db->insert_id(); 
                                                
                                              
                                                $return      =    $insertId2;
                                                
                                            }
                                      
                                            
                                            $this->db->trans_complete();
                      
                                            if($this->db->trans_status() === FALSE)
                                             {

                                                 return 0;
                                             }
                                             else
                                             {
                                                return $return;
                                             }
                                    
                                }
        }
    function verifyOtp($data)
    {
        $otp                  =             $data['otp'];
        $tempOtpId            =             $data['otp_id'];//$this->common_functions->decryptId($data['txt_ver']);
        $sql                  =             "select *  from otp where otp_id=" . $tempOtpId . " and otp='" . $otp . "'";
        $rs                   =             $this->db->query($sql);
        $result               =             $rs->row();
        // print_r($this->db->last_query());
        $date                 =             gmdate("Y-m-d H:i:s");
        if ($date > $result->otp_validity_end_time && $result->otp_id > 0) {
            return -1;
        }
        if ($result->otp_id > 0) {
            $this->db->trans_start();

            $query = $this->db->query('INSERT INTO user_table (user_first_name, user_last_name, user_email,user_password,country_id,city_id,user_phone,user_dial_code,user_type,user_zip,user_status,user_image,user_device_token,user_device_type,user_access_token,user_created_by,user_created_time,user_updated_by,user_updated_time,user_created_methode,user_last_login,login_type,fcm_token,user_company_name)
                           SELECT user_first_name, user_last_name, user_email,user_password,country_id,city_id,user_phone,user_dial_code,user_type,user_zip,user_status,user_image,user_device_token,user_device_type,user_access_token,user_created_by,user_created_time,user_updated_by,user_updated_time,user_created_methode,user_last_login,login_type,fcm_token,user_company_name
                           FROM user_table_temp
                           WHERE user_id=' . $result->user_id . '');

            $insertId = $this->db->insert_id();

            $this->db->where("user_id", $result->user_id);
            $this->db->delete('user_table_temp');

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {


                return $insertId;
            }
        } else {
            return -2;
        }
    }
    function resendOtp($data, $otp)
    {
        $tempOtpId            =             $this->common_functions->decryptId($data['txt_ver']);
        $sql                  =             "select *  from otp where otp_id=" . $tempOtpId . "";
        $rs                   =             $this->db->query($sql);
        $result               =             $rs->row();
        $date                 =             gmdate("Y-m-d H:i:s");
       
        if ($result->otp_id > 0 && $result->user_id > 0) {
            $this->db->trans_start();
            $this->db->where('otp_id', $tempOtpId);
            $this->db->update('otp', $otp);
            $this->db->trans_complete();
            
            $this->db->select('*');
            $this->db->where('otp_id',$result->otp_id);
            $otp = $this->db->get('otp')->row();
            // print_r($otp);
            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {


                return $result->user_id;
            }
        } else {
            return 0;
        }
    }
    function userLogin($data)
    {
        $query = $this->db->get_where('user_table', $data);
        // echo $this->db->last_query();
        return $query->row();
    }
    function saveProvider($input1, $input2, $services, $area)
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



            $this->db->insert('user_table', $input1);
            $insertId = $this->db->insert_id();
            $input2['user_id']      =   $insertId;
            $this->db->insert('provider_details', $input2);

            $serviceTypes  =  explode(",", $services['service_type_ids']);
            $serviceTypes  =  array_filter($serviceTypes);
            if (count($serviceTypes) > 0) {
                $i = 0;
                foreach ($serviceTypes as $rows) {
                    $userGroup = array();
                    $provServiceType[$i]['service_type_id']  = $rows;
                    $provServiceType[$i]['provider_id']      = $insertId;

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
                        $userGroup['user_id']                     =  $insertId;
                        $this->db->where('user_id', $insertId);
                        $this->db->where('notification_group_name', $userGroup['notification_group_name']);
                        $this->db->where('fcm_key', $userGroup['fcm_key']);
                        $this->db->delete('user_notification_groups');
                        $this->db->insert('user_notification_groups', $userGroup);
                    }



                    $i++;
                }

                $area = explode(",", $area['area_list_ids']);
                $data['provider_id']  = $insertId;
                $data['area_status']  = 0;
                $data['created_at']   = gmdate("Y-m-d H:i:s");
                foreach ($area as $key => $value) {
                    $data['area_id']      = $value;
                    $this->db->insert('provider_areas', $data);
                }

                $this->db->where('provider_id', $insertId);
                $this->db->delete('provider_service_type');
                //  print_r($provServiceType);
                $this->db->insert_batch('provider_service_type', $provServiceType);
                //  echo $this->db->last_query();
            } else {
                return 0;
            }




            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                if ($insertId > 0) {
                    $subject = "Welcome to Vhelp ";
                    $userMaiArray['user_name'] = $input2['company_name'];
                    $to               = $input1['user_email'];
                    $userMaiArray['subject']  = $subject;
                    $userMaiArray['message']  = "Your account will be activated after verification. We will let you know, once the verification is completed";
                    $this->load->library('parser');
                    $email_message  = $this->parser->parse('email/register', $userMaiArray, true);
                    $this->load->library("Mail_function");
                    $this->mail_function->SendEmail($email_message, $subject, $to);
                }

                return 1;
            }
        }
    }
    /*function getProviderFullDetails($userId, $language)
    {
        $this->db->select('*,u.user_id as userid');
        $this->db->from('user_table u');
        $this->db->join('provider_details u2', 'u.user_id =u2.user_id', 'left');
        $this->db->join('country c', '(c.country_id =u.country_id) AND (c.country_language_code=' . $language . ')', 'left');
        $this->db->join('city c2', '(c2.city_id =u.city_id) AND (c2.city_language_code=' . $language . ')', 'left');
        $this->db->where('u.user_id', $userId);
        // $this->db->join('area','area.area_id = user_table.area_id and area_language_code = 1','left');
        //$this->db->where('c.country_language_code',$language);   
        //  $this->db->where('c2.city_language_code',$language);   

        $query = $this->db->get();
        // echo  $this->db->last_query();
        return $query->row();
    }*/
    function getProviderServiceType($providerId)
    {
        $sql = "select array_agg(service_type_id)  from provider_service_type where provider_id=" . $providerId . "";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->row();
    }
    
    
    
    function updateProviderProfile($basic, $providerDetails, $services)
    {

        $providerId =     $this->session->userdata('eq_user_id');

        $this->db->trans_start();

        //  $this->db->where("provider_id",$providerId);
        // $this->db->delete("provider_service_type");

        // $this->db->insert_batch("provider_service_type",$services);

        $this->db->where("user_id", $providerId);
        $this->db->update("provider_details", $providerDetails);

        $this->db->where("user_id", $providerId);
        $this->db->update("user_table", $basic);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            $user                        =     $this->getRequiredFieldsforNotification($providerId);
            $userFullname                =     $user->user_first_name . " " . $user->user_last_name;
            $database                    =     get_firebase_refrence();
            $database->getReference("user_details/" . $providerId . "/")->update(["fcm_token" => trim($user->fcm_token), "user_first_name" => $user->user_first_name, "user_last_name" => $user->user_last_name, "user_type" => $user->user_type, "image" => $user->user_image, "user_name" => $userFullname]);


            return 1;
        }
    }
    function checkOldPassword($oldPassword)
    {
        $userId  =     $this->session->userdata('eq_user_id');

        $sql = "select count(user_id) as count  from user_table where user_id=" . $userId . " and user_password='" . MD5($oldPassword) . "'";
        $rs = $this->db->query($sql);
        return  $result  =   $rs->row()->count;
    }
    function monthWiseCount($type)
    {
        $userId  =     $this->session->userdata('eq_user_id');



        if ($this->session->userdata('eq_user_type') == 2) {
            $sql = "select to_char(job_request_created_time,'MM') as mon, count(a.job_request_id) as count from job_request r ,assign_job_provider a where r.job_request_id=a.job_request_id ";
            $sql .= " and a.provider_id=" . $userId . "";
            if ($type == 1) {
                $sql .= " and job_request_type=1 ";
            } else {
                $sql .= " and job_request_type=2 ";
            }
        } else {
            $sql = "select to_char(job_request_created_time,'MM') as mon, count(job_request_id) as count from job_request r where user_id=" . $userId . " ";

            if ($type == 1) {
                $sql .= " and job_request_type=1 ";
            } else {
                $sql .= " and job_request_type=2 ";
            }
        }

        $sql .= " group by 1";


        $rs = $this->db->query($sql);
        $result  =   $rs->result_array();
        $result2  = array();
        foreach ($result as $rows) {
            $result2[$rows['mon']] = $rows['count'];
        }
        return $result2;
    }
    function forgotPassword($data)
    {

        $query = $this->db->get_where('user_table', $data);
        // echo $this->db->last_query();
        $result =  $query->row();
        if($result->user_status== 0 )
            return -1;
        // print_r($result);exit;
        if ($result != "") {
            if ($result->user_id > 0) {
                echo 1;
                $six_digit_random_number                          =   mt_rand(100000, 999999);
                $inputUserBasic['user_password']                  =   md5($six_digit_random_number);
                $userId                                           =   $result->user_id;
                /* $this->db->where('user_id', $userId);
                                    $this->db->update('user_table',$inputUserBasic);*/

                $input['user_id']                         =      $userId;
                $input['session_start_time']              =      gmdate("Y-m-d H:i:s");
                $currentDate = strtotime($input['session_start_time']);
                $futureDate = $currentDate + (60 * 5);
                $formatDate = date("Y-m-d H:i:s", $futureDate);
                $input['session_end_time']                =      $formatDate;
                $this->db->where('user_id', $userId);
                $this->db->delete('password_reset');
                $this->db->insert('password_reset', $input);

                $subject  =  "Account Password reset ! ";
                $to       =   $result->user_email;

                $encryptedUserId = $this->common_functions->encryptId($userId);

                $link = base_url() . "reset_password/" . $encryptedUserId;

                $userMaiArray['message'] =  "Dear ".$result->user_first_name.",<br> We received a request to change your password.Please click <a href='" . $link . "'>here</a> to set up a new password for your account. This link expires after 5 minutes.";
                $userMaiArray['name']    =   $result->user_first_name;
                $to                      =   $to;
                $userMaiArray['subject'] =  $subject;
                $userMaiArray['heading'] =  $subject;
                $this->load->library('parser');
                $email_message  = $this->parser->parse('email/forgot_password', $userMaiArray, true);
                $this->load->library("Mail_function");
                $this->mail_function->SendEmail($email_message, $subject, $to);



                /*   $message ='<div style="background: #373242;max-width: 663px;
    margin: 0 auto;">
    <div style="background:url('.base_url().'frontend_assets/images/logo/logo.png);background-size:cover;text-align:center;width:57%;height:147px;">
        
    </div> 
   <div style="padding: 10px 20px">
        <div style="background: #fff;padding: 9px 30px;border-top: 7px solid #ef5b25;    padding-bottom: 0;overflow: hidden;margin: 20px 7px;border-radius: 0 0 3px 3px;">
            <h3 style="text-align: left;">'.$subject.'</h3>
            
            <p>Dear '.$result->user_first_name.',</p>
            <p>Please click <a href='.$link.'> here </a>to reset your password ,the link will expire after 5 minutes .</p>
            
            
            <p style="margin:0">Emirates Quotation</p>
            <span style="display: block;
    text-align: center;
    color: #000000a6;
    padding: 14px 0;
    font-size: 11px;">&copy 2019 Emirates Quotation All rights reserved.</span>
        </div>
    </div>
</div>';
                                                                                                   
                                                                                                     
                                                             //$this->send($subject,$message,$to,$from) ;
                                                                                              
                                                             $this->load->library("Mail_function");
                                                             $this->mail_function->SendEmail($message,$subject,$to);  */
            } else {
                return 0;
            }
        } else {
            return 3;
        }
    }
    function checkLinkExpired($userId)
    {
        $now = gmdate("Y-m-d H:i:s");
        // $now= '2018-12-07 08:38:31';
        $sql = " select * from password_reset where user_id=" . $userId . " and session_end_time>='" . $now . "' ";
        $rs = $this->db->query($sql);
        return $row = $rs->result();
    }
    function resetPassword($data)
    {

        $userId  = $data['user_id'];

        $sql = " select  * from user_table   where user_id=" . $userId . "  ";


        $rs = $this->db->query($sql);

        $result = $row = $rs->row();


        // $digits    =  6;
        //$randomNo  = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

        $inputUserBasic['user_password']  = MD5($data['new_password']);
        $this->db->where('user_id', $userId);
        $this->db->update('user_table', $inputUserBasic);

        $subject =  "Account Password reset ! ";
        $to      =   $result->user_email;
        //$to      =  "syamca2s@gmail.com";
        // $from    =  "info@teyaar.com";
        /*                 
                                                                                                   $message ='<div style="background: #373242;max-width: 663px;
    margin: 0 auto;">
    <div style="background:url('.base_url().'frontend_assets/images/logo/logo.png);background-size:cover;text-align:center;width:57%;height:147px;">
        
    </div> 
   <div style="padding: 10px 20px">
        <div style="background: #fff;padding: 9px 30px;border-top: 7px solid #ef5b25;    padding-bottom: 0;overflow: hidden;margin: 20px 7px;border-radius: 0 0 3px 3px;">
            <h3 style="text-align: left;">'.$subject.'</h3>
            
            <p>Dear '.$result->user_first_name.',</p>
            <p>You have successfully changed your Password ,Your new Password is '.$data['new_password'].'.</p>
            
        
            <p style="margin:0">Emirates Quotations</p>
            <span style="display: block;
    text-align: center;
    color: #000000a6;
    padding: 14px 0;
    font-size: 11px;">&copy 2018 Emirates Quotation - All rights reserved.</span>
        </div>
    </div>
</div>';
                                                   */

        // $this->send($subject,$message,$to,$from) ;
        // $this->load->library("Mail_function");
        // $this->mail_function->SendEmail($message,$subject,$to);

        return 1;
    }
    function updateUserProfile($basic)
    {



        $userId =     $this->session->userdata('eq_user_id');

        $this->db->trans_start();


        // $this->db->where("user_id", $userId);
        // $this->db->delete("user_adresses");

        // $this->db->insert_batch("user_adresses", $address);


        $this->db->where("user_id", $userId);
        $this->db->update("user_table", $basic);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            $user                        =     $this->getRequiredFieldsforNotification($userId);
            $userFullname                =     $user->user_first_name . " " . $user->user_last_name;
            $database                    =     get_firebase_refrence();
            $database->getReference("user_details/" . $userId . "/")->update(["fcm_token" => trim($user->fcm_token), "user_first_name" => $user->user_first_name, "user_last_name" => $user->user_last_name, "user_type" => $user->user_type, "image" => $user->user_image, "user_name" => $userFullname]);

            return 1;
        }
        // print_r($basic);
        // print_r($data);
    }
    function getUserLocations($userId)
    {
        $data['user_id'] = $userId;
        $data['user_adresses_status'] = 1;
        $query = $this->db->order_by("user_adresses_type_id", "asc")->get_where('user_adresses', $data);
        return $query->result();
    }
    function saveSocialLogin($data)
    {

        // print_r($data);
        $sql = " select  *  from user_table   where user_email='" . $data->email . "'  ";
        $rs = $this->db->query($sql);
        $result = $row = $rs->row();
        if (count($result) > 0) {
            $this->session->set_userdata("eq_user_email", $result->user_email);
            $this->session->set_userdata("eq_user_id", $result->user_id);
            $this->session->set_userdata("eq_user_name", $result->user_first_name);
            $this->session->set_userdata("eq_user_type", $result->user_type);
        } else {
            $inputUserBasic['user_first_name']        =    $data->firstName;
            $inputUserBasic['user_last_name']         =    $data->lastName;
            $inputUserBasic['user_email']             =    $data->email;
            // $inputUserBasic['user_gender']            =    0;
            // $inputUserBasic['user_country_id']        =    0;
            //$inputUserBasic['user_password']        =    MD5($data['txt_password']);
            $inputUserBasic['user_status']            =    0;
            //$inputUserBasic['user_deleted']           =    0;
            $inputUserBasic['user_status']            =    1;
            // $inputUserBasic['user_deleted']           =    0;
            //$inputUserBasic['user_created_by']        =    'S';
            $inputUserBasic['user_created_time']      =    gmdate("Y-m-d H:i:s");
            $inputUserBasic['user_type']              =    1;
            // $inputUserBasic['user_custom_id']         =    $data->email;
            $this->db->trans_start();

            $result  =      $this->db->insert('user_table', $inputUserBasic);

            $insertId = $this->db->insert_id();

            $this->db->trans_complete();



            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                $this->session->set_userdata("eq_user_email", $data->email);
                $this->session->set_userdata("eq_user_id", $insertId);
                $this->session->set_userdata("eq_user_name", $data->firstName);
                $this->session->set_userdata("eq_user_type", $data->lastName);


                return 1;
            }
        }
        //print_r($result);
    }
    function getTransactionFullDetails($userId, $language)
    {
        $sql = " select *  from packages p,package_purchase pp where packages_status=1 and p.packages_id = pp.package_id and pp.provider_id=" . $userId . " order by package_purchase_id DESC";
        $rs = $this->db->query($sql);
        return $result =  $rs->result();
    }
    function getTotalQutationParticipated()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j,assign_job_provider a where a.provider_id=" . $userId . " and  a.job_request_id=j.job_request_id and job_request_type=1";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getTotalQutationPending()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j,assign_job_provider a where a.provider_id=" . $userId . " and  a.job_request_id=j.job_request_id and job_request_type=1 and job_request_status not in(1,2,4) ";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getTotalQutationPendingJobrequestServed()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j,assign_job_provider a where a.provider_id=" . $userId . " and  a.job_request_id=j.job_request_id and job_request_type=2 and user_response_status in(1) ";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getTotalQutationParticipatedUser()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j where j.user_id=" . $userId . "  and job_request_type=1";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getTotalQutationPendingUser()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j where j.user_id=" . $userId . "  and job_request_type=1 and job_request_status not in(1,2,4) ";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getTotalQutationPendingJobrequestUser()
    {
        $userId =     $this->session->userdata('eq_user_id');
        $sql = " select count(j.job_request_id) as count from job_request j  where user_id=" . $userId . "  and job_request_type=2  ";
        $rs = $this->db->query($sql);
        return $result =  $rs->row()->count;
    }
    function getPackages()
    {
        //$userId       =     $this->session->userdata('eq_user_id');
        $language       =   $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;
        //$userId =     $this->session->userdata('eq_user_id');
        $sql = " select * from packages where packages_status=1  order by packages_id ASC ";
        $rs = $this->db->query($sql);
        return $result =  $rs->result();
    }
    function upgradepackage($data)
    {
        /*  $sql = " select max(packages_id) as max  from packages where packages_status=1 " ; 
                 $rs = $this->db->query($sql);
                 $max =  $rs->row()->max;
                 
                 if($max==$data['current_package_id'])
                 {
                     return -1;
                 }
                 
                 $sql = " select *  from packages where packages_status=1 and packages_id>".$data['current_package_id']." order by packages_id ASC limit 1" ; 
                 $rs = $this->db->query($sql);
                 $result =  $rs->row();*/

        $nextPackage = $data['current_package_id'];

        if ($nextPackage <= 0) {
            return -1;
        } else {
            $this->db->trans_start();
            $input['package_id']  = $nextPackage;
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('provider_details', $input);
            $digits   =  6;
            $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT) . $user_id;
            $input2['package_id'] = $nextPackage;
            $input2['package_purchase_date']      = gmdate("Y-m-d H:i:s");
            $input2['package_purchase_serial'] = $randomNo . gmdate("YmdHis");
            $input2['provider_id'] = $data['user_id'];

            $this->db->insert('package_purchase', $input2);


            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return 0;
            } else {
                return 1;
            }
        }
    }
    function getRequiredFieldsforNotification($userId)
    {
        $sql       = "select user_type,user_first_name,user_last_name,user_email,fcm_token,user_dial_code,user_phone,user_id,user_image  from user_table where user_id=" . $userId . "";
        $rs        =  $this->db->query($sql);
        return  $result   =  $rs->row();
    }
    function getRequiredFieldsforNotificationFromTemp($userId)
    {
        $sql       = "select user_type,user_first_name,user_last_name,user_email,fcm_token,user_dial_code,user_phone,user_id,user_image  from user_table_temp where user_id=" . $userId . "";
        $rs        =  $this->db->query($sql);
        return  $result   =  $rs->row();
    }
    function searchServices($data)
    {
        $language  =    $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;
        $sql       =   "select service_type_name,service_type_id from service_type  where service_type_language_code=" . $language . " ";
        $searchKey =     strtolower($data['txt_search_services']);
        if ($searchKey != "") {
            $sql .= " and  LOWER(service_type_name) like  '%" . $searchKey . "%' ";
        }
        $sql .= " order by service_type_name asc ";
        $rs        =  $this->db->query($sql);
        return  $result   =  $rs->result();
    }
    function changePassword($data)
    {
        $this->db->trans_start();

        $userId       =     $this->session->userdata('eq_user_id');

        $this->db->where('user_id', $userId);
        $this->db->update('user_table', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function updateDynamicLocation($data)
    {
        $this->db->trans_start();
        $this->db->insert('user_adresses', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }
    function saveContactus($data)
    {
        $input['name']               =  $data['txt_name'];
        $input['email']              =  $data['email'];
        $input['mobile_number']      =  $data['txt_dial'] . $data['phone'];
        $input['message']            =  $data['comments'];
        $result =  $this->db->insert('contact_us', $input);
        if ($result) {
            $subject                  =  "Enquiry recieved  ";
            $userMaiArray['name']     =  "Admin";
            $to                       =  $this->getAdminMailId();
            $userMaiArray['subject']  =  $subject;
            $userMaiArray['heading']  =  $subject;
            $userMaiArray['message']  =  "Hi Admin,<br> An enquiry has been recieved from " . $data['txt_name'];
            $this->load->library('parser');
            $email_message  = $this->parser->parse('email/status_change', $userMaiArray, true);
            $this->load->library("Mail_function");
            $this->mail_function->SendEmail($email_message, $subject, $to);


            return 1;
        } else {
            return 0;
        }
    }
    function getAdminMailId()
    {
        $sql       = "select email_id  from admin_basics limit 1";
        $rs        =  $this->db->query($sql);
        return  $result   =  $rs->row()->email_id;
    }

    function usersubscribe($data)
    {
        $this->db->trans_start();


        $this->db->where('email', $data['email']);
        $this->db->delete('usersubscribe');
        $this->db->insert('usersubscribe', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }

    function appoinment_form($data)
    {
        $this->db->trans_start();


        $this->db->where('email', $data['email']);
        $this->db->delete('appoinment_form');
        $this->db->insert('appoinment_form', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            return 0;
        } else {
            return 1;
        }
    }

    public function saveUserDetails($data, $user_id)
    {
        if ($user_id > 0) {
            $this->db->where('user_id', $user_id);
            $this->db->update('user_table', $data);
        } else {
            $this->db->insert('user_table', $data);
        }

        return $this->db->affected_rows();
    }

    public function assignStaff($data)
    {
        $this->db->select('*');
        $this->db->where('job_request_id',$data['job_request_id']);
        $this->db->where('job_status',0);
        $result = $this->db->get('staff_jobs')->num_rows();
        
        if($result > 0 )
            return -1;
        // exit;
        
        $this->db->insert('staff_jobs', $data);
        return $this->db->affected_rows();
    }

    public function updateUserStatus($user_id, $status)
    {
        $this->db->where('user_id', $user_id);
        $this->db->set('user_status', $status);
        $this->db->update('user_table');
        return $this->db->affected_rows();
    }

    public function acceptJobRequest($job_request_id, $status)
    {


        $provider['job_request_id']                   =        $job_request_id;
        $provider['assign_status']                    =        $status;
        $provider['provider_id']                      =        $this->session->userdata('eq_user_id');
        $provider['assigned_date']                    =        date("Y-m-d H:i:s");
        $provider['provider_response_time']           =        date("Y-m-d H:i:s");
        $provider['document_name']                    =        $data['document_name'];
        $provider['muted_status']                     =        1;        

        $this->db->select('*');
        $this->db->where('job_request_id', $provider['job_request_id']);
        $this->db->where('provider_id', $provider['provider_id']);
        $result = $this->db->get('assign_job_provider')->row();

        if (!empty($result)) {
            $providerId =     $this->session->userdata('eq_user_id');
            
            $assign_job_provider_id = $result->assign_job_provider_id;
            $this->db->where('assign_job_provider_id', $result->assign_job_provider_id);
            $this->db->update('assign_job_provider', $provider);
            
            $this->db->where('job_request_id',$job_request_id);
            $this->db->set('job_request_status',1);
            $this->db->set('vendor_id',$providerId);
            $this->db->update('job_request');
            
            $this->db->where('job_request_id',$job_request_id);
            $this->db->where('assign_status',0);
            $this->db->delete('assign_job_provider');
            
        } else {
            $this->db->insert('assign_job_provider', $provider);
            $assign_job_provider_id = $this->db->insert_id;
        }

        $this->db->where('job_request_id', $job_request_id);
        $this->db->set('job_request_status', $status);
        $this->db->update('job_request');

        if($this->db->affected_rows())
            return $assign_job_provider_id;
        else
            return 0;
    }

    public function searchArea($data)
    {
        $language  =    $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;

        if ($data['txt_search_area'] != "") {
            $this->db->like('LOWER(area_name)', strtolower($data['txt_search_area']));
        }

        $this->db->select('*');
        $this->db->where('area_language_code', $language);
        return $this->db->get('area')->result();
    }
    
    
    
    public function getTotalStaffAssigned(){
        $providerId =     $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('job_request_status',3);
        $this->db->where('vendor_id',$providerId);
        return $this->db->get('job_request')->num_rows();
    }
    
    public function getPendingJobRequest(){
        $providerId =     $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('assign_status',0);
        $this->db->where('provider_id',$providerId);
        return $this->db->get('assign_job_provider')->num_rows();
    }
    
    public function getTotalJobCompleted(){
        $providerId =     $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('job_request_status',5);
        $this->db->where('vendor_id',$providerId);
        return $this->db->get('job_request')->num_rows();
    }
    
    public function getTotalAcceptedrequest(){
        $providerId =     $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('job_request_status',1);
        $this->db->where('vendor_id',$providerId);
        return $this->db->get('job_request')->num_rows();exit;
        
        $providerId =     $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('assign_status',1);
        $this->db->where('provider_id',$providerId);
        return $this->db->get('assign_job_provider')->num_rows();
    }
    
    public function getTotalOnGoingJobs(){
        $providerId =     $this->session->userdata('eq_user_id');
   
        $this->db->select('*');
        $this->db->where('provider_id',$providerId);
        $this->db->where('assign_status',4);
        return $this->db->get('assign_job_provider')->num_rows();
    }

    public function get_search_result($search_key = "")
    {
        $this->db->select('*');
        $this->db->like('LOWER(service_type_name)',strtolower($search_key));
        $this->db->distinct('service_type_id');
        $this->db->where('service_type_language_code',1);
        return $this->db->get('service_type')->result();
        // return $this->db->query("select distinct ON(service_type_id) service_type_id,service_type_name,service_type_parent_id  from service_type where service_type_name like '%$search_key%'")->result();
    }
    

    public function get_user($condition){

        $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get('user_table')->result();
    }
    
    public function validate_coupon_code($condition =[],$user_id){
        $time_now = gmdate("Y-m-d H:i:s");

        $this->db->select(
            "
            DISTINCT ON (cp.coupon_id) cp.coupon_id AS coupon_id,
            cp.coupon_title,
            cp.coupon_description,
            cp.coupon_code,
            COALESCE(cp.coupon_usage_peruser, 0) AS coupon_usage_peruser,
            COALESCE(cp.coupon_amount, 0) AS coupon_amount,
            COALESCE(cp.coupon_amount) AS coupon_usage_percentage,
            COALESCE(COUNT(cpu.coupon_id), 0) AS coupon_usage_count,
            COALESCE(cp.coupon_minimum_spend, 0) AS coupon_minimum_spend,
            COALESCE(cp.coupon_maximum_spend, 0) AS coupon_maximum_spend
            "
        );
        $this->db->from('coupon cp');
        $this->db->join("(SELECT * FROM coupon_usage WHERE coupon_used_by = ". $this->db->escape($user_id) .") cpu", 'cp.coupon_id = cpu.coupon_id', 'left');
        $this->db->where('cp.coupon_status', 1);
        $this->db->group_start();
            $this->db->where('cp.coupon_end_date >', $time_now);
            $this->db->or_where('cp.coupon_end_date', NULL);
        $this->db->group_end();

        if (! empty($condition) ) {
            $this->db->where($condition);
        }
        $this->db->group_by(['cp.coupon_id', 'cp.coupon_title', 'cp.coupon_description', 'cp.coupon_code', 'cp.coupon_amount','cp.coupon_usage_peruser','cp.coupon_minimum_spend','cp.coupon_maximum_spend']);

        $result = [];
        $data = $this->db->get()->result();
        foreach ( $data as $row ) {
            if ( ($row->coupon_usage_peruser) > 0 && ($row->coupon_usage_count >= $row->coupon_usage_peruser) ) {
                continue;
            }
            $result[] = $row;
        }

        return $result;

    }  
    
    
    public function getJobRequestDetailsByRequestId($job_request_id){

        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->join('service_type','service_type.service_type_id = job_request.service_type_id','left');
        $this->db->where('service_type_language_code',1);
        return $this->db->get('job_request')->row();
    }


    public function getUserDetailsById($userId){
        $this->db->select('*');
        $this->db->where('user_id',$userId);
        return $this->db->get('user_table')->row();
    }
    
    public function get_service_list($service_type_id = 0 ){

        if($service_type_id > 0 )
            $this->db->where('service_type_parent_id',$service_type_id);
        else
            $this->db->where('service_type_parent_id',0);

        $this->db->select('*');
        $this->db->where('service_type_language_code',1);
        return $this->db->get('service_type')->result();
    }
    
    public function getuserByEmail($email){
        
        $this->db->select('*');
        $this->db->where('user_email',$email);
        return $this->db->get('user_table')->row();
    }
    
    public function socialLogin($data){
        
        $this->db->insert('user_table',$data);
        return $this->db->insert_id();
    }
    
    public function getCountryList(){
        
        $this->db->select('*');
        $this->db->where('country_language_code',1);
        $this->db->where('country_status',1);
        return $this->db->get('country')->result();
    }
    
    public function getRatingByRequestId($job_request_id){
        $this->db->select('*');
        $this->db->where('job_request_id',$job_request_id);
        return $this->db->get('user_rating_for_seller')->row();
    }
    
    public function getVendorDetailsByJobId($job_request_id){
        $user_id = $this->session->userdata('eq_user_id');
        
        $this->db->select('*,user_table.user_id as vendor_id');
        $this->db->where('job_request_id',$job_request_id);
        $this->db->where('user_id',$user_id);
        $this->db->join('user_table','user_table.user_id = job_request.vendor_id','left');
        $this->db->where('job_request_status',5);
        return $this->db->get('job_request')->row();
    }
    
    public function get_seller_rating($job_request_id){//($user_id,$provider_id,$service_type_id){
        $user_id = $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('user_id',$user_id);
        // $this->db->where('provider_id',$provider_id);
        // $this->db->where('service_type_id',$service_type_id);
        $this->db->where('job_request_id',$job_request_id);
        return $this->db->get('user_rating_for_seller')->row();
    }
    
     public function create_seller_rating($data){

        $this->db->insert('user_rating_for_seller',$data);
    }

    public function update_seller_rating($data,$id){

        $this->db->where('id',$id);
        $this->db->update('user_rating_for_seller',$data);
    }
    
    public function getVendorRequestDetails($job_request_id){
        $user_id = $this->session->userdata('eq_user_id');
        $this->db->select('*');
        $this->db->where('assign_job_provider.job_request_id',$job_request_id);
        $this->db->where('provider_id',$user_id);
        $this->db->join('job_request','job_request.job_request_id = assign_job_provider.job_request_id','left');
        return $this->db->get('assign_job_provider')->row();
    }
    
    
    public function checkPhoneNumber($phone_number,$dial_code){
        $user_id = $this->session->userdata('eq_user_id');
        
        $this->db->select('*');
        $this->db->where('user_phone',$phone_number);
        $this->db->where('user_dial_code',$dial_code);
        $this->db->where('user_id !=',$user_id);
        return $this->db->get('user_table')->row();
    }
    
    public function newOtp($otp){
        $this->db->where('user_id',$otp['user_id']);
        $this->db->delete('otp');
    
        $this->db->insert('otp',$otp);
        return $this->db->insert_id();
    }
    
    public function validatePhoneOtp($otpId,$otp){
        $this->db->select('*');
        $this->db->where('otp_id',$otpId);
        $this->db->where('otp',$otp);
        
        $result = $this->db->get('otp')->row();
        
        if(count($result) > 0 ){
            $user_id = $this->session->userdata('eq_user_id');
            $i_data['user_dial_code']   = $result->dial_code;
            $i_data['user_phone']       = $result->phone_no;
            
            $this->db->where('user_id',$user_id);
            $this->db->update('user_table',$i_data);
            
            return $this->db->affected_rows();
        }else{
            return -1;
        }
    }
    
     public function getProviderAreaList(){
        $provider_id = $this->session->userdata('eq_user_id');
        $language = 1;
        $this->db->select('*');
        $this->db->where('provider_id',$provider_id);
        $this->db->join('area','area.area_id = provider_areas.area_id and area_language_code = '.$language,'left');
        return $this->db->get('provider_areas')->result();
    }
    
    public function deleteUser($user_id){
        
        $this->db->where('user_id',$user_id);
        $this->db->set('is_deleted',1);
        $this->db->update('user_table');
        
        return $this->db->affected_rows();
    }
    
    public function getUserByPhone($dial_code,$mobile_number){
        $this->db->select('*');
        $this->db->where('user_phone',$mobile_number);
        $this->db->where('user_dial_code',$dial_code);
        return $this->db->get('user_table')->row();
    }
    
    public function getCountryById($country_id){
        $this->db->select('*');
        $this->db->where('country_id',$country_id);
        $this->db->where('country_language_code',1);
        return $this->db->get('country')->row();
    }
    
    function checkValidAppUser($data)
        {
              // $sql = " select user_id from app_user where user_id='".$data['user_id']."' and password='".MD5($data['password'])."' " ;
              $sql = " select user_id from app_user where user_id='".$data['user_id']."' and password='".$data['password']."' " ; 

                         $rs = $this->db->query($sql);
                         $row = $rs->row_array();
                         if(count($row)>0)
                         {
                                 return 1;
                         }
                 else {
                                 return 0;
                          }
        }
        
    function userLoginnew($data)
        {
               $query = $this->db->get_where('user_table',$data );
                //echo $this->db->last_query();exit;
                return $query->row();
            
        }
        
        function getUserFullDetails($userId,$language=1)
        {
              $this->db->select('*,u.user_id as userid');
              $this->db->from('user_table u');  
              $this->db->join('user_details u2','u.user_id =u2.user_id','left'); 
              $this->db->join('country c','(c.country_id =u.country_id) AND (c.country_language_code='.$language.')','left'); 
              $this->db->join('city c2','(c2.city_id =u.city_id) AND (c2.city_language_code='.$language.')','left');  
              $this->db->where('u.user_id',$userId);          
              //$this->db->where('c.country_language_code',$language);   
            //  $this->db->where('c2.city_language_code',$language);   
            
                return $this->db->get()->row();     
                // echo  $this->db->last_query();
                //  return $query->row();
        }
        
        
        function commonupdate($table,$data,$where)
{  
$this->db->where($where); 
$query=$this->db->update($table,$data);


        if($query) 
        {
        return true;
        }   
        else
        { 
        return false;   
        }
}

function validateAccessToken($accesToken)
        {
            
                          $sql = " select user_id from user_table where  user_access_token='".$accesToken."' " ; 
                         $rs = $this->db->query($sql);
                         return $row = $rs->result_array();
                       
        }


        

/*missing code added by binsha*/
public function saveQuestionAnswer($data,$user_id){
             
        $this->db->trans_start();
        
        $this->db->where('device_cart_id',$data['device_cart_id']);
        $this->db->delete('request_question_temp');
        
        $this->db->where('device_cart_id',$data['device_cart_id']);
        $this->db->delete('user_requrest_doc_temp');
        
        $input['device_cart_id']    = $data['device_cart_id'];
        
        $dataIds = $_POST['data'];
        $dataIds = json_decode($dataIds);
        
        foreach ($dataIds as $key => $value) {
            $input['question_id']   = $key;
            $input['answer']        = $value;
            $this->db->insert('request_question_temp',$input);
        }

        $inputData['document']      =   $data['document_name'];
        $inputData['description']   =   $data['description'];
        $inputData['device_cart_id']=   $data['device_cart_id'];
        $inputData['price_from']    =   $data['price_from'];
        $inputData['price_to']      =   $data['price_to'];
        $inputData['service_type_id'] = $data['service_type_id'];
        $inputData['user_id']       = $user_id;
        
        $this->db->where('device_cart_id',$data['device_cart_id']);
        $this->db->delete('user_requrest_doc_temp');
        
        $this->db->insert('user_requrest_doc_temp',$inputData);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
                return 0;
        } else {
            return 1;
        }
    }
     public function getUserServiceTempData($device_cart_id){
        $this->db->select('*');
        $this->db->where('device_cart_id', $device_cart_id);
        return $this->db->get('user_requrest_doc_temp')->row();
    }
    function getUserAddressById($address_id,$language =1 ){
            $this->db->select('user_adresses.*,area.area_name,city.city_name');
            $this->db->where('user_adresses_id',$address_id);
            $this->db->join('area','area.area_id=user_adresses.user_adresses_area','left');
            $this->db->join('city','city.city_id=user_adresses.user_adresses_city','left');
            $this->db->where('city_language_code',$language);
            $this->db->where('area_language_code',$language);
            return $this->db->get('user_adresses')->row();
        }
        public function getProviderListByArea($area_id,$service_type_id)
        {
        
        $this->db->select('*');
        $this->db->from('provider_areas');
        $this->db->where('area_id',$area_id);
        $this->db->where('area_status',1);
        $this->db->join('user_table','user_table.user_id = provider_areas.provider_id','left');
        $this->db->join('provider_service_type','provider_service_type.provider_id =provider_areas.provider_id','left');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get()->result();
    }

     public function sendNewJobRequest($inputData, $device_cart_id,$providerList){

        $job_days   = $inputData['job_days'];
        unset($inputData['job_days']);

        $this->db->trans_start();
        // print_r($inputData);exit;
        $this->db->insert('job_request', $inputData);
        $job_request_id = $this->db->insert_id();

        $this->db->select('*');
        $this->db->where('device_cart_id', $device_cart_id);
        $request_question_temp = $this->db->get('request_question_temp')->result();
        
        $input['job_request_id'] = $job_request_id;
        $input['user_id']        = $data['user_id'];
        $input['service_type_id']= $data['service_type_id'];
        foreach ($request_question_temp as $key => $value) {
            $input['question_id']   = $value->question_id;
            $input['answer']        = $value->answer;
            $this->db->insert('request_question_option',$input);
        }

        $this->db->where('device_cart_id', $device_cart_id);
        $this->db->delete('request_question_temp');
        
        $this->db->where('device_cart_id', $device_cart_id);
        $this->db->delete('user_requrest_doc_temp');
        /*wallet payment*/
        if($inputData['payment_method'] ==3 ) {
             $this->db->select('*');
            $this->db->where('user_id',$inputData['user_id']);
            $userData = $this->db->get('user_table')->row();   
            if($userData->wallet_balance >= $inputData['grand_total']) {
                $walletDetails= [
                'user_id'   => $inputData['user_id'],
                'amount'    => $inputData['grand_total'],
                'status'     => 2 ,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by'=>$inputData['user_id'],
                'transaction_status'=> 1,
                'job_request_id' =>$job_request_id,
                'transaction_id'=>$inputData['job_request_display_id']
                ];
                $this->db->insert('user_wallet',$walletDetails);
                $insertId = $this->db->insert_id();
                if($insertId >0) {
                     $userQuery =  "update user_table set wallet_balance=wallet_balance-".$inputData['grand_total']." where user_id=".$inputData['user_id'];
                    $userData = $this->db->query($userQuery);
                }
            } else {     //update job request to COD if wallet is not having enough amount
                
                 $this->db->where('job_request_id',$job_request_id);
                $this->db->set('payment_method',1);
                $this->db->update('job_request');

            }
           /* */
        }
        if(!empty($providerList)){
            $provider =[];
            foreach($providerList as $key=> $value){
                $provider[$key]['job_request_id'] = $job_request_id;
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
            $this->db->insert('job_request_days',['job_request_id'=>$job_request_id,'job_date'=>$date,'job_time'=>$data['job_validity_time']]);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return 0;
        } else {
            return $job_request_id;
        }
    }
    function getUsersFcmTokens($userId)
        {
                $sql = " select * from user_table where  user_id=".$userId."" ; 
                $rs  = $this->db->query($sql);
                return $result =  $rs->row();
        }
    public function getServiceTypeById($service_type_id){
        
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get('service_type')->row();
    }
    function getProviderFullDetails($userId,$language = 1)
        {
             $this->db->select('*,u.user_id as userid');
              $this->db->from('user_table u');  
              $this->db->join('provider_details u2','u.user_id =u2.user_id','left'); 
              $this->db->join('country c','(c.country_id =u.country_id) AND (c.country_language_code='.$language.')','left'); 
              $this->db->join('city c2','(c2.city_id =u.city_id) AND (c2.city_language_code='.$language.')','left');  
              $this->db->where('u.user_id',$userId);          
              //$this->db->where('c.country_language_code',$language);   
            //  $this->db->where('c2.city_language_code',$language);   
            
                $query = $this->db->get();     
               // echo  $this->db->last_query();
                 return $query->row();
        }
     public function getAssignJobDetails($condition){
        
        $this->db->select('*');
        $this->db->where($condition);
        return $this->db->get('assign_job_provider')->row();
    }
     public function getWalletLog($user_id){

            $this->db->select('uw.*,ut.admin_user_name');
            $this->db->from('user_wallet uw');
            $this->db->join('admin_user ut','ut.admin_user_id=uw.created_by','left');
            $this->db->where('CAST(uw.user_id as INTEGER) = '.$user_id);
            $this->db->order_by('uw.wallet_id','desc');
            return $this->db->get()->result();
        }
     public function getUserDataById($userId){
            $this->db->select('*');
            $this->db->where('user_id',$userId);
            return $this->db->get('user_table')->row();
          }
    public function getShareLinks(){
        $this->db->select('*');
        return $this->db->get('admin_basics')->row();
    }
     public function getUserServices($device_cart_id,$language=1){

        $this->db->select('urd.*,service_type.service_type_name');
        $this->db->where('device_cart_id',$device_cart_id);
        $this->db->join('service_type','service_type.service_type_id = urd.service_type_id','left');
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('user_requrest_doc_temp urd')->row();
    }
    public function getSavedQuestions($device_cart_id){

        $this->db->select('rqt.*,question.question,question.question_arb,answer_options.answer_option,answer_options.answer_option_arabic');
        $this->db->where('device_cart_id',$device_cart_id);
        $this->db->join('question','question.question_id = rqt.question_id','left');
        $this->db->join('answer_options','answer_options.answer_options_id = rqt.answer');
        return  $this->db->get('request_question_temp rqt')->result();
    }
    public function getUserAddressList($user_id,$language =1 ){
        
        $this->db->select('user_adresses.*,area.area_name,city.city_name,country.country_name');
        $this->db->from('user_adresses');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('default_address','desc');
        $this->db->join('area','area.area_id =user_adresses.user_adresses_area','left');
        $this->db->where('area_language_code',$language);
        $this->db->join('city','city.city_id = user_adresses.user_adresses_city','left');
        $this->db->where('city_language_code',$language);
        $this->db->join('country','country.country_id = user_adresses.user_adresses_country','left');
        $this->db->where('country_language_code',$language);
        return $this->db->get()->result();
        
      }

      public function get_user_by_email($email){
        $this->db->select('*');
        $this->db->where('user_email',$email);
        return $this->db->get('user_table')->row();
    }
    public function socialmediaLogin($data){

        $this->db->insert('user_table',$data);
        return $this->db->insert_id();
    }

    public function verifyPhoneOtp($otp_id,$otp,$user_id){
      $this->db->select('*');
      $this->db->where('otp_id',$otp_id);
      $this->db->where('otp',$otp);
      $result = $this->db->get('otp')->row(); 
      
      $date = gmdate("Y-m-d H:i:s");
      if($date>$result->otp_validity_end_time && $result->otp_id>0){
        return -1;
      }
        

      if($result ){
          
          $i_data['user_phone']     = $result->phone_no;
          $i_data['user_dial_code'] = $result->dial_code;
          $i_data['country_id']     = $result->country_id;
          $i_data[' phone_verified'] = 1; 
          $this->db->where('user_id',$user_id);
          $this->db->update('user_table',$i_data);

          return  $this->db->affected_rows();
      }else{
          return -2;
      }
      
  }
  
    public function updateUserDataById($u_data,$user_id){
        
            $this->db->where('user_id',$user_id);
            $this->db->update('user_table',$u_data);
            return $this->db->affected_rows();
    }
    
    public function getCityList($country_id,$language=1){
        $this->db->select('*');
        $this->db->where('city_language_code',$language);
        $this->db->where('city_country_id',$country_id);
        return $this->db->get('city')->result();
    }
      
    public function saveAddressDetails($data,$address_id){
            
            if($data['default_address'] > 0 ){
                $this->db->set('default_address',0);
                $this->db->where('user_id',$data['user_id']);
                $this->db->update('user_adresses');
            }
            
            if($address_id > 0 ){
              $this->db->where('user_adresses_id',$address_id);
              $this->db->update('user_adresses',$data);
            }else{
              $this->db->insert('user_adresses',$data);
            }
        
            return $this->db->affected_rows();
          }
          
    public function saveTempRequest($data,$device_cart_id){

        $this->db->insert('job_request',$data);
        $job_request_id = $this->db->insert_id();

        $this->db->where('device_cart_id',$device_cart_id);
        $this->db->set('job_request_temp_id',$job_request_id);
        $this->db->update('request_question_temp');

        
    }
    
    public function update_user($data,$user_id){

        $this->db->where('user_id',$user_id);
        $this->db->update('user_table',$data);

        return $this->db->affected_rows();
    }
}

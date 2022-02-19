<?php 
class M_user extends CI_Model 
{
    
     function login($data)
        {

                $query = $this->db->get_where('admin_user',$data );             
                return $query->row();

        }
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
function userLoginnew($data)
        {
               $query = $this->db->get_where('user_table',$data );
                //echo $this->db->last_query();exit;
                return $query->row();
            
        }

            function get_new_row($data,$table)
        {
               $query = $this->db->get_where($table,$data );
                //echo $this->db->last_query();exit;
                return $query->row();
            
        }
        function get_single_row($where,$table)
{
$this->db->where($where);
//echo $this->db->last_query();exit;
return $this->db->get($table)->row(); 
}
 function checkValidAppUser($data)
        {
              $sql = " select user_id from app_user where user_id='".$data['user_id']."' and password='".MD5($data['password'])."' " ; 
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
        function validateAccessToken($accesToken)
        {
            
                          $sql = " select user_id from user_table where  user_access_token='".$accesToken."' " ; 
                         $rs = $this->db->query($sql);
                         return $row = $rs->result_array();
                       
        }
        function getUserRowByArray($data)
        {
                $query = $this->db->get_where('user_table', $data);
                // echo $this->db->last_query();
                return $query->result();
            
        }
        function saveProvider($input1,$input2,$services)
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
                                                    
                                                    
                                                      $sql = " select count(user_id) as count from provider_details where  user_id='".$input1['user_id']."' " ; 
                                                      $rs = $this->db->query($sql);
                                                      $count = $rs->row()->count;
                                                      if($count>0)
                                                      {
                                                    
                                                        $this->db->where('user_id',$input1['user_id']);
                                                        $this->db->update('provider_details',$input2);
                                                        $return      =    $input1['user_id'];
                                                      }
                                                      else
                                                      {
                                                          $input2['user_id'] = $input1['user_id'];
                                                          $this->db->insert('provider_details',$input2);
                                                      }
                                            }
                                            else
                                            {
                                                
                                                
                                                
                                                
                                                
                                                
                                                unset($input1['user_id']);                                                
                                                $this->db->insert('user_table',$input1);                                                
                                                $insertId = $this->db->insert_id();                                                
                                                $input2['user_id']      =   $insertId;                                                
                                                $this->db->insert('provider_details',$input2);
                                                $return        =    $insertId;
                                                $serviceTypes  =  explode(",",$services['service_type_ids']);
                                                $serviceTypes  =  array_filter($serviceTypes);
                                                
                                                
                                                
                                               // print_r($serviceTypes);
               
               if(count($serviceTypes)>0)
               {
                   $i =0;
                   foreach($serviceTypes as $rows)
                   {
                      $userGroup = array();
                      $provServiceType[$i]['service_type_id']  = $rows;
                      $provServiceType[$i]['provider_id']      = $insertId;
                      
                       $sql = " select service_type_name,notification_group_name,fcm_key  from service_type where service_type_id=".$rows." and service_type_language_code=1" ; 
                       $rs = $this->db->query($sql);
                       $res =$rs->row();
                       
                       $notification_group_name = $res->notification_group_name;
                       
                       $groupName = ltrim(rtrim(strtolower($res->service_type_name)));
                       $groupName = str_replace("  ","",$groupName);
                       $groupName = str_replace(" ","_",$groupName);
                       $groupName = $groupName."_".date("Ymd");
                       if($notification_group_name=="" || $notification_group_name==NULL)
                       {
                           $fcmResult =  $this->fcm_notification->create_notification_group($groupName,array($input1['fcm_token']));
                           $fcm_key   =  $fcmResult->notification_key!=""?$fcmResult->notification_key:"";
                            //print_r($fcmResult);
                            if($fcm_key!="")
                            {
                                $fcmValue['notification_group_name']       =  $groupName;
                                $fcmValue['fcm_key']                       =  $fcm_key;
                                $this->db->where('service_type_id',$rows); 
                                $this->db->update('service_type',$fcmValue);
                                
                                $userGroup['notification_group_name']     = $groupName;
                                $userGroup['fcm_key']                     = $fcm_key;
                            }
                            else if($fcmResult->error=="")
                            {
                                
                            }
                       }
                       else
                       {
                            $fcmResult                                =  $this->fcm_notification->add_notification_device($res->fcm_key,$notification_group_name,array($input1['fcm_token']));
                            $userGroup['notification_group_name']     =  $notification_group_name;
                            $userGroup['fcm_key']                     =  $res->fcm_key;
                       }
                       if(count($userGroup)>0)
                       {
                                $userGroup['user_id']                     =  $insertId;
                                $this->db->where('user_id',$insertId); 
                                $this->db->where('notification_group_name',$userGroup['notification_group_name']); 
                                $this->db->where('fcm_key',$userGroup['fcm_key']); 
                                $this->db->delete('user_notification_groups');
                                
                                $this->db->insert('user_notification_groups',$userGroup);
                                
                       }
                      
                     
                      
                      $i++; 
                   }
                   
                   $this->db->where('provider_id',$insertId); 
                   $this->db->delete('provider_service_type');
                   //  print_r($provServiceType);
                   $this->db->insert_batch('provider_service_type',$provServiceType);
                   //  echo $this->db->last_query();
               }
               else
               {
                   return 0;
               }
                                                
                                                
                                                
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
        function socialmediaLogin($data,$email)
        {
                $this->db->trans_start();   
                $this->db->select('user_id');
                $this->db->from('user_table c');        
                $this->db->where('user_email',$email);      
            
                $query = $this->db->get();       
                //ho $this->db->last_query();
               //rint_r($query->row());
                if($query->row()->user_id>0)
                                {
                                                    $this->db->where('user_email',$email);
                                                    $this->db->update('user_table',$data);         
                                                    $return = $query->row()->user_id;
                                }
                                else
                                {
                                               $this->db->insert('user_table',$data);                                                
                                                $insertId = $this->db->insert_id();        
                                                $return  =  $insertId;
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
        function getUserFullDetails($userId,$language)
        {
              $this->db->select('*,u.user_id as userid');
              $this->db->from('user_table u');  
              $this->db->join('user_details u2','u.user_id =u2.user_id','left'); 
              $this->db->join('country c','(c.country_id =u.country_id) AND (c.country_language_code='.$language.')','left'); 
              $this->db->join('city c2','(c2.city_id =u.city_id) AND (c2.city_language_code='.$language.')','left');  
              $this->db->where('u.user_id',$userId);          
              //$this->db->where('c.country_language_code',$language);   
            //  $this->db->where('c2.city_language_code',$language);   
            
                $query = $this->db->get();     
               // echo  $this->db->last_query();
                 return $query->row();
        }
        function getProviderFullDetails($userId,$language)
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
        function checkServiceTypeChildExist($serviceId)
        {
                      $sql = " select count(service_type_id) as count  from service_type where service_type_parent_id=".$serviceId." and service_type_status=1" ; 
                         $rs = $this->db->query($sql);
                        return $count = $rs->row()->count;
                  
        }
        function addProviderRating($data)
        {
                $this->db->trans_start(); 
                $sql = " select count(provider_rating_id) as count  from provider_rating where provider_id=".$data['provider_id']." and user_id=".$data['user_id']." " ; 
                         $rs = $this->db->query($sql);
                         $count = $rs->row()->count;
                         if($count>0)
                         {
                             return -1;
                         }
        
             if($data['provider_rating_id']<=0)
             {
            
                              $this->db->insert('provider_rating',$data);          
                              
                               
          
             }
             else
             {
                 
                      
                                                  
                                                   $this->db->where('provider_rating_id',$data['provider_rating_id']);         
                                                   $this->db->update('provider_rating',$data);
                                                 
                                             
             }
              $this->db->trans_complete();
                      
                                            if($this->db->trans_status() === FALSE)
                                             {

                                                 return 0;
                                             }
                                             else
                                             {
                                                return 1;
                                             }
        }
        function setAddressType($data)
        {
            $input['user_id']                         = $data['user_id'];
            $input['user_adresses_location']          = $data['location'];
            $input['user_adresses_longitude']         = $data['longitude'];
            $input['user_adresses_lattitude']         = $data['lattitude'];
            $input['user_adresses_city']              = $data['user_adresses_city'];
            $input['user_adresses_created_time']      = gmdate("Y-m-d H:i:s");
            $input['user_adresses_type_id']           = $data['address_type_id'];
            $input['user_adresses_status']            = 1;
            
            
            $this->db->trans_start(); 
             
            $sql = " select count(user_id) as count  from user_adresses where user_id=".$data['user_id']." and user_adresses_type_id=".$data['address_type_id']." " ; 
                         $rs = $this->db->query($sql);
                         $count = $rs->row()->count;
                         if($count>0)
                         {
                              $this->db->where('user_id',$input['user_id']);    
                              $this->db->where('user_adresses_type_id',$input['user_adresses_type_id']);     
                              $this->db->update('user_adresses',$input);
                         }
                         else
                         {
                             $this->db->insert('user_adresses',$input);
                         }
                         
                          $this->db->trans_complete();
                      
                        if($this->db->trans_status() === FALSE)
                         {

                             return 0;
                         }
                         else
                         {
                            return 1;
                         }
        }
        function setProviderSettings($data)
        {
                $input['user_id']           = $data['user_id'];
                $input['location']          = $data['location'];
                $input['longitude']         = $data['longitude'];
                $input['lattitude']         = $data['lattitude'];
                
                $input2['country_id']      =  $data['country_id'];
                $input2['city_id']         =  $data['city_id'];
                
                $this->db->trans_start(); 
                
                $this->db->where('user_id',$input['user_id']); 
                $this->db->update('user_table',$input2);
                
                  $sql = " select count(user_id) as count  from provider_details where user_id=".$data['user_id']." " ; 
                         $rs = $this->db->query($sql);
                         $count = $rs->row()->count;
                         if($count>0)
                         {
                             $this->db->where('user_id',$input['user_id']); 
                             $this->db->update('provider_details',$input);
                         }
                         else
                         {
                             $this->db->insert('provider_details',$input);
                         }
                         
               $serviceTypes =  explode(",",$data['service_type_ids']);
               
               if(count($serviceTypes)>0)
               {
                   $i =0;
                   foreach($serviceTypes as $rows)
                   {
                      $userGroup = array();
                      $provServiceType[$i]['service_type_id']  = $rows;
                      $provServiceType[$i]['provider_id']      = $input['user_id'];
                      
                       $sql = " select service_type_name,notification_group_name,fcm_key  from service_type where service_type_id=".$rows." and service_type_language_code=1" ; 
                       $rs = $this->db->query($sql);
                       $res =$rs->row();
                       
                       $notification_group_name = $res->notification_group_name;
                       
                       $groupName = ltrim(rtrim(strtolower($res->service_type_name)));
                       $groupName = str_replace("  ","",$groupName);
                       $groupName = str_replace(" ","_",$groupName);
                       $groupName = $groupName."_".date("Ymd");
                       if($notification_group_name=="" || $notification_group_name==NULL)
                       {
                           $fcmResult =  $this->fcm_notification->create_notification_group($groupName,array($data['fcm_token']));
                           $fcm_key   =  $fcmResult->notification_key!=""?$fcmResult->notification_key:"";
                            //print_r($fcmResult);
                            if($fcm_key!="")
                            {
                                $fcmValue['notification_group_name']       =  $groupName;
                                $fcmValue['fcm_key']                       =  $fcm_key;
                                $this->db->where('service_type_id',$rows); 
                                $this->db->update('service_type',$fcmValue);
                                
                                $userGroup['notification_group_name']     = $groupName;
                                $userGroup['fcm_key']                     = $fcm_key;
                            }
                            else if($fcmResult->error=="")
                            {
                                
                            }
                       }
                       else
                       {
                            $fcmResult                                =  $this->fcm_notification->add_notification_device($res->fcm_key,$notification_group_name,array($data['fcm_token']));
                            $userGroup['notification_group_name']     =  $notification_group_name;
                            $userGroup['fcm_key']                     =  $res->fcm_key;
                       }
                       if(count($userGroup)>0)
                       {
                                $userGroup['user_id']                     =  $data['user_id'];
                                $this->db->where('user_id',$data['user_id']); 
                                $this->db->where('notification_group_name',$userGroup['notification_group_name']); 
                                $this->db->where('fcm_key',$userGroup['fcm_key']); 
                                $this->db->delete('user_notification_groups');
                                
                                $this->db->insert('user_notification_groups',$userGroup);
                                
                       }
                      
                     
                      
                      $i++; 
                   }
                   
                   $this->db->where('provider_id',$input['user_id']); 
                   $this->db->delete('provider_service_type');
              //  print_r($provServiceType);
                   $this->db->insert_batch('provider_service_type',$provServiceType);
                 //  echo $this->db->last_query();
               }
                         
                   $this->db->trans_complete();
                   
                        if($this->db->trans_status() === FALSE)
                         {

                             return 0;
                         }
                         else
                         {
                            return 1;
                         }
                
                
        }
        function getProviderRatings($data)
        {
                 $sql = " select *  from provider_rating r,user_table u where u.user_id=r.user_id and  r.provider_id=".$data['user_id']." and rating_status=1 order by provider_rating_id DESC" ; 
                 $rs = $this->db->query($sql);
                 return  $rs->result();
        }
        function getArticles($data)
        {
                 $sql = " select *  from articles where articles_type_id=".$data['article_type']." and articles_language_code=".$data['language']." limit 1" ; 
                 $rs = $this->db->query($sql);
                 return  $rs->row();
        }
        function getHomeLocation($userId,$type)
        {
                 $sql = " select *  from user_adresses where user_id=".$userId." and user_adresses_type_id=".$type." " ; 
                 $rs = $this->db->query($sql);
                 return  $rs->row();
        }
        function getCurrentPackagePlan($providerId)
        {
                 $sql = " select packages_name,packages_name_arabic,p.packages_id  from provider_details d,packages p where user_id=".$providerId." and d.package_id=p.packages_id " ; 
                 $rs = $this->db->query($sql);
                 return  $rs->row();
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
                 
                 if($nextPackage<=0)
                 {
                      return -1; 
                 }
                 else
                 {
                     $this->db->trans_start(); 
                     $input['package_id']  = $nextPackage;
                     $this->db->where('user_id',$data['user_id']); 
                     $this->db->update('provider_details',$input);
                     $digits   =  6;
                     $randomNo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT).$user_id;
                     $input2['package_id'] = $nextPackage;
                     $input2['package_purchase_date']      = gmdate("Y-m-d H:i:s");
                     $input2['package_purchase_serial'] = $randomNo.gmdate("YmdHis");
                     $input2['provider_id'] =$data['user_id'];
                     
                     $this->db->insert('package_purchase',$input2);
                     
                     
                      $this->db->trans_complete();
                   
                        if($this->db->trans_status() === FALSE)
                         {

                             return 0;
                         }
                         else
                         {
                            return 1;
                         }
                
                 }
                 
                 
            
           
        }
        function gettransactionSummary($data)
        {
                 $sql = " select *  from packages p,package_purchase pp where packages_status=1 and p.packages_id = pp.package_id and pp.provider_id=".$data['user_id']." order by package_purchase_id DESC" ; 
                 $rs = $this->db->query($sql);
                return $result =  $rs->result();
        }
        function getPackages()
        {
                $sql = " select *  from packages order by packages_id ASC" ; 
                $rs = $this->db->query($sql);
                return $result =  $rs->result();
        }
        function removeFcmGroups($userId)
        {
                $sql = " select fcm_key,notification_group_name,fcm_token  from user_notification_groups g,user_table u where g.user_id=".$userId." and u.user_id=g.user_id " ; 
                $rs = $this->db->query($sql);
                $result =  $rs->result();
                
                if(count($result)>0)
                {
                    foreach($result as $rows)
                    {
                         $fcmResult =  $this->fcm_notification->remove_notification_device($rows->fcm_key,$rows->notification_group_name,array($rows->fcm_token));
                        
                    }
                }
        }
        function addToFcmGroups($userId,$fcmToken)
        {
                $this->db->trans_start(); 
                $sql = " select s.service_type_id,fcm_key,notification_group_name,fcm_token  from service_type s,provider_service_type ps,user_table u where u.user_id=".$userId." and u.user_id=ps.provider_id and service_type_language_code=1 and ps.service_type_id=s.service_type_id " ; 
                $rs  = $this->db->query($sql);
                $result =  $rs->result();
                
                if(count($result)>0)
                {
                    foreach($result as $rows)
                    {
                        
                         $notification_group_name =  $rows->notification_group_name;
                         if($notification_group_name=="" || $notification_group_name==NULL)
                       {
                           $groupName = ltrim(rtrim(strtolower($rows->service_type_name)));
                           $groupName = str_replace("  ","",$groupName);
                           $groupName = str_replace(" ","_",$groupName);
                           $groupName = $groupName."_".date("Ymd");
                           $fcmResult =  $this->fcm_notification->create_notification_group($groupName,array($fcmToken));
                           $fcm_key   =  $fcmResult->notification_key!=""?$fcmResult->notification_key:"";
                          //print_r($fcmResult);
                            if($fcm_key!="")
                            {
                                $fcmValue['notification_group_name']       =  $groupName;
                                $fcmValue['fcm_key']                       =  $fcm_key;
                                $this->db->where('service_type_id',$rows->service_type_id); 
                                $this->db->update('service_type',$fcmValue);
                                
                                $userGroup['notification_group_name']     = $groupName;
                                $userGroup['fcm_key']                     = $fcm_key;
                            }
                            else if($fcmResult->error=="")
                            {
                                
                            }
                       }
                       else
                       {
                            $fcmResult                                =  $this->fcm_notification->add_notification_device($rows->fcm_key,$notification_group_name,array($fcmToken));
                            $userGroup['notification_group_name']     =  $notification_group_name;
                            $userGroup['fcm_key']                     =  $rows->fcm_key;
                       }
                       if(count($userGroup)>0)
                       {
                                $userGroup['user_id']                     =  $userId;
                                $this->db->where('user_id',$userId); 
                                $this->db->where('notification_group_name',$userGroup['notification_group_name']); 
                                $this->db->where('fcm_key',$userGroup['fcm_key']); 
                                $this->db->delete('user_notification_groups');
                                
                                $this->db->insert('user_notification_groups',$userGroup);
                                
                       }
                        
                    }
                }
                
                        $this->db->trans_complete();
                   
                        if($this->db->trans_status() === FALSE)
                         {

                             return 0;
                         }
                         else
                         {
                            return 1;
                         }
        }
        function getFcmGroupDetails($serviceTypeId)
        {
                $sql = " select fcm_key,notification_group_name from service_type s where  service_type_language_code=1 and service_type_id=".$serviceTypeId."" ; 
                $rs  = $this->db->query($sql);
                return $result =  $rs->row();
        }
        function getUsersFcmTokens($userId)
        {
                $sql = " select fcm_token from user_table where  user_id=".$userId."" ; 
                $rs  = $this->db->query($sql);
                return $result =  $rs->row();
        }
        function getProviderSettings($data)
        {
                $sql = " select s.* ,p.*,s.service_type_id as service_type_id,u.country_id,u.city_id from user_table u,service_type s LEFT JOIN provider_service_type p on p.service_type_id=s.service_type_id and provider_id=".$data['user_id']."  where  service_type_language_code=".$data['language_code']." and service_type_status=1 and u.user_id=".$data['user_id']." order by service_type_name ASC" ; 
                $rs  = $this->db->query($sql);
                return $result =  $rs->result();
        }
         function getProviderLocationDetails($providerId)
        {
                $sql = " select lattitude,longitude,location from provider_details where user_id=".$providerId."" ; 
                $rs  = $this->db->query($sql);
                return $result =  $rs->row();
        }
          function getRequiredFieldsforNotification($userId)
        {
                 $sql       = "select user_type,user_first_name,user_last_name,user_email,fcm_token,user_dial_code,user_phone,user_id,user_image  from user_table where user_id=".$userId."" ; 
                 $rs        =  $this->db->query($sql);
                 return  $result   =  $rs->row();
        }
         function getRequiredFieldsforNotificationFromTemp($userId)
        {
                 $sql       = "select user_first_name,user_last_name,user_email,fcm_token,user_dial_code,user_phone,user_id,user_image  from user_table_temp where user_id=".$userId."" ; 
                 $rs        =  $this->db->query($sql);
                 return  $result   =  $rs->row();
        }
         function verifyOtp($data)
        {
            $otp                  =             $data['otp'] ;
            $tempOtpId            =             $data['otp_id'] ;
            $sql                  =             "select *  from otp where otp_id=".$tempOtpId." and otp='".$otp."'";                       
            $rs                   =             $this->db->query($sql);
            $result               =             $rs->row(); 
            $date                 =             gmdate("Y-m-d H:i:s");
            if($date>$result->otp_validity_end_time && $result->otp_id>0)
            {
                 return -1;
            }
            if($result->otp_id>0)
            {
                $this->db->trans_start(); 
                
                $query = $this->db->query('INSERT INTO user_table (user_first_name, user_last_name, user_email,user_password,country_id,city_id,user_phone,user_dial_code,user_type,user_zip,user_status,user_image,user_device_token,user_device_type,user_access_token,user_created_by,user_created_time,user_updated_by,user_updated_time,user_created_methode,user_last_login,login_type,fcm_token,user_company_name)
                           SELECT user_first_name, user_last_name, user_email,user_password,country_id,city_id,user_phone,user_dial_code,user_type,user_zip,user_status,user_image,user_device_token,user_device_type,user_access_token,user_created_by,user_created_time,user_updated_by,user_updated_time,user_created_methode,user_last_login,login_type,fcm_token,user_company_name
                           FROM user_table_temp
                           WHERE user_id='.$result->user_id.'');
                           
                           $insertId = $this->db->insert_id();   
                           
                           $this->db->where("user_id",$result->user_id);
                           $this->db->delete('user_table_temp');
                           
                            $this->db->trans_complete();
                      
                                            if($this->db->trans_status() === FALSE)
                                             {

                                                 return 0;
                                             }
                                             else
                                             {
                                                
                                                
                                                return $insertId;
                                             }
                           
                           
                
            }
            else
            {
                return -2;
            }
            
            
        }
       function resendOtp($data,$otp)
        {
            $tempOtpId            =             $data['txt_ver'];
            $sql                  =             "select *  from otp where otp_id=".$tempOtpId."";                       
            $rs                   =             $this->db->query($sql);
            $result               =             $rs->row(); 
            $date                 =             gmdate("Y-m-d H:i:s");
            if($result->otp_id>0 && $result->user_id>0)
            {
                 $this->db->trans_start(); 
                 $this->db->where('otp_id',$tempOtpId); 
                 $this->db->update('otp',$otp); 
                 $this->db->trans_complete();
                      
                                            if($this->db->trans_status() === FALSE)
                                             {

                                                 return 0;
                                             }
                                             else
                                             {
                                                
                                                
                                                return $result->user_id;
                                             }
                 
            }
            else
            {
                return 0;
            }
        }
}
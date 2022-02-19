<?php 
class M_quotation extends CI_Model 
{
    
     function getQuestions($serviceTypeId)
        {
         
                        $sql = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1" ; 
                         $sql.= "  and questions_service_type_id=".$serviceTypeId.""; 
                        $sql.= "  order by question_id ASC"; 
                        $rs = $this->db->query($sql);
                       return   $row = $rs->result();
        }
        function getAnswerOptions($questionId)
        {
                         $sql = " select * from answer_options  o where question_id=".$questionId." order by answer_options_id ASC  " ; 
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
        }
        function createJobRequest($data,$question,$providers)
        {
            
            
          $this->db->trans_start(); 
             
             $documents = $data['document'];
             
             unset($data['document']);
        
             if($data['job_request_id']<=0)
             {
            
                              $this->db->insert('job_request',$data);           
                              $insertId                   =              $this->db->insert_id();        
                              $return                     =              $insertId;
          
             }
             else
             {
                                                  
                                                   $this->db->where('job_request_id',$data['job_request_id']);         
                                                   $this->db->update('job_request',$data);
                                                   $return = $data['job_request_id'] ;
                                             
             }
             
             
             
                if(count($question)>0)      
           {
                    $i =0;
                    foreach($question as $key => $value )
                    {
                            $input[$i]['job_request_id']           =        $return;
                            $input[$i]['question_id']                 =        $key;
                            $input[$i]['service_type_id']          =        $data['service_type_id'];
                            $input[$i]['user_id']                         =        $data['user_id'];
                            $answer                                              =         explode(",",$value);
                            
                            //print_r($answer);
                            if(count($answer)>1)
                            {
                                $k=1;
                                foreach($answer as $row)
                                {
                                 $input[$i]['job_request_id']           =        $return;
                                 $input[$i]['question_id']                 =        $key;
                                 $input[$i]['service_type_id']          =        $data['service_type_id'];
                                 $input[$i]['user_id']                         =        $data['user_id'];
                                 $input[$i]['answer']                         =      str_replace('"',"",$row);  
                                 if($k!=count($answer))
                                         $i++;
                                 
                                  $k++;
                                }
                            }
                            else {
                                   $input[$i]['answer']                         =      str_replace('"',"",$value);    
                            }
                            $i++;
                       
                    }
               
                                                                     $this -> db -> where('job_request_id', $return);
                                                                     $this -> db -> delete('request_question_option');
                                                                     $this -> db -> insert_batch('request_question_option',$input);
           }
           
             if($providers!="")
                              {
                                  $providerArray  = explode(",",$providers);
                                  if(count($providerArray)>0)
                                  {
                                       $l=0;
                                        foreach($providerArray as $pr)
                                        {
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
                              
                              
                 if(count($documents)>0)
                 {
                     $j=0;
                       foreach($documents as $docs)
                       {
                           $docsArray[$j]["documents_name"] = $docs;
                           $docsArray[$j]["job_request_id"] = $return;
                           $j++;
                       }
                     $this -> db -> insert_batch('documents',$docsArray); 
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
        function getJobSummary($job_request_id,$language)
        {
                        $sql = " select * from job_request r, service_type s,user_table u where r.service_type_id=s.service_type_id and  service_type_language_code=".$language." and   job_request_id=".$job_request_id." and r.user_id=u.user_id " ; 
                         $rs = $this->db->query($sql);
                         return   $row = $rs->row();
        }
        function recordViewCount($userId,$job_request_id)
        {
                         $sql   =  "select count(provider_id) as count from job_view_count where job_request_id=".$job_request_id." and provider_id=".$userId.""; 
                         $rs    =  $this->db->query($sql);
                         $count =  $rs->row()->count;
                         if($count<=0)
                         {
                             $view['job_request_id']    = $job_request_id;
                             $view['provider_id']       = $userId;
                             $this->db->insert('job_view_count',$view);
                         }
        }
        function setRequestType($data,$language)
        {
                   $input['job_request_type']       =        $data['request_type'] ;
                   $key                                                =        $data['job_request_id'] ;
                   
                   $this->db->trans_start(); 
                   $this->db->where('job_request_id',$key);         
                   $this->db->update('job_request',$input);
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
        function listProvidersForRequest($data,$language)
        {
            
            $lattittude =  $data['lattitude']!=""?$data['lattitude']:"0";
            $longitude  =  $data['longitude']!=""?$data['longitude']:"0";
            
            $rating = $data['rating'];
            //$lattittude =  "0";
           // $longitude  =  "0";
                       $sql = "select s.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,company_name,user_image ,(CASE WHEN AVG(user_rating)> 0 THEN AVG(user_rating) ELSE 0 END ) as rating, (
      6371 * acos (
      cos ( radians(CAST (lattitude AS double precision)) )
      * cos( radians( CAST (".$lattittude." AS double precision) ) )
      * cos( radians( CAST (".$longitude." AS double precision) ) - radians(CAST (longitude AS double precision)) )
      + sin ( radians(CAST (lattitude AS double precision)) )
      * sin( radians( CAST (".$lattittude." AS double precision) ) )
    )
) AS distance

from job_request r,user_table u,provider_details d,service_type s,provider_service_type ps

LEFT JOIN provider_rating pr ON pr.provider_id =ps.provider_id and rating_status=1 

WHERE u.user_id=d.user_id and ps.provider_id=u.user_id and ps.service_type_id=s.service_type_id  and s.service_type_id=r.service_type_id and 

service_type_language_code=".$language."  and user_status=1 
" ; 
                       if($data['job_request_id']>0)
                       {
                           $sql.= " and job_request_id=".$data['job_request_id']." "; 
                       }
                         if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
                       if($data['key_word']!="")
                       {
                           $search_key  = strtolower($data['key_word']);
                           
                           $sql.=      " and ( LOWER(company_name) like  '%". $search_key."%' or LOWER(location) like  '%". $search_key."%' or LOWER(job_location) like  '%". $search_key."%' ) ";
                       }
              $sql.= " GROUP BY s.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,company_name,user_image";         
              
             $already=0;
              if($rating>0)
                      {
                            if($already==0)
                            {
                                 $sql.= " HAVING ";
                            }
                            else
                            {
                                $sql.= " and ";
                            }
                           $sql.= "   avg(user_rating)>=".$rating." "; 
                      }
             
              if($data['order']!="")
              {
                       if($data['order']=="near")
                       {
                           $sql.= "  order by distance ASC ";
                       }
                         if($data['order']=="far")
                       {
                           $sql.= "  order by distance DESC ";
                       }
                        if($data['order']=="rated_high")
                       {
                           $sql.= "  order by rating DESC ";
                       }
                         if($data['order']=="rated_low")
                       {
                           $sql.= "  order by rating ASC ";
                       }
                       
              }
              else
              {
                  $sql.= "  order by distance ASC ";
              }
                     //  echo $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
                     
                    // echo $sql;
                        
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
            
        }
        function assignJobToProvider($data)
        {
                        $sql = " select count(provider_id) as count  from assign_job_provider where provider_id=".$data['provider_id']." and job_request_id=".$data['job_request_id']." " ; 
                         $rs = $this->db->query($sql);
                         $count = $rs->row()->count;
                         if($count>0)
                         {
                                 return -1;
                         }
                         else
                         {
                             $this->db->trans_start(); 
                             
                             $this->db->insert('assign_job_provider',$data);     
                             
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
        function getJobListForProvider($data,$language)
        {
            $date   = date("Y-m-d");
            $time   =  date("H:i:s");
            
 $sql = " select is_approoved,job_validity_date,job_validity_time,job_request_display_id,job_request_status,address_type,user_response_status,r.job_request_id,s.service_type_id,s.service_type_name,assign_status,aj.provider_id,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id,assigned_date from assign_job_provider aj, job_request r,provider_service_type ps,service_type s

WHERE aj.job_request_id=r.job_request_id and s.service_type_id=r.service_type_id and 

service_type_language_code=".$language."  and ps.service_type_id=r.service_type_id and aj.provider_id=ps.provider_id

and r.service_type_id in (select distinct service_type_id from provider_service_type where provider_id=aj.provider_id)  ";
 
 if($data['user_id']>0)
 {
 
       $sql.= "  and aj.provider_id =".$data['user_id']."  ";
       
 }
if($data['status']!="" && $data['status']=="pending")
 {
 
     //  $sql.= " and job_request_status not in(2,4) and assign_status in(0,3) and (user_response_status =0 or user_response_status =3 or user_response_status is null) ";
         $sql.= " and job_request_status not in(2,4,5) and assign_status not in(2,4,5) and user_response_status not in(2,1) ";
 }
  if($data['status']!="" && $data['status']=="confirmed")
 {
 
       $sql.= "  and  (user_response_status=4 or user_response_status=1) ";
       
 }
 if($data['status']!="" && $data['status']=="rejected")
 {
 
       $sql.= "  and (assign_status = 2 or  user_response_status = 2 or job_request_status=2 ) ";
       
 }
   if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
    $sql.= "   and job_request_type=2 ";
    
    $date = date("Y-m-d");
    $sql.= "     and r.job_validity_date >='".$date."'";
    $sql.= "     and r.is_approoved = 1 ";
    
     if($data['order']!="")
              {
                       if($data['order']=="price_high")
                       {
                           $sql.= "  order by job_price_to DESC ";
                       }
                         if($data['order']=="price_low")
                       {
                           $sql.= "  order by job_price_to ASC ";
                       }
                    
                       
              }
              else
              {
                  $sql.= "  order by r.job_request_id DESC ";
              }
 
    $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
    // $sql.= "  and job_validity_date>='".$date."'  ";
   // $sql.= "   and job_validity_time<='".$time."' ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
 
        }
        function getQuestionsAgainstJobRequest($jobRequestId="")
        {
            $sql = " select q.question_id,question,question_arb,answer_options_id,answer,answer_option,answer_option_arabic from question q,request_question_option ro 
LEFT JOIN answer_options a ON  a.question_id=ro.question_id  and answer_options_id::varchar=answer and a.question_id=ro.question_id
where  q.question_id=ro.question_id   ";
            if($jobRequestId>0)
            {
                $sql.=" and  ro.job_request_id=".$jobRequestId." ";
                
            }
            
            $sql.=" order by question_id ASC ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
        }
           function setProviderResponse($data)
                {
                    $input['provider_note']              =   $data['note'] ;
                    $input['assign_status']              =   $data['response_status'] ; 
                    $input['provider_response_time']     =   date("Y-m-d H:i:s") ;
                    
                    
                    if($data['response_status']!=5)
                    {
                        
                        $verifyCurrentStatus =   $this->common_functions->changedStatus($this->common_functions->decryptId($data['job_request_id']),$data['response_status'],$data['provider_id']) ;
                        
                        if($verifyCurrentStatus<0)
                        {
                            
                            return $verifyCurrentStatus;
                            
                        }
                    }
                    
                    $this->db->trans_start();
                    $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));   
                    $this->db->where('provider_id',$data['provider_id']);  
                    $this->db->update('assign_job_provider',$input);
                    
                    if($data['response_status']==5)
                    {
                        $job['job_request_status']  = 5;
                        $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                        $this->db->update('job_request',$job);
                        
                    }
                    
                     $requestId = $this->common_functions->decryptId($data['job_request_id']);
                   
                    if($data['response_status']==2)
                        {
                            
                            
                       
                       $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$requestId."";                       
                       $rs     = $this->db->query($sql);
                       $count  =   $rs->row()->count;  
                       if($count==1)
                        {
                           //echo "2-";
                            $res['job_request_status'] = 2;
                            $this->db->where('job_request_id',$requestId); 
                            $this->db->where('job_request_type',2); 
                            $this->db->update('job_request',$res);
                        }  
                            
                            
                            
                            
                           $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$requestId." and (user_response_status=2 or assign_status=2) ";                       
                           $rs     = $this->db->query($sql);
                           $count  =   $rs->row()->count;  
                           
                           $sql2    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$requestId." ";                       
                           $rs2     = $this->db->query($sql2);
                           $count2  =   $rs2->row()->count;  
                           if($count==$count2)
                           {
                                // echo "1-";
                                $res['job_request_status'] = 2;
                                $this->db->where('job_request_id',$requestId);  
                                $this->db->where('job_request_type',2);
                                $this->db->update('job_request',$res);
                                
                           }
                        }  
                    
                    
                    
                   // echo $this->db->last_query();
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
                function setUserResponse($data)
                {
                    
                   // print_r($data);exit;
                    $input['user_note']                 =   $data['note'] ;
                    $input['user_response_status']      =   $data['response_status'] ; 
                    $input['user_response_time']        =   date("Y-m-d H:i:s") ;
                    $this->db->trans_start();
                    
                    $providerId  = $data['provider_id']>0?$data['provider_id']:0;
                    
                    $verifyCurrentStatus =   $this->common_functions->changedStatus($this->common_functions->decryptId($data['job_request_id']),$data['response_status'],$providerId) ;
                    
                    if($verifyCurrentStatus<0)
                    {
                        
                        return $verifyCurrentStatus;
                        
                    }
                    if($data['response_status']==1)
                    {
                         $input2['user_response_status']      =  2;
                         $input2['user_response_time']        =   date("Y-m-d H:i:s") ;
                         $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id'])); 
                         $this->db->update('assign_job_provider',$input2);
                    }
                    
                    $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id'])); 
                    if($data['provider_id']>0)
                    {
                       $this->db->where('provider_id',$data['provider_id']);  
                    }
                    $this->db->update('assign_job_provider',$input);
                    //echo $this->db->last_query();
                    //exit;
                    if($data['response_status']==1)
                    {
                        $res['job_request_status'] = 4;
                        $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                        $this->db->update('job_request',$res);
                     
                    }
                    if($data['provider_id']<=0 && $data['response_status']==2)
                    {
                       // echo "3-";
                        $res['job_request_status'] = 2;
                        $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                        $this->db->update('job_request',$res);
                    }
                    
                    
                    
                       $sql               =  "select job_request_type,is_approoved from job_request where job_request_id=".$this->common_functions->decryptId($data['job_request_id'])."";                       
                       $rs                =  $this->db->query($sql);
                       $job_request_type  =   $rs->row()->job_request_type;  
                       
                       if($rs->row()->is_approoved<=0 && $data['response_status']==2)
                       {
                           $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                           $this->db->delete('job_request');
                           $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                           $this->db->delete('assign_job_provider');
                           
                           $sql               =  "select node_reference,user_rference from job_firebase_node where job_request_id=".$this->common_functions->decryptId($data['job_request_id'])."";                       
                           $rs                =   $this->db->query($sql);
                           $nodeReference     =   $rs->row()->node_reference;
                           $user_rference     =   $rs->row()->user_rference;
                           if($nodeReference!="" && $user_rference!="")
                           {
                           
                            $database = get_firebase_refrence();
						    $database->getReference('Notification/'.$user_rference.'/'. $nodeReference)->remove();
						    
                           }
                       }
                    
                    
                       $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$this->common_functions->decryptId($data['job_request_id'])."";                       
                       $rs     = $this->db->query($sql);
                       $count  =   $rs->row()->count;  
                       if($count==1 && $data['response_status']==2 && $job_request_type==2)
                       {
                           //echo "2-";
                            $res['job_request_status'] = 2;
                            $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                            $this->db->update('job_request',$res);
                        }
                        if($data['response_status']==2)
                        {
                           $sql    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$this->common_functions->decryptId($data['job_request_id'])." and (user_response_status=2 or assign_status=2)";                       
                           $rs     = $this->db->query($sql);
                           $count  =   $rs->row()->count;  
                           
                           $sql2    = "select count( job_request_id ) AS count from assign_job_provider a,user_table u where u.user_id=a.provider_id and u.user_status=1 and job_request_id=".$this->common_functions->decryptId($data['job_request_id'])." ";                       
                           $rs2     = $this->db->query($sql2);
                           $count2  =   $rs2->row()->count;  
                           if($count==$count2 && $job_request_type==2)
                           {
                              // echo "1-";
                                $res['job_request_status'] = 2;
                                $this->db->where('job_request_id',$this->common_functions->decryptId($data['job_request_id']));  
                                $this->db->update('job_request',$res);
                           }
                        }
                    
                   // echo $this->db->last_query();
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
  function getJobListForUser($data,$language)
        {
            $date   = date("Y-m-d");
            $time   =  date("H:i:s");
            
 $sql = " select 	is_approoved,job_request_status,job_request_display_id,job_validity_date,job_validity_time,address_type,job_date,job_time,city,state,description,r.job_request_id,s.service_type_id,s.service_type_name,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id from  job_request r,service_type s

WHERE  s.service_type_id=r.service_type_id and 

service_type_language_code=".$language."  

 ";
 
 if($data['user_id']>0)
 {
 
       $sql.= "  and r.user_id =".$data['user_id']."  ";
       
 }
 if($data['status']!="" && $data['status']=="pending")
 {
 
        $sql.=      " and r.job_request_status not in(2,4,5)"; 
       
 }
  if($data['status']!="" && $data['status']=="confirm")
 {
 
      $sql.=      " and r.job_request_id in (select job_request_id from assign_job_provider a2 where user_response_status=1 and r.user_id=".$data['user_id']." )  "; 
       
 }
 if($data['status']!="" && $data['status']=="rejected")
 {
 
       $sql.=      " and r.job_request_status=2 "; 
       
 }
  if($data['status']!="" && $data['status']=="completed")
 {
 
       $sql.=      " and r.job_request_status=5 "; 
       
 }
   if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
    $sql.= "   and job_request_type=2 ";
    
     $date = date("Y-m-d");
             $sql.= "     and r.job_validity_date >='".$date."'";
    
     if($data['order']!="")
              {
                       if($data['order']=="price_high")
                       {
                           $sql.= "  order by job_price_to DESC ";
                       }
                         if($data['order']=="price_low")
                       {
                           $sql.= "  order by job_price_to ASC ";
                       }
                    
                       
              }
              else
              {
                  $sql.= "  order by r.job_request_id DESC ";
              }
 
    $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
    // $sql.= "  and job_validity_date>='".$date."'  ";
   // $sql.= "   and job_validity_time<='".$time."' ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
 
        }
        function getUserQuotations($data,$language)
        {
            $date   = date("Y-m-d");
            $time   =  date("H:i:s");
            
 $sql = "  select is_approoved,job_request_status,address_type,job_validity_date,job_validity_time,job_date,job_time,city,state,description,r.job_request_id,s.service_type_id,s.service_type_name,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id from  
    job_request r,service_type s WHERE  s.service_type_id=r.service_type_id and

service_type_language_code=".$language."  

 ";
 
  $search_key  = strtolower($data['key_word']);

           if($search_key!="")
           {
                $sql.=      " and (  LOWER(service_type_name) like  '%". $search_key."%'  or  LOWER(job_location) like  '%". $search_key."%' or  LOWER(job_request_display_id) like  '%". $search_key."%') ";
           }
           
    if($data['from_date']!="" && $data['to_date']!="")
            {
                
                $sql.=      " and date(job_validity_date)>='".$data['from_date']."' and  date(job_validity_date)<='".$data['to_date']."' "; 
            }
            if($data['from_date']!="" && $data['to_date']=="")
            {
                $sql.=      " and date(job_validity_date)>='".$data['from_date']."' and  date(job_validity_date)<='".$data['from_date']."' "; 
            }
            if($data['from_date']=="" && $data['to_date']!="")
            {
                
                $sql.=      " and date(job_validity_date)>='".$data['to_date']."' and  date(job_validity_date)<='".$data['to_date']."' "; 
            }       
               
     if($data['status']!="" && $data['status']=="pending")
     {
     
           $sql.= "  and job_request_status not in(2,4,5) ";
           
     }
      if($data['status']!="" && $data['status']=="confirm")
     {
     
           $sql.= "  and job_request_status= 4 ";
           
     }
     if($data['status']!="" && $data['status']=="rejected")
     {
     
           $sql.= "   and job_request_status= 2 ";
           
     }
     if($data['status']!="" && $data['status']=="completed")
     {
     
           $sql.= "  and job_request_status= 5 ";
           
     }
 
 if($data['user_id']>0)
 {
 
       $sql.= "  and r.user_id =".$data['user_id']."  ";
       
 }
 
   if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
      
                         if($data['type']==2)
                       {                 
                            $sql.= "   and job_request_type=2 ";
                       }
                       else
                       {
                            $sql.= "   and job_request_type=1 ";
                       }
    
            // $date = date("Y-m-d");
            // $sql.= "     and r.job_validity_date >='".$date."'";
            $date = date("Y-m-d H:i:s");
           // $sql.= "     and (r.job_validity_date|| ' '||r.job_validity_time)::timestamp >='".$date."'::timestamp ";
            
    
     if($data['order']!="")
              {
                       if($data['order']=="price_high")
                       {
                           $sql.= "  order by job_price_to DESC ";
                       }
                         if($data['order']=="price_low")
                       {
                           $sql.= "  order by job_price_to ASC ";
                       }
                       if($data['order']=="newest")
                       {
                           $sql.= " order by r.job_request_id DESC  ";
                       }
                       if($data['order']=="oldest")
                       {
                           $sql.= " order by r.job_request_id ASC  ";
                       }
              }
              else
              {
                  $sql.= "  order by r.job_request_id DESC ";
              }
 
    $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
    // $sql.= "  and job_validity_date>='".$date."'  ";
   // $sql.= "   and job_validity_time<='".$time."' ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
        }
         function getOffersCount($jobRequestId)
     {
                       $sql = "select count( r.job_request_id ) AS count from assign_job_provider aj, job_request r,provider_service_type ps,service_type s

WHERE aj.job_request_id=r.job_request_id and s.service_type_id=r.service_type_id and 

service_type_language_code=1  and ps.service_type_id=r.service_type_id and aj.provider_id=ps.provider_id

 and r.job_request_id=".$jobRequestId."    ";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->row()->count; 
     }
     function viewProvidersOffers($data,$language)
     {
            $date   = date("Y-m-d");
            $time   =  date("H:i:s");
            $longitude = $data['longitude'] ;
            $lattitude = $data['lattitude'] ;
            
 $sql = " select aj.document_name,job_request_status,u.user_image,pd.user_id as provider_id,pd.company_name,pd.lattitude,pd.longitude,pd.location,r.job_request_id,provider_amount,user_response_status,s.service_type_id,s.service_type_name,assign_status,aj.provider_id,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id,assigned_date, 
       ( 3959 * acos( cos( radians(".$lattitude.") ) 
              * cos( radians( CAST (lattitude  AS double precision)) ) 
              * cos( radians(  CAST (longitude AS double precision)) - radians(".$longitude.") ) 
              + sin( radians(".$lattitude.") ) 
              * sin( radians(  CAST (lattitude  AS double precision)) ) ) ) AS distance,(CASE WHEN AVG(user_rating)> 0 THEN AVG(user_rating) ELSE 0 END ) as rating from assign_job_provider aj, job_request r,provider_service_type ps,service_type s,provider_details pd,user_table u
LEFT JOIN provider_rating pr ON u.user_id=pr.provider_id and rating_status=1 
WHERE aj.job_request_id=r.job_request_id and s.service_type_id=r.service_type_id and 

service_type_language_code=".$language."  and ps.service_type_id=r.service_type_id and aj.provider_id=ps.provider_id

 and r.job_request_id=".$data['job_request_id']."  and pd.user_id=aj.provider_id and u.user_id=pd.user_id";
 
 if($data['user_id']>0)
 {
 
       $sql.= "  and r.user_id =".$data['user_id']."  ";
       
 }
 if($data['status']!="" && $data['status']=="pending")
 {
 
       $sql.= "  and assign_status in(0,3) and (user_response_status =0 or user_response_status =3 or user_response_status is null) ";
       
 }
  if($data['status']!="" && $data['status']=="confirm")
 {
 
       $sql.= "  and  ( user_response_status=4 or user_response_status=1) ";
       
 }
 if($data['status']!="" && $data['status']=="rejected")
 {
 
       $sql.= "  and (assign_status =2 or  user_response_status =2) ";
       
 }
   if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
    $sql.= "    GROUP BY    aj.document_name,job_request_status,u.user_image,pd.user_id ,pd.company_name,pd.lattitude,pd.longitude,pd.location,r.job_request_id,provider_amount,user_response_status,s.service_type_id,s.service_type_name,assign_status,aj.provider_id,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id,assigned_date";
    
     if($data['order']!="")
              {
                       if($data['order']=="price_high")
                       {
                           $sql.= "  order by provider_amount DESC ";
                       }
                       else  if($data['order']=="price_low")
                       {
                           $sql.= "  order by provider_amount ASC ";
                       }
                      else  if($data['order']=="distance_low")
                       {
                           $sql.= "  order by distance ASC ";
                       }
                       else  if($data['order']=="distance_high")
                       {
                           $sql.= "  order by distance DESC ";
                       } 
                       else
                       {
                            $sql.= "  order by assigned_date DESC ";
                       }
              }
              else
              {
                  $sql.= "  order by assigned_date DESC ";
              }
              
             // echo $sql;
 
     //$sql.=" OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
    // $sql.= "  and job_validity_date>='".$date."'  ";
   // $sql.= "   and job_validity_time<='".$time."' ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
     }
     function getTotalRating($providerId)
     {
           $sql = "select count(provider_id ) AS count from provider_rating aprovider_rating WHERE provider_id=".$providerId." and rating_status=1 ";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->row()->count; 
     }
   function getProvidersQuotations($data,$language)
        {
            $date   = date("Y-m-d");
            $time   =  date("H:i:s");
            
 $sql = "  select is_approoved,job_validity_date,job_validity_time,address_type,user_response_status,assign_status,assigned_date,r.job_request_id,s.service_type_id,s.service_type_name,job_price_from,job_price_to,job_location,job_longitude,job_lattitude,r.user_id from  
    service_type s,job_request r LEFT JOIN assign_job_provider aj ON aj.job_request_id=r.job_request_id and aj.provider_id=".$data['user_id']."  WHERE  s.service_type_id=r.service_type_id and

service_type_language_code=".$language."  

 ";
 
 if($data['user_id']>0)
 {
      if($data['type']==2)
      {
 
       $sql.= "  and r.job_request_id in(select job_request_id from assign_job_provider where provider_id=".$data['user_id'].")  ";
       
      }
      else
      {
          $sql.= "  and r.service_type_id in(select service_type_id from provider_service_type where provider_id=".$data['user_id'].")  ";
      }
       
 }
 
       $search_key  = strtolower($data['key_word']);

           if($search_key!="")
           {
                $sql.=      " and (  LOWER(service_type_name) like  '%". $search_key."%'  or  LOWER(job_location) like  '%". $search_key."%' or  LOWER(job_request_display_id) like  '%". $search_key."%') ";
           }
 
 if($data['status']!="" && $data['status']=="pending")
 {
 
       $sql.= "  and (assign_status in(0,3) or assign_status is null) and (user_response_status =0 or user_response_status =3 or user_response_status is null) ";
       
 }
  if($data['status']!="" && $data['status']=="confirm")
 {
 
       $sql.= "  and ( user_response_status=4 or user_response_status=1) ";
       
 }
 if($data['status']!="" && $data['status']=="rejected")
 {
 
       $sql.= "  and (assign_status =2 or  user_response_status =2) ";
       
 }
 if($data['status']!="" && $data['status']=="completed")
 {
 
       $sql.= "  and assign_status=5 ";
       
 }
   if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
                       
    if($data['type']==2)
    {                   
      $sql.= "   and job_request_type=2 ";
    }
    else
    {
         $sql.= "   and job_request_type=1 ";
    }
    //$date = date("Y-m-d");
   // $sql.= "     and r.job_validity_date >='".$date."'";
     $date = date("Y-m-d H:i:s");
    // $sql.= "     and (r.job_validity_date|| ' '||r.job_validity_time)::timestamp >='".$date."'::timestamp ";
   
   
    $sql.= "     and r.is_approoved=1 ";
    
    
     if($data['from_date']!="" && $data['to_date']!="")
            {
                
                $sql.=      " and date(job_validity_date)>='".$data['from_date']."' and  date(job_validity_date)<='".$data['to_date']."' "; 
                
            }
            if($data['from_date']!="" && $data['to_date']=="")
            {
                $sql.=      " and date(job_validity_date)>='".$data['from_date']."' and  date(job_validity_date)<='".$data['from_date']."' "; 
                
            }
            if($data['from_date']=="" && $data['to_date']!="")
            {
                
                $sql.=      " and date(job_validity_date)>='".$data['to_date']."' and  date(job_validity_date)<='".$data['to_date']."' "; 
            }
    
    
     if($data['order']!="")
              {
                       if($data['order']=="price_high")
                       {
                           $sql.= "  order by job_price_to DESC ";
                       }
                         if($data['order']=="price_low")
                       {
                           $sql.= "  order by job_price_to ASC ";
                       }
                       if($data['order']=="oldest")
                       {
                            $sql.= "  order by r.job_request_id ASC ";
                       }
                       if($data['order']=="newest")
                       {
                            $sql.= "  order by r.job_request_id DESC ";
                       }
                       
              }
              else
              {
                  $sql.= "  order by r.job_request_id DESC ";
              }
 
    $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
    // $sql.= "  and job_validity_date>='".$date."'  ";
   // $sql.= "   and job_validity_time<='".$time."' ";
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
        }
        function markPrice($data)
        {
            
                    
                    $sql="select  count(job_request_id) as count from assign_job_provider where job_request_id= ".$data['job_request_id']." and provider_id=".$data['provider_id']." and provider_amount>0 ";
                    $rs = $this->db->query($sql);
                    $count = $result = $rs->row()->count;
                    if($count>0)
                    {
                        return -5;
                    }
                    else
                    {
                        
                    
                    $verifyCurrentStatus  =   $this->common_functions->changedStatus($data['job_request_id'],3,$data['provider_id']) ;
                    
                    if($verifyCurrentStatus<0)
                    {
                        
                        return $verifyCurrentStatus;
                        
                    }    
                        
                        
                   
                    $provider['provider_amount']                  =        $data['price'] ; 
                    $provider['provider_response_time']     =        date("Y-m-d H:i:s") ;
                    $provider['job_request_id']                       =        $data['job_request_id'];
                    $provider['assign_status']                          =        3;
                    $provider['provider_id']                              =        $data['provider_id'];
                    $provider['assigned_date']                        =        date("Y-m-d H:i:s");
                    $provider['document_name']                   =       $data['document_name'];
                    
                    
                    //$type       =  $this->getJobRequestType($provider['job_request_id']);
                    
                    $this->db->trans_start(); 
                    $sql="select  count(job_request_id) as count from assign_job_provider where job_request_id= ".$data['job_request_id']." and provider_id=".$data['provider_id']."";
                    $rs = $this->db->query($sql);
                    $count = $result = $rs->row()->count;
                    if($count<=0)
                    {
                        
                      $this->db->insert('assign_job_provider',$provider);
                      
                    }
                    else
                    {
                         unset($provider['job_request_id']);
                         $this->db->where('provider_id',$data['provider_id']);
                         $this->db->where('job_request_id',$data['job_request_id']);
                         $this->db->update('assign_job_provider',$provider);
                    }
                    //echo $this->db->last_query();
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
         function getQuestionsSingle($serviceTypeId,$parentQuestionId,$parentAnswerId)
        {
         
                         $sql  = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1" ; 
                         $sql.= "  and questions_service_type_id=".$serviceTypeId.""; 
                         if($parentAnswerId>0)
                         {
                             // $sql.= "  and answer_parent_id=".$parentAnswerId."";
                              $sql.= "  and answer_parent_id in(".$parentAnswerId.")";
                         }
                          if($parentQuestionId>0)
                         {
                              $sql.= "  and question_parent_id=".$parentQuestionId."";
                              //$sql.= "  and question_parent_id in(".$parentQuestionId.")";
                              
                         }
                        $sql.= "  order by question_id ASC limit 1"; 
                        $rs = $this->db->query($sql);
                          $row = $rs->row();
                          if(count($row)>0)
                          {
                              return  $row;
                          }
                          else
                          {
                            
                               $sql= "select question_parent_id,question_id  from question where question_id=".$parentQuestionId.""; 
                               $rs = $this->db->query($sql);
                               $question_Parent_id = $rs->row()->question_parent_id;
                               $question_id = $rs->row()->question_id;
                              //return count($this->getQuestionAlternate($question_Parent_id,$serviceTypeId))>0?$this->getQuestionAlternate($question_Parent_id,$serviceTypeId):$this->getQuestionAlternate($question_id,$serviceTypeId);
                     // return count($this->getQuestionAlternate($question_id,$serviceTypeId,$parentQuestionId))>0?$this->getQuestionAlternate($question_id,$serviceTypeId,$parentQuestionId):$this->getQuestionAlternate($question_Parent_id,$serviceTypeId,$parentQuestionId);
                           
                           return  $this->getQuestionAlternate($question_id,$serviceTypeId,$parentQuestionId);
                          }
        }
        function getQuestionAlternate($question_id,$serviceTypeId,$parentQuestionId)
        {
              $sql  = " select * from question q,form_controls f where f.form_control_id=question_form_type and question_status=1" ; 
                               $sql.= "  and questions_service_type_id=".$serviceTypeId." and question_parent_id<=0 "; 
                                 if($question_id>0)
                                 {
                                      $sql.= "  and question_id>".$question_id."";
                                 }
                               $sql.= "  order by question_id ASC limit 1"; 
                               
                                $rs = $this->db->query($sql);
                               return $row = $rs->row();
        }
          function getProviderDetails($providerId,$longitude,$lattitude)
                {
                
                    
                      $sql="select user_phone,user_dial_code,user_last_name,user_first_name,location,u.user_id,user_image,company_name,profile_document,website_url,avg(user_rating) as rating,
       ( 3959 * acos( cos( radians(".$lattitude.") ) 
              * cos( radians( CAST (lattitude  AS double precision)) ) 
              * cos( radians(  CAST (longitude AS double precision)) - radians(".$longitude.") ) 
              + sin( radians(".$lattitude.") ) 
              * sin( radians(  CAST (lattitude  AS double precision)) ) ) ) AS distance from provider_service_type ps,provider_details p,user_table u LEFT JOIN provider_rating r 
ON u.user_id=r.provider_id and rating_status=1

where ps.provider_id=u.user_id and u.user_id=p.user_id

 and u.user_status=1     and u.user_id=".$providerId."";
                   
                      $sql.= "  GROUP BY user_image,company_name,u.user_id,location,p.lattitude,p.longitude,profile_document,website_url "; 
                      
                     
                      $sql.=" order by company_name ASC";
                      
                      $rs = $this->db->query($sql);
                   return   $result = $rs->row();
                }
                function getUploadedFiles($jobRequestId)
                {
                       $sql = "select * from documents  WHERE job_request_id=".$jobRequestId."  ";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->result(); 
                }
                function getRespondedProviders($jobRequestId,$language)
                {
                        $sql = "select provider_amount,ap.document_name,job_request_status,user_response_status,assign_status,r.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,job_longitude,job_lattitude,job_location,company_name,user_image ,(CASE WHEN AVG(user_rating)> 0 THEN AVG(user_rating) ELSE 0 END ) as rating, (
      6371 * acos (
      cos ( radians(CAST (lattitude AS double precision)) )
      * cos( radians( CAST (job_lattitude AS double precision) ) )
      * cos( radians( CAST (job_longitude AS double precision) ) - radians(CAST (longitude AS double precision)) )
      + sin ( radians(CAST (lattitude AS double precision)) )
      * sin( radians( CAST (job_lattitude AS double precision) ) )
    )
) AS distance

from job_request r,user_table u,provider_details d,service_type s,provider_service_type ps,assign_job_provider ap

LEFT JOIN provider_rating pr ON pr.provider_id =ap.provider_id and rating_status=1

WHERE u.user_id=d.user_id and ps.provider_id=u.user_id and ps.service_type_id=r.service_type_id  and s.service_type_id=r.service_type_id and 

service_type_language_code=".$language."  and user_status=1  and ap.provider_id=u.user_id and r.job_request_id=ap.job_request_id and r.job_request_id=".$jobRequestId." 
" ; 
                       if($data['job_request_id']>0)
                       {
                           $sql.= " and job_request_id=".$data['job_request_id']." "; 
                       }
                         if($data['service_type_id']>0)
                       {
                           $sql.= " and r.service_type_id=".$data['service_type_id']." "; 
                       }
                       if($data['key_word']!="")
                       {
                           $search_key  = strtolower($data['key_word']);
                           
                           $sql.=      " and ( LOWER(company_name) like  '%". $search_key."%' or LOWER(location) like  '%". $search_key."%' or LOWER(job_location) like  '%". $search_key."%' ) ";
                       }
              $sql.= " GROUP BY provider_amount,ap.document_name,job_request_status,user_response_status,assign_status,r.service_type_id,service_type_name,ps.provider_id,lattitude,longitude,location,job_longitude,job_lattitude,job_location,company_name,user_image";         
              
              if($data['order']!="")
              {
                       if($data['order']=="near")
                       {
                           $sql.= "  order by distance ASC ";
                       }
                         if($data['order']=="far")
                       {
                           $sql.= "  order by distance DESC ";
                       }
                        if($data['order']=="rated_high")
                       {
                           $sql.= "  order by rating DESC ";
                       }
                         if($data['order']=="rated_low")
                       {
                           $sql.= "  order by rating ASC ";
                       }
                       
              }
              else
              {
                  $sql.= "  order by company_name ASC ";
              }
              if($data['page_limit']>0)
              {
                        $sql.="  OFFSET ".$data['page_offset']." LIMIT ".$data['page_limit']." "; 
              }
               // echo $sql;        
                         $rs = $this->db->query($sql);
                         return   $row = $rs->result();
                }
                function checkPriceAlreadyMarked($jobRequestId,$userId)
                {
                       $sql = "select * from job_request j LEFT JOIN assign_job_provider jp  ON   provider_id=".$userId." and j.job_request_id=jp.job_request_id WHERE j.job_request_id=".$jobRequestId."";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->row();
                }
                function updateToFirbase($userId,$type,$message,$title,$jobType,$id)
                {
                    
                    $touserID       =   $type.$userId;
                    
                    $t = round(microtime(true) * 1000);
                    
                    $notification_data['Notification/'.$touserID."/".$t.""] = [
																            "createdAt"         => date('Y-m-d H:i:s'),
																            "createdAtUTS"      => date('Y-m-d H:i:s'),
																            "description"       => ''.$message,
																            "notificationType"  => $jobType,
																            "notification_id"   => $id,
																            "hide"              => "0",
																            "title"             => ''.$title,
																            "viewed"            => "0",
																            "read"              => "0",
																		 ];
																		 
						 $database = get_firebase_refrence();
																		 
						 $database->getReference()->update($notification_data);
                }
                function getProvidersAgainsServiceType($serviceType)
                {
                       $sql = "select distinct provider_id from provider_service_type where service_type_id=".$serviceType."";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->result();
                }
                function getJobType($jobRequestId)
                {
                      $sql = "select distinct job_request_type from job_request where job_request_id=".$jobRequestId."";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->row()->job_request_type;
                }
                function getConfirmedProviderDetals($jobRequestId)
                {
                       $sql = "select u.* from user_table u,assign_job_provider a where a.provider_id=u.user_id and  job_request_id=".$jobRequestId." and user_response_status=1 ";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->row();
                }
                function getUerType($userId)
                {
                        $sql = " select u.user_id,u.user_type from user_table u where   user_id=".$userId." limit 1" ; 
                        $rs  = $this->db->query($sql);
                        return   $row = $rs->row();
                }
                function getAssignedStatus($jobRequestId,$userId)
                {
                        $sql  = " select assign_status,user_response_status,provider_id from assign_job_provider  where job_request_id=".$jobRequestId."  and   provider_id=".$userId." limit 1 " ; 
                        $rs   = $this->db->query($sql);
                        return   $row = $rs->row();
                }
                function getMaintenanceServiceTypes($language)
                {
                       $sql = "select * from service_type where service_type_language_code=".$language." and service_type_status=1 and service_methode=4";                       
                       $rs = $this->db->query($sql);
                       return  $result  =   $rs->result();
                }
                 function getPopularServiceTypes($language)
                {
                       $sql = "select * from service_type where service_type_language_code=".$language." and service_type_status=1 and service_type_id in (select distinct service_type_id from job_request)";                       
                       $rs = $this->db->query($sql);
                       if(count($rs->result()<=0))
                       {
                            $sql = "select * from service_type where service_type_language_code=".$language." and service_type_status=1 ";                       
                            $rs = $this->db->query($sql);
                            return  $result  =   $rs->result();
                       }
                       else
                       {
                          return  $result  =   $rs->result();
                       }
                }
                 function getJobRequestType($job_request_id)
                {
                        $sql          =  "select job_request_type from job_request where job_request_id=".$job_request_id.""; 
                        $rs           =  $this->db->query($sql);
                        return $count =  $rs->row()->job_request_type;
                }
                function isReadRequest($job_request_id,$userId)
                {
                       $sql           =  "select count(job_request_id) as count from job_view_count where job_request_id=".$job_request_id." and provider_id=".$userId.""; 
                        $rs           =  $this->db->query($sql);
                        return $count =  $rs->row()->count;
                }
                 function searchServiceType($data)
                {
                    
                       $sql       = "select * from service_type where service_type_language_code=".$data['service_type_language_code']." and service_type_status=".$data['service_type_status']." ";  
                       $search_key  = strtolower($data['service_key_word']);

                   if($search_key!="")
                   {
                        $sql.=      " and LOWER(service_type_name) like  '%". $search_key."%' ";
                   }
                    if($data['city_id']>0)
                       {
                            $sql.=      " and service_type_id in (select service_type_id from provider_service_type p,user_table u where city_id=".$data['city_id']." and p.provider_id=u.user_id and user_status=1  ) ";
                            
                       } 
           
           //echo $sql;
                      
                       $rs       =  $this->db->query($sql);             
                       return $result  =   $rs->result(); 
                   
                }
}
<?php 
class M_common extends CI_Model 
{
        function getCountries($language=0,$id=0,$status="")
        {
          
                      $language   = $language>0?$language:1;    
                      
                      $this->db->select('*');
                      $this->db->from('country c');        
                      $this->db->where('country_language_code',$language);
                      if($id>0)
                      {
                            $this->db->where('country_id',$id);
                      }
                       if($status>0)
                      {
                            $this->db->where('country_status',$status);
                      }
                      $this->db->order_by('country_language_code','ASC');
                      $query = $this->db->get();     
                       if($id<=0)
                      {
                           return $query->result();
                      }
                      else
                      {
                            return $query->row();
                      }

        }
        function getCities($data)
        {
           
            $query = $this->db->order_by('city_name', 'asc')->get_where('city', $data);                  
            return $query->result();
        }
        
        function getServiceTypes($data, $limit = 0)
        {
            $this->db->where('service_type_parent_id',0);
            
            if($limit)
                $this->db->limit($limit);
            
            $query = $this->db->order_by('service_type_name', 'asc')->get_where('service_type', $data);                  
            return $query->result();
        }
        
        public function getSubServices($service_type_parent_id){
            $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
            
            $this->db->select('*');
            $this->db->where('service_type_parent_id',$service_type_parent_id);
            $this->db->where('service_type_language_code',$language);
            return $this->db->get('service_type')->result();
        }
        
          
      function getTestimonials($data)
                {
                    
                    $query = $this->db->order_by('testimonial_id', 'desc')->get_where('testimonial', $data);
                    return $query->result();
                }
                function userTypeWiseCount($type)
                {
                       $sql="select  count(user_id) as count from user_table where user_type=".$type." and user_status=1 ";
                       $rs = $this->db->query($sql);
                       return $count = $result = $rs->row()->count;
                    
                }
                function jobsCompletedCount()
                {
                      $sql="select  count(job_request_id) as count from job_request where job_request_status=4 ";
                      $rs = $this->db->query($sql);
                       return $count = $result = $rs->row()->count;
                    //return 0;
                }
                 function turnOver()
                {
                      $sql="select  count(assign_job_provider_id) as count from assign_job_provider ";
                      $rs = $this->db->query($sql);
                       return $count = $result = $rs->row()->count;
                    //return 0;
                }
                function getProviders($data)
                {
                   
                    $serviceTypeId    =     $data['service_type_id'];
                    
                        $lattitude             =     $data['lattitude']!=""?$data['lattitude']:"24.1104026";
                        $longitude             =     $data['longitude']!=""?$data['longitude']:"55.827169599999934"; 
                    
                  $searchKey            =     strtolower($data['txt_keyword']) ; 
                   $rating                   =     $data['txt_rating'];
                   $distance              =     $data['txt_distance'];
                    
                      $sql="select u.user_id,user_image,company_name,avg(user_rating) as rating,
       ( 3959 * acos( cos( radians(".$lattitude.") ) 
              * cos( radians( CAST (lattitude  AS double precision)) ) 
              * cos( radians(  CAST (longitude AS double precision)) - radians(".$longitude.") ) 
              + sin( radians(".$lattitude.") ) 
              * sin( radians(  CAST (lattitude  AS double precision)) ) ) ) AS distance from provider_service_type ps,provider_details p ,user_table u LEFT JOIN  provider_rating r  ON u.user_id=r.provider_id and rating_status=1  where ps.provider_id=u.user_id and u.user_id=p.user_id

and ps.service_type_id=".$serviceTypeId." and u.user_status=1   ";
                      if($searchKey!="")
                      {
                           $sql.= " and  LOWER(company_name) like  '%".$searchKey."%' ";
                      }
                       if($serviceTypeId>0)
                      {
                           $sql.= " and  u.user_id in( select distinct provider_id from provider_service_type where service_type_id=".$serviceTypeId.")";
                      }
                      $sql.= " GROUP BY user_image,company_name,distance,u.user_id "; 
                      
                      $already =0;
                           if($distance>0)
                      {
                               $already=1;
                           $sql.= " having   ( 3959 * acos( cos( radians(".$lattitude.") ) 
              * cos( radians( CAST (lattitude  AS double precision)) ) 
              * cos( radians(  CAST (longitude AS double precision)) - radians(".$longitude.") ) 
              + sin( radians(".$lattitude.") ) 
              * sin( radians(  CAST (lattitude  AS double precision)) ) ) )  <=".$distance." "; 
                      }
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
                     
                      $sql.=" order by company_name ASC";
                      
                      $rs = $this->db->query($sql);
                   return   $result = $rs->result();
                }
                  function getProviderDetails($providerId)
                {
                
                    
                      $sql="select user_phone,user_dial_code,user_last_name,user_first_name,location,u.user_id,user_image,company_name,profile_document,website_url,avg(user_rating) as rating from provider_service_type ps,provider_details p,user_table u LEFT JOIN provider_rating r 
ON u.user_id=r.provider_id and rating_status=1

where ps.provider_id=u.user_id and u.user_id=p.user_id

and ps.service_type_id=1 and u.user_status=1     and u.user_id=".$providerId."";
                   
                      $sql.= "  GROUP BY user_image,company_name,u.user_id,location,profile_document,website_url "; 
                      
                     
                      $sql.=" order by company_name ASC";
                      
                      $rs = $this->db->query($sql);
                   return   $result = $rs->row();
                }
                function getAllRatings($providerId)
                {
                       $sql="select * from provider_rating r,user_table u where r. provider_id=".$providerId." and r.user_id=u.user_id and rating_status=1";
                      $rs = $this->db->query($sql);
                      return   $result = $rs->result();
                }
                function getAllServiceTypesForProvider($providerId)
                {
                       $sql=" select ARRAY_AGG (service_type_name) from service_type s,provider_service_type p WHERE p.service_type_id=s.service_type_id and provider_id=".$providerId." and service_type_language_code=1";
                      $rs = $this->db->query($sql);
                      return   $result = $rs->row();
                }
                function addRating($data)
                {
                
                         $userId   =  $this->session->userdata("eq_user_id");
                         $this->db->select('count(provider_id) as count');
                         $this->db->from('provider_rating c');        
                         $this->db->where('user_id',$userId);    
                         $this->db->where('provider_id',$data['providerId']);     
                      
                         $query = $this->db->get();              
                         if($query->row()->count>0)
                                         {
                     
                                                 return 3;
                                                 exit;
                                         }
                                         else
                                         { 
                                              
                                               $this->db->trans_start();    
                                              $rating["provider_id"]      =    $data['providerId'];
                                              $rating["user_id"]              =    $userId;
                                              $rating["user_rating"]      =    $data['rateval'];
                                              $rating["feed_back"]        =    $data['txt_feedback'];
                                              
                                                
                                               $this->db->insert("provider_rating",$rating);
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
                  function getAdminBasics()
           {
               $sql = "  select * from admin_basics limit 1 ";
                   $rs = $this->db->query($sql);
                   // echo $this->db->last_query(); 
                 return      $result  =   $rs->row(); 
           }
            function getArticles($articleId)
         {
             $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
             $sql = "  select * from articles a,article_type t where a.articles_type_id=t.article_type_id and article_type_language_code=articles_language_code and articles_language_code=".$language." and articles_type_id=".$articleId."";
                   $rs = $this->db->query($sql);
                   // echo $this->db->last_query(); 
                 return      $result  =   $rs->row(); 
                    
          }
          function getServicesList($data,$limit_per_page,$start_index)
          {
              $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
              
              $sql = "  select * from service_type where service_type_language_code=".$language." and service_type_status=1 ";
              $search_key  = strtolower($data['search_key']);
                // echo $search_key;exit;
               if($search_key!="")
               {
                    $sql.=      " and ( LOWER(service_type_name) like  '%". $search_key."%' ) ";
               }
                 if($data['city_id']>0)
               {
                    $sql.=      " and service_type_id in (select service_type_id from provider_service_type p,user_table u where city_id=".$data['city_id']." and p.provider_id=u.user_id and user_status=1  ) ";
                    
               } 
                        $sql.= " order by service_type_name ASC";  
            
                        $sql.= "    offset ".$start_index."   limit  ".$limit_per_page."";  
                        $rs      =  $this->db->query($sql);             
                         return $result  =   $rs->result(); 
              
          }
          function getServicesListCount($data)
          {
              $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
              
              $sql = "  select * from service_type where service_type_language_code=".$language." and service_type_status=1 ";
              $search_key  = strtolower(urldecode($data['search_key']));

               if($search_key!="")
               {
                    $sql.=      " and ( LOWER(service_type_name) like  '%". $search_key."%' ) ";
                    
               }
                if($data['city_id']>0)
               {
                    $sql.=      " and service_type_id in (select service_type_id from provider_service_type p,user_table u where city_id=".$data['city_id']." and p.provider_id=u.user_id and user_status=1  ) ";
                    
               }
              // echo $sql;
            $rs      = $this->db->query($sql);
             $result  =   $rs->result(); 
             $result = $rs->result_array();
             $count = count($result);
             $array['count']          = $count;        
             $array = (object) $array;
              return $array;
              
          }
           function getCityName($cityId)
                {
                     $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
                      $sql="select  city_name from city where city_id=".$cityId." and city_language_code=".$language."";
                      $rs = $this->db->query($sql);
                       return $result = $rs->row()->city_name;
                    //return 0;
                }
                 function getActiveBanner()
        {
             $language                           =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
             $sql = "  select * from banner t where banner_status =1    ";
                   $rs = $this->db->query($sql);
                   // echo $this->db->last_query(); 
                 return      $result  =   $rs->result();
        }
        function getCurrentStatus($job_request_id)
        {
            $sql = " select * from job_request r  WHERE job_request_id=".$job_request_id."  " ; 
            $rs = $this->db->query($sql);
            return   $row = $rs->row();
        }
        function getCurrentStatusProvider($job_request_id,$providerId)
        {
            $sql = " select * from assign_job_provider a  WHERE job_request_id=".$job_request_id." and provider_id=".$providerId." " ; 
            $rs = $this->db->query($sql);
            return   $row = $rs->row();
        }
         function getServiceTypesforMega($limit)
                {
                       $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
                       $sql="select  *  from service_type where service_type_language_code=".$language." and service_type_status=1 and include_mega_menu=1 order by service_type_id DESC limit ".$limit." ";
                       $rs = $this->db->query($sql);
                       return $result = $rs->result();
                    
                }
                function getServiceTypesforMega2($limit)
                {
                      $language = $this->session->userdata("language")>0? $this->session->userdata("language"):1;
                       $sql="select  *  from service_type where service_type_language_code=".$language." and service_type_status=1 and include_mega_menu=0 order by service_type_id DESC limit ".$limit." ";
                       $rs = $this->db->query($sql);
                       return $result = $rs->result();
                }
                
                
                
     public function getHowItsWork($service_type_id){

        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        return $this->db->get('how_its_work')->result();
    }
    
    public function getServiceDetails($service_type_id , $language = 1){
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('service_type_language_code',$language);
        return $this->db->get('service_type')->row();
    }
    
    public function get_seller_ratings_summary($service_ids) {
        $this->db->where_in('service_type_id',$service_ids);
        $this->db->select("round((sum(user_rating) / count(user_rating))::numeric,1) as rating,
                                    count(user_rating) as rated_users");
        return $this->db->get('user_rating_for_seller')->row();
    }
    
    public function get_rating_list($service_ids,$limi_per_page = 0,$start_index = 0 ){
        $this->db->select('*');
        $this->db->where_in('service_type_id',$service_ids);
        $this->db->join('user_table','user_table.user_id = urs.user_id','left');
        $this->db->order_by('id','desc');
        
        if($limi_per_page > 0 )
            $this->db->limit($limi_per_page,$start_index);
            
        return $this->db->get('user_rating_for_seller urs')->result();
    }

    public function get_all_by_need($table,$need=FALSE, $where=FALSE) {
        if($need){
                $this->db->select($need);
        }
        if($where){
            $this->db->where($where);
        }
        $row = $this->db->get($table)->row();
        if (isset($row)) {
            return $row;
        }
    }
    
    public function getbanerImage($service_type_id){
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('type',2);
        $this->db->order_by('id','desc');
        return $this->db->get('service_type_baner_image')->row();
    }
    
    public function getbanerImages($service_type_id){
        $this->db->select('*');
        $this->db->where('service_type_id',$service_type_id);
        $this->db->where('type',2);
        $this->db->order_by('id','desc');
        return $this->db->get('service_type_baner_image')->result();
    }
}
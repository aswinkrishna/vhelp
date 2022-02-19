<?php

Class Common_functions 
{

    function validateAccessToken($accesToken)
    {
        if($accesToken=="")
        {
              return -100;
        }
         $CI                   =         & get_instance();     
         $CI->load->model('M_user');
        $result             =      $CI->M_user->validateAccessToken($accesToken);
       //print_r($result);
       // echo count($result);
        if(count($result)<=0)
        {
            $response  =  0;
        }
        else if(count($result)==1)
        {
             $response  =  $result[0]['user_id'];
        }
        else if(count($result)>1)
        {
            $response  = -1;
        }
        return $response;
        
    }
    function showAccessTokenErrorMesssage($code,$language=0)
    {
         if($code==0)
        {
            $data['status']          =   0;
            $data['message']     =   "Invalid access token";
        }
        else if($code==1)
        {
             $data['status']              =   1;
            $data['message']         =   "Succes"; 
        }
        else if($code==-1)
        {
            $data['status']              =   0;
            $data['message']         =   "Duplicate access token";
        }
          else if($code==-100)
        {
            $data['status']              =   0;
            $data['message']         =   "access_token required";
        }
        return json_encode($data);
    }
    function encryptId($text)
        {
         $CI                   =         & get_instance();     
        $key                 =        $CI->config->item('security_key') ;
        $string             =        $text;
        $result             =        '';
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)+ord($keychar));
$result.=$char;
}
return base64_encode($result);

        }
        function decryptId($encrypted)
        {
             $CI                   =         & get_instance();     
            $key                 =         $CI->config->item('security_key') ;            
            $string            =         $encrypted;
            $result            =         '';
$string = base64_decode($string);
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)-ord($keychar));
$result.=$char;
}
if (filter_var($result, FILTER_VALIDATE_INT)) {
    
return $result;
}
else
{
    return 0;
}
            
    
        }
        function distance($lat1, $lon1, $lat2, $lon2, $unit) {
            
            /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
 function incrementalHash($len = 2){
  $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $base = strlen($charset);
  $result = '';

  $now = explode(' ', microtime())[1];
  while ($now >= $base){
    $i = $now % $base;
    $result = $charset[$i] . $result;
    $now /= $base;
  }
  return strtoUpper(substr($result, -2));
}  
    function changedStatus($jobRequestId,$status,$providerId=0)
    {
        $CI                   =         & get_instance();     
        $CI->load->model('website/M_common');
        $result               =      $CI->M_common->getCurrentStatus($jobRequestId);
        if($status==5 && $result->job_request_status==4)
        {
            return 0;
        }
        if($result->job_request_status==2)
        {
            return -1;
        }
         if($result->job_request_status==1 || $result->job_request_status==4 || $result->job_request_status==5)
        {
            return -2;
        }
        if($providerId>0)
        {
            $result2               =      $CI->M_common->getCurrentStatusProvider($jobRequestId,$providerId);
            
            if($result2->assign_status==2 || $result2->user_response_status==2)
            {
                return -3;
            }
            if($result2->user_response_status==1 || $result2->user_response_status==4)
            {
                return -4;
            }
        }
        
        return 0;
    }
    function urlFormat($string)
    {
                    $urlCategoryName  =  $string;
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                   return $urlCategoryName  = strtolower($urlCategoryName);
    }
}

<?php

 /**

  * [getCityNameById description]

  * @param   integer $city_id [description]

  * @return  [type]           [description]

  * @author Jitin Joseph <jitin.a2solution@gmail.com>

  * @created date             2018-09-18

  */

 function getCityNameById($city_id=0){



    $ci =& get_instance();  

    //load databse library

    $ci->load->database();

     

    $city_name = "";   

    if($city_id){

     $result = $ci->db->select('city.*')->from('city')->where('city_id',$city_id)->get()->row_array();

     $city_name = $result["city_name"];

    }

    return $city_name;

 }

 //-----------------------------------------------------

 

/**

 * [arrayGroup description]

 * @param   array  $data  [description]

 * @param   string $label [description]

 * @return  [type]        [description]

 * @author Jitin Joseph <jitin.a2solution@gmail.com>

 * @created date          2018-09-18

 */

 function arrayGroup($data=[],$label=""){

    foreach($data as $item){

     $groupedItems[$item[$label]][] = $item;

    }

    

    $groupedItems = array_values($groupedItems);

    return $groupedItems;

 }

 //-------------------------------------------------------



 function groupArray($arr, $group, $preserveGroupKey = false, $preserveSubArrays = false) {

    $temp = array();

    foreach($arr as $key => $value) {

        $groupValue = $value[$group];

        if(!$preserveGroupKey)

        {

            unset($arr[$key][$group]);

        }

        if(!array_key_exists($groupValue, $temp)) {

            $temp[$groupValue] = array();

        }



        if(!$preserveSubArrays){

            $data = count($arr[$key]) == 1? array_pop($arr[$key]) : $arr[$key];

        } else {

            $data = $arr[$key];

        }

        $temp[$groupValue][] = $data;

    }

    return $temp;

}



function load_user_language() {

    $CI =& get_instance();

    if($CI->session->userdata("language") == 2) 

        $CI->lang->load('web_lang','arabic');

    else

        $CI->lang->load('web_lang','english');

}





function get_firebase_refrence($return_database_ref = true) {



    require_once(APPPATH."third_party/firebase_4_18/vendor/autoload.php");



    $serviceAccount     = Kreait\Firebase\ServiceAccount::fromJsonFile(VIEWPATH.'/google-services.json');

    $firebase           = (new Kreait\Firebase\Factory)

                                ->withServiceAccount($serviceAccount)

                                ->withDatabaseUri('https://teyaar-project.firebaseio.com/')

                                ->create();



    if($return_database_ref)

        return $firebase->getDatabase();

    else

        return $firebase;

}
function getDomPdfReference()
{
    require_once(APPPATH."third_party/dompdf/vendor/autoload.php");
   
}
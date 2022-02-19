<?php
function load_user_language() {
    $CI =& get_instance();
    if($CI->session->userdata("language") == 2) 
        $CI->lang->load('web_lang','arabic');
    else
        $CI->lang->load('web_lang','english');
}


function get_firebase_refrence($return_database_ref = true) {

    require_once(APPPATH."third_party/firebase_4_18/vendor/autoload.php");

    $serviceAccount     = Kreait\Firebase\ServiceAccount::fromJsonFile(VIEWPATH.'/vhelp-eb526-firebase-adminsdk-bwqkn-a9d84cea5f.json');
    $firebase           = (new Kreait\Firebase\Factory)
                                ->withServiceAccount($serviceAccount)
                                ->withDatabaseUri('https://vhelp-eb526-default-rtdb.firebaseio.com/')
                                ->create();

    if($return_database_ref)
        return $firebase->getDatabase();
    else
        return $firebase;
}
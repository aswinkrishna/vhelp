<?php 

function get_date_in_timezone($timezone, $date, $format = "d-m-Y H:i:s", $server_time_zone = "Etc/GMT") {

    try {
        $timezone_server    = new DateTimeZone($server_time_zone);
        $timezone_user      = new DateTimeZone($timezone);
    }
    catch (Exception $e) { 
        $timezone_server    = new DateTimeZone($server_time_zone);
        $timezone_user      = new DateTimeZone($server_time_zone);
    }
    // echo $date ."<br>";
    // print_r($timezone_server);exit;
    $dt = new DateTime($date,  $timezone_server);

    $dt->setTimezone($timezone_user);

    //var_dump($dt);exit;
    return $dt->format($format);

}


function convertTimeZone( $fromTime )
    {
        $la_time = new DateTimeZone('Asia/Dubai');
        $datetime   = new DateTime($fromTime);                        
        $datetime->setTimezone($la_time);
        return $datetime->format('d, F Y h:i a');
    }
    
function multipleFileUpload($basicImageArray,$file_location){
    
    $ci =& get_instance();  
    $ci->load->library('upload');
    $imageData = [];
    if (!empty($basicImageArray)){

            $config['upload_path']      = $ci->config->item('upload_path') .$file_location.'/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            // $config['max_size']         = 1024;
            // $config['max_width']        = 1024;
            // $config['max_height']       = 573;
            //$config['encrypt_name']     = TRUE;             

            $filesCount = count($basicImageArray['name']);

            for ($i = 0; $i < $filesCount; $i++) 
            {
                $imageData[$i] = "";

                $_FILES['file']['name']     = $basicImageArray['name'][$i];
                $_FILES['file']['type']     = $basicImageArray['type'][$i];
                $_FILES['file']['tmp_name'] = $basicImageArray['tmp_name'][$i];
                $_FILES['file']['error']    = $basicImageArray['error'][$i];
                $_FILES['file']['size']     = $basicImageArray['size'][$i];

                $digits = 10;
                $randomNo = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                $filename2 = $basicImageArray['name'][$i];
                $file_ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
                $config['file_name'] = $randomNo . "." . $file_ext2;

                $ci->upload->initialize($config);  
                // Upload file to server
                if ($ci->upload->do_upload('file')) 
                {
                    // Uploaded file data
                    $fileData = $ci->upload->data();
                    $imageData[$i] = $fileData['file_name'];
                    // print_r($fileData);
                }
                else
                {
                    $status     =  "0";
                    $errors     = [
                        'image' => $ci->upload->display_errors(),
                    ];
                    // print_r($errors);
                }
            }   

        }
    return $imageData;
}
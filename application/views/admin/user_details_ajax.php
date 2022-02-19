<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
    <?php
    
    $profileImage    =   $result->user_image!=""?base_url()."uploads/user/".$result->user_image:base_url()."images/placeholder.jpg";   
   // $con3['provider_id']          =       $result->user_id;  
    //$con3['service_type_language_code']          =      1;  
   
   if (strpos($result->user_dial_code, '+') === false)
    $result->user_dial_code = "+".$result->user_dial_code;
   
    
    ?>
<tr><td style="width: 253px;">Name</td><td><?php echo $result->user_first_name?> <?php echo $result->user_last_name?></td><td rowspan="2"><img src="<?php echo $profileImage;?>" class="profileIcon" style="width:100px !important;height:100px !important" width="100px" height="100px"></td></tr>
<?php /* <tr><td>Company</td><td><?php echo $result->user_company_name!=""?$result->user_company_name:$result->company_name?> <?php echo $result->user_last_name?></td></tr> */ ?>
<?php if($result->user_type==2): ?> <tr><td>Company</td><td colspan="2"><?php echo $result->company_name?> </td></tr><?php endif; ?>
<tr><td>Email</td><td><?php echo $result->user_email?></td></tr>
<tr><td>Mobile</td><td colspan="2"><?php echo $result->user_dial_code?> <?php echo $result->user_phone?></td></tr>
<tr><td>Country</td><td colspan="2"><?php echo $result->country_name?> </td></tr>
<?php if($result->user_type==2): ?> <tr><td>City</td><td colspan="2"><?php echo $result->city_name?> </td></tr><?php endif; ?>
<?php if($result->user_type==2)
{ 
     $pro_services                 =      $this->M_admin->getProviderServiceType($result->user_id); 
    $ser =array();
    foreach($pro_services as $sr)
     {
         $ser[]   = $sr->service_type_name;
     }
       $services =  implode(", ",$ser);
       //$services =  strlen($services)>120?substr($services,0, 120)."...":$services;
?>


<tr><td>Area</td><td colspan="2"> <?php echo implode(',', $areaList); ?></td></tr>
<?php /*
<tr><td>Type</td><td colspan="2"><?php echo $result->company_type==1?"Company":"Freelance"?></td></tr>
<tr><td>Location</td><td colspan="2"> <?php echo $result->location ?></td></tr>
<tr><td>Profile</td><td colspan="2"><a href="<?php echo base_url().'uploads/user/'.$result->profile_document ;?>" target="_blank"><?php if($result->profile_document!="") { ?>View Document <?php } ?></a></td></tr>
<tr><td><a href="">Website</a></td><td colspan="2"><a href="<?php echo $result->website_url ?>" target="_blank"><?php echo $result->website_url ?></a></td></tr> 
*/ ?>
<tr><td>Trade license</td><td colspan="2"><a href="<?php echo base_url().'uploads/user/'.$result->document_name ;?>" target="_blank"><?php if($result->document_name!="") { ?>View Document <?php } ?></a></td></tr>

<tr><td>Services</td><td colspan="2" style="word-wrap: break-word"><?php echo $services; ?></td></tr> 
<?php
}

?>

<table>
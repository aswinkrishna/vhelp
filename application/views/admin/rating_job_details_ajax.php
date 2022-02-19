<style type="text/css">
    .user_images{
        height: 100px;
    }
</style>
<span class="details-heading">Job Details </span>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
    <tr>
        <td style="width:30%" colspan="2">
            <?php
                $service_image    = base_url().'uploads/service_type/'.$job_details->service_type_banner_image;   
            ?>
            <img src="<?=$service_image?>" class="user_images">
        </td>
        <td>
            <table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                <tr>
                    <td> Job ID </td>
                    <td> <?=$job_details->job_request_display_id?> </td>
                </tr>
                <tr>
                    <td>Service</td>
                    <td><?=$job_details->service_type_name?></td>
                </tr>
                <tr>
                    <td>Service Date</td>
                    <td><?=date('d M Y',strtotime($job_details->job_time))?> <?=date('h:i A',strtotime($job_details->job_time))?></td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td>
                       <?=$CURRENCY_CODE?> <?=$job_details->grand_total?>
                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>


<span class="details-heading">User Details</span>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">

    <tr>
        <td>
            <table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                <tr>
                    <td>Name</td>
                    <td><?php echo $user_details->user_first_name?> <?php echo $user_details->user_last_name?></td>
                </tr>
                <tr>
                    <td>Email</td><td><?php echo $user_details->user_email?></td>
                </tr>
                <tr>
                    <td>Mobile</td><td ><?php echo $user_details->user_dial_code?> <?php echo $user_details->user_phone?></td>
                </tr>
                <tr>
                    <td>Country</td><td><?php echo $user_details->country_name?> </td>
                </tr>
            </table>
        </td>
        <td style="width:30%" colspan="2">
            <?php
                $profileImage   = "uploads/user/".$user_details->user_image;
                if(file_exists($profileImage) && is_file($profileImage))
                    $profileImage    = base_url().$profileImage;
                else
                    $profileImage    = base_url()."images/placeholder.jpg";   
            ?>
            <img src="<?=$profileImage?>" class="user_images">
        </td>
    </tr>
</table>

<span class="details-heading">Vendor Details</span>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">

    <tr>
        <td style="width:30%" colspan="2">
            <?php
                $profileImage   = "uploads/user/".$provider_details->user_image;
                if(file_exists($profileImage) && is_file($profileImage))
                    $profileImage    = base_url().$profileImage;
                else
                    $profileImage    = base_url()."images/placeholder.jpg";   
            ?>
            <img src="<?=$profileImage?>" class="user_images">
        </td>
        <td>
            <table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                <tr>
                    <td>Name</td>
                    <td><?php echo $provider_details->company_name?> </td>
                </tr>
                <tr>
                    <td>Email</td><td><?php echo $provider_details->user_email?></td>
                </tr>
                <tr>
                    <td>Mobile</td><td ><?php echo $provider_details->user_dial_code?> <?php echo $user_details->user_phone?></td>
                </tr>
                <tr>
                    <td>Country</td><td><?php echo $provider_details->country_name?> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<span class="details-heading">Staff Details</span>
<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">

    <tr>
        <td>
            <table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-striped table-bordered table-hover">
                <tr>
                    <td>Name</td>
                    <td><?php echo $staff_details->company_name?> </td>
                </tr>
                <tr>
                    <td>Email</td><td><?php echo $staff_details->user_email?></td>
                </tr>
                <tr>
                    <td>Mobile</td><td ><?php echo $staff_details->user_dial_code?> <?php echo $user_details->user_phone?></td>
                </tr>
                <tr>
                    <td>Country</td><td><?php echo $staff_details->country_name?> </td>
                </tr>
            </table>
        </td>
        <td style="width:30%" colspan="2">
            <?php
                $profileImage   = "uploads/user/".$staff_details->user_image;
                if(file_exists($profileImage) && is_file($profileImage))
                    $profileImage    = base_url().$profileImage;
                else
                    $profileImage    = base_url()."images/placeholder.jpg";   
            ?>
            <img src="<?=$profileImage?>" class="user_images">
        </td>
    </tr>
</table>
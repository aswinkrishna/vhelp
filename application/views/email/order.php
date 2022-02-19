    <body style="margin: 0;">
        
    <div marginwidth="0" marginheight="0">
    <div marginwidth="0" marginheight="0" id="" dir="ltr" style="background-color:#0e688d;margin:0;padding:20px 0 20px 0;width:100%; margin: 0;">

    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tbody>
            <tr>
                <td align="center" valign="top" style="">
                    <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff;border:1px solid #dadada;border-radius:3px!important">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="padding: 15px 20px; background:#e2e2e2; padding-bottom: 15px;">
                                        <table style="background:#e2e2e2; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo base_url(); ?>template/images/header-logo.png" alt="" style="max-width: 220px; margin-bottom: 0px; ">
                                                        <h1 style="color: #0e688d; font-size: 30px;line-height: 100%;"><?=$subject?></h1>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <img src="<?php echo base_url(); ?>front_asset/images/email/delived-vector.png" alt="" style="max-width: 300px;margin-bottom: -4px;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="600">
                                    <tbody>
                                    <tr>
                                        <td valign="top" style="background-color:#ffffff; padding:px px 0;">
                                            <table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 0px;">

                                                        <div  style="color:#636363;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;margin-top: 30px">
                                                            <!--<h4 style="font-weight: 600; font-size: 18px;">Hi <?php echo $address->cutomer_name ?>,</h4>-->
                                                            <p style="margin:0 0 16px; font-size: 14px; line-height: 26px; color: #000000; text-align: left;">
                                                                <?=$message?>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table style="width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style=" width: 20%;"><div style="height: 10px;background: #c9ab81; border-radius: 3px;"></div></td>
                                                                    <td style=" width: 20%;"><div style="height: 10px;background: #c9ab81; border-radius: 3px;"></div></td>
                                                                    <td style=" width: 20%;"><div style="height: 10px;background: #c9ab81; border-radius: 3px;"></div></td>
                                                                    <td style=" width: 20%;"><div style="height: 10px;background: #c9ab81; border-radius: 3px;"></div></td>
                                                                    <td style=" width: 20%;"><div style="height: 10px;background: #c9ab81; border-radius: 3px;"></div></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p style="font-weight: 600;color: #c9ab81; font-size: 18px;">Received!</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <table>
                                                        <tr >
                                                    <td style=" width:100%; background:#f6f9ff; padding:15px 10px; font-size: 14px">
                                                                        <h4>ORDER SUMMARY</h4>
                                                                        <table style="font-size: 14px; width: 100%;">
                                                                            <table style="font-size: 14px; width: 100%;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <!--<?=print_r($order_details)?>-->
                                                                                    <td style="padding: 5px;">Order No:</td>
                                                                                    <td style="padding: 5px;"><?php echo $order_details['job_request_display_id']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Service Type:</td>
                                                                                    <td style="padding: 5px;"><?php echo $order_details['service_type_name']; ?></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Service Date:</td>
                                                                                    <td style="padding: 5px;"><?php echo $order_details['job_validity_date']; ?> <?php echo $order_details['job_validity_time']; ?></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Sub Total:</td>
                                                                                    <td style="padding: 5px;"><?php echo CURRENCY_CODE; ?> <?php echo number_format($order_details['job_total_price'], 2, ".", ""); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Vat Percentage:</td>
                                                                                    <td style="padding: 5px;"><?php echo $order_details['vat_percentage']; ?> %</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">VAT Amount:</td>
                                                                                    <?php
                                                                                        $total_price = $order_details['job_total_price'] - $order_details['discount'];
                                                                                        $vat_amount  = ($total_price *  $order_details['vat_percentage'] )/ 100 ;
                                                                                    ?>
                                                                                    <td style="padding: 5px;"><?php echo CURRENCY_CODE; ?> <?php echo number_format($vat_amount, 2, ".", ""); ?></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Grand Total:</td>
                                                                                    <td style="padding: 5px;"> <?php echo CURRENCY_CODE; ?> <?php echo $order_details['grand_total']; ?></td>
                                                                                </tr>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    
                                                           </tr>         
                                                    </table>                
                                                </tr>
                                                <tr>
                                                    <table>
                                                        <tr>
                                                    <td style=" width:100%; background:#f6f9ff; padding:15px 10px; font-size: 14px">
                                                                        <h4>SERVICES ADDRESS</h4>
                                                                        <table style="font-size: 14px; width: 100%;">
                                                                            <table style="font-size: 14px; width: 100%;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Building:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['building_name']; ?></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Street Name:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['street_name']; ?></td>
                                                                                </tr>  
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Location:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['user_adresses_location']; ?></td>
                                                                                </tr>   
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Country:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['country_name']; ?></td>
                                                                                </tr> 
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">City:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['city_name']; ?></td>
                                                                                </tr> 
                                                                                
                                                                                <tr>
                                                                                    <td style="padding: 5px;">Contact Number:</td>
                                                                                    <td style="padding: 5px;"><?php echo $address['dial_code'].' '.$address['user_phone']; ?></td>
                                                                                </tr> 
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                        </tr>
                                                    </table>
                                                </tr>
                                                
                                                <!-- <tr>
                                                    <td>
                                                        <p style="float: left; margin: 0; line-height: 45px;">Sold by SAPU</p>
                                                        <a href="#" style="float: right; height: 45px; background: #c9ab81; color: #ffffff; display: block; border-radius: 5px; font-size: 14px; font-weight: 600; text-decoration: none; line-height: 45px; text-transform: uppercase;padding: 0px 20px;">REVIEW THIS PURCHASE</a>
                                                    </td>
                                                </tr> -->
                                            
                                                <tr>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 style="color: #000000; font-size: 14px; margin: 0px 0px 8px; text-align: left; font-weight: 700;">Much love,</h4>
                                                        <p style="color: #000000; font-size: 16px; margin: 0px 0px 10px; text-align: left; font-weight: 700;">The <?=SITE_NAME?> team</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                                        <td>
                                            <div style="padding: 20px; background:#e2e2e2;">
                                                <table style="background:#e2e2e2; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:14px;width: 100%;">
                                                    <tbody>
                                                    	<tr>
                                                            <td style="text-align: center;">
                                                                <p style="color: #000000; padding-top: 20px; font-style: 14px; margin-top: 0px;">
                                                    © <?=date("Y")?> VEE HELP TECHNOLOGIES PVT LTD. INDIA All rights reserved.</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</div>
</div>

</body>
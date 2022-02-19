<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EQ</title>
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #eaeaea;
            font-family: 'Maven Pro', sans-serif !important;
            margin-top: 100px;
        }

        table {
            max-width: 600px;
            width: 600px;
            margin-top: 100px;
            margin: auto;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="width: 10%">
                <img src="<?php echo base_url();?>frontend_assets/email_template/logo-email.png" alt="">
                <a href="" style="float: right;margin:20px 0 0 5px"><img src="<?php echo base_url();?>frontend_assets/email_template/app-apple.png" alt=""></a>
                <a href="" style="float: right;margin:20px 0 0 5px"><img src="<?php echo base_url();?>frontend_assets/email_template/app-apple.png" alt=""></a>
            </td>

        </tr>

        <tr>
            <td
                style=" height: 167px;width: 600px;min-width: 600px;position: relative; overflow: hidden;vertical-align: middle; text-align: center;">
                <img src="<?php echo base_url();?>frontend_assets/email_template/banner-3.jpg" style="height: auto;
                width: 100%;
              position: absolute;
              top: 0;
              left: 0;" />
                <table style="text-align: left">
                    <tr>
                        <td colspan="2" style="width: 35%"></td>
                        <td>
                            <span style="position: relative;z-index: 9;font-weight: bold;font-size: 35px;color: #000">
                               {subject}
                            </span><br>
                        </td>
                    </tr>
                </table>


            </td>
        </tr>




        <table style="margin: 0px auto;background: #fff">
            <tr>

                <td colspan="2">
                    <p style="padding: 15px;font-weight: 500;margin: 0">
                        Dear {name},
                    </p>

                </td>
            </tr>

        </table>
        <table style="margin: 0px auto;background: #fff">

            <tr>

                <td colspan="2">
                    <p style="padding: 15px;line-height: 1.5em;font-weight: 500;margin: 0">

                        {message}
                        <img src="<?php echo base_url();?>frontend_assets/email_template/timw-limit.png" alt="">
                    </p>

                </td>
            </tr>

        </table>
        <table style="margin: 0px auto;background: #fff">

            <tr>

                <td colspan="2">
                    <p style="padding: 15px;line-height: 1.5em;font-weight: 500;margin: 0;color: #d72d30">
                        Vhelp
                    </p>

                </td>
            </tr>

        </table>
    </table>
    <table style="margin: 15px auto;padding:10px 0;text-align: center">
        <tr>

            <td style="color: #000;font-size: 15px;font-weight: 500">
                If you need help, write to us at <a href="#" style="text-decoration: none"><span
                        style="color: #d72d30">vhelpuae2021@gmail.com</span></a>

            </td>
        </tr>
        <tr>

            <td style="color: #000;font-size: 15px;font-weight: 500">
                Stay in Touch

            </td>
        </tr>

        <tr>

            <td style="padding: 10px;color: #000;font-size: 18px;font-weight: 500">
                <ul style="list-style: none;padding: 0;margin: 0">
                    <li style="display: inline"><a href="#"><img src="<?php echo base_url();?>frontend_assets/email_template/twitter-logo-button.png" alt=""></a></li>
                    <li style="display: inline"><a href="#"><img src="<?php echo base_url();?>frontend_assets/email_template/facebook-logo-button.png" alt=""></a></li>
                    <li style="display: inline"><a href="#"><img src="<?php echo base_url();?>frontend_assets/email_template/instagram.png" alt=""></a></li>
                </ul>

            </td>
        </tr>
        <tr>

            <td style="color: #4b4b4b;font-size: 12px;font-weight: 500">
                Email sent by Vhelp
            </td>

        </tr>
        <tr>
            <td style="color: #4b4b4b;font-size: 12px;font-weight: 500">
                Copyright © <?=date('Y')?> VEE HELP TECHNOLOGIES PVT LTD. INDIA All right reserved
            </td>
        </tr>
    </table>



</body>

</html>
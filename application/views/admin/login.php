<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/favicon.ico"/>

    <!-- Main CSS-->

    <link rel="stylesheet" type="text/css" href="<?php  echo base_url();?>admin_assets/css/main.css">

    <!-- Font-icon css-->

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

     <link rel="stylesheet" href="<?php echo base_url();?>admin_assets/swal/sweetalert.css"> 

    <title>Admin - Vhelp</title>

  </head>

  <body>

    <section class="material-half-bg">

     <!-- <div class="cover"></div> -->

    </section>

    <section class="login-content">

      <div class="logo text-center">

          <img src="<?php echo base_url();?>images/admin_logo.png">

        <!--<h1>Emirates Quotation</h1> -->

      </div>

      <div class="login-box">

          <form class="login-form" action="" id="login-form" autocomplete="off">

          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>

          <div class="form-group">

            <label class="control-label">USERNAME</label>

            <input class="form-control"  name="username" id="username" placeholder="Your email address" type="text" placeholder="Email" autofocus maxlength="100" value="admin@admin.com">

          </div>

          <div class="form-group">

            <label class="control-label">PASSWORD</label>

            <input class="form-control" type="password"  maxlength="20"  name="password" id="password" placeholder="Your password"  value="admin1234">

          </div>

          <div class="form-group">

            <div class="utility">

<!--              <div class="animated-checkbox">

                <label>

                  <input type="checkbox"><span class="label-text">Stay Signed in</span>

                </label>

              </div>-->

<!--              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>-->

            </div>

          </div>

          <div class="form-group btn-container">

            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>

          </div>

        </form>

       

      </div>

    </section>

     <script src="<?php echo base_url();?>admin_assets/js/jquery-3.2.1.min.js"></script>

      <script src="<?php echo base_url();?>admin_assets/js/jquery.validate.min.js"></script>

      <script src="<?php echo base_url();?>admin_assets/swal/sweetalert.js"></script>

      <script>

          

    function getCookie(name) {

    var cookieValue = null;

    if (document.cookie && document.cookie != '') {

        var cookies = document.cookie.split(';');

        for (var i = 0; i < cookies.length; i++) {

            var cookie = jQuery.trim(cookies[i]);

            // Does this cookie string begin with the name we want?

            if (cookie.substring(0, name.length + 1) == (name + '=')) {

                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));

                break;

            }

        }

    }

    return cookieValue;

}









       var validator=$("#login-form").validate(

            //alert();

        {

             ignore: [],

        rules: 

        {

          username: 

          {

            required: true,

              email:true

            

          },



          password: 

          {

            required: true

          },

          

        },

        messages: {

        username:{required: "User name field is required"},

        password:{required: "Password field is required"}

    },

     submitHandler: function ()

        {

                 csrf_value  =   getCookie('csrf_cookie_name');                

                dataString = $('#login-form').serialize();

                var formData = new FormData($("#login-form")[0]);           

                formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);

                

                     $.ajax({

             url: '<?php echo base_url();?>admin/C_admin/login',

             type: 'POST',

             data: formData,

             async: false,

             success: function (data) 

                {

                    

                    if(data==1)

                    {

                       

                       window.location= "<?php echo base_url();?>admin/dashboard";

                              

                    }

                    else

                    {

                              

                          swal("Sorry!", "Invalid Credentials!", "error");





                    }



                  

                   

             },

             cache: false,

             contentType: false,

             processData: false

         });



                     return false;

      

        

                }

       

 });  

      </script>

    

  </body>

</html>
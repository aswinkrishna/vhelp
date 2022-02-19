</body>
</html>
<!-- Essential javascripts for application to work-->
   
    <script src="<?php  echo base_url();?>admin_assets/js/popper.min.js"></script>
    <script src="<?php  echo base_url();?>admin_assets/js/bootstrap.min.js"></script>
    <script src="<?php  echo base_url();?>admin_assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php  echo base_url();?>admin_assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
  
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
      $(document).ready(function() 
          {
           
            //addmethod //addmethod //addmethod //addmethod //addmethod
    
jQuery.validator.addMethod("lettersonly", function(value, element) {  
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("letters_only"):"Only letters allowed")?>'); 


jQuery.validator.addMethod("alphnumeric", function(value, element) {  
  return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("letters_numbers_only"):"Only allows letters and numbers")?>'); 

jQuery.validator.addMethod("passwordCheck",
        function(value, element, param) {
            if (this.optional(element)) 
            {
                return true;
                
            } else if (!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i.test(value)) 
            {
                return false;
                
            }

            return true;
        },
        '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("strict_password"):"Password field must contain atleast one letter , number and special charcter")?>');
jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z0-9 \b/\/s_,-]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    },  '<?php echo ($this->session->userdata("langauge")==2?$this->lang->line("no_special_char"):"Special characters not allowed")?>');

jQuery.validator.addMethod("greaterThan", 
function(value, element, params) {

    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');

 //addmethod //addmethod //addmethod //addmethod
         } );
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
            function readURL(input,previewControl) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) 
    {
      $('#'+previewControl).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
 function toggleLanguage(value)
        {
            csrf_value  =   getCookie('csrf_cookie_name');
          
                   $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/toggleLanguage',
             type: 'POST',
             data: {value:value,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
             async: false,
             success: function (data) 
                {
                   

                     // alert(data);
                 // console.log(data); 
                  location.reload();

               },
             cache: false
         });

        }
        $(document).delegate(".number","keypress",function(evt)
    {
	var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
			{
			$(this).attr("placeholder","Enter numbers");
             return false;
			}else{

                return true;
			}
	});	

	 $(document).delegate(".number","keyup",function(evt)
    {
       // alert($(this).val());
     /*   
        str = $(this).val();
        
        
        occuranceOfDot = str.replace(/[^.]/g, "").length;
        
        if(occuranceOfDot>1)
        {
             $(this).val("");
             return false;
        }
        
           if (str.indexOf(".") > 0) {
                    var txtlen = str.length;
                    var dotpos = str.indexOf(".");
                    if ((txtlen - dotpos) > 3)
                    {
                       // alert(1);
                        str = str.substring(0, str.length - 1);
                        $(this).val(str);
                    }
                    else
                    {
                       // alert(2);
                    }
                        
                             }*/
        
    });
    </script>
  </body>
</html>
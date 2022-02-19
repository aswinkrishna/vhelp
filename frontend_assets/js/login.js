      $(document).ready(function(){

            $('.login_page').hide();
            $('.sign_up_page').hide();
            $('.forgot_pass_page').hide();

            $('.login').click(function(){
                $('.forgot_pass_page').hide();
                $('.form1').hide();
                $('.sign_up_page').hide();
                $('.login_page').show();
            });
            
            $('.sign button').click(function(){
                $('.forgot_pass_page').hide();
                $('.form1').hide();
                $('.login_page').hide();
                $('.sign_up_page').show();
            });
            
            $('#forgot_password').click(function(){
                $('.sign_up_page').hide();
                $('.form1').hide();
                $('.login_page').hide();
                $('.forgot_pass_page').show();
            });
            
            
            
            
             $('.search button').click(function(){
              $('.search-box').addClass('search-box-add');
          });
          $('.close_button').click(function(){
              $('.search-box').removeClass('search-box-add');
          });
          
          
          $('.min-search button').click(function(){
              $('.search-box').addClass('search-box-add');
          });
            
        $('#exampleModal').on('hidden.bs.modal', function (e) {
//            console.log('Hello World');
            $('.form1').show();
            $('.login_page').hide();
            $('.sign_up_page').hide();
            $('.forgot_pass_page').hide();
        })
          
    });















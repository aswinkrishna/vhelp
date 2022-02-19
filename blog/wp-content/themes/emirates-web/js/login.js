        $(document).ready(function(){
            $('.login_page').hide();
            $('.sign_up_page').hide();
            $('.login').click(function(){
                $('.form1').hide();
                $('.login_page').show();
                $('.sign_up_page').hide();
            });
            
            $('.sign button').click(function(){
                $('.sign_up_page').show();
                $('.form1').hide();
                $('.login_page').hide();
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
            
            
          
        });
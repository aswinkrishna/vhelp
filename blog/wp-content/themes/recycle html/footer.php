  <!--start  footer-->
  <footer>
    <!--start container fluid-->
    <div class="container-fluid">
      <!--start row-->
      <div class="row">
        <!--start container-->
        <div class="container">
          <!--start row-->
          <div class="row">
            <!--start col md 3-->
            <div class="col-md-3 col-sm-3 col-12 footer-colm">
              <img src="<?php echo get_template_directory_uri(); ?>/images/logo/footer-logo.png" />
            </div>
            <!--end col md 3-->


            <!--start col md 3-->
           <div class="col-md-3 col-sm-3 col-12 footer-colm">
              <ul>
                <li><span><img src="https://recycleassociation.com/front_template/images/icons/footer-icons/1.png"></span><a href="tel:+97156565656">+97156565656</a></li>
                <li><span><img src="https://recycleassociation.com/front_template/images/icons/footer-icons/2.png"></span><a href="mailto:recycleassociation@gmail.com">recycleassociation@gmail.com</a></li>
                <li><span><img src="https://recycleassociation.com/front_template/images/icons/footer-icons/3.png"></span><a target="_blank" href="https://www.google.com/maps/place/recycleassociation, 
Sheikh Zayed Road Dubai,UAE">
Sheikh Zayed Road Dubai,UAE</a></li>
              </ul>
            </div>
            <!--end col md 3-->



            <!--start col md 3-->
            <div class="col-md-3 col-sm-3 col-12 ">

              <div class="social-link">
                <ul>
                  <li><a target="_blank" href="https://www.facebook.com/recycleassociation/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  <li><a target="_blank" href="https://twitter.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                  <li><a target="_blank" href="https://googleplus.com"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                  <li><a target="_blank" href="https://www.linkedin.com/company/recycle-association/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                </ul>
                <p>Download the Mobile Applications</p>
              </div>

              <div class="app-stor app-padd">
                <ul>
                  <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.a2.recyclerassociation&amp;hl=en"><img src="https://recycleassociation.com/front_template/images/icons/for-android.png"></a></li>
                  <li><a target="_blank" href="https://itunes.apple.com/us/app/recycle-association/id1454212287?mt=8"><img src="https://recycleassociation.com/front_template/images/icons/for-ios.png"></a></li>
                </ul>
              </div>
            </div>
            <!--end col md 3-->

            <!--start col md 3-->
            <div class="col-md-3 col-sm-3 col-12 footer-colm left-padd">
              <ul>
                <li><a href="https://recycleassociation.com/terms_condition">Terms & Conditions</a></li>
                <li><a href="https://recycleassociation.com/Privacy_policy">Privacy Policy </a></li>
                <li><a href="https://recycleassociation.com/faq">FAQ</a></li>
                <li><a href="https://recycleassociation.com/help">Help</a></li>
              </ul>
            </div>
            <!--end col md 3-->

          </div>
          <!--end row-->
        </div>
        <!--end container-->
      </div>
      <!--end row-->

      <!--start row-->
      <div class="row footer-btm">
        <p>Copyright © 2019 Recycle Association. All Rights Reserved.</p>

      </div>
      <!--end row-->
    </div>
    <!--end container fluid-->
  </footer>
  <!--end footer-->







  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/carosel.js"></script>
  <!--start nav script-->
  <script type="text/javascript">
    $(window).scroll(function () {
      var windscroll = $(window).scrollTop();
      if (windscroll >= 100) {
        $('nav').addClass('fixed');
        $('.menu-link').addClass('fff-icon');
        $('.wrapper section').each(function (i) {

        });

      } else {

        $('nav').removeClass('fixed');
        $('.menu-link').removeClass('fff-icon');

      }

    }).scroll();




    /*
    		Smooth scroll functionality for anchor links (animates the scroll
    		rather than a sudden jump in the page)
    	*/
    $('.js-anchor-link').click(function (e) {
      e.preventDefault();
      var target = $($(this).attr('href'));
      if (target.length) {
        var scrollTo = target.offset().top;
        $('body, html').animate({
          scrollTop: scrollTo + 'px'
        }, 800);
      }
    });
    
    
    

  </script>
<script>
$(document).ready(function(){
    $("#video1")[0].src += symbol + "autoplay=1";
});
  

</script>

<?php wp_footer(); ?>  
</body></html>
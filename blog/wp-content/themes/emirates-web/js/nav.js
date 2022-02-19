      $(window).scroll(function(){
    if ($(window).scrollTop() >= 100) {
        $('.navbar-expand-lg').addClass('fixed');
    }
    else {
        $('.navbar-expand-lg').removeClass('fixed');
    }
});
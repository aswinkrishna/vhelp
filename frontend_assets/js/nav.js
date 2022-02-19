 $(window).scroll(function(){
    if ($(window).scrollTop() >= 100) {
        $('.navbar-expand-lg').addClass('fixed');
    }
    else {
        $('.navbar-expand-lg').removeClass('fixed');
    }
});

 $(document).ready(function(){
 	$('.drop_list').click(function(){
 		if ($('.drop_list_pannel').hasClass('show_nav')) {
 			$('.drop_list_pannel').removeClass('show_nav');
 			// console.log('0')
 		}else{
 			$('.drop_list_pannel').addClass('show_nav');
 			// console.log('1')
 		}

 	});

$('.side_bar_inner ul li.sub_nav').click(function(){
	    // alert(1);
	    // $('.side_bar_inner ul.submenu').addClass('active');
	    if ($(this).hasClass('active')) {
	    	// alert(0)
	    	$(this).removeClass('active');
	    	$(this).addClass('active');

	    }else{

	    	$(this).addClass('active');
	    	// alert(1)

	    }
	    // if (true) {}
	});
	$('.side_bar_inner ul li').click(function(){
	    	$('.side_bar_inner ul.submenu .nav-link').removeClass('active');
	    	$(this).not('.sub_nav').removeClass('active');
	});



	 $('#choose_lang').click(function(){
	 	$('.list_lang').show();
	 	// alert(1)
	 });
	 $('body').click(function(e) {
	    var target = $(e.target);
	    if(!target.is('#choose_lang')) {
	 		$('.list_lang').hide();
	    }
	    if(!target.is('.drop_list')) {
 			$('.drop_list_pannel').removeClass('show_nav');
	    }
	});

 });


 // $('#choose_lang').click(function(){
 // 	// $('.list_lang').show();
 // 	alert(1)
 // });
 // $('body').not('#choose_lang').click(function(){
 // 	$('.list_lang').hide();
 // });
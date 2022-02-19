function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
    
    

    
    $("input[name='option']").change(function(){
        $(this).attr("checked", true);
        var RadVAl = $(this).val();
//        if(v = d){};
        $('.choose_options > div').not('.row').hide();
        if($(this).attr('id') == 'Remodel' ){
               $('.choose_options #remodeling').show();
               console.log(2)
            
           }else if($(this).attr('id') == 'building' ){
               $('.choose_options #Rebuilding').show();
               console.log(3)
                    
            }else if($(this).attr('id') == 'Inspections' ){
               $('.choose_options #InspectAll').show();
               console.log(4)
                    
            }else{
               $('.choose_options #newconstruction').show();
               console.log(1)
           }
           if ( $('.summery_row ul').children().length > 0 ) {
//                console.log(1)
                $('.summery_row ul li').remove();
//                $('.summery_row ul li:nth-child(1)').text(RadVAl);
                $('.summery_row ul').html('<li>'+RadVAl+'</li>');

            }else{
//                console.log(0)
                $('.summery_row p').remove();
                $('.summery_row ul li:nth-child(1)').text('');
                $('.summery_row ul').html('<li>'+RadVAl+'</li>');

            }
        console.log(RadVAl);
    });
    $(".choose_options input[name='option_1']").click(function(){
        $(this).attr("checked", true);
        $('.summery_row ul li:nth-child(3)').remove();
        var RadVAl = $(this).val();
//        $(this).parents('.choose_options').find('div').not('.row').hide();
        if($(this).parents('.choose_options').find('div:visible').attr('id') == 'remodeling' ){
//               $('.choose_options #remodeling').show();
               console.log('02545')
               $('.choose_options #remodeling_1').show();
                
           }else if($(this).parents('.choose_options').find('div:visible').attr('id') == 'Rebuilding' ){
               $('.choose_options #Rebuilding_1').show();
               console.log('3254')
                    
            }else if($(this).parents('.choose_options').find('div:visible').attr('id') == 'InspectAll' ){
               $('.choose_options #InspectAll_1').show();
               console.log('4254')
                    
            }else{
               $('.choose_options #newconstruction_1').show();
               console.log('01545')
           }
        
        $('.summery_row ul li:nth-child(2)').remove();
        $('.summery_row ul li:nth-child(1)').after('<li>'+RadVAl+'</li>');
        console.log(RadVAl);
        
    });
    $(".choose_options input[name='option_2']").click(function(){
        $(this).attr("checked", true);
        var RadVAl = $(this).val();
        $('.summery_row ul li:nth-child(3)').remove();
        $('.summery_row ul li:nth-child(2)').after('<li>'+RadVAl+'</li>');
        
        console.log(RadVAl);
    });
    $(".choose_options #next-1").click(function(){
        if ($("input[name='option']:checked").val()) {
//          alert('One of the radio buttons is checked!');
          $(this).parents('.choose_options').next().show().prev().hide();
        }
        else {
           alert('Nothing is checked!');
            
        }
    });
    $(".choose_options #back-2, .choose_options #back-3").click(function(){
        if ($("input[name='option']:checked").val()) {
//          alert('One of the radio buttons is checked!');
           console.log('checked!');
          $(this).parents('.choose_options').prev().show().next().hide();
        }
        else {
           console.log('Nothing is checked!');
        }
    });
    $(".choose_options #next-2").click(function(){
        if ($("input[name='option_1']:checked").val()) {
//          alert('One of the radio buttons is checked!');
          $(this).parents('.choose_options').next().show().prev().hide();
          $(this).parents('.choose_options').next().find('.options').show();
        }
        else {
           alert('Nothing is checked!');
        }
    });

    $(".choose_options #next-35").click(function(){
          $(this).parents('.choose_options').next().show().prev().hide();
          $(this).parents('.choose_options').next().find('.options').show();
          console.log(' You successfully entered 4 Step');
//        if ($("input[name='option_1']:checked").val()) {
////          alert('One of the radio buttons is checked!');
//          $(this).parents('.choose_options').next().show().prev().hide();
//          $(this).parents('.choose_options').next().find('.options').show();
//        }
//        else {
//           alert('Nothing is checked!');
//        }
    });


    var $currElement = $(".first-bullet");
    $currElement.css('background-color', '#d52d2f');
    $currElement.addClass('bullet_solid');

    $(".choose_options #next-3").click(function(){
        if ($("input[name='option_2']:checked").val()) {
//          alert('One of the radio buttons is checked!');
          $(this).parents('.choose_options').next().show().prev().hide();
          if ($("#homecleaning .pageWrapp:visible").next().length != 0){
            $("#homecleaning .pageWrapp:visible").next().show().prev().hide();
              
	          $currElement = $currElement.next();
              
              $(".bullet").removeClass('bullet_solid');
              $(".pan").css("background", "");
              $currElement.css('background-color', '#d52d2f');
              $currElement.addClass('bullet_solid');
              $(".first-bullet").css("background-color", "#cacaca");
              $('.summery_row ul li:nth-child(3)').after('<li> <b>Schedule</b> <span class="Adddate"></span> <span class="Addtime"></span></li>');
            }else {

                $("#homecleaning .pageWrapp:visible").hide();
                $("#homecleaning .pageWrapp:first").show();
            }
//        }else if($('.choose_options').attr('id') == 'Upload_section' ){
        }else {
           alert('Nothing is checked!');
        }
    });
    $("#next-4").click(function(){
        if ($("#homecleaning .pageWrapp:visible").next().length != 0){
            $("#homecleaning .pageWrapp:visible").next().show().prev().hide();
              
	          $currElement = $currElement.next();
              
              $(".bullet").removeClass('bullet_solid');
              $(".pan").css("background", "");
              $currElement.css('background-color', '#d52d2f');
              $currElement.addClass('bullet_solid');
              $(".first-bullet").css("background-color", "#cacaca");
              
            }else {
                $("#homecleaning .pageWrapp:visible").hide();
                $("#homecleaning .pageWrapp:first").show();
            }
    });
//$('#datetimepicker4').on('input', function() {
////   alert("Hey there :)")
//        var AllVa = $(this).find('input').text()
//        console.log(AllVa);
// });
$('#datetimepicker4').change(function () {
        var AllVa = $(this).val();
        console.log(AllVa);
    $('.summery_row .Adddate').text('')
    $('.summery_row .Adddate').append(AllVa)
})
$('#datetimepicker3').change(function () {
        var AllVa = $(this).val();
        console.log(AllVa);
    $('.summery_row .Addtime').text('')
    $('.summery_row .Addtime').append(AllVa)
//    $(".datselcted").html($(this).val());
})
// $('#datetimepicker4').on('change', function() {
//   alert("Hey there, I won't trigger :(");
// });

//    $('#datetimepicker4').click(function(){
//        var AllVa = $(this).find('input').val();
//        console.log(AllVa);
//    })
//            $('.summery_row ul li:nth-child(3)').after('<li> Schedule ''</li>');








    $('.buttonNext').click(function(){
        $("#next-4").trigger('click');
    });
    
    $(".RecommendBtn").click(function(){
        $(".Recommend").hide();
        $(".providers_wrap").show();
    });

    $('input.filestyle').click(function(){
//        $("#next-4").trigger('click');
        console.log($(this).val())
//        $('#filepath').val()
    });


    $('.input-group-text').click(function(){
        $(this).parents('.input-group').find('input').trigger('click');
    });




//-----JS for Price Range slider-----
$( function() {
    $("#slider-range").slider({
        range: true,
        min: 100,
        max: 3005,
        step: 15,
        values: [100, 3000],
        slide: function( event, ui ) {
            $( ".price_wrap" ).html( "<p class='slider-amount-1'> Min Price <span> AED " + ui.values[ 0 ] + "</span></p> <p  class='slider-amount-2' >Max Price  <span> AED " + ui.values[ 1 ] + "</span></p>");
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
          " - $" + $( "#slider-range" ).slider( "values", 1 ) );
});

$(".time_slotes").owlCarousel({
      items: 3,
      navigation : true,
      itemsDesktop : [1499,3],
      itemsDesktopSmall : [1199,3],
      itemsTablet : [899,3],
      itemsMobile : [380,2],
      navigationText : ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
  });

$('.time_slotes .badge').click(function(){
   $('.time_slotes .badge').removeClass('active'); 
   $(this).addClass('active'); 
});
$('.location_button').click(function(){
   $('.location_button').removeClass('active'); 
   $(this).addClass('active'); 
});





//    $(".choose_options input[name='option_1']").click(function(){
//        $(this).attr("checked", true);
//        var RadVAl = $(this).val();
//        $('.summery_row ul li:nth-child(2)').text('');
//        $('.summery_row ul li:nth-child(2)').append(RadVAl);
//        
//        console.log(RadVAl);
//    });
//    $(".choose_options input[name='option_2']").click(function(){
//        $(this).attr("checked", true);
//        var RadVAl = $(this).val();
//        $('.summery_row ul li:nth-child(3)').text('');
//        $('.summery_row ul li:nth-child(3)').append(RadVAl);
//        
//        console.log(RadVAl);
//    });
    
    
//    $("#homecleaning .pageWrapp").each(function(e) {
//        if (e != 0)
//            $(this).hide();
//    });
//    
//    $("#next").on('click', function(){
//    $(".choose_options #next").click(function(){
////        if ($(".choose_options input[name='option']").prop("checked") == 'checked')
//        if ($("input[name='option']").prop("checked")) { 
//            console.log(1)
//        }else{
//            console.log(0);
//        }
////        return false;
//    });

//    $("#prev").click(function(){
//        if ($("#homecleaning .pageWrapp:visible").prev().length != 0)
//            $("#homecleaning div:visible").prev().show().next().hide();
//        else {
//            $("#homecleaning .pageWrapp:visible").hide();
//            $("#homecleaning .pageWrapp:last").show();
//        }
//        return false;
//    });
//    
//    var $currElement = $(".first-bullet");
//    $currElement.css('background-color', '#d52d2f');
//    $currElement.addClass('bullet_solid');
//	
//    $("#next").click(function () {
//	  
//	  $currElement = $currElement.next();
//	  
//      $(".bullet").removeClass('bullet_solid');
//      $(".pan").css("background", "");
//      $currElement.css('background-color', '#d52d2f');
//      $currElement.addClass('bullet_solid');
//      $(".first-bullet").css("background-color", "#cacaca");
//        
//    });
	



	function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    
    
    
    
    
    
$(document).ready(function(){
    $("#homecleaning .pageWrapp").each(function(e) {
        if (e != 0)
            $(this).hide();
    });
    
    $("#next").click(function(){
        
        if ($("#homecleaning .pageWrapp:visible").next().length != 0)
            $("#homecleaning .pageWrapp:visible").next().show().prev().hide();
         
          
        
        else {
           
            $("#homecleaning .pageWrapp:visible").hide();
            $("#homecleaning .pageWrapp:first").show();
        }
        return false;
    });

    $("#prev").click(function(){
        if ($("#homecleaning .pageWrapp:visible").prev().length != 0)
            $("#homecleaning div:visible").prev().show().next().hide();
        else {
            $("#homecleaning .pageWrapp:visible").hide();
            $("#homecleaning .pageWrapp:last").show();
        }
        return false;
    });
    
    
    var $currElement = $(".first-bullet");
    $currElement.css('background-color', '#d52d2f');
    $currElement.addClass('bullet_solid');
	
    $("#next").click(function () {
		

	  
	  $currElement = $currElement.next();
	  
      $(".bullet").removeClass('bullet_solid');
      $(".pan").css("background", "");
      $currElement.css('background-color', '#d52d2f');
      $currElement.addClass('bullet_solid');
      $(".first-bullet").css("background-color", "#cacaca");
    });
	
   
    
    
    
    
});


$(document).ready(function() {
 
  $("#owl-example").owlCarousel({
      autoPlay: 3000,
      itemsDesktop : [1499,4],
      itemsDesktopSmall : [1199,3],
      itemsTablet : [899,2],
      itemsMobile : [599,1],
      navigation : true,
      navigationText : ['<span class="fa-stack"><aside class="left"></aside></span>','<span class="fa-stack"><aside class="right"></aside></span>'],
  });
  
  
  
  
  
    $("#owl-example2").owlCarousel({
      autoPlay: 3000,    
      itemsDesktop : [1499,4],
      itemsDesktopSmall : [1199,3],
      itemsTablet : [899,2],
      itemsMobile : [599,1],
      navigation : true,
      navigationText : ['<span class="fa-stack"><aside class="left"></aside></span>','<span class="fa-stack"><aside class="right"></aside></span>'],
  });
  
  
  
  
  
      $("#owl-example3").owlCarousel({
      autoPlay: 3000,      
      itemsDesktop : [1499,3],
      itemsDesktopSmall : [1199,3],
      itemsTablet : [899,2],
      itemsMobile : [599,1],
      navigation : true,
      navigationText : [''],
      autoplay:false,
      autoplayTimeout:5000,
      autoplayHoverPause:false
      
  });
  
  
  
   $("#owl-example-btm").owlCarousel({
      autoPlay: 3000,
      itemsDesktop : [1499,4],
      itemsDesktopSmall : [1199,3],
      itemsTablet : [899,2],
      itemsMobile : [599,1],
      navigation : true,
      navigationText : ['<span class="fa-stack"><aside class="left"></aside></span>','<span class="fa-stack"><aside class="right"></aside></span>'],
  });
   

 $("#owl-banner").owlCarousel({
 
      navigation : true, // Show next and prev buttons
        navigationText : ['<span class="fa-stack-banner"><aside class="left"></aside></span>','<span class="fa-stack-banner"><aside class="right"></aside></span>'],
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      autoPlay: 3000,
      pagination: false
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });

});
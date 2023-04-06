$('.hero-slider').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    autoplay:true,
autoplayTimeout:5000,
autoplayHoverPause:false,
dots:false,
center:true,
 touchDrag: true,
  mouseDrag: true,
    smartSpeed: 3000,
   animateIn: 'fadeIn', 
    responsive:{
        0:{
            items:1,
         },
        768:{
            items:1,
         },
        1000:{
            items:1
        }
    }
});

$('.prd-slider').owlCarousel({
     loop:true,
    margin:0,
    nav:true,
    autoplay:true,
autoplayTimeout:5000,
autoplayHoverPause:false,
dots:false,
center:true,
 touchDrag: true,
  mouseDrag: true,
    smartSpeed: 3000,
     responsive:{
        0:{
            items:1,
         },
        768:{
            items:1,
         },
        1000:{
            items:1
        }
    }
});

$('.testimonails-slider').owlCarousel({
    loop:true,
    margin:30,
    nav:false,
    autoplay:true,
autoplayTimeout:5000,
autoplayHoverPause:false,
dots:true,
center:false,
 touchDrag: true,
  mouseDrag: true,
    smartSpeed: 3000,
    responsive:{
        0:{
            items:1,
         },
        768:{
            items:2,
         },
        1000:{
            items:2
        }
    }
});


$(document).ready(function(){

$('.play-pause-btn').on('click',function(){
if($(this).attr('data-click') == 1) {
$(this).attr('data-click', 0)
$(this).text('')
$('#video')[0].pause();
} else {
$(this).attr('data-click', 1)
$(this).text('')
$('#video')[0].play();
}
 
});

});

 
 
$(document).ready(function() {
   var offset = 200;
    var duration = 500;
    $(window).scroll(function() {
      if ($(this).scrollTop() > offset) {
        $('.back-to-top').fadeIn(700);
      } else {
        $('.back-to-top').fadeOut(700);
      }
    });
 
    $('.back-to-top').on('click',function(event) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, 600);
     })

});
 
 
 $(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    var objectSelect = $(".header");
    var objectPosition = objectSelect.offset().top >= 20
    if (scroll > objectPosition) {
        $(".header").addClass("sticky");
    } else {
        $(".header").removeClass("sticky");
    }
});

	 $(document).ready(function () {
 	 var  mn = $(".header");
    mns = "sticky";
    hdr = $('.header').height();

$(window).ready(function() {
  if( $(this).scrollTop() > hdr ) {
    mn.addClass(mns);
  } else {
    mn.removeClass(mns);
  }
 });
		 
});


 $(document).ready(function(){
       if($('.banner').length > 0) {
         $('body').addClass('banner-here');
       }
       else {
         $('body').addClass('no-banner');
       }
});


 



// on click a href="#" id traget base

//
jQuery(function(jQuery) {
 jQuery('.scrolldown[href*="#"]').on('click', function(e){
     jQuery('html,body').animate({
       scrollTop: jQuery($(this).attr('href')).offset().top - 100
     },500);
     e.preventDefault();
   });
});
  
  
  

$(document).ready(function() {
   new WOW().init();
}); 


 
  $(document).ready(function () {
  if ((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1) {
      $('body').addClass('opera');
  } else if (navigator.userAgent.indexOf("Chrome") != -1) {
      $('body').addClass('chrome');
  } else if (navigator.userAgent.indexOf("Safari") != -1) {
      $('body').addClass('safari');
  } else if (navigator.userAgent.indexOf("Firefox") != -1) {
      $('body').addClass('firefox');
  } else if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) //IF IE > 10
  {
      $('body').addClass('IE');
  } else {
      $('body').addClass('unknown');
  }
});

  

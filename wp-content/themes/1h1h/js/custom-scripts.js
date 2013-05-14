//GLOBALS
var pageHeight; //add all the sections to get the page height
var scrollDistance = 0; // how far have they scrolled down the page?
var actualHeight = 0; // how big is a section?
var activeSection;
var scrollPadding = 0; //give a little resistance/delay when scrolling past a section


//+++++++++ Helper Functions +++++++++++

/* detect browser */

function getBrowser (){
if(jQuery.uaMatch(navigator.userAgent).browser == 'webkit'){
var userAgent = navigator.userAgent.toLowerCase();
if ( userAgent.indexOf("chrome") === -1 ) { 
return 'safari';
}
else {
return jQuery.uaMatch(navigator.userAgent).browser;
}
}
}
/* end browser test */



/* no link - void clicks */
function noLink(){
return false;
}
function navTabActivate(tab, target){ //displays the portfolio navigation tab
	jQuery(tab).click(function(e){
	jQuery(target).slideDown('slow');
	jQuery(this).slideUp('fast');
	e.preventDefault();
	});
}

function centerElement(element){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();
	var elementWidth = element.width();
	var elementHeight = element.height();
	var elementOffset = new Object();
	elementOffset.x = windowWidth/2 - elementWidth/2;
	elementOffset.y = windowHeight/6;
	element.css({
	'left' : elementOffset.x,
	'top' : elementOffset.y
	});
}
/* Accordions */
function hhAccordion(target){
	jQuery(target).slideUp('fast');
	var accordionControl = jQuery(target).attr('data-controller');
	jQuery(accordionControl).click(function(e){
		jQuery(target).toggleClass('in');
		if(!jQuery(target).hasClass('in')){
		jQuery(target).slideUp('fast');
		}
		else {
			jQuery(target).slideDown('fast');
		}
		
				e.preventDefault();
	});
	
}//End of accordions function

function falsePageHeight(){ //make the page the total height of all the sections with fixed positions
	pageHeight = 0;
	
	jQuery('.section').each(function(){
		pageHeight += jQuery(this).outerHeight();
	});
	
	jQuery('body').css('height',pageHeight);
}//end falsePageHeight

function resizeSections(){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();
	jQuery('#fixed_bg').css({'height':windowHeight});
	if(jQuery('#portfolio-wrapper').length > 0){
	jQuery('#portfolio-wrapper').css({"width": windowWidth, "height": windowHeight + 100});
	}
	jQuery('.section').css({"width": windowWidth, "min-height": windowHeight + 100});
	jQuery('.hand-navigation .hand').css({'top': windowHeight/3});
	
	jQuery('.tour-entry .post-content, .instructions-modal'  ).each(function(index){
		jQuery(this).css({'top': 100});
		centerElement(jQuery(this));
	});
	
	
		//jQuery('body').css({'height':windowHeight, 'overflow':'hidden'});
	//jQuery('.menu-main-menu-container').css({"width": windowWidth});
	var menuPos =  jQuery('#menu-global-menu').offset();
	if(jQuery('#portfolio-nav').length > 0){ 
	jQuery('#portfolio-nav').css({"paddingLeft": menuPos.left});
	}
	
	jQuery('.filter-target').isotope({
	// options... http://isotope.metafizzy.co/docs/options.html
	filter: '.artist' 
		});
	
}
//End resizeSections


function imageTexturizer(){//puts a texture over all the images

	jQuery('img:not(#portfolio img, img.no-texture)').each(function(){
		jQuery(this).wrap('<div class="image-wrapper">');
		jQuery(this).parent().css({'background-image': 'url('+templateDir + '/images/paper_bg2.png), url('+ jQuery(this).attr('src')+')', 'background-repeat': 'repeat, no-repeat', 'background-size':'1400px 752px, contain'});
		
		jQuery(this).css({'opacity':0});
		jQuery('.image-wrapper img').mouseover(function(e){
			jQuery(this).animate({'opacity':1}, {'duration':'fast', 'queue':false});
		});
		jQuery('.image-wrapper img').mouseleave(function(e){
			jQuery(this).animate({'opacity':0}, {'duration':'fast', 'queue':false});
		});
	});
	
}//end imageTexturizer


//Hide the Instructions
function hideInstructions(){
jQuery('.instructions').fadeOut(200);
//jQuery('.hand-navigation').fadeOut(200);
}//end hide instructions
//Show the Instructions
function showInstructions(){
jQuery('.instructions').fadeIn(200);
//jQuery('.hand-navigation').fadeIn(200);
}//end show instructions


//TOUCHWIPE EVENT HANDLER
function makeSwipes(targetElement){
jQuery(targetElement).touchwipe({//touch settings
     wipeLeft: function() { 
     jQuery(targetElement).cycle('next'); 
     resizeSections();
      },
     wipeRight: function() {
      jQuery(targetElement).cycle('prev'); 
      resizeSections();
       },
     min_move_x: 50,
     min_move_y: 50,
     preventDefaultEvents: false
});
}


/* Accordions */
function hhAccordion(target){
	jQuery(target).slideUp('fast');
	var accordionControl = jQuery(target).attr('data-controller');
	jQuery(accordionControl).click(function(e){
		jQuery(target).toggleClass('in');
		if(!jQuery(target).hasClass('in')){
		jQuery(target).slideUp('fast');
		}
		else {
			jQuery(target).slideDown('fast');
		}
		
				e.preventDefault();
	});
	
}//End of accordions function




//++++++++++++Add Touch Support
function gestureChange(e) {
	scrollDistance = jQuery(window).scrollTop() + e;
	activeSection = jQuery('.active');
	flipDistance = parseInt(activeSection.attr('data-offset'))-scrollDistance;
	activeSection.css({'top': flipDistance});
	setActive();
	
}

function addTouchSupport(){
document.body.addEventListener("gesturechange", gestureChange, false);

}

function makeCycles(){
		jQuery('#portfolio-wrapper').before('<ul id="portfolio-nav">').cycle({ 
		    fx:     'scrollHorz', 
		    speed:  500, 
		    timeout: 0, 
		    pager:  '#portfolio-nav', 
		    next: '.next.arrow',
		    prev: '.prev.arrow',
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
		    var bgSource = jQuery(slide).find('.portfolio_bg img').attr('src');
		        return '<li><a href="#"><img src="' + bgSource + '" width="50" height="auto" /></a></li>'; 
		    } 
		}
		);
		jQuery('.next.arrow, .prev.arrow').click(function(){
			resizeSections();
		});
		//Build the portfolio slider 
		jQuery(function() {
		
		var oldAmount = 0;
		var sliderLength = 100;
		var numberOfSlides = jQuery('#portfolio-wrapper').children().length;
		sliderStep = sliderLength/numberOfSlides;
				jQuery( "#slider" ).slider({
					value:0,
					min: 0,
					max: sliderLength,
					step: sliderStep,
					slide: function( event, ui ) {
					if (ui.value > oldAmount){
						jQuery('#portfolio-wrapper').cycle('next');
					}
					else if(ui.value < oldAmount){
						jQuery('#portfolio-wrapper').cycle('prev');
					}
					oldAmount = ui.value;
						
					}
				});
			});
		
		jQuery('#portfolio-nav').after('<a class="nav-tab">+</a>');
		
			
function buildPageAnchors(slide){
		if(jQuery(slide).find('.post-title').html()){
		var linkTitle = jQuery(slide).find('.post-title').html();
		var postId = jQuery(slide).attr('id');
		    return '<li><a href="#">'+linkTitle+'</a></li>'; 
		    }
		    else {
		    	return '<li class="hidden"><a href="#"></a></li>';
		    }
	} 
	
	
		jQuery('.slider.content').cycle({ 
		    fx:     'fade', 
		    speed:  'slow', 
		    timeout: 0, 
		    pager:  '.section-menu', 
		     
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
			   return buildPageAnchors(slide);
		    	}
	    	});
	
			jQuery('#portfolio-nav').hide();
		
	
		jQuery('.section-title').each(function(){
			jQuery(this).click(function() { 
			    jQuery(this).parent().parent().parent().find('.content').cycle(0); 
			    return false; 
			}); 
		});
	}//End make cycles

function moveMenuIndicator(){

	var currentItem = jQuery('.current-menu-item');
	if(currentItem.length > 0){
	var itemOffset = currentItem.offset().left;
	var itemWidth = currentItem.width();
	var menuOffset = currentItem.parent().offset().left;
	var windowWidth = jQuery('body').width();
	var menuWidth = jQuery('#menu-global-menu').width();
	
	var tabPosition = itemOffset + itemWidth/2; 
	

	var tabPosition = itemOffset + itemWidth/2; 
	
	jQuery('.menu-global-menu-container').css({'background-position-x': tabPosition });
			}
}//end moveMenuIndicator function
/* ============= Global Scripts ========*/
jQuery(window).load(function(){
	jQuery('.hand-navigation .arrow').click(function(e){
			if(jQuery(this).hasClass('next')){
				jQuery('#portfolio-wrapper').cycle('next');
			}
			else if(jQuery(this).hasClass('prev')){
				jQuery('#portfolio-wrapper').cycle('prev');
			}
	});
	activeSection = jQuery('.active');
	//fade the wrapper in after it loads
	jQuery('#wrapper').animate({'opacity':1},1400);
	
	
	makeCycles();
	//imageTexturizer();
	resizeSections();
	
		
			});


/* +++++ Touch and Non-Touch Scripts ++++++ */

jQuery(document).ready(function($){

//KEYBOARD EVENTS

$('body').keydown(function(e){
	//console.log('keycode: ',e.keyCode); //uncomment to see keycodes
	

		if(e.keyCode == 37){//left(37) arrow is pressed
		if(jQuery('#portfolio').length > 0){
			//modal changes too
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="next"]').click();
			}//end open modal	
			
			else {
				jQuery('#portfolio-wrapper').cycle('prev'); //this is reversed to match wp post order
				resizeSections();
			} 
		}
		
		else if(jQuery('#case_studies').length > 0){
			jQuery('.post-box .content').cycle('prev'); //this is reversed to match wp post order
		}
		else if(jQuery('#services').length > 0){
			jQuery('.post-box .content').cycle('prev'); //this is reversed to match wp post order
		}
		else if(jQuery('#artists').length > 0){
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="next"]').click();
			}//end open modal	
		}
		e.preventDefault();
	}
	else if(e.keyCode == 39){//right(39) arrow is pressed
		if(jQuery('.page-template-page-showcase-php').length > 0 || jQuery('.page-template-page-tour-php').length > 0){
			
			//modal changes too
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="prev"]').click();
			}//end open modal	
			
			else {
				jQuery('#portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
				resizeSections();
							}
			
		}
		else if(jQuery('.page-template-page-category-php').length > 0){
			jQuery('.post-box .content').cycle('next'); //this is reversed to match wp post order
		}
		else if(jQuery('.page-template-page-grid-php').length > 0){
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="prev"]').click();
			}//end open modal	
		}
		e.preventDefault();
	}
else if (e.keyCode == 13) {//return(13) key was pressed
	if(jQuery('#portfolio').length > 0 && !jQuery('#modal').hasClass('open')){ 
		jQuery('#portfolio-wrapper').click();
	}
}
});//end keydown events
//end KEYBOARD EVENTS

jQuery(window).load(function(){
	moveMenuIndicator();
	makeSwipes('.wrapper');
	navTabActivate('#portfolio .nav-tab', '#portfolio-nav');
	hhAccordion('#contact-accordion');//the contact form accordion
	var $container = jQuery('.filter-target');
		$('.artist').animate({'opacity':1, 'margin':'5px'}, 500);

	
	// initialize isotope
	if($container.length > 0){
	$container.isotope({
  // options... http://isotope.metafizzy.co/docs/options.html
  filter: '.artist' 
	});
	
		}
});
	
jQuery(window).resize(function() {
  moveMenuIndicator();
  resizeSections();
  showInstructions(); 
  
  var hideThem=setTimeout(function(){hideInstructions()},3000);
  jQuery(window).scroll();
});
/* isotope activate */


//IS0TOPE MENU
// filter items when filter link is clicked
$('.filter-menu a').click(function(){
$('.filter-menu li').removeClass('activeSlide');
  var selector = $(this).attr('data-filter');
  jQuery(this).parent('li').toggleClass('activeSlide');
  var $container = jQuery('.filter-target');
  // initialize isotope
  if($container.length > 0){
  $container.isotope({
    // options... http://isotope.metafizzy.co/docs/options.html
    filter: selector 
  });
  }
  $container.find('.isotope-item').animate(500);	
  return false;
});
//End isotope activation scripts

/* Video playback control */
function stopVideo(container){


    container.find('#modal-content').empty();

}
/* Modal Activations */

    jQuery('.artist').click(function() {
    var target = jQuery(this);
    var targetID = target.attr('data-target');
    var modal = jQuery('#modal');
   //load modal template into modal content with ajax
	var modalContent =  $.ajax({
	    url: targetID,
	    
	    context: document.body
	  }).done(function() { 
	  
	    modal.find('#modal-content').html(modalContent.responseText);
	    
	     modal.reveal({
	     close: function(){stopVideo(modal);}
	     }).fitVids();
	    
	     activateLinks();
	     
	  }); 

    });

   jQuery('#portfolio-wrapper').click(function() {
    var target = jQuery(this).find('.portfolio-entry:visible');
    var targetID = target.attr('data-target');
   if(targetID != null){
    var modal = jQuery('#modal');
   //load modal template into modal content with ajax
	var modalContent =  $.ajax({
	    url: targetID,
	    context: document.body
	  }).done(function() { 
	   
	   modal.find('#modal-content').html(modalContent.responseText);
	   
	    modal.reveal({
	    close: function(){stopVideo(modal);}
	    }).fitVids();
	     
	    activateLinks();
	     
	   	  }); 
	   	  }
    });
   
   //instructions modal
   jQuery('.instructions .modal-link').click(function() {
    var target = jQuery(this);
    var targetID = target.attr('data-target');
    console.log(targetID);
    var modal = jQuery('#modal-small');
   //load modal template into modal content with ajax
   	var modalContent =  $.ajax({
   	    url: targetID,
   	    context: document.body
   	  }).done(function() { 
   	   
   	   modal.find('#modal-content').html(modalContent.responseText);
   	   
   	    modal.reveal({
   	    dismissModalClass: 'close-btn',
   	    close: function(){stopVideo(modal);}
   	    }).fitVids();
   	     
   	    activateLinks();
   	     
   	   	  }); 
    });
    //casestudy modal
    jQuery('.hh_case_study_post .modal-link').click(function(e) {
    e.preventDefault();
     var target = jQuery(this);
     var targetID = target.attr('href');
     console.log(targetID);
     var modal = jQuery('#modal');
    //load modal template into modal content with ajax
    	var modalContent =  $.ajax({
    	    url: targetID,
    	    context: document.body
    	  }).done(function() { 
    	   
    	   modal.find('#modal-content').html(modalContent.responseText);
    	   
    	    modal.reveal({
    	    dismissModalClass: 'close-btn',
    	    close: function(){stopVideo(modal);}
    	    }).fitVids();
    	     
    	    activateLinks();
    	     
    	   	  }); 
    	   	  
     });//end case study modal
   
  var modalPosition = 0;
 function activateLinks(){
 
	 jQuery('.modal-link a').click(function(e) {
	 
	        modalPosition = modalPosition + 1;
	         var target = jQuery(this);
	         var targetID = target.attr('href');
	         var modal = jQuery('#modal');	      
		    
	    if(jQuery('html').hasClass('no-touch')){//Scripts for touch-enabled devices  
		   
		 if(modalPosition == 1 && getBrowser() == 'safari'){
		      modalPosition = modal.css('margin-left');
				
						        modalPosition = 0-parseInt(modalPosition)/2;
		        
		        
		       
		        }
		else{
		modalPosition = modal.css('margin-left');
		}
		           if(target.attr('rel') == 'prev'){
		               var  animationDirection = '1000px';
		           }
		           else if(target.attr('rel') == 'next'){
		               var  animationDirection = '-2000px';
		           }
		      
		       modal.css('margin-left', modalPosition);
		       
		       modal.animate({'margin-left':animationDirection}, 300, 'easeInQuad', function(){
			       var modalContent =  $.ajax({
		     	    url: targetID,
		     	    context: document.body
		     	  }).done(function() { 
		     	   
		     	    modal.find('#modal-content').html(modalContent.responseText);
		     	    
		     	    modal.animate({'margin-left':modalPosition}, 300, 'easeOutQuad', function(){
		     	    modal.reveal({
		     	    close: function(){stopVideo(modal);}
		     	    }).fitVids();
		     	    
		     	    });
		     	    if(jQuery(target).attr('rel') == 'prev'){
		     	    jQuery('.page-template-page-showcase-php #portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
		     	    }
		     	   else if(jQuery(target).attr('rel') == 'next'){
		     	    jQuery('.page-template-page-showcase-php #portfolio-wrapper').cycle('prev');//this is reversed to match wp post order
		     	    }
		     	    activateLinks();
		     	    
		     			     	  }); 
		     
		     	  });
     	  }
     	  else { //touch devices dont animate
     	  var modalContent =  $.ajax({
     	    url: targetID,
     	    context: document.body
     	  }).done(function() { 
	        modal.find('#modal-content').html(modalContent.responseText);
	        
     	    modal.reveal({
     	    close: function(){stopVideo(modal);}
     	    }).fitVids();
     	    
     	    if(jQuery(target).attr('rel') == 'prev'){
     	    jQuery('#portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
     	    }
     	   else if(jQuery(target).attr('rel') == 'next'){
     	    jQuery('#portfolio-wrapper').cycle('prev');//this is reversed to match wp post order
     	    }
     	    activateLinks();
     	  }); 
     	  
     	  
     	  }
	 	     e.preventDefault();
	         });
	 
 }  
    
/* End modal activations */
}); //end document ready

var showThem;
var hideThem;
jQuery(window).mousemove(function(event) {
if(jQuery('#portfolio').length > 0){

		clearTimeout(showThem); 
		clearTimeout(hideThem); 
		
		
		 showThem=setTimeout(function(){
		showInstructions();
		clearTimeout(showThem);
		
			},200);
		
		 hideThem =setTimeout(function(){
		hideInstructions();  
		clearTimeout(hideThem); 
		},2000); 

	}
});

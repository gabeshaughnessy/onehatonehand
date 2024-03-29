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

function getEndOfURL(url){
	arr = url.split('/');
	return arr[arr.length-2];
}
function getURLHash(url){
	arr = url.split('#');

	return arr[arr.length-1];
}
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
	elementOffset.y = windowHeight/4;
	element.css({
	'left' : elementOffset.x,
	'top' : elementOffset.y
	});
}
function centerElementX(element){
	var windowWidth = jQuery(window).width();
	var elementWidth = element.width();
	var elementOffset = new Object();
	elementOffset.x = windowWidth/2 - elementWidth/2;
	element.css({
	'left' : elementOffset.x,
	});
}
function centerElementY(element){
	var windowHeight = jQuery(window).height();
	var elementHeight = element.height();
	var elementOffset = new Object();
	elementOffset.y = windowHeight/2 - elementHeight/2;
	element.css({
	'margin-top' : elementOffset.y,
	});
}
function falsePageHeight(){ //make the page the total height of all the sections with fixed positions
	pageHeight = 0;
	
	jQuery('.section').each(function(){
		pageHeight += jQuery(this).outerHeight();
	});
	
	jQuery('body').css('height',pageHeight);
}//end falsePageHeight

function resizeAllSections(){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();
	jQuery('#fixed_bg').css({'height':windowHeight});
	jQuery('.portfolio-wrapper').css({"width": windowWidth, "height": windowHeight + 400});
	jQuery('.section').css({"width": windowWidth, "min-height": windowHeight});
	jQuery('#hand-navigation .hand').animate({'top': windowHeight/3}, 500);
	//centerElement(jQuery('#portfolio-control'));
	//match the nav-spacer position instead

	if(jQuery('.nav-target').is(":visible")){
		navPos = jQuery('.nav-target').position();
		
	if(jQuery('#portfolio-control').length > 0 ){
			//jQuery('#portfolio-control').css({'top': navPos.top});
				
			jQuery('.tour-entry .post-content, .instructions-modal'  ).not('#portfolio-control').each(function(index){
				jQuery(this).css({'top': 100});
				centerElement(jQuery(this));
			});
			jQuery('#portfolio-control').each(function(index){
				centerElementX(jQuery(this));
			});
			}
			}
				var menuPos =  jQuery('#menu-main-menu, #menu-global-menu').offset();
			jQuery('#portfolio-nav').css({"paddingLeft": menuPos.left});
		
		
}
//End resizeSections
function resizePortfolioSections(){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();

	
	jQuery('#portfolio-control').each(function(index){
		centerElementX(jQuery(this));
	});
	
	var menuPos =  jQuery('#menu-main-menu').offset();
	if(menuPos){
	jQuery('#portfolio-nav, ').css({"paddingLeft": menuPos.left});
	}
	
}
//End resizeSections
function resizeTourSections(){
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery(window).height();

	jQuery('#hand-navigation .hand').animate({'top': windowHeight/3}, 500);

	jQuery('.tour-entry .post-content'  ).each(function(index){
		jQuery(this).css({'top': 100});
		centerElement(jQuery(this));
	});
	
}//end resize tour sections

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
jQuery('#hand-navigation').fadeOut(200);
}//end hide instructions
//Show the Instructions
function showInstructions(){
jQuery('.instructions').fadeIn(200);
jQuery('#hand-navigation').fadeIn(200);
}//end show instructions



//TOUCHWIPE EVENT HANDLER
function makeSwipes(targetElement){
jQuery(targetElement).touchwipe({//touch settings
     wipeLeft: function() { 
     jQuery(targetElement).cycle('next'); 
     resizePortfolioSections();
      },
     wipeRight: function() {
      jQuery(targetElement).cycle('prev');
      resizePortfolioSections(); 
       },
     min_move_x: 50,
     min_move_y: 50,
     preventDefaultEvents: false
});
}

function whichSectionIsActive(){
	
	if(jQuery('#landing').hasClass('active') ){
		jQuery('.menu-main-menu-container').slideUp('slow');
		jQuery('#portfolio-nav').slideUp('fast');
		jQuery('#portfolio .nav-tab').hide();
	}	
	else if (jQuery('#services').hasClass('active')) {
		jQuery('#portfolio-nav').slideUp('fast');
		jQuery('#portfolio .nav-tab').hide();	
	}
	else if(jQuery('#portfolio').hasClass('active')){
		jQuery('.menu-main-menu-container').slideDown('slow');
		jQuery('#portfolio .nav-tab').show('slow');
		resizePortfolioSections();	
	}
	else if (jQuery('#case-studies').hasClass('active')) {
		jQuery('#portfolio .nav-tab').hide();
		jQuery('.menu-main-menu-container').slideDown('slow');
		jQuery('#portfolio-nav').slideUp('fast');
	}
	else if (jQuery('#tour').hasClass('active')) {
		jQuery('#portfolio .nav-tab').hide();
		jQuery('.menu-main-menu-container').slideDown('slow');
		jQuery('#portfolio-nav').slideUp('fast');
		/* Isotope Activation */	
	}
	else if (jQuery('#clients').hasClass('active')) {
		jQuery('#portfolio .nav-tab').hide();
		jQuery('.menu-main-menu-container').slideDown('slow');
		jQuery('#portfolio-nav').slideUp('fast');
	}
	else if (jQuery('#contact').hasClass('active')) {
			jQuery('#portfolio .nav-tab').hide();
			jQuery('#portfolio-nav').slideUp('fast');
			jQuery('.menu-main-menu-container').slideDown('slow');
}


}// end of whichSectionIsActive function


function setActive() { //determines which section is active based on scroll bar position and the height of the sections.

var hash = window.location.hash;
if (hash.length > 0){//if there is a link in the url
jQuery('.section').each(function(){
	var offset = 0;
	//add up the height of all the previous sections 
	jQuery(this).prevAll('.section').each(function(){
		offset += jQuery(this).outerHeight();
	});
	
	//store the offset in a data attribute
	jQuery(this).attr('data-offset', offset);
	});
 
}
else {
	jQuery('.section').each(function(){	
		var offset = 0;
		//add up the height of all the previous sections 
		jQuery(this).prevAll('.section').each(function(){
			offset += jQuery(this).outerHeight();
		});
		
		//store the offset in a data attribute
		jQuery(this).attr('data-offset', offset);
	
		if(scrollDistance >= offset + scrollPadding && scrollDistance < jQuery(this).outerHeight() + offset){
			//If the scroll distance is between the offset and the height of the section, this section is active
			jQuery(this).addClass('active'); //don't use toggle class because this fires for every scroll event
			
		}
		else if(scrollDistance < jQuery(this).outerHeight() + offset){
		//if we haven't scrolled to the section yet
		jQuery(this).removeClass('active');
			
			
			jQuery(this).css({'top':0});
			jQuery('.section').css({'position':'relative'});
			}
		
		
		else if(scrollDistance > jQuery(this).outerHeight() + offset){
		//if the window is scrolled past the section
		jQuery(this).removeClass('active');
		
		
		jQuery(this).css({'top': jQuery(this).outerHeight() +100})
		}
		
		else{
			jQuery(this).removeClass('active');
		}
		
		//set menu active
		
			
		if(scrollDistance >= offset && scrollDistance < jQuery(this).outerHeight() + offset - 500){
			jQuery(this).find('.sidebar').addClass('active-sidebar');
		} 
		else if(scrollDistance + jQuery(this).find('.sidebar').outerHeight() > jQuery(this).outerHeight() + offset){
		jQuery(this).find('.sidebar').removeClass('active-sidebar');
		}
		
		
		
		
	});
	}//end else
	
}//end setActive


function moveMenuIndicator(){
	var $menu;
	if(jQuery('#menu-main-menu').length > 0){
		$menu = 'menu-main-menu';
	}
	else if (jQuery('#menu-global-menu').length >0) {
		$menu = 'menu-global-menu';
	}
	
	jQuery('#'+$menu+' .menu-item a').each(function(){
			var sectionID;
			if($menu == 'menu-main-menu'){
				sectionID = jQuery(this).attr('href');
				
			}
			else if($menu == 'menu-global-menu'){
				
				if(getURLHash(jQuery(this).attr('href')).indexOf('http') == -1){
					 sectionID = '#'+getURLHash(jQuery(this).attr('href'));
				}
				else {
					sectionID = false;
				}
			}
		if(sectionID != false){
			var sectionOffset = jQuery(sectionID).offset();
			
			menuLeftPos = jQuery(this).parent().parent().offset().left;
			
			if(sectionOffset){
				sectionOffset.bottom = sectionOffset.top + jQuery(sectionID).height();
			}
			
			if(jQuery(this).attr('href') == '/'+sectionID){//give the active menu item its own class
			
			jQuery('#'+$menu+' .menu-item a').removeClass('active-item');
			jQuery(this).addClass('active-item');
			}
		}
	});//end each for menu item links
	
if($menu == 'menu-main-menu'){
	if(currentSection == null){
		var activeSection = jQuery('.active').first();
	}
	else { var activeSection = currentSection; }
		if(jQuery('#'+$menu+' a[href="#'+ activeSection.attr("id") +'"]').length > 0){
		var currentItem = jQuery('#'+$menu+' a[href="#'+ activeSection.attr("id") +'"]');
	}
	else{
	var currentItem = jQuery('#'+$menu+' .current-menu-item a');
	}
	
	if(currentItem.length > 0){
		var itemOffset = currentItem.offset().left;
		var itemWidth = currentItem.width();
	}
	
	var tabPosition = itemOffset + itemWidth/2; 
	jQuery('.'+$menu+'-container').css({'backgroundPosition': tabPosition});
	
}
else if($menu == 'menu-global-menu'){
	var activeSection = currentSection; 
	if(jQuery('#'+$menu+' a[href="/#'+ activeSection.attr("id") +'"]').length > 0){
		var currentItem = jQuery('#'+$menu+' a[href="/#'+ activeSection.attr("id") +'"]');
	}
	else{
	var currentItem = jQuery('#'+$menu+' .active-item');
	}
	
	if(currentItem.length > 0){
		var itemOffset = currentItem.offset().left;
		var itemWidth = currentItem.width();
	}
	
	var tabPosition = itemOffset + itemWidth/2; 
	jQuery('.'+$menu+'-container').css({'backgroundPosition': tabPosition});

}
	
	
}//end moveMenuIndicator function
	

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
function playAnimation(compID){
	if(typeof getComposition == 'function'){
		var animation = AdobeEdge.getComposition(compID);
		if(animation != undefined)	{
			stage = animation.getStage();
			stage.play(0);
		}
	}
}
function makePortfolioCycles(){
		var navID;
		var navBar;
		if(jQuery('#portflio.tour').length == 0){
			
			navID = '#portfolio-nav';
			navBar = '<ul id="portflio-nav">';
		}
		else if(jQuery('#portflio.tour').length > 0){
			navID = false;
			navBar = '';
		}
		jQuery('#portfolio .cycle').cycle({ 
		    fx:     'scrollHorz', 
		    speed:  500, 
		    timeout: 0, 
		    //pager:  navID, 
		    next: '#portfolio-control .next',
		    prev: '#portfolio-control .prev',
		    after: afterPortfolioCycle,
		    skipInitializationCallbacks: true,
		     
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
		    var bgSource = jQuery(slide).find('.portfolio_bg img').attr('src');
			    if(bgSource){
			        return '<li><a href="#"><img src="' + bgSource + '" width="50" height="auto" /></a></li>'; 
			        }
		        else {
			        return '';
		        }
		    } 
		}
		);
		jQuery('#portfolio .next, #portfolio .prev').click(function(){
			resizePortfolioSections();
		});
		
		
		jQuery('#tour .cycle').cycle({ 
		    fx:     'scrollHorz', 
		    speed:  500, 
		    timeout: 0,  
		    next: '#tour .next',
		    prev: '#tour .prev',
		   after: afterTourCycle,
		}
		);
		jQuery('#tour .next, #tour .prev').click(function(){
		
			resizeTourSections();
			
		});
		

function afterPortfolioCycle(currSlideElement, nextSlideElement, options, forwardFlag){
			nextElementID = jQuery(nextSlideElement).attr('data-target');
			if(nextElementID != undefined && nextElementID.indexOf('shop-tour') != -1){		
				playAnimation("animate-shop-tour");
			}
		
			//ajax load next few slides and remove this one
			if (typeof portfolioItems != 'undefined'){ //look for global array with portfolio items
				//Preload Images
				var index;
				for (index = 0; index < portfolioItems.length; ++index) {
						var image = new Image();
						image.src = portfolioItems[index];
					}

				currentImgSrc = jQuery(currSlideElement).find('img').attr('src');					
					if( currentImgSrc != '' || currentImgSrc != undefined){
						jQuery(currSlideElement).find('img').attr('src', portfolioItems[1]);
						portfolioItems.splice(0,1);
						if(currentImgSrc.indexOf('paper_bg2') == -1){
							portfolioItems.push(currentImgSrc);
							//jQuery('#portfolio-control h2').remove();
						}
						
					}
					
			}
			//Stop video Playback
			videoElement = jQuery(currSlideElement).find('iframe');
			if(videoElement){
				videoSrc = jQuery(videoElement).attr('src');
				jQuery(videoElement).attr('src', '');
				jQuery(videoElement).attr('src', videoSrc);
			}

			var nextslide = jQuery(nextSlideElement).attr('data-target');
			var currslide = jQuery(currSlideElement).attr('data-target');
			
			if(jQuery(nextSlideElement).parent().parent().attr('id') == 'portfolio'){
				var portfolioGroup = jQuery(nextSlideElement).find('.portfolio-group').html();
				if(portfolioGroup != null){
					jQuery('#portfolio-control h2').text(portfolioGroup);
				}
				else{
					jQuery('#portfolio-control h2').text('Portfolio');
				}
				
				
			}
			if(jQuery(nextSlideElement).hasClass('isotope-grid')){
				var $container = jQuery('.filter-target');
				if($container.length > 0){
					$container.isotope({
					  filter: '.artist'
					});
					$container.find('.isotope-item').animate({'opacity':1}, 500);	
				}
				
			}
		}		
function afterTourCycle(currSlideElement, nextSlideElement, options, forwardFlag){
	nextElementID = jQuery(nextSlideElement).attr('data-target');
	if(nextElementID != undefined && nextElementID.indexOf('shop-tour') != -1){		
		playAnimation("animate-shop-tour");
	}
	
	//Stop video Playback
	videoElement = jQuery(currSlideElement).find('iframe');
	if(videoElement){
		videoSrc = jQuery(videoElement).attr('src');
		jQuery(videoElement).attr('src', '');
		jQuery(videoElement).attr('src', videoSrc);
	}

	var nextslide = jQuery(nextSlideElement).attr('data-target');
	var currslide = jQuery(currSlideElement).attr('data-target');
	

	if(jQuery(nextSlideElement).hasClass('isotope-grid')){
		var $container = jQuery('.filter-target');
		if($container.length > 0){
			$container.isotope({
			  filter: '.artist'
			});
			$container.find('.isotope-item').animate({'opacity':1}, 500);	
		}
		
	}
}			
function buildPageAnchors(slide){
		if(jQuery(slide).find('.post-title').html()){
		var linkTitle = jQuery(slide).find('.post-title').html();
		var postId = jQuery(slide).attr('id');
			if(jQuery(slide).find('.post-title').hasClass('has-parent')){
				hasParent = 'has-parent';
			}
			else {
				hasParent = 'parent';
			}
		    return '<li class="'+hasParent+'"><a href="#">'+linkTitle+'</a></li>'; 
		    }
		    else {
		    	return '<li class="hidden"><a href="#"></a></li>';
		    }
	} 
	
	
		jQuery('#services .content').cycle({ 
		    fx:     'fade', 
		    speed:  'slow', 
		    timeout: 0, 
		    pager:  '#services-menu', 
		     
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
			   return buildPageAnchors(slide);
		    	}
	    	});
	
		
				
		
		//jQuery('.menu-main-menu-container').hide();
		jQuery('#portfolio-nav').hide();
		
	
		jQuery('.section-title').each(function(){
			jQuery(this).click(function() { 
			    jQuery(this).parent().parent().parent().find('.content').cycle(0); 
			    return false; 
			}); 
		});
	}//End make portfolio cycles
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


function caseStudyCycles(){
	jQuery('#case-studies #slide-container.cycle').cycle({ 
		    fx:     'scrollHorz', 
		    speed:  500, 
		    timeout: 0, 
		    startingSlide: 0,
		    //pager:  '#case-study-nav', 
		    next: '#slider-nav .next',
		    prev: '#slider-nav .prev'
		}
		);
}
function makeCaseStudyCycles(){
	var casestudy = '.'+getUrlVars()["case"];
	var startID = 0;
	var slidePos = jQuery(casestudy);
	//get the slide with class that matches the casestudy value and get its count in line
	if(slidePos.length > 0){
		var listItems = jQuery('casestudy');
		var startID = jQuery(casestudy).index('#case-study-wrapper .page, #case-study-wrapper .post');
		//console.log(startID,' ', casestudy);
		//console.log(jQuery(casestudy));
	}
		jQuery('#case-study-wrapper.cycle').before('<div id="case-study-nav-container"><ul id="case-study-nav">').cycle({ 
		    fx:     'scrollHorz', 
		    speed:  500, 
		    timeout: 0, 
		    startingSlide: startID,
		    pager:  '#case-study-nav', 
		    next: '#case-studies .next',
		    prev: '#case-studies .prev',
		    after: afterCycle,
		     
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
		    var bgSource = jQuery(slide).find('.portfolio_bg img').attr('alt');
		    var firstSlide = jQuery(slide).hasClass('first-slide');
			   if(firstSlide){
			        return '<li class="first"><a href="#">.</a></li>';
			   }
			   else if(bgSource){
			        return '<li><a href="#">'+bgSource+'</a></li>'; 
			        }
			    
		        else {
			        return '<li class="sub"><a href="#">.</a></li>';
		        }
		    } 
		}
		);
		jQuery('#case-studies .next, #case-studies .prev').click(function(){
			resizePortfolioSections();
		});
		function afterCycle(currSlideElement, nextSlideElement, options, forwardFlag){
			//Stop video Playback
			videoElement = jQuery(currSlideElement).find('iframe');
			if(videoElement){
				videoSrc = jQuery(videoElement).attr('src');
				jQuery(videoElement).attr('src', '');
				jQuery(videoElement).attr('src', videoSrc);
			}

			if(jQuery(nextSlideElement).hasClass('isotope-grid')){
				var $container = jQuery('.filter-target');
				if($container.length > 0){
					$container.isotope({
					  filter: '.artist'
					});
					$container.find('.isotope-item').animate({'opacity':1}, 500);	
				}
				
			}
		}
			
				
		//jQuery('#case-study-nav').after('<a class="nav-tab">+</a>');
		
			
function buildPageAnchors(slide){
		if(jQuery(slide).find('.post-title').html()){
		var linkTitle = jQuery(slide).find('.post-title').html();
		var postId = jQuery(slide).attr('id');
			if(jQuery(slide).find('.post-title').hasClass('has-parent')){
				hasParent = 'has-parent';
			}
			else {
				hasParent = 'parent';
			}
		    return '<li class="'+hasParent+'"><a href="#">'+linkTitle+'</a></li>'; 
		    }
		    else {
		    	return '<li class="hidden"><a href="#"></a></li>';
		    }
	} 
	
	
			
		
				
		
		//jQuery('.menu-main-menu-container').hide();
		//jQuery('#case-study-nav').hide();
		
	
		jQuery('.section-title').each(function(){
			jQuery(this).click(function() { 
			    jQuery(this).parent().parent().parent().find('.content').cycle(0); 
			    return false; 
			}); 
		});
	}//End make case-study cycles
	
/* ============= Global Scripts ========*/
jQuery(window).load(function(){

	/* Psuedo Hover Events for touch devices */
	jQuery('.hover').click(function(e){
	jQuery(this).toggleClass('hovered');
	});

	activeSection = jQuery('.active');
	
	//fade the wrapper in after it loads
	jQuery('#wrapper').animate({'opacity':1},1400);
	jQuery('.loader').animate({'opacity':0},400, function(){
		jQuery('.loader').remove();
	});

	
	
	makePortfolioCycles();
	caseStudyCycles();
	
	if(jQuery('. page-template-page-case_studies-php')){//only do case studies on the case study page.
		makeCaseStudyCycles();
		//navTabActivate('#case-studies .nav-tab', '#case-study-nav');
	}
	
	resizeAllSections();
	if(jQuery('#portfolio')){
		navTabActivate('#portfolio .nav-tab', '#portfolio-nav');
		}
	hhAccordion('#contact-accordion');//the contact form accordion
	whichSectionIsActive();
	
	
	jQuery('.menu-main-menu-container').slideUp();
	
	jQuery('#landing').bind('inview', function (event, visible) {
	  if (visible == true) {
	 // alert('active landing'); //for debugging
	 jQuery('.section').removeClass('active');
	 currentSection = jQuery('#landing');
	  jQuery('#landing').addClass('active');
	    // element is now visible in the viewport
	  jQuery('.menu-main-menu-container').slideUp();
	 
	  } 
	  else { //landing out of view
	  jQuery('#landing').removeClass('active');
	    jQuery('.menu-main-menu-container').slideDown('fast');
		   jQuery('#portfolio-nav').slideUp('fast');
		   jQuery('#portfolio .nav-tab').hide();
	  }
	   moveMenuIndicator();
	});
	
	jQuery('#portfolio').bind('inview', function (event, visible) {
	  if (visible == true) {
		 jQuery('.section').removeClass('active');
	currentSection = jQuery('#portfolio');
	  jQuery('#portfolio').addClass('active');
	    // element is now visible in the viewport
	    jQuery('.menu-main-menu-container').slideDown('fast');
	   jQuery('#portfolio .nav-tab').show('fast');
	   
	   showInstructions(); 
	   //var hideThem=setTimeout(function(){hideInstructions()},3000);
	  
	   	
	  } 
	  else { //portfolio out of view
	  jQuery('#portfolio').removeClass('active');
	   jQuery('#portfolio-nav').slideUp('fast');
	   jQuery('#portfolio .nav-tab').hide('fast');
	  }
	  moveMenuIndicator();
	});
	
	jQuery('#services').bind('inview', function (event, visible) {
	  if (visible == true) {
	   jQuery('.section').removeClass('active');
	  currentSection = jQuery('#services');
	  jQuery('#services').addClass('active');
	    // element is now visible in the viewport
	    jQuery('.menu-main-menu-container').slideDown('fast');
	    jQuery('#portfolio-nav').slideUp('fast');
	    jQuery('#portfolio .nav-tab').hide();
	    	
	  } 
	  else {
	  jQuery('#services').removeClass('active');
	    // element has gone out of viewport
	   
	  }
	  moveMenuIndicator();
	});
	
	jQuery('#case-studies').bind('inview', function (event, visible) {
	  if (visible == true) {
	 // alert('active casestudies'); //for debugging
	 	 jQuery('.section').removeClass('active');
	 currentSection = jQuery('#case-studies');
	  jQuery('#case-studies').addClass('active');
	    // element is now visible in the viewport
	    jQuery('.menu-main-menu-container').slideDown('fast');
	    jQuery('#portfolio-nav').slideUp('fast');
	    jQuery('#portfolio .nav-tab').hide();
	  } 
	  else {
	  jQuery('#case-studies').removeClass('active');
	    // element has gone out of viewport
	   
	  }
	  moveMenuIndicator();
	});
	
	jQuery('#tour').bind('inview', function (event, visible) {
	  if (visible == true) {
	  //alert('active tour'); //for debugging
	  
	  	 jQuery('.section').removeClass('active');
	  
	  currentSection = jQuery('#tour');
		  jQuery('#tour').addClass('active');
		    // element is now visible in the viewport
		    jQuery('.menu-main-menu-container').slideDown('fast');
		    jQuery('#portfolio-nav').slideUp('fast');
		    jQuery('#portfolio .nav-tab').hide();
			  playAnimation("animate-shop-tour");
			  jQuery('#tour .portfolio-wrapper').cycle(0);
		  	  	 } //end in view
	  	  
  	  else {
	  jQuery('#tour').removeClass('active');
	    // element has gone out of viewport
	  } 
	  moveMenuIndicator();
	});
	
	
	jQuery('#clients').bind('inview', function (event, visible) {
	  if (visible == true) {
	  	 jQuery('.section').removeClass('active');
	  currentSection = jQuery('#clients');
	  jQuery('#clients').addClass('active');
	    // element is now visible in the viewport
	    jQuery('.menu-main-menu-container').slideDown('fast');
	    jQuery('#portfolio-nav').slideUp('fast');
	    jQuery('#portfolio .nav-tab').hide();
	  } 
	  
	  else {
	  jQuery('#clients').removeClass('active');
	   
	  }
	  moveMenuIndicator();
	});
	
	jQuery('#contact').bind('inview', function (event, visible) {
	  if (visible == true) {
	  	 jQuery('.section').removeClass('active');
	  
	  currentSection = jQuery('#contact');
	  jQuery('#contact').addClass('active');
	    // element is now visible in the viewport
	    //jQuery('.menu-main-menu-container').slideUp('fast');
	    jQuery('#portfolio-nav').slideUp('fast');
	    jQuery('#portfolio .nav-tab').hide();
	  } 
	  else {
	  jQuery('#contact').removeClass('active');
	   jQuery('.menu-main-menu-container').slideDown('fast');
	   
	  }
	  moveMenuIndicator();
	});
	
	jQuery('#modal').bind('inview', function(event, visible){
	if (visible == true) {
		
	} 
	else {
		jQuery('.close-reveal-modal').click(); 
	}
	
	});
	
			});

/* +++++ Touch and Non-Touch Scripts ++++++ */

//declare some globals 
var targetSection;
var currentSection;
jQuery(document).ready(function($){

	if ( Modernizr.touch ) {
		// remove loader for mobile
		jQuery('.loader').remove();
	}

//KEYBOARD EVENTS

$('body').keydown(function(e){
	//console.log('keycode: ',e.keyCode); //uncomment to see keycodes
	
	
	if(e.keyCode == 38 ){//up arrow(38) is pressed
		
		
		if(currentSection == null) {
		currentSection = jQuery('.section.active');

		}

		if(currentSection.attr('id') != 'landing'){
			targetSection = currentSection.prev('.section');
		}
		else {
			targetSection = currentSection;
		}
		if(targetSection.attr('id') != 'landing'){
		var scrollOffset = 40;
		
		}
		else if(targetSection.attr('id') == 'landing') {
		var scrollOffset = -50;
		}
		$.scrollTo(targetSection, 500, {'offset': scrollOffset});
		targetSection.addClass('active');
		jQuery('.close-reveal-modal').click();//close the modal
		e.preventDefault();
	}
	else if(e.keyCode == 40 ){//down(40) arrow is pressed
		
		currentSection = jQuery('.section.active');
				
		if(currentSection.attr('id') != 'contact'){	
			targetSection = currentSection.next('.section');
		}
		else {
			targetSection = currentSection;
		}
		if(targetSection.attr('id') != 'contact'){
		var scrollOffset = 40;
		}
		else {
		var scrollOffset = 0;
		}
		$.scrollTo(targetSection, 500, {'offset': scrollOffset});
		jQuery('.close-reveal-modal').click();//close the modal
		
		e.preventDefault();
	}
	if(e.keyCode == 37){//left(37) arrow is pressed
		if(currentSection.attr('id') == 'portfolio'){
			//modal changes too
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="next"]').click();
			}//end open modal	
			
			else {
				jQuery('#portfolio .portfolio-wrapper, #portfolio #portfolio-wrapper').cycle('prev'); //this is reversed to match wp post order
				resizePortfolioSections();
			} 
		}
		else if(currentSection.attr('id') == 'tour'){
		if(jQuery('#modal').hasClass('open')){
			jQuery('#modal').find('.modal-link a[rel="next"]').click();
		}//end open modal	
		else{
			jQuery('#tour .portfolio-wrapper').cycle('prev'); //this is reversed to match wp post order
			//resizeTourSections();
			}
		}
		
		else if(currentSection.attr('id') == 'case-studies' && jQuery('body.home').length == 0 ){
			jQuery('#case-studies #case-study-wrapper').cycle('prev'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'case-studies'){
			jQuery('#case-studies #slide-container').cycle('prev'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'services'){
			jQuery('#services-posts .content').cycle('prev'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'artists'){
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="next"]').click();
			}//end open modal	
		}
		e.preventDefault();
	}
	else if(e.keyCode == 39){//right(39) arrow is pressed
		if(currentSection.attr('id') == 'portfolio'){
			
			//modal changes too
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="prev"]').click();
			}//end open modal	
			else {
				jQuery('#portfolio .portfolio-wrapper,  #portfolio #portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
				resizePortfolioSections();
			}
			
		}
		else if(currentSection.attr('id') == 'tour'){
		if(jQuery('#modal').hasClass('open')){
			jQuery('#modal').find('.modal-link a[rel="prev"]').click();
		}//end open modal	
		else{
			jQuery('#tour .portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
			resizePortfolioSections();
		}
		}
		else if(currentSection.attr('id') == 'case-studies'  && jQuery('body.home').length == 0){
			jQuery('#case-studies #case-study-wrapper').cycle('next'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'case-studies'){
			jQuery('#case-studies #slide-container').cycle('next'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'services'){
			jQuery('#services-posts .content').cycle('next'); //this is reversed to match wp post order
		}
		else if(currentSection.attr('id') == 'artists'){
			if(jQuery('#modal').hasClass('open')){
				jQuery('#modal').find('.modal-link a[rel="prev"]').click();
			}//end open modal	
		}
		e.preventDefault();
	}
else if (e.keyCode == 13) {//return(13) key was pressed
	if(currentSection.attr('id') == 'portfolio' && !jQuery('#modal').hasClass('open')){ 
		jQuery('.portfolio-wrapper').click();
	}
}
});//end keydown events
//end KEYBOARD EVENTS

var $container = jQuery('.filter-target');
if($container.length > 0){
	$container.isotope({
	  filter: 'artist'
	});
	$container.find('.isotope-item').animate({'opacity':1}, 500);		
	
}

//responsive menu scrolls
jQuery('#services-menu').on('click', 'a', function(e){
	if(jQuery(window).width() < 600){
		jQuery(window).scrollTo(jQuery('#services-posts'), 500, {'offset': -100})
	}
});

//++++ Touch EVENTS +++++
if(jQuery('html').hasClass('touch')){//Scripts for touch-enabled devices


makeSwipes('#case_studies-posts .content');
makeSwipes('#services-posts .content');
makeSwipes('.portfolio-wrapper');
	//++++ Change Orientation ++++++
	window.addEventListener('orientationchange', handleOrientation, false);
	function handleOrientation() {

		var windowWidth = jQuery(window).width();
		var windowHeight = jQuery(window).height();
		
		if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
		    var viewportmeta = document.querySelector('meta[name="viewport"]');
		    if (viewportmeta) {
		}
		}
		if (orientation == 0) {
		  //portraitMode, do your stuff here
		  showInstructions(); 
		  //var hideThem=setTimeout(function(){hideInstructions()},3000);
		}
		else if (orientation == 90) {
		  //landscapeMode
		  showInstructions(); 
		 // var hideThem=setTimeout(function(){hideInstructions()},3000);
		}
		else if (orientation == -90) {
		  //landscapeMode
		  showInstructions(); 
		 // var hideThem=setTimeout(function(){hideInstructions()},3000);
		}
		else if (orientation == 180) {
		  //portraitMode
		  showInstructions(); 
		 // var hideThem=setTimeout(function(){hideInstructions()},3000);
		}
		else {
		}
	}
}
	
jQuery(window).load(function(){
	
	

 jQuery(window).scroll();
 //currentSection = jQuery('.section.active');
		
var scrollOffset;

$.localScroll({ 'offset': scrollOffset, 'onAfter' : function(){
//moveMenuIndicator();
}, 'onBefore': function(e){
clickTarget = e.toElement;
if(jQuery(clickTarget).attr('href') != '#landing'){
scrollOffset = 40;
}
else {
scrollOffset = -50;
}
this.offset = scrollOffset;

}});
});

	

/* isotope activate */


//ISTOPE MENU
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
    
    //instructions modal
    jQuery('.instructions .modal-link').click(function() {
     var target = jQuery(this);
     var targetID = target.attr('data-target');
     //console.log(targetID);
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
    jQuery('#case-studies .modal-link').click(function(e) {
     var target = jQuery(this);
     var targetID = target.attr('href');
     //console.log(targetID);
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
    	   	  e.preventDefault();
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
		     	    //jQuery('.portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
		     	    }
		     	   else if(jQuery(target).attr('rel') == 'next'){
		     	    //jQuery('.portfolio-wrapper').cycle('prev');//this is reversed to match wp post order
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
     	    jQuery('.portfolio-wrapper').cycle('next'); //this is reversed to match wp post order
     	    }
     	   else if(jQuery(target).attr('rel') == 'next'){
     	    jQuery('.portfolio-wrapper').cycle('prev');//this is reversed to match wp post order
     	    }
     	    activateLinks();
     	  }); 
     	  
     	  
     	  }
	 	     e.preventDefault();
	         });
	 
 }  
    
/* End modal activations */
}); //end document ready
jQuery(window).resize(function() {
  moveMenuIndicator();
  resizeAllSections();
  showInstructions(); 
  
  //var hideThem=setTimeout(function(){hideInstructions()},3000);
  jQuery(window).scroll();
});

var showThem;
var hideThem;
jQuery(window).mousemove(function(event) {
	if(currentSection != null){
	if(currentSection.attr('id') == 'portfolio'){
		
		clearTimeout(showThem); 
		clearTimeout(hideThem); 
		
		
		 showThem=setTimeout(function(){
		showInstructions();
		clearTimeout(showThem);
		
			},200);
		
		/* hideThem =setTimeout(function(){
		hideInstructions();  
		clearTimeout(hideThem); 
		},2000); */
	
		
			}
		}
});
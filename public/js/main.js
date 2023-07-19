(function ($) {
"use strict";

/*--
	Mobile Menu
------------------------*/
$('.mobile-menu nav').meanmenu({
	meanScreenWidth: "990",
	meanMenuContainer: ".mobile-menu",
});
/*--
	Main Slider
------------------------*/
$('#mainSlider').nivoSlider({
	directionNav: true,
	animSpeed: 500,
	slices: 18,
	pauseTime: 5000,
	pauseOnHover: false,
	controlNav: false,
	prevText: '<i class="fa fa-chevron-left nivo-prev-icon"></i>',
	nextText: '<i class="fa fa-chevron-right nivo-next-icon"></i>'
});
/*--
	Product Category Slider
------------------------*/
$(".pro-cat-slider").owlCarousel({

	nav:true,
	items : 2,
	itemsDesktop : [1199,2],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	pagination : false,
	scrollPerPage:true
});
/*--
	Tab Product and Upsell Product Slider
------------------------*/
$(".pro-tab-slider, .upsell-pro-slider").owlCarousel({

	nav:true,
	items : 5,
	itemsDesktop : [1199,4],
	itemsDesktopSmall : [980,3],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	pagination : false,
	scrollPerPage:true
});
$(".pro-tab-slider-3").owlCarousel({

	nav:true,
	items : 4,
	itemsDesktop : [1199,4],
	itemsDesktopSmall : [980,3],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	pagination : false,
	scrollPerPage:true,
	addClassActive: true
});
/*--
	Feature Product Slider
------------------------*/
$(".pro-feature-slider").owlCarousel({

	nav:true,
	items : 5,
	itemsDesktop : [1199,4],
	itemsDesktopSmall : [980,3],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	pagination : false,
	scrollPerPage:true
});
/*--
	Feature and New Product Slider
------------------------*/
$(".feature-slider, .pro-new-slider").owlCarousel({

	nav:true,
	items : 2,
	itemsDesktop : [1199,2],
	itemsDesktopSmall : [980,2],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	pagination : false,
	addClassActive: true
});
/*--
	Pro Slider for Pro Details
------------------------*/
$(".pro-img-tab-slider").owlCarousel({

	nav:true,
	items : 3,
	itemsDesktop : [1199,3],
	itemsDesktopSmall : [768,6],
	itemsTablet: [767,3],
	itemsMobile : [479,2],
	slideSpeed : 1500,
	paginationSpeed : 1500,
	rewindSpeed : 1500,
	navigation : true,
	navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	pagination : false,
	addClassActive: true
});
/*--
	Simple Lens and Lightbox
------------------------*/
	$('.simpleLens-lens-image').simpleLens({
		loading_image: 'img/loading.gif'
	});
	lightbox.option({
      'alwaysShowNavOnTouchDevices': true,
    })
/*--
	Related Product Slider
------------------------*/
$(".related-pro-slider").owlCarousel({

	nav:true,
	autoPlay : false,
	items : 1,
	itemsDesktop : [1199,2],
	itemsDesktopSmall : [980,2],
	itemsTablet: [768,2],
	itemsMobile : [479,1],
	slideSpeed : 3000,
	paginationSpeed : 3000,
	rewindSpeed : 3000,
	navigation : true,
	stopOnHover : true,
	pagination : false,
	scrollPerPage:true
});
/*--
	Active Tab for Product
------------------------*/
$('#producttabs li').on('click',function(){
	var pr_tab = $(this).find("h3").attr('class');
	$( "#producttabs li" ).removeClass( "active" );
	$(this).addClass( "active" );
	$("#producttab-"+pr_tab).slideDown(400).siblings().slideUp(400);
});
/*--
	Blog Slider
------------------------*/
$(".blog-slider").owlCarousel({

	nav:true,
	autoPlay : false,
	items : 3,
	itemsDesktop : [1199,3],
	itemsDesktopSmall : [768,2],
	itemsTablet: [767,1],
	itemsMobile : [479,1],
	slideSpeed : 1000,
	paginationSpeed : 1000,
	rewindSpeed : 1000,
	navigation : true,
	stopOnHover : true,
	pagination : false,
	scrollPerPage:true
});
/*--
	Brand Slider
------------------------*/
$(".brand-slider").owlCarousel({

	autoPlay : false,
	items : 4,
	itemsDesktop : [1199,3],
	itemsDesktopSmall : [980,2],
	itemsTablet: [768,2],
	itemsMobile : [479,2],
	slideSpeed : 4000,
	paginationSpeed : 4000,
	rewindSpeed : 4000,
	navigation : false,
	stopOnHover : true,
	pagination : false,
	scrollPerPage:true
});
/*--
	Active Tab for View Mode
------------------------*/
$('.view-mode a').on('click',function(){
	var v_mode = $(this).attr('class');
	$( ".view-mode a" ).removeClass( "active" );
	$(".view-mode a."+v_mode).addClass( "active" );
});

/*---
	Check Out Accordion
------------------------*/
$(".panel-heading a").on("click", function(){
	$(".panel-heading a").removeClass("active");
	$(this).addClass("active");
});
/*--
	Scroll Up
------------------------*/
$.scrollUp({
	easingType: 'linear',
	scrollSpeed: 900,
	animation: 'fade'
});
/*--
	Price Range Slider
------------------------*/
 $( "#slider-range" ).slider({
	range: true,
	min: 88,
	max: 721,
	values: [ 88, 721 ],
	slide: function( event, ui ) {
		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - "+ "$" + ui.values[ 1 ] );
		$('input[name="first_price"]').val(ui.values[0]);
		$('input[name="last_price"]').val(ui.values[1]);
	},
});
$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
	" - "+"$" + $( "#slider-range" ).slider( "values", 1 ) );
$('input[name="first_price"]').val($( "#slider-range" ).slider( "values", 0 ));
$('input[name="last_price"]').val($( "#slider-range" ).slider( "values", 1 ));
/*--
	Hide Newsletter Popup
------------------------*/
	$("#newsletter-popup-conatiner").mouseup(function(e)
    {
        var popContainer = $("#newsletter-popup-conatiner");
        var newsLatterPop = $("#newsletter-pop-up");
        if(e.target.id != newsLatterPop.attr('id') && !newsLatterPop.has(e.target).length)
        {
            popContainer.fadeOut();
        }
    });
	$('.hide-popup').on("click", function(){
        var popContainer = $("#newsletter-popup-conatiner");
		$('#newsletter-popup-conatiner')
        {
            popContainer.fadeOut();
        }
	});





})(jQuery);

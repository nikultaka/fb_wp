( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */ 
	var WidgetHelloWorldHandler = function( $scope, $ ) {
		console.log( $scope );
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/main-slider.default', WidgetHelloWorldHandler );
	} );
} )( jQuery );


jQuery(document).ready(function($){
	"use strict";
	
	if($('.bxslider').length){
		$('.bxslider').bxSlider({
			auto: true,
			autoControls: true,
			stopAutoOnClick: true,
			pager: false,
			slideWidth: 600
		});
	}
	
	
	/* ---------------------------------------------------------------------- */
	/*	Carousel
	/* ---------------------------------------------------------------------- */
	
	$.fn.council_owl_carousel = function(){
		if(typeof($.fn.owlCarousel) == 'function'){
			$(this).each(function(){
				var option;
				var data_small;
				var data_margin;
				var data_auto;
				if($(this).attr('data-slide')){
					option = $(this).attr('data-slide');
				}
				if($(this).attr('data-small-slide')){
					data_small = $(this).attr('data-small-slide');
				}
				if($(this).attr('data-margin')){
					data_margin = $(this).attr('data-margin');
				}
				if($(this).attr('data-auto')){
					data_auto = $(this).attr('data-auto');
				}
				var owl_attr = {
					//autoPlay: 3000, //Set AutoPlay to 3 seconds
					autoplay:data_auto,
					autoplayTimeout:5000,
					loop:true,
					margin:25,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:data_small
						},
						1000:{
							items:option
						}
					}
				};
				
				$(this).owlCarousel(owl_attr);	
			});	
		}
	}
	
	// runs countdown function
	$.fn.council_slickslider = function(){
		if(typeof($.fn.slick) == 'function'){
			$(this).each(function(){
				
				var slick_attr = {
					dots: true,
					infinite: true,
					adaptiveHeight: true,
					arrows: false,
					autoplay: false,
					autoplaySpeed: 15000,
					slidesToShow: 1,
				};
				
				// data-dots
				if( $(this).attr('data-dots') ){
					slick_attr.dots = parseInt($(this).attr('data-dots'));
				}
				//infinite
				if( $(this).attr('data-loop') ){
					slick_attr.infinite = parseInt($(this).attr('data-loop'));
				}
				//adaptiveHeight
				if( $(this).attr('data-adaptiveHeight') ){
					slick_attr.adaptiveHeight = parseInt($(this).attr('data-adaptiveHeight'));
				}
				//arrows
				if( $(this).attr('data-arrows') ){
					slick_attr.arrows = parseInt($(this).attr('data-arrows'));
				}
				//autoplay
				if( $(this).attr('data-autoplay') ){
					slick_attr.autoplay = parseInt($(this).attr('data-autoplay'));
				}
				//autoplaySpeed
				if( $(this).attr('data-autoplaySpeed') ){
					slick_attr.autoplaySpeed = parseInt($(this).attr('data-autoplaySpeed'));
				}
				//slidesToShow
				if( $(this).attr('data-slidesToShow') ){
					slick_attr.slidesToShow = parseInt($(this).attr('data-slidesToShow'));
				}
				responsive: [
					{
						breakpoint: 768,
						settings: {
							arrows: false,
							autoplay: true,
							autoplaySpeed: 7000,
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							arrows: false,
							dots: false,
							autoplay: true,
							autoplaySpeed: 7000,
							slidesToShow: 1
						}
					}
				];
				$(this).slick(slick_attr);	
				
			});	
		}
	}
	
	
	$(window).load(function(){
		// runs bxslider when available
		$('.slickslider').council_slickslider();
		
		$('.owl-carousel').council_owl_carousel();		
	});
	
	
	if(jQuery('.slider-1x').length){
		jQuery('.slider-1x').slick({
			dots: true,
			infinite: true,
			adaptiveHeight: true,
			arrows: false,
			autoplay: false,
			autoplaySpeed: 15000,
			slidesToShow: 1,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						autoplay: true,
						autoplaySpeed: 7000,
						slidesToShow: 1
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						dots: false,
						autoplay: true,
						autoplaySpeed: 7000,
						slidesToShow: 1
					}
				}
			]
		});
	}


	if(jQuery('.slider-2x').length){
		jQuery('.slider-2x').slick({
			dots: true,
			infinite: true,
			adaptiveHeight: true,
			centerMode: false,
			arrows: false,
			autoplay: false,
			autoplaySpeed: 15000,
			slidesToShow: 1,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						autoplay: true,
						autoplaySpeed: 7000,
						slidesToShow: 1
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						dots: false,
						autoplay: true,
						autoplaySpeed: 7000,
						slidesToShow: 1
					}
				}
			]
		});
	} 
	
	$('[data-search]').on('keyup', function() {
		var searchVal = $(this).val();
		var filterItems = $('[data-filter-item]');

		if ( searchVal != '' ) {
			filterItems.addClass('hidden');
			$('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
		} else {
			filterItems.removeClass('hidden');
		}
	});
	
	
});
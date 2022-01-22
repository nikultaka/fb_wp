jQuery(document).ready(function($){
	"use strict";
	
	// runs countdown function
	$.fn.kode_countdown_label = function(){
		if(typeof($.fn.countdown) == 'function'){
			$(this).each(function(){
				var austDay = new Date();
				var data_year;
				var data_month;
				var data_day;
				var data_time;
				var current_day;
				var data_text_day;
				var data_text_hour;
				var data_text_min;
				var data_text_second;
				var data_text_year;
				var data_text_month;
				var data_text_week;
				
				
				// data-year duration
				if( $(this).attr('data-year') ){
					data_year = parseInt($(this).attr('data-year'));
				}
				if( $(this).attr('data-label-year') ){
					data_text_year = $(this).attr('data-label-year');
				}
				if( $(this).attr('data-label-month') ){
					data_text_month = $(this).attr('data-label-month');
				}
				if( $(this).attr('data-label-week') ){
					data_text_week = $(this).attr('data-label-week');
				}
				if( $(this).attr('data-label-day') ){
					data_text_day = $(this).attr('data-label-day');
				}
				if( $(this).attr('data-label-hour') ){
					data_text_hour = $(this).attr('data-label-hour');
				}
				if( $(this).attr('data-label-min') ){
					data_text_min = $(this).attr('data-label-min');
				}
				if( $(this).attr('data-label-sec') ){
					data_text_second = $(this).attr('data-label-sec');
				}
				//Month
				if( $(this).attr('data-month') ){
					data_month = parseInt($(this).attr('data-month'));
				}
				
				//day
				if( $(this).attr('data-day') ){
					data_day = parseInt($(this).attr('data-day'));
				}
				
				//time
				if( $(this).attr('data-time') ){
					data_time = parseInt($(this).attr('data-time'));
				}
				
						
				current_day = new Date(data_year, data_month-1, data_day,data_time);
				$(this).countdown({until: current_day, 
					labels: [data_text_year, data_text_month, data_text_week, data_text_day, data_text_hour, data_text_min, data_text_second], 
					whichLabels: function(amount) { 
						var units = amount % 10; 
						var tens = Math.floor(amount % 100 / 10); 
						return (amount === 1 ? 1 : 
							(units >=2 && units <= 4 && tens !== 1 ? 2 : 0)); 
					}
				});
				jQuery('#year').text(current_day.getFullYear());
			});	
		}
	}
	
	// runs countdown function
	$.fn.kode_countdown = function(){
		if(typeof($.fn.countdown) == 'function'){
			$(this).each(function(){
				var austDay = new Date();
				var data_year;
				var data_month;
				var data_day;
				var data_time;
				var current_day;
				var data_text_day;
				var data_text_hour;
				var data_text_min;
				var data_text_second;
				
				// data-year duration
				if( $(this).attr('data-year') ){
					data_year = parseInt($(this).attr('data-year'));
				}
				
				//Month
				if( $(this).attr('data-month') ){
					data_month = parseInt($(this).attr('data-month'));
				}
				
				//day
				if( $(this).attr('data-day') ){
					data_day = parseInt($(this).attr('data-day'));
				}
				
				//time
				if( $(this).attr('data-time') ){
					data_time = parseInt($(this).attr('data-time'));
				}
				
						
				current_day = new Date(data_year, data_month-1, data_day,data_time);
				$(this).countdown({until: current_day});	
				jQuery('#year').text(current_day.getFullYear());
			});	
		}
	}
	
	// runs countdown function
	$.fn.kode_countdown_timmer = function(){
		if(typeof($.fn.downCount) == 'function'){
			$(this).each(function(){
				var austDay = new Date();
				var data_year;
				var data_month;
				var data_day;
				var data_time;
				var current_day;
				
				// data-year duration
				if( $(this).attr('data-year') ){
					data_year = parseInt($(this).attr('data-year'));
				}
				//Month
				if( $(this).attr('data-month') ){
					data_month = parseInt($(this).attr('data-month'));
				}
				//day
				if( $(this).attr('data-day') ){
					data_day = parseInt($(this).attr('data-day'));
				}
				//time
				if( $(this).attr('data-time') ){
					data_time = parseInt($(this).attr('data-time'));
				}
				
				var current_day = new Date(data_year, data_month-1, data_day,data_time);
				//$(this).downCount({ date: "'"+data_month+'/'+data_day+'/'+data_year+' '+data_time+"'", offset: +1 });
				$(this).downCount({ date: current_day, offset: +1 });
				
			});	
		}
	}
	

	$('.cart-option .widget_shopping_cart_content').hide();
	 //Header Search Area Function
    $('.cart-option > p ,.cart-option > span').click(function () {
        if ($(this).attr('id') == 'active-btn-shopping') {
            $(this).attr('id', 'no-active-btn-shopping');
            $(this).siblings('.widget_shopping_cart_content').slideUp();
        } else {
            $(this).attr('id', 'active-btn-shopping');
			$(this).siblings('.widget_shopping_cart_content').slideDown();
        }
    });
	
	
	if($(".range").length){
		$(".range").slider();
		$(".range").on("slide", function(slideEvt) {
			$(".range-slider").text(slideEvt.value);
		});
	}

	
	if($('.header_sticky_navvvv').length){
		// grab the initial top offset of the navigation 		
		var stickyNavTop = $('.header_sticky_nav').offset().top;
		// our function that decides weather the navigation bar should have "fixed" css position or not.
		var stickyNav = function(){
			var scrollTop = $(window).scrollTop(); // our current vertical position from the top
			// if we've scrolled more than the navigation, change its position to fixed to stick to top,
			// otherwise change it back to relative
			if (scrollTop > stickyNavTop) { 
				$('.header_sticky_nav').addClass('kf_sticky');
			} else {
				$('.header_sticky_nav').removeClass('kf_sticky'); 
			}
		};
		stickyNav();
		// and run it again every time you scroll
		$(window).scroll(function() {
			stickyNav();
		});
	
	}	
	
	if($('.nav_one_pageeeee').length){
		$('.navigation .menu').singlePageNav({
			offset: 60,
			filter: ':not(.external)',
			updateHash: true,
			beforeStart: function() {
				console.log('begin scrolling');
			},
			onComplete: function() {
				console.log('done scrolling');
			}
		});
	}
	
	// runs bx slider function
	$.fn.kode_bxslider = function(){
		if(typeof($.fn.bxSlider) == 'function'){
			$(this).each(function(){
				var bx_attr = {
					mode: 'fade',
					auto: true,
					controls:true
					// prevText: '<i class="icon-angle-left" ></i>', 
					// nextText: '<i class="icon-angle-right" ></i>',
					// useCSS: false
				};
				
				// slide duration
				if( $(this).attr('data-pausetime') ){
					bx_attr.pause = parseInt($(this).attr('data-pausetime'));
				}
				if( $(this).attr('data-slidespeed') ){
					bx_attr.speed = parseInt($(this).attr('data-slidespeed'));
				}

				// set the attribute for carousel type
				// if( $(this).attr('data-type') == 'carousel' ){
					// bx_attr.move = 1;
					// bx_attr.animation = 'slide';
					
					// if( $(this).closest('.kode-item-no-space').length > 0 ){
						// bx_attr.itemWidth = $(this).width() / parseInt($(this).attr('data-columns'));
						// bx_attr.itemMargin = 0;							
					// }else{
						// bx_attr.itemWidth = (($(this).width() + 30) / parseInt($(this).attr('data-columns'))) - 30;
						// bx_attr.itemMargin = 30;	
					// }		
					
					// if( $(this).attr('data-columns') == "1" ){ bx_attr.smoothHeight = true; }
				// }else{
					// if( $(this).attr('data-effect') ){
						// bx_attr.animation = $(this).attr('data-effect');
					// }
				// }
				// if( $(this).attr('data-columns') ){
					// bx_attr.minItems = parseInt($(this).attr('data-columns'));
					// bx_attr.maxItems = parseInt($(this).attr('data-columns'));	
				// }				
				

				$(this).bxSlider(bx_attr);	
			});				
			
			$(".bx-controls-direction .bx-prev").empty();
			$(".bx-controls-direction .bx-next").empty();
			$(".bx-controls-direction .bx-next").append('<i class="fa fa-angle-right"></i>');
			$(".bx-controls-direction .bx-prev").append('<i class="fa fa-angle-left"></i>');
			
		}
	}
	
	if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || 
		navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || 
		navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || 
		navigator.userAgent.match(/Windows Phone/i) ){ 
		var kode_touch_device = true; 
	}else{ 
		var kode_touch_device = false; 
	}
	
	// retrieve GET variable from url
	$.extend({
	  getUrlVars: function(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
		  hash = hashes[i].split('=');
		  vars.push(hash[0]);
		  vars[hash[0]] = hash[1];
		}
		return vars;
	  },
	  getUrlVar: function(name){
		return $.getUrlVars()[name];
	  }
	});	
	
	// blog - port nav
	function kode_set_item_outer_nav(){
		$('.blog-item-wrapper > .kode-nav-container').each(function(){
			var container = $(this).siblings('.blog-item-holder');
			var child = $(this).children();
			child.css({ 'top':container.position().top, 'bottom':'auto', height: container.height() - 50 });
		});
		$('.portfolio-item-wrapper > .kode-nav-container').each(function(){
			var container = $(this).siblings('.portfolio-item-holder');
			var child = $(this).children();
			child.css({ 'top':container.position().top, 'bottom':'auto', height: container.height() - 40 });
		});		
	}

	
	/* ---------------------------------------------------------------------- */
	/*	Carousel
	/* ---------------------------------------------------------------------- */
	$.fn.kode_owl_carousel = function(){
		if(typeof($.fn.owlCarousel) == 'function'){
			$(this).each(function(){
				var option;
				if($(this).attr('data-slide')){
					option = $(this).attr('data-slide');
				}
				var nice_attr = {
					loop:true,
					margin:25,
					nav:true,
					navText: [
						'<i class="fa fa-angle-left"></i>',
						'<i class="fa fa-angle-right"></i>'
					],
					responsive:{
						0:{
							items:1
						},
						600:{
							items:2
						},
						1000:{
							items:option
						}
					}
				};				
				$(this).owlCarousel(nice_attr);	
			});	
		}
	}
	
	/* ---------------------------------------------------------------------- */
	/*	Nice Scroll
	/* ---------------------------------------------------------------------- */
	$.fn.kode_nicescroll = function(){
		if(typeof($.fn.niceScroll) == 'function'){
			$(this).each(function(){					
				var nice_attr = {
					cursorwidth:'12px',	
					cursorcolor:'#FEB71F',
					cursoropacitymax:0.7,
					boxzoom:true,
					touchbehavior:false,
					cursorborder :'1px solid #FEB71F',
					zindex :999999
				};
				// Nice Scroll Color
				// if($(this).attr('data-color')){
					// nice_attr.cursorcolor = $(this).attr('data-color');
				// }
				$(this).niceScroll(nice_attr);	
			});	
		}
	}
	
	
	// runs flex slider function
	$.fn.kode_flexslider = function(){
		if(typeof($.fn.flexslider) == 'function'){
			$(this).each(function(){
				var flex_attr = {
					animation: 'fade',
					animationLoop: true,
					prevText: '<i class="fa fa-angle-left" ></i>', 
					nextText: '<i class="fa fa-angle-right" ></i>',
					useCSS: false
				};
				
				// slide duration
				if( $(this).attr('data-pausetime') ){
					flex_attr.slideshowSpeed = parseInt($(this).attr('data-pausetime'));
				}
				if( $(this).attr('data-slidespeed') ){
					flex_attr.animationSpeed = parseInt($(this).attr('data-slidespeed'));
				}

				// set the attribute for carousel type
				if( $(this).attr('data-type') == 'carousel' ){
					flex_attr.move = 1;
					flex_attr.animation = 'slide';
					
					if( $(this).closest('.kode-item-no-space').length > 0 ){
						flex_attr.itemWidth = $(this).width() / parseInt($(this).attr('data-columns'));
						flex_attr.itemMargin = 0;							
					}else{
						flex_attr.itemWidth = (($(this).width() + 30) / parseInt($(this).attr('data-columns'))) - 30;
						flex_attr.itemMargin = 30;	
					}		
					
					// if( $(this).attr('data-columns') == "1" ){ flex_attr.smoothHeight = true; }
				}else{
					if( $(this).attr('data-effect') ){
						flex_attr.animation = $(this).attr('data-effect');
					}
				}
				if( $(this).attr('data-columns') ){
					flex_attr.minItems = parseInt($(this).attr('data-columns'));
					flex_attr.maxItems = parseInt($(this).attr('data-columns'));	
				}				
				
				// set the navigation to different area
				if( $(this).attr('data-nav-container') ){
					var flex_parent = $(this).parents('.' + $(this).attr('data-nav-container')).prev('.kode-nav-container');
					
					if( flex_parent.find('.kode-flex-prev').length > 0 || flex_parent.find('.kode-flex-next').length > 0 ){
						flex_attr.controlNav = false;
						flex_attr.directionNav = false;
						flex_attr.start = function(slider){
							flex_parent.find('.kode-flex-next').click(function(){
								slider.flexAnimate(slider.getTarget("next"), true);
							});
							flex_parent.find('.kode-flex-prev').click(function(){
								slider.flexAnimate(slider.getTarget("prev"), true);
							});
							
							kode_set_item_outer_nav();
							$(window).resize(function(){ kode_set_item_outer_nav(); });
						}
					}else{
						flex_attr.controlNav = false;
						flex_attr.controlsContainer = flex_parent.find('.nav-container');	
					}
					
				}

				$(this).flexslider(flex_attr);	
			});	
		}
	}
	
	// runs nivo slider function
	$.fn.kode_nivoslider = function(){
		if(typeof($.fn.nivoSlider) == 'function'){
			$(this).each(function(){
				var nivo_attr = {};
				
				if( $(this).attr('data-pausetime') ){
					nivo_attr.pauseTime = parseInt($(this).attr('data-pausetime'));
				}
				if( $(this).attr('data-slidespeed') ){
					nivo_attr.animSpeed = parseInt($(this).attr('data-slidespeed'));
				}
				if( $(this).attr('data-effect') ){
					nivo_attr.effect = $(this).attr('data-effect');
				}

				$(this).nivoSlider(nivo_attr);	
			});	
		}
	}	
	
	
	$(document).ready(function(){
	
		
	
		// top woocommerce button
		$('.kode-top-woocommerce-wrapper').hover(function(){
			$(this).children('.kode-top-woocommerce').fadeIn(200);
		}, function(){
			$(this).children('.kode-top-woocommerce').fadeOut(200);
		});
	
		
		// script for parallax background
		$('.kode-parallax-wrapper').each(function(){
			if( $(this).hasClass('kode-background-image') ){
				var parallax_section = $(this);
				var parallax_speed = parseFloat(parallax_section.attr('data-bgspeed'));
				if( parallax_speed == 0 || kode_touch_device ) return;
				if( parallax_speed == -1 ){
					parallax_section.css('background-attachment', 'fixed');
					parallax_section.css('background-position', 'center center');
					return;
				}
					
				$(window).scroll(function(){
					// if in area of interest
					if( ( $(window).scrollTop() + $(window).height() > parallax_section.offset().top ) &&
						( $(window).scrollTop() < parallax_section.offset().top + parallax_section.outerHeight() ) ){
						
						var scroll_pos = 0;
						if( $(window).height() > parallax_section.offset().top ){
							scroll_pos = $(window).scrollTop();
						}else{
							scroll_pos = $(window).scrollTop() + $(window).height() - parallax_section.offset().top;
						}
						parallax_section.css('background-position', 'center ' + (-scroll_pos * parallax_speed) + 'px');
					}
				});			
			}else if( $(this).hasClass('kode-background-video') ){
				if(typeof($.fn.mb_YTPlayer) == 'function'){
					$(this).children('.kode-bg-player').mb_YTPlayer();
				}
			}else{
				return;
			}
		});
		
		
		// responsive menu
		if(typeof($.fn.dlmenu) == 'function'){
			$('#kode-responsive-navigation').each(function(){
				$(this).find('.dl-submenu').each(function(){
					if( $(this).siblings('a').attr('href') && $(this).siblings('a').attr('href') != '#' ){
						var parent_nav = $('<li class="menu-item kode-parent-menu"></li>');
						parent_nav.append($(this).siblings('a').clone());
						
						$(this).prepend(parent_nav);
					}
				});
				$(this).dlmenu();
			});
		}	
		
		// gallery thumbnail type
		$('.kode-gallery-thumbnail').each(function(){
			var thumbnail_container = $(this).children('.kode-gallery-thumbnail-container');
		
			$(this).find('.gallery-item').click(function(){
				var selected_slide = thumbnail_container.children('[data-id="' + $(this).attr('data-id') + '"]');
				if(selected_slide.css('display') == 'block') return false;
			
				// check the gallery height
				var image_width = selected_slide.children('img').attr('width');
				var image_ratio = selected_slide.children('img').attr('height') / image_width;
				var temp_height = image_ratio * Math.min(thumbnail_container.width(), image_width);
				
				thumbnail_container.animate({'height': temp_height});
				selected_slide.fadeIn().siblings().hide();
				return false;
			});		

			$(window).resize(function(){ thumbnail_container.css('height', 'auto') });
		});

		
		// image shortcode 
		$('.kode-image-link-shortcode').hover(function(){
			$(this).find('.kode-image-link-overlay').animate({opacity: 0.8}, 150);
			$(this).find('.kode-image-link-icon').animate({opacity: 0}, 150);
		}, function(){
			$(this).find('.kode-image-link-overlay').animate({opacity: 0}, 150);
			$(this).find('.kode-image-link-icon').animate({opacity: 0}, 150);
		});	
		
		
		// animate ux
		// if( !kode_touch_device && ( !$.browser.msie || (parseInt($.browser.version) > 8)) ){
		
			//image ux
			// $('.content-wrapper img').each(function(){
				// if( $(this).closest('.kode-ux, .ls-wp-container, .product, .flexslider, .nivoSlider').length ) return;
				
				// var ux_item = $(this);
				// if( ux_item.offset().top > $(window).scrollTop() + $(window).height() ){
					// ux_item.css({ 'opacity':0 });
				// }else{ return; }
				
				// $(window).scroll(function(){
					// if( $(window).scrollTop() + $(window).height() > ux_item.offset().top + 100 ){
						// ux_item.animate({ 'opacity':1 }, 1200); 
					// }
				// });					
			// });
		
			//item ux
			// $('.kode-ux').each(function(){
				// var ux_item = $(this);
				// if( ux_item.offset().top > $(window).scrollTop() + $(window).height() ){
					// ux_item.css({ 'opacity':0, 'padding-top':20, 'margin-bottom':-20 });
				// }else{ return; }	

				// $(window).scroll(function(){
					// if( $(window).scrollTop() + $(window).height() > ux_item.offset().top + 100 ){
						// ux_item.animate({ 'opacity':1, 'padding-top':0, 'margin-bottom':0 }, 1200);						
					// }
				// });					
			// });
			
		// do not animate on scroll in mobile
				
			// skill bar
			$('.kode-skill-bar-progress').each(function(){
				if($(this).attr('data-percent')){
					$(this).animate({width: $(this).attr('data-percent') + '%'}, 1200, 'easeOutQuart');
				}
			});			
				

		// runs nivoslider when available
		$('.nivoSlider').kode_nivoslider();		
		
		// runs flexslider when available
		$('.flexslider').kode_flexslider();
		
		// runs bxslider when available
		$('.bxslider').kode_bxslider();
		
		/*  Carousel */
		$('.owl-carousel').kode_owl_carousel();
		
		// runs CountDown when available
		$('.countdown').kode_countdown();
		
		// runs CountDown when available
		$('.kode_countdown').kode_countdown_timmer();
		
		// runs CountDown when available
		$('.countdown_label').kode_countdown_label();
		
		
		// runs niceScroll when available
		$('.nicescroll').kode_nicescroll();
	});
	
	$(window).load(function(){

		
	});
	
	
	/* ---------------------------------------------------------------------- */
	/*	Search Function
	/* ---------------------------------------------------------------------- */
	jQuery('.searchform').hide();
	jQuery("a.search-btn").click(function(){
		jQuery('.searchform').hide();
		jQuery(".searchform").fadeToggle();
	});
	jQuery('html').click(function() {
		jQuery(".searchform").fadeOut();
	});
	jQuery('.kd-search').click(function(event){
		event.stopPropagation();
	});
	
	/* ---------------------------------------------------------------------- */
	/*	Scroll to Top
	/* ---------------------------------------------------------------------- */
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#kode-topbtn').fadeIn();
		} else {
			jQuery('#kode-topbtn').fadeOut();
		}
	});
	
	/* ---------------------------------------------------------------------- */
	/*	Click to Trigger an Event
	/* ---------------------------------------------------------------------- */
	jQuery('#kode-topbtn').click(function(){
		jQuery('html, body').animate({scrollTop : 0},1200);
		return false;
	});
	
	if(jQuery('#vmap').length){
		jQuery('#vmap').vectorMap({
			map: 'usa_en',
			enableZoom: false,
			backgroundColor: '#ffffff',
			showTooltip: true,
			selectedColor: '#F37731',
			hoverColor: '#F37731',
			colors: {
				mo: '#C9DFAF',
				fl: '#C9DFAF',
				or: '#C9DFAF'
			},
			onRegionClick: function(event, code, region){
				window.location.href = STATE_DATA.HOME_URL+'/?state='+code;
				event.preventDefault();
			}
		});
	}


});
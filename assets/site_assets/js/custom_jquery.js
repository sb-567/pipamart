(function ($) {
	"use Strict";

	jQuery('.mobile-menu-area nav').meanmenu({
	    meanMenuContainer: '.mobile-menu',
	    meanScreenWidth: "991"
	});

	$(window).scroll(function() {
	if ($(this).scrollTop() >300){  
	    $('.header-sticky').addClass("sticky");
	  }
	  else{
	    $('.header-sticky').removeClass("sticky");
	  }
	});

	$('.rx-parent').on('click', function(){
	    $('.rx-child').slideToggle();
	    $(this).toggleClass('rx-change');
	});
	 
	$(".embed-responsive iframe").addClass("embed-responsive-item");
	$(".carousel-inner .item:first-child").addClass("active");
	//    category heading
	$('.category-heading').on('click', function(){
	    $('.category-menu-list').slideToggle(300);
	});	

	       
	
	/*==================================
	   Owl Carousel Active
	====================================*/   
	$('.one').owlCarousel({
	smartSpeed: 300,
    loop:true,
    margin:1,
    dots: true,
    nav:true,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    responsive:{
        0:{
            items:2,
            nav:true,
        },
        600:{
            items:2,
            nav:true,
        },
        1000:{
            items:3,
            nav:true,
        }
    }
    }); 
    
    
     $('.three').owlCarousel({
    loop:true,
    margin:10,
     autoplay: true,
        autoPlaySpeed: 2000,
        autoPlayTimeout: 2000,
    dots: false,
    nav:true,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:5
        }
        }
    });

	$('.all-product')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 2
			},
			992: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	})     

	 $('.related-products')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 3
			},
			992: {
				items: 4
			},
			1200: {
				items: 5
			}
		}
	})

	 $('.all-list-product')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 2
			},
			1000: {
				items: 2
			}
		}
	})     

	 $('.brand-active')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 3
			},
			450: {
				items: 3
			},
			600: {
				items: 3
			},
			768: {
				items: 5
			},
			991: {
				items: 5
			},
			1000: {
				items: 8
			}
		}
	})

	 $('.our-blog-active').owlCarousel({
		smartSpeed: 300,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 2
			},
			1000: {
				items: 2
			}
		}
	})

	 $('.hot-deal-of-product')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 1
			},
			450: {
				items: 1
			},
			600: {
				items: 2
			},
			768: {
				items: 1
			},
			991: {
				items: 1
			},
			992: {
				items: 2
			}
		}
	})

	 $('.bestseller-product3')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 3,
				slideBy:1
			},
			992: {
				items: 4,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	})

	$('.latest-products')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 3,
				slideBy:1
			},
			992: {
				items: 4,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	})

	$('.top-rated-products')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 3,
				slideBy:1
			},
			992: {
				items: 4,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	})

	 $('.recently-products')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 3,
				slideBy:1
			},
			992: {
				items: 4,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	});
	
  $('.five').owlCarousel({
    loop:true,
    margin:10,
     autoplay: true,
        autoPlaySpeed: 2000,
        autoPlayTimeout: 2000,
    dots: false,
    nav:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:false
        }
    }
})

	$('.product-offers')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 6,
				slideBy:1
			},
			992: {
				items: 8,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	});

	
	
	$('.category-slider')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		rewind:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy:2
			},
			450: {
				items: 2,
				slideBy:2
			},
			600: {
				items: 3,
				slideBy:1
			},
			992: {
				items: 4,
				slideBy:1
			},
			1200: {
				items: 5,
				slideBy:1
			}
		}
	})

	 $('.new-arrival-list-product')
		.on('changed.owl.carousel initialized.owl.carousel', function (event) {
			$(event.target)
				.find('.owl-item').removeClass('last')
				.eq(event.item.index + event.page.size - 1).addClass('last');
		}).owlCarousel({
		smartSpeed: 300,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 2
			},
			992: {
				items: 2
			},
			1200: {
				items: 3
			}
		}
	}) 

	 
	 $('.latest-blog-active').owlCarousel({
		smartSpeed: 300,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2
			},
			450: {
				items: 2
			},
			600: {
				items: 2
			},
			1000: {
				items: 2
			}
		}
	})

	 $('.post-slider').owlCarousel({
		autoplay: true,
		autoplayTimeout: 5000,
		loop: true,
		nav: true,
		navText: ['<i class="ion-arrow-left-b"></i>', '<i class="ion-arrow-right-b"></i>'],
		responsive: {
			0: {
				items: 1
			},
			450: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	})

	 $('.single-product-tab-menu').owlCarousel({
		smartSpeed: 300,
		margin: 10,
		loop: false,
		nav: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 3
			},
			450: {
				items: 4
			},
			600: {
				items: 4
			},
			1000: {
				items: 4
			}
		}
	})

	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
			$this.html(event.strftime('<div class="single-count"><span>%H</span>'+Settings.hour+'</div><div class="single-count"><span>%M</span>'+Settings.minute+'</div><div class="single-count"><span>%S</span>'+Settings.second+'</div>'));
		});
	});

	$('.product-action a,.product-price a,.socil-icon li a,.blog-social-icon li a, ._tooltip').tooltip({
		animated: 'fade',
		placement: 'top',
		container: 'body'
	});

	$.scrollUp({
	    scrollText: '<i class="ion-chevron-up"></i>',
	    easingType: 'linear',
	    scrollSpeed: 900,
	    animation: 'fade'
	});

	/* ---------------------------
		FAQ Accordion Active
	* ---------------------------*/ 
	  $('.panel-heading a').on('click', function() {
	    $('.panel-default').removeClass('active');
	    $(this).parents('.panel-default').addClass('active');
	  });
	  
	/*new WOW().init();*/

	/*==================================
	   All Toggle Active
	====================================*/
	$( '#showlogin' ).on('click', function() {
	    $( '#checkout-login' ).slideToggle(900);
	});    
	$( '#showcoupon' ).on('click', function() {
	    $( '#checkout_coupon' ).slideToggle(600);
	});

	 $( '#cbox' ).on('click', function() {
	    $( '#cbox_info' ).slideToggle(900);
	 });

	 $( '#ship-box' ).on('click', function() {
	    $( '#ship-box-info' ).slideToggle(1000);
	 });

	$(".payment_method_cheque-li").on('click', function(){

	  $(".payment_method_cheque").show(500);
	  $(".payment_method_paypal").hide(500);
	});
	$(".payment_method_paypal-li").on('click', function(){
	  $(".payment_method_paypal").show(500);
	  $(".payment_method_cheque").hide(500);
	});

	if($('#Instafeed').length) {
	    var feed = new Instafeed({
	        get: 'user',
	        userId: 7093388560,
	        accessToken: '7093388560.1677ed0.8e1a27120d5a4e979b1ff122d649a273',
	        target: 'Instafeed',
	        resolution: 'thumbnail',
	        limit: 6,
	        template: '<li><a href="{{link}}" target="_new"><img src="{{image}}" /></a></li>',
	    });
	    feed.run(); 
	}

	// for price filter
	$( "#slider-range" ).slider({
	      range: true,
	      min:  $( "#amount" ).data("min"),
	      max: $( "#amount" ).data("max"),
	      animate:"slow",
	      orientation: "horizontal",
	      values: [ $( "#amount" ).data("min2"), $( "#amount" ).data("max2") ],
	      slide: function( event, ui ) {

	        $( "#amount" ).val( $( "#amount" ).data("currency") +" "+ ui.values[ 0 ] + " - "+$( "#amount" ).data("currency") +" "+ ui.values[1] );

	        $("#price_filter").val(ui.values[0]+"-"+ui.values[1]);

	      }
	    });

	    $( "#amount" ).val( $( "#amount" ).data("currency") +" "+ $( "#slider-range" ).slider( "values", 0 ) +
	      " - "+$( "#amount" ).data("currency") +" "+ $( "#slider-range" ).slider( "values", 1 ) );

	    $("#price_filter").val($( "#slider-range" ).slider( "values", 0 )+"-"+$( "#slider-range" ).slider( "values", 1 ));
        
})(jQuery);
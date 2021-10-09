(function ($) {
	"use Strict";

	/*==================================
	   Slick Slider Active
	====================================*/      
	$('.slide-active').slick({
		vertical: true,
		prevArrow: '<i class="fa fa-angle-left"></i>',
		nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
		slidesToShow: 2,
		responsive: [
			{
			  breakpoint: 1200,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		  ]
	});
	   
	$('.slide-active2').slick({
		rows: 5,
		vertical: false,
		prevArrow: '<i class="fa fa-angle-left"></i>',
		nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
		responsive: [
			{
			  breakpoint: 1200,
			  settings: {
				rows: 5,
			  }
			},
			{
			  breakpoint: 991,
			  settings: {
				rows: 3,
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				rows: 2,
			  }
			}
		  ]
	});
	  
	$('.slide-active3').slick({
		slidesToShow: 3,
		vertical: true,
		prevArrow: '<i class="fa fa-angle-left"></i>',
		nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
		responsive: [
			{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		  ]
	});
	  
	$('.slide-active-home-2').slick({
		slidesToShow: 1,
		prevArrow: '<i class="fa fa-angle-left"></i>',
		nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
	});
	
})(jQuery);
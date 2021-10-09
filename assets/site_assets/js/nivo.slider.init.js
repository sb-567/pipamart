(function ($) {
	"use Strict";

	$('#slider').nivoSlider({
		manualAdvance:false,
		directionNav: false,
		controlNav: false,
		effect: 'random',
		slices: 18,
		pauseTime: 4000,
		controlNav: true,
		pauseOnHover: false,
		prevText: '<i class="ion-chevron-left"></i>', 
		nextText: '<i class="ion-chevron-right"></i>',
	});
})(jQuery);
$(document).ready(function() {
	
	/* scroll */
	
	$("a[href^='#']").click(function(){
		var _href = $(this).attr("href");
		$("html, body").animate({scrollTop: $(_href).offset().top+"px"});
		return false;
	});
});

$(window).on("load", function(){

	$(".owl-carousel").owlCarousel({
		items: 1,
		loop: true,
		autoHeight: true,
		smartSpeed: 300,
		mouseDrag: false,
		pullDrag: false,
		nav: true,
		navText: ""
	});
	
});
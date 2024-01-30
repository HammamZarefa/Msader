(function ($) {
	"use strict";

		/*=============================================
	=    		 	product set price		      =
=============================================*/
	$(".btn-order").on('click', function () {
        var categoryId = $(this).data('category-id');

        $.ajax({
            type: 'GET',
            url: 'services/'+categoryId, // Update the route to your actual route
            success: function(response) {
                // Assuming that the response is HTML, update the products section
                $("#show-orders").html(response);
                $('#btn-hide-order').addClass("show");
                $("#show-products").hide(500);
                $("#show-orders").show(500);
            },
            error: function(error) {
                console.log(error);
            }
        });
	});
	//
	$("#btn-hide-order").on('click', function () {
		$('#btn-hide-order').removeClass("show");
		$("#show-orders").hide(500);
		$("#show-products").show(500);
	});
	$(".order-form .btn-form-order").on("click", function(event){
		event.preventDefault();
		setTimeout(() => {
		$(this).parent().parent().parent().parent().parent().children('.water').addClass("active");
		$(this).addClass("disabel");
	}, 500);
	setTimeout(() => {
		$(this).parent().parent().parent().parent().parent().children('.water').removeClass("active");
		$(this).removeClass("disabel");
		$('.alert-success').show(1000);
		setTimeout(() => {
			$('.alert-success').hide(1000)
		}, 5000);
	}, 8000);

	});
	$(".orders-item .bid").on("click", function(){
		$(".orders-item .bid").not(this).parent().parent().parent().parent().parent().parent().parent().hide("slow");
		setTimeout(() => {
		$(this).parent().parent().parent().parent().parent().parent().parent().removeAttr('class');
	 	$(this).parent().parent().parent().parent().parent().parent().parent().addClass("orders-item");
	  	$(this).parent().parent().parent().parent().parent().parent().parent().addClass("col-12");
	  	$(this).parent().parent().parent().parent().parent().parent().parent().addClass("col-sm-6");
		}, 500);
	});
	$(".orders-item .Prev").on("click", function(){
	  $(".orders-item .water").removeClass("active");
	  $(".orders-item .bid").not(this).parent().parent().parent().parent().parent().parent().parent().show("slow");
	  $(this).parent().parent().parent().parent().parent().parent().parent().removeAttr('class');
	  $(this).parent().parent().parent().parent().parent().parent().parent().addClass("orders-item");
	  $(this).parent().parent().parent().parent().parent().parent().parent().addClass("col-sm-6");
	  $(this).parent().parent().parent().parent().parent().parent().parent().addClass("col-lg-4");
	  $(this).parent().parent().parent().parent().parent().parent().parent().addClass("col-xl-3");
	});
	$(".order-form .qty").on("input", function(){
		var value_qty = $(this).val();
		const old_price = $(this).parent().parent().parent().find('.main-price').data('price');
		$(this).parent().parent().parent().find('.main-price').html()
		$(this).parent().parent().parent().parent().find('.main-price').html((old_price * value_qty).toFixed(3));

	  });
	/*=============================================
	=    		 	video-btn		      =
=============================================*/
$("#video-btn-element").on('click', function () {
	$("#video-target").attr("controls","1");
	$("#video-target").attr("autoplay","1");
	$(this).hide(500);
	$('#video-target').on('ended',function(){
		$('#video-btn-element').show(500);
		$("#video-target").removeAttr("controls");
		$("#video-target").removeAttr("autoplay");

	  });
  });
/*=============================================
	=    		 sidebar			      =
=============================================*/
	$("#sidebar").hover(function(){
		$("#sidebar").addClass( "open" );
		$(".overlay").addClass( "open" );
	  });

	  $(".overlay").hover(function(){

		$("#sidebar").removeClass( "open" );
		$(".overlay").removeClass( "open" );
	  });

/*=============================================
	=    		 Preloader			      =
=============================================*/
function preloader() {
	$('#preloader').delay(0).fadeOut();
};

$(window).on('load', function () {
	preloader();
	wowAnimation();
});



/*=============================================
	=    		Mobile Menu			      =
=============================================*/
//SubMenu Dropdown Toggle
if ($('.menu-area li.menu-item-has-children ul').length) {
	$('.menu-area .navigation li.menu-item-has-children').append('<div class="dropdown-btn"><span class="fas fa-angle-down"></span></div>');

}

//Mobile Nav Hide Show
if ($('.mobile-menu').length) {

	var mobileMenuContent = $('.menu-area .main-menu').html();
	$('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);

	//Dropdown Button
	$('.mobile-menu li.menu-item-has-children .dropdown-btn').on('click', function () {
		$(this).toggleClass('open');
		$(this).prev('ul').slideToggle(500);
	});
	//Menu Toggle Btn
	$('.mobile-nav-toggler').on('click', function () {
		$('body').addClass('mobile-menu-visible');
	});

	//Menu Toggle Btn
	$('.menu-backdrop, .mobile-menu .close-btn').on('click', function () {
		$('body').removeClass('mobile-menu-visible');
	});
}


/*=============================================
	=     Menu sticky & Scroll to top      =
=============================================*/
$(window).on('scroll', function () {
	var scroll = $(window).scrollTop();
	if (scroll < 245) {
		$("#sticky-header").removeClass("sticky-menu");
		$('.scroll-to-target').removeClass('open');

	} else {
		$("#sticky-header").addClass("sticky-menu");
		$('.scroll-to-target').addClass('open');
	}
});


/*=============================================
	=    		 Scroll Up  	         =
=============================================*/
if ($('.scroll-to-target').length) {
  $(".scroll-to-target").on('click', function () {
    var target = $(this).attr('data-target');
    // animate
    $('html, body').animate({
      scrollTop: $(target).offset().top
    }, 1000);

  });
}


/*=============================================
	=            Custom Scroll            =
=============================================*/
$(window).on("load", function () {
	if ($(".scroll").length) {
		$(".scroll").mCustomScrollbar({
			mouseWheelPixels: 50,
			scrollInertia: 0,
		});
	}
});
$('.activity-table-responsive').mCustomScrollbar({
	axis: "x",
	scrollbarPosition: "outside",
	theme: "custom-bar2",
	advanced: {
		autoExpandHorizontalScroll: true
	}
});

/*=============================================
=     Offcanvas Menu      =
=============================================*/
$(".menu-trigger").on("click", function () {
	$(".offcanvas-wrapper,.offcanvas-overly").addClass("active");
	return false;
});
$(".menu-close,.offcanvas-overly").on("click", function () {
	$(".offcanvas-wrapper,.offcanvas-overly").removeClass("active");
});


/*=============================================
=           Features - Active                 =
=============================================*/
$('.filter-toggle').on('click', function () {
	$('.filter-category-wrap').slideToggle(300);
	return false;
});


/*=============================================
=           Full Screen - Active         =
=============================================*/
function toggleFullscreen(elem) {
	elem = elem || document.documentElement;
	if (!document.fullscreenElement && !document.mozFullScreenElement &&
		!document.webkitFullscreenElement && !document.msFullscreenElement) {
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.msRequestFullscreen) {
			elem.msRequestFullscreen();
		} else if (elem.mozRequestFullScreen) {
			elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
			elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}
}

/*=============================================
	=    		Collection Active		   =
=============================================*/
$('.top-collection-active').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: false,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="fi-sr-arrow-left"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="fi-sr-arrow-right"></i></button>',
	appendArrows: ".top-collection-nav",
	slidesToShow: 4,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});


/*=============================================
	=    		Testimonial Active		      =
=============================================*/
$('.testimonial-active').slick({
	dots: true,
	infinite: true,
	speed: 1000,
	autoplay: false,
	arrows: false,
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});


/*=============================================
	=    		Creator Active		      =
=============================================*/
$('.creator-active').slick({
	dots: true,
	infinite: true,
	speed: 1000,
	autoplay: false,
	arrows: false,
	slidesToShow: 6,
	slidesToScroll: 2,
	responsive: [
		{
			breakpoint: 1500,
			settings: {
				slidesToShow: 5,
				slidesToScroll: 2,
				infinite: true,
			}
		},
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 3
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});

/*=============================================
	=           sidebar Active         =
=============================================*/
$('.sidebar-active').slick({
	dots: true,
	infinite: true,
	speed: 1000,
	autoplay: false,
	arrows: false,
	fade: true,
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1500,
			settings: {
				slidesToShow: 1,
				infinite: true,
			}
		},
	]
});


/*=============================================
	=    	  Countdown Active  	         =
=============================================*/
$('[data-countdown]').each(function () {
	var $this = $(this), finalDate = $(this).data('countdown');
	$this.countdown(finalDate, function (event) {
		$this.html(event.strftime('<div class="time-count day"><span>%D</span><span>Day</span></div><div class="time-count hour"><span>%H</span><span>Hours</span></div><div class="time-count min"><span>%M</span><span>Minute</span></div><div class="time-count sec"><span>%S</span><span>Second</span></div>'));
	});
});


/*=============================================
	=    		Magnific Popup		      =
=============================================*/
$('.popup-image').magnificPopup({
	type: 'image',
	gallery: {
		enabled: true
	}
});

/* magnificPopup video view */
$('.popup-video').magnificPopup({
	type: 'iframe'
});


/*=============================================
	=    		Isotope	Active  	      =
=============================================*/
$('.features-img-wrap').imagesLoaded(function () {
	// init Isotope
	var $grid = $('.features-img-wrap').isotope({
		itemSelector: '.grid-item',
		percentPosition: true,
		masonry: {
			columnWidth: 1,
		}
	});
	// filter items on button click
	$('.portfolio-menu').on('click', 'button', function () {
		var filterValue = $(this).attr('data-filter');
		$grid.isotope({ filter: filterValue });
	});

});


/*=============================================
	=    		 Wow Active  	         =
=============================================*/
function wowAnimation() {
	var wow = new WOW({
		boxClass: 'wow',
		animateClass: 'animated',
		offset: 0,
		mobile: false,
		live: true
	});
	wow.init();
}


})(jQuery);

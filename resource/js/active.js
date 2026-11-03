(function($) {
    "use strict";

    $(document).on('ready', function() {	
		
		// Menu Click JS
		$(".menu-click .penbird-menu-toggle, .close-menu button").on("click", function (e) {
			e.preventDefault();
			var $inner = $(".menu-inner");
			var isOpen = !$inner.hasClass("active");
			$inner.toggleClass("active", isOpen);
			$(".penbird-menu-toggle").attr("aria-expanded", isOpen ? "true" : "false");
			if (isOpen) {
				$(".close-menu button").trigger("focus");
			} else {
				$(".penbird-menu-toggle").trigger("focus");
			}
		});

		// Search Form JS
		$(".penbird-search-icon, .penbird-search-close").on("click", function (e) {
			e.preventDefault();
			var $form = $(".search-form-main");
			var isOpen = !$form.hasClass("active");
			$form.toggleClass("active", isOpen).attr("aria-hidden", isOpen ? "false" : "true");
			$(".penbird-search-icon").attr("aria-expanded", isOpen ? "true" : "false");
			if (isOpen) {
				$form.find('input[type="search"]').trigger("focus");
			} else {
				$(".penbird-search-icon").trigger("focus");
			}
		});

		$(document).on("keydown", function (e) {
			if ("Escape" !== e.key && 27 !== e.keyCode) {
				return;
			}
			if ($(".search-form-main").hasClass("active")) {
				$(".search-form-main").removeClass("active").attr("aria-hidden", "true");
				$(".penbird-search-icon").attr("aria-expanded", "false").trigger("focus");
			}
			if ($(".menu-inner").hasClass("active")) {
				$(".menu-inner").removeClass("active");
				$(".penbird-menu-toggle").attr("aria-expanded", "false").trigger("focus");
			}
		});
	});	
	
	
	jQuery(window).on('load', function() {
	    // init Masonry
		var $grid = $('.penbird-masonry').masonry({
			// options
			itemSelector: '.penbird-masonry-item',
		});
		// layout Masonry after each image loads
		$grid.imagesLoaded().progress( function() {
			$grid.masonry('layout');
		});
	});

	$('.penbird-product-rating').each(function () {
      var review = $(this).data('rating');
      var reviewVal = review * 20 + '%';
      $(this).find('.penbird-product-rating_percentage').css('width', reviewVal);
    });

	$('.penbird-ptabs .penbird-ptabs__nav  a').on('click', function (e) {
	var currentAttrValue = $(this).attr('href');
	$('.penbird-ptabs ' + currentAttrValue)
		.fadeIn(400)
		.siblings()
		.hide();
	$(this).parents('li').addClass('active').siblings().removeClass('active');
	e.preventDefault();
	});


	
	
})(jQuery);



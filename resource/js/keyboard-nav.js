(function ($) {
	"use strict";

	jQuery(document).ready(function () {
		$("#primary-menu, .penbird-header__button").KeyboardAccessibleDropDown();
	});

	$.fn.KeyboardAccessibleDropDown = function () {
		var nav = $(this);
		$("a, .penbird-header__button--icon", nav)
			.focus(function () {
				$(this).parents("li, .penbird-header__button").addClass("active-focus");
			})
			.blur(function () {
				$(this).parents("li, .penbird-header__button").removeClass("active-focus");
			});
	};
})(jQuery);

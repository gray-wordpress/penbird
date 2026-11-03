/**
 * File customizer.js.
 *
 * Live preview against the real PenBird frontend.
 */

(function ($) {
	function setVar(name, value) {
		document.documentElement.style.setProperty(name, value);
	}

	function fontStack(key) {
		if (window.penbirdCustomizePreview && penbirdCustomizePreview.fonts && penbirdCustomizePreview.fonts[key]) {
			return penbirdCustomizePreview.fonts[key];
		}
		return "'Inter', sans-serif";
	}

	wp.customize("blogname", function (value) {
		value.bind(function (to) {
			$(".site-title a, .penbird-logo .normal-text a").text(to);
		});
	});

	wp.customize("blogdescription", function (value) {
		value.bind(function (to) {
			$(".site-description").text(to);
		});
	});

	wp.customize("header_textcolor", function (value) {
		value.bind(function (to) {
			if ("blank" === to) {
				$(".penbird-logo .normal-text a, .penbird-logo .site-description").css({
					clip: "rect(1px, 1px, 1px, 1px)",
					position: "absolute",
				});
			} else {
				$(".penbird-logo .normal-text a, .penbird-logo .site-description").css({
					clip: "auto",
					position: "relative",
				});
				$(".penbird-logo .normal-text a, .penbird-logo .site-description").css({
					color: to,
				});
			}
		});
	});

	wp.customize("penbird_logo_width", function (value) {
		value.bind(function (to) {
			setVar("--penbird-logo-width", parseInt(to, 10) + "px");
		});
	});

	function setHeaderClass(prefix, value, allowed) {
		var $header = $(".penbird-header");
		allowed.forEach(function (item) {
			$header.removeClass(prefix + item);
		});
		$header.addClass(prefix + value);
	}

	wp.customize("penbird_header_layout", function (value) {
		value.bind(function (to) {
			setHeaderClass("penbird-header--", to, ["logo-menu", "centered", "split"]);
		});
	});

	wp.customize("penbird_header_width", function (value) {
		value.bind(function (to) {
			var $inner = $(".penbird-header .penbird-header__container");
			setHeaderClass("penbird-header--width-", to, ["boxed", "full"]);
			$inner.removeClass("container container-fluid");
			$inner.addClass(to === "full" ? "container-fluid" : "container");
		});
	});

	wp.customize("penbird_header_logo_position", function (value) {
		value.bind(function (to) {
			setHeaderClass("penbird-header--logo-", to, ["left", "center", "right"]);
		});
	});

	wp.customize("penbird_header_menu_align", function (value) {
		value.bind(function (to) {
			setHeaderClass("penbird-header--menu-", to, ["left", "center", "right"]);
		});
	});

	wp.customize("penbird_search_enable", function (value) {
		value.bind(function (to) {
			$(".penbird-header").toggleClass("penbird-header--no-search", !to);
			if (!to) {
				$(".search-form-main").removeClass("active").attr("aria-hidden", "true");
				$(".penbird-search-icon").attr("aria-expanded", "false");
			}
		});
	});

	wp.customize("penbird_header_cart", function (value) {
		value.bind(function (to) {
			$(".penbird-header").toggleClass("penbird-header--no-cart", !to);
		});
	});

	wp.customize("penbird_header_sticky", function (value) {
		value.bind(function (to) {
			$(".penbird-header").toggleClass("penbird-header--sticky", !!to);
		});
	});

	wp.customize("penbird_header_bg", function (value) {
		value.bind(function (to) {
			setVar("--penbird-header-bg", to);
		});
	});

	wp.customize("penbird_header_color", function (value) {
		value.bind(function (to) {
			setVar("--penbird-header-color", to);
		});
	});

	wp.customize("penbird_header_padding", function (value) {
		value.bind(function (to) {
			setVar("--penbird-header-padding", parseInt(to, 10) + "px");
		});
	});

	wp.customize("penbird_footer_bg", function (value) {
		value.bind(function (to) {
			setVar("--penbird-footer-top-bg", to);
		});
	});

	wp.customize("penbird_footer_alignment", function (value) {
		value.bind(function (to) {
			$("body")
				.removeClass("penbird-footer-align-left penbird-footer-align-center penbird-footer-align-right")
				.addClass("penbird-footer-align-" + to);
		});
	});

	wp.customize("penbird_body_font", function (value) {
		value.bind(function (to) {
			setVar("--penbird-font-body", fontStack(to));
		});
	});

	wp.customize("penbird_heading_font", function (value) {
		value.bind(function (to) {
			setVar("--penbird-font-heading", fontStack(to));
		});
	});

	wp.customize("penbird_body_font_size", function (value) {
		value.bind(function (to) {
			setVar("--penbird-font-size", parseInt(to, 10) + "px");
		});
	});

	wp.customize("penbird_body_font_weight", function (value) {
		value.bind(function (to) {
			setVar("--penbird-font-weight", to);
		});
	});

	wp.customize("penbird_heading_font_weight", function (value) {
		value.bind(function (to) {
			setVar("--penbird-heading-weight", to);
		});
	});

	wp.customize("penbird_primary_color", function (value) {
		value.bind(function (to) {
			setVar("--penbird-primary", to);
		});
	});

	wp.customize("penbird_secondary_color", function (value) {
		value.bind(function (to) {
			setVar("--penbird-heading", to);
		});
	});

	wp.customize("penbird_text_color", function (value) {
		value.bind(function (to) {
			setVar("--penbird-text", to);
		});
	});

	wp.customize("penbird_container_width", function (value) {
		value.bind(function (to) {
			setVar("--penbird-container-width", parseInt(to, 10) + "px");
		});
	});

	wp.customize("penbird_content_width", function (value) {
		value.bind(function (to) {
			setVar("--penbird-content-width", parseInt(to, 10) + "px");
		});
	});

	wp.customize("penbird_container_layout", function (value) {
		value.bind(function (to) {
			$("body")
				.removeClass("penbird-layout-boxed penbird-layout-narrow penbird-layout-full")
				.addClass("penbird-layout-" + to);
		});
	});
})(jQuery);

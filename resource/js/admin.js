/**
 * PenBird dashboard tabs.
 */
(function () {
	"use strict";

	function qs(sel, ctx) {
		return (ctx || document).querySelector(sel);
	}

	function qsa(sel, ctx) {
		return Array.prototype.slice.call((ctx || document).querySelectorAll(sel));
	}

	function activate(root, tabId) {
		var tabs = qsa(".penbird-dashboard__tab", root);
		var panels = qsa(".penbird-dashboard__panel", root);
		var found = false;

		tabs.forEach(function (tab) {
			var on = tab.getAttribute("data-tab") === tabId;
			tab.classList.toggle("is-active", on);
			tab.setAttribute("aria-selected", on ? "true" : "false");
			tab.tabIndex = on ? 0 : -1;
			if (on) {
				found = true;
			}
		});

		if (!found) {
			return;
		}

		panels.forEach(function (panel) {
			var on = panel.id === "penbird-panel-" + tabId;
			panel.classList.toggle("is-active", on);
			if (on) {
				panel.removeAttribute("hidden");
			} else {
				panel.setAttribute("hidden", "hidden");
			}
		});
	}

	document.addEventListener("DOMContentLoaded", function () {
		var root = qs(".penbird-dashboard");
		if (!root) {
			return;
		}

		var tabs = qsa(".penbird-dashboard__tab", root);
		var allowed = { welcome: true, start: true, pro: true, docs: true };
		var hash = (window.location.hash || "#welcome").replace("#", "");
		if (!allowed[hash]) {
			hash = "welcome";
		}
		activate(root, hash);

		root.addEventListener("click", function (event) {
			var tab = event.target.closest(".penbird-dashboard__tab");
			if (!tab || !root.contains(tab)) {
				return;
			}
			var id = tab.getAttribute("data-tab");
			activate(root, id);
			if (history.replaceState) {
				history.replaceState(null, "", "#" + id);
			}
		});

		root.addEventListener("keydown", function (event) {
			var current = document.activeElement;
			if (!current || !current.classList.contains("penbird-dashboard__tab")) {
				return;
			}
			var index = tabs.indexOf(current);
			var next = index;
			if (event.key === "ArrowRight") {
				next = (index + 1) % tabs.length;
			} else if (event.key === "ArrowLeft") {
				next = (index - 1 + tabs.length) % tabs.length;
			} else if (event.key === "Home") {
				next = 0;
			} else if (event.key === "End") {
				next = tabs.length - 1;
			} else {
				return;
			}
			event.preventDefault();
			tabs[next].focus();
			tabs[next].click();
		});
	});
})();

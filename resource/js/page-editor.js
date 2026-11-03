/**
 * PenBird page settings plugin sidebar (block editor).
 */
(function (wp) {
	"use strict";

	if (!wp || !wp.plugins || !wp.element || !wp.data) {
		return;
	}

	var el = wp.element.createElement;
	var useEffect = wp.element.useEffect;
	var registerPlugin = wp.plugins.registerPlugin;
	var useSelect = wp.data.useSelect;
	var useDispatch = wp.data.useDispatch;
	var ToggleControl = wp.components && wp.components.ToggleControl ? wp.components.ToggleControl : null;
	var PanelBody = wp.components && wp.components.PanelBody ? wp.components.PanelBody : null;
	var pluginApi = wp.editor && wp.editor.PluginSidebar ? wp.editor : wp.editPost;
	var PluginSidebar = pluginApi && pluginApi.PluginSidebar ? pluginApi.PluginSidebar : null;
	var config = window.penbirdPageEditor || {};
	var __ = wp.i18n && wp.i18n.__ ? wp.i18n.__ : function (s) { return s; };
	var SIDEBAR_ID = "penbird-page-settings/penbird-page-settings";

	if (!PluginSidebar || !registerPlugin) {
		return;
	}

	function penbirdIcon() {
		return el(
			"svg",
			{
				xmlns: "http://www.w3.org/2000/svg",
				viewBox: "0 0 24 24",
				width: 24,
				height: 24,
				"aria-hidden": true,
				focusable: "false",
			},
			el("rect", { width: 24, height: 24, rx: 5, fill: "#0A2540" }),
			el("path", {
				fill: "#fff",
				d: "M8 6.5h5.2c2.4 0 3.8 1.4 3.8 3.5 0 2.2-1.5 3.6-3.9 3.6H10.4V17.5H8V6.5zm2.4 5.2h2.6c1.1 0 1.7-.6 1.7-1.6s-.6-1.6-1.7-1.6h-2.6v3.2z",
			}),
			el("circle", { cx: 18.2, cy: 6.2, r: 1.6, fill: "#605BE5" })
		);
	}

	var logoIcon = penbirdIcon();

	function getMeta(meta, key, fallback) {
		if (meta && typeof meta[key] !== "undefined" && meta[key] !== null && meta[key] !== "") {
			return meta[key];
		}
		return fallback;
	}

	function VisualRadios(props) {
		var choices = props.choices || {};
		var icons = props.icons || {};
		var current = props.value;
		var keys = Object.keys(choices);

		return el(
			"div",
			{ className: "penbird-visual-radio penbird-visual-radio--cols-2", role: "radiogroup" },
			keys.map(function (value) {
				var inputId = props.name + "-" + value;
				return el(
					"label",
					{ className: "penbird-visual-radio__option", htmlFor: inputId, key: value },
					el("input", {
						id: inputId,
						className: "penbird-visual-radio__input",
						type: "radio",
						name: props.name,
						value: value,
						checked: current === value,
						onChange: function () {
							props.onChange(value);
						},
					}),
					el(
						"span",
						{ className: "penbird-visual-radio__card" },
						icons[value]
							? el("span", {
									className: "penbird-visual-radio__icon",
									"aria-hidden": true,
									dangerouslySetInnerHTML: { __html: icons[value] },
							  })
							: null,
						el("span", { className: "penbird-visual-radio__text" }, choices[value])
					)
				);
			})
		);
	}

	function wrapSection(title, children) {
		if (PanelBody) {
			return el(PanelBody, { title: title, initialOpen: true }, children);
		}
		return el(
			"div",
			{ className: "penbird-metabox__field" },
			el("span", { className: "penbird-metabox__label" }, title),
			children
		);
	}

	function PenBirdPageSettingsPanel() {
		var meta = useSelect(function (select) {
			return select("core/editor").getEditedPostAttribute("meta") || {};
		}, []);
		var postType = useSelect(function (select) {
			return select("core/editor").getCurrentPostType();
		}, []);
		var editPost = useDispatch("core/editor").editPost;

		useEffect(function () {
			var iface = wp.data.dispatch("core/interface");
			if (iface && typeof iface.pinItem === "function") {
				iface.pinItem("core", SIDEBAR_ID);
			}
		}, []);

		if (postType && postType !== "page") {
			return null;
		}

		function setMeta(key, value) {
			var next = {};
			next[key] = value;
			editPost({ meta: Object.assign({}, meta, next) });
		}

		var container = getMeta(meta, "_penbird_container", "default");
		var sidebar = getMeta(meta, "_penbird_sidebar", "default");

		return el(
			PluginSidebar,
			{
				name: "penbird-page-settings",
				title: __("PenBird", "Penbird"),
				icon: logoIcon,
				className: "penbird-page-sidebar",
				isPinnable: true,
			},
			el(
				"div",
				{ className: "penbird-metabox penbird-editor-sidebar" },
				el(
					"p",
					{ className: "penbird-metabox__intro" },
					__("Default uses the matching Customizer Theme Setting. Any other value applies only to this page.", "Penbird")
				),
				wrapSection(__("Container / Layout", "Penbird"), [
					el("p", { className: "penbird-metabox__help", key: "container-help" }, config.containerHelp || ""),
					el(VisualRadios, {
						key: "container-radios",
						name: "penbird_page_container",
						value: container,
						choices: config.containerChoices || {},
						icons: config.containerIcons || {},
						onChange: function (value) {
							setMeta("_penbird_container", value);
						},
					}),
				]),
				wrapSection(__("Sidebar", "Penbird"), [
					el("p", { className: "penbird-metabox__help", key: "sidebar-help" }, config.sidebarHelp || ""),
					el(VisualRadios, {
						key: "sidebar-radios",
						name: "penbird_page_sidebar",
						value: sidebar,
						choices: config.sidebarChoices || {},
						icons: config.sidebarIcons || {},
						onChange: function (value) {
							setMeta("_penbird_sidebar", value);
						},
					}),
				]),
				wrapSection(
					__("Disable Elements", "Penbird"),
					ToggleControl
						? [
								el(ToggleControl, {
									key: "disable-header",
									label: __("Disable Header", "Penbird"),
									checked: !!getMeta(meta, "_penbird_disable_header", false),
									onChange: function (value) {
										setMeta("_penbird_disable_header", !!value);
									},
								}),
								el(ToggleControl, {
									key: "disable-footer",
									label: __("Disable Footer", "Penbird"),
									checked: !!getMeta(meta, "_penbird_disable_footer", false),
									onChange: function (value) {
										setMeta("_penbird_disable_footer", !!value);
									},
								}),
								el(ToggleControl, {
									key: "disable-title",
									label: __("Disable Page Title", "Penbird"),
									checked: !!getMeta(meta, "_penbird_disable_title", false),
									onChange: function (value) {
										setMeta("_penbird_disable_title", !!value);
									},
								}),
								el(ToggleControl, {
									key: "disable-breadcrumb",
									label: __("Disable Breadcrumbs", "Penbird"),
									checked: !!getMeta(meta, "_penbird_disable_breadcrumb", false),
									onChange: function (value) {
										setMeta("_penbird_disable_breadcrumb", !!value);
									},
								}),
						  ]
						: null
				)
			)
		);
	}

	registerPlugin("penbird-page-settings", {
		icon: logoIcon,
		render: PenBirdPageSettingsPanel,
	});
})(window.wp);

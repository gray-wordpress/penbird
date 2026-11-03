/**
 * PenBird Customizer controls and nested sections.
 *
 * Core Customizer is Panel → Section → Controls. Nested sections are moved
 * into the parent section pane, then moved again after pane-contents-reflowed
 * because core re-appends every section back into the panel.
 */
(function (api, $) {
	"use strict";

	if (!api) {
		return;
	}

	if (api.controlConstructor) {
		api.controlConstructor.penbird_visual_radio = api.Control.extend({
			ready: function () {
				var control = this;
				this.container.on("change", ".penbird-visual-radio__input", function () {
					control.setting.set($(this).val());
				});
			},
		});

		api.controlConstructor.penbird_toggle = api.Control.extend({
			ready: function () {
				var control = this;
				this.container.on("change", ".penbird-toggle__input", function () {
					control.setting.set($(this).prop("checked"));
				});
			},
		});
	}

	if (!api.Section || !api.sectionConstructor) {
		return;
	}

	api.sectionConstructor.penbird_section = api.Section.extend({
		attachEvents: function () {
			var section = this;

			api.Section.prototype.attachEvents.call(section);

			if (!section.params.section) {
				return;
			}

			section.expanded.bind(function (expanded) {
				var parent = api.section(section.params.section);
				if (!parent) {
					return;
				}
				if (expanded) {
					parent.contentContainer.addClass("current-section-parent");
				} else {
					parent.contentContainer.removeClass("current-section-parent");
				}
			});

			section.container
				.find(".customize-section-back")
				.off("click keydown")
				.on("click keydown", function (event) {
					if (api.utils.isKeydownButNotEnterEvent(event)) {
						return;
					}
					event.preventDefault();
					if (section.expanded()) {
						api.section(section.params.section).expand();
					}
				});
		},

		embed: function () {
			var section = this;
			var parentId = section.params && section.params.section;

			api.Section.prototype.embed.call(section);

			if (!parentId) {
				return;
			}

			api.section(parentId, function (parent) {
				parent.deferred.embedded.done(function () {
					section.headContainer.addClass("control-subsection");
					parent.contentContainer.append(section.headContainer);
				});
			});
		},

		isContextuallyActive: function () {
			var section = this;
			var activeCount = 0;

			api.control.each(function (control) {
				if (control.params.section === section.id && control.active()) {
					activeCount += 1;
				}
			});

			api.section.each(function (child) {
				if (
					child.params.section === section.id &&
					child.active() &&
					child.isContextuallyActive()
				) {
					activeCount += 1;
				}
			});

			return activeCount !== 0;
		},
	});

	function penbirdNestChildSections() {
		var sections = [];

		api.section.each(function (section) {
			if ("penbird_section" !== section.params.type || !section.params.section) {
				return;
			}
			sections.push(section);
		});

		sections.sort(api.utils.prioritySort).reverse();

		$.each(sections, function (i, section) {
			var parent = api.section(section.params.section);
			var parentContainer;

			if (!parent || !parent.contentContainer) {
				return;
			}

			parentContainer = parent.contentContainer.is("ul")
				? parent.contentContainer
				: parent.contentContainer.find("ul:first");

			section.headContainer.addClass("control-subsection");

			if (parentContainer.children(".section-meta").length) {
				parentContainer.children(".section-meta").after(section.headContainer);
			} else {
				parentContainer.append(section.headContainer);
			}
		});
	}

	api.bind("ready", penbirdNestChildSections);
	api.bind("pane-contents-reflowed", penbirdNestChildSections);
})(window.wp.customize, jQuery);

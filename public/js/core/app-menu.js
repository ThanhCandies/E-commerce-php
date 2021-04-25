(function (window, document, $) {
	"use strict";

	/** init app */
	$.app = $.app || {};
	const $body = $('body');

	$.app.menu = {
		// expanded: true,
		collapsed: false,
		hidden: true,
		toggle: function () {
			let collapsed = this.collapsed;
			let hidden = this.expanded;
			console.log('hello');

				if (collapsed === true) {
					this.expand();
				} else {
					this.collapse();
				}
			// }
			console.log(this.collapsed, this.hidden)
		},
		hide: function () {
			$body.removeClass('menu__expanded menu__open').addClass('menu__hide')
			this.hidden = true;
		},
		open: function () {
			$body.removeClass('menu__collapsed menu__hide').addClass('menu__open')
			this.hidden = false;
		},
		collapse: function () {
			$body.removeClass('menu__open menu__expanded').addClass('menu__collapsed')
			// this.hidden = false;
			this.collapsed = true;
		},
		expand: function () {
			$body.removeClass('menu__hide menu__collapsed').addClass('menu__expanded')
			// this.hidden = false;
			this.collapsed = false;
			// this.expanded = true;

		}
	}

	$.app.nav = {
		initialize: false,

		config: {
			speed: 300
		},

		init: function () {
			this.initialize = true;
			this.bind_events();
		},
		bind_events: function () {
			const menuObj = this;
			$('.menu__container .navigation')
				.on('active.app.menu', 'li', function (e) {
					$(this).addClass('active');
					e.stopPropagation();
				})
				.on('deactive.app.menu', 'li', function (e) {
					$(this).removeClass('active');
					e.stopPropagation();
				})
				.on('close.app.menu', 'li.open', function (e) {
					let $listItem = $(this);

					$listItem.removeClass('open');
					menuObj.collapse($listItem);
					// $(this).children('ul').show().slideUp();
					e.stopPropagation();
				})
				.on('open.app.menu', 'li', function (e) {
					let $listItem = $(this);

					$listItem.addClass('open');
					menuObj.expand($listItem);
					// $(this).children('ul').hide().slideDown();

					$listItem.siblings('.open').find('li.open').trigger('close.app.menu');
					$listItem.siblings('.open').trigger('close.app.menu');

					e.stopPropagation();
				})
				.on('click.app.menu', 'li', function (e) {
					const $listItem = $(this);
					if ($listItem.is('.disabled')) return e.preventDefault();

					//Check if is navigator with list
					if ($listItem.is('.nav__list')) {
						if ($listItem.is('.open')) {
							$listItem.trigger('close.app.menu');
						} else {
							$listItem.trigger('open.app.menu');
						}
					} else {
						// console.log('don\'t have list');
						$listItem.siblings('.active').trigger('deactive.app.menu');
						$listItem.trigger('active.app.menu');
					}
					//Check if item opened or not
					e.stopPropagation();
				})

			$('.menu.menu__container li a').on('click', function (e) {
				e.preventDefault();
			})
			$('.menu.menu__container li.nav__list > a').on('click', function (e) {
				e.preventDefault();
			});

			$('ul.nav__content').on('click', "li", function (e) {
				e.stopPropagation();
			})
		},
		collapse: function ($listItem, callback) {
			var $subList = $listItem.children('ul');

			$subList.show().slideUp($.app.nav.config.speed, function () {
				// $(this).css('display', '');

				// $(this).find('> li').removeClass('is-shown');

				if (callback) {
					callback();
				}

				// $.app.nav.container.trigger('collapsed.app.menu');
			});
		},
		expand: function ($listItem, callback) {
			let $subList = $listItem.children('ul');
			// let $children = $subList.children('li').addClass('is-hidden');

			$subList.hide().slideDown($.app.nav.config.speed, function () {
				// $(this).css('display', '');

				if (callback) {
					callback();
				}

				// $.app.nav.container.trigger('expanded.app.menu');
			})

		}
	}
})(window, document, jQuery)
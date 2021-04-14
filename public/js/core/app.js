(function(window,document,$){
	"use strict";

	$(window).on("load",function(e){
		if(!$.app.nav.initialize){
			$.app.nav.init();
		}
	})

	$(document).on('click','.menu-toggle, .nav__header-toggle',function(e){
		e.preventDefault();
		$.app.menu.toggle();

	})
})(window,document,jQuery)
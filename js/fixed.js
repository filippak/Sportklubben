window.onload = function() {

	var element = jQuery(".l-header");
	element = element[0];
	var rect = element.getBoundingClientRect();
	var y =  rect.height;

	var fromTop = jQuery(document).scrollTop();
	var width = jQuery(window).width();

	fixAside(y,fromTop,width);

	jQuery(document).scroll(function() {

		var fromTop = jQuery(document).scrollTop();
		var width = jQuery(window).width();

		fixAside(y, fromTop, width);

	});
	
}


function fixAside (y, fromTop, width) {
	var sidebar = jQuery('.l-sidebar');
	sidebar = sidebar[0];
	if(fromTop > y && width > 768) {
		jQuery(sidebar).addClass("l-sidebar-fix");
	}else {
		jQuery(sidebar).removeClass("l-sidebar-fix");
	}
}

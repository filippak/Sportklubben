window.onload = function() {

	var element = jQuery(".l-header");
	element = element[0];
	var rect = element.getBoundingClientRect();
	var y =  rect.height;

	var elementFoot = jQuery(".l-footer");
	elementFoot = elementFoot[0];
	var rectFoot = elementFoot.getBoundingClientRect();
	var topFoot = rectFoot.top;

	var elementSide = jQuery('.l-sidebar');
	elementSide = elementSide[0];
	var rectSide = elementSide.getBoundingClientRect();
	var botSide = rectSide.bottom;

	var bodyTop = document.body.getBoundingClientRect();
	bodyTop = bodyTop.top;

	var footOffset = topFoot - bodyTop;
	console.log(bodyTop);
	console.log(topFoot);
	console.log(footOffset);

	var fromTop = jQuery(document).scrollTop();
	var width = jQuery(window).width();

	fixAside(y, fromTop, width);

	jQuery(document).scroll(function() {

		var fromTop = jQuery(document).scrollTop();
		var width = jQuery(window).width();

		fixAside(y, fromTop, width, footOffset, botSide);

	});
	
}


function fixAside (y, fromTop, width, offset, bottom) {
	var sidebar = jQuery('.l-sidebar');
	sidebar = sidebar[0];

	if(fromTop > y && width >= 768 && offset > bottom) {
		jQuery(sidebar).addClass("l-sidebar-fix");

	}else if(offset < bottom){
		jQuery(sidebar).removeClass("l-sidebar-fix");
		jQuery(sidebar).css("vertical-align", "bottom");
	} else {
		jQuery(sidebar).removeClass("l-sidebar-fix");
	}
}

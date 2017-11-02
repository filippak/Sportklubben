window.onload = function() {

	//hämta storlek på head
	var headerHeight = jQuery(".l-header").height();

	//hur långt från top
	var topp = jQuery(document).scrollTop();
	var width = jQuery(window).width();

	if(width > 768) {
		checkHead(topp, headerHeight);

		jQuery(document).scroll(function() {
			topp = jQuery(document).scrollTop();
			checkHead(topp, headerHeight)
			
		});
	}
}

function checkHead (topp, headerHeight) {
	if(topp > headerHeight) {
		jQuery(".l-header").addClass("isFixed");
	} else {
		jQuery(".l-header").removeClass("isFixed");
	}
}

window.onload = function() {

	var headerHeight = jQuery(".l-header").offset().height;

	var bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
	var topFooter = jQuery(".l-footer").offset().top;

	var width = jQuery(window).width();
	console.log(width);	

	if(width >= 768) {

		var fromTop = jQuery(document).scrollTop();
		console.log(fromTop);
		
		var sidebar = jQuery('.sidebarInfo');
		sidebar = sidebar[0];


		checkFooter(sidebar, topFooter);
		checkHeader(sidebar, headerHeight);

		jQuery(document).scroll(function() {
			bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
			fromTop = jQuery(document).scrollTop();

			checkFooter(bottomInfoActivities, topFooter)
			checkHeader(fromTop, headerHeight)

		});
	}
		

	
}

function checkFooter(sidebar, footer) {
	
	if(sidebar >= footer) {
		jQuery(sidebar).addClass("sidebarBottomFix");
	} else {
		jQuery(sidebar).removeClass("sidebarBottomFix");
	}
}

function checkHeader(sidebar, header) {

	if(sidebar <= header) {
		jQuery(sidebar).addClass("l-sidebar-fix");
	} else {
		jQuery(sidebar).removeClass("l-sidebar-fix");
	}
}

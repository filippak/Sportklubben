window.onload = function() {

	var headerHeight = jQuery(".l-header").offset().height;

	var bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
	var topFooter = jQuery(".l-footer").offset().top;

	var width = jQuery(window).width();
	//console.log(width);	

	if(width >= 768) {
		//hur mycket man scrollat
		var fromTop = jQuery(document).scrollTop();
		
		var sidebar = jQuery('.sidebarInfo');
		sidebar = sidebar[0];

		//Kolla var botten av sidebar
		bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
		console.log(bottomInfoActivities);

		//kolla toppen av sidebar
		topInfoActivities = jQuery(".sidebarInfo").offset().top;
		console.log(topInfoActivities);
		
		checkFooter(bottomInfoActivities, topFooter);
		checkHeader(topInfoActivities, headerHeight);

		jQuery(document).scroll(function() {
			//hur långt ner botten är
			bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
			//hur långt scrollat
			fromTop = jQuery(document).scrollTop();

			checkFooter(bottomInfoActivities, topFooter)
			checkHeader(fromTop, headerHeight)

		});
	}
	
}

function checkFooter(sidebar, footer) {
	
	if(sidebar >= footer) {
		jQuery(".sidebarInfo").addClass("sidebarBottomFix");
	} else {
		jQuery(".sidebarInfo").removeClass("sidebarBottomFix");
	}
}

function checkHeader(sidebar, header) {
	//
	if(sidebar >= header) {
		jQuery(".sidebarInfo").addClass("l-sidebar-fix");
	} else {
		jQuery(".sidebarInfo").removeClass("l-sidebar-fix");
	}
}

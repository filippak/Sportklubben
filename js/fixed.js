window.onload = function() {

	//hämta storlek på head
	var headerHeight = jQuery(".l-header").offset().top;

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
		jQuery(".l-header").addClass("l-header-test");
	} else {
		jQuery(".l-header").removeClass("l-header-test");
	}
}

	//console.log(width);	

// 	if(width >= 768) {
// 		//hur mycket man scrollat
// 		var fromTop = jQuery(document).scrollTop();
		
// 		var sidebar = jQuery('.sidebarInfo');
// 		sidebar = sidebar[0];

// 		//Kolla var botten av sidebar
// 		bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
// 		//console.log(bottomInfoActivities);

// 		//kolla toppen av sidebar
// 		topInfoActivities = jQuery(".sidebarInfo").offset().top;
// 		//console.log(topInfoActivities);
		
// 		checkFooter(bottomInfoActivities, topFooter);
// 		checkHeader(topInfoActivities, headerHeight);

// 		jQuery(document).scroll(function() {
// 			//hur långt ner botten är
// 			bottomInfoActivities = jQuery(".sidebarInfo").offset().top + jQuery(".sidebarInfo").height();
// 			//hur långt scrollat
// 			fromTop = jQuery(document).scrollTop();

// 			checkFooter(bottomInfoActivities, topFooter)
// 			checkHeader(fromTop, headerHeight)

// 		});
// 	}
	
// }

// function checkFooter(sidebar, footer) {
	
// 	if(sidebar >= footer) {
// 		jQuery(".sidebarInfo").addClass("sidebarBottomFix");
// 	} else {
// 		jQuery(".sidebarInfo").removeClass("sidebarBottomFix");
// 	}
// }

// function checkHeader(sidebar, header) {
// 	//
// 	if(sidebar >= header) {
// 		jQuery(".sidebarInfo").addClass("l-sidebar-fix");
// 	} else {
// 		jQuery(".sidebarInfo").removeClass("l-sidebar-fix");
// 	}
// }

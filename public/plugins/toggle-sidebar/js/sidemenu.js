(function () {
	"use strict";

	var slideMenu = $('.side-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"] , .app-sidebar__overlay').click(function(event) {
	    console.log("clicked");
	    console.log(event);
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});


    // if ( $(window).width() > 1000) {
    //     console.log("width yes");
    //     setTimeout(function () {
    //         $('.app').removeClass('sidenav-toggled');
    //     },1000);
    // }
	// else
	    if ( $(window).width() > 739) {
        console.log("width " + $(window).width());
		$('.app-sidebar').hover(function(event) {
			event.preventDefault();
            $('.app').removeClass('sidenav-toggled');
		});
            // $('.app').removeClass('sidenav-toggled');
	}


	// Activate sidebar slide toggle
	$("[data-toggle='slide']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			slideMenu.find("[data-toggle='slide']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

})();

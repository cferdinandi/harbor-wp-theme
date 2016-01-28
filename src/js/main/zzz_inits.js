astro.init();
stickyFooter.init();

ready(function () {
	var dropdown = document.querySelectorAll( '.menu-item-has-children > a' );
	for (var i = 0, len = dropdown.length; i < len; i++) {
		dropdown[i].className += ' needsclick';
	}
	drop.init({
		selector: '.menu-item-has-children'
	});
});

ready(function () {
	var rh = document.querySelector( '[data-right-height]' );
	if ( !rh ) return;
	imagesLoaded(rh, function () {
		rightHeight.init();
	});
});

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net', 'www.google.com/maps']
});

ready(function () {
	FastClick.attach(document.body);
});
astro.init();
drop.init({
	selectorDropdown: '.menu-item-has-children',
    selectorMenu: '.sub-menu'
});
stickyFooter.init();

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
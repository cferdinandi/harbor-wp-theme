astro.init();
drop.init({
	selectorDropdown: '.menu-item-has-children',
    selectorMenu: '.sub-menu'
});
stickyFooter.init();
rightHeight.init();

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net']
});

document.addEventListener('DOMContentLoaded', function() {
	FastClick.attach(document.body);
}, false);
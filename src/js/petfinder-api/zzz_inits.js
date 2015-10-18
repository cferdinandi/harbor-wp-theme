petfinderSort.init();

petfinderImgToggle.init({
	selectorContainer: '.js-petfinder-img-container',
	selectorImg: '.js-petfinder-img',
	selectorToggle: '.js-petfinder-img-toggle',
	imgAttributes: 'class="img-photo img-limit-height-large"',
	callback: function () {
		rightHeight.runRightHeight();
	}
});
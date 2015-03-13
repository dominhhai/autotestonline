//alert('ie8.js');
/* IE8 JavaScript */

(function($, Core) {

Core.on('ready:', function() {
inputPlaceholderFix();
fixGalleryImages();
});

// Makes html5 inputs with the placeholder attribute work as expected on iE8

function inputPlaceholderFix() {
$('form input:text[placeholder]').each(function(i, elem) {
	var self = $.getWrappedObject(this);
	self.val(self.attr('placeholder'));
}).focus(function() {
	var self = $.getWrappedObject(this);
	if (self.val().trim() == self.attr('placeholder')) self.val('');
}).blur(function() {
	var self = $.getWrappedObject(this);
	if (self.val().trim() == '') self.val(self.attr('placeholder'));
});
}

// Fixes gallery images

function fixGalleryImages() {
$('.gallery img').each(function(i, elem) {
	var img = $(elem);
});
}

})(jQuery, window.Core);
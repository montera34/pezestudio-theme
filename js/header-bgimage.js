// set header height as a percentage of browser window
function pezestudioSetHeight(target) {
	var winHeight = jQuery(window).height();
	var headerHeight = ( headerHeightPercent * winHeight ) / 100;
	jQuery(target).css( "height", headerHeight );
}
// trigger an event when browser window resizes
jQuery(window).resize(function() {
	if(this.resizeTO) clearTimeout(this.resizeTO);
	this.resizeTO = setTimeout(function() {
		jQuery(this).trigger('resizeEnd');
	}, 500);
});
// resize header when browser window resizes
jQuery(window).bind("resizeEnd", function() {
	pezestudioSetHeight('.wrap');
});
// set height when document loads
jQuery(document).ready(function($) {
	pezestudioSetHeight('.wrap');
});

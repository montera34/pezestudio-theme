// set header height as a percentage of browser window
function pezestudioSetHeight(target) {
	winHeight = jQuery(window).height();
	headerHeight = ( headerHeightPercent * winHeight ) / 100;
	if ( headerHeight < 150 ) { headerHeight = 150; }
	jQuery(target).css( "height", headerHeight );
}
// skip header with a smoth scroll transition
function pezestudioSkipHeader() {
	jQuery('#entry-header').append('<div class="col-md-3"><div class="pull-right"><a id="skipHeader" href="#entry-content"><i class="fa fa-4x fa-angle-down" aria-hidden="true"></i></a></div></div>');
	jQuery('#skipHeader').click(function() {
		var target = jQuery(this.hash);
		jQuery('html, body').animate({
			scrollTop: target.offset().top
		}, 1000);
	});
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
// when document loads
jQuery(document).ready(function($) {
	// set height 
	pezestudioSetHeight('.wrap');
	// if bg image is set to 100% height,
	// add skip to content button
	if ( headerHeightPercent == '100' ) { pezestudioSkipHeader(); }
});

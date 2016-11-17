jQuery(document).ready(function ($) {
	//$('.project-thumb').magnificPopup({type:'image'});
	$('#project-imgs-nav').magnificPopup({
		type:'image',
		delegate:'a',
		gallery:{enabled:true}
	});
});

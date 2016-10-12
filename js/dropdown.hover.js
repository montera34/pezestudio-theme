jQuery(window).ready(function($){
	$(".menu-item-has-children>a").append(" <i class='fa fa-angle-down' aria-hidden='true'></i>");
	$(".menu-item-has-children").hover(function(){
		$(this).children(".sub-menu").slideToggle('medium');
	});
});

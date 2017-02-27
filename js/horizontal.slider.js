jQuery(document).ready(function($) {

	$(".slide-wrap").on("click", "a.slide-arrow-right", function(e) {
		e.preventDefault();
		var cur =  $(".slide-wrap .slides a.current");
		var next = cur.next();

		if(next.length != 0) {
			cur.removeClass("current");
			next.addClass("current");
			var l = next.position().left * -1;
			$(".slides").stop().animate({left:l}, 450);
		}
	});
	$(".slide-wrap").on("click", "a.slide-arrow-left", function(e) {
		e.preventDefault();

		var cur =  $(".slide-wrap .slides a.current");
		var prev = cur.prev();

		if(prev.length != 0) {
			cur.removeClass("current");
			prev.addClass("current");

			var l = prev.position().left * -1;
			$(".slides").stop().animate({left:l}, 450);
		}
	});
});

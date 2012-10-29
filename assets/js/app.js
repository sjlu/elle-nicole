var Frontpage = function()
{
	var exports = {};

	function init()
	{
		var sum = 20;

		$('#photos img').load(function() {
			sum = sum + this.width + 30;
			$('#photos').css('width', sum);
		});

		function center() 
		{
			var height = $(window).height();
			$('#navigation').css('top', height/2 - 460/2 - 31);
			$('#photos').css('margin-top', height/2 - 460/2 - 30);
			$('#footer').css('top', height/2+460/2 - 20);
		}

		$(window).resize(center);
		center();
	}
	exports.init = init;

	return exports;
}; 
/**
 * Write all your event listeners in the 
 * document.ready function or else they
 * may not bind correctly. As a side note, I like
 * to just call a public function in a class
 * to handle all your bindings here.
 */
$(document).ready(function() {
	var frontpage = new Frontpage();
	frontpage.init();
});
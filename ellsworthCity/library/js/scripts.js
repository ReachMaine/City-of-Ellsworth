(function($){ "use strict";

	// add your plugins or override existing ones here

	/* you will find all custom plugins in "library/js/library.js" file in parent theme directory
	for example, if you want to override plugin for loading HiDPI images, use the following code:
	if ( ! $.fn.lsvrLoadHiresImages ) {
		$.fn.lsvrLoadHiresImages = function() {
			if ( window.devicePixelRatio > 1 ) {
				$(this).find( 'img[data-hires]' ).each(function(){
					if ( $(this).data( 'hires' ) !== '' ) {
						$(this).attr( 'src', $(this).data( 'hires' ) );
					}
				});
			}
		};
	}
	*/

$(document).ready(function(){

	$('#wpcf7-f3211-p1025-o1').bind("keyup keypress", function(e) {
	  var code = e.keyCode || e.which;
	  if (code == 13) {
	    e.preventDefault();
	    return false;
	  }
	});

});
})(jQuery);
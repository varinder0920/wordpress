/**
 * Handles toggling the navigation menu for small screens 
 */

jQuery( document ).ready(function( $ ) {

	var adm = 0;
	if(parseInt($('#wpadminbar')) != 'undefined')
		adm = parseInt($('#wpadminbar').css('height'));
	
	var topheader = adm;
	
	$('#top-navigation').addClass('original').clone().insertAfter('#top-navigation').addClass('cloned').css('position','fixed').css('top','0').css('margin-top',adm).css('margin-left','0').css('z-index','500').removeClass('original').hide();
	
	$(window).scroll( function(){
		stickIt();
	});
	
	$(window).resize( function(){
		stickIt();
	});
	
	$('.scrollup').click( function(){
		$('html, body').animate({scrollTop : 0}, 1000);
		return false;
	});
	
	function stickIt() {
		var orgElement = $('.original');
		if( orgElement.size() <= 0)
			return;

		var orgElementPos = $('.original').offset();
		var orgElementTop = orgElementPos.top;               

		if ($(window).scrollTop() >= (orgElementTop) && parseInt($(window).width()) > 740 ) {
		// scrolled past the original position; now only show the cloned, sticky element.

		// Cloned element should always have same left position and width as original element.     
			var coordsOrgElement = orgElement.offset();
			var leftOrgElement = coordsOrgElement.left;  
			var widthOrgElement = parseInt(orgElement.css('width')) + 2;

			$('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
			$('.original').css('visibility','hidden');
			} else {
			// not scrolled past the menu; only show the original menu.
				$('.cloned').hide();
				$('.original').css('visibility','visible');
				}
		}

});
/***
  Thanks to http://tutorialzine.com/2010/02/html5-css3-website-template/ for the template idea!
***/
$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */
	
	$('form').submit(function() {
	   window.setTimeout(function(){$.scrollTo("#article4",1500)},1000);
	});
	
	$('.nav a,.footer a.up').click(function(e){
										  
		// If a link has been clicked, scroll the page to the link's hash target:
		$.scrollTo( this.hash || 0, 1500);
		e.preventDefault();
	});

});
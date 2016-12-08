// JavaScript Document
var Homepage =
{
	_HeroeHTML: '',
	_slider: null,
	init: function()
	{		
		//this._HeroHTML = $('#Hero-Slider-Container').clone();
		//this.updateOrientation();
		//this.initHeroes();
	},
	initHeroes: function()
	{
		/*
		 this._slider = $('.bxSlider').bxSlider({
			 auto: true,
			 speed: 1000,
			 pause: 10000
		 });
		 */		
		 //$('#Hero-Slider-Container').css("visibility", "visible");
		 //console.log("done");
	},
	resetHeroes: function()
	{
		$('#Hero-Slider-Container').unbind();
		$('#Hero-Slider-Container').replaceWith(this._HeroHTML);
		//console.log($('#Hero-Slider-Container').html());
		
	},
	updateOrientation: function()
	{
		//this.resetHeroes();
		// reset the heights to default and recalculate and set to max height
		
		$("div.hero-unit").css('height','auto');
		$("div.span4.box").css('height','auto');
		var heights = null
		heights = $("div.hero-unit").map(function ()
			{
				return $(this).height();
			}).get(); 
		var maxHeight = Math.max.apply(null, heights);	
			
		$("div.hero-unit").css('height',maxHeight+60);	
		if(this._slider != null)
		{
			this._slider.reloadSlider();
		}
		
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		width = width>=980 ? 980 : width;
		//alert(contentWidth);
		if(width>=560)
		{
			heights = $("div.span4.box").map(function ()
				{
					return $(this).height();
				}).get();
			maxHeight = Math.max.apply(null, heights);	
				
			$("div.span4.box").css('height',maxHeight);				
			
		}
	}
}
/*
$(document).ready(function(){	
	$( window ).on( "orientationchange", function( event ) {
		// Give time to redraw the page before updating
		setTimeout(function(){Homepage.updateOrientation();},500);
	});
	Homepage.init(); 
});
*/
// JavaScript Document
var Homepage =
{
	_HeroeHTML: '',
	_slider: null,
	init: function()
	{		
		this.initSiteInfo();
	},
	initSiteInfo: function(){
		$('#site-info .box').matchHeight();
	}
}

$(document).ready(function(){
	Homepage.init(); 
});

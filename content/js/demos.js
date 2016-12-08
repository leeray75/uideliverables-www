var UI_DEMOS = (function(){
	return {
		init: function(){
			this.initBootstrapDemoModal();
		},
		initBootstrapDemoModal: function(){
			$('.demo-bootstrap-modal').on('click',function(e){
				$('#bootstrap-demo-modal').modal();
			});
		},
		autoResize: function(iframe){			
			var newHeight = iframe.contentWindow.document.body.scrollHeight ; 
			var windowHeight = $(window).height();
			var maxHeight = windowHeight*.8;
			/*
			console.log("newHeight = "+newHeight);
			console.log("windowHeight ="+windowHeight);
			console.log("mzxHeight = "+maxHeight); 
			*/
			var iframeHeight = newHeight>maxHeight ? maxHeight : newHeight;
			iframe.height= iframeHeight+"px";  
			
	
		}
	};
})();

$(document).ready(function(e) {
    UI_DEMOS.init();
});
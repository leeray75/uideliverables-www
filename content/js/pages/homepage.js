(function(window,$){
	var Homepage =
	{
		init: function()
		{	
			this.initClock();	
			this.initSiteInfo();
		},
		initClock: function(){
			var $clockEl = $('#clock');
			var date = new Date();
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();
			
			var hoursAngle = (hours * 30) + (minutes / 2);
			var minutesAngle = minutes*6;
			var secondsAngle = seconds*6;
			var $hoursEl = $clockEl.find('.hours');
			var $minutesEl = $clockEl.find('.minutes');
			var $secondsEl = $clockEl.find('.seconds');
			function transformEl($el,angle){
				$el[0].style.transform = 'rotateZ('+angle+'deg)';
			}
			
			transformEl($hoursEl,hoursAngle);
			transformEl($minutesEl,minutesAngle);
			transformEl($secondsEl,secondsAngle);
			$clockEl.tooltip({placement : 'top' });
			function updateTime(){
				var date = new Date();
				var hours = date.getHours();
				var minutes = date.getMinutes();
				var seconds = date.getSeconds();
				var postfix = hours>11 ? 'PM' : 'AM';
				hours = hours>12 ? hours-12 : hours;
				var title = hours+":"+minutes+ ' '+postfix;
				$clockEl
				.tooltip('hide')
				.attr('data-original-title', title)
				.tooltip('fixTitle');
				
				setTimeout(updateTime,60000-(seconds*1000));
			}
			
			updateTime();	
		},
		initSiteInfo: function(){
			$('#site-info .box').matchHeight();
		}
	}
	
	$(document).ready(function(){
		Homepage.init(); 
	});
})(window, jQuery)

// main.js

window.console = window.console || { log: function(){  }}
var UI = UI || {};
UI = {
	LogInOutCallback: [],
	isUpdateAllow: false,
	init: function()
	{
		//console.log("intiializing!");
		initUser();
		
		GlobalVariables = GlobalVariables || {};
		var now = new Date();
		var year = now.getFullYear();
		var month = now.getMonth()+1;
		var day = now.getDate();
		month = month<10 ? "0"+month : month;
		day = day<10 ? "0"+day : day;
		GlobalVariables.CurrentDate = year+"-"+month+"-"+day+" 00:00:00";
		this.initLogInOutLinks();
		this.initDocument();
	},
	initDocument: function(){
		/* collapse bootstrap's navbar when user clicks outside of it */
		$(document).on("click",function (event) {
			var clickover = $(event.target);
			var _opened = $(".navbar-collapse").hasClass("in");
			if (_opened === true && !clickover.hasClass("navbar-toggle")) {
				$("button.navbar-toggle").click();
			}
		});		
	},
	updateUser: function(){
		var hdr = UI.services.getUser()
		.done(function(data){
		  	user = new User(data);
			if(user.get("isGuest")==false){
				$('.log-in-out-copy').html("Log Out");	
			}
			else{
				$('.log-in-out-copy').html("Log In");					
			}		  
			UI.executeLogInOutCallbacks();
			//UI.isUpdateAllow = true;
		}).fail(function(data){});		


	},
	initLogInOutLinks: function(){
		$('.log-in-out-link').on('click.loginout',function(){
			if(user.get("isGuest")==false){
				UI.modules.logout();
			}
			else{
				UI.modules.login();					
			}						
		});
	},
	executeLogInOutCallbacks: function(){
		for(i=0;i<this.LogInOutCallback.length;i++){
			try{
				this.LogInOutCallback[i]();	
			}catch(e){
				console.log('Error in executeLogInOutCallback '+e);
			}
				
		}
	},
	setLogInOutCallback: function(_callback){
		this.LogInOutCallback.push(_callback);
	},
	showModal: function(selector){
	   $(selector).modal(function () {
			$('#username').focus()
		 })			
	},
	loadGoogleSearch: function()
	{
		var cx = '007094520602235572549:qc-ix-slhds';
		/*
			var gcse = document.createElement('script');
			gcse.type = 'text/javascript';
			gcse.async = true;
			gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
				'//www.google.com/cse/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(gcse, s);
			
		*/
		var gsURL = '//www.google.com/cse/cse.js?cx=' + cx;
		LazyLoad.js(gsURL,function(){
			console.log("loaded: "+gsURL);
		});		
	}
	
} // UI

UI.services = {
	dev_api:{
		login: "/www/index.php/api/user/0",
		logout: "/www/index.php/api/user/0?logout=1"
	},
	prod_api:{
		login: "https://www.uideliverables.com/www/index.php/api/user/0",
		logout: "https://www.uideliverables.com/www/index.php/api/user/0?logout=1"
		
	},		
	logout: function(){
		var api = window.location.hostname == "localhost" ? UI.services.dev_api["logout"] : UI.services.prod_api["logout"];
		return $.ajax({
			dataType: "jsonp",
			url: api
		});	
	},
	login: function(userData){
		var api = window.location.hostname == "localhost" ? UI.services.dev_api["login"] : UI.services.prod_api["login"];
		return $.ajax({
			dataType: "jsonp",
			url: api,
			data: userData
		});					
	},

	getUser: function(){
		var api = window.location.hostname == "localhost" ? UI.services.dev_api["login"] : UI.services.prod_api["login"];
		return $.ajax({
			dataType: "jsonp",
			url: api
		});
	}
				
} // UI.services

UI.modules = {
	isLoginModuleInit: false,
	logout: function(_callback){
		var hdr = UI.services.logout()
			.done(function(){
				UI.updateUser();
			})
			.fail(function(){				
			});
		
	},
	login: function(_callback){
		if(this.isLoginModuleInit){
			UI.showModal('#LoginModal')
		}
		else{
			angular.module('UIDeliverablesApp', [
			'UIDeliverablesApp.controllers',
			'UIDeliverablesApp.directives'
			])	
			
			var UIDeliverablesControllers = angular.module('UIDeliverablesApp.controllers', []);	
			UIDeliverablesControllers.controller('loginController', function ($scope,$http) {
				$scope.isWaiting = false;
				$scope.isLoginSuccess = false;
				$scope.errorMessage = "";
				$scope.master = {
					username: "",
					password: ""	
				};
				$scope.user = angular.copy($scope.master);
				
				$scope.resetLogin = function(form){									
					form.$setPristine();
					form.$setUntouched();
					$scope.user = angular.copy($scope.master);
					$scope.errorMessage = "";															
				}
				$scope.login = function(form){
					form.$submitted = true;
					var data = { callback: "JSON_CALLBACK" };
					angular.copy($scope.user,data);
					if(form.$valid){
						var api = window.location.hostname == "localhost" ? UI.services.dev_api["login"] : UI.services.prod_api["login"];
						$scope.isWaiting = true;
						$http({ method: 'jsonp', 
							url: api+"?callback=JSON_CALLBACK",  /// Add '?callback=JSON_CALLBACK'
							params: $scope.user
						})
						.success(function (data, status, headers, config) { 
								if(data.hasOwnProperty("errorCode")){
									$scope.isLoginSuccess = false;
									var username = $scope.user["username"];
									$scope.resetLogin(form);
									$scope.user["username"] = username;
									$scope.errorMessage = data.hasOwnProperty("errorMessage") ? data["errorMessage"] : "Log In Error";
									$scope.isWaiting = false;									
								}
								else{
									$scope.isLoginSuccess = true;								
									$scope.resetLogin(form);
									$scope.isWaiting = false;
									UI.updateUser(data);
								}
						})
						.error(function () { 
								$scope.resetLogin(form);								
								$scope.isLoginSuccess = false;
								$scope.errorMessage = "Log In Error";
								$scope.isWaiting = false;							
						});					
										
					}
					
				}
			})// end controllers
			
			angular.module('UIDeliverablesApp.directives', [])
				.directive('loginModalContainer', function() {
					return {
						restrict: 'C',
						link: function(scope, elem, attrs) {
							var selector = '#'+attrs["id"];
							setTimeout(function(){
								UI.showModal(selector)
							},500);
							UI.modules.isLoginModuleInit = true;
							scope.closeModal = function(form){
								scope.isLoginSuccess = false;
								scope.resetLogin(form);
							}
						} // end link
					} // end return obj;
				})
			angular.bootstrap(document.getElementById("UIDeliverablesLogin"),['UIDeliverablesApp']);
		}// end if isLoginModuleInit else 
	}	
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

jQuery.fn.exists = function(){return jQuery(this).length>0;} 

jQuery.fn.isNumericEvent = function(event)
{
	//alert(event.keyCode);
	var keyCode = event.keyCode;
	//alert(keyCode);
	if(event.shiftKey)
	{
		return false;
	}
	else if(keyCode == 8 || keyCode == 46 || (keyCode>36 && keyCode<41) || (keyCode>95 && keyCode<106))
	{
		return true;	
	}
	else if (keyCode < 48 || keyCode > 57 ) {
		//event.preventDefault();	
		return false;
	}
	else {
		// Ensure that it is a number and stop the keypress
		return true;
	}
}

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}

jQuery.fn.selectAll = function(event){ this.select(); } // jQuery.fn.selectAll

jQuery.fn.isMobile = function()
{
	var ua = navigator.userAgent;
	var checker = {
  		iphone: ua.match(/(iPhone|iPod|iPad)/),
  		blackberry: ua.match(/BlackBerry/),
		android: ua.match(/Android/)
	};
	return (checker.iphone!=null || checker.blackberry!=null || checker.android!=null);
}

jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}
/* 
Check if position:fixed; is supported. Requires presence of document.body
*/
function IS_POSITION_FIXED_SUPPORTED(){
  var container = document.body;
  
  if (document.createElement && container && container.appendChild && container.removeChild) {
    var el = document.createElement('div');
    
    if (!el.getBoundingClientRect) return null;
        
    el.innerHTML = 'x';
    el.style.cssText = 'position:fixed;top:100px;';
    container.appendChild(el);

    var originalHeight = container.style.height,
        originalScrollTop = container.scrollTop;
    // In IE<=7, the window's upper-left is at 2,2 (pixels) with respect to the true client.
    // surprisely, in IE8, the window's upper-left is at -2, -2 (pixels), but other elements
    // tested is just right, so we need adjust this.
    // https://groups.google.com/forum/?fromgroups#!topic/comp.lang.javascript/zWJaFM5gMIQ
    // https://bugzilla.mozilla.org/show_bug.cgi?id=174397
    var extraTop  = document.documentElement.getBoundingClientRect().top;
    extraTop = extraTop > 0 ? extraTop : 0;

    container.style.height = '3000px';
    container.scrollTop = 500;

    var elementTop = el.getBoundingClientRect().top;
    container.style.height = originalHeight;
    
    var isSupported = (elementTop - extraTop) === 100;
    container.removeChild(el);
    container.scrollTop = originalScrollTop;

    return isSupported;
  }
  return null;
} // End IS_POSITION_FIXED_SUPPORTED
function generateModal(ContentID)
{
		var ModalStyle = "opacity: 0.5; height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 1001;";
		var ModalHTML = '<div id="'+ContentID+'"-Modal" class="cptk-modal-overlay" style="'+ModalStyle+'"></div>';
		$('body').append(ModalHTML);	
		$(ContentID).show();
		var WindowHeight = $(window).height();
		var WindowWidth = $(window).width();
		var WrapperHeight = $(ContentID).height();
		var WrapperWidth = $(ContentID).width();
		var WrapperTop = (WindowHeight/2) - (WrapperHeight/2) ;
		var WrapperLeft = (WindowWidth/2) - (WrapperWidth/2) ;		
		$(ContentID).css({position: 'fixed', top: WrapperTop, left: WrapperLeft});	
		$(ContentID).prepend('<a title="Close" class="modalCloseImg simplemodal-close"></a>');
}

function getMilitaryTime(time)
{
	var hours = Number(time.match(/^(\d+)/)[1]);
	var minutes = Number(time.match(/:(\d+)/)[1]);
	var AMPM = time.match(/\s(.*)$/)[1];
	if(AMPM == "PM" && hours<12) hours = hours+12;
	if(AMPM == "AM" && hours==12) hours = hours-12;
	var sHours = hours.toString();
	var sMinutes = minutes.toString();
	if(hours<10) sHours = "0" + sHours;
	if(minutes<10) sMinutes = "0" + sMinutes;
	return sHours + ":" + sMinutes;	
}
function getFormattedTime(militaryTime) {
    var timeArray = militaryTime.split(":");
    var hours = ((parseInt(timeArray[0]) + 11) % 12) + 1;
    var amPm = parseInt(timeArray[0]) > 11 ? ' PM' : ' AM';
    var minutes = timeArray[1];

    return hours + ':' + minutes + amPm;
};

function getDateObject(dateString)
{
	//console.log("dateString = "+dateString);
	//"2013-08-29 06:00:00"
	var fullDateArray = dateString.split(" ");
	var date = fullDateArray[0];
	var time = fullDateArray[1];
	var dateArray = date.split("-");
	var timeArray = time.split(":");
	var year = dateArray[0];
	var month = parseInt(dateArray[1])-1;
	var day = dateArray[2];
	var hours = timeArray[0];
	var minutes = timeArray[1];
	var seconds = timeArray.length>2 ? timeArray[2] : "00";
	var milliseconds = "00";
	return new Date(year, month, day, hours, minutes, seconds, milliseconds)
	
}



$(function(){	
	UI.init();	
});

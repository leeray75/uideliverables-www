// JavaScript Document

$(document).ready(function(){
	SchoolResourceCatalog.init();
	CPTK_SPS_Nav.init();
	CPTK_Nav.init();
	FairFilesLink.init();
	//BookFairEvents.init();
});
jQuery.fn.isNumeric = function(event)
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

function getDateString(date)
{
	var dateObj = new Date(date);
	var month = ("0" + (dateObj.getMonth() + 1)).slice(-2)
	var day = ("0" + (dateObj.getDate())).slice(-2);
	var hours = ("0" + (dateObj.getHours())).slice(-2)
	var minutes = ("0" + (dateObj.getMinutes())).slice(-2)
	var seconds = ("0" + (dateObj.getSeconds())).slice(-2)
	var dateString = date.getFullYear()+"-"+month+"-"+day+" "+hours+":"+minutes+":"+seconds;	
	return dateString;
}
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
	var seconds = timeArray[2];
	var milliseconds = "00";
	return new Date(year, month, day, hours, minutes, seconds, milliseconds)
	
}

var CPTK_Nav =
{
	init: function()
	{

		$(document).delegate("#nav-items .menu",'click.menu',function(event){
				if ( $("#TopNavModal").is(":visible") ){
					$("#TopNavModal").hide();
				} else {
					$("#TopNavModal").show();
				}
			});
		$(document).delegate("#TopNavModal .close",'click.menu',function(event){
				$("#TopNavModal").hide();
			});

	}
}
		   
var SchoolResourceCatalog =
{
	LinksClass: '.srcLink',
	FormID: '#SRCForm',
	TopLinkID: '#SRCTopLink',
	init: function()
	{
		//$(SchoolResourceCatalog.LinksClass).click(SchoolResourceCatalog.submitForm);
		var href = $(SchoolResourceCatalog.TopLinkID).attr('href');
		var onclick = $(SchoolResourceCatalog.TopLinkID).attr('onclick');
		$(SchoolResourceCatalog.LinksClass).attr('href',href);
		if(onclick!=null && onclick.length>0)
		{
			$(SchoolResourceCatalog.LinksClass).click(SchoolResourceCatalog.submitForm);
		}
	},
	submitForm: function()
	{
		$(SchoolResourceCatalog.FormID).submit();
	}
};

var BookFairEvents =
{
	LinksClass: '.bookFairEventsLink',
	LinkID: '#BFEvents',
	EventsHref: '',
	init: function()
	{
		if($(BookFairEvents.LinkID).exists())
		{
			BookFairEvents.EventsHref = $(BookFairEvents.LinkID).attr('href');
			$(BookFairEvents.LinksClass).click(BookFairEvents.setHref);
		}
										  
		
	},
	setHref: function()
	{
		var linkTag = this;
		$(linkTag).attr('href',BookFairEvents.EventsHref);
	}
}



var FairFilesLink =
{
	HiddenID: '#FairFilesLink',
	LinkTag: '.FairFilesLinkTag',
	
	init: function()
	{		
		if($(FairFilesLink.LinkTag).exists() && $(FairFilesLink.HiddenID).exists())
		{
			var url = $(FairFilesLink.HiddenID).val();
			$(FairFilesLink.LinkTag).attr('href',url);
		}
	}
} //FairFilesLink 

var ToolkitOverlay =
{
	ContentID: '',
	OverlayObj: null,
	ModalContainerID: '#ToolkitModalContainer',
	ModalDialog: null,
	initModal: function( ){	
		var thisObj = this;
		thisObj.ContentID = thisObj.OverlayObj.ContentID;
		if(thisObj.OverlayObj.loadAjax)
		{
			thisObj.getAjaxFile();
		}
		else
		{
			thisObj.generateModal();
		}

	},
	generateModal: function()
	{		
		$(ToolkitOverlay.ContentID).modal({
			overlayId: 'ToolkitModalOverlay',
			containerId: 'ToolkitModalContainer',
			onOpen: OnlineFairOverlay.open,
			onShow: OnlineFairOverlay.show,
			onClose: OnlineFairOverlay.close
		});
				
	},

	setOverlayObj: function(overlayObj)
	{
		ToolkitOverlay.OverlayObj = overlayObj		
	},
	open: function (dialog) {
		dialog.overlay.show(0, function () {
			dialog.container.show(0, function () {		
				ToolkitOverlay.ModalDialog = dialog;
				$(ToolkitOverlay.ContentID).show();	
			});
		});		
	},
	show: function (dialog) { 
		ToolkitOverlay.ModalDialog = dialog;
		try{ ToolkitOverlay.OverlayObj.show(); }
		catch(e){}
	},
	close: function (dialog) {		
		if(dialog==null)
		{
			dialog = ToolkitOverlay.ModalDialog;
		}
		$(ToolkitOverlay.ContentID).hide(0, function () 
		{
			dialog.container.hide(0, function () {
				dialog.overlay.hide(0, function () {							
					$.modal.close();	
				});
			});		
		});
		if(ToolkitOverlay.OverlayObj.loadAjax)
		{
			$(ToolkitOverlay.ContentID).remove();			
		}
	},
	getAjaxFile: function()
	{
		var AjaxFilePath = $(ToolkitOverlay.OverlayObj.Link).attr('href');
		// load the contact form using ajax
		if($(ToolkitOverlay.ContentID).exists())
		{
			$(ToolkitOverlay.ContentID).remove();
		}
		$.get(AjaxFilePath, function(data){
		// create a modal dialog with the data		
			$('body').append(data);
			ToolkitOverlay.generateModal();
		});		
	},	
	initAjaxForm: function()
	{

		//$(ProfitEstimator.FormID).ajaxForm();
		var AjaxForm = $(ToolkitOverlay.ContentID).find('form');
		var AjaxUrl = $(AjaxForm).attr('action');
		
		var options = { 
			type: 'POST',
			url: AjaxUrl,
			target: ToolkitOverlay.AjaxTargetID,   // target element(s) to be updated with server response 
			replaceTarget: false,
			beforeSubmit: OToolkitOverlay.ajaxBeforeSubmit,
			success: ToolkitOverlay.ajaxSuccess,  // post-submit callback 
			error: ToolkitOverlay.ajaxError

		}; 			
		$(AjaxForm).ajaxForm(options);
	
	},
	ajaxBeforeSubmit: function(arr, $form, options)
	{
		
		ToolkitOverlay.OverlayObj.ajaxBeforeSubmit(arr, $form, options);		
		return true;					
	},
	ajaxSuccess: function (data) {		
		try
		{
			ToolkitOverlay.OverlayObj.ajaxSuccess(data);
		}catch(e){}
	},
			
	ajaxError: function (xhr) {
		alert("Ajax Error: "+ xhr.textStatus);

	}
}

// The ajaxStart/Stop functions will fire whenever you do any ajax calls.
var AjaxLoading =
{
	ContainerID: '#AjaxLoadingDiv',
	init: function()
	{
		var thisObj = this;
		if(!$(thisObj.ContainerID).exists())
		{
			thisObj.build();	
		}
		$($(thisObj).ContainerID)
			.hide()  // hide it initially     
			.ajaxStart(function() 
			{ $(this).show(); })     
			.ajaxStop(function() 
			{ $(this).hide(); }) ; 
	},
	build: function()
	{
			
	}
};

/* Release 21.2 SPS My Account links integration */


var CPTK_SPS_Nav = 
{
	ContainerID: '#SPS_Container',
	SignedInContainer: '.signed-in-container',
	SignedOutContainer: '.signed-out-container',
	SignInLink: '.sps-SignIn-link',
	SignOutLink: '.sps-SignOut-link',
	MyAccountLink: '.sps-MyAccount-link',
	RegisterNowLink: '.sps-Register-link',
	init: function()
	{
		var thisObj = this;
		thisObj.initContainer();

	},// init
	initContainer: function()
	{
		var thisObj = this;		
		thisObj.initSignOutLink();
		thisObj.initMyAccountLink();			
	},
	initSignInLink: function()
	{
		var thisObj = this;
		/* CPTK can't have users signed out of SPS and in the Toolkit */
		
	},// initSignInLink
	initSignOutLink: function()
	{
		var thisObj = this;		
		$(thisObj.SignOutLink).bind('click.SPS',function(event)
		{						
			CPTK_SPS_MyAccount.doTookitSignOut();			
			return false;
		});
	},
	initMyAccountLink: function()
	{
		var thisObj = this;
		$(thisObj.MyAccountLink).bind('click.SPS',function(event)
		{
			CPTK_SPS_MyAccount.isSignedIn(function(JSON_DATA){
				if(!JSON_DATA.isSignedInSPS)
				{
					CPTK_SPS_MyAccount.doTookitSignOut();
				}
				else
				{
					CPTK_SPS_MyAccount.showMyAccount();					
				}
			});			
			
			return false;
		});
	},
	initRegisterNowLink: function()
	{
		var thisObj = this;		
		/* CPTK can't have users signed out of SPS and in the Toolkit */
	}


}; //MyAccountNav
var CPTK_SPS_MyAccount = 
{
	SPS_Cookie: 'SPS_UD',
	AjaxIsSignInFormID: '#AjaxIsSignInForm',
	init: function()
	{
		var thisObj = this;		
	},
	getUserEmail: function()
	{
		var thisObj = this;
		var SpsCookie = ($.cookie(thisObj.SPS_Cookie)).trim();
		var Email = "";

		if ( SpsCookie != null && (SpsCookie.length>0) ) 
		{
		  var ValuesArray = unescape(SpsCookie).split('|');
		  Email = (ValuesArray.length > 0) ? ValuesArray[1] : "";
		}
		return Email;
	},
	getUserFirstName: function()
	{
		var thisObj = this;
		var SpsCookie = ($.cookie(thisObj.SPS_Cookie)).trim();
		var FirstName = "";

		if ( SpsCookie != null && (SpsCookie.length>0) ) 
		{
		  var ValuesArray = unescape(SpsCookie).split('|');
		  FirstName = (ValuesArray.length > 0) ? ValuesArray[2] : "";
		}
		return FirstName;
	},
	getUserLastName: function()
	{
		var thisObj = this;
		var SpsCookie = ($.cookie(thisObj.SPS_Cookie)).trim();
		var LastName = "";

		if ( SpsCookie != null && (SpsCookie.length>0) ) 
		{
		  var ValuesArray = unescape(SpsCookie).split('|');
		  LastName = (ValuesArray.length > 0) ? ValuesArray[3] : "";
		}
		return LastName;
	},
	getUserID: function()
	{
		var thisObj = this;
		var SpsCookie = ($.cookie(thisObj.SPS_Cookie)).trim();
		var UserID = "";

		if ( SpsCookie != null && (SpsCookie.length>0) ) 
		{
		  var ValuesArray = unescape(SpsCookie).split('|');
		  UserID = (ValuesArray.length > 0) ? ValuesArray[0] : "";
		}
		return UserID;
	},      
	isSignedIn: function(hook)
	{     
		var thisObj = this;
		var PathName = document.location.pathname;
		var HostName = document.location.hostname;
		var PageProtocol = document.location.protocol;
								
		var URL = escape(document.URL);	
		var AjaxIsSignInForm = $(thisObj.AjaxIsSignInFormID);
		var AjaxURL = $(AjaxIsSignInForm).attr('action');
		var AjaxData = $(AjaxIsSignInForm).serialize();
		$.ajax({
			  url: AjaxURL,
			  data: AjaxData,
			  success: function(JSON_DATA, textStatus, jqXHR){
				var response=jQuery.parseJSON(JSON_DATA);
				if(typeof response =='object')
				{
				  //It is JSON
					try{
						hook(JSON_DATA);
					}catch(e){}
				}
				else{
					// It is not JSON
					try{
						
						console.log("Invalid AJAX Response, expect JSON object");
					}catch(e){
						alert("Invalid AJAX Response, expect JSON object");	
					}
								
				}
				  
			  },
			  error: function(jqXHR, textStatus, errorThrown){
					try{
						console.log("error in AjaxIsSignedIn command");

					}catch(e){
						alert("error in AjaxIsSignedIn command");	
					}
										
				},
			  dataType: 'json'
		});		
	},

	doTookitSignIn: function()
	{
		var thisObj = this;		
	},
	doSignIn: function()
    {
		var thisObj = this;
		try
		{  			
			maLogOut();
			resetSuccessRegistration();
			setRegistrationType('er');			
			
			//MA_showLogin();
			//window.scrollTo(0, 0);
			thisObj.doToolkitSignIn();

		  }catch(e){  }
    },

    doTookitSignOut: function()
	{
		var thisObj = this;
		var SignOutUrl = $('#SPS-Toolkit-Nav-SignOutLink').attr('href');
		window.location.href=SignOutUrl;		
	},
    doSignOut: function()
    {
    	var thisObj = this;
		try
		{  
			maLogOut();
		}catch(e){  }
    	
    },
	getQueryVariable: function(variable)
	{
		var query = window.location.search.substring(1);
		var vars = query.split("&");
  		for (var i=0;i<vars.length;i++) {
		    var pair = vars[i].split("=");
    		if (pair[0] == variable) return pair[1];    
  		}   
	},
	aShowMyAccount: function()
	{
		var thisObj = this;
		if ( location.hash == '#done' ) return;
        if ( thisObj.getQueryVariable('login') == 'y' ) { location.hash='#done'; MA_showLogin(); }
        if ( thisObj.getQueryVariable('myaccount') == 'y' ) { location.hash='#done'; MA_show(); }

	},
	showMyAccount: function()
	{
		MA_show();
	},
	showRegistration: function()
	{
		/* 
			NOT USED IN CPTK  		
		*/
	},
	hook: function(){ 
    	window.location.reload(); 
    },
	initHook: function()
	{
		var thisObj = this;
	},

	executeMyAccountCloseHook: function()
	{
		var thisObj = this;
	},
	executeSignOutHook: function()
	{
		var thisObj = this;
		thisObj.doTookitSignOut();
		
	},
	executeOnSuccessRegistrationHook: function()
	{
		var thisObj = this;

	}
} // MyAccount



function myAccoutCloseHook()
{  CPTK_SPS_MyAccount.executeMyAccountCloseHook(); }
/* This function onSuccessRegistration() is used only in SSO buy eBooks login/Registration */
/*
function onSuccessRegistration()
{  CPTK_SPS_MyAccount.executeMyAccountCloseHook(); }
*/
function onGenericSuccessRegistrationHook()
{  CPTK_SPS_MyAccount.executeMyAccountCloseHook(); }
function onGenericSuccessLoginHook()
{ CPTK_SPS_MyAccount.executeMyAccountCloseHook(); }

function onSignOutHook()
{  CPTK_SPS_MyAccount.executeSignOutHook(); }


/*
function setMyAccountCloseHook(hook){ myAccoutCloseHook = hook; }
function setOnSignOutHook(hook){ onSignOutHook = hook; }
function setOnSuccessRegistration(hook){ onSuccessRegistration = hook; }
function setShopForEBooksHook(hook){ shopForEbooksHook = hook; }
function setShopForGradeEBooksHook(hook){ shopForGradeEBooksHook = hook; }
function setAboutUsHook(hook){ aboutUsHook = hook; }
function setViewEBookDetailsHook(hook){ viewEBookDetailsHook = hook; }
function setDownloadeReaderHook(hook){ downloadeReaderHook = hook; }
function getDownloadeReaderHook(){ return downloadeReaderHook; }
*/


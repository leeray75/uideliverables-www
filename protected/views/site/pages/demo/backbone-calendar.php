<?php
/* @var $this SiteController */
$this->pageCSS = array(
/* "/www/content/css/jquery-ui-1.10.3.custom.css", */
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"/www/content/css/portfolio.css",
	"/www/content/plugins/fullcalendar/fullcalendar.css",
	 "/www/content/css/portfolio/calendar.css", 
	 "//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css",
);
$this->pageJS = array(

	//"/www/content/js/libs/jquery/jquery-ui-1.9.1.custom.js",
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",	
	"//code.jquery.com/ui/1.9.2/jquery-ui.min.js",
	"/www/content/js/libs/modernizr/modernizr-custom-2.6.2.js",
	//"/www/content/js/libs/jquery/plugins/jquery.simplemodal-1.4.4.js",
	"/www/content/js/libs/jquery/plugins/jquery.NobleCount.js",
	"/www/content/plugins/fullcalendar/fullcalendar.js",
	"/www/content/js/libs/jquery/plugins/jquery-ui-timepicker-addon.js",
	"/www/content/js/models/Calendar/Event.js",	
	"/www/content/js/collections/Calendar/EventsCollection.js",	
	"/www/content/js/views/Calendar/ModalViews.js",	
	"/www/content/js/views/Calendar/FullCalendarView.js",
	"/www/content/js/views/Calendar/EventsListView.js",
    "/www/content/js/apps/Calendar.js",
	
);

$this->metaKeyWords = "html, css, javascript, jquery, ajax, json, backbone.js, fullcalendar, calendar, events, REST";
$this->metaDescription = "An events calendar developed with Backbone.js and FullCalendar";
$this->pageTitle=Yii::app()->name . ' - Demo: Calendar';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Calendar'
);
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/page.php"; ?>


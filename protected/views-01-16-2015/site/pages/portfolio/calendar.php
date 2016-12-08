<?php
/* @var $this SiteController */
$this->pageCSS = array(
	"/www/content/css/portfolio.css",
	"/www/content/plugins/fullcalendar/fullcalendar.css",
	"/www/content/css/portfolio/calendar.css",
);
$this->pageJS = array(
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
$this->pageTitle=Yii::app()->name . ' - Portfolio: Calendar';
$this->breadcrumbs=array(
	'Portfolio'=>array('/site/page/?view=portfolio'), 
	'Calendar'
);
?>

<section class="top-content clear-fix">
  <div class="top-copy">
    <h1>Events Calendar</h1>
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/top-copy.html"; ?>
  </div>
  <!-- /top-copy -->
  <div class="resource-box">
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/resource-box.html"; ?>
  </div>
  <!-- /resource-box --> 
</section>
<!-- /top-content -->
<section id="tabs-container">
  <ul>
    <li id="calendar-tab"><a href="#calendar">Calendar</a></li>
    <li id="events-list-tab"><a href="#events-list">Current &amp; Future Events List</a></li>
  </ul>
<div id="calendar"></div>
<div id="events-list">
	<div id="active-events-list">
    
    </div>
    <!-- /active-events-list -->
</div>
</section>
<!-- /tabs-container -->

<!--#include virtual="/bookfairs/cptoolkit/common_includes/templates/PlanningCalendarAndTimeline/CAL-Overlay-Modals-Templates.html" -->
<?php //include $_SERVER['DOCUMENT_ROOT']."/www/content/templates/calendar/calendar-modals-template.html"; ?>
<?php //include $_SERVER['DOCUMENT_ROOT']."/www/content/templates/calendar/event-list-item-template.html"; ?>

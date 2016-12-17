
<?php
/* @var $this SiteController */
	$this->pageCSS = array(
		"/www/content/css/resume.css",
	);
	$this->pageJS = array(
		"/www/content/js/resume.js",
	);
$this->metaKeyWords = "resume, html, html5, css, css3, javascript, jquery, ajax, json, frontend, front-end, developer, AngularJS, Backbone.js, Bootstrap";
$this->metaDescription = "Raymond Lee's resume. Front-End web developer. Experience with HTML/HTML5, CSS/CSS3, JavaScript, jQuery, AngularJS, Backbone.js,  Bootstrap, and JSON.";
$this->pageTitle=Yii::app()->name.': Raymond Lee\'s Resume - Front End Web Developer ';
$this->breadcrumbs=array(
	'Resume',
);
?>


<!-- This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.
$_SERVER['DOCUMENT_ROOT']
-->

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/resume.html"; ?>




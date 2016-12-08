
<?php
/* @var $this SiteController */
	$this->pageCSS = array(
		"/www/content/css/resume.css",
	);
	$this->pageJS = array(
		"/www/content/js/resume.js",
	);
$this->metaKeyWords = "resume, html, css, javascript, jquery, ajax, json, frontend, front-end, developer, AngularJS, Backbone.js, Bootstrap";
$this->metaDescription = "Raymond Lee's resume. Front-End web developer. Experience with HTML, CSS, JavaScript, jQuery, AngularJS, Backbone.js,  Bootstrap, and JSON.";
$this->pageTitle=Yii::app()->name . ' - Frontend Web Developer - Raymond Lee\'s Resume';
$this->breadcrumbs=array(
	'Resume',
);
?>


<!-- This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.
$_SERVER['DOCUMENT_ROOT']
-->

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/resume.html"; ?>




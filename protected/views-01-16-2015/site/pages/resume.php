<?php
/* @var $this SiteController */
	$this->pageCSS = array(
		"/www/content/css/resume.css",
	);
	$this->pageJS = array(
		"/www/content/js/resume.js",
	);
$this->metaKeyWords = "resume, portfolio, html, css, javascript, jquery, ajax, json";
$this->metaDescription = "Raymond Lee's resume. CAREER OBJECTIVE: To work in a dynamic learning environment where I can contribute my current skills, and grow through new opportunities.";
$this->pageTitle=Yii::app()->name . ' - Resume';
$this->breadcrumbs=array(
	'Resume',
);
?>
<!-- This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.
$_SERVER['DOCUMENT_ROOT']
-->

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/resume.html"; ?>




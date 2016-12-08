<?php
/* @var $this SiteController */
$this->pageCSS = array(
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"/www/content/css/portfolio.css",
);
$this->pageJS = array(
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",	
	"//code.jquery.com/ui/1.9.2/jquery-ui.min.js",
	"/www/content/js/libs/modernizr/modernizr-custom-2.6.2.js",
	"/www/content/js/demos.js",
);

$this->metaKeyWords = "html, css, javascript, jquery, bootstrap, less, demo, portfolio";
$this->metaDescription = "A demo of a Bootstrap website demo for Skill Junction";
$this->pageTitle=Yii::app()->name . ' - Bootstrap Demo: Skill Junction';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Bootstrap: Skill Junction'
);
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/bootstrap/skill-junction/page.php"; ?>



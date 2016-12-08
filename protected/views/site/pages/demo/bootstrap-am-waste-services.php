<?php
header( 'Location: http://www.uideliverables.com/www/' ) ;
die();
/* @var $this SiteController */
$this->pageCSS = array(
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"/www/content/css/portfolio.css",
);
$this->pageJS = array(
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",	
	"//code.jquery.com/ui/1.9.2/jquery-ui.min.js",
	"/www/content/js/libs/modernizr/modernizr-custom-2.6.2.js",
);

$this->metaKeyWords = "html, css, javascript, jquery, bootstrap, less, demo, portfolio";
$this->metaDescription = "A demo of a Bootstrap website demo for AM Waste Services";
$this->pageTitle=Yii::app()->name . ' - Bootstrap Demo: AM Waste Services';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Bootstrap: AM Waste Services'
);
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/bootstrap/AM-Waste-Services/page.php"; ?>



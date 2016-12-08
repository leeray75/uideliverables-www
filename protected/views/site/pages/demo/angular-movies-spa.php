<?php
/* @var $this SiteController */
$this->pageCSS = array(
/* "/www/content/css/jquery-ui-1.10.3.custom.css", */
//"/mediamorph/css/global.css",s
	"/www/content/css/portfolio.css",
	"/www/content/css/portfolio/movies-rating-v2.css",
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css",
	// "/www/content/css/jquery-ui-1.10.3.custom.css",
	 "/www/content/js/libs/jquery/plugins/rateit/rateit.css",
	 "/www/content/css/xeditable.css",
	 
);


$this->pageJS = array(

	"//code.jquery.com/ui/1.10.4/jquery-ui.min.js",
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",
	"/www/content/js/demos/Movies-AngularJS.js",
	"/www/content/js/libs/jquery/plugins/rateit/jquery.rateit-modified.js",
	//"/www/content/js/libs/jquery/plugins/jeditable/jquery.jeditable-1.7.3.js",
	"//cdnjs.cloudflare.com/ajax/libs/jeditable.js/1.7.3/jeditable.min.js",
	"/www/content/js/libs/jquery/plugins/jeditable/jquery.jeditable.masked.js",	
	//"/www/content/js/libs/jquery/plugins/jquery.maskedinput.js",
	"//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.min.js",
//	"/www/content/js/libs/angular/angular-1.3.11/angular.min.js",	
	"//ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular-route.min.js",
	"/www/content/js/libs/angular/angular-ngStorage.js",
	//"/www/content/js/libs/angular/angular-animate.min.js",
	"/www/content/js/apps/MoviesDemo-Angular-v2.js",
	"/www/content/js/services/MoviesServices.js",
	"/www/content/js/controllers/Movies/MoviesControllers-v2.js",
	"/www/content/js/directives/MoviesDirectives.js",
	"/www/content/js/directives/xeditable.min.js",
	
	//
);
/*
$this->pageJS = array(

"/www/content/js/libs/jquery/jquery-ui-1.10.3.custom.min.js",
//"/www/content/js/libs/angular.min.js",
//"/www/content/js/libs/angular/angular-route.min.js",
//"/www/content/js/libs/angular/angular-animate.min.js",
"/www/content/js/libs/backbone/backbone-min-1.0.0.js",	
"/www/content/js/models/Users/User.js",
"/www/content/js/main.js",

	"/www/content/js/libs/jquery/plugins/rateit/jquery.rateit-modified.js",
	//"/www/content/js/controllers/Movies/MoviesControllers.js",

);
*/

$this->metaKeyWords = "html, css, javascript, jquery, ajax, json, AnglarJS, movies, ratings, REST";
$this->metaDescription = "A movies demo with AngularJS SPA (Single Page Application).";
$this->pageTitle=Yii::app()->name . ' - Movies Single Page Application Demo with AngularJS';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Movies - AngularJS SPA'
);
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/page-movies-spa-angular.php"; ?>




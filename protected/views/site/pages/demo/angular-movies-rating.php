<?php
/* @var $this SiteController */
$this->pageCSS = array(
/* "/www/content/css/jquery-ui-1.10.3.custom.css", */
//"/mediamorph/css/global.css",s
	"/www/content/css/portfolio.css",
	 "/www/content/css/jquery-ui-1.10.3.custom.css",
	 "/www/content/js/libs/jquery/plugins/rateit/rateit.css",
	 "/www/content/css/portfolio/movies-rating.css",
);


$this->pageJS = array(

	"/www/content/js/libs/jquery/jquery-ui-1.10.3.custom.min.js",
	"/www/content/js/libs/jquery/plugins/rateit/jquery.rateit-modified.js",
	"/www/content/js/libs/angular/angular-route.min.js",
	"/www/content/js/apps/MoviesDemo-Angular.js",
	"/www/content/js/controllers/Movies/MoviesControllers.js",
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

$this->metaKeyWords = "html, css, javascript, jquery, ajax, json, angularjs, movies, ratings REST";
$this->metaDescription = "A problem and solution to a movies rating problem";
$this->pageTitle=Yii::app()->name . ' - Demo: Movies Rating Demo';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Movies Rating'
);
?>

<section class="top-content clear-fix row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="top-copy">
      <h1>Movies Rating - AngularJS</h1>
      <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/top-copy-angular.html"; ?>
    </div>
    <!-- /top-copy --> 
  </div>
</section>
<!-- /top-content -->

<section id="MoviesListView">
  <div class="main" ng-view></div>
</section>



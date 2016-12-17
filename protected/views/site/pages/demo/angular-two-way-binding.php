<?php
/* @var $this SiteController */
$this->pageCSS = array(
/* "/www/content/css/jquery-ui-1.10.3.custom.css", */
//"/mediamorph/css/global.css",s
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"/www/content/css/portfolio.css",
	"/www/content/css/portfolio/angular-two-way-binding.css",
);


$this->pageJS = array(
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",
	"/www/content/js/libs/jquery/jquery-ui-1.10.3.custom.min.js",
	"/www/content/js/controllers/two-way-binding.js",
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

$this->metaKeyWords = "html, css, javascript, jquery, ajax, json, php, mysql, database, mvc, demo, angularjs, two way data binding";
$this->metaDescription = "A demo of AngularJS and Two Way Data Binding.";
$this->pageTitle=Yii::app()->name . ': AngularJS - Two Way Data Binding';
$this->breadcrumbs=array(
	'Demos'=>array('/demo'), 
	'Two Way Data Binding'
);
?>
<article itemscope itemtype="http://schema.org/Article">
    <section class="top-content clear-fix">
        <div class="top-copy">
          <h1 itemprop="name">AngularJS: Two Way Data Binding</h1>
          <div itemprop="description">
          <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/two-way-binding/top-copy.html"; ?>
          </div>
        </div>
        <!-- /top-copy -->
    </section>
    <!-- /top-content -->
    <h3>DEMO</h3>
    <div class="code">
      <div id="TWO-WAY-BINDING">
        <div ng-app="TwoWayBindingApp" id="ng-app" class="main">
          <div ng-controller="commentsController">
            <div class="row"> 
              <!-- Update Box -->
              <div class="col-xs-8 col-sm-10">
                <textarea name="submitComment" ng-model="comment.msg" placeholder="What are you thinking?"></textarea>
              </div>
              <div class="col-xs-4 col-sm-2"> <a href="javascript:void(0);" class="button" ng-click="addComment(comment)">POST</a> </div>
            </div>
            <!-- Comments -->
            <div ng-repeat="comment in comments">
              <div class="updates"> <a href="javascript:void(0);" ng-click="deleteComment($index);">Delete</a> {{comment.msg}} </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /#TWO-WAY-BINDING --> 
    </div>
    <section class="clear-fix row">
        <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/two-way-binding/bottom-copy.html"; ?>
    
    </section>
</article>

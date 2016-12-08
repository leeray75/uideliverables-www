
<?php
/* @var $this SiteController */
$this->pageCSS = array(
/* "/www/content/css/jquery-ui-1.10.3.custom.css", */
//"/mediamorph/css/global.css",
	"//google-code-prettify.googlecode.com/svn/loader/prettify.css",
	"/www/content/css/portfolio.css",
	 "/www/content/css/jquery-ui-1.10.3.custom.css",
	 "/www/content/js/libs/jquery/plugins/rateit/rateit.css",
	 "/www/content/css/portfolio/movies-rating.css",
);


$this->pageJS = array(
	"//google-code-prettify.googlecode.com/svn/loader/run_prettify.js",
	"/www/content/js/libs/jquery/jquery-ui-1.10.3.custom.min.js",
	"/www/content/js/libs/jquery/plugins/rateit/jquery.rateit-modified.js",
	"/www/content/js/models/Movies/MovieModel.js",
	"/www/content/js/collections/Movies/MoviesCollection.js",
	"/www/content/js/views/Movies/MoviesListView.js",
	"/www/content/js/apps/MoviesDemo.js",
);

$this->metaKeyWords = "html, css, javascript, jquery, ajax, json, backbone.js, movies, ratings REST";
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
    <h1>Movies Rating - backbone.js</h1>
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/top-copy.html"; ?>
  </div>
  <!-- /top-copy --> 
  </div>
</section>
<!-- /top-content -->

<section id="tabs-container" class="row">
  <div role="tabpanel"> 
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" aclass="active"><a href="#demo" aria-controls="demo" role="tab" data-toggle="tab">Demo</a></li>
      <li role="presentation"><a href="#file-structure" aria-controls="file-structure" role="tab" data-toggle="tab">File Structure</a></li>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="demo"> 
        <section id="MoviesListView">
          <ul id="movies-list">
          </ul>
          <!-- /movies-list --> 
        </section>      
      </div>
      <div role="tabpanel" class="tab-pane" id="file-structure">
        <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/tab-file-structure.html"; ?>
      </div>
    </div>
  </div>
</section>
<!-- /tabs-container --> 


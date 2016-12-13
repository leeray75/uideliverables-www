<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$this->pageCSS = array(
	"/www/content/css/homepage.css",
	/* "/www/content/plugins/bxSlider/jquery.bxslider.css", */
);
$this->pageJS = array(
	// "/www/content/plugins/bxSlider/jquery.bxslider.js",
	"/www/content/js/libs/jquery/plugins/jquery.matchHeight.js",
	"/www/content/js/pages/homepage.js",
);

$this->metaKeyWords="HTML,CSS,JavaScript,jQuery,resume,portfolio,rss,demos,contact";
$this->metaDescription="Welcome to UI Deliverables! I am a front-end developer with experience in developing in HTML, JavaScript, CSS.";
?>

<div id="welcome-hero" class="jumbotron">
  <div class="row">
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/homepage/hero-content.html"; ?>
	</div>
	<!-- /row -->
</div>
<!-- /Welcome-Hero -->

<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/homepage/bottom-content.html"; ?>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$this->pageCSS = array(
	"/www/content/css/homepage.css",
	"/www/content/plugins/bxSlider/jquery.bxslider.css",
);
$this->pageJS = array(
	"/www/content/plugins/bxSlider/jquery.bxslider.js",
	"/www/content/js/pages/homepage.js",
);

$this->metaKeyWords="HTML,CSS,JavaScript,jQuery,resume,portfolio";
$this->metaDescription="Welcome to UI Deliverables! I am Raymond Lee. This is my online portfolio. I am a Front-End Web Developer living in Edison, NJ!";
?>

  <div id="Hero-Slider-Container">
    <ul class="bxSlider">
      <li>
        <div id="Welcome-Hero" class="hero-unit">
          <h1>Welcome to <?php echo CHtml::encode(Yii::app()->name); ?></h1>
          <p>Hi, I am a front-end developer looking to work in a dynamic learning environment where I can contribute my current skills, and grow through new opportunities.</p>
          <p><a class="btn btn-primary btn-large" href="/www/index.php/site/page?view=resume">My Resume &raquo;</a></p>
          <div id="toon-image"><img src="/www/content/images/download/_TOON4.GIF" /></div><!-- /toon-image -->
        </div>
        <!-- .hero-unit --> 
      </li>
      <li>
        <div class="hero-unit">
        	<h2>Events Calendar</h2>
          <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/top-copy.html"; ?>
          <a id="Events-Calendar-Button" class="btn btn-primary btn-large" href="/www/index.php/site/page?view=portfolio&portfolio=calendar">Events Calendar &raquo;</a>
          <div id="calendar-icon"><a href="/www/index.php/site/page?view=portfolio&amp;portfolio=calendar"><img width="128" height="128" alt="Calendar" src="/www/content/images/icons/Calendar_icon.png"></a></div>
        </div>
        <!-- .hero-unit --> 
      </li>
    </ul>
  </div>
  <!-- /Hero-Slider-Container -->
  
  <div class="row">
    <div class="span4 box">
      <h2>My Resume</h2>
      <p>A document that present my backgrounds and skills. It contains a summary of my relevant job experience, technical skills, and education.</p>
      <p><a class="btn" href="/www/index.php/site/page?view=resume">Resume &raquo;</a></p>
    </div>
    <!-- .span4 -->
    
    <div class="span4 box">
      <h2>Contact Me</h2>
      <p>Please feel free to contact me if you have any questions, comments, or suggestions. I will receive everything sent through this contact form.</p>
      <p><a class="btn" href="/www/index.php/site/contact">Contact Me &raquo;</a></p>
    </div>
    <!-- .span4 -->
    
    <div class="span4 box">
      <h2>My Portfolio</h2>
      <p>A list of sites and other projects I've coded recently. It also displays some personal project demos and prototypes I am working on.</p>
      <p><a class="btn" href="/www/index.php/site/page?view=portfolio">Portfolio &raquo;</a></p>
    </div>
    <!-- .span4 --> 
  </div>
  <!-- .row --> 


<!DOCTYPE HTML>
<?php
	$ServerName = $_SERVER['SERVER_NAME'];
	if($ServerName != 'localhost' && $ServerName == "uideliverables.com"){
		$ServerName = "www.uideliverables.com";	
	}	
	if( $_SERVER["REQUEST_URI"] == "/www/index.php/site/page?view=resume"){
		header("HTTP/1.1 301 Moved Permanently");		
		header("Location: http://".$ServerName."/www/index.php/resume"); 
	}
	elseif($_SERVER['SERVER_NAME']!="localhost" && $_SERVER['SERVER_NAME']=="uideliverables.com"){
		header("HTTP/1.1 301 Moved Permanently");		
		header("Location: http://".$ServerName.$_SERVER["REQUEST_URI"]); 
	}
?>

<?php /* @var $this Controller */ 
	include_once "includes/check-crawlers.php"; 
	echo "<!-- isSSL: ".$this->isSSL." -->";
	
	if ( (isset($this->isSSL) and $this->isSSL === true) and (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
		if(!headers_sent()) {
			header("Status: 301 Moved Permanently");
			header(sprintf(
				'Location: https://%s%s',
				$_SERVER['HTTP_HOST'],
				$_SERVER['REQUEST_URI']
			));
			exit();
		}
	}
	else if((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on')){
		
		if(isset($this->isSSL) and !$this->isSSL === true)
		{
			if(!headers_sent()) {
				header("Status: 301 Moved Permanently");
				header(sprintf(
					'Location: http://%s%s',
					$_SERVER['HTTP_HOST'],
					$_SERVER['REQUEST_URI']
				));
				exit();
			}
		}
	}


?>
<!-- 
<?php /* echo 'Current PHP version: ' . phpversion(); */ ?>
-->
<?php 
$baseURL = Yii::app()->request->baseUrl;
header('Content-language: en');
if(isset($_GET["demo"]) and ($_GET["demo"] == "angular-movies-rating"))
{
	echo('<html lang="en" ng-app="myApp">');
}else{
	echo('<html lang="en">');
}
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--
<meta name="google-site-verification" content="EPIlhr6_ScpRyrPBAia0j6H8ooaKOa4Y8nmF9SrSZv4" />
-->
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<link href='//fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300,300italic,600,400italic,600italic,700,700italic,800,800italic|Roboto+Condensed:400,300,300italic,400italic,700,700italic|Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic|PT+Sans:400,400italic,700,700italic|Droid+Serif:400,400italic,700,700italic|Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic|Merriweather:400,300,300italic,400italic,700,700italic,900,900italic|Play:400,700' rel='stylesheet' type='text/css'>
<?php if(isset($this->metaDescription)): ?>
<meta name="description" content="<?php echo $this->metaDescription; ?>">
<?php endif ?>
<?php if(isset($this->metaKeywords)): ?>
<meta name="keywords" content="<?php echo $this->metaKeywords; ?>">
<?php endif ?>
<?php 
$crawler = isSpider($_SERVER['HTTP_USER_AGENT']);

if(!$crawler){
	include_once "includes/css-files.php"; 
	include_once "includes/js-files.php"; 
}
?>

<meta name="author" content="Raymond Lee" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="page" data-role="page">
  <?php include "includes/header.php" ?>
  <section id="main" class="container" data-role="content">
      <?php if(isset($this->breadcrumbs)):?>
      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
      <!-- breadcrumbs -->
      
      <?php endif?>
      <?php echo $content; ?> 
  </section>
  <!-- /main --> 
</div>
<!-- page -->
<footer data-role="footer">
  <div class="container content-container"> Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
    All Rights Reserved.<br/>
    <?php echo Yii::powered(); ?> </div>
  <!-- /content-container --> 
</footer>
<div id="UIDeliverablesLogin">
  <div ng-include src="'/www/content/partials/global/login-modal.html'"></div>
</div>
<?php 
if(strpos($_SERVER['SERVER_NAME'], "localhost")===false){
	include_once $_SERVER['DOCUMENT_ROOT']."/analyticstracking.php"; 
}
?>

<!--
<script type="text/javascript">stLight.options({publisher: "0749a3e4-1b28-453c-8ace-e949971754c9", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script>
var options={ "publisher": "0749a3e4-1b28-453c-8ace-e949971754c9", "logo": { "visible": true, "url": "http://www.uideliverables.com/", "img": "http://www.uideliverables.com/www/content/images/global/logo-UIDeliverables.png", "height": 30}, "ad": { "visible": false, "openDelay": "5", "closeDelay": "0"}, "livestream": { "domain": "", "type": "sharethis"}, "ticker": { "visible": false, "domain": "", "title": "", "type": "sharethis"}, "facebook": { "visible": false, "profile": "sharethis"}, "fblike": { "visible": false, "url": ""}, "twitter": { "visible": false, "user": "sharethis"}, "twfollow": { "visible": false}, "custom": [{ "visible": false, "title": "Custom 1", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}, { "visible": false, "title": "Custom 2", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}, { "visible": false, "title": "Custom 3", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}], "chicklets": { "items": ["facebook", "twitter", "linkedin", "pinterest", "email", "sharethis"]}};
var st_bar_widget = new sharethis.widgets.sharebar(options);
</script>
-->
</body>
</html>
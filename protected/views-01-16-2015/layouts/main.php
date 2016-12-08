<?php /* @var $this Controller */ 

$baseURL = Yii::app()->request->baseUrl;
?>
<!DOCTYPE HTML>
<!-- 
<?php echo 'Current PHP version: ' . phpversion(); ?>
-->
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<?php
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
<?php if(isset($this->metaDescription)): ?>
<meta name="description" content="<?php echo $this->metaDescription; ?>">
<?php endif ?>
<?php if(isset($this->metaKeywords)): ?>
<meta name="keywords" content="<?php echo $this->metaKeywords; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php endif ?>
<meta name="author" content="Raymond Lee" />
<?php include_once "includes/js-files.php"; ?>
<?php include_once "includes/css-files.php"; ?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<!-- Google Tag Manager -->

<div class="container" id="page" data-role="page">
  <?php include "includes/header.php" ?>
  <section id="main" data-role="content">
    <div class="content-container clearfix">
    	
      <?php if(isset($this->breadcrumbs)):?>
      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
      <!-- breadcrumbs -->
      
      <?php endif?>
 		
      <?php echo $content; ?> 
      </div>
    <!-- /content-container --> 
  </section>
  <!-- /main -->
  <footer data-role="footer">
    <div class="content-container clearfix">
      <div id="linkedin-plugin-container"> 
        <!--
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
--> 
<!--
        <script language="javascript">
	LazyLoad.js("//platform.linkedin.com/in.js", function () {});
</script> 
        <script type="IN/MemberProfile" data-id="http://www.linkedin.com/pub/raymond-lee/3/946/382" data-format="click" data-related="false"></script> 
        -->
      </div>
      <!-- /linkedin-plugin-container --> 
      Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
      All Rights Reserved.<br/>
      <?php echo Yii::powered(); ?> </div>
    <!-- /content-container --> 
  </footer>

</div>
<!-- page -->

<?php include_once $_SERVER['DOCUMENT_ROOT']."/analyticstracking.php"; ?>
<!-- Piwik -->
<?php
if(!(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on'))
{
?>
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.uideliverables.com/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "1"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; 
	s.parentNode.insertBefore(g,s);
  })();
</script> 
<!-- End Piwik Code -->
<?php } ?>
</body>
</html>

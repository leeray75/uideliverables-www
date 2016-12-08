<?php 
$cssArray =  array(
    /* $baseURL."/content/css/reset.css", */
	 
	 //$baseURL."/content/css/bootstrap.min.css", 
	/* $baseURL."/content/css/jquery-ui-1.10.3.custom.css", */
	/* $baseURL."/content/plugins/jquery.mobile/1.3.2/jquery.mobile-1.3.2.min.css", */
	"//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css",
     $baseURL."/content/css/global.css", 
);
$cssArray = isset($this->pageCSS) ? array_merge($cssArray, $this->pageCSS) : $cssArray;
	foreach ($cssArray as &$cssHref) {
		echo '<link rel="stylesheet" type="text/css" href="'.$cssHref.'" />'."\r\n";
	}
/*
if(isset($_GET["debug"]))
{
	foreach ($cssArray as &$cssHref) {
		echo '<link rel="stylesheet" type="text/css" href="'.$cssHref.'" />'."\r\n";
	}
}
else
{
	echo "<!-- ### These files are combined using minify ### -->"."\r\n";;
	echo "<!-- "."\r\n";;
	foreach ($cssArray as &$cssHref) {
		echo $cssHref."\r\n";
	}	
	echo "--> "."\r\n";;
	
	$cssListString = implode(",", $cssArray);		
	//echo '<link rel="stylesheet" type="text/css" href="/min/?f='.$cssListString.'" />'."\r\n"; 
	$cssURI = "/min/?f=".$cssListString;
	$cssURL = sprintf(
				'http://%s%s',
				$_SERVER['HTTP_HOST'],
				$cssURI
			);	
	$cssContent = file_get_contents($cssURL);
	echo "<style type='text/css'>"."\r\n".$cssContent."\r\n"."</style>"."\r\n";
}
*/
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="/www/content/js/html5shiv.min.js"></script>
  <script src="/www/content/js/respond.min.js"></script>
<![endif]-->

	
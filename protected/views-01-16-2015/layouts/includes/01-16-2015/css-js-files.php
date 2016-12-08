<?php 
$cssArray =  array(
    $baseURL."/content/css/reset.css",
	$baseURL."/content/css/bootstrap.min.css",
	$baseURL."/content/css/jquery-ui-1.10.3.custom.css",
    $baseURL."/content/css/global.css",
	
	
);
$cssArray = array_merge($cssArray, $this->pageCSS);
	
$jsArray =  array(
    $baseURL."/content/js/json2.js",
    $baseURL."/content/js/libs/jquery/jquery-1.9.1.min.js",
	$baseURL."/content/js/libs/jquery/jquery-ui-1.9.1.custom.js",
	$baseURL."/content/js/libs/underscore/underscore-1.5.2.js",
	$baseURL."/content/js/libs/backbone/backbone-min-1.0.0.js",	
	//$baseURL."/content/js/libs/bootstrap/bootstrap.min.js",
	$baseURL."/content/js/models/Users/User.js",
	$baseURL."/content/js/GlobalJQueryFunctions.js",
	$baseURL."/content/js/libs/jquery/plugins/jquery.simplemodal-1.4.4.js",
	$baseURL."/content/js/libs/jquery/plugins/jquery.NobleCount.js",
	
);

//$jsArray = array_merge($jsArray, $this->pageJS);
				 

if(isset($_GET["debug"]))
{
	$pageJS = $this->pageJS;
	foreach ($cssArray as &$cssHref) {
		echo '<link rel="stylesheet" type="text/css" href="'.$cssHref.'" />'."\r\n";
	}
	foreach ($jsArray as &$scriptSrc) {
		echo '<script src="'.$scriptSrc.'"></script>'."\r\n";
	}
	foreach ($pageJS as &$scriptSrc) {
		echo '<script src="'.$scriptSrc.'"></script>'."\r\n";
	}
}
else
{
	$pageJS = $this->pageJS;
	echo "<!-- ### These files are combined using minify ### -->"."\r\n";;
	echo "<!-- "."\r\n";;
	foreach ($cssArray as &$cssHref) {
		echo $cssHref."\r\n";
	}
	foreach ($jsArray as &$scriptSrc) {
		echo $scriptSrc."\r\n";
	}
	foreach ($pageJS as &$scriptSrc) {
		echo $scriptSrc."\r\n";
	}	
	echo "--> "."\r\n";;
	
	$cssListString = implode(",", $cssArray);		
	echo '<link rel="stylesheet" type="text/css" href="/min/?f='.$cssListString.'" />'."\r\n"; 	
	$jsListString = implode(",", $jsArray);	
	echo '<script src="/min/?f='.$jsListString.'"></script>'."\r\n";
	if(sizeof($pageJS) > 0)
	{ 
		$pageJS = implode(",",$pageJS);
		echo '<script src="/min/?f='.$pageJS.'"></script>'."\r\n";     
	}
}
?>

<script language="javascript" type="text/javascript">
user = new User({
	isGuest: <?php echo Yii::app()->user->isGuest==1 ? "true" : "false" ?>,
	isAdmin: <?php echo Yii::app()->user->isAdmin()==1 ? "true" : "false" ?>,
	id: "<?php echo Yii::app()->user->id ?>",
	username: "<?php echo Yii::app()->user->username ?>",
	email: "<?php echo Yii::app()->user->email ?>"	
});
</script>
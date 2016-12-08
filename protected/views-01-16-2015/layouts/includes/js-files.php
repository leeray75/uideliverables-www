<!-- <script src="//code.jquery.com/jquery-1.10.1.min.js" async="true"></script> -->
<script language="javascript">
var user = user || {};
var UserNav = UserNav || {};
var GlobalVariables = GlobalVariables || {};
</script>
<!-- ### Begin LazyLoad javascript ### -->
<script language="javascript">
LazyLoad=(function(doc){var env,head,pending={},pollCount=0,queue={css:[],js:[]},styleSheets=doc.styleSheets;function createNode(name,attrs){var node=doc.createElement(name),attr;for(attr in attrs){if(attrs.hasOwnProperty(attr)){node.setAttribute(attr,attrs[attr]);}}
return node;}
function finish(type){var p=pending[type],callback,urls;if(p){callback=p.callback;urls=p.urls;urls.shift();pollCount=0;if(!urls.length){callback&&callback.call(p.context,p.obj);pending[type]=null;queue[type].length&&load(type);}}}
function getEnv(){var ua=navigator.userAgent;env={async:doc.createElement('script').async===true};(env.webkit=/AppleWebKit\//.test(ua))||(env.ie=/MSIE|Trident/.test(ua))||(env.opera=/Opera/.test(ua))||(env.gecko=/Gecko\//.test(ua))||(env.unknown=true);}
function load(type,urls,callback,obj,context){var _finish=function(){finish(type);},isCSS=type==='css',nodes=[],i,len,node,p,pendingUrls,url;env||getEnv();if(urls){urls=typeof urls==='string'?[urls]:urls.concat();if(isCSS||env.async||env.gecko||env.opera){queue[type].push({urls:urls,callback:callback,obj:obj,context:context});}else{for(i=0,len=urls.length;i<len;++i){queue[type].push({urls:[urls[i]],callback:i===len-1?callback:null,obj:obj,context:context});}}}
if(pending[type]||!(p=pending[type]=queue[type].shift())){return;}
head||(head=doc.head||doc.getElementsByTagName('head')[0]);pendingUrls=p.urls;for(i=0,len=pendingUrls.length;i<len;++i){url=pendingUrls[i];if(isCSS){node=env.gecko?createNode('style'):createNode('link',{href:url,rel:'stylesheet'});}else{node=createNode('script',{src:url});node.async=false;}
node.className='lazyload';node.setAttribute('charset','utf-8');if(env.ie&&!isCSS&&'onreadystatechange'in node&&!('draggable'in node)){node.onreadystatechange=function(){if(/loaded|complete/.test(node.readyState)){node.onreadystatechange=null;_finish();}};}else if(isCSS&&(env.gecko||env.webkit)){if(env.webkit){p.urls[i]=node.href;pollWebKit();}else{node.innerHTML='@import "'+url+'";';pollGecko(node);}}else{node.onload=node.onerror=_finish;}
nodes.push(node);}
for(i=0,len=nodes.length;i<len;++i){head.appendChild(nodes[i]);}}
function pollGecko(node){var hasRules;try{hasRules=!!node.sheet.cssRules;}catch(ex){pollCount+=1;if(pollCount<200){setTimeout(function(){pollGecko(node);},50);}else{hasRules&&finish('css');}
return;}
finish('css');}
function pollWebKit(){var css=pending.css,i;if(css){i=styleSheets.length;while(--i>=0){if(styleSheets[i].href===css.urls[0]){finish('css');break;}}
pollCount+=1;if(css){if(pollCount<200){setTimeout(pollWebKit,50);}else{finish('css');}}}}
return{css:function(urls,callback,obj,context){load('css',urls,callback,obj,context);},js:function(urls,callback,obj,context){load('js',urls,callback,obj,context);}};})(this.document);
</script>
<!-- ### End LazyLoad javascript ### -->
<?php 
	
$jsArray =  array(
    $baseURL."/content/js/json2.js",
    $baseURL."/content/js/libs/jquery/jquery-1.9.1.min.js",
	$baseURL."/content/js/libs/bootstrap/bootstrap.min.js",
	$baseURL."/content/js/libs/modernizr/modernizr-custom-2.6.2.js",
	/* 
	$baseURL."/content/plugins/jquery.mobile/1.3.2/jquery.mobile-1.3.2.min.js",
	$baseURL."/content/js/libs/jquery/jquery-ui-1.9.1.custom.js",
	$baseURL."/content/js/libs/underscore/underscore-1.5.2.js",
	$baseURL."/content/js/libs/backbone/backbone-min-1.0.0.js",	
	
	
	$baseURL."/content/js/models/Users/User.js",
	$baseURL."/content/js/main.js",
	$baseURL."/content/js/libs/jquery/plugins/jquery.simplemodal-1.4.4.js", 
	*/
	
);

//$jsArray = array_merge($jsArray, $this->pageJS);
				 
$pageJS = isset($this->pageJS) ? $this->pageJS : array();
if(isset($_GET["debug"]))
{
	
	foreach ($jsArray as &$scriptSrc) {
		echo '<script src="'.$scriptSrc.'"></script>'."\r\n";
	}
	foreach ($pageJS as &$scriptSrc) {
		echo '<script src="'.$scriptSrc.'"></script>'."\r\n";
	}
}
else
{
	echo "<!-- ### These files are combined using minify ### -->"."\r\n";;
	echo "<!-- "."\r\n";;
	foreach ($jsArray as &$scriptSrc) {
		echo $scriptSrc."\r\n";
	}
	foreach ($pageJS as &$scriptSrc) {
		echo $scriptSrc."\r\n";
	}	
	echo "--> "."\r\n";;		
	$jsListString = implode(",", $jsArray);	

	//echo '<script src="/min/?f='.$jsListString.'"></script>'."\r\n";
	if(sizeof($pageJS) > 0)
	{ 
		$pageJS = implode(",",$pageJS);
		//echo '<script src="/min/?f='.$pageJS.'"></script>'."\r\n";     
	}

	$jsSrc = '/min/?f='.$jsListString;
}
?>

<script language="javascript" type="text/javascript">
var scriptsArray = new Array();
scriptsArray.push("/min/?f=<?php echo $jsListString; ?>");
<?php
if( !empty($pageJS))
{
	echo "scriptsArray.push('/min/?f=".$pageJS."');";
}
?>


function initUser()
{
	user = new User(<?php echo json_encode(Yii::app()->user->userProfile) ?>);
	<?php /*
	user = new User({
		isGuest: <?php echo Yii::app()->user->isGuest==1 ? "true" : "false" ?>,
		isAdmin: <?php echo Yii::app()->user->isAdmin()==1 ? "true" : "false" ?>,
		id: "<?php echo Yii::app()->user->id ?>",
		username: "<?php echo Yii::app()->user->username ?>",
		email: "<?php echo Yii::app()->user->email ?>"	
	});
	*/
	?>
}
<?php 
if(!isset($_GET["debug"]))
{
	echo "LazyLoad.js(scriptsArray, function () {});";
}
?>



</script>
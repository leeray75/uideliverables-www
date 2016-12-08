<?php
Yii::import('application.extensions.wikiext.wikiext');
$wiki=new wikiext();
/* @var $this SiteController */
	$this->pageCSS = array(
		"/www/content/css/about.css",
	);
	/*$this->pageJS = array(
		"/www/content/js/resume.js",
	);*/
$this->metaKeyWords = "about, UI, user, interface, human–computer interface, HCI, man–machine interface, MMI";
$this->metaDescription = "The user interface, in the industrial design field of human–machine interaction, is the space where interaction between humans and machines occurs.";
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<!-- This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.
$_SERVER['DOCUMENT_ROOT']
-->

<?php 
$result = file_get_contents('http://en.wikipedia.org/w/api.php?format=json&action=query&titles=User_interface&prop=revisions&rvprop=content'); 

$data = json_decode($result);
//$content = $data->query->pages->page->revisions->rev;
//echo var_dump(json_decode($json,true));

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($result, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);


//echo $result;
//include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/resume.html"; 

/*
$i = 0;
foreach($data->query->pages as $row)
{
	echo "i = ".$i."<br />";
	$i++;
	$j=0;
    foreach($row as $key => $val)
    {
		echo "j=".$j."<br />";
		$j++;
        echo $key . ': ' . $val;
        echo '<br>';
		$title = $key==="title" ? $val : $title;
		$article = $key==="revisions" ? $val : $article;		
    }

}
echo var_dump(json_encode($article));
$j = 0;
*/


	//$pages = json_decode(var_dump($data->query->pages), true);
	//echo "Page ID: ".$data["query"]["pages"][]["pageid"];
	//echo "Page ID: ".$data->query->pages->[1]->pageid;
	
	$title = "";
	$article = "";
	foreach ($jsonIterator as $key => $val) {
		
		if(is_array($val)) {
			//echo "$key:\n"."<br />";
		} else {
			//echo "$key => $val\n"."<br />";
		}
		
		$title = $key==="title" ? $val : $title;
		$article = $key==="*" ? $val : $article;
	
	}	
	
?>

<h1><?php echo $title; ?></h1>
<article>

<?php echo $wiki->parse( json_encode($result) ); ?>

</article>
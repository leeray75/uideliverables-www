<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$this->pageCSS = array(
	"/www/content/css/homepage.css",
	/* "/www/content/plugins/bxSlider/jquery.bxslider.css", */
);
$this->pageJS = array(
/*
	"/www/content/plugins/bxSlider/jquery.bxslider.js",
	*/
	"/www/content/js/pages/homepage.js",
);

$this->metaKeyWords="HTML,CSS,JavaScript,jQuery,resume,portfolio,rss,demos,contact";
$this->metaDescription="Welcome to UI Deliverables! I am a front-end developer with experience in developing in HTML, JavaScript, CSS.";
?>

<div id="Welcome-Hero" class="jumbotron">
  <div class="row">
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/homepage/hero-content.html"; ?>
	</div>
	<!-- /row -->
</div>
<!-- /Welcome-Hero -->

<div id="RSS-FEED" role="tabpanel">
  <h2>Front-End RSS Feeds</h2>
  <p>Some RSS feeds for front-end developers</p>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#css-tricks" aria-controls="css-tricks" role="tab" data-toggle="tab">CSS-Tricks</a></li>
    <!-- <li role="presentation"><a href="#smashing-magazine" aria-controls="smashing-magazine" role="tab" data-toggle="tab">Smashing Magazine</a></li> -->
    <li role="presentation"><a href="#codrops" aria-controls="codrops" role="tab" data-toggle="tab">Codrops</a></li>
  </ul>
  
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="css-tricks">
      <?php
	  
    $rss = new DOMDocument();
    $rss->load('http://feeds.feedburner.com/CssTricks');
    $feed = array();
    
    foreach ($rss->getElementsByTagName('item') as $node) {
        $item = array(
            'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
            'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
            'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
            'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
        );
        array_push($feed, $item);
    }
    $limit = 8;
    for ($x = 0; $x < $limit; $x++) {
        $title       = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
        $link        = $feed[$x]['link'];
        $description = $feed[$x]['desc'];
        $date        = date('l F d, Y', strtotime($feed[$x]['date']));
        echo '<p><strong><a href="' . $link . '" title="' . $title . '" target="CssTricks">' . $title . '</a></strong><br />';
        echo '<small><em>Posted on ' . $date . '</em></small></p>';
        echo '<p>' . $description . '</p>';
    }
	
    ?>
    </div><!-- /tab-pane -->
    <div role="tabpanel" class="tab-pane" id="smashing-magazin">
      <?php
		/*
		$rss = new DOMDocument();
		$rss->load('http://www.smashingmagazine.com/feed/');
		$feed = array();
		

		
		foreach ($rss->getElementsByTagName('item') as $node) {
			$desc = $node->getElementsByTagName('description')->item(0)->nodeValue;
			$tableStartPos = strpos($desc,"<table");
			$tableEndPos = strpos($desc,"</table>");
		
			if ($tableEndPos>-1 && $tableEndPos>0) {
				$tableEndPos += 8; //remove <em> tag aswell</table>
				$len = intval($tableEndPos) - intval($tableStartPos);
		
				$desc = substr_replace($desc, '', $tableStartPos, $len);
				$desc = $desc;
			}
			
			$item = array(
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $desc,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
			);
			array_push($feed, $item);
		}
		$limit = 8;
		for ($x = 0; $x < $limit; $x++) {
			$title       = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
			$link        = $feed[$x]['link'];
			$description = $feed[$x]['desc'];
			$date        = date('l F d, Y', strtotime($feed[$x]['date']));
			if($x>0){
				echo '<hr>';
			}
			echo '<p><strong><a href="' . $link . '" title="' . $title . '" target="SmashMagazine">' . $title . '</a></strong><br />';
			echo '<small><em>Posted on ' . $date . '</em></small></p>';
			echo '<p>' . $description . '</p>';
		}
	*/

    ?>
    </div><!-- /tab-pane -->
    <div role="tabpanel" class="tab-pane active" id="codrops">
      <?php
      
    $rss = new DOMDocument();
    $rss->load('http://tympanus.net/codrops/feed/');
    $feed = array();
    
    foreach ($rss->getElementsByTagName('item') as $node) {
        $item = array(
            'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
            'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
            'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
            'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
        );
        array_push($feed, $item);
    }
    $limit = 8;
    for ($x = 0; $x < $limit; $x++) {
        $title       = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
        $link        = $feed[$x]['link'];
        $description = $feed[$x]['desc'];
        $date        = date('l F d, Y', strtotime($feed[$x]['date']));
        echo '<p><strong><a href="' . $link . '" title="' . $title . '" target="CssTricks">' . $title . '</a></strong><br />';
        echo '<small><em>Posted on ' . $date . '</em></small></p>';
        echo '<p>' . $description . '</p>';
    }
	
    ?>
    </div><!-- /tab-pane -->
  </div><!-- /tab-content -->
</div>
<!-- /RSS-FEED --> 
<script language="javascript">
$('#RSS-FEED img').addClass('img-responsive');
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/homepage/bottom-content.html"; ?>
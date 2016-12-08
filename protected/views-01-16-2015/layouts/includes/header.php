<header id="fixed-header"  data-role="header">
  <section>
    <div class="content-container clearfix">
      <div id="logo"> <a href="/www/" title="UI Deliverables" class="uideliverables-logo"><span>UI Deliverables</span></a> </div>
      <!-- logo --> 
      <a href="#sidr" id="sidr-menu">&nbsp;</a>
      <div id="user-nav-view-container">
        <div id="user-nav-links" class="clear-fix">
          <?php 
     $this->widget('zii.widgets.CMenu',array(
        'items'=>array(			
            array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Register', 'url'=>array('/user/registration'), 'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest)
            
        ),
    )); 
    ?>
        </div>
        <!-- /user-nav-links -->         
      </div>
      <!-- /user-nav-view-container --> 
  
    </div>
    <!-- /content-container --> 
  </section>
  <nav>
    <div class="content-container clearfix">
      <?php $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array('label'=>'Home', 'url'=>array('/site/index')),
                    array('label'=>'My Resume', 'url'=>array('/site/page', 'view'=>'resume')),
                    array('label'=>'Contact', 'url'=>array('/site/contact')),
                    array('label'=>'Portfolio', 'url'=>array('/site/page', 'view'=>'portfolio'))
                    /*
                    array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    */
                ),
            )); ?>
		<div id="Google-Search-Container">
			<gcse:search></gcse:search>        
        </div>
        <!-- /Google-Search-Container -->                
    </div>
    <!-- /content-container --> 
  </nav>
</header>
<!-- header -->
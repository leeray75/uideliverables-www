<header>
  <nav id="UI-Deliverables-Nav" class="navbar navbar-default navbar-fixed-top navbar-inverse">
  <div class="container">
      <div class="ui-logo"> <a href="/www/"><img alt="UI Deliverables" src="/www/content/images/logos/UI-Deliverables.png" class="ui-logo-lg" ><img alt="UI Deliverables" src="/www/content/images/logos/UI-Deliverables-sm.png" class="img-responsive ui-logo-sm hidden-md hidden-lg" ></a>
      </div>  
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse"> <span class="sr-only">Toggle navigation</span> <!--<span class="glyphicon glyphicon-arrow-down"></span> MENU --> 
      <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    
      <div class="collapse navbar-collapse" id="collapse" >
        <ul class="nav navbar-nav">
          <li><a href="/www/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
          <li><a href="/www/index.php/resume"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> My Resume</a></li>
          <li><a href="/www/index.php/site/contact"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact</a></li>
          <li class="dropdown"><a href="/www/index.php/demo" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-list-alt" ariah-hidden="true"></span> Demos<span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
              <li><a href="/www/index.php/demo/angular-movies-spa"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Angular: Movie Single Page Application</a></li>
              <li><a href="/www/index.php/demo/backbone-calendar"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Backbone: Event Calendar</a></li>
              <li><a href="/www/index.php/demo/bootstrap-skill-junction"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Bootstrap: Skill Junction</a></li>
              <!--
              <li><a href="/www/index.php/demo/bootstrap-am-waste-services"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Bootstrap: 5 Page Bootstrap Website</a></li>
              -->
              <li><a href="/www/index.php/demo/angular-two-way-binding"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Angular: Two Way Data Binding</a> </li>
              <li><a href="/www/index.php/demo/angular-movies-rating"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Angular: Movie Rating</a> </li>
              <li><a href="/www/index.php/demo/backbone-movies-rating"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Backbone: Movie Rating</a> </li>
            </ul>
          </li>
          <!--
          <li class="dropdown"><a href="/www/index.php/portfolio" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-folder-open" ariah-hidden="true"></span>&nbsp;&nbsp;Portfolio<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="http://store.scholastic.com/" target="_blank"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Scholastic: Scholastic Store</a></li>
              <li><a href="http://shop.scholastic.com/" target="_blank"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"> </span> Scholastic: Teacher Store</a></li>

            </ul>          
          </li>
          -->
          <li>
          	<a href="javascript: void(0);" class="log-in-out-link"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="log-in-out-copy"><?php echo ( Yii::app()->user->isGuest==1) ? "Log In" : "Log Out" ?></span></a>
          </li>            
        </ul>
      </div><!-- /#collapse -->
    </div><!-- /container -->
  </nav>
</header>


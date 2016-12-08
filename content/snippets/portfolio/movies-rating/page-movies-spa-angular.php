
<section class="top-content row">
  <div class="col-xs-12">
    <div class="top-copy">
      <h1>Movies Single Page Application Demo with AngularJS</h1>
      <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/top-copy-angular-v2.html"; ?>
    </div>
    <!-- /top-copy --> 
  </div>
</section>
<!-- /top-content -->
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#demo" aria-controls="demo" role="tab" data-toggle="tab">Demo</a></li>  
  <li role="presentation"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
  
</ul>
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="demo">
    <section id="MoviesListView">
      <div ng-app="moviesApp">
        <div id="MoviesAppRow" class="row">
          <div id="MoviesSideNavColumn" class="col-md-2">
            <aside id="MoviesNavContainer" ng-controller="asideMenuController">
              <div id="Movie-Collapse-Menu">
                <ul class="movies-navbar" >
                  <li class="movies-brand-logo"><a href="/www/index.php/demo/angular-movies-spa#/"><img src="/www/content/images/logos/UI-Deliverables-Movies.gif" class="movie-logo img-responsive" /></a></li>
                  <li class="nav-link-item" ng-class="{active: menuActive == 'list'}"><a href="/www/index.php/demo/angular-movies-spa#/list" class="btn btn-default">Movies List <span class="glyphicon glyphicon-triangle-right"></span></a></li>
                  <li class="nav-link-item" ng-class="{active: menuActive == 'add'}"><a href="/www/index.php/demo/angular-movies-spa#/edit/preview/0" class="btn btn-default">Add Movie <span class="glyphicon glyphicon-triangle-right"></span></a></li>
                </ul>
              </div>
              <!-- /Movie-Collapse-Menu -->
              <div class="clear-fix"></div>
            </aside>
          </div>
          <!-- /MoviesSideNavColumn -->
          <div id="MoviesMainViewColumn" class="col-md-10">
            <div class="main" ng-view></div>
          </div>
          <!-- /MoviesMainViewColumn --> 
        </div>
        <!-- /MoviesAppRow --> 
      </div>
      <!-- /ng-app --> 
    </section>
  </div>
  <!-- /demo tab-pane -->
  <div role="tabpanel" class="tab-pane" id="details">
    <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/details-angular-v2.php"; ?>
  </div>
</div>
<!-- /tab-content --> 
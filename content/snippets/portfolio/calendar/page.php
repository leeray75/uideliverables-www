<article itemscope itemtype="http://schema.org/Article">
<div id="Calendar-App">
  <section class="top-content clear-fix row">
      <div class="top-copy">
        <h1 itemprop="name"> Backbone.js: Events Calendar Demo</h1>
        <div itemprop="description"><?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/top-copy.html"; ?></div>
      </div>
      <!-- /top-copy --> 

  </section>
  <!-- /top-content -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#demo" aria-controls="demo" role="tab" data-toggle="tab">Demo</a></li>
    <li role="presentation"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="demo">
      <section id="tabs-container">
        <div role="tabpanel"> 
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#calendar" id="calendar-tab" aria-controls="calendar" role="tab" data-toggle="tab">Calendar</a></li>
            <li role="presentation"><a href="#events-list" aria-controls="events-list" role="tab" data-toggle="tab">Current &amp; Future Events List</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="calendar"></div>
            <div role="tabpanel" class="tab-pane" id="events-list">
              <div id="active-events-list"> </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /tabs-container --> 
    </div>
    <!-- /demo tab-pane -->
    <div role="tabpanel" class="tab-pane" id="details" itemprop="articleBody">
      <?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/details.php"; ?>
    </div>
  </div>
  <!-- /tab-content --> 
</div>
<!-- /Calendar-App --> 
</article>


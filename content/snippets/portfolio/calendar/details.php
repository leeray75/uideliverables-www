<?php
	$CODE_PATH = $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/calendar/code/";
?>
<article id="DETAILS-CONTENT">
  <section id="About-Details">
    <h3>About</h3>
    <p>I wanted to learn more about Backbone.js and I had already started working on this when I was working at Scholatic for their Book Fair's Chairperson Toolkit application. The Calendar allows users to view events that are in the calendar. It also allows users who are logged in to create, edit, and delete their own events. The data for the calendar's events are stored in a MySQL database and have RESTful APIs to 'GET', 'POST', 'UPDATE', and 'DELETE' the data.</p>
  </section>
  <!-- /About-Details -->
  <section id="GettingStarted-Details">
    <h3>Getting Started</h3>
    <p>Before I do any of the front-end developement work. I first needed to take care of some of the back-end work. I'm not going to get into too much details about the back-end stuff, because my primary goal is to work with the Bootstrap.js. I decided to use a Events model that has the following attributes: title, if the event is all day, start/end date &amp; time, location, and description. In the MySQL database, I created the Events table and for the RESTful APIs, I added the 'event' API, to the backend PHP's Yii framework.</p>
  </section>
  <!-- /GettingStarted-Details -->
  <section id="JSON-SQL-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-JSON-SQL">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-JSON-SQL" href="#JSON-CODE">JSON - DATA MODEL</a> </div>
        <div id="JSON-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."JSON-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-JSON-SQL" href="#SQL-CODE">SQL - CREATE EVENTS TABLE</a> </div>
        <div id="SQL-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."SQL-CODE.html"; ?>
			</pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group --> 
    </div>
    <!-- /Accordian-JSON --> 
  </section>
  <!--/JSON-SQL-CODE-SECTION -->
  
  <section id="Templates-Details">
    <h3>Creating Template Views</h3>
    <p>Now is the time to start doing some front-end work. For this demo, there are 4 templates.</p>
    <ol>
      <li><b>Current &amp; Future Events List</b> - this is displayed in the Current &amp; Future Events List tab in the demo.</li>
      <li><b>Display Event Modal</b> - this shows the view for the modal that displays the event that the user clicks on.</li>
      <li><b>Add/Edit Event Modal</b>b> - this shows the view for the modal that allows users to add or edit an event.</li>
      <li><b>Delete Event Modal</b> - this shows the view for the modal that allows users to delete an event.</li>
    </ol>
  </section>
  <!-- /Templates-Details -->
  <section id="TEMPLATES-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-Templates-Code">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#LIST-TEMPLATE-CODE">TEMPLATE - CURRENT &amp; FUTURE EVENTS LIST</a> </div>
        <div id="LIST-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."LIST-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#DISPLAY-EVENT-MODAL-TEMPLATE-CODE">TEMPLATE - DISPLAY EVENT MODAL</a> </div>
        <div id="DISPLAY-EVENT-MODAL-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."DISPLAY-EVENT-MODAL-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#ADD-EDIT-MODAL-TEMPLATE-CODE">TEMPLATE - ADD/EDIT EVENT MODAL</a> </div>
        <div id="ADD-EDIT-MODAL-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."ADD-EDIT-EVENT-MODAL-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#DELETE-MODAL-TEMPLATE-CODE">TEMPLATE - DELETE EVENT MODAL</a> </div>
        <div id="DELETE-MODAL-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."DELETE-EVENT-MODAL-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group --> 
    </div>
    <!-- /Accordian-Templates-Code --> 
  </section>
  <!--/TEMPLATES-CODE-SECTION -->
  
  <section id="AppSetup-Details">
    <h3>Setting up the Application</h3>
    <p>Here's the list of Backbone's Model, Collection, and View objects:</p>
    <ul>
      <li><b>AppView</b> - the view that initializes and controls the FullCalendarView and the EventsListView.</li>
      <li><b>FullCalendarView</b> - the view that contols the display of the FullCalendar plugin with the events from the EventsCollection</li>
      <li><b>EventsListView</b> -  the view that contains the list of events</li>
      <li><b>EventListItemView</b> - the view that renders from the EventsListView to display each event item</li>
      <li><b>DisplayEventModalOverlayView</b> - the modal that displays the event</li>
      <li><b>AddEditEventModalOverlayView</b> - the modal that allows users to either add or edit a event</li>
      <li><b>DeleteEventModalOverlayView</b> - the modal that confirms if the user wants to delete a event</li>
      <li><b>Event</b> - the model for each calendar's events</li>
      <li><b>EventsCollection</b> - the collection of Event models</li>
    </ul>
  </section>
  <!-- /AppSetup-Details -->
  
  <section id="APP-SETUP-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-App-Setup">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#AppView-CODE">BACKBONE VIEW - AppView</a> </div>
        <div id="AppView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."APP-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#FullCalendarView-CODE">BACKBONE VIEW - FullCalendarView</a> </div>
        <div id="FullCalendarView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."FULL=CALENDAR-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#EventsListView-CODE">BACKBONE VIEW - EventsListView</a> </div>
        <div id="EventsListView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."EVENTS-LIST-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#EventsListItemView-CODE">BACKBONE VIEW - EventsListItemView</a> </div>
        <div id="EventsListItemView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."EVENT-LIST-ITEM-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#DisplayEventModalOverlayView-CODE">BACKBONE VIEW - DisplayEventModalOverlayView</a> </div>
        <div id="DisplayEventModalOverlayView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."DISPLAY-EVENT-MODAL-OVERLAY-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#AddEditEventModalOverlayView-CODE">BACKBONE VIEW - AddEditEventModalOverlayView</a> </div>
        <div id="AddEditEventModalOverlayView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."ADD-EDIT-EVENT-MODAL-OVERLAY-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#DeleteEventModalOverlayView-CODE">BACKBONE VIEW - DeleteEventModalOverlayView</a> </div>
        <div id="DeleteEventModalOverlayView-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."DELETE-EVENT-MODAL-OVERLAY-VIEW-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#EventModel-CODE">BACKBONE MODEL - Event</a> </div>
        <div id="EventModel-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."EVENT-MODEL-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->       
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#EventsCollection-CODE">BACKBONE COLLECTION - EventsCollection</a> </div>
        <div id="EventsCollection-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $CODE_PATH."EVENTS-COLLECTION-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->    
    </div>
    <!-- /Accordian-JSON --> 
  </section>
  <!--/APP-SETUP-CODE-SECTION -->
  <section id="Conclusion-Details">
    <h3>Conclusion</h3>
    <p>This was a great Backbone.js learning experience. The application needs some more UI enhancements and I'll probably make some more tweaks and enchancements from time to time.</p>
    <p>Thanks for visiting and feel free to try this Demo!</p>
    <p>-<span itemprop="name">Raymond Lee</span> 
  </section>
  <!-- /Conclusion-Details -->
  
  <section id="Conclusion-Details">
    <h3>Useful Resources</h3>
    <p>Here's a list of useful resources that I used to develop this application.</p>
    <ul>
      <li><a href="http://blog.shinetech.com/2011/08/05/building-a-shared-calendar-with-backbone-js-and-fullcalendar-a-step-by-step-tutorial/" target="_blank">Building a shared calendar with Backbone.js and FullCalendar</a> - this is the initial resource I used to help me develop this application. One thing to note is that the code they have wasn't compatible with the latest Backbone.js version.</li>
      <li><a href="http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/" target="_blank">How-To: Create a REST API</a> - this page was very helpful on helping me set up the RESTful APIs with the Yii framework.</li>
      <li><a href="http://backbonejs.org/" target="_blank">Backbone.js</a> - this is Backbone.js website. It will have full documentation on Backbone.js.</a>
      <li><a target="_blank" href="http://jquery.com/">jQuery</a> - a very useful and my favorite JavaScript library. Most of the plugins and code my AngularJS Directives were written with jQuery.</li>
      <li><a href="http://arshaw.com/fullcalendar/" target="_blank">FullCalendar</a> - this is the primary plugin that renders the calendar on the page. It has documentation on how to use the plugin.</li>
    </ul>
  </section>
  <!-- /Conclusion-Details --> 
</article>
<!-- /DETAILS-CONTENT --> 


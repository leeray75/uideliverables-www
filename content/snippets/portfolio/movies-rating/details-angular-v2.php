<article id="DETAILS-CONTENT">
  <section id="About-Details">
    <h3>About</h3>
    <p> I wanted to learn more about AngularJS and needed a project to work on. So I decided to build on a demo that I developed as an assignment from a job interview. In the original, I developed a prototype that received data from a API call and displayed the data in a templated view. It also notified users if their votes were successful or not. I created one version using Backbone.js and another using AngularJS. In this version, I wanted the data to be stored in a database and have RESTful APIs to 'GET', 'POST', 'UPDATE', and 'DELETE' the data.</p>
  </section>
  <!-- /About-Details -->
  <section id="GettingStarted-Details">
    <h3>Getting Started</h3>
    <p>Before I do any of the front-end developement work. I first needed to take care of some of the back-end work. I'm not going to get into too much details about the back-end stuff, because my primary goal is to work with the AngularJS framework. I decided to use the same movie data model for this project as the previous demo. In the MySQL database, the 'movies' table columns will match the keys from the JSON data model that I was using. For this demo, I wanted to keep things simple as possible. So, I only created two tables 'movies' and 'movies_votes'. I also created one view 'MoviesView' that joins the two tables.. For the RESTful APIs, I added the 'movie' API, to the backend PHP's Yii framework.</p>
  </section>
  <!-- /GettingStarted-Details -->  
  <section id="JSON-SQL-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-JSON-SQL">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-JSON-SQL" href="#JSON-CODE">JSON - DATA MODEL</a> </div>
        <div id="JSON-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/JSON-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-JSON-SQL" href="#SQL-CODE">SQL - CREATE MOVIES TABLE</a> </div>
        <div id="SQL-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/SQL-CODE.html"; ?>
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
    <p>Now is the time to start doing some front-end work. For this demo, there will be 3 templates that are needed. The first template is to list all the movies. This template will display the following attributes: title, poster image, rated, run time, genres, release date, plot, director, writer, stars, and the votes. In the list view, the user can edit or delete the movie, if they share the same user id as the user who created the movie, or if the user has admin privileges, that will be validated in the back-end. So, for this demo, I allow 'Guest' users to create movies and allow them to edit and/or delete other 'Guest' users' movies.</p>
    <p>The other two templates will be used to Add or Edit the movies.</p>
    <ol>
      <li>A traditional form input based UI.</li>
      <li>A preview inline editor.</li>
    </ol>
    <p>I didn't create separate location routes, templates, or controllers for the Add/Edit views. The two are really identical. Instead, I set the movie id to equal zero when I want to add a new movie. Otherwise the controller, will get the movie based on the id and will be in a edit mode.</p>
  </section>
  <!-- /Templates-Details -->
  <section id="TEMPLATES-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-Templates-Code">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#LIST-TEMPLATE-CODE">TEMPLATE - MOVIES LIST</a> </div>
        <div id="LIST-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/LIST-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#ADD-EDIT-FORM-TEMPLATE-CODE">TEMPLATE - ADD/EDIT FORM</a> </div>
        <div id="ADD-EDIT-FORM-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/ADD-EDIT-FORM-TEMPLATE-CODE.html"; ?>
             </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Templates-Code" href="#ADD-EDIT-INLINE-FORM-TEMPLATE-CODE">TEMPLATE - ADD/EDIT INLINE PREVIEW</a> </div>
        <div id="ADD-EDIT-INLINE-FORM-TEMPLATE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/ADD-EDIT-INLINE-FORM-TEMPLATE-CODE.html"; ?>
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
    <p>In this section, I defined the application's name 'moviesApp', and register these modules:</p>
    <ul>
      <li><b>ngRoute</b> - for the routing.</li>
      <li><b>moviesApp.services</b> - for the API calls</li>
      <li><b>movieApp.controllers</b> - for the application's controllers</li>
      <li><b>movieApp.directives'</b> - for the application's directives</li>
    </ul>
    <p>Now that I have my APIs and templates ready, I can configure and define the application's routers and services. With the three templates, I will set up three route locations that defaults to the list route. These three routes will be: </p>
    <ol>
      <li>Movies List</li>
      <li>Movie Add/Edit Form</li>
      <li>Movie Add/Edit Inline Preview</li>
    </ol>
    <p>These are the six services that are needed:</p>
    <ol>
      <li>Get all the movies</li>
      <li>Get a movie by id</li>
      <li>Update a movie by id</li>
      <li>Insert a new movie</li>
      <li>Delete a movie by id</li>
      <li>Submit a Vote</li>
    </ol>
  </section>
  <!-- /AppSetup-Details -->
  
  <section id="APP-SETUP-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-App-Setup">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#APP-ROUTER-CODE">APPLICATION CONFIGURATION CODE - moviesApp</a> </div>
        <div id="APP-ROUTER-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/APP-ROUTER-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-App-Setup" href="#APP-SERVICE-CODE">APPLICATION SERVICES CODE - moviesApp.services</a> </div>
        <div id="APP-SERVICE-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/APP-SERVICE-CODE.html"; ?>
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
  <section id="Controllers-Setup-Details">
    <h3>Setting up the Controllers</h3>
    <p>In this section, I created three Controllers.</p>
    <ol>
      <li><b>asideMenuController</b> - sets the navigation buttons' active and inactive states.</li>
      <li><b>MoviesListController</b> - sets up the movies displayed in the list view.</li>
      <li><b>MoviesAddEditController</b> - setups up the logic for the Form's and Inline Preview's Add/Edit views.</li>
    </ol>
    <p>I separated the three controllers in this section and defined the application's controller: <br/>
      <span class="line-code">var MoviesControllers = angular.module('movieApp.controllers', []);</span> 
  </section>
  <!-- /Controllers-Setup-Details -->
  
  <section id="CONTROLLERS-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-Controllers">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Controllers" href="#APP-NAV-CONTROLLER-CODE">APPLICATION NAVIGATION CONTROLLER CODE - asideMenuController</a> </div>
        <div id="APP-NAV-CONTROLLER-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/APP-NAV-CONTROLLER-CODE.html"; ?>        
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Controllers" href="#MOVIES-LIST-CONTROLLER-CODE">MOVIES LIST CONTROLLER CODE - MoviesListController</a> </div>
        <div id="MOVIES-LIST-CONTROLLER-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/MOVIES-LIST-CONTROLLER-CODE.html"; ?>
              </pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Controllers" href="#APP-ADD-EDIT-CONTROLLER-CODE">ADD/EDIT MOVIE CONTROLLER CODE - MoviesAddEditController</a> </div>
        <div id="APP-ADD-EDIT-CONTROLLER-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/APP-ADD-EDIT-CONTROLLER-CODE.html"; ?>
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
  <!--/CONTROLLERS-CODE-SECTION -->
  <section id="Directives-Setup-Details">
    <h3>Setting up the Directives</h3>
    <p>I created multiple directives to load plugins and other custom event listenters with the controllers and the views.</p>
    <ol>
      <li><b>Rate It</b> - sets ups the RateIt plugin to display rating stars and allows users to vote in the List View.</li>
      <li><b>Inline Edit</b> - sets up the Jeditable plugin for the Inline Add/Edit Preview View</li>
      <li><b>Numeric Fields</b> - sets up a event listner for input fields that have the 'numeric-field' class</li>
      <li><b>Masked Date &amp; Masked Year</b> - sets up the Masked Input Plugin for the input fields with classes 'masked-date' and 'masked-year'</li>
      <li><b>Dialog</b> - creates a dialog box, that displays successful, error, or confirmation messages.</li>
    </ol>
  </section>
  <!-- /Directives-Setup-Details -->
  
  <section id="DIRECTIVES-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-Directives">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Directives" href="#DIRECTIVES-CODE">DIRECTIVES CODE</a> </div>
        <div id="DIRECTIVES-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/DIRECTIVES-CODE.html"; ?>
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
  <!--/DIRECTIVES-CODE-SECTION -->
  <section id="Custom-Objects-Details">
    <h3>Custom JavaScript Helper Objects</h3>
    <p>I created my own custom helper objects that removes all the ugly non-AngularJS JavaScript codes that are useful to the application outside of the AngularJS framework.</p>
    <ol>
      <li><b>DefaultMovieModel</b> - this is the JSON object that represents the Movie model.</li>
      <li><b>MovieModelLabels</b> - this is a object that maps the movie JSON keys with the correct label name to display what attributes were updated successfully when users updates a movie.</li>
      <li><b>MovieTemplateHelper</b> - this object is used to help the controllers set the display parameters for the view. It also sets and updates the user's local storage while they are adding a new movie.</li>
      <li><b>MoviesPlugins</b> - this object is used to set up the plugins and event listeners used in the Directives.</li>
    </ol>
  </section>
  <!-- /Custom-Objects-Details -->
  <section id="CUSTOM-OBJECTS-CODE-SECTION" class="code-section">
    <div class="accordion" id="Accordian-Custom-Objects">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Custom-Objects" href="#CUSTOM-MODELS-CODE">DefaultMovieModel &amp; MovieModelLabels</a> </div>
        <div id="CUSTOM-MODELS-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/CUSTOM-MODELS-CODE.html"; ?>
			</pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Custom-Objects" href="#CUSTOM-MOVIE-TEMPLATE-HELPER-CODE">MovieTemplateHelper</a> </div>
        <div id="CUSTOM-MOVIE-TEMPLATE-HELPER-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/CUSTOM-MOVIE-TEMPLATE-HELPER-CODE.html"; ?>
			</pre>
          </div>
          <!-- /accordion-inner --> 
        </div>
        <!-- /accordion-body --> 
      </div>
      <!-- /accordion-group -->
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#Accordian-Custom-Objects" href="#CUSTOM-MOVIE-PLUGINS-CODE">MoviePlugins</a> </div>
        <div id="CUSTOM-MOVIE-PLUGINS-CODE" class="accordion-body collapse">
          <div class="accordion-inner code">
            <pre class="prettyprint linenums">
<?php include $_SERVER['DOCUMENT_ROOT']."/www/content/snippets/portfolio/movies-rating/code/CUSTOM-MOVIE-PLUGINS-CODE.html"; ?>
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
  <!--/CUSTOM-OBJECTS-CODE-SECTION -->
  <section id="Conclusion-Details">
    <h3>Conclusion</h3>
    <p>This was a great AngularJS learning experience. I'll probably make some more tweaks and enchancements from time to time. In the future, I'll try to develop another movie demo that will list movie cast members, such as actors, directors, and writers. And also to allow users to Add/Edit the cast members. It will involve creating a relational database and adding more back-end APIs for the project.</p>
    <p>Thanks for visiting and feel free to try this Demo!</p>
    <p>-<span itemprop="name">Raymond Lee</span> 
  </section>
  <!-- /Conclusion-Details -->
  
  <section id="Conclusion-Details">
    <h3>Useful Resources</h3>
    <p>Here's a list of useful resources that I used to develop this application.</p>
    <ul>
      <li><a href="https://angularjs.org/" target="_blank">AngularJS</a> - this is AngularJS website, with full documentation on everything you need to know about this framework. </li>
      <li><a href="http://www.toptal.com/angular-js/a-step-by-step-guide-to-your-first-angularjs-app" target="_blank">A Step-by-Step Guide to Your First AngularJS App</a> - this has very useful detailed description on a Formula F1 demo application written by <span itemprop="name">Raoni Boaventura</span>. He also has a <a href="http://www.toptal.com/angular-js/your-first-angularjs-app-part-2-scaffolding-building-and-testing" target="_blank">Part 2</a> article on how to do unit testing.</li>
      <li><a href="http://www.lynda.com" target="_blank">lynda.com</a> - this has very useful video tutorials on many topics. Including two on AngularJS, written by <span itemprop="name">Ray Villalobos</span>. You have to be registered user with them, to view these videos: "<a href="http://www.lynda.com/AngularJS-tutorials/Up-Running-AngularJS/154414-2.html" target="_blank">Up and Running with AngularJS</a>" and "<a href="http://www.lynda.com/AngularJS-tutorials/Building-Data-Driven-App-AngularJS/174237-2.html" target="_blank"> Building a Data-Driven App with AngularJS</a>
      <li><a href="http://jquery.com/" target="_blank">jQuery</a> - a very useful and my favorite JavaScript library. Most of the plugins and code my AngularJS Directives were written with jQuery.</li>
      <li><a href="http://rateit.codeplex.com/" target="_blank">RateIt</a> - a jQuery (star) rating plugin that I used for the movies' ratings.</li>
      <li><a href="http://www.appelsiini.net/projects/jeditable" target="_blank">Jeditable</a> - Edit In Place Plugin For jQuery, that I used in the Add/Edit Inline Preview page.</li>
      <li><a href="http://digitalbush.com/projects/masked-input-plugin/" target="_blank">Masked Input Plugin</a> - It allows a user to more easily enter fixed width input where you would like them to enter the data in a certain format. I used some of the numeric and dates input fields.</li>
      


    </ul>
  </section>
  <!-- /Conclusion-Details --> 
</article>
<!-- /DETAILS-CONTENT --> 


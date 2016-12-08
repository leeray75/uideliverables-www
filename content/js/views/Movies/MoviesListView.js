var MoviesList, MovieListItemView, MoviesListView;
$(function(){
	var response = $.ajax({
		url: '/www/content/templates/movies-rating/movies-templates.html',
		type: 'GET'
	});
	response.done(function(data){
		$('body').append(data);
	});	
	MoviesListView = Backbone.View.extend({
		id: '#movies-list',
		initialize: function(){
			this.$el = $(this.id);		
			this.listenTo(this.collection, 'reset', this.addAll);
			this.listenTo(this.collection, 'add', this.addOne);
			this.listenTo(this.collection, 'change', this.change);            
			this.listenTo(this.collection, 'destroy', this.destroy);   
			this.listenTo(this.collection, 'sync', this.sync);                   
		},
		render: function() {
			this.$el.html('');
			for(i=0;i<this.collection.length;i++)
			{
				var movie = this.collection.at(i);
				var MovieListItem = new MovieListItemView({model: movie });
				MovieListItem.render();		
			}
		},
		addAll: function() {
			//console.log("MoviesListView addAll");
		},
		addOne: function(movie) {
			//console.log("MoviesListView addOne");
		},
		change: function(movie){
			//console.log("MoviesListView change");
		},
		destroy: function(movie) {
			//console.log("MoviesListView destroy"); 
			$('#MovieListItem-'+movie.get("id")).remove();         
		},
		sync: function(movie) {
			//console.log("MoviesListView sync");
			this.render();              
		}		
	}); // end MoviesListView 	
	MovieListItemView = Backbone.View.extend({	
		tagName:  "li",
		template:  null,
		events: {
			"click .add-rating": "addRating"
		},	
		initialize: function() {
			this.template =  _.template($('#Movie-List-Item-Template').html())
			this.listenTo(this.model, 'change', this.render);
			this.id = '#MovieItem-'+this.model.get("imdbID");
			//this.$el = $('#MovieListItem-'+this.model.get("imdbID"));			 
		},
		
		// Re-render the titles of the tasks item.
		render: function() {		
			var jsonModel = this.model.toJSON();
			var template = this.template(jsonModel);
			var html = this.$el.html(template);
					
			if($(this.id).exists())
			{
				$(this.id).replaceWith(template);	  
			}
			else
			{
				$('#movies-list').append(html);
			}	
			this.initEvents();
			
			return this;		 		  		  
		},
		initEvents: function()
		{
			var thisObj = this;
			$(this.id +" .add-rating").off('click.add');
			$(this.id +" .add-rating").on('click.add', function(event){
				thisObj.addRating();
				return false;
			});
			this.initRateIt();


		},
		initRateIt: function()
		{
			var thisObj = this;
			var previousVal = 0;
			var rateitObj = $("#RateIt-"+this.model.get("imdbID")).rateit({
				"beforeSelection": function(prevVal){
					previousVal = prevVal;
				},
				"afterSelection": function(val){ 					
					var rating = val*2;
					var AjaxData = { "imdbID": thisObj.model.get("imdbID"), "rating": rating};
					var response = $.ajax({
						url: MoviesSettings.RateMovieUri,
						type: "POST",
						dataType: 'json',
						data: AjaxData	
					});
					response.done(function(data)
					{
						
						var dialogData = {}
						if(data.status.toUpperCase() == "FAILURE")
						{
							var message = data.reason;
							dialogData = { 
								"status": data.status,
								"message": "Your rating failed to submit!<br /><br />Reason:<br /> \""+message+"\""
							}					
							rateitObj.rateit('value', previousVal)
						}
						else
						{
							dialogData = { 
								"status": data.status,
								"message": "Your rating for \""+thisObj.model.get("Title")+"\" was sucessfully submitted!"
							}	
						}
						thisObj.showRatingDialog(dialogData);
						
					});
					response.fail(function(msg)
					{
						dialogData = { 
							"status": "FAILURE",
							"message": "Your rating failed to submit!"
						}	
						thisObj.showRatingDialog(dialogData);
					});
				}
			
			});
						
			var imdbRating = parseInt(this.model.get("imdbRating"))/2;
			$("#IMDb-RateIt-"+this.model.get("imdbID")).rateit( {"readonly": true, "value": imdbRating, "max": 5 });			 
		},
		showRatingDialog: function(data)
		{
			var template =  _.template($('#Rating-Dialog-Template').html());
			var html = template(data);
			$('#rating-dialog').remove();
			$('body').append(html);
	
			var options = { 
				autoopen: false,
			   	buttons: [{
					text: "OK",
					click: function() {
						$( this ).dialog( "close" );
					}
				}]
			}	
			$( "#rating-dialog" ).dialog(options);			
		
			
			
		}
									
	}); // end MovieListItemView		
}); // end $(function()


var MovieTemplateHelper =
{
	getReleaseDateDisplay: function(Released)
	{
		var dateArray = Released.split(" ");
		return dateArray[1] + " " + dateArray[0] + ", " + dateArray[2];
	},
	getGenreLabel: function(Genre)
	{
		var genresArray = Genre.split(",");
		return genresArray.length>1 ? "Genres" : "Genre";		
	},
	getDirectorsLabel: function(Director)
	{
		var directorsArray = Director.split(",");
		return directorsArray.length>1 ? "Directors" : "Director";		
	},
	getWritersLabel: function(Writer)
	{
		var writersArray = Writer.split(",");
		return writersArray.length>1 ? "Writers" : "Writer";		
	},
	getActorsLabel: function(Actors)
	{
		var actorsArray = Actors.split(",");
		return actorsArray.length>1 ? "Stars" : "Star";
	},
	getRuntimeMinutes: function(Runtime)
	{
		RuntimeMinutes = 0;
		var RuntimeArray = Runtime.split(" ");	
		if(RuntimeArray.length==4)
		{
			RuntimeMinutes = parseInt(RuntimeArray[0])*60 + parseInt(RuntimeArray[2]);
		}
		else if(RuntimeArray[1] == "h")
		{	
			RuntimeMinutes = parseInt(RuntimeArray[0])*60	
		}
		else
		{
			RuntimeMinutes = parseInt(RuntimeArray[0]);
		}	
		return RuntimeMinutes;	
	},
	getPosterImageSrc: function(Poster)
	{
		return Poster.replace('http://ia.media-imdb.com/images/',MoviesSettings.PosterImageUri);	
	}
	
}
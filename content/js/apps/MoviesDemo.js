var App = App || {};

$(function(){	 	

var AppView = Backbone.View.extend({
	el: $("#MoviesListView"),		
	initialize: function() {					
		this.collection =  new MoviesCollection();
		this.collection.comparator = function(model) {				
			return [model.get('Title')];
		}
			
		//this.listenTo(this.collection, 'sync', this.sync);	
		//this.listenTo(this.collection, 'remove', this.sync);				
	},		
	render: function() {

		this.MoviesList = new MoviesListView({el: $("movies-list"), collection: this.collection})
		this.MoviesList.render();
		// Create query string with data: $.param({ param: value }) 
		//this.collection.fetch({ data: $.param({ page: 1}) });
		this.collection.fetch();
		//this.collection.sort();
	},
	sync: function(movies){
		//console.log("AppView syncMovies");
		
	} // end syncMovies
		
}); // end AppView

console.log("TEST");
		App = new AppView();	  	
		App.render();


});


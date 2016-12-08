 var MoviesCollection = Backbone.Collection.extend({
	// Reference to this collection's model.
	model: MovieModel,
	url: MoviesSettings.MoviesApiUri,
	initialize: function() {
        
    }
}); // end MoviesCollection
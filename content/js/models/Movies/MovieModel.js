// JavaScript Document

var MovieModel =  Backbone.Model.extend({
	idAttribute: "imdbID",
	// Default attributes for the task item.
	defaults: function() {
	  return {
		Actors: "",
		Director: "",
		Genre: "",
		Plot: "",
		Poster: "",
		Rated : "",
		Released : "",
		Response : "True",
		Runtime : "",
		Title : "",
		Type : "movie",
		Writer : "",
		Year : "",
		imdbID : "",
		imdbRating : "",
		imdbVotes : ""
		};
	}
	 
 }); // End MovieModel
 
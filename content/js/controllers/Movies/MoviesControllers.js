var MovieControllers = angular.module('MovieControllers', []);
MovieControllers.controller('MoviesListController', ['$scope', '$http', function($scope, $http) {
	console.log("get");
  	$http.get(MoviesSettings.MoviesApiUri).success(function(data) {
	  	console.log(data);
		for (var obj in data){
			var poster = data[obj].Poster;
			data[obj].Poster = MovieTemplateHelper.getPosterImageSrc(poster);
			data[obj].RuntimeMinutes = MovieTemplateHelper.getRuntimeMinutes(data[obj].Runtime)
			data[obj].GenreLabel = MovieTemplateHelper.getGenreLabel(data[obj].Genre);
			data[obj].DisplayReleaseDate = MovieTemplateHelper.getReleaseDateDisplay(data[obj].Released)
			data[obj].DirectorLabel = MovieTemplateHelper.getDirectorsLabel(data[obj].Director);
			data[obj].WriterLabel = MovieTemplateHelper.getWritersLabel(data[obj].Writer);
			data[obj].ActorsLabel = MovieTemplateHelper.getActorsLabel(data[obj].Actors);
			
		}
		$scope.movies = data;
		

  });
}]).directive('imdbUserRate', function() {
	return {
            restrict: 'A',
            link: function(scope, elem, attrs) {	
				//console.log(scope);		
				var previousVal = parseInt(attrs.rating)/2;
				var imdbID = attrs.imdbID;
				var title = attrs.ratetitle;
				var rateitObj = $(elem).rateit({
					"title" : title,
					"imdbID": imdbID,
					"beforeSelection": function(prevVal){
						previousVal = prevVal;

					},
					"afterSelection": function(val){	
						var thisObj = this;
						var rating = val*2;
						var AjaxData = { "imdbID": this.imbdID, "rating": rating};
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
									"message": "Your rating failed to submit! Reason: \""+message+"\""
								}					
								rateitObj.rateit('value', previousVal)
								alert(dialogData.message);
							}
							else
							{
								dialogData = { 
									"status": data.status,
									"message": "Your rating for \""+thisObj.title+"\" was sucessfully submitted!"
								}	
								alert(dialogData.message);
							}
							//thisObj.showRatingDialog(dialogData);
							
							
						});
						response.fail(function(msg)
						{
							dialogData = { 
								"status": "FAILURE",
								"message": "Your rating failed to submit!"
							}
							alert("Failure!");	
							//thisObj.showRatingDialog(dialogData);
						});
					}
			
			});

			
			
            }
        }
}).directive('imdbRate', function() {
	return {
            restrict: 'A',
            link: function(scope, elem, attrs) {			
				var imdbRating = parseInt(attrs.rating)/2;				
				$(elem).rateit( {"readonly": true, "value": imdbRating, "max": 5 });
            }
        }
});


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
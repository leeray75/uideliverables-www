// JavaScript Document

var User =  Backbone.Model.extend({

	// Default attributes for the task item.
	defaults: function() {
	  return {
		isGuest: true,
		isAdmin: false,
		username: "",
		email: ""
	  };
	}	 
 }); // End User
 
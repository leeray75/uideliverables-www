// JavaScript Document

var Event =  Backbone.Model.extend({

	// Default attributes for the task item.
	defaults: function() {
	  return {
		title: "",
		description: '',
		location: '',
		start: '',
		end: '',
		allDay: false,
		isEditable: true,
		isComplete: false,
		user_id: ''
	  };
	},
	constructor: function() {

		if(arguments.length>0)
		{
			arguments[0].allDay = (arguments[0].allDay=="1" || arguments[0].allDay==true) ? true : false;
			arguments[0].color = arguments[0].allDay ? App.Calendar.allDayBgColor : App.Calendar.defaultEventBgColor;
		}
		Backbone.Model.apply(this, arguments);
  	}
	 
 }); // End TaskEvent
 
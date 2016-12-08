var App = App || {};
var events, eventView, calendarView, datepickerView;
$(function(){	 	
if(user.get("isGuest"))
{
	$('#login-info').show();	
}
else
{
	$('#login-info').hide();
}
var AppView = Backbone.View.extend({
		el: $("#CalendarView"),
		showCompleted: true,
		events: {				
			"click #calendar-tab": "refreshCalendar"		
		},
		
		initialize: function() {
			var thisObj = this;
			$('#tabs-container').tabs();	
			//$('.nav-tabs a:first').tab('show');		
			$('#calendar-tab').on('click',function(event){
				thisObj.refreshCalendar();
			});
			this.collection =  new EventsCollection();
			this.collection.comparator = function(model) {
				//console.log("comparing: "+model.get("id"));
				return [model.get('start'),model.get('end')];
    		}	
			this.CurrentEventsCollection =  new EventsCollection();
			this.CurrentEventsCollection.comparator = function(model) {
				//console.log("comparing: "+model.get("id"));
				return [model.get('start'),model.get('end')];
    		}	
			this.listenTo(this.collection, 'sync', this.syncEvents);	
			this.listenTo(this.collection, 'remove', this.syncEvents);
			this.listenTo(this.collection, 'change', this.change);    	
			


		},		
		render: function() {
			//console.log('AppView.render: \n');
			this.Calendar = new FullCalendarView({el: $("#calendar"), collection: this.collection});
			this.Calendar.render();		
			
			
			this.EventsList = new EventsListView({el: $("events-list"), collection: this.CurrentEventsCollection})
			this.EventsList.render();
			this.collection.fetch();
			//this.collection.sort();
		},		
		change: function(event){
			console.log("AppView change");
			this.collection.sort();  
		},		
		syncEvents: function(events){
			console.log("AppView syncEvents");
			//this.collection.fetch();
			this.updateCurrentEventsCollection();
			
		}, // end syncTasks
		updateCurrentEventsCollection: function()
		{			
			var EventsArray = new Array();
			for(i=0; i<this.collection.length;i++)
			{			
				var eventModel = this.collection.at(i);
				var endDateVal = eventModel.get("end");
				console.log("endDateVal: ",endDateVal);
				if(getDateObject(GlobalVariables.CurrentDate) < getDateObject(endDateVal))
				{
					EventsArray.push(eventModel);					
				}		
			}
			this.CurrentEventsCollection.reset();
			this.CurrentEventsCollection.set(EventsArray);
		},
		showEventTaskOverlay: function()
		{
			//console.log("showEventTaskOverlay");
			var TaskEventModel = new TaskEvent();
			var modalOverlay = new AddEditTaskEventModalOverlayView({ model: TaskEventModel} )
			var html = modalOverlay.render();
			//$('body').append(html);
			//modalOverlay.initModal();
		},
		refreshCalendar: function(){
			console.log("AppView refreshCalendar");
			this.Calendar.refresh();
		}
		
	}); // end AppView


		App = new AppView();	  	
		App.render();
		UI.setLogInOutCallback(function(){
			console.log("isGuest: "+user.get("isGuest"));
			if(user.get("isGuest"))
			{
				$('#login-info').show();	
			}
			else
			{
				$('#login-info').hide();
			}	
			console.log('reset');
			App.collection.reset();
			console.log('fetch');
			App.collection.fetch();
			console.log('done');

		});


});
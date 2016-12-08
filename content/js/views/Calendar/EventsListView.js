$.ajax({
	url: "/www/content/templates/calendar/event-list-item-template.html",
	}).done(function(data) {
		$(document).ready(function(){
			$('body').append(data);			
		});			
});

var EventsListView = Backbone.View.extend({
		allDayBgColor: '#767be0',
		defaultEventBgColor: '#3A87AD',
        initialize: function(){
            //_.bindAll(this); 			
			this.collection.comparator = function(model) {
				return [model.get('start'),model.get('end')];
    		}				
           // this.listenTo(this.collection, 'reset', this.addAll);
            this.listenTo(this.collection, 'add', this.addOne);
            this.listenTo(this.collection, 'change', this.change);            
            this.listenTo(this.collection, 'destroy', this.destroy);   
			this.listenTo(this.collection, 'sync', this.sync);                   
        },
        render: function() {
			console.log('EventsListView render');
			//console.log('EventsListView this.collection.length = ' + this.collection.length);
			$('#active-events-list').html('');
			for(i=0;i<this.collection.length;i++)
			{
				var event = this.collection.at(i);
				var EventListItem = new EventListItemView({model: event });
				EventListItem.render();	
			}
        },
        addAll: function() {
			
			//console.log("EventsListView addAll");
			this.render();
            //this.$el.fullCalendar('addEventSource', events.toJSON());
        },
        addOne: function(event) {
			//console.log("EventsListView addOne");			
			this.render();									
		},
		change: function(event){
			//console.log("EventsListView change");
			this.collection.sort();  
		},
        destroy: function(event) {
			console.log("EventsListView destroy"); 
			$('#EventListItem-'+event.get("id")).remove();         
        },
		sync: function(event) {
			//console.log("EventsListView sync");
			
			this.render();              
        }		
}); // end EventsListView
	
var EventListItemView = Backbone.View.extend({	
	tagName:  "div",
	template: null,
	 events: {
		"click .add-event": "addEvent",
		"click .delete-event":  "deleteEvent",
		"click .edit-event": "editEvent"
	  },	
	initialize: function() {
		this.template = _.template($('#Event-List-Item-Template').html())	
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.model, 'destroy', this.remove);		
		this.id = '#EventListItem-'+this.model.get("id");
		this.$el = $('#EventListItem-'+this.model.get("id"));			 
	},
	
	// Re-render the titles of the tasks item.
	render: function() {		
		var jsonModel = this.model.toJSON();
		var template = this.template(jsonModel);
		this.$el.html(template);
		//console.log("EventListItemView render: "+this.$el.exists());
		//console.log("title = " + this.model.get("title"));
		var endDateVal = this.model.get("end")
		//console.log("end value = "  + this.model.get("end"));
		//console.log("end = " + getDateObject(endDateVal));
		
		if(this.$el.exists())
		{
			this.$el.replaceWith(template);	  
		}
		else
		{
			$('#active-events-list').append(template);
		}	
		this.initEvents();
		
		return this;		 		  		  
	},
	initEvents: function()
	{
		var thisObj = this;
		$(this.id +" .add-event").off('click.add');
		$(this.id +" .add-event").on('click.add', function(event){
			thisObj.addEvent();
			return false;
		});
		$(this.id +" .edit-event").off('click.edit');
		$(this.id +" .edit-event").on('click.edit', function(event){
			thisObj.editEvent();
			return false;
		});
		$(this.id +" .delete-event").off('click.delete');
		$(this.id +" .delete-event").on('click.delete', function(event){
			thisObj.deleteEvent();
			return false;
		});
	},
	destroy: function(){
		
	},
	addEvent: function()
	{
		//console.log("EventListItemView addEvent: "+this.model.get("title"));	
		App.Calendar.select( new Date(), new Date());	
	},
	editEvent: function()
	{
		//console.log("EventListItemView editEvent: "+this.model.get("title"));
		var AddEditEventModalOverlay = new AddEditEventModalOverlayView({model: this.model });
		AddEditEventModalOverlay.render();			
	},
	deleteEvent: function()
	{
		//console.log("EventListItemView deleteEvent: "+this.model.get("title"));	
		var DeleteEventModalOverlay = new DeleteEventModalOverlayView({model: this.model });
		DeleteEventModalOverlay.render();
	}
								
}); // end EventListItemView
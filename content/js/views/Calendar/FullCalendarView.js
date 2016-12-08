var FullCalendarView = Backbone.View.extend({
		allDayBgColor: '#767be0',
		defaultEventBgColor: '#3A87AD',
        initialize: function(){
            //_.bindAll(this); 			
            this.listenTo(this.collection, 'reset', this.addAll);
            this.listenTo(this.collection, 'add', this.addOne);
            this.listenTo(this.collection, 'change', this.change);            
            this.listenTo(this.collection, 'destroy', this.destroy);  
			this.listenTo(this.collection, 'sync', this.sync);                     
        },
        render: function() {
			//console.log('render');
			//console.log('jsonModel = ' + JSON.stringify(this.collection));	
			//console.log("$('#calendar').exists() = " + $('#calendar').exists());
			this.$el.html('');
            this.$el.fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },				
				disableDragging: true,
				disableResizing: true,
                selectable: true,
                selectHelper: true,
                editable: true,
                ignoreTimezone: false,                
                select: this.select,
                eventClick: this.eventClick,
                eventDrop: this.eventDropOrResize,        
                eventResize: this.eventDropOrResize,
            });				
        },
        addAll: function() {
			console.log("addAll");
			var events = this.collection.toJSON();
			//console.log(events);
            //this.$el.fullCalendar('addEventSource', this.collection.toJSON());
			this.$el.fullCalendar('removeEvents');
			var model = new Event().toJSON();
			for(i=0;i<events.length;i++){
				var e = events[i];
				for(key in e){
					if(!model.hasOwnProperty(key) && key!="id"){
						delete e[key];	
					}
				}								
				this.addOne(new Event(e));	
			}
			console.log('done adding');
        },
        addOne: function(event_data) {
			//console.log("FullCalenderView addOne");
			//console.log(event);
			//console.log("event.errorMessage = "+event.get("errorMessage"));
			if(event_data.id != null)
			{
				//this.$el.fullCalendar( 'refetchEvents' );
				//console.log("JSON: \n"+JSON.stringify(event.toJSON()));
				//console.log(event_data.toJSON());
            	this.$el.fullCalendar('renderEvent', event_data.toJSON(), { stick: true });
			}
			else if(event_data.get("errorMessage") !=null)
			{			
				//events_data.pop();
				console.log("pop events = " +JSON.stringify(events_data.toJSON()));
			}				
			
        },        
        select: function(startDate, endDate) {
			console.log("FullCalenderView select");	
			//console.log('select');
			//console.log("startDate = " + startDate+" : endDate = "+endDate);
			//console.log('jsonModel = ' + JSON.stringify(events));
            //eventView.collection = events;
            //eventView.model = new Event({start: getDateString(startDate), end: getDateString(endDate)});
            //eventView.render();      
			if(!user.get("isGuest"))
			{						
				var theModel = new Event();
				var month = (startDate.getMonth()+1)<10 ? "0"+(startDate.getMonth()+1) : (startDate.getMonth()+1);
				var day = (startDate.getDate() < 10) ? "0"+startDate.getDate() : startDate.getDate();
				var hours = (startDate.getHours() < 10) ? "0"+startDate.getHours() : startDate.getHours();
				var minutes = (startDate.getMinutes() < 10) ? "0"+startDate.getMinutes() : startDate.getMinutes();
				var timeString = " "+hours+":"+minutes+":00";
				var start = startDate.getFullYear()+"-"+month+"-"+day+timeString;
				
				month = (endDate.getMonth()+1)<10 ? "0"+(endDate.getMonth()+1) : (endDate.getMonth()+1);
				day = (endDate.getDate() < 10) ? "0"+endDate.getDate() : endDate.getDate();			
				hours = (endDate.getHours() < 10) ? "0"+endDate.getHours() : endDate.getHours();
				minutes = (endDate.getMinutes() < 10) ? "0"+endDate.getMinutes() : endDate.getMinutes();
				timeString = " "+hours+":"+minutes+":00";
							
				var end = endDate.getFullYear()+"-"+month+"-"+day+timeString;
				console.log("start = " + start);
				theModel.set('start',start);
				theModel.set('end',end);      
				
				var AddEditEventModalOverlay = new AddEditEventModalOverlayView({model: theModel });
				AddEditEventModalOverlay.render();
			}
			else
			{
				//alert("You must be logged in to create an event!");	
			}
        },
        eventClick: function(fcEvent) {
			console.log("FullCalenderView eventClick");
			//console.log('eventClick id = ' + fcEvent.id + ' isEditable = '+fcEvent.isEditable);
            var theModel = App.collection.get(fcEvent.id);
			var DisplayEventModalOverlay = new DisplayEventModalOverlayView({model: theModel });
			DisplayEventModalOverlay.render();	
			/*
			if(fcEvent.isEditable>0 && !user.get("isGuest"))
			{
				var AddEditEventModalOverlay = new AddEditEventModalOverlayView({model: theModel });
				AddEditEventModalOverlay.render();
			}
			else
			{
				var DisplayEventModalOverlay = new DisplayEventModalOverlayView({model: theModel });
				DisplayEventModalOverlay.render();				
			}
			*/
        },
	
        change: function(event) {
			
			console.log("FullCalenderView change id = "+event.get('id'));			
            // Look up the underlying event in the calendar and update its details from the model
            var fcEvent = this.$el.fullCalendar('clientEvents', event.get('id'))[0];

			if(event.get('id')==null)
			{
				events.pop();
				console.log("pop events = " +JSON.stringify(events.toJSON()));
			}
			else if(fcEvent==null)
			{
				console.log("fcEvent is null");
				this.addOne(event);
			}
			else
			{
            	fcEvent.title = event.get('title');
	            fcEvent.start = event.get('start');
				fcEvent.end = event.get('end');
				fcEvent.allDay = event.get('allDay');
				fcEvent.backgroundColor = fcEvent.allDay ? this.allDayBgColor : this.defaultEventBgColor;		
				console.log("fullCalendar updateEvent "+fcEvent.id);						
        	    this.$el.fullCalendar('updateEvent', fcEvent);           
			}
        },
        eventDropOrResize: function(fcEvent) {
			console.log("eventDropOrResize");
            // Lookup the model that has the ID of the event and update its attributes
            this.collection.get(fcEvent.id).save({start: fcEvent.start, end: fcEvent.end});            
        },
        destroy: function(event) {
			console.log("destroy");
            this.$el.fullCalendar('removeEvents', event.id);         
        },
		sync: function(event) {
			console.log("FullCalendarView sync");	
			this.addAll();		
			//this.render();              
			
			/*
			this.$el.fullCalendar( 'removeEvents');  
			for(i=0; i<this.collection.length; i++)
			{
				var theEvent = this.collection.at(i);
				console.log("title = "+theEvent.get("title"));
				this.addOne(theEvent);	
			}
			*/
			

			
        },		
		showEventTaskOverlay: function()
		{
			//console.log("showEventTaskOverlay");
			var EventModel = new Event();
			var modalOverlay = new AddEditEventModalOverlayView({ model: EventModel} )
			var html = modalOverlay.render();
			//$('body').append(html);
			//modalOverlay.initModal();
		},		
		refresh: function()
		{
			console.log("FullCalendarView refresh");	
			this.$el.fullCalendar( 'rerenderEvents' );
		}
    }); // end CalendarView
	
	
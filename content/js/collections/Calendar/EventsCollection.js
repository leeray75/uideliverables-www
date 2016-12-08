 var EventsCollection = Backbone.Collection.extend({
	// Reference to this collection's model.
	model: Event,
	url: '/www/index.php/api/events',
	initialize: function() {
        //this.sort_order = 'desc';
    },
	comparator: function(model) {
		var startDate = new Date(getDateObject(model.get('start')));
		var endDate = new Date(getDateObject(model.get('end')));
		//console.log("comparator: "+model.get('start'));
        return [model.get('start'),model.get('end')];
    },
	setFilter: function(filter)
	{
		this.filterFunc = filter;
	},
	filter: function()
	{
		if(typeof this.filterFunc === 'function'){
			this.filterFunc();
		}
	}
	
}); // end / End TaskEventsCollection
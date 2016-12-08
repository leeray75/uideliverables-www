var UserNavView = UserNavView || {};
$(document).ready(function(){

	UserNavView = Backbone.View.extend({	
		tagName:  "div",
		id: '#user-nav-links',
		// Cache the template function for a single item.
		template: _.template($('#user-nav-template').html()),
		/*
		events: {
		  "click .task-do-complete-link"   : "doComplete",
		  "click .task-undo-complete-link"   : "undoComplete"	
		},
		*/

		initialize: function() {
		  this.listenTo(this.model, 'change', this.render);
		  this.listenTo(this.model, 'destroy', this.remove);
		},
	
		// Re-render the titles of the tasks item.
		render: function() {		
			var jsonModel = this.model.toJSON();
			var template = this.template(jsonModel);
		  	this.$el.html(template);
		  
		  //alert(this.el.html());
		  return this;
		},
		doComplete: function(){			
			this.setModelComplete(true);
			return false;
		},
		undoComplete: function(){
			this.setModelComplete(false);
			return false;
		},
		setModelComplete: function(value)
		{
			
				var newModel = new TaskEvent (this.model.toJSON() );
				newModel.set("isComplete",value);
                this.model.save(newModel, {success: function(data){ 
											
						if(data.get("errorMessage") != null)
						{
							alert(data.get("errorMessage"));	
						}
						else
						{
							//alert("success");
						}
					}// end success
				});			
		}
	}); // end TaskEventItemView
	
});
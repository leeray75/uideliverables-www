// JavaScript Document

var AddEditEventModalOverlayView, DeleteEventModalOverlayView, DisplayEventModalOverlayView;
$.ajax({
	url: "/www/content/templates/calendar/calendar-modals-template.html",
	}).done(function(data) {
		$(document).ready(function(){	
			$('body').append(data);
			ModalViews.init();
		});			
});


var ModalViews =
{
	init: function()
	{
		
		DeleteEventModalOverlayView = Backbone.View.extend({	
				tagName:  "div",
				template: _.template($('#Delete-Event-ModalOverlay-Template').html()),
				id: '#DeleteEventModal',
				events: {
				  "click .simplemodal-close"   : "close"
				},
		
				initialize: function() {
				 
				},
			
				// Re-render the titles of the tasks item.
				render: function() {		
					var jsonModel = this.model.toJSON();
					var thisObj = this;			
					$(AddEditEventModalOverlayView.id).remove();
					var jsonModel = this.model.toJSON();
					//console.log("render this.el = " + this.el);
					//console.log('jsonModel = ' + JSON.stringify(jsonModel));
					var template = this.template(jsonModel);	
					$('body').append(template);
					
					this.initModal();
					return this;						 		  		  
				},
				initModal: function(){ 
					var thisObj = this; 
					$(this.id).modal({
						autoResize: false,
						fixed: false,
						overlayId: 'EventModalOverlay',
						containerId: 'EventModalContainer',
						onShow: this.show(),
						onClose: this.close()
					});			
				},
				show: function(){
					var thisObj = this;
					//this.initPlugins();
					 $(this.id + ' .do-delete-link').on("click.modal", function(){thisObj.destroy(); return false; }); 
					 //$('#DeleteEventOverlay').on("click.modal", ".simplemodal-close", function(){thisObj.close(); return false; }); 
				},
			
				destroy: function(){
					var thisObj = this;
					this.model.destroy({
						success: thisObj.close(),
						error: function(model,response){
								var data = $.parseJSON(response.responseText);
								if(data.errorMessage != null)
								{
									alert(response.status + " : "  + $(data.errorMessage).text());										
									if(response.status=="401")
									{
										thisObj.close();
										location.reload();
									}
								}
								else
								{
									alert("Unknown Error");	
								}
							}
					});
					
				},
				close: function(){
					$(this.id).off("click.modal", ".do-save-link"); 
					//$.modal.close();
					$.modal.modal('hide');
					$(this.id).detach();
					
				}
				
			}); // end DeleteEventModalOverlayView
			AddEditEventModalOverlayView = Backbone.View.extend({	
				tagName:  "div",
				template: _.template($('#AddEdit-Event-ModalOverlay-Template').html()),
				id: "#AddEditEventModal",
			
				initialize: function() {		 
				},
			
				// Re-render the titles of the tasks item.
				render: function() {		
					var jsonModel = this.model.toJSON();
					var thisObj = this;			
					$(this.id).remove();
					var jsonModel = this.model.toJSON();
					//console.log("render this.el = " + this.el);
					//console.log('jsonModel = ' + JSON.stringify(jsonModel));
					var template = this.template(jsonModel);	
					$('body').append(template);
					
					this.initModal();
					return this;						 		  		  
				},
				initModal: function(){
					var thisObj = this; 
					/*$(this.id).modal({
						autoResize: false,						
						fixed: false,
						overlayId: 'EventModalOverlay',
						containerId: 'EventModalContainer',
						onShow: function(dialog){ thisObj.show(dialog)},
						onClose: this.close()
					});	*/
					$(this.id).on('shown.bs.modal', function () {
						 thisObj.show();
					  })			
					$.modal = $(this.id).modal();			
				},
				show: function(dialog){
					this.initDateTimePickerPlugin();
					this.initNobleCountPlugin();
					this.initDelegateEvents();
					/*
					dialog.wrap.css('height','500px'); 
					dialog.wrap.css('overflow','hidden'); 
					dialog.autoPosition= false;		
					*/		
					
				},

				initDelegateEvents: function()
				{
					var thisObj = this;
					$(this.id + ' .do-save-link').on("click.modal", function(){  thisObj.save(); return false; }); 
					$(this.id + " .delete-model-link").on("click.modal", function(){
						thisObj.close(); 
						var DeleteEventModalOverlay = new DeleteEventModalOverlayView({model: thisObj.model });
						DeleteEventModalOverlay.render();
						return false; 
					});			
				},
				save: function(){
					//console.log("saving...");
					var thisObj = this;

					var StartDateVal = $('#StartDate').val();
					var EndDateVal = $('#EndDate').val();
					var StartTime = StartDateVal.split(" ")[1]+":00 "+StartDateVal.split(" ")[2];
					var EndTime = EndDateVal.split(" ")[1]+":00 "+EndDateVal.split(" ")[2];
					
					StartTime = getMilitaryTime(StartTime);
					EndTime = getMilitaryTime(EndTime);
					
					var StartDate = StartDateVal.split(" ")[0];
					var EndDate = EndDateVal.split(" ")[0];
					
					var allDay = $('#AllDay').is(":checked") ? true : false;			
					var dateArray = StartDate.split("/");
					StartDate = dateArray[2]+"-"+dateArray[0]+"-"+dateArray[1];
					dateArray = EndDate.split("/");
					EndDate = dateArray[2]+"-"+dateArray[0]+"-"+dateArray[1];
					
					var StartDateObj = getDateObject(StartDate+" "+StartTime);
					var EndDateObj = getDateObject(EndDate+" "+EndTime);
					
					//console.log("this.model.isNew() = " + this.model.isNew());
					if(StartDateObj > EndDateObj)
					{
						alert("End Date & Time must be greater than Start Date & Time\n"
						+StartDate+" "+StartTime+"\n"+EndDate+" "+EndTime
						);
					}
					else if (this.model.isNew()) {
						
						 var newModel = new Event();
						 newModel.set('title',$('#title').val());
						 newModel.set('description',$('#description').val());
						 newModel.set('location',$('#location').val());
						 newModel.set('start', StartDate+" "+StartTime);
						 newModel.set('end', EndDate+ " "+ EndTime);
						 newModel.set('allDay', allDay);
						 newModel.set('user_id', user.get('id'));
						 
						App.collection.create(newModel, {wait: true, success: function(data){ 
							
								//console.log("response = \n" +JSON.stringify(data.toJSON()));
								if(data.get("errorMessage") != null)
								{
									alert(data.get("errorMessage"));										
								}
								else
								{
									if($('#file').exists() && $('#file').val().length > 0)
									{
										thisObj.uploadFile(newModel.get("id"));	
									}
									else
									{									
										thisObj.close();
									}
								}
							},// end success
							error: function(model,response){
								var data = $.parseJSON(response.responseText);
								if(data.errorMessage != null)
								{
									alert(response.status + " : "  + $(data.errorMessage).text());	
									
									if(response.status=="401")
									{
										thisObj.close();
										location.reload();
									}
								}
								else
								{
									alert("Unknown Error");	
								}
							}
						});
					}	// end if (this.model.isNew())
					else
					{
						var newModel = new Event();			
						 newModel.set('id',this.model.get('id'));
						 newModel.set('title',$('#title').val());
						 newModel.set('description',$('#description').val());
						 newModel.set('location',$('#location').val());
						 newModel.set('start', StartDate+" "+StartTime);
						 newModel.set('end', EndDate + " "+ EndTime);
						 newModel.set('allDay', allDay);
						 newModel.set('isEditable', this.model.get('isEditable'));
						 newModel.set('isComplete', this.model.get('isComplete'));
						 newModel.set('user_id', this.model.get('user_id'));
						 //console.log("newModel = " +JSON.stringify(newModel.toJSON()));
						this.model.save(newModel, {success: function(data){ 											
								//console.log("data = " +JSON.stringify(data.toJSON()));
								console.log(data);
								if(data.get("errorMessage") != null)
								{
									alert(data.get("errorMessage"));	
									return false;
								}
								else
								{
									/*
									if($('#file').val().length > 0)
									{
										thisObj.uploadFile(newModel.get("id"));	
									}
									else
									{									
										thisObj.close();
									}
									*/
									thisObj.close();
									return true;
								}
							},// end success
							error: function(model,response){
								try{
									var data = $.parseJSON(response.responseText);
									if(data.errorMessage != null)
									{
										alert(response.status + " : "  + data.errorMessage);	
										if(response.status=="401")
										{
											thisObj.close();
											location.reload();
										}
									}
									else
									{
										alert("Unknown Error");	
									}
								}catch(e){
									alert("Unknown Error");	
								}
							}
						});
					}
				},
				close: function(){
					//console.log("closing modal");
					$(this.id).off("click.modal", ".do-save-link"); 
					$.modal.modal('hide');
					//$.modal.close();
					$(this.id).detach();
				},
				delete: function(){
					
				},
				uploadFile: function(id)
				{
					var data = new FormData();					
					jQuery.each($('#file')[0].files, function(i, file) {
						data.append('file-'+i, file);
					});
					$.ajax({
						url: '/www/php/upload.php?id='+id,
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function(data){
							//alert(data);
							console.log(data);
							$.modal.close();
						}
					});					
									},
				initNobleCountPlugin: function()
				{
					var maxChar = $('#description').attr("maxlength");
					$('#description').NobleCount('#description-counter',{
						max_chars: maxChar,
						block_negative: true
		
					});
				},
				initDateTimePickerPlugin: function()
				{
					
					var thisObj = this;
					var CalendarIcon = '/www/content/images/icons/date-picker-icon.png';
					var CalendarOptions = { 
						showOn: "both", 
						buttonText: "",
						timeFormat: 'h:mm TT',
						//dateFormat: 'yy-mm-dd',
						//dateFormat: 'yy-mm-dd',
						dateFormat: 'mm/dd/yy',
						/*
						minDate: getDateObject(GlobalVariables.CalendarMinDate),
						maxDate: getDateObject(GlobalVariables.CalendarMaxDate),
						*/
						beforeShow: getCustomRange,
						firstDay: 0,  
						changeFirstDay: false,
						buttonImage: CalendarIcon,
						buttonImageOnly: true,  			
						showButtonPanel: false,
						hour: "00",
    					minute: "00"
					}
					var startDate = this.model.get('start');
					var startTime = startDate.split(" ")[1];
					var startTimeArray = startTime.split(":");
					var startHour = startTimeArray[0];
					var startMinute = startTimeArray[1];
					CalendarOptions.hour = startHour;
					CalendarOptions.minute = startMinute;
					//CalendarOption.hour
					$('#StartDate').datetimepicker(CalendarOptions);	
					
					var endDate = this.model.get('end');
					var endTime = startDate.split(" ")[1];
					var endTimeArray = endTime.split(":");
					var endHour = endTimeArray[0];
					var endMinute = endTimeArray[1];
					CalendarOptions.hour = endHour;
					CalendarOptions.minute = endMinute;
											
					$('#EndDate').datetimepicker(CalendarOptions);	
									
					//$('#StartDate').datepicker(CalendarOptions); 
					//$('#EndDate').datepicker(CalendarOptions);
					
					function getCustomRange()
					{
						
						var id=$(this).attr('id');
						var time = " 00:00:00";
						var dateString;
						if(id=="StartDate")
						{
							var endDate = $("#EndDate").val();		
							var dateTimeArray = endDate.split(" ");		
							var dateArray = dateTimeArray[0].split("/");	
							endDate = dateArray[2]+"-"+dateArray[0]+"-"+dateArray[1];
							dateString = endDate.trim().length>0 ? endDate+time : GlobalVariables.CalendarMaxDate;
							return { maxDate: getDateObject(dateString) }	
						}
						else
						{
							var startDate = $("#StartDate").val();	
							var dateTimeArray = startDate.split(" ");		
							var dateArray = dateTimeArray[0].split("/");		
							startDate = dateArray[2]+"-"+dateArray[0]+"-"+dateArray[1];					
							dateString = startDate.trim().length>0 ? startDate+time : GlobalVariables.CalendarMinDate;
							return { minDate: getDateObject(dateString) }
						}
					}
					/*
					TimePickerOverlay.URL = "/bookfairs/cptoolkit/onlinefair_includes/overlays/TimePickerOverlay.html";
					TimePickerOverlay.loadAjax = true;
					EventsTimepicker.init();
					*/
		
					//$('#start').timepicker();	
						
				}
			}); // end AddEditEventModalOverlayView	
				
			DisplayEventModalOverlayView = Backbone.View.extend({	
				tagName:  "div",
				template: _.template($('#Display-Event-ModalOverlay-Template').html()),
				id: '#DisplayEventModal',
				events: {
				  "click .simplemodal-close"   : "close"
				},
		
				initialize: function() {
				 
				},
			
				// Re-render the titles of the tasks item.
				render: function() {		
					var jsonModel = this.model.toJSON();
					var thisObj = this;		
						
					$('#DisplayEventModal').remove();

					//console.log(jsonModel);
					if(user.get("isAdmin")==true || (jsonModel["user_id"]!="0" && jsonModel["user_id"]==user.get('id'))){
						jsonModel["isEditable"] = true;
					}
					else
					{
						jsonModel["isEditable"] = false;
					}
					//console.log("render this.el = " + this.el);
					//console.log('jsonModel = ' + JSON.stringify(jsonModel));
					var template = this.template(jsonModel);						
					$('body').append(template);
					
					this.initModal();
					return this;						 		  		  
				},
				initDelegateEvents: function()
				{
					var thisObj = this;
					$(this.id + " .delete-model-link").on("click.modal", function(){
						thisObj.close(); 
						var DeleteEventModalOverlay = new DeleteEventModalOverlayView({model: thisObj.model });
						DeleteEventModalOverlay.render();
						return false; 
					});			
				},				
				initModal: function(){ 
					var thisObj = this; 
					/*
					$(this.id).modal({
						autoResize: false,
						fixed: false,
						overlayId: 'EventModalOverlay',
						containerId: 'EventModalContainer',
						onShow: this.show(),
						onClose: this.close()
					});
					*/
					$(this.id).on('shown.bs.modal', function () {
						 thisObj.show();
					  })			
					$.modal = $(this.id).modal();						
								
				},
				show: function(){
					var thisObj = this;
					$(this.id + " .edit-model-link").on("click.modal", function(){
						thisObj.close(); 
						var AddEditEventModalOverlay = new AddEditEventModalOverlayView({model: thisObj.model });
						AddEditEventModalOverlay.render();						
						return false; 
					});						
					this.initDelegateEvents();
					//this.initPlugins();
					 //$(this.id + ' .do-delete-link').on("click.modal", function(){thisObj.destroy(); return false; }); 
					 //$('#DeleteEventOverlay').on("click.modal", ".simplemodal-close", function(){thisObj.close(); return false; }); 
				},
				close: function(){
					$(this.id).off("click.modal", ".do-save-link"); 
					//$.modal.close();
					$.modal.modal('hide');
					$(this.id).detach();
					
				}
				
			}); // end DisplayEventModalOverlayView			
			
	}
}
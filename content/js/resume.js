// JavaScript Document
$(document).ready(function(){
	
	$.ajax({
		url: "/www/content/templates/resume.html",
		}).done(function(data) {
			$('body').append(data);
			Resume.init();
	});
});
var PersonalInfo = {
	city: 'Edison',
	state: 'NJ',
	zip: '08817',	
	email: 'hoyenlee@gmail.com'	
}
var Resume =
{
	template: null,
	init: function()
	{
		this.template = _.template($('#Resume-Personal-Info-Template').html());
		var html = this.template(PersonalInfo);
		$('#personal-info').html(html);
	}
	
}

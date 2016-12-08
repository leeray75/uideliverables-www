function viewMessage(id, url) {
	var request = {'id':id};
	$('#bbii-message').toggleClass('spinner');
	$('#bbii-message').html('');
	$.post(url, request, function(data) {
		if(data.success == 'yes') {
			$("#bbii-message").html(data.html);
			$('#bbii-message').toggleClass('spinner');
		} else {
			alert(data.message);
			$('#bbii-message').toggleClass('spinner');
		}
	}, 'json');
}

function viewPost(id, url) {
	var request = {'id':id};
	$('#bbii-message').toggleClass('spinner');
	$('#bbii-message').html('');
	$.post(url, request, function(data) {
		if(data.success == 'yes') {
			$("#bbii-message").html(data.html);
			$('#bbii-message').toggleClass('spinner');
		} else {
			alert(data.message);
			$('#bbii-message').toggleClass('spinner');
		}
	}, 'json');
}

function deletePost(url) {
	var request = {'ajax': '1'};
	$.ajax({
		url: url,
		type: "GET",
		dataType: "json",
		data: request,
	});
}

function reportPost(id) {
	$('#BbiiMessage_post_id').val(id);
	$('#dlgReportForm').dialog('open');
}

function sendReport() {
	var formdata = $('#report-form').serialize();
	var url = $('#url').val();
	$.post(url, formdata, function(data) {
		if(data.success == 'yes') {
			alert(data.message);
			$("#dlgReportForm").dialog('close');
		} else {
			alert(data.message);
			$("#dlgReportForm").dialog('close');
		}
	}, 'json');
}

function banIp(id, url) {
	url = url + /id/ + id;
	$.get(url);
}

function updateTopic(id, url) {
	$.post(url, {'id': id}, function(data) {
		if(data.success == 'yes') {
			$('#BbiiTopic_id').val(id);
			$('#BbiiTopic_forum_id').val(data.forum_id);
			$('#BbiiTopic_title').val(data.title);
			$('#BbiiTopic_locked').val(data.locked);
			$('#BbiiTopic_sticky').val(data.sticky);
			$('#BbiiTopic_global').val(data.global);
			$('#BbiiTopic_merge').html(data.option);
			$("#dlgTopicForm").dialog('open');
		} else {
			alert(data.message);
			$("#dlgTopicForm").dialog('close');
		}
	}, 'json');
}

function refreshTopics(obj, url) {
	$.post(url, {'id': obj.value}, function(data) {
		if(data.success == 'yes') {
			$('#BbiiTopic_merge').html(data.option);
		} else {
			alert(data.message);
		}
	}, 'json');
	return false;
}

function changeTopic(url) {
	var formdata = $('#update-topic-form').serialize();
	$.post(url, formdata, function(data) {
		if(data.success == 'yes') {
			$("#dlgTopicForm").dialog('close');
		} else {
			settings = $('#update-topic-form').data('settings');
			$.each(settings.attributes, function () {
				$.fn.yiiactiveform.updateInput(this, data.error, $('#update-topic-form'));
			});
		}
	}, 'json');
}
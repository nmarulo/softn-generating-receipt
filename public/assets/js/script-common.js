var idMessages = '';
var divMessageContent = '';
var messagesTimeout = null;

(function () {
	setVars();
	registerEvents();
})();

function setVars() {
	idMessages = '#messages';
	divMessageContent = '.messages-content';
}

function registerEvents() {
	if ($(document).find(idMessages).length > 0) {
		removeMessagesTimeOut();
	}
}

function removeMessagesTimeOut() {
	if (messagesTimeout != null) {
		clearTimeout(messagesTimeout);
	}
	
	messagesTimeout = setTimeout(function () {
		removeMessages();
	}, 5000);
}

function removeMessages() {
	var divMessages = $(document).find(idMessages);
	var messagesContent = divMessages.find(divMessageContent);
	
	if (messagesContent.length > 1) {
		messagesContent.get(0).remove();
		removeMessagesTimeOut();
	} else {
		divMessages.remove();
	}
}

function includeMessages() {
	var setContentView = function (data) {
		var divMessages = $(document).find(idMessages);
		var element = $('body');
		
		if (divMessages.length > 0) {
			element = divMessages;
			data = $(data).find(divMessageContent);
		}
		
		element.append(data);
		removeMessagesTimeOut();
	};
	
	callAjax('messages', 'POST', '', setContentView, false);
}

function callAjax(url, method, data, callback, parseJSON) {
	$.ajax({
		method: method,
		url: url,
		data: data
	}).done(function (data, textStatus, jqXHR) {
		callBack(data, callback, parseJSON)
	}).fail(function (jqXHR, textStatus, errorThrown) {
		//TODO: registrar error.
		console.log(jqXHR.statusText + '[' + jqXHR.status + '] ' + jqXHR.responseText);
		callBack(false, callback, false);
	});
}

function callBack(data, callback, parseJSON) {
	if (callback !== undefined) {
		var parseData = data;
		
		if (parseJSON) {
			parseData = JSON.parse(data);
		}
		
		callback(parseData);
	}
}

function btnDisabled(btn, disabled) {
	btn.attr('disabled', disabled);
}

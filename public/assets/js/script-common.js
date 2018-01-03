var idMessages = '';

(function () {
	setVars();
	registerEvents();
})();

function setVars() {
	idMessages = '#messages';
}

function registerEvents() {
	if ($(document).find(idMessages).length > 0) {
		removeMessagesTimeOut();
	}
}

function removeMessagesTimeOut() {
	if (timeout != undefined) {
		clearTimeout(timeout);
	}
	var timeout = setTimeout(function () {
		removeMessages();
	}, 5000);
}

function removeMessages() {
	var divMessages = $(document).find(idMessages);
	var messagesContent = divMessages.find('.messages-content');
	
	if (messagesContent.length > 1) {
		messagesContent.get(0).remove();
		removeMessagesTimeOut();
	} else {
		divMessages.remove();
	}
}

function includeMessages(url, messages, typeMessage) {
	var data = {
		method: 'messages',
		messages: messages,
		typeMessage: typeMessage
	};
	
	var setContentView = function (data) {
		$('body').append(data);
		removeMessagesTimeOut();
	};
	
	callAjax(url, data, setContentView, false);
}

function callAjax(url, method, data, callback, parseJSON) {
	$.ajax({
		method: method,
		url: url,
		data: data
	}).done(function (data, textStatus, jqXHR) {
		console.log('callAjax LOG |');
		console.log(data);
		if (callback !== undefined) {
			var parseData = data;
			
			if (parseJSON) {
				parseData = JSON.parse(data);
			}
			
			callback(parseData);
		}
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.log('ERROR: ' + textStatus);
	});
}

function btnDisabled(btn, disabled) {
	btn.attr('disabled', disabled);
}

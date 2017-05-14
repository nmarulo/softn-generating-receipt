function callAjaxParseJSON(url, data, callback) {
	callAjax(url, data, callback, true);
}

function callAjax(url, data, callback, parseJSON) {
	$.ajax({
		url: url,
		data: data
	}).done(function (data, textStatus, jqXHR) {
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

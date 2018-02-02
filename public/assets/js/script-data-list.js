var dataTableList = '';
var idDataTableList = '';
var classPaginationContainer = '';

(function () {
	setVar();
	registerEvents();
})();

function setVar() {
	classPaginationContainer = '.pagination-container';
	idDataTableList = '#data-table-list';
	dataTableList = $(idDataTableList);
}

function registerEvents() {
	$(document).on('click', '.pagination-container .pagination li > a', function (event) {
		event.preventDefault();
		pagination($(this));
	});
}

function pagination(element) {
	if ($(this).parent().hasClass('disabled') || element.data('page') == null) {
		return;
	}
	
	var setContentList = function (data) {
		dataTableList.html($(data).find(idDataTableList).html());
		dataTableList.parent()
			.find(classPaginationContainer)
			.each(function () {
				$(this).html($(data).find(idDataTableList).parent().find(classPaginationContainer).html());
			});
	};
	callAjax('clients', 'GET', {'page': element.data('page')}, setContentList, false);
}

var dataTableList = '';
var idDataTableList = '';
var classPaginationContainer = '';
var idDivPanelContent = '';

(function () {
	setVar();
	registerEvents();
})();

function setVar() {
	classPaginationContainer = '.pagination-container';
	idDataTableList = '#data-table-list';
	dataTableList = $(idDataTableList);
	idDivPanelContent = '#content-index';
}

function registerEvents() {
	$(document).on('click', '.pagination-container .pagination li > a', function (event) {
		event.preventDefault();
		pagination($(this));
	});
}

function pagination(element) {
	var page = element.data('page');
	var url = element.data('url');
	
	if ($(this).parent().hasClass('disabled') || page == null || url == null) {
		return;
	}
	
	var setContentList = function (data) {
		dataTableList.html($(data).find(idDataTableList).html());
		dataTableList.closest(idDivPanelContent)
			.find(classPaginationContainer)
			.each(function () {
				$(this).html($(data).find(idDataTableList)
					.closest(idDivPanelContent)
					.find(classPaginationContainer).html());
			});
	};
	
	callAjax(url, 'GET', {'page': page}, setContentList, false);
}

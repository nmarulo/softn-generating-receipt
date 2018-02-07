var dataTableList = '';
var idDataTableList = '';
var classPaginationContainer = '';
var idDivPanelContent = '';
var dataTableSort = '';
var currentTHeadTHElement = null;

(function () {
	setVar();
	registerEvents();
})();

function setVar() {
	classPaginationContainer = '.pagination-container';
	idDataTableList = '#data-table-list';
	dataTableList = $(idDataTableList);
	idDivPanelContent = '#content-index';
	dataTableSort = 'desc';
}

function registerEvents() {
	$(document).on('click', classPaginationContainer + ' .pagination li > a', function (event) {
		event.preventDefault();
		pagination($(this));
	});
	
	$(document).on('click', idDataTableList + ' thead > tr > th', function () {
		var element = $(this);
		
		if (element.data('column') == null) {
			return;
		}
		
		if (currentTHeadTHElement !== element.get(0)) {
			if (currentTHeadTHElement != null) {
				currentTHeadTHElement.classList.remove('active');
			}
			
			currentTHeadTHElement = element.get(0);
		}
		
		tableOrderByColumn(currentTHeadTHElement, element.closest(idDivPanelContent).find(classPaginationContainer));
	})
}

function pagination(element) {
	var page = element.data('page');
	var url = element.data('url');
	
	if (element.parent().hasClass('disabled') || page == null || url == null) {
		return;
	}
	
	var data = getDataTableToSend(page, currentTHeadTHElement, dataTableSort);
	
	callAjax(url, 'GET', data, updateDataTablePagination, false);
}

function updateDataTablePagination(data) {
	dataTableList.html($(data).find(idDataTableList).html());
	dataTableList.closest(idDivPanelContent)
		.find(classPaginationContainer)
		.each(function () {
			$(this).html($(data).find(idDataTableList)
				.closest(idDivPanelContent)
				.find(classPaginationContainer).html());
		});
	dataTableList.find('thead tr th[data-column]').each(function () {
		if (currentTHeadTHElement != null && $(this).text() === currentTHeadTHElement.innerText) {
			$(this).addClass('active');
		}
	});
}

function tableOrderByColumn(column, paginationContainer) {
	var page = 1;
	
	if (paginationContainer != null) {
		page = paginationContainer.find('.pagination').find('li[class=active]').get(0).innerText;
	}
	
	callAjax(document.URL, 'GET', getDataTableToSend(page, column, getSort()), updateDataTablePagination, false);
}

function getSort() {
	if (dataTableSort === 'desc') {
		dataTableSort = 'asc';
	} else {
		dataTableSort = 'desc';
	}
	
	return dataTableSort;
}

function getDataTableToSend(page, orderBy, sort) {
	if (orderBy == null || !orderBy.hasAttribute('data-column')) {
		orderBy = ''
	} else {
		orderBy = orderBy.getAttribute('data-column');
	}
	
	return {'order_by': orderBy, 'page': page, 'sort': sort};
}

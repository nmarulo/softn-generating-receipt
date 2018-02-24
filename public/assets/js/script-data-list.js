var dataTableList = '';
var idDataTableList = '';
var classPaginationContainer = '';
var idDivPanelContent = '';
var dataTableSort = '';
var dataTableSortDefault = '';
var currentTHeadTHElement = null;
var inputSearchDataValue = null;
var formDataTableList = null;
var formCanSearch = false;

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
    dataTableSortDefault = 'desc';
    formDataTableList = $('.form-data-table-list');
    inputSearchDataValue = formDataTableList.find('.search-data');
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
        
        if (element.hasClass('active')) {
            dataTableSort = getSort();
        } else {
            dataTableSort = dataTableSortDefault;
            
            if (currentTHeadTHElement != null) {
                currentTHeadTHElement.classList.remove('active');
            }
            
            currentTHeadTHElement = element.get(0);
        }
        
        updateDataTablePagination();
    });
    
    formDataTableList.on('submit', function (event) {
        event.preventDefault();
        updateDataTablePagination();
    });
    
    inputSearchDataValue.on('keyup', function () {
        var element = $(this);
        
        if (element.val().length > 1) {
            formCanSearch = true;
            element.closest('form').submit();
        } else if (formCanSearch) {
            formCanSearch = false;
            element.val('');
            element.closest('form').submit();
        }
    });
    
    formDataTableList.on('change', '[type=radio]', function(){
        inputSearchDataValue.trigger('keyup');
    });
}

function pagination(element) {
    var page = element.data('page');
    var url = element.data('url');
    
    if (element.parent().hasClass('disabled') || page == null || url == null) {
        return;
    }
    
    updateDataTablePagination(getDataTableToSend(page));
}

function updateDataTablePagination(dataToSend) {
    var callBack = function (data) {
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
    };
    
    if (dataToSend === undefined) {
        dataToSend = getDataTableToSend();
    }
    
    callAjax(document.URL, 'GET', dataToSend, callBack, false);
}

function getSort() {
    if (dataTableSort === 'desc') {
        dataTableSort = 'asc';
    } else {
        dataTableSort = 'desc';
    }
    
    return dataTableSort;
}

function getDataTableToSend(page) {
    var orderBy = currentTHeadTHElement;
    var formSearch = formDataTableList.serializeArray();
    
    if (orderBy == null || !orderBy.hasAttribute('data-column')) {
        orderBy = ''
    } else {
        orderBy = orderBy.getAttribute('data-column');
    }
    
    if (page === undefined) {
        page = getPageActive();
    }
    
    return formSearch.concat([
        createData('order_by', orderBy),
        createData('page', page),
        createData('sort', dataTableSort)
    ]);
}

function createData(name, value) {
    return {'name': name, 'value': value};
}


function getPageActive() {
    var page = 1;
    var paginationContainer = $(document).find(idDivPanelContent).find(classPaginationContainer);
    
    if (paginationContainer.length > 0) {
        var pagination = paginationContainer.find('.pagination');
        
        if (pagination.length > 0) {
            page = pagination.find('li[class=active]').get(0).innerText;
        }
    }
    
    return page;
}

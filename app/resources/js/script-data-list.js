var btnSearch = '';
var btnClearSearch = '';
var ulContentDataList = '';
var inputSearchData = '';

(function () {
	setVar();
	registerEvents();
	setContentList();
})();

function setVar() {
	btnSearch = $('#btn-search');
	btnClearSearch = $('#btn-clear-search');
	ulContentDataList = $('#content-data-list');
	inputSearchData = $('#search-data');
}

function registerEvents() {
	btnSearch.on('click', function () {
		setContentList();
	});
	
	btnClearSearch.on('click', function () {
		inputSearchData.val('');
		setContentList();
	});
}

function setContentList() {
	var pageName = btnSearch.closest('div').data('page-name');
	var url = '.php';
	
	if(pageName === undefined || pageName.length === 0){
		return false;
	}
	
	url = pageName + url;
	var search = inputSearchData.val();
	
	var setContentList = function (data) {
		ulContentDataList.html(data);
	};
	
	var data = {
		method: 'dataList'
	};
	
	if (search.length > 0) {
		data['search'] = search;
	}
	
	callAjax(url, data, setContentList, false);
}


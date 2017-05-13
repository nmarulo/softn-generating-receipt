var inputSearchData = '';
var formGenerateReceipt = '';
var btnGenerateReceipt = '';
var divContentAutocompleteModal = '';
var divContentListGroup = '';
var divModalGenerateReceipt = '';
var inputReceiptClient = '';
var inputHiddenReceiptClientId = '';
var inputHiddenReceiptProducts = '';
var inputReceiptProduct = '';
var inputReceiptProductUnit = '';
var ulListSelectedProducts = '';
var selectedProductId = 0;
//Método que establece el valor al input de producto
//y el identificador del producto seleccionado.
var setProductInput = '';
//Método que establece el valor al input de cliente
//y el identificador del cliente seleccionado.
var setClientInput = '';
//Lista de productos
var listProductsIdAndUnits = [];

(function () {
	setVars();
	registerEvents();
})();

function setVars() {
	formGenerateReceipt = $('#form-generate-receipt');
	btnGenerateReceipt = $('#btn-generate-receipt');
	divModalGenerateReceipt = $('#modal-generate-receipt');
	divContentAutocompleteModal = $('.content-autocomplete-modal');
	inputReceiptClient = $('#receipt-client');
	inputHiddenReceiptClientId = $('#receipt-client-id');
	inputHiddenReceiptProducts = $('#receipt-products');
	inputReceiptProduct = $('#receipt-product');
	inputReceiptProductUnit = $('#receipt-product-unit');
	ulListSelectedProducts = $('#list-selected-products');
	
	//Establece la información del producto seleccionado.
	setProductInput = function (element) {
		var exists = false;
		var productId = element.data('element-id');
		inputReceiptProduct.val(element.text());
		selectedProductId = productId;
		
		/*
		 * En caso de que ya esta en la lista de productos,
		 * evito agregarlo, ya que esta función se llamara con cada click.
		 */
		for (var i = 0; i < listProductsIdAndUnits.length && !exists; ++i) {
			if (listProductsIdAndUnits[i]['id'] == productId) {
				exists = true;
			}
		}
		
		if (!exists) {
			listProductsIdAndUnits.push({
				id: productId,
				'receipt_product_unit': 1
			})
		}
	};
	
	//Establece la información del cliente seleccionado.
	setClientInput = function (element) {
		inputReceiptClient.val(element.text());
		inputHiddenReceiptClientId.val(element.data('element-id'));
	};
}

/**
 * Método que establece los eventos principales.
 */
function registerEvents() {
	inputReceiptClient.on('click', function () {
		setContentAutocompleteModalElements($(this));
		divContentAutocompleteModal.modal('show');
		setDataContentListGroupAndRegisterEvents('getClients', 'getId', 'getClientName', '');
		registerEventContentListGroup(setClientInput, 'getClients', 'getId', 'getClientName');
	});
	
	inputReceiptProduct.on('click', function () {
		setContentAutocompleteModalElements($(this));
		divContentAutocompleteModal.modal('show');
		setDataContentListGroupAndRegisterEvents('getProducts', 'getId', 'getProductName', '');
		registerEventContentListGroup(setProductInput, 'getProducts', 'getId', 'getProductName');
	});
	
	inputReceiptProduct.on('focus', function(){
		$(this).trigger('click');
	});
	
	inputReceiptClient.on('focus', function(){
		$(this).trigger('click');
	});
	
	$('#btn-add-product').on('click', function () {
		var exit = false;
		
		for (var i = 0; i < listProductsIdAndUnits.length && !exit; ++i) {
			if (listProductsIdAndUnits[i]['id'] == selectedProductId) {
				listProductsIdAndUnits[i]['receipt_product_unit'] = inputReceiptProductUnit.val();
				exit = true;
			}
		}
		
		setListSelectedProducts(listProductsIdAndUnits);
		setInputHiddenReceiptProducts(listProductsIdAndUnits);
		inputReceiptProduct.val('');
		inputReceiptProductUnit.val(1);
	});
	
	$(document).on('click', '#btn-remove-product', function () {
		var exit = false;
		var elementLi = $(this).closest('li');
		var productId = elementLi.data('element-id');
		
		//Busca y elimina el producto.
		for (var i = 0; i < listProductsIdAndUnits.length && !exit; ++i) {
			if (listProductsIdAndUnits[i]['id'] == productId) {
				listProductsIdAndUnits.splice(i, 1);
				exit = true;
			}
		}
		
		//Actualiza el input.
		setInputHiddenReceiptProducts(listProductsIdAndUnits);
		//Borra el elemento actual.
		elementLi.remove();
	});
	
	$('.btn-generate-pdf').on('click', function (event) {
		event.preventDefault();
		generatePDF($(this).data('receipt-id'));
	});
	
	btnGenerateReceipt.on('click', function (event) {
		event.preventDefault();
		generatingReceipt();
	});
	
	divModalGenerateReceipt.on('hide.bs.modal', function () {
		location.reload();
	});
}

/**
 *
 * @param receiptID
 * @param isPageGenerating bool True si estoy en la pagina generating.php
 */
function generatePDF(receiptID, isPageGenerating) {
	var dataPDF = function (data) {
		var client = data['client'];
		var products = data['products'];
		var receipt = data['receipt'];
		var options = data['options'];
		var dataUrlString = createPDF(client, products, receipt, options, isPageGenerating);
		
		if (isPageGenerating) {
			divModalGenerateReceipt.modal('show');
			$('#btn-generate-pdf').on('click', function (event) {
				event.preventDefault();
				window.open(dataUrlString, '_blank');
				divModalGenerateReceipt.modal('hide');
			});
		}
	};
	var data = {
		method: 'dataPDF',
		id: receiptID
	};
	callAjaxParseJSON('receipts.php', data, dataPDF);
}

function registerEventContentListGroup(callbackSetDataInput, methodGetData, methodGetId, methodGetName) {
	divContentListGroup.on('click', 'button', function () {
		callbackSetDataInput($(this));
		divContentAutocompleteModal.modal('hide');
	});
	
	inputSearchData.on('keyup', function () {
		var inputText = $(this).val();
		
		if (inputText.length < 3 || (isNaN(inputText) && inputText.length == 0)) {
			inputText = '';
		}
		
		setDataContentListGroupAndRegisterEvents(methodGetData, methodGetId, methodGetName, inputText);
	});
}

function setContentAutocompleteModalElements(element) {
	divContentAutocompleteModal = element.closest('.form-group').find('.content-autocomplete-modal');
	divContentListGroup = divContentAutocompleteModal.find('.content-autocomplete-data-list');
	inputSearchData = divContentAutocompleteModal.find('.search-data');
}

function setDataContentListGroupAndRegisterEvents(methodGetData, methodGetId, methodGetName, search) {
	var setContentList = function (data) {
		divContentListGroup.html(data);
	};
	
	var data = {
		method: 'dataList',
		methodGetId: methodGetId,
		methodGetName: methodGetName,
		methodGetData: methodGetData
	};
	
	if (search.length > 0) {
		data['search'] = search;
	}
	
	callAjax('generating.php', data, setContentList, false);
}

function setInputHiddenReceiptProducts(listProducts) {
	inputHiddenReceiptProducts.val(JSON.stringify(listProducts));
}

function setListSelectedProducts(listProductsIdAndUnits) {
	var setContentList = function (data) {
		ulListSelectedProducts.html(data);
	};
	
	var data = {
		method: 'selectedProducts',
		productsIdAndUnits: listProductsIdAndUnits
	};
	
	callAjax('generating.php', data, setContentList, false);
}

function generatingReceipt() {
	var data = formGenerateReceipt.serialize();
	
	var showPDF = function (data) {
		generatePDF(data['id'], true);
	};
	
	var getReceiptId = function (data) {
		callAjaxParseJSON('receipts.php', {method: 'lastInsert'}, showPDF);
	};
	
	callAjax('generating.php', data, getReceiptId);
}

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

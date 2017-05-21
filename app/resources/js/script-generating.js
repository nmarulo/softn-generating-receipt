var inputSearchData = '';
var formGenerateReceipt = '';
var btnGenerateReceipt = '';
var divContentAutocompleteModal = '';
var divContentAutocompleteListGroup = '';
var inputReceiptClient = '';
var inputHiddenReceiptClientId = '';
var inputHiddenReceiptProducts = '';
var inputReceiptProduct = '';
var inputReceiptProductUnit = '';
var contentSelectedProducts = '';
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
	divContentAutocompleteModal = $('.content-autocomplete-modal');
	inputReceiptClient = $('#receipt-client');
	inputHiddenReceiptClientId = $('#receipt-client-id');
	inputHiddenReceiptProducts = $('#receipt-products');
	inputReceiptProduct = $('#receipt-product');
	inputReceiptProductUnit = $('#receipt-product-unit');
	contentSelectedProducts = $('#list-selected-products');
	
	//Establece la información del producto seleccionado.
	setProductInput = function (element) {
		inputReceiptProduct.val(element.text());
		selectedProductId = element.data('element-id');
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
	
	inputReceiptProduct.on('focus', function () {
		$(this).trigger('click');
	});
	
	inputReceiptClient.on('focus', function () {
		$(this).trigger('click');
	});
	
	$('#btn-add-product').on('click', function () {
		var exists = false;
		var productUnits = inputReceiptProductUnit.val();
		
		//Comprueba si ya existe, el producto en la lista y actualiza la unidades.
		for (var i = 0; i < listProductsIdAndUnits.length && !exists; ++i) {
			if (listProductsIdAndUnits[i]['id'] == selectedProductId) {
				listProductsIdAndUnits[i]['receipt_product_unit'] = productUnits;
				exists = true;
			}
		}
		
		//Si no existe, agrega el producto a la lista.
		if (!exists) {
			listProductsIdAndUnits.push({
				id: selectedProductId,
				'receipt_product_unit': productUnits
			})
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
	
	btnGenerateReceipt.on('click', function (event) {
		event.preventDefault();
		generatingReceipt();
	});
	
	divContentAutocompleteModal.on('hide.bs.modal', function () {
		inputSearchData.val('');
	})
}

function registerEventContentListGroup(callbackSetDataInput, methodGetData, methodGetId, methodGetName) {
	divContentAutocompleteListGroup.on('click', 'button', function () {
		callbackSetDataInput($(this));
		divContentAutocompleteModal.modal('hide');
	});
	
	inputSearchData.on('keyup', function () {
		var inputText = $(this).val();
		
		if (inputText.length < 3 && isNaN(inputText)) {
			inputText = '';
		}
		
		setDataContentListGroupAndRegisterEvents(methodGetData, methodGetId, methodGetName, inputText);
	});
}

function setContentAutocompleteModalElements(element) {
	divContentAutocompleteModal = element.closest('div').find('.content-autocomplete-modal');
	divContentAutocompleteListGroup = divContentAutocompleteModal.find('.content-autocomplete-data-list');
	inputSearchData = divContentAutocompleteModal.find('.search-data');
}

function setDataContentListGroupAndRegisterEvents(methodGetData, methodGetId, methodGetName, search) {
	var setContentList = function (data) {
		divContentAutocompleteListGroup.html(data);
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
		contentSelectedProducts.html(data);
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
	
	var generateAndGetLastReceipt = function (data) {
		includeMessages('generating.php', data['messages'], data['typeMessage']);
		
		//Si es igual, la factura se genero.
		if (data['notError'] == '1') {
			formGenerateReceipt.find('input').each(function () {
				$(this).attr('disabled', true);
			});
			
			formGenerateReceipt.find('button').each(function () {
				$(this).attr('disabled', true);
			});
			
			btnGenerateReceipt.closest('div').addClass('hidden');
			callAjaxParseJSON('receipts.php', {method: 'lastInsert'}, showPDF);
		}
	};
	
	callAjaxParseJSON('generating.php', data, generateAndGetLastReceipt);
}

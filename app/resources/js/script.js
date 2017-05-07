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
var selectedProductsJSON = [];
var selectedProductJSON = 0;
//Método que establece el valor al input de producto
//y el identificador del producto seleccionado.
var setProductInput = '';
//Método que establece el valor al input de cliente
//y el identificador del cliente seleccionado.
var setClientInput = '';
//Lista de clientes
var clientsJSON = '';
//Lista de productos
var productsJSON = '';
//Método que establece la lista de clientes.
var setClientsJSON = '';
//Método que establece la lista de productos.
var setProductsJSON = '';
//Indica si se ha pulsado sobre los campos de cliente o producto.
var isEventInput = false;

(function () {
	setVars();
	setProductsAndClients();
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
	
	setProductInput = function (element) {
		var exit = false;
		var productId = element.data('product-id');
		inputReceiptProduct.val(element.text());
		
		for (var i = 0; i < productsJSON.length && !exit; ++i) {
			if (productsJSON[i]['id'] == productId) {
				selectedProductJSON = productsJSON[i];
				exit = true;
			}
		}
	};
	
	setClientInput = function (element) {
		inputReceiptClient.val(element.text());
		inputHiddenReceiptClientId.val(element.data('client-id'));
	};
	
	setClientsJSON = function (data) {
		clientsJSON = data;
	};
	
	setProductsJSON = function (data) {
		productsJSON = data;
	};
}

/**
 * Método que establece la lista de clientes y productos.
 */
function setProductsAndClients() {
	callAjaxParseJSON('clients.php', {method: 'getClientsJSON'}, setClientsJSON);
	callAjaxParseJSON('products.php', {method: 'getProductsJSON'}, setProductsJSON);
}

function registerEvents() {
	inputReceiptClient.on('click', function () {
		setContentAutocompleteModalElements($(this));
		divContentAutocompleteModal.modal('show');
		setDataContentListGroup(clientsJSON, 'id', 'client_name', 'client');
		registerEventContentListGroup(setClientInput, 'clients.php', 'getClientsJSON', function (data) {
			clientsJSON = data;
			setDataContentListGroup(clientsJSON, 'id', 'client_name', 'client');
		});
	});
	
	inputReceiptProduct.on('click', function () {
		setContentAutocompleteModalElements($(this));
		divContentAutocompleteModal.modal('show');
		setDataContentListGroup(productsJSON, 'id', 'product_name', 'product');
		registerEventContentListGroup(setProductInput, 'products.php', 'getProductsJSON', function (data) {
			productsJSON = data;
			setDataContentListGroup(productsJSON, 'id', 'product_name', 'product');
		});
	});
	
	$('#btn-add-product').on('click', function () {
		var exit = false;
		var ulLiElements = ulListSelectedProducts.find('li');
		
		//En caso de agregar el mismo producto.
		for (var i = 0; i < ulLiElements.length && !exit; ++i) {
			var ulLiElementSelect = $(ulLiElements[i]);
			
			if (ulLiElementSelect.data('product-id') == selectedProductJSON['id']) {
				ulLiElementSelect.find('#btn-remove-product').click()
			}
		}
		
		selectedProductJSON['receipt_product_unit'] = inputReceiptProductUnit.val();
		setListSelectedProducts(selectedProductJSON);
		selectedProductsJSON.push(selectedProductJSON);
		setInputHiddenReceiptProducts(selectedProductsJSON);
		inputReceiptProduct.val('');
		inputReceiptProductUnit.val(1);
	});
	
	$(document).on('click', '#btn-remove-product', function () {
		var exit = false;
		var elementLi = $(this).closest('li');
		var productId = elementLi.data('product-id');
		
		for (var i = 0; i < selectedProductsJSON.length && !exit; ++i) {
			if (selectedProductsJSON[i]['id'] == productId) {
				selectedProductsJSON.splice(i, 1);
				exit = true;
			}
		}
		setInputHiddenReceiptProducts(selectedProductsJSON);
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

function registerEventContentListGroup(callbackSetDataInput, url, method, callbackSetDataJSON) {
	divContentListGroup.on('click', 'button', function () {
		callbackSetDataInput($(this));
		divContentAutocompleteModal.modal('hide');
	});
	
	inputSearchData.on('keyup', function () {
		var element = $(this);
		var inputText = element.val();
		var data = {
			method: method
		};
		
		if (inputText.length >= 3 || (!isNaN(inputText) && inputText.length > 0)) {
			data['search'] = inputText;
			divContentListGroup.text('');
			callAjaxParseJSON(url, data, callbackSetDataJSON);
			
		} else {
			callAjaxParseJSON(url, data, callbackSetDataJSON);
		}
	});
}

function setContentAutocompleteModalElements(element) {
	divContentAutocompleteModal = element.closest('.form-group').find('.content-autocomplete-modal');
	divContentListGroup = divContentAutocompleteModal.find('.list-group');
	inputSearchData = divContentAutocompleteModal.find('.search-data');
}

function setDataContentListGroup(dataJSON, keyId, keyName, type) {
	//Evita que se rellene la lista si ya tiene contenido.
	if (divContentListGroup.text() !== '' && dataJSON.length > 0) {
		divContentListGroup.text('');
	}
	
	for (var i in dataJSON) {
		var name = dataJSON[i][keyName];
		var id = dataJSON[i][keyId];
		
		divContentListGroup.append('<button class="list-group-item" type="button" data-' + type + '-id="' + id + '">' + name + '</button>');
	}
}

function setInputHiddenReceiptProducts(productsJSON) {
	inputHiddenReceiptProducts.val(JSON.stringify(productsJSON));
}

function setListSelectedProducts(productJSON) {
	var productId = productJSON['id'];
	var productPriceUnit = productJSON['product_price_unit'];
	var productName = productJSON['product_name'];
	var productUnit = productJSON['receipt_product_unit'];
	var badgeProductUnit = '<span class="badge">Unidades: ' + productUnit + '</span>';
	var badgeProductPrice = '<span class="badge">Precio U.: ' + productPriceUnit + '</span>';
	var btnRemoveProduct = '<button id="btn-remove-product" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span></button>';
	
	ulListSelectedProducts.append('<li class="list-group-item" data-product-id="' + productId + '">' + badgeProductUnit + badgeProductPrice + productName + btnRemoveProduct + '</li>');
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

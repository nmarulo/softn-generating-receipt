var inputSearchData = '';
var formGenerateReceipt = '';
var btnGenerateReceipt = '';
var btnAddProduct = '';
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
	btnAddProduct = $('#btn-add-product');
	
	//Establece la información del producto seleccionado.
	setProductInput = function (element) {
		btnDisabled(btnAddProduct, false);
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
		setDataContentListGroupAndRegisterEvents('clients', 'client_name', '');
		registerEventContentListGroup(setClientInput, 'clients', 'client_name');
	});
	
	inputReceiptProduct.on('click', function () {
		setContentAutocompleteModalElements($(this));
		divContentAutocompleteModal.modal('show');
		setDataContentListGroupAndRegisterEvents('products', 'product_name', '');
		registerEventContentListGroup(setProductInput, 'products', 'product_name');
	});
	
	inputReceiptProduct.on('focus', function () {
		$(this).trigger('click');
	});
	
	inputReceiptClient.on('focus', function () {
		$(this).trigger('click');
	});
	
	btnAddProduct.on('click', function () {
		btnDisabled(btnAddProduct, true);
		
		if (selectedProductId === 0) {
			return false;
		}
		
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
		selectedProductId = 0;
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
		
		if (listProductsIdAndUnits.length === 0) {
			contentSelectedProducts.html('No hay productos seleccionados.');
		}
	});
	
	btnGenerateReceipt.on('click', function (event) {
		event.preventDefault();
		generatingReceipt();
	});
	
	divContentAutocompleteModal.on('hide.bs.modal', function () {
		inputSearchData.val('');
	})
}

function registerEventContentListGroup(callbackSetDataInput, methodGetData, methodGetName) {
	divContentAutocompleteListGroup.on('click', 'button', function () {
		callbackSetDataInput($(this));
		divContentAutocompleteModal.modal('hide');
	});
	
	inputSearchData.on('keyup', function () {
		var inputText = $(this).val();
		
		if (inputText.length < 3 && isNaN(inputText)) {
			inputText = '';
		}
		
		setDataContentListGroupAndRegisterEvents(methodGetData, methodGetName, inputText);
	});
}

function setContentAutocompleteModalElements(element) {
	divContentAutocompleteModal = element.closest('div').find('.content-autocomplete-modal');
	divContentAutocompleteListGroup = divContentAutocompleteModal.find('.content-autocomplete-data-list');
	inputSearchData = divContentAutocompleteModal.find('.search-data');
}

/**
 *
 * @param methodGetData
 * @param methodGetName
 * @param search
 */
function setDataContentListGroupAndRegisterEvents(methodGetData, methodGetName, search) {
	var setContentList = function (data) {
		divContentAutocompleteListGroup.html(data);
	};
	
	var data = {
		methodGetName: methodGetName,
		methodGetData: methodGetData
	};
	
	if (search.length > 0) {
		data['search'] = search;
	}
	
	callAjax('generating/datamodal', 'POST', data, setContentList, false);
}

function setInputHiddenReceiptProducts(listProducts) {
	inputHiddenReceiptProducts.val(JSON.stringify(listProducts));
}

function setListSelectedProducts(listProductsIdAndUnits) {
	var setContentList = function (data) {
		contentSelectedProducts.html(data);
	};
	
	var data = {
		productsIdAndUnits: listProductsIdAndUnits
	};
	
	callAjax('generating/selectedproducts', 'POST', data, setContentList, false);
}

function generatingReceipt() {
	var data = formGenerateReceipt.serialize();
	
	var generateAndGetLastReceipt = function (data) {
		includeMessages();
		contentSelectedProducts.text('');
		listProductsIdAndUnits = [];
		
		formGenerateReceipt.find('input').each(function () {
			$(this).attr('disabled', true);
		});
		
		formGenerateReceipt.find('select').each(function () {
			$(this).attr('disabled', true);
		});
		
		formGenerateReceipt.find('button').each(function () {
			$(this).attr('disabled', true);
		});
		
		if (typeof data === 'boolean') {
			return false;
		}
		
		btnGenerateReceipt.closest('div').addClass('hidden');
		$('#btn-group-actions-generate').removeClass('hidden');
		generatePDF(data['receipt_id'], true);
	};
	
	callAjax('generating', 'POST', data, generateAndGetLastReceipt, true);
}

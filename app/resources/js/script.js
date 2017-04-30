var inputReceiptClient = '';
var divContentAutocomplete = '';
var divDropdownAutocomplete = '';
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
		
		for(var i = 0; i < productsJSON.length && !exit; ++i){
			if(productsJSON[i]['id'] == productId){
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
	callAjax('clients.php', 'getClientsJSON', setClientsJSON);
	callAjax('products.php', 'getProductsJSON', setProductsJSON);
}

function registerEvents() {
	inputReceiptClient.on('click', function () {
		//Si esta visible uno de los "div" del "Content Autocomplete" se oculta.
		hiddenContentAutocomplete();
		isEventInput = true;
		getDivAutocomplete($(this));
		setClientsContentAutocomplete();
		showOrHiddenContentAutocomplete();
		registerEventContentAutocomplete(setClientInput);
	});
	inputReceiptProduct.on('click', function () {
		//Si esta visible uno de los "div" del "Content Autocomplete" se oculta.
		hiddenContentAutocomplete();
		isEventInput = true;
		getDivAutocomplete($(this));
		setProductsContentAutocomplete();
		showOrHiddenContentAutocomplete();
		registerEventContentAutocomplete(setProductInput);
	});
	$('body').on('click', function () {
		hiddenContentAutocomplete();
		//Ya que este evento sera llamado siempre, se establece a false
		//para que al pulsar en cualquier lugar
		//se cierre el "div" del "Content Autocomplete".
		isEventInput = false;
	});
	$('#btn-add-product').on('click', function(){
		selectedProductJSON['receipt_product_unit'] = inputReceiptProductUnit.val();
		setListSelectedProducts(selectedProductJSON);
		selectedProductsJSON.push(selectedProductJSON);
		setInputHiddenReceiptProducts(selectedProductsJSON);
		inputReceiptProduct.val('');
		inputReceiptProductUnit.val(1);
	});
	$(document).on('click', '#btn-remove-product', function(){
		var exit = false;
		var elementLi = $(this).closest('li');
		var productId = elementLi.data('product-id');
		
		for(var i = 0; i < selectedProductsJSON.length && !exit; ++i){
			if(selectedProductsJSON[i]['id'] == productId){
				selectedProductsJSON.splice(i, 1);
				exit = true;
			}
		}
		setInputHiddenReceiptProducts(selectedProductsJSON);
		elementLi.remove();
	});
	
	$('#btn-generate-pdf').on('click', function(){
		createPDF('','','');
	});
}

function getDivAutocomplete(element) {
	divContentAutocomplete = element.closest('.form-group').find('.content-autocomplete');
	divDropdownAutocomplete = divContentAutocomplete.find('.dropdown-autocomplete');
}

function showOrHiddenContentAutocomplete() {
	divContentAutocomplete.toggleClass('hidden');
}

function hiddenContentAutocomplete() {
	if (divContentAutocomplete !== '' && !divContentAutocomplete.hasClass('hidden') && !isEventInput) {
		divContentAutocomplete.addClass('hidden');
	}
}

function registerEventContentAutocomplete(callback) {
	divContentAutocomplete.on('click', 'li', function () {
		callback($(this));
		showOrHiddenContentAutocomplete();
	});
}

function setClientsContentAutocomplete() {
	//Evita que se rellene el desplegable si ya tiene contenido.
	if (divDropdownAutocomplete.text() !== '') {
		return;
	}
	
	for (var i in clientsJSON) {
		var clientName = clientsJSON[i]['client_name'];
		var clientId = clientsJSON[i]['id'];
		
		divDropdownAutocomplete.append('<li data-client-id="' + clientId + '">' + clientName + '</li>');
	}
}

function setProductsContentAutocomplete() {
	//Evita que se rellene el desplegable si ya tiene contenido.
	if (divDropdownAutocomplete.text() !== '') {
		return;
	}
	
	for (var i in productsJSON) {
		var productName = productsJSON[i]['product_name'];
		var productId = productsJSON[i]['id'];
		
		divDropdownAutocomplete.append('<li data-product-id="' + productId + '">' + productName + '</li>');
	}
}

function setInputHiddenReceiptProducts(productsJSON){
	inputHiddenReceiptProducts.val(JSON.stringify(productsJSON));
}

function setListSelectedProducts(productJSON){
	var productId = productJSON['id'];
	var productPriceUnit = productJSON['product_price_unit'];
	var productName = productJSON['product_name'];
	var productUnit = productJSON['receipt_product_unit'];
	var badgeProductUnit = '<span class="badge">Unidades: ' + productUnit + '</span>';
	var badgeProductPrice = '<span class="badge">Precio U.: ' + productPriceUnit + '</span>';
	var btnRemoveProduct = '<button id="btn-remove-product" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span></button>';
	
	ulListSelectedProducts.append('<li class="list-group-item" data-product-id="' + productId + '">' + badgeProductUnit + badgeProductPrice + productName + btnRemoveProduct + '</li>');
}

function callAjax(url, method, callback) {
	$.ajax({
		url: url,
		data: {
			method: method
		}
	}).done(function (data, textStatus, jqXHR) {
		callback(JSON.parse(data));
	});
}

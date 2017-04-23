function initGenerating() {
	var inputReceiptClient = '';
	var divContentAutocomplete = '';
	var divDropdownAutocomplete = '';
	var inputReceiptClientId = '';
	var inputHiddenReceiptProducts = '';
	var inputReceiptProduct = '';
	var productIdSelected = 0;
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
	
	setVars();
	setProductsAndClients();
	registerEvents();
	
	function setVars() {
		inputReceiptClient = $('#receipt-client');
		inputReceiptClientId = $('#receipt-client-id');
		inputHiddenReceiptProducts = $('#receipt-products');
		inputReceiptProduct = $('#receipt-product');
		setProductInput = function (element) {
			inputReceiptProduct.val(element.text());
			productIdSelected = element.data('product-id');
		};
		setClientInput = function (element) {
			inputReceiptClient.val(element.text());
			inputReceiptClientId.val(element.data('client-id'));
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
			//Para casos donde previamente este visible uno de los "div" del "Content Autocomplete".
			hiddenContentAutocomplete();
			isEventInput = true;
			getDivAutocomplete($(this));
			setClientsContentAutocomplete();
			showOrHiddenContentAutocomplete();
			registerEventContentAutocomplete(setClientInput);
		});
		inputReceiptProduct.on('click', function () {
			//Para casos donde previamente este visible uno de los "div" del "Content Autocomplete".
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
}

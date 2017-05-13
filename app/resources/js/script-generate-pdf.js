(function (api, $) {
	'use strict';
	api.textAlignRight = function (x, y, text) {
		
		// Get current font size
		var fontSize = this.internal.getFontSize();
		
		// Get the actual text's width
		/* You multiply the unit width of your string by your font size and divide
		 * by the internal scale factor. The division is necessary
		 * for the case where you use units other than 'pt' in the constructor
		 * of jsPDF.
		 */
		var txtWidth = this.getStringUnitWidth(text) * fontSize / this.internal.scaleFactor;
		
		x = x - txtWidth;
		
		//default is 'left' alignment
		this.text(text, x, y);
		
	}
	
})(jsPDF.API);

function getBase64Image(img) {
	
	var canvas = document.createElement("canvas");
	
	canvas.width = img.width;
	canvas.height = img.height;
	var ctx = canvas.getContext("2d");
	
	ctx.drawImage(img, 0, 0);
	
	var dataURL = canvas.toDataURL("image/jpeg");
	
	return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
	
}
// var img = new Image();
// img.onload = function () {
// 	var dataURI = getBase64Image(img);
// 	return dataURI;
// };
// img.src = "app/resources/img/softn.png";

function createPDF(client, products, receipt, options, dataUrlString) {
	var doc = new jsPDF();
	var marginX = 18;//Margen inicial izquierdo
	var marginXMax = 192;//Margen final derecho
	var marginY = 30;//Margen iniciar superior
	var fontSize = 12;//tamaño de letra por defecto
	var numRow = 15;//Total de filas de la tabla
	var rowSize = 7;//Tamaño de las filas
	var sizeTableHeight = rowSize * (numRow + 1);//Alto de la tabla
	var sizeTableWidth = marginXMax - marginX;//Ancho de la tabla
	var marginYBase = 0;
	var marginXBase = 0;
	var lineBaseX = 0;
	var lineBaseY = 0;
	var subtotal = 0.00;
	var ivaPercentage = parseInt(options['option_iva']);
	var ivaTotal = 0.00;
	var total = 0.00;
	var receiptNumber = '';
	var productSubtotal = 0.00;
	var strNumber = 'Número:';
	
	if (receipt['receipt_type'] == 'Presupuesto') {
		receiptNumber = '';
		strNumber = '';
	} else {
		if (receipt['receipt_number'] < 10) {
			receiptNumber = '000' + receipt['receipt_number'];
		} else if (receipt['receipt_number'] < 100) {
			receiptNumber = '00' + receipt['receipt_number'];
		} else if (receipt['receipt_number'] < 1000) {
			receiptNumber = '0' + receipt['receipt_number'];
		}
	}
	
	for (var i = 0; i < products.length; i = i + 1) {
		subtotal = subtotal + (products[i]['product']['product_price_unit'] * products[i]['receipt_product_unit']);
	}
	
	ivaTotal = (subtotal * ivaPercentage) / 100;
	ivaTotal = Math.round(ivaTotal * 100) / 100;
	total = ivaTotal + subtotal;
	total = Math.round(total * 100) / 100;
	
	//Imágenes -------------------------------------
	// doc.addImage(img.onload(), 'jpeg', marginX, marginY + 70, sizeTableWidth, 80);//facturaFondo
	doc.setTextColor(220, 0, 0);
	doc.setFontSize(fontSize);
	doc.setFontType('bold');
	doc.text(marginXMax - 58, marginY + 40, options['option_web_site'].toUpperCase());
	
	//Datos del encabezado -------------------------
	doc.setTextColor(102, 102, 102);
	doc.setFontSize(fontSize + 24);
	doc.setFontType('bold');
	doc.text(marginX, marginY, receipt['receipt_type'].toUpperCase());
	
	doc.setFontType('normal');
	doc.setFontSize(fontSize);
	doc.textAlignRight(marginXMax, marginY - 6, options['option_name']);
	doc.textAlignRight(marginXMax, marginY + 1, options['option_identification_document']);
	doc.textAlignRight(marginXMax, marginY + 7, options['option_address']);
	doc.textAlignRight(marginXMax, marginY + 14, options['option_phone_number']);
	
	doc.setFontSize(fontSize);
	doc.text(marginX, marginY + 10, strNumber);
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 17, marginY + 10, receiptNumber);
	
	doc.setTextColor(102, 102, 102);
	doc.text(marginX, marginY + 17, 'Fecha:');
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 17, marginY + 17, receipt['receipt_date']);
	
	//Datos del cliente ----------------------------
	doc.setDrawColor(102, 102, 102);
	doc.rect(marginX, marginY + 25, sizeTableWidth, 26);
	
	marginYBase = marginY + 30.6;
	doc.setTextColor(102, 102, 102);
	doc.text(marginX + 2, marginYBase, 'Cliente:');
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 22, marginYBase, client['client_name']);
	
	doc.setTextColor(102, 102, 102);
	doc.text(marginX + 2, marginYBase + 6, 'Domicilio:');
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 22, marginYBase + 6, client['client_address']);
	
	doc.setTextColor(102, 102, 102);
	doc.text(marginX + 2, marginYBase + 12, 'Ciudad:');
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 22, marginYBase + 12, client['client_city']);
	
	doc.setTextColor(102, 102, 102);
	doc.text(marginX + 2, marginYBase + 18, 'N.I.F:');
	doc.setTextColor(0, 0, 0);
	doc.text(marginX + 22, marginYBase + 18, client['client_identification_document']);
	
	//Tabla de artículos --------------------------
	//Fondo encabezado
	doc.setFillColor(200, 200, 200);
	marginYBase = marginY + 55;
	doc.rect(marginX, marginYBase, sizeTableWidth, rowSize, 'F');
	//Borde exterior
	doc.rect(marginX, marginYBase, sizeTableWidth, sizeTableHeight);
	
	marginYBase = marginY + 60;
	doc.setTextColor(220, 0, 0);
	doc.setFontType('bold');
	doc.text(marginX + 2, marginYBase, 'REF.');
	doc.text(marginX + 52, marginYBase, 'DESCRIPCIÓN');
	doc.text(marginXMax - 65.6, marginYBase, 'CANT.');
	doc.text(marginXMax - 49, marginYBase, 'PRECIO U.');
	doc.text(marginXMax - 24, marginYBase, 'SUBTOTAL');
	
	//Borde interior - columnas
	lineBaseX = marginX + 18;
	lineBaseY = marginY + 55;
	doc.line(lineBaseX, lineBaseY, lineBaseX, lineBaseY + sizeTableHeight);
	lineBaseX = lineBaseX + 89;
	doc.line(lineBaseX, lineBaseY, lineBaseX, lineBaseY + sizeTableHeight);
	lineBaseX = lineBaseX + 16;
	doc.line(lineBaseX, lineBaseY, lineBaseX, lineBaseY + sizeTableHeight);
	lineBaseX = lineBaseX + 25;
	doc.line(lineBaseX, lineBaseY, lineBaseX, lineBaseY + sizeTableHeight);
	
	//Borde interior - filas
	lineBaseX = marginX;
	lineBaseY = marginY + 62;
	doc.line(lineBaseX, lineBaseY, lineBaseX + sizeTableWidth, lineBaseY);
	for (var i = 1; i < numRow; i = i + 1) {
		lineBaseY = lineBaseY + rowSize;
		doc.line(lineBaseX, lineBaseY, lineBaseX + sizeTableWidth, lineBaseY);
	}
	
	//Datos de la tabla ---------------------------
	doc.setTextColor(0, 0, 0);
	doc.setFontType('normal');
	var MarginXAlignRightUnit = marginX + 122;
	var MarginXAlignRightPriceUnit = MarginXAlignRightUnit + 24;
	var MarginXAlignRightSubtotal = MarginXAlignRightPriceUnit + 26;
	var priceUnit;
	var unit;
	
	for (var i = 0; i < products.length; i = i + 1) {
		marginYBase = marginYBase + rowSize;
		doc.text(marginX + 1, marginYBase, products[i]['product']['product_reference']);
		doc.text(marginX + 19, marginYBase, products[i]['product']['product_name']);
		
		unit = number_format(products[i]['receipt_product_unit'], 0, ',', '.').toString();
		doc.textAlignRight(MarginXAlignRightUnit, marginYBase, unit);
		
		priceUnit = parseFloat(products[i]['product']['product_price_unit']).toFixed(2);
		priceUnit = number_format(priceUnit, 2, ',', '.').toString();
		doc.textAlignRight(MarginXAlignRightPriceUnit, marginYBase, priceUnit + ' €');
		
		productSubtotal = products[i]['receipt_product_unit'] * products[i]['product']['product_price_unit'];
		productSubtotal = number_format(productSubtotal, 2, ',', '.').toString();
		doc.textAlignRight(MarginXAlignRightSubtotal, marginYBase, productSubtotal + ' €');
	}
	
	//Tabla de firma y total ---------------------
	marginXBase = marginX + 80;
	marginYBase = marginY + sizeTableHeight;
	sizeTableHeight = rowSize * 4;
	
	doc.setFillColor(200, 200, 200);
	doc.rect(marginXBase, marginYBase + 55 + (rowSize * 3), sizeTableWidth - 80, rowSize, 'F');
	
	doc.rect(marginX, marginYBase + 55, sizeTableWidth, sizeTableHeight);
	
	//borde columna
	lineBaseY = marginYBase + 55;
	lineBaseX = marginXBase;
	doc.line(lineBaseX, lineBaseY, lineBaseX, lineBaseY + sizeTableHeight);
	
	//borde filas
	lineBaseY = marginYBase + 55 + rowSize;
	doc.line(lineBaseX, lineBaseY, sizeTableWidth + 18, lineBaseY);
	lineBaseY = lineBaseY + rowSize;
	doc.line(lineBaseX, lineBaseY, sizeTableWidth + 18, lineBaseY);
	lineBaseY = lineBaseY + rowSize;
	doc.line(lineBaseX, lineBaseY, sizeTableWidth + 18, lineBaseY);
	
	//Texto
	doc.setTextColor(0, 0, 0);
	doc.setFontType('bold');
	doc.setFontSize(fontSize + 2);
	marginYBase = marginYBase + 60;
	doc.text(marginX + 2, marginYBase, 'Firma');
	
	marginXBase = marginX + 85;
	doc.setFontSize(fontSize);
	doc.text(marginXBase, marginYBase, 'Subtotal');
	doc.text(marginXBase, marginYBase + rowSize, 'I.V.A.');
	doc.setFontSize(fontSize + 4);
	doc.setTextColor(220, 0, 0);
	doc.setFontType('bold');
	doc.text(marginXBase, marginYBase + (rowSize * 3), 'TOTAL FACTURA');
	
	marginXBase = marginXBase + 37;
	doc.setFontSize(fontSize);
	doc.setTextColor(0, 0, 0);
	doc.setFontType('normal');
	doc.textAlignRight(marginXBase, marginYBase + rowSize, ivaPercentage + '%');
	
	marginXBase = marginXMax - 2;
	subtotal = number_format(subtotal, 2, ',', '.').toString();
	doc.textAlignRight(marginXBase, marginYBase, subtotal + ' €');
	
	ivaTotal = number_format(ivaTotal, 2, ',', '.').toString();
	doc.textAlignRight(marginXBase, marginYBase + rowSize, ivaTotal + ' €');
	
	doc.setFontSize(fontSize + 4);
	doc.setTextColor(220, 0, 0);
	doc.setFontType('bold');
	total = number_format(total, 2, ',', '.').toString();
	doc.textAlignRight(marginXBase, marginYBase + (rowSize * 3), total + ' €');
	
	if (dataUrlString) {
		return doc.output('dataurlstring');
	} else {
		doc.output('dataurlnewwindow');
	}
}

/**
 * Metodo para dar formato a valores numericos.
 * @param {int} number Numero a formatear.
 * @param {int} decimals Numero de decimales a mostrar
 * @param {string} decPoint Simbolo para los decimales
 * @param {string} thousandsSep Simbilo para los Miles.
 * @returns {string} Numero formateado
 */
function number_format(number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/number_format/
	// original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: davook
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Theriault (https://github.com/Theriault)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// bugfixed by: Michael White (http://getsprink.com)
	// bugfixed by: Benjamin Lupton
	// bugfixed by: Allan Jensen (http://www.winternet.no)
	// bugfixed by: Howard Yeend
	// bugfixed by: Diogo Resende
	// bugfixed by: Rival
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	//  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	//  revised by: Luke Smith (http://lucassmith.name)
	//    input by: Kheang Hok Chin (http://www.distantia.ca/)
	//    input by: Jay Klehr
	//    input by: Amir Habibi (http://www.residence-mixte.com/)
	//    input by: Amirouche
	//   example 1: number_format(1234.56)
	//   returns 1: '1,235'
	//   example 2: number_format(1234.56, 2, ',', ' ')
	//   returns 2: '1 234,56'
	//   example 3: number_format(1234.5678, 2, '.', '')
	//   returns 3: '1234.57'
	//   example 4: number_format(67, 2, ',', '.')
	//   returns 4: '67,00'
	//   example 5: number_format(1000)
	//   returns 5: '1,000'
	//   example 6: number_format(67.311, 2)
	//   returns 6: '67.31'
	//   example 7: number_format(1000.55, 1)
	//   returns 7: '1,000.6'
	//   example 8: number_format(67000, 5, ',', '.')
	//   returns 8: '67.000,00000'
	//   example 9: number_format(0.9, 0)
	//   returns 9: '1'
	//  example 10: number_format('1.20', 2)
	//  returns 10: '1.20'
	//  example 11: number_format('1.20', 4)
	//  returns 11: '1.2000'
	//  example 12: number_format('1.2000', 3)
	//  returns 12: '1.200'
	//  example 13: number_format('1 000,50', 2, '.', ' ')
	//  returns 13: '100 050.00'
	//  example 14: number_format(1e-8, 8, '.', '')
	//  returns 14: '0.00000001'
	
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	var n = !isFinite(+number) ? 0 : +number
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''
	
	var toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec)
		return '' + (Math.round(n * k) / k)
				.toFixed(prec)
	}
	
	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
	}
	
	return s.join(dec)
}

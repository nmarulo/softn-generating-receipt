(function () {
	$(document).on('click', '.btn-generate-pdf', function (event) {
		event.preventDefault();
		generatePDF($(this).attr('href'), $(this).data('receipt-id'));
	});
})();

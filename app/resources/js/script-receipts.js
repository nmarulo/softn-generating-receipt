(function () {
	$(document).on('click', '.btn-generate-pdf', function (event) {
		event.preventDefault();
		generatePDF($(this).data('receipt-id'));
	});
})();

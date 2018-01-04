(function () {
	var modalDelete = $('#modal-delete');
	var modalForm = $('#modal-delete-form');
	var modalInput = $('#modal-delete-input-hidden');
	
	modalDelete.on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		modalInput.val(button.data('element-id'));
		modalForm.attr('action', button.data('form-action'));
	});
})();

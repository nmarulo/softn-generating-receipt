(function () {
	var modalDelete = $('#modal-delete');
	var modalForm = $('#modal-delete-form');
	var modalInputHiddenId = $('#modal-delete-input-id');
	var modalInputHiddenReload = $('#modal-delete-input-reload');
	var dataUpdate = null;
	
	modalDelete.on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		modalInputHiddenId.val(button.data('element-id'));
		modalForm.attr('action', button.data('form-action'));
		dataUpdate = button.data('update');
	});
	
	modalForm.on('submit', function (event) {
		if (dataUpdate != null) {
			modalInputHiddenReload.val('true');
			event.preventDefault();
			
			var afterDelete = function () {
				location.reload();
			};
			
			callAjax($(this).attr('action'), 'POST', $(this).serialize(), afterDelete, false);
		}
	});
})();

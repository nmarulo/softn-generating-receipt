<?php
use Softn\controllers\ViewController;

$modalTile = ViewController::getViewData('viewData');
?>
<div class="modal fade content-autocomplete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $modalTile; ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control search-data" type="text" placeholder="Buscar...">
                </div>
                <div class="content-autocomplete-data-list"></div>
            </div>
        </div>
    </div>
</div>

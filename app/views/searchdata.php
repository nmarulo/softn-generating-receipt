<?php
use Softn\controllers\ViewController;

$pageName = ViewController::getViewData('pageName');
?>
<div class="form-inline" data-page-name="<?php echo $pageName; ?>">
    <div class="form-group">
        <label for="search-data" class="control-label">Buscar</label>
        <input id="search-data" class="form-control" type="text" name="search" placeholder="Buscar...">
    </div>
    <button id="btn-search" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
    <button id="btn-clear-search" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span></button>
</div>

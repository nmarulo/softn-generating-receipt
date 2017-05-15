<?php
use Softn\controllers\ViewController;

$pageName = ViewController::getViewData('pageName');
?>
<div class="form-inline pull-right" data-page-name="<?php echo $pageName; ?>">
    <div class="form-group input-group">
        <span id="span-search-data" class="input-group-addon">Buscar</span>
        <input id="search-data" class="form-control" type="text" aria-describedby="span-search-data" name="search" placeholder="Buscar...">
    </div>
    <button id="btn-search" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
    <button id="btn-clear-search" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span></button>
</div>

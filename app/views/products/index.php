<?php
use Softn\controllers\ViewController;

ViewController::registerScript('script-common');
ViewController::registerScript('script-data-list');
$clients = ViewController::getViewData('products');
?>
<div>
    <h1>
        Productos/Servicios
        <a class="btn btn-success" href="products.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <?php
    ViewController::sendViewData('pageName', 'products');
    ViewController::setDirectory('');
    ViewController::singleView('searchdata');
    ?>
    <h3>Lista de productos/servicios</h3>
    <ul id="content-data-list"></ul>
</div>

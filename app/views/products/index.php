<?php
use Softn\controllers\ViewController;

ViewController::registerScript('script-data-list');
?>
<div class="row clearfix">
    <div class="col-sm-6">
        <h1>
            Productos/Servicios
            <a class="btn btn-success" href="products.php?method=insert" title="Agregar">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h1>
    </div>
    <div class="col-sm-6">
        <?php
        ViewController::sendViewData('pageName', 'products');
        ViewController::setDirectory('');
        ViewController::singleView('searchdata');
        ?>
    </div>
</div>
<div id="content-index">
    <h3>Lista de productos/servicios</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Referencia</th>
                <th>Nombre</th>
                <th>Precio unidad</th>
            </tr>
        </thead>
        <tbody id="content-data-list"></tbody>
    </table>
</div>

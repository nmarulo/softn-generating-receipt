<?php
use Softn\controllers\ViewController;

ViewController::registerScript('script-common');
ViewController::registerScript('script-data-list');
?>
<div class="row clearfix">
    <div class="col-sm-6">
        <h1>
            Clientes
            <a class="btn btn-success" href="clients.php?method=insert" title="Agregar">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h1>
    </div>
    <div class="col-sm-6">
        <?php
        ViewController::sendViewData('pageName', 'clients');
        ViewController::setDirectory('');
        ViewController::singleView('searchdata');
        ?>
    </div>
</div>
<div id="content-index">
    <h3>Lista de clientes</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Documento de identificación</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Facturas</th>
            </tr>
        </thead>
        <tbody id="content-data-list"></tbody>
    </table>
</div>

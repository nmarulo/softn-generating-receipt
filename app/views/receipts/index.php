<?php
use Softn\controllers\ViewController;

ViewController::registerScript('jspdf.min');
ViewController::registerScript('script-generate-pdf');
ViewController::registerScript('script-receipts');
ViewController::registerScript('script-data-list');
?>
<div class="row clearfix">
    <div class="col-sm-6">
        <h1>
            Facturas
            <a class="btn btn-success" href="generating.php" title="Agregar">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h1>
    </div>
    <div class="col-sm-6">
        <?php
        ViewController::sendViewData('pageName', 'receipts');
        ViewController::setDirectory('');
        ViewController::singleView('searchdata');
        ?>
    </div>
</div>
<div id="content-index">
    <h3>Lista de facturas</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Numero</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody id="content-data-list"></tbody>
    </table>
</div>

<?php
use Softn\controllers\ViewController;

ViewController::registerScript('jquery-3.2.1');
ViewController::registerScript('bootstrap');
ViewController::registerScript('jspdf.min');
ViewController::registerScript('script-common');
ViewController::registerScript('script-generate-pdf');
ViewController::registerScript('script-receipts');
ViewController::registerScript('script-data-list');
$receipts = ViewController::getViewData('receipts');
?>
<div>
    <h1>
        Facturas
        <a class="btn btn-success" href="generating.php" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <?php
    ViewController::sendViewData('pageName', 'receipts');
    ViewController::setDirectory('');
    ViewController::singleView('searchdata');
    ?>
    <h3>Lista de facturas</h3>
    <ul id="content-data-list"></ul>
</div>

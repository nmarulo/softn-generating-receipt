<?php
use Softn\controllers\ViewController;

ViewController::registerScript('script-common');
ViewController::registerScript('script-data-list');
$clients = ViewController::getViewData('clients');
?>
<div>
    <h1>
        Clientes
        <a class="btn btn-success" href="clients.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <?php
    ViewController::sendViewData('pageName', 'clients');
    ViewController::setDirectory('');
    ViewController::singleView('searchdata');
    ?>
    <h3>Lista de clientes</h3>
    <ul id="content-data-list"></ul>
</div>

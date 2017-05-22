<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsManager;
use Softn\models\ReceiptsHasProductsManager;

ViewController::registerScript('jspdf.min');
ViewController::registerScript('script-generate-pdf');
ViewController::registerScript('script-generating');

$generating = ViewController::getViewData('generating');
$receipt    = $generating->getReceipt();
?>
<div>
    <h1>Generar factura</h1>
</div>
<div id="content-index">
    <form id="form-generate-receipt" method="get">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body form-table">
                        <div class="form-group input-group">
                            <span id="span-receipt-type" class="input-group-addon">Tipo</span>
                            <input id="receipt-type" class="form-control" type="text" aria-describedby="span-receipt-type" name="<?php echo ReceiptsManager::RECEIPT_TYPE; ?>" value="<?php echo $receipt->getReceiptType(); ?>">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-number" class="input-group-addon">Número</span>
                            <input id="receipt-number" class="form-control" type="number" aria-describedby="span-receipt-number" name="<?php echo ReceiptsManager::RECEIPT_NUMBER; ?>" value="<?php echo $receipt->getReceiptNumber(); ?>">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-date" class="input-group-addon">Fecha</span>
                            <input id="receipt-date" class="form-control" type="text" aria-describedby="span-receipt-date" name="<?php echo ReceiptsManager::RECEIPT_DATE; ?>" value="<?php echo $receipt->getReceiptDate(); ?>">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="input-group form-table-row">
                            <span id="span-receipt-client" class="input-group-addon">Cliente</span>
                            <input id="receipt-client" class="form-control" type="text" aria-describedby="span-receipt-client">
                            <?php
                            ViewController::sendViewData('viewData', 'Lista de clientes');
                            ViewController::singleView('modalcontent');
                            ?>
                        </div>
                    </div>
                </div>
                <input id="receipt-products" type="hidden" name="<?php echo ReceiptsHasProductsManager::RECEIPT_PRODUCTS; ?>">
                <input id="receipt-client-id" type="hidden" name="<?php echo ReceiptsManager::CLIENT_ID; ?>">
                <input type="hidden" name="method" value="generate">
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Agregar producto/servicio</div>
                    <div class="panel-body form-table">
                        <div class="form-group input-group">
                            <span id="span-receipt-product" class="input-group-addon">Producto/Servicio</span>
                            <input id="receipt-product" class="form-control" type="text" aria-describedby="span-receipt-product">
                            <?php
                            ViewController::sendViewData('viewData', 'Lista de productos/servicios');
                            ViewController::singleView('modalcontent');
                            ?>
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-group input-group">
                            <span id="span-receipt-product-unit" class="input-group-addon">Unidades</span>
                            <input id="receipt-product-unit" class="form-control" type="number" aria-describedby="span-receipt-product-unit" value="1">
                        </div>
                        <span class="form-table-cell-hidden"></span>
                        <div class="form-table-row">
                            <button id="btn-add-product" class="btn btn-primary" type="button" disabled="disabled">Agregar producto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button id="btn-generate-receipt" class="btn btn-success" type="submit">Generar</button>
        </div>
    </form>
    <div id="btn-group-actions-generate" class="hidden">
        <button id="btn-generate-pdf" class="btn btn-success" type="button">Generar PDF</button>
        <a class="btn btn-primary" href="receipts.php">Ver lista de facturas</a>
        <a class="btn btn-warning" href="generating.php">Nueva factura</a>
    </div>
    <div id="list-selected-products" class="form-group"></div>
</div>

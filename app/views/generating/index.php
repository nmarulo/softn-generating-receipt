<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsManager;
use Softn\models\ReceiptsHasProductsManager;
var_dump($_GET);
$generating = ViewController::getViewData('generating');
$receipt    = $generating->getReceipt();
?>

<div>
    <h1>Generar factura</h1>
</div>
<div id="content-index">
    <form method="get">
        <div class="form-group">
            <label for="receipt-type" class="control-label">Tipo</label>
            <input id="receipt-type" class="form-control" type="text" name="<?php echo ReceiptsManager::RECEIPT_TYPE; ?>" value="<?php echo $receipt->getReceiptType(); ?>">
        </div>
        <div class="form-group">
            <label for="receipt-number" class="control-label">Numero</label>
            <input id="receipt-number" class="form-control" type="number" name="<?php echo ReceiptsManager::RECEIPT_NUMBER; ?>" value="<?php echo $receipt->getReceiptNumber(); ?>">
        </div>
        <div class="form-group">
            <label for="receipt-date" class="control-label">Fecha</label>
            <input id="receipt-date" class="form-control" type="text" name="<?php echo ReceiptsManager::RECEIPT_DATE; ?>" value="<?php echo $receipt->getReceiptDate(); ?>">
        </div>
        <div class="form-group">
            <label for="receipt-client" class="control-label">Cliente</label>
            <input id="receipt-client" class="form-control" type="text">
            <div class="content-autocomplete hidden">
                <div class="hide-autocomplete"></div>
                <div class="dropdown-autocomplete"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="receipt-product" class="control-label">Producto/Servicio</label>
            <input id="receipt-product" class="form-control" type="text">
            <div class="content-autocomplete hidden">
                <div class="hide-autocomplete"></div>
                <div class="dropdown-autocomplete"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="receipt-product-unit" class="control-label">Unidades</label>
            <input id="receipt-product-unit" class="form-control" type="number" value="1">
        </div>
        <div class="form-group">
            <button id="btn-add-product" class="btn btn-primary" type="button">Agregar producto</button>
        </div>
        <input id="receipt-products" type="hidden" name="<?php echo ReceiptsHasProductsManager::RECEIPT_PRODUCTS; ?>">
        <input id="receipt-client-id" type="hidden" name="<?php echo ReceiptsManager::CLIENT_ID; ?>">
        <input type="hidden" name="method" value="generate">
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Generar</button>
        </div>
        <div class="form-group">
            <div class="panel panel-default">
                <div class="panel-body">
                    Lista de servicios/productos agregados
                </div>
            </div>
            <ul id="list-selected-products" class="list-group"></ul>
        </div>
    </form>
</div>

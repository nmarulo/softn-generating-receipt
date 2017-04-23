<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsManager;
use Softn\models\GeneratingManager;

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
            <button class="btn btn-primary" type="submit">Agregar producto</button>
        </div>
        <input id="receipt-products" type="hidden" name="<?php echo GeneratingManager::RECEIPT_PRODUCTS; ?>">
        <input id="receipt-client-id" type="hidden" name="<?php echo GeneratingManager::RECEIPT_CLIENT_ID; ?>">
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Generar</button>
        </div>
        <div class="form-group">
            <div class="panel panel-default">
                <div class="panel-body">
                    Lista de servicios/productos agregados
                </div>
            </div>
            <ul id="receipt-products"></ul>
        </div>
    </form>
</div>
<script>
    initGenerating();
</script>

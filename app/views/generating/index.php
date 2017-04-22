<?php
use Softn\controllers\ViewController;

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
            <select id="receipt-type" class="form-control" name="receiptType">
                <option value="0">Factura</option>
                <option value="1">Presupuesto</option>
            </select>
        </div>
        <div class="form-group">
            <label for="receipt-number" class="control-label">Numero</label>
            <input id="receipt-number" class="form-control" type="number" name="receiptNumber" value="<?php echo $receipt->getReceiptNumber(); ?>">
        </div>
        <div class="form-group">
            <label for="receipt-date" class="control-label">Fecha</label>
            <input id="receipt-date" class="form-control" type="date" name="receiptDate" value="<?php echo $receipt->getReceiptDate(); ?>">
        </div>
        <div class="form-group">
            <label for="receipt-client" class="control-label">Cliente</label>
            <input id="receipt-client" class="form-control" type="text" name="receiptClient" value="">
        </div>
        <div class="form-group">
            <label for="receipt-product" class="control-label">Producto/Servicio</label>
            <input id="receipt-product" class="form-control" type="text" name="receiptProduct" value="">
        </div>
        <div class="form-group">
            <label for="receipt-product-unit" class="control-label">Unidades</label>
            <input id="receipt-product-unit" class="form-control" type="number" name="receiptProductUnit" value="">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Agregar producto</button>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Generar</button>
        </div>
        <div class="form-group">
            <div class="panel panel-default">
                <div class="panel-body">
                    Lista de servicios/productos agregados
                </div>
            </div>
            <select class="form-control" name="receiptProducts">
            
            </select>
        </div>
    </form>
</div>


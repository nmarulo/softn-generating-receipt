<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsManager;
use Softn\models\ReceiptsHasProductsManager;

$generating = ViewController::getViewData('generating');
$receipt    = $generating->getReceipt();
?>

<div>
    <h1>Generar factura</h1>
</div>
<div id="content-index">
    <form id="form-generate-receipt" method="get">
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
            <div class="modal fade content-autocomplete-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Lista de clientes</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control search-data" type="text" placeholder="Buscar...">
                            </div>
                            <div class="list-group"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="receipt-product" class="control-label">Producto/Servicio</label>
            <input id="receipt-product" class="form-control" type="text">
            <div class="modal fade content-autocomplete-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Lista de productos/servicios</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control search-data" type="text" placeholder="Buscar...">
                            </div>
                            <div class="list-group"></div>
                        </div>
                    </div>
                </div>
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
            <button id="btn-generate-receipt" class="btn btn-primary" type="submit">Generar</button>
            <div class="modal fade" id="modal-generate-receipt" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>La factura se genero correctamente.</h4>
                        </div>
                        <div class="modal-body">
                            <a class="btn btn-primary" href="receipts.php">Ver lista de facturas</a>
                            <button id="btn-generate-pdf" class="btn btn-primary" type="button">Generar PDF</button>
                        </div>
                    </div>
                </div>
            </div>
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

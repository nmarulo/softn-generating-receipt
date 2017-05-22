<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsHasProductsManager;

$dataView = ViewController::getViewData('dataView');
?>
<p class="text-header bg-primary">Lista de servicios/productos agregados</p>
<ul class="list-group">
<?php foreach ($dataView as $value) {
    $id               = $value['product']->getId();
    $productName      = $value['product']->getProductName();
    $productPriceUnit = $value['product']->getProductPriceUnit();
    $productUnits     = $value[ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT];
    ?>
    <li class="list-group-item" data-element-id="<?php echo $id; ?>">
        <button id="btn-remove-product" class="btn btn-danger btn-action" type="button"><span class="glyphicon glyphicon-remove"></span></button>
        <span><?php echo $productName; ?></span>
        <span class="badge">Unidades: <?php echo $productUnits; ?></span>
        <span class="badge">Precio U.: <?php echo $productPriceUnit; ?> &euro;</span>
    </li>
<?php } ?>
</ul>

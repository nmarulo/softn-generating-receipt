<?php
use Softn\controllers\ViewController;
use Softn\models\ReceiptsHasProductsManager;

$dataView = ViewController::getViewData('dataView');
?>
<?php foreach ($dataView as $value) {
    $id               = $value['product']->getId();
    $productName      = $value['product']->getProductName();
    $productPriceUnit = $value['product']->getProductPriceUnit();
    $productUnits     = $value[ReceiptsHasProductsManager::RECEIPT_PRODUCT_UNIT];
    ?>
    <li class="list-group-item" data-element-id="<?php echo $id; ?>">
        <span><?php echo $productName; ?></span>
        <button id="btn-remove-product" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove"></span></button>
        <span class="badge">Unidades: <?php echo $productUnits; ?></span>
        <span class="badge">Precio U.: <?php echo $productPriceUnit; ?></span>
    </li>
<?php }

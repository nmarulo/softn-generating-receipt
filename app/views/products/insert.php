<?php
use Softn\controllers\ViewController;
use Softn\models\ProductsManager;

$object   = ViewController::getViewData('product');
$method   = ViewController::getViewData('method');
$title    = 'Nuevo';
$button   = 'Agregar';
$isUpdate = $method == 'update';

if ($isUpdate) {
    $title  = 'Actualizar';
    $button = $title;
}
?>
<div>
    <h1>
        <?php echo $title; ?> producto/servicio
        <?php if ($isUpdate) { ?>
            <a class="btn btn-success" href="products.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <?php } ?>
    </h1>
</div>
<div>
    <form class="form-table" method="get">
        <div class="form-group input-group">
            <span id="span-product-name" class="input-group-addon">Nombre</span>
            <input id="product-name" class="form-control" type="text" aria-describedby="span-product-name" name="<?php echo ProductsManager::PRODUCT_NAME; ?>" value="<?php echo $object->getProductName(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <div class="form-group input-group">
            <span id="span-product-price-unit" class="input-group-addon">Precio unidad</span>
            <input id="product-price-unit" class="form-control" type="text" aria-describedby="span-product-price-unit" name="<?php echo ProductsManager::PRODUCT_PRICE_UNIT; ?>" value="<?php echo $object->getProductPriceUnit(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <div class="form-group input-group">
            <span id="span-product-reference" class="input-group-addon">Referencia</span>
            <input id="product-reference" class="form-control" type="text" aria-describedby="span-product-reference" name="<?php echo ProductsManager::PRODUCT_REFERENCE; ?>" value="<?php echo $object->getProductReference(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <input type="hidden" value="<?php echo $object->getId(); ?>" name="id">
        <input type="hidden" value="update" name="method">
        <div class="form-table-row">
            <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
        </div>
    </form>
</div>

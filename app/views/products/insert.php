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
    <form method="get">
        <div class="form-group">
            <label for="product-name" class="control-label">Nombre</label>
            <input id="product-name" class="form-control" type="text" name="<?php echo ProductsManager::PRODUCT_NAME; ?>" value="<?php echo $object->getProductName(); ?>">
        </div>
        <div class="form-group">
            <label for="product-price-unit" class="control-label">Precio unidad</label>
            <input id="product-price-unit" class="form-control" type="text" name="<?php echo ProductsManager::PRODUCT_PRICE_UNIT; ?>" value="<?php echo $object->getProductPriceUnit(); ?>">
        </div>
        <div class="form-group">
            <label for="product-reference" class="control-label">Referencia</label>
            <input id="product-reference" class="form-control" type="text" name="<?php echo ProductsManager::PRODUCT_REFERENCE; ?>" value="<?php echo $object->getProductReference(); ?>">
        </div>
        <input type="hidden" value="<?php echo $object->getId(); ?>" name="id">
        <input type="hidden" value="update" name="method">
        <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
    </form>
</div>

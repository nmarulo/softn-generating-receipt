<?php
use Softn\controllers\ViewController;

$products = ViewController::getViewData('products');
?>
<div>
    <h1>
        Productos/Servicios
        <a class="btn btn-success" href="products.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <h3>Lista de productos/servicios</h3>
    <ul>
        <?php foreach ($products as $product) { ?>
            <li>
                <?php echo $product->getProductName(); ?>
                <a href="products.php?method=update&update=<?php echo $product->getId(); ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="products.php?method=delete&delete=<?php echo $product->getId(); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

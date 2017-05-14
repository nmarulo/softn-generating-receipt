<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $product) {
    $productName = $product->getProductName();
    $id          = $product->getId();
    ?>
    <li>
        <span><?php echo $productName; ?></span>
        <a href="products.php?method=update&update=<?php echo $id; ?>">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
        <a href="products.php?method=delete&delete=<?php echo $id; ?>">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </li>
<?php }

<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $product) {
    $id = $product->getId();
    ?>
    <tr>
        <td class="btn-actions">
            <a class="btn btn-primary" href="products.php?method=update&update=<?php echo $id; ?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a class="btn btn-danger" href="products.php?method=delete&delete=<?php echo $id; ?>">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </td>
        <td><?php echo $product->getProductReference(); ?></td>
        <td><?php echo $product->getProductName(); ?></td>
        <td class="text-right"><?php echo $product->getProductPriceUnit(); ?> &euro;</td>
    </tr>
<?php }

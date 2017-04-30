<?php
use Softn\controllers\ViewController;

$receipts = ViewController::getViewData('receipts');
?>
<div>
    <h1>
        Facturas
        <a class="btn btn-success" href="generating.php" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>
</div>
<div id="content-index">
    <h3>Lista de facturas</h3>
    <ul>
        <?php foreach ($receipts as $receipt) { ?>
            <li>
                <?php echo $receipt->getReceiptNumber(); ?>
                <a href="receipts.php?method=update&update=<?php echo $receipt->getId(); ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="receipts.php?method=delete&delete=<?php echo $receipt->getId(); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
                <a class="btn-generate-pdf" data-receipt-id="<?php echo $receipt->getId(); ?>" href="#"><span class="glyphicon glyphicon-open-file"></span></a>
            </li>
        <?php } ?>
    </ul>
</div>

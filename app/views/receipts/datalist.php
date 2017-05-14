<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $receipt) {
    $receiptNumber = $receipt->getReceiptNumber();
    $id            = $receipt->getId();
    ?>
    <li>
        <span><?php echo $receiptNumber; ?></span>
        <a href="receipts.php?method=delete&delete=<?php echo $id; ?>">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
        <a class="btn-generate-pdf" data-receipt-id="<?php echo $receipt->getId(); ?>" href="#">
            <span class="glyphicon glyphicon-open-file"></span>
        </a>
    </li>
<?php }

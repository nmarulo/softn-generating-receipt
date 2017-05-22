<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $receipt) {
    $id = $receipt->getId();
    ?>
    <tr>
        <td class="btn-actions">
            <a class="btn btn-warning btn-generate-pdf" data-receipt-id="<?php echo $receipt->getId(); ?>" href="#">
                <span class="glyphicon glyphicon-open-file"></span>
            </a>
            <a class="btn btn-danger" href="receipts.php?method=delete&delete=<?php echo $id; ?>">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </td>
        <td><?php echo $receipt->getReceiptNumber(); ?></td>
        <td><?php echo $receipt->getReceiptType(); ?></td>
        <td><?php echo $receipt->getReceiptDate(); ?></td>
        <td><?php echo $receipt->getClientId(); ?></td>
    </tr>
<?php }

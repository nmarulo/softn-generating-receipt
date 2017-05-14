<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $client) {
    $clientName = $client->getClientName();
    $id         = $client->getId();
    ?>
    <li>
        <span><?php echo $clientName; ?></span>
        <a href="clients.php?method=update&update=<?php echo $id; ?>">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
        <a href="clients.php?method=delete&delete=<?php echo $id; ?>">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </li>
<?php }

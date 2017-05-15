<?php
use Softn\controllers\ViewController;

$viewData = ViewController::getViewData('viewData');

foreach ($viewData as $client) {
    $id = $client->getId();
    ?>
    <tr>
        <td class="btn-actions">
            <a class="btn btn-primary" href="clients.php?method=update&update=<?php echo $id; ?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a class="btn btn-danger" href="clients.php?method=delete&delete=<?php echo $id; ?>">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </td>
        <td><?php echo $client->getClientName(); ?></td>
        <td><?php echo $client->getClientIdentificationDocument(); ?></td>
        <td><?php echo $client->getClientAddress(); ?></td>
        <td><?php echo $client->getClientCity(); ?></td>
        <td>#</td>
    </tr>
<?php }

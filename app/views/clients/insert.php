<?php
use Softn\controllers\ViewController;
use Softn\models\ClientsManager;

$client   = ViewController::getViewData('client');
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
        <?php echo $title; ?> cliente
        <?php if ($isUpdate) { ?>
            <a class="btn btn-success" href="clients.php?method=insert" title="Agregar">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <?php } ?>
    </h1>
</div>
<div>
    <form class="form-table" method="get">
        <div class="form-group input-group">
            <span id="span-client-name" class="input-group-addon">Nombre</span>
            <input id="client-name" class="form-control" type="text" aria-describedby="span-client-name" name="<?php echo ClientsManager::CLIENT_NAME; ?>" value="<?php echo $client->getClientName(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <div class="form-group input-group">
            <span id="span-client-address" class="input-group-addon">Dirección</span>
            <input id="client-address" class="form-control" type="text" aria-describedby="span-client-address" name="<?php echo ClientsManager::CLIENT_ADDRESS; ?>" value="<?php echo $client->getClientAddress(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <div class="form-group input-group">
            <span id="span-client-identification-document" class="input-group-addon">Documento de identificación</span>
            <input id="client-identification-document" class="form-control" aria-describedby="span-client-identification-document" type="text" name="<?php echo ClientsManager::CLIENT_IDENTIFICATION_DOCUMENT; ?>" value="<?php echo $client->getClientIdentificationDocument(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <div class="form-group input-group">
            <span id="span-client-city" class="input-group-addon">Ciudad</span>
            <input id="client-city" class="form-control" type="text" aria-describedby="span-client-city" name="<?php echo ClientsManager::CLIENT_CITY; ?>" value="<?php echo $client->getClientCity(); ?>">
        </div>
        <span class="form-table-cell-hidden"></span>
        <input type="hidden" value="<?php echo $client->getId(); ?>" name="id">
        <input type="hidden" value="update" name="method">
        <div class="form-table-row">
            <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
        </div>
    </form>
</div>

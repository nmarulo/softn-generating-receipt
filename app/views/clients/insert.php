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
    <form method="get">
        <div class="form-group">
            <label for="client-name" class="control-label">Nombre</label>
            <input id="client-name" class="form-control" type="text" name="<?php echo ClientsManager::CLIENT_NAME; ?>" value="<?php echo $client->getClientName(); ?>">
        </div>
        <div class="form-group">
            <label for="client-address" class="control-label">Dirección</label>
            <input id="client-address" class="form-control" type="text" name="<?php echo ClientsManager::CLIENT_ADDRESS; ?>" value="<?php echo $client->getClientAddress(); ?>">
        </div>
        <div class="form-group">
            <label for="client-identification-document" class="control-label">Documento de identificación</label>
            <input id="client-identification-document" class="form-control" type="text" name="<?php echo ClientsManager::CLIENT_IDENTIFICATION_DOCUMENT; ?>" value="<?php echo $client->getClientIdentificationDocument(); ?>">
        </div>
        <div class="form-group">
            <label for="client-city" class="control-label">Ciudad</label>
            <input id="client-city" class="form-control" type="text" name="<?php echo ClientsManager::CLIENT_CITY; ?>" value="<?php echo $client->getClientCity(); ?>">
        </div>
        <input type="hidden" value="<?php echo $client->getId(); ?>" name="id">
        <input type="hidden" value="update" name="method">
        <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
    </form>
</div>

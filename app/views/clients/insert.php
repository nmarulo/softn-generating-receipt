<?php
$client = $viewData['client'];
?>
<div>
    <h1>Nuevo cliente</h1>
</div>
<div>
    <form method="get">
        <div class="form-group">
            <label for="client-name" class="control-label">Nombre</label>
            <input id="client-name" class="form-control" type="text" name="clientName" value="<?php echo $client->getClientName(); ?>">
        </div>
        <div class="form-group">
            <label for="client-address" class="control-label">Dirección</label>
            <input id="client-address" class="form-control" type="text" name="clientAddress" value="<?php echo $client->getClientAddress(); ?>">
        </div>
        <div class="form-group">
            <label for="client-identification-document" class="control-label">Documento de identificación</label>
            <input id="client-identification-document" class="form-control" type="text" name="clientIdentificationDocument" value="<?php echo $client->getClientIdentificationDocument(); ?>">
        </div>
        <div class="form-group">
            <label for="client-city" class="control-label">Ciudad</label>
            <input id="client-city" class="form-control" type="text" name="clientCity" value="<?php echo $client->getClientCity(); ?>">
        </div>
        <input type="hidden" value="<?php echo $client->getId(); ?>" name="id">
        <input type="hidden" value="update" name="method">
        <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
</div>

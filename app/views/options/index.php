<?php
use Softn\models\OptionsManager;

$optionsManager              = new OptionsManager();
$valueName                   = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_NAME);
$valueIdentificationDocument = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT);
$valueAddress                = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_ADDRESS);
$valuePhoneNumber            = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_PHONE_NUMBER);
$valueWebSite                = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_WEB_SITE);
$valueIVA                    = $optionsManager->selectByKey(OptionsManager::OPTION_KEY_IVA);
?>
<div>
    <h1>Opciones</h1>
</div>
<div>
    <form method="get">
        <div class="panel panel-default">
            <div class="panel-heading">Datos de la factura</div>
            <div class="panel-body">
                <div class="form-group input-group">
                    <span id="span-option-name" class="input-group-addon">Nombre:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-name" name="<?php echo OptionsManager::OPTION_KEY_NAME; ?>" value="<?php echo $valueName->getOptionValue(); ?>">
                </div>
                <div class="form-group input-group">
                    <span id="span-option-identification-document" class="input-group-addon">Documento de identificación:</span>
                    <input id="option-name" class="form-control" type="text" aria-describedby="span-option-identification-document" name="<?php echo OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT; ?>" value="<?php echo $valueIdentificationDocument->getOptionValue(); ?>">
                </div>
                <div class="form-group input-group">
                    <span id="span-option-address" class="input-group-addon">Dirección:</span>
                    <input id="option-address" class="form-control" type="text" aria-describedby="span-option-address" name="<?php echo OptionsManager::OPTION_KEY_ADDRESS; ?>" value="<?php echo $valueAddress->getOptionValue(); ?>">
                </div>
                <div class="form-group input-group">
                    <span id="span-option-phone-number" class="input-group-addon">Teléfono:</span>
                    <input id="option-phone-number" class="form-control" type="tel" aria-describedby="span-option-phone-number" name="<?php echo OptionsManager::OPTION_KEY_PHONE_NUMBER; ?>" value="<?php echo $valuePhoneNumber->getOptionValue(); ?>">
                </div>
                <div class="form-group input-group">
                    <span id="span-option-web-site" class="input-group-addon">Pagina web:</span>
                    <input id="option-web-site" class="form-control" type="text" aria-describedby="span-option-web-site" name="<?php echo OptionsManager::OPTION_KEY_WEB_SITE; ?>" value="<?php echo $valueWebSite->getOptionValue(); ?>">
                </div>
                <div class="form-group input-group">
                    <span id="span-option-iva" class="input-group-addon">I.V.A.:</span>
                    <input id="option-iva" class="form-control" type="number" aria-describedby="span-option-iva" name="<?php echo OptionsManager::OPTION_KEY_IVA; ?>" value="<?php echo $valueIVA->getOptionValue(); ?>">
                </div>
            </div>
        </div>
        <input type="hidden" name="method" value="update">
        <button class="btn btn-primary" type="submit">Guardar</button>
    </form>
</div>

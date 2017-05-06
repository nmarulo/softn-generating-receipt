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
        <div class="form-group">
            <label for="option-name" class="control-label">Nombre:</label>
            <input id="option-name" class="form-control" type="text" name="<?php echo OptionsManager::OPTION_KEY_NAME; ?>" value="<?php echo $valueName->getOptionValue(); ?>">
        </div>
        <div class="form-group">
            <label for="option-identification-document" class="control-label">Documento de identificación:</label>
            <input id="option-name" class="form-control" type="text" name="<?php echo OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT; ?>" value="<?php echo $valueIdentificationDocument->getOptionValue(); ?>">
        </div>
        <div class="form-group">
            <label for="option-address" class="control-label">Dirección:</label>
            <input id="option-address" class="form-control" type="text" name="<?php echo OptionsManager::OPTION_KEY_ADDRESS; ?>" value="<?php echo $valueAddress->getOptionValue(); ?>">
        </div>
        <div class="form-group">
            <label for="option-phone-number" class="control-label">Teléfono:</label>
            <input id="option-phone-number" class="form-control" type="tel" name="<?php echo OptionsManager::OPTION_KEY_PHONE_NUMBER; ?>" value="<?php echo $valuePhoneNumber->getOptionValue(); ?>">
        </div>
        <div class="form-group">
            <label for="option-web-site" class="control-label">Pagina web:</label>
            <input id="option-web-site" class="form-control" type="text" name="<?php echo OptionsManager::OPTION_KEY_WEB_SITE; ?>" value="<?php echo $valueWebSite->getOptionValue(); ?>">
        </div>
        <div class="form-group">
            <label for="option-iva" class="control-label">I.V.A.:</label>
            <input id="option-iva" class="form-control" type="number" name="<?php echo OptionsManager::OPTION_KEY_IVA; ?>" value="<?php echo $valueIVA->getOptionValue(); ?>">
        </div>
        <input type="hidden" name="method" value="update">
        <button class="btn btn-primary" type="submit">Guardar</button>
    </form>
</div>

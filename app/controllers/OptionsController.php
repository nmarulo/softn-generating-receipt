<?php
/**
 * OptionsController.php
 */

namespace Softn\controllers;

use Softn\models\Option;
use Softn\models\OptionsManager;
use Softn\util\Arrays;
use Softn\util\Messages;

/**
 * Class OptionsController
 * @author Nicolás Marulanda P.
 */
class OptionsController extends ControllerAbstract implements ControllerInterface {
    
    /**
     * OptionsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('options');
    }
    
    public static function init() {
        parent::method(new OptionsController());
    }
    
    public function update() {
        $notError       = TRUE;
        $optionsManager = new OptionsManager();
        $options        = $this->getViewForm();
        $count          = count($options);
        $messages       = 'Actualizado correctamente.';
        $typeMessages   = Messages::TYPE_SUCCESS;
        
        for ($i = 0; $i < $count && $notError; ++$i) {
            $option = Arrays::get($options, $i);
            
            if (!$optionsManager->update($option->getOptionKey(), $option)) {
                $notError     = FALSE;
                $messages     = 'No se puede actualizar el campo con el valor "' . $option->getOptionValue() . '".';
                $typeMessages = Messages::TYPE_DANGER;
            }
        }
        
        ViewController::sendViewData('messages', $messages);
        ViewController::sendViewData('typeMessages', $typeMessages);
        $this->index();
    }
    
    protected function getViewForm() {
        $objects = [];
        $options = [
            OptionsManager::OPTION_KEY_NAME                    => Arrays::get($_GET, OptionsManager::OPTION_KEY_NAME),
            OptionsManager::OPTION_KEY_IVA                     => Arrays::get($_GET, OptionsManager::OPTION_KEY_IVA),
            OptionsManager::OPTION_KEY_WEB_SITE                => Arrays::get($_GET, OptionsManager::OPTION_KEY_WEB_SITE),
            OptionsManager::OPTION_KEY_ADDRESS                 => Arrays::get($_GET, OptionsManager::OPTION_KEY_ADDRESS),
            OptionsManager::OPTION_KEY_PHONE_NUMBER            => Arrays::get($_GET, OptionsManager::OPTION_KEY_PHONE_NUMBER),
            OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT => Arrays::get($_GET, OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT),
        ];
        
        foreach ($options as $key => $value) {
            $option = new Option();
            
            $option->setOptionKey($key);
            $option->setOptionValue($value);
            
            $objects[] = $option;
        }
        
        return $objects;
    }
    
    public function index() {
        $optionsManager              = new OptionsManager();
        $valueName                   = $optionsManager->getByKey(OptionsManager::OPTION_KEY_NAME);
        $valueIdentificationDocument = $optionsManager->getByKey(OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT);
        $valueAddress                = $optionsManager->getByKey(OptionsManager::OPTION_KEY_ADDRESS);
        $valuePhoneNumber            = $optionsManager->getByKey(OptionsManager::OPTION_KEY_PHONE_NUMBER);
        $valueWebSite                = $optionsManager->getByKey(OptionsManager::OPTION_KEY_WEB_SITE);
        $valueIVA                    = $optionsManager->getByKey(OptionsManager::OPTION_KEY_IVA);
        
        ViewController::sendViewData('name', $valueName);
        ViewController::sendViewData('identificationDocument', $valueIdentificationDocument);
        ViewController::sendViewData('address', $valueAddress);
        ViewController::sendViewData('phoneNumber', $valuePhoneNumber);
        ViewController::sendViewData('webSite', $valueWebSite);
        ViewController::sendViewData('IVA', $valueIVA);
        ViewController::view('index');
    }
    
}

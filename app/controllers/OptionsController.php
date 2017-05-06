<?php
/**
 * OptionsController.php
 */

namespace Softn\controllers;

use Softn\models\Option;
use Softn\models\OptionsManager;
use Softn\util\Arrays;

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
        $optionsManager = new OptionsManager();
        $options        = $this->getViewForm();
        
        foreach ($options as $optionKey => $optionValue) {
            $object = new Option();
            $object->setOptionKey($optionKey);
            $object->setOptionValue($optionValue);
            
            $optionsManager->update($object);
        }
        
        $this->index();
    }
    
    protected function getViewForm() {
        $options = [
            OptionsManager::OPTION_KEY_NAME                    => Arrays::get($_GET, OptionsManager::OPTION_KEY_NAME),
            OptionsManager::OPTION_KEY_IVA                     => Arrays::get($_GET, OptionsManager::OPTION_KEY_IVA),
            OptionsManager::OPTION_KEY_WEB_SITE                => Arrays::get($_GET, OptionsManager::OPTION_KEY_WEB_SITE),
            OptionsManager::OPTION_KEY_ADDRESS                 => Arrays::get($_GET, OptionsManager::OPTION_KEY_ADDRESS),
            OptionsManager::OPTION_KEY_PHONE_NUMBER            => Arrays::get($_GET, OptionsManager::OPTION_KEY_PHONE_NUMBER),
            OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT => Arrays::get($_GET, OptionsManager::OPTION_KEY_IDENTIFICATION_DOCUMENT),
        ];
        
        return $options;
    }
    
    public function index() {
        
        ViewController::view('index');
    }
    
}

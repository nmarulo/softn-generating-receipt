<?php
/**
 * OptionsManager.php
 */

namespace Softn\models;

use Softn\util\Arrays;
use Softn\util\MySql;

/**
 * Class OptionsManager
 * @author Nicolás Marulanda P.
 */
class OptionsManager extends ManagerAbstract {
    
    const TABLE                              = 'options';
    
    const OPTION_KEY                         = 'option_key';
    
    const OPTION_VALUE                       = 'option_value';
    
    const OPTION_KEY_NAME                    = 'option_name';
    
    const OPTION_KEY_IDENTIFICATION_DOCUMENT = 'option_identification_document';
    
    const OPTION_KEY_ADDRESS                 = 'option_address';
    
    const OPTION_KEY_PHONE_NUMBER            = 'option_phone_number';
    
    const OPTION_KEY_WEB_SITE                = 'option_web_site';
    
    const OPTION_KEY_IVA                     = 'option_iva';
    
    /**
     * OptionsManager constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    public function getLast() {
        // TODO: Implement getLast() method.
    }
    
    public function getAll() {
        // TODO: Implement getAll() method.
    }
    
    public function getByID($id) {
        // TODO: Implement getByID() method.
    }
    
    public function insert($object) {
        // TODO: Implement insert() method.
    }
    
    /**
     * @param string $optionKey
     * @param Option $object
     *
     * @return bool
     */
    public function update($optionKey, $object) {
        $option = $this->getAndSetterObject($optionKey, $object);
        
        parent::addSetForUpdate(self::OPTION_VALUE);
        
        return parent::updateData($option, self::TABLE, $optionKey, self::OPTION_KEY);
    }
    
    /**
     * @param string $optionKey
     * @param Option $object
     *
     * @return Option
     */
    protected function getAndSetterObject($optionKey, $object) {
        $option = $this->getByKey($optionKey);
        
        $option->setOptionValue($object->getOptionValue());
        
        return $option;
    }
    
    /**
     * @param string $value
     *
     * @return Option
     */
    public function getByKey($value) {
        return parent::selectByColumn($value, self::TABLE, self::OPTION_KEY);
    }
    
    public function delete($id) {
        // TODO: Implement delete() method.
    }
    
    protected function create($data) {
        $object = new Option();
        
        if (empty($data)) {
            return $object;
        }
        
        $object->setId(Arrays::get($data, self::ID));
        $object->setOptionKey(Arrays::get($data, self::OPTION_KEY));
        $object->setOptionValue(Arrays::get($data, self::OPTION_VALUE));
        
        return $object;
    }
    
    /**
     * @param Option $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare   = [];
        $prepare[] = MySql::prepareStatement(':' . self::OPTION_VALUE, $object->getOptionValue(), \PDO::PARAM_STR);
        
        return $prepare;
    }
    
}

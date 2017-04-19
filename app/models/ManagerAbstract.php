<?php
/**
 * ManagerAbstract.php
 */

namespace Softn\models;

/**
 * Class ManagerAbstract
 * @author Nicolás Marulanda P.
 */
abstract class ManagerAbstract implements ManagerInterfaces {
    
    /** @var string */
    private $columnsForInsert;
    
    /** @var string */
    private $valuesForInsert;
    
    /** @var string */
    private $setForUpdate;
    
    /**
     * ManagerAbstract constructor.
     */
    public function __construct() {
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
    }
    
    /**
     * @return string
     */
    public function getSetForUpdate() {
        return $this->setForUpdate;
    }
    
    protected function addValueAndColumnForInsert($name) {
        $this->valuesForInsert  .= empty($this->valuesForInsert) ? '' : ', ';
        $this->valuesForInsert  .= ':' . $name;
        $this->columnsForInsert .= empty($this->columnsForInsert) ? '' : ', ';
        $this->columnsForInsert .= $name;
    }
    
    protected function addSetForUpdate($name) {
        $this->setForUpdate .= empty($this->setForUpdate) ? '' : ', ';
        $this->setForUpdate .= $name . ' = :' . $name;
    }
    
    /**
     * @return string
     */
    protected function getColumnsForInsert() {
        return $this->columnsForInsert;
    }
    
    /**
     * @return string
     */
    protected function getValuesForInsert() {
        return $this->valuesForInsert;
    }
    
    protected abstract function prepare($object, $mysql);
    
}

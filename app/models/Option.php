<?php
/**
 * Option.php
 */

namespace Softn\models;

/**
 * Class Option
 * @author Nicolás Marulanda P.
 */
class Option {
    
    /** @var int */
    private $id;
    
    /** @var string */
    private $optionKey;
    
    /** @var string */
    private $optionValue;
    
    /**
     * Option constructor.
     */
    public function __construct() {
        $this->id          = 0;
        $this->optionKey   = '';
        $this->optionValue = '';
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getOptionKey() {
        return $this->optionKey;
    }
    
    /**
     * @param string $optionKey
     */
    public function setOptionKey($optionKey) {
        $this->optionKey = $optionKey;
    }
    
    /**
     * @return string
     */
    public function getOptionValue() {
        return $this->optionValue;
    }
    
    /**
     * @param string $optionValue
     */
    public function setOptionValue($optionValue) {
        $this->optionValue = $optionValue;
    }
    
}

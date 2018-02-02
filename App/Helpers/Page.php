<?php
/**
 * Page.php
 */

namespace App\Helpers;

/**
 * Class Page
 * @author Nicolás Marulanda P.
 */
class Page {
    
    /** @var string */
    private $styleClass;
    
    /** @var string */
    private $value;
    
    /** @var array */
    private $attrData;
    
    public function __construct($value, $styleClass = "", $attrData = []) {
        $this->styleClass = $styleClass;
        $this->value      = $value;
        $this->attrData   = $attrData;
    }
    
    /**
     * @return string
     */
    public function getAttrData() {
        $strAttrData = "";
        
        foreach ($this->attrData as $key => $value) {
            $strAttrData .= "data-$key='$value' ";
        }
        
        return $strAttrData;
    }
    
    /**
     * @return mixed
     */
    public function getStyleClass() {
        return $this->styleClass;
    }
    
    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }
    
}

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
    
    public function __construct($value, $styleClass = "") {
        $this->styleClass = $styleClass;
        $this->value      = $value;
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

<?php
/**
 * Generating.php
 */

namespace Softn\models;

/**
 * Class Generating
 * @author Nicolás Marulanda P.
 */
class Generating {
    
    /** @var Receipt */
    private $receipt;
    
    /** @var array */
    private $receiptsHasProducts;
    
    /**
     * Generating constructor.
     */
    public function __construct() {
        $this->receipt             = new Receipt();
        $this->receiptsHasProducts = [];
    }
    
    /**
     * @return Receipt
     */
    public function getReceipt() {
        return $this->receipt;
    }
    
    /**
     * @param Receipt $receipt
     */
    public function setReceipt($receipt) {
        $this->receipt = $receipt;
    }
    
    /**
     * @return array
     */
    public function getReceiptsHasProducts() {
        return $this->receiptsHasProducts;
    }
    
    /**
     * @param array $receiptsHasProducts
     */
    public function setReceiptsHasProducts($receiptsHasProducts) {
        $this->receiptsHasProducts = $receiptsHasProducts;
    }
    
}

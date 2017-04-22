<?php
/**
 * ReceiptHasProduct.php
 */

namespace Softn\models;

/**
 * Class ReceiptHasProduct
 * @author Nicolás Marulanda P.
 */
class ReceiptHasProduct {
    
    /** @var int */
    private $receiptId;
    
    /** @var int */
    private $productId;
    
    /** @var int */
    private $receiptProductUnit;
    
    /**
     * ReceiptHasProduct constructor.
     */
    public function __construct() {
        $this->receiptId          = 0;
        $this->productId          = 0;
        $this->receiptProductUnit = 0;
    }
    
    /**
     * @return int
     */
    public function getReceiptId() {
        return $this->receiptId;
    }
    
    /**
     * @param int $receiptId
     */
    public function setReceiptId($receiptId) {
        $this->receiptId = $receiptId;
    }
    
    /**
     * @return int
     */
    public function getProductId() {
        return $this->productId;
    }
    
    /**
     * @param int $productId
     */
    public function setProductId($productId) {
        $this->productId = $productId;
    }
    
    /**
     * @return int
     */
    public function getReceiptProductUnit() {
        return $this->receiptProductUnit;
    }
    
    /**
     * @param int $receiptProductUnit
     */
    public function setReceiptProductUnit($receiptProductUnit) {
        $this->receiptProductUnit = $receiptProductUnit;
    }
    
}

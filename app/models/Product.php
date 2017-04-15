<?php
/**
 * Product.php
 */

namespace Softn\models;

/**
 * Class Product
 * @author Nicolás Marulanda P.
 */
class Product {
    
    /** @var int */
    private $id;
    
    /** @var string */
    private $productName;
    
    /** @var int */
    private $productPriceUnit;
    
    /** @var string */
    private $reference;
    
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
    public function getProductName() {
        return $this->productName;
    }
    
    /**
     * @param string $productName
     */
    public function setProductName($productName) {
        $this->productName = $productName;
    }
    
    /**
     * @return int
     */
    public function getProductPriceUnit() {
        return $this->productPriceUnit;
    }
    
    /**
     * @param int $productPriceUnit
     */
    public function setProductPriceUnit($productPriceUnit) {
        $this->productPriceUnit = $productPriceUnit;
    }
    
    /**
     * @return string
     */
    public function getReference() {
        return $this->reference;
    }
    
    /**
     * @param string $reference
     */
    public function setReference($reference) {
        $this->reference = $reference;
    }
    
}

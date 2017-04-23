<?php
/**
 * Product.php
 */

namespace Softn\models;

/**
 * Class Product
 * @author Nicolás Marulanda P.
 */
class Product implements \JsonSerializable {
    
    /** @var int */
    private $id;
    
    /** @var string */
    private $productName;
    
    /** @var int */
    private $productPriceUnit;
    
    /** @var string */
    private $productReference;
    
    /**
     * Product constructor.
     */
    public function __construct() {
        $this->id               = 0;
        $this->productName      = '';
        $this->productPriceUnit = 0;
        $this->productReference = '';
    }
    
    function jsonSerialize() {
        return [
            ProductsManager::ID                 => $this->id,
            ProductsManager::PRODUCT_NAME       => $this->productName,
            ProductsManager::PRODUCT_PRICE_UNIT => $this->productPriceUnit,
            ProductsManager::PRODUCT_PRICE_UNIT => $this->productReference,
        ];
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
    public function getProductReference() {
        return $this->productReference;
    }
    
    /**
     * @param string $productReference
     */
    public function setProductReference($productReference) {
        $this->productReference = $productReference;
    }
    
}

<?php
/**
 * ProductsManager.php
 */

namespace Softn\models;

use Softn\util\Arrays;
use Softn\util\MySql;

/**
 * Class ProductsManager
 * @author Nicolás Marulanda P.
 */
class ProductsManager extends ManagerAbstract {
    
    const TABLE              = 'products';
    
    const PRODUCT_NAME       = 'product_name';
    
    const PRODUCT_PRICE_UNIT = 'product_price_unit';
    
    const PRODUCT_REFERENCE  = 'product_reference';
    
    /**
     * ProductsManager constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @param string $search
     *
     * @return array
     */
    public function filter($search){
        $products = [];
        $mysql = new MySql();
        $value = "%$search%";
        $product = new Product();
        $product->setProductName($value);
        $product->setProductReference($value);
        $product->setProductPriceUnit(intval($search));
        $where = self::PRODUCT_REFERENCE . ' LIKE :' . self::PRODUCT_REFERENCE . ' OR ';
        $where .= self::PRODUCT_NAME . ' LIKE :' . self::PRODUCT_NAME . ' OR ';
        $where .= self::PRODUCT_PRICE_UNIT . ' = :' . self::PRODUCT_PRICE_UNIT;
        $prepare = $this->prepare($product);
        $select = $mysql->select(self::TABLE, MySql::FETCH_ALL, $where, $prepare);
        $mysql->close();
        
        foreach ($select as $selectValue){
            $products[] = $this->create($selectValue);
        }
        
        return $products;
    }
    
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    public function getAll() {
        return parent::selectAll(self::TABLE);
    }
    
    /**
     * @param $id
     *
     * @return Product
     */
    public function getByID($id) {
        return parent::selectByID($id, self::TABLE);
    }
    
    public function insert($object) {
        parent::addValueAndColumnForInsert(self::PRODUCT_NAME);
        parent::addValueAndColumnForInsert(self::PRODUCT_PRICE_UNIT);
        parent::addValueAndColumnForInsert(self::PRODUCT_REFERENCE);
        parent::insertData($object, self::TABLE);
    }
    
    /**
     * @param Product $object
     */
    public function update($object) {
        parent::addSetForUpdate(self::PRODUCT_NAME);
        parent::addSetForUpdate(self::PRODUCT_PRICE_UNIT);
        parent::addSetForUpdate(self::PRODUCT_REFERENCE);
        $id = $object->getId();
        parent::updateData($object, self::TABLE, $id);
    }
    
    public function delete($id) {
        parent::deleteByID($id, self::TABLE);
    }
    
    protected function create($data) {
        $object = new Product();
        
        if (empty($data)) {
            return $object;
        }
        
        $object->setId(Arrays::get($data, self::ID));
        $object->setProductName(Arrays::get($data, self::PRODUCT_NAME));
        $object->setProductReference(Arrays::get($data, self::PRODUCT_REFERENCE));
        $object->setProductPriceUnit(Arrays::get($data, self::PRODUCT_PRICE_UNIT));
        
        return $object;
    }
    
    /**
     * @param Product $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare   = [];
        $prepare[] = MySql::prepareStatement(':' . self::PRODUCT_NAME, $object->getProductName(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::PRODUCT_PRICE_UNIT, $object->getProductPriceUnit(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::PRODUCT_REFERENCE, $object->getProductReference(), \PDO::PARAM_STR);
        
        return $prepare;
    }
    
}

<?php
/**
 * ReceiptsHasProductsManager.php
 */

namespace Softn\models;

use Softn\util\MySql;

/**
 * Class ReceiptsHasProductsManager
 * @author Nicolás Marulanda P.
 */
class ReceiptsHasProductsManager extends ManagerAbstract {
    
    const TABLE                = 'receipts_has_products';
    
    const RECEIPT_PRODUCTS     = 'receipt_products';
    
    const RECEIPT_PRODUCT_UNIT = 'receipt_product_unit';
    
    const RECEIPT_ID           = 'receipt_id';
    
    const PRODUCT_ID           = 'product_id';
    
    /**
     * ReceiptsHasProductsManager constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @return ReceiptHasProduct
     */
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    public function getAll() {
        return parent::selectAll(self::TABLE);
    }
    
    /**
     * @param $id
     *
     * @return array
     */
    public function getByID($id) {
        $objects = [];
        $mysql   = new MySql();
        $select  = $mysql->selectByColumn($id, self::TABLE, self::RECEIPT_ID);
        $mysql->close();
        
        foreach ($select as $value) {
            $objects[] = $this->create($value);
        }
        
        return $objects;
    }
    
    /**
     * @param array $data
     *
     * @return ReceiptHasProduct
     */
    protected function create($data) {
        $object = new ReceiptHasProduct();
        
        if ($data === FALSE) {
            return $object;
        }
        
        $object->setReceiptId($data[self::RECEIPT_ID]);
        $object->setProductId($data[self::PRODUCT_ID]);
        $object->setReceiptProductUnit($data[self::RECEIPT_PRODUCT_UNIT]);
        
        return $object;
    }
    
    public function insert($object) {
        parent::addValueAndColumnForInsert(self::RECEIPT_ID);
        parent::addValueAndColumnForInsert(self::PRODUCT_ID);
        parent::addValueAndColumnForInsert(self::RECEIPT_PRODUCT_UNIT);
        parent::insertData($object, self::TABLE);
    }
    
    public function update($object) {
        // TODO: Implement update() method.
    }
    
    public function delete($id) {
        $mysql        = new MySql();
        $paramReceipt = ':' . self::RECEIPT_ID;
        $where        = self::RECEIPT_ID . ' = ' . $paramReceipt;
        $prepare      = [];
        $prepare[]    = MySql::prepareStatement($paramReceipt, $id, \PDO::PARAM_INT);
        
        $mysql->delete(self::TABLE, $where, $prepare);
        $mysql->close();
    }
    
    /**
     * @param ReceiptHasProduct $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare   = [];
        $prepare[] = MySql::prepareStatement(':' . self::PRODUCT_ID, $object->getProductId(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_ID, $object->getReceiptId(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_PRODUCT_UNIT, $object->getReceiptProductUnit(), \PDO::PARAM_INT);
        
        return $prepare;
    }
}

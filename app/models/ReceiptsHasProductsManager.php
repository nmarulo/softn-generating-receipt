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
    
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    public function getAll() {
        return parent::selectAll(self::TABLE);
    }
    
    public function getByID($id) {
        // TODO: Implement getByID() method.
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
        // TODO: Implement delete() method.
    }
    
    protected function create($data) {
        // TODO: Implement create() method.
    }
    
    /**
     * @param ReceiptHasProduct $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare = [];
        $prepare[] = MySql::prepareStatement(':' . self::PRODUCT_ID, $object->getProductId(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_ID, $object->getReceiptId(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_PRODUCT_UNIT, $object->getReceiptProductUnit(), \PDO::PARAM_INT);
        
        return $prepare;
    }
}

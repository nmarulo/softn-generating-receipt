<?php
/**
 * ReceiptsManager.php
 */

namespace Softn\models;

use Softn\util\Arrays;
use Softn\util\MySql;

/**
 * Class ReceiptsManager
 * @author Nicolás Marulanda P.
 */
class ReceiptsManager extends ManagerAbstract {
    
    const TABLE          = 'receipts';
    
    const RECEIPT_TYPE   = 'receipt_type';
    
    const RECEIPT_NUMBER = 'receipt_number';
    
    const RECEIPT_DATE   = 'receipt_date';
    
    const CLIENT_ID      = 'client_id';
    
    /**
     * ReceiptsManager constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @return array
     */
    public function getAll() {
        return parent::selectAll(self::TABLE);
    }
    
    /**
     * @param $id
     *
     * @return null|Receipt
     */
    public function getByID($id) {
        $object = NULL;
        $select = parent::selectByID($id, self::TABLE);
        
        foreach ($select as $value) {
            $object = $this->create($value);
        }
        
        if ($object === NULL) {
            $object = new Receipt();
        }
        
        return $object;
    }
    
    /**
     * @param array $data
     *
     * @return Receipt
     */
    protected function create($data) {
        $object = new Receipt();
        $object->setId(Arrays::get($data, self::ID));
        $object->setReceiptDate(Arrays::get($data, self::RECEIPT_DATE));
        $object->setReceiptNumber(Arrays::get($data, self::RECEIPT_NUMBER));
        $object->setReceiptType(Arrays::get($data, self::RECEIPT_TYPE));
        $object->setClientId(Arrays::get($data, self::CLIENT_ID));
        
        return $object;
    }
    
    /**
     * @param Receipt $object
     */
    public function insert($object) {
        parent::addValueAndColumnForInsert(self::RECEIPT_TYPE);
        parent::addValueAndColumnForInsert(self::RECEIPT_NUMBER);
        parent::addValueAndColumnForInsert(self::RECEIPT_DATE);
        parent::addValueAndColumnForInsert(self::CLIENT_ID);
        parent::insertData($object, self::TABLE);
    }
    
    /**
     * @param Receipt $object
     */
    public function update($object) {
        parent::addSetForUpdate(self::RECEIPT_DATE);
        parent::addSetForUpdate(self::RECEIPT_NUMBER);
        parent::addSetForUpdate(self::RECEIPT_TYPE);
        parent::addSetForUpdate(self::CLIENT_ID);
        $id = $object->getId();
        parent::updateData($object, self::TABLE, $id);
    }
    
    /**
     * @param int $id
     */
    public function delete($id) {
        parent::deleteByID($id, self::TABLE);
    }
    
    /**
     * @param Receipt $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare   = [];
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_TYPE, $object->getReceiptType(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_NUMBER, $object->getReceiptNumber(), \PDO::PARAM_INT);
        $prepare[] = MySql::prepareStatement(':' . self::RECEIPT_DATE, $object->getReceiptDate(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::CLIENT_ID, $object->getClientId(), \PDO::PARAM_INT);
        
        return $prepare;
    }
    
}

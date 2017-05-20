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
     * @param string $search
     *
     * @return array
     */
    public function filter($search) {
        $receipts = [];
        $mysql    = new MySql();
        $value    = "%$search%";
        $receipt  = new Receipt();
        
        if (is_numeric($search)) {
            $receipt->setReceiptNumber(intval($search));
            $where = self::RECEIPT_NUMBER . ' = :' . self::RECEIPT_NUMBER;
        } else {
            $receipt->setReceiptType($value);
            $receipt->setReceiptDate($value);
            $where = self::RECEIPT_DATE . ' LIKE :' . self::RECEIPT_DATE . ' OR ';
            $where .= self::RECEIPT_TYPE . ' LIKE :' . self::RECEIPT_TYPE;
        }
        
        $prepare = $this->prepare($receipt);
        $select  = $mysql->select(self::TABLE, MySql::FETCH_ALL, $where, $prepare);
        $mysql->close();
        
        foreach ($select as $selectValue) {
            $receipts[] = $this->create($selectValue);
        }
        
        return $receipts;
    }
    
    /**
     * @param Receipt $object
     *
     * @return array
     */
    protected function prepare($object) {
        parent::prepareStatement(':' . self::RECEIPT_TYPE, $object->getReceiptType(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::RECEIPT_NUMBER, $object->getReceiptNumber(), \PDO::PARAM_INT);
        parent::prepareStatement(':' . self::RECEIPT_DATE, $object->getReceiptDate(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::CLIENT_ID, $object->getClientId(), \PDO::PARAM_INT);
        
        return $this->getPrepareAndClear();
    }
    
    /**
     * @param array $data
     *
     * @return Receipt
     */
    protected function create($data) {
        $object = new Receipt();
        
        if (empty($data)) {
            return $object;
        }
        
        $object->setId(Arrays::get($data, self::ID));
        $object->setReceiptDate(Arrays::get($data, self::RECEIPT_DATE));
        $object->setReceiptNumber(Arrays::get($data, self::RECEIPT_NUMBER));
        $object->setReceiptType(Arrays::get($data, self::RECEIPT_TYPE));
        $object->setClientId(Arrays::get($data, self::CLIENT_ID));
        
        return $object;
    }
    
    /**
     * @return Receipt
     */
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    /**
     * @return array
     */
    public function getAll() {
        return parent::selectAll(self::TABLE);
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
        $receipt        = $this->getByID($id);
        $clientsManager = new ClientsManager();
        $client         = $clientsManager->getByID($receipt->getClientId());
        //TODO: Conversión temporal.
        $numberReceipt = intval($client->getClientNumberReceipts());
        $client->setClientNumberReceipts(--$numberReceipt < 0 ? 0 : $numberReceipt);
        $clientsManager->update($client);
        parent::deleteByID($id, self::TABLE);
        
    }
    
    /**
     * @param $id
     *
     * @return Receipt
     */
    public function getByID($id) {
        return parent::selectByID($id, self::TABLE);;
    }
    
    public function getCountReceiptByClientId($id) {
        $parameter = ':' . self::CLIENT_ID;
        $where     = self::CLIENT_ID . " = $parameter";
        $prepare   = [];
        $prepare[] = MySql::prepareStatement($parameter, $id, \PDO::PARAM_INT);
        
        return parent::countData(self::TABLE, $where, $prepare);
    }
    
}

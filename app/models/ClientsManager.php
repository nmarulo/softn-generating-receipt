<?php
/**
 * ClientsManager.php
 */

namespace Softn\models;

use Softn\util\Arrays;
use Softn\util\MySql;

/**
 * Class ClientsManager
 * @author Nicolás Marulanda P.
 */
class ClientsManager extends ManagerAbstract {
    
    const TABLE                          = 'clients';
    
    const CLIENT_IDENTIFICATION_DOCUMENT = 'client_identification_document';
    
    const CLIENT_CITY                    = 'client_city';
    
    const CLIENT_ADDRESS                 = 'client_address';
    
    const CLIENT_NAME                    = 'client_name';
    
    const CLIENT_NUMBER_RECEIPTS         = 'client_number_receipts';
    
    /**
     * ClientsManager constructor.
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
        $clients = [];
        $mysql   = new MySql();
        $value   = "%$search%";
        $client  = new Client();
        $client->setClientName($value);
        $client->setClientAddress($value);
        $client->setClientCity($value);
        $client->setClientIdentificationDocument($value);
        $client->setClientNumberReceipts('');
        $where   = self::CLIENT_ADDRESS . ' LIKE :' . self::CLIENT_ADDRESS . ' OR ';
        $where   .= self::CLIENT_CITY . ' LIKE :' . self::CLIENT_CITY . ' OR ';
        $where   .= self::CLIENT_NAME . ' LIKE :' . self::CLIENT_NAME . ' OR ';
        $where   .= self::CLIENT_IDENTIFICATION_DOCUMENT . ' LIKE :' . self::CLIENT_IDENTIFICATION_DOCUMENT;
        $prepare = $this->prepare($client);
        $select  = $mysql->select(self::TABLE, MySql::FETCH_ALL, $where, $prepare);
        $mysql->close();
        
        foreach ($select as $selectValue) {
            $clients[] = $this->create($selectValue);
        }
        
        return $clients;
    }
    
    /**
     * @param Client $object
     *
     * @return array
     */
    protected function prepare($object) {
        parent::prepareStatement(':' . self::CLIENT_NAME, $object->getClientName(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::CLIENT_IDENTIFICATION_DOCUMENT, $object->getClientIdentificationDocument(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::CLIENT_ADDRESS, $object->getClientAddress(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::CLIENT_CITY, $object->getClientCity(), \PDO::PARAM_STR);
        parent::prepareStatement(':' . self::CLIENT_NUMBER_RECEIPTS, $object->getClientNumberReceipts(), \PDO::PARAM_INT);
        
        return parent::getPrepareAndClear();
    }
    
    /**
     * Método que obtiene una instancia con los datos.
     *
     * @param array $data Datos de la consulta 'SELECT'.
     *
     * @return Client
     */
    protected function create($data) {
        $object = new Client();
        
        if (empty($data)) {
            return $object;
        }
        
        $object->setId(Arrays::get($data, self::ID));
        $object->setClientIdentificationDocument(Arrays::get($data, self::CLIENT_IDENTIFICATION_DOCUMENT));
        $object->setClientCity(Arrays::get($data, self::CLIENT_CITY));
        $object->setClientAddress(Arrays::get($data, self::CLIENT_ADDRESS));
        $object->setClientName(Arrays::get($data, self::CLIENT_NAME));
        $object->setClientNumberReceipts(Arrays::get($data, self::CLIENT_NUMBER_RECEIPTS));
        
        return $object;
    }
    
    /**
     * @return array
     */
    public function getAll() {
        return parent::selectAll(self::TABLE);
    }
    
    /**
     * @param int $id
     *
     * @return Client
     */
    public function getByID($id) {
        return parent::selectByID($id, self::TABLE);
    }
    
    /**
     * @param Client $object
     */
    public function insert($object) {
        parent::addValueAndColumnForInsert(self::CLIENT_NAME);
        parent::addValueAndColumnForInsert(self::CLIENT_ADDRESS);
        parent::addValueAndColumnForInsert(self::CLIENT_IDENTIFICATION_DOCUMENT);
        parent::addValueAndColumnForInsert(self::CLIENT_CITY);
        parent::addValueAndColumnForInsert(self::CLIENT_NUMBER_RECEIPTS);
        parent::insertData($object, self::TABLE);
    }
    
    /**
     * @param Client $object
     */
    public function update($object) {
        parent::addSetForUpdate(self::CLIENT_NAME);
        parent::addSetForUpdate(self::CLIENT_ADDRESS);
        parent::addSetForUpdate(self::CLIENT_IDENTIFICATION_DOCUMENT);
        parent::addSetForUpdate(self::CLIENT_CITY);
        parent::addSetForUpdate(self::CLIENT_NUMBER_RECEIPTS);
        $id = $object->getId();
        parent::updateData($object, self::TABLE, $id);
    }
    
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete($id) {
        if ($this->canBeDelete($id)) {
            return parent::deleteByID($id, self::TABLE);
        }
        
        return FALSE;
    }
    
    private function canBeDelete($id) {
        $receiptsManager = new ReceiptsManager();
        $count           = $receiptsManager->getCountReceiptByClientId($id);
        
        return $count == 0;
    }
}

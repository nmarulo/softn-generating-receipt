<?php
/**
 * ClientsManager.php
 */

namespace Softn\models;

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
    
    /**
     * ClientsManager constructor.
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
     * @param int $id
     *
     * @return Client
     */
    public function getByID($id) {
        $clientSelect = NULL;
        $select       = parent::selectByID($id, self::TABLE);
        
        foreach ($select as $value) {
            $clientSelect = $this->create($value);
        }
        
        if ($clientSelect === NULL) {
            $clientSelect = new Client();
        }
        
        return $clientSelect;
    }
    
    /**
     * Método que obtiene una instancia con los datos.
     *
     * @param array $data Datos de la consulta 'SELECT'.
     *
     * @return Client
     */
    protected function create($data) {
        $client = new Client();
        $client->setId($data[self::ID]);
        $client->setClientIdentificationDocument($data[self::CLIENT_IDENTIFICATION_DOCUMENT]);
        $client->setClientCity($data[self::CLIENT_CITY]);
        $client->setClientAddress($data[self::CLIENT_ADDRESS]);
        $client->setClientName($data[self::CLIENT_NAME]);
        
        return $client;
    }
    
    /**
     * @param Client $object
     */
    public function insert($object) {
        $this->addValueAndColumnForInsert(self::CLIENT_NAME);
        $this->addValueAndColumnForInsert(self::CLIENT_ADDRESS);
        $this->addValueAndColumnForInsert(self::CLIENT_IDENTIFICATION_DOCUMENT);
        $this->addValueAndColumnForInsert(self::CLIENT_CITY);
        parent::insertData($object, self::TABLE);
    }
    
    /**
     * @param Client $object
     */
    public function update($object) {
        $this->addSetForUpdate(self::CLIENT_NAME);
        $this->addSetForUpdate(self::CLIENT_ADDRESS);
        $this->addSetForUpdate(self::CLIENT_IDENTIFICATION_DOCUMENT);
        $this->addSetForUpdate(self::CLIENT_CITY);
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
     * @param Client $object
     *
     * @return array
     */
    protected function prepare($object) {
        $prepare   = [];
        $prepare[] = MySql::prepareStatement(':' . self::CLIENT_NAME, $object->getClientName(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::CLIENT_IDENTIFICATION_DOCUMENT, $object->getClientIdentificationDocument(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::CLIENT_ADDRESS, $object->getClientAddress(), \PDO::PARAM_STR);
        $prepare[] = MySql::prepareStatement(':' . self::CLIENT_CITY, $object->getClientCity(), \PDO::PARAM_STR);
        
        return $prepare;
    }
}

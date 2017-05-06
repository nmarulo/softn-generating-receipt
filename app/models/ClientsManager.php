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
        $id = $object->getId();
        parent::updateData($object, self::TABLE, $id);
    }
    
    public function getLast() {
        return parent::getLastData(self::TABLE);
    }
    
    /**
     * @param int $id
     */
    public function delete($id) {
        parent::deleteByID($id, self::TABLE);
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
        
        return $object;
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

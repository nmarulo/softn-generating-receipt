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
        $clients = [];
        $mysql   = new MySql();
        $select  = $mysql->select(self::TABLE, MySql::FETCH_ALL);
        
        foreach ($select as $value) {
            $client = new Client();
            $client->setId($value[self::ID]);
            $client->setClientIdentificationDocument($value[self::CLIENT_IDENTIFICATION_DOCUMENT]);
            $client->setClientCity($value[self::CLIENT_CITY]);
            $client->setClientAddress($value[self::CLIENT_ADDRESS]);
            $client->setClientName($value[self::CLIENT_NAME]);
            $clients[] = $client;
        }
        
        $mysql->close();
        
        return $clients;
    }
    
    /**
     * @param int $id
     *
     * @return null|Client
     */
    public function getByID($id) {
        $clientSelect = NULL;
        $mysql        = new MySql();
        $where        = self::ID . ' = :' . self::ID;
        $prepare      = [];
        $prepare[]    = $mysql->prepareStatement(':' . self::ID, $id, \PDO::PARAM_INT);
        $select       = $mysql->select(self::TABLE, MySql::FETCH_ALL, $where, $prepare);
        
        foreach ($select as $value) {
            $client = new Client();
            $client->setId($value['id']);
            $client->setClientIdentificationDocument($value['client_identification_document']);
            $client->setClientCity($value['client_city']);
            $client->setClientAddress($value['client_address']);
            $client->setClientName($value['client_name']);
            $clientSelect = $client;
        }
        
        $mysql->close();
        
        return $clientSelect;
    }
    
    /**
     * @param Client $object
     */
    public function insert($object) {
        $this->addValueAndColumnForInsert(self::CLIENT_NAME);
        $this->addValueAndColumnForInsert(self::CLIENT_ADDRESS);
        $this->addValueAndColumnForInsert(self::CLIENT_IDENTIFICATION_DOCUMENT);
        $this->addValueAndColumnForInsert(self::CLIENT_CITY);
        $mysql   = new MySql();
        $values  = $this->getValuesForInsert();
        $columns = $this->getColumnsForInsert();
        
        $prepare = $this->prepare($object, $mysql);
        
        $mysql->insert(self::TABLE, $columns, $values, $prepare);
        $mysql->close();
    }
    
    /**
     * @param Client $object
     * @param MySql  $mysql
     *
     * @return array
     */
    protected function prepare($object, $mysql) {
        $prepare   = [];
        $prepare[] = $mysql->prepareStatement(':' . self::CLIENT_NAME, $object->getClientName(), \PDO::PARAM_STR);
        $prepare[] = $mysql->prepareStatement(':' . self::CLIENT_IDENTIFICATION_DOCUMENT, $object->getClientIdentificationDocument(), \PDO::PARAM_STR);
        $prepare[] = $mysql->prepareStatement(':' . self::CLIENT_ADDRESS, $object->getClientAddress(), \PDO::PARAM_STR);
        $prepare[] = $mysql->prepareStatement(':' . self::CLIENT_CITY, $object->getClientCity(), \PDO::PARAM_STR);
        
        return $prepare;
    }
    
    /**
     * @param Client $object
     */
    public function update($object) {
        $this->addSetForUpdate(self::CLIENT_NAME);
        $this->addSetForUpdate(self::CLIENT_ADDRESS);
        $this->addSetForUpdate(self::CLIENT_IDENTIFICATION_DOCUMENT);
        $this->addSetForUpdate(self::CLIENT_CITY);
        $mysql     = new MySql();
        $id        = $object->getId();
        $columns   = $this->getSetForUpdate();
        $where     = self::ID . ' = :' . self::ID;
        $prepare   = $this->prepare($object, $mysql);
        $prepare[] = $mysql->prepareStatement(':' . self::ID, $id, \PDO::PARAM_INT);
        $mysql->update(self::TABLE, $columns, $where, $prepare);
        $mysql->close();
    }
    
    /**
     * @param int $id
     */
    public function delete($id) {
        $mysql     = new MySql();
        $where     = self::ID . ' = :' . self::ID;
        $prepare   = [];
        $prepare[] = $mysql->prepareStatement(':' . self::ID, $id, \PDO::PARAM_INT);
        $mysql->delete(self::TABLE, $where, $prepare);
        $mysql->close();
    }
}

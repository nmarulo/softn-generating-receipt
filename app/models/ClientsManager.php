<?php
/**
 * ClientsManager.php
 */

namespace Softn\models;

/**
 * Class ClientsManager
 * @author Nicolás Marulanda P.
 */
class ClientsManager {
    
    public function getAll() {
        $clients = [];
        
        try {
            $mysql  = new \PDO('mysql:host=localhost;dbname=softn_gr;charset=utf8', 'root', 'root');
            $select = $mysql->query("SELECT * FROM clients")
                            ->fetchAll();
            
            foreach ($select as $value) {
                $client = new Client();
                $client->setId($value['id']);
                $client->setClientIdentificationDocument($value['client_identification_document']);
                $client->setClientCity($value['client_city']);
                $client->setClientAddress($value['client_address']);
                $client->setClientName($value['client_name']);
                $clients[] = $client;
            }
        } catch (\PDOException $ex) {
            die('Error al intentar establecer la conexión con la base de datos');
        }
        
        return $clients;
    }
    
    public function getByID($id) {
        $clientSelect = NULL;
        
        try {
            $mysql  = new \PDO('mysql:host=localhost;dbname=softn_gr;charset=utf8', 'root', 'root');
            $select = $mysql->query("SELECT * FROM clients WHERE ID = $id")
                            ->fetchAll();
            
            foreach ($select as $value) {
                $client = new Client();
                $client->setId($value['id']);
                $client->setClientIdentificationDocument($value['client_identification_document']);
                $client->setClientCity($value['client_city']);
                $client->setClientAddress($value['client_address']);
                $client->setClientName($value['client_name']);
                $clientSelect = $client;
            }
        } catch (\PDOException $ex) {
            die('Error al intentar establecer la conexión con la base de datos');
        }
        
        return $clientSelect;
    }
    
    /**
     * @param Client $object
     */
    public function insert($object) {
        try {
            $mysql   = new \PDO('mysql:host=localhost;dbname=softn_gr;charset=utf8', 'root', 'root');
            $values  = '"' . $object->getClientName() . '","' . $object->getClientAddress() . '","' . $object->getClientIdentificationDocument() . '","' . $object->getClientCity() . '"';
            $columns = 'client_name, client_address, client_identification_document, client_city';
            $insertSQL = "INSERT INTO clients ($columns) VALUE ($values)";
            $mysql->exec($insertSQL);
        } catch (\PDOException $ex) {
            die('Error al intentar establecer la conexión con la base de datos');
        }
    }
    
    /**
     * @param Client $object
     */
    public function update($object) {
        try {
            $mysql   = new \PDO('mysql:host=localhost;dbname=softn_gr;charset=utf8', 'root', 'root');
            $id      = $object->getId();
            $columns = 'client_name = "' . $object->getClientName() . '" , client_address = "' . $object->getClientAddress() . '", client_identification_document = "' . $object->getClientIdentificationDocument() . '", client_city = "' . $object->getClientCity() . '"';
            $updateSQL = "UPDATE clients SET $columns WHERE ID = $id";
            $mysql->exec($updateSQL);
        } catch (\PDOException $ex) {
            die('Error al intentar establecer la conexión con la base de datos');
        }
    }
    
    /**
     * @param int $id
     */
    public function delete($id) {
        try {
            $mysql = new \PDO('mysql:host=localhost;dbname=softn_gr;charset=utf8', 'root', 'root');
            $mysql->exec("DELETE FROM clients WHERE ID = $id");
        } catch (\PDOException $ex) {
            die('Error al intentar establecer la conexión con la base de datos');
        }
    }
}

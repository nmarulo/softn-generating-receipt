<?php
/**
 * ManagerAbstract.php
 */

namespace Softn\models;

use Softn\util\MySql;

/**
 * Class ManagerAbstract
 * @author Nicolás Marulanda P.
 */
abstract class ManagerAbstract implements ManagerInterface {
    
    /** @var string */
    private $columnsForInsert;
    
    /** @var string */
    private $valuesForInsert;
    
    /** @var string */
    private $setForUpdate;
    
    private $lastInsertId;
    
    /**
     * ManagerAbstract constructor.
     */
    public function __construct() {
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
        $this->lastInsertId = 0;
    }
    
    public function getLastInsertId(){
        return $this->lastInsertId;
    }
    
    public abstract function getLast();
    
    /**
     * @param int    $id
     * @param string $table
     */
    public function deleteByID($id, $table) {
        $mysql = new MySql();
        $mysql->deleteByColumn($id, $table, self::ID);
        $mysql->close();
    }
    
    /**
     * @param int    $id
     * @param string $table
     *
     * @return array|bool|\PDOStatement
     */
    public function selectByID($id, $table) {
        $mysql  = new MySql();
        $select = $mysql->selectByColumn($id, $table, self::ID);
        $mysql->close();
        
        return $select;
    }
    
    protected function getLastData($table) {
        $mysql  = new MySql();
        $select = $mysql->select($table, MySql::FETCH_ALL, '', [], '*', 'id DESC', 1);
        $mysql->close();
        
        return $this->create($select);
    }
    
    /**
     * @param string $name
     */
    protected function addValueAndColumnForInsert($name) {
        $this->valuesForInsert  .= empty($this->valuesForInsert) ? '' : ', ';
        $this->valuesForInsert  .= ':' . $name;
        $this->columnsForInsert .= empty($this->columnsForInsert) ? '' : ', ';
        $this->columnsForInsert .= $name;
    }
    
    /**
     * @param string $table
     *
     * @return array
     */
    protected function selectAll($table) {
        $objects = [];
        $mysql   = new MySql();
        $select  = $mysql->select($table, MySql::FETCH_ALL);
        $mysql->close();
        
        foreach ($select as $value) {
            $objects[] = $this->create($value);
        }
        
        return $objects;
    }
    
    /**
     * @param array $data
     *
     * @return object
     */
    protected abstract function create($data);
    
    /**
     * @param string $name
     */
    protected function addSetForUpdate($name) {
        $this->setForUpdate .= empty($this->setForUpdate) ? '' : ', ';
        $this->setForUpdate .= $name . ' = :' . $name;
    }
    
    /**
     * @param object $object
     * @param string $table
     */
    protected function insertData($object, $table) {
        $mysql   = new MySql();
        $values  = $this->valuesForInsert;
        $columns = $this->columnsForInsert;
        $prepare = $this->prepare($object);
        $mysql->insert($table, $columns, $values, $prepare);
        $this->lastInsertId = $mysql->lastInsertId();
        $mysql->close();
        $this->clear();
    }
    
    protected abstract function prepare($object);
    
    /**
     * @param object $object
     * @param string $table
     * @param int    $id
     */
    protected function updateData($object, $table, $id) {
        $mysql     = new MySql();
        $columns   = $this->setForUpdate;
        $where     = self::ID . ' = :' . self::ID;
        $prepare   = $this->prepare($object);
        $prepare[] = $mysql->prepareStatement(':' . self::ID, $id, \PDO::PARAM_INT);
        $mysql->update($table, $columns, $where, $prepare);
        $mysql->close();
        $this->clear();
    }
    
    /**
     *
     */
    private function clear(){
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
    }
}

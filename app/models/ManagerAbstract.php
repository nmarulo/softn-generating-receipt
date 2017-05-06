<?php
/**
 * ManagerAbstract.php
 */

namespace Softn\models;

use Softn\util\Arrays;
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
    
    /** @var int */
    private $lastInsertId;
    
    /**
     * ManagerAbstract constructor.
     */
    public function __construct() {
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
        $this->lastInsertId     = 0;
    }
    
    /**
     * @return int
     */
    public function getLastInsertId() {
        return $this->lastInsertId;
    }
    
    public abstract function getLast();
    
    /**
     * @param int    $id
     * @param string $table
     *
     * @return bool
     */
    protected function deleteByID($id, $table) {
        $mysql     = new MySql();
        $isExecute = $mysql->deleteByColumn($id, $table, self::ID);
        $mysql->close();
        
        return $isExecute;
    }
    
    /**
     * @param $id
     * @param $table
     *
     * @return object
     */
    protected function selectByID($id, $table) {
        return $this->selectByColumn($id, $table, self::ID);
    }
    
    /**
     * @param string $value
     * @param string $table
     * @param string $column
     *
     * @return object
     */
    protected function selectByColumn($value, $table, $column) {
        $mysql  = new MySql();
        $select = $mysql->selectByColumn($value, $table, $column);
        $mysql->close();
        
        return $this->create(Arrays::get($select, 0));
    }
    
    /**
     * @param array $data
     *
     * @return object
     */
    protected abstract function create($data);
    
    /**
     * @param string $table
     *
     * @return object
     */
    protected function getLastData($table) {
        $mysql  = new MySql();
        $select = $mysql->select($table, MySql::FETCH_ALL, '', [], '*', 'id DESC', 1);
        $mysql->close();
        
        return $this->create(Arrays::get($select, 0));
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
     * @param string $name
     */
    protected function addSetForUpdate($name) {
        $this->setForUpdate .= empty($this->setForUpdate) ? '' : ', ';
        $this->setForUpdate .= $name . ' = :' . $name;
    }
    
    /**
     * @param object $object
     * @param string $table
     *
     * @return bool
     */
    protected function insertData($object, $table) {
        $mysql              = new MySql();
        $values             = $this->valuesForInsert;
        $columns            = $this->columnsForInsert;
        $prepare            = $this->prepare($object);
        $isExecute          = $mysql->insert($table, $columns, $values, $prepare);
        $this->lastInsertId = $mysql->lastInsertId();
        $mysql->close();
        $this->clear();
        
        return $isExecute;
    }
    
    protected abstract function prepare($object);
    
    /**
     *
     */
    private function clear() {
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
    }
    
    /**
     * @param object $object
     * @param string $table
     * @param int    $value
     * @param string $column [Opcional]
     *
     * @return bool
     */
    protected function updateData($object, $table, $value, $column = self::ID) {
        $mysql     = new MySql();
        $columns   = $this->setForUpdate;
        $param     = ":$column";
        $where     = "$column = $param";
        $prepare   = $this->prepare($object);
        $prepare[] = $mysql->prepareStatement($param, $value, \PDO::PARAM_INT);
        $isExecute = $mysql->update($table, $columns, $where, $prepare);
        $mysql->close();
        $this->clear();
        
        return $isExecute;
    }
}

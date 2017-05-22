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
    
    /** @var array */
    private $prepare;
    
    /**
     * ManagerAbstract constructor.
     */
    public function __construct() {
        $this->columnsForInsert = '';
        $this->valuesForInsert  = '';
        $this->setForUpdate     = '';
        $this->lastInsertId     = 0;
        $this->prepare          = [];
    }
    
    /**
     * @return int
     */
    public function getLastInsertId() {
        return $this->lastInsertId;
    }
    
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
        
        return $this->createObjects($select);
    }
    
    /**
     * @param array $select      Resultado de la consulta select.
     * @param bool  $alwaysArray Indica si retornara siempre una lista con los datos.
     *
     * @return array|object
     */
    private function createObjects($select, $alwaysArray = FALSE) {
        if (count($select) > 1 || $alwaysArray) {
            $objects = [];
            
            foreach ($select as $value) {
                $objects[] = $this->create($value);
            }
            
            return $objects;
        }
        
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
        
        return $this->createObjects($select);
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
     * @param string $orderBy
     *
     * @return array
     */
    protected function selectAll($table, $orderBy = self::ID) {
        $mysql  = new MySql();
        $select = $mysql->select($table, MySql::FETCH_ALL, '', [], '*', "$orderBy DESC");
        
        $mysql->close();
        
        return $this->createObjects($select, TRUE);
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
        $mysql     = new MySql();
        $values    = $this->valuesForInsert;
        $columns   = $this->columnsForInsert;
        $prepare   = $this->prepare($object);
        $isExecute = FALSE;
        
        if ($mysql->insert($table, $columns, $values, $prepare)) {
            $isExecute          = TRUE;
            $this->lastInsertId = $mysql->lastInsertId();
        }
        
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
    
    protected function prepareStatement($parameter, $value, $dataType) {
        if (!empty($value) || is_numeric($value)) {
            $this->prepare[] = MySql::prepareStatement($parameter, $value, $dataType);
        }
    }
    
    protected function getPrepareAndClear() {
        $prepare       = $this->prepare;
        $this->prepare = [];
        
        return $prepare;
    }
    
    /**
     * Método que actualiza los datos del objeto.
     *
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
    
    protected function countData($table, $column, $value, $dataType = \PDO::PARAM_INT) {
        $mySql     = new MySql();
        $prepare   = [];
        $parameter = ":$column";
        $where     = "$column = $parameter";
        $prepare[] = MySql::prepareStatement($parameter, $value, $dataType);
        $columns   = 'COUNT(*) AS COUNT';
        $select    = $mySql->select($table, MySql::FETCH_ALL, $where, $prepare, $columns);
        $count     = Arrays::get($select, 0);
        
        if ($count === FALSE) {
            return 0;
        }
        
        return Arrays::get($count, 'COUNT');
    }
}

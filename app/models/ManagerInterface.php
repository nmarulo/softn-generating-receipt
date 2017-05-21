<?php
/**
 * ManagerInterfaces.php
 */

namespace Softn\models;

/**
 * Class ManagerInterfaces
 * @author Nicolás Marulanda P.
 */
interface ManagerInterface {
    
    const ID = 'id';
    
    public function getAll();
    
    public function getByID($id);
    
    public function insert($object);
    
    public function update($id, $object);
    
    public function delete($id);
}

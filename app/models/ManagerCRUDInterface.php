<?php
/**
 * ManagerCRUDInterface.php
 */

namespace Softn\models;

/**
 * Class ManagerCRUDInterface
 * @author Nicolás Marulanda P.
 */
interface ManagerCRUDInterface extends ManagerInterface {
    
    public function insert($object);
    
    public function update($id, $object);
    
    public function delete($id);
    
    public function filter($search);
    
    public function getByID($id);
}

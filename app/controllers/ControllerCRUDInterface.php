<?php
/**
 * ControllerCRUDInterface.php
 */

namespace Softn\controllers;

/**
 * Class ControllerCRUDInterface
 * @author Nicolás Marulanda P.
 */
interface ControllerCRUDInterface extends ControllerInterfaces {
    
    public function insert($object);
    
    public function update($object);
    
    public function delete($id);
}

<?php
/**
 * ControllerCRUDInterface.php
 */

namespace Softn\controllers;

/**
 * Class ControllerCRUDInterface
 * @author Nicolás Marulanda P.
 */
interface ControllerCRUDInterface extends ControllerInterface {
    
    public function insert();
    
    public function update();
    
    public function delete();
}

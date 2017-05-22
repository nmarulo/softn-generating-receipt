<?php
/**
 * ManagerCRUDAbstract.php
 */

namespace Softn\models;

/**
 * Class ManagerCRUDAbstract
 * @author Nicolás Marulanda P.
 */
abstract class ManagerCRUDAbstract extends ManagerAbstract implements ManagerCRUDInterface {
    
    protected abstract function getAndSetterObject($id, $object);
}

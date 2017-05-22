<?php
/**
 * ControllerCRUDAbstract.php
 */

namespace Softn\controllers;

/**
 * Class ControllerCRUDAbstract
 * @author Nicolás Marulanda P.
 */
abstract class ControllerCRUDAbstract extends ControllerAbstract implements ControllerCRUDInterface {
    
    protected abstract function getViewForm();
}

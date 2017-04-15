<?php
/**
 * ReceiptsController.php
 */

namespace Softn\controllers;

/**
 * Class ReceiptsController
 * @author Nicolás Marulanda P.
 */
class ReceiptsController extends ControllerAbstract implements ControllerCRUDInterface {
    
    /**
     * ReceiptsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('receipts');
    }
    
    public static function init() {
        parent::method(new ReceiptsController());
    }
    
    public function insert() {
        // TODO: Implement insert() method.
    }
    
    public function update() {
        // TODO: Implement update() method.
    }
    
    public function delete() {
        // TODO: Implement delete() method.
    }
    
    public function index() {
        
        ViewController::view('index');
    }
}

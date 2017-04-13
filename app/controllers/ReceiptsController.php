<?php
/**
 * ReceiptsController.php
 */

namespace Softn\controllers;

/**
 * Class ReceiptsController
 * @author Nicolás Marulanda P.
 */
class ReceiptsController implements ControllerCRUDInterface {
    
    /**
     * ReceiptsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('receipts');
    }
    
    public static function init() {
        return new ReceiptsController();
    }
    
    public function insert($object) {
        // TODO: Implement insert() method.
    }
    
    public function update($object) {
        // TODO: Implement update() method.
    }
    
    public function delete($id) {
        // TODO: Implement delete() method.
    }
    
    public function index() {
        
        ViewController::view('index');
    }
}

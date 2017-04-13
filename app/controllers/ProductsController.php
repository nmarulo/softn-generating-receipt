<?php
/**
 * ProductsController.php
 */

namespace Softn\controllers;

/**
 * Class ProductsController
 * @author Nicolás Marulanda P.
 */
class ProductsController implements ControllerCRUDInterface {
    
    /**
     * ProductsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('products');
    }
    
    public static function init() {
        return new ProductsController();
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

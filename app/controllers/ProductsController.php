<?php
/**
 * ProductsController.php
 */

namespace Softn\controllers;

/**
 * Class ProductsController
 * @author Nicolás Marulanda P.
 */
class ProductsController extends ControllerAbstract implements ControllerCRUDInterface {
    
    /**
     * ProductsController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('products');
    }
    
    public static function init() {
        parent::method(new ProductsController());
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

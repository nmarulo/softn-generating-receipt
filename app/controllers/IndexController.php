<?php
/**
 * IndexController.php
 */

namespace Softn\controllers;

/**
 * Class IndexController
 * @author Nicolás Marulanda P.
 */
class IndexController implements ControllerInterfaces {
    
    /**
     * IndexController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('index');
    }
    
    public static function init() {
        return new IndexController();
    }
    
    public function index() {
        
        ViewController::view('index');
    }
}

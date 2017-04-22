<?php
/**
 * IndexController.php
 */

namespace Softn\controllers;

/**
 * Class IndexController
 * @author Nicolás Marulanda P.
 */
class IndexController extends ControllerAbstract implements ControllerInterface {
    
    /**
     * IndexController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('index');
    }
    
    public static function init() {
        parent::method(new IndexController());
    }
    
    public function index() {
        ViewController::view('index');
    }
    
    protected function getViewForm() {
        // TODO: Implement getViewForm() method.
    }
}

<?php
/**
 * GeneratingController.php
 */

namespace Softn\controllers;

/**
 * Class GeneratingController
 * @author Nicolás Marulanda P.
 */
class GeneratingController extends ControllerAbstract implements ControllerInterfaces {
    
    /**
     * GeneratingController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('generating');
    }
    
    public static function init() {
        parent::method(new GeneratingController());
    }
    
    public function generate() {
    }
    
    public function index() {
        
        ViewController::view('index');
    }
}

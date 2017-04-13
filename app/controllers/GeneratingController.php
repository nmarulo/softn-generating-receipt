<?php
/**
 * GeneratingController.php
 */

namespace Softn\controllers;

/**
 * Class GeneratingController
 * @author Nicolás Marulanda P.
 */
class GeneratingController implements ControllerInterfaces {
    
    /**
     * GeneratingController constructor.
     */
    public function __construct() {
        ViewController::setDirectory('generating');
    }
    
    public static function init() {
        return new GeneratingController();
    }
    
    public function generate() {
    }
    
    public function index() {
        
        ViewController::view('index');
    }
}
